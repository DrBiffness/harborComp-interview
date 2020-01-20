<?php

namespace App\Controller;

class TasksController extends AppController
{

    public $statuses = ['Not Started' => 'Not Started', 'In Progress' => 'In Progress', 'Completed' => 'Completed'];
    
    public function index()
    {
        // $this->loadComponent('Paginator');
        $this->paginate = [
            'limit' => 10,
            'order' => [
                'Tasks.task_name' => 'asc'
            ]
        ];

        $this->set('status', $this->statuses);

        $filter = $this->request->getData('filter');

        if ($filter) {
            $tasks = $this->paginate($this->Tasks->find('all')->where(['Tasks.status =' => $filter])->contain(['Users']));
        } else {
            $tasks = $this->paginate($this->Tasks->find('all')->contain(['Users']));
        }

        $this->set(compact('tasks'));
    }

    public function add()
    {
        $task = $this->Tasks->newEmptyEntity();
        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
            // $task->user_id = $this->request->getAttribute('authentication');

            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('Your task has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your task.'));
        }
        $this->set('task', $task);
        
        $this->loadModel('Users');
        $users = $this->Users->find();
        $usersArr = array();
        foreach ($users as $user) {
            $usersArr[$user->id] = $user->username; 
        }
        $this->set('users', $usersArr);

        $this->set('status', $this->statuses);
    }

    public function edit($id)
    {
        $task = $this->Tasks
            ->findById($id)
            ->firstOrFail();

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
        $this->set('status', $this->statuses);
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

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // configure the login action to don't require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['index']);
    }
}