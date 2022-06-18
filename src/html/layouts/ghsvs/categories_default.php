<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

?>

<?php
#### SEITENÜBERSCHRIFT (Menü)
if ($displayData->params->get('show_page_heading'))
{
	echo HTMLHelper::_(
		'bs3ghsvs.layout',
		'ghsvs.page_heading',
		[
		'params' => $displayData->params,
		'bs3ghsvs.rendermodules-position' => '',
	]
	);
}
#### ENDE - SEITENÜBERSCHRIFT (Menü)
?>

<?php if ($displayData->params->get('show_base_description')) : ?>
	<?php if ($displayData->params->get('categories_description')) : ?>
		<div class="category-desc base-desc">
		<?php echo HTMLHelper::_('content.prepare', $displayData->params->get('categories_description'), '', $displayData->get('extension') . '.categories'); ?>
		</div>
	<?php else : ?>
		<?php  if ($displayData->parent->description) : ?>
			<div class="category-desc base-desc lead">
				<?php echo HTMLHelper::_('content.prepare', $displayData->parent->description, '', $displayData->parent->extension . '.categories'); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
