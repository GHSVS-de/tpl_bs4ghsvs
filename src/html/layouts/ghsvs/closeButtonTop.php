<?php
/*
<?php echo LayoutHelper::render('ghsvs.closeButtonTop', $options); ?>
*/
defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

$options = new Registry (isset($displayData['options']) ? $displayData['options']
	: []);
$dismissType = $options->get('dismissType', 'modal');
$class = $options->get('class', '');
?>
<button type="button" class="btn-close <?php echo $class; ?>"
	data-bs-dismiss="<?php echo $dismissType; ?>"
	aria-label="<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_CLOSE'); ?>">
	{svg{bi/x-circle-fill}class="text-danger"}
</button>
