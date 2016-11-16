<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class ClientsController extends AppController {

    public function index() {
        $this->set('title_for_layout', 'Clients');

        $this->loadModel('Clients');
        $this->set('clients', $this->Clients->find('all')->order(['id' => 'DESC']));
    }

    public function add() {
        $this->loadModel('Clients');
        $client = $this->Clients->newEntity($this->request->data);
        if ($this->request->is('post')) {
            if ($this->Clients->save($client)) {
                $this->Flash->set('The client has been saved.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->set('Unable to add client.',
                ['element' => 'alert-box',
                    'params' => [
                        'class' => 'danger'
                    ]]
            );
        }
        $this->set(compact('client'));
    }

    public function edit($id = NULL) {
        $this->loadModel('Clients');
        $client = $this->Clients->get($id);
        $this->set('title_for_layout', $client->title);
        if (empty($client)) {
            throw new NotFoundException('Could not find that client.');
        }
        else {
            $this->set(compact('client'));
        }

        if ($this->request->is(['post', 'put'])) {
            //Save
            $this->Clients->patchEntity($client, $this->request->data);
            if ($this->Clients->save($client)) {
                $this->Flash->set('The client has been updated.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->set('Unable to update client.',
                ['element' => 'alert-box',
                    'params' => [
                        'class' => 'danger'
                    ]]
            );
        }
    }

    public function delete($id = NULL) {
        $this->loadModel('Clients');
        $client = $this->Clients->get($id);
        $this->Clients->delete($client);

        $this->loadModel('Invoices');
        $invoice_ids = array();
        $invoices = $this->Invoices->find('all', array('conditions' => array('client_id' => $id)));
        if(!empty($invoices)) {
            foreach ($invoices as $invoice) {
                $this->Invoices->delete($invoice);
                $invoice_ids[] = $invoice['id'];
            }
        }

        $this->loadModel('InvoiceItems');
        $invoiceitems = $this->InvoiceItems->find()->where(['invoice_id IN' => $invoice_ids])->all();
        if(!empty($invoiceitems)) {
            foreach ($invoiceitems as $invoiceitem) {
                $this->InvoiceItems->delete($invoiceitem);
            }
        }

        $this->Flash->set('The client '.$client->title.' has been deleted.',
            ['element' => 'alert-box',
                'params' => [
                    'class' => 'success'
                ]]
        );

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = NULL) {
        $this->loadModel('Clients');
        $client = $this->Clients->get($id);
        $this->set('title_for_layout', $client->title);
        if (empty($client)) {
            throw new NotFoundException('Could not find that client.');
        }
        else {
            $this->set(compact('client'));
        }

        //Invoices
        $this->loadModel('Invoices');
        $invoices = $this->Invoices->find('all')->where(['client_id IN' => $client->id]);
        $this->set(compact('invoices'));
    }
}