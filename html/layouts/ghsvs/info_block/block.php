<?php
\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

extract($displayData);

/**
 * Layout variables
 * ---------------------
 *
 * @var object  $item  Article
 * @var object  $params  Registry. Of article or module
 */

$show_parent_category = $params->get('show_parent_category')
	&& !empty($item->parent_slug);
$show_category = $params->get('show_category');
$showDate = $params->get('show_publish_date')
	|| $params->get('show_create_date')
	|| $params->get('show_modified_date');
?>
<?php
if ($showDate || $show_category || $show_parent_category)
{ ?>
	<dl class="article-info">
		<?php if ($params->get('show_author')
			&& !(empty($item->author) && empty($item->created_by_alias)))
		{
			echo LayoutHelper::render('ghsvs.info_block.author',
				['item' => $item, 'params' => $params]);
		} ?>

	<?php
		if (
			!isset($item->combinedCatsGhsvs) ||
			(!$params->get('ghsvs_combine_categories', 0) &&
			!$item->params->get('ghsvs_combine_categories', 0))
		){
		?>
			<?php if ($show_parent_category || $show_category)
			{ ?>
				<dt class="visually-hidden"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_CATEGORIES'); ?></dt>
			<?php
			} ?>

			<?php if ($show_parent_category) : ?>
				<?php echo HTMLHelper::_('bs3ghsvs.layout', 'joomla.content.info_block.parent_category', $displayData); ?>
			<?php endif; ?>

			<?php if ($show_category) : ?>
				<?php echo HTMLHelper::_('bs3ghsvs.layout', 'joomla.content.info_block.category', $displayData); ?>
			<?php endif; ?>

		<?php
		}
		else
		{
		?>
			<dt class="visually-hidden"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_CATEGORIES'); ?></dt>
			<?php
			$item->params->set('ghsvs_combine_categories', 0);
			echo HTMLHelper::_('bs3ghsvs.layout', 'ghsvs.combine_categories', $displayData);
		}
	?>

			<?php if ($showDate)
			{ ?>
				<dt class="visually-hidden">
					<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_DATE_INFO'); ?>
				</dt>
			<?php
			} ?>

		<?php if ($params->get('show_publish_date')) : ?>
		<dd class="published">
			<?php echo Text::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', HTMLHelper::_('date', $item->publish_up, Text::_('DATE_FORMAT_LC3'))); ?>
		</dd>
		<?php endif; ?>

		<?php if ($params->get('show_create_date')) : ?>
		<dd class="create">
			<?php echo Text::sprintf('COM_CONTENT_CREATED_DATE_ON',
				HTMLHelper::_('date', $item->created, Text::_('DATE_FORMAT_LC3'))); ?>
		</dd>
		<?php endif; ?>

		<?php if ($params->get('show_modify_date')) : ?>
		<dd class="modified">
			<?php echo Text::sprintf('COM_CONTENT_LAST_UPDATED',
				HTMLHelper::_('date', $item->modified, Text::_('DATE_FORMAT_LC3'))); ?>
		</dd>
		<?php endif; ?>
	</dl><!--/article-info-->
<?php
}
