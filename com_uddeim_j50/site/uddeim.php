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
use Joomla\CMS\Input\Input;
use Joomla\CMS\Filter\InputFilter;

$uddeim_isadmin = 0;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
}

$pathtoadmin = uddeIMgetPath('admin');
$pathtouser  = uddeIMgetPath('user');
$pathtosite  = uddeIMgetPath('live_site');

require_once($pathtoadmin."/admin.shared.php");		// before includes.php is included!

require_once($pathtouser.'/bbparser.php');
require_once($pathtouser.'/includes.php');
require_once($pathtouser.'/includes.db.php');
require_once($pathtouser.'/crypt.class.php');
require_once($pathtouser.'/getpiclink.php');		// after includes.db.php and admin.shared.php

require($pathtoadmin."/config.class.php");			// get the configuration file
global $versionstring;

$config = new uddeimconfigclass();

$userid = uddeIMgetUserID();
$usergid = uddeIMgetGID($userid);
$cbitemid = uddeIMinitGetPicLink($config);
$config->userid = $userid;
$config->usergid = $usergid;
$config->cbitemid = $cbitemid;


uddeIMcheckConfig($pathtouser, $pathtoadmin, $config);
$usedlanguage = uddeIMloadLanguage($pathtoadmin, $config);

// prepare temporary variables
$config->flags = 0;
$nouserlist = (int) uddeIMmosGetParam ( $_REQUEST, 'nouserlist', 0);		// suppress userlist (used for menu links only)
if ($nouserlist) $config->flags |= ($nouserlist & 0x07);			// 0x01 = suppress user list, 0x02 = suppress connection list, 0x03 = supress both (+0x04=disable TO field)

if ($plugin=uddeIMcheckPlugin('postbox')) {
	if ($config->enablepostbox) {
		include_once($plugin);
		if (!uddeIMcheckVersionPlugin('postbox'))
			$config->enablepostbox = 0;
	}
} else {
	$config->enablepostbox = 0;
}

if ($plugin=uddeIMcheckPlugin('attachment')) {
	if ($config->enableattachment) {
		include_once($plugin);
		if (!uddeIMcheckVersionPlugin('attachment'))
			$config->enableattachment = 0;
	}
} else {
	$config->enableattachment = 0;
}

if ($plugin=uddeIMcheckPlugin('rss')) {
	if ($config->enablerss) {
		$task = uddeIMmosGetParam( $_REQUEST, 'task', '');
		if ($task=="rss") {
			include_once($plugin);
			if (uddeIMcheckVersionPlugin('rss'))
				uddeIMrssFeedPlugin($versionstring, $userid, $config);
			exit;
		}
	}
} else {
	$config->enablerss = 0;
}

// check if public frontend is called
if ($plugin=uddeIMcheckPlugin('pfrontend')) {
	if ($config->pubfrontend && !$userid) {
		include_once($plugin);
		if (uddeIMcheckVersionPlugin('pfrontend'))
			uddeIMpublicFrontendPlugin($versionstring, $pathtouser, $pathtosite, $config);
		return;		// exit the script here, so no more output is produced
	}
} else {
	$config->pubfrontend = 0;
}

// No access if not logged in, and bye
if (!$userid) {
	$mosmsg = _UDDEIM_NOTLOGGEDIN;
	echo($mosmsg);
	return;
}

if (uddeIMisReggedOnly($usergid)) {		// only banned registered users cannot use uddeIM
	$is_banned = uddeIMisBanned($userid, $config);
	if ($is_banned) {
		$mosmsg = _UDDEIM_YOUAREBANNED;
		echo($mosmsg);
		return;
	}
}

// Check if default record for message notification and popups for the current user must be created. If a record already exists, then nothing to do...
if (!uddeIMexistsEMN((int)$userid))
	uddeIMinsertEMNdefaults((int)$userid, $config);

if (uddeIMgetEMNlocked($userid)) {
	$mosmsg = _UDDEIM_ACCOUNTLOCKED;
	echo($mosmsg);
	return;
}

// first check config for overwrite itemid
if ($config->overwriteitemid && (int)$config->useitemid) {
	$Itemid = (int)$config->useitemid;
} else {   // if no Itemid is passed on, try to find one somewhere
    $Itemid = uddeIMmosGetParam( $_REQUEST, 'Itemid');
}
if (!$Itemid || !isset($Itemid) || empty( $Itemid )) {
	$Itemid = uddeIMgetItemid($config);
}

$item_id	= (int) $Itemid;
$task		= uddeIMmosGetParam( $_REQUEST, 'task', '');

$view		= uddeIMmosGetParam( $_REQUEST, 'view', '');
$id			= uddeIMmosGetParam( $_REQUEST, 'id', 0);
if (!$task && $view=="select") {
	switch($id) {
		case 1: $task="inbox";		break;
		case 2: $task="outbox";		break;
		case 3: $task="trashcan";	break;
		case 4: $task="archive";	break;
		case 5: $task="settings";	break;
		case 6: $task="showlists";	break;
		case 7: $task="new";		break;
		case 8: $task="postbox";	break;
	}
}
if( $config->enablepostbox )
	if ($task=="inbox" || $task=="outbox")
		$task="postbox";

$messageid	= (int)uddeIMmosGetParam ( $_REQUEST, 'messageid');
$recip		= (int)uddeIMmosGetParam ( $_REQUEST, 'recip');				// blocking ID and new message
$runame		= uddeIMmosGetParam ( $_REQUEST, 'runame');					//  blocking NAME and new message
$ret		= uddeIMmosGetParam ( $_REQUEST, 'ret');

$to_id		= (int)uddeIMmosGetParam ($_POST, 'to_id');
$to_name	= uddeIMmosGetParam ($_POST, 'to_name');
$pmessage	= strip_tags(uddeIMmosGetParam($_POST, 'pmessage', '', _MOS_ALLOWHTML));
$cryptpass  = uddeIMmosGetParam ($_POST, 'cryptpass');

$sendeform_showallusers = uddeIMmosGetParam ($_POST, 'sendeform_showallusers', '');
$tobedeleted	= (int)uddeIMmosGetParam ($_POST, 'tobedeleted', 0);
$tobedeletedsent= (int)uddeIMmosGetParam ($_POST, 'tobedeletedsent', 0);
$copytome		= (int)uddeIMmosGetParam ($_POST, 'copytome', 0);
if ($config->addccline)
	$addccinfo		= (int)uddeIMmosGetParam ($_POST, 'addccinfo', 0);
else
	$addccinfo		= 0;
$forceembedded	= (int)uddeIMmosGetParam ($_POST, 'forceembedded', 0);

$emailradio		= (int)uddeIMmosGetParam ($_POST, 'emailradio', 0);
$emailreplycheck= (int)uddeIMmosGetParam ($_POST, 'emailreplycheck', 0);
$popupcheck		= (int)uddeIMmosGetParam ($_POST, 'popupcheck', 0);
$publiccheck	= (int)uddeIMmosGetParam ($_POST, 'publiccheck', 0);

$autorespondercheck = uddeIMmosGetParam ($_POST, 'autorespondercheck', 0);
$autorespondertext  = strip_tags(uddeIMmosGetParam($_POST, 'autorespondertext', '', _MOS_ALLOWHTML));
$autoforwardcheck   = (int)uddeIMmosGetParam ($_POST, 'autoforwardcheck', 0);
$autoforwardid      = (int)uddeIMmosGetParam ($_POST, 'autoforwardid', 0);

$arcmes		    = uddeIMmosGetParam ($_POST, 'arcmes');
$backto			= uddeIMmosGetParam ($_POST, 'backto');

$limitstart		= (int)uddeIMmosGetParam ($_REQUEST, 'limitstart', 0) ?:
                  (int)uddeIMmosGetParam ($_REQUEST, 'start', 0);
$limit			= (int)uddeIMmosGetParam ($_REQUEST, 'limit');
if(!$limit) { $limit=$config->perpage; }
if(!$limit) { $limit=10; }

$sysgm_sys	    = uddeIMmosGetParam ($_POST, 'sysgm_sys');
$sysgm_nonotify = uddeIMmosGetParam ($_POST, 'sysgm_nonotify');
$sysgm_universe	= uddeIMmosGetParam ($_POST, 'sysgm_universe');
$sysgm_validfor	= uddeIMmosGetParam ($_POST, 'sysgm_validfor');
$sysgm_really	= uddeIMmosGetParam ($_POST, 'sysgm_really');

$fileid			= (int)uddeIMmosGetParam ($_REQUEST, 'fileid');

$filter_user = 0;
$filter_unread = 0;
$filter_flagged = 0;
if ($config->enablefilter) {
	$filter_user = (int)uddeIMmosGetParam ($_REQUEST, 'filter_user');
	$filter_check_unread = uddeIMmosGetParam ($_REQUEST, 'filter_unread');
	if ($filter_check_unread)
		$filter_unread = 1;
	$filter_check_flagged = uddeIMmosGetParam ($_REQUEST, 'filter_flagged');
	if ($filter_check_flagged)
		$filter_flagged = 1;
}
$sort_mode = 0;
if ($config->enablesort) {
	$sort_mode = (int)uddeIMmosGetParam ($_REQUEST, 'sort_mode', 0);
}

// load template css file
if(!$config->templatedir) {
	$config->templatedir="default";
}

if($task =='postbox') {
$unflagtitle = _UDDEIM_STATUS_UNFLAGGED_POSTBOX;
$flagtitle  = _UDDEIM_STATUS_FLAGGED_POSTBOX;
$unreadstr  = _UDDEIM_STATUS_UNREAD_POSTBOX;
} else {
$unflagtitle = _UDDEIM_STATUS_UNFLAGGED;
$flagtitle  = _UDDEIM_STATUS_FLAGGED;
$unreadstr  = _UDDEIM_STATUS_UNREAD;
}

// change image config values to image links
$uddeicons_flagged    = "<img class ='flagp' alt='"._UDDEIM_STATUS_FLAGGED  ."' title='".$flagtitle."' src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/staron.gif' />";
$uddeicons_unflagged  = "<img class ='flagp' alt='"._UDDEIM_STATUS_UNFLAGGED."' title='".$unflagtitle."' src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/staroff.gif' />";
$uddeicons_readpic    = "<img class ='readp' alt='"._UDDEIM_STATUS_READ     ."' title='"._UDDEIM_STATUS_READ     ."' src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/nonew_im.gif' border='0' />";
$uddeicons_unreadpic  = "<img class ='readp' alt='"._UDDEIM_STATUS_UNREAD   ."' title='".$unreadstr ."' src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/new_im.gif' border='0' />";
$uddeicons_sentunread = "<img class ='readp' alt='"._UDDEIM_STATUS_SENT  . "' title='"._UDDEIM_STATUS_SENT_UNREAD ."' src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/outnew_im.gif' border='0' />";
$uddeicons_sentpic    = "<img class ='readp' alt='"._UDDEIM_STATUS_SENT  . "' title='"._UDDEIM_STATUS_SENT ."' src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/nonew_im.gif' border='0' />";
$uddeicons_delayedpic = "<img alt='"._UDDEIM_STATUS_DELAYED  ."' title='"._UDDEIM_STATUS_DELAYED  ."' src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/delayed_im.gif' border='0' />";
$uddeicons_onlinepic  = "<img alt='"._UDDEIM_STATUS_ONLINE   ."' title='"._UDDEIM_STATUS_ONLINE   ."' src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_online.gif' />";
$uddeicons_offlinepic = "<img alt='"._UDDEIM_STATUS_OFFLINE  ."' title='"._UDDEIM_STATUS_OFFLINE  ."' src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_offline.gif' />";
$GLOBALS['uddeicons_flagged']    = $uddeicons_flagged;
$GLOBALS['uddeicons_unflagged']  = $uddeicons_unflagged;
$GLOBALS['uddeicons_onlinepic']  = $uddeicons_onlinepic;
$GLOBALS['uddeicons_offlinepic'] = $uddeicons_offlinepic;
$GLOBALS['uddeicons_readpic']    = $uddeicons_readpic;
$GLOBALS['uddeicons_unreadpic']  = $uddeicons_unreadpic;
$GLOBALS['uddeicons_delayedpic'] = $uddeicons_delayedpic;
$GLOBALS['uddeicons_sentunread'] = $uddeicons_sentunread;
$GLOBALS['uddeicons_sentpic'] = $uddeicons_sentpic;

// browser switch
$used_browser = uddeIMmosGetParam($_SERVER, 'HTTP_USER_AGENT', null);
$css_appendix="";
$css_alternative="";

/*I think we do not need these old browser checks anymore*/
/*if (stristr($used_browser, "Opera")) {
	$css_appendix="-opera";
} elseif (stristr($used_browser, "MSIE 4")) {
	$css_appendix="-ie4";
	$css_alternative="-ie";
} elseif (stristr($used_browser, "MSIE 6") || stristr($used_browser, "MSIE/6")) {
	$css_appendix="-ie6";
	$css_alternative="-ie";
} elseif (stristr($used_browser, "MSIE 7") || stristr($used_browser, "MSIE/7")) {
	$css_appendix="-ie7";
	$css_alternative="-ie";
} elseif (((stristr($used_browser, "MSIE 5") || stristr($used_browser, "MSIE/5"))) && stristr($used_browser, "Win")) {
	$css_appendix="-ie5win";
	$css_alternative="-ie";
} elseif (stristr($used_browser, "MSIE 5") && stristr($used_browser, "Mac")) {
	$css_appendix="-ie5mac";
	$css_alternative="-ie";
} elseif (stristr($used_browser, "Safari/100")) {
	$css_appendix="-safari100";
	$css_alternative="-safari";
} elseif (stristr($used_browser, "Safari/85")) {
	$css_appendix="-safari85";
	$css_alternative="-safari";
} elseif (stristr($used_browser, "Safari")) {
	$css_appendix="-safari";
} elseif (stristr($used_browser, "Konqueror/2")) {
	$css_appendix="-konq2";
	$css_alternative="-konq";
} elseif (stristr($used_browser, "Konqueror/3")) {
	$css_appendix="-konq3";
	$css_alternative="-konq";
} elseif (stristr($used_browser, "Konqueror")) {
	$css_appendix="-konq";
}*/

// 2007-11-21 zenny: changed this so default output is omitted when gettin raw output (eg for autocomplete ajax response)
$omitDefaultOutput = false;

if (uddeIMcheckJversion()>=4) {  //true on joomla5
	$jinput = Factory::getApplication()->getInput();
	$input1 = $jinput->get('no_html', false, 'BOOL');
	$input2 = $jinput->get('format', 'html', 'STRING');
	if ($input1 || 'raw'==$input2)
		$omitDefaultOutput = true;
} else {
		if (uddeIMmosGetParam($_REQUEST, 'no_html', false) || 'raw'==uddeIMmosGetParam($_REQUEST, 'format', 'raw'))
			$omitDefaultOutput = true;
}

// now start the output
if (!$omitDefaultOutput){
	echo "\n<!-- ".$versionstring." output below -->\n";

    echo "<script type=text/javascript>  //language defines for JS toggle
        var _read ='"._UDDEIM_STATUS_READ."'
        var _unread ='"._UDDEIM_STATUS_UNREAD."'
        var _flagged ='"._UDDEIM_STATUS_FLAGGED."'
        var _unflagged ='"._UDDEIM_STATUS_UNFLAGGED."'
        </script>\n";

    $css = "";
    if(file_exists($pathtouser.'/templates/'.$config->templatedir.'/css/uddeim.css')) {
		$css = $pathtosite."/components/com_uddeim/templates/".$config->templatedir."/css/uddeim.css";
	} else {
		// template css doesn't exist, now we try to load the default css file
	if(file_exists($pathtouser.'/templates/default/css/uddeim.css'))
	   	$css = $pathtosite."/components/com_uddeim/templates/default/css/uddeim.css";
	}
	uddeIMaddCSS($css);

	$version = uddeIMgetVersion();

// special css no  longer needed
 /*	if ($config->useautocomplete) {
        $css = "";
		if ($config->autocompleter==0) {
            if(file_exists($pathtouser.'/templates/'.$config->templatedir.'/css/autocompleter.css')) {
				$css = $pathtosite."/components/com_uddeim/templates/".$config->templatedir."/css/autocompleter.css";
			} else {
				// template css doesn't exist, now we try to load the default css file
				if(file_exists($pathtouser.'/templates/default/css/autocompleter.css'))
					$css = $pathtosite."/components/com_uddeim/templates/default/css/autocompleter.css";
			}
        } elseif ( $config->autocompleter==6 || $config->autocompleter==7) {
            if(file_exists($pathtouser.'/templates/'.$config->templatedir.'/css/meio.aucomplete.css')) {
				$css = $pathtosite."/components/com_uddeim/templates/".$config->templatedir."/css/meio.aucomplete.css";
			} else {
				// template css doesn't exist, now we try to load the default css file
				if(file_exists($pathtouser.'/templates/default/css/meio.aucomplete.css'))
					$css = $pathtosite."/components/com_uddeim/templates/default/css/meio.aucomplete.css";
			}
        }
			uddeIMaddCSS($css);
	} */

	/*if ($config->useautocomplete) {
		if ( $config->autocompleter==6 || $config->autocompleter==7) {
			$css = "";
			if(file_exists($pathtouser.'/templates/'.$config->templatedir.'/css/meio.aucomplete.css')) {
				$css = $pathtosite."/components/com_uddeim/templates/".$config->templatedir."/css/meio.aucomplete.css";
			} else {
				// template css doesn't exist, now we try to load the default css file
				if(file_exists($pathtouser.'/templates/default/css/meio.aucomplete.css'))
					$css = $pathtosite."/components/com_uddeim/templates/default/css/meio.aucomplete.css";
			}
			uddeIMaddCSS($css);
		}
	}*/

	echo "<div id='uddeim'><div id='uddeim-topborder'></div>\n";
}

// fork according to task
switch ($task) {

	case "downloadOutbox":
	case "downloadInbox":
		if( $config->enableattachment )
			uddeIMdownloadAttachments($task, $userid, $item_id, $messageid, $fileid, $config);
		break;

	// --------------------------------------------------

	case "showlists":
		require_once($pathtouser.'/userlists.php');
		uddeIMshowLists($userid, $item_id, $limit, $limitstart, $config);
		break;
	case "createlists":
		require_once($pathtouser.'/userlists.php');
		uddeIMcreateLists($userid, $item_id, 0, $limit, $limitstart, $config);
		break;
	case "editlists":
		require_once($pathtouser.'/userlists.php');
		$listid		= (int) uddeIMmosGetParam ($_REQUEST, 'listid', 0);
		uddeIMcreateLists($userid, $item_id, $listid, $limit, $limitstart, $config);
		break;
	case "savelists":
		require_once($pathtouser.'/userlists.php');
		$listid		= (int) uddeIMmosGetParam ($_REQUEST, 'listid', 0);
		$listname	= uddeIMmosGetParam ($_REQUEST, 'listname');
		$listdesc	= uddeIMmosGetParam ($_REQUEST, 'listdesc');
		$listids	= uddeIMmosGetParam ($_REQUEST, 'listids');
		$listglobal = (int) uddeIMmosGetParam ($_REQUEST, 'listglobal', 0);
		uddeIMsaveLists($userid, $item_id, $listid, $listname, $listdesc, $listids, $listglobal, $config);
		break;
	case "deletelists":
		require_once($pathtouser.'/userlists.php');
		$listid		= (int) uddeIMmosGetParam ($_REQUEST, 'listid', 0);
		uddeIMdeleteLists($userid, $item_id, $listid, $limit, $limitstart, $config);
		break;
	case "deletelistsmultiple":
		require_once($pathtouser.'/userlists.php');
		uddeIMdeleteListsMultiple($userid, $item_id, $arcmes, $limit, $limitstart, $config);
		break;

// --------------------------------------------------

	case "postbox":
		if( $config->enablepostbox ) {
			uddeIMemit("onPostbox", Array( "userid" => $userid ) );
			uddeIMshowPostbox($userid, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);
		}
		break;

	case "postboxuser":
		if( $config->enablepostbox )
			uddeIMshowPostboxUser($userid, $recip, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);
		break;

	case "mulpostboxdelete":
		if( $config->enablepostbox )
			uddeIMdeleteMessagePostboxMultiple($userid, $recip, $arcmes, $limit, $limitstart, $item_id, $config);
		break;

	case "postboxdeleteinbox":
		if( $config->enablepostbox )
			uddeIMdeleteMessagePostbox($userid, $messageid, $recip, "inbox", $limit, $limitstart, $item_id, $config);
		break;

	case "postboxdeleteoutbox":
		if( $config->enablepostbox )
			uddeIMdeleteMessagePostbox($userid, $messageid, $recip, "outbox", $limit, $limitstart, $item_id, $config);
		break;

	case "deletealluser":
		if( $config->enablepostbox )
			uddeIMdeletePostboxUser($userid, $recip, $limit, $limitstart, $item_id, $config);
		break;

	case "muldeletealluser":
		if( $config->enablepostbox )
			uddeIMdeletePostbox($userid, $arcmes, $limit, $limitstart, $item_id, $config);
		break;

// --------------------------------------------------

	case "inbox":
		require_once($pathtouser.'/inbox.php');
		uddeIMemit("onInbox", Array( "userid" => $userid ) );
		uddeIMshowInbox($userid, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);
		break;

	case "show":
		require_once($pathtouser.'/inbox.php');
		uddeIMshowMessage($userid, $item_id, $messageid, false, $cryptpass, $config);
		break;

	case "showpass":
		require_once($pathtouser.'/inbox.php');
		uddeIMshowPass($userid, $item_id, $messageid, $config);
		break;

	case "forward":
		require_once($pathtouser.'/inbox.php');
		uddeIMshowMessage($userid, $item_id, $messageid, true, $cryptpass, $config);
		break;

	case "forwardpass":
		require_once($pathtouser.'/inbox.php');
		uddeIMforwardPass($userid, $item_id, $messageid, $config);
		break;

	case "delete":
		require_once($pathtouser.'/inbox.php');
		uddeIMdeleteMessageInbox($userid, $messageid, $limit, $limitstart, $item_id, $ret, $config);
		break;

	case "muldelete":
		require_once($pathtouser.'/inbox.php');
		uddeIMdeleteInbox($userid, $item_id, $arcmes, $limit, $limitstart, $config);
		break;

// --------------------------------------------------

	case "outbox":
		require_once($pathtouser.'/outbox.php');
		uddeIMemit("onOutbox", Array( "userid" => $userid ) );
		uddeIMshowOutbox($userid, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);
		break;

	case "showout":
		require_once($pathtouser.'/outbox.php');
		uddeIMshowOutmessage($userid, $item_id, $messageid, false, $cryptpass, $config);
		break;

	case "showoutpass":
		require_once($pathtouser.'/outbox.php');
		uddeIMshowOutPass($userid, $item_id, $messageid, $config);
		break;

	case "forwardoutbox":
		require_once($pathtouser.'/outbox.php');
		uddeIMshowOutmessage($userid, $item_id, $messageid, true, $cryptpass, $config);
		break;

	case "forwardoutboxpass":
		require_once($pathtouser.'/outbox.php');
		uddeIMforwardOutPass($userid, $item_id, $messageid, $config);
		break;

	case "deletefromoutbox":
		require_once($pathtouser.'/outbox.php');
		uddeIMdeleteMessageOutbox($userid, $messageid, $limit, $limitstart, $item_id, $ret, $config);
		break;

	case "outboxmuldelete":
		require_once($pathtouser.'/outbox.php');
		uddeIMdeleteOutbox($userid, $item_id, $arcmes, $limit, $limitstart, $config);
		break;

	case "recall":
		require_once($pathtouser.'/outbox.php');
		uddeIMrecallMessage($userid, $item_id, $messageid, $cryptpass, $config);
		break;

	case "recallpass":
		require_once($pathtouser.'/outbox.php');
		uddeIMrecallPass($userid, $item_id, $messageid, $config);
		break;

// --------------------------------------------------

	case "trashcan":
		require_once($pathtouser.'/trashcan.php');
		uddeIMemit("onTrashcan", Array( "userid" => $userid ) );
		uddeIMshowTrashCan($userid, $item_id, $limit, $limitstart, $cryptpass, $config);
		break;

	case "restore":
		require_once($pathtouser.'/trashcan.php');
		uddeIMrestoreMessage($userid, $messageid, $limit, $limitstart, $item_id, $config);
		break;

// --------------------------------------------------

	case "archive":
		require_once($pathtouser.'/archive.php');
		uddeIMemit("onArchive", Array( "userid" => $userid ) );
		uddeIMarchive($userid, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);
		break;

	case "archivemessage":
		require_once($pathtouser.'/archive.php');
		uddeIMarchiveMessage ($userid, $item_id, $messageid, $cryptpass, $config);
		break;

	case "unarchive":
		require_once($pathtouser.'/archive.php');
		uddeIMunarchiveMessage($userid, $messageid, $limit, $limitstart, $item_id, $config);
		break;

	case "archivedownload":
		require_once ($pathtouser.'/archive.php');
		uddeIMarchiveDownload($userid, $item_id, $arcmes, $limit, $limitstart, $cryptpass, $config);
		break;

	case "archivetrash":
		require_once ($pathtouser.'/archive.php');
		uddeIMarchiveTrash($userid, $item_id, $arcmes, $limit, $limitstart, $config);
		break;

// --------------------------------------------------

	case "prune":
		uddeIMpruneMessages($userid, $item_id, 0, $task, $config);	// group id not required here
		break;

	case "fileprune":
		uddeIMpruneFiles($userid, $item_id, 0, $task, $config);	// group id not required here
		break;

// --------------------------------------------------

	case "save":
		uddeIMsaveMessage($userid, $to_name, $to_id, $pmessage, $tobedeleted, $tobedeletedsent, $forceembedded, $item_id, $messageid, $copytome, $addccinfo, $sendeform_showallusers, $cryptpass, $backto, $config);
		break;

	case "new":
		uddeIMemit("onCompose", Array( "userid" => $userid ) );
		uddeIMnewMessage($userid, $item_id, $to_id, $recip, $runame, $pmessage, 0, 0, $config);
		break;

	case "reply":
		uddeIMnewMessage($userid, $item_id, $to_id, $recip, $runame, $pmessage, $messageid, 0, $config);	// für echtes Reply = 1
		break;

	case "version":
		echo "<h2>Installed uddeIM version</h2>\n";
		echo $versionstring;
		echo "<div id='uddeim-bottomborder'></div>\n";
		break;

	case "sysgm":
	    uddeIMnewSysgm($userid, $item_id, $to_id, $pmessage, $config);
		break;

	case "savesysgm":
	    uddeIMsaveSysgm($userid, $to_name, $to_id, $pmessage, $tobedeleted, $tobedeletedsent, $forceembedded, $item_id, $messageid, $sysgm_sys, $sysgm_nonotify, $sysgm_universe, $sysgm_validfor, $sysgm_really, $cryptpass, $config);
		break;

	case "markread":
		uddeIMmarkRead($userid, $messageid, $limit, $limitstart, $item_id, $recip, $ret, $config);
		break;

	case "markunread":
		uddeIMmarkUnread($userid, $messageid, $limit, $limitstart, $item_id, $recip, $ret, $config);
		break;

	case "flag":
		uddeIMmarkFlagged($userid, $messageid, $limit, $limitstart, $item_id, $recip, $ret, $config);
		break;

	case "unflag":
		uddeIMmarkUnflagged($userid, $messageid, $limit, $limitstart, $item_id, $recip, $ret, $config);
		break;

	case "blockuser":
		uddeIMblockUserUdde($userid, $item_id, $recip, $ret, $config);
		break;

	case "unblockuser":
		uddeIMunblockUserUdde($userid, $item_id, $recip, $ret, $config);
		break;

	case "reportspam":
		uddeIMreportSpam($userid, $item_id, $messageid, $recip, $ret, $limit, $limitstart, $config);
		break;

	case "unreportspam":
		uddeIMunreportSpam($userid, $item_id, $messageid, $recip, $ret, $limit, $limitstart, $config);
		break;

	case "settings":
		uddeIMemit("onSettings", Array( "userid" => $userid ) );
		uddeIMshowSettings($userid, $item_id, $config);
		break;

	case "about":
		uddeIMemit("onAbout", Array( "userid" => $userid ) );
		uddeIMshowAbout($userid, $item_id, $versionstring, $usedlanguage, $config);
		break;

	case "help":
		uddeIMemit("onHelp", Array( "userid" => $userid ) );
		uddeIMshowHelp($userid, $item_id, $versionstring, $config);
		break;

	case "saveemn":
		uddeIMsaveEMN($userid, $item_id, $emailradio, $emailreplycheck, $config);
		break;

	case "saveresponderemn":
		uddeIMsaveAutoresponderEMN($userid, $item_id, $autorespondertext, $autorespondercheck, $config);
		break;

	case "saveforwardemn":
		uddeIMsaveAutoforwardEMN($userid, $item_id, $autoforwardid, $autoforwardcheck, $config);
		break;

	case "saveuseremn":
		uddeIMsaveUserEMN($userid, $item_id, $popupcheck, $publiccheck, $config);
		break;

	// 2007-11-21 zenny: added this to route onto autocomplete ajax return
	case 'completeUserName':
		uddeIMcompleteUserName($userid, $config);
		break;

	case 'ajaxGetNewMessages':
		uddeIMajaxGetNewMessages($userid, $config);
		break;

	default:
		if( $config->enablepostbox ) {
			uddeIMemit("onPostbox", Array( "userid" => $userid ) );
			uddeIMshowPostbox($userid, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);
			break;
		}
		require_once($pathtouser.'/inbox.php');
		uddeIMemit("onInbox", Array( "userid" => $userid ) );
		uddeIMshowInbox($userid, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode, $sort_mode);
		break;
}

if (!$omitDefaultOutput){
	echo "</div>\n";		// </div id='uddeim'>
	echo "<!-- ".$versionstring." output above -->\n";
}

// *****************************************************************************************

function uddeIMpruneMessages($myself, $item_id, $my_gid, $task, $config) {
	// check if this can be called by admins or superadmins only (=1 admins/superadmins automatically, =2 admins/superadmins manually)
	$my_gid = $config->usergid;
	if ($config->adminignitiononly>0) {
		if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
			echo _UDDEIM_VIOLATION;
			return;
//			_osRedirect(uddeIMsefRelToAbs("index.php?option=com_uddeim"), _UDDEIM_VIOLATION);
		}
	}
	uddeIMdoPrune($config);
	uddeIMreminderDispatch($item_id, $config);		// process forgetmenot emails

	if ($task=="prune") {
		$mosmsg="uddeIM Prune";
		uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id, $mosmsg);
	}
}

function uddeIMpruneFiles($myself, $item_id, $my_gid, $task, $config) {
	// check if this can be called by admins or superadmins only (=1 admins/superadmins automatically, =2 admins/superadmins manually)
	$my_gid = $config->usergid;
	if ($config->fileadminignitiononly>0) {
		if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
			echo _UDDEIM_VIOLATION;
			return;
		}
	}
	uddeIMdoFilePrune($config);

	if ($task=="fileprune") {
		$mosmsg="uddeIM File prune";
		uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id, $mosmsg);
	}
}

// *****************************************************************************************

function uddeIMsaveMessage($myself, $to_name, $to_id, $pmessage, $tobedeleted, $tobedeletedsent, $forceembedded, $item_id, $messageid, $copytome, $addccinfo, $sendeform_showallusers, $cryptpass, $backto, $config) {
	$database = uddeIMgetDatabase();

	$to_name = stripslashes($to_name ?? '');

	// I could have modified this function to process mails to public users but instead of adding
	// several exceptions it is better to have an own function for this purpose.
	// Everything we need is available here, so we can use this for the new function.
	// When we have the public frontend enabled and the user saves a REPLY (=$messageid exists) and the receiver is a public user then do it...
	if ($config->pubfrontend && $messageid && !$to_id) {
		uddeIMtoPublicSaveMessage($myself, $pmessage, $tobedeleted, $tobedeletedsent, $forceembedded, $item_id, $messageid, $copytome, $cryptpass, $backto, $config);
		return;
	}

	$my_gid = $config->usergid;
	$to_name_bak = $to_name;				// save all already typed in names

	if($config->inboxlimit) {
		if ($config->allowarchive) {		// have an archive and an "archive and inbox" limit, so get number of messages in inbox and archive
			$total = uddeIMgetInboxArchiveCount($myself);
		} else {							// user has switched of archive but there is an limit for "inbox and archive", so count inbox messages only
			$total = uddeIMgetInboxCount($myself);
		}
		if($total>$config->maxarchive && !uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
			$mosmsg=_UDDEIM_MSGLIMITREACHED;
			uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id, $mosmsg);
		}
	}
	
	// link to drop down box with names of connected users, value is 2 since it is shown the first time (so selecting the link does not show an error message because of an empty recipient field)
	if(!$to_id && !$to_name && $sendeform_showallusers!=2) {
		// write the uddeim menu
		uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 5, $config);
		return;
	}

	if($sendeform_showallusers) {	// =2, click on button / =1, keep on showing
		// write the uddeim menu
		uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 1, $config);
		return;
	}

	$lastsent = uddeIMgetEMNlastsent($myself);
	$flooding = 0;
	if ($config->timedelay>0) {
		if (uddeIMisReggedOnly($config->usergid)) {
			if ($lastsent) {
				$delay = uddetime($config->timezone) - $lastsent;
				if ($delay <= $config->timedelay)
					$flooding = 1;
			}
		}
	}
	if($flooding) {
		// write the uddeim menu
		uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 14, $config);
		return;
	}
	
	if( ($config->enablelists==1) ||
	    ($config->enablelists==2 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) ||
	    ($config->enablelists==3 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) ) {
		// when userlists are not enabled, then "#listname" is treated as "normal" username
		$ok = uddeIMreplaceListsWithNames($to_name, $myself, $config);
		if (!$ok) {
			// write the uddeim menu
			uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 11, $config);
			return;
		}
		// the list is ok, so we work with the expanded names from now
		$to_name_bak = $to_name;					// save all expanded names, we do not want to work with lists because this minimizes db queries
	}

	if ($config->separator==1)
		$anames = explode(";", $to_name);
	else
		$anames = explode(",", $to_name);

	// expand always, so the next condition may be fulfilled
	if( ( $config->allowmultiplerecipients && count($anames)>$config->maxrecipients && $config->maxrecipients>0) ||
		(!$config->allowmultiplerecipients && count($anames)>1)	) { // too many recipients
		// write the uddeim menu
		uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 6, $config);
		return;
	}

	// FIRST ROUND: Check all names that were typed in (lists have been replaced by the corresponding names)
	// ATTENTION: $to_name contains one name only below this line, to restore what the user typed in use $to_name_bak

	// NOTE: A reply contains a valid $to_id and an emtpy string in $to_name, so the array contains an empty entry here.
	foreach ($anames as $value) {

		$to_name = trim($value);

		// when we have a name, then resolve the name
		// remember that replies provide $to_id only and $to_name is empty, so do not try to resolve names when it is empty
		if ($to_name) {
			$to_id = uddeIMgetIDfromName($to_name, $config, true);		// add "AND block=0"
			// BUGBUG: maybe it is a good idea to do the query vice versa (so I could add a query for "realname"s here)
			if (!$to_id) { // no user with this name found, so try again with username (maybe we do the query twice (see query above, but who cares)
				if ($config->realnames) {
					$to_id = uddeIMgetIDfromUsername($to_name, true);	// add "AND block=0"
				}
			}

			if(!$to_id) { // no user with this username found
				// display to form again so that the user can correct his/her fault
				// the wrong name is displayed in brackets (add brackets only once)
				if (substr($to_name,0,1)!="(") {
					$to_name = str_replace($to_name, "(".$to_name.")", $to_name_bak);
				}
				// write the uddeim menu
				uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 3, $config);
				return;
			} elseif ($to_id==$myself) { // don't send to yourself
				if (substr($to_name,0,1)!="(") {
					$to_name = str_replace($to_name, "(".$to_name.")", $to_name_bak);
				}
				// write the uddeim menu
//				$to_name=stripslashes($to_name_bak);		// all names
				uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 2, $config);
				return;
			}
		}

		// now check banning
		if (uddeIMisAllNotAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {	// I am not an admin, so check if the recipient has been banned
			$is_banned = uddeIMisBanned($to_id, $config);
			if ($is_banned) {
				if (substr($to_name,0,1)!="(") {
					$to_name = str_replace($to_name, "(".$to_name.")", $to_name_bak);
				}
				// write the uddeim menu
				uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 17, $config);
				return;
			}
		}

		// now check blocking
		$isblocked = uddeIMcheckBlockerBlocked($to_id, $myself);
		// well, should be changed in a way that the user can change his input again
		if ($isblocked && $config->blocksystem) { // must not send message to to_id
			if ($config->blockalert) { // sending user shall be informed that (s)he's been blocked
				if (substr($to_name,0,1)!="(") {
					$to_name = str_replace($to_name, "(".$to_name.")", $to_name_bak);
				}
				// write the uddeim menu
				uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 9, $config);
				return;
			}
		}

		// now check group blocking
		if (uddeIMisReggedOnly($my_gid)) {	// I am a registered user, so check if I am allowed to send to this group
			$is_group_blocked = uddeIMisRecipientBlockedReg($myself, $to_id, $config);
			if ($is_group_blocked) {
				if (substr($to_name,0,1)!="(") {
					$to_name = str_replace($to_name, "(".$to_name.")", $to_name_bak);
				}
				// write the uddeim menu
				uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 10, $config);
				return;
			}
		}
	}

	if(!$pmessage) {
		// write the uddeim menu
		$to_name = $to_name_bak;
		uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 4, $config);
		return;
	}

	// BADWORDFILTER
	$temp = trim($config->badwords);
	if ($temp) {
		$badwordlist = explode(";", $temp);
		//$badwordlist = Array();
		//$badwordlist[] = 'badword1';
		//$badwordlist[] = 'badword2';

		$pmessage_orig = $pmessage;
		// foreach ($badwordlist as $val) {
		//	$tval = trim($val);
		//	$pmessage = preg_replace("/\b$tval\b/i", '***',$pmessage);
		// }
		foreach ($badwordlist as $key => $val) {
			$tval = trim($val);
			$badwordlist[$key] = '/'.$tval.'/i';
		}
		$pmessage = preg_replace($badwordlist, '***',$pmessage);

		if ($pmessage_orig!=$pmessage) {
			$to_name = $to_name_bak;
			uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 21, $config);
			return;
		}
	}

	// UDDEIMFILE
	// We have checked that everything is ok, now do the file uploads
	$uploadfile_temppathname = array();
	$uploadfile_original = array();
	$uploadfile_id = array(); 
	$uploadfile_size = array(); 
	$uploadfile_error = array();
	if( $config->enableattachment && uddeIMisAttachmentAllowed($my_gid, $config)) {
		$noerror = uddeIMhandleAttachments($uploadfile_temppathname, $uploadfile_original, $uploadfile_id, $uploadfile_size, $uploadfile_error, $config);
		if (!$noerror) { // something goes wrong
			// BUGBUG: that is not the best error handling possible but is will do the work
			// iterate through all errorcodes and show the first error found, rest of data will be lost
			// ==> delete all files that were uploaded ok
			foreach ($uploadfile_temppathname as $key => $value) {
				if (file_exists($value))
					unlink($value);
			}
			foreach ($uploadfile_error as $key => $value) {
				if ($value==-1) {	// upload failed
					uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 18, $config);
					return;
				}
				if ($value==-2) {	// file size exceeded
					uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 19, $config);
					return;
				}
				if ($value==-3) {	// file type not allowed
					uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 20, $config);
					return;
				}
			}
			$uploadfile_temppathname = array();		// should never been reached when an error occurs but neverthless destroy old arrays
			$uploadfile_original = array();
			$uploadfile_id = array(); 
			$uploadfile_size = array(); 
			$uploadfile_error = array();
		}
	}
	// The uploaded file is stored in "$uploadfile_tempname" (with path) ad the original name in "$uploadfile_original" (without path) and an Id for the file.
	// When we reach this line we can store these fileames in the DB.


	if(!$to_id) {					// this should never be reached
		$mosmsg = _UDDEIM_NOID;
		uddeJSEFredirect("index.php?option=com_uddeim&task=new&Itemid=".$item_id, $mosmsg);
	}

	// CAPTCHA (first check for all other errors and then the CAPTCHA)
	if (!uddeIMcheckCAPTCHA($my_gid, $config)) {
		$to_name = $to_name_bak;
		uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 7, $config);
		return;
	}

	if (!uddeIMcheckCSRF($config)) {
		$to_name = $to_name_bak;
		uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, 15, $config);
		return;
	}

	foreach ($anames as $value) {

		$to_name = trim($value);

		if ($to_name) {
			$to_id = uddeIMgetIDfromName($to_name, $config, true);		// add "AND block=0"
			// BUGBUG: maybe it is a good idea to do the query vice versa (so I could add a query for "realname"s here)
			if (!$to_id) { // no user with this name found, so try again with username (maybe we do the query twice (see query above, but who cares)
				if ($config->realnames) {
					$to_id = uddeIMgetIDfromUsername($to_name, true);	// add "AND block=0"
				}
			}
		}
		if (!$to_id) {	// that should never happen, but you never know...
			$mosmsg=_UDDEIM_NOID;
			uddeJSEFredirect("index.php?option=com_uddeim&task=new&Itemid=".$item_id, $mosmsg);
		}

		// now check blocking
		$isblocked = uddeIMcheckBlockerBlocked($to_id, $myself);
		if ($isblocked && $config->blocksystem) { // must not send message to to_id
			continue;
		}

		$savedatum  = uddetime($config->timezone);
		$savetoid   = $to_id;
		$savefromid = $myself;

		// CRYPT
		if ($config->cryptmode>=1) {	// because of encoding do not use slashes
			$savemessage=strip_tags($pmessage);
		} else {
			$savemessage=addslashes(strip_tags($pmessage));   // original 0.6+
		}

		$savemessage = uddeIMRemoveXSS($savemessage);

		if (!$config->allowbb)
			$savemessage=uddeIMbbcode_strip($savemessage);

		// set message max length
		if ($config->maxlength>0)		// because if 0 do not use any maxlength
			$savemessage=uddeIM_utf8_substr($config->languagecharset, $savemessage, 0, $config->maxlength);

		// add CC: information
		if ($config->allowmultipleuser && $addccinfo && count($anames)>1) {
			$ccinfo = implode(", ", $anames);
			if ($config->allowbb)
				$ccheader = "\n\n[i]"._UDDEIM_CC." ".(($config->cryptmode>=1) ? $ccinfo : addslashes($ccinfo))."[/i]";
			else
				$ccheader = "\n\n"._UDDEIM_CC." ".(($config->cryptmode>=1) ? $ccinfo : addslashes($ccinfo))."";
			$savemessage .= $ccheader;
		}

		// ##################################################################################################
		// SAVE MESSAGE
		// ##################################################################################################

		uddeIMemit("onSaveMessage", Array( "fromid" => $savefromid, "toid" => $savetoid, "replyid" => $messageid ) );
		$insID = uddeIMsaveRAWmessage($savefromid, $savetoid, $messageid, $savemessage, $savedatum, $config, $config->cryptmode, $cryptpass);

		// update lastsent field (record already exists since we check this at the very beginning of this component)
		uddeIMupdateEMNlastsent($myself, uddetime($config->timezone));

		// When the account is moderated, delay the message
		$ismoderated = uddeIMgetEMNmoderated($myself);
		if ($ismoderated) { // && uddeIMisReggedOnly($my_gid)) {
			uddeIMupdateDelayed($myself, $insID, 1);
		}

		// Check if E-Mail notification or popups are enabled by default, if so create a record for the receiver.
		// Note: Not necessary for "copy to myself" sind the record for the current user has been set at the very beginning...
		if ($config->modnewusers>0 || $config->notifydefault>0 || $config->popupdefault>0 || $config->pubfrontenddefault>0 || $config->autoresponder>0 || $config->autoforward>0) {
			if (!uddeIMexistsEMN($savetoid))
				uddeIMinsertEMNdefaults($savetoid, $config);
		}

		// get the group ID of the recipient
		$rec_gid = uddeIMgetGID((int)$savetoid);
		
		// UDDEIMFILE
		// Now save the uploads
		if (count($uploadfile_temppathname)>=1) {
			$num = count($uploadfile_temppathname);
			uddeIMemit("onSaveMessageAttachment", Array( "num" => $num, "fromid" => $savefromid, "toid" => $savetoid, "replyid" => $messageid ) );
		}
		if( $config->enableattachment && uddeIMisAttachmentAllowed($my_gid, $config))
			uddeIMsaveAttachments($insID, $uploadfile_temppathname, $uploadfile_original, $uploadfile_id, $uploadfile_size, $savedatum, $config);

		
		// ##################################################################################################
		// autoforward code
		// ##################################################################################################
		if ($config->autoforward==1 || 
		   ($config->autoforward==2 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) ||
		   ($config->autoforward==3 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) ) {

           $ison = uddeIMgetEMNautoforward($savetoid);						// recipient has autoforward enabled
			if ($ison==1) {
				$autoforwardid = uddeIMgetEMNautoforwardid($savetoid);	// new recipient

				if (uddeIMgetUserExists($autoforwardid)) {
					if (!uddeIMgetUserBlock($autoforwardid)) {
						$temp = uddeIMgetNameFromID($savetoid, $config);
						$temp = (($config->cryptmode>=1) ? $temp : addslashes($temp));
						if ($config->allowbb)
							$forwardheader="\n\n[i]("._UDDEIM_THISISAFORWARD.$temp.")[/i]";
						else
							$forwardheader="\n\n("._UDDEIM_THISISAFORWARD.$temp.")";
						$savemessagecopy = $savemessage.$forwardheader;

						$insIDforward = uddeIMsaveRAWmessage($savefromid, $autoforwardid, 0, $savemessagecopy, $savedatum, $config, $config->cryptmode, $cryptpass);

						// When the account is moderated, delay also the forwarded message
						if (uddeIMgetEMNmoderated($myself) ) { // && uddeIMisReggedOnly($my_gid)) {
							uddeIMupdateDelayed($myself, $insIDforward, 1);
						}

						// UDDEIMFILE
						if( $config->enableattachment && uddeIMisAttachmentAllowed($my_gid, $config))
							uddeIMsaveAttachments($insIDforward, $uploadfile_temppathname, $uploadfile_original, $uploadfile_id, $uploadfile_size, $savedatum, $config);
					}
				}
			}
		}

		// ##################################################################################################
		// copy to myself?
		// ##################################################################################################
		if($copytome && $config->allowcopytome) {
			$to_name = uddeIMgetNameFromID($savetoid, $config);
			// set reply id if necessary (also copy2me messages might be replies)
			$replyid = $messageid;

			$temp = (($config->cryptmode>=1) ? $to_name : addslashes($to_name));
			if ($config->allowbb)
				$copyheader="\n\n[i]("._UDDEIM_THISISACOPY.$temp.")[/i]";
			else
				$copyheader="\n\n("._UDDEIM_THISISACOPY.$temp.")";

			$savemessagecopy = $savemessage.$copyheader;
			$copyname = _UDDEIM_TO_SMALL." ".$temp;		// "to username" in systemmsg
			// if($config->allowarchive) { $archiveflag=1; }

			// it is a copy to myself, so assume that the message has already been trashed in the senders outbox (remember: system messages are not shown in the outbox)
			// so set totrashoutbox=1, totrashdateoutbox=uddetime($config->timezone)
			// CRYPT
			$themode=0;
			if ($config->cryptmode==1) {
				$cm = uddeIMencrypt($savemessagecopy,$config->cryptkey,CRYPT_MODE_BASE64);
				$sql="INSERT INTO `#__uddeim` (fromid, toid, replyid, toread, message, datum, disablereply, systemflag, systemmessage, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$savefromid.", ".(int)$savefromid.", ".(int)$replyid.", 1, '".$cm."', ".$savedatum.", 1, 2, '".$copyname."', 1,".$savedatum.",1,'".md5($config->cryptkey)."')";
			} elseif ($config->cryptmode==2) {
				$themode=2;
				$thepass=$cryptpass;
				if (!$thepass) {	// no password entered, then fallback to obfuscating
					$themode=1;
					$thepass=$config->cryptkey;
				}
				$cm = uddeIMencrypt($savemessagecopy,$thepass,CRYPT_MODE_BASE64);
				$sql="INSERT INTO `#__uddeim` (fromid, toid, replyid, toread, message, datum, disablereply, systemflag, systemmessage, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$savefromid.", ".(int)$savefromid.", ".(int)$replyid.", 1, '".$cm.             "', ".$savedatum.", 1, 2, '".$copyname."', 1,".$savedatum.",".$themode.",'".md5($thepass)."')";
			} elseif ($config->cryptmode==3) {
				$cm = uddeIMencrypt($savemessagecopy,"",CRYPT_MODE_STOREBASE64);
				$sql="INSERT INTO `#__uddeim` (fromid, toid, replyid, toread, message, datum, disablereply, systemflag, systemmessage, totrashoutbox, totrashdateoutbox, cryptmode) VALUES (".(int)$savefromid.", ".(int)$savefromid.", ".(int)$replyid.", 1, '".$cm."', ".$savedatum.", 1, 2, '".$copyname."', 1,".$savedatum.",3)";
			} elseif ($config->cryptmode==4) {
				$themode=4;
				$thepass=$cryptpass;
				$cipher = CRYPT_MODE_OSSL_AES_256;
				if (!$thepass) {	// no password entered, then fallback to obfuscating
					$themode=1;
					$thepass=$config->cryptkey;
					$cipher = CRYPT_MODE_BASE64;
				}
				$cm = uddeIMencrypt($savemessagecopy,$thepass,$cipher);
				$sql="INSERT INTO `#__uddeim` (fromid, toid, replyid, toread, message, datum, disablereply, systemflag, systemmessage, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$savefromid.", ".(int)$savefromid.", ".(int)$replyid.", 1, '".$cm.             "', ".$savedatum.", 1, 2, '".$copyname."', 1,".$savedatum.",".$themode.",'".md5($thepass)."')";
			} else {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, replyid, toread, message, datum, disablereply, systemflag, systemmessage, totrashoutbox, totrashdateoutbox) VALUES (".(int)$savefromid.", ".(int)$savefromid.", ".(int)$replyid.", 1, '".$savemessagecopy."', ".$savedatum.", 1, 2, '".$copyname."', 1,".$savedatum.")";
			}
			$database->setQuery($sql);
			try {
				$database->execute();
			} catch(Exception $e) {
				throw new Exception("SQL error when attempting to save a message. " . get_class($e));
			}
			
			// UDDEIMFILE
			$insCopyID = $database->insertid();
			if( $config->enableattachment && uddeIMisAttachmentAllowed($my_gid, $config))
				uddeIMsaveAttachments($insCopyID, $uploadfile_temppathname, $uploadfile_original, $uploadfile_id, $uploadfile_size, $savedatum, $config);
			
		}

		// ##################################################################################################
		// autoresponder
		// ##################################################################################################
		if ($config->autoresponder==1 || 
		   ($config->autoresponder==2 && (uddeIMisAdmin($rec_gid) || uddeIMisAdmin2($rec_gid, $config)))) {

           $ison = uddeIMgetEMNautoresponder($savetoid);
			if ($ison==1) {

				// NOTE: An autoresponder message is created and the outbox message is marked deleted.
				// This is not a bug since in my opinion it does not make sense to store autoresponder messages AND the received message.
				$autorespondertext = uddeIMgetEMNautorespondertext($savetoid);
				$savemessage2=addslashes(strip_tags($autorespondertext));
				// $sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, totrashoutbox, totrashdateoutbox) VALUES (".(int)$savetoid.", ".(int)$savefromid.", '". $savemessage ."', ".$savedatum.", 1,".$savedatum.")";

				$themode=0;
				if ($config->cryptmode==1) {
					$themode=1;
					$thepass=$config->cryptkey;
					$cm = uddeIMencrypt($savemessage2,$thepass,CRYPT_MODE_BASE64);
					$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$savetoid.", ".(int)$savefromid.", '". $cm ."', ".$savedatum.", 1,".$savedatum.",".$themode.",'".md5($thepass)."')";
				} elseif ($config->cryptmode==2) {
					// no password entered, then fallback to obfuscating
					$themode=1;
					$thepass=$config->cryptkey;
					$cm = uddeIMencrypt($savemessage2,$thepass,CRYPT_MODE_BASE64);
					$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$savetoid.", ".(int)$savefromid.", '". $cm ."', ".$savedatum.", 1,".$savedatum.",".$themode.",'".md5($thepass)."')";
				} elseif ($config->cryptmode==3) {
					$cm = uddeIMencrypt($savemessage2,"",CRYPT_MODE_STOREBASE64);
					$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$savetoid.", ".(int)$savefromid.", '". $cm ."', ".$savedatum.", 1,".$savedatum.", 3)";
				} elseif ($config->cryptmode==4) {
					// no password entered, then fallback to obfuscating
					$themode=1;
					$thepass=$config->cryptkey;
					$cm = uddeIMencrypt($savemessage2,$thepass,CRYPT_MODE_BASE64);
					$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$savetoid.", ".(int)$savefromid.", '". $cm ."', ".$savedatum.", 1,".$savedatum.",".$themode.",'".md5($thepass)."')";
				} else {
					$cm = $savemessage2;
					$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, totrashoutbox, totrashdateoutbox) VALUES (".(int)$savetoid.", ".(int)$savefromid.", '". $cm ."', ".$savedatum.", 1,".$savedatum.")";
				}
				$database->setQuery($sql);
				try {
					$database->execute();
				} catch(Exception $e) {
					throw new Exception("SQL error when attempting to save a message. " . get_class($e));
				}
			}
		}

		// ##################################################################################################
		// email notification
		// ##################################################################################################
		// is this a reply?
		$itisareply = stristr($savemessage, $config->quotedivider);
		// is the receiver currently online?
		$currentlyonline = uddeIMisOnline($savetoid);

		if ($config->cryptmode>=1) {
			$email=stripslashes($savemessage);
		} else {
			$email=stripslashes(stripslashes($savemessage));	// without encoding remove the safety slashes
		}

		if ($config->emailwithmessage==2 && !uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config) ||
			$config->emailwithmessage==1 ||
			$config->emailwithmessage==0)
			$forceembedded = 0;

		$type = $forceembedded ? 2 : 0;  // 0=normal, 1=forgetmenot, 2=admin forces text

        $ison = uddeIMgetEMNstatus($savetoid); //get user status setting
        $emailallowed = (($ison==1) || ($ison==10 && !$itisareply) ||
                        ($ison==20 && !$currentlyonline && !$itisareply) ||
                        ($ison==2 && !$currentlyonline)) ? true : false;

        $notify = '';

		// BUGBUG: it would be better to have the correct cryptmode here (it might be 1 when no password has been entered, otherwise 2
        if ($emailallowed && !$ismoderated) {     //send email if...
            if (($config->allowemailnotify==1) ||
                ($config->allowemailnotify==2 && (uddeIMisAdmin($rec_gid) || uddeIMisAdmin2($rec_gid, $config))))

        $notify = uddeIMdispatchEMN($insID, $item_id, $config->cryptmode, $savefromid, $savetoid, $email, $type, $config);
        }

		if ($tobedeletedsent) {
			$deletetime=uddetime($config->timezone);
			uddeIMdeleteMessageFromOutbox($myself, $insID, $deletetime);
		}
	}

	// delete original message?
	if ($tobedeleted) {
		$deletetime=uddetime($config->timezone);
		uddeIMdeleteMessageFromInbox($myself, $messageid, $deletetime);
	}

//Debug   $config->mailsystem==2 = debug  $config->mailsystem==3 = debug on sent
if ( $notify && ($config->mailsystem ==3 || ($config->mailsystem ==2 && !intval($notify))) ){   //debug only if email used (see 'good' value delete &&!intval($notify))
echo '<span class="alert alert-secondary">Message <b>has been sent</b> and Email shown below - only the <b>return</b> (to Inbox) <b>is skipped</b></span><br><br>';
echo  '<u>basics:</u>&emsp;allowed='.$emailallowed.' | ID='.$insID.' | item='.$item_id.' | crypt='.$config->cryptmode.' | von:'.$savefromid.' | to:'.$savetoid.' | text='.$email.' | type='.$type.'<br>';
echo '<u>maildata:</u><br>'.$notify.'<br><u>Config settings:</u><br>';
var_dump($config);
return;
}

	if($messageid) {
		$mosmsg = _UDDEIM_MESSAGE_REPLIEDTO;
        if(intval($notify))
        $mosmsg .= _UDDEIM_MESSAGE_REPLY_INFO;
    } elseif (intval($notify)) {
        $mosmsg=_UDDEIM_MESSAGEINFO_SENT.uddeIMgetNameFromID($savetoid, $config);
    } elseif ($emailallowed && $notify && !intval($notify) && !$tobedeleted) {
        $mosmsg=_UDDEIM_MESSAGEINFO_ERROR.", 'error'";
	} else {
		$mosmsg=_UDDEIM_MESSAGE_SENT.(!$emailallowed ? ' (no infomail accepted)' : '');
	}
	if ($tobedeleted) {
		$mosmsg.=_UDDEIM_MOVEDTOTRASH;
	}
  

	if($backto) {
		uddeIMmosRedirect($backto, $mosmsg);
	}
	uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id, $mosmsg);
}



// Sends a message to a "Public User"
// we need the email address here...
// instead of $to_name use the messageid and query the corresponding parameters with (messageid/toid=myself)
// $forceembedded has no function since messages TO PUBLIC USERS are always WITH full text
function uddeIMtoPublicSaveMessage($myself, $pmessage, $tobedeleted, $tobedeletedsent, $forceembedded, $item_id, $messageid, $copytome, $cryptpass, $backto, $config) {
	$mosConfig_sitename = uddeIMgetSitename();
	$pathtosite  = uddeIMgetPath('live_site');

	$database = uddeIMgetDatabase();
	$my_gid = $config->usergid;

	if($config->inboxlimit) {
		if ($config->allowarchive) {		// have an archive and an "archive and inbox" limit, so get number of messages in inbox and archive
			$total = uddeIMgetInboxArchiveCount($myself);
		} else {							// user has switched of archive but there is an limit for "inbox and archive", so count inbox messages only
			$total = uddeIMgetInboxCount($myself);
		}
		if($total>$config->maxarchive && !uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
			$mosmsg=_UDDEIM_MSGLIMITREACHED;
			uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id, $mosmsg);
		}
	}

	$lastsent = uddeIMgetEMNlastsent($myself);
	$flooding = 0;
	if ($config->timedelay>0) {
		if (uddeIMisReggedOnly($config->usergid)) {
			if ($lastsent) {
				$delay = uddetime($config->timezone) - $lastsent;
				if ($delay <= $config->timedelay)
					$flooding = 1;
			}
		}
	}
	if($flooding) {
		// write the uddeim menu
		uddeIMprintMenu($myself, 'new', $item_id, $config);
		echo "<div id='uddeim-m'>\n";
		$pmessage=stripslashes($pmessage);
		uddeIMdrawWriteform($myself, $my_gid, $item_id, "", "", $pmessage, $messageid, 1, 14, 0, $config);	// reply!!!
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}
	
	// select the message I write a reply to
	// I need the email address and the sender name of the public user (the message id is $messageid and I am $myself)
	// das war vorher... a.toid=b.id??? richtig sollte a.fromid=b.id sein, also selectInboxMessage nehmen
	// $sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.toid=b.id WHERE a.toid=".(int)$myself." AND a.id=".(int)$messageid;
	$displaymessages = 	uddeIMselectInboxMessage($myself, $messageid, $config);
	if (count($displaymessages)<1) {
		echo _UDDEIM_MESSAGENOACCESS;
		return;
	}
	foreach($displaymessages as $displaymessage) {
		$var_toname = $displaymessage->publicname;
		$var_tomail = $displaymessage->publicemail;
	}
	if (!$var_toname || $var_toname==NULL)
		$var_toname = _UDDEIM_PUBLICUSER;
	
	if(!$pmessage) {
		// write the uddeim menu
		uddeIMprintMenu($myself, 'new', $item_id, $config);
		echo "<div id='uddeim-m'>\n";
		$pmessage=stripslashes($pmessage);
		uddeIMdrawWriteform($myself, $my_gid, $item_id, "", "", $pmessage, $messageid, 1, 4, 0, $config);	// reply!!!
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

	// CAPTCHA (first check for all other errors and then the CAPTCHA)
	if (!uddeIMcheckCAPTCHA($my_gid, $config)) {
		uddeIMprintMenu($myself, 'new', $item_id, $config);
		echo "<div id='uddeim-m'>\n";
		$pmessage=stripslashes($pmessage);
		uddeIMdrawWriteform($myself, $my_gid, $item_id, "", "", $pmessage, $messageid, 1, 7, 0, $config);	// reply!!!
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

	if (!uddeIMcheckCSRF($config)) {
		uddeIMprintMenu($myself, 'new', $item_id, $config);
		echo "<div id='uddeim-m'>\n";
		$pmessage=stripslashes($pmessage);
		uddeIMdrawWriteform($myself, $my_gid, $item_id, "", "", $pmessage, $messageid, 1, 15, 0, $config);	// reply!!!
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

	$savedatum  = uddetime($config->timezone);
	$savetoid   = 0;			// reveiver is a public user

	// CRYPT
	if ($config->cryptmode>=1) {	// because of encoding do not use slashes
		$savemessage=strip_tags($pmessage);
	} else {
		$savemessage=addslashes(strip_tags($pmessage));   // original 0.6+
	}
	// strip XSS code
	$savemessage = uddeIMRemoveXSS($savemessage);

	// strip bbcodes
	if (!$config->allowbb)
		$savemessage=uddeIMbbcode_strip($savemessage);

	// set message max length
	if ($config->maxlength>0)		// because if 0 do not use any maxlength
		$savemessage=uddeIM_utf8_substr($config->languagecharset, $savemessage, 0, $config->maxlength);

	uddeIMemit("onSavePublicMessage", Array( "fromid" => $myself, "toid" => $savetoid, "replyid" => $replyid ) );
	// we have all we need, now save it
	// CRYPT
	// maybe its an reply to a message from a public user
	$replyid = $messageid;
	$fromname=addslashes(strip_tags($var_toname));
	$fromemail=addslashes(strip_tags($var_tomail));
	if ($config->cryptmode==1) {
		$cm = uddeIMencrypt($savemessage,$config->cryptkey,CRYPT_MODE_BASE64);
		$sql="INSERT INTO `#__uddeim` (publicname, publicemail, fromid, toid, replyid, message, datum, totrash, totrashdate, toread, cryptmode, crypthash) VALUES ('".$fromname."', '".$fromemail."', ".(int)$myself.", ".(int)$savetoid.", ".(int)$replyid.", '".$cm."', ".$savedatum.",1,".$savedatum.",1,1,'".md5($config->cryptkey)."')";
	} elseif ($config->cryptmode==2) {
		$themode=2;
		$thepass=$cryptpass;
		if (!$thepass) {	// no password entered, then fallback to obfuscating
			$themode=1;
			$thepass=$config->cryptkey;
		}
		$cm = uddeIMencrypt($savemessage,$thepass,CRYPT_MODE_BASE64);
		$sql="INSERT INTO `#__uddeim` (publicname, publicemail, fromid, toid, replyid, message, datum, totrash, totrashdate, toread, cryptmode, crypthash) VALUES ('".$fromname."', '".$fromemail."', ".(int)$myself.", ".(int)$savetoid.", ".(int)$replyid.", '".$cm."', ".$savedatum.",1,".$savedatum.",1,".$themode.",'".md5($thepass)."')";
	} elseif ($config->cryptmode==3) {
		$cm = uddeIMencrypt($savemessage,"",CRYPT_MODE_STOREBASE64);
		$sql="INSERT INTO `#__uddeim` (publicname, publicemail, fromid, toid, replyid, message, datum, totrash, totrashdate, toread, cryptmode) VALUES ('".$fromname."', '".$fromemail."', ".(int)$myself.", ".(int)$savetoid.", ".(int)$replyid.", '".$cm."', ".$savedatum.",1,".$savedatum.",1,3)";
	} elseif ($config->cryptmode==4) {
		$themode=4;
		$thepass=$cryptpass;
		$cipher = CRYPT_MODE_OSSL_AES_256;
		if (!$thepass) {	// no password entered, then fallback to obfuscating
			$themode=1;
			$thepass=$config->cryptkey;
			$cipher = CRYPT_MODE_BASE64;
		}
		$cm = uddeIMencrypt($savemessage,$thepass,$cipher);
		$sql="INSERT INTO `#__uddeim` (publicname, publicemail, fromid, toid, replyid, message, datum, totrash, totrashdate, toread, cryptmode, crypthash) VALUES ('".$fromname."', '".$fromemail."', ".(int)$myself.", ".(int)$savetoid.", ".(int)$replyid.", '".$cm."', ".$savedatum.",1,".$savedatum.",1,".$themode.",'".md5($thepass)."')";
	} else {
		$sql="INSERT INTO `#__uddeim` (publicname, publicemail, fromid, toid, replyid, message, datum, totrash, totrashdate, toread) VALUES ('".$fromname."', '".$fromemail."', ".(int)$myself.", ".(int)$savetoid.", ".(int)$replyid.", '".$savemessage."', ".$savedatum.",1,".$savedatum.",1)";
	}
	$database->setQuery($sql);
	try {
		$database->execute();
	} catch(Exception $e) {
		throw new Exception("SQL error when attempting to save a message. " . get_class($e));
	}
	$insID = $database->insertid();

	// update lastsent field (record already exists since we check this at the very beginning of this component)
	uddeIMupdateEMNlastsent($myself, uddetime($config->timezone));

	// copy to myself?
	if($copytome && $config->allowcopytome) {

		$temp = (($config->cryptmode>=1) ? $var_toname : addslashes($var_toname));
		if ($config->allowbb)
			$copyheader="\n\n[i]("._UDDEIM_THISISACOPY.$temp.")[/i]";
		else
			$copyheader="\n\n("._UDDEIM_THISISACOPY.$temp.")";

		// also copy2me messages can be replies
		$replyid = $messageid;
		$savemessagecopy = $savemessage.$copyheader;
		$copyname = _UDDEIM_TO_SMALL." ".$temp;			// "to username" in systemmsg
		// if($config->allowarchive) { $archiveflag=1; }

		// it is a copy to myself, so assume that the message has already been trashed in the senders outbox (remember: system messages are not shown in the outbox)
		// so set totrashoutbox=1, totrashdateoutbox=uddetime($config->timezone)
		// CRYPT
		if ($config->cryptmode==1) {
			$cm = uddeIMencrypt($savemessagecopy,$config->cryptkey,CRYPT_MODE_BASE64);
			$sql="INSERT INTO `#__uddeim` (fromid, toid, replyid, toread, message, datum, disablereply, systemflag, systemmessage, archived, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$myself.", ".(int)$myself.", ".(int)$replyid.", 1, '".$cm."', ".$savedatum.", 1, 2, '".$copyname."', 0, 1,".$savedatum.",1,'".md5($config->cryptkey)."')";
		} elseif ($config->cryptmode==2) {
			$themode=2;
			$thepass=$cryptpass;
			if (!$thepass) {	// no password entered, then fallback to obfuscating
				$themode=1;
				$thepass=$config->cryptkey;
			}
			$cm = uddeIMencrypt($savemessagecopy,$thepass,CRYPT_MODE_BASE64);
			$sql="INSERT INTO `#__uddeim` (fromid, toid, replyid, toread, message, datum, disablereply, systemflag, systemmessage, archived, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$myself.", ".(int)$myself.", ".(int)$replyid.", 1, '".$cm.             "', ".$savedatum.", 1, 2, '".$copyname."', 0, 1,".$savedatum.",".$themode.",'".md5($thepass)."')";
		} elseif ($config->cryptmode==3) {
			$cm = uddeIMencrypt($savemessagecopy,"",CRYPT_MODE_STOREBASE64);
			$sql="INSERT INTO `#__uddeim` (fromid, toid, replyid, toread, message, datum, disablereply, systemflag, systemmessage, archived, totrashoutbox, totrashdateoutbox, cryptmode) VALUES (".(int)$myself.", ".(int)$myself.", ".(int)$replyid.", 1, '".$cm."', ".$savedatum.", 1, 2, '".$copyname."', 0, 1,".$savedatum.",3)";
		} elseif ($config->cryptmode==4) {
			$themode=4;
			$thepass=$cryptpass;
			$cipher = CRYPT_MODE_OSSL_AES_256;
			if (!$thepass) {	// no password entered, then fallback to obfuscating
				$themode=1;
				$thepass=$config->cryptkey;
				$cipher = CRYPT_MODE_BASE64;
			}
			$cm = uddeIMencrypt($savemessagecopy,$thepass,$cipher);
			$sql="INSERT INTO `#__uddeim` (fromid, toid, replyid, toread, message, datum, disablereply, systemflag, systemmessage, archived, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$myself.", ".(int)$myself.", ".(int)$replyid.", 1, '".$cm.             "', ".$savedatum.", 1, 2, '".$copyname."', 0, 1,".$savedatum.",".$themode.",'".md5($thepass)."')";
		} else {
			$sql="INSERT INTO `#__uddeim` (fromid, toid, replyid, toread, message, datum, disablereply, systemflag, systemmessage, archived, totrashoutbox, totrashdateoutbox) VALUES (".(int)$myself.", ".(int)$myself.", ".(int)$replyid.", 1, '".$savemessagecopy."', ".$savedatum.", 1, 2, '".$copyname."', 0, 1,".$savedatum.")";
		}
		$database->setQuery($sql);
		try {
			$database->execute();
		} catch(Exception $e) {
			throw new Exception("SQL error when attempting to save a message. " . get_class($e));
		}
	}

	// send notification (message) to public user
	// check if we have an email address
	//	uddeIMdispatchEMN(msgid, $myself, 0, $savemessage, 0, $config);
	// if e-mail traffic stopped, don't send.
	if($config->emailtrafficenabled && $var_tomail) {

		$var_fromname = uddeIMgetNameFromID($myself, $config);
		if (!$var_fromname)
			$var_fromname=$config->sysm_username;

		$var_body = _UDDEIM_EMN_BODY_PUBLICWITHMESSAGE;
		$var_body = str_replace("%livesite%", $pathtosite, $var_body);
		$var_body = str_replace("%you%", $var_toname, $var_body);
		$var_body = str_replace("%site%", $mosConfig_sitename, $var_body);
		$var_body = str_replace("%user%", $var_fromname, $var_body);
		$var_body = str_replace("%pmessage%", $savemessage, $var_body);

		$subject = _UDDEIM_EMN_SUBJECT;
		$subject = str_replace("%livesite%", $pathtosite, $subject);
		$subject = str_replace("%site%", $mosConfig_sitename, $subject);
		$subject = str_replace("%you%", $var_toname, $subject);
		$subject = str_replace("%user%", $var_fromname, $subject);

		$replyto = $var_tomail;
		$replytoname = "";
        $notify = 0;
        try {
		  $notify = uddeIMsendmail($config->emn_sendername, $config->emn_sendermail, $var_toname, $var_tomail, $subject, $var_body, $replyto, $replytoname, "", $config);
            //Factory::getApplication()->enqueueMessage('Mail send');
        } catch(Exception $e) {
				throw new Exception("Error sending email notification");
			}

		//if(uddeIMsendmail($config->emn_sendername, $config->emn_sendermail, $var_toname, $var_tomail, $subject, $var_body, $replyto, $replytoname, "", $config)) {
		//  	// maybe a code here that the email cound not have been sent
		//}
	}
    //else // just for testing to see if variables are correct
    //echo $var_tomail.'='.$config->emailtrafficenabled;

	if ($tobedeletedsent) {
		$deletetime=uddetime($config->timezone);
		uddeIMdeleteMessageFromOutbox($myself, $insID, $deletetime);
	}

	// delete the original message?
	if ($tobedeleted) {
		$deletetime=uddetime($config->timezone);
		uddeIMdeleteMessageFromInbox($myself, $messageid, $deletetime);
	}

    if($messageid) {
		$mosmsg=_UDDEIM_MESSAGE_REPLIEDTO;
    } elseif ($notify) {
        $mosmsg=_UDDEIM_MESSAGEINFO_SENT.uddeIMgetNameFromID($savetoid, $config);
    } elseif ($config->allowemailnotify && !$notify && !$tobedeleted) {
        $mosmsg=_UDDEIM_MESSAGEINFO_ERROR.',error';
	} else {
		$mosmsg=_UDDEIM_MESSAGE_SENT;
	}

	if ($tobedeleted) {
		$mosmsg.=_UDDEIM_MOVEDTOTRASH;
	}

	if($backto) {
		uddeIMmosRedirect($backto, $mosmsg);
	}
	uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id, $mosmsg);
}

// *****************************************************************************************

// BUGBUG: $tobedeleted and $tobedeletedsent, $to_id, $to_name not used here
function uddeIMsaveSysgm($myself, $to_name, $to_id, $pmessage, $tobedeleted, $tobedeletedsent, $forceembedded, $item_id, $messageid, $sysgm_sys, $sysgm_nonotify, $sysgm_universe, $sysgm_validfor, $sysgm_really, $cryptpass, $config) {
	$database = uddeIMgetDatabase();

	$to_name = stripslashes($to_name);

	$my_gid = $config->usergid;
	if ($config->allowsysgm==0 || 
	   ($config->allowsysgm==1 && !uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) ||
	   ($config->allowsysgm==2 && !uddeIMisManager($my_gid)) ) {
		$mosmsg=_UDDEIM_NOTALLOWED_SYSM_GM;
		uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id, $mosmsg);
	}

	// what is username of sender?
	$sendername = uddeIMgetNameFromID($myself, $config);
	if ($sysgm_sys)
		$sendername=$config->sysm_username;

	if (!$sysgm_really) {
		// send not confirmed. ask for confirmation

		// CAPTCHA (first check for all other errors and then the CAPTCHA)
		if (!uddeIMcheckCAPTCHA($my_gid, $config)) {
			uddeIMprintMenu($myself, 'new', $item_id, $config);
			echo "<div id='uddeim-m'>\n";
			$to_name=stripslashes($to_name);
			$pmessage=stripslashes($pmessage);
			uddeIMdrawWriteform($myself, $my_gid, $item_id, "", $to_name, $pmessage, 0, 0, 7, 1, $config);
			echo "</div>\n<div id='uddeim-bottomborder'></div>\n";
			return;
		}

		if (!uddeIMcheckCSRF($config)) {
			uddeIMprintMenu($myself, 'new', $item_id, $config);
			echo "<div id='uddeim-m'>\n";
			$to_name=stripslashes($to_name);
			$pmessage=stripslashes($pmessage);
			uddeIMdrawWriteform($myself, $my_gid, $item_id, "", $to_name, $pmessage, 0, 0, 15, 1, $config);
			echo "</div>\n<div id='uddeim-bottomborder'></div>\n";
			return;
		}

		uddeIMprintMenu($myself, 'new', $item_id, $config);
		echo "<div id='uddeim-m'>\n";

		echo "<div id='uddeim-toplines'><p>"._UDDEIM_SYSGM_PLEASECONFIRM."</p></div>\n";
		echo "<div id='uddeim-message'><table cellpadding='7' cellspacing='1' width='100%'>\n";
		$usql="";	// send to unblocked users only

		getAdditonalGroups($add_special, $add_admin, $config);

        $usql = 0;
        $universe = '';
		if (uddeIMcheckJversion()>=2) {		// J1.6
			if ($sysgm_universe=="sysgm_toall") {
				$universe=_UDDEIM_SYSGM_WILLSENDTOALL;
				$usql="SELECT count(id) FROM `#__users` WHERE block=0";
			} elseif ($sysgm_universe=="sysgm_toalllogged") {
				$universe=_UDDEIM_SYSGM_WILLSENDTOALLLOGGED;
				$usql="SELECT count(a.id) FROM `#__users` AS a, `#__session` AS b WHERE a.block=0 AND a.id=b.userid";
			} elseif ($sysgm_universe=="sysgm_toallspecial") {
				$universe=_UDDEIM_SYSGM_WILLSENDTOALLSPECIAL;
				$usql="SELECT count(*) FROM (SELECT DISTINCT u.id FROM (`#__users` AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
						INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
						WHERE u.block=0 AND g.id IN (3,4,5,6,7,8".$add_admin.$add_special.")) AS aTable";
			} elseif ($sysgm_universe=="sysgm_toalladmins") {
				$universe=_UDDEIM_SYSGM_WILLSENDTOALLADMINS;
				$usql="SELECT count(*) FROM (SELECT DISTINCT u.id FROM (`#__users` AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
						INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
						WHERE u.block=0 AND g.id IN (7,8".$add_admin.")) AS aTable";
			} elseif ($config->showgroups) {
				$aclsql = "SELECT title AS name FROM `#__usergroups` WHERE id=".(int)$sysgm_universe;
				$database->setQuery($aclsql);
				$universe=$database->loadResult();
				$usql="SELECT count(*) FROM (SELECT DISTINCT u.id
						FROM (`#__users` AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
						INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
						WHERE g.id=".(int)$sysgm_universe.") AS aTable";
			}
		}


		if (!$universe) {
			$mosmsg=_UDDEIM_UNEXPECTEDERROR_QUIT." No recipients selected";
			uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id, $mosmsg);
		}

		if ($usql) {
			$database->setQuery($usql);
			$rf = (int)$database->loadResult();
			$rft = ($rf==1) ? _UDDEIM_RECIPIENTFOUND : _UDDEIM_RECIPIENTSFOUND;
			$universe.=" (".$rf." ".$rft.")";
		}



		// UDDEIMFILE
		// We have checked that everything is ok, now do the file uploads
		$uploadfile_temppathname = array();
		$uploadfile_original = array();
		$uploadfile_id = array(); 
		$uploadfile_size = array(); 
		$uploadfile_error = array();
		if( $config->enableattachment && uddeIMisAttachmentAllowed($my_gid, $config)) {
			$noerror = uddeIMhandleAttachments($uploadfile_temppathname, $uploadfile_original, $uploadfile_id, $uploadfile_size, $uploadfile_error, $config);
			if (!$noerror) { // something goes wrong
				// BUGBUG: that is not the best error handling possible but is will do the work
				// iterate through all errorcodes and show the first error found, rest of data will be lost
				// ==> delete all files that were uploaded ok
				foreach ($uploadfile_temppathname as $key => $value) {
					if (file_exists($value))
						unlink($value);
				}
				foreach ($uploadfile_error as $key => $value) {
					if ($value==-1) {	// upload failed
						uddeIMprintMenu($myself, 'new', $item_id, $config);
						echo "<div id='uddeim-m'>\n";
						$to_name=stripslashes($to_name);
						$pmessage=stripslashes($pmessage);
						uddeIMdrawWriteform($myself, $my_gid, $item_id, "", $to_name, $pmessage, 0, 0, 18, 1, $config);
						return;
					}
					if ($value==-2) {	// file size exceeded
						uddeIMprintMenu($myself, 'new', $item_id, $config);
						echo "<div id='uddeim-m'>\n";
						$to_name=stripslashes($to_name);
						$pmessage=stripslashes($pmessage);
						uddeIMdrawWriteform($myself, $my_gid, $item_id, "", $to_name, $pmessage, 0, 0, 19, 1, $config);
						return;
					}
					if ($value==-3) {	// file type not allowed
						uddeIMprintMenu($myself, 'new', $item_id, $config);
						echo "<div id='uddeim-m'>\n";
						$to_name=stripslashes($to_name);
						$pmessage=stripslashes($pmessage);
						uddeIMdrawWriteform($myself, $my_gid, $item_id, "", $to_name, $pmessage, 0, 0, 20, 1, $config);
						return;
					}
				}
				$uploadfile_temppathname = array();		// should never been reached when an error occurs but neverthless destroy old arrays
				$uploadfile_original = array();
				$uploadfile_id = array(); 
				$uploadfile_size = array(); 
				$uploadfile_error = array();
			} else {
				$savedatum=uddetime($config->timezone);
				uddeIMpreSaveAttachments($uploadfile_temppathname, $uploadfile_original, $uploadfile_id, $uploadfile_size, $savedatum, $config);
			}
		}
		// The uploaded file is stored in "$uploadfile_tempname" (with path) ad the original name in "$uploadfile_original" (without path) and an Id for the file.
		// When we reach this line we can store these fileames in the DB.

		$udde_infoheader = $universe."<br />";
		$udde_infoheader .= _UDDEIM_SYSGM_WILLSENDAS_1.$sendername._UDDEIM_SYSGM_WILLSENDAS_2."<br />";
		if($sysgm_sys) {
			$udde_infoheader .= _UDDEIM_SYSGM_WILLDISABLEREPLY."<br />";
		}
		if($forceembedded && !$sysgm_nonotify) {
			$udde_infoheader .= _UDDEIM_SYSGM_FORCEEMBEDDED."<br />";
		}
		if($sysgm_nonotify) {
			$udde_infoheader .= _UDDEIM_SYSGM_NONOTIFY."<br />";
		}
		if($sysgm_validfor>0) {
			$now=uddetime($config->timezone);
			$validuntil_timestamp=$now+($sysgm_validfor*3600);
			$validuntil=date("Y-m-d H:i", $validuntil_timestamp);
			$udde_infoheader .= _UDDEIM_SYSGM_WILLEXPIRE." ".$validuntil."<br />";
		}

		echo "\t<tr class='sectiontableentry1'>\n\t\t<td>".$udde_infoheader."</td></tr>\n";

		// strip any HTML from message but don't add slashes yet
		$dmessage=strip_tags($pmessage);
		$dmessage=stripslashes($pmessage);
		$hmessage=htmlspecialchars($dmessage, ENT_QUOTES, $config->charset);
		$jmessage=$dmessage;

		$containslink=stristr($dmessage, "[url");
		// parse bb code if it is a sysgm
		$dmessage=uddeIMbbcode_replace($dmessage, $config);
		$dmessage=uddeIMsmile_replace($dmessage, $config);

		echo "\t<tr class='sectiontableentry2'>\n\t\t\n\t\t<td>".nl2br($dmessage)."</td></tr>\n"; // to do
		echo "</table></div>\n";

		echo "<div id='uddeim-writeform'>\n";
		echo "<form method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=savesysgm&Itemid=".$item_id)."'><input type='hidden' name='sysgm_sys' value='".$sysgm_sys."' />\n";
		echo "<span style='display: none'>\n";

		if ($sysgm_universe=="sysgm_toall") {
			echo "<input type='hidden' name='sysgm_universe' value='sysgm_toall' />\n";
		} elseif ($sysgm_universe=="sysgm_toallspecial") {
			echo "<input type='hidden' name='sysgm_universe' value='sysgm_toallspecial' />\n";
		} elseif ($sysgm_universe=="sysgm_toalladmins") {
			echo "<input type='hidden' name='sysgm_universe' value='sysgm_toalladmins' />\n";
		} elseif ($sysgm_universe=="sysgm_toalllogged") {
			echo "<input type='hidden' name='sysgm_universe' value='sysgm_toalllogged' />\n";
		} elseif ($config->showgroups) { 
			echo "<input type='hidden' name='sysgm_universe' value='".$sysgm_universe."' />\n";
		} 
		echo "<input type='hidden' name='sysgm_validfor' value='".(int)$sysgm_validfor."' />\n";
		echo "<textarea style='visibility: hidden;' name='pmessage' class='inputbox' rows='1' cols='60'>".$jmessage."</textarea>\n";
		echo "<input type='hidden' name='sysgm_really' value='1' />\n";
		echo "<input type='hidden' name='forceembedded' value='".(int)$forceembedded."' />\n";
		echo "<input type='hidden' name='sysgm_nonotify' value='".(int)$sysgm_nonotify."' />\n";
		echo "<span id='divpass' style='visibility:hidden;'><input type='hidden' name='cryptpass' value='".$cryptpass."' /></span>\n";

		if( $config->enableattachment && uddeIMisAttachmentAllowed($my_gid, $config)) {
			foreach ($uploadfile_temppathname as $key => $value) {
				echo "<input type='hidden' name='uploadfile_temppathname[". $key ."]' value=". $database->Quote($uploadfile_temppathname[$key]) ." />\n";
				echo "<input type='hidden' name='uploadfile_original[". $key ."]' value=". $database->Quote($uploadfile_original[$key]) ." />\n";
				echo "<input type='hidden' name='uploadfile_id[". $key ."]' value=". $database->Quote($uploadfile_id[$key]) ." />\n";
				echo "<input type='hidden' name='uploadfile_size[". $key ."]' value=". $database->Quote($uploadfile_size[$key]) ." />\n";
			}
		}

		echo "</span>\n";
		echo "<input type='submit' name='reply' class='button' value='"._UDDEIM_SUBMIT."' />\n";
		echo "<input type='button' class='button' value='".htmlspecialchars(_UDDEIM_DONTSEND, ENT_QUOTES, $config->charset)."' onclick='history.go(-1); return false;' />";
		echo "</form>";
		echo "</div>";

		if ($containslink) {
			echo "<div id='uddeim-bottomlines'><p>"._UDDEIM_SYSGM_CHECKLINK."</p>\n</div>\n";
		}

		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";

	} else { // sysgm_really is set to true, send is confirmed. Now send it.

		$uploadfile_temppathname = uddeIMmosGetParam ($_POST, 'uploadfile_temppathname', array());
		$uploadfile_original = uddeIMmosGetParam ($_POST, 'uploadfile_original', array());
		$uploadfile_id = uddeIMmosGetParam ($_POST, 'uploadfile_id', array());
		$uploadfile_size = uddeIMmosGetParam ($_POST, 'uploadfile_size', array());

		$savedatum=uddetime($config->timezone);
		if($sysgm_validfor>0) {
			$now=uddetime($config->timezone);
			$validuntil=$now+($sysgm_validfor*3600);
		} else {
			$validuntil=0;
		}
		$savefromid=$myself;
		$savedisablereply=0;
		$savesysflag="";
		if($sysgm_sys) {
			$savesysflag=addslashes($config->sysm_username); 	// system message
			$savedisablereply=1; 								// and users can't reply to them
		} else {
			$savesysflag=addslashes($sendername);
			$savedisablereply=0;
		}

		if ($config->cryptmode>=1) {	// because of encoding do not use slashes
			$savemessage=strip_tags($pmessage);
		} else {
			$savemessage=addslashes(strip_tags($pmessage));   // original 0.6+
		}
		// strip XSS code
		$savemessage = uddeIMRemoveXSS($savemessage);

		getAdditonalGroups($add_special, $add_admin, $config);
		if (uddeIMcheckJversion()>=2) {		// J1.6
			// who shall get the message?
			if($sysgm_universe=="sysgm_toall") {
				$sql="SELECT id FROM `#__users` WHERE block=0";
			} elseif($sysgm_universe=="sysgm_toalllogged") {
				$sql="SELECT a.id, b.userid FROM `#__users` AS a, `#__session` AS b WHERE block=0 AND a.id=b.userid";
			} elseif($sysgm_universe=="sysgm_toallspecial") {
				$sql="SELECT DISTINCT u.id FROM (`#__users` AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
							INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
							WHERE u.block=0 AND g.id IN (3,4,5,6,7,8".$add_admin.$add_special.")";
			} elseif($sysgm_universe=="sysgm_toalladmins") {
				$sql="SELECT DISTINCT u.id FROM (`#__users` AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
							INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
							WHERE u.block=0 AND g.id IN (7,8".$add_admin.")";
			} elseif ($config->showgroups) {
				$sql="SELECT DISTINCT u.id FROM (`#__users` AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
							INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
							WHERE u.block=0 AND g.id=".(int)$sysgm_universe;
			}
		} else {
			// who shall get the message?
			if($sysgm_universe=="sysgm_toall") {
				$sql="SELECT id FROM `#__users` WHERE block=0";
			} elseif($sysgm_universe=="sysgm_toalllogged") {
				$sql="SELECT a.id, b.userid FROM `#__users` AS a, `#__session` AS b WHERE block=0 AND a.id=b.userid";
			} elseif($sysgm_universe=="sysgm_toallspecial") {
				$sql="SELECT id FROM `#__users` WHERE block=0 AND gid IN (19,20,21,23,24,25".$add_admin.")";
			} elseif($sysgm_universe=="sysgm_toalladmins") {
				$sql="SELECT id FROM `#__users` WHERE block=0 AND gid IN (24,25".$add_admin.")";
			} elseif ($config->showgroups) {
				$sql="SELECT id FROM `#__users` WHERE block=0 AND gid=".(int)$sysgm_universe;
			}
		}
		// query the database
		$database->setQuery($sql);
		$receivers=$database->loadObjectList();

		if (!count($receivers)) {
			// when there are temporary files, remove them and the markers
			uddeIMpreSaveAttachmentsRemove($config);
			$mosmsg = _UDDEIM_SYSGM_ERRORNORECIPS;
			uddeJSEFredirect("index.php?option=com_uddeim&task=sysgm&Itemid=".$item_id, $mosmsg);
		}
		// we have all we need, now save it


		// when we have reached that, we can remove the temporary attachment markers since the files will be referenced later
		if( $config->enableattachment && uddeIMisAttachmentAllowed($my_gid, $config))
			uddeIMpreSaveAttachmentsFinish($config);


		foreach($receivers as $receiver) {
			$savetoid=$receiver->id;

			// it is a systemmsg to "toid", so assume that the message has already been trashed in the senders outbox (remember: system messages are not shown in the outbox)
			// so set totrashoutbox=1, totrashdateoutbox=uddetime($config->timezone)
			// CRYPT
			$themode = 0;
			if ($config->cryptmode==1) {
				$themode = 1;
				$cm = uddeIMencrypt($savemessage,$config->cryptkey,CRYPT_MODE_BASE64);
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, expires, systemmessage, systemflag, disablereply, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$savefromid.", ".(int)$savetoid.", '".$cm."', ".$savedatum.", ".$validuntil.", '".$savesysflag."', 1,".$savedisablereply.", 1, ".$savedatum.",1,'".md5($config->cryptkey)."')";
			} elseif ($config->cryptmode==2) {
				$themode = 2;
				$thepass=$cryptpass;
				if (!$thepass) {	// no password entered, then fallback to obfuscating
					$themode = 1;
					$thepass=$config->cryptkey;
				}
				$cm = uddeIMencrypt($savemessage,$thepass,CRYPT_MODE_BASE64);
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, expires, systemmessage, systemflag, disablereply, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$savefromid.", ".(int)$savetoid.", '".$cm."', ".$savedatum.", ".$validuntil.", '".$savesysflag."', 1,".$savedisablereply.", 1, ".$savedatum.", ".$themode.",'".md5($thepass)."')";
			} elseif ($config->cryptmode==3) {
				$themode = 3;
				$cm = uddeIMencrypt($savemessage,"",CRYPT_MODE_STOREBASE64);
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, expires, systemmessage, systemflag, disablereply, totrashoutbox, totrashdateoutbox, cryptmode) VALUES (".(int)$savefromid.", ".(int)$savetoid.", '".$cm."', ".$savedatum.", ".$validuntil.", '".$savesysflag."', 1,".$savedisablereply.", 1, ".$savedatum.",3)";
			} elseif ($config->cryptmode==4) {
				$themode = 4;
				$thepass=$cryptpass;
				$cipher = CRYPT_MODE_OSSL_AES_256;
				if (!$thepass) {	// no password entered, then fallback to obfuscating
					$themode = 1;
					$thepass=$config->cryptkey;
					$cipher = CRYPT_MODE_BASE64;
				}
				$cm = uddeIMencrypt($savemessage,$thepass,$cipher);
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, expires, systemmessage, systemflag, disablereply, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$savefromid.", ".(int)$savetoid.", '".$cm."', ".$savedatum.", ".$validuntil.", '".$savesysflag."', 1,".$savedisablereply.", 1, ".$savedatum.", ".$themode.",'".md5($thepass)."')";
			} else {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, expires, systemmessage, systemflag, disablereply, totrashoutbox, totrashdateoutbox) VALUES (".(int)$savefromid.", ".(int)$savetoid.", '".$savemessage."', ".$savedatum.", ".$validuntil.", '".$savesysflag."', 1,".$savedisablereply.", 1,".$savedatum.")";
			}
			$database->setQuery($sql);
			try {
				$database->execute();
			} catch(Exception $e) {
				throw new Exception("SQL error when attempting to save a message. " . get_class($e));
			}
			$insID = $database->insertid();



			// UDDEIMFILE
			// Now save the uploads
			if( $config->enableattachment && uddeIMisAttachmentAllowed($my_gid, $config))
				uddeIMsaveAttachments($insID, $uploadfile_temppathname, $uploadfile_original, $uploadfile_id, $uploadfile_size, $savedatum, $config);

			

			// Check if E-Mail notification or popups are enabled by default, if so create a record for the receiver.
			if ($config->modnewusers>0 || $config->notifydefault>0 || $config->popupdefault>0 || $config->pubfrontenddefault>0 || $config->autoresponder>0 || $config->autoforward>0) {
				if (!uddeIMexistsEMN($savetoid))
					uddeIMinsertEMNdefaults($savetoid, $config);
			}

			// Check if notifications are not disabled temporary
			if (!$sysgm_nonotify) {

				// e-mail notification code
				// is the receiver currently online?
				$currentlyonline = uddeIMisOnline($savetoid);

				if ($config->cryptmode>=1) {
					$email=stripslashes($savemessage);
				} else {
					$email=stripslashes(stripslashes($savemessage));	// without encoding remove the safety slashes
				}

				$type = 0; 			// 0=normal message, 1=forgetmenot, 2=admin forces text
				if ($forceembedded)
					$type = 2;		// admin forces
				if($config->allowemailnotify==1) {
					$ison = uddeIMgetEMNstatus($savetoid);
					if($sysgm_sys) {
						$emn_fromid = 0;
					} else {
						$emn_fromid = $savefromid;
					}
					if (($ison==1) || ($ison==2 && !$currentlyonline) || ($ison==10) || ($ison==20 && !$currentlyonline))  {
						uddeIMdispatchEMN($insID, $item_id, $themode, $emn_fromid, $savetoid, $email, $type, $config);
						// 0 stands for normal (not forgetmenot)
					}
				} elseif($config->allowemailnotify==2) {
					$my_gid = uddeIMgetGID($savetoid);
					if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) {
						$ison = uddeIMgetEMNstatus($savetoid);
						if($sysgm_sys) {
							$emn_fromid = 0;
						} else {
							$emn_fromid = $savefromid;
						}
						if (($ison==1) || ($ison==2 && !$currentlyonline) || ($ison==10) || ($ison==20 && !$currentlyonline))  {
							uddeIMdispatchEMN($insID, $item_id, $themode, $emn_fromid, $savetoid, $email, $type, $config);
							// 0 stands for normal (not forgetmenot)
						}
					}
				}
			}
		}
		$mosmsg=_UDDEIM_MESSAGE_SENT;
		uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id, $mosmsg);
	}
}

// *****************************************************************************************

// BUGBUG: When public frontend is called with parameter e.g. http://joomla33/index.php/uddeim?task=new&recip=227
// the public frontend username/realname setting might be different from the global one. In that case the
// name will not be found.

function uddeIMnewMessage($myself, $item_id, $to_id, $recip, $runame, $pmessage, $replyid, $isreply, $config) {
	$my_gid = $config->usergid;

	$recipname="";
	if($recip) {
		$recipname = uddeIMgetNameFromID($recip, $config);
	} elseif ($runame) {
		$recipname = uddeIMgetNameFromUsername($runame, $config);
		if (!$recipname)
			$recipname=$runame;
	}

	// write the uddeim menu
	uddeIMprintMenu($myself, 'new', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	// Don't display writeform if inboxlimit set AND over limit
	// how many messages total in inbox? I do not need the number of messages separately for both boxes!
	if ($config->inboxlimit) {				// there is a limit for inbox + archive
		if ($config->allowarchive) {		// have an archive and an "archive and inbox" limit, so get number of messages in inbox and archive
			$universeflag = _UDDEIM_ARC_UNIVERSE_BOTH;	// inbox and archive
			$total = uddeIMgetInboxArchiveCount($myself);
		} else {							// user has switched of archive but there is an limit for "inbox and archive", so count inbox messages only
			$universeflag = _UDDEIM_ARC_UNIVERSE_INBOX;	// inbox
			$total = uddeIMgetInboxCount($myself);
		}
	
		if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
			// "The allowed maximum is XX."
			// $limitreached.= _UDDEIM_INBOX_LIMIT_3." ".$config->maxarchive.". ";
			// $limitreached.= " "._UDDEIM_SHOWINBOXLIMIT_2." ".$config->maxarchive.").";	// (of max. )

			if ($total > $config->maxarchive) {
				// "You have XX messages in your inbox/inbox+archive."
				$limitreached = _UDDEIM_INBOX_LIMIT_1." ".$total;
				$limitreached.= " ".($total==1 ? _UDDEIM_INBOX_LIMIT_2_SINGULAR : _UDDEIM_INBOX_LIMIT_2)." ";
				$limitreached.= $universeflag;
				// You can still receive and read messages but you will not be able to reply or to compose new ones until you delete messages.
				$limitwarning = _UDDEIM_INBOX_LIMIT_4;

				$showinboxlimit_borderbottom = "<span class='uddeim-warning'>";
				$showinboxlimit_borderbottom.= $limitreached." ";
				$showinboxlimit_borderbottom.= $limitwarning;
				$showinboxlimit_borderbottom.= "</span>";
				echo "<div id='uddeim-bottomlines'>".$showinboxlimit_borderbottom."</div>";
				// close main container
				echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', $limitreached, $config)."</div>\n";
				return;
			}
		}
	}



	// which page did refer to this page?
	// because we want to send back the user where (s)he came from
	$tbackto = uddeIMmosGetParam( $_SERVER, 'HTTP_REFERER', null );
	if(stristr($tbackto ?? '', "com_pms")) {
		$tbackto="";
	}

	uddeIMdrawWriteform($myself, $my_gid, $item_id, $tbackto, $recipname, $pmessage, $replyid, $isreply, 0, 0, $config); // isreply, errorcode, sysmsg

	// now check if user is an admin and if system messages are allowed
	if($config->allowsysgm) {
		if (($config->allowsysgm==1 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))) ||
		    ($config->allowsysgm==2 && uddeIMisManager($my_gid)) ) {
			echo "<div id='uddeim-bottomlines'><p>";
			echo "<a class='btn btn-sm btn-info' href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=sysgm&Itemid=".$item_id)."'>";
			echo _UDDEIM_WRITE_SYSM_GM;
			echo "</a></p></div>\n";
		}
	}
	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

// *****************************************************************************************

function uddeIMnewSysgm($myself, $item_id, $to_id, $pmessage, $config) {
	$my_gid = $config->usergid;

	if ($config->allowsysgm==0 || 
	   ($config->allowsysgm==1 && !uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) ||
	   ($config->allowsysgm==2 && !uddeIMisManager($my_gid)) ) {
		$mosmsg=_UDDEIM_NOTALLOWED_SYSM_GM;
		uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id, $mosmsg);
	}

	// write the uddeim menu
	uddeIMprintMenu($myself, 'new', $item_id, $config);
	echo "<div id='uddeim-m'>\n";
	uddeIMdrawWriteform($myself, $my_gid, $item_id, "", "", $pmessage, "", 0, 0, 1, $config); // isreply, errorcode, sysmsg
	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

// *****************************************************************************************

function uddeIMshowSettings($myself, $item_id, $config) {
	// write the uddeim menu
	uddeIMprintMenu($myself, 'settings', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	$emptysettings = _UDDEIM_NOSETTINGS;

	$my_gid = $config->usergid;

	if ($config->blocksystem) {
		$emptysettings='';
		$blockedusers = uddeIMselectBlockerBlockedList($myself, $config);
		$howmanyblocks=count($blockedusers);

		echo "<div class='uddeim-set-block'>\n";
		echo "<h4>"._UDDEIM_BLOCKSYSTEM."</h4>\n";
		if ($howmanyblocks) {
			echo "<p>"._UDDEIM_BLOCKS_EXP."</p>\n";
			echo "<p>"._UDDEIM_YOUBLOCKED_PRE.$howmanyblocks._UDDEIM_YOUBLOCKED_POST."</p>\n";
			echo "<div id='uddeim-overview'>";
			foreach($blockedusers as $blockeduser) {
				if ($blockeduser->displayname)
					echo uddeIMgetLinkOnly($blockeduser->blocked, "<b>".$blockeduser->displayname."</b>", $config);
				else
					echo _UDDEADM_NONEORUNKNOWN;
				echo "&nbsp;&nbsp;";
				echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=unblockuser&Itemid=".$item_id."&recip=".$blockeduser->blocked)."'>"._UDDEIM_UNBLOCKNOW."</a><br />";
			}
			echo "</div>\n";
			if ($config->blockalert) {
				echo "<p>"._UDDEIM_BLOCKALERT_EXP_ON."</p>\n";
			} else {
				echo "<p>"._UDDEIM_BLOCKALERT_EXP_OFF."</p>\n";
			}
		} else {
			echo "<p>"._UDDEIM_NOBODYBLOCKED."</p>\n";
		}
		echo "</div>";
	}

	if ($config->allowemailnotify==1 || 
	   ($config->allowemailnotify==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)))) {

		$emptysettings='';
		$emn_notonreply_checkstatus='';
		$emn_always_checkstatus='';
		$emn_whenoffline_checkstatus='';
		$emn_none_checkstatus='';

		$ison = uddeIMgetEMNstatus($myself);
		if ($ison==0) {
			$emn_none_checkstatus='checked="checked"';
		} elseif ($ison==1 || $ison==10) {
			$emn_always_checkstatus='checked="checked"';
		} elseif ($ison==2 || $ison==20) {
			$emn_whenoffline_checkstatus='checked="checked"';
		}
		if ($ison==10 || $ison==20) {
			$emn_notonreply_checkstatus='checked="checked"';
		}
		echo "<div class='uddeim-set-block'>";  // was uddeim-set-emn
		echo "<h4>"._UDDEIM_EMN."</h4>";
		echo "<p>"._UDDEIM_EMN_EXP."</p>";
		echo "<form name='emnform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=saveemn&Itemid=".$item_id)."'>";
		echo '<input type="radio" '.$emn_always_checkstatus.		' name="emailradio" value="1" onclick="document.emnform.emailreplycheck.disabled=false;" />'._UDDEIM_EMN_ALWAYS.'<br />';
		echo '<input type="radio" '.$emn_whenoffline_checkstatus.	' name="emailradio" value="2" onclick="document.emnform.emailreplycheck.disabled=false;" />'._UDDEIM_EMN_WHENOFFLINE.'<br />';
		echo '<input type="radio" '.$emn_none_checkstatus.			' name="emailradio" value="0" onclick="document.emnform.emailreplycheck.disabled=true; document.emnform.emailreplycheck.checked=false;" />'._UDDEIM_EMN_NONE.'<br />';
		if ($emn_none_checkstatus) {
			echo '<input type="checkbox" '.$emn_notonreply_checkstatus.' value="1" name="emailreplycheck" disabled="disabled" />'._UDDEIM_EMN_NOTONREPLY.'<br />';
		} else {
			echo '<input type="checkbox" '.$emn_notonreply_checkstatus.' value="1" name="emailreplycheck" />'._UDDEIM_EMN_NOTONREPLY.'<br />';
		}
		echo '<input type="submit" name="reply" class="button" value="'._UDDEIM_SAVECHANGE.'" />';
		echo "</form>";
		echo "</div>";
	}

	if ($config->autoresponder==1 || 
	   ($config->autoresponder==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)))) {
		$emptysettings='';

		$emn_responder_checkstatus='';
		$ison = uddeIMgetEMNautoresponder($myself);
		if ($ison==1) {
			$emn_responder_checkstatus='checked="checked"';
		}
		$autorespondertext = uddeIMgetEMNautorespondertext($myself);
		if (!$autorespondertext) {
			$autorespondertext = _UDDEIM_AUTORESPONDER_DEFAULT;
		}
		if ($config->maxlength>0)		// because if 0 do not use any maxlength
			$autorespondertext = uddeIM_utf8_substr($config->languagecharset, $autorespondertext, 0, $config->maxlength);
		echo "<div class='uddeim-set-block'>";  // was uddeim-set-emn
		echo "<h4>"._UDDEIM_AUTORESPONDER."</h4>";
		echo "<p>"._UDDEIM_AUTORESPONDER_EXP."</p>";
		echo "<form name='emnrespform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=saveresponderemn&Itemid=".$item_id)."'>";
		echo '<input onclick="document.emnrespform.autorespondercheck.checked ? document.emnrespform.autorespondertext.disabled=false : document.emnrespform.autorespondertext.disabled=true;" type="checkbox" '.$emn_responder_checkstatus.' value="1" name="autorespondercheck" />'._UDDEIM_EMN_AUTORESPONDER.'<br />';
		echo "<textarea name='autorespondertext' class='inputbox' rows='4' cols='60'".($ison==1 ? '' : 'disabled="disabled"').">".htmlentities($autorespondertext,ENT_QUOTES, $config->charset)."</textarea><br />";
		echo '<input type="submit" name="reply" class="button" value="'._UDDEIM_SAVECHANGE.'" />';
		echo "</form>";
		echo "</div>";
	}

	if ($config->autoforward==1 || 
	   ($config->autoforward==2 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) ||
	   ($config->autoforward==3 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) ) {
		$emptysettings='';

		$emn_forward_checkstatus='';
		$ison = uddeIMgetEMNautoforward($myself);
		if ($ison==1) {
			$emn_forward_checkstatus='checked="checked"';
		}
		$autoforwardid = uddeIMgetEMNautoforwardid($myself);

		echo "<div class='uddeim-set-block'>";  // was uddeim-set-emn
		echo "<h4>"._UDDEIM_AUTOFORWARD."</h4>";
		echo "<p>"._UDDEIM_AUTOFORWARD_EXP."</p>";
		echo "<form name='emnfwdform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=saveforwardemn&Itemid=".$item_id)."'>";
		echo '<input onclick="document.emnfwdform.autoforwardcheck.checked ? document.emnfwdform.autoforwardid.disabled=false : document.emnfwdform.autoforwardid.disabled=true;" type="checkbox" '.$emn_forward_checkstatus.' value="1" name="autoforwardcheck" />'._UDDEIM_EMN_AUTOFORWARD.'<br />';
		uddeIMdoShowAllUsers($myself, $my_gid, $config, 2, $ison, $autoforwardid);
//		echo "<textarea name='autoforwardid' class='inputbox' rows='1' cols='10'".($ison==1 ? '' : 'disabled="disabled"').">".htmlentities($autoforwardid,ENT_QUOTES, $config->charset)."</textarea><br />";
		echo "<br />";
		echo '<input type="submit" name="reply" class="button" value="'._UDDEIM_SAVECHANGE.'" />';
		echo "</form>";
		echo "</div>";
	}

	if ($config->allowpopup || ($config->pubfrontend && !uddeIMisRecipientBlockedPublic($myself, $config)) ) {

		$emptysettings='';
		echo "<div class='uddeim-set-block'>";
		echo "<h4>"._UDDEIM_OPTIONS."</h4>";
		echo "<p>"._UDDEIM_OPTIONS_EXP."</p>";
		echo "<form name='uddeim-popupform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=saveuseremn&Itemid=".$item_id)."'>";

		$ison = uddeIMgetEMNpopup($myself);
		$p0checked='';
		switch($ison) {
			case 0:		$p0checked='';						break;
			case 1:		$p0checked='checked="checked"'; 	break;
		}
		if ($config->allowpopup)
			echo '<input type="checkbox" '.$p0checked.' value="1" name="popupcheck" />'._UDDEIM_OPTIONS_P.'<br />';
		else
			echo '<input type="hidden" name="popupcheck" value="'.$ison.'" />';

		$ison = uddeIMgetEMNpublic($myself);
		$p0checked='';
		switch($ison) {
			case 0:		$p0checked='';						break;
			case 1:		$p0checked='checked="checked"'; 	break;
		}
		if ($config->pubfrontend && !uddeIMisRecipientBlockedPublic($myself, $config))			// show option only when I am not in a generally blocked group
			echo '<input type="checkbox" '.$p0checked.' value="1" name="publiccheck" />'._UDDEIM_OPTIONS_F.'<br />';
		else
			echo '<input type="hidden" name="publiccheck" value="'.$ison.'" />';
		// Note: When a certain group is blocked it does not matter what is stored in $public by default, since the group checked if performed before the individual check.
		// I.e. when the group is not blocked -> the individual check $public is tested (the user can modify this value here)
		// and when the group is blocked -> the individual check is not done, since the user will see an error message that the group is not allowed

		echo '<input type="submit" name="reply" class="button" value="'._UDDEIM_SAVECHANGE.'" />';
		echo "</form>";
		echo "</div>";
	}

	if ($config->enablerss==1 || 
	   ($config->enablerss==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)))) {

		$emptysettings='';
		$database = uddeIMgetDatabase();
		$sql = "SELECT id, name, username, password, block FROM `#__users` WHERE id=".(int)$myself;
		$database->setQuery($sql);
		$values = $database->loadObjectList();
		if (!$values)
			$values = Array();
		$row = NULL;
		foreach($values as $value) {
			$row = $value;
		}
		if ($row) {
			if ((strpos($row->password, ':') === false) && $row->password == md5($passwd)) {
				$salt = uddeIMmosMakePassword(16);
				$crypt = md5($passwd.$salt);
				$row->password = $crypt.':'.$salt;
			}
			list($hash, $salt) = explode(':', $row->password);
			$hash_db = sha1($hash);
			$pms_show = uddeIMgetPath('live_site')."/index.php?option=com_uddeim&amp;task=rss&amp;no_html=1&amp;format=raw&amp;user=".$row->username."&amp;pass=".$hash_db;
			$link = '<a href="'.$pms_show.'" target="_blank">'.$pms_show.'</a>';
			echo '<div class="uddeim-set-block">';
			echo '<h4>'._UDDEIM_RSS_FEED.'</h4>';
			echo '<p>'._UDDEIM_RSS_INTRO1.' '._UDDEIM_RSS_INTRO1B.'</p>';
			echo '<p>'.$link.'</p>';
			echo '<p>'._UDDEIM_RSS_INTRO2.'</p>';
			
			if ($config->showigoogle) {
				echo '<p><a href="http://fusion.google.com/ig/add?synd=open&amp;source=ggyp&amp;moduleurl='.uddeIMgetPath('live_site').'/components/com_uddeim/uddeim_igoogle.xml">';
				echo '<img src="'.uddeIMgetPath('live_site').'/components/com_uddeim/templates/images/igoogle.gif" border="0" alt="Add to Google" width="62" height="17" />';
				echo '</a></p>';
				echo '</div>';
			}
		}
	}

	if ($emptysettings) {
			echo "<div id='uddeim-toplines'>".$emptysettings."</div>";
	}
	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'settings', 'none', $config)."</div>\n";
}

function uddeIMsaveEMN($myself, $item_id, $emailradio, $emailreplycheck, $config) {
	if ($emailradio==0 || $emailradio==1 || $emailradio==2) {
		$emn_setstatus=$emailradio;
		if ($emailradio==1 && $emailreplycheck) {
			$emn_setstatus=10;
		}
		if ($emailradio==2 && $emailreplycheck) {
			$emn_setstatus=20;
		}
		if (!uddeIMexistsEMN($myself))
			uddeIMinsertEMNdefaults($myself, $config);
		uddeIMupdateEMNstatus($myself, $emn_setstatus);
	}
	uddeJSEFredirect("index.php?option=com_uddeim&task=settings&Itemid=".$item_id);
}

function uddeIMsaveAutoresponderEMN($myself, $item_id, $autorespondertext, $autorespondercheck, $config) {
	// $autorespondercheck contains "on"
	$valueautoresponder = 0;
	if ($autorespondercheck)
		$valueautoresponder=1;
	if ($config->maxlength>0)		// because if 0 do not use any maxlength
		$autorespondertext = uddeIM_utf8_substr($config->languagecharset, $autorespondertext, 0, $config->maxlength);
	if (!uddeIMexistsEMN($myself))
		uddeIMinsertEMNdefaults($myself, $config);
	uddeIMupdateEMNautoresponder($myself, $valueautoresponder);
	if ($valueautoresponder)
		uddeIMupdateEMNautorespondertext($myself, $autorespondertext);
	uddeJSEFredirect("index.php?option=com_uddeim&task=settings&Itemid=".$item_id);
}

function uddeIMsaveAutoforwardEMN($myself, $item_id, $autoforwardid, $autoforwardcheck, $config) {
	// $autorespondercheck contains "on"
	$valueautoforward = 0;
	if ($autoforwardcheck)
		$valueautoforward=1;
	if (!uddeIMexistsEMN($myself))
		uddeIMinsertEMNdefaults($myself, $config);

	uddeIMupdateEMNautoforward($myself, $valueautoforward);
	if ($valueautoforward)
		uddeIMupdateEMNautoforwardid($myself, $autoforwardid);
	uddeJSEFredirect("index.php?option=com_uddeim&task=settings&Itemid=".$item_id);
}

function uddeIMsaveUserEMN ($myself, $item_id, $popupcheck, $publiccheck, $config) {
	// $popupcheck and $publiccheck contain "on"
	$valuepopup = 0;
	if ($popupcheck)
		$valuepopup=1;
	$valuepublic = 0;
	if ($publiccheck)
		$valuepublic=1;

	if (!uddeIMexistsEMN($myself))
		uddeIMinsertEMNdefaults($myself, $config);
	uddeIMupdateEMNpopup($myself, $valuepopup);
	uddeIMupdateEMNpublic($myself, $valuepublic);

	uddeJSEFredirect("index.php?option=com_uddeim&task=settings&Itemid=".$item_id);
}

// *****************************************************************************************

function uddeIMshowAbout($myself, $item_id, $versionstring, $usedlanguage, $config) {
	// write the uddeim menu
	uddeIMprintMenu($myself, 'about', $item_id, $config);
	echo "<div id='uddeim-m'>\n";
	echo "<div id='uddeim-bottomlines'>\n";
	echo "<p><b>uddeIM (Instant Messages)</b></p>";
	echo "<p>".$versionstring."</p>\n";
	echo "<p>PMS component for Joomla<br />";
	echo "&copy; 2007-2014 Stephan Slabihoud, &copy; 2005-2006 by Benjamin Zweifel</p>\n";
    echo "2024 version 5: code updated for Joomla 5 by joomod.de";
	echo "<p>Language file: ".$usedlanguage."</p>";
	echo "<p>"._UDDEADM_TRANSLATORS_CREDITS."</p>";

	echo "<p>This is free software and you may redistribute it under the GPL.<br />";
	echo "uddeIM comes with absolutely no warranty. For details, see the license at <a href='http://www.gnu.org/licenses/gpl.txt'>www.gnu.org/licenses/gpl.txt</a>.</p>\n";
	echo "<p>For the latest uddeIM version, go to<br /><a href='http://www.slabihoud.de/software/'>http://www.slabihoud.de/software/</a></p>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'about', 'none', $config)."</div>\n";
}

function uddeIMshowHelp($myself, $item_id, $versionstring, $config) {
	global $uddeicons_delayedpic, $uddeicons_flagged, $uddeicons_unflagged, $uddeicons_onlinepic, $uddeicons_offlinepic, $uddeicons_readpic, $uddeicons_unreadpic;

	$my_gid = $config->usergid;
	$pathtosite = uddeIMgetPath('live_site');

	uddeIMprintMenu($myself, 'help', $item_id, $config);
	echo "<div id='uddeim-m'>\n";
	echo "<div id='uddeim-bottomlines'>\n";
	echo "<p><b>"._UDDEIM_HELP_HEADLINE1."</b></p>";
	echo "<p>"._UDDEIM_HELP_HEADLINE2."</p>\n";
	echo "<p></p>\n";

	if ($config->enablepostbox) {
		echo "<p><b>";
		if ($config->showmenuicons) echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_postbox.png' alt='"._UDDEIM_POSTBOX."' style='height:18px;' />";
		echo " "._UDDEIM_POSTBOX."</b></p>";
		echo "<p>"._UDDEIM_HELP_POSTBOX."</p>";

		echo "<ul>";
		echo "<li>".$uddeicons_readpic." "._UDDEIM_HELP_IREAD."</li>";
		echo "<li>".$uddeicons_unreadpic." "._UDDEIM_HELP_IUNREAD."</li>";
		if ($config->allowflagged) {
			echo "<li>".$uddeicons_flagged." "._UDDEIM_HELP_FLAGGED."</li>";
			echo "<li>".$uddeicons_unflagged." "._UDDEIM_HELP_UNFLAGGED."</li>";
		}
		if ($config->showonline) {
			echo "<li>".$uddeicons_onlinepic." "._UDDEIM_HELP_ONLINE."</li>";
			echo "<li>".$uddeicons_offlinepic." "._UDDEIM_HELP_OFFLINE."</li>";
		}
		if ($config->enableattachment && $config->showlistattachment) {
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/attachment.gif' alt='"._UDDEIM_ATTACHMENT."' title='"._UDDEIM_ATTACHMENT."' />";
			echo " "._UDDEIM_HELP_ATTACHMENT;
			echo "</li>";
		}
		if ($config->actionicons) {
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' />";
			echo " "._UDDEIM_HELP_DELETE;
			echo "</li>";
			if ($config->allowforwards) {
				echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' />";
				echo " "._UDDEIM_HELP_FORWARD;
				echo "</li>";
			}
			if ($config->allowarchive) {
				echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/archive.gif' alt='"._UDDEIM_STORE."' title='"._UDDEIM_STORE."' />";
				echo " "._UDDEIM_HELP_ARCHIVEMSG;
				echo "</li>";
			}
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/restore.gif' alt='"._UDDEIM_RECALL."' title='"._UDDEIM_RECALL."' />";
			echo " "._UDDEIM_HELP_RECALL;
			echo "</li>";
		}
		echo "</ul>";
	} else {
		echo "<p><b>";
		if ($config->showmenuicons) echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_inbox.gif' alt='"._UDDEIM_INBOX."' />";
		echo " "._UDDEIM_INBOX."</b></p>";
		echo "<p>"._UDDEIM_HELP_INBOX."</p>";

		echo "<ul>";
		echo "<li>".$uddeicons_readpic." "._UDDEIM_HELP_IREAD."</li>";
		echo "<li>".$uddeicons_unreadpic." "._UDDEIM_HELP_IUNREAD."</li>";
		if ($config->allowflagged) {
			echo "<li>".$uddeicons_flagged." "._UDDEIM_HELP_FLAGGED."</li>";
			echo "<li>".$uddeicons_unflagged." "._UDDEIM_HELP_UNFLAGGED."</li>";
		}
		if ($config->showonline) {
			echo "<li>".$uddeicons_onlinepic." "._UDDEIM_HELP_ONLINE."</li>";
			echo "<li>".$uddeicons_offlinepic." "._UDDEIM_HELP_OFFLINE."</li>";
		}
		if ($config->enableattachment && $config->showlistattachment) {
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/attachment.gif' alt='"._UDDEIM_ATTACHMENT."' title='"._UDDEIM_ATTACHMENT."' />";
			echo " "._UDDEIM_HELP_ATTACHMENT;
			echo "</li>";
		}
		if ($config->actionicons) {
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' />";
			echo " "._UDDEIM_HELP_DELETE;
			echo "</li>";
			if ($config->allowforwards) {
				echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' />";
				echo " "._UDDEIM_HELP_FORWARD;
				echo "</li>";
			}
			if ($config->allowarchive) {
				echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/archive.gif' alt='"._UDDEIM_STORE."' title='"._UDDEIM_STORE."' />";
				echo " "._UDDEIM_HELP_ARCHIVEMSG;
				echo "</li>";
			}
		}
		echo "</ul>";

		echo "<p><b>";
		if ($config->showmenuicons)	echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_outbox.gif' alt='"._UDDEIM_OUTBOX."' />";
		echo " "._UDDEIM_OUTBOX."</b></p>";
		echo "<p>"._UDDEIM_HELP_OUTBOX."</p>";

		echo "<ul>";
		echo "<li>".$uddeicons_readpic." "._UDDEIM_HELP_OREAD."</li>";
		echo "<li>".$uddeicons_unreadpic." "._UDDEIM_HELP_OUNREAD."</li>";
		if ($config->showonline) {
			echo "<li>".$uddeicons_onlinepic." "._UDDEIM_HELP_ONLINE."</li>";
			echo "<li>".$uddeicons_offlinepic." "._UDDEIM_HELP_OFFLINE."</li>";
		}
		if ($config->enableattachment && $config->showlistattachment) {
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/attachment.gif' alt='"._UDDEIM_ATTACHMENT."' title='"._UDDEIM_ATTACHMENT."' />";
			echo " "._UDDEIM_HELP_ATTACHMENT;
			echo "</li>";
		}
		if ($config->actionicons) {
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' />";
			echo " "._UDDEIM_HELP_DELETE;
			echo "</li>";
			if ($config->allowforwards) {
				echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' />";
				echo " "._UDDEIM_HELP_FORWARD;
				echo "</li>";
			}
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/restore.gif' alt='"._UDDEIM_RECALL."' title='"._UDDEIM_RECALL."' />";
			echo " "._UDDEIM_HELP_RECALL;
			echo "</li>";
		}
		echo "</ul>";
	}

	if ($config->trashrestriction==0 ||
	   ($config->trashrestriction==1 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) || 
	   ($config->trashrestriction==2 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config)))) {
		echo "<p><b>";
		if ($config->showmenuicons)	echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_trashcan.gif' alt='"._UDDEIM_TRASHCAN."' />";
		echo " "._UDDEIM_TRASHCAN."</b></p>";
		echo "<p>"._UDDEIM_HELP_TRASHCAN."</p>";

		echo "<ul>";
		echo "<li>".$uddeicons_readpic." "._UDDEIM_HELP_TREAD."</li>";
		echo "<li>".$uddeicons_unreadpic." "._UDDEIM_HELP_TUNREAD."</li>";
		if ($config->showonline) {
		echo "<li>".$uddeicons_onlinepic." "._UDDEIM_HELP_ONLINE."</li>";
		echo "<li>".$uddeicons_offlinepic." "._UDDEIM_HELP_OFFLINE."</li>";
		}
		if ($config->actionicons) {
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/recycle.gif' alt='"._UDDEIM_RESTORE."' title='"._UDDEIM_RESTORE."' />";
			echo " "._UDDEIM_HELP_RECYCLE;
			echo "</li>";
		}
		echo "</ul>";
	}

	if ($config->allowarchive) {
		echo "<p><b>";
		if ($config->showmenuicons) echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_archive.gif' alt='"._UDDEIM_ARCHIVE."' />";
		echo " "._UDDEIM_ARCHIVE."</b></p>";
		echo "<p>"._UDDEIM_HELP_ARCHIVE."</p>";

		echo "<ul>";
		echo "<li>".$uddeicons_readpic." "._UDDEIM_HELP_IREAD."</li>";
		echo "<li>".$uddeicons_unreadpic." "._UDDEIM_HELP_IUNREAD."</li>";
		if ($config->allowflagged) {
			echo "<li>".$uddeicons_flagged." "._UDDEIM_HELP_FLAGGED."</li>";
			echo "<li>".$uddeicons_unflagged." "._UDDEIM_HELP_UNFLAGGED."</li>";
		}
		if ($config->showonline) {
			echo "<li>".$uddeicons_onlinepic." "._UDDEIM_HELP_ONLINE."</li>";
			echo "<li>".$uddeicons_offlinepic." "._UDDEIM_HELP_OFFLINE."</li>";
		}
		if ($config->enableattachment && $config->showlistattachment) {
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/attachment.gif' alt='"._UDDEIM_ATTACHMENT."' title='"._UDDEIM_ATTACHMENT."' />";
			echo " "._UDDEIM_HELP_ATTACHMENT;
			echo "</li>";
		}
		if ($config->actionicons) {
			echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' />";
			echo " "._UDDEIM_HELP_DELETE;
			echo "</li>";
			if ($config->allowforwards) {
				echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' />";
				echo " "._UDDEIM_HELP_FORWARD;
				echo "</li>";
			}
			if ($config->allowarchive) {
				echo "<li><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/unarchive.gif' alt='"._UDDEIM_UNARCHIVE."' title='"._UDDEIM_UNARCHIVE."' />";
				echo " "._UDDEIM_HELP_UNARCHIVEMSG;
				echo "</li>";
			}
		}
		echo "</ul>";
	}

	if ($config->enablelists==1 ||
	   ($config->enablelists==2 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) || 
	   ($config->enablelists==3 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config)))) {
		echo "<p><b>";
		if ($config->showmenuicons)	echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_book.gif' alt='"._UDDEIM_LISTS."' />";
		echo " "._UDDEIM_LISTS."</b></p>";
		echo "<p>"._UDDEIM_HELP_USERLISTS."</p>";
	}

	echo "<p><b>";
	if ($config->showmenuicons)	echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_settings.gif' alt='"._UDDEIM_SETTINGS."' />";
	echo " "._UDDEIM_SETTINGS."</b></p>";
	echo "<p>"._UDDEIM_HELP_SETTINGS."</p>";

	echo "<ul>";
	if ($config->allowemailnotify==1 || 
	   ($config->allowemailnotify==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)))) {
		echo "<li><b>"._UDDEIM_EMN."</b><br />"._UDDEIM_HELP_NOTIFY."</li>";
	}
	if ($config->autoresponder==1 || 
	   ($config->autoresponder==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)))) {
		echo "<li><b>"._UDDEIM_AUTORESPONDER."</b><br />"._UDDEIM_HELP_AUTORESPONDER."</li>";
	}
	if ($config->autoforward==1 || 
	   ($config->autoforward==2 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) ||
	   ($config->autoforward==3 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config)))) {
		echo "<li><b>"._UDDEIM_AUTOFORWARD."</b><br />"._UDDEIM_HELP_AUTOFORWARD."</li>";
	}
	if ($config->blocksystem) {
		echo "<li><b>"._UDDEIM_BLOCKSYSTEM."</b><br />"._UDDEIM_HELP_BLOCKING."</li>\n";
	}
	if ($config->enablerss==1 || 
	   ($config->enablerss==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)))) {
		echo "<li><b>"._UDDEIM_RSS_FEED."</b><br />"._UDDEIM_HELP_FEED."</li>";
	}
	if ($config->allowpopup || ($config->pubfrontend && !uddeIMisRecipientBlockedPublic($myself, $config)) ) {
		echo "<li><b>"._UDDEIM_OPTIONS."</b><br />"._UDDEIM_HELP_MISC."</li>";
	}
	echo "</ul>";
	
	echo "<p><b>";
	if ($config->showmenuicons)	echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_new.gif' alt='"._UDDEIM_COMPOSE."' />";
	echo " "._UDDEIM_COMPOSE."</b></p>";
	echo "<p>"._UDDEIM_HELP_COMPOSE."</p>";

	echo "</div>\n";
	echo "</div>\n";
	echo "<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'help', 'none', $config)."</div>\n";
}

/**
 * returns userlist for autocomplete functionality
 * @since J!1.5 - uddeim 0.9b+ 2007-11-21
 * @author zenny
 */
function uddeIMcompleteUserName($myself, $config){

	$db = uddeIMgetDatabase();

        // $input = ''; not needed to filter, return full list

		$fieldToUse = $config->realnames ? 'name' : 'username';

			if ($myself) {  // normal use, not public
				$my_gid = $config->usergid;

				$hide = "";
				if ($config->hideusers && !uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config))
					$hide = " AND u.id NOT IN (".uddeIMquoteSmart($config->hideusers).")";

				$hide2 = "";
				if ($config->blockgroups && uddeIMisReggedOnly($my_gid))
					$hide2 = " AND g.id NOT IN (".uddeIMquoteSmart($config->blockgroups).")";

				$query = sprintf( 'SELECT DISTINCT u.id,u.%1$s AS displayname FROM (`#__users` AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id)
								INNER JOIN `#__usergroups` AS g ON um.group_id=g.id
								WHERE u.block=0 AND u.id <> '.$myself.$hide.$hide2.' ORDER BY u.%1$s', $fieldToUse);     // no limit to get full list
                                //, $db->Quote( ($config->searchinstring ? '%' : '').$input.'%' )  AND u.%1$s LIKE %2$s   no more used

			} else {  //public
			    $my_gid = 0;
				$hide = "";
				if ($config->hideusers && !uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config))
					$hide = " AND a.id NOT IN (".uddeIMquoteSmart($config->hideusers).")";

				$hide2 = "";
				if ($config->pubblockgroups)
					$hide2 = " AND a.gid NOT IN (".uddeIMquoteSmart($config->pubblockgroups).")";

                $query = sprintf( 'SELECT a.%1$s AS displayname FROM `#__users` AS a, `#__uddeim_emn` AS b
                                   WHERE a.id=b.userid AND b.public=1 AND a.block=0'.$hide.$hide2.' ORDER BY a.%1$s'   // no limit to get full list
								   , $db->quoteName( $fieldToUse ) // ok
									//, $db->Quote( ($config->pubsearchinstring ? '%' : '').$input.'%' )   AND a.%1$s LIKE %2$s  no mor used
								);
			}

		$db->setQuery( $query );
		$results = $db->loadObjectList();

		$i = 0;
        $users = array();
		foreach ( $results as $item ) {
			$temp = $item->displayname;
			$temp = iconv($config->charset,'UTF-8',$temp);
			//$items[] = array( "id"=>($i+1) ,"value"=>rawurlencode($temp), "info"=>rawurlencode("") );
            $users[] = "\"".$temp."\"";   // simple list, skip the urlencode if called for list
            $i++;
		}

        return implode(", ", $users);  // for javascript add brackets [...]
	}

function uddeIMajaxGetNewMessages($myself, $config){

    if (!$myself)
    return _UDDEIM_NOTLOGGEDIN;

	if (uddeIMcheckJversion()>=4) {
		$jinput = Factory::getApplication()->getInput();
		$input = $jinput->get('value', '', 'USERNAME');
	} else {
        $input = trim( uddeIMmosGetParam($_REQUEST, 'value', '') );
        if (class_exists('Joomla\CMS\Filter\InputFilter')) {
			$filter = new InputFilter;
			$input = $filter->clean($input, 'username');
		} else {
			$input = (string) preg_replace( '/[\x00-\x1F\x7F<>"\'%&]/', '', $input );
		}
	}

	if (function_exists('iconv'))
		$input = iconv('UTF-8',$config->charset,$input);

    $db = uddeIMgetDatabase();
	$sql="SELECT count(a.id) FROM `#__uddeim` AS a WHERE a.totrash=0 AND a.toread=0 AND a.toid=".(int)$myself;
	$db->setQuery($sql);
	$result=(int)$db->loadResult();
	echo $result;
}


function uddeIMreportSpam($myself, $item_id, $messageid, $recip, $ret, $limit, $limitstart, $config) {
	$db = uddeIMgetDatabase();

	// read message $messageid
	$displaymessages = uddeIMselectInboxMessage($myself, $messageid, $config);
	if (count($displaymessages)<1) {
		echo _UDDEIM_MESSAGENOACCESS;
		return;
	}
	if (!uddeIMgetSpamStatus($messageid)) {

		// and append to `#__uddeim_spam`
		foreach($displaymessages as $displaymessage) {
			if ($displaymessage->cryptmode==2 || $displaymessage->cryptmode==4)
				$cm = "Cannot display - Message is encrypted.";
			else
				$cm = uddeIMgetMessage($displaymessage->message, "", $displaymessage->cryptmode, $displaymessage->crypthash, $config->cryptkey);
			$dm = nl2br(htmlspecialchars(stripslashes($cm), ENT_QUOTES, $config->charset));
			$dm = str_replace("&amp;#", "&#", $dm);
			$dm = str_replace("&amp;&lt;/br&gt;", "</br>", $dm);

			$dm = uddeIMencrypt($dm,"",CRYPT_MODE_STOREBASE64);

			$sql  = "INSERT INTO `#__uddeim_spam` (mid, datum, reported, fromid, toid, message) VALUES (".
					(int)$displaymessage->id.", ".
					(int)$displaymessage->datum.", ".
					(int)uddetime($config->timezone).", ".
					(int)$displaymessage->fromid.", ".
					(int)$displaymessage->toid.", ".
					$db->Quote($dm).")";
			$db->setQuery($sql);
			if (!$db->execute())
				die("SQL error when attempting to save a report" . $db->stderr(true));
		}
		uddeIMnotifySpam($myself, $item_id, $displaymessage->fromid, $displaymessage->toid, $config);
	}

	$addlink = "";
	if ($recip)
		$addlink = "&recip=".(int)$recip;
	
	$task = "inbox";
	if ($ret=="postboxuser")
		$task = "postboxuser";
		
	if(!$limit && !$limitstart) {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink;
	} else {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink."&limit=".$limit."&limitstart=".$limitstart;
	}
	uddeJSEFredirect($redirecturl);
}

function uddeIMunreportSpam($myself, $item_id, $messageid, $recip, $ret, $limit, $limitstart, $config) {
	uddeIMdeleteReport($myself, $messageid);

	$addlink = "";
	if ($recip)
		$addlink = "&recip=".(int)$recip;
	
	$task = "inbox";
	if ($ret=="postboxuser")
		$task = "postboxuser";

	if(!$limit && !$limitstart) {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink;
	} else {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart.$addlink;
	}
	uddeJSEFredirect($redirecturl);
}



function uddeIMnotifySpam($myself, $item_id, $fromid, $toid, $config) {
	$db = uddeIMgetDatabase();
	$mosConfig_sitename = uddeIMgetSitename();
	$pathtosite  = uddeIMgetPath('live_site');

	if(!$config->emailtrafficenabled) {
		return;
	}
	if(!$config->allowemailnotify) {
		return;
	}
	
	getAdditonalGroups($add_special, $add_admin, $config);
	if (uddeIMcheckJversion()>=2) {		// J1.6
		$sql="SELECT DISTINCT u.id FROM (`#__users` AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
				INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
				WHERE u.block=0 AND g.id IN (7,8".$add_admin.")";
	} else {
		$sql="SELECT id FROM `#__users` WHERE block=0 AND gid IN (24,25".$add_admin.")";
	}
	$db->setQuery($sql);
	$receivers = $db->loadObjectList();
	if (!count($receivers)) {
		return;
	}

	foreach($receivers as $receiver) {
		// the admin
		$var_toid = $receiver->id;
		$var_toname = uddeIMgetNameFromID($var_toid, $config);
		$var_tomail = uddeIMgetEMailFromID($var_toid, $config);
		if(!$var_tomail)
			continue;
		if (!$var_toname)
			$var_toname = "Anonymous";
	
		$sname = uddeIMgetNameFromID($fromid, $config);
		$dname = uddeIMgetNameFromID($toid, $config);

		$var_body = _UDDEIM_BODY_SPAMREPORT;
		$var_body = str_replace("%livesite%", $pathtosite, $var_body);
		$var_body = str_replace("%you%", $var_toname, $var_body);
		$var_body = str_replace("%fromuser%", $sname, $var_body);
		$var_body = str_replace("%touser%", $dname, $var_body);
		$var_body = str_replace("%site%", $mosConfig_sitename, $var_body);

		$subject = _UDDEIM_SUBJECT_SPAMREPORT;
		$subject = str_replace("%livesite%", $pathtosite, $subject);
		$subject = str_replace("%you%", $var_toname, $subject);
		$var_body = str_replace("%fromuser%", $sname, $var_body);
		$var_body = str_replace("%touser%", $dname, $var_body);
		$subject = str_replace("%site%", $mosConfig_sitename, $subject);

		$replyto = $var_tomail;
		$replytoname = "";

		if(uddeIMsendmail($config->emn_sendername, $config->emn_sendermail, $var_toname, $var_tomail, $subject, $var_body, $replyto, $replytoname, "", $config)) {
			// 
		}
	}
}
