<h1 align="center">Other Miscellaneous Animals</h1>
<br />
<h4 align="center">Some animals are so out of this world that they are impossible for our programmers to categorize and thus they end up here</h4>
<br />
<?php echo $this->Paginator->limitControl([10 => "10 results per page", 20 => "20 results per page", 40 => "40 results per page"]);?>
<h4>Click a column's name to sort the products</h4>
<table>
    <tr>
        <th><?= $this->Paginator->sort("product_name", "Product name") ?></th>
        <th><?= $this->Paginator->sort("price", "Price in €") ?></th>
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
