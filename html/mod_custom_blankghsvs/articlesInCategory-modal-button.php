<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\ApplicationHelper;

$view = Factory::getApplication()->input->get('view');
$views = array('article', 'category');

// Wenn empty($list) kommen wir hier gar nicht an. Muss also nicht prüfen.
if (!in_array($view, $views))
{
	return '';
}

// To calculate a unique id for both participating modules (button and modal) we need a
// identical base in both modules.
JLoader::register('Bs3ghsvsArticle', JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ArticleHelper.php');
$id = Bs3ghsvsArticle::buildUniqueIdFromJinput('articlesInCategoryModal');

$buttonTitle = $module->showtitle ? $module->title
	: ($view === 'article'
	? 'PLG_SYSTEM_BS3GHSVS_ARTICLES_IN_CATEGORY' : 'PLG_SYSTEM_BS3GHSVS_ARTICLES_IN_CATEGORY_CHANGE');
$buttonTitle = Text::_($buttonTitle);
?>
<div>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $id; ?>">
	<?php echo $buttonTitle; ?>
	{svg{bi/caret-up-fill}}
</button>
</div>
