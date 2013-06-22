<!-- File: /app/View/Shows/view.ctp -->

<h1><?php echo h($show['Show']['title']); ?></h1>
<p>Tagline: <?php echo $show['Show']['tagline']; ?></p>
<p>Description: <?php echo $show['Show']['description']; ?></p>

<p><small>Created: <?php echo $show['Show']['created']; ?></small></p>
<p><small>Last Modified: <?php echo $show['Show']['modified']; ?></small></p>

<?php echo $this->Html->link(
    'Back to Shows',
    array('controller' => 'shows', 'action' => 'index')
); ?>