<!-- File: /app/View/Genres/add.ctp -->

<h1>Add Genre</h1>
<?php
	echo $this->Form->create('Genre');
	echo $this->Form->input('title');
	echo $this->Form->end('Save Genre');
?>

<?php echo $this->Html->link(
    'Back to Genres',
    array('controller' => 'genres', 'action' => 'index')
); ?>