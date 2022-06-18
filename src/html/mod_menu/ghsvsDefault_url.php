<?php
defined('_JEXEC') or die;

use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\HTML\HTMLHelper;

echo HTMLHelper::_(
	'link',
	OutputFilter::ampReplace(
		htmlspecialchars(
		$item->flink,
		ENT_COMPAT,
		'UTF-8',
		false
	)
	),
	$item->title,
	$item->aAttributes
);
