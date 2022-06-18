<?php
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/' . basename(__FILE__) . '-->' . PHP_EOL;

/* To calculate a unique id for both participating modules (button and modal) we need a
identical base in both modules. */
// Set already otherwise? E.g. in layout buttonAndModal.php.
if (!empty($btnModalConnector))
{
	$id = $btnModalConnector;
}
// Paranoia.
else
{
	$id = TocGhsvsHelper::getId($params);
}

$moduleSubHeader = $params->get('moduleSubHeader');
$modalHeadline = $module->showtitle ? $module->title
	: ($moduleSubHeader ?: 'MOD_TOCGSHVS_MODAL_TITLE');

$scriptOptions = TocGhsvsHelper::getScriptOptions(
	$params,
	$id,
	$module->id
);

### Custom overrides START
/* Here you can override the $scriptOptions array because not all parameters
are already implemented in module settings. */

### Custom overrides END

$document = Factory::getDocument();

$document->addScriptOptions(
	'tocGhsvs-settings' . $module->id,
	[
			'settings' => [
				'TocGhsvs' => $scriptOptions,
			],
		]
);

// Why?
//HTMLHelper::_('behavior.core');
HTMLHelper::_(
	'script',
	'mod_tocghsvs/tocGhsvs.min.js',
	['version' => 'auto', 'relative' => true],
	['defer' => true]
);

$document->addScriptDeclaration("document.addEventListener('DOMContentLoaded', function() {
	window.tocGhsvsInit(Joomla.getOptions('tocGhsvs-settings" . $module->id . "'));
});");

######### Close modal after action.
/* $document->addScriptDeclaration(
'jQuery(function(){jQuery("#' . $id . ' a[href*=\"#\"]").not("[href=\"#\"]").not("[href=\"#0\"]").on("click", function(event){jQuery("#' . $id . '").modal("hide");jQuery("#' . $id . ' .dropdown").removeClass("open");});});'
); */
// BS5
$document->addScriptDeclaration(
	'jQuery(function(){
 var myModalEl' . $module->id . ' = new bootstrap.Modal("#' . $id . '");
 jQuery("#' . $id . ' a[href*=\"#\"]").not("[href=\"#\"]").not("[href=\"#0\"]").on("click",
  function(event){myModalEl' . $module->id . '.hide();}
 );});'
);
?>
<div class="HIDEIFNOTHINGFOUND<?php echo $id; ?>">
	<div class="modal fade" id="<?php echo $id; ?>" tabindex="-1" role="dialog"
		aria-labelledby="<?php echo $id; ?>Title" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
			<div class="modal-content bg-light">
				<div class="modal-header">
					<p class="modal-title h3" id="<?php echo $id; ?>Title">
						<?php echo Text::_($modalHeadline); ?>
					</p>
					<?php echo LayoutHelper::render('ghsvs.closeButtonTop'); ?>
				</div><!--/modal-header-->
				<div class="modal-body">
					<div id="tocGhsvsOutput-<?php echo $id; ?>">

					</div>
				</div><!--/modal-body-->
				<div class="modal-footer">
					<?php echo LayoutHelper::render('ghsvs.closeButton'); ?>
				</div><!--/modal-footer-->
			</div><!--/modal-content-->
		</div><!--/modal-dialog-->
	</div>
</div>
