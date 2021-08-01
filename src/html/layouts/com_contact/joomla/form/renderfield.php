<?php
/**
 * Template override-override for com_contact form. Bootstrap 3.
 */
defined('_JEXEC') or die;

use Joomla\CMS\Utility\Utility;

extract($displayData);

/**
 * Layout variables
 * ---------------------
 * 	$options         : (array)  Optional parameters
 * 	$label           : (string) The html code for the label (not required if $options['hiddenLabel'] is true)
 * 	$input           : (string) The input field html code
 */

if (!empty($options['showonEnabled']))
{
	JHtml::_('jquery.framework');
	JHtml::_('script', 'jui/cms.js', array('version' => 'auto', 'relative' => true));
}

$class = empty($options['class']) ? '' : ' ' . $options['class'];
$rel   = empty($options['rel']) ? '' : ' ' . $options['rel'];

/**
 * @TODO:
 *
 * As mentioned in #8473 (https://github.com/joomla/joomla-cms/pull/8473), ...
 * as long as we cannot access the field properties properly, this seems to
 * be the way to go for now.
 *
 * On a side note: Parsing html is seldom a good idea.
 * https://stackoverflow.com/questions/1732348/regex-match-open-tags-except-xhtml-self-contained-tags/1732454#1732454
 */
preg_match('/class=\"([^\"]+)\"/i', $input, $match);
$required      = (strpos($input, 'aria-required="true"') !== false || (!empty($match[1]) && strpos($match[1], 'required') !== false));
$typeOfSpacer  = (strpos($label, 'spacer-lbl') !== false);

// GHSVS. In J!4 the above preg_match shit does not exist. Thus cannot use $match[1] any longer.
$inputAttrs = Utility::parseAttributes($input);
$addClass = 'form-control';

if (!isset($inputAttrs['class']))
{
	$input = str_replace('<input ', '<input class="' . $addClass . '"', $input);
}
elseif (strpos($inputAttrs['class'], $addClass) === false)
{
	$input = str_replace(' class="', ' class="' . $addClass . ' ', $input);
}

?>
<div class="form-group<?php echo $class; ?>"<?php echo $rel; ?>>
	<?php if (empty($options['hiddenLabel'])) : ?>
			<?php echo $label; ?>
			<?php if (!$required && !$typeOfSpacer) : ?>
				<span class="optional sr-only"><?php echo JText::_('COM_CONTACT_OPTIONAL'); ?></span>
			<?php endif; ?>
	<?php endif; ?>
	<?php echo $input; ?>
</div>
