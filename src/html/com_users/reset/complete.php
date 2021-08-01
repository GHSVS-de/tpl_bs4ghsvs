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
	array(
	 'formSelector' => '.form4complete',
		'additionalScript' => '',
	)
);
?>
<div class="reset-complete<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>

	<form action="<?php echo JRoute::_('index.php?option=com_users&task=reset.complete'); ?>" method="post" class="form-validate form4complete">
		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
			<fieldset>
				<p><?php echo JText::_($fieldset->label); ?></p>
				<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
<?php echo $field->renderField();
					if ($field->fieldname == 'password1')
					{
      echo JHtml::_(
       'bs3ghsvs.layout',
       'ghsvs.password_hint',
       array('style' => '.p4password_hint_button{margin-top:-14px}')
      );
					}
					?>
				<?php endforeach; ?>
			</fieldset>
		<?php endforeach; ?>

<div class="form-group">
				<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JSUBMIT'); ?></button>
</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
