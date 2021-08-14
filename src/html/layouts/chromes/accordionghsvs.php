<?php
\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$module = $displayData['module'];
$params = $displayData['params'];
$attribs = $displayData['attribs'];

$moduleTag      = $params->get('module_tag', 'div');
$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
$bootstrapClass  = $params->get('bootstrap_class', 'span');
$moduleClass    = $bootstrapSize != 0 ? ' ' . $bootstrapClass
	. $bootstrapSize : '';

// Temporarily store header class in variable
$headerClass    = $params->get('header_class');
$headerClass    = !empty($headerClass) ? ' class="'
	. htmlspecialchars($headerClass) . '"' : '';

$selector = $dataParent = 'modChrome_accordionghsvs'.$module->id;
$href = $selector.'-0';

if (!empty ($module->content)) : ?>
	<<?php echo $moduleTag; ?> class="moduletable<?php
		echo htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass; ?>">

	<?php
echo HTMLHelper::_(
	'bootstrap.startAccordion',
	$selector,
	array(
		// Damit mehrere geöffnet werden können auf FALSE!
		'parent' => false
	)
);
echo HTMLHelper::_(
'bootstrap.addSlide',
	$selector,
	$title = $module->title,
	$href,
	$class = 'modChrome_accordionghsvs',
	$headerTag,
	$alt = ''
);
echo $module->content;
echo HTMLHelper::_('bootstrap.endSlide');
echo HTMLHelper::_('bootstrap.endAccordion');
	?>
</<?php echo $moduleTag; ?>>

<?php endif;
