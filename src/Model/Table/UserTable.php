<?php
// src/Model/Table/UserTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UserTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('users');
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('username', 'A username is required')
            ->notEmpty('password', 'A password is required')
            ->notEmpty('role', 'A role is required')
            ->add('role', 'inList', [
                'rule' => ['inList', ['1', '2', '3']],
                'message' => 'Please enter a valid role'
            ]);
    }


}