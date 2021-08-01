<?php
defined('_JEXEC') or die;

$uri = JUri::getInstance();
if (
 $uri->getVar('option') == 'com_users'
 || strpos($uri->getPath(), '/component/users') !== false
){
 throw new RuntimeException(JText::_('Ich mag dich nicht!'), '403');
 die;
}

$cookieLogin = $this->user->get('cookieLogin');

if ($this->user->get('guest') || !empty($cookieLogin))
{
	// The user is not logged in or needs to provide a password.
	echo $this->loadTemplate('login');
}
else
{
	// The user is already logged in.
	echo $this->loadTemplate('logout');
}
