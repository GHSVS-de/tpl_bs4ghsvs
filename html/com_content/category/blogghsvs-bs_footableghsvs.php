<?php
defined('_JEXEC') or die;

use Joomla\CMS\Cache\Cache;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

// FooTable-Liste braucht Abfrage aller Artikel

$tableSelector = 'FooTable' . str_replace('.', '', uniqid('', true));

// Set the cache options.
$cache_group = '_footableghsvs';

$options = array(
	'cachebase' => Factory::getApplication()->get('cache_path', JPATH_SITE . '/cache'),
	'lifetime' => 360,
	'defaultgroup' => $cache_group,
	'caching' => true,
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

// Lass ich, weil derzeit zu faul:
$cacheActive = 1;

// 2017-06 Brauchen wir jetzt immer.
$input = Factory::getApplication()->input;
$catid = (int) $input->get('id');

if (!$cacheGet)
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

	// Mögliche Parameter für ArticleHelper
	// In View XML sollte weiteres fieldset für Footables
	$params = new Joomla\Registry\Registry;

	$params->set('count', 0);
	// vom Modul Beiträge Kategorie. Lass ich mal drin.
	$params->set('mode', 'normal');
	$params->set('catid', $catid);
	// Include/Exclude cat
	$params->set('category_filtering_type', 1);
	$params->set('show_child_category_articles', 0);
	// Kategorielevel
	$params->set('levels', 1);
	
	$params->set('article_ordering', 'a.ordering');
	$params->set('article_ordering_direction', 'ASC');

	####### FILTERS START
	// filter.featured
	$params->set('show_front', 'show');
	//filter.author_id
	// Lieber auf false statt Leerstring. Siehe u. Problem created_by_alias
	$params->set('created_by', false);
	//filter.author_id.include/exclude
	$params->set('author_filtering_type', 1);
	//filter.author_alias
	// Muss explizit false! Leerstring filtert!
	$params->set('created_by_alias', false);
	//filter.author_alias.include/exclude
	$params->set('author_alias_filtering_type', 1);
	
	//Mehrzeilges Array mit Linebreak "\r\n"
	$params->set('excluded_articles', '');
	
	//filter.date_filtering
	$params->set('date_filtering', 'off');
	//filter.date_field
	$params->set('date_field', 'a.created');
	//filter.start_date_range
	$params->set('start_date_range', '1000-01-01 00:00:00');
	//filter.end_date_range
	$params->set('end_date_range', '9999-12-31 23:59:59');
	//filter.relative_date
	$params->set('relative_date', 30);


	// Display options. Glaube, nur fürs Modul interessant,
	// da der Helper eh alles abholt
	$params->set('show_date', 0);
	$params->set('show_date_field', 'created');
	$params->set('show_date_format', 'Y-m-d H:i:s');
	$params->set('show_category', 0);
	$params->set('show_hits', 0);
	$params->set('show_author', 0);
	$params->set('show_introtext', 0);
	$params->set('introtext_limit', 100);

	####### FILTERS ENDE

	$rows = Bs3ghsvsArticle::getList($params);

	$cols = array();

	$dontKill = $dates = $numbers = array();
	$dateBreakpoints = 'xs';
	$authorBreakpoints = 'xs';
	$hitsBreakpoints = 'lg';
	$idBreakpoints = 'sm';
	$dateFormat = 'DD.MM.YYYY';

	$name = 'title';
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

	if ($this->params->get('show_modify_date'))
	{
		$name = 'modified';
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
		$name = 'created';
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
		$name = 'publish_up';
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

	if ($this->params->get('list_show_author'))
	{
		$name = 'author';
		$cols[] = array(
			'name' => $name,
			'title' => Text::_('JAUTHOR'),
			'filterable' => true,
			'breakpoints' => $authorBreakpoints,
			'classes' => array('td4author'),
		);
		$dontKill[] = $name;
	}

	if ($this->params->get('list_show_hits'))
	{
		$name = 'hits';
		$cols[] = array(
			'name' => $name,
			'title' => Text::_('JGLOBAL_HITS'),
			'filterable' => true,
			'breakpoints' => $hitsBreakpoints,
			'classes' => array('td4hits'),
			'type' => 'number',
		);
		$dontKill[] = $numbers[] = $name;
	}

	if ($this->params->get('list_show_id', 1))
	{
		$name = 'id';
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

	foreach ($rows as $index => $row)
	{
		$article = new stdClass;
		
		# Wird doch oben schon gefüllt:
		// $dates = array('created', 'modified', 'publish_up');

		foreach ($dontKill as $key)
		{
			if (!isset($row->$key))
			{
				continue;
			}
			if ($key == 'link')
			{
				$article->$key = '<a class=linkWithIconGhsvs href="'.$row->link.'">' . $linkIcon . '</a>';
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
	}
	$cache->store(
		json_encode(array('rows' => $rows, 'cols' => $cols)),
		$cache_key,
		$cache_group
	);
}

$countCollect = count($rows);

$maxentries = 15;

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
		'key' => 'blogghsvs_' . $catid
	),
	'cascade' => true
);

HTMLHelper::_('bs3ghsvs.footable', '#' . $tableSelector, $options);
?>
<table id=<?php echo $tableSelector; ?> class="table table-bordered table-condensed"></table>
