<?php
/**
page_heading.php
2015-12-22
H1-Seitenüberschrift (Menü).
Sowohl für Kategorien als auch Einzelbeiträge.
2017-08 Um Module per bs3ghsvs.rendermodules unterhalb des page_headers setzen zu können.
*/
?>
<?php
defined('JPATH_BASE') or die;

$params  = $displayData['params'];

// Die Seitenüberschrift im Menü.
if ($page_heading = ($params->get('show_page_heading') ? $params->get('page_heading') : ''))
{
	$page_heading = '<span class="page_heading_main">' . $page_heading . '</span>';
}

// Für Kategorie-Menüeinträge kann man Joomla-eigenes "page_subheading" angeben.
// Zusätzlich gibt es ein "page_subheading_ghsvs", da nicht alle Menü-Typen "page_subheading" haben
// "page_subheading" overruled 'page_subheading_ghsvs'
$page_subheading = $params->get('page_subheading') ?: $params->get('page_subheading_ghsvs');
$page_subheading = $page_subheading
	? '<small class="page_subheading">('
		. $page_subheading
		. ')</small>' : '';

if ($page_heading || $page_subheading)
{
	// CSS-Klassen-Suffix. Eigenes Menüeintrags-Feld (bs3ghsvs Felder).
	$class = 'page-header' . $params->get('pageheader_suffix_ghsvs', '');

	// Eine Modulposition kann zum Rendern angegeben werden.
	$position = !empty($displayData['bs3ghsvs.rendermodules-position'])
		? $displayData['bs3ghsvs.rendermodules-position'] :'';

	// Eine CSS-Klasse für den page-header-DIV, die Modulposition enthält, falls angegben.
	$class .= ($position ? ' rendermodules-position ' . $position : ''); ?>
<div class="<?php echo $class ?> div4hyphens">
	<h1 class="page_heading fst-italic text-muted">
		<?php echo $page_heading; ?>
		<?php echo $page_subheading; ?>
	</h1>

<?php
 if ($position)
 {
 	echo JHtml::_('bs3ghsvs.rendermodules', $position);
 } ?>

</div><!--/page-header h1-->
<?php
} ?>
