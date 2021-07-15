<?php
defined('_JEXEC') or die;

use Joomla\CMS\Cache\Cache;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$tableSelector = 'FooTable' . str_replace('.', '', uniqid('', true));

// Set the cache options.
$cache_group = '_footableghsvs';

$options = array(
	'cachebase' => Factory::getApplication()->get('cache_path', JPATH_SITE . '/cache'),
	'lifetime' => 360,
	'defaultgroup' => $cache_group,
	'caching' => true
);
$cache = new Cache($options);

// Create a safe ID for cached data from URL parameters
$cache_key = $cache->makeId();

if ($cache->contains($cache_key) && ($cacheGet = $cache->get($cache_key)))
{
	$cacheGet = json_decode($cacheGet);
	$rows = $cacheGet->rows;
	$cols = $cacheGet->cols;
	$allEmpty = !is_array($rows) && !count($rows);
}
else
{
	$cacheGet = false;
}

// Array ->item sind die Tags selber! Für Subtemplates brauch ich aber ebenfalls $this->item
$this->tagitem = $this->item[0];
unset($this->item);

// 2015-12-22 Keine Ahnung, warum com_tags mit Array arbeitet
$this->tagitem->params = new Registry($this->tagitem->params);
$this->tagitem->params->merge($this->params);

// Eigene Paras in XML
$ownParas = array('float_fulltext');

$this->tagitem->images = json_decode($this->tagitem->images);

foreach ($ownParas as $para)
{
	$this->tagitem->images->$para = $this->params->get($para);
}

$this->tagitem->images = json_encode($this->tagitem->images);

if ($cacheGet === false)
{
	$cols = array();
	$rows = $this->items;
	$allEmpty = !is_array($rows) && !count($rows);

	if (!$allEmpty)
	{
		JLoader::register(
			'Bs3ghsvsArticle',
			JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ArticleHelper.php'
		);
		
		JLoader::register(
			'Bs3ghsvsItem',
			JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ItemHelper.php'
		);

		$linkIcon = Bs3ghsvsItem::replaceSvgPlaceholders(
			'{svg{bi/link-45deg}}',
			[
				'addSpan'   => 1,
				'spanClass' => 'svgSpan svg-lg',
			]
		);

		foreach ($rows as $row)
		{
			$row->link = Route::_(TagsHelperRoute::getItemRoute(
				$row->content_item_id,
				$row->core_alias,
				$row->core_catid,
				$row->core_language,
				$row->type_alias,
				$row->router
			));
		
			if (
				$this->params->get('show_extensiondescription')
				&& false !== ($extensionData = Bs3ghsvsArticle::getExtensionData($row->content_item_id))
			){
				$row->extensiondescription = $extensionData->description;
			}
		}
		unset($row);
	
		$dontKill = $dates = $numbers = array();
		$descriptionBreakpoints = 'xxs';
		$dateBreakpoints = 'xs';
		$authorBreakpoints = 'xs';
		$hitsBreakpoints = 'lg';
		$idBreakpoints = 'sm';
		$dateFormat = 'DD.MM.YYYY';

		##### TABELLEN-COLS START #####
		$name = 'core_title';
		$cols[] = array(
			'name' => $name,
			'title' => Text::_('JGLOBAL_TITLE'),
			'filterable' => true,
			'classes' => array('td4title', 'td4toggler'),
		);
		$dontKill[] = $name;

		$name = 'link';
		$cols[] = array(
			'name' => $name,
			'title' => Text::_('GHSVS_OPEN'),
			'filterable' => false,
			'sortable' => false,
			'classes' => array('td4link'),
		);
		$dontKill[] = $name;
	
		if ($this->params->get('show_extensiondescription'))
		{
			$name = 'extensiondescription';
			$cols[] = array(
				'name' => $name,
				'title' => Text::_('GHSVS_EXTENSIONDESCRIPTION'),
				'filterable' => true,
				'sortable' => false,
				'classes' => array('td4shortdescription'),
				'breakpoints' => $descriptionBreakpoints,
			);
			$dontKill[] = $name;
		}
	
		if ($this->params->get('show_modify_date'))
		{
			$name = 'core_modified_time';
			$cols[] = array(
				'name' => $name,
				'title' => Text::_('GHSVS_MODIFIED'),
				'type' => 'date',
				'filterable' => true,
				'breakpoints' => $dateBreakpoints,
				'classes' => array('td4date'),
				'sorted' => true,
				'direction' => 'DESC',
				'formatString' => $dateFormat,
			);
			$dontKill[] = $dates[] = $name;
		}
	
		if ($this->params->get('show_create_date'))
		{
			$name = 'core_created_time';
			$cols[] = array(
				'name' => $name,
				'title' => Text::_('GHSVS_CREATED'),
				'type' => 'date',
				'filterable' => true,
				'breakpoints' => $dateBreakpoints,
				'classes' => array('td4date'),
				'formatString' => $dateFormat,
			);
			$dontKill[] = $dates[] = $name;
		}
	
		if ($this->params->get('show_publish_date'))
		{
			$name = 'core_publish_up';
			$cols[] = array(
				'name' => $name,
				'title' => Text::_('GHSVS_PUBLISHED'),
				'type' => 'date',
				'filterable' => false,
				'breakpoints' => $dateBreakpoints,
				'classes' => array('td4date'),
				'formatString' => $dateFormat,
			);
			$dontKill[] = $dates[] = $name;
		}
	
		if ($this->params->get('show_id'))
		{
			$name = 'content_item_id';
			$cols[] = array(
				'name' => $name,
				'title' => Text::_('JGRID_HEADING_ID'),
				'filterable' => true,
				'breakpoints' => $idBreakpoints,
				'classes' => array('td4id'),
				'type' => 'number',
			);
			$dontKill[] = $numbers[] = $name;
		}
		##### TABELLEN-COLS ENDE #####

		##### TABELLEN-ROWS START #####
		foreach ($rows as $index => $row)
		{
			$article = new stdClass;
		
			foreach ($dontKill as $key)
			{
				if (!isset($row->$key))
				{
					continue;
				}

				if ($key === 'link')
				{
					$article->$key = '<a class="linkWithIconGhsvs" href="' . $row->link . '">
					<span class="sr-only">' . Text::_('GHSVS_OPEN_ARTICLE') . '</span>'
					. $linkIcon . '</a>';
					continue;
				}

				if (in_array($key, $dates))
				{
					$date = Factory::getDate($row->$key)->toUnix();
					$article->$key = ($date * 1000);
					continue;
				}
			
				if (in_array($key, $numbers))
				{
					$article->$key = (int) $row->$key;
					continue;
				}
			
				$article->$key = $row->$key;
			}
			$rows[$index] = $article;
		} // foreach ($rows as $index => $row)
		##### TABELLEN-ROWS ENDE #####
		$cache->store(
			json_encode(array('rows' => $rows, 'cols' => $cols)),
			$cache_key,
			$cache_group
		);
	} // !$allEmpty
} //if ($cacheGet === false)

if (!$allEmpty)
{
	// Falls Robot lesbare Listenausgabe
	if (Factory::getApplication()->client->robot)
	{
		$html = array();
	
		foreach ($rows as $row)
		{
			$html[] = '<h3>' . $row->core_title . '</h3>';
	
			if (isset($row->extensiondescription))
			{
				$html[] = '<p>' . $row->extensiondescription . '</p>';
			}
	
			$html[] = '<p>' . $row->link . '</p>';
		}
	} // ENDE client->robot
	// Andernfalls Footable
	else
	{
		$countCollect = count($rows);
		$maxentries = 20;
		
		$options = array(
			'rows' => $rows,
			'columns' => $cols,
			'paging' => array(
				'enabled' => ($countCollect > $maxentries) ? true : false,
				'size' => $maxentries,
			),
			'sorting' => array(
				'enabled' => true
			),
			'filtering' => array(
				'enabled' => true
			),
			'state' => array(
				'enabled' => true,
				'filtering' => true,
				'paging' => true,
				'sorting' => true,
				'key' => 'tagitem_items' . $this->tagitem->id . $this->tagitem->alias
			),
			'cascade' => true
		);
		
		HTMLHelper::_('bs3ghsvs.footable', '#' . $tableSelector, $options);
	}
} // ENDE !$allEmpty
?>
<div class="blog<?php echo $this->pageclass_sfx; ?> footabled">

<!--SEITENÜBERSCHRIFT h1 START-->
<?php echo HTMLHelper::_(
 'bs3ghsvs.layout',
	'ghsvs.page_heading',
	array('params' => $this->tagitem->params)
	);
?>
<!--SEITENÜBERSCHRIFT h1 ENDE-->

<!--TAG BESCHREIBUNG BILD START-->
<?php
$showDesc = (
	$this->params->get('tag_list_show_tag_image', 1) 
	|| ($this->params->get('tag_list_show_tag_description', 1) && $this->tagitem->description)
	|| $this->params->get('show_tag_title', 1)
);

if ($showDesc)
{ ?>
<div class="tag-desc clearfix">	
<?php
if ($this->params->get('show_tag_title', 1)){ ?>
  <div class="page-header">
   <h2>
		<?php echo HTMLHelper::_('content.prepare', $this->tags_title, '', 'com_tag.tag'); ?>
   </h2>
  </div>
<?php
} ?>
<?php
if ($this->params->get('tag_list_show_tag_image', 1))
{
	echo HTMLHelper::_('bs3ghsvs.layout', 
		'ghsvs.full_image_venobox',
		array(
			'item' => $this->tagitem,
			'microdata' => false
		)
	);
}
?>
<?php
if (
	$this->params->get('tag_list_show_tag_description', 1)
	&& $this->tagitem->description
){ ?>
	<div class="tag-description">
		<?php echo HTMLHelper::_('content.prepare', $this->tagitem->description, '', 'com_tags.tag'); ?>
	</div><!--/tag-description-->
<?php
} ?>
</div><!--/tag-desc-->
<?php
} // if $showDesc ?>
<!--TAG BESCHREIBUNG BILD ENDE-->

<?php
if ($allEmpty && $this->params->get('show_no_articles', 1))
{
?>
		<p class="alert alert-info">
			<?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?>
		</p>
<?php
}
elseif (!isset($html))
{
?>
	<table id=<?php echo $tableSelector; ?> class="table"></table>
<?php 
}
elseif(isset($html))
{
	echo implode('', $html);
}?>
</div><!--/blog<?php echo $this->pageclass_sfx; ?>-->
