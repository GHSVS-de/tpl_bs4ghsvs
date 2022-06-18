<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/' . basename(__FILE__) . '-->' . PHP_EOL;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

// Benötigt in JLayout ghsvs.tags_n_tagscat
$this->params->set('itemIsCatGhsvs', 1);

$leadingcount = 0;
$this->columns = $this->params->get('num_columns', 3);
$this->intro_items = $this->items[$this->parent->id];

if (!$this->params->get('show_empty_categories_cat', 0))
{
	foreach ($this->intro_items as $key => $item)
	{
		if (!$item->numitems && !count($item->getChildren()))
		{
			unset($this->intro_items[$key]);
		}
	}
}

##### NUR FÜR DEBUG !!!! ####
/*
Paar Properties entfernen für lesbare Ausgabe eines einzelnen Items.
Vorsicht!! Damit werden ggf. andere, ganze Items gelöscht!!! Kein Plan warum!
*/
/*foreach ($this->intro_items as $key => $item)
{
	if (is_object($item))
	{
		$item->set("_parent", null);
		$item->set("_constructor", null);
		$item->set("_rightSibling", null);
		$item->set("_rightsibling", null);
		$item->set("_leftSibling", null);
	}else{
	}
}
exit;*/
##### ENDE - NUR FÜR DEBUG !!!! ####

?>
<div class="blog-featured<?php echo $this->pageclass_sfx;?>">

<div class="categories-list<?php echo $this->pageclass_sfx;?>">
	<?php echo HTMLHelper::_('bs3ghsvs.layout', 'ghsvs.categories_default', $this);?>
</div><!--/categories-list-->
<div class="categories-page">
<?php
	$introcount = (count($this->intro_items));
	$counter = 0;
?>

<?php if (!empty($this->intro_items)) : ?>
	<?php foreach ($this->intro_items as $key => &$item) :
	 $item->state = $item->published;
		$key = ($key - $leadingcount) + 1;
		$rowcount = (((int) $key - 1) % (int) $this->columns) + 1;
		$row = $counter / $this->columns;

		if ($rowcount == 1) : ?>
		<div class="items-row cols-<?php echo (int) $this->columns;?> <?php echo 'row-' . $row; ?> row-fluid">
		<?php endif; ?>
			<div class="item column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?> span<?php echo round((12 / $this->columns));?>">
			<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
			?>
			</div>
			<?php $counter++; ?>
			<?php if (($rowcount == $this->columns) or ($counter == $introcount)) : ?>
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
</div><!--/item-page<?php echo $this->pageclass_sfx;?>-->
</div><!--/blog-featured<?php echo $this->pageclass_sfx;?>-->
