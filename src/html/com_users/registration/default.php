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
	 'formSelector' => '.form4registration',
		'additionalScript' => '$(".form-group.field-spacer").addClass("visually-hidden");',
	]
);
?>
<div class="registration<?php echo $this->pageclass_sfx; ?>">
<?php
 echo JHtml::_(
	'bs3ghsvs.layout',
	'ghsvs.page_heading',
	[
		 'params' => LibHelpGhsvs::$TEMPLATEPARAMS->get('menuParams'),
		 // Falls keine Seitenüberschrift im Menü aktiviert.
			'ifNoPage_heading' => '',
			'bs3ghsvs.rendermodules-position' => 'rendermodules-registration',
		]
);
?>

	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form4registration" enctype="multipart/form-data">



		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
			<?php $fields = $this->form->getFieldset($fieldset->name); ?>
			<?php if (count($fields)) : ?>
				<fieldset>
				<?php if (isset($fieldset->label)) : ?>
					<!--<legend>-->
					<?php
     if ($fieldset->name == 'default')
     {
     	echo JHtml::_('bs3ghsvs.spoiler', JText::_($fieldset->label), JText::_('GHSVS_TOGGLE_HINT'));
     }
					else
					{
						echo JText::_($fieldset->label);
					}

					?>
     <!--</legend>-->
				<?php endif; ?>

<?php

?>

				<?php foreach ($fields as $field) : ?>
					<?php // If the field is hidden, just display the input. ?>
					<?php if ($field->hidden) : ?>
						<?php echo $field->input; ?>
					<?php else : ?>


     <?php echo $field->renderField();

					if ($field->fieldname == 'password1')
					{
						echo JHtml::_(
							'bs3ghsvs.layout',
							'ghsvs.password_hint',
							['style' => '.p4password_hint_button{margin-top:-14px}']
						);
					}
					?>

					<?php endif; ?>
				<?php endforeach; ?>
				</fieldset>
			<?php endif; ?>
		<?php endforeach; ?>

<div id="form-login-submit" class="form-group">
 <button type="submit" class="btn btn-primary validate"><?php echo JText::_('JREGISTER'); ?></button>
 <!--<a class="btn btn-default" href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>-->
</div>


 <input type="hidden" name="option" value="com_users" />
 <input type="hidden" name="task" value="registration.register" />

		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
