<br />
<h2 align="center"><?= h($product->product_name) ?></h2>
<h4 align="center">ID: <?= h($product->product_id) ?></h4>
<br />
<!-- h() is a convenience wrapper for htmlspecialchars() to avoid problems if adding html tags to the DB -->
<h3 align="center">Price: <?= h($product->price) ?> €</h3>
<br />
<br />
<div align="center">
    <h4><b>Product details</b></h4>
    <br />
    <p>Species category: <?= ucfirst(h($product->species)) ?></p>
    <p>Weight: <?= h($product->weight) ?> kg</p>
    <p>Age: <?= h($product->age) ?> years</p>
    <p>Product added: <?= $product->created->format(DATE_RFC850) ?></p>
    <?php if($product->modified !== null ): ?>
    <!-- only displayed if there have been edits after creation -->
        <?php if($product->modified."time" !==  $product->created."time"): ?>
            <p>Last edited: <?= $product->modified->format(DATE_RFC850) ?></p>
        <?php endif; ?>
    <?php endif; ?>
    <br />
    <p>
        <?php echo $this->Form->create('Cart', ["id"=>"add-form"]);?>
        <?php echo $this->Form->hidden('id',array('value'=>$product["id"]))?>
        <?php echo $this->Form->button("Add to cart", ["id" => "add-btn", "class" => "button"]) ?>
        <?php echo $this->Form->end();?>
    </p>
    <?php if($user_status === "admin"): ?>
        <p><?= $this->Html->link("Edit", ["action" => "edit", $product->slug]) ?></p>
        <p><?= $this->Form->postLink("Delete",
            ["action" => "delete", $product->slug],
            ["confirm" => "Are you sure you wish to remove this product permanently?"])
        ?></p>
    <?php endif; ?>

</div>

<!-- jQuery script for adding products to cart -->
<script type="text/javascript">
    $("#add-form").submit(function(event) {
        event.preventDefault();
        var form = $(this).serialize();
        var webroot = <?= $this->request->webroot ?>;
        $.ajax({
            type: "POST",
            url: [webroot, "/carts/add"].join(""),
            headers: {
                "X-CSRF-Token": $('[name="_csrfToken"]').val()
            },
            data: form,
            success: function(data) {
                alert("Product added to shopping cart"); //would have liked to add a cakephp flash msg here, but did not know how and ran out of time to find out
                $('#cart-counter').text(data);
            },
            error: function(data) {
                alert("Something went wrong...");
            }
        });
    });
</script>
