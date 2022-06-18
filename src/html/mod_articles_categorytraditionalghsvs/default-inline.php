<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

?>
<?php
echo LayoutHelper::render('ghsvs.moduleColDiv.start', [
	'module' => $module,
	'params' => $params,
	'prependClass' => '',
]);
?>
<?php if ($grouped)
{ ?>
<div class="category-module default-inline">
	<div class="page-header">
	<h2><?php echo $module->title; ?></h2>
	</div>
	<?php
	ob_start();
	require __DIR__ . '/default_inline_html.php';
	$html = ob_get_clean();
	echo HTMLHelper::_(
		'bs3ghsvs.spoiler',
		$html,
		[
			// 'buttontext' => $module->title,
			'in' => $params->get('spoiler_in', 0),
			// 'spoilerclass' => '',
			// 'buttonclass' => '',
			'role' => 'navigation',
		]
	);
	?>
</div>
<?php
} ?>
<?php echo LayoutHelper::render('ghsvs.moduleColDiv.end'); ?>
