<!-- File: /app/View/Episodes/index.ctp -->

<h1>Episodes</h1>
<?php echo $this->Html->link(
    'Add Episode',
    array('controller' => 'episodes', 'action' => 'add')
); ?>
<table>
    <tr>
        <th>Id</th>
        <th>Active</th>
        <th>Title</th>
        <th>Episode Number</th>
        <th>Original Air Date</th>
        <th>Season</th>
        <th>Show</th>
        <th>Actions</th>
        <th>Last Modified</th>
        <th>Modified By</th>
    </tr>

    <!-- Here is where we loop through our $episodes array, printing out post info -->

    <?php foreach ($episodes as $episode): ?>
    <tr>
        <td><?php echo $episode['Episode']['id']; ?></td>
        <td><?php echo $episode['Episode']['is_active']; ?></td>
        <td>
            <?php echo $this->Html->link($episode['Episode']['title'],
							array('controller' => 'episodes', 'action' => 'view', $episode['Episode']['id'])); ?>
        </td>
        <td><?php echo $episode['Episode']['episode_number']; ?></td>
        <td><?php echo $episode['Episode']['original_air_date']; ?></td>
        <td><?php echo $episode['Season']['title']; ?></td>
        <td><?php echo $episode['Show']['title']; ?></td>
        <td>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $episode['Episode']['id']),
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $episode['Episode']['id'])); ?>
        </td>
        <td><?php echo $episode['Episode']['modified']; ?></td>
        <td>
			<?php echo $this->Html->link(
							$episode['ModifiedBy']['first_name'] . " " . $episode['ModifiedBy']['last_name'],
							array('controller' => 'users', 'action' => 'view', $episode['Episode']['modified_by'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($show); ?>
</table>