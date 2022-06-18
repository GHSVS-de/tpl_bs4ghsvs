<?php
defined('_JEXEC') or die;

$module = $displayData['module'];
$params = $displayData['params'];
$attribs = $displayData['attribs'];

if ($module->content)
{
	echo $module->content;
}
