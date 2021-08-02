<?php
// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2010 Stephan Slabihoud
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

global $uddeim_isadmin;

DEFINE ('_UDDEIM_GID_SADMIN',		25);
DEFINE ('_UDDEIM_GID_ADMIN',		24);
DEFINE ('_UDDEIM_GID_MAMAGER',		23);
DEFINE ('_UDDEIM_GID_PUBLISHER',	21);
DEFINE ('_UDDEIM_GID_EDITOR',		20);
DEFINE ('_UDDEIM_GID_AUTHOR',		19);
DEFINE ('_UDDEIM_GID_REGISTERED',	18);
DEFINE ('_UDDEIM_GID_PUBLIC',		 0);
// $groupsadmin
// $groupsspecial

jimport('joomla.utilities.date');

function uddeIMgetUserTZ() {
	$JUser = JFactory::getUser();
	$tz = (int)$JUser->getParam('timezone');
	return $tz;
}

function uddetime($timezone = 0) {
	$JDate = JFactory::getDate();
	$ud = $JDate->toUnix();	// toUnix does not include timezone, it is GMT+0
    $rightnow=$ud+($timezone*3600);
    return $rightnow;
}

function uddeIMisAdmin($my_gid) {
	$new = array_intersect($my_gid, array(24,25));
	return !empty($new);
}

function uddeIMisManager($my_gid) {
	$new = array_intersect($my_gid, array(23,24,25));
	return !empty($new);
}

function uddeIMisSpecial($my_gid) {
	$new = array_intersect($my_gid, array(19,20,21,23,24,25));
	return !empty($new);
}

function uddeIMisAllNotAdmin($my_gid) {
	$new = array_intersect($my_gid, array(0,18,19,20,21,23));
	return !empty($new);
}

function uddeIMisReggedOnly($my_gid) {
	$new = array_intersect($my_gid, array(18));
	return !empty($new);
}

// JHTML::script('Autocompleter.js', 'components/com_uddeim/js/', false);
function uddeIMaddScript($value) {
	if ($value) {
		$document = JFactory::getDocument();
		$document->addScript( $value );
	}
}

function uddeIMaddCSS($value) {
	if ($value) {
		$document = JFactory::getDocument();
		$document->addStyleSheet( $value );
	}
}

function uddeIMsefRelToAbs($value) {
	// Replace all &amp; with & as the router doesn't understand &amp;
	$url = str_replace('&amp;', '&', $value);
	if(substr(strtolower($url),0,9) != "index.php") return $url;
	$uri    = JURI::getInstance();
	$prefix = $uri->toString(array('scheme', 'host', 'port'));
	return $prefix.JRoute::_($url);
}

if (!defined('_MOS_NOTRIM'))
	define( "_MOS_NOTRIM", 0x0001 );
if (!defined('_MOS_ALLOWHTML'))
	define( "_MOS_ALLOWHTML", 0x0002 );
if (!defined('_MOS_ALLOWRAW'))
	define( "_MOS_ALLOWRAW", 0x0004 );

function uddeIMmosGetParam( &$arr, $name, $def=null, $mask=0 ) {
	static $noHtmlFilter	= null;
	static $safeHtmlFilter	= null;
	$var = JArrayHelper::getValue( $arr, $name, $def, '' );
	if (!($mask & 1) && is_string($var)) {
		$var = trim($var);
	}
	if ($mask & 2) {
		if (is_null($safeHtmlFilter)) {
			$safeHtmlFilter = JFilterInput::getInstance(null, null, 1, 1);
		}
		$var = $safeHtmlFilter->clean($var, 'none');
	} elseif ($mask & 4) {
		$var = $var;
	} else {
		if (is_null($noHtmlFilter)) {
			$noHtmlFilter = JFilterInput::getInstance(/* $tags, $attr, $tag_method, $attr_method, $xss_auto */);
		}
		$var = $noHtmlFilter->clean($var, 'none');
	}
	return $var;
}

function uddeIMmosRedirect( $url, $msg='' ) {
	global $mainframe;
	$mainframe->redirect( $url, JText::_($msg) );
}

function uddeJSEFredirect($url, $msg='', $avoid='') {			// REMOVE FROM includes.php
	global $mainframe;
	$redirecturl = $url;
	if ($redirecturl=="HTTP_REFERER") {
		$redirecturl=uddeIMmosGetParam( $_SERVER, 'HTTP_REFERER', null );
		if (is_null($redirecturl))
			$redirecturl="index.php?option=com_uddeim&task=inbox&Itemid=".$item_id;
		if ($avoid && stristr($redirecturl, $avoid))
			$redirecturl="index.php?option=com_uddeim&task=inbox&Itemid=".$item_id;
	}
	$redirecturl = JRoute::_($redirecturl, false);
	$mainframe->redirect( $redirecturl, JText::_($msg) );
}

function uddeIMmosMail($from, $fromname, $recipient, $subject, $body, $mode=0, $cc=NULL, $bcc=NULL, $attachment=NULL, $replyto=NULL, $replytoname=NULL ) {
	return JUTility::sendMail($from, $fromname, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyto, $replytoname );
}

function uddeIMgetOffset() {
	$config = JFactory::getConfig();
	return $config->getValue('config.offset');  
}

function uddeIMgetLocale() {
	$config = JFactory::getConfig();
	return $config->getValue('config.locale');  
}

function uddeIMgetSitename() {
	$config = JFactory::getConfig();
	return $config->getValue('config.sitename');  
}

function uddeIMgetMailFrom() {
	$config = JFactory::getConfig();
	return $config->getValue('config.mailfrom');
}

function uddeIMgetMetaDesc() {
	$config = JFactory::getConfig();
	return $config->getValue('config.MetaDesc');  
}

function uddeIMgetMetaKeys() {
	$config = JFactory::getConfig();
	return $config->getValue('config.MetaKeys');  
}

function uddeIMgetLang() {
	$lang = JFactory::getLanguage();
	return $lang->getBackwardLang();
}

function uddeIMgetVersion() {
	$ver = new JVersion();
	return $ver;
}

function uddeIMgetDatabase() {
	$db = JFactory::getDBO();
	return $db;
}

function uddeIMgetDBprefix() {
	$config = JFactory::getConfig();
	return $config->getValue('config.dbprefix');  
}

function uddeIMgetUserID() {
	$user = JFactory::getUser();
	return $user->id;
}

function uddeIMgetGroupID() {
	$user = JFactory::getUser();
	return $user->get('aid', 0);
}

function uddeIMgetGroupID2($config) {
	$user = JFactory::getUser();
	return $user->get('aid', 0);
}

function uddeIMgetMy() {
	$user = JFactory::getUser();
	$my = (object)$user->getProperties();
	$my->gid = $user->get('aid', 0);
	return $my;
}
		
function uddeIMgetPath($path, $component="com_uddeim") {
	switch($path) {
		case "absolute_path":	return JPATH_SITE;
		case "live_site":		return substr_replace(JURI::root(), '', -1, 1);
		case "admin":			return JPATH_ADMINISTRATOR .'/components/'.$component;
		case "user":			return JPATH_SITE .'/components/'.$component;
	}
	return NULL;
}

if (!class_exists('uddeIMmosPageNav')) {
	jimport('joomla.html.pagination');
	class uddeIMmosPageNav extends JPagination {
		function mosPageNav( $total, $limitstart, $limit ) {
			parent::__construct($total, $limitstart, $limit);
		}
		function writeLimitBox($link = null) {
			echo $this->getLimitBox();
		}
		function writePagesCounter() {
			return $this->getPagesCounter();
		}
		function writePagesLinks($link = null) {
			return $this->getPagesLinks();
		}
		function writeLeafsCounter() {
			return $this->getPagesCounter();
		}
		function rowNumber($index) {
			return $index +1 + $this->limitstart;
		}
	}
}

function uddeIMmosMakePassword($length=8) {
	jimport('joomla.user.helper');
	return JUserHelper::genRandomPassword($length);
}

function uddeIMmosFormatDate($date='now', $format=null, $offset=null) {
	if (!$format)
		$format = JText::_('DATE_FORMAT_LC1');
	return JHTML::_('date', $date, $format, $offset);
}

function uddeIMisWritable($file, $forcenoftp=false) {
	$options = array();
	$ret = false;
	if (class_exists('JFactory')) {		// Joomla 1.5?
		$config = JFactory::getConfig();
		$options = array(
			'enabled'	=> $config->getValue('config.ftp_enable'),
			'host'		=> $config->getValue('config.ftp_host'),
			'port'		=> $config->getValue('config.ftp_port'),
			'user'		=> $config->getValue('config.ftp_user'),
			'pass'		=> $config->getValue('config.ftp_pass'),
			'root'		=> $config->getValue('config.ftp_root'),
		);
	}
	if ($forcenoftp)
		$options['enabled'] = false;

	if ($options['enabled']) {
		//jimport('joomla.client.ftp');
		//$configdatei = $options['root'].$file;
		//$ftp = JFTP::getInstance($options['host'], $options['port']);
		//if ($ftp->isConnected()) {
		//	if ($ftp->login($options['user'], $options['pass'])) {
				// there is no check available, so assume it is writeable
				$ret = true;
		//	}
		//	$ftp->quit();
		//}
	} else {
		$configdatei = uddeIMgetPath('absolute_path').$file;
		$ret = is_writable($configdatei);
	}
	return $ret;
}

function uddeIMwriteFile($file, $string, $forcenoftp=false) {
	$options = array();
	$ret = false;
	if (class_exists('JFactory')) {		// Joomla 1.5?
		$config = JFactory::getConfig();
		$options = array(
			'enabled'	=> $config->getValue('config.ftp_enable'),
			'host'		=> $config->getValue('config.ftp_host'),
			'port'		=> $config->getValue('config.ftp_port'),
			'user'		=> $config->getValue('config.ftp_user'),
			'pass'		=> $config->getValue('config.ftp_pass'),
			'root'		=> $config->getValue('config.ftp_root'),
		);
	}
	if ($forcenoftp)
		$options['enabled'] = false;

	if ($options['enabled']) {
		jimport('joomla.client.ftp');
		$configdatei = $options['root'].$file;
		//$configdatei = JPath::clean(str_replace( JPATH_ROOT, $options['root'], $configdatei), '/' );
		$ftp = JFTP::getInstance($options['host'], $options['port'], null, $options['user'], $options['pass']);
		//if ($ftp->isConnected()) {
		//	if ($ftp->login($options['user'], $options['pass'])) {
				$ret = $ftp->write($configdatei, $string);
		//	}
		//	$ftp->quit();
		//}
	} else {
		$configdatei = uddeIMgetPath('absolute_path').$file;
		if ($fout = fopen($configdatei, "w")) {
			fputs($fout, $string, strlen($string));
			fclose ($fout);
			$ret = true;
		}
	}
	return $ret;
}

function uddeIMchmod($file, $mode, $forcenoftp=false) {
	$options = array();
	$ret = false;
	if (class_exists('JFactory')) {		// Joomla 1.5?
		$config = JFactory::getConfig();
		$options = array(
			'enabled'	=> $config->getValue('config.ftp_enable'),
			'host'		=> $config->getValue('config.ftp_host'),
			'port'		=> $config->getValue('config.ftp_port'),
			'user'		=> $config->getValue('config.ftp_user'),
			'pass'		=> $config->getValue('config.ftp_pass'),
			'root'		=> $config->getValue('config.ftp_root'),
		);
	}
	if ($forcenoftp)
		$options['enabled'] = false;

	if ($options['enabled']) {
		jimport('joomla.client.ftp');
		$configdatei = $options['root'].$file;
		//$ftp = JFTP::getInstance($options['host'], $options['port']);
		$ftp = JFTP::getInstance($options['host'], $options['port'], null, $options['user'], $options['pass']);
		//if ($ftp->isConnected()) {
		//	if ($ftp->login($options['user'], $options['pass'])) {
				$ret = $ftp->chmod($configdatei, $mode);
		//	}
		//	$ftp->quit();
		//}
	} else {
		$configdatei = uddeIMgetPath('absolute_path').$file;
		$mode = intval($mode, 8);		// chmod requires octal number
		$ret = @chmod($configdatei, $mode);
	}
	return $ret;
}

function uddeIMisFtpLayer() {
	if (class_exists('JFactory')) {
		$config = JFactory::getConfig();
		if ($config->getValue('config.ftp_enable'))
			return true;
	}
	return false;
}

function uddeIMmkdir($folder, $forcenoftp=false) {
	$options = array();
	$ret = false;
	if (class_exists('JFactory')) {		// Joomla 1.5?
		$config = JFactory::getConfig();
		$options = array(
			'enabled'	=> $config->getValue('config.ftp_enable'),
			'host'		=> $config->getValue('config.ftp_host'),
			'port'		=> $config->getValue('config.ftp_port'),
			'user'		=> $config->getValue('config.ftp_user'),
			'pass'		=> $config->getValue('config.ftp_pass'),
			'root'		=> $config->getValue('config.ftp_root'),
		);
	}
	if ($forcenoftp)
		$options['enabled'] = false;

	if ($options['enabled']) {
		jimport('joomla.client.ftp');
		$configdatei = $options['root'].$folder;
		$ftp = JFTP::getInstance($options['host'], $options['port'], null, $options['user'], $options['pass']);
		//if ($ftp->isConnected()) {
		//	if ($ftp->login($options['user'], $options['pass'])) {
				$ret = $ftp->mkdir($configdatei);
		//	}
		//	$ftp->quit();
		//}
	} else {
		$configdatei = uddeIMgetPath('absolute_path').$folder;
		$ret = @mkdir($configdatei);
	}
	return $ret;
}

function uddeIMfileExists($file) {
	return (file_exists(uddeIMgetPath('absolute_path').$file) && is_file(uddeIMgetPath('absolute_path').$file));
}

function uddeIMfolderExists($file) {
	return (file_exists(uddeIMgetPath('absolute_path').$file) && is_dir(uddeIMgetPath('absolute_path').$file));
}

function uddeIM_utf8_check($Str) {
	for ($i=0; $i<strlen($Str); $i++) {
		if (ord($Str[$i]) < 0x80) continue; # 0bbbbbbb
		elseif ((ord($Str[$i]) & 0xE0) == 0xC0) $n=1; # 110bbbbb
		elseif ((ord($Str[$i]) & 0xF0) == 0xE0) $n=2; # 1110bbbb
		elseif ((ord($Str[$i]) & 0xF8) == 0xF0) $n=3; # 11110bbb
		elseif ((ord($Str[$i]) & 0xFC) == 0xF8) $n=4; # 111110bb
		elseif ((ord($Str[$i]) & 0xFE) == 0xFC) $n=5; # 1111110b
		else return false; # Does not match any model
		for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
			if ((++$i == strlen($Str)) || ((ord($Str[$i]) & 0xC0) != 0x80))
				return false;
		}
	}
	return true;
}

function uddeIM_utf8_substr($utf8, $str, $start) {
	if ($utf8) {
		preg_match_all("/./su", $str, $ar);
		if(func_num_args() >= 4) {
			$end = func_get_arg(3);
			return join("",array_slice($ar[0],$start,$end));
		} else {
			return join("",array_slice($ar[0],$start));
		}
	}
	if(func_num_args() >= 4) {
		$end = func_get_arg(3);
		return substr($str,$start,$end);
	} else {
		return substr($str,$start);
	}
}
// ----------
//	if(func_num_args() >= 3) {
//		$end = func_get_arg(2);
//		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'. $start .'}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'. $end .'}).*#s','$1', $str);
//	} else {
//		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'. $start .'}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+)).*#s','$1', $str);
//	}
// ----------

function uddeIM_utf8_strlen($utf8, $str) {
//	return mb_strlen($str, "UTF-8");
	if ($utf8) {
		$i = 0;
		$count = 0;
		$len = strlen ($str);
		while ($i < $len) {
			$chr = ord ($str[$i]);
			$count++;
			$i++;
			if ($i >= $len)
				break;
			if ($chr & 0x80) {
				$chr <<= 1;
				while ($chr & 0x80) {
					$i++;
					$chr <<= 1;
				}
			}
		}
		return $count;
	}
	return strlen($str);
}

function uddeIMquoteSmart($source) { 
	$database = uddeIMgetDatabase();
	if (get_magic_quotes_gpc()) { 
		$source = stripslashes($source);
	}
	$source = $database->getEscaped( $source );
	return $source; 
} 
