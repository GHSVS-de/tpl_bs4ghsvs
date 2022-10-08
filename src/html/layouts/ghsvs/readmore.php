<?php
defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$params    = $displayData['params'];
$item      = $displayData['item'];
$direction = Factory::getLanguage()->isRtl() ? 'left' : 'right';
$ignoreAccessView = Factory::getApplication()->input->get('view') === 'categories';

$icon = '{svg{bi/chevron-' . $direction . '}}';

$aClass = 'btn';

?>
<p class="readmore">
	<?php if (!$params->get('access-view') && !$ignoreAccessView) : ?>
		<a class="<?php echo $aClass; ?>" href="<?php echo $displayData['link']; ?>"
			aria-label="<?php echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
			<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
				<?php echo $icon; ?>
				<?php echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
		</a>
		<?php elseif (isset($item->alternative_readmore) && $readmore = $item->alternative_readmore) : ?>
		<a class="<?php echo $aClass; ?>" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
			<?php echo $icon; ?>
			<?php echo $readmore; ?>
			<?php if ($params->get('show_readmore_title', 0) != 0) : ?>
				<?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
			<?php endif; ?>
		</a>
	<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
		<a class="<?php echo $aClass; ?>" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo Text::_('COM_CONTENT_READ_MORE'); ?> <?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
			<?php echo Text::sprintf('TPL_BS4GHSVS_READ_MORE'); ?>
		</a>
	<?php else : ?>
		<a class="<?php echo $aClass; ?>" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo Text::_('COM_CONTENT_READ_MORE'); ?> <?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
			<?php echo $icon; ?>
			<?php echo Text::_('COM_CONTENT_READ_MORE'); ?>
			<?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit', 30)); ?>
		</a>
	<?php endif; ?>
</p>
