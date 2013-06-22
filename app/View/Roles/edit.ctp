<!-- File: /app/View/Roles/edit.ctp -->

<h1>Edit Role</h1>
<?php
    echo $this->Form->create('Role');
    echo $this->Form->input('title');
	echo $this->Form->input('is_add_user', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_user', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_user_role', array('type' => 'checkbox'));
	echo $this->Form->input('is_make_any_user_inactive', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_role', array('type' => 'checkbox'));
	echo $this->Form->input('is_add_show', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_show', array('type' => 'checkbox'));
	echo $this->Form->input('is_make_any_show_inactive', array('type' => 'checkbox'));
	echo $this->Form->input('is_add_episode', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_episode', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_authored_episode', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_settings', array('type' => 'checkbox'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save Role');
?>

<?php echo $this->Html->link(
    'Back to Roles',
    array('controller' => 'roles', 'action' => 'index')
); ?>