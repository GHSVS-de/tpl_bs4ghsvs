<?php
/**
2017-11-16 GHSVS
- mod_custom_blankghsvs
- Custom module without editor by GHSVS
 */
defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

?>
<?php
echo LayoutHelper::render('ghsvs.moduleColDiv.start', [
	'module' => $module,
	'params' => $params,
	'prependClass' => '',
]);
?>
<?php echo $module->content; ?>
<?php echo LayoutHelper::render('ghsvs.moduleColDiv.end'); ?>