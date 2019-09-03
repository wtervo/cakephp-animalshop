<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\Query;

class ProductsTable extends Table
{
    public function initialize(array $config)
    {
        $this->hasMany("SubCategories", [
            "species" => "Categories"
        ]);
        $this->addBehavior("Timestamp");
    }

    // this method is fired before every query and it sorts the tables alphabetically by default instead of the id
    public function beforeFind ($event, $query, $options, $primary)
    {
        $order = $query->clause("order");
        if ($order === null || !count($order)) {
            $query->order( [$this->alias() . ".product_name" => "ASC"] );
        }
    }

    //this method generates a slug before a new product is added
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->product_name);
            $entity->slug = substr($sluggedTitle, 0, 254);
        }
        if ($entity->isNew() && !$entity->product_id) {
            $entity->product_id = Text::uuid();
        }
    }

    public function validationDefault(Validator $validator)
    {
        $validator

            ->requirePresence("product_name")
            ->notEmpty("product_name", "This field is required")
            ->add("product_name", [
                "minLength" => [
                    "rule" => ["minLength", 6],
                    "message" => "Product names need to be at least 6 characters long"
                ],
                "maxLength" => [
                    "rule" => ["maxLength", 255],
                    "message" => "Product names cannot be longer than 255 characters"
                ]
            ])

            ->requirePresence("price")
            ->add("price", "validValue", [
                "rule" => ["range", 0, 999999],
                "message" => "Prices must be positive and not larger than 999 999"
            ])

            ->requirePresence("species")

            ->requirePresence("weight")
            ->add("weight", "validValue", [
                "rule" => ["range", 0, 99999],
                "message" => "Weight must be positive and not larger than 99 999"
            ])

            ->requirePresence("age")
            ->add("age", "validValue", [
                "rule" => ["range", 0, 999],
                "message" => "Age must be a positive integer and not larger than 999"
            ]);

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(["product_name", "slug"], "This product name is already in use")); //checks if the product name, id or slug are already used

        return $rules;
    }

    public function findProduct(Query $query, array $options)
    {
        $product = $options["product"];
        return $query->where(["product_id" => $product->product_id])->orWhere(["product_name" => $product->product_name]);
    }
}
