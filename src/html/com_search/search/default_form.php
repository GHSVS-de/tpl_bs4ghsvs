<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

$upper_limit = Factory::getLanguage()->getUpperLimitSearchWord();
?>
<form class="form" id="searchForm" action="<?php echo Route::_('index.php?option=com_search');?>" method="post">

<?php if ($this->params->get('search_phrases', 1)) : ?>
	<div class="form-group phrases">
		<legend class="visually-hidden"><?php echo Text::_('COM_SEARCH_FOR');?></legend>
		<div class="phrases-box">
			<?php echo $this->lists['searchphrase']; ?>
		</div>
	</div>
	<div class="form-group phrases">
		<label for="ordering" class="ordering">
			<?php echo Text::_('COM_SEARCH_ORDERING'); ?>
		</label>
		<p class="block-info mt-1"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_SEARCH_ORDERING_HINT'); ?></p>
		<?php echo $this->lists['ordering'];?>
	</div>
<?php endif; ?>

	<div class="form-group">
		<div class="input-group">
			<label for="search-searchword" class="visually-hidden">
				<?php echo Text::_('COM_SEARCH_SEARCH_KEYWORD'); ?>
			</label>
			<input type="text" name="searchword"
				placeholder="<?php echo Text::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" id="search-searchword"
				value="<?php echo $this->escape($this->origkeyword); ?>" class="form-control" />
			<button name="Search" class="btn btn-danger" type="submit">
				<span class="visually-hidden"><?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?></span>
				{svg{bi/search}}
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
			<span class="visually-hidden"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_SEARCH_YOU_ARE_HERE'); ?></span>
			<?php echo $counter; ?>
		</p>
		<?php
		} ?>
 </div>

	<div class="form-group limitBox">
		<label for="limit">
			<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_DISPLAY_NUM_PER_PAGE'); ?>
		</label>
		<div class="input-group">
			<?php
			$limitBox = $this->pagination->getLimitBox();
			$limitBox = str_replace([' class="', ' onchange='], [' class="form-control ', ' onchangeKilled='], $limitBox );
			echo $limitBox; ?>
			<button name="LimitButton" class="btn btn-danger" type="submit">
				<span class="visually-hidden"><?php echo Text::_('TPL_BS4GHSVS_APPLY_LIMIT'); ?></span>
				{svg{bi/fast-forward-fill}}
			</button>
		</div><!-- /input-group -->
	</div><!--/form-group-->
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
