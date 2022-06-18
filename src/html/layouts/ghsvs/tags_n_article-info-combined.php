<?php
/*
Fasst <div class="div4article-info"> zusammen.
Ruft die Jlayouts 'ghsvs.tags_n_tagscat' und 'joomla.content.info_block.block'.
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/**
 * $item' => $this->item,
 * $params' => $this->item->params,
 * $position' => 'below'
 * $useDefList
*/
extract($displayData);

$tagsBlock = '';
$infoBlock = '';

$isCategoryView = in_array(
	Factory::getApplication()->input->get('view'),
	['category', 'featured', 'categories']
);

if ($isCategoryView && $params->get('show_tags_in_article_in_blog_view', 0) === 0)
{
	$params->set('show_tags', 0);
}

if ($params->get('show_tags', 1))
{
	$tagsBlock = trim(HTMLHelper::_(
		'bs3ghsvs.layout',
		'ghsvs.tags_n_tagscat',
		['item' => $item]
	));
}

if ($useDefList)
{
	$infoBlock = trim(HTMLHelper::_(
		'bs3ghsvs.layout',
		'joomla.content.info_block.block',
		[
			'item' => $item,
			'params' => $params,
			'position' => $position,
		]
	));
}
?>
<?php if ($tagsBlock || $infoBlock)
{ ?>
<div class="div4article-info<?php echo !empty($addDivClass) ? $addDivClass : ''; ?>">
	<h3 class="visually-hidden"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_ARTICLE_INFO'); ?></h3>
	<?php echo $tagsBlock; ?>
	<?php if ($infoBlock)
	{ ?>
		<h4 class="visually-hidden"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_ARTICLE_INFO_PUBLISHING'); ?></h4>
		<?php echo $infoBlock; ?>
	<?php
	} ?>
</div><!--/div4article-info-->
<?php
} ?>
