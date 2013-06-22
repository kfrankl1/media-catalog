<!-- File: /app/View/Roles/index.ctp -->

<h1>Roles</h1>
<?php echo $this->Html->link(
    'Add Role',
    array('controller' => 'roles', 'action' => 'add')
); ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Add User</th>
        <th>Edit Any User</th>
        <th>Edit Any User Role</th>
        <th>Make Any User Inactive</th>
        <th>Edit Any Role</th>
        <th>Add Show</th>
        <th>Edit Any Show</th>
        <th>Make Any Show Inactive</th>
        <th>Add Episode</th>
        <th>Edit Any Episode</th>
        <th>Edit Authored Episode</th>
        <th>Edit Settings</th>
        <th>Actions</th>
        <th>Last Modified</th>
        <th>Modified By</th>
    </tr>

    <!-- Here is where we loop through our $roles array, printing out post info -->

    <?php foreach ($roles as $role): ?>
    <tr>
        <td><?php echo $role['Role']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($role['Role']['title'],
							array('controller' => 'roles', 'action' => 'view', $role['Role']['id'])); ?>
        </td>
        <td><?php echo $role['Role']['is_add_user']; ?></td>
        <td><?php echo $role['Role']['is_edit_any_user']; ?></td>
        <td><?php echo $role['Role']['is_edit_any_user_role']; ?></td>
        <td><?php echo $role['Role']['is_make_any_user_inactive']; ?></td>
        <td><?php echo $role['Role']['is_edit_any_role']; ?></td>
        <td><?php echo $role['Role']['is_add_show']; ?></td>
        <td><?php echo $role['Role']['is_edit_any_show']; ?></td>
        <td><?php echo $role['Role']['is_make_any_show_inactive']; ?></td>
        <td><?php echo $role['Role']['is_add_episode']; ?></td>
        <td><?php echo $role['Role']['is_edit_any_episode']; ?></td>
        <td><?php echo $role['Role']['is_edit_authored_episode']; ?></td>
        <td><?php echo $role['Role']['is_edit_settings']; ?></td>
        <td>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $role['Role']['id']),
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $role['Role']['id'])); ?>
        </td>
        <td><?php echo $role['Role']['modified']; ?></td>
        <td>
			<?php echo $this->Html->link(
							$role['ModifiedBy']['first_name'] . " " . $role['ModifiedBy']['last_name'],
							array('controller' => 'users', 'action' => 'view', $role['Role']['modified_by'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($role); ?>
</table>