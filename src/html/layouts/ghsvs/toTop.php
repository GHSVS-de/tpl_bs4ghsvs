<?php
\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->usePreset('template.' . $displayData['template'] . '.toTop');

// Auf mehrseitigen Blogansichten wechselt sonst die Seite.
$uri = Uri::getInstance()->toString();
?>
<a href="<?php echo $uri; ?>#TOP" class="btnsss btn-lightsss" id="toTop" tabindex="-1">
	<span class="visually-hidden">
		<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_TO_TOP'); ?>
	</span>
	{svg{bi/arrow-up-circle}class="bg-whitesss"}</a>

<!--/ arrow-up-square arrow-up-->
