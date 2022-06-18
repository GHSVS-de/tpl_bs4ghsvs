<?php
defined('_JEXEC') or die;

$module = $displayData['module'];
$params = $displayData['params'];
$attribs = $displayData['attribs'];

if ($module->content)
{
	echo '<div class="divOnly ' . $module->module . ' ID' . $module->id
		. ' ' . $module->position . '">' . $module->content . '</div>';
}
