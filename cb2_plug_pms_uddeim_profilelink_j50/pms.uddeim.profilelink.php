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
		die( 'pms.uddeim.profilelink: UddeIM main component not installed.' );
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
} else {
	global $mainframe;
	if (!file_exists($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeim.php'))
		die( 'pms.uddeim.profilelink: UddeIM main component not installed.' );
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
}

require_once(uddeIMgetPath('admin')."/admin.shared.php");		// before includes.php is included!
require_once(uddeIMgetPath('user').'/includes.php');
require_once(uddeIMgetPath('user').'/includes.db.php');
require_once(uddeIMgetPath('user').'/crypt.class.php');
require_once(uddeIMgetPath('admin')."/config.class.php");			// get the configuration file

class getuddeimLinkTab extends cbTabHandler {

	var $config;
	var $absolute_path;
	var $mosConfig_lang;
	var $mosConfig_sitename;
	var $mosConfig_live_site;
	var $myuserid;
	var $mygroupid;

	function __construct() {
		$this->cbTabHandler();
		$this->config = new uddeimconfigclass();
		$this->absolute_path = uddeIMgetPath('absolute_path');
		$this->mosConfig_lang = uddeIMgetLang();
		$this->mosConfig_sitename = uddeIMgetSitename();
		$this->mosConfig_live_site = uddeIMgetPath('live_site');
		$this->myuserid = uddeIMgetUserID();
		$this->mygroupid = uddeIMgetGroupID();

		uddeIMloadLanguage(uddeIMgetPath('admin'), $this->config);
	}

	function _checkPMSinstalled($pmsType) {
		if (!file_exists($this->absolute_path.'/components/com_uddeim/uddeim.php')) {
			$this->_setErrorMSG(_UE_PMS_NOTINSTALLED);
			return false;
		}
		return true;
	}
	
	function getDisplayTab($tab,$user,$ui) {
		global $_CB_database;

		$myself = $this->myuserid;
		if ($myself == $user->id)
			return null;

		$my_gid = uddeIMgetGID($myself);

		$params = $this->params;
		$showTitle = $params->get('showTitlePL', "1");
		$noUserlist = $params->get('noUserlistPL', "0");
		$noTo = $params->get('noToPL', "0");
		$textLink = $params->get('textLinkPL', "Send Private Message");

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

		$value = 0;
		if ($noUserlist)
			$value += 3;
		if ($noTo)
			$value += 4;

		$link = $this->_getPMSlink($user->id);
		if ($value)
			$link .= "&nouserlist=".(int)$value;

		$return = "";
		if($showTitle) $return .= "<div class=\"titleCell\" style=\"width:95%; align: left; text-align:left; margin-left: 0px;\">"
							.$this->_unHtmlspecialchars($this->_getLangDefinition($tab->title))."</div>\n";

		if($tab->description != null)
			$return .= "<div class=\"tab_Description\">".$this->_unHtmlspecialchars($this->_getLangDefinition($tab->description))."</div>\n";

		$return .= "<div class=\"fieldCell\" style=\"text-align:left;width:95%;\">";
		$return .= "<a href='".uddeIMsefRelToAbs($link)."'>".$textLink."</a>";
		$return .= "</div>";

		return $return;
    }
		
	function _getPMSlink($toid) {
		global $_CB_database;

		$pmsurlSend="index.php?option=com_uddeim&task=new&recip=".$toid;
		$item_id = uddeIMgetItemid($this->config);
		if ($item_id) {
			$pmsurlSend .= "&Itemid=".$item_id;
		}
		return $pmsurlSend;
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
