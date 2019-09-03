<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;

class CartsController extends AppController {

    //the whole cart thing is mostly based on
    //https://stackoverflow.com/questions/44143516/cakephp-3-4-shopping-cart
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // allow all action
        $this->Auth->allow();
    }

    public function add() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $this->Carts->addProduct($this->request->data["id"]);
            echo $this->Carts->getCount();
        }

    }

    public function view() {
        $this->loadModel('Products');

        $carts = $this->Carts->readProduct();
        $products = array();
        if (null!=$carts) {
            foreach ($carts as $id => $count) {

                $product = $this->Products->findById($id)->first();
                $product['count'] = $count;
                $products[]=$product;
            }
        }
        $this->set(compact('products'));
    }

    public function update() {
        if ($this->request->is('post')) {
            if (!empty($this->request->data)) {
                $cart = array();
                foreach ($this->request->data['count'] as $index=>$count) {
                    if ($count>0) {
                        $id = $this->request->data['id'][$index];
                        $cart[$id] = $count;
                    }
                }
                $this->Carts->saveProduct($cart);
            }
        }
        $this->redirect(array('action'=>'view'));
    }

    public function delete($id) {
        $this->autoRender = false;
        debug($id);

        $this->Carts->removeProduct($id);
        $this->redirect(array('action'=>'view'));
    }

    public function deleteAll() {
        $this->autoRender = false;
        $this->Carts->removeAllProducts();
        $this->redirect(array('action'=>'view'));
    }

    public function purchase($total) {
        if ($total === "0") {
            $this->Flash->success(__("Please add products to your shopping cart"));
            $this->redirect(array('action'=>'view'));
        }
        else {
            $this->Flash->success(__("Your order for a total of {0} € has been sent!", $total));
            $this->deleteAll();
        }
    }
}
