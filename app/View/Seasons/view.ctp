<!-- File: /app/View/Seasons/view.ctp -->

<h1><?php echo h($season['Season']['title']); ?></h1>

<p><small>Created: <?php echo $season['Season']['created']; ?></small></p>
<p><small>Last Modified: <?php echo $season['Season']['modified']; ?></small></p>


<p><?php echo $this->Html->link('Edit', 
	array('action' => 'edit', $season['Season']['id'])); ?>
</p>

<p><?php echo $this->Html->link('Back to Seasons',
    array('controller' => 'seasons', 'action' => 'index')); ?>
</p>