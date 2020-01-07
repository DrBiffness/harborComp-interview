<?php

namespace App\Controller;

class TasksController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $tasks = $this->Paginator->paginate($this->Tasks->find());
        $this->set(compact('tasks'));
    }
}