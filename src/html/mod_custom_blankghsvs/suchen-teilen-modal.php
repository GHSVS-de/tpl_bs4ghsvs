<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

// @since 2023-11
use GHSVS\Plugin\System\Bs3Ghsvs\Helper\Bs3GhsvsArticleHelper as Bs3ghsvsArticle;

//echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/' . basename(__FILE__) . '-->' . PHP_EOL;

if ($params->get('robotsHide', 1) === 1 && $params->get('isRobot') === 1)
{
	return;
}

/* To calculate a unique id for both participating modules (button and modal)
we need a identical base id in both modules. */
$modalId = Bs3ghsvsArticle::buildUniqueIdFromJinput(
	$params->get('connectorKey', '')
);
?>
<div id="<?php echo $modalId; ?>"
	class="modal fade"
	tabindex="-1"
	role="dialog"
	aria-labelledby="<?php echo $modalId; ?>Title"
	aria-hidden="true"
>
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content bg-light">
			<div class="modal-header">
				<h2 class="modal-title h3" id="<?php echo $modalId; ?>Title">
					<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_SEARCH_AND_SHARE'); ?>
				</h2>
				<?php echo LayoutHelper::render('ghsvs.closeButtonTop'); ?>
			</div><!--/modal-header-->
			<div class="modal-body">
				<h3 class="h4"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_SEARCH_ME'); ?></h3>
				<?php echo HTMLHelper::_(
	'content.prepare',
	'{loadposition suche-position-bs}',
	'',
	'com_content.article'
);
				?>
				<h3 class="h4"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_SHARE_ME'); ?></h3>
				<?php echo HTMLHelper::_(
					'content.prepare',
					'{shariff}',
					'',
					'com_content.article'
				);
				?>
				<h3 class="h4"><?php echo Text::_('Besuch mich'); ?></h3>
				<?php /* echo HTMLHelper::_(
					'content.prepare',
					'{shariff}',
					'',
					'com_content.article'
				); */
				?>
				<?php echo HTMLHelper::_(
	'content.prepare',
	'{loadposition besuch-mich}',
	'',
	'com_content.article'
);
				?>

			</div><!--/modal-body-->
			<div class="modal-footer">
				<?php echo LayoutHelper::render('ghsvs.closeButton'); ?>
			</div><!--/modal-footer-->
		</div><!--/modal-content-->
	</div><!--/modal-dialog-->
</div><!--/#TeilenSuchePanel-->
