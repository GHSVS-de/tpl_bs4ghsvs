<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

$this->isRobot = Factory::getApplication()->client->robot;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

// False bleibt im Blog. Das soll Fallback sein, wenn Button nicht gezeigt etc.
$this->alternateView = false;

$div4toggler = '';

// Anzeigen des Liste-Blog-Buttons erlaubt?
$viewlevels = Factory::getUser()->getAuthorisedViewLevels();

// JALL = 0. Für folgendes array_intersect muss Wert ebenfalls hinterlegt werden.
$viewlevels[] = 0;
// JNONE = -9999.

// Siehe bspw. templates\protostarbs3ghsvs\html\com_content\category\blogghsvs.xml
$hideToggler = $this->isRobot || !count(array_intersect(
	$this->params->get('accesslevel_for_toggler', [-9999], 'ARRAY'),
	$viewlevels
));

if (!$hideToggler)
{
	// Hier verboten Klasse 'hide'
	// DENKE an Sprachplatzhalter, also hier Großschrift:
	// DEFAULT IMMER ALS ERSTEN!!!! Wird an JS weitergegeben!
	$btnClasses = [
		'SHOWLIST',
		'SHOWBLOG',
	];

	// Vorsicht mit nur 'TOGGLER'. Derzeit noch was in template.js, was Konflikt machen könnte.
	$TOGGLER = 'BLOGLISTTOGGLER';

	$plugin = 'SessionBs3Ghsvs';

	HTMLHelper::_('bs3ghsvs.bloglisttoggle');

	$node = 'plg_system_bs3ghsvs';
	$key = 'bloglisttoggler';
	$defaultClass = 'SHOWLIST';

	$session = Factory::getSession();
	$sessionData = (array) $session->get($node);

	if (!empty($sessionData[$key]))
	{
		$currentClass = $sessionData[$key];
	}
	// Kein Sessioneintrag, also u.a. in Session schreiben.
	// Die Session muss initialisiert sein, sonst ist mir das JS zu kompliziert!
	else
	{
		// Der View zu dem geswitcht werden soll mit Button bei nächstem Klick.
		$currentClass = $sessionData[$key] = $defaultClass;
		$session->set($node, $sessionData);
	}

	// Der View zu dem geswitcht werden soll mit Button bei nächstem Klick.
	// Und, wenn das nicht der default ist, sind wir im default.
	if ($currentClass != $defaultClass)
	{
		// Also wollen wir aktuell die Liste sehen
		$this->alternateView = true;
		$this->document->setMetadata('robots', 'noindex,nofollow');
	}

	// Muss für Javascriptteil gesichert sein!!! Sonst ewiger Reload!
	if (in_array($currentClass, $btnClasses))
	{
		foreach ($btnClasses as $cl)
		{
			// Sprachplatzhalter für javascript, zB: SINFOTPL_ARTICLEINFOTOGGLER_SHOWME
			Text::script('SINFOTPL_' . $TOGGLER . '_' . $cl);
		}

		Text::script('PLG_SYSTEM_BS3GHSVS_LOADING');

		$div4toggler = '
			<div id="' . $TOGGLER . 'DIV" class="hidden"></div>
			<script type="text/javascript">
			(function($)
			{
				$(document).ready(function()
				{
					$.fn.bloglisttoggle("' . $currentClass . '");
				});
			})(jQuery);
			</script>';
	}
}

$allEmpty = (
	empty($this->lead_items)
	&& empty($this->link_items)
	&& empty($this->intro_items)
);
?>
<div class="blog<?php echo $this->pageclass_sfx; ?><?php echo($this->alternateView ? ' footabled' : ''); ?>">

 <?php echo LayoutHelper::render('ghsvs.category_header', $this); ?>
 <?php $output = ''; ?>

<?php
if (
	!$this->isRobot && !$this->alternateView
	&& $this->params->get('show_dropdown_sprungmarken', 0)
) {
	$output .= HTMLHelper::_(
		'bs3ghsvs.layout',
		'ghsvs.scroll-to-article-modal',
		[
	'items' => array_merge($this->lead_items, $this->intro_items),
	]
	);
}
	?>
	<?php
		if (!$this->alternateView && $this->pagination->pagesTotal > 1)
		{
			$output .= '<div id="PAGINATION-CLONE"></div>';
		}
	?>
	<?php
	 if (!$this->isRobot)
	 {
	 	$output .= HTMLHelper::_('bs3ghsvs.rendermodules', 'buttonGruppeGhsvs-bs');
	 }
	?>
	<?php
		$output .= $div4toggler;
	?>
	<?php
		if (trim($output))
		{
			echo '<div class="buttonGruppeGhsvs">' . $output . '</div>';
		}
 ?>
	<?php if (!$this->alternateView && $allEmpty
	           && $this->params->get('show_no_articles', 1)): ?>
			<p class="alert alert-info"><?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>

<?php if (!$this->alternateView){?>
<div class="div4hyphens pt-3 TOC_GHSVS">
<?php } ?>

<?php if (!$this->alternateView)
	           { //Blog START
	           	if (!empty($this->lead_items))
	           	{
	           		$leadingcount = 0;
	           		// Marker for image sources in layout intro_image_readmore.php.
	           		$this->whichItem = 'leadItem'; ?>
	<div class="items-leading">
		<?php foreach ($this->lead_items as &$item)
		{ ?>
		<div id="blogitem-anker-<?php echo $item->id; ?>"
			class="leadingItem-<?php echo $leadingcount; ?>">
		<?php
		$this->item = &$item;
		echo $this->loadTemplate('item');
		$leadingcount++;
		?>
		</div>
		<?php
		} //foreach ?>
	</div><!--/items-leading-->
	<?php
	           	} ?>

	<?php
	if (!empty($this->intro_items))
	{
		$introcount = 0;
		// Marker for image sources in layout intro_image_readmore.php.
		$this->whichItem = 'introItem'; ?>

	<div class="items-intro row row-cols-1 row-cols-lg-2  row-cols-xl-3 g-2">

		<?php foreach ($this->intro_items as $key => &$item)
		{
			$this->item = &$item;
			echo $this->loadTemplate('item');
			$introcount++;
		} // foreach $this->intro_items ?>

	</div><!--/items-intro row-->
	<?php
	} // if (!empty($this->intro_items) ?>

<?php
	           } //Blog ENDE ?>

<?php
	if ($this->alternateView) : ?>
  <?php echo $this->loadTemplate('footableghsvs'); ?>
<?php endif; ?>

<?php if (!$this->alternateView)
{ //Blog START ?>

	<?php if (!empty($this->link_items)) : ?>
		<div class="items-link">
			<?php echo $this->loadTemplate('links'); ?>
		</div>
	<?php endif; ?>

<?php if (!$this->alternateView){?>
</div><!--div4hyphens-->
<?php } ?>

	<?php if (!empty($this->children[$this->category->id]) && $this->maxLevel != 0) : ?>
		<div class="cat-children">
			<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h3><?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?></h3>
			<?php endif; ?>
			<?php echo $this->loadTemplate('children'); ?>
		</div><!--/cat-children-->
	<?php endif; ?>

	<?php if (!empty($this->items))
	{ ?>
	<div class="paginationToClone">
		<?php echo LayoutHelper::render(
		'ghsvs.pagination_dropdown',
		[
				'pagination' => $this->pagination,
				'params' => $this->params,
				'options' => [
					// 'cloneIt' => false,
					// 'align' => 'dropdown-menu-end'
					],
			]
	); ?>
	</div><!--/paginationToClone-->
	<?php
	} ?>

<?php
} //Blog ENDE ?>

</div><!--/blog<?php echo $this->pageclass_sfx; ?>-->
