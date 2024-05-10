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


$uddeim_isadmin = 0;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
}
require_once(uddeIMgetPath('absolute_path')."/administrator/components/com_uddeim/config.class.php");

// '1': Keep all messages
// '2': Remove all messages (received and sent)
// '3': Remove received messages only
// '4': Remove sent message only
function user_delete_ext($userid, $pmsUserDeleteOption) {
	$database = uddeIMgetDatabase();
	$config = new uddeimconfigclass();
	$rightnow = uddetime($config->timezone);

//	$query_pms_delete = "DELETE FROM `#__uddeim` WHERE fromid='" . (int) $userid ."' OR toid='" . (int) $userid . "'";

	// delete all messages send from this user and trashed from the outbox
	$query_pms_delete1 = "UPDATE `#__uddeim` SET totrashoutbox=1, totrashdateoutbox=".$rightnow." WHERE fromid='" . (int) $userid . "'";
	// delete all messages recived by this user and trashed from the inbox
	$query_pms_delete2 = "UPDATE `#__uddeim` SET totrash=1, totrashdate=".$rightnow." WHERE toid='".(int) $userid . "'";

	$query_pms_delete_extra1 = "DELETE FROM `#__uddeim_emn` WHERE userid='" . (int) $userid . "'";
	$query_pms_delete_extra2 = "DELETE FROM `#__uddeim_blocks` WHERE blocker='" . (int) $userid . "' OR blocked='" . (int) $userid . "'";
	$query_pms_delete_extra3 = "DELETE FROM `#__uddeim_userlists` WHERE userid='" . (int) $userid ."'";

	print "Deleting pms data for user ".$userid;

	if ($pmsUserDeleteOption==2 || $pmsUserDeleteOption==4) {
		$database->setQuery( $query_pms_delete1 );
		try {
			$database->execute();
		} catch(Exception $e) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete1 . $e->getMessage());
			return false;
		}
	}

	if ($pmsUserDeleteOption==2 || $pmsUserDeleteOption==3) {
		$database->setQuery( $query_pms_delete2 );
		try {
			$database->execute();
		} catch(Exception $e) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete2 . $e->getMessage());
			return false;
		}
	}

	if ($pmsUserDeleteOption>=2) {
		$database->setQuery( $query_pms_delete_extra1 );
		try {
			$database->execute();
		} catch(Exception $e) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete_extra1 . $e->getMessage());
			return false;
		}
		$database->setQuery( $query_pms_delete_extra2 );
		try {
			$database->execute();
		} catch(Exception $e) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete_extra2 . $e->getMessage());
			return false;
		}
		$database->setQuery( $query_pms_delete_extra3 );
		try {
			$database->execute();
		} catch(Exception $e) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete_extra3 . $e->getMessage());
			return false;			
		}
	}
	return true;
}

function user_delete($userid) {
	user_delete_ext($userid, 2);
}
