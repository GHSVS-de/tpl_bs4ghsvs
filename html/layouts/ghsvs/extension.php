<?php
defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Registry\Registry;

/**
 * $displayData is item->id
*/

JLoader::register(
	'Bs3ghsvsArticle',
	JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ArticleHelper.php'
);

JLoader::register(
	'Bs3ghsvsItem',
	JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ItemHelper.php'
);

$displayData = Bs3ghsvsArticle::getExtensionData($displayData);

if (false === $displayData)
{
	return '';
}

$displayData = new Registry($displayData);
?>
<div class="block-download" aria-labelledby="EXTENSION_INFO">
<h3 id="EXTENSION_INFO"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_INFO'); ?></h3>

<h4 class="h6"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_NAME'); ?></h4>
<p class="breakall">
	<?php echo Text::_($displayData->get('name')); ?>
</p>

<h4 class="h6"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_DESCRIPTION'); ?></h4>
<p>
	<?php echo nl2br($displayData->get('description')); ?>
</p>

<?php
if (($out = trim($displayData->get('inspiredby'))))
{
	if (strpos($out, ' ') === false && Bs3ghsvsItem::hasScheme($out))
	{
		$out = '<a href="' . $out . '">' . $out . '</a>';
	}
?>
	<h4 class="h6"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_INSPIREDBY'); ?></h4>
	<p>
		<?php echo $out; ?>
	</p>
<?php
} ?>

<h4 class="h6"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_URL'); ?></h4>
<p>
	<a href="<?php echo $displayData->get('url'); ?>" class="btn btn-catcolor">
		<span class="sr-only"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_URL_DESC')?></span>
		{svg{bi/download}}
	</a>
</p>

<?php
if ($displayData->get('updateserver'))
{ ?>
<h4 class="h6"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_UPDATESERVER'); ?></h4>
<p>
	<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_UPDATESERVER_'
		. $displayData->get('updateserver')); ?>
</p>
<?php
} ?>

<?php
if ($displayData->get('languages'))
{
	$flags = Bs3ghsvsArticle::buildFlagImages($displayData->get('languages'));	
?>
<h4 class="h6"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_LANGUAGES'); ?></h4>
<p>
	<?php echo implode(' ', $flags); ?>:
</p>
<?php
} ?>

<?php
if (($out = trim($displayData->get('project'))))
{ ?>
<h4 class="h6"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_PROJECT'); ?></h4>
<p>
	<a href="<?php echo $out; ?>" class="btn btn-catcolor">
		<span class="sr-only"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_PROJECT_OPEN'); ?></span>
		{svg{bi/link-45deg}}
	</a>
</p>
<?php
} ?>

<?php
if (($out = trim($displayData->get('comment'))))
{ ?>
<h4 class="h6"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_COMMENT'); ?></h4>
<p>
	<?php echo nl2br($out); ?>
</p>
<?php
} ?>

<?php
if (($out = trim($displayData->get('history'))))
{ ?>
<h4 class="h6"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_HISTORY'); ?></h4>
<p>
	<a href="<?php echo $out; ?>" class="btn btn-catcolor">
		<span class="sr-only"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EXTENSION_HISTORY_OPEN'); ?></span>
		{svg{bi/link-45deg}}
	</a>
</p>
<?php
} ?>

<?php echo Text::_('GHSVS_MODULES_SCRIPT_HINT'); ?>
</div><!--/block-download-->
