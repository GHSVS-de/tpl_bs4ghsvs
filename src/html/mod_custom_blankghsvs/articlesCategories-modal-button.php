<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/' . basename(__FILE__) . '-->' . PHP_EOL;

$jinput = Factory::getApplication()->input;
$views = ['article', 'category'];

// Wenn empty($list) kommen wir hier gar nicht an. Muss also nicht prüfen.
if (!in_array($jinput->get('view'), $views))
{
	return '';
}

// To calculate a unique id for both participating modules (button and modal) we need a
// identical base in both modules.
JLoader::register('Bs3ghsvsArticle', JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ArticleHelper.php');
$id = Bs3ghsvsArticle::buildUniqueIdFromJinput('articlesCategoriesModal');

$buttonTitle = $module->showtitle ? $module->title : 'PLG_SYSTEM_BS3GHSVS_CHANGE_CATEGORY';
$buttonTitle = Text::_($buttonTitle);
?>
<div>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $id; ?>">
	<?php echo $buttonTitle; ?>
	{svg{bi/caret-up-fill}}
</button>
</div>
