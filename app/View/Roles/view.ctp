<!-- File: /app/View/Roles/view.ctp -->

<h1><?php echo h($role['Role']['title']); ?></h1>
<p>Add User: <?php echo $role['Role']['is_add_user']; ?></p>
<p>Edit Any User: <?php echo $role['Role']['is_edit_any_user']; ?></p>
<p>Edit Any User Role: <?php echo $role['Role']['is_edit_any_user_role']; ?></p>
<p>Make Any User Inactive: <?php echo $role['Role']['is_make_any_user_inactive']; ?></p>
<p>Edit Any Role: <?php echo $role['Role']['is_edit_any_role']; ?></p>
<p>Add Show: <?php echo $role['Role']['is_add_show']; ?></p>
<p>Edit Any Show: <?php echo $role['Role']['is_edit_any_show']; ?></p>
<p>Make Any Show Inactive: <?php echo $role['Role']['is_make_any_show_inactive']; ?></p>
<p>Add Episode: <?php echo $role['Role']['is_add_episode']; ?></p>
<p>Edit Any Episode: <?php echo $role['Role']['is_edit_any_episode']; ?></p>
<p>Edit Authored Episode: <?php echo $role['Role']['is_edit_authored_episode']; ?></p>
<p>Edit Settings: <?php echo $role['Role']['is_edit_settings']; ?></p>

<p><small>Created: <?php echo $role['Role']['created']; ?></small></p>
<p><small>Last Modified: <?php echo $role['Role']['modified']; ?></small></p>


<p><?php echo $this->Html->link('Edit', 
	array('action' => 'edit', $role['Role']['id'])); ?>
</p>

<p><?php echo $this->Html->link('Back to Roles',
    array('controller' => 'roles', 'action' => 'index')); ?>
</p>