<?php
/*
Für Joomla 3 gedacht. Joomla 4 weiß ich noch nicht, ob da auch 'right', 'left',
'none' die Joomlaeinstellungen sein werden.

Ist kein JLayout. Via require einzubinden. z.B. siehe JLayout full_image_venobox.php.

require(__DIR__ . '/imgClassTranslator.php');
$figureClass = $images->get('float_fulltext', 'ghsvs_img-right');

if (!empty($imgClassTranslator[$figureClass]))
{
	$figureClass = $imgClassTranslator[$figureClass];
}

Wenn das Plugin bs3ghsvs und articleImages.xml geladen wird, ist eine Eingabe
des floats nicht möglich im Beitrag.

Man steuert über die Globalen Inhalts-Optionen.

Benötigt dann natürlich auch entprechednes SCSS für meine Klassen unten.
*/

$imgClassTranslator = [
    'right' => 'ghsvs_img-default',
    'left' => 'ghsvs_img-default',
    'none' => 'ghsvs_img-default',
];
