<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

// @since 2023-11
use GHSVS\Plugin\System\Bs3Ghsvs\Helper\Bs3GhsvsArticleHelper as Bs3ghsvsArticle;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/' . basename(__FILE__) . '-->' . PHP_EOL;

$app = Factory::getApplication();

if (
	$params->get('robotsHide', 0) === 1
	&& $app->client->robot
) {
	return '';
}

/* To calculate a unique id for both participating modules (button and modal)
we need a identical base id in both modules. */
$modalId = Bs3ghsvsArticle::buildUniqueIdFromJinput(
	$params->get('connectorKey', '')
);

if ($app->input->get('view') === 'article')
{
	$activeCatId = $app->input->get('catid');
}
else
{
	$activeCatId = $app->input->get('id');
}

$activeCatId = (int) $activeCatId;

$class = 'list-group-item list-group-item-action';
?>
<div id="<?php echo $modalId; ?>"
	class="modal fade"
	tabindex="-1"
	role="dialog"
	aria-labelledby="<?php echo $modalId; ?>Title"
	aria-hidden="true"
>
	<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content  bg-modal">
			<div class="modal-header">
				<p class="modal-title h3" id="<?php echo $modalId; ?>Title">
					<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_OPEN_CATEGORY'); ?>
				</p>
				<?php echo LayoutHelper::render('ghsvs.closeButtonTop'); ?>
			</div><!--/modal-header-->
			<div class="modal-body container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="list-group">
						<?php
						foreach ($list as $item)
						{
							$item->link = Route::_(ContentHelperRoute::getCategoryRoute($item->id));
							$item->active = (int) $item->id === $activeCatId;
							$aClass = $class . ($item->active ? ' active' : ''); ?>
							<a href="<?php echo $item->link; ?>" class="<?php echo $aClass; ?>">
								<?php echo $item->title; ?>
							<?php if ($item->description = trim(strip_tags($item->description)))
							{ ?>
							<span class="small fst-italic">
								(<?php echo $item->description; ?>)
							</span>
							<?php
							} ?></a>
						<?php
						} ?>
						</div>
					</div>
				</div>
			</div><!--/modal-body-->
			<div class="modal-footer">
				<?php echo LayoutHelper::render('ghsvs.closeButton'); ?>
			</div><!--/modal-footer-->
		</div><!--/modal-content-->
	</div><!--/modal-dialog-->
</div><!--/#<?php echo $modalId; ?>-->
