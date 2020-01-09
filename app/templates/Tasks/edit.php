<h1>Edit Task</h1>
<?php 
    echo $this->Form->create($task, ['type' => 'put']);
    echo $this->Form->control('task_name');
    echo $this->Form->control('description', ['rows' => '5']);
    echo $this->Form->control('status', ['options' => ['Not Started', 'In Progress', 'Completed']]);
    echo $this->Form->select('username', $users);
    echo $this->Form->button(__('Save Task'));
    echo $this->Form->end();
?>