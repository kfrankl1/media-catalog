<!-- File: /app/View/Seasons/view.ctp -->

<h1><?php echo h($season['Season']['title']); ?></h1>

<p><small>Created on <?php echo $season['Season']['created']; ?> by <?php echo $season['CreatedBy']['first_name'] . " " . $season['CreatedBy']['last_name'] ?></small></p>
<p><small>Modified on <?php echo $season['Season']['modified']; ?> by <?php echo $season['ModifiedBy']['first_name'] . " " . $season['ModifiedBy']['last_name']; ?></small></p>


<p><?php echo $this->Html->link('Edit', 
	array('action' => 'edit', $season['Season']['id'])); ?>
</p>

<p><?php echo $this->Html->link('Back to Seasons',
    array('controller' => 'seasons', 'action' => 'index')); ?>
</p>