<?php
defined('_JEXEC') or die;

use Joomla\Application\Web\WebClient;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\Input\Cookie;
?>
<?php
if ($params->get('robotsHide', 0) === 1 && $params->get('isRobot') === 1)
{
	return;
}
?>
<?php
// $app = Factory::getApplication();
$node = 'WIPNoteSeen';
$session = Factory::getSession();
$sessionData = (int) $session->get($node);

// Nein, da die alte Cookie-Klasse kein $cookieOptions mit 'samesite' kann.
// $cookie = $app->input->cookie;

// Die neuere Cookie-Klasse:
$cookie = new Cookie;
$cookieData = (int) $cookie->get($node);

if ($sessionData === 1 || $cookieData === 1)
{
	return;
}

$session->set($node, 1);
// 14 days 60 * 60 * 24 * 14
$cookie_time = 60 * 60 * 24 * 60;

$cookieOptions = array(
	'expires' => time() + $cookie_time,
	// Wichtig! Damit Cookie sowohl unter /de/ als auch /en/ verfügbar.
	'path' => '/',
	/*
	When TRUE the cookie will be made accessible only through the HTTP protocol.
	This means that the cookie won't be accessible by scripting languages, such
	as JavaScript. This setting can effectively help to reduce identity theft
	through XSS attacks (although it is not supported by all browsers)
	*/
	'httponly' => true,
	'samesite' => 'strict',
	'secure' => true
);

$cookie->set($node,
	1,
	$cookieOptions
);

$toastId = 'thisToast' . $module->id;
//var myToastEl = document.getElementById('myToast')
?>
<?php
/* echo LayoutHelper::render('ghsvs.moduleColDiv.start', array(
	'module' => $module,
	'params' => $params,
	'prependClass' => '',
	'attribs' => '',
)); */
?>
<div id="<?php echo $toastId; ?>" role="status" class="toast"
	data-bs-autohide="false">
  <div class="toast-header">
		<strong class="me-auto"><?php echo Text::_('SINFOTPL_WIP_LBL'); ?></strong>
		<?php echo LayoutHelper::render('ghsvs.closeButtonTop',
			array('options' => ['dismissType' => 'toast'])); ?>
  </div>
  <div class="toast-body">
    <?php echo Text::_('SINFOTPL_WIP_TXT'); ?>
  </div>
</div>
<?php #echo LayoutHelper::render('ghsvs.moduleColDiv.end'); ?>
<?php
$js = <<< JS
document.addEventListener("DOMContentLoaded", function() {
var $toastId = new bootstrap.Toast("#$toastId");
$toastId.show();
});
JS;

Factory::getApplication()->getDocument()->addScriptDeclaration($js);
