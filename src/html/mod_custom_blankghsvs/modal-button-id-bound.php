<?php
/*
Für Buttons, die über einen connector-key (eindeutige id) mit Modals verbunden
werden können.
Wenn man visually-hidden oder aria-xy-Zeugs in der Buttonbeschriftung haben möchte,
kann man das z.B. über Sprachstring machen.
Für die Button-Class wird das "Modulklassensuffix" "missbraucht". Es reicht z.B.
"btn-danger", um das default "btn-warning" zu überschreiben. Nicht ganz schön,
aber aus B\C-Gründen so gemacht.
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/' . basename(__FILE__) . '-->' . PHP_EOL;

if (
	$params->get('robotsHide', 0) === 1
	&& Factory::getApplication()->client->robot
) {
	return '';
}

/* To calculate a unique id for both participating modules (button and modal)
we need a identical base id in both modules. */
JLoader::register(
	'Bs3ghsvsArticle',
	JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ArticleHelper.php'
);
$modalId = Bs3ghsvsArticle::buildUniqueIdFromJinput(
	$params->get('connectorKey', '')
);

$moduleSubHeader = $params->get('moduleSubHeader');
$buttonTitle = $module->showtitle ? $module->title
	: ($moduleSubHeader ?: 'TPL_BUTTON_FALLBACK');
$buttonClass = $moduleclass_sfx ? ' ' . $moduleclass_sfx : '';
?>
<button type="button" class="btn btn-warning<?php echo $buttonClass; ?>"
	data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>"
	aria-haspopup="true" id="button_<?php echo $modalId; ?>">
	<?php echo Text::_($buttonTitle); ?>
</button>
