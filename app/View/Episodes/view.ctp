<!-- File: /app/View/Episodes/view.ctp -->

<h1><?php echo h($episode['Episode']['title']); ?></h1>
<p>Show ID: <?php echo $episode['Show']['title']; ?></p>
<p>Episode Number: <?php echo $episode['Episode']['episode_number']; ?></p>
<p>Original Air Date: <?php echo $episode['Episode']['original_air_date']; ?></p>

<p><small>Created: <?php echo $episode['Episode']['created']; ?></small></p>
<p><small>Last Modified: <?php echo $episode['Episode']['modified']; ?></small></p>


<p><?php echo $this->Html->link('Edit', 
	array('action' => 'edit', $episode['Episode']['id'])); ?>
</p>

<p><?php echo $this->Html->link('Back to Episodes',
    array('controller' => 'episodes', 'action' => 'index')); ?>
</p>