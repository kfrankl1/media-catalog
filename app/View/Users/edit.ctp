<!-- File: /app/View/Users/edit.ctp -->

<h1>Edit User</h1>
<?php
    echo $this->Form->create('User');
    echo $this->Form->input('first_name');
    echo $this->Form->input('last_name');
    echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->input('role_id');
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save User');
?>

<?php echo $this->Html->link(
    'Back to Users',
    array('controller' => 'users', 'action' => 'index')
); ?>