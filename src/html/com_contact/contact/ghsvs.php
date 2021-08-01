<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<div class="contact<?php echo $this->pageclass_sfx?>">
	<?php
	echo HTMLHelper::_('bs3ghsvs.layout',
		'ghsvs.page_heading',
		array('params' => $this->params)
	);
	?>
	<div class="item-page div4hyphens">
		<?php if ($this->contact->name && $this->params->get('show_name'))
		{ ?>
		<div class="page-header">
			<h2><?php echo $this->contact->name; ?>
			<?php if ($this->contact->con_position && $this->params->get('show_position'))
			{ ?>
			<span class="articlesubtitle"><?php echo $this->contact->con_position; ?></span>
			<?php
			} ?>
			</h2>
			<?php
			if ($this->contact->image)
			{ ?>
			<div class="contact-image mt-4">
			<?php echo HTMLHelper::_('image',
				$this->contact->image,
				Text::_('COM_CONTACT_IMAGE_DETAILS'),
				array('align' => 'middle')
			); ?>
			</div>
			<?php
			} ?>
		</div><!--/page-header-->
		<?php
		} ?>

		<div class="articleBody">
			<?php if ($this->contact->misc && $this->item->params->get('show_misc'))
			{ ?>
			<div class="contact-miscinfo">
				<?php echo $this->contact->misc; ?>
			</div>
			<?php
			} ?>

			<?php
			$headingTagGhsvs = $this->params->get('headingTagGhsvs', 'div');
			$i = 1;
			$selector = $dataParent = 'pagebreakghsvs' . $this->item->id;
			$class = 'system-pagebreak';

			echo HTMLHelper::_(
				'bootstrap.startAccordion',
				$selector,
				array(
					// Damit mehrere geöffnet werden können auf FALSE!
					'parent' => false
				)
			); ?>
			<?php
			echo HTMLHelper::_('bootstrap.addSlide',
				$selector,
				Text::_('COM_CONTACT_DETAILS'), // $text
				$selector . '-' . $i, // $id
				$class,
				$headingTagGhsvs,
				Text::_('COM_CONTACT_CONTACT_VIEW_GHSVS_ALT_HEADLINE_1') // $title
			); ?>
				<?php	if ($this->contact->email_to && $this->params->get('show_email'))
				{ ?>
				<h3><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_EMAIL'); ?></h3>
				<p><?php echo $this->contact->email_to; ?></p>
				<?php
				} ?>

				<?php	if ($this->contact->telephone)
				{ ?>
				<h3><?php echo Text::_('COM_CONTACT_TELEPHONE'); ?></h3>
				<p><?php echo $this->contact->telephone; ?></p>
				<?php
				} ?>

				<?php	if ($this->contact->fax)
				{ ?>
				<h3><?php echo Text::_('COM_CONTACT_FAX'); ?></h3>
				<p><?php echo $this->contact->fax; ?></p>
				<?php
				} ?>

				<?php	if ($this->contact->address)
				{ ?>
				<h3><?php echo Text::_('COM_CONTACT_CONTACT_VIEW_GHSVS_POST-ADRESSE'); ?></h3>
				<p><?php echo nl2br($this->contact->address); ?></p>
				<?php
				} ?>

				<h3><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_VCARD'); ?></h3>
				<p>
					<a class="btn btn-primary" href="<?php echo Route::_('index.php?option=com_contact&amp;view=contact&amp;id=' . $this->contact->id . '&amp;format=vcf'); ?>">{svg{solid/download}}
						<span class="sr-only"><?php echo Text::_('PLG_SYSTEM_BS3GHSVS_VCARD_DOWNLOAD'); ?></span>
					</a>
				</p>

			<?php echo HTMLHelper::_('bootstrap.endSlide');?>

			<?php
			$i++;
			$href = $selector.'-'.$i;
			$class = 'system-pagebreak';
			$alt = Text::_('PLG_SYSTEM_BS3GHSVS_SEND_EMAIL');
			echo HTMLHelper::_('bootstrap.addSlide',
				$selector,
				Text::_('COM_CONTACT_EMAIL_FORM'),
				$href,
				$class,
				$headingTagGhsvs,
				$alt
			); ?>
				<?php  echo $this->loadTemplate('form');  ?>
			<?php echo HTMLHelper::_('bootstrap.endSlide');?>
			<?php echo HTMLHelper::_('bootstrap.endAccordion');?>
		</div><!--/articleBody-->
		<?php
		// Aktive Slides öffnen bzw. bei Klick Status in Session schreiben.
		//echo HTMLHelper::_('bs3ghsvs.activeToSession', $selector);
		?>
	</div><!--/item-page-->
</div><!--/contact<?php echo $this->pageclass_sfx?>-->
