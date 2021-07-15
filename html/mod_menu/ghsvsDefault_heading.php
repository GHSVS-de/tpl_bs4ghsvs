<?php
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

/* Convert array with <A> attributes to string. E.g.
$item->aAttributes['class'] = 'thing thang thong';
$item->aAttributes['title'] = 'Hello my thing!';
*/
$aAttributes = ArrayHelper::toString($item->aAttributes);
?>
<span tabindex="0"<?php echo $aAttributes ? ' ' . $aAttributes : ''; ?>>
<?php echo $item->title; ?>
</span>
