<?php
/**
 * Call via
 	echo LayoutHelper::render('ghsvs.moduleColDiv.start',
 		array(
			'module' => $module,
			'params' => $params,
			'attribs' => 'role="navigation" aria-label="example"',
			'prependClass' => 'mod_something blubberClass',
		));
*/
defined('_JEXEC') or die;

/**
 * $module mandatory
 * $params mandatory
 * $prependClass
 * $attribs : String der in den Div-Tag eingesetzt wird, bspw role="navigation"
*/
extract($displayData);

if (empty($attribs))
{
	$attribs = '';
}
else
{
	$attribs = ' ' . trim($attribs);
}

if (empty($prependClass))
{
	$prependClass = '';
}

$collectClasses = trim(implode(
	' ',
	[
		$prependClass,
		$params->get('colClass', ''),
		$params->get('freeColClasses', ''),
	]
));
?>
<div id="<?php echo $module->module . $module->id; ?>" class="<?php echo $collectClasses; ?>"<?php echo $attribs; ?>>

