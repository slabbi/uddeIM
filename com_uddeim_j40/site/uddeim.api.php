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
require_once( uddeIMgetPath('admin')."/config.class.php" );
require_once( uddeIMgetPath('admin')."/admin.shared.php" );
require_once( uddeIMgetPath('user') ."/includes.php" );
require_once( uddeIMgetPath('user') ."/includes.db.php" );
require_once( uddeIMgetPath('user') ."/crypt.class.php" );

class uddeIMAPI {
  
	var $config;
	var $absolute_path;
	var $pathtoadmin;
	var $pathtouser;
	var $pathtosite;

	function __construct() {
		global $udde_smon, $udde_lmon, $udde_sweekday, $udde_lweekday;
		$this->config 		 = new uddeimconfigclass();
		$this->absolute_path = uddeIMgetPath('absolute_path');
		$this->pathtoadmin   = uddeIMgetPath('admin');
		$this->pathtouser    = uddeIMgetPath('user');
		$this->pathtosite    = uddeIMgetPath('live_site');
		uddeIMloadLanguage($this->pathtoadmin, $this->config);
	}

	function version() {
		return 5;
	}

	function mainVersion() {
		$temp = uddeIMgetVersionArray();
		return $temp;		
	}

	function registerHook($event, $callback) {
		if (is_callable('uddeIMregisterHook')) {
			return uddeIMregisterHook($event, $callback);
		}
		return false;
	}

	function getLinkToBox($box, $sef=0) {
		$Itemid = uddeIMgetItemid($this->config);
		switch($box) {
			case 'inbox':
				$link = "index.php?option=com_uddeim&task=inbox".($Itemid ? "&Itemid=".$Itemid : "");
				break;
			case 'outbox':
				$link = "index.php?option=com_uddeim&task=outbox".($Itemid ? "&Itemid=".$Itemid : "");
				break;
			case 'archive':
				$link = "index.php?option=com_uddeim&task=archive".($Itemid ? "&Itemid=".$Itemid : "");
				break;
			case 'trashcan':
				$link = "index.php?option=com_uddeim&task=trashcan".($Itemid ? "&Itemid=".$Itemid : "");
				break;
			case 'settings':
				$link = "index.php?option=com_uddeim&task=settings".($Itemid ? "&Itemid=".$Itemid : "");
				break;
			case 'compose':
				$link = "index.php?option=com_uddeim&task=new".($Itemid ? "&Itemid=".$Itemid : "");
				break;
			case 'contacts':
				$link = "index.php?option=com_uddeim&task=showlists".($Itemid ? "&Itemid=".$Itemid : "");
				break;
			default:
				$link = "index.php?option=com_uddeim&task=inbox".($Itemid ? "&Itemid=".$Itemid : "");
				break;
		}
		if ($sef)
			$link = uddeIMsefRelToAbs($link);
		return $link;
	}

	function isInboxLimitReached($userid) {
		if($this->config->inboxlimit) {
			if ($this->config->allowarchive) {
				$total = uddeIMgetInboxArchiveCount($userid);
			} else {
				$total = uddeIMgetInboxCount($userid);
			}
			$gid=uddeIMgetGID((int)$userid);
			if($total>$this->config->maxarchive && !uddeIMisAdmin($gid) && !uddeIMisAdmin2($gid, $this->config)) {
				return true;
			}
		}
		return false;
	}

	function getInboxUnreadMessages($userid) {
		return uddeIMgetInboxCount($userid, 0, true);
	}

	function getInboxTotalMessages($userid) {
		return uddeIMgetInboxCount($userid);
	}

	function getItemid() {
		$found = uddeIMgetItemid($this->config);
//		$database = uddeIMgetDatabase();
//		$gid = uddeIMgetGroupID2($this->config);
//		if ($this->config->overwriteitemid)
//			return (int)$this->config->useitemid;

//		$sql="SELECT id FROM `#__menu` WHERE link LIKE '%com_uddeim%' AND published=1 AND access".($gid==0 ? "=" : "<=").$gid;
//		if (uddeIMcheckJversion()>=2) {		// J1.6
//			$lang = JFactory::getLanguage();
//			$sql.=" AND language IN (" . $database->Quote($lang->get('tag')) . ",'*')";
//		}
//		$sql.=" LIMIT 1";
//		$database->setQuery($sql);
//		$found = (int)$database->loadResult();
//		if (!$found) {
//			$sql="SELECT id FROM `#__menu` WHERE link LIKE '%com_uddeim%' AND published=0 AND access".($gid==0 ? "=" : "<=").$gid;
//			if (uddeIMcheckJversion()>=2) {		// J1.6
//				$lang = JFactory::getLanguage();
//				$sql.=" AND language IN (" . $database->Quote($lang->get('tag')) . ",'*')";
//			}
//			$sql.=" LIMIT 1";
//			$database->setQuery($sql);
//			$found = (int)$database->loadResult();
//		}
		return $found;
	}
	
	function getConfiguration() {
		return $this->config;
	}
	
	function sendNewMessageDelayed($fromid, $toid, $message, $sendnotification=0, $updatelastsent=0) {
		$messageid = sendNewMessage($fromid, $toid, $message, $sendnotification, $updatelastsent);
		uddeIMupdateDelayed($fromid, $messageid, 1);
		return $messageid;
	}
	
	function sendNewMessage($fromid, $toid, $message, $sendnotification=0, $updatelastsent=0) {

		if ($this->config->cryptmode>=1)
			$savemessage = strip_tags($message);
		else
			$savemessage = addslashes(strip_tags($message));

		$date  = uddetime($this->config->timezone);
		$replyid = 0;
		$cryptmode = $this->config->cryptmode;
		$insID = uddeIMsaveRAWmessage($fromid, $toid, $replyid, $savemessage, $date, $this->config, $cryptmode);

		if ($updatelastsent) {
			if (!uddeIMexistsEMN((int)$fromid))
				uddeIMinsertEMNdefaults((int)$fromid, $this->config);
			uddeIMupdateEMNlastsent($fromid, $date);
		}

		if ($sendnotification) {
			// Check if E-Mail notification or popups are enabled by default, if so create a record for the receiver.
			// Note: Not necessary for "copy to myself" sind the record for the current user has been set at the very beginning...
			if ($this->config->notifydefault>0 || $this->config->popupdefault>0 || $this->config->pubfrontenddefault>0 || $this->config->autoresponder>0 || $this->config->autoforward>0) {
				if (!uddeIMexistsEMN($toid))
					uddeIMinsertEMNdefaults($toid, $this->config);
			}
		}

		// get the group ID of the recipient
		$gid = uddeIMgetGID((int)$toid);

		// ##################################################################################################
		// autoforward code
		// ##################################################################################################
		if ($this->config->autoforward==1 || 
		   ($this->config->autoforward==2 && (uddeIMisAdmin($gid)   || uddeIMisAdmin2($gid, $this->config))) ||
		   ($this->config->autoforward==3 && (uddeIMisSpecial($gid) || uddeIMisSpecial2($my_gid, $this->config))) ) {
			$ison = uddeIMgetEMNautoforward($toid);						// recipient has autoforward enabled
			if ($ison==1) {
				$autoforwardid = uddeIMgetEMNautoforwardid($toid);	// new recipient

				if (uddeIMgetUserExists($autoforwardid)) {
					if (!uddeIMgetUserBlock($autoforwardid)) {
						$temp = uddeIMgetNameFromID($toid, $this->config);
						$temp = (($this->config->cryptmode>=1) ? $temp : addslashes($temp));
						if ($this->config->allowbb)
							$forwardheader="\n\n[i]("._UDDEIM_THISISAFORWARD.$temp.")[/i]";
						else
							$forwardheader="\n\n("._UDDEIM_THISISAFORWARD.$temp.")";
						$savemessagecopy = $savemessage.$forwardheader;
						$insIDforward = uddeIMsaveRAWmessage($fromid, $autoforwardid, 0, $savemessagecopy, $date, $this->config, $this->config->cryptmode, "");
					}
				}
			}
		}

		// ##################################################################################################
		// copy to myself?
		// ##################################################################################################

		// nothing to do

		// ##################################################################################################
		// autoresponder
		// ##################################################################################################

		// nothing to do

		// ##################################################################################################
		// email notification
		// ##################################################################################################

		if ($sendnotification) {
			$currentlyonline = uddeIMisOnline($toid);

			if ($this->config->cryptmode>=1) {
				$email = stripslashes($savemessage);
			} else {
				$email = stripslashes(stripslashes($savemessage));
			}
			
			if($this->config->allowemailnotify==1) {
				$ison = uddeIMgetEMNstatus($toid);
				if (($ison==1) || ($ison==2 && !$currentlyonline) || $ison==10 || ($ison==20 && !$currentlyonline)) {
					uddeIMdispatchEMN($insID, $item_id, $cryptmode, $fromid, $toid, $email, 0, $this->config);
				}
			} elseif($this->config->allowemailnotify==2) {
				if (uddeIMisAdmin($gid) || uddeIMisAdmin2($gid, $this->config)) {
					$ison = uddeIMgetEMNstatus($toid);
					if (($ison==1) || ($ison==2 && !$currentlyonline) || $ison==10  || ($ison==20 && !$currentlyonline)) {
						uddeIMdispatchEMN($insID, $item_id, $cryptmode, $fromid, $toid, $email, 0, $this->config);
					}
				}
			}
		}
		return $insID;
	}
	
	function appendAttachment($messageID, $filename, $originalname, $id) {
		$file = $this->absolute_path."/images/uddeimfiles/".$filename;
		$uploadfile_temppathname[] = $file;
		$uploadfile_original[] = $originalname;
		$uploadfile_id[] = $id;
		$uploadfile_size[] = filesize($file);
		$savedatum = uddetime($config->timezone);
		uddeIMsaveAttachments($messageID, $uploadfile_temppathname, $uploadfile_original, $uploadfile_id, $uploadfile_size, $savedatum, NULL);
	}

	function isAttachmentAvailable() {
		$plugin_attachment = 0;
		if (uddeIMcheckPlugin('attachment'))
			$plugin_attachment = 1;
		return $plugin_attachment;
	}

		
	function sendNewSysMessage($fromid, $recipients, $message, $systemmsg=0, $validfor=0, $sendnotification=0, $forceembedded=0) {
		$database = uddeIMgetDatabase();

		if ($systemmsg) {		// system message
			$sendername = $this->config->sysm_username;
			$savesysflag = addslashes($sendername); 			// system message
			$savedisablereply = 1; 								// and users can't reply to them
			$emn_fromid = 0;									// for email notifications set userid 0
		} else {
			$sendername = uddeIMgetNameFromID($fromid, $this->config);
			$savesysflag = addslashes($sendername);
			$savedisablereply = 0;
			$emn_fromid = $fromid;
		}

		$savedatum = uddetime($this->config->timezone);
		if ($validfor>0) {
			$now = uddetime($this->config->timezone);
			$validuntil = $now+($validfor*3600);
		} else {
			$validuntil = 0;
		}

		if ($this->config->cryptmode>=1) {	// because of encoding do not use slashes
			$savemessage = strip_tags($message);
		} else {
			$savemessage = addslashes(strip_tags($message));   // original 0.6+
		}

		getAdditonalGroups($add_special, $add_admin, $config);
		if (uddeIMcheckJversion()>=2) {		// J1.6
			if ($recipients=="all") {
				$sql="SELECT id FROM `#__users` WHERE block=0";
			} elseif($recipients=="online") {
				$sql="SELECT a.id, b.userid FROM `#__users` AS a, `#__session` AS b WHERE block=0 AND a.id=b.userid";
			} elseif($recipients=="special") {
				$sql="SELECT DISTINCT u.id FROM (#__users AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
							INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
							WHERE u.block=0 AND g.id IN (3,4,5,6,7,8".$add_admin.$add_special.")";
			} elseif($recipients=="admins") {
				$sql="SELECT DISTINCT u.id FROM (#__users AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
							INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
							WHERE u.block=0 AND g.id IN (7,8".$add_admin.")";
			} else {
				$sql="SELECT DISTINCT u.id FROM (#__users AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
							INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
							WHERE u.block=0 AND g.id=".(int)$recipients;
			}
		} else {
			if ($recipients=="all") {
				$sql="SELECT id FROM `#__users` WHERE block=0";
			} elseif($recipients=="online") {
				$sql="SELECT a.id, b.userid FROM `#__users` AS a, `#__session` AS b WHERE block=0 AND a.id=b.userid";
			} elseif($recipients=="special") {
				$sql="SELECT id FROM `#__users` WHERE block=0 AND gid IN (19,20,21,23,24,25".$add_admin.")";
			} elseif($recipients=="admins") {
				$sql="SELECT id FROM `#__users` WHERE block=0 AND gid IN (24,25".$add_admin.")";
			} else {
				$sql="SELECT id FROM `#__users` WHERE block=0 AND gid=".(int)$recipients;
			}
		}
		$database->setQuery($sql);
		$receivers=$database->loadObjectList();

		if (!count($receivers)) {
			return 1;
		}

		foreach($receivers as $receiver) {
			$toid = $receiver->id;

			$themode = 0;
			if ($this->config->cryptmode==1 || $this->config->cryptmode==2 || $this->config->cryptmode==4) {
				$themode = 1;
				$cm = uddeIMencrypt($savemessage,$this->config->cryptkey,CRYPT_MODE_BASE64);
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, expires, systemmessage, systemflag, disablereply, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$fromid.", ".(int)$toid.", '".$cm."', ".$savedatum.", ".$validuntil.", '".$savesysflag."', 1,".$savedisablereply.", 1, ".$savedatum.",1,'".md5($this->config->cryptkey)."')";
			} elseif ($this->config->cryptmode==3) {
				$themode = 3;
				$cm = uddeIMencrypt($savemessage,"",CRYPT_MODE_STOREBASE64);
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, expires, systemmessage, systemflag, disablereply, totrashoutbox, totrashdateoutbox, cryptmode) VALUES (".(int)$fromid.", ".(int)$toid.", '".$cm."', ".$savedatum.", ".$validuntil.", '".$savesysflag."', 1,".$savedisablereply.", 1, ".$savedatum.",3)";
			} else {
				$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, expires, systemmessage, systemflag, disablereply, totrashoutbox, totrashdateoutbox) VALUES (".(int)$fromid.", ".(int)$toid.", '".$savemessage."', ".$savedatum.", ".$validuntil.", '".$savesysflag."', 1,".$savedisablereply.", 1,".$savedatum.")";
			}
			$database->setQuery($sql);
			if (!$database->query()) {
				die("SQL error when attempting to save a message" . $database->stderr(true));
			}
			$insID = $database->insertid();

			if ($sendnotification) {
				// Check if E-Mail notification or popups are enabled by default, if so create a record for the receiver.
				if ($this->config->notifydefault>0 || $this->config->popupdefault>0 || $this->config->pubfrontenddefault>0 || $this->config->autoresponder>0 || $this->config->autoforward>0) {
					if (!uddeIMexistsEMN($toid))
						uddeIMinsertEMNdefaults($toid, $this->config);
				}
			}

			// ##################################################################################################
			// email notification
			// ##################################################################################################

			if ($sendnotification) {
				$currentlyonline = uddeIMisOnline($toid);

				if ($this->config->cryptmode>=1) {
					$email = stripslashes($savemessage);
				} else {
					$email = stripslashes(stripslashes($savemessage));
				}

				$type = 0;
				if ($forceembedded)
					$type = 2;
				if ($this->config->allowemailnotify==1) {
					$ison = uddeIMgetEMNstatus($toid);
					if (($ison==1) || ($ison==2 && !$currentlyonline) || $ison==10 || ($ison==20 && !$currentlyonline)) {
						uddeIMdispatchEMN($insID, $item_id, $themode, $emn_fromid, $toid, $email, $type, $this->config);
					}
				} elseif($this->config->allowemailnotify==2) {
					$gid = uddeIMgetGID((int)$toid);
					if (uddeIMisAdmin($gid) || uddeIMisAdmin2($gid, $this->config)) {
						$ison = uddeIMgetEMNstatus($toid);
						if (($ison==1) || ($ison==2 && !$currentlyonline) || $ison==10 || ($ison==20 && !$currentlyonline)) {
							uddeIMdispatchEMN($insID, $item_id, $themode, $emn_fromid, $toid, $email, $type, $this->config);
						}
					}
				}
			}
		}
		return 0;
	}
}
