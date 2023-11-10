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

function uddeIMprintNoPlugin($cond) {
	if (!$cond) {
		echo '<br /><a href="http://www.slabihoud.de/uddeim_premium.htm" target="_new"><span style="color:#B08080">'._UDDEADM_NOPREMIUM.'</span></a>';
	}
}

function uddeIMcheckPMS() {
	$database = uddeIMgetDatabase();
	$prefix = uddeIMgetDBprefix();
	// check if another pms is still installed
	unset($tables);
	$ret = array();
//	$sql="SHOW TABLES";
//	$database->setQuery($sql);
//	$rows=$database->loadObjectList(); 
//	foreach ($rows as $row)
//		foreach ($row as $r)
//			$tables[]=$r;
	$tables = $database->getTableList();
	if (in_array($prefix."pms", $tables)) {
    	$ret[] = 1;		// myPMS II 2.x - Danial Taherzadeh
    	$ret[] = 2;		// myPMS Enhanced 2.x - Stefan Klingner
    	$ret[] = 9;		// myPMS OS 2.x - Danial Taherzadeh
    	$ret[] = 12;	// myPMS Enhanced 1.x - Stefan Klingner
	}
	if (in_array($prefix."jim", $tables)) {
    	$ret[] = 3;		// JIM 1.x - Laurent Belloeil
    	$ret[] = 11;	// JIM Reloaded 1.x - Edi Goetschel
	}
	if (in_array($prefix."abim_data", $tables))
		$ret[] = 4;		// Archaic Binary Private Messages 1.x - Wayne Smith
	if (in_array($prefix."jam", $tables))
    	$ret[] = 5;		// JAM - Joomla Advanced Message 1.x - Cas de Vroom
	if (in_array($prefix."mypms", $tables)) {
    	$ret[] = 6;		// Clexus 2.x - Clexus New Media
    	$ret[] = 10;	// myPMS Pro 1.x - Danial Taherzadeh
	}
	if (in_array($prefix."missus", $tables)) {
    	$ret[] = 7;		// Missus 1.x - Barbara Irene Meclazcke
	}
	if (in_array($prefix."primezilla_inbox", $tables))
    	$ret[] = 8;		// Primezilla 1.x - Achim Fischer
	if (in_array($prefix."community_msg_recepient", $tables))
    	$ret[] = 13;	// JomSocial 1.x - Azrul Rahim
	if (in_array($prefix."messaging", $tables))
    	$ret[] = 14;	// Messaging 1.x - Sander Kromwijk
	if (in_array($prefix."cdpuremessenger", $tables))
    	$ret[] = 15;	// CD Pure Messenger 1.x - Daniel Rataj
	return $ret;
}

function uddeIMnamePMS($pmsfound) {
	switch($pmsfound) {
		case  1: return "myPMS II 2.x - Danial Taherzadeh"; break;
		case  2: return "myPMS Enhanced 2.x - Stefan Klingner"; break;
		case  3: return "JIM 1.x - Laurent Belloeil"; break;
		case  4: return "Archaic Binary Private Messages 1.x - Wayne Smith"; break;
		case  5: return "JAM - Joomla Advanced Message 1.x - Cas de Vroom"; break;
		case  6: return "Clexus 2.x - Clexus New Media"; break;
		case  7: return "Missus 1.x - Barbara Irene Meclazcke (incl. Missus Revised 0.9b)"; break;
		case  8: return "Primezilla 1.x - Achim Fischer"; break;
		case  9: return "myPMS OS 2.x - Danial Taherzadeh"; break;
		case 10: return "myPMS Pro 1.x - Danial Taherzadeh"; break;
		case 11: return "JIM Reloaded 1.x - Edi Goetschel"; break;
		case 12: return "myPMS Enhanced 1.x - Stefan Klingner"; break;
		case 13: return "JomSocial 1.x - Azrul Rahim"; break;
		case 14: return "Messaging 1.x - Sander Kromwijk"; break;
		case 15: return "CD Pure Messenger 1.x - Daniel Rataj"; break;
	}
	return _UDDEADM_NONEORUNKNOWN;
}

function uddeIMcheckPMStype() {
	$database = uddeIMgetDatabase();
	$mypmstype = array();

	$tablefound = uddeIMcheckPMS();

	if ( in_array(1, $tablefound) || in_array(2, $tablefound) || in_array(9, $tablefound) || in_array(12, $tablefound) ) {	// _pms found
		$sql = "SHOW FIELDS FROM `#__pms`;";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows)
			$rows = Array();
		$fields = Array();
		foreach ($rows as $row)
			$fields[]=$row->Field;
//		$rows = $database->getTableFields(array("#__pms"));
//		$fields = $rows["#__pms"];
//		if ( array_key_exists("groupname"	, $fields) &&

		// check for myPMS II 2.x - Danial Taherzadeh
		if ( in_array("groupname"	, $fields) &&
			 in_array("username"	, $fields) &&
			 in_array("whofrom"		, $fields) &&
			!in_array("recip_id"	, $fields) &&
			!in_array("senderip_id"	, $fields) &&
			 in_array("time"		, $fields)      ) {
			$mypmstype[] = 1;
		}
		// check for myPMS Enhanced 1.x - Stefan Klinger
		if (!in_array("groupname"	, $fields) &&
			 in_array("username"	, $fields) &&
			 in_array("whofrom"		, $fields) &&
			!in_array("recip_id"	, $fields) &&
			!in_array("senderip_id"	, $fields) &&
			 in_array("time"		, $fields)      ) {
			$mypmstype[] = 12;
		}
		// check for myPMS Enhanced 2.x - Stefan Klingner
		if (!in_array("groupname"	, $fields) &&
			!in_array("username" 	, $fields) &&
			!in_array("whofrom"  	, $fields) &&
			 in_array("recip_id" 	, $fields) &&
			 in_array("sender_id"	, $fields) &&
			 in_array("time"     	, $fields)      ) {
			$mypmstype[] = 2;
		}
		// check for myPMS OS 2.x - Danial Taherzadeh
		if (!in_array("groupname"	, $fields) &&
			 in_array("username"	, $fields) &&
			 in_array("whofrom"		, $fields) &&
			!in_array("recip_id"	, $fields) &&
			!in_array("senderip_id"	, $fields) &&
			!in_array("time"		, $fields)      ) {
			$mypmstype[] = 9;
		}

	}
	
	if ( in_array(3, $tablefound) || in_array(11, $tablefound) ) {	// _jim found
		$sql = "SHOW FIELDS FROM `#__jim`;";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows)
			$rows = Array();
		$fields = Array();
		foreach ($rows as $row)
			$fields[]=$row->Field;

		// check for jim - Laurent Belloeil
		if (!in_array("inbox"		, $fields) &&
			 in_array("username"	, $fields) &&
			 in_array("whofrom"		, $fields) &&
			 in_array("outbox"		, $fields) &&
			 in_array("date"		, $fields) &&
			 in_array("readstate"	, $fields)      ) {
			$mypmstype[] = 3;
		}
		// check for jim reloaded - Edi Goetschel
		if ( in_array("inbox"		, $fields) &&
			 in_array("username"	, $fields) &&
			 in_array("whofrom"		, $fields) &&
			 in_array("outbox"		, $fields) &&
			 in_array("date"		, $fields) &&
			 in_array("readstate"	, $fields)      ) {
			$mypmstype[] = 11;
		}

	}
	
	if ( in_array(4, $tablefound) ) {	// _abim_data
		$sql = "SHOW FIELDS FROM `#__abim_data`;";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows)
			$rows = Array();
		$fields = Array();
		foreach ($rows as $row)
			$fields[]=$row->Field;
		// check for Archaic Binary Private Messages not required
		$mypmstype[] = 4;

	}
	
	if ( in_array(5, $tablefound) ) {	// _jam
		$sql = "SHOW FIELDS FROM `#__jam`;";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows)
			$rows = Array();
		$fields = Array();
		foreach ($rows as $row)
			$fields[]=$row->Field;
		// check for JAM not required
		$mypmstype[] = 5;

	}
	
	if ( in_array(6, $tablefound) || in_array(10, $tablefound) ) {	// _mypms 
		$sql = "SHOW FIELDS FROM `#__mypms`;";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows)
			$rows = Array();
		$fields = Array();
		foreach ($rows as $row)
			$fields[]=$row->Field;

		// check for Clexus 2.0
		if ( in_array("sent_id"		, $fields) &&
			 in_array("userid"		, $fields) &&
			 in_array("whofrom"		, $fields) &&
			 in_array("replyid"		, $fields) &&
			 in_array("pm_notify"	, $fields) &&
			 in_array("owner"		, $fields)      ) {
			$mypmstype[] = 6;
		}
		// check for myPMS Pro
		if ( in_array("sent_id"		, $fields) &&
			!in_array("userid"		, $fields) &&
			 in_array("whofrom"		, $fields) &&
			 in_array("replyid"		, $fields) &&
			!in_array("pm_notify"	, $fields) &&
			 in_array("owner"		, $fields)      ) {
			$mypmstype[] = 10;
		}
	}
	
	if ( in_array(7, $tablefound) ) {	// _missus
		$sql = "SHOW FIELDS FROM `#__missus`;";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows)
			$rows = Array();
		$fields = Array();
		foreach ($rows as $row)
			$fields[]=$row->Field;

		// check for Missus 1.x
		if ( in_array("senderid"	, $fields) &&
			 in_array("sendername"	, $fields) &&
			 in_array("datesended"	, $fields) &&
			 in_array("sdr_rstate"	, $fields) &&
			 in_array("broadcast"	, $fields) &&
			 in_array("message"		, $fields)      ) {
			$mypmstype[] = 7;

		} 
	}
	
	if ( in_array(8, $tablefound) ) {	// __primezilla_inbox
		$sql = "SHOW FIELDS FROM `#__primezilla_inbox`;";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows)
			$rows = Array();
		$fields = Array();
		foreach ($rows as $row)
			$fields[]=$row->Field;

		// check for Primezilla 1.0
		if ( in_array("userid"		, $fields) &&
			 in_array("userid_from"	, $fields) &&
			 in_array("msg_date"	, $fields) &&
			 in_array("message"		, $fields) &&
			 in_array("flag_read"	, $fields) &&
			 in_array("marker"		, $fields)      ) {
			$mypmstype[] = 8;
		}
	}

	if ( in_array(13, $tablefound) ) {	// __community_msg_recepient
		$sql = "SHOW FIELDS FROM `#__community_msg_recepient`;";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows)
			$rows = Array();
		$fields = Array();
		foreach ($rows as $row)
			$fields[]=$row->Field;

		// check for JomSocial 1.0
		if ( in_array("msg_id"		, $fields) &&
			 in_array("msg_parent"	, $fields) &&
			 in_array("msg_from"	, $fields) &&
			 in_array("to"			, $fields) &&
			 in_array("bcc"			, $fields) &&
			 in_array("is_read"		, $fields)      ) {
			$mypmstype[] = 13;
		}
	}

	if ( in_array(14, $tablefound) ) {	// __messaging
		$sql = "SHOW FIELDS FROM `#__messaging`;";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows)
			$rows = Array();
		$fields = Array();
		foreach ($rows as $row)
			$fields[]=$row->Field;

		// check for Messaging 1.5
		if ( in_array("idFrom"		, $fields) &&
			 in_array("idTo"		, $fields) &&
			 in_array("subject"		, $fields) &&
			 in_array("seen"		, $fields) &&
			 in_array("message"		, $fields) &&
			 in_array("date"		, $fields)      ) {
			$mypmstype[] = 14;
		}
	}

	if ( in_array(15, $tablefound) ) {	// __cdpuremessenger
		$sql = "SHOW FIELDS FROM `#__cdpuremessenger`;";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows)
			$rows = Array();
		$fields = Array();
		foreach ($rows as $row)
			$fields[]=$row->Field;

		// check for CD Pure Messenger 1.x
		if ( in_array("from_id"		, $fields) &&
			 in_array("to_id"		, $fields) &&
			 in_array("message"		, $fields) &&
			 in_array("from_created", $fields) &&
			 in_array("from_ip"		, $fields) &&
			 in_array("to_read"		, $fields)      ) {
			$mypmstype[] = 15;
		}
	}

	return $mypmstype;
}

function uddeIMcreateCFGstring($config) {
	$cf="<?php\n";
	$cf.="if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }\n";
	$cf.="if (defined('_uddeConfig')) {\n";
	$cf.=" return true;\n";
	$cf.="} else {\n";
	$cf.=" define('_uddeConfig', 1);\n";
	$cf.=" class uddeimconfigclass {\n";
	$cf.="  var \$version = '2.6';\n";		// this is the version number of the configuration file
	$cf.="  var \$cryptkey = '".$config->cryptkey."';\n";
	$cf.="  var \$datumsformat = '".$config->datumsformat."';\n";
	$cf.="  var \$ldatumsformat = '".$config->ldatumsformat."';\n";  
	$cf.="  var \$emn_sendermail = '".$config->emn_sendermail."';\n";   
	$cf.="  var \$emn_sendername = '".$config->emn_sendername."';\n";  
	$cf.="  var \$sysm_username = '".$config->sysm_username."';\n";
	$cf.="  var \$charset = '".uddeIMgetCharsetalias($config->charset)."';\n";
	$cf.="  var \$mailcharset = '".uddeIMgetCharsetalias($config->mailcharset)."';\n";
	$cf.="  var \$emn_body_nomessage = '".$config->emn_body_nomessage."';\n";
	$cf.="  var \$emn_body_withmessage = '".$config->emn_body_withmessage."';\n";
	$cf.="  var \$emn_forgetmenot = '".$config->emn_forgetmenot."';\n";
	$cf.="  var \$export_format = '".$config->export_format."';\n";
	$cf.="  var \$showtitle = '".addslashes($config->showtitle)."';\n";
	$cf.="  var \$templatedir = '".$config->templatedir."';\n";
	$cf.="  var \$quotedivider = '".$config->quotedivider."';\n";
	$cf.="  var \$blockgroups = '".$config->blockgroups."';\n";
	$cf.="  var \$pubblockgroups = '".$config->pubblockgroups."';\n";
	$cf.="  var \$hideusers = '".$config->hideusers."';\n";
	$cf.="  var \$pubhideusers = '".$config->pubhideusers."';\n";
	$cf.="  var \$attachmentgroups = '".$config->attachmentgroups."';\n";
	$cf.="  var \$recaptchaprv = '".$config->recaptchaprv."';\n";
	$cf.="  var \$recaptchapub = '".$config->recaptchapub."';\n";
	$cf.="  var \$allowedextensions = '".addslashes($config->allowedextensions)."';\n";
	$cf.="  var \$badwords = '".addslashes($config->badwords)."';\n";
	$cf.="  var \$gravatard = '".$config->gravatard."';\n";
	$cf.="  var \$gravatarr = '".$config->gravatarr."';\n";
	$cf.="  var \$groupsadmin = '".$config->groupsadmin."';\n";
	$cf.="  var \$groupsspecial = '".$config->groupsspecial."';\n";

	$cf.="  var \$ReadMessagesLifespan = ".(int)$config->ReadMessagesLifespan.";\n";
	$cf.="  var \$UnreadMessagesLifespan = ".(int)$config->UnreadMessagesLifespan.";\n";
	$cf.="  var \$SentMessagesLifespan = ".(int)$config->SentMessagesLifespan.";\n";
	$cf.="  var \$TrashLifespan = ".(float)$config->TrashLifespan.";\n";
	$cf.="  var \$ReadMessagesLifespanNote = ".(int)$config->ReadMessagesLifespanNote.";\n";
	$cf.="  var \$UnreadMessagesLifespanNote = ".(int)$config->UnreadMessagesLifespanNote.";\n";
	$cf.="  var \$SentMessagesLifespanNote = ".(int)$config->SentMessagesLifespanNote.";\n";
	$cf.="  var \$TrashLifespanNote = ".(int)$config->TrashLifespanNote.";\n";
	$cf.="  var \$adminignitiononly = ".(int)$config->adminignitiononly.";\n";
	$cf.="  var \$pmsimportdone = ".(int)$config->pmsimportdone.";\n";
	$cf.="  var \$blockalert = ".(int)$config->blockalert.";\n";
	$cf.="  var \$blocksystem = ".(int)$config->blocksystem.";\n";
	$cf.="  var \$allowemailnotify = ".(int)$config->allowemailnotify.";\n";
	$cf.="  var \$notifydefault = ".(int)$config->notifydefault.";\n";
	$cf.="  var \$popupdefault = ".(int)$config->popupdefault.";\n";
	$cf.="  var \$allowsysgm = ".(int)$config->allowsysgm.";\n";
	$cf.="  var \$emailwithmessage = ".(int)$config->emailwithmessage.";\n";
	$cf.="  var \$firstwordsinbox = ".(int)$config->firstwordsinbox.";\n";
	$cf.="  var \$longwaitingdays = ".(int)$config->longwaitingdays.";\n";
	$cf.="  var \$longwaitingemail = ".(int)$config->longwaitingemail.";\n";
	$cf.="  var \$maxlength = ".(int)$config->maxlength.";\n";
	$cf.="  var \$showcblink = ".(int)$config->showcblink.";\n";
	$cf.="  var \$showmenulink = ".(int)$config->showmenulink.";\n";
	$cf.="  var \$showcbpic = ".(int)$config->showcbpic.";\n";
	$cf.="  var \$showonline = ".(int)$config->showonline.";\n";
	$cf.="  var \$allowarchive = ".(int)$config->allowarchive.";\n";
	$cf.="  var \$maxarchive = ".(int)$config->maxarchive.";\n";
	$cf.="  var \$allowcopytome = ".(int)$config->allowcopytome.";\n";
	$cf.="  var \$trashoriginal = ".(int)$config->trashoriginal.";\n";
	$cf.="  var \$perpage = ".(int)$config->perpage.";\n"; 
	$cf.="  var \$enabledownload = ".(int)$config->enabledownload.";\n";
	$cf.="  var \$inboxlimit = ".(int)$config->inboxlimit.";\n";
	$cf.="  var \$showinboxlimit = ".(int)$config->showinboxlimit.";\n";
	$cf.="  var \$allowpopup = ".(int)$config->allowpopup.";\n";
	$cf.="  var \$allowbb = ".(int)$config->allowbb.";\n";
	$cf.="  var \$allowsmile = ".(int)$config->allowsmile.";\n";
	$cf.="  var \$animated = ".(int)$config->animated.";\n";
	$cf.="  var \$animatedex = ".(int)$config->animatedex.";\n";
	$cf.="  var \$showmenuicons = ".(int)$config->showmenuicons.";\n";
	$cf.="  var \$bottomlineicons = ".(int)$config->bottomlineicons.";\n";
	$cf.="  var \$actionicons = ".(int)$config->actionicons.";\n";
	$cf.="  var \$showconnex = ".(int)$config->showconnex.";\n";
	$cf.="  var \$showsettingslink = ".(int)$config->showsettingslink.";\n";
	$cf.="  var \$showabout = ".(int)$config->showabout.";\n";
	$cf.="  var \$emailtrafficenabled = ".(int)$config->emailtrafficenabled.";\n";
	$cf.="  var \$getpiclink = ".(int)$config->getpiclink.";\n";
	$cf.="  var \$connex_listbox = ".(int)$config->connex_listbox.";\n";
	$cf.="  var \$forgetmenotstart = ".(int)$config->forgetmenotstart.";\n";
	$cf.="  var \$realnames = ".(int)$config->realnames.";\n";
	$cf.="  var \$cryptmode = ".(int)$config->cryptmode.";\n";
	$cf.="  var \$modeshowallusers = ".(int)$config->modeshowallusers.";\n";
	$cf.="  var \$useautocomplete = ".(int)$config->useautocomplete.";\n";
	$cf.="  var \$allowmultipleuser = ".(int)$config->allowmultipleuser.";\n";
	$cf.="  var \$connexallowmultipleuser = ".(int)$config->connexallowmultipleuser.";\n";
	$cf.="  var \$allowmultiplerecipients = ".(int)$config->allowmultiplerecipients.";\n";
	$cf.="  var \$showtextcounter = ".(int)$config->showtextcounter.";\n";
	$cf.="  var \$allowforwards = ".(int)$config->allowforwards.";\n";
	$cf.="  var \$showgroups = ".(int)$config->showgroups.";\n";
	$cf.="  var \$mailsystem = ".(int)$config->mailsystem.";\n";
	$cf.="  var \$searchinstring = ".(int)$config->searchinstring.";\n";
	$cf.="  var \$maxrecipients = ".(int)$config->maxrecipients.";\n";
	$cf.="  var \$languagecharset = ".(int)$config->languagecharset.";\n";
	$cf.="  var \$usecaptcha = ".(int)$config->usecaptcha.";\n";
	$cf.="  var \$captchalen = ".(int)$config->captchalen.";\n";
	$cf.="  var \$pubfrontend = ".(int)$config->pubfrontend.";\n";
	$cf.="  var \$pubfrontenddefault = ".(int)$config->pubfrontenddefault.";\n";
	$cf.="  var \$pubmodeshowallusers = ".(int)$config->pubmodeshowallusers.";\n";
	$cf.="  var \$hideallusers = ".(int)$config->hideallusers.";\n";
	$cf.="  var \$pubhideallusers = ".(int)$config->pubhideallusers.";\n";
	$cf.="  var \$unblockCBconnections = ".(int)$config->unblockCBconnections.";\n";
	$cf.="  var \$CBgallery = ".(int)$config->CBgallery.";\n";
	$cf.="  var \$enablelists = ".(int)$config->enablelists.";\n";
	$cf.="  var \$maxonlists = ".(int)$config->maxonlists.";\n";
	$cf.="  var \$timedelay = ".(int)$config->timedelay.";\n";
	$cf.="  var \$pubrealnames = ".(int)$config->pubrealnames.";\n";
	$cf.="  var \$pubreplies = ".(int)$config->pubreplies.";\n";
	$cf.="  var \$pubemail = ".(int)$config->pubemail.";\n";
	$cf.="  var \$csrfprotection = ".(int)$config->csrfprotection.";\n";
	$cf.="  var \$trashrestriction = ".(int)$config->trashrestriction.";\n";
	$cf.="  var \$replytruncate = ".(int)$config->replytruncate.";\n";
	$cf.="  var \$allowflagged = ".(int)$config->allowflagged.";\n";
	$cf.="  var \$overwriteitemid = ".(int)$config->overwriteitemid.";\n";
	$cf.="  var \$useitemid = ".(int)$config->useitemid.";\n";
	$cf.="  var \$timezone = ".(float)$config->timezone.";\n";
	$cf.="  var \$pubuseautocomplete = ".(int)$config->pubuseautocomplete.";\n";
	$cf.="  var \$pubsearchinstring = ".(int)$config->pubsearchinstring.";\n";
	$cf.="  var \$mootools = ".(int)$config->mootools.";\n";
	$cf.="  var \$autoresponder = ".(int)$config->autoresponder.";\n";
	$cf.="  var \$autoforward = ".(int)$config->autoforward.";\n";
	$cf.="  var \$rows = ".(int)$config->rows.";\n";
	$cf.="  var \$cols = ".(int)$config->cols.";\n";
	$cf.="  var \$width = ".(int)$config->width.";\n";
	$cf.="  var \$enablefilter = ".(int)$config->enablefilter.";\n";
	$cf.="  var \$enablereply = ".(int)$config->enablereply.";\n";
	$cf.="  var \$enablerss = ".(int)$config->enablerss.";\n";
	$cf.="  var \$showigoogle = ".(int)$config->showigoogle.";\n";
	$cf.="  var \$showhelp = ".(int)$config->showhelp.";\n";
	$cf.="  var \$separator = ".(int)$config->separator.";\n";
	$cf.="  var \$rsslimit = ".(int)$config->rsslimit.";\n";
	$cf.="  var \$restrictallusers = ".(int)$config->restrictallusers.";\n";
	$cf.="  var \$trashoriginalsent = ".(int)$config->trashoriginalsent.";\n";
	$cf.="  var \$reportspam = ".(int)$config->reportspam.";\n";
	$cf.="  var \$checkbanned = ".(int)$config->checkbanned.";\n";
	$cf.="  var \$enableattachment = ".(int)$config->enableattachment.";\n";
	$cf.="  var \$maxsizeattachment = ".(int)$config->maxsizeattachment.";\n";
	$cf.="  var \$maxattachments = ".(int)$config->maxattachments.";\n";
	$cf.="  var \$fileadminignitiononly = ".(int)$config->fileadminignitiononly.";\n";
	$cf.="  var \$showlistattachment = ".(int)$config->showlistattachment.";\n";
	$cf.="  var \$showmenucount = ".(int)$config->showmenucount.";\n";
	$cf.="  var \$encodeheader = ".(int)$config->encodeheader.";\n";
	$cf.="  var \$enablesort = ".(int)$config->enablesort.";\n";
	$cf.="  var \$captchatype = ".(int)$config->captchatype.";\n";
	$cf.="  var \$unprotectdownloads = ".(int)$config->unprotectdownloads.";\n";
	$cf.="  var \$waitdays = ".(float)$config->waitdays.";\n";
	$cf.="  var \$avatarw = ".(int)$config->avatarw.";\n";
	$cf.="  var \$avatarh = ".(int)$config->avatarh.";\n";
	$cf.="  var \$gravatar = ".(int)$config->gravatar.";\n";
	$cf.="  var \$addccline = ".(int)$config->addccline.";\n";
	$cf.="  var \$modnewusers = ".(int)$config->modnewusers.";\n";
	$cf.="  var \$modpubusers = ".(int)$config->modpubusers.";\n";
	$cf.="  var \$restrictcon = ".(int)$config->restrictcon.";\n";
	$cf.="  var \$restrictrem = ".(int)$config->restrictrem.";\n";
	$cf.="  var \$stime = ".(int)$config->stime.";\n";
	$cf.="  var \$dontsefmsglink = ".(int)$config->dontsefmsglink.";\n";
	$cf.="  var \$enablepostbox = ".(int)$config->enablepostbox.";\n";
	$cf.="  var \$postboxfull = ".(int)$config->postboxfull.";\n";
	$cf.="  var \$postboxavatars = ".(int)$config->postboxavatars.";\n";
	$cf.="  var \$replytext = ".(int)$config->replytext.";\n";
	$cf.="  // temporary variables\n";
	$cf.="  var \$flags = 0;\n";
	$cf.="  var \$userid = 0;\n";
	$cf.="  var \$usergid = Array();\n";
	$cf.="  var \$cbitemid = 0;\n";
	$cf.=" }\n";
	$cf.="}\n";
	return $cf;
}

function uddeIMsaveConfig($pathtoadmin, $config) {
	$cf = uddeIMcreateCFGstring($config);

	$configdatei = "/administrator/components/com_uddeim/config.class.php";

	// uddeIMchmod($configdatei, "766");		// BUGBUG: Joomla send CHMOD instead of SITE CHMOD
	if (!uddeIMwriteFile($configdatei, $cf)) {
		echo "<b><span style='color: red;'>"._UDDEADM_CFGFILE_WRITEFAILED." $configdatei</span></b>";
		return 0;
	}
	return 1;
}

function uddeIMquotecode($astring) {
	$astring=str_replace('\"', '', $astring);
	$astring=str_replace('\\\\', '\\', $astring);	
	$astring=str_replace('"', '', $astring);		
	return $astring;
}

function uddeIMquotestrip($astring) {
	$astring=str_replace("\"", "", $astring);
	$astring=str_replace("'", "", $astring);	
	$astring=str_replace("\\", "", $astring);	
	return $astring;
}
