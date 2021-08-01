<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Filter\OutputFilter;

echo HTMLHelper::_('link',
	OutputFilter::ampReplace(htmlspecialchars(
		$item->flink, ENT_COMPAT, 'UTF-8', false)
	),
	$item->title,
	$item->aAttributes
);
