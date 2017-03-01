<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class InvoicesTable extends Table
{

    public function initialize(array $config)
    {
        $this->belongsTo('clients', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('invoice_items', [
            'foreignKey' => 'invoice_id'
        ]);
    }

}