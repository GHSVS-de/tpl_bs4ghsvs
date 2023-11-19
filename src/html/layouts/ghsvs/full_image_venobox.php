<?php
// full_image venobox bs4
defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

// @since 2023-11
use GHSVS\Plugin\System\Bs3Ghsvs\Helper\Bs3GhsvsItemHelper as Bs3ghsvsItem;

// NEIN NEIN NEIN! Da Prüfung auf empty() fehlschlägt! Also runter
#echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->' . PHP_EOL;

$item = $displayData['item'];
$images = Bs3ghsvsItem::getItemImagesghsvs($item);

if ($image = $images->get('image_fulltext', ''))
{
	echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/' . basename(__FILE__) . '-->' . PHP_EOL;

	$options = new Registry(
		isset(
		$displayData['options']) ? $displayData['options'] : []
	);
	$venobox = '';
	$figureClasses = ['autoLimited item-image image_fulltext'];

	// Siehe Beschreibung in der Datei.
	require __DIR__ . '/imgClassTranslator.php';
	$figureClass = $images->get('float_intro', 'ghsvs_img-default');

	if (!empty($imgClassTranslator[$figureClass]))
	{
		$figureClass = $imgClassTranslator[$figureClass];
	}

	$figureClasses[] = $figureClass;
	$mediaQueries = [];
	$classes = $options->get('classes', '');
	$aTitle = 'GHSVS_HIGHER_RESOLUTION_1';

	// Zoom-Button.
	$aClass = ['btn btn-dark btn-sm stretched-link'];

	if (PluginHelper::isEnabled('system', 'venoboxghsvs'))
	{
		$venobox = 'venobox';
		HTMLHelper::_('plgvenoboxghsvs.venobox');
		$aTitle = 'GHSVS_HIGHER_RESOLUTION_0';
	}

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
		/* Derzeit folgende Größen im plg_system_bs3ghsvs
		x-large 850
		large 650
		medium 470
		small 360
		*/
		$mediaQueries = [
			'(max-width: 380px)' => '_s',
			'(max-width: 490px)' => '_m',
			'(max-width: 767.98px)' => '_l',
			'(max-width: 991.98px)' => '_s',
			'(max-width: 1199.98px)' => '_m',
			'(max-width: 2600px)' => '_l',

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
	$aClass[] = $venobox;
	$figureClasses = implode(' ', $figureClasses); ?>
<div class="<?php echo $classes; ?>">
	<figure class="<?php echo $figureClasses; ?>">
		<div class="position-relative">
			<?php echo $picture; ?>
			<div class="iconGhsvs text-end">
				<a href="<?php echo $image; ?>" data-title="<?php echo $caption; ?>"
					class="<?php echo implode(' ', $aClass); ?>">
					<span class="visually-hidden"><?php echo Text::_($aTitle); ?></span>
					{svg{bi/zoom-in}}
				</a>
			</div>
		</div>
		<?php if ($caption)
		{ ?>
		<figcaption><?php echo $caption; ?></figcaption>
		<?php
		} ?>
	</figure>
</div>
<?php
} // if image_fulltext ?>
