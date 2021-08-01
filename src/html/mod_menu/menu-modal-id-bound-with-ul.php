<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;
use Joomla\String\StringHelper;
use Joomla\CMS\Layout\LayoutHelper;

if (
	$params->get('robotsHide', 0) === 1
	&& Factory::getApplication()->client->robot
){
	return '';
}

echo '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->';

/* To calculate a unique id for both participating modules (button and modal)
	we need a	identical base in both modules. */
JLoader::register('Bs3ghsvsArticle',
	JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ArticleHelper.php'
);
$modalId = Bs3ghsvsArticle::buildUniqueIdFromJinput(
	$params->get('connectorKey', '')
);
$moduleSubHeader = $params->get('moduleSubHeader', '');
$modalHeadline = $module->showtitle ? $module->title
	: ($moduleSubHeader ?: 'TPL_MODAL_FALLBACK');
$levelPrefix = Text::_('TPL_MODAL_MENUE_LEVEL_PREFIX');

if ($tagId = $params->get('tag_id', ''))
{
	$id = $tagId;
}
else
{
	$id = 'navbar-' . $module->id;
}

$class_sfx = $class_sfx ? ' ' . $class_sfx : '';

foreach ($list as $item)
{
	$item->liClass = ['list-group-item'];
	$item->liClass[] = 'item-' . $item->id . ' level-' . $item->level;
	$aClass = [];
	$item->add = '';

	/* Die geben wohl die einleitenden &nbsp; mit einer ESC-Folge ein(?)
	Im Quellcode kommt aber '   Thomas Boyken' raus. trim() hilft nichts.
	str_replace('&nbsp;', ...) hilft nix
	Wenn man das dann mit einem json_encode ausgibt, kommt man auf
	\u00a0\u00a0\u00a0Thomas Boyken und damit dann endlich auf:
	*/
	$item->title = StringHelper::trim($item->title, "\u{00a0}");

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
			&& $item->params->get('aliasoptions') == $active_id)
	){
		$item->liClass[] = 'current';
		$item->aAttributes['aria-current'] = 'page';
		$aClass[] = 'active';

		// Fürs li eigentlich.
		$item->add = '';
	}

	if (in_array($item->id, $path))
	{
		$item->liClass[] = 'active';
	}
	elseif ($item->type === 'alias')
	{
		$aliasToId = $item->params->get('aliasoptions');

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

	// Just indent because I'm too lazy to build nested UL.
	$item->prefix = str_repeat($levelPrefix, ($item->level - 1));
	$item->liClass = implode(' ', $item->liClass);

	if ($aClass)
	{
		$item->aAttributes['class'] = implode(' ', $aClass);
	}

	// Is in subfiles for chance to override.
	// $item->aAttributes = ArrayHelper::toString($item->aAttributes);
}
?>
<div id="<?php echo $modalId; ?>" class="modal fade" tabindex="-1" role="dialog"
	aria-labelledby="<?php echo $modalId; ?>Title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content bg-modal">
			<div class="modal-header">
				<p class="modal-title h3"
					id="<?php echo $modalId; ?>Title">
					<?php echo Text::_($modalHeadline); ?>
				</p>
				<?php echo LayoutHelper::render('ghsvs.closeButtonTop'); ?>
			</div><!--/modal-header-->
			<div class="modal-body container-fluid">
				<div class="row">
					<div class="col-12">
						<ul class="<?php echo 'list-group' . $class_sfx; ?>">
						<?php
						foreach ($list as &$item)
						{

							?>
							<li class="<?php echo $item->liClass; ?>"<?php echo $item->add; ?>>
							<?php echo $item->prefix; ?>
							<?php
							switch ($item->type) :
								case 'separator':
								case 'component':
								case 'heading':
								case 'url':
									require ModuleHelper::getLayoutPath('mod_menu',
										'ghsvsDefault_' . $item->type);
									break;

								default:
									require ModuleHelper::getLayoutPath('mod_menu',
										'ghsvsDefault_url');
									break;
							endswitch;
							?>
							</li>
						<?php
						} ?>
						</ul>
					</div>
				</div>
			</div><!--/modal-body-->
			<div class="modal-footer">
				<?php echo LayoutHelper::render('ghsvs.closeButton'); ?>
			</div><!--/modal-footer-->
		</div><!--/modal-content-->
	</div><!--/modal-dialog-->
</div><!--/#<?php echo $modalId; ?>-->
