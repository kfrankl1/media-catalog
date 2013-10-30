<!-- File: /app/View/Genres/view.ctp -->

<h1><?php echo h($genre['Genre']['title']); ?></h1>

<p><small>Created on <?php echo $this->Time->nice($genre['Genre']['created']); ?> by <?php echo $genre['CreatedBy']['first_name'] . " " . $genre['CreatedBy']['last_name'] ?></small></p>
<p><small>Modified on <?php echo $this->Time->nice($genre['Genre']['modified']); ?> by <?php echo $genre['ModifiedBy']['first_name'] . " " . $genre['ModifiedBy']['last_name']; ?></small></p>


<p><?php if ($canEditGenre) {
		echo $this->Html->link('Edit', 
		array('action' => 'edit', $genre['Genre']['id']));
	} ?>
</p>

<p><?php echo $this->Html->link('Back to Genres',
    array('controller' => 'genres', 'action' => 'index')); ?>
</p>