<?php
/**
GHSVS 2015-01-06
*/

defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// $this->params sind die im Menüeintrag eingestellten Parameter.
// Im Unterschied zu.
$this->item->params = new JRegistry($this->item->params);

// Menüparameter ($this->params) überschreiben Kategorieparameter
$temp = clone($this->params);
$this->item->params->merge($temp);
#echo '4654sd48sa7d98sD81s8d71dsa '.print_r($this->params,true);exit;

$this->item->readmore = ($this->item->numitems ? true : false);


/* Für /layouts/ */
// ToDo: Unsicher, ob das Model das evtl. schon abgefangen hat. Darf ich hier einfach access-view auf 1 setzen???
$this->item->params->set('access-view', 1);

#$this->item->params->set('show_titles', 1);
#$this->item->params->set('show_readmore', 1);
$this->item->params->set('show_intro', $this->params->get('show_subcat_desc_cat'));

$this->item->linkGhsvs = JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->id));

$this->item->images = new stdClass;
if ($this->params->get('show_description_image') && $this->item->params->get('image'))
{
 $this->item->images->image_intro = $this->item->params->get('image');
 $this->item->images->float_intro = $this->params->get('float_intro_categories', 'left');
 $this->item->images->image_intro_caption = '';
 $this->item->images->image_intro_alt = '';
}
$this->item->images = json_encode($this->item->images);
?>

<?php
// Sonst funktionieren die /layouts/.../joomla.content.info_block NICHT
$lang = JFactory::getLanguage();
$lang->load('com_content');

$this->item->alternative_readmore = ''; 
$info = $this->item->params->get('info_block_position', 0);
?>
<?php
echo JHtml::_('bs3ghsvs.layout', 
	'ghsvs.page_header_n_icons',
	array(
		'item' => $this->item, 
		'print' => false,
	)
);
?>
<?php
if ($this->params->get('show_introimage_blogview_ghsvs', 1))
{
 echo JHtml::_('bs3ghsvs.layout', 
 'ghsvs.category_image_readmore',
	array(
	 'item' => $this->item,
		'link' => $this->item->linkGhsvs
	)
	); 
}
?>
<?php if ($this->params->get('show_cat_num_articles_cat')) :?>
	<p><span class="badge badge-info tip hasTooltip" title="<?php echo JHtml::tooltipText('COM_CONTENT_NUM_ITEMS'); ?>">
		<?php echo $this->item->numitems; ?>
	</span></p>
<?php endif; ?>

<?php if (!$this->item->params->get('show_intro')) : ?>
	<?php #echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>
<?php /* GHSVS 2015-01-01: ToDo: introtext_limit irgendwo konfigurierbar im Backend einrichten. Vielleicht im Plugin  */ ?>

<?php
if ($this->item->params->get('show_intro')) :
	$truncated = JHtml::_(
		'string.truncateComplex',
		$this->item->description,
		$this->item->params->get('introtext_limit', 500)
	);
	// Bisschen plump:
	if (empty($this->item->readmore) && mb_substr($truncated, -3) == '...')
	{
		$this->item->readmore = true;
	}
	// Und jetzt statt Introtext:;
	echo '
<div class="category-desc">
'.JHtml::_('content.prepare', $truncated, '', 'com_content.categories').'
</div><!--/category-desc-->
';
endif; ?>
<?php if ($this->item->params->get('show_readmore') && $this->item->readmore) :?>
	<?php echo JHtml::_('bs3ghsvs.layout', 'joomla.content.readmore', array('item' => $this->item, 'params' => $this->item->params, 'link' => $this->item->linkGhsvs)); ?>
<?php endif; ?>
<?php if ($this->item->params->get('show_tags'))
{
	echo JHtml::_('bs3ghsvs.layout',
		'ghsvs.tags_n_tagscat',
		$this->item);
} ?>
