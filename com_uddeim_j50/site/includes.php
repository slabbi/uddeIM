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

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

function uddeIMcheckCAPTCHA($my_gid, $config) {
	// CAPTCHA (first check for all other errors and then the CAPTCHA)
	if ( $config->usecaptcha>=4 ||													// all users (incl. admins)
		($config->usecaptcha==3 && !uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) ||						// CAPTCHA enabled for public frontend, registered and special users
		($config->usecaptcha==2 && !uddeIMisSpecial($my_gid) && !uddeIMisSpecial2($my_gid, $config)) ) {				// CAPTCHA enabled for public frontend and registered users (note: 0 is not required since this is done in public.php)

		if ($config->captchatype==0) {			
				$session = Factory::getApplication()->getSession(); 
				$_SESSION['security_code'] = $session->get('security_code');	// so I do not need to modify saveMessage code
			
			if( $_SESSION['security_code'] == strtolower($_POST['security_code']) && !empty($_SESSION['security_code'] ) ) {
				// CAPTCHA is correct, so unset security code
				$session->set('security_code', null);				
			} else {
				return false;
			}
		} 
		elseif ($config->captchatype==1) {
			//$pathtouser  = uddeIMgetPath('user');
			//require_once($pathtouser."/recaptchalib.php");
			//$resp = recaptcha_check_answer ($config->recaptchaprv,
                                      //$_SERVER["REMOTE_ADDR"],
                                      //$_POST["recaptcha_challenge_field"],
                                      //$_POST["recaptcha_response_field"]);		
			//if (!$resp->is_valid)
			$capinput = Factory::getApplication()->getInput()->get('eccl', '', 'RAW');
            			if (!CheckCaptcha($capinput,$config->timedelay))
                		return false;
		} 
		elseif ($config->captchatype==2) {
			if (isset($_POST['g-recaptcha-response'])) {
				$pathtouser  = uddeIMgetPath('user');
				require_once($pathtouser."/autoload.php");
				$recaptcha = new \ReCaptcha\ReCaptcha($config->recaptchaprv);
				// If file_get_contents() is locked down on your PHP installation to disallow
				// its use with URLs, then you can use the alternative request method instead.
				// This makes use of fsockopen() instead.
				//  $recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\SocketPost());
				// Make the call to verify the response and also pass the user's IP address
				$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
				if (!$resp->isSuccess())
					return false;
			}
		}
	}
	return true;
}

function uddeIMwriteCSRF($config) {
	if ($config->csrfprotection) {
		$code = md5(uniqid(rand(),true));
		if (class_exists('Joomla\CMS\Factory')) {
			$session = Factory::getSession();
			$session->set('csrf_code', $code);
		} else {
			session_start();
			$_SESSION['csrf_code'] = $code;
		}
		echo "<input type='hidden' name='csrf_token' value='".$code."' />";
	}
}

function uddeIMcheckCSRF($config) {
	if ($config->csrfprotection) {
		if (class_exists('Joomla\CMS\Factory')) {
			$session = Factory::getSession();
			$_SESSION['csrf_code'] = $session->get('csrf_code');	// so I do not need to modify saveMessage code
		} else {
			session_start();
		}
		if( $_SESSION['csrf_code'] == $_POST['csrf_token'] && !empty($_SESSION['csrf_code'] ) ) {
			if (class_exists('Joomla\CMS\Factory')) {
				$session = Factory::getSession();
				$session->set('csrf_code', null);
			} else {
				unset($_SESSION['csrf_code']);
			}
		} else {
			return false;
		}
	}
	return true;
}

function uddeIMmb_mime_header($string, $config, $encoding=null) {
	if (!$encoding)
		$encoding = uddeIMgetCharsetMailalias($config->mailcharset);
	$encoded = "=?$encoding?B?". base64_encode($string) ."?=";
	return $encoded;
}

function uddeIMsendmail($fromname, $frommail, $toname, $tomail, $subject, $message, $replyto, $replytoname, $addheaders, $config) {
	$mosConfig_sitename = uddeIMgetSitename();
	$ret = false;
	$temp = $fromname;				// was '"'.$fromname.'"';
	if ($config->encodeheader)
		$temp = uddeIMmb_mime_header($temp, $config);

	$header  = "From: ".$temp." <".$frommail.">\n";
	$header .= "Organization: ".$mosConfig_sitename."\n";
	$header .= "User-Agent: uddeIM PMS\n";
	$header .= "MIME-Version: 1.0\n";
	$header .= "Content-type: text/plain; charset=".uddeIMgetCharsetMailalias($config->mailcharset)."\n";
	$header .= "Content-Transfer-Encoding: 8bit\n";

	if ($config->encodeheader)
		$subject = uddeIMmb_mime_header($subject, $config);

	$header .= $addheaders;

	if ($config->mailsystem==1) {			// mosMail
		$ret = uddeIMmosMail($frommail, $fromname, $tomail, $subject, $message, false, NULL, NULL, NULL, $replyto, NULL);
	} else {								//php mail
		if ($replyto)
			$header .= "Reply-To: ".$replyto."\n";
        if ($config->mailsystem ==4)  //force \r\n
            $header = str_replace('\n','\r\n',$header);

		$ret = mail($tomail,$subject,$message,$header);
        }
	return $ret.' - (1 =sent, 0 =error)&emsp;to:&emsp;'.$tomail.'<br><b>subject:</b>&emsp;'.$subject.'<br>full text:&emsp;'.$message.'<br><b>Header:</b>&emsp;'.$header;  //debug line;
}

function uddeIMisPublicUser($name, $id) {
	if ($name==NULL && !$id)
		return 1;
	return 0;
}

function uddeIMisDeletedUser($name, $id) {
	if ($name==NULL && $id)
		return 1;
	return 0;
}

function uddeIMevaluateUsername($fromname, $fromid, $publicname) {
	$back = NULL;
	if ($fromname==NULL && !$fromid) {
		if (!$publicname || $publicname==NULL)
			$back = _UDDEIM_PUBLICUSER;
		else
			$back = $publicname;
	} elseif ($fromname==NULL) {
		if (!$publicname || $publicname==NULL)			// maybe we have the original name still stored here
			$back = _UDDEIM_DELETEDUSER;
		else
			$back = $publicname;
	} else
		$back = $fromname;
	return $back;
}

function uddeIMisRecipientBlockedPublic($toid, $config) {
	$togid = Array(-1);		// default group (uddeim intern) for public users
	if ($toid)				// we have an id, so get group for this user
		$togid = uddeIMgetGID($toid);
	//if (!is_array($togid))
	//	$togid = -1;	// we could not find a group, so assume it is a Public user
	$acl = explode(",",$config->pubblockgroups ?? '');
	if (!is_array($acl))
		$acl = array();

	$blocked = 0;
	$new = array_intersect($togid, $acl);	// either we have a recipient GID or recipient is a Public user (GID=-1), so we check if this user is blocked
	if (!empty($new))
		$blocked = 1;				// yes, it is
	return $blocked;
}

function uddeIMisRecipientBlockedReg($myself, $toid, $config) {
	$database = uddeIMgetDatabase();
	$togid = Array(-1);		// default group (uddeim intern) for public users
	if ($toid)				// we have an id, so get group for this user
		$togid = uddeIMgetGID($toid);
	// if (!$togid)
	// 	$togid = -1;	// we could not find a group, so assume it is a Public user
	$acl = explode(",",$config->blockgroups ?? '');
	if (!is_array($acl))
		$acl = array();

	$blocked = 0;
	$new = array_intersect($togid, $acl);	// either we have a recipient GID or recipient is a Public user (GID=-1), so we check if this user is blocked
	if (!empty($new))
		$blocked = 1;				// yes, it is

	if ($blocked && $config->unblockCBconnections) {	// unblock CB connections?
		if (uddeIMcheckCB()) {							// do we have CB installed?
			// Am I on the recipients user list?
			$sql = "SELECT count(m.memberid) FROM `#__comprofiler_members` AS m, `#__users` AS u WHERE m.memberid=u.id AND u.block=0 AND m.referenceid=".(int)$toid." AND m.memberid=".(int)$myself;
			$database->setQuery($sql);
			$friends=(int)$database->loadResult();	// this person might be on the connections list
			if (!$friends) { 					// not on CB, maybe on CBE?
				if (uddeIMcheckCBE()) {
					$sql="SELECT count(m.buddyid) FROM `#__comprofiler_buddylist` AS m, `#__users` AS u WHERE m.buddyid=u.id AND u.block=0 AND m.userid=".(int)$toid." AND m.buddyid=".(int)$myself." AND buddy='1'";
					$database->setQuery($sql);
					$friends=(int)$database->loadResult();
				}
			}
			if ($friends>0)						// yes, its on the list, so allow as recipient
				$blocked = 0;
		} elseif (uddeIMcheckCBE2()) {
			$sql="SELECT count(m.buddyid) FROM `#__cbe_buddylist` AS m, `#__users` AS u WHERE m.buddyid=u.id AND u.block=0 AND m.userid=".(int)$toid." AND m.buddyid=".(int)$myself." AND buddy='1'";
			$database->setQuery($sql);
			$friends=(int)$database->loadResult();
			if ($friends>0)						// yes, its on the list, so allow as recipient
				$blocked = 0;
		}
	}
	return $blocked;
}

function uddeIMisAttachmentAllowed($mygid, $config) {
	$acl = explode(",",$config->attachmentgroups);
	if (!is_array($acl))
		$acl = array();
	$allowed = 0;
	$new = array_intersect($mygid, $acl);
	if (!empty($new))
		$allowed = 1;
	return $allowed;
}

function uddeIMisBanned($userid, $config) {
	$database = uddeIMgetDatabase();

	$is_banned = 0;
	if ($config->checkbanned) {
		if (uddeIMcheckCB()) {		// this is for CB and CBE (old), etxra check for CBE (old) is not required
			$sql = "SELECT banned FROM `#__comprofiler` WHERE user_id=".(int)$userid;
			$database->setQuery($sql);
			$is_banned=(int)$database->loadResult();
		} elseif (uddeIMcheckCBE2()) {
			$sql = "SELECT banned FROM `#__cbe` WHERE user_id=".(int)$userid;
			$database->setQuery($sql);
			$is_banned=(int)$database->loadResult();
		}
	}
	return $is_banned;
}

function uddeIMblockUserUdde($myself, $item_id, $recip, $ret, $config) {

    $task = ($ret=="postboxuser" && $config->enablepostbox)
		    ? "postboxuser"
            : "inbox";

    $addlink = $recip ? "&recip=".(int)$recip : "";

	if (!$config->blocksystem) {
		$mosmsg = _UDDEIM_BLOCKSDISABLED;
		uddeJSEFredirect("index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink, $mosmsg);
	}

	// is this user already blocked?
	$isblocked = uddeIMcheckBlockerBlocked($myself, $recip);
	if ($isblocked)
		uddeJSEFredirect("index.php?option=com_uddeim&task=settings&Itemid=".$item_id);

	$recip_gid = uddeIMgetGID($recip);
	if (uddeIMisAdmin($recip_gid) || uddeIMisAdmin2($recip_gid, $config)) {	
		$mosmsg = _UDDEIM_CANTBLOCKADMINS;
		uddeJSEFredirect("index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink, $mosmsg);
	}

	uddeIMinsertBlockerBlocked($myself, $recip);
	uddeJSEFredirect("index.php?option=com_uddeim&task=settings&Itemid=".$item_id);
}

function uddeIMunblockUserUdde($myself, $item_id, $recip, $ret, $config) {

    $task = ($ret=="postboxuser" && $config->enablepostbox)
		    ? "postboxuser"
            : "inbox";

    $addlink = $recip ? "&recip=".(int)$recip : "";

	if (!$config->blocksystem) {
		$mosmsg = _UDDEIM_BLOCKSDISABLED;
		uddeJSEFredirect("index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink, $mosmsg);
	}
	uddeIMpurgeBlockerBlocked($myself, $recip);
	uddeJSEFredirect("index.php?option=com_uddeim&task=settings&Itemid=".$item_id);
}

function uddeIMmarkUnread($myself, $messageid, $limit, $limitstart, $item_id, $recip, $ret, $config) {

    uddeIMupdateToread($myself, $messageid, 0);		// previously it set also "totrash=0" which is not required

    if ($ret=="postboxclick")
    return;

    $task = ($ret == 'postboxuser' && $config->enablepostbox)
            ? 'postboxuser'
            : 'inbox';

    $addlink = $recip ? "&recip=".(int)$recip : "";

	if(!$limit && !$limitstart) {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink;
	} else {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink."&limit=".$limit."&limitstart=".$limitstart;
	}
	uddeJSEFredirect($redirecturl);
}

function uddeIMmarkRead($myself, $messageid, $limit, $limitstart, $item_id, $recip, $ret, $config) {

    uddeIMupdateToread($myself, $messageid, 1);

    if ($ret=="postboxclick")
    return;

	$task = ($ret == 'postboxuser' && $config->enablepostbox)
            ? 'postboxuser'
            : 'inbox';

    $addlink = $recip ? "&recip=".(int)$recip : "";

	if(!$limit && !$limitstart) {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink;
	} else {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink."&limit=".$limit."&limitstart=".$limitstart;
	}
	uddeJSEFredirect($redirecturl);
}

function uddeIMmarkUnflagged($myself, $messageid, $limit, $limitstart, $item_id, $recip, $ret, $config) {

    uddeIMupdateFlagged($myself, $messageid, 0);

    if ($ret=="postboxclick")
    return;

	if ($ret=="postboxuser" && $config->enablepostbox)
		$task = "postboxuser";
	elseif($ret=='archive' && $config->allowarchive)
		$task = "archive";
    else
        $task="inbox";

    $addlink = $recip ? "&recip=".(int)$recip : "";

	if(!$limit && !$limitstart) {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink;
	} else {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink."&limit=".$limit."&limitstart=".$limitstart;
	}
	uddeJSEFredirect($redirecturl);
}

function uddeIMmarkFlagged($myself, $messageid, $limit, $limitstart, $item_id, $recip, $ret, $config) {

    uddeIMupdateFlagged($myself, $messageid, 1);

    if ($ret=="postboxclick")
    return;

	if ($ret=="postboxuser" && $config->enablepostbox)
		$task = "postboxuser";
	elseif($ret=='archive' && $config->allowarchive)
		$task = "archive";
    else
        $task="inbox";

    $addlink = $recip ? "&recip=".(int)$recip : "";

	if(!$limit && !$limitstart) {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink;
	} else {
		$redirecturl="index.php?option=com_uddeim&task=".$task."&Itemid=".$item_id.$addlink."&limit=".$limit."&limitstart=".$limitstart;
	}
	uddeJSEFredirect($redirecturl);
}

function uddeIMmenuWriteform($myself, $my_gid, $item_id, $to_name, $pmessage, $error, $config) {
	uddeIMprintMenu($myself, 'new', $item_id, $config);
	echo "<div id='uddeim-m'>\n";
	$to_name=stripslashes($to_name);
	$pmessage=stripslashes($pmessage);
	uddeIMdrawWriteform($myself, $my_gid, $item_id, "", $to_name, $pmessage, 0, 0, $error, 0, $config);
	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

function uddeIMshowNoMessage($type, $filter_user, $filter_unread, $filter_flagged) {
	if ($filter_user || $filter_unread || $filter_flagged) {
		echo "<div id='uddeim-overview'><p><b>";
		switch($type) {
			case 'postbox':	// $user = ($filter_unread ? _UDDEIM_NOMESSAGES2_UNFR_FILTERED : _UDDEIM_NOMESSAGES2_FR_FILTERED);
							$user = _UDDEIM_NOMESSAGES3_FILTERED;
							$box  = _UDDEIM_NOMESSAGES_FILTERED_POSTBOX;
							break;
			case 'inbox':	// $user = ($filter_unread ? _UDDEIM_NOMESSAGES2_UNFR_FILTERED : _UDDEIM_NOMESSAGES2_FR_FILTERED);
							$user = _UDDEIM_NOMESSAGES3_FILTERED;
							$box  = _UDDEIM_NOMESSAGES_FILTERED_INBOX;
							break;
			case 'outbox':	// $user = ($filter_unread ? _UDDEIM_NOMESSAGES2_UNTO_FILTERED : _UDDEIM_NOMESSAGES2_TO_FILTERED);
							$user = _UDDEIM_NOMESSAGES3_FILTERED;
							$box  = _UDDEIM_NOMESSAGES_FILTERED_OUTBOX;
							break;
			case 'archive':	// $user = ($filter_unread ? _UDDEIM_NOMESSAGES2_UNFR_FILTERED : _UDDEIM_NOMESSAGES2_FR_FILTERED);
							$user = _UDDEIM_NOMESSAGES3_FILTERED;
							$box  = _UDDEIM_NOMESSAGES_FILTERED_ARCHIVE;
							break;
		}
		$text = sprintf($user, $box);
		echo $text;
		echo "</b></p></div>\n";
	} else {
		switch($type) {
			case 'postbox':	$text = _UDDEIM_NOMESSAGES_POSTBOX;
							break;
			case 'inbox':	$text = _UDDEIM_NOMESSAGES_INBOX;
							break;
			case 'outbox':	$text = _UDDEIM_NOMESSAGES_OUTBOX;
							break;
			case 'archive':	$text = _UDDEIM_ARC_SAVED_NONE_2;
							break;
		}
		echo "<div id='uddeim-overview'><p><b>".$text."</b></p></div>\n";
	}
}

function uddeIMprintFilter($myself, $uddeaction, $count, $item_id, $config, $filter_user, $filter_unread, $filter_flagged) {
	$database = uddeIMgetDatabase();

	$showfilter = $config->enablefilter && ($uddeaction=="inbox" || $uddeaction=="outbox" || $uddeaction=="archive");
	$title = _UDDEIM_FILTER_TITLE_INBOX;	// for INBOX and ARCHIVE
	if ($uddeaction=="outbox") {
		$title = _UDDEIM_FILTER_TITLE_OUTBOX;
	} elseif ($uddeaction=="postbox") {
		$title = _UDDEIM_FILTER_TITLE_POSTBOX;
	}
	$users = uddeIMselectFilter($myself, $uddeaction, $config);

	echo "<div id='uddeim-filter'>";
	echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>";
	echo "<td align='left'>";
	if ($uddeaction=="postbox") {
		if ($filter_user || $filter_unread || $filter_flagged) {
			echo ($count==1 ? $count." "._UDDEIM_FILTEREDUSER : $count." "._UDDEIM_FILTEREDUSERS);
		} else {
			echo "&nbsp;";
		}
	} else {
		if ($filter_user || $filter_unread || $filter_flagged) {
			echo ($count==1 ? $count." "._UDDEIM_FILTEREDMESSAGE : $count." "._UDDEIM_FILTEREDMESSAGES);
		} else {
			echo "&nbsp;";
		}
	}
	echo "</td>";
	echo "<td align='right'>";
	echo "<form name='filterform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=".$uddeaction."&Itemid=".$item_id)."'>";
	echo "<span title='".$title."'>"._UDDEIM_FILTER."</span> ";
	echo "<select name='filter_user'>\n";
	echo "<option value='0'>"._UDDEIM_FILTER_ALL."</option>\n";
	if ($config->pubfrontend)
		echo "<option value='-1'".($filter_user==-1 ? " selected='selected'" : "").">"._UDDEIM_FILTER_PUBLIC."</option>\n";
	foreach ($users as $usr) {
		$sel = ($filter_user == $usr->id) ? " selected='selected'" : "";
		echo "<option value='".(int)$usr->id."'".$sel.">".$usr->displayname."</option>\n";
	}
	echo "</select>\n";
	$sel = ($filter_unread) ? " checked='checked'" : "";
	echo " <input type='checkbox' name='filter_unread'".$sel."/> " . _UDDEIM_FILTER_UNREAD;
	if($config->allowflagged) {
		if ($uddeaction!="outbox") {
			$sel = ($filter_flagged) ? " checked='checked'" : "";
			echo " <input type='checkbox' name='filter_flagged'".$sel."/> " . _UDDEIM_FILTER_FLAGGED;
		}
	}
	echo " <input type='submit' class='button' value='"._UDDEIM_FILTER_SUBMIT."' />";
	echo "</form>";
	echo "</td></tr></table>";
	echo "</div>";
}

function uddeIMprintMenu($myself, $uddeaction, $item_id, $config) {
	$pathtosite = uddeIMgetPath('live_site');
	$my_gid = $config->usergid;

	// write the uddeim title
	if ($config->showtitle)
		echo "<div class='contentheading'>".$config->showtitle."</div>";

	if ($config->showmenuicons==3)
		return;

	// write the uddeim menu
	echo "\n<div id='uddeim-navbar2'><ul>\n";

	if ( $config->enablepostbox ) {
		$cnt = "";
		if ($config->showmenucount)
			$cnt = " (".uddeIMgetInboxCount($myself, 0, true, 0)."/".uddeIMgetInboxCount($myself)."/".uddeIMgetOutboxCount($myself).")";
		if ($uddeaction=="postbox") {
			echo "<li class='uddeim-activemenu menu-postbox'><span>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_postbox.gif' alt='"._UDDEIM_POSTBOX."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_POSTBOX;
			echo $cnt;
			echo "</span>&ensp;</li>\n";
		} else {
			echo "<li class='menu-postbox'>";
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postbox&Itemid=".$item_id)."'>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_postbox.gif' border='0' alt='"._UDDEIM_POSTBOX."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_POSTBOX;
			echo $cnt;
			echo "</a>&ensp;";
			echo "</li>\n";
		}
	} else {
		$cnt = "";
		if ($config->showmenucount)
			$cnt = " (".uddeIMgetInboxCount($myself, 0, true, 0)."/".uddeIMgetInboxCount($myself).")";
		if ($uddeaction=="inbox") {
			echo "<li class='uddeim-activemenu menu-inbox'><span>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_inbox.gif' alt='"._UDDEIM_INBOX."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_INBOX;
			echo $cnt;
			echo "</span>&ensp;</li>\n";
		} else {
			echo "<li class='menu-inbox'>";
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id)."'>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_inbox.gif' border='0' alt='"._UDDEIM_INBOX."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_INBOX;
			echo $cnt;
			echo "</a>&ensp;";
			echo "</li>\n";
		}

		$cnt = "";
		if ($config->showmenucount)
			$cnt = " (".uddeIMgetOutboxCount($myself).")";
		if ($uddeaction=="outbox") {
			echo "<li class='uddeim-activemenu menu-outbox'><span>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_outbox.gif' alt='"._UDDEIM_OUTBOX."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_OUTBOX;
			echo $cnt;
			echo "</span>&ensp;</li>\n";
		} else {
			echo "<li class='menu-outbox'>";
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=outbox&Itemid=".$item_id)."'>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_outbox.gif' border='0' alt='"._UDDEIM_OUTBOX."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_OUTBOX;
			echo $cnt;
			echo "</a>&ensp;";
			echo "</li>\n";
		}
	}

    if ($uddeaction=="new") {
		echo "<li class='uddeim-activemenu menu-new'><span>";
		if ($config->showmenuicons==1 || $config->showmenuicons==2)
			echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_new.gif' alt='"._UDDEIM_COMPOSE."' />";
		if ($config->showmenuicons==0 || $config->showmenuicons==1)
			echo _UDDEIM_COMPOSE;
		echo "</span>&ensp;</li>\n";
	} else {
		echo "<li class='menu-new'>";
		echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=new&Itemid=".$item_id)."'>";
		if ($config->showmenuicons==1 || $config->showmenuicons==2)
			echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_new.gif' border='0' alt='"._UDDEIM_COMPOSE."' />";
		if ($config->showmenuicons==0 || $config->showmenuicons==1)
			echo _UDDEIM_COMPOSE;
		echo "</a>&ensp;";
		echo "</li>\n";
	}

	$cnt = "";
	if ($config->showmenucount) {
		$rightnow=uddetime($config->timezone);
		$offset=((float)$config->TrashLifespan) * 86400;
		$timeframe=$rightnow-$offset;
		$cnt = " (".uddeIMgetTrashcanCount($myself, $timeframe).")";
	}
	if ($uddeaction=="trashcan") {
		echo "<li class='uddeim-activemenu menu-trashcan'><span>";
		if ($config->showmenuicons==1 || $config->showmenuicons==2)
			echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_trashcan.gif' alt='"._UDDEIM_TRASHCAN."' />";
		if ($config->showmenuicons==0 || $config->showmenuicons==1)
			echo _UDDEIM_TRASHCAN;
		echo $cnt;
		echo "</span>&ensp;</li>\n";
	} else {
		if( ($config->trashrestriction==0) ||
			($config->trashrestriction==1 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) || 
			($config->trashrestriction==2 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) ) {
			echo "<li class='menu-trashcan'>";
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=trashcan&Itemid=".$item_id)."'>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_trashcan.gif' border='0' alt='"._UDDEIM_TRASHCAN."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_TRASHCAN;
			echo $cnt;
			echo "</a>&ensp;";
			echo "</li>\n";
		}
	}

	$cnt = "";
	if ($config->showmenucount)
		$cnt = " (".uddeIMgetArchiveCount($myself).")";
	if ($uddeaction=="archive") {
		echo "<li class='uddeim-activemenu menu-archive'><span>";
		if ($config->showmenuicons==1 || $config->showmenuicons==2)
			echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_archive.gif' alt='"._UDDEIM_ARCHIVE."' />";
		if ($config->showmenuicons==0 || $config->showmenuicons==1)
			echo _UDDEIM_ARCHIVE;
		echo $cnt;
		echo "</span>&ensp;</li>\n";
	} else {
		if ($config->allowarchive) {
			echo "<li class='menu-archive'>";
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archive&Itemid=".$item_id)."'>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_archive.gif' border='0' alt='"._UDDEIM_ARCHIVE."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_ARCHIVE;
			echo $cnt;
			echo "</a>&ensp;";
			echo "</li>\n";
		}
	}

	if ($uddeaction=="lists") {
		echo "<li class='uddeim-activemenu menu-book'><span>";
		if ($config->showmenuicons==1 || $config->showmenuicons==2)
			echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_book.gif' alt='"._UDDEIM_LISTS."' />";
		if ($config->showmenuicons==0 || $config->showmenuicons==1)
			echo _UDDEIM_LISTS;
		echo "</span>&ensp;</li>\n";
	} else {
		if($config->allowmultiplerecipients &&
		   (($config->enablelists==1) ||
			($config->enablelists==2 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) || 
			($config->enablelists==3 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) )
		  ) {
			echo "<li class='menu-book'>";
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showlists&Itemid=".$item_id)."'>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_book.gif' border='0' alt='"._UDDEIM_LISTS."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_LISTS;
			echo "</a>&ensp;";
			echo "</li>\n";
		}
	}

	if ($uddeaction=="settings") {
		if ($config->showsettingslink==1) {
			echo "<li class='uddeim-activemenu menu-settings'><span>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_settings.gif' alt='"._UDDEIM_SETTINGS."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_SETTINGS;
			echo "</span>&ensp;</li>\n";
		}
	} else {
		$showsettings = 0;
		if ($config->showsettingslink==1) {
			if ($config->pubfrontend || $config->allowpopup || $config->blocksystem || 
				$config->allowemailnotify==1 || 
			   ($config->allowemailnotify==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))) ||
				$config->autoresponder==1 ||
			   ($config->autoresponder==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))) ||
				$config->autoforward==1 ||
			   ($config->autoforward==2 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) ||
			   ($config->autoforward==3 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) ||
			    $config->enablerss==1 || 
			   ($config->enablerss==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))) )
				$showsettings = 1;
		}
		if ($showsettings) {
			echo "<li class='menu-settings'>";
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=settings&Itemid=".$item_id)."'>";
			if ($config->showmenuicons==1 || $config->showmenuicons==2)
				echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_settings.gif' border='0' alt='"._UDDEIM_SETTINGS."' />";
			if ($config->showmenuicons==0 || $config->showmenuicons==1)
				echo _UDDEIM_SETTINGS;
			echo "</a>&ensp;";
			echo "</li>\n";
		}
	}

	// Add menu forum Kunena 
	if (uddeIMcheckKU() && in_array($config->showmenulink, array(15, 16))) {
		$cnt = "";
		echo "<li class='menu-forum'>";
		echo "<a href='".$pathtosite."/index.php?option=com_kunena'>"; //".uddeIMsefRelToAbs("
		if ($config->showmenuicons==1 || $config->showmenuicons==2)
			echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_next.gif' border='0' alt='"._UDDEIM_KUNENA_LINK."' />";
		if ($config->showmenuicons==0 || $config->showmenuicons==1)
			echo _UDDEIM_KUNENA_LINK;
		echo $cnt; 
		echo "</a>"; 
		echo "</li>\n"; 
	}
	// End of add menu forum Kunena

	echo "</ul></div>\n";
}

function uddeIMcontentBottomborder($myself, $item_id, $uddemenucontent, $messagetotal, $config) {
	$zurueck="";
	$my_gid = $config->usergid;

	if ($uddemenucontent!="settings") {	// do not show on settings page
		$showsettings = 0;
		if ($config->showsettingslink==2) {
			if ($config->pubfrontend || $config->allowpopup || $config->blocksystem || 
				$config->allowemailnotify==1 || 
			   ($config->allowemailnotify==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))) ||
				$config->autoresponder==1 ||
			   ($config->autoresponder==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))) ||
				$config->autoforward==1 ||
			   ($config->autoforward==2 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) ||
			   ($config->autoforward==3 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) )
				$showsettings = 1;
		}
		if ($showsettings) {
			$zurueck="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=settings&Itemid=".$item_id)."'>"._UDDEIM_SETTINGS."</a> ";
		}
	}

	if($config->showabout && $uddemenucontent!="about") {
		$zurueck.="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=about&Itemid=".$item_id)."'>"._UDDEIM_ABOUT."</a> ";
	}
	if($config->showhelp && $uddemenucontent!="help") {
		$zurueck.="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=help&Itemid=".$item_id)."'>"._UDDEIM_HELP."</a> ";
	}

	// BUGBUG this is displayed when $config->showinboxlimit is enabled: Planned for future:
	// New setting: "Show inbox/archive statusline" and $config->showinboxlimit should display a percent bar at the top in "uddeim-toplines"
	if($messagetotal && $messagetotal!='none' && $config->showinboxlimit) {
		$zurueck.="<span class='uddeim-limit-bb'>".$messagetotal."</span>";
	}
	return $zurueck;
}

// *****************************************************************************************

function uddeIMreminderDispatch($item_id, $config) {
	$database = uddeIMgetDatabase();
	// send reminder if forgetmenot is activated
	if ($config->longwaitingemail && $config->longwaitingdays>0) {
		if(!$config->forgetmenotstart) {
			$config->forgetmenotstart=0;
		}
		$rightnow=uddetime($config->timezone);
		$sincewhen=$rightnow-($config->longwaitingdays*86400);
		// $sql="SELECT * FROM `#__uddeim` WHERE toread=0 AND totrash=0 AND datum<".$sincewhen;
		// $sql="SELECT * FROM `#__uddeim` WHERE toread=0 AND totrash=0 AND datum<".$sincewhen. " AND datum>".$config->forgetmenotstart;
		// select only messages from users which still exist in the database (public users and deleted users have no inbox and so we do not send forgetmenot mails)
		// only messages before "$sincewhen" can be forgetmenot messages
		// $sql = "SELECT a.* FROM `#__uddeim` AS a, `#__users` AS b WHERE a.fromid=b.id AND a.toread=0 AND a.totrash=0 AND a.datum<".$sincewhen." AND a.datum>".$config->forgetmenotstart;
		$sql = "SELECT a.* FROM `#__uddeim` AS a, `#__users` AS b WHERE a.toid=b.id AND a.toread=0 AND a.totrash=0 AND a.datum<".$sincewhen." AND a.datum>".$config->forgetmenotstart;

		$next = (int)$config->longwaitingdays*86400;
		$sql = "SELECT min(a.id) AS mid, a.toid, b.name, a.cryptmode "
			 . "FROM `#__uddeim` AS a, `#__users` AS b, `#__uddeim_emn` AS c "
			 . "WHERE a.toid=b.id AND a.toid=c.userid AND "
			 . "a.toread=0 AND a.totrash=0 AND b.block=0 AND "
			 . "a.datum<".$sincewhen." AND a.datum>".$config->forgetmenotstart." AND "
			 . "c.remindersent+".$next."<".$rightnow." "
			 . "GROUP BY a.toid";
		$database->setQuery($sql);
		$castaways=$database->loadObjectList();
		if (!$castaways)
			$castaways = Array();
		
		$loopcounter=0;
		foreach($castaways as $castaway) {
			// has this user already received a reminder?
//			$var_remindersent = uddeIMgetEMNremindersent($castaway->toid);
			
//			$next_remindersent=$var_remindersent+($config->longwaitingdays*86400);
//			if ($next_remindersent < $rightnow) { // send only if no reminder has already been sent
				// =1 means: send forgetmenot message, fromid=0 uses sysmessage as sender name
				$var_message="";
				uddeIMdispatchEMN($castaway->mid, $item_id, $castaway->cryptmode, 0, $castaway->toid, $var_message, 1, $config);
				$loopcounter++;
//			}
			// new: never send more than 25 forgetmenot e-mails in one script call to avoid too many mails to be sent out at once
			if ($loopcounter>=25) {
				break;
			}
		}
	}
}

// $emn_option = 1 : forgotmenot message
// $emn_option = 2 : force include message text into message
function uddeIMdispatchEMN($var_msgid, $item_id, $cryptmode, $var_fromid, $var_toid, $var_message, $emn_option, $config) {
	$mosConfig_sitename = uddeIMgetSitename();
	$pathtosite  = uddeIMgetPath('live_site');

	// if e-mail traffic stopped, don't send.
	if(!$config->emailtrafficenabled) {
		return;
	}

	if ($var_fromid>0) {
		$var_fromname = uddeIMgetNameFromID($var_fromid, $config);
		if (!$var_fromname)
			$var_fromname=$config->sysm_username;
	} else {
		$var_fromname=$config->sysm_username;
	}

//	$ret = uddeIMgetNameEmailFromID($var_toid, $var_toname, $var_tomail, $config);
	$var_toname = uddeIMgetNameFromID($var_toid, $config);
	$var_tomail = uddeIMgetEMailFromID($var_toid, $config);

	if(!$var_tomail)
		return;
	if (!$var_toname)
		$var_toname = "Anonymous";

	$msglink = "";
	if ($cryptmode==2 || $cryptmode==4) {			// Message is encrypted, so go to enter password page
		if ($config->dontsefmsglink)
			$msglink = $pathtosite."/index.php?option=com_uddeim&task=showpass&Itemid=".$item_id."&messageid=".$var_msgid;
		else
			$msglink = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showpass&Itemid=".$item_id."&messageid=".$var_msgid);
	} else {							// normal message
		if ($config->dontsefmsglink)
			$msglink = $pathtosite."/index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$var_msgid;
		else
			$msglink = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$var_msgid);
	}

	if($emn_option==1) {
		$var_body = _UDDEIM_EMN_FORGETMENOT;
		$var_body = str_replace("%livesite%", $pathtosite, $var_body);
		$var_body = str_replace("%you%", $var_toname, $var_body);
		$var_body = str_replace("%site%", $mosConfig_sitename, $var_body);
		$var_body = str_replace("%msglink%", $msglink, $var_body);
	} else {
		if($config->emailwithmessage==1 || $emn_option==2) {
			$var_body = _UDDEIM_EMN_BODY_WITHMESSAGE;
			$var_body = str_replace("%livesite%", $pathtosite, $var_body);
			$var_body = str_replace("%you%", $var_toname, $var_body);
			$var_body = str_replace("%site%", $mosConfig_sitename, $var_body);
			$var_body = str_replace("%msglink%", $msglink, $var_body);
			$var_body = str_replace("%user%", $var_fromname, $var_body);
			$var_body = str_replace("%pmessage%", $var_message, $var_body);
		} else {
			$var_body = _UDDEIM_EMN_BODY_NOMESSAGE;
			$var_body = str_replace("%livesite%", $pathtosite, $var_body);
			$var_body = str_replace("%you%", $var_toname, $var_body);
			$var_body = str_replace("%site%", $mosConfig_sitename, $var_body);
			$var_body = str_replace("%msglink%", $msglink, $var_body);
			$var_body = str_replace("%user%", $var_fromname, $var_body);
		}
	}

	$subject = _UDDEIM_EMN_SUBJECT;
	$subject = str_replace("%livesite%", $pathtosite, $subject);
	$subject = str_replace("%site%", $mosConfig_sitename, $subject);
	$subject = str_replace("%you%", $var_toname, $subject);
	$subject = str_replace("%user%", $var_fromname, $subject);

	$replyto = $var_tomail;
	$replytoname = "";

    $mailphp=uddeIMsendmail($config->emn_sendername,$config->emn_sendermail,$var_toname,$var_tomail,$subject,$var_body,$replyto,$replytoname,"", $config);
    $lasterror = '<br>[last_error]<br>'.error_get_last()['message'].' in '.error_get_last()['file'].' line '.error_get_last()['line'].'<br>';

    if(substr($mailphp,0,1) == '1'){  //sent is ok
       	// set the remindersent status of this user to true
		if(!uddeIMexistsEMN($var_toid))
			uddeIMinsertEMNdefaults($var_toid, $config);
		uddeIMupdateEMNreminder($var_toid, uddetime($config->timezone));
        return $mailphp.$lasterror;
	}
    else {
        $mailphp.$lasterror;
        }
}

// *****************************************************************************************

function uddeIMreplyquoteMarkup($string, $quotedivider) {
	if (stristr($string, $quotedivider)) {
		$msgparts = explode($quotedivider, $string, 2);
		if($msgparts[1]) {
			$string=$msgparts[0]."<div class='uddeim-replyquote'>".$quotedivider.$msgparts[1]."</div>";
		}
	}
	return $string;
}

function uddeIMteaser($ofwhat, $howlong, $quotedivider, $utf8) {
	$msgparts=explode($quotedivider, $ofwhat, 2);
	$words=explode(" ", $msgparts[0]);
	$howmanywords=count($words);
	$x=0;
	if (!$howlong)
		$howlong=10;
	$trailstring="";
	if (uddeIM_utf8_strlen($utf8,$msgparts[0])>$howlong) {
		$howlong = $howlong-3;
		$trailstring = "...";
	}
	$construct="";
	if (uddeIM_utf8_strlen($utf8,$words[0])>$howlong) {
		$construct = uddeIM_utf8_substr($utf8, $words[0], 0, $howlong);
	} else {
		for($x=0; $x < $howmanywords; $x++) {
			$posslen = uddeIM_utf8_strlen($utf8,$construct) + uddeIM_utf8_strlen($utf8,$words[$x]);
			if ($posslen<=$howlong) {
				$construct .= " ".$words[$x];
			} else {
				break;
			}
		}
	}
	$construct .= $trailstring;
	$construct = ltrim($construct);
	if (empty($construct))
		$construct="...";
	return $construct;
}

function uddeIMarrowReplace($shownav, $templatedir) {
	$pathtosite  = uddeIMgetPath('live_site');

	if(uddeIMfileExists('/components/com_uddeim/templates/'.$templatedir.'/images/icon_end.gif')) {
		$shownav=str_replace("&raquo;",  "<img src='".$pathtosite."/components/com_uddeim/templates/".$templatedir."/images/icon_end.gif' border='0' alt='' />", $shownav);
		$shownav=str_replace("&gt;&gt;", "<img src='".$pathtosite."/components/com_uddeim/templates/".$templatedir."/images/icon_end.gif' border='0' alt='' />", $shownav);
	}
	if(uddeIMfileExists('/components/com_uddeim/templates/'.$templatedir.'/images/icon_start.gif')) {
		$shownav=str_replace("&laquo;",  "<img src='".$pathtosite."/components/com_uddeim/templates/".$templatedir."/images/icon_start.gif' border='0' alt='' />", $shownav);
		$shownav=str_replace("&lt;&lt;", "<img src='".$pathtosite."/components/com_uddeim/templates/".$templatedir."/images/icon_start.gif' border='0' alt='' />", $shownav);
	}
	if(uddeIMfileExists('/components/com_uddeim/templates/'.$templatedir.'/images/icon_prev.gif')) {
		$shownav=str_replace("&lt;", "<img src='".$pathtosite."/components/com_uddeim/templates/".$templatedir."/images/icon_prev.gif' border='0' alt='' />", $shownav);
	}
	if(uddeIMfileExists('/components/com_uddeim/templates/'.$templatedir.'/images/icon_next.gif')) {
		$shownav=str_replace("&gt;", "<img src='".$pathtosite."/components/com_uddeim/templates/".$templatedir."/images/icon_next.gif' border='0' alt='' />", $shownav);
	}
	return $shownav;
}

function uddeIMRemoveXSS($val) {
//	$aAllowedTags = array();
//	$aDisabledAttributes = array('onclick', 'ondblclick', 'onkeydown', 'onkeypress', 'onkeyup', 'onload', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onunload');
	// remove tags
//    $val = strip_tags($val, implode('', $aAllowedTags));
	// remove events
//	$val = preg_replace('/<(.*?)>/ie', "'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $aDisabledAttributes) . ")=[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", $val);

	// Actually this function does nothing. I added it to add some special anti XSS code later...
	return $val;
}

function uddeIMdoAutocomplete($config,$myself) {
	$pathtosite  = uddeIMgetPath('live_site');
    $sep = $config->separator==1 ? ";" : ",";

    if ($config->autocompleter==0) {    // set to not use
     return;
    }

    $userJSlist = "[".uddeIMcompleteUserName($myself, $config)."]";

    if ($config->autocompleter==1) {  // case insensitiv, multiple input, load js
        uddeIMaddScript($pathtosite."/components/com_uddeim/js/autocompleterW3.js");
    ?> <!--autocomplete here takes 6 arguments:
       required: the input element and the array of possible autocompleted values,
       optional: the multi-seperator, an errormessage on wrong seperator, start counter (letters), the option to look in namestr-->
       <script>
       const start = <?php echo $config->autocompletestart; ?>;
       const instr = <?php echo ($myself ? $config->searchinstring : $config->pubsearchinstring); ?>;
       const sep   = '<?php echo $sep; ?>';
       const seperror = '<?php echo _UDDEADM_SEPERROR.$sep.($config->separator ? _UDDEADM_SEP1 : _UDDEADM_SEP); ?>';
       autocomplete(document.getElementById("input_to_name"), <?php echo $userJSlist;?>, seperror, sep, start, instr);
    </script>

    <?php }

    if ($config->autocompleter==2) {   // light, but case sensitiv, complete js here
    echo "<ul id='autocompleter-choices' class='autocompleter-choices' style='width: 200px; z-index: 42; display:none; '></ul>"; //visibility: hidden; opacity: 0;
    ?>

    <script>
    const start = <?php echo $config->autocompletestart; ?>;
    const instr = <?php echo ($myself ? $config->searchinstring : $config->pubsearchinstring); ?>;
    const autocomplete = document.getElementById("input_to_name");
    const resultsHTML = document.getElementById("autocompleter-choices");
    const data = <?php echo $userJSlist;?>;

    autocomplete.oninput = function () {
    let results = [];
    const userInput = this.value;
    resultsHTML.innerHTML = "";
    if (userInput.length >= start) {
        results = getResults(userInput);
        resultsHTML.style.display = "block";
        for (i = 0; i < results.length; i++) {
            resultsHTML.innerHTML += "<li>" + results[i] + "</li>";
        }
    }
    else {
        resultsHTML.style.display = "none";
    }

    };

    function getResults(input) {
    const results = [];
    for (i = 0; i < data.length; i++) {

        if (instr && data[i].indexOf(input) > -1) {
            results.push(data[i]);
        } else if (input === data[i].slice(0, input.length)) {
            results.push(data[i]);
        }
    }
    return results;

    }
    resultsHTML.onclick = function (event) {
    const setValue = event.target.innerText;
    autocomplete.value = setValue;
    this.innerHTML = "";
    this.style.display = "none";
    };
    </script>

    <?php }
}

function uddeIMdoSmileysExHeight($config) {
	$pathtouser  = uddeIMgetPath('user');
	$pathtosite  = uddeIMgetPath('live_site');
	$num = 0;
	if ($config->allowsmile) {
		$picfolder = "animated-extended";
		$testpath2 = $pathtouser."/templates/images/".$picfolder;
		if ($config->animated && $config->animatedex && is_dir($testpath2)) {
			$smileys = $testpath2."/";
			$folder=opendir ($smileys);
			while ($file = readdir ($folder))
				if($file != "." && $file != ".." && (substr($file, strrpos($file, '.'))=='.gif'))
					$num++;
			closedir($folder);
		}
	}
	$height = 44*($num/8);		// 8 smileys per line
	if ($height<160)
		$height=160;
	return $height;
}

function uddeIMdoSmileysEx($config) {
	$pathtouser  = uddeIMgetPath('user');
	$pathtosite  = uddeIMgetPath('live_site');
	$num = 0;
	if ($config->allowsmile) {
		$picfolder = "animated-extended";
		$testpath2 = $pathtouser."/templates/images/".$picfolder;
		if ($config->animated && $config->animatedex && is_dir($testpath2)) {
			// Extended Animated Emoticons
			$smileys   = $testpath2."/";

			echo("\n<script type=\"text/javascript\"><!--\n");
			echo("function uddeimWindowOpen (title, par) {\n");
			echo("  uddeimWindow = window.open(\"\", title, par);\n");
			echo("  uddeimWindow.document.writeln(\"<html><head><title>uddeIM<\/title>");

			if(file_exists($pathtouser.'/templates/'.$config->templatedir.'/css/uddeim.css')) {
				echo "<link rel='stylesheet' href='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/css/uddeim.css' type='text/css' />";
			}
			echo("<\/head><body>");
			echo("<div id='uddeim-smileybox-popup'>");
			echo("<table border='1' cellpadding='2' cellspacing='0'>");

			$maxcols = 8;
			unset($ff);
			$folder=opendir ($smileys);
			while ($file = readdir ($folder)) {
				if($file != "." && $file != ".." && (substr($file, strrpos($file, '.'))=='.gif')) {
					$ext = strrchr($file, '.');
					if($ext !== false) {
						$noextname = substr($file, 0, -strlen($ext));
					} else {
						$noextname = $file;
					}
					$ff[$noextname] = $file;
				}
			}
			closedir($folder);
			ksort($ff);
			reset($ff);
			foreach($ff as $key => $value){
				$name = ":".$key.": ";
				$file = $value;
				if (!($num % $maxcols)) {
					echo("<tr>");
				}
				$uc2 = ($config->showtextcounter && $config->maxlength) ? "window.opener.textCount(window.opener.document.sendeform.pmessage,window.opener.document.sendeform.characterstyped,".$config->maxlength.");" : "";
				echo ("<td><img style='cursor: pointer;' onclick='window.opener.emo(\\\"".$name."\\\"); ".$uc2." return false;' src='".$pathtosite."/components/com_uddeim/templates/images/".$picfolder."/".$file."' alt='".$file."' title='".$file."' /><\/td>");
				$num++;
				if (!($num % $maxcols)) {
					echo("<\/tr>");
				}
			}
			while ($num % $maxcols) {
				echo ("<td>&nbsp;<\/td>");
				$num++;
			}
			if ($num % $maxcols) {
				echo("<\/tr>");
			}
			echo("<\/table>");
			echo("<\/div>");
			echo("<\/body><\/html>\");\n");
			echo("uddeimWindow.document.close();\n");
			echo("uddeimWindow.focus();\n");
			echo("}\n");
			echo("-->\n");
			echo("</script>\n");
		}
	}
	return $num;
}

function uddeIMdoBB($config) {
	// Most of the following/referenced javascript code is taken from phpBB
	// (C) 2001 The phpBB Group, for original code go to phpbb.com
	// Changed by Benjamin Zweifel for integration with uddeIM

	//$pathtosite  = uddeIMgetPath('live_site');
    $imgpath = uddeIMgetPath('live_site').'/components/com_uddeim/templates/images/';

	if ($config->allowbb) {
		$uc = ($config->showtextcounter && $config->maxlength) ? "textCount(document.sendeform.pmessage,document.sendeform.characterstyped,".$config->maxlength.");" : "";
	?>
		<div id='uddeim-bbemobox'>
			<table border="0" cellspacing="4" cellpadding="0">
				<tr>
					<td><img alt="bold" src="<?php echo $imgpath; ?>format_bold.gif" style="cursor: pointer;" name="addbbcode0" onclick="bbstyle(0); <?php echo $uc; ?> return false;" title="<?php echo _UDDEIM_TOOLTIP_BOLD; ?>" /></td>
					<td><img alt="italic" src="<?php echo $imgpath; ?>format_italic.gif" style="cursor: pointer;" name="addbbcode2" onclick="bbstyle(2); <?php echo $uc; ?> return false;"  title="<?php echo _UDDEIM_TOOLTIP_ITALIC; ?>" /></td>
					<td><img alt="underline" src="<?php echo $imgpath; ?>format_underline.gif" style="cursor: pointer;" name="addbbcode4" onclick="bbstyle(4); <?php echo $uc; ?> return false;"  title="<?php echo _UDDEIM_TOOLTIP_UNDERLINE; ?>" /></td>
					<td>&nbsp;</td>
					<td><img alt="red" src="<?php echo $imgpath; ?>format_red.gif" style="cursor: pointer;"  name="addbbcode6" onclick="bbstyle(6); <?php echo $uc; ?> return false;"  title="<?php echo _UDDEIM_TOOLTIP_COLORRED; ?>" /></td>
					<td><img alt="green" src="<?php echo $imgpath; ?>format_green.gif" style="cursor: pointer;"  name="addbbcode8" onclick="bbstyle(8); <?php echo $uc; ?> return false;"  title="<?php echo _UDDEIM_TOOLTIP_COLORGREEN; ?>" /></td>
					<td><img alt="blue" src="<?php echo $imgpath; ?>format_blue.gif" style="cursor: pointer;"  name="addbbcode10" onclick="bbstyle(10); <?php echo $uc; ?> return false;"  title="<?php echo _UDDEIM_TOOLTIP_COLORBLUE; ?>" /></td>
					<td>&nbsp;</td>
					<td><img alt="very small" src="<?php echo $imgpath; ?>format_size1.gif" style="cursor: pointer;"  name="addbbcode12" onclick="bbstyle(12); <?php echo $uc; ?> return false;"  title="<?php echo _UDDEIM_TOOLTIP_FONTSIZE1; ?>" /></td>
					<td><img alt="small" src="<?php echo $imgpath; ?>format_size2.gif" style="cursor: pointer;"  name="addbbcode14" onclick="bbstyle(14); <?php echo $uc; ?> return false;" title="<?php echo _UDDEIM_TOOLTIP_FONTSIZE2; ?>" /></td>
					<td><img alt="large" src="<?php echo $imgpath; ?>format_size4.gif" style="cursor: pointer;"  name="addbbcode16" onclick="bbstyle(16); <?php echo $uc; ?> return false;" title="<?php echo _UDDEIM_TOOLTIP_FONTSIZE4; ?>" /></td>
					<td><img alt="very large" src="<?php echo $imgpath; ?>format_size5.gif" style="cursor: pointer;"  name="addbbcode18" onclick="bbstyle(18); <?php echo $uc; ?> return false;" title="<?php echo _UDDEIM_TOOLTIP_FONTSIZE5; ?>" /></td>
		<?php
	}
	if ($config->allowbb>1) {
	?>
					<td>&nbsp;</td>
					<td><img alt="image" src="<?php echo $imgpath; ?>format_image.gif" style="cursor: pointer;"  name="addbbcode24" onclick="bbstyle(24); <?php echo $uc; ?> return false;" title="<?php echo _UDDEIM_TOOLTIP_IMAGE; ?>" /></td>
					<td><img alt="web link" src="<?php echo $imgpath; ?>format_link.gif" style="cursor: pointer;"  name="addbbcode26" onclick="bbstyle(26); <?php echo $uc; ?> return false;" title="<?php echo _UDDEIM_TOOLTIP_URL; ?>" /></td>
	<?php
	}
	if ($config->allowbb) {
	?>
					<td>&nbsp;</td>
					<td><img alt="close tags" src="<?php echo $imgpath; ?>format_closeall.gif" style="cursor: pointer;"  onclick="bbstyle(-1); <?php echo $uc; ?> return false;" title="<?php echo _UDDEIM_TOOLTIP_CLOSEALLTAGS; ?>" /></td>
				</tr>
			</table>
		</div>
	<?php
	}
}

function uddeIMdoSmileys($config, $num) {
	$pathtouser  = uddeIMgetPath('user');
	//$pathtosite  = uddeIMgetPath('live_site');
    $iconpath = uddeIMgetPath('live_site').'/components/com_uddeim/templates/';

	if ($config->allowsmile) {
		$uc = ($config->showtextcounter && $config->maxlength) ? "textCount(document.sendeform.pmessage,document.sendeform.characterstyped,".$config->maxlength.");" : "";
		$testpath1 = $pathtouser."/templates/images/animated";
		$picfolder = "animated-extended";
		$testpath2 = $pathtouser."/templates/images/".$picfolder;
		$icon_folder = "images";
		if ($config->animated && is_dir($testpath1))
			$icon_folder = "images/animated";
        $iconpath .= $icon_folder;
	?>
		<div id='uddeim-smileybox'>
			<table border='0' cellpadding='2' cellspacing='0'>
				<tr>
					<td><img style="cursor: pointer;" onclick="emo(':) '); <?php echo $uc; ?> return false;" src="<?php echo $iconpath; ?>/emoticon_smile.gif" alt=":)" title=":)" /></td>
					<td><img style="cursor: pointer;" onclick="emo(':( '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_sad.gif" alt=":(" title=":(" /></td>
					<td><img style="cursor: pointer;" onclick="emo(':P '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_tongue.gif" alt=":P" title=":P" /></td>
					<td><img style="cursor: pointer;" onclick="emo(':x '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_crossed.gif" alt=":x" title=":x" /></td>
					<td><img style="cursor: pointer;" onclick="emo(':angry: '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_angry.gif" alt=":angry:" title=":angry:" /></td>
					<td><img style="cursor: pointer;" onclick="emo(':blush: '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_blush.gif" alt=":blush:" title=":blush:" /></td>
					<td><img style="cursor: pointer;" onclick="emo('B) '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_cool.gif" alt="B)" title="B)" /></td>
					<td><img style="cursor: pointer;" onclick="emo(':* '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_heart.gif" alt=":*" title=":*" /></td>
					<td><img style="cursor: pointer;" onclick="emo(':kiss: '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_kiss.gif" alt=":kiss:" title=":kiss:" /></td>
					<td><img style="cursor: pointer;" onclick="emo(':laugh: '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_laughing.gif" alt=":laugh:" title=":laugh:" /></td>
					<td><img style="cursor: pointer;" onclick="emo(':ohmy: '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_shocked.gif" alt=":ohmy:" title=":ohmy:" /></td>
					<td><img style="cursor: pointer;" onclick="emo(';) '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_wink.gif" alt=";)" title=";)" /></td>
					<td><img style="cursor: pointer;" onclick="emo(':? '); <?php echo $uc; ?> return false;"  src="<?php echo $iconpath; ?>/emoticon_wondering.gif" alt=":?" title=":?" /></td>
					<?php
						if ($config->animated && $config->animatedex && is_dir($testpath2)) {
							$height=uddeIMdoSmileysExHeight($config);
							if ($num>0) {
					?>
								<td><a href="#" onclick="uddeimWindowOpen('uddeIM','width=464,height=<?php echo $height;?>,status=no,toolbar=no,scrollbars=no,dependent=yes,location=no,menubar=no,resizable=yes'); return false;"><?php echo _UDDEIM_MORE;?></a></td>
					<?php 
							}
						}
					?>
				</tr>
			</table>
		</div>
	<?php 
	}
}

function uddeIMdoShowConnections($myself, $my_gid, $config) {						
	$sep=",";
	if ($config->separator==1)
		$sep=";";

	$somanyfriends = 0;
	if ($config->showconnex) {
		if (uddeIMcheckCB()) {
			$rows = uddeIMselectCBbuddies($myself, $config);
			$somanyfriends = count($rows);
		}

		if (!$somanyfriends) { // no friends found, maybe there are some in CBE?
			if (uddeIMcheckCBE()) {
				$rows = uddeIMselectCBEbuddies($myself, $config);
				$somanyfriends = count($rows);
			}
			if (uddeIMcheckCBE2()) {
				$rows = uddeIMselectCBE2buddies($myself, $config);
				$somanyfriends = count($rows);
			}
		}

		if (!$somanyfriends) { // no friends found, maybe there are some in JS?
			if (uddeIMcheckJS()) {
				$rows = uddeIMselectJSbuddies($myself, $config);
				$somanyfriends = count($rows);
			}
		}
	}

	// collect lists
	$somanylists=0;
	if( ($config->enablelists==1) ||
	    ($config->enablelists==2 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) || 
	    ($config->enablelists==3 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) ) {
		$my_lists = uddeIMselectAllUserlists($myself, $my_gid, $config, true); 		
		$somanylists = count($my_lists);
	}

	if ($somanyfriends>0 || $somanylists>0) {

		if ($somanyfriends>0 && $somanylists>0)
			$mycons = _UDDEIM_CONNECTIONS."/"._UDDEIM_LISTS."<br />";
		elseif ($somanyfriends>0)
			$mycons = _UDDEIM_CONNECTIONS."<br />";
		elseif ($somanylists>0)
			$mycons = _UDDEIM_LISTS."<br />";
		else
			$mycons = "";

		if ($config->connex_listbox) {
			if ($config->connexallowmultipleuser)
				$mycons.="<select size=\"1\" class=\"inputbox\" onchange=\"document.sendeform.to_name.value=(document.sendeform.to_name.value.length>0 &amp;&amp; this.options[this.selectedIndex].value.length>0) ? document.sendeform.to_name.value+'".$sep."'+this.options[this.selectedIndex].value : this.options[this.selectedIndex].value; return false;\" name=\"connexlistbox\">";
			else
				$mycons.="<select size=\"1\" class=\"inputbox\" onchange=\"document.sendeform.to_name.value=this.options[this.selectedIndex].value; return false;\" name=\"connexlistbox\">";
			$mycons.="<option value=''>&nbsp;</option>";

			if ($somanyfriends>0)
				foreach ($rows as $row)
					$mycons.="<option value=\"".$row->displayname."\">".$row->displayname."</option>";
			if ($somanylists>0)
				foreach ($my_lists as $row)
					$mycons.="<option value=\"#".$row->name."\">#".$row->name."</option>";

			$mycons.="</select>";
		} else {
			if ($config->connexallowmultipleuser) {
				$mycons.="<ul>";
				$mycons.="<li><a href=\"#\" onclick=\"document.sendeform.to_name.value=''; return false;\">"._UDDEIM_CLEAR."</a></li>&nbsp; ";
				if ($somanyfriends>0)
					foreach ($rows as $row)
						$mycons.="<li><a href=\"#\" onclick=\"document.sendeform.to_name.value=(document.sendeform.to_name.value.length>0) ? document.sendeform.to_name.value+'".$sep."'+'".$row->displayname."' : '".$row->displayname."'; return false;\">".$row->displayname."</a></li>&nbsp; ";
				if ($somanylists>0)
					foreach ($my_lists as $row)
						$mycons.="<li><a href=\"#\" onclick=\"document.sendeform.to_name.value=(document.sendeform.to_name.value.length>0) ? document.sendeform.to_name.value+'".$sep."'+'#".$row->name."' : '#".$row->name."'; return false;\">#".$row->name."</a></li>&nbsp; ";
				$mycons.="</ul>";
			} else {
				if ($somanyfriends>0)
					foreach ($rows as $row)
						$mycons.="<a href=\"#\" onclick=\"document.sendeform.to_name.value='".$row->displayname."'; return false;\">".$row->displayname."</a>&nbsp; ";
				if ($somanylists>0)
					foreach ($my_lists as $row)
						$mycons.="<a href=\"#\" onclick=\"document.sendeform.to_name.value='#".$row->name."'; return false;\">#".$row->name."</a>&nbsp; ";
			}
		}

// START THIRD LINE IN TABLE (when connections exist)
		if ($config->connex_listbox) {
			echo "<tr><td valign='top'>&nbsp;</td><td valign='top' align='right'>".$mycons."</td></tr>";
		} else {
			echo "<tr><td colspan='2'>".$mycons."</td></tr>";
		}
	}
}

function uddeIMreplaceListsWithNames(&$thelist, $myself, $config) {
	$database = uddeIMgetDatabase();

	$ok = 1;
	if ($config->separator==1)
		$objs = explode(";", $thelist);
	else
		$objs = explode(",", $thelist);

	if ($objs==FALSE)
		return 0;	// error

	foreach ($objs as $key => $obj) {
		if (substr($obj,0,1)=="#") {				// its a list
			$listname = substr($obj,1);				// remove leading "#"
			// also show global lists
			$this_lists = uddeIMselectUserlistsListFromName($myself, $listname, true);
//			$this_lists = uddeIMselectUserlistsListFromName($myself, $listname);
			if (!empty($this_lists)) {				// we have a list with that name
				$lids = "";
				$ltype = 0;
				$luser = 0;
				foreach($this_lists as $this_list) {
					$lids = trim($this_list->userids);
					$ltype = $this_list->global;
					$luser = $this_list->userid;
				}
				// remove lists if required (1: global list => do not remove; 2: restricted list => remove if not on list or creator)
				if ($ltype==2) {
					$ar_ids = explode(",",$lids);
					$ar_ids[] = $luser;				// the creator of the list is always allowed to access the list
					if (!in_array($myself,$ar_ids))
						$lids = "";
				}
				if ($lids) {
					$obj_new = Array();
					// $database->setQuery( "SELECT id,name,username FROM `#__users` WHERE block=0 AND id IN (".$lids.") ORDER BY ".($config->realnames ? "name" : "username") );
					// New behavior: Remove myself from the list
					$database->setQuery( "SELECT id,name,username FROM `#__users` WHERE block=0 AND id IN (".$lids.") AND id<>".$myself." ORDER BY ".($config->realnames ? "name" : "username") );
					$users = $database->loadObjectList();
					if ( count( $users ) )  {
						foreach ( $users as $user )
							array_push($obj_new, ($config->realnames ? $user->name : $user->username));
						if ($config->separator==1)
							$obj = implode(";", $obj_new);
						else
							$obj = implode(",", $obj_new);
					}
					$objs[$key] = $obj;
				} else {
					$objs[$key] = "(".$obj.")";
					$ok = 0;	// error
				}
			} else {
				// we have no list, so check if we have a user with this name
				$ret = uddeIMgetIDfromName($obj, $config, true);
				if (!$ret) {	// no there is no user with that name or user is blocked
					$objs[$key] = "(".$obj.")";
					$ok = 0;	// error
				}
			}
		}	// when it is not a list, do nothing
	}
	if ($config->separator==1)
		$thelist = implode(";", $objs);					// now return the complete list
	else
		$thelist = implode(",", $objs);					// now return the complete list
	return $ok;
}

function uddeIMdrawWriteform($myself, $my_gid, $item_id, $backto, $recipname, $pmessage, $messageid, $dwf_isreply, $dwf_errorcode, $dwf_sysgm, $config) {
	$pathtouser  = uddeIMgetPath('user');
	$pathtosite  = uddeIMgetPath('live_site');

	// possible values for dwf_errorcode:
	// 0 = no error
	// 1 = no error, show complete userlist
	// 2 = don't send to yourself
	// 3 = username not found
	// 4 = no message
	// 5 = no username
	// 6 = too many recipients
	// 7 = wrong captcha code
	// 8 = does not allow public messages
	// 9 = one user has blocked you
	// 10 = sending to this group not allowed
	// 11 = contact list not found
	// 12 = error in from name (n/a, public frontend only)
	// 13 = error in from email (n/a, public frontend only)
	// 14 = time delay for spam protection
	// 15 = csrf protection
	// 16 = administrative blocking
	// 17 = user is banned
	// 18 = file upload failed
	// 19 = file size exceeded
	// 20 - file type not allowed
	// 21 - bad words

	// This functions expects values stripslashed

	// allowed to send messages?
	if ($config->waitdays && uddeIMisReggedOnly($my_gid)) {
		$rightnow=uddetime($config->timezone);
		$offset=((float)$config->waitdays) * 86400;
		$timeframe=$rightnow-$offset;
		$registerDate=uddeIMgetRegisterDate($myself, $config);
		// $registerDate=mktime(0, 0, 0, 3, 28, 2010);
		if ($timeframe<$registerDate) {
			$temp = ($registerDate-$timeframe)/86400;
			$showinboxlimit_borderbottom = "<span class='uddeim-warning'>";
			if ($temp>=1)
				$showinboxlimit_borderbottom.= _UDDEIM_WAITDAYS1.sprintf("%0.1f", $temp)._UDDEIM_WAITDAYS2;
			else 
				$showinboxlimit_borderbottom.= _UDDEIM_WAITDAYS1.sprintf("%0.1f", $temp*24)._UDDEIM_WAITDAYS2H;
			$showinboxlimit_borderbottom.= "</span>";
			echo "<div id='uddeim-bottomlines'>".$showinboxlimit_borderbottom."</div>";
			return;
		}
	}
	
	echo "<div id='uddeim-writeform'>\n";
	if ($dwf_sysgm) {
		echo "<br />";
		echo "<form enctype='multipart/form-data' name='sendeform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=savesysgm&Itemid=".$item_id)."'>\n";
		uddeIMwriteCSRF($config);
		echo "<p><input type='checkbox' checked='checked' name='sysgm_sys' value='1' />"._UDDEIM_SEND_ASSYSM."</p>\n";

		if ($config->showgroups) {
			echo "<p><select name='sysgm_universe' size='1'>";
			echo "<option value='sysgm_toall'>"._UDDEIM_SEND_TOALL."</option>";
			echo "<option value='sysgm_toallspecial'>"._UDDEIM_SEND_TOALLSPECIAL."</option>";
			echo "<option value='sysgm_toalladmins'>"._UDDEIM_SEND_TOALLADMINS."</option>";
			echo "<option value='sysgm_toalllogged'>"._UDDEIM_SEND_TOALLLOGGED."</option>";
			$groups = uddeIMselectAROgroups();
			foreach ($groups as $group) {
				$groupid = $group->id;
				$groupname = $group->name;
				echo "<option value='".$groupid."'>".$groupname."</option>";
			}
			echo "</select></p>";
		} else {
			echo "<p><input type='radio' name='sysgm_universe' value='sysgm_toall' />"._UDDEIM_SEND_TOALL."<br />\n";
			echo "<input type='radio' name='sysgm_universe' checked='checked' value='sysgm_toallspecial' />"._UDDEIM_SEND_TOALLSPECIAL."<br />\n";
			echo "<input type='radio' name='sysgm_universe' checked='checked' value='sysgm_toalladmins' />"._UDDEIM_SEND_TOALLADMINS."<br />\n";
			echo "<input type='radio' name='sysgm_universe' value='sysgm_toalllogged' />"._UDDEIM_SEND_TOALLLOGGED."</p>\n";
		}
		echo "<p>"._UDDEIM_VALIDFOR_1;
		echo "<input name='sysgm_validfor' type='text' size='4' />"._UDDEIM_VALIDFOR_2."</p>\n";
        echo "<p>".$config->allowbb < 2 ? _UDDEIM_SYSGM_SHORTHELP : '&nbsp;'."</p>\n";
	} else {
		echo "<br />";
		echo "<form enctype='multipart/form-data' name='sendeform' method='post' autocomplete='off' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=save&Itemid=".$item_id)."'>";
		echo "<input type='hidden' name='sendeform_showallusers' value='' />\n";
		uddeIMwriteCSRF($config);
		if (uddeIMgetEMNmoderated($myself) ) { //&& uddeIMisReggedOnly($my_gid)) {
			echo "<p>"._UDDEIM_MCP_MODERATED."</p>";
		}
	}
	echo "\n";

	if($dwf_errorcode==0 && $backto) {
		echo "<input type='hidden' name='backto' value='".htmlspecialchars($backto)."' />";
	}

	if(!$dwf_sysgm) {
	
		if($dwf_isreply!=1) { // if this is NOT a reply

			echo "<table width='100%' cellspacing='0' cellpadding='0' width='100%'>";

			if(0 && $dwf_errorcode==0 && $recipname) {		// BUGBUG "0 &&". don't need this case
				echo "<tr><td valign='top'>";
				echo "<b>".$recipname."</b>";
				echo "<input type='hidden' name='to_name' id='input_to_name' value='".htmlentities($recipname, ENT_QUOTES, $config->charset)."' />&nbsp;";
				echo "</td></tr>";
			} else {

// START FIRST LINE IN TABLE (contains two fields: TO USER and select from ALL USER list)
				echo "<tr><td valign='top'>";
				echo "<span title='".($config->allowmultipleuser ? _UDDEIM_TODP_TITLE_CC.($config->separator ? _UDDEIM_TODP_TITLE_CC1 : _UDDEIM_TODP_TITLE_CC0) : _UDDEIM_TODP_TITLE)."'>";
				echo _UDDEIM_TODP;
				echo "<br />";

				if($dwf_errorcode==2 || $dwf_errorcode==3 || $dwf_errorcode==5 ||
				   $dwf_errorcode==6 || $dwf_errorcode==8 || $dwf_errorcode==9 ||
				   $dwf_errorcode==10 || $dwf_errorcode==11 || $dwf_errorcode==16 ||
				   $dwf_errorcode==17 || $dwf_errorcode==18 || $dwf_errorcode==19 ||
				   $dwf_errorcode==20) {
					$errorstyle='style="background-color: #ff0000;" ';
				} else {
					$errorstyle='';
				}

				echo "<input type='hidden' name='to_id' value='' />";
				echo "<input type='hidden' name='messageid' value='".$messageid."' />";
				if (!($config->flags & 0x04)) {
					echo "<input type='text' ".$errorstyle."name='to_name' id='input_to_name' value='".htmlentities($recipname, ENT_QUOTES, $config->charset)."' />&nbsp;";
				} else {
					echo "<span ".$errorstyle.">".htmlentities($recipname, ENT_QUOTES, $config->charset)."</span>";
					echo "<input type='hidden' name='to_name' id='input_to_name' value='".htmlentities($recipname, ENT_QUOTES, $config->charset)."' />&nbsp;";
				}
				echo "</span>";

				if ($config->useautocomplete) {
					uddeIMdoAutocomplete($config,$myself);
				}

// SECOND FIELD IN FIRST LINE IN TABLE
				echo "</td><td valign='top' align='right'>\n";
				$allusersallowed = 0;
				if( ($config->restrictallusers==0) ||
					($config->restrictallusers==1 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) || 
					($config->restrictallusers==2 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) )
					$allusersallowed=1;
				if (!($config->flags & 0x01) && $allusersallowed) {
					if ($config->modeshowallusers==1 || $config->modeshowallusers==2) {
						if ($dwf_errorcode==0 && $config->modeshowallusers==1) {
							// link to drop down box with names of connected users, value is 2 since it is shown the first time (so selecting the link does not show an error message because of an empty recipient field)
							echo "<br />";
							echo "<a href=\"#\" onclick=\"document.sendeform.sendeform_showallusers.value='2'; document.sendeform.submit(); return false;\">"._UDDEIM_SHOWUSERS."</a>";
						} else { // now show all users
							uddeIMdoShowAllUsers($myself, $my_gid, $config, 1);
						}
					}
				}
				echo "</td></tr>";

// START SECOND LINE IN TABLE (colspan=2)
				if ($dwf_errorcode==3) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_NOSUCHUSER."</td></tr>";
				} elseif ($dwf_errorcode==2) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_NOTTOYOURSELF."</td></tr>";
				} elseif ($dwf_errorcode==5) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_ENTERNAME."</td></tr>";
				} elseif ($dwf_errorcode==6) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_TOOMANYRECIPIENTS."</td></tr>";
				} elseif ($dwf_errorcode==7) {
					if ($config->captchatype==0) {
						echo "<tr><td valign=left colspan=2><b>"._UDDEIM_WRONGCAPTCHA."</b></td></tr>";
					} elseif ($config->captchatype==1) {
						echo "<tr><td valign=left colspan=2><b><span style='background-color: #ff9999;'>"._UDDEIM_WRONGCAPTCHA."</b></span></td></tr>";
					} elseif ($config->captchatype==2) {
						echo "<tr><td valign=left colspan=2><b><span style='background-color: #ff9999;'>"._UDDEIM_WRONGCAPTCHA."</b></span></td></tr>";
					}
				} elseif ($dwf_errorcode==8) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_NOPUBLICMSG."</td></tr>";
				} elseif ($dwf_errorcode==9) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_ONEUSERBLOCKS."</td></tr>";
				} elseif ($dwf_errorcode==10) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_GROUPBLOCKED."</td></tr>";
				} elseif ($dwf_errorcode==11) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_NOSUCHLIST."</td></tr>";
				} elseif ($dwf_errorcode==12) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_ERRORINFROMNAME."</td></tr>";
				} elseif ($dwf_errorcode==13) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_ERRORINEMAIL."</td></tr>";
				} elseif ($dwf_errorcode==14) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_YOUHAVETOWAIT."</td></tr>";
				} elseif ($dwf_errorcode==15) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_ERRORCSRF."</td></tr>";
				} elseif ($dwf_errorcode==16) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_USERBLOCKED."</td></tr>";
				} elseif ($dwf_errorcode==17) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_USERBANNED."</td></tr>";
				} elseif ($dwf_errorcode==18) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_FILEUPLOAD_FAILED."</td></tr>";
				} elseif ($dwf_errorcode==19) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_FILESIZE_EXCEEDED."</td></tr>";
				} elseif ($dwf_errorcode==20) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_FILETYPE_NOTALLOWED."</td></tr>";
				} elseif ($dwf_errorcode==21) {
					echo "<tr><td valign=left colspan=2>"._UDDEIM_BADWORD."</td></tr>";
				}
// START THIRD LINE IN TABLE WHEN CONNECTIONS AVAILABLE

				$have_lists=0;
				if( ($config->enablelists==1) ||
					($config->enablelists==2 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) || 
					($config->enablelists==3 && (uddeIMisAdmin($my_gid)   || uddeIMisAdmin2($my_gid, $config))) )
					$have_lists=1;

				if (!($config->flags & 0x02)) {
					if ($config->showconnex || $have_lists) {
						// if (uddeIMcheckCB() && $showconnex && !($recipname && $dwf_errorcode==0)) {
						uddeIMdoShowConnections($myself, $my_gid, $config);	// this creates a third row in table
					}
				}
			}
			echo "</table>";
			echo "<br />";
		} else { // it IS a reply
			if ($dwf_errorcode) {
				echo "<table width='100%' cellspacing='0' cellpadding='0'>";
				if ($dwf_errorcode==7) {
					echo "<tr><td valign=left colspan=2><b>"._UDDEIM_WRONGCAPTCHA."</b></td></tr>";
				} elseif ($dwf_errorcode==13) {
					echo "<tr><td valign=left colspan=2><b>"._UDDEIM_ERRORINEMAIL."</b></td></tr>";
				} elseif ($dwf_errorcode==14) {
					echo "<tr><td valign=left colspan=2><b>"._UDDEIM_YOUHAVETOWAIT."</b></td></tr>";
				}
				echo "</table>";
				echo "<br />";
			}
			echo "<input type='hidden' name='to_id' value='".htmlentities($recipname, ENT_QUOTES, $config->charset)."' />&nbsp;";
			echo "<input type='hidden' name='messageid' value='".$messageid."' />";
			echo "<input type='hidden' name='to_name' value='' />";
		}
	}

	if(($config->showtextcounter && $config->maxlength) || 
		$config->cryptmode==2 || $config->cryptmode==4) {
		uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");
	}

	if($config->allowbb || $config->allowsmile) {
		uddeIMaddScript($pathtosite."/components/com_uddeim/js/bbsmile.js");
		$num = uddeIMdoSmileysEx($config);
		uddeIMdoBB($config);
		uddeIMdoSmileys($config, $num);
	}

		$errorstyle='';


	if($dwf_isreply==1) {
		echo "<span".$errorstyle.">"._UDDEIM_REPLY."</span>";
	} else {
		echo "<span".$errorstyle.">"._UDDEIM_MESSAGE."</span>";
	}
	echo "<br />";

	$thestyle = "";
	if ($config->width)
		$thestyle .= "width: ".(int)$config->width."px; ";

	if ($dwf_errorcode==4 || $dwf_errorcode==21)
		$thestyle .= "background-color: #ff0000; ";

	$errorstyle="";
	if ($thestyle!="")
		$errorstyle="style='".$thestyle."' ";

	// ================================== TEXTBOX/TEXTCOUNTER ==============================

	if($config->showtextcounter && $config->maxlength) {
		$uc = ($config->showtextcounter) ? "textCount(document.sendeform.pmessage,document.sendeform.characterstyped,".$config->maxlength.");" : "";
		echo "<textarea name='pmessage' ".$errorstyle."class='inputbox' rows='".(int)$config->rows."' cols='".(int)$config->cols."' onkeydown='".$uc."' onkeyup='".$uc."'>".$pmessage."</textarea>";
		echo "<div class='uddeim-textcounter'>";
		echo "<input style='background-color: lightgray;' readonly='readonly' type='text' name='characterstyped' size='4' maxlength='4' value='".$config->maxlength."' /> "._UDDEIM_CHARSLEFT;
		echo "</div>";
	} else {
		echo "<textarea name='pmessage' ".$errorstyle."class='inputbox' rows='".(int)$config->rows."' cols='".(int)$config->cols."'>".$pmessage."</textarea>";
	}

	// ================================== FILE UPLOAD ==============================

	if( $config->enableattachment && uddeIMisAttachmentAllowed($my_gid, $config))
		uddeIMshowUploadButtons($config);

	// ================================== PASSWORD ==============================

	// CRYPT
	if($config->cryptmode==2 || $config->cryptmode==4) {
		echo "<div class='alert bg-light uddeim-password'>";
		echo "<a href='javascript:uddeidswap(\"divpass\");'>"._UDDEIM_PASSWORDBOX."</a>";
		echo "<span id='divpass' style='visibility:hidden;'>: <input name='cryptpass' value='' />"._UDDEIM_ENCRYPTIONTEXT."</span>";
		echo "</div>";
	}

	// ================================== CAPTCHA ==============================

	if ( $config->usecaptcha>=4 ||																			// all users (incl. admins)
		($config->usecaptcha==3 && !uddeIMisAdmin($my_gid)   && !uddeIMisAdmin2($my_gid, $config)) ||		// CAPTCHA enabled for public frontend, registered and special users
		($config->usecaptcha==2 && !uddeIMisSpecial($my_gid) && !uddeIMisSpecial2($my_gid, $config)) ) {	// CAPTCHA enabled for public frontend and registered users (note: 0 is not required since this is done in public.php)
		// CAPTCHA
		if ($config->captchatype==0) {			
			$errorstyle= $dwf_errorcode==7 ? 'style="border: 2px solid red;height:30px;" ' : 'style="height:30px;"';  //background-color: #ff0000;
			
			echo "<div class='uddeim-captcha'>";
			echo "<label for='security_code'>"._UDDEIM_SECURITYCODE." </label>&nbsp;
   				<input id='security_code' name='security_code' type='text' ".$errorstyle." />&nbsp;";

			echo "<img id='capimg' alt='' style='vertical-align:bottom;' src='' /> <i class='fas fa-lg fa-rotate' style='color:#777;' onclick='newcapimg()'></i><br />";
			
            		echo "<script type='text/javascript'>
                	window.onload = newcapimg();
                	function newcapimg() {
                	fetch('/components/com_uddeim/captcha.php').then(response => response.text()) .then(text => {document.getElementById('capimg').src='data:image/jpg;base64,' + text;}) .catch(error => console.error(error));}
                	</script>";
			
            		/* function newjqimg() {  //old jquery script
                	jQuery.get('/components/com_uddeim/captcha.php',function( data ) {jQuery('#capimg').attr('src', 'data:image/jpg;base64,' + data);});}
                	jQuery(window).on('load', newcapimg());*/
			
			echo "</div>";
		} 
		elseif ($config->captchatype==1) {
			//$pathtouser  = uddeIMgetPath('user');
			//require_once($pathtouser."/recaptchalib.php");
			echo "<div class='uddeim-captcha alert alert-link alert-light' style='display:inline-block;'>"._UDDEIM_SECURITYCODE."*&nbsp;&nbsp;";
		        echo numericcaptcha($dwf_errorcode);
			echo "</div>";
		} 
		elseif ($config->captchatype==2) {
			echo "<div class='uddeim-captcha'>";
            echo '<div class="g-recaptcha" data-sitekey="'. $config->recaptchapub .'"></div>';
            echo '<script type="text/javascript"';
            echo ' src="https://www.google.com/recaptcha/api.js?hl='.  uddeIMgetLang()   .'">';
            echo '</script>';
			echo "</div>";
		}
	}

	// ================================== Show the SEND OPTIONS ==============================

	$showoptions =  ($config->trashoriginal && $dwf_isreply==1) ||
					($config->trashoriginalsent && !$dwf_sysgm) ||
					($config->allowcopytome && !$dwf_sysgm) ||
					($config->addccline && $config->allowmultipleuser && !$dwf_sysgm) ||
					($config->allowemailnotify && $config->emailwithmessage==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))) ||
					($config->allowemailnotify && $dwf_sysgm);

	if ($showoptions) {
		echo "<div class='uddeim-sendoption'>";
	}
	if($config->trashoriginal && $dwf_isreply==1) {
		echo "<input type='checkbox' value='1' checked='checked' name='tobedeleted' />"._UDDEIM_TRASHORIGINAL."&nbsp;";
	}
	if($config->trashoriginalsent && !$dwf_sysgm) {
		echo "<input type='checkbox' value='1' name='tobedeletedsent' />"._UDDEIM_TRASHORIGINALSENT."&nbsp;";
	}
	if($config->allowcopytome && !$dwf_sysgm) {
		echo "<input type='checkbox' value='1' name='copytome' />"._UDDEIM_SENDCOPYTOME."&nbsp;";
	}
	if($config->addccline && $config->allowmultipleuser && !$dwf_sysgm) {
		echo "<span title='"._UDDEIM_ADDCCINFO_TITLE."'>";
		echo "<input type='checkbox' value='1' checked='checked' name='addccinfo' />"._UDDEIM_ADDCCINFO;
		echo "</span>";
	}
	// Email notifications must be on AND emailwithmessage for admins AND its an admin
	if($config->allowemailnotify && $config->emailwithmessage==2 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))) {
		echo "<span title='"._UDDEAIM_ADDEMAIL_TITLE."'>";
		echo "<input type='checkbox' value='1' name='forceembedded' />"._UDDEAIM_ADDEMAIL_SELECT;
		echo "</span>";
	}
	if($config->allowemailnotify && $dwf_sysgm) {
		echo "<span><input type='checkbox' value='1' name='sysgm_nonotify' />"._UDDEIM_SEND_NONOTIFY."</span>\n";
	}

	if ($showoptions) {
		echo "</div>";
	}

	// ================================== SEND BUTTON ==============================

	echo "<div class='uddeim-sendbutton'>";
	// when going back one page (history(-1)) the button stays disabled
    // echo "<input type='submit' name='reply' class='button' onclick=\"this.disabled=true;this.value='"._UDDEIM_PROCESSING."';this.form.submit();\" value='"._UDDEIM_SUBMIT."' /> ";
    echo "<input type='submit' name='reply' class='button btn-primary' style='margin:1em;' value='"._UDDEIM_SUBMIT."' /> ";
	echo "</div>";

	echo "</form>\n";
	echo "</div>\n"; // end of uddeim-writeform
}

function uddeIMreplySuggestion($decryptedmessage, $displaymessage, $fromname, $toname, $isforward, $box, $config) {
	$replysuggest = stripslashes($decryptedmessage);
	// if allowed to contain bbcodes they should be stripped for the reply quote
	if ($displaymessage->systemflag || $config->allowbb)
		$replysuggest = uddeIMbbcode_strip($replysuggest);

	if ($box=="outbox") {
		if ($isforward && $config->allowforwards) {
			$fromname = uddeIMgetNameFromID($displaymessage->fromid, $config);
			if ($config->allowbb)
				$replysuggest="[i]"._UDDEIM_FWDFROM." ".$fromname." "._UDDEIM_FWDTO." ".$toname." (".uddeLdate($displaymessage->datum, $config, uddeIMgetUserTZ())."):[/i]\n\n".$replysuggest;
			else
				$replysuggest=""._UDDEIM_FWDFROM." ".$fromname." "._UDDEIM_FWDTO." ".$toname." (".uddeLdate($displaymessage->datum, $config, uddeIMgetUserTZ())."):\n\n".$replysuggest;
		}
	} else {
		if ($isforward && $config->allowforwards) {
			if ($displaymessage->toid!=$displaymessage->fromid) { 		// not a copy to myself
				$toname = uddeIMgetNameFromID($displaymessage->toid, $config);
				if ($config->allowbb)
					$replysuggest="[i]"._UDDEIM_FWDFROM." ".$fromname." "._UDDEIM_FWDTO." ".$toname." (".uddeLdate($displaymessage->datum, $config, uddeIMgetUserTZ())."):[/i]\n\n".$replysuggest;
				else
					$replysuggest=""._UDDEIM_FWDFROM." ".$fromname." "._UDDEIM_FWDTO." ".$toname." (".uddeLdate($displaymessage->datum, $config, uddeIMgetUserTZ())."):\n\n".$replysuggest;
			} else {	// its a copy2me
				$toname = uddeIMgetNameFromID($displaymessage->toid, $config);
				if ($config->allowbb)
					$replysuggest="[i]"._UDDEIM_FWDFROM." ".$toname." ".$fromname." (".uddeLdate($displaymessage->datum, $config, uddeIMgetUserTZ())."):[/i]\n\n".$replysuggest;
				else
					$replysuggest=""._UDDEIM_FWDFROM." ".$toname." ".$fromname." (".uddeLdate($displaymessage->datum, $config, uddeIMgetUserTZ())."):\n\n".$replysuggest;
			}
		}
	}
	$replytomessage = "\n\n\n\n".$config->quotedivider."\n".$replysuggest;

	if ($config->maxlength) {
		if (uddeIM_utf8_strlen($config->languagecharset, $replytomessage)+3>=$config->maxlength) {
			$mlength = $config->maxlength * 2 / 3;
			$replytomessage = uddeIM_utf8_substr($config->languagecharset, $replytomessage,0,$mlength)."...";
		}
	}
	return $replytomessage;
}

/*
** numeric captcha solution and hidden field based on
** EasyCalcCheck Plus / Captcha - ECC © Viktor Vogel <admin@kubik-rubik.de>
*/

function numericcaptcha($errorcode){

    $session     = Factory::getApplication()->getSession();
    $maxValue    = 20; //may be set up to 50
    $hiddenId    = createRandomString();
    $id = $name = 'eccl';

$session->set('initTimeStamp', time(), 'eccl');
$session->set('spamCheckNumber1', mt_rand(0, $maxValue), 'eccl');
$session->set('spamCheckNumber2', mt_rand(0, $maxValue), 'eccl');    
$session->set('hiddenId', $hiddenId, 'eccl');

    Factory::getApplication()->getDocument()->getWebAssetManager()->addInlineStyle('#' . $hiddenId . ' {display: none;}');
    $hiddenFieldOutput = '<input type="text" name="' . $hiddenId . '" id="' . $hiddenId . '" size="3" class="inputbox" value="" placeholder="' . formatNumbersSpellout(mt_rand(0, $maxValue)) . ' + ' . formatNumbersSpellout(mt_rand(0, $maxValue)) . '"/>';

$spamCheckNumber1 = $session->get('spamCheckNumber1', 0, 'eccl');
$spamCheckNumber2 = $session->get('spamCheckNumber2', 0, 'eccl');
$random = random_int(1, 3);
$spamCheckNumber1 = $random > 1 ? formatNumbersSpellout($spamCheckNumber1) : (string)$spamCheckNumber1;
$random = random_int(1, 3);
$spamCheckNumber2 = $random > 1 ? formatNumbersSpellout($spamCheckNumber2) : (string)$spamCheckNumber2;

$inputstyle = $errorcode == 7 ? 'style="font-weight:bold;text-indent:.5em;border:2px solid red;"' : 'style="font-weight:bold;text-indent:.5em;"';
$spamCheckField = '<input type="text" name="' . $name . '" id="' . $id . '" size="auto" '.$inputstyle.' class="inputbox validate-numeric required" value="" required="required" placeholder="' . $spamCheckNumber1 . ' + ' . $spamCheckNumber2 . '"/>';

return $spamCheckField.$hiddenFieldOutput;

}

function formatNumbersSpellout(int $number) {
        if (class_exists('NumberFormatter')) {
            $formatter = new NumberFormatter(Factory::getApplication()->getLanguage()->getTag(), NumberFormatter::SPELLOUT);
            return $formatter->format($number);
        }
        return $number;
    }

function createRandomString(): string {
        $charactersArray = array_merge(range('a', 'z'), range('A', 'Z'));
        $randomString = $charactersArray[mt_rand(0, count($charactersArray) - 1)];
        $randomString .= Joomla\CMS\User\UserHelper::genRandomPassword(mt_rand(6, 12));
        return $randomString;
    }

function CheckCaptcha($result = null,$timeLockSeconds = 5): bool {
        if (!performChecks($result,$timeLockSeconds)) {
            Factory::getApplication()->enqueueMessage(_UDDEIM_WRONGCAPTCHA, 'error');
            return false;
        }
        return true;
    }
function performChecks($result,$timeLockSeconds): bool {

        if (is_null($result))
            return false;

        $session     = Factory::getApplication()->getSession();
        $initTimeStamp = $session->get('initTimeStamp', null, 'eccl');
        $session->clear('initTimeStamp', 'eccl');

        //check Timestamp
        if (is_null($initTimeStamp) || time() - $timeLockSeconds <= (int)$initTimeStamp)
            return false;

        //check hiddenfield
            $hiddenId = $this->session->get('hiddenId', false, 'eccl');
            $hiddenFieldValue = Factory::getApplication()->getInput()->get($hiddenId, '', 'RAW');

            if (!empty($hiddenFieldValue))
                return false;

        //check Captcha
        $spamCheckNumber1 = (int)$session->get('spamCheckNumber1', null, 'eccl');
        $spamCheckNumber2 = (int)$session->get('spamCheckNumber2', null, 'eccl');
        $session->clear('spamCheckNumber1', 'eccl');
        $session->clear('spamCheckNumber2', 'eccl');

        if (is_null($spamCheckNumber1) || is_null($spamCheckNumber2))
                return false;
        if ($spamCheckNumber1 + $spamCheckNumber2 !== (int)$result)
                return false;

        return true;
    }
