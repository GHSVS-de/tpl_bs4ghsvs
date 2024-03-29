<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;

// @since 2023-11
use GHSVS\Plugin\System\Bs3Ghsvs\Helper\Bs3GhsvsArticleHelper as Bs3ghsvsArticle;

$jinput = Factory::getApplication()->input;
$views = ['article', 'category'];

// Wenn empty($list) kommen wir hier gar nicht an. Muss also nicht prüfen.
if (!in_array($jinput->get('view'), $views))
{
	return '';
}

// To calculate a unique id for both participating modules (button and modal) we need a
// identical base in both modules.
$id = Bs3ghsvsArticle::buildUniqueIdFromJinput('articlesInCategoryModal');
HTMLHelper::_('bs3ghsvs.addsprungmarke', '#' . $id . ' .list-group');

$cats = array_unique(ArrayHelper::getColumn($list, 'category_title'));
$catsTitle = count($cats) > 1 ? 'PLG_SYSTEM_BS3GHSVS_CATEGORIES' : 'JCATEGORY';
$catsTitle = Text::_($catsTitle) . ': ' . implode(', ', $cats);
?>
<div id="<?php echo $id; ?>"
	class="modal fade"
	tabindex="-1"
	role="dialog"
	aria-labelledby="<?php echo $id; ?>Title"
	aria-hidden="true"
>
	<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content  bg-modal">
			<div class="modal-header">
				<p class="modal-title h3" id="<?php echo $id; ?>Title">
					<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_OPEN_ARTICLE'); ?>
					<span class="small text-muted">
						<?php echo $catsTitle; ?>
					</span>
				</p>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_CLOSE'); ?>">
          {svg{bi/x-circle-fill}class="text-danger"}
				</button>
			</div><!--/modal-header-->
			<div class="modal-body container-fluid">
				<div class="row">
					<div class="col-12">
						<ul class="list-group">
						<?php
						foreach ($list as $item)
						{
							$ariaCurrent = '';
							$liclass = 'list-group-item';

							if ($item->active)
							{
								$liclass .= ' active disabled';
								$ariaCurrent = ' aria-current="page"';
							} ?>
							 <li class="<?php echo $liclass; ?>">
							 	<a href="<?php echo $item->link; ?>"<?php echo $ariaCurrent; ?>>
									<?php echo $item->title; ?>
								</a>
							</li>
						<?php
						} ?>
						</ul>
					</div>
				</div>
			</div><!--/modal-body-->
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
					<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_CLOSE'); ?>
				</button>
			</div><!--/modal-footer-->
		</div><!--/modal-content-->
	</div><!--/modal-dialog-->
</div><!--/#<?php echo $id; ?>-->
