<?php
defined('_JEXEC') or die;

 $uri = JUri::getInstance();
	if (strpos($uri->toString(), 'com_users') !== false)
	{
		return;
	}




JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
?>
<?php
echo JHtml::_(
	'bs3ghsvs.layout',
	'ghsvs.addclass_form-control',
	array(
	 'formSelector' => '.form4login',
		'additionalScript' => '',
	)
);
?>
<div class="login<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="page-header">
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	</div><!--/page-header-->
	<?php endif; ?>

	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
	<div class="login-description">
	<?php endif; ?>

		<?php if ($this->params->get('logindescription_show') == 1) : ?>
			<?php echo $this->params->get('login_description'); ?>
		<?php endif; ?>

		<?php if ($this->params->get('login_image') != '') : ?>
			<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JText::_('COM_USERS_LOGIN_IMAGE_ALT'); ?>"/>
		<?php endif; ?>

	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
	</div><!--/login-description-->
	<?php endif; ?>

	<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate form4login">

		<fieldset>
			<?php foreach ($this->form->getFieldset('credentials') as $field) : ?>
				<?php if (!$field->hidden) : ?>
     <?php echo $field->renderField(); ?>
				<?php endif; ?>
			<?php endforeach; ?>

<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
 <div id="form-login-remember" class="checkbox">
    <label for="remember">
    <input id="remember" type="checkbox" name="remember" checked value="yes"/>
    <?php echo JText::_('COM_USERS_LOGIN_REMEMBER_ME'); ?>
    </label>
					</div>
<?php endif; ?>


<div id="form-login-submit" class="form-group">
 <button type="submit" name="Submit" class="btn btn-primary login-button"><?php echo JText::_('JLOGIN'); ?></button>
</div>


			<?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
			<input type="hidden" name="return" value="<?php echo base64_encode($return); ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</fieldset>
	</form>
</div>
<div>
	<ul class="list-unstyled">
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
			<?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
		</li>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
			<?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
		</li>
		<?php
		$usersConfig = JComponentHelper::getParams('com_users');
		if ($usersConfig->get('allowUserRegistration')) : ?>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
				<?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
		</li>
		<?php endif; ?>
	</ul>
</div>
