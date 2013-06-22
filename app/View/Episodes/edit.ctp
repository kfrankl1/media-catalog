<!-- File: /app/View/Shows/edit.ctp -->

<h1>Edit Show</h1>
<?php
	echo $this->Form->create('Episode', array('type' => 'file'));
	echo $this->Form->input('title');
	echo $this->Form->input('short_description');
	echo $this->Form->input('long_description');
	echo $this->Form->input('episode_number');
	echo $this->Form->input('original_air_date');
	//echo $this->Form->input('still_image_file', array('between' => '<br />', 'type' => 'file'));
	//echo $this->Form->input('episode_file', array('type' => 'file'));
	echo $this->Form->input('show_id');
	echo $this->Form->end('Save Episode');
?>

<?php echo $this->Html->link(
    'Back to Episodes',
    array('controller' => 'episodes', 'action' => 'index')
); ?>