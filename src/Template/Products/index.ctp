<h1 align="center">Welcome to the Animalshop!</h1>
<br />
<h4 align="center">We are the World's n. 1 supplier of questionably obtained animals</h4>
<h4 align="center">Please use the navigation bar or the search bar to filter the products to your interests</h4>
<br />
<h2>Products</h2>
<div>
    <form action="<?php echo $this->Url->build(["action" => "search"]) ?>" method="get">
        <div class="input-group">
            <input type="search" name="q" placeholder="Search by product title or ID"/>
            <div class="input-group-prepend">
                <button type="submit">Search</button>
            </div>
        </div>
    </form>
</div>
<br />
<?php echo $this->Paginator->limitControl([10 => "10 results per page", 20 => "20 results per page", 40 => "40 results per page"]);?>
<h4>Click a column's name to sort the products</h4>
<table>
    <tr>
        <th><?= $this->Paginator->sort("product_name", "Product name") ?></th>
        <th><?= $this->Paginator->sort("price", "Price in €") ?></th>
        <th><?= $this->Paginator->sort("species", "Species") ?></th>
        <th><?= $this->Paginator->sort("created", "Product added") ?></th>
        <th><?= $this->Paginator->sort("product_id", "Product ID") ?></th>
    </tr>

    <?php foreach ($products as $product): ?>
    <tr>
        <td>
            <?= $this->Html->link($product->product_name, ["action" => "view", $product->slug]) ?>
        </td>
        <td>
            <?= $product->price ?>
        </td>
        <td>
            <?= ucfirst($product->species) ?>
        </td>
        <td>
            <?= $product->created->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $product->product_id ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<!-- Pagination page links and their logic -->
<?php
    echo "<ul class='pagination' align='center'>";
    echo $this->Paginator->first("First");
    if($this->Paginator->hasPrev()){
        echo $this->Paginator->prev("Prev");
    }
    echo $this->Paginator->numbers(array("modulus" => 2));
    if($this->Paginator->hasNext()){
        echo $this->Paginator->next("Next");
    }
    echo $this->Paginator->last("Last");
    echo $this->Paginator->counter([
        "format" => "Page {{page}}/{{pages}}, showing products {{start}}-{{end}} out of {{count}}"
    ]);
    echo "</ul>";
?>
