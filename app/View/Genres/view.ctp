<!-- File: /app/View/Genres/view.ctp -->

<h1><?php echo h($genre['Genre']['title']); ?></h1>

<p><small>Created: <?php echo $genre['Genre']['created']; ?></small></p>
<p><small>Last Modified: <?php echo $genre['Genre']['modified']; ?></small></p>


<p><?php echo $this->Html->link('Edit', 
	array('action' => 'edit', $genre['Genre']['id'])); ?>
</p>

<p><?php echo $this->Html->link('Back to Genres',
    array('controller' => 'genres', 'action' => 'index')); ?>
</p>