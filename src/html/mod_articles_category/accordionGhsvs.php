<?php
\defined('_JEXEC') or die;

use Joomla\CMS\Factory;

if (!$list)
{
  return;
}

/* Factory::getApplication()
  ->getDocument()
  ->getWebAssetManager()
  ->useScript('bootstrap.collapse'); */

$id = 'accordionGhsvs-' . $module->id;
?>
<div class="accordion" id="<?php echo $id; ?>">
  <?php
  foreach ($list as $key => $item)
  {
    $itemId = $id . '-' . $key;
  ?>
    <div class="accordion-item mb-1">
      <p class="accordion-header h6 mb-0" id="<?php echo $itemId; ?>Header">
        <button class="accordion-button text-start w-100 btn-warning" type="button" data-bs-toggle="collapse"
          data-bs-target="#<?php echo $itemId; ?>" aria-expanded="false"
          aria-controls="<?php echo $itemId; ?>">
          <?php echo $item->title; ?>
        </button>
      </p>
      <div id="<?php echo $itemId; ?>" class="accordion-collapse collapse"
        aria-labelledby="<?php echo $itemId; ?>Header"
        data-bs-parent="#<?php echo $id; ?>">
        <div class="accordion-body">
          <?php echo $item->introtext; ?>
        </div>
      </div><!--/accordion-collapse-->
    </div><!--/accordion-item-->
  <?php
  } ?>
</div><!--/accordion -->
