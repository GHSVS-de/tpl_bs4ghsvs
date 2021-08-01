<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

$upper_limit = Factory::getLanguage()->getUpperLimitSearchWord();
?>
<form class="form" id="searchForm" action="<?php echo Route::_('index.php?option=com_search');?>" method="post">

<?php if ($this->params->get('search_phrases', 1)) : ?>
	<div class="form-group phrases">
		<legend class="sr-only"><?php echo Text::_('COM_SEARCH_FOR');?></legend>
		<div class="phrases-box">
			<?php echo $this->lists['searchphrase']; ?>
		</div>
	</div>
	<div class="form-group phrases">
		<label for="ordering" class="ordering">
			<?php echo Text::_('COM_SEARCH_ORDERING'); ?>
			<p class="block-info"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_SEARCH_ORDERING_HINT'); ?></p>
		</label>
		<?php echo $this->lists['ordering'];?>
	</div>
<?php endif; ?>

	<div class="form-group">
		<div class="input-group">
			<label for="search-searchword" class="sr-only">
				<?php echo Text::_('COM_SEARCH_SEARCH_KEYWORD'); ?>
			</label>
			<input type="text" name="searchword"
				placeholder="<?php echo Text::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" id="search-searchword"
				value="<?php echo $this->escape($this->origkeyword); ?>" class="form-control" />
			<button name="Search" class="btn btn-danger" onclick="this.form.submit()" type="submit">
				<span class="sr-only"><?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?></span>
				{svg{solid/search}}
			</button>
		</div><!-- /input-group -->
	</div><!--/form-group-->


	<div class="searchintro<?php echo $this->params->get('pageclass_sfx'); ?>">
		<?php if (!empty($this->searchword)):?>
		<h3 class="h5">
			<?php echo Text::plural('COM_SEARCH_SEARCH_KEYWORD_N_RESULTS', '<span class="badge badge-info">' . $this->total . '</span>');?>
		</h3>
		<?php endif;?>
	</div>


<?php if ($this->total > 0) : ?>
 <div class="form-group phrases">
		<?php
		if ($counter = $this->pagination->getPagesCounter())
		{ ?>
		<p class="counter my-3">
			<span class="sr-only"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_SEARCH_YOU_ARE_HERE'); ?></span>
			<?php echo $counter; ?>
		</p>
		<?php
		} ?>
		<label for="limit"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_DISPLAY_NUM_PER_PAGE'); ?></label>
	 <?php echo $this->pagination->getLimitBox(); ?>
 </div>
<?php endif; ?>

<?php if ($this->params->get('search_areas', 1)) : ?>
	<fieldset class="only">
		<legend><?php echo JText::_('COM_SEARCH_SEARCH_ONLY');?></legend>
		<?php foreach ($this->searchareas['search'] as $val => $txt) :
			$checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="checked"' : '';
		?>
		<label for="area-<?php echo $val;?>" class="checkbox">
			<input type="checkbox" name="areas[]" value="<?php echo $val;?>" id="area-<?php echo $val;?>" <?php echo $checked;?> >
			<?php echo Text::_($txt); ?>
		</label>
		<?php endforeach; ?>
	</fieldset>
<?php endif; ?>
<input type="hidden" name="task" value="search" />
</form>
