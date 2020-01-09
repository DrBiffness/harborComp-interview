<?php

$status = ['Not Started' => 'Not Started', 'In Progress' => 'In Progress', 'Completed' => 'Completed'];
namespace App\Controller;

class TasksController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $tasks = $this->Paginator->paginate($this->Tasks->find());
        $this->set(compact('tasks'));
    }

    public function add()
    {
        $task = $this->Tasks->newEmptyEntity();
        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
            $task->user_id = 1;

            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('Your task has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your task.'));
        }
        $this->set('task', $task);
        global $status;
        $this->set('status', $status);
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
        // $this->loadModel('Users');
        // $users = $this->Users->find();
        // $usersArr = array();
        // foreach ($users as $user) {
        //     $usersArr[$user->id] = $user->username; 
        // }
        // $this->set('users', $usersArr);
        global $status;
        $this->set('status', $status);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $task = $this->Tasks->findById($id)->firstOrFail();
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('The task named "{0}" has been deleted.', $task->task_name));
            return $this->redirect(['action' => 'index']);
        }  
    }
}