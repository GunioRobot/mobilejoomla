<?php
/**
 * Mobile Joomla!
 * http://www.mobilejoomla.com
 *
 * @version		0.9.7
 * @license		http://www.gnu.org/licenses/gpl-2.0.htm GNU/GPL
 * @copyright	(C) 2008-2010 MobileJoomla!
 * @date		August 2010
 */
defined('_JEXEC') or die ('Restricted access');

/** @var JParameter $params */

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$showTitle = $params->get('show_title', 1);
$imgURL = $params->get('img_url', '{{root}}templates/mobile_pda/resources/images/mw_joomla_logo.png');
$siteTitle = $params->get('site_title', '{{sitename}}');
$pageTitle = $params->get('page_title', '');
$cutTitle = $params->get('cut_title', 1);

$imgURL = JString::str_ireplace('{{root}}', JURI::base(), $imgURL);

/** @var JSite $app */
$app =& JFactory::getApplication();
/** @var JDocument $doc */
$doc =& JFactory::getDocument();

$siteTitle = JString::str_ireplace('{{sitename}}', $app->getCfg('sitename'), $siteTitle);
$siteTitle = JString::str_ireplace('{{pagetitle}}', $doc->getTitle(), $siteTitle);

$pageTitle = JString::str_ireplace('{{sitename}}', $app->getCfg('sitename'), $pageTitle);
$pageTitle = JString::str_ireplace('{{pagetitle}}', $doc->getTitle(), $pageTitle);

if($cutTitle)
{
	if(JString::strlen($siteTitle) > 35)
		$siteTitle = JString::substr($siteTitle, 0, 34).'...';

	if(JString::strlen($pageTitle) > 39)
		$siteTitle = JString::substr($siteTitle, 0, 37).'...';
}


require (JModuleHelper::getLayoutPath('mod_mj_header'));
