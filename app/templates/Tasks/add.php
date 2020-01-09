<h1>Add Task</h1>
<?php
    echo $this->Form->create($task);
    // Hard code the user for now.
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('task_name');
    echo $this->Form->control('description', ['rows' => '5']);
    echo $this->Form->control('status', ['options' => $status]);
    echo $status;
    echo $this->Form->button(__('Save Task'));
    echo $this->Form->end();
?>