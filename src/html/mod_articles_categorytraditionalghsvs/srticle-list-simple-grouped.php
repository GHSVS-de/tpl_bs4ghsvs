<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
use GHSVS\Plugin\System\PagebreakSliderGhsvs\Helper\PagebreakSliderGhsvsHelper;

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

	/*
Auch möglich:
Factory::getApplication()->bootPlugin('pagebreaksliderghsvs', 'system')
	->helper->buildSliders(
		$html,
		$module->id,
['headingTagGhsvs' => 'h2',
'activeToSession' => 0,
'parent' => true,
'toggleContainer' => 'div',
]
	); */
	PagebreakSliderGhsvsHelper::buildSlidersStatic(
		$html,
		$module->id,
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
