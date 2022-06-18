<?php
defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

$this->_scripts = $this->_styleSheets = $this->_script = $this->_style = $this->_script = $this->_custom = $this->_scriptText = [];
$this->link = '';
$this->setMetadata('robots', 'noindex,nofollow');
$this->addStyleSheet(Uri::root() . 'templates/' . $this->template . '/css/template.min.css');
$this->addStyleSheet(Uri::root() . 'templates/' . $this->template . '/css/print.min.css');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<jdoc:include type="head" />
</head>
<body class="bodyPrint ausdruck">
 <p class="printintro text-monospace">
  - <?php echo Uri::root(); ?>, <?php echo date('Y-m-d'); ?><br />
  - <?php echo Uri::current(); ?><br />
  - <?php echo $this->title; ?>
 </p>
	<jdoc:include type="component" />
</body>
</html>
