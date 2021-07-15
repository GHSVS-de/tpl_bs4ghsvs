<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Layout\LayoutHelper;

if (
	$params->get('robotsHide', 0) === 1
	&& Factory::getApplication()->client->robot
){
	return '';
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

// Alle x Einträge ein Close-Button, da teils sehr viele.
$dismissButton = LayoutHelper::render('ghsvs.closeButtonTop');
$dismissEvery = 20;
?>
<div id="<?php echo $modalId; ?>"
	class="modal fade"
	tabindex="-1"
	role="dialog"
	aria-labelledby="<?php echo $modalId; ?>Title"
	aria-hidden="true"
>
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content bg-modal">
			<div class="modal-header">
				<p class="modal-title h3" id="<?php echo $modalId; ?>Title">
					<?php echo Text::_($modalHeadline); ?>
					<small class="text-muted">
						(<?php echo $catsTitle; ?>)
					</small>
				</p>
				<?php echo $dismissButton; ?>
			</div><!--/modal-header-->
			<div class="modal-body container-fluid">
				<div class="row">
					<div class="col-12">
						<ul class="list-group">
						<?php
						$countLi = 0;

						foreach ($list as $item)
						{
							$countLi++;

							if ($countLi % $dismissEvery === 0)
							{ ?>
							<li class="list-unstyled text-end">
								<?php echo $dismissButton; ?>
							</li>
							<?php }
							$ariaCurrent = '';
							$liclass = 'list-group-item';

							if ($item->active)
							{
								$liclass .= ' active disabled';
								$ariaCurrent = ' aria-current="page"';
							}
							?>
							 <li class="<?php echo $liclass; ?>">
							 	<a href="<?php echo $item->link; ?>"<?php echo $ariaCurrent; ?>>
									<?php echo $item->title; ?></a>
								<?php
								// Das signalisiert, dass Kategorie anzeigen im
								// Modul aktiviert ist.
								if ($item->displayCategoryTitle)
								{?>
								<span class="font-italic">
									(Kategorie: <?php echo $item->category_title; ?>)
								</span>
								<?php
								}?>

							</li>
						<?php
						} ?>
						</ul>
					</div>
				</div>
			</div><!--/modal-body-->
			<div class="modal-footer">
				<?php echo LayoutHelper::render('ghsvs.closeButton'); ?>
			</div><!--/modal-footer-->
		</div><!--/modal-content-->
	</div><!--/modal-dialog-->
</div><!--/#<?php echo $modalId; ?>-->
