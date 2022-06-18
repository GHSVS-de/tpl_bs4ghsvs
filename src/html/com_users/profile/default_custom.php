<?php
defined('_JEXEC') or die;

return;

JLoader::register('JHtmlUsers', JPATH_COMPONENT . '/helpers/html/users.php');
JHtml::register('users.spacer', ['JHtmlUsers', 'spacer']);

$fieldsets = $this->form->getFieldsets();

if (isset($fieldsets['core']))
{
	unset($fieldsets['core']);
}

if (isset($fieldsets['params']))
{
	unset($fieldsets['params']);
}

foreach ($fieldsets as $group => $fieldset): // Iterate through the form fieldsets
	$fields = $this->form->getFieldset($group);

	if (count($fields)):
?>

<fieldset id="users-profile-custom" class="users-profile-custom-<?php echo $group; ?>">
	<?php // If the fieldset has a label set, display it as the legend. ?>
	<?php if (isset($fieldset->label)): ?>
	<legend><?php echo JText::_($fieldset->label); ?></legend>
	<?php endif; ?>
	<dl class="dl-horizontal">
	<?php foreach ($fields as $field) :
		if (!$field->hidden && $field->type != 'Spacer') : ?>
		<dt><?php echo $field->title; ?></dt>
		<dd>
			<?php if (JHtml::isRegistered('users.' . $field->id)) : ?>
				<?php echo JHtml::_('users.' . $field->id, $field->value); ?>
			<?php elseif (JHtml::isRegistered('users.' . $field->fieldname)) : ?>
				<?php echo JHtml::_('users.' . $field->fieldname, $field->value); ?>
			<?php elseif (JHtml::isRegistered('users.' . $field->type)) : ?>
				<?php echo JHtml::_('users.' . $field->type, $field->value); ?>
			<?php else : ?>
				<?php echo JHtml::_('users.value', $field->value); ?>
			<?php endif; ?>
		</dd>
		<?php endif; ?>
	<?php endforeach; ?>
	</dl>
</fieldset>
	<?php endif; ?>
<?php endforeach; ?>
