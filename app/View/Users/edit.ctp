<!-- File: /app/View/Users/edit.ctp -->

<h1>Edit User</h1>
<?php
    echo $this->Form->create('User');
    echo $this->Form->input('first_name');
    echo $this->Form->input('last_name');
	echo $this->Form->input('username', array('label' => 'Email'));
	echo $this->Form->input('password', array('label' => 'New Password'));
	if ($canEditUserRole) {
		echo $this->Form->input('role_id');
	} else {
		echo $this->Form->input('role_id', array('disabled' => 'disabled'));
	}
?>
	<!--	Adding 'required' to ShowUser adds required class to all options.
	    	Manually creating the label makes for a better UI. -->
	<div class="required"><label for="UserShow">Authorized Shows</label></div>
<?php
	echo $this->Form->input('User.Show', array(
        'label' => false
        ,'type' => 'select'
        ,'multiple' => 'checkbox'
	));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save User');
?>

<?php echo $this->Html->link(
    'Back to Users',
    array('controller' => 'users', 'action' => 'index')
); ?>