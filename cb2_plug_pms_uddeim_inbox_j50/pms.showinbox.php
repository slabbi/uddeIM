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

use Joomla\CMS\Factory;

class getInboxTab extends cbTabHandler {
	
	var $uddeicons_readpic = "";
	var $uddeicons_unreadpic = "";
	var $config;
	var $absolute_path;
	var $pathtoadmin;
	var $pathtouser;
	var $pathtosite;
	var $mosConfig_lang;
	var $mosConfig_offset;
	var $myuserid;
	var $mygroupid;
	
	function __construct() {
		$this->cbTabHandler();
		$uddeim_isadmin = 0;
		if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
			if (!file_exists(JPATH_SITE.'/components/com_uddeim/uddeim.php'))
				die( 'pms.showinbox.uddeim: UddeIM main component not installed.' );
			require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
		} else {
			global $mainframe;
			if (!file_exists($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeim.php'))
				die( 'pms.showinbox.uddeim: UddeIM main component not installed.' );
			require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
		}

		$this->absolute_path = uddeIMgetPath('absolute_path');
		$this->pathtoadmin   = uddeIMgetPath('absolute_path')."/administrator/components/com_uddeim";
		$this->pathtouser    = uddeIMgetPath('absolute_path')."/components/com_uddeim";
		$this->pathtosite    = uddeIMgetPath('live_site');

		require_once($this->pathtoadmin."/admin.shared.php");

		if(file_exists( $this->pathtoadmin."/config.class.php"))
			include_once( $this->pathtoadmin."/config.class.php");
		$this->config = new uddeimconfigclass();

		$this->mosConfig_lang = uddeIMgetLang();
		$this->mosConfig_offset = uddeIMgetOffset();
		$this->myuserid = uddeIMgetUserID();
		$this->mygroupid = uddeIMgetGroupID();
	}

	function _evaluateUsername($fromname, $fromid, $publicname) {
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

	function _getLanguageFile() {
		require_once( $this->pathtouser."/crypt.class.php");
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
		$this->uddeicons_readpic    = "<img alt='"._UDDEIM_STATUS_READ   ."' title='"._UDDEIM_STATUS_READ   ."' src='".$this->pathtosite."/components/com_uddeim/templates/".$this->config->templatedir."/images/nonew_im.gif' border='0'>";
		$this->uddeicons_unreadpic  = "<img alt='"._UDDEIM_STATUS_UNREAD ."' title='"._UDDEIM_STATUS_UNREAD ."' src='".$this->pathtosite."/components/com_uddeim/templates/".$this->config->templatedir."/images/new_im.gif' border='0'>";
	}

	function getDisplayTab($tab,$user,$ui) {
		global $_CB_database;

		$myself = $this->myuserid;
		if ($myself != $user->id)
			return null;

        $lang  = Factory::getLanguage();
        $input = Factory::getApplication()->getInput();


        if ($this->config->overwriteitemid && (int)$this->config->useitemid)
			$item_id = $this->config->useitemid;
        else {
		                              //assuming MIN(id) is the first published main menu item for uddeim
        $sql="SELECT COUNT(id) as ids, MIN(id) as menuid FROM `#__menu` WHERE link LIKE '%com_uddeim&view%' AND published=1 AND access".($this->mygroupid==1 ? "=" : "<=").$this->mygroupid;
        if (uddeIMcheckJversion()>=2) {          // J1.6
			$sql.=" AND language IN (" . $_CB_database->Quote($lang->get('tag')) . ",'*')";
		}
		//$sql.=" LIMIT 1";  //no limit needed as count in select returns only 1 row
		$_CB_database->setQuery($sql);
        $result = $_CB_database->loadAssoc();

		if ($result['ids'] == 0) {
			$item_id = $input->getInt('Itemid');
		} else {
			$item_id = (int)$result['menuid'];
		}
        }

		if (!$item_id) {
			// when no published link has been found, try to find an unpublished one
			$sql="SELECT count(id) as ids, MIN(id) as menuid FROM `#__menu` WHERE link LIKE '%com_uddeim&view%' AND published=0 AND access".($this->mygroupid==1 ? "=" : "<=").$this->mygroupid;
			if (uddeIMcheckJversion()>=2) {		// J1.6
				$sql.=" AND language IN (" . $_CB_database->Quote($lang->get('tag')) . ",'*')";
			}
			$_CB_database->setQuery($sql);
            $result = $_CB_database->loadAssoc();

			$item_id = $result['ids'] ? (int)$result['menuid'] : 0;
		}

		$this->_getLanguageFile();

		$params = $this->params;
		$return="";

		if($tab->description != null)
			$return .= "\t\t<div class=\"tab_Description\">".$this->_unHtmlspecialchars($this->_getLangDefinition($tab->description))."</div>\n";

		$params = $this->params;
        $entriesNumber	= $params->get('entriesNumber', '10');
		$pagingEnabled	= $params->get('pagingEnabled', 0);

		$pagingParams = $this->_getPaging(array(),array("entries_"));

		if ($pagingEnabled) {
			$sql = "SELECT count(a.id) FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=0";
			$_CB_database->setQuery($sql);
			$total=$_CB_database->loadResult();
            if (!is_numeric($total))
				$total = 0;

            if ($pagingParams["entries_limitstart"] === null)
				$pagingParams["entries_limitstart"] = 0;
            if ($entriesNumber > $total)
				$pagingParams["entries_limitstart"] = 0;
        } else {
            $pagingParams["entries_limitstart"] = 0;
        }

		$sql = "SELECT a.*, b.".($this->config->realnames ? "name" : "username")." AS fromname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND archived=0 ORDER BY datum DESC LIMIT ".($pagingParams["entries_limitstart"]?$pagingParams["entries_limitstart"]:"0").",".$entriesNumber;
		$_CB_database->setQuery($sql);
		$items=$_CB_database->loadObjectList();

		if(count($items) > 0) {
			if ($pagingEnabled) {
				$title = _UDDEIM_PLUG_INBOXENTRIES.$entriesNumber;
			} else { 
				$title = _UDDEIM_PLUG_LAST.$entriesNumber._UDDEIM_PLUG_ENTRIES;
			}

			$return .= "<br /><div class=\"sectiontableheader\" style=\"text-align:left;padding-left:0px;padding-right:0px;margin:0px 0px 10px 0px;height:auto;width:100%;\">";
			$return .= "<div class=\"sectiontableheader\" style=\"float:left;\">".$title."</div>";
		
			$return .= "<br /><div style=\"clear:both;\">&nbsp;</div>";
            $return .= "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" style=\"margin:0px;padding:0px;width:100%;\">";
            $return .= "<tr class=\"sectiontableheader\">";
            $return .= "<th>".   _UDDEIM_PLUG_STATUS   ."</th>";
            $return .= "<th>".   _UDDEIM_PLUG_SENDER   ."</th>";
           	$return .= "<th>".   _UDDEIM_PLUG_MESSAGE  ."</th>";
            $return .= "</tr>";
            $i = 2;
            foreach($items as $item) {

				if($item->toread)
					$readcell=$this->uddeicons_readpic;
				else
					$readcell=$this->uddeicons_unreadpic;

				if ($this->config->showlistattachment) {
					$sql="SELECT COUNT(id) FROM `#__uddeim_attachments` WHERE mid=".(int)$item->id;
					$_CB_database->setQuery($sql);
					$cnt = (int)$_CB_database->loadResult();
					if ($cnt)
						$readcell .= "&nbsp;<img src='".$this->pathtosite."/components/com_uddeim/templates/".$this->config->templatedir."/images/attachment.gif' alt='"._UDDEIM_ATTACHMENT."' title='"._UDDEIM_ATTACHMENT."' border='0' />";
				}
	
				$fromname = $this->_evaluateUsername($item->fromname, $item->fromid, $item->publicname);

				if($item->systemmessage)
					$fromname = $item->systemmessage;

				if ($item->cryptmode==2 || $item->cryptmode==4)
					$pms_show = uddeIMsefRelToAbs("index.php?option=com_uddeim&Itemid=".$item_id."&task=showpass&messageid=".$item->id);
				else
					$pms_show = uddeIMsefRelToAbs("index.php?option=com_uddeim&Itemid=".$item_id."&task=show&messageid=".$item->id);
                
				$cm = uddeIMgetMessage($item->message, "", $item->cryptmode, "", $this->config->cryptkey);
				$cm = stripslashes($cm);
				if($item->systemmessage || $this->config->allowbb) {					
					require_once ($this->absolute_path."/components/com_uddeim/bbparser.php");
					$cm = uddeIMbbcode_strip($cm);
				}
				$cm = htmlspecialchars($cm, ENT_QUOTES, $this->config->charset);
				$cm = str_replace("&amp;#", "&#", $cm); 

				$i = ($i==1) ? 2 : 1;
                $return .= "<tr class=\"sectiontableentry$i\"><td>".$readcell."</td>"
						. "<td>".$fromname."</td>"
                		. "<td><a href=\"".$pms_show."\">".uddeIM_utf8_substr($this->config->languagecharset, $cm, 0, $this->config->firstwordsinbox)."...</a></td>";
                $return .= "</tr>\n";
			}
            $return .= "</table></div>";

            if ($pagingEnabled && ($entriesNumber < $total)) {
                $return .= "<div style='width:95%;text-align:center;'>"
                .$this->_writePaging($pagingParams,"entries_",$entriesNumber,$total)
                ."</div>";
            }
        } else {
			$return .= "<br /><br /><div class=\"sectiontableheader\" style=\"text-align:left;width:95%;\">";
			$return .= _UDDEIM_PLUG_EMPTYINBOX;		// empty
			$return .= "</div>";
        }
		return $return;
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
