<?php
defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

if (!$lineone)
{
	return;
}
?>
<?php
echo LayoutHelper::render('ghsvs.moduleColDiv.start', [
	'module' => $module,
	'params' => $params,
	'prependClass' => '',
]);
?>
	<div class="footerghsvs<?php echo $moduleclass_sfx ?>" aria-label="Copyright">
		<?php echo $lineone; ?>
	</div>
<?php echo LayoutHelper::render('ghsvs.moduleColDiv.end'); ?>