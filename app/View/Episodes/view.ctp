<!-- File: /app/View/Episodes/view.ctp -->

<h1><?php echo h($episode['Episode']['title']); ?></h1>
<p>Show: <?php echo $episode['Show']['title']; ?></p>
<p>Episode Number: <?php echo $episode['Episode']['episode_number']; ?></p>
<p>Short Description: <?php echo $episode['Episode']['short_description']; ?></p>
<p>Long Description: <?php echo $episode['Episode']['long_description']; ?></p>
<p>Original Air Date: <?php echo $episode['Episode']['original_air_date']; ?></p>

<p><small>Created: <?php echo $episode['Episode']['created']; ?></small></p>
<p><small>Last Modified: <?php echo $episode['Episode']['modified']; ?></small></p>


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