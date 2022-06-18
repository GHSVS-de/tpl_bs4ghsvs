<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

$items = $displayData['items'];

if (isset($displayData['options']))
{
	$options = new Registry($displayData['options']);
}
else
{
	$options = new Registry();
}
$class = [];

$class[] = 'sprungmarken makeBackdrop';

if (!empty($displayData['bootstrapsize']))
{
	$class[] = 'col-sm-' . $displayData['bootstrapsize'];
}

if ($class = implode(' ', $class))
{
	$class = ' class ="' . $class . '"';
}

$dropdownHeader = '<li class="dropdown-header">Hüpfen auf dieser Seite</li>';
$close = '<li class="dropdown-header"><span class="close glyphicon glyphicon-remove"></span></li>';
$cnt = 0;
?>
<?php if (!empty($items))
{
	$time = 'blogitem-ankers-dropdown-' . str_replace('.', '', uniqid('', true)); ?>
<div<?php echo $class; ?>>
 <div class="dropdown">
  <button class="btn btn-primary" type="button" id="<?php echo $time; ?>" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <?php echo Text::_('PLG_SYSTEM_BS3GHSVS_SCROLL_TO'); ?>
   {svg{bi/caret-down-fill}}
  </button>
  <ul class="dropdown-menu controlMaxWidth " aria-labelledby="<?php echo $time; ?>">
		 <?php echo $dropdownHeader; ?>
			<?php echo $close; ?>
<?php
foreach ($items as $item)
	{
		$cnt++;
		// Vorsicht mit $item->title. $items wird referenziert übergeben, also
		// auch die Blogitem-Überschrift geändert!
		$title = str_replace(['"', "'", '-', '«', '»'], ' ', $item->title); ?>
   <li><a href="#blogitem-anker-<?php echo $item->id; ?>"><?php echo $title; ?></a></li>
<?php
 if (!($cnt % 10))
 {
 	#echo $close;
 }
	} ?>
<?php #echo $close; ?>
  </ul>
</div>
</div>
<?php
} ?>
