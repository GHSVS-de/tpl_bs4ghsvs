<?php
defined('_JEXEC') or die;

$this->_scripts = $this->_styleSheets = $this->_script = $this->_style = $this->_script = $this->_custom = $this->_scriptText = array();
$this->link = '';
$this->setMetadata('robots', 'noindex,nofollow');
$this->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<jdoc:include type="head" />
<!--[if lt IE 9]>
	<script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script>
<![endif]-->
</head>
<body class="bodyPrint ausdruck">
 <p class="printintro text-kursiv">
  - <?php echo JUri::getInstance()->getHost() ?>, <?php echo date('Y-m-d'); ?><br />
  - <?php echo $this->base; ?><br />
  - <?php echo $this->title; ?>
 </p>
	<jdoc:include type="component" />
</body>
</html>
