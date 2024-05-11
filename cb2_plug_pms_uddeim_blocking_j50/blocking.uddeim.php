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

class getUddeIMblockingTab extends cbTabHandler {

	var $config;
	var $absolute_path;
	var $pathtoadmin;
	var $pathtouser;
	var $pathtosite;
	var $mosConfig_lang;
	var $myuserid;
	var $mygroupid;

	function __construct() {
		$this->cbTabHandler();
		$uddeim_isadmin = 0;
		if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
			if (!file_exists(JPATH_SITE.'/components/com_uddeim/uddeim.php'))
				die( 'blocking.uddeim: UddeIM main component not installed.' );
			require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
		} else {
			global $mainframe;
			if (!file_exists($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeim.php'))
				die( 'blocking.uddeim: UddeIM main component not installed.' );
			require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
		}

		$this->absolute_path = uddeIMgetPath('absolute_path');
		$this->pathtoadmin   = uddeIMgetPath('absolute_path')."/administrator/components/com_uddeim";
		$this->pathtouser    = uddeIMgetPath('absolute_path')."/components/com_uddeim";
		$this->pathtosite    = uddeIMgetPath('live_site');

		if (file_exists( $this->pathtoadmin."/config.class.php" ))
			include_once( $this->pathtoadmin."/config.class.php" );
		if (file_exists( $this->pathtouser."/includes.db.php" ))
			include_once( $this->pathtouser."/includes.db.php" );
		if (file_exists( $this->pathtouser."/getpiclink.php" ))
			include_once( $this->pathtouser."/getpiclink.php" );
		$this->config = new uddeimconfigclass();

		$this->mosConfig_lang = uddeIMgetLang();
		$this->myuserid = uddeIMgetUserID();
		$this->mygroupid = uddeIMgetGroupID();
	}

	function getDisplayTab($tab,$user,$ui) {
		global $_CB_database;

		if (!$this->config->blocksystem)
			return null;

		if (!$this->myuserid)
			return null;

		$params = $this->params;
		$is_enabled = (int)$params->get('uddeIMblockingPlugEnabled', "1");

		$this->_getLanguageFile();

		$action  = uddeIMmosGetParam ($_GET, 'action', '');
		$blocker = (int)uddeIMmosGetParam ($_REQUEST, 'blocker', 0);
		$blocked = (int)uddeIMmosGetParam ($_REQUEST, 'blocked', 0);

		if ($is_enabled) {

			if ($action == "delete") {
				if ($blocked && $blocker && $blocker==$this->myuserid) {
					$sql = "DELETE FROM `#__uddeim_blocks` WHERE blocked=".$blocked." AND blocker=".$blocker;
					$_CB_database->setQuery( $sql );
					if (!$_CB_database->query())
						die("SQL error" . $_CB_database->stderr(true));
					$ret = '<fieldset><legend>'._UDDEIM_CBPLUG_BLOCKINGCFG.'</legend>';
					$ret .= _UDDEIM_CBPLUG_NOWUNBLOCKED;
					$ret .= "<br /><br /><a href='".uddeIMsefRelToAbs("index.php?option=com_comprofiler&task=userProfile&user=".$user->id."&tab=getUddeIMblockingTab")."'>"._UDDEIM_CBPLUG_CONT."</a>";
					$ret .= '</fieldset>';
					return $ret;
				}
			} elseif ($action == "add") {
				if ($blocked && $blocker && $blocker==$this->myuserid) {
					$_CB_database->setQuery("SELECT count(id) FROM `#__uddeim_blocks` WHERE blocker=".$blocker." AND blocked=".$blocked);
					$exists = (int)$_CB_database->loadResult();
					if (!$exists) {
						$sql = "INSERT INTO `#__uddeim_blocks` (blocker, blocked) VALUES (".$blocker.", ".$blocked.")";
						$_CB_database->setQuery( $sql );
						if (!$_CB_database->query())
							die("SQL error" . $_CB_database->stderr(true));
					}
					$ret = '<fieldset><legend>'._UDDEIM_CBPLUG_BLOCKINGCFG.'</legend>';
					$ret .= _UDDEIM_CBPLUG_NOWBLOCKED;
					$ret .= "<br /><br /><a href='".uddeIMsefRelToAbs("index.php?option=com_comprofiler&task=userProfile&user=".$user->id."&tab=getUddeIMblockingTab")."'>"._UDDEIM_CBPLUG_CONT."</a>";
					$ret .= '</fieldset>';
					return $ret;
				}
			} else {

				if ($user->id!=$this->myuserid) {
                     
					$_CB_database->setQuery("SELECT count(id) FROM `#__uddeim_blocks` WHERE blocker=".(int)$this->myuserid." AND blocked=".(int)$user->id);
					$is_blocked = (int)$_CB_database->loadResult();

					if ($is_blocked) {
						// $ret = '<form action="index.php?option=com_comprofiler&task=userProfile&user='.$user->id.'&tab=getUddeIMblockingTab&action=none" method="post">';
						$ret = '<fieldset><legend>'._UDDEIM_CBPLUG_BLOCKINGCFG.'</legend>';
						$ret .= _UDDEIM_CBPLUG_BLOCKED."<br /><br /><a href='".uddeIMsefRelToAbs("index.php?option=com_comprofiler&task=userProfile&user=".$user->id."&tab=getUddeIMblockingTab&blocker=".$this->myuserid."&blocked=".$user->id."&action=delete")."'>"._UDDEIM_CBPLUG_DOUNBLOCK."</a>";
						$ret .= '</fieldset>';
						return $ret;
					} else {
						// $ret = '<form action="index.php?option=com_comprofiler&task=userProfile&user='.$user->id.'&tab=getUddeIMblockingTab&action=none" method="post">';
						$ret = '<fieldset><legend>'._UDDEIM_CBPLUG_BLOCKINGCFG.'</legend>';
						$ret .= _UDDEIM_CBPLUG_UNBLOCKED."<br /><br /><a href='".uddeIMsefRelToAbs("index.php?option=com_comprofiler&task=userProfile&user=".$user->id."&tab=getUddeIMblockingTab&blocker=".$this->myuserid."&blocked=".$user->id."&action=add")."'>"._UDDEIM_CBPLUG_DOBLOCK."</a>";
						$ret .= '</fieldset>';
						return $ret;
					}

				} else {
						$blockedusers = uddeIMselectBlockerBlockedList($this->myuserid, $this->config);
						$howmanyblocks=count($blockedusers);
						// $ret = '<form action="index.php?option=com_comprofiler&task=userProfile&user='.$user->id.'&tab=getUddeIMblockingTab&action=none" method="post">';
						$ret = '<fieldset><legend>'._UDDEIM_CBPLUG_BLOCKINGCFG.'</legend>';
						if ($howmanyblocks) {
							$ret .= "<p>"._UDDEIM_BLOCKS_EXP."</p>\n";
							$ret .= "<p>"._UDDEIM_YOUBLOCKED_PRE.$howmanyblocks._UDDEIM_YOUBLOCKED_POST."</p>\n";
							foreach($blockedusers as $blockeduser) {
								if ($blockeduser->displayname)
									$ret .= uddeIMgetLinkOnly($blockeduser->blocked, "<b>".$blockeduser->displayname."</b>", $this->config);
								else
									$ret .= _UDDEADM_NONEORUNKNOWN;
								$ret .= "&nbsp;&nbsp;";
								$ret .= "<a href='".uddeIMsefRelToAbs("index.php?option=com_comprofiler&task=userProfile&user=".$user->id."&tab=getUddeIMblockingTab&blocker=".$blockeduser->blocker."&blocked=".$blockeduser->blocked."&action=delete")."'>"._UDDEIM_CBPLUG_UNBLOCKNOW."</a><br />";
							}
						} else {
							$ret .= "<p>"._UDDEIM_NOBODYBLOCKED."</p>\n";
						}

						$ret .= '</fieldset>';
						return $ret;
				}
			}
		}
		return null;
	}

	function _getLanguageFile() {
		if(!defined('_UDDEIM_INBOX')) {
			$postfix = "";
			if ($this->config->languagecharset)
				$postfix = ".utf8";
			if (file_exists($this->pathtoadmin.'/language'.$postfix.'/'.$this->mosConfig_lang.'.php')) {
				include_once($this->pathtoadmin.'/language'.$postfix.'/'.$this->mosConfig_lang.'.php');
			} elseif (file_exists($this->pathtoadmin.'/language'.$postfix.'/english.php')) {
				include_once($this->pathtoadmin.'/language'.$postfix.'/english.php');
			} elseif (file_exists($this->pathtoadmin.'/language/english.php')) {
				include_once($this->pathtoadmin.'/language/english.php');
			}
		}
	}
}
