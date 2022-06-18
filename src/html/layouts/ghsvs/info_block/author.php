<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

extract($displayData);

/**
 * Layout variables
 * ---------------------
 *
 * @var object  $item  Article
 * @var object  $params  Registry. Of article or module
 */
?>
<dt class="visually-hidden">
	<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_AUTHOR'); ?>
</dt>
<dd class="createdby">
	<?php $author = ($item->created_by_alias ?: $item->author); ?>
	<?php if (!empty($item->contact_link) && $params->get('link_author') == true) : ?>
		<?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $item->contact_link, $author, [])); ?>
	<?php else : ?>
		<?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
	<?php endif; ?>
</dd>
