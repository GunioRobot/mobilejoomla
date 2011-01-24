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

/** @var JParameter $params */

require_once(dirname(__FILE__).DS.'helper.php');

if(!defined('_MJ'))
{
	$mj_class_path = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_mobilejoomla'.DS.'mobilejoomla.class.php';
	if(!file_exists($mj_class_path))
		return;
	include_once($mj_class_path);
	if($params->get('hide_on_pc', 1))
	{
		$MobileJoomla_Device =& MobileJoomla::getDevice();
		if(empty($MobileJoomla_Device['real_markup']))
			return;
	}
	$markup = '';
	$config =& MobileJoomla::getConfig();
	$base = $config['desktop_url'];
}
else
{
	/** @var MobileJoomla $MobileJoomla */
	$MobileJoomla =& MobileJoomla::getInstance();
	$markup = $MobileJoomla->getMarkup();
	$base = $MobileJoomla->config['desktop_url'];
}

/** @var JSite $mainframe */
global $mainframe;
$saved_markup = $mainframe->getUserState('mobilejoomla.markup', false);
switch($saved_markup)
{
	case '':
	case 'xhtml':
	case 'iphone':
	case 'mobile':
	case 'wml':
	case 'imode':
		break;
	default:
		$saved_markup = false;
}

/** @var JURI $uri */
$uri = clone(JFactory::getURI());
$uri->delVar('naked');

// Set-up mark-up chooser helper
$return = base64_encode($uri->toString(array('path', 'query')));
$show_chosen_markup = $params->get('show_choosen', 1);
$helper = new modMarkupChooserHelper($base, $return, $show_chosen_markup);

$links = array();

if($params->get('auto_show', 0))
{
	$text = $params->get('auto_text', 'Automatic Version');
	$link = modMarkupChooserHelper::getChangeLink($saved_markup===false?'-':'', '-', $text);
	if($link!==false) $links[] = array('url'=>$link, 'text'=>$text);
}

if($params->get('mobile_show', 1))
{
	$text = $params->get('mobile_text', 'Mobile Version');
	$is_mobile_markup = $markup == 'xhtml' || $markup == 'iphone' ||
						$markup == 'wml' || $markup == 'imode' ||
						$saved_markup=='mobile';
	$link = $helper->getChangeLink($is_mobile_markup?'mobile':'', 'mobile', $text);
	if($link!==false) $links[] = array('url'=>$link, 'text'=>$text);
}

if($params->get('web_show', 1))
{
	$text = $params->get('web_text', 'Standard Version');
	$link = $helper->getChangeLink($markup, '', $text);
	if($link!==false) $links[] = array('url'=>$link, 'text'=>$text);
}

if($params->get('xhtml_show', 0))
{
	$text = $params->get('xhtml_text', 'Smartphone Version');
	$link = $helper->getChangeLink($markup, 'xhtml', $text);
	if($link!==false) $links[] = array('url'=>$link, 'text'=>$text);
}

if($params->get('iphone_show', 0))
{
	$text = $params->get('iphone_text', 'iPhone Version');
	$link = $helper->getChangeLink($markup, 'iphone', $text);
	if($link!==false) $links[] = array('url'=>$link, 'text'=>$text);
}

if($params->get('wml_show', 0))
{
	$text = $params->get('wml_text', 'WAP Version');
	$link = $helper->getChangeLink($markup, 'wml', $text);
	if($link!==false) $links[] = array('url'=>$link, 'text'=>$text);
}

if($params->get('imode_show', 0))
{
	$text = $params->get('imode_text', 'iMode Version');
	$link = $helper->getChangeLink($markup, 'imode', $text);
	if($link!==false) $links[] = array('url'=>$link, 'text'=>$text);
}

require(JModuleHelper::getLayoutPath('mod_mj_markupchooser', $markup?$markup:'default'));
