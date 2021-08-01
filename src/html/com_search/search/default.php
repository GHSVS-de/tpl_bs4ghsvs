<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
?>
<?php
#### SEITENÜBERSCHRIFT (Menü)
if ($this->params->get('show_page_heading'))
{
 echo HTMLHelper::_('bs3ghsvs.layout',
  'ghsvs.page_heading',
  array(
		'params' => $this->params,
		'bs3ghsvs.rendermodules-position' => ''
	)
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
	<div class="page-header">
		<h2>Alternativ: Google-Suche für Domain www.ghsvs.de</h2>
	</div>
<p class="block-warning">
- Bei Aktivierung und Nutzung der Suche wird eine Verbindung zu Google aufgebaut und Google schreibt Cookies in Ihren Browser. Wenn Sie keine Vorbehalte gegen die "normale" Google-Suche haben, die das ebenfalls tut, klicken Sie den Aktivieren-Knopf, um das Suchfeld einzublenden. <a href="datenschutz#datenschutz-google-cse">Siehe auch Datenschutzerklärung zu Google-CSE</a><br />
- Google-Suche-Ergebnisse zeigen (meist oben) auch Werbung an, die Google einfügt. Diese sind mit einem Label "Anzeige" versehen.</p>
<div class="google-suche">
<?php echo HTMLHelper::_('script', 'loadCse.js',
	array('relative' => true, 'version' =>'auto')
); ?>

<gcse:search></gcse:search>
<button onclick="loadCse();this.classList.add('d-none');return false;" class="btn btn-primary">
Google-Suche aktivieren
</button>

<style>
div.google-suche{
	position:relative;
	min-height:40px;
}
div.gsc-control-cse{
	padding: 1em 0;
}
div.gsc-control-cse div{
	min-height:34px;
}
td.gsc-search-button input{
	height:34px;
	width:34px;
	padding:6px;
	display: inline-block;
}
</style>
</div>
</div>
