<?php
// ********************************************************************************************
// @title         udde Instant Messages (uddeIM)
// @description   Instant Messages System for Joomla 5
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

$uddeim_isadmin = 0;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	if (!file_exists(JPATH_SITE.'/components/com_uddeim/uddeim.php'))
		die( 'pms.uddeim: UddeIM main component not installed.' );
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
} else {
	global $mainframe;
	if (!file_exists($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeim.php'))
		die( 'pms.uddeim: UddeIM main component not installed.' );
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
}

require_once(uddeIMgetPath('admin')."/admin.shared.php");		// before includes.php is included!
require_once(uddeIMgetPath('user').'/includes.php');
require_once(uddeIMgetPath('user').'/includes.db.php');
require_once(uddeIMgetPath('user').'/crypt.class.php');
require_once(uddeIMgetPath('admin')."/config.class.php");			// get the configuration file

// 1: UddeIM 0.9

// nants delete user code (uncomment next line to activate it)
// $_PLUGINS->registerFunction( 'onAfterDeleteUser', 'userDeleted','getmypmsproTab' );

class getuddeimTab extends cbPMSHandler {

	var $config;
	var $absolute_path;
	var $mosConfig_lang;
	var $mosConfig_sitename;
	var $mosConfig_live_site;
	var $myuserid;
	var $mygroupid;

	function __construct() {
		if (method_exists($this, "cbPMSHandler"))
			$this->cbPMSHandler();
		else
			parent::__construct();
		$this->config = new uddeimconfigclass();
		$this->absolute_path = uddeIMgetPath('absolute_path');
		$this->mosConfig_lang = uddeIMgetLang();
		$this->mosConfig_sitename = uddeIMgetSitename();
		$this->mosConfig_live_site = uddeIMgetPath('live_site');
		$this->myuserid = uddeIMgetUserID();
		$this->mygroupid = uddeIMgetGroupID();

		uddeIMloadLanguage(uddeIMgetPath('admin'), $this->config);
	}
	function _setStatusMenuSBstats($sbConfig, $user, &$params, $sbUserDetails) {
	}
	function _checkPMSinstalled() {
		if (!file_exists($this->absolute_path.'/components/com_uddeim/uddeim.php')) {
			$this->_setErrorMSG(_UE_PMS_NOTINSTALLED);
			return false;
		}
		return true;
	}

	function _sendPMSuddesysMSG($udde_toid,$udde_fromid,$sub,$msg) {
		global $_CB_database; 

		$params = $this->params;
//echo "1:"; var_dump($this->params);
//echo "2:"; var_dump($params);
		// $doObfuscate = (int)$params->get('doObfuscate', '0');
		$doSingleEscape = (int)$params->get('doSingleEscape', '0');
		$doEscape = (int)$params->get('doEscape', '1');

//echo "doSingleEscape:"; var_dump($doSingleEscape);
//echo "doEscape:"; var_dump($doEscape); exit;

		require_once($this->absolute_path."/components/com_uddeim/crypt.class.php");

		$udde_sysm = "System";
		if ($this->config->sysm_username) {
			$udde_sysm = $this->config->sysm_username;		
		}
		// set the udde systemmessage username to the virtual sender
		if ($udde_fromid) {
			$udde_sysm = uddeIMgetNameFromID($udde_fromid, $this->config);
		}

		// format the message
		if($sub) {
			$udde_msg = "[b]".$sub."[/b]\n\n".$msg;
		} else {
			$udde_msg = $msg;
		}
		
		// now change the <strong> or <b> tags to BB Code
		$udde_msg = str_replace("<strong>","[b]",$udde_msg);
		$udde_msg = str_replace("<b>","[b]",$udde_msg);
		$udde_msg = str_replace("</strong>","[/b]",$udde_msg);
		$udde_msg = str_replace("</b>","[/b]",$udde_msg);
		
		// now change the links to BB code links
		$udde_msg = str_replace("<a href=\"", "[url=", $udde_msg);
		$udde_msg = str_replace("<a href=\\\"", "[url=", $udde_msg);		
		$udde_msg = str_replace("\">", "]", $udde_msg);
		$udde_msg = str_replace("\\\">", "]", $udde_msg);		
		$udde_msg = str_replace("</a>", "[/url]", $udde_msg);
		$udde_msg = str_replace("<br/>", "\n", $udde_msg);
		$udde_msg = str_replace("<br />", "\n", $udde_msg);
		$udde_msg = str_replace("<br>", "\n", $udde_msg);
		$udde_msg = str_replace("&amp;", "&", $udde_msg);
		
		// workaround
		// commands above made the closing bracket of the div to a ]
		// we change it back to a > here so that the next command can strip the div entirely
		$udde_msg = str_replace("cbNotice\\\"]", "cbNotice\\\">", $udde_msg);
		$udde_msg = str_replace("cbNotice]", "cbNotice\">", $udde_msg);
		$udde_msg = str_replace("cbNotice\\]", "cbNotice\">", $udde_msg);
		
		$udde_msg = strip_tags($udde_msg);

		$udde_time = uddetime($this->config->timezone);

		$udde_sysm = addslashes($udde_sysm);

		if ($this->config->cryptmode==1 ||
			$this->config->cryptmode==2 ||
			$this->config->cryptmode==4) {			// encryption not possible, so fall back to obfuscating
			$cm = $udde_msg;
			if (!$doSingleEscape) {
				$cm = $this->_uddeUnescapeCrypt($cm);
			}
			$cm = uddeIMencrypt($cm,$this->config->cryptkey,CRYPT_MODE_BASE64);
			$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, systemmessage, disablereply, cryptmode, crypthash) VALUES (".$udde_fromid.", ".$udde_toid.", '".$cm."', ".$udde_time.", '".$udde_sysm."', 0, 1,'".md5($this->config->cryptkey)."')";
		} else if ($this->config->cryptmode==3) {
			$cm = $udde_msg;
			if (!$doSingleEscape) {
				$cm = $this->_uddeUnescapeCrypt($cm);
			}
			$cm = uddeIMencrypt($cm,"",CRYPT_MODE_STOREBASE64);
			$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, systemmessage, disablereply, cryptmode, crypthash) VALUES (".$udde_fromid.", ".$udde_toid.", '".$cm."', ".$udde_time.", '".$udde_sysm."', 0, 1,'".md5($this->config->cryptkey)."')";
		} else {
			$cm = $udde_msg;
			if (!$doSingleEscape) {
				$cm = $this->_uddeUnescape($cm);
			}
			if ($doEscape) {
				$cm = $_CB_database->getEscaped($cm);
			}
			$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, systemmessage, disablereply) VALUES (".$udde_fromid.", ".$udde_toid.", '".$cm."', ".$udde_time.", '".$udde_sysm."', 0)";
		}

		// escaping not necessary, already escaped before this internal function gets called now insert the message as system message 
		// REPLY IS NOT DISABLED AS THE SYSTEMMESSAGE USERNAME WILL CONTAIN A VALID USERNAME
		if($udde_fromid && $udde_toid) {
			$_CB_database->SetQuery($sql);
			if (!$_CB_database->execute()) {
				die("SQL error" . $_CB_database->stderr(true));
			}
			$insID = $_CB_database->insertid();
			
			$ismoderated = uddeIMgetEMNmoderated($udde_fromid);
			if ($ismoderated) { // && uddeIMisReggedOnly($my_gid)) {
				uddeIMupdateDelayed($udde_fromid, $insID, 1);
			}
			$this->_pmsUddeNotify($insID, $udde_fromid, $udde_toid, $udde_msg);
		}
	}

	function _sendPMSuddeimMSG($udde_toid,$udde_fromid,$sub,$msg) {
		global $_CB_database; 
		
		$params = $this->params;
		// $doObfuscate = (int)$params->get('doObfuscate', '0');
		$doSingleEscape = (int)$params->get('doSingleEscape', '0');
		$doEscape = (int)$params->get('doEscape', '1');

		// format the message
		if($sub) { // is actually impossible
			$udde_msg = "[b]".$sub."[/b]\n\n".$msg;
		} else {
			$udde_msg = $msg;
		}
		
		// now strip the remaining html tags
		$udde_msg = strip_tags($udde_msg);
		// escaping dangerous stuff not necessary, already escaped before this internal function gets called
		
		// get current time but recognize mosConfig Offset
		$udde_time = uddetime($this->config->timezone);
		
		if ($this->config->cryptmode==1 ||
			$this->config->cryptmode==2 ||
			$this->config->cryptmode==4) {			// encryption not possible, so fall back to obfuscating
			$cm = $udde_msg;
			if (!$doSingleEscape) {
				$cm = $this->_uddeUnescapeCrypt($cm);
			}
			$cm = uddeIMencrypt($cm,$this->config->cryptkey,CRYPT_MODE_BASE64);
   			$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, cryptmode, crypthash) VALUES (".$udde_fromid.", ".$udde_toid.", '".$cm."', ".$udde_time.",1,'".md5($this->config->cryptkey)."')";
		} else if ($this->config->cryptmode==3) {	// store base64 encoded
			$cm = $udde_msg;
			if (!$doSingleEscape) {
				$cm = $this->_uddeUnescapeCrypt($cm);
			}
			$cm = uddeIMencrypt($cm,"",CRYPT_MODE_STOREBASE64);
   			$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, cryptmode, crypthash) VALUES (".$udde_fromid.", ".$udde_toid.", '".$cm."', ".$udde_time.",1,'".md5($this->config->cryptkey)."')";
		} else {
			$cm = $udde_msg;
			if (!$doSingleEscape) {
				$cm = $this->_uddeUnescape($cm);
			}
			if ($doEscape) {
				$cm = $_CB_database->getEscaped($cm);
			}
			$sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum) VALUES (".$udde_fromid.", ".$udde_toid.", '".$cm."', ".$udde_time.")";
		}

		if($udde_fromid && $udde_toid) {
			$_CB_database->SetQuery($sql);
			if (!$_CB_database->execute()) {
				die("SQL error" . $_CB_database->stderr(true));
			}
			$insID = $_CB_database->insertid();
			$ismoderated = uddeIMgetEMNmoderated($udde_fromid);
			if ($ismoderated) { // && uddeIMisReggedOnly($my_gid)) {
				uddeIMupdateDelayed($udde_fromid, $insID, 1);
			}
			$this->_pmsUddeNotify($insID, $udde_fromid, $udde_toid, $udde_msg);
		}
	}
	
	/**
	* Sends a PMS message
	* @param int userId of receiver (ESCAPED)
	* @param int userId of sender (ESCAPED)
	* @param string subject of PMS message (ESCAPED Subject) 
	* @param string body of PMS message (html, ESCAPED Body)
	* @param boolean false: real user-to-user message = default; true: system-Generated by an action from user $fromid (if non-null)
	* @param boolean false: subject and message body UNESCAPED = default; true: ESCAPED
	* @return boolean : true for OK, or false if ErrorMSG generated. Special error: _UE_PMS_TYPE_UNSUPPORTED : if anonym fromid>=0 sysgenerated unsupported
	*/
	function sendUserPMS($toid, $fromid, $subject, $message, $systemGenerated=false, $fromName = null, $fromEmail = null) {      //, org. with $escaped=false
		global $_CB_database;

		if (!$this->_checkPMSinstalled()) {
			return false;
		}

		$toid	= (int) $toid;
		$fromid	= (int) $fromid;
		//if (!$escaped) {
			$subject = $_CB_database->getEscaped($subject);
			$message = $_CB_database->getEscaped($message);
		//}

		if($systemGenerated || !$fromid) {
			$this->_sendPMSuddesysMSG($toid,$fromid,$subject,$message);
		} else {
			$this->_sendPMSuddeimMSG($toid,$fromid,$subject,$message);				
		}
		return true;
	}
	/**
	* returns all the parameters needed for a hyperlink or a menu entry to do a pms action
	* @param int userId of receiver
	* @param int userId of sender
	* @param string subject of PMS message
	* @param string body of PMS message
	* @param int kind of link: 1: link to compose new PMS message for $toid user. 2: link to inbox of $fromid user; 3: outbox, 4: trashbox,
	  5: link to edit pms options
	* @return mixed array of string {"caption" => menu-text ,"url" => NON-sefRelToAbs relative url-link, "tooltip" => description} or false and errorMSG
	*/
	function getPMSlink($toid, $fromid, $subject, $message, $kind) {

		if (!$this->_checkPMSinstalled()) {
			return false;
		}

		$pmsurlBase="index.php?option=com_uddeim";

		// first try to find a published link
		$item_id = uddeIMgetItemid($this->config);
		$pms_id = $item_id;
		$urlItemId = "";
		if ($pms_id) {
			$urlItemId = "&amp;Itemid=".$pms_id;
		}

		switch( $kind ) {
			case 1: // Send PM
				return array(	'caption'	=>	_UDDEIM_PM_USER,
								'url'		=>	$pmsurlBase . '&amp;task=new&amp;recip=' . (int) $toid . $urlItemId,
								'tooltip'	=>	_UDDEIM_PM_USER_DESC
							);
				break;
			case 2: // Inbox
				return array(	'caption'	=>	_UDDEIM_PM_INBOX,
								'url'		=>	$pmsurlBase . '&amp;task=inbox' . $urlItemId,
								'tooltip'	=>	_UDDEIM_PM_INBOX_DESC
							);
				break;
			case 3: // Outbox
				return array(	'caption'	=>	_UDDEIM_PM_OUTBOX,
								'url'		=>	$pmsurlBase . '&amp;task=outbox' . $urlItemId,
								'tooltip'	=>	_UDDEIM_PM_OUTBOX_DESC
							);
				break;
			case 4: // Trashcan
				return array(	'caption'	=>	_UDDEIM_PM_TRASHBOX,
								'url'		=>	$pmsurlBase . '&amp;task=trashcan' . $urlItemId,
								'tooltip'	=>	_UDDEIM_PM_TRASHBOX_DESC
							);
				break;
			case 5: // Options
				return array(	'caption'	=>	_UDDEIM_PM_OPTIONS,
								'url'		=>	$pmsurlBase . '&amp;task=settings' . $urlItemId,
								'tooltip'	=>	_UDDEIM_PM_OPTIONS_DESC
							);
				break;
			case 6: // Archive
				return array(	'caption'	=>	_UDDEIM_PM_ARCHIVE,
								'url'		=>	$pmsurlBase . '&amp;task=archive' . $urlItemId,
								'tooltip'	=>	_UDDEIM_PM_ARCHIVE_DESC
							);
				break;
		}

		$this->_setErrorMSG("Function not supported by this PMS type");
		return false;
	}
	/**
	* gets PMS system capabilities
	* @return mixed array of string {"subject" => boolean ,"body" => boolean} or false if ErrorMSG generated
	*/
	function getPMScapabilites() {
		if (!$this->_checkPMSinstalled()) {
			return false;
		}
		
		$capacity = array( "subject" => true, "body" => true);
		return $capacity;
	}
	/**
	* gets PMS unread messages count
	* @param	int user id
	* @return	mixed number of messages unread by user $userid or false if ErrorMSG generated
	*/
	function getPMSunreadCount($userid) {
		if (!$this->_checkPMSinstalled()) {
			return false;
		}
		return uddeIMgetInboxCount( $userid, 0, 1 );
	}

	/**
	* Generates the HTML to display the user profile tab
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayTab($tab,$user,$ui) {
		global $_POST, $_CB_OneTwoRowsStyleToggle, $_CB_database;

		$myself = $this->myuserid;
		if (!$myself) {
			return null;
		}

		$usermy = uddeIMgetMy();
		$return = "";

		$params = $this->params;
		$showTitle		= $params->get('showTitle', "1");
		$showSubject	= $params->get('showSubject', "1");
		$width			= $params->get('width', "30");
		$height			= $params->get('height', "5");

		$capabilities = $this->getPMScapabilites();

		if (!$this->_checkPMSinstalled() || ($capabilities === false)) {
			return false;
		}
		if ($myself == $user->id) {		// do not send messages to myself
			return null;
		}

		$my_gid = uddeIMgetGID($myself);	// ARRAY(!))

		// now check banning
		if (uddeIMisReggedOnly($my_gid)) {	// I am a registered user, so check if the recipient has been banned
			$is_banned = uddeIMisBanned((int)$user->id, $this->config);
			if ($is_banned) {
				return null;
			}
		}

		// now check blocking
		$isblocked = uddeIMcheckBlockerBlocked((int)$user->id, $myself);
		if ($isblocked && $this->config->blocksystem) {
			return null;
		}

		// now check group blocking
		if (uddeIMisReggedOnly($my_gid)) {	// I am a registered user, so check if I am allowed to send to this group
			$is_group_blocked = uddeIMisRecipientBlockedReg($myself, $user->id, $this->config);
			if ($is_group_blocked) {
				return null;
			}
		}
		
		$newsub = null;
		$newmsg = null;

		// send PMS from this tab form input:
		if ( cbGetParam( $_POST, $this->_getPagingParamName("sndnewmsg") ) == _UDDEIM_PM_SENDMESSAGE ) {
			$sender = $this->_getReqParam("sender", null);
			$recip = $this->_getReqParam("recip", null);
			if ( $sender && $recip && ($sender==$myself) && ($recip==$user->id) ) {
				$newsub = htmlspecialchars($this->_getReqParam("newsub", ''));	//urldecode done in _getReqParam
				$newmsg = $this->_getReqParam("newmsg", null);
//				$newmsg = htmlspecialchars($this->_getReqParam("newmsg", null));	//don't allow html input on user profile!

				if ( ( $newsub || $newmsg ) && isset( $_POST[$this->_getPagingParamName( "protect" )] ) ) {
					$parts	=	explode( '_', $this->_getReqParam('protect', '' ) );

					if ((count($parts)==3) && ($parts[0]=='cbpms1') && (strlen($parts[2])==32) && ($parts[1]==md5($parts[2].$user->id.$user->lastvisitDate.$usermy->password.$usermy->lastvisitDate))) {
						if (!$newsub && $capabilities["subject"]) $newsub = _UDDEIM_PM_PROFILEMSG;
						if ($this->sendUserPMS($recip, $sender, $newsub, $newmsg, $systemGenerated=false, $escaped=true)) {
							$return .= "\n<script type='text/javascript'>alert('"._UDDEIM_PM_SENTSUCCESS."')</script>";
							$newsub = null;
							$newmsg = null;
						} else {
							$return .= "\n<script type='text/javascript'>alert('".$this->getErrorMSG()."')</script>";
						}
					} else {
						$return .= "\n<script type='text/javascript'>alert('"._UDDEIM_PM_SESSIONTIMEOUT." "._UDDEIM_PM_NOTSENT." "._UDDEIM_PM_TRYAGAIN."')</script>";
					}
				} else {
					$return .= "\n<script type='text/javascript'>alert('"._UDDEIM_PM_EMPTYMESSAGE." "._UDDEIM_PM_NOTSENT."')</script>";
				}
			}
		}

		// display Quick Message tab:
		$return .= "\n\t<div class=\"sectiontableentry".$_CB_OneTwoRowsStyleToggle."\" style=\"padding-bottom:5px;\">\n";
		$_CB_OneTwoRowsStyleToggle = ($_CB_OneTwoRowsStyleToggle == 1 ? 2 : 1);
		if($showTitle) $return .= "\t\t<div class=\"titleCell\" style=\"align: left; text-align:left; margin-left: 0px;\">"
							.$this->_unHtmlspecialchars($this->_getLangDefinition($tab->title)).(($showSubject && $capabilities["subject"])?"" : ":")."</div>\n";
		$return .= $this->_writeTabDescription( $tab, $user );

		$base_url = $this->_getAbsURLwithParam(array());
		$return .= '<form method="post" action="'.$base_url.'">';
		$return .= '<table cellspacing="0" cellpadding="5" class="contentpane" style="border:0px;align:left;width:90%;">';
		if ($showSubject && $capabilities["subject"]) {
			$return .= '<tr><td><b>'._UDDEIM_PM_EMAILFORMSUBJECT.'</b></td>';
			$return .= '<td><input type="text" class="inputbox" name="'.$this->_getPagingParamName("newsub")
					.'" size="'.($width-8).'" value="'.stripslashes($newsub ?? '').'" /></td></tr>';
			$return .= '<tr><td colspan="2"><b>'._UDDEIM_PM_EMAILFORMMESSAGE.'</b></td></tr>';
		}
		$return .= '<tr><td colspan="2"><textarea name="'.$this->_getPagingParamName("newmsg")
				.'" class="inputbox" rows="'.$height.'" cols="'.$width.'">'.stripslashes($newmsg ?? '').'</textarea></td></tr>';
		$return .= '<tr><td colspan="2"><input type="submit" class="button" name="'.$this->_getPagingParamName("sndnewmsg").'" value="'._UDDEIM_PM_SENDMESSAGE.'" /></td></tr>';
		$return .= '</table>';
		$return .= "<input type=\"hidden\"  name=\"".$this->_getPagingParamName("sender")."\" value=\"$myself\" />";
		$return .= "<input type=\"hidden\"  name=\"".$this->_getPagingParamName("recip")."\" value=\"$user->id\" />";

		$salt	=	cbMakeRandomString( 32 );
		$return .= "<input type=\"hidden\"  name=\"".$this->_getPagingParamName("protect")."\" value=\""
				. 'cbpms1_' . md5($salt.$user->id.$user->lastvisitDate.$usermy->password.$usermy->lastvisitDate) . '_' . $salt . "\" />";

		$return .= '</form>';
		$return .= "</div>";

		return $return;
	}
	
	//****************************************************************************
	// UddeIM specific private methods:
	
	/**
	 * Udde PMS notification by email depending on user's settings
	 *
	 * @access private
	 * @param int $savefromid
	 * @param int $savetoid
	 * @param string $savemessage
	 */

	function _pmsUddeNotify($var_msgid, $savefromid, $savetoid, $savemessage) {
		
		$item_id = uddeIMgetItemid($this->config);

		if (!uddeIMexistsEMN($savetoid))
			uddeIMinsertEMNdefaults($savetoid, $this->config);

		$ismoderated = uddeIMgetEMNmoderated($savefromid);
		$itisareply = stristr($savemessage, $this->config->quotedivider);
		$currentlyonline = uddeIMisOnline($savetoid);
		
		$savemessage = $this->_pmsMailcompatible($savemessage);

		if($this->config->allowemailnotify==1 && !$ismoderated) {
			$ison = uddeIMgetEMNstatus($savetoid);
			if (($ison==1) || ($ison==2 && !$currentlyonline) || ($ison==10 && !$itisareply) || ($ison==20 && !$currentlyonline && !$itisareply))  {
				uddeIMdispatchEMN($var_msgid, $item_id, 0, $savefromid, $savetoid, $savemessage, 0, $this->config);  // 0=cryptmode, 0=stands for normal (not forgetmenot)
			}
		} elseif($this->config->allowemailnotify==2 && !$ismoderated) {
			$rec_gid = uddeIMgetGID((int)$savetoid);
			if (uddeIMisAdmin($rec_gid)) {
				$ison = uddeIMgetEMNstatus($savetoid);
				if (($ison==1) || ($ison==2 && !$currentlyonline) || ($ison==10 && !$itisareply) || ($ison==20 && !$currentlyonline && !$itisareply))  {
					uddeIMdispatchEMN($var_msgid, $item_id, 0, $savefromid, $savetoid, $savemessage, 0, $this->config);  // 0=cryptmode, 0=stands for normal (not forgetmenot)
				}
			}
		}
	}

	function _pmsMailcompatible($string) {
	    if ($string) {
		$string = str_replace('\\n', '#!CRLF!#', $string);
		$string = stripslashes($string);
	    $string = preg_replace("/(\[b\])(.*?)(\[\/b\])/si","\\2",$string);
	    $string = preg_replace("/(\[u\])(.*?)(\[\/u\])/si","\\2",$string);
		$string = preg_replace("/(\[i\])(.*?)(\[\/i\])/si","\\2",$string);
		$string = preg_replace("/\[size=([1-7])\](.+?)\[\/size\]/si","\\2",$string);
		$string = preg_replace("%\[color=(.*?)\](.*?)\[/color\]%si","\\2",$string);
		$string = preg_replace("/(\[ul\])(.*?)(\[\/ul\])/si","\\2",$string);
		$string = preg_replace("/(\[ol\])(.*?)(\[\/ol\])/si","\\2",$string);
		$string = preg_replace("/(\[li\])(.*?)(\[\/li\])/si","\\2\\n",$string);
		$string = preg_replace('/\[url\](.*?)javascript(.*?)\[\/url\]/si','',$string);
		$string = preg_replace('/\[url=(.*?)javascript(.*?)\](.*?)\[\/url\]/si','',$string);
		$string = preg_replace("/\[url\](.*?)\[\/url\]/si","\\1",$string);
		$string = preg_replace("/\[url=(.*?)\](.*?)\[\/url\]/si","\\2 (\\1)",$string);	
		$string = preg_replace("/\[url=(.*?)\]/si","",$string);	
		$string = preg_replace("/\[img size=([0-9][0-9][0-9])\](.*?)\[\/img\]/si","",$string);
		$string = preg_replace("/\[img size=([0-9][0-9])\](.*?)\[\/img\]/si","",$string);
		$string = preg_replace("/\[img\](.*?)\[\/img\]/si","",$string);
		$string = preg_replace("/<img(.*?)javascript(.*?)>/si",'',$string);	
		$string = preg_replace("/\[img size=([0-9][0-9][0-9])\]]/si","",$string);
		$string = preg_replace("/\[img size=([0-9][0-9])\]]/si","",$string);
		$string = str_replace(array("[i]","[/i]","[b]","[/b]","[u]","[/u]","[ul]","[/ul]","[ol]","[/ol]","[li]","[/li]"), "", $string);
	    $string = preg_replace('/\[url=(.*?)javascript(.*?)\]/si','',$string);	
	    $string = preg_replace("/\[img size=([0-9][0-9][0-9])\]/si","",$string);
	    $string = preg_replace("/\[img size=([0-9][0-9])\]/si","",$string);
	    $string = preg_replace("/\[size=([1-7])\]/si","",$string);
	    $string = preg_replace("%\[color=(.*?)\]%si","",$string);
		$string = str_replace(array("[img]","[/img]","[url]","[/url]","[/color]","[/size]"), "", $string);
		$string = str_replace("#!CRLF!#", "\n", $string);
        }
		return $string;
	}	
		
	// nants delete user code (not yet activated)
	function userDeleted($user, $success) {
		global $_CB_database;

		if (!$this->_checkPMSinstalled()) {
			return false;
		}

		$query_pms_delete = "DELETE FROM `#__uddeim` WHERE fromid='" . (int) $user->id ."' OR toid='" . (int) $user->id . "'";
		$query_pms_delete_extra1 = "DELETE FROM `#__uddeim_emn` WHERE userid='" . (int) $user->id . "'";
		$query_pms_delete_extra2 = "DELETE FROM `#__uddeim_blocks` WHERE blocker='" . (int) $user->id . "' OR blocked='" . (int) $user->id . "'";

		print "Deleting pms data for user ".$user->id;
		$_CB_database->setQuery( $query_pms_delete );
		if (!$_CB_database->execute()) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete . $_CB_database->stderr(true));
			return false;			
		}
		$_CB_database->setQuery( $query_pms_delete_extra1 );
		if (!$_CB_database->execute()) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete_extra1 . $_CB_database->stderr(true));
			return false;			
		}			
		$_CB_database->setQuery( $query_pms_delete_extra2 );
		if (!$_CB_database->execute()) {
			$this->_setErrorMSG("SQL error " . $query_pms_delete_extra2 . $_CB_database->stderr(true));
			return false;			
		}			
		return true;
	}

	function _uddeUnescapeCrypt($cm) {
		$cm = str_replace("\\\\", "&backslash;", $cm);	// protect escaped slashes
		$cm = str_replace("\\n", "\n", $cm);			// convert newlines to "real" newlines
		$cm = str_replace("\\r", "\r", $cm);
		$cm = str_replace("&backslash;", "\\\\", $cm);	// back to slashes
		return $cm;
	}

	function _uddeUnescape($cm) {
		return $cm;
	}

	function _unHtmlspecialchars( $text ) {
		return str_replace( array( "&amp;", "&quot;", "&#039;", "&lt;", "&gt;" ), array( "&", "\"", "'", "<", ">" ), $text );
	}

	function _getLangDefinition($text) {
		// check for '::' as a workaround of bug #42770 in PHP 5.2.4 with optimizers:
		if ( ( strpos( $text, '::' ) === false ) && defined( $text ) ) {
			$returnText		=	constant( $text ); 
		} else {
			$returnText		=	$text;
		}
		return $returnText;
	}
}
