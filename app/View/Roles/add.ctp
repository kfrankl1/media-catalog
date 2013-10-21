<!-- File: /app/View/Roles/add.ctp -->

<h1>Add Role</h1>
<?php
	echo $this->Form->create('Role');
	echo $this->Form->input('title');
	echo $this->Form->input('is_add_user', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_user', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_user_role', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_user_status', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_role', array('type' => 'checkbox'));
	echo $this->Form->input('is_add_show', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_show', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_show_status', array('type' => 'checkbox'));
	echo $this->Form->input('is_add_any_episode', array('type' => 'checkbox'));
	echo $this->Form->input('is_add_authorized_episode', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_episode', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_authored_episode', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_authorized_episode', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_any_episode_status', array('type' => 'checkbox'));
	echo $this->Form->input('is_edit_authorized_episode_status', array('type' => 'checkbox'));
	echo $this->Form->input('is_add_edit_genre', array('label' => 'Is Add/Edit Genre', 'type' => 'checkbox'));
	echo $this->Form->input('is_edit_settings', array('type' => 'checkbox'));
	echo $this->Form->end('Save Role');
?>

<?php echo $this->Html->link(
    'Back to Roles',
    array('controller' => 'roles', 'action' => 'index')
); ?>