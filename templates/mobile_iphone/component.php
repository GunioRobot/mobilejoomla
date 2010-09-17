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
defined('_JEXEC') or die('Restricted access');

defined('_MJ') or die('Incorrect usage of Mobile Joomla.');

$MobileJoomla =& MobileJoomla::getInstance();

$MobileJoomla->showXMLheader();
$MobileJoomla->showDocType();

$base = $this->baseurl."/templates/".$this->template;

?>
<!doctype html>
<html <?php echo $MobileJoomla->getXmlnsString(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php echo $MobileJoomla->getContentString(); ?>"/>
	<title>Mobile Joomla!</title>
	<style type="text/css" media="screen">@import "<?=$base?>/jqtouch-src/jqtouch/jqtouch.min.css";</style>
	<style type="text/css" media="screen">@import "<?=$base?>/jqtouch-src/themes/apple/theme.min.css";</style>
	<style type="text/css" media="screen">@import "<?=$base?>/mj_iphone.css";</style>
	<script src="<?=$base?>/jqtouch-src/jqtouch/jquery.1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$base?>/jqtouch-src/jqtouch/jqtouch.js" type="application/x-javascript" charset="utf-8"></script>
	<script src="<?=$base?>/mj_iphone.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<?php $MobileJoomla->showMainBody(); ?>
</body>
</html>