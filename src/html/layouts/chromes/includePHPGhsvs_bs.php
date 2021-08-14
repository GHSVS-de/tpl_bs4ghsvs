<?php
\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$module = $displayData['module'];
$params = $displayData['params'];
$attribs = $displayData['attribs'];

$includeFile = JPATH_SITE . '/media/php-includes_ghsvs/' . $module->position . '.php';

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
