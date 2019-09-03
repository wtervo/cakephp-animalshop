<h1>Edit Product</h1>
<br />
<h4>Product ID: <?= $product->product_id ?></h4>
<br />
<?php
    echo $this->Form->create($product);
    echo $this->Form->control("product_name", ["required" => true]);
    echo $this->Form->control("price", ["required" => true]);
    echo $this->Form->input("species", ["options" => $options, "empty" => "Select", "label" => "Species"], ["required" => true]);
    echo $this->Form->control("weight", ["required" => true]);
    echo $this->Form->control("age");
    echo $this->Form->button(__("Save changes"));
    echo $this->Form->end();
?>
