<!-- File: /app/View/Seasons/index.ctp -->

<h1>Seasons</h1>
<?php echo $this->Html->link(
    'Add Season',
    array('controller' => 'seasons', 'action' => 'add')
); ?>
<table>
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('title'); ?></th>
        <th>Actions</th>
        <th><?php echo $this->Paginator->sort('modified'); ?></th>
        <th><?php echo $this->Paginator->sort('modified_by'); ?></th>
    </tr>

    <!-- Here is where we loop through our $seasons array, printing out post info -->

    <?php foreach ($seasons as $season): ?>
    <tr>
        <td><?php echo $season['Season']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($season['Season']['title'],
							array('controller' => 'seasons', 'action' => 'view', $season['Season']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $season['Season']['id']),
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $season['Season']['id'])); ?>
        </td>
        <td><?php echo $season['Season']['modified']; ?></td>
        <td>
			<?php echo $this->Html->link(
							$season['ModifiedBy']['first_name'] . " " . $season['ModifiedBy']['last_name'],
							array('controller' => 'users', 'action' => 'view', $season['Season']['modified_by'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($season); ?>
</table>