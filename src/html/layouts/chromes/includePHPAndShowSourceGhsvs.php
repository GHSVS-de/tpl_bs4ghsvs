<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use GHSVS\Plugin\System\PagebreakSliderGhsvs\Helper\PagebreakSliderGhsvsHelper;

$module = $displayData['module'];
$params = $displayData['params'];
$attribs = $displayData['attribs'];

$includeFile = JPATH_BASE . '/media/php-includes_ghsvs/' . $module->position
	. '.php';

if (!is_file($includeFile))
{
	return;
}

if ($spoilerOn = $params->get('spoiler', 1))
{
	$options = [
		'activeToSession' => 0,
	];
}

if ((bool) $module->showtitle)
{
	$headerTag = htmlspecialchars($params->get('header_tag', 'h3'));
	$headerClass = $params->get('header_class');
	$headerClass = !empty($headerClass) ? ' class="'
		. htmlspecialchars($headerClass) . '"' : '';
	echo '<' . $headerTag . $headerClass . '>' . $module->title
		. '</' . $headerTag . '>';
}

ob_start();
require_once $includeFile;
$text_1 = ob_get_clean();

$includeFile_ = basename($includeFile);

$text_2 = '<pre class="language-php line-numbers modChrome_includePHPAndSourceGhsvs"><code>'
	. htmlentities(file_get_contents($includeFile), ENT_QUOTES, 'UTF-8')
	. '</code></pre>';

HTMLHelper::_('content.prepare', $text_2, '', 'com_content.article');

if ($spoilerOn)
{
	$text = '<p>{pagebreakghsvs-slider title="'
		. Text::sprintf('PLG_SYSTEM_BS3GHSVS_SHOW_HIDE_OUTPUT_OF_FILE', $includeFile_) . '" title2=""}</p>'
		. $text_1
		. '';

	$text .= '{pagebreakghsvs-slider title="'
		. Text::sprintf('GHSVS_MODULES_SPOILER_BTN_TEXT', $includeFile_)
		. '" title2=""}' . $text_2;

	PagebreakSliderGhsvsHelper::buildSlidersStatic($text, $module->id . '-sp1', $options);
}
else
{
	$text = $text_1 . $text_2;
}

echo $text;
