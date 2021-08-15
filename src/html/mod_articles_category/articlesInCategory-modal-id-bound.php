<?php
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

if (
	!$list
	|| ($params->get('robotsHide', 0) === 1
		&& Factory::getApplication()->client->robot)
){
	return;
}

// To calculate a unique id for both participating modules (button and modal) we need a
// identical base in both modules.
JLoader::register('Bs3ghsvsArticle',
	JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ArticleHelper.php'
);
$modalId = Bs3ghsvsArticle::buildUniqueIdFromJinput(
	$params->get('connectorKey', '')
);

$moduleSubHeader = $params->get('moduleSubHeader');
$modalHeadline = $module->showtitle ? $module->title
	: ($moduleSubHeader ?: 'TPL_MODAL_FALLBACK');

$cats = array_unique(ArrayHelper::getColumn($list, 'category_title'));
$catsTitle = count($cats) > 1 ? 'PLG_SYSTEM_BS3GHSVS_CATEGORIES' : 'JCATEGORY';
$catsTitle = Text::_($catsTitle) . ' "' . implode('", "', $cats) . '"';
?>
<div id="<?php echo $modalId; ?>"
	class="modal fade"
	tabindex="-1"
	role="dialog"
	aria-labelledby="<?php echo $modalId; ?>Title"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content bg-modal">
			<div class="modal-header">
				<p class="modal-title h3" id="<?php echo $modalId; ?>Title">
					<?php echo Text::_($modalHeadline); ?>
					<small class="text-muted">
						(<?php echo $catsTitle; ?>)
					</small>
				</p>
				<?php echo LayoutHelper::render('ghsvs.closeButtonTop'); ?>
			</div><!--/modal-header-->
			<div class="modal-body">
				<div class="list-group">
					<?php foreach ($list as $item)
					{
						$aAttributes = [
							'class' => 'list-group-item list-group-item-action',
							'href' => $item->link,
						];

						if ($item->active)
						{
							$aAttributes['aria-current'] = 'page';
							$aAttributes['class'] .= ' active disabled';
						}
						?>
						<a <?php echo ArrayHelper::toString($aAttributes); ?>>
							<?php echo $item->title; ?>
							<?php
							// Kategorie anzeigen im Modul aktiviert.
							if ($item->displayCategoryTitle)
							{ ?>
							<span class="font-italic">
								(Kategorie: <?php echo $item->category_title; ?>)
							</span>
							<?php
							} ?>
						</a>
					<?php
					} ?>
				</div><!--/list-group-->
			</div><!--/modal-body-->
			<div class="modal-footer">
				<?php echo LayoutHelper::render('ghsvs.closeButton'); ?>
			</div><!--/modal-footer-->
		</div><!--/modal-content-->
	</div><!--/modal-dialog-->
</div><!--/#<?php echo $modalId; ?>-->
