<!-- app/View/Users/add.ctp -->
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php
			echo $this->Form->input('first_name');
			echo $this->Form->input('last_name');
			echo $this->Form->input('username', array('label' => 'Email'));
			echo $this->Form->input('password');
			echo $this->Form->input('role_id');
?>
	<!--	Adding 'required' to ShowUser adds required class to all options.
	    	Manually creating the label makes for a better UI. -->
	<div class="required"><label for="ShowUser">Authorized Shows</label></div>
<?php
	echo $this->Form->input('User.Show', array( //Show.Genre
        'label' => false
        ,'type' => 'select'
        ,'multiple' => 'checkbox'
	));
?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>

<?php echo $this->Html->link(
    'Back to Users',
    array('controller' => 'users', 'action' => 'index')
); ?>
</div>