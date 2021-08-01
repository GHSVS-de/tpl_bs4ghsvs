<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
?>
<?php
if ($params->get('robotsHide', 0) === 1 && $params->get('isRobot') === 1)
{
	return '';
}
?>
<?php
/* echo LayoutHelper::render('ghsvs.moduleColDiv.start', array(
	'module' => $module,
	'params' => $params,
	'prependClass' => '',
)); */
?>
<?php if ($grouped)
{ ?>
<div class="category-module article-list-simple mt-section-space-custom">
	<!-- <div class="page-header">
		<h2><?php echo $module->title; ?></h2>
	</div> -->
	<?php
	ob_start();
	require __DIR__ . '/srticle_list_simple_grouped_html.php';
	$html = ob_get_clean();
	$title = htmlspecialchars($module->title);
	$html = '{pagebreakghsvs-slider title="' . $title . '"}' . $html;
	JLoader::register('Bs3ghsvsPagebreak',
		JPATH_PLUGINS . '/system/bs3ghsvs/Helper/PagebreakHelper.php');
	Bs3ghsvsPagebreak::buildSliders($html, $module->id,
		['headingTagGhsvs' => 'h2',
		'activeToSession' => 0,
		'parent' => true,
		'toggleContainer' => 'div',
		]
	);
	echo $html;
	?>
</div>
<?php
} ?>
<?php #echo LayoutHelper::render('ghsvs.moduleColDiv.end'); ?>
