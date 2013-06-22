<!-- File: /app/View/Shows/edit.ctp -->

<h1>Edit Show</h1>
<?php
    echo $this->Form->create('Show');
    echo $this->Form->input('title');
    echo $this->Form->input('tagline');
    echo $this->Form->input('description');
	echo $this->Form->input('Genre', array(
        'label' => __('Genre', true)
        ,'type' => 'select'
        ,'multiple' => 'checkbox'
	));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save Show');
?>

<?php echo $this->Html->link(
    'Back to Shows',
    array('controller' => 'shows', 'action' => 'index')
); ?>