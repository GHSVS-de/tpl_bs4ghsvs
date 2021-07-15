<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

?>
<?php foreach ($list as $group_name => $group)
{ #echo ' 4654sd48sa7d98sD81s8d71dsa <pre>' . print_r($group, true) . '</pre>';exit; ?>
	<div class="catId-<?php echo $group['myCatId']; ?>">
		<h3 class="h5 mt-3"><?php echo $group_name; ?></h3>
		<?php
		unset($group['myCatId']);
		foreach ($group as $i => $item)
		{ ?>
		<a class="badge badge-catcolor" href="<?php echo $item->link; ?>">
			<?php echo $item->title; ?>
		</a>
		<?php
		} ?>
	</div>
<?php
} ?>
