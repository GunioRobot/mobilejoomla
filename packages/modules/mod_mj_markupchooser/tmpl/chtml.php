<?php
/**
 * ###DESC###
 * ###URL###
 *
 * @version		###VERSION###
 * @license		###LICENSE###
 * @copyright	###COPYRIGHT###
 * @date		###DATE###
 */
defined('_JEXEC') or die('Restricted access');

echo $params->get('show_text', ' ');

$parts = array();
foreach($links as $link)
{
	if($link['url'])
		$parts[] = '<a href="'.$link['url'].'">'.$link['text'].'</a>';
	else
		$parts[] = $link['text'];
}

echo implode(' | ', $parts);
