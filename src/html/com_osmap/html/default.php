<?php
defined('_JEXEC') or die();

use Alledia\OSMap;
use Joomla\CMS\HTML\HTMLHelper;

// Check if we need to inject the CSS
if ($this->params->get('use_css', 1))
{
	HTMLHelper::stylesheet('media/com_osmap/css/sitemap_html.min.css');
}

// If debug is enabled, use text content type
if ($this->debug)
{
	OSMap\Factory::getApplication()->input->set('tmpl', 'component');
	HTMLHelper::stylesheet('media/com_osmap/css/sitemap_html_debug.min.css');
}

// Check if we have parameters from a menu, acknowledging we have a menu
if (!is_null($this->params->get('menu_text')))
{
	// We have a menu, so let's use its params to display the heading
	$pageHeading = $this->params->get('page_heading', $this->params->get('page_title'));
}
else
{
	// We don't have a menu, so lets use the sitemap name
	$pageHeading = $this->sitemap->name;
}
$this->params->set('page_heading', $pageHeading)
?>
<div id="osmap" class="sitemap<?php echo $this->params->get('pageclass_sfx'); ?>">
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
#### ENDE - SEITENÜBERSCHRIFT (Menü)
?>

<div class="item-page">
	<div class="page-header">
		<h2>Sitemap
		<span class="articlesubtitle">(Ohne Kategorie "Spezielles". Siehe unten.)</span>
		</h2>
	</div>
    <!-- Description -->
    <?php if ($this->params->get('show_sitemap_description', 1)) :   ?>
        <div class="osmap-sitemap-description">
            <?php echo $this->params->get('sitemap_description', ''); ?>
        </div>
    <?php endif; ?>

    <!-- Error message, if exists -->
    <?php if (!empty($this->message)) : ?>
        <div class="alert alert-warning">
            <?php echo $this->message; ?>
        </div>
    <?php endif; ?>

    <!-- Items -->
    <?php if (empty($this->message)) : ?>
		<div class="articleBody">
			<?php echo $this->loadTemplate('items'); ?>
		</div>
    <?php endif; ?>
</div><!--/item-page-->

<div class="clearfix"></div>
</div>
