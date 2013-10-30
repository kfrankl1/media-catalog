<!-- File: /app/View/Roles/index.ctp -->

<h1>Roles</h1>
<?php if ($canAddRole) {
	echo $this->Html->link(
    	'Add Role',
	    array('controller' => 'roles', 'action' => 'add')
	);
} ?>
<table>
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('title'); ?></th>
        <th><?php echo $this->Paginator->sort('is_add_user', 'Add User'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_any_user', 'Edit Any User'); ?></th>
        <th><?php echo $this->Paginator->sort('is_add_role', 'Add Role'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_any_user_role', 'Edit Any User\'s Role'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_any_user_status', 'Edit Any User Status'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_any_role', 'Edit Any Role'); ?></th>
        <th><?php echo $this->Paginator->sort('is_add_show', 'Add Show'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_any_show', 'Edit Any Show'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_any_show_status', 'Edit Any Show Status'); ?></th>
        <th><?php echo $this->Paginator->sort('is_add_any_episode', 'Add Any Episode'); ?></th>
        <th><?php echo $this->Paginator->sort('is_add_authorized_episode', 'Add Authorized Episode'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_any_episode', 'Edit Any Episode'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_authored_episode', 'Edit Authored Episode'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_authorized_episode', 'Edit Authorized Episode'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_any_episode_status', 'Edit Any Episode Status'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_authorized_episode_status', 'Edit Authorized Episode Status'); ?></th>
        <th><?php echo $this->Paginator->sort('is_add_genre', 'Add Genre'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_any_genre', 'Edit Any Genre'); ?></th>
        <th><?php echo $this->Paginator->sort('is_add_season', 'Add Season'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_any_season', 'Edit Any Season'); ?></th>
        <th><?php echo $this->Paginator->sort('is_edit_settings', 'Edit Settings'); ?></th>
        <th>Actions</th>
        <th><?php echo $this->Paginator->sort('modified'); ?></th>
        <th><?php echo $this->Paginator->sort('modified_by'); ?></th>
    </tr>

    <!-- Here is where we loop through our $roles array, printing out post info -->

    <?php foreach ($roles as $role): ?>
    <tr>
        <td><?php echo $role['Role']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($role['Role']['title'],
							array('controller' => 'roles', 'action' => 'view', $role['Role']['id'])); ?>
        </td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_add_user']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_any_user']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_add_role']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_any_user_role']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_any_user_status']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_any_role']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_add_show']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_any_show']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_any_show_status']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_add_any_episode']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_add_authorized_episode']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_any_episode']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_authorized_episode']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_authored_episode']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_any_episode_status']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_authorized_episode_status']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_add_genre']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_any_genre']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_add_season']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_any_season']); ?></td>
        <td><?php echo $this->UI->toBolString($role['Role']['is_edit_settings']); ?></td>
        <td>
            <?php if ($canEditRole) {
					echo $this->Form->postLink(
					'Delete',
					array('action' => 'delete', $role['Role']['id']),
					array('confirm' => 'Are you sure?'));
			}
            ?>
            <?php if ($canEditRole) {
						echo $this->Html->link('Edit', array('action' => 'edit', $role['Role']['id']));
			} ?>
        </td>
        <td><?php echo $this->Time->format($role['Role']['modified'], $timeFormat); ?></td>
        <td>
			<?php echo $this->Html->link(
						$role['ModifiedBy']['first_name'] . " " . $role['ModifiedBy']['last_name'],
						array('controller' => 'users', 'action' => 'view', $role['Role']['modified_by'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($role); ?>
</table>