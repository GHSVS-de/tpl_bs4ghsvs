<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Layout\LayoutHelper;
//use Joomla\CMS\Utility\Utility;
//use Joomla\Utilities\ArrayHelper;

$id = '';

if ($tagId = $params->get('tag_id', ''))
{
	$id = $tagId;
}
else
{
	$id = 'navbar-' . $module->id;
}

$dataTarget = $id . 'NavDropdown';

$class_sfx = $class_sfx ? ' ' . $class_sfx : '';
$hasDropdown = [];

foreach ($list as $item)
{
	$item->ulLabelledBy = '';
	$item->liClass = ['item-' . $item->id, 'level-' . $item->level];
	$aClass = [];
	$itemParams = $item->getParams();

	/* Collect attributes like aria-* and others for the type subfiles.
	Can also be a SPAN attribute in case of headings.
	*/
	$item->aAttributes = [];

	if ($item->anchor_title)
	{
		$item->aAttributes['title'] = $item->anchor_title;
	}

	if ($item->anchor_css)
	{
		$aClass[] = $item->anchor_css;
	}

	if ($item->browserNav == 1)
	{
		$item->aAttributes['target'] = '_blank';
		$item->aAttributes['rel'] = 'noopener noreferrer';

		if ($item->anchor_rel == 'nofollow')
		{
			$attributes['rel'] .= ' nofollow';
		}
	}

	// At the moment only headings are used as dropdwon SPANs.
	if ($item->deeper)
	{
		$item->liClass[] = 'deeper dropdown';
		$hasDropdown[$item->id] = 1;
		$aClass[] = 'dropdown-toggle';
		$item->aAttributes['data-bs-toggle'] = 'dropdown';
		$item->aAttributes['aria-haspopup'] = 'true';
		$item->aAttributes['aria-expanded'] = 'false';
		$item->aAttributes['id'] = $id . '-' . $item->id;
		$item->ulLabelledBy = ' aria-labelledby="' . $item->aAttributes['id'] . '"';
	}

	if ((int) $item->level === 1)
	{
		$item->liClass[] = 'nav-item';
		$aClass[] = 'nav-link';
	}
	// in dropdown tree?
	elseif (array_intersect($item->tree, array_flip($hasDropdown)))
	{
		$aClass[] = 'dropdown-item';
	}

	if ($item->id == $default_id)
	{
		$item->liClass[] = 'default';
	}

	if (
		$item->id == $active_id
		|| ($item->type === 'alias'
			&& $itemParams->get('aliasoptions') == $active_id)
	){
		$item->liClass[] = 'current';
		$item->aAttributes['aria-current'] = 'page';
		$aClass[] = 'active';
	}

	if (in_array($item->id, $path))
	{
		$item->liClass[] = 'active';
		// $aClass[] = 'active';
	}
	elseif ($item->type === 'alias')
	{
		$aliasToId = $itemParams->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$item->liClass[] = 'active';
			//$aClass[] = 'active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$item->liClass[] = 'alias-parent-active';
			//$aClass[] = 'active';
		}
	}

	$type = ucfirst($item->type);
	$item->liClass[] = 'liType' . $type;
	$aClass[] = 'aType' . $type;

	if ($item->parent)
	{
		$item->liClass[] = 'parent';
	}

	$item->liClass = implode(' ', $item->liClass);

	if ($aClass)
	{
		$item->aAttributes['class'] = implode(' ', $aClass);
	}

	// Is in subfiles for chance to override.
	// $item->aAttributes = ArrayHelper::toString($item->aAttributes);
}

#echo ' 4654sd48sa7d98sD81s8d71dsa <pre>' . print_r($list, true) . '</pre>';exit;
?>
<?php
echo LayoutHelper::render('ghsvs.moduleColDiv.start', array(
	'module' => $module,
	'params' => $params,
	'prependClass' => '',
));
?>
<nav class="navbar navbar-expand-md navbar-custom<?php echo $class_sfx; ?>"
	id="<?php echo $id; ?>">
	<div class="container-fluid">
		<?php ### Den DIV braucht es, damit der Toggler automatisch nach rechts rückt. ?>
		<span class="navbar-brandsssssssss"></span>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
			data-bs-target="#<?php echo $dataTarget; ?>"
			aria-controls="<?php echo $dataTarget; ?>" aria-expanded="false"
			aria-label="<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_TOGGLE_NAVIGATION'); ?>"
		>{svg{bi/list}}</button>
		<div class="collapse navbar-collapse" id="<?php echo $dataTarget; ?>">
			<ul class="navbar-nav">
				<?php foreach ($list as $i => &$item)
				{
					echo '<li class="' . $item->liClass . '">';

					switch ($item->type)
					{
					case 'separator':
					case 'component':
					case 'heading':
					case 'url':
						require ModuleHelper::getLayoutPath('mod_menu',
							'ghsvsDefault_' . $item->type
						);
					break;

					default:
						require ModuleHelper::getLayoutPath('mod_menu', 'ghsvsDefault_url');
					break;
					}

					// The next item is deeper.
					if ($item->deeper)
					{
						echo '<ul class="dropdown-menu nav-child"' . $item->ulLabelledBy
							. '>';
					}
					// The next item is shallower.
					elseif ($item->shallower)
					{
						echo '</li>';
						echo str_repeat('</ul></li>', $item->level_diff);
					}
					// The next item is on the same level.
					else
					{
						echo '</li>';
					}
				} ?>
			</ul>
		</div>
	</div><!--/container-fluid-->
</nav>
<?php echo LayoutHelper::render('ghsvs.moduleColDiv.end'); ?>
