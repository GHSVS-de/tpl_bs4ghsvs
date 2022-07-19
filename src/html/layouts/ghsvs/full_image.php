<?php
/* full_image ohne Kokolores wie venobox oder readmore */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/*
$displayData:
item mandatory
options:
 - classes (DIV around figure)
*/

$item = $displayData['item'];
$images = Bs3ghsvsItem::getItemImagesghsvs($item);

if ($image = $images->get('image_fulltext'))
{
	echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->' . PHP_EOL;

	$options = new Registry(isset(
		$displayData['options']) ? $displayData['options'] : []
	);

	$figureClasses = ['autoLimited item-image image_fulltext'];

	// Siehe Beschreibung in der Datei.
	require(__DIR__ . '/imgClassTranslator.php');
	$figureClass = $images->get('float_fulltext', 'ghsvs_img-right');

	if (!empty($imgClassTranslator[$figureClass]))
	{
		$figureClass = $imgClassTranslator[$figureClass];
	}

	$figureClasses[] = $figureClass;
	$mediaQueries = [];
	$classes = $options->get('classes', '');
	$alt = $images->get('image_fulltext_alt', '');
	$caption = $images->get('image_fulltext_caption', '');
	$alt = htmlspecialchars(($alt ? $alt : $caption), ENT_QUOTES, 'UTF-8');
	$caption = htmlspecialchars($caption, ENT_QUOTES, 'UTF-8');
	$picture = ['<picture>'];

	// From plg_system_bs3ghsvs. If resizer active.
	// Returns empty array if nothing.
	$imgs = $images->get('fulltext_imagesghsvs');

	if (!empty($imgs[0]) && is_array($imgs[0]))
	{
		$mediaQueries = [

			// figure hat dann max 332px
			'(max-width: 410px)' => '_s',

			// figure hat dann max 402px.
			'(max-width: 480px)' => '_m',

			// Hier hört xs auf.
			'(max-width: 575.98px)' => '_l',

			// Hier hört sm auf.
			'(max-width: 767.98px)' => '_x',

			// float-end beginnt bei 768px.
			'(max-width: 890px)' => '_s',

			'(max-width: 1030px)' => '_m',

			// lg-max endet.
			'(max-width: 1199.98px)' => '_l',

			//xl beginnt: Position right kommt dazu.
			'(max-width: 1300px)' => '_s',
			'(max-width: 1440.98px)' => '_m',
			'(min-width: 1441px)' => '_l',

			// Largest <source> without mediaQuery. Also for fallback <img> src, width and height calculation.
			// Value only if you want to force one. Otherwise _x or fallback _u is used.
			'srcSetKey' => '',
		];
	}

	// Use $imgs not $imgs[0] because of ['order'] index.
	// And because other $imgs collections can contain more than just 1 image.
	$sources   = Bs3ghsvsItem::getSources($imgs, $mediaQueries, $image);
	$sources   = $sources[0];
	$picture[] = $sources['sources'];
	$picture[] = '<img loading="lazy"'
		. ' src="' . $sources['assets']['img'] . '"'
		. ' alt="' . $alt . '"'
		. ' width="' . $sources['assets']['width'] . '"'
		. ' height="' . $sources['assets']['height'] . '"'
		. ' class="h-auto"'
		. '>';
	$picture[] = '</picture>';
	$picture = implode('', $picture);
	$figureClasses = implode(' ', $figureClasses);
?>
<div class="<?php echo $classes; ?>">
	<figure class="<?php echo $figureClasses; ?>">
		<?php echo $picture; ?>
		<?php if ($caption)
		{ ?>
		<figcaption><?php echo $caption; ?></figcaption>
		<?php
		} ?>
	</figure>
</div>
<?php
} //if $images->get('image_fulltext') ?>
