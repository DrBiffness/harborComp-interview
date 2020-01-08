<?php

namespace App\Controller;

class TasksController extends AppController
{
    public function index()
    {
        $tasks = $this->Tasks->find();
        $this->set(compact('tasks'));
    }
}