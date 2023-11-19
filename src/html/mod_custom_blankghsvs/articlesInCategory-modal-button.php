<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

// @since 2023-11
use GHSVS\Plugin\System\Bs3Ghsvs\Helper\Bs3GhsvsArticleHelper as Bs3ghsvsArticle;

$view = Factory::getApplication()->input->get('view');
$views = ['article', 'category'];

// Wenn empty($list) kommen wir hier gar nicht an. Muss also nicht prüfen.
if (!in_array($view, $views))
{
	return '';
}

// To calculate a unique id for both participating modules (button and modal) we need a
// identical base in both modules.
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
