<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

$this->isRobot = Factory::getApplication()->client->robot;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

######## KANN DANN RAUS START
// Kann dann raus. Habe halt blogghsvs kopiert
// also bleiben wir im Blog
$this->alternateView = false;
$hideToggler = true;
$div4toggler = '';
######## KANN DANN RAUS ENDE

$allEmpty = (empty($this->lead_items)
 && empty($this->link_items)
 && empty($this->intro_items));
?>
<div class="blog<?php echo $this->pageclass_sfx; ?>">
 <?php echo HTMLHelper::_('bs3ghsvs.layout', 'ghsvs.category_header', $this); ?>
 <?php $output = ''; ?>
 <?php
	if (!$this->isRobot && !$this->alternateView && $this->params->get('show_dropdown_sprungmarken', 1))
	{
  $output .= HTMLHelper::_('bs3ghsvs.layout',
		 'ghsvs.scroll-to-article-modal',
		 array(
			 'items' => array_merge($this->lead_items, $this->intro_items)
		 )
		);
	}
	?>
	<?php
		if (!$this->alternateView && $this->pagination->get('pages.total') > 1)
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
			echo '<div class="buttonGruppeGhsvs">' .$output. '</div>';
		}
 ?>
	<?php if (!$this->alternateView && $allEmpty
	           && $this->params->get('show_no_articles', 1)): ?>
			<p class="alert alert-info"><?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>
	
<?php if (!$this->alternateView){ //Blog START ?>
	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
		<div class="items-leading clearfix">
			<?php foreach ($this->lead_items as &$item) : ?>
				<div id="blogitem-anker-<?php echo $item->id;?>" class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
					<?php
					$this->item = & $item;
					echo $this->loadTemplate('item');
					?>
				</div>
				<?php $leadingcount++; ?>
			<?php endforeach; ?>
		</div><!-- end items-leading -->
	<?php endif; ?>

	<?php
	// Blog
	if (!empty($this->intro_items)) : ?>
<div class="">
	<div id="timeline" class="salvattoreColumns clearfix" data-columns>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
			<div id="blogitem-anker-<?php echo $item->id;?>" class="salvattoreItems">
				<?php
				$this->item = &$item;
				echo $this->loadTemplate('item');
				?>
			</div><!--/salvattoreItems-->

		<?php endforeach; ?>
	</div><!--/timeline-->
</div>
	<?php 
	endif; ?>

<?php } //Blog ENDE ?>

<?php
	if ($this->alternateView) : ?>
  <?php echo $this->loadTemplate('footableghsvs'); ?>
<?php endif; ?>

<?php if (!$this->alternateView){ //Blog START ?>

	<?php if (!empty($this->link_items)) : ?>
		<div class="items-more">
			<?php echo $this->loadTemplate('links'); ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($this->children[$this->category->id]) && $this->maxLevel != 0) : ?>
		<div class="cat-children">
			<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h3> <?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
			<?php endif; ?>
			<?php echo $this->loadTemplate('children'); ?> </div>
	<?php endif; ?>

 <?php if (!empty($this->items)) : ?>
	 <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
	  <div class="paginationToClone">
    <?php   echo HTMLHelper::_(
    'bs3ghsvs.layout',
    'ghsvs.pagination_dropdown',
    array('pagination' => $this->pagination)
    );?>
		 </div>
	 <?php endif; ?>
 <?php endif; ?>
<?php } //Blog ENDE ?>
<?php 
$file = HTMLHelper::_('bs3ghsvs.addLessCss',
 'salvattore.less',
 array(
	'force' => false,
 )
);
?>
<!-- Include the plug-in -->
<script src="media/plg_system_bs3ghsvs/js/salvattore/salvattore.min.js"></script>
<?php
HTMLHelper::_('bs3ghsvs.animsition',
 array('div.salvattoreItems'),
	array(
	 'inDuration' => 2000,
		'inClasses' => array('rotate-in-lg', 'zoom-in-lg', "flip-in-x", "flip-in-y"),
	)
);
?>



</div><!--/blog<?php echo $this->pageclass_sfx; ?>-->
<?php
$this->document->addScriptDeclaration(
'(function($)
{
$(document).ready(function()
	{
		location.hash = "content";
	}) //ready
})(jQuery);'
);
