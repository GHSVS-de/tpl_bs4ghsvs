<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');
?>
<div class="categories-list<?php echo $this->pageclass_sfx; ?>">
	<?php
	// Description and things.
	echo LayoutHelper::render('ghsvs.categories_default', $this); ?>

	<div class="div4hyphens TOC_GHSVS">
		<?php if ($this->maxLevelcat != 0
			&& count($this->items[$this->parent->id]) > 0)
		{ ?>
		<div class="items-category row row-cols-1 row-cols-lg-2  row-cols-xl-3 g-2">

		<?php
			foreach ($this->items[$this->parent->id] as $id => $item)
			{
				$catLink = Route::_(ContentHelperRoute::getCategoryRoute(
					$item->id,
					$item->language
				)); ?>
			<div class="col">
			<div class="card h-100 border-danger">
				<div class="card-body">
					<div class="card-title">
						<div class="page-header">
							<h2><?php echo $item->title; ?></h2>
						</div><!--/page-header-->
					</div><!--/card-title-->
					<?php
					if ($this->params->get('show_subcat_desc_cat', 1) == 1
						&& $item->description !== ''
					){ ?>
					<div class="card-text lead">
					<?php echo HTMLHelper::_(
						'content.prepare',
						$item->description,
						'',
						'com_content.categories'
					); ?>
					</div><!--/card-text lead-->
					<?php
					} ?>
					<div class="card-text">
					<?php
					echo LayoutHelper::render(
							'ghsvs.readmore',
							[
							'item' => $item,
							'params' => $this->params,
							'link' => $catLink,
						]
						); ?>
					</div>
				</div><!--/card-body-->
				<?php if ($this->params->get('show_cat_num_articles_cat') == 1)
				{ ?>
				<div class="card-footer">
					<div class="div4article-info_categoryItem">
						<h3 class="visually-hidden">Kategorie-Infos</h3>
						<dl class="article-info">
							<dd class="num-items">
							<?php echo Text::_('COM_CONTENT_NUM_ITEMS'); ?>:
							<?php echo $item->numitems; ?>
							</dd>
						</dl>
					</div>
				</div><!--/card-footer-->
				<?php
				} ?>
			</div><!--/card-->
			</div><!--/col-->
			<?php
			} //foreach ?>
		</div><!--/items-category-->
		<?php
		} ?>
	</div><!--/div4hyphens-->
</div><!--/categories-list-->
