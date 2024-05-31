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
// version 5.1
// ****************************************************************************
defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );


// for the public frontend we have
// all libs
// the configuration file
// the language file
//
// Note: $my->id is ZERO
//
// all REQUEST vars must be evaluated here for security reasons

use Joomla\CMS\Factory;

function uddeIMcheckPluginPF() {
	return 7;
}

function uddeIMpublicFrontendPlugin($versionstring, $pathtouser, $pathtosite, $config) {
	// not required since I do this in uddeim.php now
	//	session_start();

	$Itemid 	= uddeIMmosGetParam( $_REQUEST, 'Itemid');
	if (!$Itemid || !isset($Itemid) || empty( $Itemid )) {
		$Itemid = uddeIMgetItemid($config);
	} else if ($config->overwriteitemid) {
		$Itemid = (int)$config->useitemid;
	}

	$item_id	= (int) $Itemid;
	$task		= uddeIMmosGetParam( $_REQUEST, 'task', 'inbox');	// task is publicnew or publicsave

	$recip		= (int) uddeIMmosGetParam ( $_REQUEST, 'recip');				// für blocking nach ID and new message
	$runame		= uddeIMmosGetParam ( $_REQUEST, 'runame');	// für blocking nach NAME and new message

	$to_id		= (int) uddeIMmosGetParam ($_POST, 'to_id');
	$to_name	= uddeIMmosGetParam ($_POST, 'to_name');
	$fromname	= uddeIMmosGetParam ($_POST, 'from_name');
	$fromemail	= uddeIMmosGetParam ($_POST, 'from_email');
	$pmessage	= strip_tags(uddeIMmosGetParam($_POST, 'pmessage', '', _MOS_ALLOWHTML));
	$spamtrap	= uddeIMmosGetParam ($_POST, 'city');
	if ($spamtrap)
		$task = "spamtrap";

	$sendeform_showallusers = uddeIMmosGetParam ($_POST, 'sendeform_showallusers', '');
	$backto			= uddeIMmosGetParam ($_POST, 'backto');

	// load template css file
	if(!$config->templatedir) {
		$config->templatedir="default";
	}

	$omitDefaultOutput = false;

	if (Factory::getApplication()->getInput()->get('no_html',false))
		$omitDefaultOutput = true;

	//if (uddeIMmosGetParam( $_REQUEST, 'no_html', false ))
		//$omitDefaultOutput = true;

	// now start the output
	if (!$omitDefaultOutput){
		echo "\n<!-- ".$versionstring." output below -->\n";

		// load the css file
		$css = "";
		if(file_exists($pathtouser.'/templates/'.$config->templatedir.'/css/uddeim.css')) {
			$css = $pathtosite."/components/com_uddeim/templates/".$config->templatedir."/css/uddeim.css";
		} else {
			// template css doesn't exist, now we try to load the default css file
			if(file_exists($pathtouser.'/templates/default/css/uddeim.css'))
				$css = $pathtosite."/components/com_uddeim/templates/default/css/uddeim.css";
		}
		uddeIMaddCSS($css);


		if ($config->pubuseautocomplete) {
		 // no more special css needed, some line include in uddeim.css
		}
		echo "<div id='uddeim'><div id='uddeim-topborder'></div>\n";
	}
	// fork according to task
	switch ($task) {
		case 'completeUserName':
			uddeIMcompleteUserName(0, $config);
			break;
		case "spamtrap":
			uddeIMprintPublicMenu($item_id, $config);
			echo "<div id='uddeim-m'>\n<div id='uddeim-bottomlines'>\n";
			echo "<p><b>"._UDDEIM_PUBLICSENT."</b></p>";
			echo "</div>\n</div>\n<div id='uddeim-bottomborder'></div>\n";
			break;
		case "publicsent":
			uddeIMprintPublicMenu($item_id, $config);
			echo "<div id='uddeim-m'>\n<div id='uddeim-bottomlines'>\n";
			echo "<p><b>"._UDDEIM_PUBLICSENT."</b></p>";
			echo "</div>\n</div>\n<div id='uddeim-bottomborder'></div>\n";
			break;
		case "publicsave":
			uddeIMpublicSaveMessage($fromname, $fromemail, $to_name, $to_id, $pmessage, $item_id, $sendeform_showallusers, $backto, $config);
			break;
		case "publicnew":
		default:
			uddeIMpublicNewMessage($item_id, $to_id, $recip, $runame, $pmessage, $config);
			break;
	}

	if (!$omitDefaultOutput){
		echo "</div>\n";		// </div id='uddeim'>
		echo "<!-- ".$versionstring." output above -->\n";
	}
}

// *****************************************************************************************

function uddeIMpublicSaveMessage($fromname, $fromemail, $to_name, $to_id, $pmessage, $item_id, $sendeform_showallusers, $backto, $config) {
	$mosConfig_sitename = uddeIMgetSitename();
	$pathtosite  = uddeIMgetPath('live_site');
	$database = uddeIMgetDatabase();

	$to_name = stripslashes($to_name);

	$to_name_bak = $to_name;		// save all already typed in names

	if(!$to_id && !$to_name && $sendeform_showallusers!=2) {
		// write the uddeim menu
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 5, $config);
		return;
	}

	if($sendeform_showallusers) {	// =2, click on button / =1, keep on showing
		// write the uddeim menu
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 1, $config);
		return;
	}

	// do not allow multiple recipients from public frontend
	$to_name = trim($to_name);
	$fromname = trim($fromname);
	$fromemail = trim($fromemail);

	if(!$fromname) {
		// write the uddeim menu
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 12, $config);
		return;
	}

	// When there is an email address this must be valid
	if ($fromemail && !preg_match("/\b[a-z0-9!#$%&'*+\/=?^_`{|}-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/i", $fromemail)) {
		// write the uddeim menu
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 13, $config);
		return;
	}

	// Check if an email address is required
	if (!$fromemail && $config->pubemail) {
		// write the uddeim menu
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 13, $config);
		return;
	}

	$to_id = uddeIMgetIDfromNamePublic($to_name, $config, true);	// add "AND block=0"
	// BUGBUG: Maybe it is a good idea to do the query vice versa (so I could add a query for "realname"s here)
	if (!$to_id) { // no user with this name found, so try again with username (maybe we do the query twice (see query above, but who cares)
		if ($config->pubrealnames) {
			$to_id = uddeIMgetIDfromUsername($to_name, true);		// add "AND block=0"
		}
	}

	if(!$to_id) { // no user with this username found
		// display to form again so that the user can correct his/her fault
		// the wrong name is displayed in brackets (add brackets only once)
		if (substr($to_name,0,1)!="(") {
			$to_name = str_replace($to_name, "(".$to_name.")", $to_name_bak);
		}
		// write the uddeim menu
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 3, $config);
		return;
	}

	// now check banning
	$is_banned = uddeIMisBanned($to_id, $config);
	if ($is_banned) {
		if (substr($to_name,0,1)!="(") {
			$to_name = str_replace($to_name, "(".$to_name.")", $to_name_bak);
		}
		// write the uddeim menu
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 17, $config);
		return;
	}

	// now check group blocking
	$is_group_blocked = uddeIMisRecipientBlockedPublic($to_id, $config);
	if ($is_group_blocked) {
		if (substr($to_name,0,1)!="(") {
			$to_name = str_replace($to_name, "(".$to_name.")", $to_name_bak);
		}
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 10, $config);
		return;
	}

	if(!$pmessage) {
		// write the uddeim menu
		$to_name = $to_name_bak;
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 4, $config);
		return;
	}

	// check if user allows public access (this check must be done after group blocking, because the admin can block a certain group and the user cannot longer decide if he allows the public frontend or not)
	$ispublic = uddeIMgetEMNpublic($to_id);
	if (!$ispublic) {		// user does not allow public messages
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 8, $config);
		return;
	}
			
	// CAPTCHA (first check for all other errors and then the CAPTCHA)
	if ($config->usecaptcha>=1) {		// CAPTCHA is enabled for public frontend
		if ($config->captchatype==0) {
				// CAPTCHA
				$session = Factory::getApplication()->getSession();
				$_SESSION['security_code'] = $session->get('security_code');	// so I do not need to modify saveMessage code


			if( $_SESSION['security_code'] == strtolower($_POST['security_code']) && !empty($_SESSION['security_code'] ) ) {
				// CAPTCHA is correct, so unset security code
				$session->set('security_code', null);

			} else {
				// wrong captcha, so write the uddeim menu
				$to_name = $to_name_bak;
				uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 7, $config);
				return;
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
			// die ("The reCAPTCHA wasn't entered correctly. Go back and try it again. (reCAPTCHA said: " . $resp->error . ")");
			
			$capinput = Factory::getApplication()->getInput()->get('eccl', '', 'RAW');
            		if (!CheckCaptcha($capinput,$config->timedelay)) {
				$to_name = $to_name_bak;
				uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 7, $config);
				return;				
		    }
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
				if (!$resp->isSuccess()) {
					$to_name = $to_name_bak;
					uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 7, $config);
					return;
				}
			}
		}
	}

	if (!uddeIMcheckCSRF($config)) {
		$to_name = $to_name_bak;
		uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, 15, $config);
		return;
	}

	$savedatum  = uddetime($config->timezone);
	$savetoid   = $to_id;
	$savefromid = 0;			// This is '0' in public frontend

	// CRYPT
	if ($config->cryptmode>=1) {	// because of encoding do not use slashes
		$savemessage=strip_tags($pmessage);
	} else {
		$savemessage=addslashes(strip_tags($pmessage));   // original 0.6+
	}

	// strip bbcodes
	if (!$config->allowbb) {
		$savemessage=uddeIMbbcode_strip($savemessage);
	}

	// set message max length
	if ($config->maxlength>0) { // because if 0 do not use any maxlength
		$savemessage=substr($savemessage, 0, $config->maxlength);
	}

	$fromname=addslashes(strip_tags($fromname));
	$fromemail=addslashes(strip_tags($fromemail));

	$delayed = 0;
	if ($config->modpubusers)
		$delayed = 1;
	
	// we have all we need, now save it
	// no replyid can be set here, since public users cannot reply to a message, replyid = 0
	// CRYPT
	if ($config->cryptmode==1 || $config->cryptmode==2 || $config->cryptmode==4) {		// do not allow individual encryption
		$cm = uddeIMencrypt($savemessage,$config->cryptkey,CRYPT_MODE_BASE64);
		$sql="INSERT INTO `#__uddeim` (`delayed`, publicname, publicemail, fromid, toid, message, datum, totrashoutbox, totrashdateoutbox, cryptmode, crypthash) VALUES (".(int)$delayed.", '".$fromname."', '".$fromemail."', ".(int)$savefromid.", ".(int)$savetoid.", '".$cm."', ".$savedatum.",1,".$savedatum.",1,'".md5($config->cryptkey)."')";
	} elseif ($config->cryptmode==3) {
		$cm = uddeIMencrypt($savemessage,"",CRYPT_MODE_STOREBASE64);
		$sql="INSERT INTO `#__uddeim` (`delayed`, publicname, publicemail, fromid, toid, message, datum, totrashoutbox, totrashdateoutbox, cryptmode) VALUES (".(int)$delayed.", '".$fromname."', '".$fromemail."', ".(int)$savefromid.", ".(int)$savetoid.", '".$cm."', ".$savedatum.",1,".$savedatum.",3)";
	} else {
		$sql="INSERT INTO `#__uddeim` (`delayed`, publicname, publicemail, fromid, toid, message, datum, totrashoutbox, totrashdateoutbox) VALUES (".(int)$delayed.", '".$fromname."', '".$fromemail."', ".(int)$savefromid.", ".(int)$savetoid.", '".$savemessage."', ".$savedatum.",1,".$savedatum.")";
	}
	$database->setQuery($sql);
	if (!$database->execute()) {
		die("SQL error when attempting to save a message" . $database->stderr(true));
	}
	$insID = $database->insertid();

	// When public users are moderated, delay the message
	// if (uddeIMgetEMNmoderated($savefromid) ) { // && uddeIMisReggedOnly($my_gid)) {
	// 	uddeIMupdateDelayed($savefromid, $insID, 1);
	// }

	// Check if E-Mail notification or popups are enabled by default, if so create a record for the receiver.
	// Note: Not necessary for "copy to myself" sind the record for the current user has been set at the very beginning...
	if ($config->notifydefault>0 || $config->popupdefault>0 || $config->pubfrontenddefault>0 || $config->autoresponder>0 || $config->autoforward>0) {
		if (!uddeIMexistsEMN($savetoid))
			uddeIMinsertEMNdefaults($savetoid, $config);
	}

	$rec_gid = uddeIMgetGID((int)$savetoid);

	
	// ##################################################################################################
	// autoforward code
	// ##################################################################################################
	if ($config->autoforward==1 || ($config->autoforward==2 && (uddeIMisAdmin($rec_gid) || uddeIMisAdmin2($rec_gid, $config)))) {
		$ison = uddeIMgetEMNautoforward($savetoid);						// recipient has autoforward enabled
		if ($ison==1) {
			$autoforwardid = uddeIMgetEMNautoforwardid($savetoid);	// new recipient
			$forwardheader="

[i]("._UDDEIM_THISISAFORWARD.uddeIMgetNameFromID($savetoid, $config).")[/i]";
			$savemessagecopy = $savemessage.$forwardheader;
			$themode = 0;
			if ($config->cryptmode==1) {
				$themode = 1;
				$cm = uddeIMencrypt($savemessagecopy,$config->cryptkey,CRYPT_MODE_BASE64);
				$sql  = "INSERT INTO `#__uddeim` (fromid, toid, message, datum, cryptmode, crypthash) VALUES (".(int)$savefromid.", ".(int)$autoforwardid.", '".$cm."', ".$savedatum.",1,'".md5($config->cryptkey)."')";
			} elseif ($config->cryptmode==2) {
				$themode = 2;
				$thepass=$cryptpass;
				if (!$thepass) {	// no password entered, then fallback to obfuscating
					$themode = 1;
					$thepass=$config->cryptkey;
				}
				$cm = uddeIMencrypt($savemessagecopy,$thepass,CRYPT_MODE_BASE64);
				$sql  = "INSERT INTO `#__uddeim` (fromid, toid, message, datum, cryptmode, crypthash) VALUES (".(int)$savefromid.", ".(int)$autoforwardid.", '".$cm."', ".$savedatum.",".$themode.",'".md5($thepass)."')";
			} elseif ($config->cryptmode==3) {
				$themode = 3;
				$cm = uddeIMencrypt($savemessagecopy,"",CRYPT_MODE_STOREBASE64);
				$sql  = "INSERT INTO `#__uddeim` (fromid, toid, message, datum, cryptmode) VALUES (".(int)$savefromid.", ".(int)$autoforwardid.", '".$cm."', ".$savedatum.",3)";
			} elseif ($config->cryptmode==4) {
				$themode = 4;
				$thepass=$cryptpass;
                $cipher = CRYPT_MODE_OSSL_AES_256;
				if (!$thepass) {	// no password entered, then fallback to obfuscating
					$themode = 1;
					$thepass=$config->cryptkey;
                    $cipher = CRYPT_MODE_BASE64;
				}
				$cm = uddeIMencrypt($savemessagecopy,$thepass,$cipher);
				$sql  = "INSERT INTO `#__uddeim` (fromid, toid, message, datum, cryptmode, crypthash) VALUES (".(int)$savefromid.", ".(int)$autoforwardid.", '".$cm."', ".$savedatum.",".$themode.",'".md5($thepass)."')";
			} else {
				$sql  = "INSERT INTO `#__uddeim` (fromid, toid, message, datum) VALUES (".(int)$savefromid.", ".(int)$autoforwardid.", '".$savemessage."', ".$savedatum.")";
			}
			$database->setQuery($sql);
			if (!$database->execute()) {
				die("SQL error when attempting to save a message" . $database->stderr(true));
			}
			$insIDforward = $database->insertid();
		}
	}

	// ##################################################################################################
	// autoresponder
	// ##################################################################################################
	if ($config->autoresponder==1 || ($config->autoresponder==2 && (uddeIMisAdmin($rec_gid) || uddeIMisAdmin2($rec_gid, $config)))) {
		$ison = uddeIMgetEMNautoresponder($savetoid);
		if ($ison==1)  {
			// $sql="INSERT INTO `#__uddeim` (fromid, toid, message, datum, totrashoutbox, totrashdateoutbox) VALUES (".(int)$savetoid.", ".(int)$savefromid.", '". _UDDEIM_AUTORESPONDER_DEFAULT ."', ".$savedatum.", 1,".uddetime($config->timezone).")";

// BUGBUG: An autoresponder message is send via email but no message in the outbox is created.
// This is not a bug since in my opinion it does not make sense to store autoresponder messages AND the received message.

			if($config->emailtrafficenabled && $fromemail) {

				$autorespondertext = uddeIMgetEMNautorespondertext($savetoid);

				$var_fromname = uddeIMgetNameFromID($savetoid, $config);
				if (!$var_fromname)
					$var_fromname=$config->sysm_username;

				$var_body = _UDDEIM_EMN_BODY_PUBLICWITHMESSAGE;
				$var_body = str_replace("%livesite%", $pathtosite, $var_body);
				$var_body = str_replace("%user%", $var_fromname, $var_body);
				$var_body = str_replace("%site%", $mosConfig_sitename, $var_body);
				$var_body = str_replace("%you%", $fromname, $var_body);
				$autorespondertext = str_replace(chr(13).chr(10), "\n", $autorespondertext);
				$var_body = str_replace("%pmessage%", $autorespondertext, $var_body);

				$subject = _UDDEIM_EMN_SUBJECT;
				$subject = str_replace("%livesite%", $pathtosite, $subject);
				$subject = str_replace("%site%", $mosConfig_sitename, $subject);
				$subject = str_replace("%you%", $fromname, $subject);
				$subject = str_replace("%user%", $var_fromname, $subject);

				$replyto = $fromemail;
				$replytoname = "";

				if(uddeIMsendmail($config->emn_sendername, $config->emn_sendermail, $var_toname, $fromemail, $subject, $var_body, $replyto, $replytoname, "", $config)) {
					// maybe a code here that the email cound not have been sent
				}
			}
		}
	}

	// ##################################################################################################
	// email notification
	// ##################################################################################################

	// is the receiver currently online?
	$currentlyonline = uddeIMisOnline($savetoid);

	if ($config->cryptmode>=1) {
		$email=stripslashes($savemessage);
	} else {
		$email=stripslashes(stripslashes($savemessage));	// without encoding remove the safety slashes
	}

	if($config->allowemailnotify==1) {
		$ison = uddeIMgetEMNstatus($savetoid);
		if (($ison==1) || ($ison==2 && !$currentlyonline) || ($ison==10) || ($ison==20 && !$currentlyonline))  {
			uddeIMpublicDispatchEMN($insID, $fromname, $savetoid, $email, 0, $config);
			// 0 stands for normal (not forgetmenot)
		}
	} elseif($config->allowemailnotify==2) {
		$my_gid = uddeIMgetGID((int)$savetoid);
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) {
			$ison = uddeIMgetEMNstatus($savetoid);
			if (($ison==1) || ($ison==2 && !$currentlyonline) || ($ison==10) || ($ison==20 && !$currentlyonline))  {
				uddeIMpublicDispatchEMN($insID, $fromname, $savetoid, $email, 0, $config);
				// 0 stands for normal (not forgetmenot)
			}
		}
	}

	$mosmsg="";		// _UDDEIM_MESSAGE_SENT
	uddeJSEFredirect("index.php?option=com_uddeim&task=publicsent&Itemid=".$item_id, $mosmsg);
}

// *****************************************************************************************

function uddeIMpublicDispatchEMN($var_msgid, $var_fromname, $var_toid, $var_message, $emn_option, $config) {
	$mosConfig_sitename = uddeIMgetSitename();
	$pathtosite  = uddeIMgetPath('live_site');

	// if e-mail traffic stopped, don't send.
	if(!$config->emailtrafficenabled) {
		return;
	}

	$fromname = $var_fromname;
	if (!$fromname)
		$fromname = _UDDEIM_PUBLICUSER;

//	$ret = uddeIMgetNameEmailFromID($var_toid, $var_toname, $var_tomail, $config);
	$var_toname = uddeIMgetNameFromID($var_toid, $config);
	$var_tomail = uddeIMgetEMailFromID($var_toid, $config);

	if(!$var_tomail)
		return;
	if (!$var_toname)
		$var_toname = "Anonymous";

	$msglink = "";
	if ($cryptmode==2) {				// Message is encrypted, so go to enter password page
		$msglink = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showpass&Itemid=".$item_id."&messageid=".$var_msgid);
	} else {							// normal message
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

	if(uddeIMsendmail($config->emn_sendername, $config->emn_sendermail, $var_toname, $var_tomail, $subject, $var_body, $replyto, $replytoname, "", $config)) {
		// set the remindersent status of this user to true
		if(!uddeIMexistsEMN($var_toid))
			uddeIMinsertEMNdefaults($var_toid, $config);
		uddeIMupdateEMNreminder($var_toid, uddetime($config->timezone));
	}
}

// *****************************************************************************************

function uddeIMpublicNewMessage($item_id, $to_id, $recip, $runame, $pmessage, $config) {

	$recipname="";
	if($recip) {
		$recipname = uddeIMgetNameFromID($recip, $config);
	} elseif ($runame) {
		$recipname = uddeIMgetNameFromID($runame, $config);
	}

	// write the uddeim menu
	uddeIMprintPublicMenu($item_id, $config);
	echo "<div id='uddeim-m'>\n";

	// which page did refer to this page?
	// because we want to send back the user where (s)he came from
	$tbackto = uddeIMmosGetParam( $_SERVER, 'HTTP_REFERER', null );
	if(stristr($tbackto ?? '', "com_pms")) {
		$tbackto="";
	}
	uddeIMdrawPublicWriteform($item_id, $tbackto, "", "", $recipname, $pmessage, 0, $config); // isreply, errorcode, sysmsg
	echo "</div>\n<div id='uddeim-bottomborder'></div>\n";
}

function uddeIMdoPublicShowAllUsers($config) {						
	$database = uddeIMgetDatabase();

	$hide = "";
	if ($config->pubhideusers)
		$hide = "AND a.id NOT IN (".uddeIMquoteSmart($config->pubhideusers).") ";

	$hide2 = "";
	if ($config->pubblockgroups)
		$hide2 = "AND gid NOT IN (".uddeIMquoteSmart($config->pubblockgroups).") ";

	switch ($config->pubhideallusers) {
		case 3:		// special users
			$sql="SELECT a.".($config->pubrealnames ? "name" : "username")." AS displayname FROM `#__users` AS a, `#__uddeim_emn` AS b WHERE a.id=b.userid AND b.public=1 AND a.block=0 AND gid NOT IN (19,20,21,23,24,25) ".$hide.$hide2."ORDER BY a.".($config->pubrealnames ? "name" : "username");
			break;
		case 2:		// admins
			$sql="SELECT a.".($config->pubrealnames ? "name" : "username")." AS displayname FROM `#__users` AS a, `#__uddeim_emn` AS b WHERE a.id=b.userid AND b.public=1 AND a.block=0 AND gid NOT IN (24,25) ".$hide.$hide2."ORDER BY a.".($config->pubrealnames ? "name" : "username");
			break;
		case 1:		// superadmins
			$sql="SELECT a.".($config->pubrealnames ? "name" : "username")." AS displayname FROM `#__users` AS a, `#__uddeim_emn` AS b WHERE a.id=b.userid AND b.public=1 AND a.block=0 AND gid NOT IN (25) ".$hide.$hide2."ORDER BY a.".($config->pubrealnames ? "name" : "username");
			break;
		default:	// none
			$sql="SELECT a.".($config->pubrealnames ? "name" : "username")." AS displayname FROM `#__users` AS a, `#__uddeim_emn` AS b WHERE a.id=b.userid AND b.public=1 AND a.block=0 ".$hide.$hide2."ORDER BY a.".($config->pubrealnames ? "name" : "username");
			break;
	}

	$database->setQuery($sql);
	$rows=$database->loadObjectList();
	if (count($rows)>0) {
		$allnames="<select size=\"1\" class=\"inputbox\" name=\"userlist\" onchange=\"document.sendeform.to_name.value=document.sendeform.userlist.value; return false;\">";
		$allnames.="<option value=\"\">&nbsp;</option>";
		foreach ($rows as $row)
			$allnames.="<option value=\"".$row->displayname."\">".$row->displayname."</option>";
		$allnames.="</select>";
		echo _UDDEIM_USERLIST."<br />";
		echo $allnames;
	}
}

function uddeIMpublicMenuWriteform($item_id, $fromname, $fromemail, $to_name, $pmessage, $error, $config) {
	uddeIMprintPublicMenu($item_id, $config);
	echo "<div id='uddeim-m'>\n";
	$fromname=stripslashes($fromname);
	$fromemail=stripslashes($fromemail);
	$to_name=stripslashes($to_name);
	$pmessage=stripslashes($pmessage);
	uddeIMdrawPublicWriteform($item_id, "", $fromname, $fromemail, $to_name, $pmessage, $error, $config);
	echo "</div>\n<div id='uddeim-bottomborder'></div>\n";
}

function uddeIMprintPublicMenu($item_id, $config) {
	$pathtosite  = uddeIMgetPath('live_site');

	if($config->showtitle)
		echo "<div class='contentheading'>".$config->showtitle."</div>";
	echo "\n<div id='uddeim-navbar2'><ul>\n";

	echo "<li>";
	if($config->showmenuicons) {
		echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=publicnew&Itemid=".$item_id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_new.gif' border='0' alt='"._UDDEIM_COMPOSE."' /></a>";
	}
	echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=publicnew&Itemid=".$item_id)."'>"._UDDEIM_COMPOSE."</a>";
	echo "</li>\n";

//	echo "<li class='uddeim-activemenu'>";
//	if($config->showmenuicons)
//		echo "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_new.gif' />";
//	echo _UDDEIM_COMPOSE;
//	echo "</li>\n";
	echo "</ul></div>\n";
}

function uddeIMdrawPublicWriteform($item_id, $backto, $fromname, $fromemail, $recipname, $pmessage, $dwf_errorcode, $config) {
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
	// 12 = error in from name
	// 13 = error in from email
	// 14 = time delay for spam protection
	// 15 = csrf protection
	// 16 = administrative blocking
	// 17 = user has been banned
	// 18 = file upload failed
	// 19 = file size exceeded
	// 20 = file type not allowed

	// This functions expects values stripslashed

	echo "<div id='uddeim-writeform'>\n";
	echo "<form name='sendeform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=publicsave&Itemid=".$item_id)."'>\n";
	echo "<input type='hidden' name='sendeform_showallusers' value='' />\n";
	uddeIMwriteCSRF($config);

	if($dwf_errorcode==0 && $backto) {
		echo "<input type='hidden' name='backto' value='".$backto."' />\n";
	}

	echo "<table width='100%' cellspacing='0' cellpadding='0'>";

// START SENDER LINE IN TABLE
	echo "<tr><td colspan='2' valign='top'>"._UDDEIM_YOURNAME."<br />";
	$errorstyle='';
	if($dwf_errorcode==12)
		$errorstyle='style="background-color: #ff0000;" ';

	echo "<input type='text' ".$errorstyle."name='from_name' value='".htmlentities($fromname, ENT_QUOTES, $config->charset)."' /></td></tr>";

// START SENDER EMAIL LINE IN TABLE
	echo "<tr><td colspan='2' valign='top'>"._UDDEIM_YOUREMAIL."<br />";
	$errorstyle='';
	if($dwf_errorcode==13)
		$errorstyle='style="background-color: #ff0000;" ';
	echo "<input type='text' ".$errorstyle."name='from_email' value='".htmlentities($fromemail, ENT_QUOTES, $config->charset)."' /></td></tr>";

// START FIRST LINE IN TABLE (contains two fields: TO USER and select from ALL USER list)
	echo "<tr><td valign='top'>"._UDDEIM_TODP."<br />";

	if($dwf_errorcode==2 || $dwf_errorcode==3 || $dwf_errorcode==5 || 
	   $dwf_errorcode==6 || $dwf_errorcode==8 || $dwf_errorcode==9 || 
	   $dwf_errorcode==10 || $dwf_errorcode==11 || $dwf_errorcode==16 ||
	   $dwf_errorcode==17 || $dwf_errorcode==18 || $dwf_errorcode==19 ||
	   $dwf_errorcode==20) {
		$errorstyle='style="background-color: #ff0000;" ';
	} else {
		$errorstyle='';
	}

	if (!($config->flags & 0x04)) {
		echo "<input type='text' ".$errorstyle."name='to_name' id='input_to_name' value='".htmlentities($recipname, ENT_QUOTES, $config->charset)."' />&nbsp;";
	} else {
		echo "<span ".$errorstyle.">".htmlentities($recipname, ENT_QUOTES, $config->charset)."</span>";
		echo "<input type='hidden' name='to_name' id='input_to_name' value='".htmlentities($recipname, ENT_QUOTES, $config->charset)."' />&nbsp;";
	}

	if ($config->pubuseautocomplete) {
		uddeIMdoAutocomplete($config,0); //parameter 0 = userid(myself)
	}

// SECOND FIELD IN FIRST LINE IN TABLE
	echo "</td><td valign='top' align='right'>\n";
	if (!($config->flags & 0x01)) {
		if ($config->pubmodeshowallusers==1 || $config->pubmodeshowallusers==2) {
			if ($dwf_errorcode==0 && $config->pubmodeshowallusers==1) {
				// link to drop down box with names of connected users, value is 2 since it is shown the first time (so selecting the link does not show an error message because of an empty recipient field)
				echo "<br />";
				echo "<a href=\"#\" onclick=\"document.sendeform.sendeform_showallusers.value='2'; document.sendeform.submit(); return false;\">"._UDDEIM_SHOWUSERS."</a>";
			} else { // now show all users
				uddeIMdoPublicShowAllUsers($config);
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
			echo "<tr><td valign=left colspan=2><b><span style='background-color: #ff0000;'>"._UDDEIM_WRONGCAPTCHA."</b></span></td></tr>";
		} elseif ($config->captchatype==2) {
			echo "<tr><td valign=left colspan=2><b><span style='background-color: #ff0000;'>"._UDDEIM_WRONGCAPTCHA."</b></span></td></tr>";
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
	}
	echo "</table>";
	echo "<br />";

	if($config->showtextcounter && $config->maxlength) {
		uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");
	}

	if($config->allowbb || $config->allowsmile) {
		uddeIMaddScript($pathtosite."/components/com_uddeim/js/bbsmile.js");
		$num = uddeIMdoSmileysEx($config);
		uddeIMdoBB($config);
		uddeIMdoSmileys($config, $num);
	}

	$errorstyle='';
	echo "<span".$errorstyle.">"._UDDEIM_MESSAGE."</span>";
	echo "<br />";

	$thestyle = "";
	if ($config->width)
		$thestyle .= "width: ".(int)$config->width."px; ";
	if ($dwf_errorcode==4)
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

	// ================================== CAPTCHA ==============================

	if ($config->usecaptcha>=1) {
		if ($config->captchatype==0) {
		// CAPTCHA
			$errorstyle= $dwf_errorcode==7 ? 'style="height:30px;border: 2px solid red;" ' : 'style="height:30px;"';  //background-color: #ff0000		
			echo "<div class='uddeim-captcha'>";
			echo "<label for='security_code'>Security Code: </label>&nbsp;<input id='security_code' name='security_code' type='text' ".$errorstyle." />&nbsp;";
            	// CAPTCHA IMG
			echo "<img id='capimg' style='vertical-align:bottom;' alt='' src='' /> <i class='fas fa-lg fa-rotate' style='color:#777;' onclick='newcapimg()'></i><br />";
            	//load img
			echo "<script type='text/javascript'>
                	window.onload = newcapimg();
                	function newcapimg() {
                	fetch('/components/com_uddeim/captcha.php').then(response => response.text()) .then(text => {document.getElementById('capimg').src='data:image/jpg;base64,' + text;}) .catch(error => console.error(error));}
                	</script>";
			
			echo "</div>";

		} elseif ($config->captchatype==1) {
			//$pathtouser  = uddeIMgetPath('user');
			//require_once($pathtouser."/recaptchalib.php");
			echo "<div class='uddeim-captcha alert alert-link alert-light' style='display:inline-block;'>"._UDDEIM_SECURITYCODE."*&nbsp;&nbsp;";
		    	echo numericcaptcha($dwf_errorcode);
			echo "</div>";
		} elseif ($config->captchatype==2) {
			echo "<div class='uddeim-captcha'>";
            echo '<div class="g-recaptcha" data-sitekey="'. $config->recaptchapub .'"></div>';
            echo '<script type="text/javascript"';
            echo ' src="https://www.google.com/recaptcha/api.js?hl='.  uddeIMgetLang()   .'">';
            echo '</script>';
			echo "</div>";
		}		
	}

	echo "<div class='uddeim-sendbutton'>";
	echo "<input type='submit' name='reply' class='button' value='"._UDDEIM_SUBMIT."' />&nbsp;";
	echo "</div>";
	echo "<span id='city' style='visibility:hidden;'><input type='text' name='city' value='' /></span>\n";

	echo "</form>\n";
	echo "</div>\n"; // end of uddeim-writeform
}
