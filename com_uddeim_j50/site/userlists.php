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

function uddeIMshowLists($myself, $item_id, $limit, $limitstart, $config) {
	$pathtosite  = uddeIMgetPath('live_site');

	$my_gid = $config->usergid;

	if( $config->allowmultiplerecipients &&
	   (($config->enablelists==1) ||
	    ($config->enablelists==2 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) || 
	    ($config->enablelists==3 && (uddeIMisAdmin($my_gid)) || uddeIMisAdmin2($my_gid, $config))) 
	  ) {
		// ok contact lists are enabled
	} else {
		uddeIMprintMenu($myself, 'lists', $item_id, $config);
		echo "<div id='uddeim-m'>\n";
		echo "<div id='uddeim-overview'><p><b>"._UDDEIM_LISTSNOTENABLED."</b></p></div>\n";
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))
		$total = uddeIMgetUserlistCount($myself, true);
	else
		$total = uddeIMgetUserlistCount($myself);

	// now load messages as required
	if(!$limitstart)
		$limitstart = 0;

	if(!$limit)
		$limit=$config->perpage;

	if ($limitstart>=$total)
		$limitstart=max(0,$limitstart - $limit);

	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))
		$my_lists = uddeIMselectUserlists($myself, $limitstart, $limit, true);
	else
		$my_lists = uddeIMselectUserlists($myself, $limitstart, $limit);

	// write the uddeim menu
	uddeIMprintMenu($myself, 'lists', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");

	echo "<form method='post' name='messages' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=listsfork&Itemid=".$item_id)."'>\n";

	echo "<div id='uddeim-overview'><table cellpadding='7' width='100%'>\n";
	$delall="<input type='checkbox' name='arcmes[]' value='' onclick='wiglwogl(this);' title='"._UDDEIM_CHECKALL."' />";
	echo "<tr><th style='text-align:center;' class='sectiontableheader'>".$delall."</th><th class='sectiontableheader'>"._UDDEIM_LISTSNAME."</th><th class='sectiontableheader'>"._UDDEIM_LISTSDESC."</th>";
	echo "<th style='text-align:center;' class='sectiontableheader'>"._UDDEIM_LISTGLOBAL_ENTRIES."</th>";
	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) 		// admins can create global user lists
		echo "<th style='text-align:center;' class='sectiontableheader'>"._UDDEIM_LISTGLOBAL_TYPE."</th>";
	echo "<th class='sectiontableheader'>&nbsp;</th></tr>\n";

	$i = 1;
	// now write the list
	foreach ( $my_lists as $cl ) {
		$delcell="<input type='checkbox' name='arcmes[]' value='".$cl->id."' />";

		echo "<tr class='sectiontableentry".$i."'>";
		echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$delcell."</td>";		// checkcell
		echo "<td style='vertical-align:middle'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=editlists&listid=".$cl->id."&Itemid=".$item_id)."'>".$cl->name."</a></td>";
		echo "<td style='vertical-align:middle'>".$cl->description;
		if ($cl->userid!=$myself)
			echo "<br /><br />"._UDDEIM_LISTGLOBAL_CREATOR." ".uddeIMgetNameFromID($cl->userid, $config);
		echo "</td>";
		$temp = "0";
		if ($cl->userids)
			$temp = substr_count($cl->userids, ",")+1;
		echo "<td style='text-align:center; vertical-align:middle'>".$temp."</td>";
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) {		// admins can create global user lists
			$temp = "";
			switch($cl->global) {
				case 0: $temp = _UDDEIM_LISTGLOBAL_NORMAL; break;
				case 1: $temp = _UDDEIM_LISTGLOBAL_GLOBAL; break;
				case 2: $temp = _UDDEIM_LISTGLOBAL_RESTRICTED; break;
			}
			echo "<td style='text-align:center; vertical-align:middle'>".$temp."</td>";
		}

		if ($config->actionicons) {
			$editcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=editlists&listid=".$cl->id."&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/edit.gif' alt='"._UDDEIM_EDITLINK."' title='"._UDDEIM_EDITLINK."' /></a><br />";
			$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=deletelists&listid=".$cl->id."&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' /></a>";
		} else {
			$editcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=editlists&listid=".$cl->id."&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart)."'>"._UDDEIM_EDITLINK."</a><br />";
			$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=deletelists&listid=".$cl->id."&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart)."'>"._UDDEIM_DELETELINK."</a>";
		}

		if ($config->actionicons) {
			echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$editcell.$deletecell."</td>";
		} else {
			echo "<td class='pathway'>".$editcell.$deletecell."</td>";
		}
		echo "</tr>\n";

		$i++;
		if ($i>2) {
			$i=1;
		}
	}

	$muldel = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=deletelistsmultiple&Itemid=".$item_id."&limitstart=0&limit=".$limit);
	if($config->bottomlineicons) {
		echo "<tr><th style='text-align:center;' class='sectiontablefooter'>";
		echo '<a href="#" onclick="listsDelete(\''.$muldel.'\'); return false;"><img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/images/trash.gif" alt="'._UDDEIM_TRASHCHECKED.'" title="'._UDDEIM_TRASHCHECKED.'" /></a></th>';
        echo "<th class='sectiontablefooter'>&nbsp;</th>";
        echo "<th class='sectiontablefooter'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=createlists&Itemid=".$item_id)."'>"._UDDEIM_LISTSNEW."</a></th>";
		echo "<th class='sectiontablefooter'>&nbsp;</th>";
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) 		// admins can create global user lists
			echo "<th class='sectiontablefooter'>&nbsp;</th>";
		echo "<th class='sectiontablefooter'>&nbsp;</th></tr>\n";
	}
	echo "</table></div>\n";
	echo "</form>\n";

	// write the inbox navigation links
	$pageNav = new uddeIMmosPageNav($total, $limitstart, $limit);
	$referlink = "index.php?option=com_uddeim&task=showlists&Itemid=".$item_id;
	if ($total>$limit) {
		$shownav = $pageNav->writePagesLinks($referlink);
		$shownav = uddeIMarrowReplace($shownav, $config->templatedir);
		echo "<div id='uddeim-pagenav'>".$shownav."<br />";
		echo "<a class='btn btn-sm btn-info' href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showlists&Itemid=".$item_id."&limitstart=0&limit=".$total)."'>"._UDDEIM_SHOWALL."</a>";
		echo "</div>\n";
	}

	echo "<div id='uddeim-bottomlines'>";
	if(!$config->bottomlineicons) {
		echo '<p><a href="#" onclick="listsDelete(\''.$muldel.'\'); return false;">'._UDDEIM_TRASHCHECKED.'</a></p>';
		echo "<p><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=createlists&Itemid=".$item_id)."'>"._UDDEIM_LISTSNEW."</a></p>";
	}
	echo "</div>\n";

	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', "", $config)."</div>\n";
}   

function uddeIMcreateLists($myself, $item_id, $listid, $limit, $limitstart, $config) {
	$pathtosite  = uddeIMgetPath('live_site');

	$my_gid = $config->usergid;

	// write the uddeim menu
	uddeIMprintMenu($myself, 'none', $item_id, $config);
	echo "<div id='uddeim-m'>\n";
	echo "<div id='uddeim-writeform' class='user-list'>\n";

	uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");

	$lname = "";
	$ldesc = "";
	$lids = "";
	$lglobal = 0;
	if ( $listid ) {
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) 		// admins can create global user lists
			$this_lists = uddeIMselectUserlistsListFromID($myself, $listid, true);
		else
			$this_lists = uddeIMselectUserlistsListFromID($myself, $listid);
		foreach($this_lists as $this_list) {
			$lname = $this_list->name;
			$ldesc = $this_list->description;
			$lids = trim($this_list->userids);
			$lglobal = $this_list->global;
		}
	}
//	$total = count(explode(",",$lids));
	$total = 0;
	if ($lids)
		$total = substr_count($lids, ",")+1;
	if ($total>=$config->maxonlists) {
		echo "<div id='uddeim-toplines'><p>"._UDDEIM_LISTSLIMIT_1." ".$config->maxonlists.").</p></div>\n";
	}

	echo "<br />";
	echo "<form name='listsform' method='post' action='".uddeIMsefRelToAbs( "index.php?option=com_uddeim&listid=".$listid."&Itemid=".$item_id."&task=savelists" )."'>";
	echo _UDDEIM_LISTSNAMEWO."<br />";
	echo "<input type='text' name='listname' size='20' maxlength='40' value='".$lname."' /><br />";
	echo _UDDEIM_LISTSDESC."<br />";
	echo "<textarea name='listdesc' rows='5' cols='40'>".$ldesc."</textarea><br />";

	$global_checkstatus='';
	if ($lglobal)
		$global_checkstatus='checked="checked"';

	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))	{		// admins can create global user lists
		echo '<input type="radio" '.($lglobal==0 ? 'checked="checked"' : '' ).' name="listglobal" value="0" />'._UDDEIM_LISTGLOBAL_P0.'<br />';
		echo '<input type="radio" '.($lglobal==1 ? 'checked="checked"' : '' ).' name="listglobal" value="1" />'._UDDEIM_LISTGLOBAL_P1.'<br />';
		echo '<input type="radio" '.($lglobal==2 ? 'checked="checked"' : '' ).' name="listglobal" value="2" />'._UDDEIM_LISTGLOBAL_P2.'<br />';
	}

	echo "<input type='hidden' name='listids' size='40' value='".$lids."' />";
	echo "<br />";
	echo "<table border='0' cellspacing='10' cellpadding='0'><tr><td valign='top' nowrap='nowrap'>";
	echo uddeIMselectComboSelectionlist( $myself, $my_gid, $lids, $config );
	echo "</td><td valign='middle' style='padding:0 8px;'>";
	echo "<input type='button' name='buttonadd' class='btn btn-sm btn-outline-primary' value='&nbsp;&laquo;&nbsp;' onclick='uddeIMaddToSelection( \"listsform\", \"userlist\", \"selectionlist\", ".$config->maxonlists." );' /><br />";
	echo "<input type='button' name='buttonadd' class='btn btn-sm btn-outline-danger' value='&nbsp;&raquo;&nbsp;' onclick='uddeIMremoveFromSelection( \"listsform\", \"selectionlist\", \"userlist\", ".$config->maxonlists." );' />";
	echo "</td><td valign='top'>";
	echo uddeIMselectComboUserlist( $myself, $my_gid, $lids, $config );
	echo "</td></tr></table>";
	echo "<br />";
	echo "<input type='submit' name='reply' class='button btn btn-sm btn-primary' value='"._UDDEIM_SAVE."' />";
	echo "<br /><br />";
	echo "</form>";

	$temp = _UDDEIM_LISTSLIMIT_2." ".$config->maxonlists;
	echo "</div>\n";
	echo "</div>\n";
	echo "<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', $temp, $config)."</div>\n";
}

function uddeIMsaveLists($myself, $item_id, $listid, $listname, $listdesc, $listids, $listglobal, $config) {
	$database = uddeIMgetDatabase();

	$my_gid = $config->usergid;
	if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config))			// when not an admin, than user can not create global user lists
		$listglobal = 0;

//	$listname=addslashes(strip_tags($listname));
	$listname=stripslashes(strip_tags($listname));	// strip tags and slashes
	$listname=str_replace(" ", "", $listname);		// remove all spaces
//	$listname=ereg_replace("[^[:alnum:]_\-]","",$listname);	// remove non.alphanumerics
	$listname=preg_replace("/[^[:alnum:]_\-]/","",$listname);	// remove non.alphanumerics
	if (!$listname)
		$listname = "untitled";
	$i=0;
	$suffix="";
	do {
		$exists = uddeIMexistsUserlistName($myself, $listid, $listname.$suffix, true);
		if ($exists) {
			$i++;
			$suffix="_".$i;
		}
	} while($exists);
	$listname=$listname.$suffix;
	$listdesc=addslashes(strip_tags($listdesc));
	$listids =addslashes(strip_tags($listids));

	$cnt = 0;
	$ar_ids = explode(",",$listids);
	$ar_ids2 = Array();
	foreach ($ar_ids as $key => $value) {
		$cnt++;
		if ($cnt > $config->maxonlists)
			break;
		$ar_ids2[$key] = (int)$value;
	}

	// remove items that are not friends anymore
	if (($config->restrictcon==1 && uddeIMisReggedOnly($my_gid)) ||
		($config->restrictcon==2 && uddeIMisAllNotAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) ||
		($config->restrictcon==3) ) {

		if ($lids)
			$temp = "u.id NOT IN (".uddeIMquoteSmart($lids).") AND ";
		$somanyfriends = 0;
		if (uddeIMcheckCB()) {
			$users = uddeIMselectCBbuddies($myself, $config, $temp);
			$somanyfriends = count($users);
		}

		if (!$somanyfriends) { // no friends found, maybe there are some in CBE?
			if (uddeIMcheckCBE()) {
				$users = uddeIMselectCBEbuddies($myself, $config, $temp);
				$somanyfriends = count($users);
			}
			if (uddeIMcheckCBE2()) {
				$users = uddeIMselectCBE2buddies($myself, $config, $temp);
				$somanyfriends = count($users);
			}
		}

		if (!$somanyfriends) { // no friends found, maybe there are some in JS?
			if (uddeIMcheckJS()) {
				$users = uddeIMselectJSbuddies($myself, $config, $temp);
				$somanyfriends = count($users);
			}
		}

		// remove non friends from save list
		if ($config->restrictrem) {
			foreach ( $ar_ids2 as $key=>$value ) {
				$found = false;
				foreach ( $users as $key2=>$value2 ) {
					if ( $value2->id==$value ) {
						$found = true;
						break;
					}
				}
				if (!$found)
					unset($ar_ids2[$key]);
			}
		}
	}

	$listids = implode(",",$ar_ids2);
	if ($listid) {
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))			// when not an admin, than user can not create global user lists
			uddeIMupdateUserlist($myself, $listid, $listname, $listdesc, $listids, $listglobal, true);
		else
			uddeIMupdateUserlist($myself, $listid, $listname, $listdesc, $listids, $listglobal);
		uddeJSEFredirect("index.php?option=com_uddeim&task=showlists&Itemid=".$item_id, _UDDEIM_LISTSUPDATED);
	} else {
		uddeIMinsertUserlist($myself, $listname, $listdesc, $listids, $listglobal);
		uddeJSEFredirect("index.php?option=com_uddeim&task=showlists&Itemid=".$item_id, _UDDEIM_LISTSSAVED);
	}
}

function uddeIMselectComboSelectionlist( $myself, $my_gid, $lids, $config ) {
	$database = uddeIMgetDatabase();

	$temp = "AND id IN (-1) ";
	if ($lids)
		$temp = "AND id IN (".$lids.") ";

	$ret = '<select multiple="multiple" name="selectionlist" class="inputbox form-select" style="background-color:floralwhite;min-width:10em" ondblclick="selectionlistdblclick(this.selectedIndex, \'listsform\', \'selectionlist\', \'userlist\', '.$config->maxonlists.')" size="10">';	
	$database->setQuery( "SELECT id,name,username FROM `#__users` WHERE block=0 ".$temp."ORDER BY ".($config->realnames ? "name" : "username") );
	$users = $database->loadObjectList(); 
	if ( count( $users ) )  {
		foreach ( $users as $user ) {
			// if ( $user->id<>$myself )
			$ret .= '<option value="'.$user->id.'">'.($config->realnames ? $user->name : $user->username).'</option>';
		}
	}
	$ret .= '</select>';
	return $ret;
}

function uddeIMselectComboUserlist( $myself, $my_gid, $lids, $config ) {
	$database = uddeIMgetDatabase();
	$users = Array();
	
	getAdditonalGroups($add_special, $add_admin, $config);

	$ret = '<select multiple="multiple" name="userlist" class="inputbox form-select" ondblclick="userlistdblclick(this.selectedIndex, \'listsform\', \'userlist\', \'selectionlist\', '.$config->maxonlists.')" size="10">';

	if (($config->restrictcon==1 && uddeIMisReggedOnly($my_gid)) ||
		($config->restrictcon==2 && uddeIMisAllNotAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) ||
		($config->restrictcon==3) ) {

		if ($lids)
			$temp = "u.id NOT IN (".uddeIMquoteSmart($lids).") AND ";
		$somanyfriends = 0;
		if (uddeIMcheckCB()) {
			$users = uddeIMselectCBbuddies($myself, $config, $temp);
			$somanyfriends = count($users);
		}

		if (!$somanyfriends) { // no friends found, maybe there are some in CBE?
			if (uddeIMcheckCBE()) {
				$users = uddeIMselectCBEbuddies($myself, $config, $temp);
				$somanyfriends = count($users);
			}
			if (uddeIMcheckCBE2()) {
				$users = uddeIMselectCBE2buddies($myself, $config, $temp);
				$somanyfriends = count($users);
			}
		}

		if (!$somanyfriends) { // no friends found, maybe there are some in JS?
			if (uddeIMcheckJS()) {
				$users = uddeIMselectJSbuddies($myself, $config, $temp);
				$somanyfriends = count($users);
			}
		}

	} else {


		if (uddeIMcheckJversion()>=2) {		// J1.6
			$temp = "";
			if ($lids)
				$temp = "AND u.id NOT IN (".uddeIMquoteSmart($lids).") ";
			switch ($config->hideallusers) {
				case 3:		// special users
					$sql="SELECT DISTINCT u.id,u.".($config->realnames ? "name" : "username")." AS displayname FROM (#__users AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
								INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
								WHERE u.block=0 ".$temp."AND g.id NOT IN (3,4,5,6,7,8".$add_admin.$add_special.") ORDER BY u.".($config->realnames ? "name" : "username");
					break;
				case 2:		// admins
					$sql="SELECT DISTINCT u.id,u.".($config->realnames ? "name" : "username")." AS displayname FROM (#__users AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
								INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
								WHERE u.block=0 ".$temp."AND g.id NOT IN (7,8".$add_admin.") ORDER BY u.".($config->realnames ? "name" : "username");
					break;
				case 1:		// superadmins
					$sql="SELECT DISTINCT u.id,u.".($config->realnames ? "name" : "username")." AS displayname FROM (#__users AS u INNER JOIN `#__user_usergroup_map` AS um ON u.id=um.user_id) 
								INNER JOIN `#__usergroups` AS g ON um.group_id=g.id 
								WHERE u.block=0 ".$temp."AND g.id NOT IN (8) ORDER BY u.".($config->realnames ? "name" : "username");
					break;
				default:	// none
					$sql="SELECT u.id,u.".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` AS u WHERE u.block=0 ".$temp."ORDER BY u.".($config->realnames ? "name" : "username");
					break;
			}
			if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))		// do not hide users when it is an admin
				$sql="SELECT u.id,u.".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` AS u WHERE u.block=0 ".$temp."ORDER BY u.".($config->realnames ? "name" : "username");
		} else {
			$temp = "";
			if ($lids)
				$temp = "AND id NOT IN (".uddeIMquoteSmart($lids).") ";
			switch ($config->hideallusers) {
				case 3:		// special users
					$sql="SELECT id,".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` WHERE block=0 ".$temp."AND gid NOT IN (19,20,21,23,24,25".$add_admin.$add_special.") ORDER BY ".($config->realnames ? "name" : "username");
					break;
				case 2:		// admins
					$sql="SELECT id,".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` WHERE block=0 ".$temp."AND gid NOT IN (24,25".$add_admin.") ORDER BY ".($config->realnames ? "name" : "username");
					break;
				case 1:		// superadmins
					$sql="SELECT id,".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` WHERE block=0 ".$temp."AND gid NOT IN (25) ORDER BY ".($config->realnames ? "name" : "username");
					break;
				default:	// none
					$sql="SELECT id,".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` WHERE block=0 ".$temp."ORDER BY ".($config->realnames ? "name" : "username");
					break;
			}
			if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))		// do not hide users when it is an admin
				$sql="SELECT id,".($config->realnames ? "name" : "username")." AS displayname FROM `#__users` WHERE block=0 ".$temp."ORDER BY ".($config->realnames ? "name" : "username");
		}
		$database->setQuery( $sql );
		$users = $database->loadObjectList(); 
		if (!$users)
			$users = Array();
	}

	if ( count( $users ) )  {
		foreach ( $users as $user )
			$ret .= '<option value="'.$user->id.'">'.$user->displayname.'</option>';
	}
	$ret .= '</select>';
	return $ret;
}

function uddeIMdeleteLists($myself, $item_id, $listid, $limit, $limitstart, $config) {
	$my_gid = $config->usergid;
	$lg = 0;
	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))
		$lg = true;

	uddeIMpurgeUserlist($myself, $listid, $lg);
	uddeJSEFredirect("index.php?option=com_uddeim&task=showlists&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
}

function uddeIMdeleteListsMultiple($myself, $item_id, $arcmes, $limit, $limitstart, $config) {
	$my_gid = $config->usergid;
	$lg = 0;
	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))
		$lg = true;

	$n = count($arcmes);
	if (!$n) {
		echo _UDDEIM_NOLISTSELECTED."<br /><a href='javascript:history.go(-1)'>"._UDDEIM_BACK."</a>";
		return;
	}
	for ($i = 0; $i <= ($n-1); $i++) {
		if ($arcmes[$i]>0) {
			uddeIMpurgeUserlist($myself, $arcmes[$i], $lg);
		}
	}
	uddeJSEFredirect("index.php?option=com_uddeim&task=showlists&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
}
