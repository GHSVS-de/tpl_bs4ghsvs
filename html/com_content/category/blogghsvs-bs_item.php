<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Layout\LayoutHelper;

/*
GHSVS 2014-12-22
Ich will kein Drucken/Email in Featured oder Blog-View
*/
$this->item->params->set('show_print_icon', 0);
$this->item->params->set('show_email_icon', 0);

// "Blog-überschriften trotzdem verlinken"
if ((int) $this->item->params->get('link_titles_blog_ghsvs', '') === 1)
{
	$this->item->params->set('link_titles', 1);
}

HTMLHelper::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $this->item->params->get('info_block_position', 0);
?>

<?php

$this->item->params->set('show_articlesubtitle', 0);

$cardHeader = LayoutHelper::render('ghsvs.page_header_n_icons',
	array('item' => $this->item, 'print' => false)
	);
?>
<?php
 $useDefList = (
	$this->item->params->get('show_modify_date') ||
	$this->item->params->get('show_publish_date') ||
	$this->item->params->get('show_create_date') ||
	$this->item->params->get('show_category') ||
	$this->item->params->get('show_parent_category') ||
	$this->item->params->get('show_author') );
?>

<?php echo $this->item->event->beforeDisplayContent; ?>

<?php if (!$this->item->params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>

<?php
$introtextClasses = '';

if ($this->item->params->get('show_introimage_blogview_ghsvs', 0))
{
	// Leading items have full width.
	if ($this->whichItem === 'leadItem')
	{
		$imageClasses = '';
	}
	// intro items are in 2 columns
	else
	{
		$imageClasses = '';
	}

	$cardImage = trim(LayoutHelper::render('ghsvs.intro_image_readmore',
		[
			'item' => $this->item,
			'options' => [
				'classes' => $imageClasses,
				// 'link' => '',
				// Marker for image sources in layout intro_image_readmore.php.
				'whichItem' => $this->whichItem,
			]
		]
	));

	if ($cardImage)
	{
		// echo $cardImage;
		// Leading items have full width.
		if ($this->whichItem === 'leadItem')
		{
			$introtextClasses .= '';
		}
		// intro items are in 2 columns
		else
		{
			$introtextClasses .= '';
		}
	}
}
?>


	<?php
	// Introtext kürzen
	$limit = (int) $this->item->params->get('introtext_limit_ghsvs', 250);

	if ($limit > 20)
	{
		$truncated = HTMLHelper::_('string.truncateComplex',
			$this->item->introtext, $limit
	 );

	 // Bisschen plump:
	 if (!$this->item->readmore && mb_substr($truncated, -3) == '...')
	 {
		 $this->item->readmore = true;
	 }
	 // Und jetzt statt Introtext:
	 $cardText = $truncated;
	}
	else
	{
		$cardText = $this->item->introtext;
	}
	?>


<?php if ($this->item->params->get('show_readmore') && $this->item->readmore) :
	if ($this->item->params->get('access-view')) :
		$link = Route::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
	else :
		$menu = Factory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link1 = Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
		$returnURL = Route::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
		$link = new JUri($link1);
		$link->setVar('return', base64_encode($returnURL));
	endif; ?>

	<?php $cardReadmore = LayoutHelper::render('ghsvs.readmore',
		array(
			'item' => $this->item,
			'params' => $this->item->params,
			'link' => $link
		)); ?>

<?php endif; ?>


	<?php
	// Output of <div class="div4article-info">.
	if (($useDefList && is_numeric($info)) || $this->item->params->get('show_tags', 1))
	{
		$cardInfos = LayoutHelper::render('ghsvs.tags_n_article-info-combined',
			array(
				'item' => $this->item,
				'params' => $this->item->params,
				'position' => 'below',
				'useDefList' => $useDefList,
				/* Klasse, die div4article-info angehängt wird (ohne Space), da ich z.B.
				im Blog, was Cards verwendet keine spezielle Formatierung haben will */
				'addDivClass' => '_blogItem'
			)
		);
	} ?>


<?php echo $this->item->event->afterDisplayContent; ?>
<div class="col">
<div class="card h-100 border-danger">


<div class="card-body">
	<div class="card-title"><?php echo $cardHeader; ?></div>
	<div class="card-image"><?php echo $cardImage; ?></div>
	<div class="card-text lead"><?php echo $cardText; ?></div>
	<?php if (!empty($cardReadmore))
	{ ?>
	<div class="card-text"><?php echo $cardReadmore; ?></div>
	<?php
	}?>
</div><!--/card-body-->
<div class="card-footer"><?php echo $cardInfos; ?></div>
</div><!--/card-->
</div><!--/col-->
