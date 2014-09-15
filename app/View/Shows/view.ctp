<!-- File: /app/View/Shows/view.ctp -->

<h1><?php echo h($show['Show']['title']); ?></h1>
<p>
    <a href="<?php echo $show['Show']['logo_image_file']; ?>" title="Download <?php echo $show['Show']['title']; ?> logo" target="_blank">
        <img src="<?php echo $show['Show']['logo_image_file']; ?>" alt="<?php echo $show['Show']['title']; ?> logo" width="300" />
    </a>
</p>
<p>Tagline: <?php echo $show['Show']['tagline']; ?></p>
<p>Description: <?php echo $show['Show']['description']; ?></p>
<p>Genre(s): <?php echo $this->Text->toList($genres); ?></p>

<p><small>Created on <?php echo $show['Show']['created']; ?> by <?php echo $show['CreatedBy']['first_name'] . " " . $show['CreatedBy']['last_name'] ?></small></p>
<p><small>Modified on <?php echo $show['Show']['modified']; ?> by <?php echo $show['ModifiedBy']['first_name'] . " " . $show['ModifiedBy']['last_name']; ?></small></p>


<p><?php if ($canEditShow) {
		echo $this->Html->link('Edit', 
		array('action' => 'edit', $show['Show']['id'])); 
} ?>
</p>

<!-- See show's episodes here -->

<h2>Episodes</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Is Active</th>
        <th>Title</th>
        <th>Episode Number</th>
        <th>Original Air Date</th>
        <th>Still Image File</th>
        <th>Episode File</th>
        <th>Season</th>
        <th>Modified</th>
        <th>Modified By</th>
    </tr>

    <!-- Here is where we loop through our $episodes array, printing out episode info -->

    <?php foreach ($episodes as $episode): ?>
    <tr>
        <td><?php echo $episode['Episode']['id']; ?></td>
        <td><?php echo $this->UI->toBolString($episode['Episode']['is_active']); ?></td>
        <td>
            <?php echo $this->Html->link($episode['Episode']['title'],
							array('controller' => 'episodes', 'action' => 'view', $episode['Episode']['id'])); ?>
        </td>
        <td><?php echo $episode['Episode']['episode_number']; ?></td>
        <td><?php echo $this->Time->format($episode['Episode']['original_air_date'], $timeFormat); ?></td>
        <td><a href="<?php echo $episode['Episode']['still_image_file']; ?>" title="Download <?php echo $episode['Episode']['title']; ?> still" target="_blank">Download still</a></td>
        <td><a href="<?php echo $episode['Episode']['episode_file']; ?>" title="Download <?php echo $episode['Episode']['title']; ?> episode" target="_blank">Download file</a></td>
        <td><?php echo $episode['Season']['title']; ?></td>
        <td><?php echo $this->Time->format($episode['Episode']['modified'], $timeFormat); ?></td>
        <td>
			<?php echo $this->Html->link(
							$episode['ModifiedBy']['first_name'] . " " . $episode['ModifiedBy']['last_name'],
							array('controller' => 'users', 'action' => 'view', $episode['Episode']['modified_by'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($show); ?>
</table>

<!-- End show's episodes -->

<p><?php echo $this->Html->link('Back to Shows',
    array('controller' => 'shows', 'action' => 'index')); ?>
</p>