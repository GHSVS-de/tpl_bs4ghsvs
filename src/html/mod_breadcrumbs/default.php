<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

// Stupid outputs by com_tags.
$option = Factory::getApplication()->input->get('option', '');

if (version_compare(JVERSION, '4', 'ge'))
{
	$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');
}

// Fixes https://github.com/GHSVS-de/tpl_bs4ghsvs/issues/25
if (version_compare(JVERSION, '3', 'gt'))
{
	foreach ($list as $key => $item)
	{
		if (!empty($item->link))
		{
			$list[$key]->link = Route::_($item->link);
		}
	}
}
?>
<?php
/* echo LayoutHelper::render('ghsvs.moduleColDiv.start', array(
	'module' => $module,
	'params' => $params,
	'prependClass' => 'col-12',
)); */
?>
	<nav aria-label="<?php echo htmlspecialchars($module->title, ENT_QUOTES, 'utf-8'); ?>">
		<ol class="breadcrumb <?php echo $moduleclass_sfx; ?>">

			<?php
			$showHereClass = '';

			if (!$params->get('showHere', 1))
			{
				$showHereClass = ' visually-hidden';
			} ?>
			<li class="breadcrumb-item">
				{svg{bi/geo-fill}}
				<span class="<?php echo $showHereClass; ?>">
				<?php echo Text::_('MOD_BREADCRUMBS_HERE'); ?>
				</span>
			</li>

			<?php
			// Get rid of duplicated entries on trail including home page when using multilanguage
			for ($i = 0; $i < $count; $i++)
			{
				if (
					$i === 1
					&& !empty($list[$i]->link)
					&& !empty($list[$i - 1]->link)
					&& $list[$i]->link === $list[$i - 1]->link
				) {
					unset($list[$i]);
					continue;
				}

				// Shit like /downloads?layout=protostarbs3ghsvs:footable
				if (strpos($list[$i]->link, '?') !== false)
				{
					$parts = explode('?', $list[$i]->link);
					$list[$i]->link = $parts[0];
				}
			}

			// Find last and penultimate items in breadcrumbs list
			end($list);
			$last_item_key   = key($list);
			prev($list);
			$penult_item_key = key($list);

			// Make a link if not the last item in the breadcrumbs
			$show_last = $params->get('showLast', 1);
			?>
			<?php foreach ($list as $key => $item)
			{ ?>
				<?php if ($key !== $last_item_key)
				{ ?>
				<li class="breadcrumb-item">
					<?php if (!empty($item->link))
					{ ?>
					<a href="<?php echo $item->link; ?>">
						<?php echo $item->name; ?>
					</a>
					<?php
					}
					else
					{ ?>
					<span>
						<?php echo $item->name; ?>
					</span>
					<?php
					} ?>
				</li>
				<?php
				}
				elseif ($show_last && !in_array($option, ['com_tags', 'com_osmap']))
				{ ?>
				<li class="breadcrumb-item active fst-italic" aria-current="location">
					<?php echo $item->name; ?>
				</li>
				<?php
				} ?>
			<?php
			} ?>
		</ol>
	</nav>
<?php #echo LayoutHelper::render('ghsvs.moduleColDiv.end'); ?>
