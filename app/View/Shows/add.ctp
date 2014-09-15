<!-- File: /app/View/Shows/add.ctp -->

<h1>Add Show</h1>
<?php
	echo $this->Form->create('Show');
	echo $this->Form->input('title');
	echo $this->Form->input('tagline');
	echo $this->Form->input('description');
	echo $this->Form->input('logo_image_file');
?>
    <!--	Adding 'required' to ShowGenre adds required class to all options.
            Manually creating the label makes for a better UI. -->
	<div class="required"><label for="ShowGenre">Genres</label></div>
<?php
	echo $this->Form->input('Show.Genre', array(
        'label' => false
        ,'type' => 'select'
        ,'multiple' => 'checkbox'
	));
	echo $this->Form->end('Save Show');
?>

<?php echo $this->Html->link(
    'Back to Shows',
    array('controller' => 'shows', 'action' => 'index')
); ?>