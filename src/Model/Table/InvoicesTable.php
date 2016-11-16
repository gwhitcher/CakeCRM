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
    }

}