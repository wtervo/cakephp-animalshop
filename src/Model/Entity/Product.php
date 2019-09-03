<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Product extends Entity
{
    protected $_accessible = [
        "*" => true,
        "id" => true,
        "slug" => false,
    ];
}
