<h1>Edit Task</h1>
<?php 
    echo $this->Form->create($task);
    echo $this->Form->control('task_name');
    echo $this->Form->control('description', ['rows' => '5']);
    echo $this->Form->control('status', ['options' => $status]);
    echo $this->Form->control('username', ['options' => $users]);
    echo $this->Form->button(__('Save Task'));
    echo $this->Form->end();
?>