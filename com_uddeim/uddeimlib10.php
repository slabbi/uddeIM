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
	
function uddeIMgetUserTZ() {
	$mosConfig_offset = uddeIMgetOffset();
	return (int)$mosConfig_offset;		// not supported by Joomla 1.0, so return server TZ
}

function uddetime($timezone = 0) {
//	$mosConfig_offset = uddeIMgetOffset();
//	$rightnow=time()+(($mosConfig_offset+$timezone)*3600);		// store the server's time zone
	$rightnow=time()+($timezone*3600);			// store the server's time zone
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

function uddeIMaddScript($value) {
	global $mainframe;
	if ($value) {
		// $valuelink = "<script language=\"JavaScript\" type=\"text/javascript\" src=\"".$value."\"></script>\n";
		$valuelink = "<script type=\"text/javascript\" src=\"".$value."\"></script>\n";
		$mainframe->addCustomHeadTag( $valuelink );
	}
}

function uddeIMaddCSS($value) {
	global $mainframe;
	if ($value) {
		$valuelink = "<link rel='stylesheet' href='".$value."' type='text/css' />\n";
		$mainframe->addCustomHeadTag( $valuelink );
	}
}

function uddeIMsefRelToAbs($value) {
	return sefRelToAbs($value);
}

function uddeIMmosGetParam( &$arr, $name, $def=null, $mask=0 ) {
	return mosGetParam( $arr, $name, $def, $mask );
}

function uddeIMmosRedirect( $url, $msg='' ) {
	mosRedirect( $url, $msg );
}

function uddeJSEFredirect($url, $msg='', $avoid='') {
	$redirecturl = $url;
	if ($redirecturl=="HTTP_REFERER") {
		$redirecturl=uddeIMmosGetParam( $_SERVER, 'HTTP_REFERER', null );
		if (is_null($redirecturl))
			$redirecturl="index.php?option=com_uddeim&task=inbox&Itemid=".$item_id;
		if ($avoid && stristr($redirecturl, $avoid))
			$redirecturl="index.php?option=com_uddeim&task=inbox&Itemid=".$item_id;
	}
	$redirecturl = sefRelToAbs($redirecturl);
	mosRedirect( $redirecturl, $msg );
}

function uddeIMmosMail($from, $fromname, $recipient, $subject, $body, $mode=0, $cc=NULL, $bcc=NULL, $attachment=NULL, $replyto=NULL, $replytoname=NULL ) {
	return mosMail($from, $fromname, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyto, $replytoname );
}

function uddeIMgetOffset() {
	global $mosConfig_offset;
	return $mosConfig_offset;
}

function uddeIMgetLocale() {
	global $mosConfig_locale;
	return $mosConfig_locale;
}

function uddeIMgetSitename() {
	global $mosConfig_sitename;
	return $mosConfig_sitename;
}

function uddeIMgetMailFrom() {
	global $mosConfig_mailfrom;
	return $mosConfig_mailfrom;
}

function uddeIMgetMetaDesc() {
	global $mosConfig_MetaDesc;
	return $mosConfig_MetaDesc;
}

function uddeIMgetMetaKeys() {
	global $mosConfig_MetaKeys;
	return $mosConfig_MetaKeys;
}

function uddeIMgetLang() {
	global $mosConfig_lang;
	return $mosConfig_lang;
}

function uddeIMgetVersion() {
	global $_VERSION;
	return $_VERSION;
}

function uddeIMgetDatabase() {
	global $database;
	return $database;
}

function uddeIMgetDBprefix() {
	global $mainframe;
	return $mainframe->getCfg('dbprefix');
}

function uddeIMgetUserID() {
	global $my;
	return $my->id;
}

function uddeIMgetGroupID() {	// 0=public, 1=registered, 2=special
	global $my;
	return $my->gid;
}

function uddeIMgetGroupID2($config) {	// 0=public, 1=registered, 2=special
	global $my;
	return $my->gid;
}

function uddeIMgetMy() {
	global $my;
	return $my;
}

function uddeIMgetPath($path, $component="com_uddeim") {
	global $mainframe;
	switch($path) {
		case "absolute_path":	return $mainframe->getCfg('absolute_path');
		case "live_site":		return $mainframe->getCfg('live_site');
		case "admin":			return $mainframe->getCfg('absolute_path')."/administrator/components/".$component;
		case "user":			return $mainframe->getCfg('absolute_path')."/components/".$component;
	}
	return NULL;
}

if ($uddeim_isadmin) {
	if (!class_exists('uddeIMmosPageNav')) {
		if (!class_exists('mosPageNav'))
			include_once(uddeIMgetPath('absolute_path')."/administrator/includes/pageNavigation.php");
		class uddeIMmosPageNav extends mosPageNav {
			function mosPageNav( $total, $limitstart, $limit ) {
				parent::__construct($total, $limitstart, $limit);
			}
		}
	}
} else {
	if (!class_exists('uddeIMmosPageNav')) {
		if (!class_exists('mosPageNav'))
			include_once(uddeIMgetPath('absolute_path')."/includes/pageNavigation.php");
		class uddeIMmosPageNav extends mosPageNav {
			function mosPageNav( $total, $limitstart, $limit ) {
				parent::__construct($total, $limitstart, $limit);
			}
		}
	}
}

function uddeIMmosMakePassword($length=8) {
	return mosMakePassword($length);
}

function uddeIMmosFormatDate($date='now', $format=null, $offset=null) {
	mosFormatDate($date, $format, $offset);
}

function uddeIMisWritable($file, $forcenoftp=false) {
	return is_writable(uddeIMgetPath('absolute_path').$file);
}

function uddeIMwriteFile($file, $string, $forcenoftp=false) {
	if ($fout = fopen(uddeIMgetPath('absolute_path').$file, "w")) {
		fputs($fout, $string, strlen($string));
		fclose ($fout);
		return true;
	}
	return false;
}

function uddeIMchmod($file, $mode, $forcenoftp=false) {
	$mode = intval($mode, 8);		// chmod requires octal number
	return @chmod(uddeIMgetPath('absolute_path').$file, $mode);
}

function uddeIMisFtpLayer() {
	return false;
}

function uddeIMmkdir($folder, $forcenoftp=false) {
	return @mkdir(uddeIMgetPath('absolute_path').$folder);
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
