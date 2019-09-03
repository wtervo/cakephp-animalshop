<?php

namespace App\Controller;

class ProductsController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent("Paginator");
        $this->loadComponent("Flash");
    }

    public function index()
    {
        $products = $this->Paginator->paginate($this->Products->find());
        $this->set(compact("products"));
    }

    public function view($slug = null)
    {
        $product = $this->Products->findBySlug($slug)->firstOrFail();
        $this->set(compact("product"));
    }

    public function add()
    {
        $product = $this->Products->newEntity();
        $options = $this->Products->find("list", ["keyField" => "species", "valueField" => "species"]); //options for the species dropdown menu
        $this->set(compact("options"));
        if ($this->request->is("post")) {
            $product = $this->Products->patchEntity($product, $this->request->getData());

            if ($this->Products->save($product)) {
                $this->Flash->success(__('New product "{0}" added to the shop!', $product->product_name));
                return $this->redirect(["action" => "index"]);
            }
            $this->Flash->error(__("Adding the product failed"));
        }
        $this->set("product", $product);
    }

    public function edit($slug)
    {
        $product = $this->Products->findBySlug($slug)->firstOrFail();
        $options = $this->Products->find("list", ["keyField" => "species", "valueField" => "species"]);
        $this->set(compact("options"));
        if ($this->request->is(["post", "put"])) {
            $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__("Product details have been updated"));
                return $this->redirect(["action" => "index"]);
            }
            $this->Flash->error(__("Updating product details failed"));
        }
        $this->set("product", $product);
    }

    public function delete($slug)
    {
        $this->request->allowMethod(["post", "delete"]);
        $product = $this->Products->findBySlug($slug)->firstOrFail();
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product "{0}" has been removed from the shop database', $product->product_name));
            return $this->redirect(["action" => "index"]);
        }
    }

    public function search()
    {
        $search = $this->request->getQuery("q");
        $this->paginate;
        //LIKE query for product titles and IDs
        $query = $this->paginate($this->Products->find("all", array(
            "conditions" => array("OR" => array("Products.product_name LIKE" => "%".$search."%", "Products.product_id LIKE" => "%".$search."%")))));
        $this->set("products", $query);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        // These actions are always available for logged users
        if (in_array($action, ["index", "view", "dogs", "cats", "birds", "reptiles", "vermin", "other"])) {
            return true;
        }

        return $user['admin_status'];
    }

    public function dogs()
    {
        $products = $this->Paginator->paginate($this->Products->find("all", [
            "conditions" => ["species" => "dog"]
        ]));
        $this->set(compact("products"));
    }

    public function cats()
    {
        $products = $this->Paginator->paginate($this->Products->find("all", [
            "conditions" => ["species" => "cat"]
        ]));
        $this->set(compact("products"));
    }

    public function birds()
    {
        $products = $this->Paginator->paginate($this->Products->find("all", [
            "conditions" => ["species" => "bird"]
        ]));
        $this->set(compact("products"));
    }

    public function vermin()
    {
        $products = $this->Paginator->paginate($this->Products->find("all", [
            "conditions" => ["species" => "vermin"]
        ]));
        $this->set(compact("products"));
    }

    public function reptiles()
    {
        $products = $this->Paginator->paginate($this->Products->find("all", [
            "conditions" => ["species" => "reptile"]
        ]));
        $this->set(compact("products"));
    }

    public function other()
    {
        $products = $this->Paginator->paginate($this->Products->find("all", [
            "conditions" => ["species" => "other"]
        ]));
        $this->set(compact("products"));
    }
}
