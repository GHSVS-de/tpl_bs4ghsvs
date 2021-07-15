<?php
/**
Liste für intro_items.
GHSVS 2015-08-01: Erste Schritte auch Einleitende und Links mit anzuzeigen. Dazwischen Liste.



###################################################
2016: OUTDATED! Replaced by blogghsvs_footable.php
###################################################


 */
defined('_JEXEC') or die;

// FooTable-Liste braucht Abfrage aller Artikel
use Joomla\Registry\Registry;
require_once JPATH_SITE . '/plugins/system/bs3ghsvs/helpers/articles.php';

// Mögliche Parameter für ArticlesHelper
// In View XML sollte weiteres fieldset für Footables
$params = new Registry;
$input = JFactory::getApplication()->input;
$params->set('count', 0);
// vom Modul Beiträge Kategorie. Lass ich mal drin.
$params->set('mode', 'normal');
$catid = $input->get('id');
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

// GHSVS 2018-06 Use uniqid('', true)
#$tableSelector = 'FooTable' . str_replace(array('.', ' ', ','), '', microtime());
$tableSelector = 'FooTable' . str_replace('.', '', uniqid('', true));
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
 'title' => JText::_('JGLOBAL_TITLE'),
	'filterable' => true,
	'classes' => array('td4title', 'td4toggler'),
);
$dontKill[] = $name;

$name = 'link';
$cols[] = array(
 'name' => $name,
 'title' => JText::_('GHSVS_OPEN'),
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
  'title' => JText::_('GHSVS_MODIFIED'),
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
  'title' => JText::_('GHSVS_CREATED'),
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
  'title' => JText::_('GHSVS_PUBLISHED'),
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
  'title' => JText::_('JAUTHOR'),
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
  'title' => JText::_('JGLOBAL_HITS'),
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
  'title' => JText::_('JGRID_HEADING_ID'),
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
		if ($key == 'link')
		{
			$article->$key = '<a class=linkWithIconGhsvs href="'.$row->link.'"> {svg{bi/link-45deg}}</a>';
			continue;
		}

		if (in_array($key, $dates))
		{
			$date = JFactory::getDate($row->$key)->toUnix();
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
		'key' => 'blogghsvs_liste' . $catid
	),
	'cascade' => true
);

JHtml::_('bs3ghsvs.footable', '#' . $tableSelector, $options);
?>
<table id=<?php echo $tableSelector; ?> class="table table-bordered table-condensed"></table>



echo '<div class="example">

  </div>';
<?php
return;


#echo '4654sd48sa7d98sD81s8d71dsa json '.print_r(json_encode($this->items, JSON_PRETTY_PRINT),true);exit;
// Create some shortcuts.
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

// Check for at least one editable article
$isEditable = false;
if (!empty($this->items))
{
	foreach ($this->items as $article)
	{
		if ($article->params->get('access-edit'))
		{
			$isEditable = true;
			break;
		}
	}
}
?>
	<table class="category table table-striped table-bordered table-hover">
		<?php if ($this->params->get('show_headings')) : ?>
		<thead>
				<?php if ($this->params->get('list_show_hits')) : ?>
					<th id="categorylist_header_hits">
						<?php echo JHtml::_('grid.sort', '', 'a.hits', $listDirn, $listOrder); ?>
					</th>
				<?php endif; ?>
				<?php if ($isEditable) : ?>
					<th id="categorylist_header_edit"><?php echo JText::_('COM_CONTENT_EDIT_ITEM'); ?></th>
				<?php endif; ?>
			</tr>
		</thead>
		<?php endif; ?>
		<tbody>
			<?php foreach ($this->intro_items as $i => $article) : ?>
				<?php if ($article->state == 0) : ?>
				<tr class="system-unpublished cat-list-row<?php echo $i % 2; ?>" id="blogitem-anker-<?php echo $article->id;?>">
				<?php else: ?>
				<tr class="cat-list-row<?php echo $i % 2; ?>" id="blogitem-anker-<?php echo $article->id;?>">
				<?php endif; ?>
					<td headers="categorylist_header_title" class="list-title">
						<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
							<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid)); ?>">
								<?php echo $this->escape($article->title); ?>
							</a>
						<?php else: ?>
							<?php
							echo $this->escape($article->title).' : ';
							$menu		= JFactory::getApplication()->getMenu();
							$active		= $menu->getActive();
							$itemId		= $active->id;
							$link = JRoute::_('index.php?option=com_users&view=login&Itemid='.$itemId);
							$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
							$fullURL = new JUri($link);
							$fullURL->setVar('return', base64_encode($returnURL));
							?>
							<a href="<?php echo $fullURL; ?>" class="register">
								<?php echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
							</a>
						<?php endif; ?>
						<?php if ($article->state == 0) : ?>
							<span class="list-published badge bg-warning">
								<?php echo JText::_('JUNPUBLISHED'); ?>
							</span>
						<?php endif; ?>
						<?php if ($article->state == 2) : ?>
							<span class="list-archived badge bg-warning">
								<?php echo JText::_('JARCHIVED'); ?>
							</span>
						<?php endif; ?>
						<?php if (strtotime($article->publish_up) > strtotime(JFactory::getDate())) : ?>
							<span class="list-published badge bg-warning">
								<?php echo JText::_('JNOTPUBLISHEDYET'); ?>
							</span>
						<?php endif; ?>
						<?php if ((strtotime($article->publish_down) < strtotime(JFactory::getDate())) && $article->publish_down != '0000-00-00 00:00:00') : ?>
							<span class="list-published badge bg-warning">
								<?php echo JText::_('JEXPIRED'); ?>
							</span>
						<?php endif; ?>
					</td>
					<?php if ($this->params->get('list_show_date')) : ?>
						<td headers="categorylist_header_date" class="list-date">
							<?php
							echo JHtml::_(
								'date', $article->displayDate,
								$this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))
							); ?>
						</td>
					<?php endif; ?>
					<?php if ($this->params->get('list_show_author', 1)) : ?>
						<td headers="categorylist_header_author" class="list-author">
							<?php if (!empty($article->author) || !empty($article->created_by_alias)) : ?>
								<?php $author = $article->author ?>
								<?php $author = ($article->created_by_alias ? $article->created_by_alias : $author);?>
								<?php if (!empty($article->contact_link) && $this->params->get('link_author') == true) : ?>
									<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', $article->contact_link, $author)); ?>
								<?php else: ?>
									<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					<?php endif; ?>
					<?php if ($this->params->get('list_show_hits', 1)) : ?>
						<td headers="categorylist_header_hits" class="list-hits">
							<span class="badge badge-info">
								<?php echo JText::sprintf('JGLOBAL_HITS_COUNT', $article->hits); ?>
							</span>
						</td>
					<?php endif; ?>
					<?php if ($isEditable) : ?>
						<td headers="categorylist_header_edit" class="list-edit">
							<?php if ($article->params->get('access-edit')) : ?>
								<?php echo JHtml::_('icon.edit', $article, $$article->params); ?>
							<?php endif; ?>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
