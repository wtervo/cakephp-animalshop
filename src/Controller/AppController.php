<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');

        $this->loadComponent('Auth', [
            "authorize" => "Controller",
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        "username" => "username",
                        "password" => "password"
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login' //trying to access protected URLs unauthorized will redirect to the main page
            ],
             // If unauthorized, return them to the index
            'unauthorizedRedirect' => "/products/index"
        ]);

        // Allow the display action so our PagesController
        // continues to work. Also enable the read only actions.
        $this->Auth->allow(["", "index", "view", "dogs", "cats", "birds", "reptiles", "vermin", "other", "search"]); //only these pages are allowed for non-admins
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->loadModel("Carts");
        $this->set("count", $this->Carts->getCount());
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        if($this->Auth->user("user_id")) {
            $this->set("logged_id", $this->Auth->user("user_id"));
            $this->set("logged_username", $this->Auth->user("username"));
            if($this->Auth->user("admin_status")) {
                $this->set("user_status", "admin");
            }
            else {
                $this->set("user_status", "logged_user");
            }
        }
        else {
            $this->set("user_status", "not_logged");
        }
    }

    public function isAuthorized($user)
    {
        // By default deny access.
        return false;
    }
}
