<?php
/*
Das id #PAGINATION_TO_CLONE wird per JS nach #PAGINATION_CLONE kopiert.
Für zweiteres ein Modul in Position 'buttonGruppe' (oder anderstwo) mit HTML
<div id="PAGINATION_CLONE" class="d-inline"></div>
Das wird ersetzt durch #PAGINATION_TO_CLONE.

*/

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

/* Wegen protected bullshit seitens Joomla, muss ich all den Scheiß einzeln
übergeben. */
$pagination = $displayData['pagination'];
$params = $displayData['params'];
#echo ' 4654sd48sa7d98sD81s8d71dsa <pre>' . print_r($pagination->getPaginationPages(), true) . '</pre>';exit;
if (
	(int) $params->get('show_pagination') < 1
	|| (int) $pagination->pagesTotal < 2
	|| ! ($PaginationPages = $pagination->getPaginationPages())
){
	return;
}

$options = new Registry (isset($displayData['options']) ? $displayData['options']
	: []);
$alignClass = $options->get('align', 'dropdown-menu-end');
$items = [];
$total = count($PaginationPages['pages']);
$anchor = $options->get('anchor', '');

foreach ($PaginationPages as $key => $page)
{
	// Funktioniert sowieso nicht:
	if ($key === 'all')
	{
		continue;
	}

	if ($key !== 'pages' && $page['active'])
	{
		$page['key'] = $key;
		$page['class'] = ' class="dropdown-item"';
		$page['text'] = $page['data']->text;
		$items[] = $page;
	}
	elseif ($key === 'pages')
	{
		foreach ($page as $numbered)
		{
			if ($numbered['active'] || $numbered['data']->active)
			{
				$numbered['class'] = $numbered['data']->active ?
					' class="dropdown-item active disabled" aria-current="page" aria-disabled="true"'
					: ' class="dropdown-item"';
				$numbered['text'] = Text::sprintf('JLIB_HTML_PAGE_CURRENT_OF_TOTAL',
					$numbered['data']->text, $total);
				$items[] = $numbered;
			}
		}
	}
}
?>
<div id="PAGINATION_TO_CLONE"class="dropdown">
<button class="btn btn-primary" type="button"
	id="seitenPaginationButton" data-bs-toggle="dropdown" aria-expanded="false">
	<span class="visually-hidden">
		<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_CHANGE_OVERVIEW_PAGE'); ?>
	</span>
	<?php echo $displayData['pagination']->getPagesCounter(); ?>
	 {svg{bi/book}}
</button>
<ul class="dropdown-menu <?php echo $alignClass; ?>"
	aria-labelledby="seitenPaginationButton">
<?php foreach ($items as $item)
{
	$data = $item['data'];
	?>
	<li>
		<a href="<?php echo $data->link . $anchor; ?>"<?php echo $item['class']; ?>>
			<?php echo $item['text']; ?>
		</a>
	</li>
	<?php
} ?>
</ul>
<?php
if ($options->get('cloneIt', true) === true)
{
$js = ';jQuery(window).on("load", function(){'
	. 'jQuery.fn.paginationClone("#PAGINATION_TO_CLONE", "#PAGINATION_CLONE");'
	. '});';
Factory::getDocument()->addScriptDeclaration($js);
}
