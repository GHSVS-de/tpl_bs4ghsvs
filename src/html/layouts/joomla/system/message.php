<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
?>
<!--BC shit for JS-Alerts via core.js-->
<div id="system-message-container" class="modalFallback"></div>
<?php
$msgList = $displayData['msgList'];

if (!is_array($msgList) || !$msgList)
{
	return;
}

$alerts = array
(
	'error' => 'danger',
	'message' => 'light',
	'notice' => 'info',
	'warning' => 'warning',
	'warn' => 'warning',
	'success' => 'success'
);

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
						$class = isset($alerts[$type]) ? $alerts[$type] : 'dark';
					?>
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
var messageQueueModal = new bootstrap.Modal('#messageQueue');
messageQueueModal.show();
</script>
