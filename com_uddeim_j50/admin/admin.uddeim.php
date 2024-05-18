<?php
// ********************************************************************************************
// @title         udde Instant Messages (uddeIM)
// @description   Instant Messages System for Joomla 5, main admin file
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
use Joomla\CMS\Language\Text;

$uddeim_isadmin = 1;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
	require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib50.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
	require_once($mainframe->getCfg('absolute_path').'/administrator/components/com_uddeim/admin.uddeimlib50.php');
}

$pathtoadmin = uddeIMgetPath('admin');
$pathtouser  = uddeIMgetPath('user');
$pathtosite  = uddeIMgetPath('live_site');


require_once($pathtoadmin."/admin.shared.php");
require_once($pathtouser.'/includes.php');
require_once($pathtouser.'/includes.db.php');
require_once($pathtoadmin."/admin.includes.php");
require_once($pathtoadmin."/admin.usersettings.php");
require_once($pathtouser."/crypt.class.php");

global $configversion,$versionstring;  //$configversion	= "2.8";

if ($plugin=uddeIMcheckPlugin('mcp'))
	require_once($plugin);
if ($plugin=uddeIMcheckPlugin('spamcontrol'))
	require_once($plugin);
if ($plugin=uddeIMcheckPlugin('postbox'))
	require_once($plugin);
if ($plugin=uddeIMcheckPlugin('attachment'))
	require_once($plugin);
if ($plugin=uddeIMcheckPlugin('rss'))
	require_once($plugin);
if ($plugin=uddeIMcheckPlugin('pfrontend'))
	include_once($plugin);


clearstatcache(TRUE,$pathtoadmin."/config.class.php");

require($pathtoadmin."/config.class.php");			// configuration file
$config = new uddeimconfigclass();
uddeIMcheckConfig($pathtouser, $pathtoadmin, $config);
$usedlanguage = uddeIMloadLanguage($pathtoadmin, $config);

uddeIMcompTitle(""._UDDEADM_UDDEIM."");

$task	= uddeIMmosGetParam( $_REQUEST, 'task', 'settings');
$option	= uddeIMmosGetParam( $_REQUEST, 'option', 'com_uddeim');

if ($config->version!=$configversion) {
    echo 'configversion='.$configversion.' ';
	$task='convertconfig';	// its the wrong configuration file, so we have to convert it first
}

if (uddeIMcheckJversion()>=4) {	// Joomla >=2.5
	if (!Factory::getApplication()->getIdentity()->authorise('core.manage', 'com_uddeim')) {
        return Factory::getApplication()->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'warning');
    }
} else {
	$userid = uddeIMgetUserID();
	$my_gid = uddeIMgetGID($userid);
	if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
		$mosmsg = _UDDEIM_VIOLATION;
		$redirecturl = uddeIMredirectIndex();
		uddeIMmosRedirect($redirecturl, $mosmsg);
	}
}

$act	= uddeIMmosGetParam($_REQUEST, 'act', '');
$id		= uddeIMmosGetParam($_REQUEST, 'id', 0);
$uddeid	= uddeIMmosGetParam($_REQUEST, 'uddeid', array());
if (!is_array($uddeid)) {
	$uddeid = array();
}

echo "\n<!-- ".$versionstring." output below -->\n";

if (uddeIMcheckJversion()>=5) {
	// load the admin css file for Joomla 3.0+
	$css = "";
	if(file_exists($pathtouser.'/templates/admin/admin.uddeim.css')) {
		$css = $pathtouser.'/templates/admin/admin.uddeim.css';
	} else {
		// template css doesn't exist, now we try to load the default css file
		if(file_exists(file_exists($pathtoadmin.'/admin.uddeim.css'))
			$css = $pathtoadmin.'/admin.uddeim.css';
	}
	if ($css)
		uddeIMaddCSS($css);
}


switch ($task) {
	// Report Control Center
	case "spamcontrol":
		uddeIMshowSpamControl($option, $task, $act, $config);
		break;
	case "reportremove":
	case "spamremove":
		uddeIMremoveReportSPAM($option, $task, $uddeid, $config);
		break;

	// Message Control Center
	case "mcp":
		uddeIMshowMCP($option, $task, $act, $config);
		break;
	case "messageremove":
	case "messagedeliver":
		uddeIMremoveMessage($option, $task, $uddeid, $config);
		break;

	// User settings
	case "usermessagesremove":
		uddeIMusermessagesremove($option, $task, $uddeid, $config);
		break;
	case "usersettingsremove":
	case "usersettingsnew":
		uddeIMdolistEMN($option, $task, $uddeid, $config);
		break;
	case "editautoresponder":
		uddeIMeditAutoresponder($option, $task, $act, $config);
		break;
	case "saveautoresponder":
		uddeIMsaveAutoresponder($option, $task, $act, $config);
		break;
	case "editautoforward":
		uddeIMeditAutoforward($option, $task, $act, $config);
		break;
	case "saveautoforward":
		uddeIMsaveAutoforward($option, $task, $act, $config);
		break;
	case "usersettings":
		uddeIMshowUsersettings($option, $task, $act, $config);
		break;

	case "convertconfig":
		// convert config and recall admin
		uddeIMconvertConfiguration($option, $task, $pathtoadmin, $configversion, $config);
		break;

	case "settings":
		uddeIMshowSettings($option, $task, $usedlanguage, $pathtoadmin, $pathtouser, $versionstring, $config);
		break;

	case "savesettings":
		$config->cryptkey = uddeIMmosGetParam ($_POST, 'config_cryptkey', 'uddeIMOpensslKey');
		$config->datumsformat = uddeIMmosGetParam ($_POST, 'config_datumsformat', 'j M, H:i');
		$config->ldatumsformat = uddeIMmosGetParam ($_POST, 'config_ldatumsformat', 'j F Y, H:i');  
		$config->emn_sendermail = uddeIMmosGetParam ($_POST, 'config_emn_sendermail', 'webmaster');   
		$config->emn_sendername = uddeIMquotestrip(uddeIMmosGetParam ($_POST, 'config_emn_sendername', 'Messaging'));  
		$config->sysm_username = htmlspecialchars(uddeIMquotestrip(uddeIMmosGetParam ($_POST,'config_sysm_username', 'System')),ENT_QUOTES);   	
		$config->charset = uddeIMmosGetParam($_POST,'config_charset');  	
		$config->mailcharset = uddeIMmosGetParam($_POST,'config_mailcharset');  			
		$config->emn_body_nomessage = uddeIMmosGetParam($_POST,'config_emn_body_nomessage', '');	
		$config->emn_body_withmessage = uddeIMmosGetParam($_POST,'config_emn_body_withmessage', '');	
		$config->emn_forgetmenot = uddeIMmosGetParam($_POST,'config_emn_forgetmenot', '');	
		$config->export_format = uddeIMmosGetParam($_POST,'config_export_format', '');				
		$config->showtitle = stripslashes(uddeIMmosGetParam($_POST,'config_showtitle', ''));			
		$config->templatedir = uddeIMmosGetParam($_POST,'config_templatedir');					
		$config->quotedivider = uddeIMmosGetParam ($_POST, 'config_quotedivider', '__________');

		$xxx=uddeIMmosGetParam ($_POST, 'config_blockgroups', array());  
		if (!is_array( $xxx ))
			$xxx = array();
		$config->blockgroups = implode(",", $xxx);

		$xxx=uddeIMmosGetParam ($_POST, 'config_pubblockgroups', array());  
		if (!is_array( $xxx ))
			$xxx = array();
		$config->pubblockgroups = implode(",", $xxx);

		$xxx=trim(uddeIMmosGetParam ($_POST, 'config_hideusers'));
		if ($xxx) {
			$xxx=explode(",", $xxx);
			$xxx=array_map("intval", $xxx);
			$xxx=implode(",", $xxx);
		}
		$config->hideusers = $xxx;

		$xxx=trim(uddeIMmosGetParam ($_POST, 'config_pubhideusers'));
		if ($xxx) {
			$xxx=explode(",", $xxx);
			$xxx=array_map("intval", $xxx);
			$xxx=implode(",", $xxx);
		}
		$config->pubhideusers = $xxx;

		$xxx=uddeIMmosGetParam ($_POST, 'config_attachmentgroups', array());  
		if (!is_array( $xxx ))
			$xxx = array();
		$config->attachmentgroups = implode(",", $xxx);

		$config->recaptchaprv = uddeIMmosGetParam($_POST,'config_recaptchaprv', '');
		$config->recaptchapub = uddeIMmosGetParam($_POST,'config_recaptchapub', '');
		$config->allowedextensions = uddeIMmosGetParam($_POST,'config_allowedextensions', '');
		$config->badwords = uddeIMmosGetParam($_POST,'config_badwords', '');
		$config->gravatard = uddeIMmosGetParam ($_POST, 'config_gravatard', '');		
		$config->gravatarr = uddeIMmosGetParam ($_POST, 'config_gravatarr', 'g');		

		$xxx=trim(uddeIMmosGetParam ($_POST, 'config_groupsadmin'));
		if ($xxx) {
			$xxx=explode(",", $xxx);
			$xxx=array_map("intval", $xxx);
			$xxx=implode(",", $xxx);
		}
		$config->groupsadmin = $xxx;

		$xxx=trim(uddeIMmosGetParam ($_POST, 'config_groupsspecial'));
		if ($xxx) {
			$xxx=explode(",", $xxx);
			$xxx=array_map("intval", $xxx);
			$xxx=implode(",", $xxx);
		}
		$config->groupsspecial = $xxx;

		$config->TrashLifespan = (float)uddeIMmosGetParam ($_POST, 'config_TrashLifespan', 2, _MOS_ALLOWRAW);	// otherwise we will not get a float (maybe $config->TrashLifespan = (float) $_POST['config_TrashLifespan'];)
		$config->ReadMessagesLifespan = (int)uddeIMmosGetParam ($_POST, 'config_ReadMessagesLifespan', 36524);
		$config->UnreadMessagesLifespan = (int)uddeIMmosGetParam ($_POST, 'config_UnreadMessagesLifespan', 36524);
		$config->SentMessagesLifespan = (int)uddeIMmosGetParam ($_POST, 'config_SentMessagesLifespan', 36524);
		$config->ReadMessagesLifespanNote = (int)uddeIMmosGetParam ($_POST, 'config_ReadMessagesLifespanNote', 0);
		$config->UnreadMessagesLifespanNote = (int)uddeIMmosGetParam ($_POST, 'config_UnreadMessagesLifespanNote', 0);
		$config->SentMessagesLifespanNote = (int)uddeIMmosGetParam ($_POST, 'config_SentMessagesLifespanNote', 0);
		$config->TrashLifespanNote = (int)uddeIMmosGetParam ($_POST, 'config_TrashLifespanNote', 1);
		$config->adminignitiononly = (int)uddeIMmosGetParam ($_POST, 'config_adminignitiononly', 1);
		$config->pmsimportdone = (int)uddeIMmosGetParam ($_POST, 'config_pmsimportdone', 0);
		$config->blockalert = (int)uddeIMmosGetParam ($_POST, 'config_blockalert', 0);
		$config->blocksystem = (int)uddeIMmosGetParam ($_POST, 'config_blocksystem', 0);
		$config->allowemailnotify = (int)uddeIMmosGetParam ($_POST, 'config_allowemailnotify', 0);
		$config->notifydefault = (int) uddeIMmosGetParam ($_POST, 'config_notifydefault', 0);
		$config->popupdefault = (int) uddeIMmosGetParam ($_POST, 'config_popupdefault', 0);
		$config->allowsysgm = (int)uddeIMmosGetParam ($_POST, 'config_allowsysgm', 0);
		$config->emailwithmessage = (int)uddeIMmosGetParam ($_POST, 'config_emailwithmessage', 0);
		$config->firstwordsinbox = (int)uddeIMmosGetParam ($_POST, 'config_firstwordsinbox', 40);
		$config->longwaitingdays = (int)uddeIMmosGetParam ($_POST, 'config_longwaitingdays', 75);
		$config->longwaitingemail = (int)uddeIMmosGetParam ($_POST, 'config_longwaitingemail', 0);
		$config->maxlength = (int)uddeIMmosGetParam ($_POST, 'config_maxlength', 1200);
		$config->showcblink = (int)uddeIMmosGetParam ($_POST, 'config_showcblink', 0);
		$config->showmenulink = (int)uddeIMmosGetParam ($_POST, 'config_showmenulink', 0);
		$config->showcbpic = (int)uddeIMmosGetParam ($_POST, 'config_showcbpic', 0);
		$config->showonline = (int)uddeIMmosGetParam ($_POST, 'config_showonline', 1);
		$config->allowarchive = (int)uddeIMmosGetParam ($_POST, 'config_allowarchive', 0);
		$config->maxarchive = (int)uddeIMmosGetParam ($_POST, 'config_maxarchive', 100);
		$config->allowcopytome = (int)uddeIMmosGetParam ($_POST, 'config_allowcopytome', 0);
		$config->trashoriginal = (int)uddeIMmosGetParam ($_POST, 'config_trashoriginal', 1);
		$config->perpage = (int)uddeIMmosGetParam ($_POST, 'config_perpage', 8);
		$config->enabledownload = (int)uddeIMmosGetParam ($_POST, 'config_enabledownload', 0);
		$config->inboxlimit = (int)uddeIMmosGetParam ($_POST, 'config_inboxlimit', 0);
		$config->showinboxlimit = (int)uddeIMmosGetParam ($_POST, 'config_showinboxlimit',0);
		$config->allowpopup = (int)uddeIMmosGetParam ($_POST, 'config_allowpopup', 0);
		$config->allowbb = (int)uddeIMmosGetParam ($_POST, 'config_allowbb', 1);
		$config->allowsmile = (int)uddeIMmosGetParam ($_POST, 'config_allowsmile', 1);
		$config->animated = (int)uddeIMmosGetParam ($_POST, 'config_animated', 0);
		$config->animatedex = (int)uddeIMmosGetParam ($_POST, 'config_animatedex', 0);
		$config->showmenuicons = (int)uddeIMmosGetParam ($_POST, 'config_showmenuicons', 1);
		$config->bottomlineicons = (int)uddeIMmosGetParam ($_POST, 'config_bottomlineicons', 1);
		$config->actionicons = (int)uddeIMmosGetParam ($_POST, 'config_actionicons', 1);
		$config->showconnex = (int)uddeIMmosGetParam ($_POST, 'config_showconnex', 0);
		$config->showsettingslink = (int)uddeIMmosGetParam ($_POST, 'config_showsettingslink', 0);
		$config->connex_listbox = (int)uddeIMmosGetParam ($_POST, 'config_connex_listbox', 0);
		$config->forgetmenotstart = (int)uddeIMmosGetParam ($_POST, 'config_forgetmenotstart', 0);
		$config->showabout = (int)uddeIMmosGetParam ($_POST, 'config_showabout', 0);
		$config->emailtrafficenabled = (int)uddeIMmosGetParam ($_POST, 'config_emailtrafficenabled', 0);
		$config->getpiclink = (int)uddeIMmosGetParam ($_POST, 'config_getpiclink', 0);
		$config->realnames = (int)uddeIMmosGetParam ($_POST, 'config_realnames', 0);
		$config->cryptmode = (int)uddeIMmosGetParam ($_POST, 'config_cryptmode', 0);
		$config->modeshowallusers = (int)uddeIMmosGetParam ($_POST, 'config_modeshowallusers', 0);
		$config->useautocomplete = (int)uddeIMmosGetParam ($_POST, 'config_useautocomplete', 0);
		$config->allowmultipleuser = (int)uddeIMmosGetParam ($_POST, 'config_allowmultipleuser', 0);
		$config->connexallowmultipleuser = (int)uddeIMmosGetParam ($_POST, 'config_connexallowmultipleuser', 0);
		$config->allowmultiplerecipients = (int)uddeIMmosGetParam ($_POST, 'config_allowmultiplerecipients', 0);
		$config->showtextcounter = (int)uddeIMmosGetParam ($_POST, 'config_showtextcounter', 1);
		$config->allowforwards = (int)uddeIMmosGetParam ($_POST, 'config_allowforwards', 1);
		$config->showgroups = (int)uddeIMmosGetParam ($_POST, 'config_showgroups', 0);
		$config->mailsystem = (int)uddeIMmosGetParam ($_POST, 'config_mailsystem', 0);
		$config->searchinstring = (int)uddeIMmosGetParam ($_POST, 'config_searchinstring', 1);
		$config->maxrecipients = (int)uddeIMmosGetParam ($_POST, 'config_maxrecipients', 0);
		$config->languagecharset = (int)uddeIMmosGetParam ($_POST, 'config_languagecharset', 0);
		$config->usecaptcha = (int)uddeIMmosGetParam ($_POST, 'config_usecaptcha', 0);
		$config->captchalen = (int)uddeIMmosGetParam ($_POST, 'config_captchalen', 4);
		$config->pubfrontend = (int)uddeIMmosGetParam ($_POST, 'config_pubfrontend', 0);
		$config->pubfrontenddefault = (int)uddeIMmosGetParam ($_POST, 'config_pubfrontenddefault', 0);
		$config->pubmodeshowallusers = (int)uddeIMmosGetParam ($_POST, 'config_pubmodeshowallusers', 0);
		$config->hideallusers = (int)uddeIMmosGetParam ($_POST, 'config_hideallusers', 0);
		$config->pubhideallusers = (int)uddeIMmosGetParam ($_POST, 'config_pubhideallusers', 0);
		$config->unblockCBconnections = (int)uddeIMmosGetParam ($_POST, 'config_unblockCBconnections', 1);
		$config->CBgallery = (int)uddeIMmosGetParam ($_POST, 'config_CBgallery', 0);
		$config->enablelists = (int)uddeIMmosGetParam ($_POST, 'config_enablelists', 0);
		$config->maxonlists = (int)uddeIMmosGetParam ($_POST, 'config_maxonlists', 100);
		$config->timedelay = (int)uddeIMmosGetParam ($_POST, 'config_timedelay', 0);
		$config->pubrealnames = (int)uddeIMmosGetParam ($_POST, 'config_pubrealnames', 0);
		$config->pubreplies = (int)uddeIMmosGetParam ($_POST, 'config_pubreplies', 0);
		$config->pubemail = (int)uddeIMmosGetParam ($_POST, 'config_pubemail', 0);
		$config->csrfprotection = (int)uddeIMmosGetParam ($_POST, 'config_csrfprotection', 0);
		$config->trashrestriction = (int)uddeIMmosGetParam ($_POST, 'config_trashrestriction', 0);
		$config->replytruncate = (int)uddeIMmosGetParam ($_POST, 'config_replytruncate', 0);
		$config->allowflagged = (int)uddeIMmosGetParam ($_POST, 'config_allowflagged', 0);
		$config->overwriteitemid = (int)uddeIMmosGetParam ($_POST, 'config_overwriteitemid', 0);
		$config->useitemid = (int)uddeIMmosGetParam ($_POST, 'config_useitemid', 0);
		$config->timezone = (float)uddeIMmosGetParam ($_POST, 'config_timezone', 0, _MOS_ALLOWRAW);	// otherwise we will not get a float
		$config->pubuseautocomplete = (int)uddeIMmosGetParam ($_POST, 'config_pubuseautocomplete', 0);
		$config->pubsearchinstring = (int)uddeIMmosGetParam ($_POST, 'config_pubsearchinstring', 1);
		$config->autocompleter = (int)uddeIMmosGetParam ($_POST, 'config_autocompleter', 0);
        $config->autocompletestart = (int)uddeIMmosGetParam ($_POST, 'config_autocompletestart', 1);
        $config->autoresponder = (int)uddeIMmosGetParam ($_POST, 'config_autoresponder', 0);
		$config->autoforward = (int)uddeIMmosGetParam ($_POST, 'config_autoforward', 0);
		$config->rows = (int)uddeIMmosGetParam ($_POST, 'config_rows', 10);
		$config->cols = (int)uddeIMmosGetParam ($_POST, 'config_cols', 60);
		$config->width = (int)uddeIMmosGetParam ($_POST, 'config_width', 0);
		$config->enablefilter = (int)uddeIMmosGetParam ($_POST, 'config_enablefilter', 0);
		$config->enablereply = (int)uddeIMmosGetParam ($_POST, 'config_enablereply', 0);
		$config->enablerss = (int)uddeIMmosGetParam ($_POST, 'config_enablerss', 0);
		$config->showigoogle = (int)uddeIMmosGetParam ($_POST, 'config_showigoogle', 0);
		$config->showhelp = (int)uddeIMmosGetParam ($_POST, 'config_showhelp', 0);
		$config->separator = (int)uddeIMmosGetParam ($_POST, 'config_separator', 0);
		$config->rsslimit = (int)uddeIMmosGetParam ($_POST, 'config_rsslimit', 20);
		$config->restrictallusers = (int)uddeIMmosGetParam ($_POST, 'config_restrictallusers', 0);
		$config->trashoriginalsent = (int)uddeIMmosGetParam ($_POST, 'config_trashoriginalsent', 0);
		$config->reportspam = (int)uddeIMmosGetParam ($_POST, 'config_reportspam', 0);
		$config->checkbanned = (int)uddeIMmosGetParam ($_POST, 'config_checkbanned', 0);
		$config->enableattachment = (int)uddeIMmosGetParam ($_POST, 'config_enableattachment', 0);
		$config->maxsizeattachment = (int)uddeIMmosGetParam ($_POST, 'config_maxsizeattachment', 16384);
		$config->maxattachments = (int)uddeIMmosGetParam ($_POST, 'config_maxattachments', 1);
		$config->fileadminignitiononly = (int)uddeIMmosGetParam ($_POST, 'config_fileadminignitiononly', 1);
		$config->showlistattachment =(int)uddeIMmosGetParam ($_POST, 'config_showlistattachment', 1);
		$config->showmenucount = (int)uddeIMmosGetParam ($_POST, 'config_showmenucount', 0);
		$config->encodeheader = (int)uddeIMmosGetParam ($_POST, 'config_encodeheader', 0);
		$config->enablesort = (int)uddeIMmosGetParam ($_POST, 'config_enablesort', 0);
		$config->captchatype = (int)uddeIMmosGetParam ($_POST, 'config_captchatype', 0);
		$config->unprotectdownloads = (int)uddeIMmosGetParam ($_POST, 'config_unprotectdownloads', 0);
		$config->waitdays = (float)uddeIMmosGetParam ($_POST, 'config_waitdays', 0, _MOS_ALLOWRAW);
		$config->avatarw = (int)uddeIMmosGetParam ($_POST, 'config_avatarw', 0);
		$config->avatarh = (int)uddeIMmosGetParam ($_POST, 'config_avatarh', 0);
		$config->gravatar = (int)uddeIMmosGetParam ($_POST, 'config_gravatar', 0);
		$config->addccline = (int)uddeIMmosGetParam ($_POST, 'config_addccline', 0);
		$config->modnewusers = (int)uddeIMmosGetParam ($_POST, 'config_modnewusers', 0);
		$config->modpubusers = (int)uddeIMmosGetParam ($_POST, 'config_modpubusers', 0);
		$config->restrictcon = (int)uddeIMmosGetParam ($_POST, 'config_restrictcon', 0);
		$config->restrictrem = (int)uddeIMmosGetParam ($_POST, 'config_restrictrem', 0);
		$config->stime = (int)uddeIMmosGetParam ($_POST, 'config_stime', 0);
		$config->dontsefmsglink = (int)uddeIMmosGetParam ($_POST, 'config_dontsefmsglink', 0);
		$config->enablepostbox = (int)uddeIMmosGetParam ($_POST, 'config_enablepostbox', 0);
		$config->postboxfull = (int)uddeIMmosGetParam ($_POST, 'config_postboxfull', 0);
		$config->postboxavatars = (int)uddeIMmosGetParam ($_POST, 'config_postboxavatars', 0);
		$config->replytext = (int)uddeIMmosGetParam ($_POST, 'config_replytext', 1);
                $config->saveconfigdb = (int)uddeIMmosGetParam ($_POST, 'config_saveconfigdb', 0);

		$oldsetting_allowarchive=uddeIMmosGetParam ($_POST, 'oldsetting_allowarchive', 0);
		$oldsetting_longwaitingemail= uddeIMmosGetParam ($_POST, 'oldsetting_longwaitingemail', 0);
		$GLOBALS['oldsetting_allowarchive'] = $oldsetting_allowarchive;
		$GLOBALS['oldsetting_longwaitingemail'] = $oldsetting_longwaitingemail;

		uddeIMcheckConfig($pathtouser, $pathtoadmin, $config);
		uddeIMsaveSettings($option, $task, $pathtoadmin, $config);
		break;
	
	case "cancel":
		$redirecturl = uddeIMredirectIndex();
		uddeIMmosRedirect($redirecturl);
	
	case "importpms":
		$start=(int)uddeIMmosGetParam ($_REQUEST, 'importstart', 0);
		$count=(int)uddeIMmosGetParam ($_REQUEST, 'importcount', 0);
		uddeIMimportPMS($option, $task, $act, $start, $count, $pathtoadmin, $config);
		break;
	
	case "archivetotrash":
		uddeIMarchivetoTrash($option, $task, $act, $config);
		break;	

	case "maintenance":
		uddeIMmaintenanceCheckTrash($option, $task, $act, $config);		// act=trash/check
		break;	

	case "maintenancefix":
		uddeIMmaintenanceCheckFix($option, $task, $act, $config);		// act=fix/check
		break;	

	case "maintenanceprune":
		uddeIMmaintenancePrune($option, $task, $config);
		break;

	case "filemaintenanceprune":
		uddeIMfileMaintenancePrune($option, $task, $config);
		break;

	case "backuprestore":
		uddeIMbackupRestoreConfig($option, $task, $act, $pathtoadmin, $config);		// act=emtpy, backup, restore
		break;

	case "versioncheck":
		uddeIMversioncheck($option, $task, $checkversion, $checkhotfix);
		break;

	case "showstatistics":
		uddeIMshowstatistics($option, $task, $config);
		break;

	default:
		uddeIMshowSettings($option, $task, $usedlanguage, $pathtoadmin, $pathtouser, $versionstring, $config);
		break;	
}

function uddeIMsaveSettings($option, $task, $pathtoadmin, $config) {
	global $oldsetting_allowarchive, $oldsetting_longwaitingemail;

	$database = uddeIMgetDatabase();
	if(($oldsetting_longwaitingemail != $config->longwaitingemail) && ($config->longwaitingemail==1)) {
		$config->forgetmenotstart=uddetime($config->timezone);
	}
	if (!uddeIMsaveConfig($pathtoadmin, $config))
		return;

    //save config to database
    if ($config->saveconfigdb)
    uddeIMbackupRestoreConfig($option, $task, 'backup', $pathtoadmin, $config, true); //true means: "during save, no redirect"

	if($oldsetting_allowarchive==1 && $config->allowarchive==0) {
		$mosmsg = _UDDEADM_SETTINGSSAVED;
		$redirecturl = uddeIMredirectIndex()."?option=com_uddeim&task=archivetotrash";
		uddeIMmosRedirect($redirecturl, $mosmsg);
	}

    $ocreset = function_exists('opcache_reset') ? opcache_reset() : 0;
	$mosmsg=_UDDEADM_SETTINGSSAVED;
	$redirecturl = uddeIMredirectIndex()."?option=com_uddeim&task=settings&ocr=".$ocreset;
	uddeIMmosRedirect($redirecturl, $mosmsg);
}


function uddeIMimportPMS($option, $task, $act, $start, $count, $pathtoadmin, $config) {
	$database = uddeIMgetDatabase();
	$act = (int)$act;
	$mypmstypes = uddeIMcheckPMStype();

	$mypmstype = 0;
	if ( in_array($act, $mypmstypes) ) {
		echo _UDDEADM_IMPORTING;
		$mypmstype = $act;
	}

	$limit = "";
	if ($count>0) {
		$limit = " LIMIT ".$start.",".$count;
	}
	
// **************************************************************************************************
	if ($mypmstype==1) {     // import myPMS II 2.x

		$sql="SELECT id, whofrom, username AS whoto, date, time, message, subject, readstate FROM `#__pms`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			// convert the usernames saved in the PMS messages to user IDs
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whofrom."'";
			$database->setQuery($sql);
			$fromid=$database->loadResult();
		
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whoto."'";
			$database->setQuery($sql);
			$toid=$database->loadResult();
		
			// merge the PMS fields date and time into one single unix timestamp
			$totaldate=$thepms->date." ".$thepms->time;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);

			$toread=$thepms->readstate;
		
			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==2) {     // import myPMS Enhanced 2.x

		$sql="SELECT id, sender_id, recip_id, date, time, message, subject, readstate, inbox, sent_items FROM `#__pms`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			$fromid=$thepms->sender_id;
			$toid  =$thepms->recip_id;
		
			// merge the PMS fields date and time into one single unix timestamp
			$totaldate=$thepms->date." ".$thepms->time;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;
			$pmessage=str_replace("<br />", "", $pmessage);
			$pmessage=str_replace("<br/>", "", $pmessage);
			$pmessage=str_replace("<br>", "", $pmessage);	
			$pmessage=stripslashes($pmessage);
			$pmessage=addslashes($pmessage);	
			$pmessage=strip_tags($pmessage);
	
			$toread=$thepms->readstate;
			$totrash=0;
			$totrashoutbox=0;
			if ($thepms->inbox<0)
				$totrash=1;
			if ($thepms->sent_items<0)
				$totrashoutbox=1;

			$totrashdate="NULL";
			if ($totrash) {
				$totrashdate=uddetime($config->timezone);
			}
			$totrashdateoutbox="NULL";
			if ($totrashoutbox) {
				$totrashdateoutbox=uddetime($config->timezone);
			}

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrash, totrashdate, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$totrash.", ".$totrashdate.", ".(int)$totrashoutbox.", ".$totrashdateoutbox.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==3) {    // import jim 1.x

		$sql="SELECT id, whofrom, username AS whoto, date, message, subject, outbox, readstate FROM `#__jim`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			// convert the usernames saved in the PMS messages to user IDs
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whofrom."'";
			$database->setQuery($sql);
			$fromid=$database->loadResult();
		
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whoto."'";
			$database->setQuery($sql);
			$toid=$database->loadResult();
		
			// jim stores date and time in one field
			$totaldate=$thepms->date;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);

			$toread=$thepms->readstate;
		
			$totrashoutbox=0;
			if (!$thepms->outbox)
				$totrashoutbox=1;

			$totrashdateoutbox="NULL";
			if ($totrashoutbox)
				$totrashdateoutbox=uddetime($config->timezone);

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$totrashoutbox.", ".$totrashdateoutbox.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==4) {      // import Archaic Binary Private Messages 1.x

		$sql="SELECT id, sender AS whofrom, usern AS whoto, created, title, text, opened FROM `#__abim_data`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			// convert the usernames saved in the PMS messages to user IDs
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whofrom."'";
			$database->setQuery($sql);
			$fromid=$database->loadResult();
		
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whoto."'";
			$database->setQuery($sql);
			$toid=$database->loadResult();
		
			$totaldate=$thepms->created;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->title)
				$pmessage="[b]".$thepms->title."[/b]\n\n".$thepms->text;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);

			$toread=$thepms->opened;
		
			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==5) {   // import JAM

		// Do not import drafts, but note that one message may have many receivers - improved code by Matias Griese <matias@kunena.com>
		$sql="SELECT m.id, m.sid, m.outbox, m.subject, m.message, m.datetime, m.system, r.rid, r.state, r.inbox FROM `#__jam` AS m LEFT JOIN `#__jam_receivers` AS r ON r.mid=m.id WHERE draft=0".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) { 

			$toid	= $thepms->rid;
			$fromid	= $thepms->sid;
			
			$archived = 0;
			$totrash = 0;
			if ($thepms->inbox==-2) {
				$archived = 1;
				$totrash = 1;
			} elseif ($thepms->inbox==2) {
				$archived = 1;
				$totrash = 0;
			} elseif ($thepms->inbox==-1) {
				$archived = 0;
				$totrash = 1;
			}

			$totrashdate = "NULL";
			if ($totrash) {
				$totrashdate=uddetime($config->timezone);
			}
		
            $totrashoutbox = 0;
            if ($thepms->outbox<0) {
                $totrashoutbox = 1;
            }
            $totrashdateoutbox = "NULL";
			if ($totrashoutbox) {
				$totrashdateoutbox=uddetime($config->timezone);
			}

			$totaldate=$thepms->datetime;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);
			$toread=$thepms->state; 

			$disablereply=0;
			$systemflag=0;
			if ($thepms->system) {
				$disablereply=1;
				$systemflag=1;
			}

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, systemflag, disablereply, archived, totrash, totrashdate, totrashoutbox, totrashdateoutbox) VALUES (".
						(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$systemflag.", ".(int)$disablereply.", ".(int)$archived.", ".(int)$totrash.", ".$totrashdate.", ".(int)$totrashoutbox.", ".$totrashdateoutbox.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==6) {     // import Clexus 2.0

		$sql="SELECT id, whofrom, userid AS whoto, time, message, subject, readstate FROM `#__mypms`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			$fromid=$thepms->whofrom;
			$toid  =$thepms->whoto;

			// merge the PMS fields date and time into one single unix timestamp
			$totaldate=$thepms->time;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);

			$toread=$thepms->readstate;

			if($fromid && $toid && $pmessage) {
				if ($fromid==$toid) {
					$trashoffset=((float)$config->TrashLifespan)*86400;
					$deletetime=uddetime($config->timezone)-$trashoffset;
					$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", 1, ".$deletetime.")";
				} else {
					$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.")";
				}
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==7) {     // import Missus 1.x

		$sql = "SELECT m.id, subject, message, senderid, sendername, sendermail, datesended, "
				."receptorid, broadcast, replied, forwarded, rptr_rstate AS readstate, rptr_tstate AS totrash, sdr_tstate AS totrashoutbox "
				."FROM `#__missus` AS m JOIN `#__missus_receipt` AS r "
				."WHERE m.id = r.id AND m.is_draft=0".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			$fromid=$thepms->senderid;
			$toid  =$thepms->receptorid;
		
			$totaldate=$thepms->datesended;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);
	
			$toread=$thepms->readstate;
			$totrash=$thepms->totrash;
			$totrashoutbox=$thepms->totrashoutbox;

			$totrashdate="NULL";
			if ($totrash) {
				$totrashdate=uddetime($config->timezone);
			}
			$totrashdateoutbox="NULL";
			if ($totrashoutbox) {
				$totrashdateoutbox=uddetime($config->timezone);
			}

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrash, totrashdate, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$totrash.", ".$totrashdate.", ".(int)$totrashoutbox.", ".$totrashdateoutbox.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==8) {    // import Primezilla 1.0

		$sql="SELECT id, userid, userid_from, msg_date, msg_time, subject, message, flag_read, flag_deleted FROM `#__primezilla_inbox`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			$fromid=$thepms->userid_from;
			$toid  =$thepms->userid;
		
			// merge the PMS fields date and time into one single unix timestamp
			$totaldate=$thepms->msg_date." ".$thepms->msg_time;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);
	
			$toread=$thepms->flag_read;
			$totrash=0;
			if ($thepms->flag_deleted)
				$totrash=1;
			$totrashoutbox=1;

			$totrashdate="NULL";
			if ($totrash) {
				$totrashdate=uddetime($config->timezone);
			}
			$totrashdateoutbox="NULL";
			if ($totrashoutbox) {
				$totrashdateoutbox=uddetime($config->timezone);
			}

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrash, totrashdate, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$totrash.", ".$totrashdate.", ".(int)$totrashoutbox.", ".$totrashdateoutbox.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==9) {    // import myPMS OS 2.x

		$sql="SELECT id, whofrom, username AS whoto, date, message, subject, readstate FROM `#__pms`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			// convert the usernames saved in the PMS messages to user IDs
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whofrom."'";
			$database->setQuery($sql);
			$fromid=$database->loadResult();
		
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whoto."'";
			$database->setQuery($sql);
			$toid=$database->loadResult();
		
			$totaldate=$thepms->date;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);

			$toread=$thepms->readstate;
		
			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==10) {   // import myPMS Pro 1.x

		$sql="SELECT id, whofrom, username AS whoto, time, message, subject, readstate FROM `#__mypms`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			// convert the usernames saved in the PMS messages to user IDs
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whofrom."'";
			$database->setQuery($sql);
			$fromid=$database->loadResult();
		
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whoto."'";
			$database->setQuery($sql);
			$toid=$database->loadResult();
		
			$totaldate=$thepms->time;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);

			$toread=$thepms->readstate;

			$totrash=0;
			if ($toread==2) {
				$totrash=1;
				$toread=1;
			}
			$totrashdate="NULL";
			if ($totrash)
				$totrashdate=uddetime($config->timezone);

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrash, totrashdate) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$totrash.", ".$totrashdate.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==11) {    // import jim reloaded 1.x

		$sql="SELECT id, whofrom, username AS whoto, date, message, subject, inbox, outbox, readstate FROM `#__jim`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			// convert the usernames saved in the PMS messages to user IDs
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whofrom."'";
			$database->setQuery($sql);
			$fromid=$database->loadResult();
		
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whoto."'";
			$database->setQuery($sql);
			$toid=$database->loadResult();
		
			// jim stores date and time in one field
			$totaldate=$thepms->date;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);

			$toread=$thepms->readstate;
		
			$totrash=0;
			if (!$thepms->inbox)
				$totrash=1;

			$totrashoutbox=0;
			if (!$thepms->outbox)
				$totrashoutbox=1;

			$totrashdate="NULL";
			if ($totrash)
				$totrashdate=uddetime($config->timezone);
			$totrashdateoutbox="NULL";
			if ($totrashoutbox)
				$totrashdateoutbox=uddetime($config->timezone);

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrash, totrashdate, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$totrash.", ".$totrashdate.", ".(int)$totrashoutbox.", ".$totrashdateoutbox.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==12) {   // import myPMS Enhanced 1.x

		$sql="SELECT id, whofrom, username AS whoto, date, time, message, subject, readstate, inbox, sent_items FROM `#__pms`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			// convert the usernames saved in the PMS messages to user IDs
			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whofrom."'";
			$database->setQuery($sql);
			$fromid=$database->loadResult();

			$sql="SELECT id FROM `#__users` WHERE `username`='".$thepms->whoto."'";
			$database->setQuery($sql);
			$toid=$database->loadResult();

			// merge the PMS fields date and time into one single unix timestamp
			$totaldate=$thepms->date." ".$thepms->time;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->message;
			else
				$pmessage=$thepms->message;

			$pmessage = uddeIMfixImport($pmessage);
	
			$toread=$thepms->readstate;

			$totrash=0;
			$totrashoutbox=0;
			if ($thepms->inbox<0)
				$totrash=1;
			if ($thepms->sent_items<0)
				$totrashoutbox=1;

			$totrashdate="NULL";
			if ($totrash) {
				$totrashdate=uddetime($config->timezone);
			}
			$totrashdateoutbox="NULL";
			if ($totrashoutbox) {
				$totrashdateoutbox=uddetime($config->timezone);
			}

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrash, totrashdate, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$totrash.", ".$totrashdate.", ".(int)$totrashoutbox.", ".$totrashdateoutbox.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==13) {    // import JomSocial 1.x

		$sql = "SELECT m.posted_on AS thedatetime, m.subject, m.body, r.msg_from AS fromid, r.to AS toid, "
				."r.is_read AS readstate, r.deleted AS deletestate, m.deleted AS deletestateoutbox "
				."FROM `#__community_msg` AS m JOIN `#__community_msg_recepient` AS r "
				."WHERE m.id=r.msg_id".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			$fromid = $thepms->fromid;
			$toid   = $thepms->toid;

			// convert into unix timestamp
			$totaldate = $thepms->thedatetime;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->body;
			else
				$pmessage=$thepms->body;

			$pmessage = uddeIMfixImport($pmessage);
	
			$toread = $thepms->readstate;

			$totrash=0;
			$totrashoutbox=0;
			if ($thepms->deletestate==1)
				$totrash=1;
			if ($thepms->deletestateoutbox==1)
				$totrashoutbox=1;

			$totrashdate="NULL";
			if ($totrash)
				$totrashdate=uddetime($config->timezone);

			$totrashdateoutbox="NULL";
			if ($totrashoutbox)
				$totrashdateoutbox=uddetime($config->timezone);

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrash, totrashdate, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$totrash.", ".$totrashdate.", ".(int)$totrashoutbox.", ".$totrashdateoutbox.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==14) {   // import Messaging 1.x

		$sql = "SELECT date AS thedatetime, subject, message AS body, idFrom AS fromid, idTo AS toid, "
				."seen AS readstate FROM `#__messaging`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			$fromid = $thepms->fromid;
			$toid   = $thepms->toid;

			// convert into unix timestamp
			$totaldate = $thepms->thedatetime;
			$unixdate=strtotime($totaldate);
		
			if ($thepms->subject)
				$pmessage="[b]".$thepms->subject."[/b]\n\n".$thepms->body;
			else
				$pmessage=$thepms->body;

			$pmessage = uddeIMfixImport($pmessage);
	
			$toread = $thepms->readstate;

			$totrash=0;
			$totrashoutbox=0;
			$totrashdate="NULL";
			$totrashdateoutbox="NULL";

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrash, totrashdate, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$totrash.", ".$totrashdate.", ".(int)$totrashoutbox.", ".$totrashdateoutbox.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}

	} elseif ($mypmstype==15) {    // import CD Pure Messenger 1.x

		$sql = "SELECT from_created AS thedatetime, message AS body, from_id AS fromid, to_id AS toid, "
				."to_read AS readstate, from_deleted, to_deleted FROM `#__cdpuremessenger`".$limit;
		$database->setQuery($sql);
		$allpms=$database->loadObjectList();
		foreach($allpms as $thepms) {
			$fromid = $thepms->fromid;
			$toid   = $thepms->toid;

			// convert into unix timestamp
			$totaldate = $thepms->thedatetime;
			$unixdate=strtotime($totaldate);
		
			$pmessage=$thepms->body;
			$pmessage = uddeIMfixImport($pmessage);
	
			$toread = $thepms->readstate;

			$totrash=0;
			$totrashoutbox=0;
			if ($thepms->to_deleted==1)
				$totrash=1;
			if ($thepms->from_deleted==1)
				$totrashoutbox=1;

			$totrashdate="NULL";
			if ($totrash)
				$totrashdate=uddetime($config->timezone);

			$totrashdateoutbox="NULL";
			if ($totrashoutbox)
				$totrashdateoutbox=uddetime($config->timezone);

			if($fromid && $toid && $pmessage) {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, toread, totrash, totrashdate, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$pmessage."', ".$unixdate.", ".(int)$toread.", ".(int)$totrash.", ".$totrashdate.", ".(int)$totrashoutbox.", ".$totrashdateoutbox.")";
				$database->setQuery( $sql );
				$database->execute();
			}
		}
	}

/*********************************************************************************/
// now set the config_pmsimportdone variable in the config file to true
	$config->pmsimportdone=1;
	uddeIMsaveConfig($pathtoadmin, $config);

	echo "<p>&nbsp;</p><p><span style='color: red;'>";
	if ($count>0) {
		echo _UDDEADM_PARTIALIMPORTDONE;
	} else {
		echo _UDDEADM_IMPORTDONE;
	}
	echo "</span></p><p>&nbsp;</p>";
	echo "<p><a href=".uddeIMredirectIndex()."?option=com_uddeim>"._UDDEADM_CONTINUE."</a></p>";
}

function uddeIMshowSettings($option, $task, $usedlanguage, $pathtoadmin, $pathtouser, $uddeimversion, $config) {
	global $oldsetting_longwaitingemail,$configversion,$versionstring;

	$database = uddeIMgetDatabase();

	// Check for Attachment plugin
	$plugin_attachment = 0;
	if (uddeIMcheckVersionPlugin('attachment'))
		$plugin_attachment = 1;

	// Check for RSS plugin
	$plugin_rss = 0;
	if (uddeIMcheckVersionPlugin('rss'))
		$plugin_rss = 1;

	// Check for Public Frontend plugin
	$plugin_public = 0;
	if (uddeIMcheckVersionPlugin('pfrontend'))
		$plugin_public = 1;

	// Check for Spamcontrol plugin
	$plugin_spamcontrol = 0;
	if (uddeIMcheckVersionPlugin('spamcontrol'))
		$plugin_spamcontrol = 1;

	// Check for Message Center plugin
	$plugin_mcp = 0;
	if (uddeIMcheckVersionPlugin('mcp'))
		$plugin_mcp = 1;

	// Check for Postbox plugin
	$plugin_postbox = 0;
	if (uddeIMcheckVersionPlugin('postbox'))
		$plugin_postbox = 1;

	$is_cbe2 = uddeIMcheckCBE2();
	$is_cbe  = uddeIMcheckCBE();
	$is_aup  = uddeIMcheckAUP();
    $is_cb   = uddeIMcheckCB();
    $is_fb   = uddeIMcheckFB();
    $is_ag   = uddeIMcheckAG();
	$is_ku	 = uddeIMcheckKU();
	$is_nb	 = uddeIMcheckNB();
	$is_js	 = uddeIMcheckJS();
	$is_cm	 = uddeIMcheckCM();


	if(!$config->emn_body_nomessage)
		$config->emn_body_nomessage=_UDDEIM_EMN_BODY_NOMESSAGE;
	
	if(!$config->emn_body_withmessage)
		$config->emn_body_withmessage=_UDDEIM_EMN_BODY_WITHMESSAGE;
	
	if(!$config->emn_forgetmenot)
		$config->emn_forgetmenot=_UDDEIM_EMN_FORGETMENOT;
	
	if(!$config->export_format)
		$config->export_format=_UDDEIM_EXPORT_FORMAT;
	
	$oldsetting_allowarchive = $config->allowarchive;
	$oldsetting_longwaitingemail = $config->longwaitingemail;

?>

  <form action="<?php echo uddeIMredirectIndex(); ?>" method="POST" name="adminForm" id="adminForm">
  <input type="hidden" name="oldsetting_allowarchive" value="<?php echo $oldsetting_allowarchive; ?>" />
  <input type="hidden" name="oldsetting_longwaitingemail" value="<?php echo $oldsetting_longwaitingemail; ?>" />
  <input type="hidden" name="config_quotedivider" value="<?php echo $config->quotedivider; ?>" />
  <input type="hidden" name="config_forgetmenotstart" value="<?php echo $config->forgetmenotstart; ?>" />

  <div align="center">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
  <tr>
    <td class="sectionname" align="left">
      <h3><?php echo _UDDEADM_SETTINGS; ?></h3>
    </td>
    <td align="left" width="50%">
    <?php
        if (!$config->emailtrafficenabled) {
		echo "<span class='alert bg-warning' style='color: red; padding: 3px 8px'>"._UDDEADM_EMAILSTOPPED."</span>";
		}
    ?>
    </td>
    <td align="right" width="10%">
            <img align="middle" style="display: inline; border:1px solid lightgray;" src="<?php echo uddeIMgetPath('live_site')."/components/com_uddeim/templates/images/uddeim_logo.png"; ?>" width="150" height="75" />
    </td></tr>
    <tr>
    <td width="100%" colspan="3">
            <?php
		// when the ftp layer is enabled it does not make any sense to ask if the file is writeable since this cannot be checked
		$configdatei = "/administrator/components/com_uddeim/config.class.php";

		if (!uddeIMisFtpLayer()) {
			if (!uddeIMisWritable($configdatei)) {
				echo "<p><b><span style='color: red;'>"._UDDEADM_CONFIGNOTWRITEABLE." $configdatei</span></b></p>";
			} else {
				echo "<p><b><span style='color: green;'>"._UDDEADM_CONFIGWRITEABLE." $configdatei</span></b>&ensp;-&ensp;";
                                echo "<span style='color:red;'><i>".(isset($_GET['ocr']) ? ($_GET['ocr'] ? '<b>OPCache reset</b>' : _UDDEADM_CONFIGNOTE) : '')."</i></span></p>";

			}
		} else {
			echo "<p><b><span style='color: blue;'>"._UDDEADM_CONFIG_FTPLAYER." $configdatei</span></b></p>";
		}

		$ret = uddeIMcheckForValidDB($option, $task, $uddeimversion, $config);
		if (!$ret)
			echo "<p><b><span style='color: red;'>"._UDDEADM_UPDATEYOURDB."</span></b></p>";

	?>
    </td></tr>
    <tr>
    <td>
    <?php
			$plugin_error = 0;
			if (uddeIMcheckPlugin('poxtbox'))
				if (!uddeIMcheckVersionPlugin('postbox'))
					$plugin_error = 1;
			if (uddeIMcheckPlugin('mcp'))
				if (!uddeIMcheckVersionPlugin('mcp'))
					$plugin_error = 1;
			if (uddeIMcheckPlugin('spamcontrol'))
				if (!uddeIMcheckVersionPlugin('spamcontrol'))
					$plugin_error = 1;
			if (uddeIMcheckPlugin('rss'))
				if (!uddeIMcheckVersionPlugin('rss'))
					$plugin_error = 1;
			if (uddeIMcheckPlugin('pfrontend'))
				if (!uddeIMcheckVersionPlugin('pfrontend'))
					$plugin_error = 1;
			if (uddeIMcheckPlugin('attachment'))
				if (!uddeIMcheckVersionPlugin('attachment'))
					$plugin_error = 1;

			if ($plugin_error) {
                echo "<span style='padding: 12px'>"._UDDEADM_VERSIONCHECK_INFO."</span>";
                echo "</td><td>";
                if (!uddeIMcheckVersionPlugin('postbox'))
					echo "<span style='color: red; padding: 3px'>"._UDDEADM_OOD_PB."</span><br />";
				if (!uddeIMcheckVersionPlugin('mcp'))
					echo "<span style='color: red; padding: 3px'>"._UDDEADM_OOD_MCP."</span><br />";
				if (!uddeIMcheckVersionPlugin('spamcontrol'))
					echo "<span style='color: red; padding: 3px'>"._UDDEADM_OOD_ASC."</span><br />";
				if (!uddeIMcheckVersionPlugin('rss'))
					echo "<span style='color: red; padding: 3px'>"._UDDEADM_OOD_RSS."</span><br />";
				if (!uddeIMcheckVersionPlugin('pfrontend'))
					echo "<span style='color: red; padding: 3px'>"._UDDEADM_OOD_PF."</span><br />";
				if (!uddeIMcheckVersionPlugin('attachment'))
					echo "<span style='color: red; padding: 3px'>"._UDDEADM_OOD_A."</span><br />";
            }
        ?>
	</td></tr>
    <tr>
    <td colspan="3">
        <?php
            if ( $plugin_spamcontrol || $plugin_mcp )
				echo "<span style='padding: 12px'>"._UDDEADM_INFORMATION."</span>";

			if ($plugin_mcp) {
				$sql  = "SELECT count(id) FROM `#__uddeim` WHERE `delayed`!=0";
				$database->setQuery($sql);
				$temp = (int)$database->loadResult();
				echo "<a class='btn btn".($temp ? '-' : '-outline-')."info' href='".uddeIMredirectIndex()."?option=com_uddeim&task=mcp'>"._UDDEADM_MCP_STAT."&ensp;<b class='badge bg-danger'>&ensp;".$temp."&ensp;</b></a> ";
			}

			if ($plugin_spamcontrol) {
				$sql  = "SELECT count(a.id) FROM `#__uddeim_spam` AS a LEFT JOIN `#__uddeim` AS b ON a.mid = b.id";
				$database->setQuery($sql);
				$temp = (int)$database->loadResult();
				echo "<a class='btn btn".($temp ? '-' : '-outline-')."danger' style='margin:8px 0' href='".uddeIMredirectIndex()."?option=com_uddeim&task=spamcontrol'>"._UDDEADM_SPAMCONTROL_STAT."&ensp;<b class='badge bg-info'>&ensp;".$temp."&ensp;</b></a>";
			}
        ?>
    </td></tr>
    </table>
  </div><br />

<?php	
	$adminstyle = ' style="border-top:1px solid lightgray; padding-top:1em"';

	if (uddeIMcheckJversion()>=15) {	// not J5 - was Joomla 3.0, bug (not) fixed in Joomla 3.1
		echo '<ul class="nav nav-tabs" id="submenu">';
		echo ' <li class="active"><a data-toggle="tab" href="#home">'._UDDEADM_MESSAGES.'</a></li>';
		echo ' <li><a data-toggle="tab" href="#display-tab">'._UDDEADM_DISPLAY.'</a></li>';
		echo ' <li><a data-toggle="tab" href="#delete-tab">'._UDDEADM_DELETIONS.'</a></li>';
		echo ' <li><a data-toggle="tab" href="#integration-tab">'._UDDEADM_INTEGRATION.'</a></li>';
		echo ' <li><a data-toggle="tab" href="#email-tab">'._UDDEADM_EMAIL.'</a></li>';
		echo ' <li><a data-toggle="tab" href="#block-tab">'._UDDEADM_BLOCK.'</a></li>';
		echo ' <li><a data-toggle="tab" href="#archive-tab">'._UDDEADM_ARCHIVE.'</a></li>';
		echo ' <li><a data-toggle="tab" href="#date-tab">'._UDDEADM_DATESETTINGS.'</a></li>';
		if ($plugin_public)
			echo ' <li><a data-toggle="tab" href="#public-tab">'._UDDEADM_PUBLIC.'</a></li>';
		echo ' <li><a data-toggle="tab" href="#system-tab">'._UDDEADM_SYSTEM.'</a></li>';
		if ($config->pmsimportdone<=1)
			echo ' <li><a data-toggle="tab" href="#import-tab">'._UDDEADM_IMPORT.'</a></li>';
		echo ' <li><a data-toggle="tab" href="#maintenance-tab">'._UDDEADM_MAINTENANCE.'</a></li>';
		echo ' <li><a data-toggle="tab" href="#about-tab">'._UDDEADM_ABOUT.'</a></li>';
		echo '</ul>';
	}

	// ==================MESSAGES======================================================================================

	$tabs = new mosTabs( 1 );
	$tabs->startPane( "uddeim" );
	$tabs->startTab(_UDDEADM_MESSAGES,"home");

?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">
			<?php uddeIMadmText($config->maxlength, 4, 'config_maxlength', false, _UDDEADM_MAXLENGTH_HEAD, _UDDEADM_MAXLENGTH_EXP, _UDDEIM_CHARS); ?>
			<?php uddeIMadmYesNo($config->replytext, 'config_replytext', false, _UDDEADM_REPLYTEXT_HEAD, _UDDEADM_REPLYTEXT_EXP); ?>
			<?php uddeIMadmYesNo($config->replytruncate, 'config_replytruncate', !$config->maxlength, _UDDEADM_TRUNCATE_HEAD, _UDDEADM_TRUNCATE_EXP); ?>
			<?php uddeIMadmYesNo($config->showtextcounter, 'config_showtextcounter', !$config->maxlength, _UDDEADM_SHOWTEXTCOUNTER_HEAD, _UDDEADM_SHOWTEXTCOUNTER_EXP); ?>
			<?php uddeIMadmSelect($config->allowbb, 'config_allowbb', Array('2'=>_UDDEADM_YES, '1'=>_UDDEADM_FONTFORMATONLY, '0'=>_UDDEADM_NO), false, _UDDEADM_ALLOWBB_HEAD, _UDDEADM_ALLOWBB_EXP); ?>
			<?php uddeIMadmSelect($config->realnames, 'config_realnames', Array('1'=>_UDDEADM_REALNAMES, '0'=>_UDDEADM_USERNAMES), false, _UDDEADM_NAMESTEXT, _UDDEADM_NAMESDESC); ?>
			<?php uddeIMadmYesNo($config->allowsmile, 'config_allowsmile', false, _UDDEADM_ALLOWSMILE_HEAD, _UDDEADM_ALLOWSMILE_EXP, $adminstyle); ?>
			<?php uddeIMadmYesNo($config->animated, 'config_animated', !$config->allowsmile, _UDDEADM_ANIMATED_HEAD, _UDDEADM_ANIMATED_EXP); ?>
			<?php uddeIMadmYesNo($config->animatedex, 'config_animatedex', !$config->allowsmile || !$config->animated, _UDDEADM_ANIMATEDEX_HEAD, _UDDEADM_ANIMATEDEX_EXP); ?>

			<?php uddeIMadmYesNo($config->trashoriginal, 'config_trashoriginal', false, _UDDEADM_TRASHORIGINAL_HEAD, _UDDEADM_TRASHORIGINAL_EXP, $adminstyle); ?>
			<?php uddeIMadmYesNo($config->trashoriginalsent, 'config_trashoriginalsent', false, _UDDEADM_TRASHORIGINALSENT_HEAD, _UDDEADM_TRASHORIGINALSENT_EXP); ?>
			<?php uddeIMadmYesNo($config->allowcopytome, 'config_allowcopytome', false, _UDDEADM_COPYTOME_HEAD, _UDDEADM_COPYTOME_EXP); ?>
			<?php uddeIMadmYesNo($config->allowforwards, 'config_allowforwards', false, _UDDEADM_ALLOWFORWARDS_HEAD, _UDDEADM_ALLOWFORWARDS_EXP); ?>
			<?php uddeIMadmYesNo($config->reportspam, 'config_reportspam', !$plugin_spamcontrol, _UDDEADM_REPORTSPAM_HEAD, _UDDEADM_REPORTSPAM_EXP.uddeIMnoPremium(!$plugin_spamcontrol)); ?>
			<?php uddeIMadmText($config->badwords, 40, 'config_badwords', false, _UDDEADM_BADWORDS_HEAD, _UDDEADM_BADWORDS_EXP); ?>

			<?php uddeIMadmYesNo($config->allowmultiplerecipients, 'config_allowmultiplerecipients', false, _UDDEADM_ALLOWMULTIPLERECIPIENTS_HEAD, _UDDEADM_ALLOWMULTIPLERECIPIENTS_EXP, $adminstyle); ?>
			<?php uddeIMadmText($config->maxrecipients, 4, 'config_maxrecipients', !$config->allowmultiplerecipients, _UDDEADM_MAXRECIPIENTS_HEAD, _UDDEADM_MAXRECIPIENTS_EXP); ?>
			<?php uddeIMadmYesNo($config->addccline, 'config_addccline', false, _UDDEADM_CC_HEAD, _UDDEADM_CC_EXP); ?>
			<?php uddeIMadmYesNo($config->allowmultipleuser, 'config_allowmultipleuser', !$config->allowmultiplerecipients, _UDDEADM_ALLOWMULTIPLEUSER_HEAD, _UDDEADM_ALLOWMULTIPLEUSER_EXP); ?>
			<?php uddeIMadmYesNo($config->connexallowmultipleuser, 'config_connexallowmultipleuser', (!$is_cb && !$is_cbe2) || !$config->allowmultiplerecipients, _UDDEADM_CBALLOWMULTIPLEUSER_HEAD, _UDDEADM_CBALLOWMULTIPLEUSER_EXP); ?>
			<?php uddeIMadmSelect($config->separator, 'config_separator', Array('1'=>_UDDEADM_SEPARATOR_P1, '0'=>_UDDEADM_SEPARATOR_P0), false, _UDDEADM_SEPARATOR_HEAD, _UDDEADM_SEPARATOR_EXP); ?>

			<?php uddeIMadmSelect($config->enablelists, 'config_enablelists', Array('3'=>_UDDEADM_ENABLELISTS_3, '2'=>_UDDEADM_ENABLELISTS_2, '1'=>_UDDEADM_ENABLELISTS_1, '0'=>_UDDEADM_ENABLELISTS_0), !$config->allowmultiplerecipients, _UDDEADM_ENABLELISTS_HEAD, _UDDEADM_ENABLELISTS_EXP, $adminstyle); ?>
			<?php uddeIMadmText($config->maxonlists, 4, 'config_maxonlists', !$config->enablelists || !$config->allowmultiplerecipients, _UDDEADM_MAXONLISTS_HEAD, _UDDEADM_MAXONLISTS_EXP); ?>
			<?php uddeIMadmSelect($config->restrictcon, 'config_restrictcon', Array('3'=>_UDDEADM_RESTRICTCON3, '2'=>_UDDEADM_RESTRICTCON2, '1'=>_UDDEADM_RESTRICTCON1, '0'=>_UDDEADM_RESTRICTCON0), (!$is_js && !$is_cb && !$is_cbe), _UDDEADM_RESTRICTCON_HEAD, _UDDEADM_RESTRICTCON_EXP); ?>
			<?php uddeIMadmYesNo($config->restrictrem, 'config_restrictrem', !$config->restrictcon, _UDDEADM_RESTRICTREM_HEAD, _UDDEADM_RESTRICTREM_EXP); ?>
		
		        <?php uddeIMadmSelect($config->cryptmode, 'config_cryptmode', Array('4'=>_UDDEADM_CRYPT4, '3'=>_UDDEADM_CRYPT3, '2'=>_UDDEADM_CRYPT2, '1'=>_UDDEADM_CRYPT1, '0'=>_UDDEADM_CRYPT0), false, _UDDEADM_USEENCRYPTION, _UDDEADM_USEENCRYPTIONDESC, $adminstyle); ?>
			<?php uddeIMadmText($config->cryptkey, 30, 'config_cryptkey', $config->cryptmode==0, _UDDEADM_OBFUSCATING_HEAD, _UDDEADM_OBFUSCATING_EXP); // BUGBUG: also cryptmode==3 ?>
		</table>
<?php
	$tabs->endTab(_UDDEADM_MESSAGES,"home");			


	// ==============DISPLAY===========================================================================================


	$tabs->startTab(_UDDEADM_DISPLAY,"display-tab");
?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">
			<?php uddeIMadmText($config->showtitle, 30, 'config_showtitle', false, _UDDEADM_SHOWTITLE_HEAD, _UDDEADM_SHOWTITLE_EXP); ?>
			<?php
				$tdirs = Array();
				$dir = $pathtouser."/templates";
				if ($hd = opendir($dir)) {
					while ($sz = readdir($hd)) { 
						if (!preg_match("/\./",$sz) && !preg_match("/images/",$sz))
							$tdirs[] = $sz;
					}
					closedir($hd);
				}
				asort($tdirs);
				$remodir = Array();
				foreach($tdirs as $tdir) {
					$lastdiradded=$tdir;
					$remodir[ $tdir ] = $tdir;
				}
				uddeIMadmSelect($config->templatedir, 'config_templatedir', $remodir, false, _UDDEADM_TEMPLATEDIR_HEAD, _UDDEADM_TEMPLATEDIR_EXP);
			?>

			<?php uddeIMadmSelect($config->showmenuicons, 'config_showmenuicons', Array('1'=>_UDDEIM_MENUICONS_P1, '2'=>_UDDEIM_MENUICONS_P2, '3'=>_UDDEIM_MENUICONS_P3, '0'=>_UDDEIM_MENUICONS_P0), false, _UDDEADM_SHOWMENUICONS1_HEAD, _UDDEADM_SHOWMENUICONS1_EXP, $adminstyle); ?>
			<?php uddeIMadmYesNo($config->showmenucount, 'config_showmenucount', false, _UDDEADM_SHOWMENUCOUNT_HEAD, _UDDEADM_SHOWMENUCOUNT_EXP); ?>
			<?php uddeIMadmSelect($config->showsettingslink, 'config_showsettingslink', Array('2'=>_UDDEADM_SHOWSETTINGS_ATBOTTOM, '1'=>_UDDEADM_YES, '0'=>_UDDEADM_NO), false, _UDDEADM_SHOWSETTINGSLINK_HEAD, _UDDEADM_SHOWSETTINGSLINK_EXP); ?>

			<?php uddeIMadmYesNo($config->actionicons, 'config_actionicons', false, _UDDEADM_SHOWACTIONICONS_HEAD, _UDDEADM_SHOWACTIONICONS_EXP, $adminstyle); ?>
			<?php uddeIMadmYesNo($config->bottomlineicons, 'config_bottomlineicons', false, _UDDEADM_SHOWBOTTOMICONS_HEAD, _UDDEADM_SHOWBOTTOMICONS_EXP); ?>
			<?php uddeIMadmYesNo($config->showabout, 'config_showabout', false, _UDDEADM_SHOWABOUT_HEAD, _UDDEADM_SHOWABOUT_EXP); ?>
			<?php uddeIMadmYesNo($config->showhelp, 'config_showhelp', false, _UDDEADM_SHOWHELP_HEAD, _UDDEADM_SHOWHELP_EXP); ?>

			<?php uddeIMadmYesNo($config->allowflagged, 'config_allowflagged', false, _UDDEADM_ALLOWFLAGGED_HEAD, _UDDEADM_ALLOWFLAGGED_EXP, $adminstyle); ?>
			<?php uddeIMadmYesNo($config->enablereply, 'config_enablereply', false, _UDDEADM_PMNAV_HEAD, _UDDEADM_PMNAV_EXP); ?>

			<?php uddeIMadmSelect($config->enablefilter, 'config_enablefilter', Array('0'=>_UDDEADM_FILTER_P0, '1'=>_UDDEADM_FILTER_P1, '2'=>_UDDEADM_FILTER_P2, '3'=>_UDDEADM_FILTER_P3), false, _UDDEADM_FILTER_HEAD, _UDDEADM_FILTER_EXP, $adminstyle); ?>
			<?php uddeIMadmYesNo($config->enablesort, 'config_enablesort', false, _UDDEADM_ENABLESORT_HEAD, _UDDEADM_ENABLESORT_EXP); ?>

			<?php uddeIMadmText($config->perpage, 4, 'config_perpage', false, _UDDEADM_PERPAGE_HEAD, _UDDEADM_PERPAGE_EXP, "", $adminstyle); ?>
			<?php uddeIMadmText($config->firstwordsinbox, 4, 'config_firstwordsinbox', false, _UDDEADM_FIRSTWORDSINBOX_HEAD, _UDDEADM_FIRSTWORDSINBOX_EXP); ?>
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_COLSROWS_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<input type="text" name="config_cols" class="form-control" size="3" value="<?php echo uddeIMquotecode($config->cols); ?>" /> /
					<input type="text" name="config_rows" class="form-control" size="3" value="<?php echo uddeIMquotecode($config->rows); ?>" />
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_COLSROWS_EXP; ?>
				</td>
			</tr>
			<?php uddeIMadmText($config->width, 4, 'config_width', false, _UDDEADM_WIDTH_HEAD, _UDDEADM_WIDTH_EXP,'px'); ?>

			<?php uddeIMadmSelect($config->modeshowallusers, 'config_modeshowallusers', Array('2'=>_UDDEADM_MODESHOWALLUSERS_2, '1'=>_UDDEADM_MODESHOWALLUSERS_1, '0'=>_UDDEADM_MODESHOWALLUSERS_0), false, _UDDEADM_MODESHOWALLUSERS_HEAD, _UDDEADM_MODESHOWALLUSERS_EXP, $adminstyle); ?>
			<?php uddeIMadmSelect($config->restrictallusers, 'config_restrictallusers', Array('0'=>_UDDEADM_RESTRALLUSERS_0, '1'=>_UDDEADM_RESTRALLUSERS_1, '2'=>_UDDEADM_RESTRALLUSERS_2), false, _UDDEADM_RESTRALLUSERS_HEAD, _UDDEADM_RESTRALLUSERS_EXP); ?>
			<?php uddeIMadmSelect($config->hideallusers, 'config_hideallusers', Array('3'=>_UDDEADM_HIDEALLUSERS_3, '2'=>_UDDEADM_HIDEALLUSERS_2, '1'=>_UDDEADM_HIDEALLUSERS_1, '0'=>_UDDEADM_HIDEALLUSERS_0), false, _UDDEADM_HIDEALLUSERS_HEAD, _UDDEADM_HIDEALLUSERS_EXP); ?>
			<?php uddeIMadmText($config->hideusers, 20, 'config_hideusers', false, _UDDEADM_HIDEUSERS_HEAD, _UDDEADM_HIDEUSERS_EXP); ?>
			
			<?php uddeIMadmYesNo($config->useautocomplete, 'config_useautocomplete', false, _UDDEADM_USEAUTOCOMPLETE_HEAD, _UDDEADM_USEAUTOCOMPLETE_EXP, $adminstyle); ?>
			<?php uddeIMadmYesNo($config->searchinstring, 'config_searchinstring', !$config->useautocomplete, _UDDEADM_SEARCHINSTRING_HEAD, _UDDEADM_SEARCHINSTRING_EXP); ?>
		</table>
<?php
	$tabs->endTab(_UDDEADM_DISPLAY,"display-tab");


	// ====================DELETIONS MESSAGES======================================================================


	$tabs->startTab(_UDDEADM_DELETIONS,"delete-tab");
?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">
			<?php uddeIMadmYesNo($config->ReadMessagesLifespanNote, 'config_ReadMessagesLifespanNote', false, _UDDEADM_DELETEREADAFTERNOTE_HEAD, _UDDEADM_DELETEREADAFTERNOTE_EXP); ?>
			<?php uddeIMadmText($config->ReadMessagesLifespan, 4, 'config_ReadMessagesLifespan', false, _UDDEADM_DELETEREADAFTER_HEAD, _UDDEADM_DELETEREADAFTER_EXP, _UDDEADM_DAYS); ?>

			<?php uddeIMadmYesNo($config->UnreadMessagesLifespanNote, 'config_UnreadMessagesLifespanNote', false, _UDDEADM_DELETEUNREADAFTERNOTE_HEAD, _UDDEADM_DELETEUNREADAFTERNOTE_EXP, $adminstyle); ?>
			<?php uddeIMadmText($config->UnreadMessagesLifespan, 4, 'config_UnreadMessagesLifespan', false, _UDDEADM_DELETEUNREADAFTER_HEAD, _UDDEADM_DELETEUNREADAFTER_EXP, _UDDEADM_DAYS); ?>

			<?php uddeIMadmYesNo($config->SentMessagesLifespanNote, 'config_SentMessagesLifespanNote', false, _UDDEADM_DELETESENTAFTERNOTE_HEAD, _UDDEADM_DELETESENTAFTERNOTE_EXP, $adminstyle); ?>
			<?php uddeIMadmText($config->SentMessagesLifespan, 4, 'config_SentMessagesLifespan', false, _UDDEADM_DELETESENTAFTER_HEAD, _UDDEADM_DELETESENTAFTER_EXP, _UDDEADM_DAYS); ?>

			<?php uddeIMadmYesNo($config->TrashLifespanNote, 'config_TrashLifespanNote', false, _UDDEADM_DELETETRASHAFTERNOTE_HEAD, _UDDEADM_DELETETRASHAFTERNOTE_EXP, $adminstyle); ?>
			<?php uddeIMadmText($config->TrashLifespan, 4, 'config_TrashLifespan', false, _UDDEADM_DELETETRASHAFTER_HEAD, _UDDEADM_DELETETRASHAFTER_EXP, _UDDEADM_DAYS); ?>
			<?php uddeIMadmSelect($config->trashrestriction, 'config_trashrestriction', Array('0'=>_UDDEADM_NOTRASHACCESS_0, '1'=>_UDDEADM_NOTRASHACCESS_1, '2'=>_UDDEADM_NOTRASHACCESS_2), false, _UDDEADM_NOTRASHACCESS_HEAD, _UDDEADM_NOTRASHACCESS_EXP); ?>
		</table>
<?php
	$tabs->endTab(_UDDEADM_DELETIONS,"delete-tab");			


	// ====================INTEGRATION================================================================================


	$tabs->startTab(_UDDEADM_INTEGRATION,"integration-tab");
?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">	
			<?php uddeIMadmYesNo($config->showonline, 'config_showonline', false, _UDDEADM_SHOWONLINE_HEAD, _UDDEADM_SHOWONLINE_EXP); ?>
			<?php uddeIMadmYesNo($config->allowpopup, 'config_allowpopup', false, _UDDEADM_POPUP_HEAD, _UDDEADM_POPUP_EXP); ?>
			<?php uddeIMadmYesNo($config->popupdefault, 'config_popupdefault', false, _UDDEADM_POPUPDEFAULT_HEAD, _UDDEADM_POPUPDEFAULT_EXP); ?>

			<tr align="center" valign="middle">
				<td align="left" valign="top"<?php echo $adminstyle; ?>>
					<strong><?php echo _UDDEADM_SHOWLINK_HEAD; ?></strong>
				</td>
				<td align="left" valign="top"<?php echo $adminstyle; ?>>
					<?php
					if ($is_cb)		$cbl[] = mosHTML::makeOption( '13', _UDDEADM_CB2 );
					if ($is_ku)		$cbl[] = mosHTML::makeOption( '16', _UDDEADM_KUNENA6 );
				  //if ($is_ku)		$cbl[] = mosHTML::makeOption( '15', _UDDEADM_KUNENA5 );
                  //if ($is_ku)		$cbl[] = mosHTML::makeOption( '5', _UDDEADM_KUNENA );
					if ($is_cm)		$cbl[] = mosHTML::makeOption( '8', _UDDEADM_JOOCM );
					if ($is_aup)	$cbl[] = mosHTML::makeOption( '7', _UDDEADM_AUP );
					if ($is_js)		$cbl[] = mosHTML::makeOption( '6', _UDDEADM_JOMSOCIAL );
					if ($is_cbe2)	$cbl[] = mosHTML::makeOption( '4', _UDDEADM_CBE );
					if ($is_ag)		$cbl[] = mosHTML::makeOption( '3', _UDDEADM_AGORA );
					$cbl[] = mosHTML::makeOption( '0', _UDDEADM_DISABLED );
					$list_cbl = mosHTML::selectList( $cbl, 'config_showcblink', 'class="form-select" size="1"', 'value', 'text', $config->showcblink );
					echo $list_cbl;
					?>
				</td>
				<td align="left" valign="top" width="40%"<?php echo $adminstyle; ?>>
					<?php echo _UDDEADM_SHOWLINK_EXP; ?>
				</td>
			</tr>		
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_SHOWMENULINK_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<?php
					if ($is_ku)		$sml[] = mosHTML::makeOption( '16', _UDDEADM_KUNENA6 );
                  //if ($is_ku)		$sml[] = mosHTML::makeOption( '15', _UDDEADM_KUNENA5 );
				  //if ($is_ku)		$sml[] = mosHTML::makeOption( '5', _UDDEADM_KUNENA );
					$sml[] = mosHTML::makeOption( '0', _UDDEADM_DISABLED );
					$list_sml = mosHTML::selectList( $sml, 'config_showmenulink', 'class="form-select" size="1"', 'value', 'text', $config->showmenulink );
					echo $list_sml;
					?>
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_SHOWMENULINK_EXP; ?>
				</td>
			</tr>		
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_SHOWPIC_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<?php
					if ($is_cb)		$cbp[] = mosHTML::makeOption( '13', _UDDEADM_CB2 );
					if ($is_ku)		$cbp[] = mosHTML::makeOption( '16', _UDDEADM_KUNENA6 );
				  //if ($is_ku)		$cbp[] = mosHTML::makeOption( '15', _UDDEADM_KUNENA5 );
                  //if ($is_ku)		$cbp[] = mosHTML::makeOption( '5', _UDDEADM_KUNENA );
					if ($is_cm)		$cbp[] = mosHTML::makeOption( '8', _UDDEADM_JOOCM );
					if ($is_aup)	$cbp[] = mosHTML::makeOption( '7', _UDDEADM_AUP );
					if ($is_js)		$cbp[] = mosHTML::makeOption( '6', _UDDEADM_JOMSOCIAL );
					if ($is_cbe2)	$cbp[] = mosHTML::makeOption( '4', _UDDEADM_CBE );
					if ($is_ag)		$cbp[] = mosHTML::makeOption( '3', _UDDEADM_AGORA );
					$cbp[] = mosHTML::makeOption( '0', _UDDEADM_DISABLED );
					$list_cbp = mosHTML::selectList( $cbp, 'config_showcbpic', 'class="form-select" size="1"', 'value', 'text', $config->showcbpic );
					echo $list_cbp;
					?>
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_SHOWPIC_EXP; ?>
				</td>
			</tr>
			<?php uddeIMadmYesNo($config->getpiclink, 'config_getpiclink', (!$is_cb && !$is_cbe2 && !$is_fb && !$is_ag && !$is_ku && !$is_cm && !$is_nb && !$is_js && !$is_aup), _UDDEADM_THUMBLISTS_HEAD, _UDDEADM_THUMBLISTS_EXP); ?>
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_AVATARWH_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<input type="text" name="config_avatarw" class="form-control" size="3" value="<?php echo uddeIMquotecode($config->avatarw); ?>" /> /
					<input type="text" name="config_avatarh" class="form-control" size="3" value="<?php echo uddeIMquotecode($config->avatarh); ?>" />
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_AVATARWH_EXP; ?>
				</td>
			</tr>
			<?php uddeIMadmYesNo($config->showconnex, 'config_showconnex', (!$is_js && !$is_cb && !$is_cbe2), _UDDEADM_SHOWCONNEX_HEAD, _UDDEADM_SHOWCONNEX_EXP); ?>
			<?php uddeIMadmSelect($config->connex_listbox, 'config_connex_listbox', Array('1'=>_UDDEADM_LISTBOX, '0'=>_UDDEADM_TABLE), false, _UDDEADM_CONLISTBOX, _UDDEADM_CONLISTBOXDESC); ?>

			<?php uddeIMadmYesNo($config->CBgallery, 'config_CBgallery', (!$is_cb && !$is_cbe2), _UDDEADM_CBGALLERY_HEAD, _UDDEADM_CBGALLERY_EXP, $adminstyle); ?>
			<?php uddeIMadmYesNo($config->checkbanned, 'config_checkbanned', (!$is_cb && !$is_cbe2), _UDDEADM_CBBANNED_HEAD, _UDDEADM_CBBANNED_EXP); ?>

			<?php uddeIMadmYesNo($config->gravatar, 'config_gravatar', (!$is_cb && !$is_cbe && !$is_cbe2 && !$is_fb && !$is_ag && !$is_ku && !$is_nb && !$is_cm), _UDDEADM_GRAVATAR_HEAD, _UDDEADM_GRAVATAR_EXP, $adminstyle); ?>
			<tr align="center" valign="middle">
				<td align="left" valign="top">
<?php				echo uddeIMprintCond((!$config->gravatar || $is_nb), _UDDEADM_GRAVATARD_HEAD, "gray", true); ?>
				</td>
				<td align="left" valign="top">
					<?php
					$grd[] = mosHTML::makeOption( '404', 		_UDDEADM_GR404 );
					$grd[] = mosHTML::makeOption( 'mm', 		_UDDEADM_GRMM );
					$grd[] = mosHTML::makeOption( 'identicon', 	_UDDEADM_GRIDENTICON );
					$grd[] = mosHTML::makeOption( 'monsterid', 	_UDDEADM_GRMONSTERID );
					$grd[] = mosHTML::makeOption( 'wavatar', 	_UDDEADM_GRWAVATAR );
					$grd[] = mosHTML::makeOption( 'retro', 		_UDDEADM_GRRETRO );
					$grd[] = mosHTML::makeOption( '',			_UDDEADM_GRDEFAULT );
					$list_grd = mosHTML::selectList( $grd, 'config_gravatard', 'class="form-select" size="1"', 'value', 'text', $config->gravatard );
					echo $list_grd;
					?>
				</td>
				<td align="left" valign="top" width="40%">
<?php				echo uddeIMprintCond((!$config->gravatar || $is_nb), _UDDEADM_GRAVATARD_EXP, "gray", false); ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top">
<?php				echo uddeIMprintCond((!$config->gravatar || $is_nb), _UDDEADM_GRAVATARR_HEAD, "gray", true); ?>
				</td>
				<td align="left" valign="top">
					<?php
					$grr[] = mosHTML::makeOption( 'g', 	_UDDEADM_GRG );
					$grr[] = mosHTML::makeOption( 'pg', _UDDEADM_GRPG );
					$grr[] = mosHTML::makeOption( 'r', 	_UDDEADM_GRR );
					$grr[] = mosHTML::makeOption( 'x', 	_UDDEADM_GRX );
					$list_grr = mosHTML::selectList( $grr, 'config_gravatarr', 'class="form-select" size="1"', 'value', 'text', $config->gravatarr );
					echo $list_grr;
					?>
				</td>
				<td align="left" valign="top" width="40%">
<?php				echo uddeIMprintCond((!$config->gravatar || $is_nb), _UDDEADM_GRAVATARR_EXP, "gray", false); ?>
				</td>
			</tr>
		</table>
<?php
	$tabs->endTab(_UDDEADM_INTEGRATION,"integration-tab");			


	// ======================EMAIL=====================================================================================


	$tabs->startTab(_UDDEADM_EMAIL,"email-tab");
?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">		
			<?php uddeIMadmSelect($config->allowemailnotify, 'config_allowemailnotify', Array('2'=>_UDDEADM_ADMINSONLY, '1'=>_UDDEADM_YES, '0'=>_UDDEADM_NO), false, _UDDEADM_ALLOWEMAILNOTIFY_HEAD, _UDDEADM_ALLOWEMAILNOTIFY_EXP); ?>
			<?php uddeIMadmSelect($config->notifydefault, 'config_notifydefault', Array('2'=>_UDDEADM_NOTIFYDEF_2, '1'=>_UDDEADM_NOTIFYDEF_1, '0'=>_UDDEADM_NOTIFYDEF_0), false, _UDDEADM_NOTIFYDEFAULT_HEAD, _UDDEADM_NOTIFYDEFAULT_EXP); ?>
			<?php uddeIMadmSelect($config->emailwithmessage, 'config_emailwithmessage', Array('2'=>_UDDEADM_ADDEMAIL_ADMIN, '1'=>_UDDEADM_YES, '0'=>_UDDEADM_NO), false, _UDDEADM_EMAILWITHMESSAGE_HEAD, _UDDEADM_EMAILWITHMESSAGE_EXP); ?>

			<?php uddeIMadmYesNo($config->longwaitingemail, 'config_longwaitingemail', false, _UDDEADM_LONGWAITINGEMAIL_HEAD, _UDDEADM_LONGWAITINGEMAIL_EXP, $adminstyle); ?>
			<?php uddeIMadmText($config->longwaitingdays, 4, 'config_longwaitingdays', !$config->longwaitingemail, _UDDEADM_LONGWAITINGDAYS_HEAD, _UDDEADM_LONGWAITINGDAYS_EXP, _UDDEADM_DAYS); ?>

			<?php uddeIMadmText($config->emn_sendername, 20, 'config_emn_sendername', false, _UDDEADM_EMN_SENDERNAME_HEAD, _UDDEADM_EMN_SENDERNAME_EXP, '', $adminstyle); ?>
			<?php
				$temp = _UDDEADM_EMN_SENDERMAIL_EXP;
				if ($config->mailsystem==1) {	// mosMail
					if (preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w+/", $config->emn_sendermail )==false) {
						$temp .= _UDDEADM_EMN_SENDERMAIL_WARNING;
					}
				}
				uddeIMadmText($config->emn_sendermail, 20, 'config_emn_sendermail', false, _UDDEADM_EMN_SENDERMAIL_HEAD, $temp);
			?>

			<?php uddeIMadmSelect($config->autoresponder, 'config_autoresponder', Array('2'=>_UDDEADM_ADMINSONLY, '1'=>_UDDEADM_YES, '0'=>_UDDEADM_NO), false, _UDDEADM_AUTORESPONDER_HEAD, _UDDEADM_AUTORESPONDER_EXP, $adminstyle); ?>
			<?php uddeIMadmSelect($config->autoforward, 'config_autoforward', Array('2'=>_UDDEADM_ADMINSONLY, '3'=>_UDDEADM_AUTOFORWARD_SPECIAL, '1'=>_UDDEADM_YES, '0'=>_UDDEADM_NO), false, _UDDEADM_AUTOFORWARD_HEAD, _UDDEADM_AUTOFORWARD_EXP); ?>

			<?php uddeIMadmYesNo($config->dontsefmsglink, 'config_dontsefmsglink', false, _UDDEADM_DONTSEFMSGLINK_HEAD, _UDDEADM_DONTSEFMSGLINK_EXP, $adminstyle); ?>

			<?php uddeIMadmSelect($config->emailtrafficenabled, 'config_emailtrafficenabled', Array('0'=>_UDDEADM_YES, '1'=>_UDDEADM_NO), false, _UDDEADM_STOPALLEMAIL_HEAD, _UDDEADM_STOPALLEMAIL_EXP, $adminstyle); ?>

		</table>
<?php
	$tabs->endTab(_UDDEADM_EMAIL,"email-tab");				


	// ======================BLOCK======================================================================================


	$tabs->startTab(_UDDEADM_BLOCK,"block-tab");
?>		
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">
			<?php uddeIMadmYesNo($config->blocksystem, 'config_blocksystem', false, _UDDEADM_BLOCKSYSTEM_HEAD, _UDDEADM_BLOCKSYSTEM_EXP); ?>
			<?php uddeIMadmYesNo($config->blockalert, 'config_blockalert', !$config->blocksystem, _UDDEADM_BLOCKALERT_HEAD, _UDDEADM_BLOCKALERT_EXP); ?>
<?php
			$xxx = explode(",", $config->blockgroups);
			if ($xxx==FALSE)
				$xxx = Array();
?>
			<tr align="center" valign="middle">
				<td align="left" valign="top"<?php echo $adminstyle; ?>>
					<strong><?php echo _UDDEADM_BLOCKGROUPS_HEAD; ?></strong>
				</td>
				<td align="left" valign="top"<?php echo $adminstyle; ?>>
<?php
					echo '<table border="0" cellpadding="0" cellspacing="0"><tr>';
					if (uddeIMcheckJversion()>=2) {
						$query = "SELECT id, title AS name FROM `#__usergroups` ORDER BY id";
					} elseif (uddeIMcheckJversion()>=1) {
						$query = "SELECT id, name FROM `#__core_acl_aro_groups` WHERE id NOT IN ( 17, 28, 29, 30 ) ORDER BY id";
					} else {
						$query = "SELECT group_id AS id, name FROM `#__core_acl_aro_groups` WHERE group_id NOT IN ( 17, 28, 29, 30 ) ORDER BY group_id";
					}

					$database->setQuery( $query );
					$usergroups = $database->loadObjectList();
					$numofcol = 1;
					$count = 0;
					foreach($usergroups as $usergroup) {
						$checked = '';
						if (in_array($usergroup->id,$xxx))
							$checked = 'checked="checked"';
						$count++;
						echo '<td><input style="float:none;" type="checkbox" name="config_blockgroups['.$count.']" '.$checked.' value="'.$usergroup->id.'" id="cb'.$count.'" class="form-check-input" /><label style="margin-left:4px;display:inline;float:none;" for="cb'.$count.'">'.$usergroup->name.'</label></td>';
						if (!($count % $numofcol))
							echo '</tr><tr>';
					}
					$addcol = $numofcol - ($count % $numofcol);
					if ($addcol < $numofcol)
						for ($i=0; $i<$addcol; $i++)
							echo '<td>&nbsp;</td>';
					echo '</tr></table>';
?>
				</td>
				<td align="left" valign="top" width="40%"<?php echo $adminstyle; ?>>
					<?php echo _UDDEADM_BLOCKGROUPS_EXP; ?>
				</td>
			</tr>										
			<?php uddeIMadmYesNo($config->unblockCBconnections, 'config_unblockCBconnections', false, _UDDEADM_UNBLOCKCB_HEAD, _UDDEADM_UNBLOCKCB_EXP); ?>
<?php
			$xxx = explode(",", $config->pubblockgroups);
			if ($xxx==FALSE)
				$xxx = Array();
?>
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<?php echo uddeIMprintCond(!$config->pubfrontend || !$plugin_public, _UDDEADM_PUBBLOCKGROUPS_HEAD, "gray", true); ?>
				</td>
				<td align="left" valign="top">
<?php
					echo '<table border="0" cellpadding="0" cellspacing="0"><tr>';
					if (uddeIMcheckJversion()>=2)
						$query = "SELECT id, title AS name FROM `#__usergroups` ORDER BY id";
					else if (uddeIMcheckJversion()>=1)
						$query = "SELECT id, name FROM `#__core_acl_aro_groups` WHERE id NOT IN ( 17, 28, 29, 30 ) ORDER BY id";
					else
						$query = "SELECT group_id AS id, name FROM `#__core_acl_aro_groups` WHERE group_id NOT IN ( 17, 28, 29, 30 ) ORDER BY group_id";
					$database->setQuery( $query );
					$usergroups = $database->loadObjectList();
					$numofcol = 1;
					$count = 0;
					foreach($usergroups as $usergroup) {
						$checked = '';
						if (in_array($usergroup->id,$xxx))
							$checked = 'checked="checked"';
						$count++;
						echo '<td><input style="float:none;" type="checkbox" name="config_pubblockgroups['.$count.']" '.$checked.' value="'.$usergroup->id.'" id="pcb'.$count.'" class="form-check-input" /><label style="margin-left:4px;display:inline;float:none;" for="pcb'.$count.'">'.$usergroup->name.'</label></td>';
						if (!($count % $numofcol))
							echo '</tr><tr>';
					}
					$addcol = $numofcol - ($count % $numofcol);
					if ($addcol < $numofcol)
						for ($i=0; $i<$addcol; $i++)
							echo '<td>&nbsp;</td>';
					echo '</tr></table>';
?>
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo uddeIMprintCond(!$config->pubfrontend || !$plugin_public, _UDDEADM_PUBBLOCKGROUPS_EXP.uddeIMnoPremium(!$plugin_public), "gray"); ?>
				</td>
			</tr>										
		</table>
<?php			
	$tabs->endTab(_UDDEADM_BLOCK,"block-tab");


	// ======================ARCHIVE=====================================================================================


	$tabs->startTab(_UDDEADM_ARCHIVE,"archive-tab");

?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">
			<?php uddeIMadmYesNo($config->allowarchive, 'config_allowarchive', false, _UDDEADM_ALLOWARCHIVE_HEAD, _UDDEADM_ALLOWARCHIVE_EXP); ?>
			<?php uddeIMadmText($config->maxarchive, 4, 'config_maxarchive', false, _UDDEADM_MAXARCHIVE_HEAD, _UDDEADM_MAXARCHIVE_EXP); ?>
			<?php uddeIMadmYesNo($config->inboxlimit, 'config_inboxlimit', false, _UDDEADM_INBOXLIMIT_HEAD, _UDDEADM_INBOXLIMIT_EXP); ?>
			<?php uddeIMadmYesNo($config->showinboxlimit, 'config_showinboxlimit', false, _UDDEADM_SHOWINBOXLIMIT_HEAD, _UDDEADM_SHOWINBOXLIMIT_EXP); ?>
			<?php uddeIMadmYesNo($config->enabledownload, 'config_enabledownload', !$config->allowarchive, _UDDEADM_ENABLEDOWNLOAD_HEAD, _UDDEADM_ENABLEDOWNLOAD_EXP); ?>
		</table>
<?php	
	$tabs->endTab(_UDDEADM_ARCHIVE, "archive-tab");	


	// =====================DATE=======================================================================================


	$tabs->startTab(_UDDEADM_DATESETTINGS,"date-tab");
?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">
			<?php 
				$df = Array();
                $df[ 'j. n. H:i' ] =   '5. 8. 22:40';
                $df[ 'd.m. H:i' ] =    '05.08. 22:40';
                $df[ 'j.m.y H:i' ] =   '5.08.07 22:40';
                $df[ 'd.m.y H:i' ] =   '05.08.07 22:40';
				$df[ 'j M, H:i' ] =    '5 Aug, 22:40';
				$df[ 'j. M H:i' ] =    '5. Aug 22:40';
				$df[ 'j. M, H:i' ] =   '5. Aug, 22:40';
				$df[ 'j M y, H:i' ] =  '5 Aug 07, 22:40';
				$df[ 'j. M y H:i' ] =  '5. Aug 07 22:40';
				$df[ 'j. M y, H:i' ] = '5. Aug 07, 22:40';
				$df[ 'M j, H:i' ] =    'Aug 5, 22:40';
				$df[ 'M j, h:i a' ] =  'Aug 5, 10:40 pm';
				$df[ 'Y-m-d H:i' ] =   '2007-08-05 22:40';
				$df[ 'm/d/y h:i a' ] = '08/05/07 10:40 pm';
				uddeIMadmSelect($config->datumsformat, 'config_datumsformat', $df, false, _UDDEADM_DATEFORMAT_HEAD, _UDDEADM_DATEFORMAT_EXP);
			?>
			<?php 
				$ldf = Array();
				$ldf[ 'j M, H:i' ] =        '5 Aug, 22:40';
				$ldf[ 'j. M H:i' ] =        '5. Aug 22:40';
				$ldf[ 'j. M, H:i' ] =       '5. Aug, 22:40';
				$ldf[ 'j F, H:i' ] =        '5 August, 22:40';
				$ldf[ 'j. F H:i' ] =        '5. August 22:40';
				$ldf[ 'j. F, H:i' ] =       '5. August, 22:40';
				$ldf[ 'j F Y, H:i' ] =      '5 August 2007, 22:40';
				$ldf[ 'j. F Y H:i' ] =      '5. August 2007 22:40';
				$ldf[ 'j. F Y, H:i' ] =     '5. August 2007, 22:40';
				$ldf[ 'M j, H:i' ] =        'Aug 5, 22:40';
				$ldf[ 'M j, h:i a' ] =      'Aug 5, 10:40 pm';
				$ldf[ 'F j, Y - H:i' ] =    'August 5, 2007 - 22:40';
				$ldf[ 'F j, Y - h:i a' ] =  'August 5, 2007 - 10:40 pm';
				$ldf[ 'Y-m-d H:i' ] =       '2007-08-05 22:40';
				$ldf[ 'm/d/y h:i a' ] =     '08/05/07 10:40 pm';
				$ldf[ 'D, j M - H:i' ] =    'Tue, 5 Aug - 22:40';
				$ldf[ 'D, j. M - H:i' ] =   'Tue, 5. Aug - 22:40';
				$ldf[ 'D, M j - H:i' ] =    'Tue, Aug 5 - 22:40';
				$ldf[ 'D, M j - h:i a' ] =  'Tue, Aug 5 - 10:40 pm';
				$ldf[ 'l, j. F - H:i' ] =   'Tuesday, 5. August - 22:40';
				$ldf[ 'l, j. F - h:i a' ] = 'Tuesday, 5. August - 10:40 pm';
				$ldf[ 'l, j. F Y - H:i' ] = 'Tuesday, 5. August 2007 - 22:40';
				$ldf[ 'l, F j - H:i' ] =    'Tuesday, August 5 - 22:40';
				$ldf[ 'l, F j - h:i a' ] =  'Tuesday, August 5 - 10:40 pm';
				$ldf[ 'l, F j, Y - H:i' ] = 'Tuesday, August 5, 2005 - 22:40';
				$ldf[ 'l, \d\e\n j F Y, H:i' ] = 'Tuesday, den 5 August 2007, 22:40';
				$ldf[ 'l, \d\e\n j. F Y, H:i' ] = 'Tuesday, den 5. August 2007, 22:40';
				uddeIMadmSelect($config->ldatumsformat, 'config_ldatumsformat', $ldf, false, _UDDEADM_LDATEFORMAT_HEAD, _UDDEADM_LDATEFORMAT_EXP);
			?>

			<?php 
				uddeIMadmText($config->timezone, 4, 'config_timezone', false, _UDDEADM_TIMEZONE_HEAD, _UDDEADM_TIMEZONE_EXP, _UDDEADM_HOURS, $adminstyle);
				uddeIMadmYesNo($config->stime, 'config_stime', false, _UDDEADM_STIME_HEAD, _UDDEADM_STIME_EXP);
			?>
		</table>														
<?php
	$tabs->endTab(_UDDEADM_DATESETTINGS, "date-tab");


	// ======================PUBLIC=====================================================================================


	if ($plugin_public) {
		$tabs->startTab(_UDDEADM_PUBLIC,"public-tab");
?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">
			<?php uddeIMadmYesNo($config->pubfrontend, 'config_pubfrontend', false, _UDDEADM_PUBFRONTEND_HEAD, _UDDEADM_PUBFRONTEND_EXP); ?>
			<?php uddeIMadmSelect($config->pubfrontenddefault, 'config_pubfrontenddefault', Array('1'=>_UDDEADM_PUBDEF1, '0'=>_UDDEADM_PUBDEF0), !$config->pubfrontend, _UDDEADM_PUBFRONTENDDEF_HEAD, _UDDEADM_PUBFRONTENDDEF_EXP); ?>
			<?php uddeIMadmSelect($config->pubmodeshowallusers, 'config_pubmodeshowallusers', Array('2'=>_UDDEADM_MODESHOWALLUSERS_2, '1'=>_UDDEADM_MODESHOWALLUSERS_1, '0'=>_UDDEADM_MODESHOWALLUSERS_0), !$config->pubfrontend, _UDDEADM_PUBMODESHOWALLUSERS_HEAD, _UDDEADM_PUBMODESHOWALLUSERS_EXP); ?>
			<?php uddeIMadmSelect($config->pubrealnames, 'config_pubrealnames', Array('1'=>_UDDEADM_REALNAMES, '0'=>_UDDEADM_USERNAMES), !$config->pubfrontend, _UDDEADM_PUBNAMESTEXT, _UDDEADM_PUBNAMESDESC); ?>
			<?php uddeIMadmSelect($config->pubhideallusers, 'config_pubhideallusers', Array('3'=>_UDDEADM_HIDEALLUSERS_3, '2'=>_UDDEADM_HIDEALLUSERS_2, '1'=>_UDDEADM_HIDEALLUSERS_1, '0'=>_UDDEADM_HIDEALLUSERS_0), !$config->pubfrontend, _UDDEADM_PUBHIDEALLUSERS_HEAD, _UDDEADM_PUBHIDEALLUSERS_EXP); ?>
			<?php uddeIMadmText($config->pubhideusers, 20, 'config_pubhideusers', !$config->pubfrontend, _UDDEADM_PUBHIDEUSERS_HEAD, _UDDEADM_PUBHIDEUSERS_EXP, 'ID'); ?>
			<?php uddeIMadmYesNo($config->pubemail, 'config_pubemail', !$config->pubemail, _UDDEADM_PUBEMAIL_HEAD, _UDDEADM_PUBEMAIL_EXP); ?>
			<?php uddeIMadmYesNo($config->pubreplies, 'config_pubreplies', !$config->pubfrontend, _UDDEADM_PUBREPLYS_HEAD, _UDDEADM_PUBREPLYS_EXP); ?>
			<?php uddeIMadmYesNo($config->modpubusers, 'config_modpubusers', !$config->pubfrontend, _UDDEADM_MODPUBUSERS_HEAD, _UDDEADM_MODNEWUSERS_EXP); ?>

			<?php uddeIMadmYesNo($config->pubuseautocomplete, 'config_pubuseautocomplete', !$config->pubfrontend, _UDDEADM_USEAUTOCOMPLETE_HEAD, _UDDEADM_USEAUTOCOMPLETE_EXP, $adminstyle); ?>
			<?php uddeIMadmYesNo($config->pubsearchinstring, 'config_pubsearchinstring', !$config->pubuseautocomplete, _UDDEADM_SEARCHINSTRING_HEAD, _UDDEADM_SEARCHINSTRING_EXP); ?>
		</table>
<?php	
		$tabs->endTab(_UDDEADM_PUBLIC, "public-tab");
	}


	// =======================SYSTEM==================================================================================


	$tabs->startTab(_UDDEADM_SYSTEM,"system-tab");
?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">
			<?php 
				$temp  = _UDDEADM_ADMINIGNITIONONLY_EXP."<br />";
				$temp .= "<a href=".uddeIMredirectIndex()."?option=com_uddeim&task=maintenanceprune>"._UDDEADM_MAINTENANCE_PRUNE."</a>";
				uddeIMadmSelect($config->adminignitiononly, 'config_adminignitiononly', Array('1'=>_UDDEADM_ADMINIGNITIONONLY_YES, '0'=>_UDDEADM_ADMINIGNITIONONLY_NO, '2'=>_UDDEADM_ADMINIGNITIONONLY_MANUALLY), false, _UDDEADM_ADMINIGNITIONONLY_HEAD, $temp);
			?>

			<?php uddeIMadmSelect($config->allowsysgm, 'config_allowsysgm', Array('2'=>_UDDEADM_ALLOWTOALL2_2, '1'=>_UDDEADM_ALLOWTOALL2_1, '0'=>_UDDEADM_ALLOWTOALL2_0), false, _UDDEADM_ALLOWTOALL2_HEAD, _UDDEADM_ALLOWTOALL2_EXP); ?>
			<?php uddeIMadmYesNo($config->showgroups, 'config_showgroups', !$config->allowsysgm, _UDDEADM_SHOWGROUPS_HEAD, _UDDEADM_SHOWGROUPS_EXP); ?>

			<?php uddeIMadmText($config->groupsadmin, 20, 'config_groupsadmin', false, _UDDEADM_GROUPSADMIN_HEAD, _UDDEADM_GROUPSADMIN_EXP); ?>
			<?php uddeIMadmText($config->groupsspecial, 20, 'config_groupsspecial', false, _UDDEADM_GROUPSSPECIAL_HEAD, _UDDEADM_GROUPSSPECIAL_EXP); ?>

			<?php uddeIMadmSelect($config->mailsystem, 'config_mailsystem', Array('1'=>_UDDEADM_MAILSYSTEM_MOSMAIL, '0'=>_UDDEADM_MAILSYSTEM_PHPMAIL, '4'=>'php mail - force \r\n [header]', '2'=>'php mail [debug on Error]', '3'=>'php mail Info [debug All]'), false, _UDDEADM_MAILSYSTEM_HEAD, _UDDEADM_MAILSYSTEM_EXP); ?>
			<?php uddeIMadmText($config->sysm_username, 20, 'config_sysm_username', false, _UDDEADM_SYSM_USERNAME_HEAD, _UDDEADM_SYSM_USERNAME_EXP); ?>

			<?php uddeIMadmSelect($config->usecaptcha, 'config_usecaptcha', Array('4'=>_UDDEADM_CAPTCHAF4, '3'=>_UDDEADM_CAPTCHAF3, '2'=>_UDDEADM_CAPTCHAF2, '1'=>_UDDEADM_CAPTCHAF1, '0'=>_UDDEADM_CAPTCHAF0), false, _UDDEADM_USECAPTCHA_HEAD, _UDDEADM_USECAPTCHA_EXP, $adminstyle); ?>
			<?php uddeIMadmText($config->captchalen, 4, 'config_captchalen', !$config->usecaptcha, _UDDEADM_CAPTCHALEN_HEAD, _UDDEADM_CAPTCHALEN_EXP); ?>
			<?php uddeIMadmSelect($config->captchatype, 'config_captchatype', Array('2'=>_UDDEADM_CAPTCHA_RECAPTCHA2, '1'=>_UDDEADM_CAPTCHA_RECAPTCHA, '0'=>_UDDEADM_CAPTCHA_INTERNAL), !$config->usecaptcha, _UDDEADM_CAPTCHATYPE_HEAD, _UDDEADM_CAPTCHATYPE_EXP); ?>
			<?php uddeIMadmText($config->recaptchapub, 40, 'config_recaptchapub', !$config->usecaptcha, _UDDEADM_RECAPTCHAPUB_HEAD, _UDDEADM_RECAPTCHAPUB_EXP); ?>
			<?php uddeIMadmText($config->recaptchaprv, 40, 'config_recaptchaprv', !$config->usecaptcha, _UDDEADM_RECAPTCHAPRV_HEAD, _UDDEADM_RECAPTCHAPRV_EXP); ?>
			<?php uddeIMadmYesNo($config->csrfprotection, 'config_csrfprotection', false, _UDDEADM_CSRFPROTECTION_HEAD, _UDDEADM_CSRFPROTECTION_EXP); ?>

			<?php uddeIMadmText($config->timedelay, 4, 'config_timedelay', false, _UDDEADM_TIMEDELAY_HEAD, _UDDEADM_TIMEDELAY_EXP, _UDDEADM_SECONDS, $adminstyle); ?>
			<?php uddeIMadmText($config->waitdays, 4, 'config_waitdays', false, _UDDEADM_WAITDAYS_HEAD, _UDDEADM_WAITDAYS_EXP, _UDDEADM_DAYS); ?>

			<?php uddeIMadmText($config->charset, 10, 'config_charset', false, _UDDEADM_CHARSET_HEAD, _UDDEADM_CHARSET_EXP, '', $adminstyle); ?>
			<?php uddeIMadmText($config->mailcharset, 10, 'config_mailcharset', false, _UDDEADM_MAILCHARSET_HEAD, _UDDEADM_MAILCHARSET_EXP); ?>
			<?php uddeIMadmYesNo($config->encodeheader, 'config_encodeheader', false, _UDDEADM_ENCODEHEADER_HEAD, _UDDEADM_ENCODEHEADER_EXP); ?>
			<?php uddeIMadmSelect($config->languagecharset, 'config_languagecharset', Array('1'=>_UDDEADM_LANGUAGECHARSET_UTF8, '0'=>_UDDEADM_LANGUAGECHARSET_DEFAULT), false, _UDDEADM_LANGUAGECHARSET_HEAD, _UDDEADM_LANGUAGECHARSET_EXP); ?>

			<?php uddeIMadmSelect($config->autocompleter, 'config_autocompleter', Array('0'=>_UDDEADM_AUTOCOMPLETER_0, '1'=>_UDDEADM_AUTOCOMPLETER_1, '2'=>_UDDEADM_AUTOCOMPLETER_2), false, _UDDEADM_AUTOCOMPLETER_HEAD, _UDDEADM_AUTOCOMPLETER_EXP, $adminstyle); ?>
            <?php uddeIMadmSelect($config->autocompletestart, 'config_autocompletestart', Array('1'=>1, '2'=>2, '3'=>3), false, _UDDEADM_AUTOCOMPLETESTART_HEAD, _UDDEADM_AUTOCOMPLETESTART_EXP); ?>

			<?php
				$temp  = _UDDEADM_OVERWRITEITEMID_EXP." ";
				$found = uddeIMgetItemidComponent("com_uddeim", $config);
//
				$temp .= _UDDEADM_OVERWRITEITEMID_CURRENT.$found;
				uddeIMadmYesNo($config->overwriteitemid, 'config_overwriteitemid', false, _UDDEADM_OVERWRITEITEMID_HEAD, $temp, $adminstyle);
			?>
			<?php uddeIMadmText($config->useitemid, 3, 'config_useitemid', !$config->overwriteitemid, _UDDEADM_USEITEMID_HEAD, _UDDEADM_USEITEMID_EXP,'ID uddeIM'); ?>

			<?php
				$arss = Array();
				if ($plugin_rss) {
					$arss['2'] = _UDDEADM_ADMINSONLY;
					$arss['1'] = _UDDEADM_YES;
				}
				$arss['0'] = _UDDEADM_NO;
				uddeIMadmSelect($config->enablerss, 'config_enablerss', $arss, false, _UDDEADM_ENABLERSS_HEAD, _UDDEADM_ENABLERSS_EXP.uddeIMnoPremium(!$plugin_rss), $adminstyle);
			?>
			<?php uddeIMadmYesNo($config->showigoogle, 'config_showigoogle', !$config->enablerss, _UDDEADM_SHOWIGOOGLE_HEAD, _UDDEADM_SHOWIGOOGLE_EXP); ?>
			<?php uddeIMadmText($config->rsslimit, 4, 'config_rsslimit', !$config->enablerss, _UDDEADM_RSSLIMIT_HEAD, _UDDEADM_RSSLIMIT_EXP); ?>

			<?php uddeIMadmYesNo($config->enableattachment, 'config_enableattachment', false, _UDDEADM_ENABLEATTACHMENT_HEAD, _UDDEADM_ENABLEATTACHMENT_EXP.uddeIMnoPremium(!$plugin_attachment), $adminstyle); ?>
			<?php uddeIMadmYesNo($config->unprotectdownloads, 'config_unprotectdownloads', false, _UDDEADM_UNPROTECTATTACHMENT_HEAD, _UDDEADM_UNPROTECTATTACHMENT_EXP); ?>
			<?php uddeIMadmYesNo($config->showlistattachment, 'config_showlistattachment', !$config->enableattachment, _UDDEADM_SHOWLISTATTACHMENT_HEAD, _UDDEADM_SHOWLISTATTACHMENT_EXP); ?>
<?php
			$xxx = explode(",", $config->attachmentgroups);
			if ($xxx==FALSE)
				$xxx = Array();
?>
			<tr align="center" valign="middle">
				<td align="left" valign="top">
<?php				echo uddeIMprintCond(!$config->enableattachment, _UDDEADM_ATTACHMENTGROUPS_HEAD, "gray", true); ?>
				</td>
				<td align="left" valign="top">
<?php
					echo '<table border="0" cellpadding="0" cellspacing="0"><tr>';
					if (uddeIMcheckJversion()>=2)
						$query = "SELECT id, title AS name FROM `#__usergroups` ORDER BY id";
					else if (uddeIMcheckJversion()>=1)
						$query = "SELECT id, name FROM `#__core_acl_aro_groups` WHERE id NOT IN ( 17, 28, 29, 30 ) ORDER BY id";
					else
						$query = "SELECT group_id AS id, name FROM `#__core_acl_aro_groups` WHERE group_id NOT IN ( 17, 28, 29, 30 ) ORDER BY group_id";
					$database->setQuery( $query );
					$usergroups = $database->loadObjectList();
					$numofcol = 1;
					$count = 0;
					foreach($usergroups as $usergroup) {
						$checked = '';
						if (in_array($usergroup->id,$xxx))
							$checked = 'checked="checked"';
						$count++;
						echo '<td>';
						// if (!$config->enableattachment) echo "<span style='color: gray;'>";
						echo '<input style="float:none;" type="checkbox" name="config_attachmentgroups['.$count.']" '.$checked.' value="'.$usergroup->id.'" id="cb'.$count.'" class="form-check-input" /><label style="margin-left:4px;display:inline;float:none;" for="cb'.$count.'">'.$usergroup->name.'</label>';
						// if (!$config->enableattachment) echo "</span>";
						echo '</td>';
						if (!($count % $numofcol))
							echo '</tr><tr>';
					}
					$addcol = $numofcol - ($count % $numofcol);
					if ($addcol < $numofcol)
						for ($i=0; $i<$addcol; $i++)
							echo '<td>&nbsp;</td>';
					echo '</tr></table>';
?>
				</td>
				<td align="left" valign="top" width="40%">
<?php				echo uddeIMprintCond(!$config->enableattachment, _UDDEADM_ATTACHMENTGROUPS_EXP, "gray", false); ?>
				</td>
			</tr>										
			<?php uddeIMadmText($config->maxsizeattachment, 10, 'config_maxsizeattachment', !$config->enableattachment, _UDDEADM_MAXSIZEATTACHMENT_HEAD, _UDDEADM_MAXSIZEATTACHMENT_EXP,'bytes'); ?>
			<?php uddeIMadmText($config->allowedextensions, 40, 'config_allowedextensions', !$config->enableattachment, _UDDEADM_ALLOWEDEXTENSIONS_HEAD, _UDDEADM_ALLOWEDEXTENSIONS_EXP); ?>
			<?php 
				$amatt = Array();
				$amatt['3'] = "3";
				$amatt['2'] = "2";
				$amatt['1'] = "1";
				uddeIMadmSelect($config->maxattachments, 'config_maxattachments', $amatt, !$config->enableattachment, _UDDEADM_MAXATTACHMENTS_HEAD, _UDDEADM_MAXATTACHMENTS_EXP.uddeIMnoPremium(!$plugin_attachment));
			?>
			<?php 
				$temp  = _UDDEADM_FILEADMINIGNITIONONLY_EXP."<br />";
				$temp .= "<a href=".uddeIMredirectIndex()."?option=com_uddeim&task=filemaintenanceprune>"._UDDEADM_FILEMAINTENANCE_PRUNE."</a>";
				uddeIMadmSelect($config->fileadminignitiononly, 'config_fileadminignitiononly', Array('1'=>_UDDEADM_FILEADMINIGNITIONONLY_YES, '0'=>_UDDEADM_FILEADMINIGNITIONONLY_NO, '2'=>_UDDEADM_FILEADMINIGNITIONONLY_MANUALLY), !$config->enableattachment, _UDDEADM_FILEADMINIGNITIONONLY_HEAD, $temp);
			?>

			<?php uddeIMadmYesNo($config->modnewusers, 'config_modnewusers', !$plugin_mcp, _UDDEADM_MODNEWUSERS_HEAD, _UDDEADM_MODNEWUSERS_EXP.uddeIMnoPremium(!$plugin_mcp), $adminstyle); ?>

			<?php uddeIMadmYesNo($config->enablepostbox, 'config_enablepostbox', !$plugin_postbox, _UDDEADM_POSTBOX_HEAD, _UDDEADM_POSTBOX_EXP.uddeIMnoPremium(!$plugin_postbox), $adminstyle); ?>
			<?php uddeIMadmSelect($config->postboxfull, 'config_postboxfull', Array('2'=>_UDDEADM_POSTBOXFULL_2, '1'=>_UDDEADM_POSTBOXFULL_1, '0'=>_UDDEADM_POSTBOXFULL_0), !$config->enablepostbox, _UDDEADM_POSTBOXFULL_HEAD, _UDDEADM_POSTBOXFULL_EXP); ?>
			<?php uddeIMadmYesNo($config->postboxavatars, 'config_postboxavatars', !$config->enablepostbox, _UDDEADM_POSTBOXAVATARS_HEAD, _UDDEADM_POSTBOXAVATARS_EXP); ?>
		</table>
<?php	
	$tabs->endTab(_UDDEADM_SYSTEM, "system-tab");	


	// ======================IMPORT=================================================================================


	if ($config->pmsimportdone<=1) {	// PMS found or already imported (=2 means suppress this tab, set when no PMS is found)
		$tabs->startTab(_UDDEADM_IMPORT,"import-tab");
?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<h2><?php echo _UDDEADM_IMPORT_HEADER; ?></h2>
					<?php echo _UDDEADM_IMPORT_HELP; ?>
				</td>
			</tr>
			<tr align="center" valign="middle">				
				<td align="left" valign="top">
<?php
					$pmsfounds = uddeIMcheckPMStype();

					echo "<p>"._UDDEADM_PMSFOUND."</p>";
					echo "<p>";
					foreach ($pmsfounds as $pmsfound) {
						$importlink = "<a href=".uddeIMredirectIndex()."?option=com_uddeim&task=importpms&act=".(int)$pmsfound.">"._UDDEADM_IMPORT_CAPS."</a>";
						echo $importlink.": ".uddeIMnamePMS($pmsfound)." (";
						switch($pmsfound) {
							case  1: $sql = "SELECT count(id) FROM `#__pms`"; break;
							case  2: $sql = "SELECT count(id) FROM `#__pms`"; break;
							case  3: $sql = "SELECT count(id) FROM `#__jim`"; break;
							case  4: $sql = "SELECT count(id) FROM `#__abim_data`"; break;
							case  5: $sql = "SELECT count(*) FROM `#__jam` AS m LEFT JOIN `#__jam_receivers` AS r ON r.mid=m.id WHERE draft=0"; break;
							case  6: $sql = "SELECT count(id) FROM `#__mypms`"; break;
							case  7: $sql = "SELECT count(m.id) FROM `#__missus` AS m JOIN `#__missus_receipt` AS r WHERE m.id = r.id AND m.is_draft=0"; break;
							case  8: $sql = "SELECT count(id) FROM `#__primezilla_inbox`"; break;
							case  9: $sql = "SELECT count(id) FROM `#__pms`"; break;
							case 10: $sql = "SELECT count(id) FROM `#__mypms`"; break;
							case 11: $sql = "SELECT count(id) FROM `#__jim`"; break;
							case 12: $sql = "SELECT count(id) FROM `#__pms`"; break;
							case 13: $sql = "SELECT count(*) FROM `#__community_msg_recepient`"; break;
							case 14: $sql = "SELECT count(n) FROM `#__messaging`"; break;
							case 15: $sql = "SELECT count(id) FROM `#__cdpuremessenger`"; break;
						}
						$database->setQuery($sql);
						$allpms=(int)$database->loadResult();
						echo $allpms." "._UDDEADM_MESSAGES.") ";

						$count = 5000;
						if ($allpms>$count) {
							$cnt = 1;
							echo _UDDEADM_IMPORT_PARTIAL." ";
							for ($start = 0; $start < $allpms; $start+=$count) {
								$importlink = "<a href='".uddeIMredirectIndex()."?option=com_uddeim&task=importpms&act=".(int)$pmsfound."&importstart=".(int)$start."&importcount=".(int)$count."'>[".$cnt++."]</a> ";
								echo $importlink;
							}
						}
						echo "<br />";
					}
					echo "</p>";
					echo "<p>&nbsp;</p>";

					$oldpmsimportdone = $config->pmsimportdone;
					if (!empty($pmsfounds)) {
						switch($config->pmsimportdone) {
							case 2:		// this should not happen here since tab is not visible when pmsimportdone=2
							case 1:		echo "<p>"._UDDEADM_ALREADYIMPORTED."</p>";
										break;
						}
					} else {
						switch($config->pmsimportdone) {
							case 1:		echo "<p>"._UDDEADM_PMSNOTFOUND."</p>";
										$config->pmsimportdone=2;
										break;
							case 2:		echo "<p>"._UDDEADM_PMSNOTFOUND."</p>";
										break;	// this should not happen here since tab is not visible when pmsimportdone=2
							default:	echo "<p>"._UDDEADM_PMSNOTFOUND."</p>";
										$config->pmsimportdone=2;			// ok, we can suppress the import tab next time
										break;
						}
					}
					if ($oldpmsimportdone!=$config->pmsimportdone) {
						uddeIMsaveConfig($pathtoadmin, $config);
					}
?>
				</td>
			</tr>
		</table>
<?php	
		$tabs->endTab(_UDDEADM_IMPORT, "import-tab");
	}

	
	// ======================MAINTENANCE==============================================================================


	$tabs->startTab(_UDDEADM_MAINTENANCE,"maintenance-tab");
?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm uddeim" id="adminForm">
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_MAINTENANCE_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<?php
						echo "<a class='btn btn-sm btn-info' href=".uddeIMredirectIndex()."?option=com_uddeim&task=maintenance&act=check>"._UDDEADM_MAINTENANCE_CHECK."</a>&nbsp;";
						echo "<a class='btn btn-sm btn-outline-action' href=".uddeIMredirectIndex()."?option=com_uddeim&task=maintenance&act=trash>"._UDDEADM_MAINTENANCE_TRASH."</a>&nbsp;";
					?>
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_MAINTENANCE_EXP; ?>
				</td>
			</tr>						
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_MAINTENANCEDEL_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<?php
						echo "<a class='btn btn-sm btn-outline-danger' href=".uddeIMredirectIndex()."?option=com_uddeim&task=maintenanceprune>"._UDDEADM_MAINTENANCEDEL_ERASE."</a>";
					?>
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_MAINTENANCEDEL_EXP; ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_FILEMAINTENANCEDEL_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<?php
						echo "<a class='btn btn-sm btn-outline-danger' href=".uddeIMredirectIndex()."?option=com_uddeim&task=filemaintenanceprune>"._UDDEADM_FILEMAINTENANCEDEL_ERASE."</a>";
					?>
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_FILEMAINTENANCEDEL_EXP; ?>
				</td>
			</tr>						
<?php
		if (uddeIMcheckJversion()>15) { //not needed for joomla5
?>
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_MAINTENANCEFIX_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<?php
						echo "<a class='btn btn-sm btn-info' href=".uddeIMredirectIndex()."?option=com_uddeim&task=maintenancefix&act=check>"._UDDEADM_MAINTENANCE_CHECK."</a>&nbsp;";
						echo "<a class='btn btn-sm btn-outline-action' href=".uddeIMredirectIndex()."?option=com_uddeim&task=maintenancefix&act=fix>"._UDDEADM_MAINTENANCE_FIX."</a>&nbsp;";
					?>
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_MAINTENANCEFIX_EXP; ?>
				</td>
			</tr>						
<?php
		}
?>
<?php
				$query = "SELECT value FROM `#__uddeim_config` WHERE varname='_backupdate'";
				$database->setQuery($query);
				$backupdate = $database->loadResult();
?>
                <!-- new:  backup to db on saving -->
                <?php uddeIMadmYesNo($config->saveconfigdb, 'config_saveconfigdb', false, _UDDEADM_SAVECONFIGDB_HEAD, _UDDEADM_SAVECONFIGDB_EXP, $adminstyle); ?>

                <tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_BACKUPRESTORE_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<?php
						echo "<a class='btn btn-sm btn-success' href=".uddeIMredirectIndex()."?option=com_uddeim&task=backuprestore&act=backup>"._UDDEADM_BACKUPRESTORE_BACKUP."</a>&nbsp;";
						if ($backupdate)
						echo "<a class='btn btn-sm btn-outline-action' href=".uddeIMredirectIndex()."?option=com_uddeim&task=backuprestore&act=restore>"._UDDEADM_BACKUPRESTORE_RESTORE."</a>&nbsp;";
					?>
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_BACKUPRESTORE_EXP;
					if ($backupdate) echo "<br />"._UDDEADM_BACKUPRESTORE_DATE.$backupdate; ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_VERSIONCHECK_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<?php
						echo "<a class='btn btn-sm btn-info' href=".uddeIMredirectIndex()."?option=com_uddeim&task=versioncheck>"._UDDEADM_VERSIONCHECK_CHECK."</a>";
					?>
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_VERSIONCHECK_EXP; ?>
				</td>
			</tr>						
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<strong><?php echo _UDDEADM_STATISTICS_HEAD; ?></strong>
				</td>
				<td align="left" valign="top">
					<?php
						echo "<a class='btn btn-sm btn-secondary' href=".uddeIMredirectIndex()."?option=com_uddeim&task=showstatistics>"._UDDEADM_STATISTICS_CHECK."</a>";
					?>
				</td>
				<td align="left" valign="top" width="40%">
					<?php echo _UDDEADM_STATISTICS_EXP; ?>
				</td>
			</tr>						
		</table>														
<?php
	$tabs->endTab(_UDDEADM_MAINTENANCE, "maintenance-tab");


	// =====================ABOUT======================================================================================
	

	$tabs->startTab(_UDDEADM_ABOUT,"about-tab");
?>
		<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm" id="adminForm">
			<tr align="center" valign="middle">
				<td align="left" valign="top">
					<h2>uddeIM</h2>
					<?php echo "<p><span style='color: red;'>".($versionstring ?? 'uddeIM 5.3')." - config ".($configversion ?? '2.8')."</span></p>\n"; ?>

					<p><b>uddeIM (Instant Messsages)</b><br />
					PMS component for Joomla 5+<br />
					&copy; 2007-2014 Stephan Slabihoud, &copy; 2005-2006 by Benjamin Zweifel<br />
                    <b>version 5</b> (Joomla5):  2024  by joomod.de</p>

					<p>Language file: <?php echo $usedlanguage; ?></p>
					<?php echo "<p>"._UDDEADM_TRANSLATORS_CREDITS."</p>"; ?>

					<p><b>Thanks in advance...</b><br />
					You can use and distribute uddeIM freely, but if you really find it useful, a small donation would be 
					very appreciated. uddeIM is the result of hard work, spending hours developing and testing this component.
					If you feel that you would like to give a donation for your use of uddeIM, or just because you want to 
					support uddeIM for future updates, please make a small donation using the Paypal buttons below.</p>
					
					<p>This version is based on uddeIM 0.5b which has been written by Benjamin Zweifel in 2006.</p>

					<p>uddeIM comes with absolutely no warranty.<br />
					For details, see the license at <a href="http://www.gnu.org/licenses/gpl.txt">www.gnu.org/licenses/gpl.txt</a>.</p>

					<input type="hidden" name="config_version" value="<?php echo $config->version; ?>" />
					<input type="hidden" name="config_pmsimportdone" value="<?php echo $config->pmsimportdone; ?>" /> 
				</td>
			</tr>
		</table>
<?php	
	$tabs->endTab(_UDDEADM_ABOUT, "about-tab");


	// ======================END=======================================================================================


	$tabs->endPane();
?>
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="<?php echo $task;?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="hidemainmenu" value="0" />
</form>
	<br clear=all>
<?php	
}

function uddeIMnoPremium($value) {
	if ($value)
		return "<br /><a href='http://www.slabihoud.de/uddeim_premium.htm' target='_new'><span style='color:#800000'>"._UDDEADM_NOPREMIUM."</span></a>";
	return "";
}

function uddeIMprintCond($cond, $text, $color, $strong=false) {
	if ($cond)	 echo "<span style='color: ".$color.";'>";
	if ($strong) echo "<strong>";
	echo $text;
	if ($strong) echo "</strong>";
	if ($cond)	 echo "</span>";
}

function uddeIMadmYesNo($value, $postvar, $condition, $head, $exp, $style='') {
	$tm = new mosHTML();
	echo '<tr align="center" valign="middle">';
	echo '<td align="left" valign="top"'.$style.'>';
	echo uddeIMprintCond($condition, $head, "gray", true);
	echo '</td>';
	echo '<td align="left" valign="top"'.$style.'>';
	//$local = Array();
	//$local[] = $tm->makeOption( '1', _UDDEADM_YES );
	//$local[] = $tm->makeOption( '0', _UDDEADM_NO );
	//echo $tm->RadioList( $local, $postvar, 'class="inputbox" size="2"', $value );
	echo $tm->yesnoButton( $postvar, $value ); 
	echo '</td>';
	echo '<td align="left" valign="top" width="40%"'.$style.'>';
	echo uddeIMprintCond($condition, $exp, "gray");
	echo '</td>';
	echo '</tr>';
}

function uddeIMadmSelect($value, $postvar, $options_arr, $condition, $head, $exp, $style='') {
	$tm = new mosHTML();
	echo '<tr align="center" valign="middle">';
	echo '<td align="left" valign="top"'.$style.'>';
	echo uddeIMprintCond($condition, $head, "gray", true);
	echo '</td>';
	echo '<td align="left" valign="top"'.$style.'>';
	$local = Array();
	foreach ($options_arr as $key => $val)
		$local[] = $tm->makeOption( $key, $val );
	echo $tm->selectList( $local, $postvar, 'class="inputbox" size="1"', 'value', 'text', $value );
	echo '</td>';
	echo '<td align="left" valign="top" width="40%"'.$style.'>';
	echo uddeIMprintCond($condition, $exp, "gray");
	echo '</td>';
	echo '</tr>';
}

function uddeIMadmText($value, $size, $postvar, $condition, $head, $exp, $postfixtext='', $style='') {
	echo '<tr align="center" valign="middle">';
	echo '<td align="left" valign="top"'.$style.'>';
	echo uddeIMprintCond($condition, $head, "gray", true);
	echo '</td>';
	echo '<td align="left" valign="top"'.$style.'>';
	echo '<input type="text" name="'.$postvar.'" size="'.$size.'" value="'.uddeIMquotecode($value).'" />'.($postfixtext ? '<span class="uddpostfix">'.$postfixtext.'</span>' : '');
	echo '</td>';
	echo '<td align="left" valign="top" width="40%"'.$style.'>';
	echo uddeIMprintCond($condition, $exp, "gray");
	echo '</td>';
	echo '</tr>';
}

function uddeIMarchivetoTrash($option, $task, $act, $config) {
	$database = uddeIMgetDatabase();

	if($act=="inbox") {
		$rightnow=uddetime($config->timezone);
		$sql="UPDATE `#__uddeim` SET archived=0 WHERE archived=1";
		$database->setQuery($sql);
		try {
			$database->execute();
		} catch(Exception $e) {
			throw new Exception("SQL error when attempting to unarchive messages. " . get_class($e));
		}
		$mosmsg = _UDDEADM_ARCHIVETOTRASH_INBOX_DONE;
		$redirecturl = uddeIMredirectIndex()."?option=com_uddeim";
		uddeIMmosRedirect($redirecturl, $mosmsg);
	} else {

?>

	  <table cellpadding="4" cellspacing="0" border="0" width="100%">
	  	<tr>
    		<td width="100%" class="sectionname">
			      <h4><?php echo _UDDEADM_SETTINGS; ?></h4>
		    </td>
		</tr>
	  </table>

	  <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm" id="adminForm">
		    <tr align="center" valign="middle">
			    <td align="left" valign="top">
						<?php
						echo "<p><b>"._UDDEADM_ARCHIVETOTRASH_INTRO."</b></p>";
						echo "<p>";
						echo "<a href='".uddeIMredirectIndex()."?option=com_uddeim&task=archivetotrash&act=inbox'>"._UDDEADM_ARCHIVETOTRASH_INBOX_LINK."</a><br />"._UDDEADM_ARCHIVETOTRASH_INBOX_EXP;
						echo "</p>";
						echo "<p>";
						echo "<a href='".uddeIMredirectIndex()."?option=com_uddeim'>"._UDDEADM_ARCHIVETOTRASH_LEAVE_LINK."</a><br />"._UDDEADM_ARCHIVETOTRASH_LEAVE_EXP;
						echo "</p>";
						?>
				</td>
			</tr>
	  </table>
<?php			
	}
}

function uddeIMmaintenanceCheckTrash($option, $task, $act, $config) {
	$database = uddeIMgetDatabase();
	$jobtodo=0;
	if ($act=="check") {
		echo _UDDEADM_MAINTENANCE_MC1;
		echo "<br />";
		echo _UDDEADM_MAINTENANCE_MC2;
		echo _UDDEADM_MAINTENANCE_MC3;
		echo _UDDEADM_MAINTENANCE_MC4;
		echo _UDDEADM_MAINTENANCE_MC5;
		echo _UDDEADM_MAINTENANCE_MC6;
		echo "<br />";
	}
	if ($act=="trash") {
		echo _UDDEADM_MAINTENANCE_MT1;
		echo "<br />";
	}


	$query = "SELECT min(id) FROM `#__users` WHERE id>0";
	$database->setQuery($query);
	$mmin = (int)$database->loadResult();
	$query = "SELECT min(fromid) FROM `#__uddeim` WHERE fromid>0";	// don't select public users
	$database->setQuery($query);
	$mmin1 = (int)$database->loadResult();
	$query = "SELECT min(toid) FROM `#__uddeim` WHERE toid>0";		// don't select public users
	$database->setQuery($query);
	$mmin2 = (int)$database->loadResult();

	$query = "SELECT max(id) FROM `#__users` WHERE id>0";
	$database->setQuery($query);
	$mmax = (int)$database->loadResult();
	$query = "SELECT max(fromid) FROM `#__uddeim` WHERE fromid>0";
	$database->setQuery($query);
	$mmax1 = (int)$database->loadResult();
	$query = "SELECT max(toid) FROM `#__uddeim` WHERE toid>0";
	$database->setQuery($query);
	$mmax2 = (int)$database->loadResult();

	$mmin = min($mmin,$mmin1,$mmin2);
	$mmax = max($mmax,$mmax1,$mmax2);

	for ($i=$mmin;$i<=$mmax;$i++) {

		$query = "SELECT count(id) FROM `#__users` WHERE id=".(int)$i;
		$database->setQuery($query);
		$value = (int)$database->loadResult();

		if ($value==0) {
			// the user does not exist, so count if there are still messages from or to him in the database
			$query = 'SELECT COUNT(id) FROM `#__uddeim` WHERE fromid='.(int)$i;
			$database->setQuery($query);
			$mvon = (int)$database->loadResult();

			$query = 'SELECT COUNT(id) FROM `#__uddeim` WHERE toid='.(int)$i;
			$database->setQuery($query);
			$man = (int)$database->loadResult();

			$query = 'SELECT COUNT(id) FROM `#__uddeim_emn` WHERE userid='.(int)$i;
			$database->setQuery($query);
			$memn = (int)$database->loadResult();

			$query = 'SELECT COUNT(id) FROM `#__uddeim_blocks` WHERE blocker='.(int)$i;
			$database->setQuery($query);
			$mbl1 = (int)$database->loadResult();

			$query = 'SELECT COUNT(id) FROM `#__uddeim_blocks` WHERE blocked='.(int)$i;
			$database->setQuery($query);
			$mbl2 = (int)$database->loadResult();

			if ($mvon>0 || $man>0 || $mbl1>0 || $memn>0 || $mbl2>0)
				echo "<b>#$i "._UDDEADM_MAINTENANCE_NOTFOUND." $mvon/$man/$memn/$mbl1/$mbl2</b><br />";

			if ($act!="trash" && ($mvon>0 || $man>0 || $memn>0 || $mbl1>0 || $mbl2>0)) {
				$jobtodo=1;
			}
			if ($act=="trash" && ($mvon>0 || $man>0 || $memn>0 || $mbl1>0 || $mbl2>0)) {
				echo _UDDEADM_MAINTENANCE_MT2." #$i<br />";
				$query = "DELETE FROM `#__uddeim_emn` WHERE userid=".(int)$i;
				$database->setQuery($query);
				$database->execute();	

				echo _UDDEADM_MAINTENANCE_MT3." #$i<br />";
				$query = "DELETE FROM `#__uddeim_blocks` WHERE blocker=".(int)$i." OR blocked=".(int)$i;
				$database->setQuery($query);
				$database->execute();	

				$trashoffset=((float)$config->TrashLifespan)*86400;
				$deletetime=uddetime($config->timezone)-$trashoffset-1;	// "-1" to ensure that pruning will delete the message

// when this is removed, deleted users are shown as "User deleted" in the outbox
				echo _UDDEADM_MAINTENANCE_MT4." #$i<br />";		// Recdipient does not longer exist, so delete from all outboxes and from non-existing users inbox
				// This following statement is ok, when also messages from purged users are listed in the Outbox, unfortunately they are not, so these messages are also purged.
				//              $query = "UPDATE `#__uddeim` SET totrash=1, totrashdate=".$deletetime." WHERE toid=".(int)$i;
				$query = "UPDATE `#__uddeim` SET totrashoutbox=1, totrashdateoutbox=".$deletetime.", totrash=1, totrashdate=".$deletetime." WHERE toid=".(int)$i;
				$database->setQuery($query);
				$database->execute();	

// when this is removed, deleted users are shown as "User deleted" in the inbox
				echo _UDDEADM_MAINTENANCE_MT5." #$i<br />";
				// This following statement is ok, when also messages from purged users are listed in the Inbox, unfortunately they are not, so these messages are also purged.
				//              $query = "UPDATE `#__uddeim` SET totrashoutbox=1, totrashdateoutbox=".$deletetime." WHERE fromid=".(int)$i;
				$query = "UPDATE `#__uddeim` SET totrashoutbox=1, totrashdateoutbox=".$deletetime.", totrash=1, totrashdate=".$deletetime." WHERE fromid=".(int)$i;
				$database->setQuery($query);
				$database->execute();	
			}
		} else {		// user exists, so display some stats only
			$query = 'SELECT COUNT(id) FROM `#__uddeim` WHERE totrashoutbox=0 AND fromid='.(int)$i;
			$database->setQuery($query);
			$mvonoutbox = (int)$database->loadResult();

			$query = 'SELECT COUNT(id) FROM `#__uddeim` WHERE totrashoutbox=1 AND fromid='.(int)$i;
			$database->setQuery($query);
			$mvonoutboxtrashed = (int)$database->loadResult();

			$query = 'SELECT COUNT(id) FROM `#__uddeim` WHERE totrash=0 AND toid='.(int)$i;
			$database->setQuery($query);
			$maninbox = (int)$database->loadResult();

			$query = 'SELECT COUNT(id) FROM `#__uddeim` WHERE totrash=1 AND toid='.(int)$i;
			$database->setQuery($query);
			$maninboxtrashed = (int)$database->loadResult();

			$query = "SELECT username FROM `#__users` WHERE id=".(int)$i;
			$database->setQuery($query);
			$username = $database->loadResult();

			if ($act=="check") {
				echo "#$i ($username): [$maninbox|$maninboxtrashed|$mvonoutbox|$mvonoutboxtrashed]<br />";
			}
		}
	}
	
	// step 2: search other problems
	$query = 'SELECT COUNT(id) FROM `#__uddeim` WHERE totrash=0 AND totrashdate IS NOT NULL';
	$database->setQuery($query);
	$datein = (int)$database->loadResult();

	$query = 'SELECT COUNT(id) FROM `#__uddeim` WHERE totrashoutbox=0 AND totrashdateoutbox IS NOT NULL';
	$database->setQuery($query);
	$dateout = (int)$database->loadResult();

	if ($act=="check") {
		echo "<br />";
		echo _UDDEADM_MAINTENANCE_D1."$datein/$dateout<br />";
		if ($datein>0 || $dateout>0)
			$jobtodo=1;
	}
	if ($act=="trash" && ($datein>0 || $dateout>0)) {
		$query = 'UPDATE `#__uddeim` SET totrashdate=NULL WHERE totrash=0 AND totrashdate IS NOT NULL';
		$database->setQuery($query);
		$ret=$database->execute();
		$query = 'UPDATE `#__uddeim` SET totrashdateoutbox=NULL WHERE totrashoutbox=0 AND totrashdateoutbox IS NOT NULL';
		$database->setQuery($query);
		$ret=$database->execute();
		echo "<br />";
		echo _UDDEADM_MAINTENANCE_D2."<br />";
	}

	// step 3: search orphaned files
	$query = "SELECT count(id) FROM `#__uddeim_attachments` WHERE mid=-1";
	$database->setQuery($query);
	$count = (int)$database->loadResult();
	if ($act=="check") {
		echo "<br />";
		echo _UDDEADM_MAINTENANCE_F1."$count<br />";

		if ($count>0)
			$jobtodo=1;
	}
	if ($act=="trash" && ($count>0)) {
		echo "<br />";
		echo _UDDEADM_MAINTENANCE_F2;
		uddeIMpreSaveAttachmentsRemove($config);
	}

	// now pune messages
	if ($act=="trash") {
		// now prune all messages and files
		uddeIMdoPrune($config);
		uddeIMdoFilePrune($config);
		
	}

	if ($act=="trash" && uddeIMcheckJversion()<=1) {
			$database = uddeIMgetDatabase();
			$database->setQuery( "UPDATE `#__components` SET admin_menu_img = '../components/com_uddeim/templates/images/uddeim-favicon.png' WHERE admin_menu_link = 'option=com_uddeim'" );
			$database->execute();
	}

	if ($act=="trash" && uddeIMcheckJversion()>=2) {
		$database = uddeIMgetDatabase();
		$database->setQuery( "UPDATE `#__menu` SET img = '../components/com_uddeim/templates/images/uddeim-favicon.png' WHERE link = 'index.php?option=com_uddeim'" );
		$database->execute();
	}

	if ($act=="check") {
		echo "<br />";
		if ($jobtodo==1) {
			echo _UDDEADM_MAINTENANCE_JOBTODO;
		} else {
			echo _UDDEADM_MAINTENANCE_NOTHINGTODO;
		}
	}
	echo "<p><b><a href=".uddeIMredirectIndex()."?option=com_uddeim>"._UDDEADM_CONTINUE."</a></b></p>";
}

function uddeIMmaintenanceCheckFix($option, $task, $act, $config) {
	$jobtodo=0;

	// Joomla 1.5 installer fix, this ensures that Joomla 1.5 finds the correct XML file and the extension manager does not claim incompatibility
	$mod1 = 0;
	$mod2 = 0;
	$mod3 = 0;
	$mod4 = 0;
	$mod5 = 0;
	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		$udd_moduleSubPath = uddeIMgetPath('absolute_path')."/modules/mod_uddeim_statistics/";
		if (file_exists($udd_moduleSubPath.'mod_uddeim_statistics.j15.xml'))
			if (file_exists($udd_moduleSubPath.'mod_uddeim_statistics.xml'))
				$mod1 = 1;
	}
	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		$udd_moduleSubPath = uddeIMgetPath('absolute_path')."/modules/mod_uddeim_mailbox/";
		if (file_exists($udd_moduleSubPath.'mod_uddeim_mailbox.j15.xml'))
			if (file_exists($udd_moduleSubPath.'mod_uddeim_mailbox.xml'))
				$mod2 = 1;
	}
	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		$udd_moduleSubPath = uddeIMgetPath('absolute_path')."/modules/mod_uddeim/";
		if (file_exists($udd_moduleSubPath.'mod_uddeim.j15.xml'))
			if (file_exists($udd_moduleSubPath.'mod_uddeim.xml'))
				$mod3 = 1;
	}
	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		$udd_moduleSubPath = uddeIMgetPath('absolute_path')."/plugins/content/";
		if (file_exists($udd_moduleSubPath.'uddeim_pms_contentlink.j15.xml'))
			if (file_exists($udd_moduleSubPath.'uddeim_pms_contentlink.xml'))
				$mod4 = 1;
	}
	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		$udd_moduleSubPath = uddeIMgetPath('absolute_path')."/plugins/search/";
		if (file_exists($udd_moduleSubPath.'uddeim.searchbot.j15.xml'))
			if (file_exists($udd_moduleSubPath.'uddeim.searchbot.xml'))
				$mod5 = 1;
	}
	if ($act=="check" && ($mod1 || $mod2 || $mod3 || $mod4 || $mod5) ) {
		echo "<br />";
		echo _UDDEADM_MAINTENANCE_XML1;
		echo _UDDEADM_MAINTENANCE_XML2;
		echo _UDDEADM_MAINTENANCE_XML3;
		echo _UDDEADM_MAINTENANCE_XML4;
		$jobtodo=1;
	}
	if ($act=="check" && !($mod1 || $mod2 || $mod3 || $mod4 || $mod5) ) {
		echo "<br />";
		echo _UDDEADM_MAINTENANCE_FXML2;
	}
	if ($act=="fix" && ($mod1 || $mod2 || $mod3 || $mod4 || $mod5) ) {
		echo "<br />";
		echo _UDDEADM_MAINTENANCE_FXML1;
	}
	if ($act=="fix" && !($mod1 || $mod2 || $mod3 || $mod4 || $mod5) ) {
		echo "<br />";
		echo _UDDEADM_MAINTENANCE_FXML2;
	}
	if ($mod1) echo "mod_uddeim_statistics<br />";
	if ($mod2) echo "mod_uddeim_mailbox<br />";
	if ($mod3) echo "mod_uddeim<br />";
	if ($mod4) echo "plug_uddeim_pms_contentlink<br />";
	if ($mod5) echo "plug_uddeim_pms_searchbot<br />";
	if ($act=="fix" && $mod1) {
		$udd_moduleSubPath = uddeIMgetPath('absolute_path')."/modules/mod_uddeim_statistics/";
		@chmod ($udd_moduleSubPath.'mod_uddeim_statistics.xml', 0766);
		@chmod ($udd_moduleSubPath.'mod_uddeim_statistics.j15.xml', 0766);
		$writeable1 = is_writable($udd_moduleSubPath.'mod_uddeim_statistics.xml');
		$writeable2 = is_writable($udd_moduleSubPath.'mod_uddeim_statistics.j15.xml');
		if ($writeable1 && $writeable2) {
			unlink($udd_moduleSubPath.'mod_uddeim_statistics.xml');
			rename($udd_moduleSubPath.'mod_uddeim_statistics.j15.xml',$udd_moduleSubPath.'mod_uddeim_statistics.xml');
		}
	}
	if ($act=="fix" && $mod2) {
		$udd_moduleSubPath = uddeIMgetPath('absolute_path')."/modules/mod_uddeim_mailbox/";
		@chmod ($udd_moduleSubPath.'mod_uddeim_mailbox.xml', 0766);
		@chmod ($udd_moduleSubPath.'mod_uddeim_mailbox.j15.xml', 0766);
		$writeable1 = is_writable($udd_moduleSubPath.'mod_uddeim_mailbox.xml');
		$writeable2 = is_writable($udd_moduleSubPath.'mod_uddeim_mailbox.j15.xml');
		if ($writeable1 && $writeable2) {
			unlink($udd_moduleSubPath.'mod_uddeim_mailbox.xml');
			rename($udd_moduleSubPath.'mod_uddeim_mailbox.j15.xml',$udd_moduleSubPath.'mod_uddeim_mailbox.xml');
		}
	}
	if ($act=="fix" && $mod3) {
		$udd_moduleSubPath = uddeIMgetPath('absolute_path')."/modules/mod_uddeim/";
		@chmod ($udd_moduleSubPath.'mod_uddeim.xml', 0766);
		@chmod ($udd_moduleSubPath.'mod_uddeim.j15.xml', 0766);
		$writeable1 = is_writable($udd_moduleSubPath.'mod_uddeim.xml');
		$writeable2 = is_writable($udd_moduleSubPath.'mod_uddeim.j15.xml');
		if ($writeable1 && $writeable2) {
			unlink($udd_moduleSubPath.'mod_uddeim.xml');
			rename($udd_moduleSubPath.'mod_uddeim.j15.xml',$udd_moduleSubPath.'mod_uddeim.xml');
		}
	}
	if ($act=="fix" && $mod4) {
		$udd_moduleSubPath = uddeIMgetPath('absolute_path')."/plugins/content/";
		@chmod ($udd_moduleSubPath.'uddeim_pms_contentlink.xml', 0766);
		@chmod ($udd_moduleSubPath.'uddeim_pms_contentlink.j15.xml', 0766);
		$writeable1 = is_writable($udd_moduleSubPath.'uddeim_pms_contentlink.xml');
		$writeable2 = is_writable($udd_moduleSubPath.'uddeim_pms_contentlink.j15.xml');
		if ($writeable1 && $writeable2) {
			unlink($udd_moduleSubPath.'uddeim_pms_contentlink.xml');
			rename($udd_moduleSubPath.'uddeim_pms_contentlink.j15.xml',$udd_moduleSubPath.'uddeim_pms_contentlink.xml');
		}
	}
	if ($act=="fix" && $mod5) {
		$udd_moduleSubPath = uddeIMgetPath('absolute_path')."/plugins/search/";
		@chmod ($udd_moduleSubPath.'uddeim.searchbot.xml', 0766);
		@chmod ($udd_moduleSubPath.'uddeim.searchbot.j15.xml', 0766);
		$writeable1 = is_writable($udd_moduleSubPath.'uddeim.searchbot.xml');
		$writeable2 = is_writable($udd_moduleSubPath.'uddeim.searchbot.j15.xml');
		if ($writeable1 && $writeable2) {
			unlink($udd_moduleSubPath.'uddeim.searchbot.xml');
			rename($udd_moduleSubPath.'uddeim.searchbot.j15.xml',$udd_moduleSubPath.'uddeim.searchbot.xml');
		}
	}

	if ($act=="check") {
		echo "<br />";
		if ($jobtodo==1) {
			echo _UDDEADM_MAINTENANCE_JOBTODO;
		} else {
			echo _UDDEADM_MAINTENANCE_NOTHINGTODO;
		}
	}
	echo "<p><b><a href=".uddeIMredirectIndex()."?option=com_uddeim>"._UDDEADM_CONTINUE."</a></b></p>";
}

function uddeIMmaintenancePrune($option, $task, $config) {
	uddeIMdoPrune($config);
	echo "<div style='text-align:left'>";
	echo "<p><b>"._UDDEADM_PRUNE_DONE."</b></p>";
	echo "<p><b><a href=".uddeIMredirectIndex()."?option=com_uddeim>"._UDDEADM_CONTINUE."</a></b></p></div>";
}

function uddeIMfileMaintenancePrune($option, $task, $config) {
	uddeIMdoFilePrune($config);
	echo "<div style='text-align:left'>";
	echo "<p><b>"._UDDEADM_FILEPRUNE_DONE."</b></p>";
	echo "<p><b><a href=".uddeIMredirectIndex()."?option=com_uddeim>"._UDDEADM_CONTINUE."</a></b></p></div>";
}

function uddeIMconvertConfiguration($option, $task, $pathtoadmin, $expectedversion, $config) {
	$database = uddeIMgetDatabase();
	echo "<p><span style='color: red;'>"._UDDEADM_CFGFILE_NOTFOUND."<br /><br />"._UDDEADM_CFGFILE_FOUND." ".$config->version."<br />"._UDDEADM_CFGFILE_EXPECTED." ".$expectedversion."</span></p>\n";
	echo "<p>"._UDDEADM_CFGFILE_CONVERTING."</p>";
	echo "<p>";

    if ($config->version<"2.6") {
		echo _UDDEADM_CFGFILE_CONVERTING_0."<br />";
	}
	if ($config->version=="2.6") {
		echo _UDDEADM_CFGFILE_CONVERTING_18."<br />";
        uddeIMsaveConfig($pathtoadmin, $config, $bak = '_2.6');
		$config->autocompleter = $config->autocompleter ?? 0;  //some config_2.6 may include autocompleter
        $config->autocompletestart = $config->autocompletestart ?? 1;           //and autocompletestart
        $config->saveconfigdb = 0;  //new setting to always backup config
        $config->version=="2.8";
        //uddeIMsaveConfig($pathtoadmin, $config);
        //uddeIMsaveSettings($option, $task, $pathtoadmin, $config)
        //uddeIMbackupRestoreConfig($option, $task, 'backup', $pathtoadmin, $config, true); //true means: "during save, no redirect"
	}

	echo "</p>";

	// do the converting here
	if (uddeIMsaveConfig($pathtoadmin, $config))
		echo "<p>"._UDDEADM_CFGFILE_DONE."</p>";

    clearstatcache(TRUE,$pathtoadmin."/config.class.php");
    if (function_exists('opcache_reset'))
    opcache_reset();

	echo "<p><b><a class='btn btn-success' href=".uddeIMredirectIndex()."?option=com_uddeim>"._UDDEADM_CONTINUE."</a></b></p>";
}

function uddeIMbackupRestoreConfig($option, $task, $act, $pathtoadmin, $config, $onsave = false) {
	$database = uddeIMgetDatabase();
	if ($act=="backup") {
		$backup = array();
		$backup['_backupdate']					= uddeLdate(uddetime($config->timezone), $config, uddeIMgetUserTZ());
		$backup['version'] 						= $config->version;
		$backup['cryptkey'] 					= $config->cryptkey;
		$backup['datumsformat'] 				= $config->datumsformat;
		$backup['ldatumsformat'] 				= $config->ldatumsformat;
		$backup['emn_sendermail'] 				= $config->emn_sendermail;
		$backup['emn_sendername'] 				= $config->emn_sendername;
		$backup['sysm_username'] 				= $config->sysm_username;
		$backup['charset'] 						= $config->charset;
		$backup['mailcharset'] 					= $config->mailcharset;
		$backup['emn_body_nomessage'] 			= $config->emn_body_nomessage;
		$backup['emn_body_withmessage'] 		= $config->emn_body_withmessage;
		$backup['emn_forgetmenot'] 				= $config->emn_forgetmenot;
		$backup['export_format'] 				= $config->export_format;
		$backup['showtitle'] 					= $config->showtitle;
		$backup['templatedir'] 					= $config->templatedir;
		$backup['quotedivider'] 				= $config->quotedivider;
		$backup['blockgroups'] 					= $config->blockgroups;
		$backup['pubblockgroups'] 				= $config->pubblockgroups;
		$backup['hideusers'] 					= $config->hideusers;
		$backup['pubhideusers'] 				= $config->pubhideusers;
		$backup['attachmentgroups'] 			= $config->attachmentgroups;
		$backup['recaptchaprv'] 				= $config->recaptchaprv;
		$backup['recaptchapub'] 				= $config->recaptchapub;
		$backup['allowedextensions'] 			= $config->allowedextensions;
		$backup['badwords'] 					= $config->badwords;
		$backup['gravatard'] 					= $config->gravatard;
		$backup['gravatarr'] 					= $config->gravatarr;
		$backup['groupsadmin'] 					= $config->groupsadmin;
		$backup['groupsspecial'] 				= $config->groupsspecial;

		$backup['ReadMessagesLifespan']			= $config->ReadMessagesLifespan;
		$backup['UnreadMessagesLifespan']		= $config->UnreadMessagesLifespan;
		$backup['SentMessagesLifespan'] 		= $config->SentMessagesLifespan;
		$backup['TrashLifespan'] 				= $config->TrashLifespan;
		$backup['ReadMessagesLifespanNote'] 	= $config->ReadMessagesLifespanNote;
		$backup['UnreadMessagesLifespanNote'] 	= $config->UnreadMessagesLifespanNote;
		$backup['SentMessagesLifespanNote'] 	= $config->SentMessagesLifespanNote;
		$backup['TrashLifespanNote'] 			= $config->TrashLifespanNote;
		$backup['adminignitiononly'] 			= $config->adminignitiononly;
		$backup['pmsimportdone'] 				= $config->pmsimportdone;
		$backup['blockalert'] 					= $config->blockalert;
		$backup['blocksystem'] 					= $config->blocksystem;
		$backup['allowemailnotify'] 			= $config->allowemailnotify;
		$backup['notifydefault'] 				= $config->notifydefault;
		$backup['popupdefault'] 				= $config->popupdefault;
		$backup['allowsysgm'] 					= $config->allowsysgm;
		$backup['emailwithmessage'] 			= $config->emailwithmessage;
		$backup['firstwordsinbox'] 				= $config->firstwordsinbox;
		$backup['longwaitingdays'] 				= $config->longwaitingdays;
		$backup['longwaitingemail'] 			= $config->longwaitingemail;
		$backup['maxlength'] 					= $config->maxlength;
		$backup['showcblink'] 					= $config->showcblink;
		$backup['showmenulink'] 				= $config->showmenulink;
		$backup['showcbpic'] 					= $config->showcbpic;
		$backup['showonline'] 					= $config->showonline;
		$backup['allowarchive']					= $config->allowarchive;
		$backup['maxarchive'] 					= $config->maxarchive;
		$backup['allowcopytome'] 				= $config->allowcopytome;
		$backup['trashoriginal'] 				= $config->trashoriginal;
		$backup['perpage'] 						= $config->perpage;
		$backup['enabledownload'] 				= $config->enabledownload;
		$backup['inboxlimit'] 					= $config->inboxlimit;
		$backup['showinboxlimit'] 				= $config->showinboxlimit;
		$backup['allowpopup'] 					= $config->allowpopup;
		$backup['allowbb'] 						= $config->allowbb;
		$backup['allowsmile'] 					= $config->allowsmile;
		$backup['animated'] 					= $config->animated;
		$backup['animatedex'] 					= $config->animatedex;
		$backup['showmenuicons'] 				= $config->showmenuicons;
		$backup['bottomlineicons'] 				= $config->bottomlineicons;
		$backup['actionicons'] 					= $config->actionicons;
		$backup['showconnex'] 					= $config->showconnex;
		$backup['showsettingslink'] 			= $config->showsettingslink;
		$backup['showabout'] 					= $config->showabout;
		$backup['emailtrafficenabled'] 			= $config->emailtrafficenabled;
		$backup['getpiclink'] 					= $config->getpiclink;
		$backup['connex_listbox'] 				= $config->connex_listbox;
		$backup['forgetmenotstart'] 			= $config->forgetmenotstart;
		$backup['realnames'] 					= $config->realnames;
		$backup['cryptmode'] 					= $config->cryptmode;
		$backup['modeshowallusers'] 			= $config->modeshowallusers;
		$backup['allowmultipleuser'] 			= $config->allowmultipleuser;
		$backup['connexallowmultipleuser'] 		= $config->connexallowmultipleuser;
		$backup['allowmultiplerecipients'] 		= $config->allowmultiplerecipients;
		$backup['showtextcounter'] 				= $config->showtextcounter;
		$backup['allowforwards'] 				= $config->allowforwards;
		$backup['showgroups'] 					= $config->showgroups;
		$backup['mailsystem'] 					= $config->mailsystem;
		$backup['searchinstring'] 				= $config->searchinstring;
		$backup['maxrecipients'] 				= $config->maxrecipients;
		$backup['languagecharset'] 				= $config->languagecharset;
		$backup['usecaptcha'] 					= $config->usecaptcha;
		$backup['captchalen'] 					= $config->captchalen;
		$backup['pubfrontend'] 					= $config->pubfrontend;
		$backup['pubfrontenddefault'] 			= $config->pubfrontenddefault;
		$backup['pubmodeshowallusers'] 			= $config->pubmodeshowallusers;
		$backup['hideallusers'] 				= $config->hideallusers;
		$backup['pubhideallusers'] 				= $config->pubhideallusers;
		$backup['unblockCBconnections'] 		= $config->unblockCBconnections;
		$backup['CBgallery'] 					= $config->CBgallery;
		$backup['enablelists'] 					= $config->enablelists;
		$backup['maxonlists'] 					= $config->maxonlists;
		$backup['timedelay'] 					= $config->timedelay;
		$backup['pubrealnames'] 				= $config->pubrealnames;
		$backup['pubreplies'] 					= $config->pubreplies;
		$backup['pubemail'] 					= $config->pubemail;
		$backup['csrfprotection'] 				= $config->csrfprotection;
		$backup['trashrestriction'] 			= $config->trashrestriction;
		$backup['replytruncate'] 				= $config->replytruncate;
		$backup['allowflagged'] 				= $config->allowflagged;
		$backup['overwriteitemid'] 				= $config->overwriteitemid;
		$backup['useitemid'] 					= $config->useitemid;
		$backup['timezone'] 					= $config->timezone;
		$backup['pubuseautocomplete'] 			= $config->pubuseautocomplete;
		$backup['pubsearchinstring'] 			= $config->pubsearchinstring;
        $backup['useautocomplete'] 				= $config->useautocomplete;
        $backup['autocompleter'] 				= $config->autocompleter;
        $backup['autocompletestart'] 		   	= $config->autocompletestart;
		$backup['autoresponder'] 				= $config->autoresponder;
		$backup['autoforward'] 					= $config->autoforward;
		$backup['rows'] 						= $config->rows;
		$backup['cols'] 						= $config->cols;
		$backup['width'] 						= $config->width;
		$backup['enablefilter'] 				= $config->enablefilter;
		$backup['enablereply'] 					= $config->enablereply;
		$backup['enablerss'] 					= $config->enablerss;
		$backup['showigoogle'] 					= $config->showigoogle;
		$backup['showhelp'] 					= $config->showhelp;
		$backup['separator'] 					= $config->separator;
		$backup['rsslimit'] 					= $config->rsslimit;
		$backup['restrictallusers'] 			= $config->restrictallusers;
		$backup['trashoriginalsent'] 			= $config->trashoriginalsent;
		$backup['reportspam'] 					= $config->reportspam;
		$backup['checkbanned'] 					= $config->checkbanned;
		$backup['enableattachment']				= $config->enableattachment;
		$backup['maxsizeattachment']			= $config->maxsizeattachment;
		$backup['maxattachments']				= $config->maxattachments;
		$backup['fileadminignitiononly'] 		= $config->fileadminignitiononly;
		$backup['showlistattachment'] 			= $config->showlistattachment;
		$backup['showmenucount'] 				= $config->showmenucount;
		$backup['encodeheader'] 				= $config->encodeheader;
		$backup['enablesort'] 					= $config->enablesort;
		$backup['captchatype'] 					= $config->captchatype;
		$backup['unprotectdownloads'] 			= $config->unprotectdownloads;
		$backup['waitdays'] 					= $config->waitdays;
		$backup['avatarw'] 						= $config->avatarw;
		$backup['avatarh'] 						= $config->avatarh;
		$backup['gravatar'] 					= $config->gravatar;
		$backup['addccline'] 					= $config->addccline;
		$backup['modnewusers'] 					= $config->modnewusers;
		$backup['modpubusers'] 					= $config->modpubusers;
		$backup['restrictcon'] 					= $config->restrictcon;
		$backup['restrictrem'] 					= $config->restrictrem;
		$backup['stime'] 						= $config->stime;
		$backup['dontsefmsglink'] 				= $config->dontsefmsglink;
		$backup['enablepostbox']				= $config->enablepostbox;
		$backup['postboxfull']					= $config->postboxfull;
		$backup['postboxavatars']				= $config->postboxavatars;
		$backup['replytext']					= $config->replytext;
        $backup['saveconfigdb']                 = $config->saveconfigdb;

		$query = 'TRUNCATE TABLE `#__uddeim_config`';
		$database->setQuery($query);
		$database->execute();
		foreach ($backup as $key => $value) {
			$query = 'INSERT INTO `#__uddeim_config` ( varname, value ) VALUES ( '.$database->Quote($key).', '.$database->Quote($value).' )';
			$database->setQuery($query);
			$database->execute();
		}

        if ($onsave)
        return true;

		echo "<div style='text-align:left'>";
		echo "<p><b>"._UDDEADM_BACKUP_DONE."</b></p>";
		echo "<p><b><a href=".uddeIMredirectIndex()."?option=com_uddeim>"._UDDEADM_CONTINUE."</a></b></p></div>";
    }
	elseif ($act=="restore") {
		$query = "SELECT varname, value FROM `#__uddeim_config`";
        $database->setQuery($query);
        $results = $database->loadObjectList();
		$database->execute();
        foreach ($results as $result) {
			if (substr($result->varname,0,1)!='_')
				$config->{$result->varname} = $result->value;
		}
		uddeIMsaveConfig($pathtoadmin, $config);
		echo "<div style='text-align:left'>";
		echo "<p><b>"._UDDEADM_RESTORE_DONE."</b></p>";
		echo "<p><b><a href=".uddeIMredirectIndex()."?option=com_uddeim>"._UDDEADM_CONTINUE."</a></b></p></div>";
	}
}

function uddeIMversioncheck($option, $task, $checkversion, $checkhotfix) {
    $current_version = explode('.', $checkversion);
    $current_major  = (int) $current_version[0];
    $current_minor  = (int) $current_version[1];
    $current_hotfix = (int) $checkhotfix;
	$live_site		= uddeIMgetPath("live_site");

	echo "<div style='text-align:left'>";
	echo "<p><b>"._UDDEADM_VERSIONCHECK."</b></p>";

	$premium = "";

	if (uddeIMcheckVersionPlugin('postbox'))
		$premium .= "1";
	else
		$premium .= "0";

	if (uddeIMcheckVersionPlugin('attachment'))
		$premium .= "1";
	else
		$premium .= "0";

	if (uddeIMcheckVersionPlugin('rss'))
		$premium .= "1";
	else
		$premium .= "0";

	if (uddeIMcheckVersionPlugin('pfrontend'))
		$premium .= "1";
	else
		$premium .= "0";

	if (uddeIMcheckVersionPlugin('spamcontrol'))
		$premium .= "1";
	else
		$premium .= "0";

	if (uddeIMcheckVersionPlugin('mcp'))
		$premium .= "1";
	else
		$premium .= "0";

	$admin = uddeIMgetMailFrom();
	$parm = "?ver=".$current_major.".".$current_minor."&hotfix=".$current_hotfix."&premium=".$premium."&admin=".urlencode($admin)."&site=".urlencode($live_site);
	$handle = @fopen("http://www.slabihoud.de/checkuddeimupdate.php".$parm, "rb");
	if ($handle) {
		$version_info = "";
		while (!feof($handle))
			$version_info .= @fread($handle, 8192);
		@fclose($handle);
        $version_info = explode("\n", $version_info);
		$latest_structure	= (int) $version_info[0];

		// This is for $latest_structure==1
        $latest_major		= (int) $version_info[1];
        $latest_minor 		= (int) $version_info[2];
        $latest_hotfix 		= (int) $version_info[3];
		$t1					= trim($version_info[4]);
		$l1					= trim($version_info[5]);
		$t2					= trim($version_info[6]);
		$l2					= trim($version_info[7]);
		$t3					= trim($version_info[8]);
		$l3					= trim($version_info[9]);
		$t4					= trim($version_info[10]);
		$l4					= trim($version_info[11]);
		$t5					= trim($version_info[12]);
		$l5					= trim($version_info[13]);
		$tfree				= trim($version_info[14]);
        $latest_info  		= trim($version_info[15]);
        $important  		= trim($version_info[16]);

        if (!$latest_info)	$latest_info = _UDDEADM_VERSIONCHECK_NONE;

		$cur_hotfixtext = "";
		if ($current_hotfix)
			$cur_hotfixtext = " "._UDDEADM_VERSIONCHECK_HOTFIX." ".$current_hotfix;
		$lat_hotfixtext = "";
		if ($latest_hotfix)
			$lat_hotfixtext = " "._UDDEADM_VERSIONCHECK_HOTFIX." ".$latest_hotfix;

		$latest  = 1000*$latest_major  + 10*$latest_minor  + $latest_hotfix;
		$current = 1000*$current_major + 10*$current_minor + $current_hotfix;
		if ($latest<=$current) {
			echo "<p style='color:green'>"._UDDEADM_VERSIONCHECK_USING." ".$checkversion.$cur_hotfixtext.".</p>";
			echo "<p style='color:green'>"._UDDEADM_VERSIONCHECK_LATEST."</p>";
			echo "<p>".$important."</p>";
		} else {
			echo "<p style='color:red'>"._UDDEADM_VERSIONCHECK_USING." ".$checkversion.$cur_hotfixtext.".</p>";
			echo "<p style='color:red'>"._UDDEADM_VERSIONCHECK_CURRENT." ".$latest_major.".".$latest_minor.$lat_hotfixtext.".</p>";
			echo "<p>"._UDDEADM_VERSIONCHECK_INFO."<br />".$latest_info."</p>";
			echo "<p>".$important."</p>";
		}
		
		if ($t1 || $t2 || $t3 || $t4 || $t5) {
			$bar = Array();
			for ($i=1; $i<=5; $i++) {
				$ttemp = "t{$i}";
				$ltemp = "l{$i}";
				if ($$ttemp) $bar[] = "<a href='".$$ltemp."' target='_new'>".$$ttemp."</a>";
			}
			echo "<p>"._UDDEADM_VERSIONCHECK_IMPORTANT."<br />";
			echo implode("&nbsp;|&nbsp;", $bar)."</p>";
		}
	} else {
   		echo "<b><span style='color: red;'>"._UDDEADM_VERSIONCHECK_ERROR." $configdatei</span></b>";
    }
	echo "<p><b><a href=".uddeIMredirectIndex()."?option=com_uddeim>"._UDDEADM_CONTINUE."</a></b></p>";
	echo "</div>";
}

function uddeIMshowstatistics($option, $task, $config) {
	$database = uddeIMgetDatabase();
	echo "<div style='text-align:left'>";
	echo "<p><b>"._UDDEADM_STATISTICS."</b></p>";

	echo "<table border='0'>";
	$query="SELECT count(id) FROM `#__uddeim`";
	$database->setQuery($query);
	$result=(int)$database->loadResult();
	echo "<tr><td>"._UDDEADM_MAINTENANCE_COUNT."</td><td>".$result."</td></tr>";

	$query="SELECT count(id) FROM `#__uddeim` WHERE totrash=1";
	$database->setQuery($query);
	$result=(int)$database->loadResult();
	echo "<tr><td>"._UDDEADM_MAINTENANCE_COUNT_RECIPIENT."</td><td>".$result."</td></tr>";

	$query="SELECT count(id) FROM `#__uddeim` WHERE totrashoutbox=1";
	$database->setQuery($query);
	$result=(int)$database->loadResult();
	echo "<tr><td>"._UDDEADM_MAINTENANCE_COUNT_SENDER."</td><td>".$result."</td></tr>";
	
	$query="SELECT count(id) FROM `#__uddeim` WHERE totrash=1 AND totrashoutbox=1";
	$database->setQuery($query);
	$result=(int)$database->loadResult();
	echo "<tr><td>"._UDDEADM_MAINTENANCE_COUNT_TRASH."</td><td>".$result."</td></tr>";

	$query="SELECT max(id) FROM `#__uddeim`";
	$database->setQuery($query);
	$result=(int)$database->loadResult();
	$max = $result;
	echo "<tr><td>"._UDDEADM_MAINTENANCE_ALLDAYS."</td><td>".$result."</td></tr>";
	
	$rightnow=uddetime((int)$config->timezone);
	$timeframe=$rightnow-(86400*7);
	$query="SELECT min(datum) FROM `#__uddeim` WHERE datum>=".(int)$timeframe;
	$database->setQuery($query);
	$result=(int)$database->loadResult();
	if (!$result) {
		$result = 0;
	} else {
		$query="SELECT min(id) FROM `#__uddeim` WHERE datum=".(int)$result." LIMIT 1";
		$database->setQuery($query);
		$result=(int)$database->loadResult();
		$result = $max - $result + 1;
	}
	echo "<tr><td>"._UDDEADM_MAINTENANCE_7DAYS."</td><td>".$result."</td></tr>";

	$rightnow=uddetime((int)$config->timezone);
	$timeframe=$rightnow-(86400*30);
	$query="SELECT min(datum) FROM `#__uddeim` WHERE datum>=".(int)$timeframe;
	$database->setQuery($query);
	$result=(int)$database->loadResult();
	if (!$result) {
		$result = 0;
	} else {
		$query="SELECT min(id) FROM `#__uddeim` WHERE datum=".(int)$result." LIMIT 1";
		$database->setQuery($query);
		$result=(int)$database->loadResult();
		$result = $max - $result + 1;
	}
	echo "<tr><td>"._UDDEADM_MAINTENANCE_30DAYS."</td><td>".$result."</td></tr>";

	$rightnow=uddetime((int)$config->timezone);
	$timeframe=$rightnow-(86400*365);
	$query="SELECT min(datum) FROM `#__uddeim` WHERE datum>=".(int)$timeframe;
	$database->setQuery($query);
	$result=(int)$database->loadResult();
	if (!$result) {
		$result = 0;
	} else {
		$query="SELECT min(id) FROM `#__uddeim` WHERE datum=".(int)$result." LIMIT 1";
		$database->setQuery($query);
		$result=(int)$database->loadResult();
		$result = $max - $result + 1;
	}
	echo "<tr><td>"._UDDEADM_MAINTENANCE_365DAYS."</td><td>".$result."</td></tr>";

	if ($config->enableattachment) {
		$query="SELECT COUNT(id) FROM `#__uddeim_attachments`";
		$database->setQuery($query);
		$result=(int)$database->loadResult();
		echo "<tr><td>"._UDDEADM_MAINTENANCE_COUNTFILES."</td><td>".$result."</td></tr>";

		$query="SELECT COUNT(DISTINCT fileid) FROM `#__uddeim_attachments`";
		$database->setQuery($query);
		$result=(int)$database->loadResult();
		echo "<tr><td>"._UDDEADM_MAINTENANCE_COUNTFILESDISTINCT."</td><td>".$result."</td></tr>";
	}

	echo "</table>";

	echo "<br />";
	$rightnow=uddetime($config->timezone);
	$sincewhen=$rightnow-($config->longwaitingdays*86400);
	$next = (int)$config->longwaitingdays*86400;
	$sql = "SELECT min(a.id) AS mid, a.toid, b.name, a.datum, c.remindersent FROM `#__uddeim` AS a, `#__users` AS b, `#__uddeim_emn` AS c "
		 . "WHERE a.toid=b.id AND a.toid=c.userid AND "
		 . "a.toread=0 AND a.totrash=0 AND b.block=0 AND "
		 . "a.datum<".$sincewhen." AND a.datum>".$config->forgetmenotstart." AND "
		 . "c.remindersent+".$next."<".$rightnow." "
		 . "GROUP BY a.toid";
	$database->setQuery($sql);
	$castaways=$database->loadObjectList();
	$text = sprintf(_UDDEADM_MAINTENANCE_HEAD1, $config->longwaitingdays);
	echo $text."<br />";
	echo "<table border='1' cellpadding='1' cellspacing='0'>";
	echo "<tr><th>"._UDDEADM_MAINTENANCE_NO."</th><th>"._UDDEADM_MAINTENANCE_USERID."</th><th>"._UDDEADM_MAINTENANCE_TONAME."</th><th>"._UDDEADM_MAINTENANCE_MID."</th><th>"._UDDEADM_MAINTENANCE_WRITTEN."</th><th>"._UDDEADM_MAINTENANCE_TIMER."</th></tr>";
	$loopcounter=1;
	foreach($castaways as $castaway) {
		echo "<tr><td>".$loopcounter."</td><td>".$castaway->toid."</td><td>".$castaway->name."</td><td>".$castaway->mid."</td><td>".uddeDate($castaway->datum, $config, uddeIMgetUserTZ())."</td><td>".uddeDate($castaway->remindersent, $config, uddeIMgetUserTZ())." / ".uddeDate($castaway->remindersent+$next, $config, uddeIMgetUserTZ())."</td></tr>";
		$loopcounter++;
	}
	echo "</table>";

	echo "<br />";
	$rightnow=uddetime($config->timezone)+7*86400;
	$sincewhen=$rightnow-($config->longwaitingdays*86400);
	$next = (int)$config->longwaitingdays*86400;
	$sql = "SELECT min(a.id) AS mid, a.toid, b.name, a.datum, c.remindersent FROM `#__uddeim` AS a, `#__users` AS b, `#__uddeim_emn` AS c "
		 . "WHERE a.toid=b.id AND a.toid=c.userid AND "
		 . "a.toread=0 AND a.totrash=0 AND b.block=0 AND "
		 . "a.datum<".$sincewhen." AND a.datum>".$config->forgetmenotstart." AND "
		 . "c.remindersent+".$next."<".$rightnow." "
		 . "GROUP BY a.toid";
	$database->setQuery($sql);
	$castaways=$database->loadObjectList();
	$text = sprintf(_UDDEADM_MAINTENANCE_HEAD2, 7);

	echo $text."<br />";
	echo "<table border='1' cellpadding='1' cellspacing='0'>";
	echo "<tr><th>"._UDDEADM_MAINTENANCE_NO."</th><th>"._UDDEADM_MAINTENANCE_USERID."</th><th>"._UDDEADM_MAINTENANCE_TONAME."</th><th>"._UDDEADM_MAINTENANCE_MID."</th><th>"._UDDEADM_MAINTENANCE_WRITTEN."</th><th>"._UDDEADM_MAINTENANCE_TIMER."</th></tr>";
	$loopcounter=1;
	foreach($castaways as $castaway) {
		echo "<tr><td>".$loopcounter."</td><td>".$castaway->toid."</td><td>".$castaway->name."</td><td>".$castaway->mid."</td><td>".uddeDate($castaway->datum, $config, uddeIMgetUserTZ())."</td><td>".uddeDate($castaway->remindersent, $config, uddeIMgetUserTZ())." / ".uddeDate($castaway->remindersent+$next, $config, uddeIMgetUserTZ())."</td></tr>";
		$loopcounter++;
	}
	echo "</table>";

	echo "<p><b><a href=".uddeIMredirectIndex()."?option=com_uddeim>"._UDDEADM_CONTINUE."</a></b></p>";
	echo "</div>";
}

function uddeIMcheckForValidDB($option, $task, $uddeimversion, $config) {
	$database = uddeIMgetDatabase();

	$sql = "SHOW FIELDS FROM `#__uddeim_userlists` LIKE 'global';";
	$database->setQuery($sql);
	$rows = $database->loadObjectList();
	if (!$rows)
		$rows = Array();
	$fields = Array();
	foreach ($rows as $row)
		$fields[]=$row->Field;
	if ( !in_array("global" , $fields) )
		return 0;	// it is 1.5 or below, since 1.6 has "global"

	$sql = "SHOW FIELDS FROM `#__uddeim_spam` LIKE 'mid';";
	$database->setQuery($sql);
	$rows = $database->loadObjectList();
	if (!$rows)
		$rows = Array();
	$fields = Array();
	foreach ($rows as $row)
		$fields[]=$row->Field;
	if ( !in_array("mid" , $fields) )
		return 0;	// it is 1.6 or below, since 1.7 has "mid"

	$sql = "SHOW FIELDS FROM `#__uddeim_emn` LIKE 'locked';";
	$database->setQuery($sql);
	$rows = $database->loadObjectList();
	if (!$rows)
		$rows = Array();
	$fields = Array();
	foreach ($rows as $row)
		$fields[]=$row->Field;
	if ( !in_array("locked" , $fields) )
		return 0;	// it is 1.6 or below, since 1.7 has "locked"

	$sql = "SHOW FIELDS FROM `#__uddeim_attachments` LIKE 'filename';";
	$database->setQuery($sql);
	$rows = $database->loadObjectList();
	if (!$rows)
		$rows = Array();
	$fields = Array();
	foreach ($rows as $row)
		$fields[]=$row->Field;
	if ( !in_array("filename" , $fields) )
		return 0;	// it is 1.7 or 1.8, since 1.9 has "attachments"

	$sql = "SHOW FIELDS FROM `#__uddeim` LIKE 'systemflag';";
	$database->setQuery($sql);
	$rows = $database->loadObjectList();
	if (!$rows)
		$rows = Array();
	$fields = Array();
	foreach ($rows as $row)
		$fields[]=$row->Field;
	if ( !in_array("systemflag" , $fields) )
		return 0;	// it is 1.9 or 2.0, since 2.1 has "systemflag"

	$sql = "SHOW FIELDS FROM `#__uddeim` LIKE 'delayed';";
	$database->setQuery($sql);
	$rows = $database->loadObjectList();
	if (!$rows)
		$rows = Array();
	$fields = Array();
	foreach ($rows as $row)
		$fields[]=$row->Field;
	if ( !in_array("delayed" , $fields) )
		return 0;	// it is 2.2, since 2.3 has "delayed"

	return 1;
}

function uddeIMintval($n) {
    return int_val($n);
}

function uddeIMfixImport($pmessage) {
	$pmessage=str_replace("<p>", "", $pmessage);
	$pmessage=str_replace("</p>", "\n\n", $pmessage);
	$pmessage=str_replace(array("<br />", "<br/>", "<br>"), "\n", $pmessage);
	$pmessage=str_replace(array("<hr />", "<hr/>", "<hr>"), str_repeat("-", 20)."\n", $pmessage);
	$pmessage=str_replace("<b>", "[b]", $pmessage);
	$pmessage=str_replace("</b>", "[/b]", $pmessage);
	$pmessage=str_replace("&nbsp;", " ", $pmessage);
	// add slashes (but strip them first to avoid double slashes if they have already been added)
	$pmessage=stripslashes($pmessage);
	$pmessage=addslashes($pmessage);
	$pmessage=strip_tags($pmessage);
	$pmessage=preg_replace("%\n(\s*\n)+%", "\n\n", $pmessage);
	return $pmessage;
}
