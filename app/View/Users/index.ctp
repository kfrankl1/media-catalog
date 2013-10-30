<!-- File: /app/View/Users/index.ctp -->

<h1>Users</h1>
<?php if ($canAddUser) {
		echo $this->Html->link(
		'Add User',
		array('controller' => 'users', 'action' => 'add')
); } ?>
<table>
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('first_name'); ?></th>
        <th><?php echo $this->Paginator->sort('last_name'); ?></th>
        <th><?php echo $this->Paginator->sort('username', 'Email'); ?></th>
        <th><?php echo $this->Paginator->sort('Role.title', 'Role'); ?></th>
        <th>Actions</th>
        <th><?php echo $this->Paginator->sort('modified'); ?></th>
        <th><?php echo $this->Paginator->sort('modified_by'); ?></th>
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
        <td>
            <?php if ($canEditUserStatus) {
					echo $this->Form->postLink(
					'Delete',
					array('action' => 'delete', $user['User']['id']),
					array('confirm' => 'Are you sure?'));
			} ?>
            <?php if ($canEditUser) {
					echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id'])); 
			} ?>
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