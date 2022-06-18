<?php
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Layout\LayoutHelper;

if ($tagId = $params->get('tag_id', ''))
{
	$id = $tagId;
}
else
{
	$id = 'navbar-' . $module->id;
}

$class_sfx = $class_sfx ? ' ' . $class_sfx : '';

// Für CSS-Spielerei.
$ulClass = '';

foreach ($list as $item)
{
	$item->liClass = ['nav-item'];
	$item->liClass[] = 'item-' . $item->id . ' level-' . $item->level;
	$aClass = ['nav-link'];
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
		$item->liClass[] = 'deeper';
	}

	if ($item->id == $default_id)
	{
		$item->liClass[] = 'default';
	}

	if (
		$item->id == $active_id
		|| ($item->type === 'alias'
			&& $itemParams->get('aliasoptions') == $active_id)
	) {
		$item->liClass[] = 'current';
		$item->aAttributes['aria-current'] = 'page';
		$aClass[] = 'active disabled';

		if ($ulClass === '')
		{
			$ulClass = ' active';
		}
	}

	if (in_array($item->id, $path))
	{
		$item->liClass[] = 'active';
	}
	elseif ($item->type === 'alias')
	{
		$aliasToId = $itemParams->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$item->liClass[] = 'active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$item->liClass[] = 'alias-parent-active';
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
?>
<?php
echo LayoutHelper::render('ghsvs.moduleColDiv.start', [
	'module' => $module,
	'params' => $params,
	'prependClass' => '',
	// leading space!
	'attribs' => ' role="navigation"',
]);
?>
<ul class="nav nav-pills h-100 flex-column<?php echo $class_sfx; ?>
	<?php echo $ulClass; ?>" id="<?php echo $id; ?>">

	<?php foreach ($list as $i => &$item)
	{ ?>
		<li class="<?php echo $item->liClass; ?>">
			<?php switch ($item->type)
			{
			case 'separator':
			case 'component':
			case 'heading':
			case 'url':
				require ModuleHelper::getLayoutPath(
					'mod_menu',
					'ghsvsDefault_' . $item->type
				);
			break;

			default:
				require ModuleHelper::getLayoutPath('mod_menu', 'ghsvsDefault_url');
			break;
			} ?>
		</li>
	<?php
	} // foreach $list ?>

</ul>
<?php echo LayoutHelper::render('ghsvs.moduleColDiv.end'); ?>
