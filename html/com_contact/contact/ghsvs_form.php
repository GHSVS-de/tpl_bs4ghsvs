<?php
/**
 * GHSVS
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

JLoader::register('Bs3GhsvsFormHelper', __DIR__ . '/Helper/FormHelper.php');

$overrides = array(
	'contact_name' => array('str' => 'SINFOTPL_CONTACT_NAME_DESC', 'group' => ''),
	'contact_email' => array('str' => 'SINFOTPL_CONTACT_EMAIL_DESC', 'group' => ''),
	'contact_subject' => array('str' => 'SINFOTPL_CONTACT_SUBJECT_DESC', 'group' => ''),
	'contact_message' => array('str' => 'SINFOTPL_CONTACT_MESSAGE_DESC', 'group' => ''),
	//'contact_phoneghsvs'=> array('str' => '', 'group' => ''),
	
	// GHSVS 2018 neue Datenschutz-Checkbox
	//'contact-datenschutz' => 'onlyClasses',
);

// add BS3 form-control class and Placeholders.
Bs3GhsvsFormHelper::prepareFormFields($this->form, 'description', $overrides);

if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<div class="contact-form">
	<form id="contact-form" action="<?php echo Route::_('index.php'); ?>" method="post" class="form-validate">
		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
			<?php if ($fieldset->name === 'captcha' && !$this->captchaEnabled) : ?>
				<?php continue; ?>
			<?php endif; ?>
			<?php $fields = $this->form->getFieldset($fieldset->name); ?>
			<?php if (count($fields)) : ?>
				<fieldset>
					<?php if (isset($fieldset->label) && ($legend = trim(Text::_($fieldset->label))) !== '') : ?>
						<legend><?php echo $legend; ?></legend>
					<?php endif; ?>
					<?php foreach ($fields as $field) : ?>
						<?php echo $field->renderField(); ?>
					<?php endforeach; ?>
				</fieldset>
			<?php endif; ?>
		<?php endforeach; ?>
		<div class="control-group">
			<div class="controls">
				<button class="btn btn-primary validate" type="submit"><?php echo Text::_('COM_CONTACT_CONTACT_SEND'); ?></button>
				<input type="hidden" name="option" value="com_contact" />
				<input type="hidden" name="task" value="contact.submit" />
				<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
				<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
				<?php echo HTMLHelper::_('form.token'); ?>
			</div>
		</div>
	</form>
</div>