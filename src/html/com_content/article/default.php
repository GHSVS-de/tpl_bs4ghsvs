<?php
defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->' . PHP_EOL;

// Unbedingt nötig für Print.
HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

$urls    = json_decode($this->item->urls);
$user    = Factory::getUser();
$isRobot = Factory::getApplication()->client->robot;

/* info_block_position
<option value="0">COM_CONTENT_FIELD_OPTION_ABOVE</option>
<option value="1">COM_CONTENT_FIELD_OPTION_BELOW</option>
<option value="2">COM_CONTENT_FIELD_OPTION_SPLIT</option>
*/
$info = $this->item->params->get('info_block_position', 0);

$useDefList = (
 $this->item->params->get('show_modify_date')
 || $this->item->params->get('show_publish_date')
 || $this->item->params->get('show_create_date')
 || $this->item->params->get('show_category')
 || $this->item->params->get('show_parent_category')
 || $this->item->params->get('show_author')
);

// ''|0|1. Für layout page_heading.php.
$page_heading_article = (string) $this->item->params->get('page_heading_article_ghsvs');

if ($page_heading_article === '1')
{
 $this->params->set('show_page_heading', 1);
}
elseif ($page_heading_article === '0')
{
 $this->params->set('show_page_heading', 0);
}

?>
<?php
#### SEITENÜBERSCHRIFT (Menü)
if ($this->params->get('show_page_heading'))
{
 echo LayoutHelper::render('ghsvs.page_heading',
  [
		'params' => $this->params,
		'bs3ghsvs.rendermodules-position' => ''
	]
 );
}
#### ENDE - SEITENÜBERSCHRIFT (Menü)
?>
<div class="item-page<?php echo $this->pageclass_sfx; ?>">
	<?php if (!$isRobot)
	{
	$rendermodules = HTMLHelper::_('bs3ghsvs.rendermodules',
		'buttonGruppeGhsvs-bs');
	$output = '';

	if ($this->item->params->get('show_print_icon'))
	{
		$printBtnId = 'ARTICLE_PRINT_BTN' . $this->item->id;
		$output = trim(HTMLHelper::_('icon.print_popup',
			$this->item,
			$this->item->params,
			['class' => 'btn btn-success', 'id' => $printBtnId],
			null,
			'print',
			'{svg{bi/printer-fill}}'
		));

		if ($output !== '')
		{
			//https://stackoverflow.com/questions/1279957/how-to-move-an-element-into-another-element
			$js = <<<JS
;(function(){
document.addEventListener('DOMContentLoaded',function(){
// Declare a fragment:
var fragment = document.createDocumentFragment();

// Append desired element to the fragment:
fragment.appendChild(document.getElementById("$printBtnId"));

// Append fragment to desired element:
document.getElementById('PRINTBUTTON_TARGET').appendChild(fragment);
});})();
JS;
			Factory::getDocument()->addScriptDeclaration($js);
		}
	}

	if (($rendermodules = trim($rendermodules)) || $output)
	{
		echo '<div class="buttonGruppeGhsvs">' . $rendermodules . $output
			. '</div>';
	}
	} // !$isRobot ?>

		<article class="itemscope-Article div4hyphens">
			<div class="TOC_GHSVS">
				<?php
				// Weil ich ihn oben schon separat anzeige.
				$this->item->params->set('show_print_icon', false);

				$aricleTitle = HTMLHelper::_('bs3ghsvs.layout',
					'ghsvs.page_header_n_icons',
					['item' => $this->item, 'print' => $this->print]
				);?>

 				<?php if (!$this->item->params->get('show_intro'))
				{
					echo $this->item->event->afterDisplayTitle;
				}

				echo $this->item->event->beforeDisplayContent;

				if ($urls && $this->item->params->get('urls_position') == 0)
				{
				 echo $this->loadTemplate('links');
 				}
				?>
				<?php	if ($this->item->params->get('access-view')):
				?>

					<?php if (isset ($this->item->toc))
					{
						echo $this->item->toc;
					} ?>

				<div class="articleBody">

					<?php
					// Selbst, wenn das irritierend ist, wird so gewährleistet, dass item->text nur den Rest enthält:
					if (!$this->item->params->get('show_intro'))
					{

						$image = trim(LayoutHelper::render('ghsvs.full_image_venobox',
							[
								'item' => $this->item,
								'options' => [
									'classes' => 'col-12 col-md-5 order-first order-md-last text-center text-md-end'
								]
							]
						));

						$introtext = trim($this->item->introtext);

						if ($introtext || $image)
						{ ?>
						<div class="articleIntrotext border bg-modal mb-3 row
							align-items-center">
							<?php echo $aricleTitle; ?>
							<div class="col-12 col-md-<?php echo ($image ? '7' : '12'); ?>">
								<?php echo $this->item->introtext; ?>
							</div>
							<?php echo $image; ?>
						</div>
						<?php
						}
					}

					echo $this->item->text; ?>

				</div><!--/articleBody-->
			</div><!--/TOC_GHSVS -->

			<?php echo HTMLHelper::_('bs3ghsvs.layout', 'ghsvs.extension',
				$this->item->id
			) ?>

			<?php
			// Output of <div class="div4article-info">.
			if (($useDefList && is_numeric($info)) || $this->item->params->get('show_tags', 1))
			{
				echo HTMLHelper::_('bs3ghsvs.layout',
					'ghsvs.tags_n_article-info-combined',
					array(
						'item' => $this->item,
						'params' => $this->item->params,
						'position' => 'below',
						'useDefList' => $useDefList,
					)
				);
			} ?>
		</article><!--/itemscope-Article-->

 <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($this->item->params->get('urls_position') == '1'))) : ?>
 <?php echo $this->loadTemplate('links'); ?>
 <?php endif; ?>

<?php // Optional teaser intro text for guests
elseif ($this->item->params->get('show_noauth') == true && $user->get('guest')) :
?>
 <?php echo $this->item->introtext; ?>
 <?php //Optional link to let them register to see the whole article. ?>
 <?php if ($this->item->params->get('show_readmore') && $this->item->fulltext != null) :
  $link1 = JRoute::_('index.php?option=com_users&view=login');
  $link = new JUri($link1);?>
 <p class="readmore">
  <a href="<?php echo $link; ?>">
  <?php $attribs = json_decode($this->item->attribs); ?>
  <?php
  if ($attribs->alternative_readmore == null) :
   echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE');
  elseif ($readmore = $this->item->alternative_readmore) :
   echo $readmore;
   if ($this->item->params->get('show_readmore_title', 0) != 0) :
    echo HTMLHelper::_('string.truncate', ($this->item->title), $this->item->params->get('readmore_limit'));
   endif;
  elseif ($this->item->params->get('show_readmore_title', 0) == 0) :
   echo Text::sprintf('COM_CONTENT_READ_MORE_TITLE');
  else :
   echo Text::_('COM_CONTENT_READ_MORE');
   echo HTMLHelper::_('string.truncate', ($this->item->title), $this->item->params->get('readmore_limit'));
  endif; ?>
  </a>
 </p>
 <?php endif; ?>
 <?php endif; ?>
	<?php if (!empty($this->item->pagination))
	{ ?>
		<div class="articlePagination below">
		<?php echo $this->item->pagination; ?>
		</div>
	<?php
	} ?>
<?php
// Das führt so leider zu doppelten id="sonstwas". Müsstest also erneut rendern.
if (!$isRobot && $rendermodules)
{
	echo '<div class="buttonGruppeGhsvs mt-3">' . $rendermodules . '</div>';
}
?>
 <?php echo $this->item->event->afterDisplayContent; ?>

</div><!--/item-page<?php echo $this->pageclass_sfx; ?>-->
