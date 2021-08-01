<?php
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->' . PHP_EOL;

if (
	$params->get('robotsHide', 1) === 1
	&& Factory::getApplication()->client->robot
){
	return '';
}

/* To calculate a unique id for both participating modules (button and modal) we need a
identical base in both modules. */
// Set already otherwise? E.g. in layout buttonAndModal.php.
if (!empty($btnModalConnector))
{
	$id = $btnModalConnector;
}
// Paranoia.
else
{
	$id = TocGhsvsHelper::getId($params);
}

$moduleSubHeader = $params->get('moduleSubHeader');
$buttonTitle = $module->showtitle ? $module->title
	: ($moduleSubHeader ?: 'TPL_BUTTON_FALLBACK');
$buttonClass = $moduleclass_sfx ? ' ' . $moduleclass_sfx : '';
?><button type="button" class="btn btn-primary<?php echo $buttonClass; ?> HIDEIFNOTHINGFOUND<?php echo $id; ?>"
	data-bs-toggle="modal"
	data-bs-target="#<?php echo $id; ?>">
	<?php echo Text::_($buttonTitle); ?>
</button>
