<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
            if($user->user_id === $this->Auth->user("user_id")) {
                return $this->redirect(['action' => 'logout']); //if the user deletes his/her own account, they are immediately logged out to avoid a mess
            }
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        if (in_array($action, ["users", "view", "add", "login", "logout"])) {
            return true;
        }
        else if ($action === "edit" || $action === "delete") {
            if ($action === "delete" && $user['admin_status']) { //if true, allows deleting any user
                return true;
            }
            else {
                $slug = $this->request->getParam('pass.0');
                if (!$slug) {
                    return false;
                }
                return (int)$slug === $user["user_id"];
            }
        }
        else {
            return $user['admin_status'];
        }
    }

    public function login()
    {
        if($this->Auth->user()) {
            $this->Flash->error(__("You are already logged in"));
            return $this->redirect($this->Auth->redirectUrl("/products/index"));
        }
        else {
            if ($this->request->is('post')) {
                $user = $this->Auth->identify();
                if ($user) {
                    //although not ideal, I choose to destroy the session on login to avoid a crash which is caused if an unlogged
                    //user has created a session of his/her own before trying to log in
                    $this->Carts->destroySession();
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl("/products/index"));
                }
                $this->Flash->error("Login details are incorrect");
            }
        }
    }

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout', "add"]);
    }

    public function logout()
    {
        $this->loadModel('Carts');
        $this->Carts->destroySession();
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
}
