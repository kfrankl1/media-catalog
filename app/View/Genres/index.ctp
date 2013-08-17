<!-- File: /app/View/Genres/index.ctp -->

<h1>Genres</h1>
<?php echo $this->Html->link(
    'Add Genre',
    array('controller' => 'genres', 'action' => 'add')
); ?>
<table>
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('title'); ?></th>
        <th>Actions</th>
        <th><?php echo $this->Paginator->sort('modified'); ?></th>
        <th><?php echo $this->Paginator->sort('modified_by'); ?></th>
    </tr>

    <!-- Here is where we loop through our $genres array, printing out post info -->

    <?php foreach ($genres as $genre): ?>
    <tr>
        <td><?php echo $genre['Genre']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($genre['Genre']['title'],
							array('controller' => 'genres', 'action' => 'view', $genre['Genre']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $genre['Genre']['id']),
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $genre['Genre']['id'])); ?>
        </td>
        <td><?php echo $genre['Genre']['modified']; ?></td>
        <td>
			<?php echo $this->Html->link(
							$genre['ModifiedBy']['first_name'] . " " . $genre['ModifiedBy']['last_name'],
							array('controller' => 'users', 'action' => 'view', $genre['Genre']['modified_by'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($genre); ?>
</table>