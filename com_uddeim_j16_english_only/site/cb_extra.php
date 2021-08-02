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

$uddeim_isadmin = 0;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib.php');
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
		if (!$database->query()) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete1 . $database->stderr(true));
			return false;			
		}
	}

	if ($pmsUserDeleteOption==2 || $pmsUserDeleteOption==3) {
		$database->setQuery( $query_pms_delete2 );
		if (!$database->query()) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete2 . $database->stderr(true));
			return false;			
		}
	}

	if ($pmsUserDeleteOption>=2) {
		$database->setQuery( $query_pms_delete_extra1 );
		if (!$database->query()) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete_extra1 . $database->stderr(true));
			return false;			
		}
		$database->setQuery( $query_pms_delete_extra2 );
		if (!$database->query()) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete_extra2 . $database->stderr(true));
			return false;			
		}
		$database->setQuery( $query_pms_delete_extra3 );
		if (!$database->query()) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete_extra3 . $database->stderr(true));
			return false;			
		}
	}
	return true;
}

function user_delete($userid) {
	user_delete_ext($userid, 2);
}
