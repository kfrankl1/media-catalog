<!-- File: /app/View/Shows/view.ctp -->

<h1><?php echo h($show['Show']['title']); ?></h1>
<p>Tagline: <?php echo $show['Show']['tagline']; ?></p>
<p>Description: <?php echo $show['Show']['description']; ?></p>
<p>Genre(s): <?php echo $this->Text->toList($genres); ?></p>

<p><small>Created on <?php echo $show['Show']['created']; ?> by <?php echo $show['CreatedBy']['first_name'] . " " . $show['CreatedBy']['last_name'] ?></small></p>
<p><small>Modified on <?php echo $show['Show']['modified']; ?> by <?php echo $show['ModifiedBy']['first_name'] . " " . $show['ModifiedBy']['last_name']; ?></small></p>


<p><?php echo $this->Html->link('Edit', 
	array('action' => 'edit', $show['Show']['id'])); ?>
</p>

<p><?php echo $this->Html->link('Back to Shows',
    array('controller' => 'shows', 'action' => 'index')); ?>
</p>