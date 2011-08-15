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

jimport('joomla.plugin.plugin');

class plgMobileDomains extends JPlugin
{
	var $_domain_markup = null;

	function plgMobileDomains(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onAfterDeviceDetection(&$MobileJoomla_Settings, &$MobileJoomla_Device)
	{
		if($MobileJoomla_Settings['domains'] != '1')
			return;

		$version = new JVersion;
		$is_joomla15 = (substr($version->getShortVersion(),0,3) == '1.5');
		if($is_joomla15)
			$config_live_site = 'config.live_site';
		else
			$config_live_site = 'live_site';

		// Check for special domains
		$parsed = parse_url(JURI::base());
		$path = isset($parsed['path']) ? $parsed['path'] : '';
		$http = isset($parsed['scheme']) ? $parsed['scheme'] : 'http';

		$domain_xhtml = $MobileJoomla_Settings['xhtmldomain'];
		$domain_wap = $MobileJoomla_Settings['wapdomain'];
		$domain_imode = $MobileJoomla_Settings['imodedomain'];
		$domain_iphone = $MobileJoomla_Settings['iphonedomain'];

		/** @var JRegistry $config */
		$config =& JFactory::getConfig();

		if(($MobileJoomla_Device['markup']=='xhtml' && $domain_xhtml && $_SERVER['HTTP_HOST']==$domain_xhtml) ||
		   ($MobileJoomla_Device['markup']=='wml' && $domain_wap && $_SERVER['HTTP_HOST']==$domain_wap) ||
		   ($MobileJoomla_Device['markup']=='chtml' && $domain_imode && $_SERVER['HTTP_HOST']==$domain_imode) ||
		   ($MobileJoomla_Device['markup']=='iphone' && $domain_iphone && $_SERVER['HTTP_HOST']==$domain_iphone) )
		{
			$config->setValue($config_live_site, $http.'://'.$_SERVER['HTTP_HOST'].$path);
			$this->_domain_markup = $MobileJoomla_Device['markup'];
			return;
		}

		if($domain_xhtml && $_SERVER['HTTP_HOST'] == $domain_xhtml)
		{ // Smartphone (xhtml-mp/wap2) domain
			$MobileJoomla_Device['markup'] = 'xhtml';
			$config->setValue($config_live_site, $http.'://'.$_SERVER['HTTP_HOST'].$path);
			$this->_domain_markup = $MobileJoomla_Device['markup'];
		}
		elseif($domain_iphone && $_SERVER['HTTP_HOST'] == $domain_iphone)
		{ // iPhone/iPod domain
			$MobileJoomla_Device['markup'] = 'iphone';
			$config->setValue($config_live_site, $http.'://'.$_SERVER['HTTP_HOST'].$path);
			$this->_domain_markup = $MobileJoomla_Device['markup'];
		}
		elseif($domain_imode && $_SERVER['HTTP_HOST'] == $domain_imode)
		{ // iMode (chtml) domain
			$MobileJoomla_Device['markup'] = 'chtml';
			$config->setValue($config_live_site, $http.'://'.$_SERVER['HTTP_HOST'].$path);
			$this->_domain_markup = $MobileJoomla_Device['markup'];
		}
		elseif($domain_wap && $_SERVER['HTTP_HOST'] == $domain_wap)
		{ // WAP (wml) domain
			$MobileJoomla_Device['markup'] = 'wml';
			$config->setValue($config_live_site, $http.'://'.$_SERVER['HTTP_HOST'].$path);
			$this->_domain_markup = $MobileJoomla_Device['markup'];
		}
	}

	function onBeforeMobileMarkupInit(&$MobileJoomla_Settings, &$MobileJoomla_Device)
	{
		if($this->_domain_markup !== null)
			$MobileJoomla_Device['markup'] = $this->_domain_markup;

		if($MobileJoomla_Settings['domains'] != '1')
			return;
		if($MobileJoomla_Device['markup'] == '')
			return;

		$uri =& JURI::getInstance();
		$parsed = parse_url($uri->toString());
		$path = isset($parsed['path']) ? $parsed['path'] : '';
		$http = isset($parsed['scheme']) ? $parsed['scheme'] : 'http';

		/** @var JSite $mainframe */
		$mainframe =& JFactory::getApplication();
		switch($MobileJoomla_Device['markup'])
		{
		case 'xhtml':
			$domain_xhtml = $MobileJoomla_Settings['xhtmldomain'];
			if($MobileJoomla_Settings['xhtmlredirect'] && $domain_xhtml && $_SERVER['HTTP_HOST'] != $domain_xhtml)
				$mainframe->redirect($http.'://'.$domain_xhtml.$path);
			break;
		case 'wml':
			$domain_wap = $MobileJoomla_Settings['wapdomain'];
			if($MobileJoomla_Settings['wapredirect'] && $domain_wap && $_SERVER['HTTP_HOST'] != $domain_wap)
				$mainframe->redirect($http.'://'.$domain_wap.$path);
			break;
		case 'chtml':
			$domain_imode = $MobileJoomla_Settings['imodedomain'];
			if($MobileJoomla_Settings['imoderedirect'] && $domain_imode && $_SERVER['HTTP_HOST'] != $domain_imode)
				$mainframe->redirect($http.'://'.$domain_imode.$path);
			break;
		case 'iphone':
			$domain_iphone = $MobileJoomla_Settings['iphonedomain'];
			if($MobileJoomla_Settings['iphoneredirect'] && $domain_iphone && $_SERVER['HTTP_HOST'] != $domain_iphone)
				$mainframe->redirect($http.'://'.$domain_iphone.$path);
			break;
		}
	}
}
