<?php
// ********************************************************************************************
// @title         udde Instant Messages (uddeIM)
// @description   Instant Messages System for Joomla 5, admin toolbar
// @author        Stephan Slabihoud
// @copyright     © 2007-2024 Stephan Slabihoud, © 2024 v5 joomod.de
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
use Joomla\CMS\Toolbar\ToolbarHelper;

if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
	require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib50.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
	require_once($mainframe->getCfg('absolute_path').'/administrator/components/com_uddeim/admin.uddeimlib50.php');
}
require_once(uddeIMgetPath('absolute_path').'/administrator/components/com_uddeim/admin.shared.php');

if (uddeIMcheckJversion()>=4) {	// Joomla >=2.5
	// Options button. -> Action: "Configure"
	if (Factory::getApplication()->getIdentity()->authorise('core.admin', 'com_uddeim')) {
		ToolBarHelper::preferences('com_uddeim');
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
			
			/*if (uddeIMcheckPlugin('mcp'))
				if (uddeIMcheckVersionPlugin('mcp'))
					mosMenuBar::custom( 'mcp', 'edit.png', 'edit_f2.png', _UDDEIM_TOOLBAR_MCP, false );
			if (uddeIMcheckPlugin('spamcontrol'))
				if (uddeIMcheckVersionPlugin('spamcontrol'))
					mosMenuBar::custom( 'spamcontrol', 'edit.png', 'edit_f2.png', _UDDEIM_TOOLBAR_SPAMCONTROL, false );
     			*/
			mosMenuBar::startTable();
			mosMenuBar::custom( 'usersettings', 'edit.png', 'edit_f2.png', _UDDEIM_TOOLBAR_USERSETTINGS, false );
			mosMenuBar::save( 'savesettings', _UDDEIM_TOOLBAR_SAVE );
			mosMenuBar::cancel();
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		break;
}
