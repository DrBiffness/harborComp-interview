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

        // $userOptions = $users->map(function ($value, $key) {
        //     return [
        //         'value' => $value->id,
        //         'text' => $value->username
        //     ];
        // });

        if ($this->request->is(['post', 'put'])) {
            $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update this task.'));
        }
        $this->set('task', $task);
        $this->loadModel('Users');
        $users = $this->Users->find();
        $usersArr = array();
        foreach ($users as $user) {
            $usersArr[$user->id] = $user->username; 
        }
        $this->set('users', $usersArr);
        $this->set('status', ['Not Started' => 'Not Started', 'In Progress' => 'In Progress', 'Completed' => 'Completed']);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $task = $this->Tasks->findById($id)->firstOrFail();
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('The {0} task has been deleted.', $task->task_name));
            return $this->redirect(['action' => 'index']);
        }  
    }
}