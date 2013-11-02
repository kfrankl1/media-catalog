<!-- File: /app/View/Roles/view.ctp -->

<h1><?php echo h($role['Role']['title']); ?></h1>
<p>Add User: <?php echo $this->UI->toBolString($role['Role']['is_add_user']); ?></p>
<p>Edit Any User: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_user']); ?></p>
<p>Add Role: <?php echo $this->UI->toBolString($role['Role']['is_add_role']); ?></p>
<p>Edit Any User Role: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_user_role']); ?></p>
<p>Edit Any User's Shows: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_user_show']); ?></p>
<p>Edit Any User Status: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_user_status']); ?></p>
<p>Edit Any Role: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_role']); ?></p>
<p>Add Show: <?php echo $this->UI->toBolString($role['Role']['is_add_show']); ?></p>
<p>Edit Any Show: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_show']); ?></p>
<p>Edit Any Show Status: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_show_status']); ?></p>
<p>Add Any Episode: <?php echo $this->UI->toBolString($role['Role']['is_add_any_episode']); ?></p>
<p>Add Authorized Episode: <?php echo $this->UI->toBolString($role['Role']['is_add_authorized_episode']); ?></p>
<p>Edit Any Episode: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_episode']); ?></p>
<p>Edit Authored Episode: <?php echo $this->UI->toBolString($role['Role']['is_edit_authored_episode']); ?></p>
<p>Edit Any Episode Status: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_episode_status']); ?></p>
<p>Edit Authorized Episode Status: <?php echo $this->UI->toBolString($role['Role']['is_edit_authorized_episode_status']); ?></p>
<p>Add Genre: <?php echo $this->UI->toBolString($role['Role']['is_add_genre']); ?></p>
<p>Edit Any Genre: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_genre']); ?></p>
<p>Add Season: <?php echo $this->UI->toBolString($role['Role']['is_add_season']); ?></p>
<p>Edit Any Season: <?php echo $this->UI->toBolString($role['Role']['is_edit_any_season']); ?></p>
<p>Edit Settings: <?php echo $this->UI->toBolString($role['Role']['is_edit_settings']); ?></p>

<p><small>Created on <?php echo $this->Time->nice($role['Role']['created']); ?> by <?php echo $role['CreatedBy']['first_name'] . " " . $role['CreatedBy']['last_name'] ?></small></p>
<p><small>Modified on <?php echo $this->Time->nice($role['Role']['modified']); ?> by <?php echo $role['ModifiedBy']['first_name'] . " " . $role['ModifiedBy']['last_name']; ?></small></p>


<p><?php if ($canEditRole) {
			echo $this->Html->link('Edit', 
			array('action' => 'edit', $role['Role']['id']));
}?>
</p>

<p><?php echo $this->Html->link('Back to Roles',
    array('controller' => 'roles', 'action' => 'index')); ?>
</p>