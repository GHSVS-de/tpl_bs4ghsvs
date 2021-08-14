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
	echo LayoutHelper::render('chromes.no',
	['module' => $module,
	'params' => $params,
	'attribs' => $attribs]
	);
}

function modChrome_divOnly($module, &$params, &$attribs)
{
	echo LayoutHelper::render('chromes.divOnly',
	['module' => $module,
	'params' => $params,
	'attribs' => $attribs]
	);
}

/*
2015-08-30
Z.B. für /media/php-includes_ghsvs/icomoonclasses.php
Siehe /media/php-includes_ghsvs/ReadMe.txt
*/
function modChrome_includePHPGhsvs_bs($module, &$params, &$attribs)
{
	echo LayoutHelper::render('chromes.includePHPGhsvs_bs',
	['module' => $module,
	'params' => $params,
	'attribs' => $attribs]
	);
}

/*
2015-10-27
Ein einzelnes Accordionelement. Überschrift zum Klicken.
Modulinhalt klappt auf.
*/
function modChrome_accordionghsvs($module, &$params, &$attribs)
{
	echo LayoutHelper::render('chromes.accordionghsvs',
	['module' => $module,
	'params' => $params,
	'attribs' => $attribs]
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
	echo LayoutHelper::render('chromes.includePHPAndShowSourceGhsvs',
	['module' => $module,
	'params' => $params,
	'attribs' => $attribs]
	);
}
