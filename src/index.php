<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Uri\Uri;

if (!class_exists('PlgSystemBS3Ghsvs', false))
{
	throw new \InvalidArgumentException('Class "PlgSystemBS3Ghsvs" not found. Please install and/or activate plugin "PLG_SYSTEM_BS3GHSVS" to use this template.');
}

$isRobot = $this->params->get('isRobot', false);
$wa = PlgSystemBS3Ghsvs::getWa();

if ($done = PluginHelper::isEnabled('system', 'astroidghsvs'))
{
	/*
	 * OPTIONAL possibility to override all or some parameters of
	 *  AstroidGhsvsHelper::$compileSettingsDefault (= Settings of plg__astroidghsvs).
	 * But you don't have to! Leave array empty or remove if you like default
	 * 	settings.
	 * Heads up! The Helper does not protect you in the case of incorrect
	 * 	entries like wrong folders or so.
	 */
	AstroidGhsvsHelper::$compileSettingsCustom = [
		// 'sourceMaps' => false,
		// 'scssFolder' => 'scss-ghsvs',
		// ## Needs AstroidGhsvsHelper::$replaceThis comment in template index.php:
		'placeHolderMode' => false,
		// ## Set to -1 if you want to disable compiling completely.
		//'forceSCSSCompilingGhsvs' => 0,
		//'includeStyleId' => true,
	];

	if ($isRobot)
	{
		AstroidGhsvsHelper::$compileSettingsCustom = [
			'forceSCSSCompilingGhsvs' => -2,
		];
	}
	else
	{
		/*
		These scss files (enter without extension!) must be in scss folder of
		this template (see parameter 'scssFolder' (default: 'scss-ghsvs'))!
		Only 'template' will include Astroid variables automatically. Others not.
			(See parameter 'mainCssName' (default: 'template')).
		'template' will compile 'scss-ghsvs/template.scss' to 'css/template.css'
		and 'css/template.min.css'
		and according sourcemap files if activated (see parameter 'sourceMaps'
		(default: false)).
		The resulting CSS files will be included in the template if not marked
		with a '|noInsert'. See
		Der Befehl zum Kompilieren wird in einem System-Plugin in
		"public function onAfterAstroidRender()" abgefeuert.
		*/
		AstroidGhsvsHelper::$filesToCompile = [
			'editorghsvs|noInsert',
			'editor-inserttagsghsvs|noInsert',
			'editor-prism|noInsert',
			'print|noInsert',
			'prism-ghsvs|noInsert',
			// JQuery free Venobox 2 doesn't need that anymore.
			// 'venobox|noInsert',
			'template',
		];

		/* Because this is a non-Astroid template the plugin method
		onAfterAstroidRender() is not fired. Therefore: */
		AstroidGhsvsHelper::runScssGhsvs('');
	}
}

// Don't show header after x pages seen. A BODY CSS class.
$HidePageHeader = '';

if (!$isRobot && $this->params->get('HidePageHeader', ''))
{
	$node = 'HidePageHeader';
	$dontShowAfter = $this->params->get('HidePageHeaderAfter', 5);
	$session = Factory::getSession();
	$sessionData = (int) $session->get($node);

	if ($sessionData >= $dontShowAfter)
	{
		$HidePageHeader = $node;
	}
	else
	{
		$sessionData++;
		$session->set($node, $sessionData);
	}
}

// Set by Http-Header-plugin?
if ($nonce = Factory::getApplication()->get('csp_nonce', ''))
{
	$nonce = ' nonce="' . $nonce . '"';
}

$this->setHtml5(true);
$this->setMetaData('viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no');

// Uses WAM if J4..
HTMLHelper::_('bs3ghsvs.templatejs');

####START - LOGO, SEITENTITEL, SITEDESCRIPTION.
$sitetitleHide = $this->params->get('sitetitleHide', 0);
$logo = $this->params->get('logoimg', '');
$sitetitle = '';

if ($sitetitleHide !== -1)
{
	$sitetitle = $this->params->get('sitetitle');
	$class = 'site-title';

	if ($logo || $sitetitleHide === 1)
	{
		$class .= ' visually-hidden';
	}

	$sitetitle = '<h1 class="' . $class . '">' . $sitetitle . '</h1>';
}

if ($sitedescription = $this->params->get('sitedescription', ''))
{
	$sitedescription = '<div class="site-description">' . $sitedescription . '</div>';
}

$logo = $sitetitle . $logo . $sitedescription;
####ENDE - LOGO, SEITENTITEL, SITEDESCRIPTION, SITENAME

$BodyClasses = $this->params->get('BodyClasses', [], 'array');

if ($HidePageHeader !== '')
{
	$BodyClasses[] = $HidePageHeader;
}

$BodyClasses = trim(implode(' ', $BodyClasses));

/*
Search for "stickyCompensation" for answer what this is about!
The dummy content is mandatory when JCH is used.
*/
if ($wa)
{
	// WAM sets $nonce.
	$wa->useStyle('template.stickyCompensation')
		->useScript('template.js')
		->usePreset('template.custom');
}
else
{
	$this->addCustomTag('<style' . $nonce . ' type="text/css" id="stickyCompensation">.dummyByGhsvs{cursor: default};</style>');

	$loadAssets = [
		'js' =>
			[
				'templates/' . $this->template . '/js/template.min.js',
				'templates/' . $this->template . '/js/custom.js',
				// Needed for JLayout messages.php JavaScript part. Don't use HTMLHelper!
				'templates/' . $this->template . '/js/core-mine.min.js'
			],
		'css' =>
			[
				'templates/' . $this->template . '/css/custom.css',
			],
		'nonce' => $nonce
	];
}
?>
<!DOCTYPE html>
<html class="no-js jsNotActive" lang="<?php echo $this->language; ?>"
	dir="<?php echo $this->direction; ?>">
<head>
	<script<?php echo $nonce; ?>>
		JURIROOT = "<?php echo Uri::root(true)?>"; //No var! "super-global"
		JURIROOT2 = "<?php echo Uri::root()?>"; //No var! "super-global"
		HidePageHeader = <?php echo (int) $HidePageHeader; ?>;
	</script>
	<jdoc:include type="head" />
	<?php echo LayoutHelper::render('ghsvs.favicons'); ?>
</head>
<body class="<?php echo $BodyClasses; ?> pb-4rem" id="TOP">
<div id="mainBackground">
	<div id="div4all">
		<header id="CfHeader" class="cf-outer">
			<div class="cf-inner">
				<div class="container-fluid CfHeader pt-1">
					<div class="row">
						<?php
						$cols = $this->countModules('teaser') ? '-sm-6' : '';
						?>
						<?php
						if ($logo)
						{ ?>
						<div class="col<?php echo $cols; ?> text-center text-sm-start mb-3
							mb-sm-0">
							<a href="<?php echo Uri::root(); ?>"><?php echo $logo?></a>
						</div>
						<?php
						} ?>
						<?php
						if ($cols)
						{ ?>
						<div class="col<?php echo $cols; ?> text-center text-sm-end mb-sm-0 div4headteaser">
							<jdoc:include type="modules" name="teaser" style="none"/>
						</div>
						<?php
						} ?>
					</div>
				</div><!--/CfHeader-->
			</div><!--/cf-inner-->
		</header><!--/cf-outer-->

		<a name="BELOWHEADER" id="BELOWHEADER" class="BELOWHEADER"></a>

		<?php if ($this->countModules('menue-oben-bs'))
		{ ?>
		<div id="CfMenueOben">
			<div class="cf-inner">
				<jdoc:include type="modules" name="menue-oben-bs" style="none" />
			</div><!--/cf-inner-->
		</div><!--/#CfMenueOben-->
		<?php
		} ?>
		<?php
		// Bspw. Toasts
		if ($this->countModules('toasts'))
		{ ?>
		<div id="CfToasts" class="container-fluid">
				<jdoc:include type="modules" name="toasts" style="none" />
		</div><!--/#CfToasts-->
		<?php
		} ?>
		<a name="ABOVEBUTTONGRUPPE" id="ABOVEBUTTONGRUPPE"
			class="ABOVEBUTTONGRUPPE"></a>
		<?php
		if ($this->countModules('buttonGruppe'))
		{ ?>
		<div id="CfButtonGruppe" class="container-fluid sticky-top">
			<div class="cf-inner d-flex justify-content-around flex-wrap">
				<jdoc:include type="modules" name="buttonGruppe" style="none" />
			</div>
		</div><!--/#CfButtonGruppe-->
		<?php
		} ?>

		<?php if ($this->countModules('breadcrumb-bs'))
		{ ?>
		<div id="CfBreadcrumb" class="container-fluid">
			<div class="cf-inner d-flex flex-wrap justify-content-between
				align-items-center">
				<jdoc:include type="modules" name="breadcrumb-bs" style="none" />
			</div>
		</div><!--/#CfBreadcrumb-->
		<?php
		} ?>

		<?php // damit ich Main und Module darunter außen z.B. padden kann ?>
		<div id="div4mainPadder" class="container">
			<?php /* Für Sonderfälle, wo auch Modulposition mit erfasst werden soll.
			Bspw. auf der Sitemap-Seite */ ?>
			<div class="TOC_GHSVS_SPECIAL">

				<div id="CfMain" class="cf-outer mt-2 mt-md-4">
					<div class="CfMain containersssssss">
						<div class="CfMainInner cf-inner">
							<div class="row">
								<main id="content">
									<jdoc:include type="component" />
								</main>
							</div>
						</div><!--/cf-inner-->
					</div><!--/CfMain-->
				</div><!--/#CfMain cf-outer-->

				<?php if ($this->countModules('unter-component'))
				{ ?>
				<div id="CfUnterComponent">
					<div class="cf-inner">
						<jdoc:include type="modules" name="unter-component" style="none" />
					</div><!--/cf-inner-->
				</div><!--/#CfUnterComponent-->
				<?php
				} ?>

			</div><!--/TOC_GHSVS_SPECIAL-->

				<?php if ($this->countModules('unter-main-bs'))
				{ ?>
				<div id="CfUnterMain" class="cf-outer mb-3">
					<div class="cf-inner">
						<div class="CfUnterMain container-fluidsssssssssss">
							<div class="row">
								<jdoc:include type="modules" name="unter-main-bs" style="none" />
							</div>
						</div><!--/CfUnterMain-->
					</div><!--/cf-inner-->
				</div><!--/cf-outer-->
				<?php
				} ?>
		</div><!--/div4mainPadder-->

		<?php
		if ($this->countModules('footer-bs') || $this->countModules('copyright-bs'))
		{ ?>
		<footer class="footer">
			<?php
			if ($this->countModules('footer-bs'))
			{ ?>
			<div id="CfFooter" class="cf-outer bg-light">
				<div class="CfFooterInner cf-inner">
					<div class="CfFooter container-fluid">
						<div class="row">
							<jdoc:include type="modules" name="footer-bs" style="none" />
						</div>
					</div><!--/CfFooter-->
				</div><!--/cf-inner-->
			</div><!--/#CfFooter cf-outer-->
			<?php
			}?>

			<?php
			if ($this->countModules('copyright-bs'))
			{ ?>
			<div id="CfCopyright" class="cf-outer py-2">
				<div class="CfCopyrightInner cf-inner">
					<div class="CfCopyright container-fluid">
						<div class="row">
							<jdoc:include type="modules" name="copyright-bs" style="none" />
						</div>
					</div><!--/CfCopyright-->
				</div><!--/cf-inner-->
			</div><!--/#CfCopyright cf-outer-->
			<?php
			}?>
		</footer>
		<?php
		}?>
	</div><!--/#div4all-->

		<?php if (!$isRobot)
		{
			// Uses WAM if J4..
			echo HTMLHelper::_('bs3ghsvs.toTop');
		} ?>

		<?php
		if (!$isRobot)
		{ ?>
		<div id="noscriptdiv" role="alert" aria-hidden="true">
			<?php echo Text::_('TPL_WOHNMICHL_ACTIVATE_JAVASCRIPT');?>
		</div>
		<jdoc:include type="modules" name="modal-content" style="none" />
		<jdoc:include type="message" />
		<jdoc:include type="modules" name="debug" style="none" />
		<?php
		} ?>
	</div><!--/mainBackground-->
	<div id="BOTTOM"></div>
	<!--ghsvs.assets-->
	<?php
	if (!$wa)
	{
		echo LayoutHelper::render('ghsvs.assets', $loadAssets);
	} ?>
	<!--/ghsvs.assets-->
 </body>
</html>
