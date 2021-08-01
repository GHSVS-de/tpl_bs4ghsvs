<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$jinput = Factory::getApplication()->input;
$views = array('article', 'category');

// Wenn empty($list) kommen wir hier gar nicht an. Muss also nicht prüfen.
if (!in_array($jinput->get('view'), $views))
{
	return '';
}

// To calculate a unique id for both participating modules (button and modal) we need a
// identical base in both modules.
$id = 'articlesCategoryPanel-' . md5(json_encode((array) $jinput));

$buttonTitle = $module->showtitle ? $module->title : 'PLG_SYSTEM_BS3GHSVS_ARTICLES_IN_CATEGORY';
$buttonTitle = Text::_($buttonTitle);
?>
<button type="button" class="btn btn-link btn-smsss btn-defaultsss" data-bs-toggle="modal" data-bs-target="#<?php echo $id; ?>">
	{svg{bi/caret-up-fill}}
	<?php echo $buttonTitle; ?>
</button>
