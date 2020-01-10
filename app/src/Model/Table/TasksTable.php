<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TasksTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->hasOne('Users', [
            'className' => 'Users'
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->allowEmptyString('id', false);

        $validator
            ->scalar('task_name')
            ->minLength('task_name', 5)
            ->maxLength('task_name', 25)
            ->requirePresence('task_name', 'create')
            ->notEmptyString('task_name');
        
        $validator
            ->scalar('description')
            ->maxLength('description', 1000)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('status')
            ->notEmptyString('status', false)
            ->inList('status', ['Not Started', 'In Progress', 'Completed']);
            
        return $validator;
    }
}