<!-- File: /app/View/Users/edit.ctp -->

<h1>Edit User</h1>
<?php
    echo $this->Form->create('User');
    echo $this->Form->input('first_name');
    echo $this->Form->input('last_name');
	echo $this->Form->input('username', array('label' => 'Email'));
	echo $this->Form->input('password', array('label' => 'New Password'));
	echo $this->Form->input('role_id');
	echo $this->Form->input('show_id', array('empty' => 'Default'));
    echo $this->Form->input('id');
    echo $this->Form->end('Save User');
?>

<?php echo $this->Html->link(
    'Back to Users',
    array('controller' => 'users', 'action' => 'index')
); ?>