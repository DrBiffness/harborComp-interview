<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TasksTable extends Table
{
    public function initialize(array $config): void
    {
        
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->allowEmptyString('task_name', false)
            ->minLength('task_name', 5)
            ->maxLength('task_name', 25)

            ->allowEmptyString('description', false)
            ->minLength('description', 5)
            ->maxLength('description', 1000)

            ->allowEmptyString('status', false)
            ->inList('status', ['Not Started', 'In Progress', 'Completed']); 
    }
}