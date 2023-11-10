<?php
// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2010 Stephan Slabihoud, © 2006 Benjamin Zweifel
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib.php');
	require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib.php');
	require_once($mainframe->getCfg('absolute_path').'/administrator/components/com_uddeim/admin.uddeimlib.php');
}
require_once(uddeIMgetPath('absolute_path').'/administrator/components/com_uddeim/admin.shared.php');

if (uddeIMcheckJversion()>=4) {	// Joomla >=2.5
	// Options button. -> Action: "Configure"
	if (JFactory::getUser()->authorise('core.admin', 'com_uddeim')) {
		JToolBarHelper::preferences('com_uddeim');
	}
}

// $act = uddeIMmosGetParam( $_REQUEST, 'act', '' );
$index = uddeIMredirectIndex();

switch ($task) {
	case "mcp":
		mosMenuBar::startTable();
		mosMenuBar::addNew('messagedeliver', _UDDEIM_TOOLBAR_DELIVERMESSAGE);				// Deliver message
		mosMenuBar::deleteList('', 'messageremove', _UDDEIM_TOOLBAR_REMOVEMESSAGE);			// Delete Message
		mosMenuBar::back(_UDDEIM_TOOLBAR_BACK, $index."?option=$option&task=settings");
		mosMenuBar::spacer();
		mosMenuBar::endTable();
		break;
	case "spamcontrol":
		mosMenuBar::startTable();
		mosMenuBar::deleteList('', 'reportremove', _UDDEIM_TOOLBAR_REMOVEREPORT);			// Remove Report
		mosMenuBar::deleteList('', 'spamremove', _UDDEIM_TOOLBAR_REMOVESPAM);				// Delete Message
		mosMenuBar::back(_UDDEIM_TOOLBAR_BACK, $index."?option=$option&task=settings");
		mosMenuBar::spacer();
		mosMenuBar::endTable();
		break;
	case "usersettings":
		mosMenuBar::startTable();
		mosMenuBar::addNew('usersettingsnew', _UDDEIM_TOOLBAR_CREATESETTINGS);				// new
		mosMenuBar::deleteList('', 'usersettingsremove', _UDDEIM_TOOLBAR_REMOVESETTINGS);	// remove
		mosMenuBar::deleteList('', 'usermessagesremove', _UDDEIM_TOOLBAR_TRASHMSGS);		// trash messages
		mosMenuBar::back(_UDDEIM_TOOLBAR_BACK, $index."?option=$option&task=settings");
		mosMenuBar::spacer();
		mosMenuBar::endTable();
		break;
	case "usermessagesremove":
	case "convertconfig":
	case "importpms":
	case "archivetotrash":
	case "maintenance":
	case "maintenancefix":
	case "maintenanceprune":
	case "filemaintenanceprune":
	case "versioncheck":
	case "backuprestore":
	case "showstatistics":
		mosMenuBar::startTable();
		mosMenuBar::back(_UDDEIM_TOOLBAR_BACK, $index."?option=$option&task=settings");
		mosMenuBar::spacer();
		mosMenuBar::endTable();
		break;
//		mosMenuBar::startTable();
//		mosMenuBar::customX( 'usersettings', '../components/com_uddeim/images/user.png', '../components/com_uddeim/images/user.png', 'User settings', false );
//		mosMenuBar::customX( 'usersettings', 'user.png', 'user.png', 'User settings', false );
//		mosMenuBar::customX( 'usersettings', 'edit.png', 'edit_f2.png', 'User settings', false );
//		mosMenuBar::save( 'savesettings', 'Save' );
//		mosMenuBar::cancel();
//		mosMenuBar::spacer();
//		mosMenuBar::endTable();
//		break;
	case "savesettings":
	case "cancel":
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
		break;
	case "editautoresponder":
		mosMenuBar::startTable();
		mosMenuBar::save( 'saveautoresponder', _UDDEIM_TOOLBAR_SAVE );
		mosMenuBar::back("Back", $index."?option=$option&task=usersettings");
		mosMenuBar::spacer();
		mosMenuBar::endTable();
		break;
	case "editautoforward":
		mosMenuBar::startTable();
		mosMenuBar::save( 'saveautoforward', _UDDEIM_TOOLBAR_SAVE );
		mosMenuBar::back("Back", $index."?option=$option&task=usersettings");
		mosMenuBar::spacer();
		mosMenuBar::endTable();
		break;
	case "settings":
	default:
		if (strncasecmp($ver->RELEASE, "3.0", 3)) {		// if NOT Version 3.0 which had a bug
//		if ($xver<3) {
			mosMenuBar::startTable();
	//		mosMenuBar::customX( 'usersettings', '../components/com_uddeim/images/user.png', '../components/com_uddeim/images/user.png', 'User settings', false );
	//		mosMenuBar::customX( 'usersettings', 'user.png', 'user.png', 'User settings', false );
	//		mosMenuBar::customX( 'backuprestore', 'archive.png', 'archive_f2.png', 'Backup &amp; Restore', false );
			if (uddeIMcheckPlugin('mcp'))
				if (uddeIMcheckVersionPlugin('mcp'))
					mosMenuBar::customX( 'mcp', 'edit.png', 'edit_f2.png', _UDDEIM_TOOLBAR_MCP, false );
			if (uddeIMcheckPlugin('spamcontrol'))
				if (uddeIMcheckVersionPlugin('spamcontrol'))
					mosMenuBar::customX( 'spamcontrol', 'edit.png', 'edit_f2.png', _UDDEIM_TOOLBAR_SPAMCONTROL, false );
			mosMenuBar::customX( 'usersettings', 'edit.png', 'edit_f2.png', _UDDEIM_TOOLBAR_USERSETTINGS, false );
			mosMenuBar::save( 'savesettings', _UDDEIM_TOOLBAR_SAVE );
	//		mosMenuBar::customX( 'usersettings', 'edit.png', 'edit_f2.png', 'User settings', false );
	//		mosMenuBar::save( 'savesettings', 'Save' );
			mosMenuBar::cancel();
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		} else {
			mosMenuBar::startTable();
			if (uddeIMcheckPlugin('mcp'))
				if (uddeIMcheckVersionPlugin('mcp'))
					mosMenuBar::custom( 'mcp', 'edit.png', 'edit_f2.png', _UDDEIM_TOOLBAR_MCP, false );
			if (uddeIMcheckPlugin('spamcontrol'))
				if (uddeIMcheckVersionPlugin('spamcontrol'))
					mosMenuBar::custom( 'spamcontrol', 'edit.png', 'edit_f2.png', _UDDEIM_TOOLBAR_SPAMCONTROL, false );
			mosMenuBar::custom( 'usersettings', 'edit.png', 'edit_f2.png', _UDDEIM_TOOLBAR_USERSETTINGS, false );
			mosMenuBar::save( 'savesettings', _UDDEIM_TOOLBAR_SAVE );
			mosMenuBar::cancel();
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		}
		break;
}
