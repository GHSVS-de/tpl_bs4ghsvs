<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

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
function modChrome_includePHPAndShowSourceGhsvssssssssss($module, &$params, &$attribs)
{
	$includeFile = JPATH_BASE . '/media/php-includes_ghsvs/' . $module->position . '.php';

	if (!is_file($includeFile))
	{
		return;
	}

	$spoilerOn = $params->get('spoiler', 1);

	if ((bool) $module->showtitle)
	{
		$headerTag = htmlspecialchars($params->get('header_tag', 'h3'));
		$headerClass = $params->get('header_class');
		$headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass) . '"' : '';
		echo '<' . $headerTag . $headerClass .'>' . $module->title .'</' . $headerTag . '>';
	}

	ob_start();
	require_once($includeFile);
	$text = ob_get_clean();

	$includeFile_ = basename($includeFile);

	if ($spoilerOn)
	{
		echo HTMLHelper::_('bs3ghsvs.spoiler',
			$text,
			array(
				'buttontext' => Text::sprintf('PLG_SYSTEM_BS3GHSVS_SHOW_HIDE_OUTPUT_OF_FILE', $includeFile_),
				'in' => $params->get('spoiler_in', 0),
				// 'spoilerclass' => '',
				'buttonclass' => 'btn btn-catcolor',
				// 'role' => 'navigation',
			)
		);
	}
	else
	{
		echo $text;
	}

	$text = '<pre class="modChrome_includePHPAndSourceGhsvs"><code>'
		. htmlentities(file_get_contents($includeFile), ENT_QUOTES, 'UTF-8') . '</code></pre>';

	$text .= Text::_('GHSVS_MODULES_SCRIPT_HINT');

	echo HTMLHelper::_('bs3ghsvs.spoiler',
		$text,
		array(
			'buttontext' => Text::sprintf('GHSVS_MODULES_SPOILER_BTN_TEXT', $includeFile_),
			'in' => $params->get('spoiler_in', 0),
			// 'spoilerclass' => '',
			'buttonclass' => 'btn btn-catcolor',
			// 'role' => 'navigation',
		)
	);
}



/*
2015-08-30
Z.B. für /media/php-includes_ghsvs/icomoonclasses.php
Siehe /media/php-includes_ghsvs/ReadMe.txt
Dieser Stil zeigt zusätzlich den PHP-Quellcode der ausgeführten Datei an.
*/
function modChrome_includePHPAndShowSourceGhsvs($module, &$params, &$attribs)
{
	$includeFile = JPATH_BASE . '/media/php-includes_ghsvs/' . $module->position . '.php';

	if (!is_file($includeFile))
	{
		return;
	}

	if ($spoilerOn = $params->get('spoiler', 1))
	{
		// $spoiler_in = $params->get('spoiler_in', 0);
		JLoader::register('Bs3ghsvsPagebreak',
			JPATH_PLUGINS . '/system/bs3ghsvs/Helper/PagebreakHelper.php');
		$options = [
			'activeToSession' => 0
		];
	}

	if ((bool) $module->showtitle)
	{
		$headerTag = htmlspecialchars($params->get('header_tag', 'h3'));
		$headerClass = $params->get('header_class');
		$headerClass = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass) . '"' : '';
		echo '<' . $headerTag . $headerClass .'>' . $module->title .'</' . $headerTag . '>';
	}

	ob_start();
	require_once($includeFile);
	$text_1 = ob_get_clean();

	$includeFile_ = basename($includeFile);

	$text_2 = '<pre class="language-php line-numbers modChrome_includePHPAndSourceGhsvs"><code>'
		. htmlentities(file_get_contents($includeFile), ENT_QUOTES, 'UTF-8') . '</code></pre>';

	HTMLHelper::_('content.prepare', $text_2, '', 'com_content.article');

	if ($spoilerOn)
	{
		$text = '<p>{pagebreakghsvs-slider title="'
			. Text::sprintf('PLG_SYSTEM_BS3GHSVS_SHOW_HIDE_OUTPUT_OF_FILE', $includeFile_) . '" title2=""}</p>'
			. $text_1
			. '';

		$text .= '{pagebreakghsvs-slider title="'
			. Text::sprintf('GHSVS_MODULES_SPOILER_BTN_TEXT', $includeFile_) . '" title2=""}'
			. $text_2;

			Bs3ghsvsPagebreak::buildSliders($text, $module->id . '-sp1', $options);
	}
	else
	{
		$text = $text_1 . $text_2;
	}

	echo $text;
}
