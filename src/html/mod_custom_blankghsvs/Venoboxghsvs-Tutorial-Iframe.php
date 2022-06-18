<?php
/*
Fügt Venobox-Konfiguration in Beitrag "Integration von Venobox via JHtml/HTMLHelper in Joomla" ein.
 */
defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;

\Joomla\CMS\HTML\HTMLHelper::_(
	'plgvenoboxghsvs.venobox',
	[
		'selector' => '.popup-iframe',
		'framewidth' => '400px',
		'frameheight' => '300px',
		'titleattr' => 'title',
		'arrowsColor' => '#fa0',
		'infinigall' => true,
	]
);
?>
<p>Zwei verlinkte IFrames. Beide Links verwenden <code>.popup-iframe</code>
als Klasse, weil so in der Konfiguration definiert. Beide haben Attribut <code>data-gall="myIframeGallery"</code>. So werden sie als
Galerie verknüpft (geht nat. auch bei Bildern).  Der zweite Link wird durch ein
<code>d-none</code> versteckt (Bootstrap-Klasse). <code>infingall</code> in der Konfiguration sorgt
dafür, dass die angezeigten Iframes im Kreis geblättert werden können.
</p>
<p>
	<a href="https://www.ghsvs.de/credits-und-danke#content"
	data-vbtype="iframe"
	data-gall="myIframeGallery"
	class="popup-iframe"
	title="Ich bin der erste Iframe. Mit den Pfeilen rechts und links kannst du blättern.">
	Öffne einen Iframe in PopUp und verknüpfe
	ihn mit Blätterfunktion mit einem weiteren
	Iframe-Popup
	</a>
</p>
<p class="d-none">
	<a href="https://www.ghsvs.de/programmierer-schnipsel#content"
	data-vbtype="iframe"
	data-gall="myIframeGallery"
	class="popup-iframe"
	title="Ich bin der zweite Iframe in der Galerie.">
	Ich bin ein versteckter Link, aber im PopUp sieht man mich.
	</a>
</p>
