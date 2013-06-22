<!-- File: /app/View/Seasons/edit.ctp -->

<h1>Edit Season</h1>
<?php
    echo $this->Form->create('Season');
    echo $this->Form->input('title');
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save Season');
?>

<?php echo $this->Html->link(
    'Back to Seasons',
    array('controller' => 'seasons', 'action' => 'index')
); ?>