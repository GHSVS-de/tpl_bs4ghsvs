<?php
defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
/*
$js array
$css array
$nonce string
*/
extract($displayData);

/* Wenn $nonce, geht das JLayout davon aus, dass der String schon fertig ist,
also so übergeben wurde: 'nonce="blubber blabber"'. */
if (!isset($nonce))
{
	$nonce = '';
}
else
{
	$nonce = ' ' . trim($nonce);
}

if (!empty($css))
{
	foreach ($css as $path)
	{
		if (!is_file(JPATH_SITE . '/' . $path))
		{
			continue;
		}

		$mediaVersion = md5_file(JPATH_SITE . '/' . $path);
		echo '<link' . $nonce . ' href="' . $path . '?' . $mediaVersion . '" rel="stylesheet" />';
	}
}

if (!empty($js))
{
	foreach ($js as $path)
	{
		if (!is_file(JPATH_SITE . '/' . $path))
		{
			continue;
		}

		$mediaVersion = md5_file(JPATH_SITE . '/' . $path);
		echo '<script' . $nonce . ' src="' . Uri::root(true) . '/' . $path . '?' . $mediaVersion . '"></script>';
	}
}
