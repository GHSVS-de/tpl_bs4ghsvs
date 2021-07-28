<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

/*
 * Module chrome for rendering the module in a submenu
 */
function modChrome_no($module, &$params, &$attribs)
{
	if ($module->content)
	{
		echo $module->content;
	}
}

function modChrome_divOnly($module, &$params, &$attribs)
{
	if ($module->content)
	{
		echo
		'<div class="divOnly ' . $module->module . ' ID' . $module->id
			. ' ' . $module->position . '">'
			. $module->content . '</div>';
	}
}

/*
2015-08-30
Z.B. für /media/php-includes_ghsvs/icomoonclasses.php
Siehe /media/php-includes_ghsvs/ReadMe.txt
*/
function modChrome_includePHPGhsvs_bs($module, &$params, &$attribs)
{
	$includeFile = JPATH_BASE . '/media/php-includes_ghsvs/' . $module->position . '.php';

	if (!is_file($includeFile))
	{
		return;
	}

	if ((bool) $module->showtitle){
		$headerTag = htmlspecialchars($params->get('header_tag', 'h3'));
		$headerClass = $params->get('header_class');
		$headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass) . '"' : '';
		echo '<' . $headerTag . $headerClass .'>' . $module->title .'</' . $headerTag . '>';
	}
	require_once($includeFile);
}

/*
2015-10-27
Ein einzelnes Accordionelement. Überschrift zum Klicken.
Modulinhalt klappt auf.
*/
function modChrome_accordionghsvs($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
	$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
	// GHSVS
	$bootstrapClass  = $params->get('bootstrap_class', 'span');
	$moduleClass    = $bootstrapSize != 0 ? ' ' . $bootstrapClass . $bootstrapSize : '';

	// Temporarily store header class in variable
	$headerClass    = $params->get('header_class');
	$headerClass    = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass) . '"' : '';

 $selector = $dataParent = 'modChrome_accordionghsvs'.$module->id;
 $href = $selector.'-0';

	if (!empty ($module->content)) : ?>
		<<?php echo $moduleTag; ?> class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass; ?>">

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
}

/*
2015-08-30
Z.B. für /media/php-includes_ghsvs/icomoonclasses.php
Siehe /media/php-includes_ghsvs/ReadMe.txt
Dieser Stil zeigt zusätzlich den PHP-Quellcode der ausgeführten Datei an.
*/
function modChrome_includePHPAndShowSourceGhsvs($module, &$params, &$attribs)
{
	echo LayoutHelper::render('chromes.includePHPAndShowSourceGhsvs',
	['module' => $module,
	'params' => $params,
	'attribs' => $attribs]
	);
}
