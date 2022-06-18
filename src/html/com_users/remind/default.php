<?php
defined('_JEXEC') or die;

return;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
?>
<?php
echo JHtml::_(
	'bs3ghsvs.layout',
	'ghsvs.addclass_form-control',
	[
	 'formSelector' => '.form4remind',
		'additionalScript' => '',
	]
);
?>
<div class="remind<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="page-header">
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	</div>
	<?php endif; ?>

	<form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=remind.remind'); ?>" method="post" class="form-validate form4remind">
		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
		<fieldset>
			<p><?php echo JText::_($fieldset->label); ?></p>
			<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
<?php echo $field->renderField(); ?>
			<?php endforeach; ?>
		</fieldset>
		<?php endforeach; ?>
<div class="form-group">
				<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JSUBMIT'); ?></button>
</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
