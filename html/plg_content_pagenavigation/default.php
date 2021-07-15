<?php
defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$lengthLimit = 50;

HTMLHelper::_('bs3ghsvs.addsprungmarke', '.pager.page-nav');
?>
<nav class="pager page-nav"
	aria-label="<?php echo Text::_('PLG_SYSTEM_BS3GHSVS_PREVIOUS_NEXT_ARTICLE_NAVIGATION'); ?>">
	<div class="row align-items-center justify-content-between">
		<div class="col-auto">
			<?php
			if ($row->prev)
			{
				$Title = $rows[$location - 1]->title;
				$showSrOnly = $Title != $row->prev_label;
			?>
			<a class="btn btn-warning my-1 text-start" href="<?php echo $row->prev; ?>" rel="prev"
				title="<?php echo htmlspecialchars($Title); ?>">
				<?php
				if ($showSrOnly)
				{ ?>
				<span class="sr-only">
					<?php echo Text::sprintf('JPREVIOUS_TITLE', htmlspecialchars($Title)); ?>
				</span>
				<?php
				} ?>
				{svg{bi/skip-backward-fill}}
				<span<?php echo ($showSrOnly ? ' aria-hidden="true"' : ''); ?> class="articleLabel">
					<?php echo HTMLHelper::_('string.truncate', $row->prev_label, $lengthLimit, false); ?>
				</span>
			</a>
			<?php
			} ?>
		</div>
		<div class="col-auto ml-auto">
			<?php
			if ($row->next)
			{
				$Title = $rows[$location + 1]->title;
				$showSrOnly = $Title != $row->next_label;
			?>
			<a class="btn btn-warning my-1 text-right" href="<?php echo $row->next; ?>" rel="next"
					title="<?php echo htmlspecialchars($Title); ?>">
				<?php
				if ($showSrOnly)
				{ ?>
				<span class="sr-only">
					<?php echo Text::sprintf('JNEXT_TITLE', htmlspecialchars($Title)); ?>
				</span>
				<?php
				} ?>
				<span<?php echo ($showSrOnly ? ' aria-hidden="true"' : ''); ?> class="articleLabel">
					<?php echo HTMLHelper::_('string.truncate', $row->next_label, $lengthLimit, false); ?>
				</span>
				{svg{bi/skip-forward-fill}}
			</a>
			<?php
			} ?>
		</div>
	</div>
</nav>
