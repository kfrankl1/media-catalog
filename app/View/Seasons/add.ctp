<!-- File: /app/View/Seasons/add.ctp -->

<h1>Add Season</h1>
<?php
	echo $this->Form->create('Season');
	echo $this->Form->input('title');
	echo $this->Form->end('Save Season');
?>

<?php echo $this->Html->link(
    'Back to Seasons',
    array('controller' => 'seasons', 'action' => 'index')
); ?>