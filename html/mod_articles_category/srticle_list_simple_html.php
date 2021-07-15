<?php
defined('_JEXEC') or die;
?>
<ul>
<?php foreach ($list as $item)
{ ?>
<li>
<a href="<?php echo $item->link; ?>">
<?php echo $item->title; ?>
</a>
</li>
<?php
} ?>
</ul>