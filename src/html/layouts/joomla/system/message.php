<?php
defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

use Joomla\CMS\Layout\LayoutHelper;

if (version_compare(JVERSION, '4', 'ge'))
{
	/* @var $displayData array */
	$msgList   = $displayData['msgList'];
	$document  = Factory::getDocument();
	$msgOutput = '';
	$alert     = [
		CMSApplication::MSG_EMERGENCY => 'danger',
		CMSApplication::MSG_ALERT     => 'danger',
		CMSApplication::MSG_CRITICAL  => 'danger',
		CMSApplication::MSG_ERROR     => 'danger',
		CMSApplication::MSG_WARNING   => 'warning',
		CMSApplication::MSG_NOTICE    => 'info',
		CMSApplication::MSG_INFO      => 'info',
		CMSApplication::MSG_DEBUG     => 'info',
		'message'                     => 'success',
	];

	// Load JavaScript message titles
	Text::script('ERROR');
	Text::script('MESSAGE');
	Text::script('NOTICE');
	Text::script('WARNING');

	// Load other Javascript message strings
	Text::script('JCLOSE');
	Text::script('JOK');
	Text::script('JOPEN');

	// Alerts progressive enhancement
	$document->getWebAssetManager()
		->useStyle('webcomponent.joomla-alert')
		->useScript('messages');

	if (is_array($msgList) && !empty($msgList))
	{
		$messages = [];

		foreach ($msgList as $type => $msgs)
		{
			// JS loaded messages
			$messages[] = [$alert[$type] ?? $type => $msgs];
			// Noscript fallback
			if (!empty($msgs))
			{
				$msgOutput .= '<div class="alert alert-' . ($alert[$type] ?? $type) . '">';

				foreach ($msgs as $msg) :
					$msgOutput .= $msg;
				endforeach;
				$msgOutput .= '</div>';
			}
		}

		if ($msgOutput !== '')
		{
			$msgOutput = '<noscript>' . $msgOutput . '</noscript>';
		}

		$document->addScriptOptions('joomla.messages', $messages);
	} ?>

	<div id="system-message-container" class="fixed-top" aria-live="polite"><?php echo $msgOutput; ?></div>
<?php
}
elseif (version_compare(JVERSION, '4', 'lt'))
{ ?>
	<div id="system-message-container" class="modalFallback"></div>
	<?php
	$msgList = $displayData['msgList'];

	if (!is_array($msgList) || !$msgList)
	{
		return;
	}

	$alerts = [
		'error' => 'danger',
		'message' => 'dark',
		'notice' => 'info',
		'warning' => 'warning',
		'warn' => 'warning',
		'success' => 'success',
	];

	$cnt = 0;

	foreach ($msgList as $type => $msgs)
	{
		if (!empty($msgs))
		{
			$cnt += count($msgs);
		}
	}

	if ($cnt > 1)
	{
		$messageQueueTitle = Text::sprintf('PLG_SYSTEM_BS3GHSVS_SYSTEM_MESSAGES', $cnt);
	}
	else
	{
		$messageQueueTitle = Text::_('PLG_SYSTEM_BS3GHSVS_SYSTEM_MESSAGE');
	}

	?>
	<div id="messageQueue"
		class="modal fade"
		tabindex="-1"
		role="dialog"
		aria-labelledby="messageQueueTitle"
		aria-hidden="true"
	>
		<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="messageQueueTitle">
						<?php echo $messageQueueTitle; ?>
					</h5>
					<?php echo LayoutHelper::render('ghsvs.closeButtonTop'); ?>
				</div>
				<div class="modal-body container-fluid">
					<?php foreach ($msgList as $type => $msgs)
	{
		if (!empty($msgs))
		{
			$class = isset($alerts[$type]) ? $alerts[$type] : 'dark'; ?>
						<h6 class="h4 border-<?php echo $class; ?> text-<?php echo $class; ?>">
							<?php echo Text::_($type); ?>
						</h6>
						<ol class="alert alert-<?php echo $class; ?> row no-gutter">
							<?php foreach ($msgs as $msg)
							{ ?>
							<li class="singleSystemMessage list-item-inside mb-2">
								<?php echo $msg; ?>
							</li>
							<?php
							} ?>
						</ol>
						<?php
		} ?>
					<?php
	} ?>
				</div>
				<div class="modal-footer">
					<?php echo LayoutHelper::render('ghsvs.closeButton'); ?>
				</div>
			</div>
		</div>
	</div>

	<script>
	document.addEventListener('DOMContentLoaded', () => {
		var messageQueueModal = new bootstrap.Modal('#messageQueue');
		messageQueueModal.show();
	});
	</script>
	<!--/See also loading of  core-mine.js in index.php-->
<?php
}
