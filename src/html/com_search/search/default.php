<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

?>
<?php
#### SEITENÜBERSCHRIFT (Menü)
if ($this->params->get('show_page_heading'))
{
	echo HTMLHelper::_(
		'bs3ghsvs.layout',
		'ghsvs.page_heading',
		[
		'params' => $this->params,
		'bs3ghsvs.rendermodules-position' => '',
	]
	);
}
$this->params->set('show_page_heading', 0);
#### ENDE - SEITENÜBERSCHRIFT (Menü)
?>
<div class="item-page item-pageSearch col-12">
	<div class="page-header">
		<h2>Suche in Joomla-Datenbank</h2>
	</div>
	<div class="search<?php echo $this->pageclass_sfx; ?>">
		<?php echo $this->loadTemplate('form'); ?>
		<div class="search-resultsAndError">
			<?php if ($this->error == null && count($this->results) > 0) : ?>
				<?php echo $this->loadTemplate('results'); ?>
			<?php else : ?>
				<?php echo $this->loadTemplate('error'); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
