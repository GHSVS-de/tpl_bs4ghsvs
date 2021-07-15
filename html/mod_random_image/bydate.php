<?php
/*
Siehe
www.ghsvs.de/programmierer-schnipsel/joomla/162-override-modul-zufallsbild-taeglich-neues-bild
*/
defined('_JEXEC') or die;

$comparisonFormat = 'Ymd'; // Jahr, Monat, Tag
$now = JFactory::getDate(time(), 'UTC');
$now = $now->format($comparisonFormat); // z.B. 20160106
foreach ($images as $img)
{
 if (strpos($img->name, $now) === 0)
 {
  $image = $img;
  break;
 }
}
?>
<div class="random-image<?php echo $moduleclass_sfx; ?>">
<?php if ($link) : ?>
<a href="<?php echo $link; ?>">
<?php endif; ?>
 <?php echo JHtml::_('image', $image->folder . '/' . $image->name, $image->name); ?>
<?php if ($link) : ?>
</a>
<?php endif; ?>
</div>