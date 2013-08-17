<!-- File: /app/View/Users/view.ctp -->

<h1><?php echo h($user['User']['username']); ?></h1>
<p>Name: <?php echo $user['User']['first_name'] . " " . $user['User']['last_name']; ?></p>
<p>Email: <?php echo $user['User']['username']; ?></p>
<p>Role: <?php echo $user['Role']['title']; ?></p>
<p>Authorized Show(s): <?php echo $this->Text->toList($shows); ?></p>

<p><small>Created: <?php echo $user['User']['created']; ?></small></p>
<p><small>Last Modified: <?php echo $user['User']['modified']; ?></small></p>


<p><?php echo $this->Html->link('Edit', 
	array('action' => 'edit', $user['User']['id'])); ?>
</p>

<p><?php echo $this->Html->link('Back to Users',
    array('controller' => 'users', 'action' => 'index')); ?>
</p>