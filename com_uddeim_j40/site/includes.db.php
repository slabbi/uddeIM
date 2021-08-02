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

// ===================================================================================================================
// MESSAGE
// ===================================================================================================================

function uddeIMsaveRAWmessage($fromid, $toid, $replyid, $message, $date, $config, $cryptmode=0, $pass="") {
	$database = uddeIMgetDatabase();

	$themode = 0;
	if ($cryptmode==1) {
		$themode = 1;
		$cm = uddeIMencrypt($message,$config->cryptkey,CRYPT_MODE_BASE64);
		$sql  = "INSERT INTO `#__uddeim` (fromid, toid, replyid, message, datum, cryptmode, crypthash) VALUES (".
				(int)$fromid.", ".(int)$toid.", ".(int)$replyid.", '".$cm."', ".$date.", 1, '".md5($config->cryptkey)."')";
	} elseif ($cryptmode==2) {
		$themode = 2;
		$thepass=$pass;
		if (!$thepass) {	// no password entered, then fallback to obfuscating
			$themode = 1;
			$thepass=$config->cryptkey;
		}
		$cm = uddeIMencrypt($message,$thepass,CRYPT_MODE_BASE64);
		$sql  = "INSERT INTO `#__uddeim` (fromid, toid, replyid, message, datum, cryptmode, crypthash) VALUES (".
				(int)$fromid.", ".(int)$toid.", ".(int)$replyid.", '".$cm."', ".$date.", ".$themode.", '".md5($thepass)."')";
	} elseif ($cryptmode==3) {
		$themode = 3;
		$cm = uddeIMencrypt($message,"",CRYPT_MODE_STOREBASE64);
		$sql  = "INSERT INTO `#__uddeim` (fromid, toid, replyid, message, datum, cryptmode) VALUES (".
				(int)$fromid.", ".(int)$toid.", ".(int)$replyid.", '".$cm."', ".$date.", 3)";
	} elseif ($cryptmode==4) {
		$themode = 4;
		$thepass=$pass;
		$cipher = CRYPT_MODE_3DESBASE64;
		if (!$thepass) {	// no password entered, then fallback to obfuscating
			$themode = 1;
			$thepass=$config->cryptkey;
			$cipher = CRYPT_MODE_BASE64;
		}
		$cm = uddeIMencrypt($message,$thepass,$cipher);
		$sql  = "INSERT INTO `#__uddeim` (fromid, toid, replyid, message, datum, cryptmode, crypthash) VALUES (".
				(int)$fromid.", ".(int)$toid.", ".(int)$replyid.", '".$cm."', ".$date.", ".$themode.", '".md5($thepass)."')";
	} else {
		$sql  = "INSERT INTO `#__uddeim` (fromid, toid, replyid, message, datum) VALUES (".
				(int)$fromid.", ".(int)$toid.", ".(int)$replyid.", '".$message."', ".$date.")";
	}
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to save a message" . $database->stderr(true));
	}
	$insID = $database->insertid();
	return $insID;
}

// ===================================================================================================================
// UDDIM_SPAM
// ===================================================================================================================

function uddeIMgetSpamStatus($messageid) {
	$database = uddeIMgetDatabase();
	$sql = "SELECT count(id) FROM `#__uddeim_spam` WHERE mid=".(int)$messageid;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMdeleteReport($myself, $messageid) {
	$database = uddeIMgetDatabase();
	$sql = "DELETE FROM `#__uddeim_spam` WHERE toid=".(int)$myself." AND mid=".(int)$messageid;
	$database->setQuery($sql);
	if (!$database->query())
		die("SQL error when attempting to recall a report" . $db->stderr(true));
}

// ===================================================================================================================
// USERS
// ===================================================================================================================

function uddeIMgetGID($myself) {
	$database = uddeIMgetDatabase();
	$my_gid = Array();
	if ($myself) {
		if (uddeIMcheckJversion()>=2) {		// J1.6
			$sql="SELECT g.id AS gid 
				FROM (#__users AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
				INNER JOIN `#__usergroups` AS g ON um.group_id=g.id WHERE u.id=".(int)$myself;
			$database->setQuery($sql);
			$rows = $database->loadObjectList();
			$my_gid = Array();					// 1 = Public, 2 = Registered, ...
			foreach($rows as $key => $value) {
				if ($value->gid<=1)
					$my_gid[] = (int)0;
				else
					$my_gid[] = (int)$value->gid;
			}
		} else {
			$sql="SELECT gid FROM `#__users` AS u WHERE u.id=".(int)$myself;
			$database->setQuery($sql);
			$ret = (int)$database->loadResult();	// 0 = Public, 18=Registered, ...
			$my_gid = Array($ret);
		}
	}
	return $my_gid;
}

function uddeIMgetNameFromUsername($username, $config) {
	$database = uddeIMgetDatabase();
//	$sql="SELECT ".($config->realnames ? "name" : "username")." FROM `#__users` WHERE username LIKE '".$username."'";		// username only is correct here
	$sql="SELECT ".($config->realnames ? "name" : "username")." FROM `#__users` WHERE username = " . $database->Quote( $username );		// username only is correct here
	$database->setQuery($sql);
	$value = $database->loadResult();
	return $value;
}

function uddeIMgetNameFromID($id, $config) {
	$database = uddeIMgetDatabase();
	$sql="SELECT ".($config->realnames ? "name" : "username")." FROM `#__users` WHERE id=".(int)$id;
	$database->setQuery($sql);
	$value = $database->loadResult();

	// BUGBUG: next few lines are experimental
	// when we have realnames, check if the realname is used several times
	if ($config->realnames) {
		$sql="SELECT count(id) FROM `#__users` WHERE name=".$database->Quote( $value );
		$database->setQuery($sql);
		$cnt = (int)$database->loadResult();
		if ($cnt>1) {
			// ups, we have more than one realname matching the result, so return the username instead
			$sql="SELECT username FROM `#__users` WHERE id=".(int)$id;
			$database->setQuery($sql);
			$value = $database->loadResult();
		}
	}
	return $value;
}

function uddeIMgetEMailFromID($id, $config) {
	$database = uddeIMgetDatabase();
	$sql="SELECT email FROM `#__users` WHERE id=".(int)$id;
	$database->setQuery($sql);
	$value = $database->loadResult();
	return $value;
}

// DO NOT USE THIS ON JOOMLA 1.5 (loadObject is broken)
function uddeIMgetNameEmailFromID($id, &$name, &$email, $config) {
	$database = uddeIMgetDatabase();
	$sql="SELECT ".($config->realnames ? "name" : "username")." AS displayname, email FROM `#__users` WHERE id=".(int)$id;
	$database->setQuery($sql);
	$value = NULL;
	if($database->loadObject($value)) {
		$name = $value->displayname;
		$email = $value->email;
	}
	return $value;
}

function uddeIMgetIDfromUsername($name, $unblockedonly=false) {
	$database = uddeIMgetDatabase();
	$sql="SELECT id FROM `#__users` WHERE ".($unblockedonly ? "block=0 AND " : "")."username = " . $database->Quote( $name );
	$database->setQuery($sql);
	$value = (int)$database->loadResult($sql);
	return $value;
}

function uddeIMgetIDfromName($name, $config, $unblockedonly=false) {
	$database = uddeIMgetDatabase();
	$sql="SELECT id FROM `#__users` WHERE ".($unblockedonly ? "block=0 AND " : "").($config->realnames ? "name" : "username")." = " . $database->Quote( $name );
	$database->setQuery($sql);
	$value = (int)$database->loadResult($sql);
	return $value;
}

function uddeIMgetIDfromNamePublic($name, $config, $unblockedonly=false) {
	$database = uddeIMgetDatabase();
	$sql="SELECT id FROM `#__users` WHERE ".($unblockedonly ? "block=0 AND " : "").($config->pubrealnames ? "name" : "username")." = " . $database->Quote( $name );
	$database->setQuery($sql);
	$value = (int)$database->loadResult($sql);
	return $value;
}

function uddeIMgetUserBlock($id) {
	$database = uddeIMgetDatabase();
	$sql="SELECT block FROM `#__users` WHERE id=".(int)$id;
	$database->setQuery($sql);
	$value = (int)$database->loadResult($sql);
	return $value;
}

function uddeIMgetUserExists($id) {
	$database = uddeIMgetDatabase();
	$sql="SELECT COUNT(id) FROM `#__users` WHERE id=".(int)$id;
	$database->setQuery($sql);
	$value = (int)$database->loadResult($sql);
	return $value;
}

function uddeIMgetRegisterDate($id, $config) {
	$database = uddeIMgetDatabase();
	$sql="SELECT UNIX_TIMESTAMP(registerDate) FROM `#__users` WHERE id=".(int)$id;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

// ===============================================================================================================================================================
// CORE_ACL_ARO_GROUPS
// ===============================================================================================================================================================

function uddeIMselectAROgroups() {
	$database = uddeIMgetDatabase();
	if (uddeIMcheckJversion()>=2) {
		$sql = "SELECT id, title AS name FROM `#__usergroups` ORDER BY id";
	} else if (uddeIMcheckJversion()>=1) {
		$sql = "SELECT id, name FROM `#__core_acl_aro_groups` WHERE id NOT IN ( 17, 28, 29, 30 ) ORDER BY id";
	} else {
		$sql = "SELECT group_id AS id, name FROM `#__core_acl_aro_groups` WHERE group_id NOT IN ( 17, 28, 29, 30 ) ORDER BY group_id";
	}
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

// ===============================================================================================================================================================
// MENU
// ===============================================================================================================================================================

function uddeIMgetItemid($config) {
	$database = uddeIMgetDatabase();
	$gid = uddeIMgetGroupID2($config);
	if ($config->overwriteitemid)
		return (int)$config->useitemid;
	$found = uddeIMgetItemidComponent("com_uddeim", $config);
	// first try to find a published link
//	$sql="SELECT id FROM `#__menu` WHERE link LIKE '%com_uddeim%' AND published=1 AND access".($gid==0 ? "=" : "<=").$gid;
//	if (uddeIMcheckJversion()>=2) {		// J1.6
//		$lang = JFactory::getLanguage();
//		$sql.=" AND language IN (" . $database->Quote($lang->get('tag')) . ",'*')";
//	}
//	$sql.=" LIMIT 1";
//	$database->setQuery($sql);
//	$found = (int)$database->loadResult();
//	if (!$found) {
		// when no published link has been found, try to find an unpublished one
//		$sql="SELECT id FROM `#__menu` WHERE link LIKE '%com_uddeim%' AND published=0 AND access".($gid==0 ? "=" : "<=").$gid;
//		if (uddeIMcheckJversion()>=2) {		// J1.6
//			$lang = JFactory::getLanguage();
//			$sql.=" AND language IN (" . $database->Quote($lang->get('tag')) . ",'*')";
//		}
//		$sql.=" LIMIT 1";
//		$database->setQuery($sql);
//		$found = (int)$database->loadResult();
//	}
	return $found;
}

function uddeIMgetItemidComponent($component, $config) {
	$database = uddeIMgetDatabase();
	$gid = uddeIMgetGroupID2($config);

	$sql="SELECT COUNT(id) FROM `#__menu` WHERE link LIKE '%".$component."%' AND published=1 AND access".($gid==0 ? "=" : "<=").$gid;
	if (uddeIMcheckJversion()>=2) {          // J1.6
		$lang = JFactory::getLanguage();
		$sql.=" AND language IN (" . $database->Quote($lang->get('tag')) . ",'*')";
	}
	$sql.=" LIMIT 1";
	$database->setQuery($sql);
	if ($component=="com_uddeim" && 
		(int)$database->loadResult() > 1) {
		$found = JRequest::getint('Itemid');
	} else {
		$sql="SELECT id FROM `#__menu` WHERE link LIKE '%".$component."%' AND published=1 AND access".($gid==0 ? "=" : "<=").$gid;
		if (uddeIMcheckJversion()>=2) {         // J1.6
			$lang = JFactory::getLanguage();
			$sql.=" AND language IN (" . $database->Quote($lang->get('tag')) . ",'*')";
		}
		$sql.=" LIMIT 1";
		$database->setQuery($sql);
		$found = (int)$database->loadResult();
	}

	// first try to find a published link
//	$sql="SELECT id FROM `#__menu` WHERE link LIKE '%".$component."%' AND published=1 AND access".
//			($gid==0 ? "=" : "<=").$gid;
//	if (uddeIMcheckJversion()>=2) {		// J1.6
//		$lang = JFactory::getLanguage();
//		$sql.=" AND language IN (" . $database->Quote($lang->get('tag')) . ",'*')";
//	}
//	$sql.=" LIMIT 1";
//	$database->setQuery($sql);
//	$found = (int)$database->loadResult();

	if (!$found) {
		// when no published link has been found, try to find an unpublished one
		$sql="SELECT id FROM `#__menu` WHERE link LIKE '%".$component."%' AND published=0 AND access".($gid==0 ? "=" : "<=").$gid;
		if (uddeIMcheckJversion()>=2) {		// J1.6
			$lang = JFactory::getLanguage();
			$sql.=" AND language IN (" . $database->Quote($lang->get('tag')) . ",'*')";
		}
		$sql.=" LIMIT 1";
		$database->setQuery($sql);
		$found = (int)$database->loadResult();
	}
	return $found;
}

// ===================================================================================================================
// SESSION
// ===================================================================================================================

function uddeIMisOnline($myself) {
	$database = uddeIMgetDatabase();
	// $sql="SELECT userid FROM `#__session` WHERE (guest=0) AND (NOT (usertype is NULL OR usertype='')) AND userid=".(int)$myself;
	$sql="SELECT userid FROM `#__session` WHERE (guest=0) AND userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

// ===================================================================================================================
// UDDEIM_BLOCKS
// ===================================================================================================================

function uddeIMinsertBlockerBlocked($blocker, $blocked) {
	$database = uddeIMgetDatabase();
	$sql="INSERT INTO `#__uddeim_blocks` (blocker, blocked) VALUES (".(int)$blocker.",".(int)$blocked.")";
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to save a message" . $database->stderr(true));
	}	
}

function uddeIMcheckBlockerBlocked($blocker, $blocked) {
	$database = uddeIMgetDatabase();
	$sql="SELECT count(id) FROM `#__uddeim_blocks` WHERE blocker=".(int)$blocker." AND blocked=".(int)$blocked;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMpurgeBlockerBlocked($blocker, $blocked) {
	$database = uddeIMgetDatabase();
	$sql="DELETE FROM `#__uddeim_blocks` WHERE blocker=".(int)$blocker." AND blocked=".(int)$blocked;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to delete a blocking" . $database->stderr(true));
	}
}

function uddeIMselectBlockerBlockedList($blocker, $config) {
	$database = uddeIMgetDatabase();
	$sql="SELECT a.*, b.".($config->realnames ? "name" : "username")." AS displayname FROM `#__uddeim_blocks` AS a, `#__users` AS b WHERE blocker=".(int)$blocker." AND a.blocked=b.id";
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

// ===================================================================================================================
// UDDEIM_USERLISTS
// ===================================================================================================================

function uddeIMgetUserlistCount($myself, $withglobal=0) {
	$database = uddeIMgetDatabase();
	if ($withglobal)
		$sql = "SELECT count(id) FROM `#__uddeim_userlists` WHERE (global<>0 OR userid=".(int)$myself.")";
	else
		$sql = "SELECT count(id) FROM `#__uddeim_userlists` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMexistsUserlistName($myself, $listid, $name, $withglobal=0) {
	$database = uddeIMgetDatabase();
	if ($withglobal) 		// when it is a global list check globally
		$sql="SELECT COUNT(id) FROM `#__uddeim_userlists` WHERE name=".$database->Quote($name)." AND id<>".(int)$listid." AND (global<>0 OR userid=".(int)$myself.")";	// do I already have a list with this name?
	else
		$sql="SELECT COUNT(id) FROM `#__uddeim_userlists` WHERE name=".$database->Quote($name)." AND id<>".(int)$listid." AND userid=".(int)$myself;	// do I already have a list with this name?
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMselectUserlists($myself, $limitstart, $limit, $withglobal=0) {
	$database = uddeIMgetDatabase();
	if ($withglobal) 		// when it is a global list check globally
		$sql = "SELECT * FROM `#__uddeim_userlists` WHERE (global<>0 OR userid=".(int)$myself.") ORDER BY name LIMIT ".(int)$limitstart.", ".(int)$limit;
	else
		$sql = "SELECT * FROM `#__uddeim_userlists` WHERE userid=".(int)$myself." ORDER BY name LIMIT ".(int)$limitstart.", ".(int)$limit;
	$database->setQuery( $sql );
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectAllUserlists($myself, $my_gid, $config, $withglobal=0) {
	$database = uddeIMgetDatabase();
	if ($withglobal) 		// when it is a global list check globally
		$sql = "SELECT * FROM `#__uddeim_userlists` WHERE (global<>0 OR userid=".(int)$myself.") ORDER BY name";
	else
		$sql = "SELECT * FROM `#__uddeim_userlists` WHERE userid=".(int)$myself." ORDER BY name";
	$database->setQuery( $sql );
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();

	// remove lists if required (1: global list => do not remove; 2: restricted list => remove if not on list or creator or admin)
	if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
		while (list($key, $row) = each($value)) {
			if ($row->global==2) {
				// test if $myself in list
				$ar_ids = explode(",",$row->userids);
				$ar_ids[] = $row->userid;				// the creator of the list is always allowed to access the list
				if (!in_array($myself,$ar_ids))
					unset($value[$key]);
			}
		}
	}
	return $value;
}

function uddeIMselectUserlistsListFromID($myself, $listid, $withglobal=0) {
	$database = uddeIMgetDatabase();
	if ($withglobal) 		// when it is a global list check globally
		$database->setQuery( "SELECT * FROM `#__uddeim_userlists` WHERE id=".(int)$listid." AND (global<>0 OR userid=".(int)$myself.")");
	else
		$database->setQuery( "SELECT * FROM `#__uddeim_userlists` WHERE id=".(int)$listid." AND userid=".(int)$myself);
	$value = $database->loadObjectList(); 		
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectUserlistsListFromName($myself, $listname, $withglobal=0) {
	$database = uddeIMgetDatabase();
	if ($withglobal) 		// when it is a global list check globally
		$database->setQuery( "SELECT * FROM `#__uddeim_userlists` WHERE name=".$database->Quote($listname)." AND (global<>0 OR userid=".(int)$myself.")");
	else
		$database->setQuery( "SELECT * FROM `#__uddeim_userlists` WHERE name=".$database->Quote($listname)." AND userid=".(int)$myself);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMpurgeUserlist($myself, $listid, $withglobal=0) {
	$database = uddeIMgetDatabase();
	if ($withglobal) 		// when it is a global list check globally
		$sql="DELETE FROM `#__uddeim_userlists` WHERE id=".(int)$listid." AND (global<>0 OR userid=".(int)$myself.")";
	else
		$sql="DELETE FROM `#__uddeim_userlists` WHERE id=".(int)$listid." AND userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to delete a list" . $database->stderr(true));
	}
}

function uddeIMupdateUserlist($myself, $listid, $listname, $listdesc, $listids, $lglobal, $withglobal=0) {
	$database = uddeIMgetDatabase();
	if ($withglobal) 		// when it is a global list check globally
		$sql="UPDATE `#__uddeim_userlists` SET name=".$database->Quote($listname).", description=".$database->Quote($listdesc).", userids=".$database->Quote($listids).", global=".(int)$lglobal." WHERE id=".(int)$listid." AND (global<>0 OR userid=".(int)$myself.")";
	else
		$sql="UPDATE `#__uddeim_userlists` SET name=".$database->Quote($listname).", description=".$database->Quote($listdesc).", userids=".$database->Quote($listids).", global=".(int)$lglobal." WHERE id=".(int)$listid." AND userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query())
		die("SQL error when attempting to update a list" . $database->stderr(true));
}

function uddeIMinsertUserlist($myself, $listname, $listdesc, $listids, $lglobal) {
	$database = uddeIMgetDatabase();
	$sql="INSERT INTO `#__uddeim_userlists` (userid, name, description, userids, global) VALUES (".(int)$myself.", ".$database->Quote($listname).", ".$database->Quote($listdesc).", ".$database->Quote($listids).", ".(int)$lglobal.")";
	$database->setQuery($sql);
	if (!$database->query())
		die("SQL error when attempting to save a list" . $database->stderr(true));
}

// ===================================================================================================================
// UDDEIM_EMN
// ===================================================================================================================

function uddeIMgetEMNpublic($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT public FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetEMNpopup($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT popup FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetEMNstatus($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT status FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetEMNautoresponder($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT autoresponder FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetEMNautorespondertext($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT autorespondertext FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = $database->loadResult();
	$value = stripslashes($value);
	return $value;
}

function uddeIMgetEMNautoforward($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT autoforward FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetEMNautoforwardid($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT autoforwardid FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetEMNremindersent($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT remindersent FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetEMNlastsent($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT lastsent FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetEMNlocked($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT locked FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetEMNmoderated($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT moderated FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMupdateEMNstatus($myself, $status) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim_emn` SET status=".(int)$status." WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}
}

function uddeIMupdateEMNreminder($myself, $reminder) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim_emn` SET remindersent=".(int)$reminder." WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}
}

function uddeIMupdateEMNlastsent($myself, $lastsent) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim_emn` SET lastsent=".(int)$lastsent." WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}
}

function uddeIMupdateEMNpublic($myself, $public) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim_emn` SET public=".(int)$public." WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}
}

function uddeIMupdateEMNpopup($myself, $popup) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim_emn` SET popup=".(int)$popup." WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}
}

function uddeIMupdateEMNautoresponder($myself, $autoresponder) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim_emn` SET autoresponder=".(int)$autoresponder." WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}
}

function uddeIMupdateEMNautorespondertext($myself, $autorespondertext) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim_emn` SET autorespondertext='".addslashes(strip_tags($autorespondertext))."' WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}
}

function uddeIMupdateEMNautoforward($myself, $autoforward) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim_emn` SET autoforward=".(int)$autoforward." WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}
}

function uddeIMupdateEMNautoforwardid($myself, $autoforwardid) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim_emn` SET autoforwardid=".(int)$autoforwardid." WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}
}

function uddeIMexistsEMN($myself) {
	$database = uddeIMgetDatabase();
	$sql="SELECT count(id) FROM `#__uddeim_emn` WHERE userid=".(int)$myself;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMinsertEMNdefaults($myself, $config) {
	$database = uddeIMgetDatabase();
	$status = $config->notifydefault;
	$popup  = $config->popupdefault;
	$public = $config->pubfrontenddefault;
	$autoresponder = 0;		// autorespondertext will not be set here
	$autoforward   = 0;
	$autoforwardid = 0;
	$locked = 0;
	$mod	= 0;
	if (uddeIMisReggedOnly($config->usergid))
		$mod	= $config->modnewusers;
	$sql="INSERT INTO `#__uddeim_emn` (moderated, locked, status, popup, public, autoresponder, autoforward, autoforwardid, userid) VALUES (".
			(int)$mod.", ".
			(int)$locked.", ".
			(int)$status.", ".
			(int)$popup.", ".
			(int)$public.", ".
			(int)$autoresponder.", ".
			(int)$autoforward.", ".
			(int)$autoforwardid.", ".
			(int)$myself.")";
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}
}



// ===================================================================================================================
// UDDEIM
// ===================================================================================================================

function uddeIMgetArchiveCount($myself, $filter_user=0, $filter_unread=0, $filter_flagged=0) {
	$database = uddeIMgetDatabase();
//	$sql = "SELECT count(a.id) FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.totrash=0 AND archived=1 AND a.toid=".(int)$myself;
// OPT
	$filter="";
	if ($filter_user) $filter = " AND a.fromid=".(int)$filter_user;
	if ($filter_user==-1) $filter = " AND a.fromid=0";
	if ($filter_unread) $filter .= " AND a.toread=0";
	if ($filter_flagged) $filter .= " AND a.flagged<>0";
	$sql = "SELECT count(a.id) FROM `#__uddeim` AS a WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=1".$filter;
	$database->setQuery($sql);
	$total = (int)$database->loadResult();
	return $total;
}

function uddeIMgetInboxCount($myself, $filter_user=0, $filter_unread=0, $filter_flagged=0) {
	$database = uddeIMgetDatabase();
//	$sql = "SELECT count(a.id) FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=0";
// OPT
	$filter="";
	if ($filter_user) $filter = " AND a.fromid=".(int)$filter_user;
	if ($filter_user==-1) $filter = " AND a.fromid=0";
	if ($filter_unread) $filter .= " AND a.toread=0";
	if ($filter_flagged) $filter .= " AND a.flagged<>0";
	$sql = "SELECT count(a.id) FROM `#__uddeim` AS a WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=0 AND `a`.`delayed`=0".$filter;
	$database->setQuery($sql);
	$total = (int)$database->loadResult();
	return $total;
}

function uddeIMgetInboxArchiveCount($myself) {
	$database = uddeIMgetDatabase();
//	$sql = "SELECT count(a.id) FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0";
// OPT
	$sql = "SELECT count(a.id) FROM `#__uddeim` AS a WHERE a.toid=".(int)$myself." AND a.totrash=0 AND `a`.`delayed`=0";
	$database->setQuery($sql);
	$total = (int)$database->loadResult();
	return $total;
}

function uddeIMgetOutboxCount($myself, $filter_user=0, $filter_unread=0, $filter_flagged=0) {
	$database = uddeIMgetDatabase();
	$filter = "";
	if ($filter_user) $filter .= " AND a.toid=".(int)$filter_user;
	if ($filter_user==-1) $filter = " AND a.toid=0";
	if ($filter_unread) $filter .= " AND a.toread=0";
	if ($filter_flagged) $filter .= " AND a.flagged<>0";
	$sql = "SELECT count(a.id) FROM `#__uddeim` AS a WHERE a.fromid=".(int)$myself." AND a.totrashoutbox=0".$filter." AND a.systemflag=0";
	$database->setQuery($sql);
	$total = (int)$database->loadResult();
	return $total;
}

function uddeIMgetTrashcanCount($myself, $timeframe) {
	$database = uddeIMgetDatabase();
	// how many messages total?
	//	$sql="SELECT count(id) FROM `#__uddeim` WHERE (totrashdate>=".$timeframe." AND toid=".(int)$myself." AND totrash=1) OR (totrashdateoutbox>=".$timeframe." AND fromid=".(int)$myself." AND totrashoutbox=1)";
	// don't count messages that are "copy to me" messages and sender has already trashed the message (totrashoutbox=1 and fromid=toid)
	// !!! systemmessages from me to others should not be shown here when  totrashoutbox=1 and totrashdateoutbox=valid (==add: && systemflag=0)
	$sql = "SELECT count(a.id)
				FROM `#__uddeim` AS a 
				WHERE (totrashdate       >= ".(int)$timeframe." AND a.totrash=1       AND a.toid  =".(int)$myself.") 
				   OR (totrashdateoutbox >= ".(int)$timeframe." AND a.totrashoutbox=1 AND a.fromid=".(int)$myself." AND a.toid<>".(int)$myself." AND systemflag=0)"; 
	$database->setQuery($sql);
	$total = (int)$database->loadResult();
	return $total;
}

function uddeIMgetAttachmentCount($messageid) {
	$database = uddeIMgetDatabase();
	$sql="SELECT COUNT(id) FROM `#__uddeim_attachments` WHERE mid=".(int)$messageid;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetFlagged($messageid) {
	$database = uddeIMgetDatabase();
	$sql="SELECT flagged FROM `#__uddeim` WHERE id=".(int)$messageid;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetDelayed($messageid) {
	$database = uddeIMgetDatabase();
	$sql="SELECT `delayed` FROM `#__uddeim` WHERE id=".(int)$messageid;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetToread($messageid) {
	$database = uddeIMgetDatabase();
	$sql="SELECT toread FROM `#__uddeim` WHERE id=".(int)$messageid;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetArchived($messageid) {
	$database = uddeIMgetDatabase();
	$sql="SELECT archived FROM `#__uddeim` WHERE id=".(int)$messageid;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetArchivedFromTrashedMessage($myself, $messageid) {
	$database = uddeIMgetDatabase();
	$sql="SELECT archived FROM `#__uddeim` WHERE (toid=".(int)$myself." AND id=".(int)$messageid." AND totrash=1) OR (fromid=".(int)$myself." AND id=".(int)$messageid." AND totrashoutbox=1)";
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetTotrash($myself, $messageid) {
	$database = uddeIMgetDatabase();
	$sql="SELECT totrash FROM `#__uddeim` WHERE toid=".(int)$myself." AND id=".(int)$messageid;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMgetTotrashoutbox($myself, $messageid) {
	$database = uddeIMgetDatabase();
	$sql="SELECT totrashoutbox FROM `#__uddeim` WHERE fromid=".(int)$myself." AND id=".(int)$messageid;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMupdateFlagged($myself, $messageid, $value) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim` SET flagged=".(int)$value." WHERE toid=".(int)$myself." AND id=".(int)$messageid;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to mark a message" . $database->stderr(true));
	}
}

function uddeIMupdateDelayed($myself, $messageid, $value) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim` SET `delayed`=".(int)$value." WHERE fromid=".(int)$myself." AND id=".(int)$messageid;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to mark a message" . $database->stderr(true));
	}
}

function uddeIMupdateToread($myself, $messageid, $value) {
	$database = uddeIMgetDatabase();
//	$sql="UPDATE `#__uddeim` SET toread=".(int)$value." WHERE toid=".(int)$myself." AND archived=0 AND id=".(int)$messageid;
	$sql="UPDATE `#__uddeim` SET toread=".(int)$value." WHERE toid=".(int)$myself." AND id=".(int)$messageid;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to trash a message" . $database->stderr(true));
	}
}

function uddeIMupdateArchived($messageid, $value) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim` SET archived=".(int)$value." WHERE id=".(int)$messageid;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to archive a message" . $database->stderr(true));
	}
}

function uddeIMupdateArchivedToid($myself, $messageid, $value) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim` SET archived=".(int)$value." WHERE toid=".(int)$myself." AND id=".(int)$messageid;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to archive a message" . $database->stderr(true));
	}
}

function uddeIMexistsMessage($id) {
	$database = uddeIMgetDatabase();
	$sql="SELECT count(id) FROM `#__uddeim` WHERE id=".(int)$id;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMexistsMessageToUser($toid, $messageid) {
	$database = uddeIMgetDatabase();
	$sql="SELECT count(id) FROM `#__uddeim` WHERE toid=".(int)$toid." AND id=".(int)$messageid;
	$database->setQuery($sql);
	$value = (int)$database->loadResult();
	return $value;
}

function uddeIMpurgeMessageFromUser($fromid, $messageid) {
	$database = uddeIMgetDatabase();
	$sql="DELETE FROM `#__uddeim` WHERE fromid=".(int)$fromid." AND id=".(int)$messageid;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to delete a message" . $database->stderr(true));
	}
}

function uddeIMdeleteMessageFromInbox($myself, $messageid, $deletetime) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim` SET totrash=1, totrashdate=".(int)$deletetime." WHERE toid=".(int)$myself." AND id=".(int)$messageid;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to delete a message" . $database->stderr(true));
	}
}

function uddeIMdeleteMessageFromArchive($myself, $messageid, $deletetime) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim` SET totrash=1, totrashdate=".(int)$deletetime." WHERE toid=".(int)$myself." AND id=".(int)$messageid;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to delete a message" . $database->stderr(true));
	}
}

function uddeIMdeleteMessageFromOutbox($myself, $messageid, $deletetime) {
	$database = uddeIMgetDatabase();
	$sql="UPDATE `#__uddeim` SET totrashoutbox=1, totrashdateoutbox=".(int)$deletetime." WHERE fromid=".(int)$myself." AND id=".(int)$messageid;
	$database->setQuery($sql);
	if (!$database->query()) {
		die("SQL error when attempting to delete a message" . $database->stderr(true));
	}
}

function uddeIMrestoreMessageToInboxOutboxArchive($myself, $messageid) {
	$database = uddeIMgetDatabase();
	// Important:
	// First check if it was sent to Inbox, then if it was sent to outbox, it is important when a "general message" was send, deleted and restored (fromid==toid)

	// Check if the message is send to me (so it was either in the Inbox or the Archive)
	if (uddeIMgetTotrash($myself, $messageid)) {
		// so when the message was from the inbox/archivem then restore it to there and do not restore to outbox (might be also valid e.g. for copy2me messages)
		$sql="UPDATE `#__uddeim` SET totrash=0, totrashdate=NULL WHERE toid=".(int)$myself." AND id=".(int)$messageid;
		$database->setQuery($sql);
		if (!$database->query()) {
			die("SQL error when attempting to restore a message" . $database->stderr(true));
		}
	} else {
		// Check if the message was send by me (so it was in the Outbox)
		$sql="UPDATE `#__uddeim` SET totrashoutbox=0, totrashdateoutbox=NULL WHERE fromid=".(int)$myself." AND id=".(int)$messageid;
		$database->setQuery($sql);
		if (!$database->query()) {
			die("SQL error when attempting to restore a message" . $database->stderr(true));
		}
	}
}

// ===================================================================================================================
// JOINs
// ===================================================================================================================

function uddeIMselectFilter($myself, $type, $config) {
	$database = uddeIMgetDatabase();
	switch($type) {
		case 'postbox':	$sql = "SELECT id, displayname FROM (
								(SELECT b.id, b.".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` AS b LEFT JOIN `#__uddeim` AS a ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND a.archived=0) 
								UNION
								(SELECT b.id, b.".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` AS b LEFT JOIN `#__uddeim` AS a ON a.toid=b.id WHERE a.fromid=".(int)$myself." AND a.totrashoutbox=0)
								) AS comb_table ORDER BY displayname";
						break;
		case 'inbox':	$sql = "SELECT distinct b.id, b.".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` AS b LEFT JOIN `#__uddeim` AS a ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND a.archived=0 ORDER BY ".($config->realnames ? "name" : "username");
						break;
		case 'outbox':	$sql = "SELECT distinct b.id, b.".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` AS b LEFT JOIN `#__uddeim` AS a ON a.toid=b.id WHERE a.fromid=".(int)$myself." AND a.totrashoutbox=0 ORDER BY ".($config->realnames ? "name" : "username");
						break;
		case 'archive':	$sql = "SELECT distinct b.id, b.".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` AS b LEFT JOIN `#__uddeim` AS a ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND a.archived=1 ORDER BY ".($config->realnames ? "name" : "username");
						break;
		default:		return Array();
						break;
	}
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectMessage($myself, $messageid, $config, $trashed=-1) {
	$database = uddeIMgetDatabase();
	$filter = "";
	$filter2 = "";
	if($trashed>=0) {
		$filter = " AND totrash=".(int)$trashed;
		$filter2 = " AND totrashoutbox=".(int)$trashed;
	}
	$sql = "SELECT * FROM `#__uddeim` WHERE id=".(int)$messageid." AND (toid=".(int)$myself.$filter." OR fromid=".(int)$myself.$filter2.")";
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectInbox($myself, $limitstart, $limit, $config, $filter_user=0, $filter_unread=0, $filter_flagged=0, $sort_mode=0) {
	$database = uddeIMgetDatabase();
//	$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=0 ORDER BY datum DESC LIMIT ".(int)$limitstart.", ".(int)$limit;
// OPT
	$filter = "";
	if ($filter_user) $filter = " AND a.fromid=".(int)$filter_user;
	if ($filter_user==-1) $filter = " AND a.fromid=0";
	if ($filter_unread) $filter .= " AND a.toread=0";
	if ($filter_flagged) $filter .= " AND a.flagged<>0";

	$sort = " ORDER BY datum";	// default
	switch($sort_mode) {
		case 0:
		case 1: $sort = " ORDER BY datum"; break;		// default
		case 2:
		case 3: $sort = " ORDER BY b.".($config->realnames ? "name" : "username"); break;
	}
	if ($sort_mode % 2)
		$sort .= " ASC";		// 1= ASC
	else
		$sort .= " DESC";		// 0 = DESC

//	if ($config->showlistattachment)
//		$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname, c.id AS attid FROM (#__uddeim AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id) LEFT JOIN `#__uddeim_attachments` AS c ON a.id=c.mid WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=0".$filter." GROUP BY a.id".$sort." LIMIT ".(int)$limitstart.", ".(int)$limit;
//	else
//		$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname, NULL AS attid FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=0".$filter.$sort." LIMIT ".(int)$limitstart.", ".(int)$limit;
	$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=0 AND `a`.`delayed`=0".$filter.$sort." LIMIT ".(int)$limitstart.", ".(int)$limit;

	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectInboxMessage($myself, $messageid, $config, $trashed=-1) {
	$database = uddeIMgetDatabase();
	$filter = "";
	if($trashed>=0)
		$filter = " AND a.totrash=".(int)$trashed;
	$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND `a`.`delayed`=0 AND a.id=".(int)$messageid.$filter;
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectArchive($myself, $limitstart, $limit, $config, $filter_user=0, $filter_unread=0, $filter_flagged=0, $sort_mode=0) {
	$database = uddeIMgetDatabase();
//	$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.totrash=0 AND archived=1 AND a.toid=".(int)$myself." ORDER BY datum DESC LIMIT ".(int)$limitstart.", ".(int)$limit;
// OPT
	$filter = "";
	if ($filter_user) $filter = " AND a.fromid=".(int)$filter_user;
	if ($filter_user==-1) $filter = " AND a.fromid=0";
	if ($filter_unread) $filter .= " AND a.toread=0";
	if ($filter_flagged) $filter .= " AND a.flagged<>0";

	$sort = " ORDER BY datum";	// default
	switch($sort_mode) {
		case 0:
		case 1: $sort = " ORDER BY datum"; break;		// default
		case 2:
		case 3: $sort = " ORDER BY b.".($config->realnames ? "name" : "username"); break;
	}
	if ($sort_mode % 2)
		$sort .= " ASC";		// 1= ASC
	else
		$sort .= " DESC";		// 0 = DESC

//	if ($config->showlistattachment)
//		$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname, c.id AS attid FROM (#__uddeim AS a FORCE INDEX(datum) LEFT JOIN `#__users` AS b ON a.fromid=b.id) LEFT JOIN `#__uddeim_attachments` AS c ON a.id=c.mid WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=1".$filter." GROUP BY a.id".$sort." LIMIT ".(int)$limitstart.", ".(int)$limit;
//	else
//		$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname, NULL AS attid FROM `#__uddeim` AS a FORCE INDEX(datum) LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=1".$filter.$sort." LIMIT ".(int)$limitstart.", ".(int)$limit;
	$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname FROM `#__uddeim` AS a FORCE INDEX(datum) LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=1".$filter.$sort." LIMIT ".(int)$limitstart.", ".(int)$limit;

	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectArchiveMessage($myself, $messageid, $config) {
	$database = uddeIMgetDatabase();
	// does not test on " AND archived=1", but thats ok
	$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.id=".(int)$messageid;
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectOutbox($myself, $limitstart, $limit, $config, $filter_user=0, $filter_unread=0, $filter_flagged=0, $sort_mode=0) {
	$database = uddeIMgetDatabase();
	// 1. Do not select messages which have been already trashed in the outbox ("totrashoutbox" must be 0)
	// 2. Do not show Systemmessages ("systemflag=1")
	// There are following special cases:
	//	"welcome messages" (toid==myself && fromid==toid && systemflag=1 => not shown)
	//	"general messages" (toid==myself && fromid==toid && systemflag=1 				-> systemmessage to myself
	//			       OR toid==myself && fromid<>toid && systemflag=1 => not shown)		-> systemmessage to others
	//	"copy2me" (toid=myself && fromid==toid && systemflag=2 => not shown)
	// FIXME?: copy2me ändern => keine systemmessage mehr, sondern neues feld mit "original author"
	$filter = "";
	if ($filter_user) $filter = " AND a.toid=".(int)$filter_user;
	if ($filter_user==-1) $filter = " AND a.toid=0";
	if ($filter_unread) $filter .= " AND a.toread=0";
	if ($filter_flagged) $filter .= " AND a.flagged<>0";

	$sort = " ORDER BY toread ASC, datum";	// default
	switch($sort_mode) {
		case 0:
		case 1: $sort = " ORDER BY toread ASC, datum"; break;		// default
		case 2:
		case 3: $sort = " ORDER BY toread ASC, b.".($config->realnames ? "name" : "username"); break;
	}
	if ($sort_mode % 2)
		$sort .= " ASC";		// 1= ASC
	else
		$sort .= " DESC";		// 0 = DESC

	$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS toname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.toid=b.id WHERE a.fromid=".(int)$myself." AND a.totrashoutbox=0".$filter." AND a.systemflag=0".$sort." LIMIT ".(int)$limitstart.", ".(int)$limit;
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectOutboxMessage($myself, $messageid, $config, $trashed=-1) {
	$database = uddeIMgetDatabase();
	$filter = "";
	if($trashed>=0)
		$filter = " AND a.totrashoutbox=".(int)$trashed;
	$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS toname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.toid=b.id WHERE a.fromid=".(int)$myself." AND a.id=".(int)$messageid.$filter;
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectOutboxMessageIfUnread($myself, $messageid, $config) {
	$database = uddeIMgetDatabase();
	$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS toname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.toid=b.id WHERE a.toread=0 AND a.fromid=".(int)$myself." AND a.id=".(int)$messageid;
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectTrashcan($myself, $timeframe, $limitstart, $limit, $config) {
	$database = uddeIMgetDatabase();
	// copy2me messages have always "totrashoutbox"=1, so they would be always shown in the trashcan.
	// since copy2me messages have "fromid"="toid", I do filter these messages in the outbox part
	// I do also not show systemmsgs which have "fromid"<>"toid" but have "systemflag" set
	$sql = "SELECT a.*, ufrom.".($config->realnames ? "name" : "username")." AS fromname, 
						  uto.".($config->realnames ? "name" : "username")." AS toname
				FROM (#__uddeim AS a FORCE INDEX(PRIMARY) LEFT JOIN `#__users` AS ufrom ON a.fromid = ufrom.id) 
									 LEFT JOIN `#__users` AS uto   ON a.toid   = uto.id
				WHERE (totrashdate       >= ".$timeframe." AND a.totrash=1       AND a.toid  =".(int)$myself.") 
				   OR (totrashdateoutbox >= ".$timeframe." AND a.totrashoutbox=1 AND a.fromid=".(int)$myself." AND a.toid<>".(int)$myself." AND systemflag=0) 
				ORDER BY a.id DESC LIMIT ".(int)$limitstart.", ".(int)$limit;
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectJSbuddies($myself, $config, $extrafilter="") {
	$database = uddeIMgetDatabase();
//	$sql = "SELECT DISTINCT(u.".($config->realnames ? "name" : "username").") AS displayname " .
//		   "FROM `#__community_connection` AS a INNER JOIN `#__users` AS u " .
//		   "ON a.connect_from=".(int)$myself." AND a.connect_to=u.id AND a.status=1";
	$sql = "SELECT DISTINCT(u.".($config->realnames ? "name" : "username").") AS displayname, u.id " .
		   "FROM `#__community_connection` AS a INNER JOIN `#__users` AS u " .
		   "ON a.connect_to=u.id WHERE ".$extrafilter."a.status=1 AND a.connect_from=".(int)$myself;
//	if (class_exists('CFactory')) {
//		$friendsModel = CFactory::getModel('friends');
//		$friends = $friendsModel->getFriends($myself);
//	}
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectCBEbuddies($myself, $config, $extrafilter="") {
	$database = uddeIMgetDatabase();
	$sql="SELECT a.buddyid, a.userid, u.id, u.".($config->realnames ? "name" : "username")." AS displayname FROM `#__comprofiler_buddylist` AS a, `#__users` AS u WHERE ".$extrafilter."u.block=0 AND (((a.userid=".(int)$myself." AND u.id=a.buddyid) OR (a.buddyid=".(int)$myself." AND u.id=a.userid)) AND buddy='1') ORDER by u.".($config->realnames ? "name" : "username");
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectCBE2buddies($myself, $config, $extrafilter="") {
	$database = uddeIMgetDatabase();
	$sql="SELECT a.buddyid, a.userid, u.id, u.".($config->realnames ? "name" : "username")." AS displayname FROM `#__cbe_buddylist` AS a, `#__users` AS u WHERE ".$extrafilter."u.block=0 AND (((a.userid=".(int)$myself." AND u.id=a.buddyid) OR (a.buddyid=".(int)$myself." AND u.id=a.userid)) AND buddy='1') ORDER by u.".($config->realnames ? "name" : "username");
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectCBbuddies($myself, $config, $extrafilter="") {
	$value = Array();
	$database = uddeIMgetDatabase();
	$sql = "SELECT m.referenceid,m.memberid,u.".($config->realnames ? "name" : "username")." as displayname, u.id FROM `#__comprofiler_members` AS m, `#__users` AS u "
		 . " WHERE ".$extrafilter."u.block=0 AND m.memberid=u.id AND m.referenceid=".(int)$myself." ORDER BY u.".($config->realnames ? "name" : "username");
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectMessageReplies($currentid, $type, $myself) {
	$database = uddeIMgetDatabase();
	if ($type=='inbox')
//		$sql="SELECT id,fromid,toid,replyid,cryptmode FROM `#__uddeim` WHERE toid=".  (int)$myself." AND replyid=".(int)$currentid." LIMIT 10";
		$sql="SELECT id,fromid,toid,replyid,cryptmode FROM `#__uddeim` WHERE toid=".  (int)$myself." AND replyid=".(int)$currentid." AND totrash=0 LIMIT 10";
	else
//		$sql="SELECT id,fromid,toid,replyid,cryptmode FROM `#__uddeim` WHERE fromid=".(int)$myself." AND replyid=".(int)$currentid." LIMIT 10";
		$sql="SELECT id,fromid,toid,replyid,cryptmode FROM `#__uddeim` WHERE fromid=".(int)$myself." AND replyid=".(int)$currentid." AND (totrashoutbox=0 OR (totrash=0 AND fromid=toid)) LIMIT 10";
//		$sql="SELECT id,fromid,toid,replyid,cryptmode FROM `#__uddeim` WHERE fromid=".(int)$myself." AND replyid=".(int)$currentid." AND totrashoutbox=0 LIMIT 10";
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectUserrecordFromUsername($username, $config) {
	$database = uddeIMgetDatabase();
	// $sql = "SELECT id, name, username, password, usertype, block FROM `#__users` WHERE username=". $database->Quote( $username );
	$sql = "SELECT id, name, username, password, block FROM `#__users` WHERE username=". $database->Quote( $username );
	$database->setQuery($sql);
	$values = $database->loadObjectList();
	if (!$values)
		$values = Array();
	$row = "";
	foreach($values as $value)
		$row = $value;
	return $row;
}
