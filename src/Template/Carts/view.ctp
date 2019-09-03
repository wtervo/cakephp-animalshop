<h2 class="row">Your shopping cart</h2>
<br />
<?php echo  $this->Form->create('Cart',array('url'=>array('controller'=>'carts', 'action'=>'update')));?>
<div class="row">
    <div class="col-lg-12">
        <table class="table">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php $total=0;?>
        <?php foreach ($products as $product):?>
            <tr>
                <td><?php echo $product['product_name'];?></td>
                <td><?php echo $product['price'];?> €
                </td>
                <td><div class="col-xs-3">
                    <?php echo $this->Form->hidden('id.',array('value'=>$product['id']));?>
                    <?php echo $this->Form->input('count.',array('type'=>'number', 'label'=>false,
                    'class'=>'form-control input-sm', 'value'=>$product['count']));?>
                </div></td>
                <td><?php echo $product['count']*$product['price']; ?> €</td>
                <td><?= $this->Html->link("Remove", ["action" => "delete", $product->id]) ?></td>
            </tr>
            <?php $total = $total + ($product['count']*$product['price']);?>
        <?php endforeach;?>

        <tr class="success">
            <td colspan=3></td>
            <td><b><?php echo $total;?> €</b></td>
        </tr>
        </tbody>
    </table>

    <p class="text-right">
        <?php echo $this->Form->button("Update", ["action" => "update"]);?>
    </p>
    </div>
</div>
<?php echo $this->Form->end();?>
<div class="row">
    <p class="text-right">
        <?php echo $this->Form->postButton("Remove all", ["controller" => "Carts", "action" => "deleteAll"]);?>
    </p>
    <br />
    <p class="text-right">
        <?php echo $this->Form->postButton("Purchase", ["controller" => "Carts", "action" => "purchase", $total]);?>
    </p>
</div>
