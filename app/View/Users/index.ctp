<!-- File: /app/View/Users/index.ctp -->

<h1>Users</h1>
<?php echo $this->Html->link(
    'Add User',
    array('controller' => 'users', 'action' => 'add')
); ?>
<table>
    <tr>
        <th>Id</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Authorized Show</th>
        <th>Actions</th>
        <th>Last Modified</th>
        <th>Modified By</th>
    </tr>

    <!-- Here is where we loop through our $users array, printing out post info -->

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td><?php echo $user['User']['first_name']; ?></td>
        <td><?php echo $user['User']['last_name']; ?></td>
        <td>
            <?php echo $this->Html->link($user['User']['username'],
							array('controller' => 'users', 'action' => 'view', $user['User']['id'])); ?>
        </td>
        <td><?php echo $user['Role']['title']; ?></td>
        <td><?php echo $user['Show']['title']; ?></td>
        <td>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $user['User']['id']),
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id'])); ?>
        </td>
        <td><?php echo $user['User']['modified']; ?></td>
        <td>
			<?php echo $this->Html->link(
							$user['ModifiedBy']['first_name'] . " " . $user['ModifiedBy']['last_name'],
							array('controller' => 'users', 'action' => 'view', $user['User']['modified_by'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($user); ?>
</table>