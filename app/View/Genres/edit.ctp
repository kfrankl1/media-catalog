<!-- File: /app/View/Genres/edit.ctp -->

<h1>Edit Role</h1>
<?php
    echo $this->Form->create('Genre');
    echo $this->Form->input('title');
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save Genre');
?>

<?php echo $this->Html->link(
    'Back to Genres',
    array('controller' => 'genres', 'action' => 'index')
); ?>