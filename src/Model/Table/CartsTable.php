<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Network\Session;
use Cake\Core\Configure;
use Cake\Utility\Hash;

class CartsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('carts');
    }

    /*
    * add a product to cart
    */
    public function addProduct($id) {
        $allProducts = $this->readProduct();
        if ($allProducts != null) {

            if (array_key_exists($id, $allProducts)) {
                $allProducts[$id]++;
                $this->saveProduct($allProducts);
            } else {
                $allProducts[$id] = 1;
                $this->saveProduct($allProducts);
            }
        } else {
            $allProducts[$id] = 1;
            $this->saveProduct($allProducts);
        }
    }

    /*
    * get total count of products
    */
    public function getCount() {
        $allProducts = $this->readProduct();

        if (count($allProducts)<1) {
            return 0;
        }

        $count = 0;
        foreach ($allProducts as $product) {
            $count=$count+$product;
        }

        return $count;
    }

    /*
    * save data to session
    */
    public function saveProduct($data) {
        $session = new Session();
        return $session->write('cart',$data);
    }

    /*
    * read cart data from session
    */
    public function readProduct() {
        $session = new Session();
        return $session->read('cart');
    }

    public function removeProduct($id) {
        $allProducts = $this->readProduct();
        if (array_key_exists($id, $allProducts)) {
            $allProducts = Hash::remove($allProducts, $id);
            $this->saveProduct($allProducts);
        }
    }

    public function removeAllProducts() {
        $session = new Session();
        return $session->delete("cart");
    }

    public function destroySession() {
        $session = new Session();
        return $session->destroy();
    }
}
