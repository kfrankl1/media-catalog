<!-- File: /app/View/Users/view.ctp -->

<h1><?php echo h($user['User']['first_name'] . " " . $user['User']['last_name']); ?></h1>
<p>Email: <?php echo $user['User']['username']; ?></p>
<p>Role: <?php echo $user['Role']['title']; ?></p>
<p>Authorized shows(s): <?php echo $this->Text->toList($shows); ?></p>

<p><small>Created on <?php echo $user['User']['created']; ?> by <?php echo $user['CreatedBy']['first_name'] . " " . $user['CreatedBy']['last_name'] ?></small></p>
<p><small>Modified on <?php echo $user['User']['modified']; ?> by <?php echo $user['ModifiedBy']['first_name'] . " " . $user['ModifiedBy']['last_name']; ?></small></p>


<p><?php echo $this->Html->link('Edit', 
	array('action' => 'edit', $user['User']['id'])); ?>
</p>

<p><?php echo $this->Html->link('Back to Users',
    array('controller' => 'users', 'action' => 'index')); ?>
</p>