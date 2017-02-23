<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class InvoiceitemsController extends AppController {

    public function index() {
        $this->set('title_for_layout', 'Invoices');

        $this->Flash->set('Please choose a client first!',
            ['element' => 'alert-box',
                'params' => [
                    'class' => 'danger'
                ]]
        );
        return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
    }

    public function add($id = NULL) {
        $this->loadModel('InvoiceItems');
        $invoiceitem = $this->InvoiceItems->newEntity($this->request->data);
        if ($this->request->is('post')) {
            $invoiceitem['invoice_id'] = $id;
            if ($this->InvoiceItems->save($invoiceitem)) {
                $this->Flash->set('The invoice item has been saved.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                $this->redirect(['controller' => 'Invoices', 'action' => 'view', $invoiceitem['invoice_id']]);
            } else {
                $this->Flash->set('Unable to add invoice item.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'danger'
                        ]]
                );
            }
        }
        $this->set(compact('invoiceitem'));
    }

    public function edit($id = NULL) {
        $this->loadModel('InvoiceItems');
        $invoiceitem = $this->InvoiceItems->get($id);
        $this->set('title_for_layout', 'Invoice Item #'.$invoiceitem->id);
        if (empty($invoiceitem)) {
            throw new NotFoundException('Could not find that invoice item.');
        }
        else {
            $this->set(compact('invoiceitem'));
        }

        if ($this->request->is(['post', 'put'])) {
            //Save
            $this->InvoiceItems->patchEntity($invoiceitem, $this->request->data);
            if ($this->InvoiceItems->save($invoiceitem)) {
                $this->Flash->set('The invoice item has been updated.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                $this->redirect(['controller' => 'Invoices', 'action' => 'view', $invoiceitem->invoice_id]);
            } else {
                $this->Flash->set('Unable to update invoice item.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'danger'
                        ]]
                );
            }
        }
    }

    public function delete($id = NULL) {
        $this->loadModel('InvoiceItems');
        $invoiceitem = $this->InvoiceItems->get($id);
        $this->InvoiceItems->delete($invoiceitem);

        $this->Flash->set('The invoice item '.$invoiceitem->id.' has been deleted.',
            ['element' => 'alert-box',
                'params' => [
                    'class' => 'success'
                ]]
        );

        return $this->redirect($this->referer());
    }
}