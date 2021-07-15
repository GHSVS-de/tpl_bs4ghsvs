<?php
defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Text;

$description = Text::_($params->get('text'));
$button_text = Text::_($params->get('label'));
?>
<?php
/* echo LayoutHelper::render('ghsvs.moduleColDiv.start', array(
	'module' => $module,
	'params' => $params,
	'prependClass' => '',
)); */
?>
<form action="<?php echo Route::_('index.php'); ?>" method="post" class="mb-3"
	role="search">
	<div class="input-group">
		<input type="search" class="form-control" name="searchword"
			id="mod-search-searchword<?php echo $module->id; ?>"
			aria-label="<?php echo $description; ?>"
			aria-describedby="button<?php echo $module->id; ?>"
			placeholder="<?php echo $description; ?>">
		<button type="submit" class="btn btn-danger"
			id="button<?php echo $module->id; ?>"
			onclick="this.form.searchword.focus();">
			{svg{bi/search}}
			<span class="visually-hidden"><?php echo $button_text; ?></span>
		</button>
	</div>
	<input type="hidden" name="task" value="search" />
	<input type="hidden" name="option" value="com_search" />
	<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
</form>
<?php #echo LayoutHelper::render('ghsvs.moduleColDiv.end'); ?>
