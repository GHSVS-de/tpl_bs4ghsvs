<?php
defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

$options = new Registry(isset($displayData['options']) ? $displayData['options']
	: []);
$dismissType = $options->get('dismissType', 'modal');
?>
<button type="button" class="btn btn-secondary"
	data-bs-dismiss="<?php echo $dismissType; ?>">
<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_CLOSE'); ?>
</button>
