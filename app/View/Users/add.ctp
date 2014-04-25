<!-- app/View/Users/add.ctp -->
<?php echo $this->Html->script('prototype'); ?>
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

<?php //if ($requireShow) { ?>
		
<!--	Adding 'required' to ShowUser adds required class to all options.
        Manually creating the label makes for a better UI. -->
<div class="required"><label for="ShowUser">Authorized Shows</label></div>
<?php
		echo $this->Form->input('User.Show', array(
			'label' => false
			,'type' => 'select'
			//,'multiple' => 'checkbox'
		)); 
	//}
?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>

<?php echo $this->Html->link(
    'Back to Users',
    array('controller' => 'users', 'action' => 'index')
); ?>

<?php

//$this->Js->event('click', 'alert("whoa!");', false);

// http://www.verious.com/tutorial/dynamic-select-box-with-cake-php-2-0
$this->Js->get('#UserRoleId')->event('change', $this->Js->request(
	//array( 
//		'controller'=>'shows',
//		'action'=>'getByRole'
//	),
	array('action' => 'shows', 'getByRole'),
	array(
		'action' => 'shows', 'getByRole',
		'update'=>'#UserShow',
		'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		'data'=> $this->Js->serializeForm(array( 'isForm' => true, 'inline' => true ))
	)
));

	// Once the user selects a role, decide whether or not the user needs to pick an authorized show
//    $this->Js->get('#UserRoleId')->event('change', $this->Js->request(
//		array( 
//			'controller'=>'show',
//			'action'=>'getShowsForRole' 
//		)
//		,array( 
//			'update'=>'#UserShow', 
//			'async' => true, 
//			'method' => 'post', 
//			'dataExpression'=>true, 
//			'data'=> $this->Js->serializeForm(array( 'isForm' => true, 'inline' => true ))
//		)
//	));
?>
</div>