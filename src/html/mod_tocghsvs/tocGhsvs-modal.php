<?php
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

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

$document->addScriptDeclaration(
	<<<JS
document.addEventListener('DOMContentLoaded', function()
{
	window.tocGhsvsInit(Joomla.getOptions("tocGhsvs-settings$module->id"));
	var myModalEl$module->id = new bootstrap.Modal("#$id");
	document.getElementById("$id").querySelectorAll("#$id a[href*=\"#\"]")
		.forEach((link) =>
		{
			/*
			JQuery would simply use .not("[href=\"#\"]").not("[href=\"#0\"]")
			but vanilla is too stupid for CSS :not()-selectors.
			*/
			let parts = link.href.split('#');

			if (! parts[1] || parts[1] === '0')
			{
				return;
			}

			link.addEventListener('click', (e) => {
				myModalEl$module->id.hide();
			});
	});
});
JS
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
