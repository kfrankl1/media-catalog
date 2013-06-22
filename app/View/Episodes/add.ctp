<!-- File: /app/View/Episodes/add.ctp -->

<h1>Add Episode</h1>
<?php
	echo $this->Form->create('Episode');
	echo $this->Form->input('title');
	echo $this->Form->input('short_description');
	echo $this->Form->input('long_description');
	echo $this->Form->input('episode_number');
	echo $this->Form->input('original_air_date');
	echo $this->Form->input('show_id');
	echo $this->Form->end('Save Episode');
?>

<?php echo $this->Html->link(
    'Back to Episodes',
    array('controller' => 'episodes', 'action' => 'index')
); ?>