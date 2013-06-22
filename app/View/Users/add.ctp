<!-- app/View/Users/add.ctp -->
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php
			echo $this->Form->input('first_name');
			echo $this->Form->input('last_name');
			echo $this->Form->input('username');
			echo $this->Form->input('password');
			echo $this->Form->input('role_id');
		?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>

<?php echo $this->Html->link(
    'Back to Users',
    array('controller' => 'users', 'action' => 'index')
); ?>
</div>