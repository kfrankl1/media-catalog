<!-- File: /app/View/Shows/index.ctp -->

<h1>Shows</h1>
<?php echo $this->Html->link(
    'Add Show',
    array('controller' => 'shows', 'action' => 'add')
); ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Tagline</th>
        <th>Description</th>
        <th>Actions</th>
        <th>Last Modified</th>
        <th>Modified By</th>
    </tr>

    <!-- Here is where we loop through our $shows array, printing out post info -->

    <?php foreach ($shows as $show): ?>
    <tr>
        <td><?php echo $show['Show']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($show['Show']['title'],
							array('controller' => 'shows', 'action' => 'view', $show['Show']['id'])); ?>
        </td>
        <td><?php echo $show['Show']['tagline']; ?></td>
        <td><?php echo $show['Show']['description']; ?></td>
        <td>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $show['Show']['id']),
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $show['Show']['id'])); ?>
        </td>
        <td><?php echo $show['Show']['modified']; ?></td>
        <td>
			<?php echo $this->Html->link(
							$show['ModifiedBy']['first_name'] . " " . $show['ModifiedBy']['last_name'],
							array('controller' => 'users', 'action' => 'view', $show['Show']['modified_by'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($show); ?>
</table>