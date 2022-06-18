<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

?>
<?php
if ($params->get('robotsHide', 1) === 1 && $params->get('isRobot') === 1)
{
	return;
}

echo LayoutHelper::render('ghsvs.moduleColDiv.start', [
	'module' => $module,
	'params' => $params,
	'prependClass' => '',
]);
?>
<div class="teilenSuchenButtons">
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#TeilenSuchePanel">
	<span class="visually-hidden"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_SHARE'); ?></span>
	<?php echo Text::_('TPL_BS4GHSVS_MODAL_BUTTON_SHARE_LONG'); ?>
</button><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#TeilenSuchePanel">
	<span class="visually-hidden"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_SEARCH_START'); ?></span>
	{svg{solid/search}}
</button>
</div>
<?php echo LayoutHelper::render('ghsvs.moduleColDiv.end'); ?>
