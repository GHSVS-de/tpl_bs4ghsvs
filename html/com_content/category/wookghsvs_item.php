<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

if ($this->item->params->get('link_titles_blog_ghsvs', ''))
{
	$this->item->params->set('link_titles', 1);
}
// Create a shortcut for params.
$params = $this->item->params;
HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);
?>
<?php
 echo HTMLHelper::_('bs3ghsvs.layout',
	 'ghsvs.page_header_n_icons',
		array(
		 'item' => $this->item,
		 'print' => false
		)
	);
?>

<?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
	|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') ); ?>

<?php
if ($useDefList && ($info == 0 || $info == 2)) : ?>
	<?php echo HTMLHelper::_(
	 'bs3ghsvs.layout',
		'joomla.content.info_block.block',
		array(
		 'item' => $this->item,
			'params' => $params,
			'position' => 'above'
		)
	); ?>
<?php endif; ?>
<?php echo $this->item->event->beforeDisplayContent; ?>

<?php if (!$params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>

<?php
// Alle Bilder entfernen. Ist das noch nötig? Macht doch eh Plugin articlesubtitle.
if ($params->get('clearimgtag_blogview_ghsvs', 1))
{
	$this->item->introtext = OutputFilter::stripImages($this->item->introtext);
}
// Introtext kürzen
$limit = (int) $params->get('introtext_limit_ghsvs', 250);
if ($limit > 20)
{
 $truncated = HTMLHelper::_(
	 'string.truncateComplex',
	 $this->item->introtext,
	 $limit
 );
 // Bisschen plump:
 if (!$this->item->readmore && mb_substr($truncated, -3) == '...')
 {
	 $this->item->readmore = true;
 }
 // Und jetzt statt Introtext:
 echo $truncated;
}
else
{
	echo $this->item->introtext;
}
?>
<?php
if ($params->get('show_introimage_blogview_ghsvs', 0))
{
	echo HTMLHelper::_('bs3ghsvs.layout', 
		'ghsvs.intro_image_readmore',
		array('item' => $this->item)
	);
}
?>
<?php echo $this->loadTemplate('itemlinks'); ?>
<?php if ($params->get('show_readmore') && $this->item->readmore) :
	if ($params->get('access-view')) :
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

	<?php echo HTMLHelper::_('bs3ghsvs.layout', 'joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

<?php endif; ?>

<?php if ($params->get('show_tags')) : ?>
	<?php echo HTMLHelper::_('bs3ghsvs.layout', 'ghsvs.tags_n_tagscat', $this->item); ?>
<?php endif; ?>
<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
	<?php echo HTMLHelper::_('bs3ghsvs.layout', 'joomla.content.info_block.block', array(
	 'item' => $this->item,
		'params' => $params,
		'position' => 'below'
		)); ?>
<?php  endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>
