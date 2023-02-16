<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

$app = Factory::getApplication();
$params = $app->getTemplate(true)->params;

if (($erroremail = $params->get('erroremail', '')))
{
	if ($erroremail == 'fromEmail')
	{
		$erroremail = trim($app->get('mailfrom', ''));
	}
	else
	{
		$erroremail = trim($params->get('erroremail_email', ''));
	}
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $this->error->getCode(); ?> - <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
		<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/error.css" rel="stylesheet" />
<script src="/media/system/js/core.min.js"></script>
<script src="/media/vendor/webcomponentsjs/js/webcomponents-bundle.min.js" nomodule defer></script>
<script src="/media/system/js/joomla-hidden-mail-es5.min.js" nomodule></script>
	<script src="/media/system/js/joomla-hidden-mail.min.js" type="module"></script>
	</head>
	<body>
		<div class="error">
			<div id="outline">
				<div id="errorboxoutline">

					<div id="errorboxheader">
						<p><strong>
							<?php
							$ownStr = 'GHSVS_ERROR_LAYOUT_NOT_ABLE_TO_VISIT';

							// not translated?
							if (Text::_($ownStr) === $ownStr)
							{
								$ownStr = 'JERROR_LAYOUT_NOT_ABLE_TO_VISIT';
							}

							echo Text::_($ownStr);
							?>
						</strong></p>

						<p class="errorMessage">
							<?php echo $this->error->getCode(); ?>
							-
							<?php echo htmlspecialchars(
								$this->error->getMessage(),
								ENT_COMPAT,
								'UTF-8'
							); ?>
						</p>
					</div><!--/#errorboxheader-->

					<div id="errorboxbody">
						<p><strong>
							<?php
							$ownStr = 'GHSVS_ERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES';

							// not translated?
							if (Text::_($ownStr) === $ownStr)
							{
								$ownStr = 'JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES';
							}

							echo Text::sprintf($ownStr, JUri::root());
							?>
							<br>
							<a href="<?php echo JUri::root(); ?>"
								title="<?php echo Text::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>">
								<?php echo Text::_('JERROR_LAYOUT_HOME_PAGE'); ?>
							</a>
						</strong></p>

						<p>
							<?php
							$ownStr = 'GHSVS_ERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR';

							// not translated?
							if (Text::_($ownStr) === $ownStr)
							{
								$ownStr = 'JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR';
							}

							echo Text::sprintf(
								$ownStr,
								Uri::getInstance()->toString(),
								($erroremail ? HTMLHelper::_('email.cloak', $erroremail) : '')
							);
							?>
						</p>

						<div id="techinfo">
							<?php if ($this->debug) : ?>
							<div>
								<p>&nbsp;</p>
								<p><strong>Debug:</strong><br></p>
								<p>
									<?php echo $this->error->getCode(); ?>
									-
									<?php echo htmlspecialchars(
								$this->error->getMessage(),
								ENT_QUOTES,
								'UTF-8'
							); ?>
								</p>

								<?php echo $this->renderBacktrace(); ?>

								<?php // Check if there are more Exceptions and render their data as well ?>
								<?php if ($this->error->getPrevious()) : ?>
									<?php $loop = true; ?>
									<?php // Reference $this->_error here and in the loop as setError() assigns errors to this property and we need this for the backtrace to work correctly ?>
									<?php // Make the first assignment to setError() outside the loop so the loop does not skip Exceptions ?>
									<?php $this->setError($this->_error->getPrevious()); ?>
									<?php while ($loop === true) : ?>
										<p><strong>
											<?php echo Text::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?>
										</strong></p>
										<p>
											<?php echo htmlspecialchars(
											$this->_error->getMessage(),
											ENT_QUOTES,
											'UTF-8'
										); ?>
										</p>
										<?php echo $this->renderBacktrace(); ?>
										<?php $loop = $this->setError($this->_error->getPrevious()); ?>
									<?php endwhile; ?>
									<?php // Reset the main error object to the base error ?>
									<?php $this->setError($this->error); ?>
								<?php endif; ?>
								<p>&nbsp;</p>
							</div>
							<?php endif; ?>
						</div><!--/#techinfo-->
					</div><!--/#errorboxbody-->
				</div><!--/#errorboxoutline-->
			</div><!--/#outline-->
		</div><!--/.error-->
		<jdoc:include type="modules" name="debug" style="none" />
	</body>
</html>
