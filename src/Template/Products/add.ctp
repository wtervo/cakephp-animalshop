<h1>Add a New Product</h1>
<?php
    echo $this->Form->create($product);
    // Hard code the user for now.
    // echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control("product_name");
    echo $this->Form->control("price");
    echo $this->Form->input("species", ["options" => $options, "empty" => "Select", "label" => "Species"]);
    echo $this->Form->control("weight");
    echo $this->Form->control("age");
    echo $this->Form->button(__("Add Product"));
    echo $this->Form->end();
?>
