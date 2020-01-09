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

    public function edit($id)
    {
        $task = $this->Tasks
            ->findById($id)
            ->firstOrFail();

        $users = $this->loadModel('User');
        $userOptions = $users->map(function ($value, $key) {
            return [
                'value' => $value->id,
                'text' => $value->username
            ];
        });

        if ($this->request->is(['post', 'put'])) {
            $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Task->save($task)) {
                $this->Flash->success(__('The task has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update this task.'));
        }
        $this->set('task', $task);
        $this->set('userOptions', $userOptions);
    }

    public function delete()
    {

    }
}