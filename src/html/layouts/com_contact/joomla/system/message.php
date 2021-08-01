<?php
/*
Kontaktformular soll Message in Modal-PopUp ausgeben.
*/

defined('JPATH_BASE') or die;

use Joomla\CMS\Layout\LayoutHelper;

$msgList = $displayData['msgList'];
#JHtml::_('behavior.modal', 'modalxxx', array('show' => true));
?>
<style>
div.modalxxx {
 background-color: transparent;
 border-radius: 6px;
 left: 50%;
 margin-left: -40%;
 position: fixed;
 top: 5%;
 width: 80%;
 z-index: 1050;
}
div.modalxxx .alert{
	margin-bottom:0;
	border:1px solid red;
}
div.modalxxx .close{
	opacity:1;
	font-size:28px;
	color:red;
	background-color:#fff;
}
</style>
<div id="system-message-container" class="modalxxx">
	<?php if (is_array($msgList) && !empty($msgList)) : ?>
		<div id="system-message">
			<?php foreach ($msgList as $type => $msgs) : ?>
				<div class="alert alert-<?php echo $type; ?>">
					<!-- <a class="btn-close" data-bs-dismiss="alert">×</a> -->
					<?php
					echo LayoutHelper::render('ghsvs.closeButtonTop',
						['options' => ['dismissType' => 'alert']]); ?>
					<?php if (!empty($msgs)) : ?>
						<h4 class="alert-heading"><?php echo JText::_($type); ?></h4>
						<div>
							<?php foreach ($msgs as $msg) : ?>
								<div class="alert-message"><?php echo $msg; ?></div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
