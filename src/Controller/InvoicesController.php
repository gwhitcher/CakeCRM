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

    public function add($client_id = NULL) {
        $this->set('title_for_layout', 'Add Invoice');

        if (empty($client_id)) {
            throw new NotFoundException('A client ID is required.');
        }
        $this->loadModel('Clients');
        $client = $this->Clients->get($client_id);
        $this->set('client', $client);

        $this->loadModel('Invoices');
        $invoice = $this->Invoices->newEntity($this->request->data);
        if ($this->request->is('post')) {
            $invoice->i_date = date("Y-m-d H:i:s");
            $invoice->client_id = $client_id;
            if ($this->Invoices->save($invoice)) {
                $invoice_id = $invoice->id;
                $this->Flash->set('The invoice has been saved.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                $this->redirect(['action' => 'view', $invoice_id]);
            } else {
                $this->Flash->set('Unable to add invoice.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'danger'
                        ]]
                );
            }
        }
        $this->set(compact('invoice'));
    }

    public function edit($id = NULL) {
        $this->loadModel('Invoices');
        $invoice = $this->Invoices->get($id);
        $this->set('title_for_layout', 'Invoice #:'.$invoice->id);
        if (empty($invoice)) {
            throw new NotFoundException('Could not find that invoice.');
        }
        else {
            $this->set(compact('invoice'));
            $this->loadModel('Clients');
            $client = $this->Clients->get($invoice->client_id);
            $this->set('client', $client);
        }

        if ($this->request->is(['post', 'put'])) {
            //Save
            $invoice->client_id = $client->id;
            $this->Invoices->patchEntity($invoice, $this->request->data);
            if ($this->Invoices->save($invoice)) {
                $this->Flash->set('The invoice has been updated.',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                return $this->redirect(['action' => 'view', $invoice->id]);
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

        $display .= '<div style="width: 400px; float: left;"><h1>'.$client['title'].'</h1></div>';
        $display .= '<div style="width: 400px; float: right; text-align: right;"><h1>Invoice #'.$invoice['id'].'</h1></div>';

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
        $invoice_id = 1;
        foreach($invoiceitems as $invoiceitem) {
            $total_array[] = $invoiceitem['time_billed'] * $invoiceitem['time_rate'];
            $display .= '<tr>';
            $display .= '<td valign="top">'.$invoice_id.'</td>';
            $display .= '<td valign="top">'.nl2br($invoiceitem['body']).'</td>';
            $display .= '<td valign="top" align="center">'.$invoiceitem['time_billed'].'</td>';
            $display .= '<td valign="top" align="center">$'.$invoiceitem['time_rate'].'</td>';
            $display .= '</tr>';
            $invoice_id++;
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

    public function taxes() {
        $this->loadModel('Invoices');
        $this->set('title_for_layout', 'Taxes');
        if ($this->request->is(['post', 'put'])) {
            $start_date_year = $this->request->data['start_date']['year'];
            $start_date_month = $this->request->data['start_date']['month'];
            $start_date_day = $this->request->data['start_date']['day'];
            $end_date_year = $this->request->data['end_date']['year'];
            $end_date_month = $this->request->data['end_date']['month'];
            $end_date_day = $this->request->data['end_date']['day'];
            //$start_date = new \DateTime('2014-01-01');
            //$end_date = new \DateTime('2017-12-31');
            $start_time = strtotime($start_date_month.'/'.$start_date_day.'/'.$start_date_year);
            $start_date_format = date('Y-m-d',$start_time);
            $end_time = strtotime($end_date_month.'/'.$end_date_day.'/'.$end_date_year);
            $end_date_format = date('Y-m-d',$end_time);
            $invoices = $this->Invoices->find('all')->where([
                'i_date BETWEEN :start AND :end'
            ])
                ->bind(':start', $start_date_format, 'date')
                ->bind(':end',   $end_date_format, 'date')
                ->contain(['clients','invoice_items']);
            $this->set('invoices', $invoices);
        }
    }
}