<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Router\Route;

$jinput = Factory::getApplication()->input;
$view = $jinput->get('view');

$views = array('article', 'category');

// Wenn empty($list) kommen wir hier gar nicht an. Muss also nicht prüfen.
if (!in_array($view, $views))
{
	return '';
}

if ($view === 'article')
{
	$activeCatId = $jinput->get('catid');
}
else
{
	$activeCatId = $jinput->get('id');
}

$activeCatId = (int) $activeCatId;

// To calculate a unique id for both participating modules (button and modal) we need a
// identical base in both modules.
JLoader::register('Bs3ghsvsArticle', JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ArticleHelper.php');
$id = Bs3ghsvsArticle::buildUniqueIdFromJinput('articlesCategoriesModal');
?>
<div id="<?php echo $id; ?>"
	class="modal fade"
	tabindex="-1"
	role="dialog"
	aria-labelledby="<?php echo $id; ?>Title"
	aria-hidden="true"
>
	<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content bg-modal">
			<div class="modal-header">
				<p class="modal-title h3" id="<?php echo $id; ?>Title">
					<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_OPEN_CATEGORY'); ?>
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
							$item->link = Route::_(ContentHelperRoute::getCategoryRoute($item->id));
							$item->active = (int) $item->id === $activeCatId;
							$liclass = 'list-group-item' . ($item->active ? ' active' : '');
							?>
							<li class="<?php echo $liclass; ?>">
							 	<a href="<?php echo $item->link; ?>"><?php echo $item->title; ?>
								<?php if ($item->description = trim(strip_tags($item->description)))
								{ ?>
								<span class="small"><?php echo $item->description; ?></span>
								<?php
								} ?></a>
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
