<!-- File: /app/View/Episodes/index.ctp -->

<h1>Episodes</h1>
<?php echo $this->Html->link(
    'Add Episode',
    array('controller' => 'episodes', 'action' => 'add')
); ?>
<table>
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('is_active'); ?></th>
        <th><?php echo $this->Paginator->sort('Show.title', 'Show'); ?></th>
        <th><?php echo $this->Paginator->sort('title'); ?></th>
        <th><?php echo $this->Paginator->sort('episode_number'); ?></th>
        <th><?php echo $this->Paginator->sort('original_air_date'); ?></th>
        <th><?php echo $this->Paginator->sort('Season.title', 'Season'); ?></th>
        <th>Actions</th>
        <th><?php echo $this->Paginator->sort('modified'); ?></th>
        <th><?php echo $this->Paginator->sort('modified_by'); ?></th>
    </tr>

    <!-- Here is where we loop through our $episodes array, printing out episode info -->

    <?php foreach ($episodes as $episode): ?>
    <tr>
        <td><?php echo $episode['Episode']['id']; ?></td>
        <td><?php echo $episode['Episode']['is_active']; ?></td>
        <td>
            <?php echo $this->Html->link($episode['Show']['title'],
							array('controller' => 'shows', 'action' => 'view', $episode['Show']['id']));
			?>
        </td>
        <td>
            <?php echo $this->Html->link($episode['Episode']['title'],
							array('controller' => 'episodes', 'action' => 'view', $episode['Episode']['id'])); ?>
        </td>
        <td><?php echo $episode['Episode']['episode_number']; ?></td>
        <td><?php echo $episode['Episode']['original_air_date']; ?></td>
        <td><?php echo $episode['Season']['title']; ?></td>
        <td>
            <?php
            	if (AuthComponent::user('role_id') === '1') {
					echo $this->Form->postLink(
						'Delete',
						array('action' => 'delete', $episode['Episode']['id']),
						array('confirm' => 'Are you sure?'));
				}
            ?>
            <?php			
				if ($episode['Episode']['created_by'] == AuthComponent::user('id')
					| AuthComponent::user('role_id') === '1') {
					echo $this->Html->link('Edit', array('action' => 'edit', $episode['Episode']['id'])); 
				}
			?>
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