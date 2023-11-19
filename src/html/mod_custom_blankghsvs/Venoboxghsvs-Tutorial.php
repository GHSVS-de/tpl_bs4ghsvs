<?php
/*
Fügt Venobox-Konfiguration in Beitrag "Integration von Venobox via JHtml/HTMLHelper in Joomla" ein.
*/
defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_(
	'plgvenoboxghsvs.venobox',
	[
	'selector' => '.thickbox',
	'titleattr' => 'title',
	'share' => true,
	]
);?>
<p>
 <a href="images/erweiterungen/plg_venoboxghsvs/Demobild_700x2000px.jpg" class="thickbox"
 data-title="Ich tue gar nichts, weil ich wegkonfiguriert wurde."
 title="Hallo, ich bin der title des Bild-Links und werden im PopUp angezeigt.">
  Öffne ein PopUp via eigener CSS-Klasse 'thickbox' mit Beschriftung aus 'title' und nicht 'data-title' und 2 Teilen-Knöpfen
 </a>
</p>
<p>
 <a href="images/erweiterungen/plg_venoboxghsvs/Demobild_700x2000px.jpg" class="venobox"
 data-title="Hallo, ich bin der data-title des Bild-Links."
 title="Ich bin der title des Bild-Links und hab nix zu tun.">
  Und ich bin ein PopUp, das weiterhin die Klasse 'venobox' verwendet und die Grundkonfiguration des Plugins.
 </a>
</p>
