<?php
defined('_JEXEC') or die;
$urls = json_decode($this->item->urls);
$params = $this->item->params;
$collect = array();
if ($urls)
{

	$urls = Joomla\Utilities\ArrayHelper::fromObject($urls);
 // Joomla-Links
	$indexes = array('a', 'b', 'c');
	foreach ($indexes as $index)
	{
		if (isset($urls['url'.$index]))
		{
			$collect[] = array(
				'url' => trim($urls['url'.$index]),
				'text' => trim($urls['url'.$index.'text']),
				'target' => trim($urls['target'.$index]),
				'linkclass' => isset($urls['url'.$index.'linkclass']) ? $urls['url'.$index.'linkclass'] : '',
			);
		}
	}
	
	// Eigene Linkfelder aus Plugin articlesubtitleghsvs.
	$index = 1;
	while (isset($urls['url_ghsvs_'.$index]))
	{
		$collect[] = array(
		 'url' => trim($urls['url_ghsvs_'.$index]),
			'text' => trim($urls['url_ghsvs_'.$index.'_text']),
			'target' => trim($urls['url_ghsvs_'.$index.'_target']),
			'linkclass' => isset($urls['url_ghsvs_'.$index.'_linkclass']) ? $urls['url_ghsvs_'.$index.'_linkclass'] : '',
		);
		$index++;
	}
	foreach ($collect as $index => $link)
	{
		$class = '';
		if (!$link['url'] && !$link['text'])
		{
			unset($collect[$index]);
			continue;
		}
		if (!$link['text'])
		{
			$link['text'] = $link['url'];
		}
		$collect[$index] = '';
		if ($link['url'])
		{
			if ($link['linkclass'])
			{
				$class = ' class="' . $link['linkclass'] . '"';
			}
			$collect[$index] .= '<a href="' . htmlspecialchars($link['url']) . '"';
   switch ($link['target'])
			{
				case 1:
				case 2:
				case 3:
				 $collect[$index] .= ' target="_blank">';
				break;
				default:
				break;
			}
			$collect[$index] .= $class . '>';
		}
		$collect[$index] .= $link['text'];
		if ($link['url'])
		{
			$collect[$index] .= '</a>';
		}
	}
}
?>
<?php
if (count($collect))
{
?>
<div class="content-links">
	<ul class="list-group">
<?php
 foreach ($collect as $link)
	{?>
  <li class="list-group-item"><?php echo $link; ?></li>
<?php
 } ?>
	</ul>
</div>
<?php 
} ?>
