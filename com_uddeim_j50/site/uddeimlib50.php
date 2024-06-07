<?php
// ********************************************************************************************
// @title         udde Instant Messages (uddeIM)
// @description   Instant Messages System for Joomla 5
// @author        Stephan Slabihoud, Benjamin Zweifel
// @copyright     © 2007-2024 Stephan Slabihoud, © 2024 v5 joomod.de, © 2006 Benjamin Zweifel
// @license       GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
//                This program is free software: you may redistribute it and/or modify under the
//                terms of the GNU General Public License as published by the Free Software Foundation,
//                either version 3 of the License, or (at your option) any later version.
//
//                uddeIM is distributed in the hope to be useful but comes with absolutely NO WARRENTY.
//                You should have received a copy of the GNU General Public License along with this program.
//                Use at your own risk. For details, see the license at http://www.gnu.org/licenses/gpl.txt
//                Other licenses may be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );

use Joomla\CMS\Factory;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Client\ClientHelper;
use Joomla\CMS\Client\FtpClient;
use Joomla\CMS\Router\Route;

global $uddeim_isadmin;

DEFINE ('_UDDEIM_GID_GUEST',		 9);
DEFINE ('_UDDEIM_GID_SADMIN',		 8);
DEFINE ('_UDDEIM_GID_ADMIN',		 7);
DEFINE ('_UDDEIM_GID_MAMAGER',		 6);
DEFINE ('_UDDEIM_GID_PUBLISHER',	 5);
DEFINE ('_UDDEIM_GID_EDITOR',		 4);
DEFINE ('_UDDEIM_GID_AUTHOR',		 3);
DEFINE ('_UDDEIM_GID_REGISTERED',	 2);
DEFINE ('_UDDEIM_GID_PUBLIC',		 1);
// $groupsadmin
// $groupsspecial


//jimport('joomla.utilities.utility');

function uddeIMgetUserTZ() {
    //$user = Factory::getApplication()->getIdentity();
    $tz = (int)Factory::getApplication()->getIdentity()->getParam('timezone');
    return $tz;
}

function uddetime($timezone = 0) {
    //$Date = Factory::getDate();
    $ud = Factory::getDate()->toUnix();	// toUnix does not include timezone, it is GMT+0
    $rightnow=$ud+($timezone*3600);
    return $rightnow;
}

function uddeIMisAdmin($my_gid) {
    $new = is_array($my_gid) ? array_intersect($my_gid, array(7,8)) : 0;
    return !empty($new);
}

function uddeIMisManager($my_gid) {
    $new = is_array($my_gid) ? array_intersect($my_gid, array(6,7,8)) : 0;
    return !empty($new);
}

function uddeIMisSpecial($my_gid) {
    $new = is_array($my_gid) ? array_intersect($my_gid, array(3,4,5,6,7,8)) : 0;
    return !empty($new);
}

function uddeIMisAllNotAdmin($my_gid) {
    // $new = array_intersect($my_gid, array(0,2,3,4,5,6));
    // return !empty($new);
    return !uddeIMisAdmin($my_gid);
}

function uddeIMisReggedOnly($my_gid) {
    $new = is_array($my_gid) ? array_intersect($my_gid, array(2)) : 0;
    return !empty($new);
}

function uddeIMaddScript($value) {
    if ($value) {
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
        $wa->registerAnduseScript('udd_'.basename($value,'.js'), $value );
    }
}

function uddeIMaddCSS($value) {
    if ($value) {
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
        $wa->registerAnduseStyle('udd_'.basename($value,'.css'), $value );
    }
}

function uddeIMsefRelToAbs($value) {
    // Replace all &amp; with & as the router doesn't understand &amp;
    $url = str_replace('&amp;', '&', $value);
    if(substr(strtolower($url),0,9) != "index.php") return $url;
    $uri    = Uri::getInstance();
    $prefix = $uri->toString(array('scheme', 'host', 'port'));
    return $prefix.Route::_($url);
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
    $var = Joomla\Utilities\ArrayHelper::getValue( $arr, $name, $def, '' );
    if (!($mask & 1) && is_string($var)) {
        $var = trim($var);
    }
    if ($mask & 2) {
        if (is_null($safeHtmlFilter)) {
            //passing null as first argument to ::getInstance raises an exception
//            $safeHtmlFilter = JFilterInput::getInstance(null, null, 1, 1);
            $safeHtmlFilter = new InputFilter();
        }
        $var = $safeHtmlFilter->clean($var, 'none');
    } elseif ($mask & 4) {
        $var = $var;
    } else {
        if (is_null($noHtmlFilter)) {
            $noHtmlFilter = InputFilter::getInstance(/* $tags, $attr, $tag_method, $attr_method, $xss_auto */);
        }
        $var = $noHtmlFilter->clean($var, 'none');
    }
    return $var;
}

function uddeIMmosRedirect( $url, $msg='' ) {
    $app = Factory::getApplication();
    if ($msg)
    $app->enqueueMessage($msg);
    $app->redirect(Route::_($url, false));
}

function uddeJSEFredirect($url, $msg='', $avoid='') {			// REMOVE FROM includes.php
    $redirecturl = $url;
    if ($redirecturl=="HTTP_REFERER") {
        $redirecturl=uddeIMmosGetParam( $_SERVER, 'HTTP_REFERER', null );
        if (is_null($redirecturl))
            $redirecturl="index.php?option=com_uddeim&task=inbox&Itemid=".$item_id;
        if ($avoid && stristr($redirecturl, $avoid))
            $redirecturl="index.php?option=com_uddeim&task=inbox&Itemid=".$item_id;
    }
    $redirecturl = Route::_($redirecturl, false);
    $app = Factory::getApplication();
    if ($msg)
    $app->enqueueMessage($msg);
    $app->redirect( $redirecturl );

}

function uddeIMmosMail($from, $fromname, $recipient, $subject, $body, $mode=0, $cc=NULL, $bcc=NULL, $attachment=NULL, $replyto=NULL, $replytoname=NULL ) {
    $mailer = Factory::getMailer();

    if (!empty($replyto) && !empty($replytoname))
        $mailer-> addReplyTo($replyto, $replytoname);
    else if (!empty($replyto))
        $mailer-> addReplyTo($replyto);

    $sender = array( $from, $fromname );
    $mailer->setSender($sender);
    $mailer->addRecipient($recipient);
    $mailer->setSubject($subject);
    $mailer->setBody($body);
    //$mailer->addAttachment(JPATH_COMPONENT.DS.'assets'.DS.'document.pdf');
    if ($mode==1) {
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
    }
    if (!empty($bcc))
        $mailer->addBCC($bcc);

    if (!empty($cc))
        $mailer->addCC($cc);

    $send = $mailer->Send();
    return $send;
    // return JMail::sendMail($from, $fromname, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyto, $replytoname );
}

// The timezone support is completely messed up in Joomla because of several API changes.
// The code below does not longer work (returns e.g. CET instead of an number).
function uddeIMgetOffset() {
    $config = Factory::getApplication()->getConfig();
    return $config->get('offset');  //returns string
}

function uddeIMgetLocale() {
    $lang = Factory::getApplication()->getLanguage();
    return $lang->getTag();
}

function uddeIMgetSitename() {
    $config = Factory::getApplication()->getConfig();
    return $config->get('sitename');
}

function uddeIMgetMailFrom() {
    $config = Factory::getApplication()->getConfig();
    return $config->get('mailfrom');
}

function uddeIMgetMetaDesc() {
    $config = Factory::getApplication()->getConfig();
    return $config->get('MetaDesc');
}

function uddeIMgetMetaKeys() {
    $config = Factory::getApplication()->getConfig();
    return $config->get('MetaKeys');
}

function uddeIMgetLang() {
    $lang = Factory::getApplication()->getLanguage();
    $tag = $lang->getTag();
    $tag1 = strtolower(substr($tag,0,2));
    $tag2 = strtolower(substr($tag,3,2));
    switch($tag1) {
        case "af":		$temp = "afrikaansi";		break;
        case "sq":		$temp = "albanian";			break;
        case "ar":		$temp = "arabic";			break;
        case "az":		$temp = "azeri";			break;
        case "bg":		$temp = "bulgarian";		break;
        case "bn":		$temp = "bengali";			break;
        case "bs":		$temp = "bosanski";			break;
        case "ca":		$temp = "catalan";			break;
        case "cs":		$temp = "czech";			break;
        case "da":		$temp = "danish";			break;
        case "de":		$temp = "german";			break;
        case "el":		$temp = "greek";			break;
        case "en":		$temp = "english";			break;
        case "eo":		$temp = "esperanto";		break;
        case "es":		$temp = "spanish";			break;
        case "eu":		$temp = "basque";			break;
        case "fa":		$temp = "farsi";			break;
        case "fi":		$temp = "finnish";			break;
        case "fr":		$temp = "french";			break;
        case "gl":		$temp = "galician";			break;
        case "he":		$temp = "hebrew";			break;
        case "hi":		$temp = "hindi";			break;
        case "hr":		$temp = "hrvatski";			break;
        case "hu":		$temp = "hungarian";		break;
        case "hy":		$temp = "armenian";			break;
        case "id":		$temp = "indonesian";		break;
        case "it":		$temp = "italian";			break;
        case "ja":		$temp = "japanese";			break;
        case "ko":		$temp = "korean";			break;
        case "lo":		$temp = "lao";				break;
        case "lt":		$temp = "lithuanian";		break;
        case "lv":		$temp = "latvian";			break;
        case "nb":		$temp = "norwegian";		break;
        case "nl":		$temp = "dutch";			break;
        case "pl":		$temp = "polish";			break;
        case "pt":		if ($tag2=="br")
            $temp = "brazilian_portuguese";
        else
            $temp = "portuguese";
            break;
        case "ro":		$temp = "romanian";			break;
        case "ru":		$temp = "russian";			break;
        case "sk":		$temp = "slovak";			break;
        case "sr":		if ($tag2=="me")
            $temp = "montenegrin";
        else
            $temp = "serbian";
            break;
        case "sv":		$temp = "swedish";			break;
        case "th":		$temp = "thai";				break;
        case "tr":		$temp = "turkish";			break;
        case "uk":		$temp = "ukrainian";		break;
        case "vi":		$temp = "vietnamese";		break;
        case "zh":		if ($tag2=="cn")
            $temp = "simplified_chinese";
        else
            $temp = "traditional_chinese";
            break;
        case "en":		$temp = "english";			break;
        default: 		$temp = "english";			break;
    }
    return $temp;
}


function uddeIMgetVersion() {
    $ver = new Joomla\CMS\Version;
    return $ver;
}

function uddeIMgetDatabase() {
    $db = Factory::getContainer()->get('DatabaseDriver');
    return $db;
}

function uddeIMgetDBprefix() {
    $config = Factory::getApplication()->getConfig();
    return $config->get('dbprefix');
}

function uddeIMgetUserID() {
    $user = Factory::getApplication()->getIdentity();
    return $user->id;
}

function uddeIMgetGroupID() {	// 1=public, 2=registered, 3=special
    $database = uddeIMgetDatabase();
    $userid = uddeIMgetUserID();

    $sql="SELECT g.id AS gid
		FROM (#__users AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id)
		INNER JOIN `#__usergroups` AS g ON um.group_id=g.id WHERE u.id=".(int)$userid;
    $database->setQuery($sql);
    $rows = $database->loadObjectList();
    $my_gid = Array();
    foreach($rows as $key => $value) {
        if ($value->gid==1 || $value->gid==9)  //1=public   9=guest
            $my_gid[] = 1;
        else
            $my_gid[] = (int)$value->gid;   // 2= registered ...
    }
    if (uddeIMisSpecial($my_gid))   // numbers have to be increased by 1 to catch the new joomla viewlevels
        return 3;
    if (uddeIMisReggedOnly($my_gid))
        return 2;
    return 1;
}

function uddeIMgetGroupID2($config) {	// 1=public, 2=registered, 3=special
    $database = uddeIMgetDatabase();
    $userid = uddeIMgetUserID();

    $sql="SELECT g.id AS gid
		FROM (#__users AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id)
		INNER JOIN `#__usergroups` AS g ON um.group_id=g.id WHERE u.id=".(int)$userid;
    $database->setQuery($sql);
    $rows = $database->loadObjectList();
    $my_gid = Array();
    foreach($rows as $key => $value) {
        if ($value->gid==1 || $value->gid==9)  // 1=public,  9=guest
            $my_gid[] = 1;
        else
            $my_gid[] = (int)$value->gid;  // 2 = Registered, ...
    }
    if (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))
        return 3;  // 2    // numbers have to be increased by 1 catch the new joomla viewlevels
    if (uddeIMisReggedOnly($my_gid))
        return 2;  // 1
    return 1;      // 0
}

function uddeIMgetMy() {
    $user = Factory::getApplication()->getIdentity();
    $my = (object)$user->getProperties();
    $my->gid = uddeIMgetGroupID();
    return $my;
}

function uddeIMgetPath($path, $component="com_uddeim") {
    switch($path) {
        case "absolute_path":	return JPATH_SITE;
        case "live_site":		return substr_replace(URI::root(), '', -1, 1);
        case "admin":			return JPATH_ADMINISTRATOR .'/components/'.$component;
        case "user":			return JPATH_SITE .'/components/'.$component;
    }
    return NULL;
}

if (!class_exists('uddeIMmosPageNav')) {
    class uddeIMmosPageNav extends Pagination {
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
    return Joomla\CMS\User\UserHelper::genRandomPassword($length);
}

function uddeIMmosFormatDate($date='now', $format=null, $offset=null) {
    if (!$format)
        $format = Text::_('DATE_FORMAT_LC1');
    return Joomla\CMS\HTML\HTMLHelper::_('date', $date, $format, $offset);
}

function uddeIMisWritable($file, $forcenoftp=false) {
    //$options = array();
    $ret = false;
    $options = ClientHelper::getCredentials('ftp');
    /*if (class_exists('Factory')) {		// Joomla 1.5?
        $config = Factory::getConfig();
        $options = array(
            'enabled'	=> $config->get('ftp_enable'),
            'host'		=> $config->get('ftp_host'),
            'port'		=> $config->get('ftp_port'),
            'user'		=> $config->get('ftp_user'),
            'pass'		=> $config->get('ftp_pass'),
            'root'		=> $config->get('ftp_root'),
        );
    }*/
    if ($forcenoftp)
        $options['enabled'] = false;

    if ($options['enabled']) {
        //jimport('joomla.client.ftp');
        //$configdatei = $options['root'].$file;
        //$ftp = FtpClient::getInstance($options['host'], $options['port']);
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
    //$options = array();
    $ret = false;
    //J5
    $options = ClientHelper::getCredentials('ftp');
    /*if (class_exists('Factory')) {		// Joomla 1.5?
        $config = Factory::getConfig();
        $options = array(
            'enabled'	=> $config->get('ftp_enable'),
            'host'		=> $config->get('ftp_host'),
            'port'		=> $config->get('ftp_port'),
            'user'		=> $config->get('ftp_user'),
            'pass'		=> $config->get('ftp_pass'),
            'root'		=> $config->get('ftp_root'),
        );
    }*/
    if ($forcenoftp)
        $options['enabled'] = false;

    if ($options['enabled']) {
        $configdatei = $options['root'].$file;
        //$configdatei = JPath::clean(str_replace( JPATH_ROOT, $options['root'], $configdatei), '/' );
        $ftp = FtpClient::getInstance($options['host'], $options['port'], array(), $options['user'], $options['pass']);
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
    //$options = array();
    $ret = false;
    $options = ClientHelper::getCredentials('ftp');
    /*if (class_exists('Factory')) {		// Joomla 1.5?
        $config = Factory::getConfig();
        $options = array(
            'enabled'	=> $config->get('ftp_enable'),
            'host'		=> $config->get('ftp_host'),
            'port'		=> $config->get('ftp_port'),
            'user'		=> $config->get('ftp_user'),
            'pass'		=> $config->get('ftp_pass'),
            'root'		=> $config->get('ftp_root'),
        );
    }*/
    if ($forcenoftp)
        $options['enabled'] = false;

    if ($options['enabled']) {
        $configdatei = $options['root'].$file;
        //$ftp = JClientFtp::getInstance($options['host'], $options['port']);
        $ftp = FtpClient::getInstance($options['host'], $options['port'], array(), $options['user'], $options['pass']);
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
    if (class_exists('Factory')) {
        $config = Factory::getApplication()->getConfig();
        if ($config->get('ftp_enable'))
            return true;
    }
    return false;
}

function uddeIMmkdir($folder, $forcenoftp=false) {
    //$options = array();
    $ret = false;
    $options = ClientHelper::getCredentials('ftp');
    /*if (class_exists('Factory')) {		// Joomla 1.5?
        $config = Factory::getConfig();
        $options = array(
            'enabled'	=> $config->get('ftp_enable'),
            'host'		=> $config->get('ftp_host'),
            'port'		=> $config->get('ftp_port'),
            'user'		=> $config->get('ftp_user'),
            'pass'		=> $config->get('ftp_pass'),
            'root'		=> $config->get('ftp_root'),
        );
    }*/
    if ($forcenoftp)
        $options['enabled'] = false;

    if ($options['enabled']) {
        $configdatei = $options['root'].$folder;
        $ftp = FtpClient::getInstance($options['host'], $options['port'], array(), $options['user'], $options['pass']);
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
    if ( function_exists("get_magic_quotes_gpc") ) {
		if ( get_magic_quotes_gpc() )
			$source = stripslashes($source);
    }
    $source = $database->escape( $source );
    return $source;
}
