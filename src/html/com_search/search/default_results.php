<?php
defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

?>
<dl class="search-results<?php echo $this->pageclass_sfx; ?>">
<?php foreach ($this->results as $result) : ?>
	<dt class="result-title">
		<?php echo $this->pagination->limitstart + $result->count . '. '; ?>
		<?php if ($result->href) : ?>
			<a href="<?php echo JRoute::_($result->href); ?>"<?php if ($result->browsernav == 1) : ?> target="_blank"<?php endif; ?>>
				<?php // $result->title should not be escaped in this case, as it may ?>
				<?php // contain span HTML tags wrapping the searched terms, if present ?>
				<?php // in the title. ?>
				<?php echo $result->title; ?>
			</a>
		<?php else : ?>
			<?php // see above comment: do not escape $result->title ?>
			<?php echo $result->title; ?>
		<?php endif; ?>
	</dt>
	<?php if ($result->section) : ?>
		<dd class="result-category">
			<span class="small<?php echo $this->pageclass_sfx; ?>">
				(<?php echo $this->escape($result->section); ?>)
			</span>
		</dd>
	<?php endif; ?>
	<dd class="result-text">
		<?php echo $result->text; ?>
	</dd>
	<?php if ($this->params->get('show_date')) : ?>
		<dd class="result-created<?php echo $this->pageclass_sfx; ?>">
			<?php echo JText::sprintf('JGLOBAL_CREATED_DATE_ON', $result->created); ?>
		</dd>
	<?php endif; ?>
<?php endforeach; ?>
</dl>
	<div class="paginationToClone">
		<?php

		#echo ' 4654sd48sa7d98sD81s8d71dsa <pre>' . print_r($this->pagination, true) . '</pre>';exit;
		$this->params->set('show_pagination', 1);
		echo LayoutHelper::render(
			'ghsvs.pagination_dropdown',
			[
				'pagination' => $this->pagination,
				'params' => $this->params,
				'options' => [
					// 'cloneIt' => false,
					// 'align' => 'dropdown-menu-end',
				'anchor' => '#ABOVEBUTTONGRUPPE',
					],
			]
		); ?>
	</div><!--/paginationToClone-->
