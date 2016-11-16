<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Mailer\Email;

class InvoicesController extends AppController {

    public function index() {
        $this->set('title_for_layout', 'Invoices');

        $this->loadModel('Invoices');
        $this->set('invoices', $this->Invoices->find('all')->contain(['clients'])->order(['Invoices.id' => 'DESC']));
    }

    public function add() {
        $this->set('title_for_layout', 'Add Invoice');

        //Load clients
        $this->loadModel('Clients');
        $client_ids = $this->Clients->find('list');
        $this->set(compact('client_ids'));

        $this->loadModel('Invoices');
        $invoice = $this->Invoices->newEntity($this->request->data);
        if ($this->request->is('post')) {
            $invoice->i_date = date("Y-m-d H:i:s");
            if ($this->Invoices->save($invoice)) {
                $this->Flash->set('The invoice has been saved.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->set('Unable to add invoice.',
                ['element' => 'alert-box',
                    'params' => [
                        'class' => 'danger'
                    ]]
            );
        }
        $this->set(compact('invoice'));
    }

    public function edit($id = NULL) {
        //Load clients
        $this->loadModel('Clients');
        $client_ids = $this->Clients->find('list');
        $this->set(compact('client_ids'));

        $this->loadModel('Invoices');
        $invoice = $this->Invoices->get($id);
        $this->set('title_for_layout', 'Invoice #:'.$invoice->id);
        if (empty($invoice)) {
            throw new NotFoundException('Could not find that invoice.');
        }
        else {
            $this->set(compact('invoice'));
        }

        if ($this->request->is(['post', 'put'])) {
            //Save
            $this->Invoices->patchEntity($invoice, $this->request->data);
            if ($this->Invoices->save($invoice)) {
                $this->Flash->set('The invoice has been updated.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->set('Unable to update invoice.',
                ['element' => 'alert-box',
                    'params' => [
                        'class' => 'danger'
                    ]]
            );
        }
    }

    public function delete($id = NULL) {
        $this->loadModel('Invoices');
        $invoice = $this->Invoices->get($id);
        $this->Invoices->delete($invoice);

        $this->loadModel('InvoiceItems');
        $invoiceitems = $this->InvoiceItems->find('all', array('conditions' => array('invoice_id' => $id)));
        if(!empty($invoiceitems)) {
            foreach ($invoiceitems as $invoiceitem) {
                $this->InvoiceItems->delete($invoiceitem);
            }
        }

        $this->Flash->set('The invoice '.$invoice->id.' has been deleted.',
            ['element' => 'alert-box',
                'params' => [
                    'class' => 'success'
                ]]
        );

        return $this->redirect(['action' => 'index']);
    }

    public function view($id = NULL) {
        $this->loadModel('Invoices');
        $invoice = $this->Invoices->get($id);
        $this->set('title_for_layout', 'Invoice #'.$invoice->id);
        if (empty($invoice)) {
            throw new NotFoundException('Could not find that invoice.');
        }
        else {
            $this->set(compact('invoice'));
        }

        //Load client
        $this->loadModel('Clients');
        $client = $this->Clients->find('all')->where(['id' => $invoice->client_id])->first();
        $this->set(compact('client'));

        //Invoice Items
        $this->loadModel('InvoiceItems');
        $invoiceitems = $this->InvoiceItems->find('all')->where(['invoice_id IN' => $invoice->id]);
        $this->set(compact('invoiceitems'));
    }

    public function printing($id = NULL) {
        //Layout
        $this->viewBuilder()->layout('print');

        $this->loadModel('Invoices');
        $invoice = $this->Invoices->get($id);
        $this->set('title_for_layout', 'Invoice #'.$invoice->id);
        if (empty($invoice)) {
            throw new NotFoundException('Could not find that invoice.');
        }
        else {
            $this->set(compact('invoice'));
        }

        //Load client
        $this->loadModel('Clients');
        $client = $this->Clients->find('all')->where(['id' => $invoice->client_id])->first();
        $this->set(compact('client'));

        //Invoice Items
        $this->loadModel('InvoiceItems');
        $invoiceitems = $this->InvoiceItems->find('all')->where(['invoice_id IN' => $invoice->id]);
        $this->set(compact('invoiceitems'));
    }

    public function mail($id = NULL) {
        $this->loadModel('Invoices');
        $invoice = $this->Invoices->get($id);
        $this->set('title_for_layout', 'Invoice #'.$invoice['id']);
        if (empty($invoice)) {
            throw new NotFoundException('Could not find that invoice.');
        }
        else {
            $this->set(compact('invoice'));
        }

        //Load client
        $this->loadModel('Clients');
        $client = $this->Clients->find('all')->where(['id' => $invoice->client_id])->first();
        $this->set(compact('client'));

        //Invoice Items
        $this->loadModel('InvoiceItems');
        $invoiceitems = $this->InvoiceItems->find('all')->where(['invoice_id IN' => $invoice->id]);
        $this->set(compact('invoiceitems'));

        $display = '<div style="width: 800px; margin: 0 auto; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;">';

        $display .= '<h1>Invoice #'.$invoice['id'].' for '.$client['title'].'</h1>';

        //Information
        $display .= '<table border="0" cellspacing="2" cellpadding="2" width="100%">';
        $display .= '<tr>';
        $display .= '<td valign="top" width="50%"><fieldset><legend>Client Address:</legend>'.$client['title'].'<br/>'.nl2br($client['address']).'</fieldset></td>';
        $display .= '<td valign="top" width="50%"><fieldset><legend>Company Address:</legend>'.MAIN_ADDRESS.'</fieldset></td>';
        $display .= '</tr>';
        $display .= '</table>';

        //Invoice
        $display .= '<table border="0" cellspacing="2" cellpadding="2" width="100%">';
        $display .= '<thead>';
        $display .= '<tr>';
        $display .= '<th>#</th>';
        $display .= '<th>Description</th>';
        $display .= '<th>Time (Hours)</th>';
        $display .= '<th>Rate</th>';
        $display .= '</tr>';
        $display .= '</thead>';
        $display .= '<tbody>';
        $total_array = array();
        foreach($invoiceitems as $invoiceitem) {
            $total_array[] = $invoiceitem['time_billed'] * $invoiceitem['time_rate'];
            $display .= '<tr>';
            $display .= '<td valign="top">'.$invoiceitem['id'].'</td>';
            $display .= '<td valign="top">'.$invoiceitem['body'].'</td>';
            $display .= '<td valign="top" align="center">'.$invoiceitem['time_billed'].'</td>';
            $display .= '<td valign="top" align="center">$'.$invoiceitem['time_rate'].'</td>';
            $display .= '</tr>';
        }
        $total = 0;
        foreach($total_array as $total_item) {
            $total += $total_item;
        }
        $display .= '<tr>';
        $display .= '<td> </td>';
        $display .= '<td> </td>';
        $display .= '<td> </td>';
        $display .= '<td align="center"><strong>Total: $'.$total.'</strong></td>';
        $display .= '</tr>';
        $display .= '</tbody>';
        $display .= '</table>';

        if ($this->request->is(['post', 'put'])) {
            $email_addresses = explode(', ', $this->request->data['email_addresses']);
            $email = new Email('default');
            $email->from([BILLING_EMAIL => BILLING_EMAIL])
                ->emailFormat('html')
                ->to($email_addresses)
                ->replyTo(REPLYTO_EMAIL)
                ->subject('Invoice #'.$invoice['id'])
                ->send($display);

            $this->Flash->set('The mail has been sent.',
                ['element' => 'alert-box',
                    'params' => [
                        'class' => 'success'
                    ]]
            );
            return $this->redirect(['action' => 'index']);
        }
    }
}