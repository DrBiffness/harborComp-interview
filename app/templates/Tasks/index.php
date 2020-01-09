<h1>Tasks</h1>
    <table>
        <tr>
            <th>Task Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Assigned User</th>
            <th>Action</th>
        </tr>

        <?php foreach ($tasks as $task): ?>
        <tr>
            <td>
                <?= $task->task_name ?>
            </td>
            <td>
                <?= $task->description ?>
            </td>
            <td>
                <?= $task->status ?>
            </td>
            <td>
                <?= $task->user_id ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $task->id]) ?> | 
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $task->id],
                    ['confirm' => 'Are you sure?']
                )
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>    