<?php
/*
- Siehe templates/DEINTEMPLATE/images/favicons
- Die Bilder wurden generiert mit https://www.favicon-generator.org.
- Die Pfade in `browserconfig.xml` müssen händisch angepasst werden.
- Ebenso manifest.json
*/
\defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

$pathToFavicons = Uri::root(true) . '/templates/bs4ghsvs/images/favicons';
?>

	<!--Favicons by override ghsvs/favicons.php -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $pathToFavicons; ?>/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $pathToFavicons; ?>/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $pathToFavicons; ?>/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $pathToFavicons; ?>/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $pathToFavicons; ?>/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $pathToFavicons; ?>/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $pathToFavicons; ?>/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $pathToFavicons; ?>/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $pathToFavicons; ?>/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo $pathToFavicons; ?>/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $pathToFavicons; ?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $pathToFavicons; ?>/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $pathToFavicons; ?>/favicon-16x16.png">
	<meta name="msapplication-config" content="<?php echo $pathToFavicons; ?>/browserconfig.xml">
	<link rel="manifest" href="<?php echo $pathToFavicons; ?>/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo $pathToFavicons; ?>/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!--/Favicons-->
