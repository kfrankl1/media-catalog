<!-- File: /app/View/Episodes/view.ctp -->

<h1><?php echo h($episode['Episode']['title']); ?></h1>
<p>Show: <?php echo $episode['Show']['title']; ?></p>
<p>Episode Number: <?php echo $episode['Episode']['episode_number']; ?></p>
<p>Short Description: <?php echo $episode['Episode']['short_description']; ?></p>
<p>Long Description: <?php echo $episode['Episode']['long_description']; ?></p>
<p>Original Air Date: <?php echo $episode['Episode']['original_air_date']; ?></p>

<p><small>Created on <?php echo $episode['Episode']['created']; ?> by <?php echo $episode['CreatedBy']['first_name'] . " " . $episode['CreatedBy']['last_name'] ?></small></p>
<p><small>Modified on <?php echo $episode['Episode']['modified']; ?> by <?php echo $episode['ModifiedBy']['first_name'] . " " . $episode['ModifiedBy']['last_name']; ?></small></p>


<p><?php if ($episode['Episode']['created_by'] == AuthComponent::user('id')
			| AuthComponent::user('role_id') === '1') {
			echo $this->Html->link('Edit', array('action' => 'edit', $episode['Episode']['id'])); 
		}
	?>
</p>
<p><?php
		if (AuthComponent::user('role_id') === '1') {
			echo $this->Form->postLink(
				'Delete',
				array('action' => 'delete', $episode['Episode']['id']),
				array('confirm' => 'Are you sure?'));
		}
	?>
</p>

<p><?php echo $this->Html->link('Back to Episodes',
    array('controller' => 'episodes', 'action' => 'index')); ?>
</p>