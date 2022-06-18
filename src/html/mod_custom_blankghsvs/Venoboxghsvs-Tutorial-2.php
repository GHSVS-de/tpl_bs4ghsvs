<?php
/*
Fügt Venobox-Konfiguration in Beitrag "Integration von Venobox via JHtml/HTMLHelper in Joomla" ein.
*/
defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_(
	'plgvenoboxghsvs.venobox',
	[
		'titleBackground' => '#f00',
		'titleColor' => '#fff',
		'closeColor' => '#d2d2d2',
		'share' => ['download'],
	]
);
?>
<p>
<a href="images/erweiterungen/plg_venoboxghsvs/Demobild_700x2000px.jpg" class="venobox"
 data-title="Hallo, ich bin der data-title des Bildes. Ich werde angezeigt, weil ich diesmal nicht wegkonfiguriert wurde."
 title="Hallo, ich bin der title des Bildes.">
  Öffne ein PopUp via CSS-Klasse 'venobox' mit Beschriftung aus 'data-title', einem Downloadbutton unten und enervierend roter Farbe mit weißer Beschreibung und einem grauen Schließen</a>
</p>
