<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

?>
<?php foreach ($list as $group_name => $group)
{ #echo ' 4654sd48sa7d98sD81s8d71dsa <pre>' . print_r(array_values($group)[0]->displayCategoryLink, true) . '</pre>';exit; ?>
	<div class="catId-<?php echo $group['myCatId']; ?>">
		<h3 class="mt-3 pb-2 pt-1 badge-catcolor">
		<?php echo $group_name; ?>
		</h3>
		<ul>
		<?php
		unset($group['myCatId']);
		foreach ($group as $i => $item)
		{ ?>
		<li>
		<a class="" href="<?php echo $item->link; ?>">
			<?php echo $item->title; ?>
		</a>
		</li>
		<?php
		} ?>
		</ul>
	</div>
<?php
} ?>
