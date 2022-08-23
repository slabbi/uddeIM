<?php
// ********************************************************************************************
// Title          Module to show mailbox status in udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2008 Stephan Slabihoud
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

$uddeim_isadmin = 0;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib.php');
}

$uddpathtoadmin = uddeIMgetPath('admin');
$uddpathtouser  = uddeIMgetPath('user');
$uddpathtosite  = uddeIMgetPath('live_site');
$udddatabase 	= uddeIMgetDatabase();
$uddmosConfig_lang = uddeIMgetLang();

require_once($uddpathtoadmin."/admin.shared.php");		// before includes.php is included!
require_once($uddpathtouser.'/includes.php');
require_once($uddpathtouser.'/includes.db.php');
require_once($uddpathtouser.'/crypt.class.php');
require_once($uddpathtoadmin."/config.class.php");		// get the configuration file
$uddconfig = new uddeimconfigclass();

if(!defined('_UDDEIM_INBOX')) {
	uddeIMloadLanguage($uddpathtoadmin, $uddconfig);
}

$uddshownew		= $params->get( 'uddshownew', 1 );
$uddshowinbox	= $params->get( 'uddshowinbox', 1 );
$uddshowoutbox	= $params->get( 'uddshowoutbox', 1 );
$uddshowtrashcan= $params->get( 'uddshowtrashcan', 1 );
$uddshowarchive	= $params->get( 'uddshowarchive', 1 );
$uddshowcontacts= $params->get( 'uddshowcontacts', 1 );
$uddshowsettings= $params->get( 'uddshowsettings', 1 );
$uddshowcompose	= $params->get( 'uddshowcompose', 1 );
$uddshowicons	= $params->get( 'uddshowicons', 0 );

if ( defined( 'JPATH_ADMINISTRATOR' ) ) {	// this works in Joomla 1.5+
	if (file_exists($uddpathtouser.'/templates/'.$uddconfig->templatedir.'/css/uddemodule.css')) {
		$css = $uddpathtosite."/components/com_uddeim/templates/".$uddconfig->templatedir."/css/uddemodule.css"; 
		uddeIMaddCSS($css);
	} elseif(file_exists($uddpathtouser.'/templates/default/css/uddemodule.css')) {
		$css = $uddpathtosite."/components/com_uddeim/templates/default/css/uddemodule.css"; 
		uddeIMaddCSS($css);
	}
} else {
	if (file_exists($uddpathtouser.'/templates/'.$uddconfig->templatedir.'/css/uddemodule.css')) {
		echo '<link rel="stylesheet" href="'.$uddpathtosite.'/components/com_uddeim/templates/'.$uddconfig->templatedir.'/css/uddemodule.css" type="text/css" />';
	} elseif(file_exists($uddpathtouser.'/templates/default/css/uddemodule.css')) {
		echo '<link rel="stylesheet" href="'.$uddpathtosite.'/components/com_uddeim/templates/default/css/uddemodule.css" type="text/css" />';
	}
}

$udduserid    = uddeIMgetUserID();
$uddmygroupid = uddeIMgetGroupID();

if (!$udduserid) {
	echo "<div id='uddeim-module'>";
	echo "<p class='uddeim-module-head'>"._UDDEIM_NOTLOGGEDIN."</p>";
	echo "</div>";
	return;
}

$uddmy_gid = uddeIMgetGID((int)$udduserid);	// ARRAY(!))

// first try to find a published link
$udditem_id = uddeIMgetItemid($uddconfig);

$uddout = "<div id='uddeim-module'>";

if ( $uddshownew ) {
	$uddsql="SELECT count(a.id) FROM `#__uddeim` AS a WHERE `a`.`delayed`=0 AND a.totrash=0 AND a.toread=0 AND a.toid=".(int)$udduserid;
//	$uddsql="SELECT count(a.id) FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.totrash=0 AND a.toread=0 AND a.toid=".(int)$udduserid;
	$udddatabase->setQuery($uddsql);
	$uddresult=(int)$udddatabase->loadResult();
	if ($uddresult>0) {
		$uddout .= "<p class='uddeim-module-head'>";
		$uddout .= _UDDEMODULE_NEWMESSAGES." ".$uddresult;
		$uddout .= "</p>";
	}
}

if ( $uddshowinbox ) {
	$uddsql="SELECT count(a.id) FROM `#__uddeim` AS a WHERE `a`.`delayed`=0 AND a.totrash=0 AND archived=0 AND a.toid=".(int)$udduserid;
//	$uddsql="SELECT count(a.id) FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.totrash=0 AND archived=0 AND a.toid=".(int)$udduserid;
	$udddatabase->setQuery($uddsql);
	$uddresult=(int)$udddatabase->loadResult();

	$uddout .= "<p class='uddeim-module-body'>";
	if($uddshowicons)
		$uddout .= "<img src='".$uddpathtosite."/components/com_uddeim/templates/".$uddconfig->templatedir."/images/menu_inbox.gif' alt='"._UDDEIM_INBOX."' /> ";
	$uddout .= '<a href="'.uddeIMsefRelToAbs( "index.php?option=com_uddeim&task=inbox".($udditem_id ? "&Itemid=".$udditem_id : "") ).'" title="'._UDDEIM_INBOX.'">';
	$uddout .= _UDDEIM_INBOX.": ".$uddresult;
	$uddout .= '</a>';
	$uddout .= "</p>";
}

if ( $uddshowoutbox ) {
	$uddsql="SELECT count(a.id) FROM `#__uddeim` AS a WHERE a.totrashoutbox=0 AND ((a.systemmessage IS NULL) OR (a.systemmessage='')) AND a.fromid=".(int)$udduserid;
//	$uddsql="SELECT count(a.id) FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.toid=b.id WHERE a.totrashoutbox=0 AND ((a.systemmessage IS NULL) OR (a.systemmessage='')) AND a.fromid=".(int)$udduserid;
	$udddatabase->setQuery($uddsql);
	$uddresult=(int)$udddatabase->loadResult();

	$uddout .= "<p class='uddeim-module-body'>";
	if($uddshowicons)
		$uddout .= "<img src='".$uddpathtosite."/components/com_uddeim/templates/".$uddconfig->templatedir."/images/menu_outbox.gif' alt='"._UDDEIM_OUTBOX."' /> ";
	$uddout .= '<a href="'.uddeIMsefRelToAbs( "index.php?option=com_uddeim&task=outbox".($udditem_id ? "&Itemid=".$udditem_id : "") ).'" title="'._UDDEIM_OUTBOX.'">';
	$uddout .= _UDDEIM_OUTBOX.": ".$uddresult;
	$uddout .= '</a>';
	$uddout .= "</p>";
}

if ( $uddshowtrashcan ) {
	$uddrightnow=uddetime((int)$uddconfig->timezone);
	$uddoffset=((float)$uddconfig->TrashLifespan) * 86400;
	$uddtimeframe=$uddrightnow-$uddoffset;

	$uddsql="SELECT count(id) FROM `#__uddeim` WHERE (totrashdate>=".$uddtimeframe." AND toid=".(int)$udduserid." AND totrash=1) OR (totrashdateoutbox>=".$uddtimeframe." AND fromid=".(int)$udduserid." AND totrashoutbox=1 AND toid<>".(int)$udduserid." AND ((systemmessage IS NULL) OR (systemmessage='')))";
//	$uddsql="SELECT count(id) FROM `#__uddeim` WHERE (totrashdate>=".$uddtimeframe." AND toid=".(int)$udduserid." AND totrash=1) OR (totrashdateoutbox>=".$uddtimeframe." AND fromid=".(int)$udduserid." AND totrashoutbox=1 AND toid<>fromid AND ((systemmessage IS NULL) OR (systemmessage='')))";
	$udddatabase->setQuery($uddsql);
	$uddresult=(int)$udddatabase->loadResult();

	$uddout .= "<p class='uddeim-module-body'>";
	if($uddshowicons)
		$uddout .= "<img src='".$uddpathtosite."/components/com_uddeim/templates/".$uddconfig->templatedir."/images/menu_trashcan.gif' alt='"._UDDEIM_TRASHCAN."' /> ";
	$uddout .= '<a href="'.uddeIMsefRelToAbs( "index.php?option=com_uddeim&task=trashcan".($udditem_id ? "&Itemid=".$udditem_id : "") ).'" title="'._UDDEIM_TRASHCAN.'">';
	$uddout .= _UDDEIM_TRASHCAN.": ".$uddresult;
	$uddout .= '</a>';
	$uddout .= "</p>";
}

if ( $uddshowarchive && $uddconfig->allowarchive) {
	$uddsql="SELECT count(a.id) FROM `#__uddeim` AS a WHERE a.totrash=0 AND archived=1 AND a.toid=".(int)$udduserid;
//	$uddsql="SELECT count(a.id) FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.totrash=0 AND archived=1 AND a.toid=".(int)$udduserid;
	$udddatabase->setQuery($uddsql);
	$uddresult=(int)$udddatabase->loadResult();

	$uddout .= "<p class='uddeim-module-body'>";
	if($uddshowicons)
		$uddout .= "<img src='".$uddpathtosite."/components/com_uddeim/templates/".$uddconfig->templatedir."/images/menu_archive.gif' alt='"._UDDEIM_ARCHIVE."' /> ";
	$uddout .= '<a href="'.uddeIMsefRelToAbs( "index.php?option=com_uddeim&task=archive".($udditem_id ? "&Itemid=".$udditem_id : "") ).'" title="'._UDDEIM_ARCHIVE.'">';
	$uddout .= _UDDEIM_ARCHIVE.": ".$uddresult;
	$uddout .= '</a>';
	$uddout .= "</p>";
}

if( ($uddconfig->enablelists==1) ||
	($uddconfig->enablelists==2 && (uddeIMisSpecial($uddmy_gid) || uddeIMisSpecial2($uddmy_gid, $config))) || 
	($uddconfig->enablelists==3 && (uddeIMisAdmin($uddmy_gid) || uddeIMisAdmin2($uddmy_gid, $config))) ) {
	// ok contact lists are enabled
	if ( $uddshowcontacts ) {
		$uddout .= "<p class='uddeim-module-body'>";
		if($uddshowicons)
			$uddout .= "<img src='".$uddpathtosite."/components/com_uddeim/templates/".$uddconfig->templatedir."/images/menu_book.gif' alt='"._UDDEIM_LISTS."' /> ";
		$uddout .= '<a href="'.uddeIMsefRelToAbs( "index.php?option=com_uddeim&task=showlists".($udditem_id ? "&Itemid=".$udditem_id : "") ).'" title="'._UDDEIM_LISTS.'">';
		$uddout .= _UDDEIM_LISTS;
		$uddout .= '</a>';
		$uddout .= "</p>";
	}
}

if ( $uddshowsettings ) {
	$uddout .= "<p class='uddeim-module-body'>";
	if($uddshowicons)
		$uddout .= "<img src='".$uddpathtosite."/components/com_uddeim/templates/".$uddconfig->templatedir."/images/menu_settings.gif' alt='"._UDDEIM_SETTINGS."' /> ";
	$uddout .= '<a href="'.uddeIMsefRelToAbs( "index.php?option=com_uddeim&task=settings".($udditem_id ? "&Itemid=".$udditem_id : "") ).'" title="'._UDDEIM_SETTINGS.'">';
	$uddout .= _UDDEIM_SETTINGS;
	$uddout .= '</a>';
	$uddout .= "</p>";
}

if ( $uddshowcompose ) {
	$uddout .= "<p class='uddeim-module-body'>";
	if($uddshowicons)
		$uddout .= "<img src='".$uddpathtosite."/components/com_uddeim/templates/".$uddconfig->templatedir."/images/menu_new.gif' alt='"._UDDEIM_COMPOSE."' /> ";
	$uddout .= '<a href="'.uddeIMsefRelToAbs( "index.php?option=com_uddeim&task=new".($udditem_id ? "&Itemid=".$udditem_id : "") ).'" title="'._UDDEIM_COMPOSE.'">';
	$uddout .= _UDDEIM_COMPOSE;
	$uddout .= '</a>';
	$uddout .= "</p>";
}

$uddout .= "</div>";

echo $uddout;

//function moduddemailboxtime($uddtimezone = 0) {
//	$uddmosConfig_offset = uddeIMgetOffset();
//	$uddrightnow=time()+(($uddmosConfig_offset+$uddtimezone)*3600);
//	return $uddrightnow;
//}
