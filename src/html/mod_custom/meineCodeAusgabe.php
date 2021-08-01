<?php
/*
Begleitend zu Tutorial
"/programmierer-schnipsel/joomla/315-joomla-modul-override-fuer-einbinden-eigener-php-dateien"
*/
defined('_JEXEC') or die;

$aktuellerSeitenPfad = JUri::getInstance()->getPath();
?>
<p>
Der aktuelle Pfad ohne Domain und Query-String dieser Seite in der Adresszeile lautet:
<b><?php echo $aktuellerSeitenPfad; ?></b>.
</p>
