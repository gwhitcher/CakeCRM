<?php
// src/Controller/UsersController.php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Auth\DefaultPasswordHasher;

class UsersController extends AppController
{

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function login() {
        $this->set('title_for_layout', 'Login');

        //Login security
        if(empty($_SESSION['login_count'])) {
            $_SESSION['login_count'] = 0;
        } elseif($_SESSION['login_count'] >= 3) {
            return $this->redirect('http://google.com');
        }

        if ($this->request->is('post')) {

            //Captcha
            if($this->request->data['captcha'] != 7) {
                $_SESSION['login_count']++;
                $this->Flash->set('Captcha incorrect!',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'danger'
                        ]]
                );
                return $this->redirect(['action' => 'login']);
            }

            $user = $this->Auth->identify();
            if ($user) {
                unset($_SESSION['login_count']);
                $this->Auth->setUser($user);
                $this->Flash->set('Logged in!',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $_SESSION['login_count']++;

                $this->Flash->set('Invalid username or password, try again',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'danger'
                        ]]
                );
            }
        }
    }

    public function index() {
        $this->set('title_for_layout', 'Users');
        $this->loadModel('User');
        $this->set('users', $this->User->find('all'));
    }

    public function logout() {
        $this->Flash->set('Successfully logged out.',
            ['element' => 'alert-box',
                'params' => [
                    'class' => 'success'
                ]]
        );
        return $this->redirect($this->Auth->logout());
    }

    public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid user'));
        }

        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function add() {
        $user = $this->Users->newEntity($this->request->data);
        if ($this->request->is('post')) {
            //Password hash
            $password_hash = new DefaultPasswordHasher;
            $this->request->data['password'] = $password_hash->hash($this->request->data['password']);

            if ($this->Users->save($user)) {
                $this->Flash->set('The user has been saved.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                return $this->redirect(['action' => 'users']);
            }
            $this->Flash->set('Unable to add user.',
                ['element' => 'alert-box',
                    'params' => [
                        'class' => 'danger'
                    ]]
            );
        }
        $this->set('user', $user);
    }

    public function edit($id = null) {
        $user = $this->Users->get($id);
        $this->set('title_for_layout', $user->name);
        if (empty($user)) {
            throw new NotFoundException('Could not find that user.');
        }
        else {
            $this->set(compact('user'));
        }

        if ($this->request->is(['post', 'put'])) {
            //Password hash
            $password_hash = new DefaultPasswordHasher;
            $this->request->data['password'] = $password_hash->hash($this->request->data['password']);

            //Save
            $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->set('The user has been updated.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                return $this->redirect(['action' => 'users']);
            }
            $this->Flash->set('Unable to update the user.',
                ['element' => 'alert-box',
                    'params' => [
                        'class' => 'danger'
                    ]]
            );
        }
    }

    public function delete($id = null) {
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->set('The user ID:'.$id.' has been deleted.',
                ['element' => 'alert-box',
                    'params' => [
                        'class' => 'success'
                    ]]
            );
            return $this->redirect(['action' => 'users']);
        }
    }
}