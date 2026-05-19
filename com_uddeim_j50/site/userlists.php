<?php
// ********************************************************************************************
// @title         udde Instant Messages (uddeIM)
// @description   Instant Messages System for Joomla 6
// @author        Stephan Slabihoud, Benjamin Zweifel
// @copyright     © 2007-2024 Stephan Slabihoud, © 2024 v5 joomod.de, © 2006 Benjamin Zweifel
// @license       GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
// ********************************************************************************************

defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );

function uddeIMshowLists($myself, $item_id, $limit, $limitstart, $config) {
	$pathtosite  = uddeIMgetPath('live_site');
	$my_gid = $config->usergid;

	if ($config->allowmultiplerecipients &&
	   (($config->enablelists==1) ||
	    ($config->enablelists==2 && (uddeIMisSpecial($my_gid) || uddeIMisSpecial2($my_gid, $config))) || 
	    ($config->enablelists==3 && (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)))) 
	  ) {
		// ok contact lists are enabled
	} else {
		uddeIMprintMenu($myself, 'lists', $item_id, $config);
		echo "<div id='uddeim-m'>\n";
		echo "<div id='uddeim-overview'><p><b>"._UDDEIM_LISTSNOTENABLED."</b></p></div>\n";
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) {
		$total = uddeIMgetUserlistCount($myself, true);
	} else {
		$total = uddeIMgetUserlistCount($myself);
	}

	if (!$limitstart) { $limitstart = 0; }
	if (!$limit) { $limit=$config->perpage; }
	if ($limitstart>=$total) { $limitstart=max(0,$limitstart - $limit); }

	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) {
		$my_lists = uddeIMselectUserlists($myself, $limitstart, $limit, true);
	} else {
		$my_lists = uddeIMselectUserlists($myself, $limitstart, $limit);
	}

	uddeIMprintMenu($myself, 'lists', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");

	echo "<form method='post' name='messages' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=listsfork&Itemid=".$item_id)."'>\n";
	echo "<div id='uddeim-overview'><table cellpadding='7' width='100%'>\n";
	$delall="<input type='checkbox' name='arcmes[]' value='' onclick='wiglwogl(this);' title='"._UDDEIM_CHECKALL."' />";
	echo "<tr><th style='text-align:center;' class='sectiontableheader'>".$delall."</th><th class='sectiontableheader'>"._UDDEIM_LISTSNAME."</th><th class='sectiontableheader'>"._UDDEIM_LISTSDESC."</th>";
	echo "<th style='text-align:center;' class='sectiontableheader'>"._UDDEIM_LISTGLOBAL_ENTRIES."</th>";
	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) {
		echo "<th style='text-align:center;' class='sectiontableheader'>"._UDDEIM_LISTGLOBAL_TYPE."</th>";
	}
	echo "<th class='sectiontableheader'>&nbsp;</th></tr>\n";

	$i = 1;
	foreach ( $my_lists as $cl ) {
		$delcell="<input type='checkbox' name='arcmes[]' value='".$cl->id."' />";
		echo "<tr class='sectiontableentry".$i."'>";
		echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$delcell."</td>";
		echo "<td style='vertical-align:middle'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=editlists&listid=".$cl->id."&Itemid=".$item_id)."'>".$cl->name."</a></td>";
		echo "<td style='vertical-align:middle'>".htmlspecialchars($cl->description, ENT_QUOTES, 'UTF-8');
		if ($cl->userid!=$myself) {
			echo "<br /><br />"._UDDEIM_LISTGLOBAL_CREATOR." ".htmlspecialchars(uddeIMgetNameFromID($cl->userid, $config), ENT_QUOTES, 'UTF-8');
		}
		echo "</td>";
		$temp = "0";
		if ($cl->userids) {
			$temp = substr_count($cl->userids, ",")+1;
		}
		echo "<td style='text-align:center; vertical-align:middle'>".$temp."</td>";
		
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) {
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
		if ($i>2) { $i=1; }
	}

	$muldel = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=deletelistsmultiple&Itemid=".$item_id."&limitstart=0&limit=".$limit);
	if($config->bottomlineicons) {
		echo "<tr><th style='text-align:center;' class='sectiontablefooter'>";
		echo '<a href="#" onclick="listsDelete(\''.$muldel.'\'); return false;"><img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/images/trash.gif" alt="'._UDDEIM_TRASHCHECKED.'" title="'._UDDEIM_TRASHCHECKED.'" /></a></th>';
        echo "<th class='sectiontablefooter'>&nbsp;</th>";
        echo "<th class='sectiontablefooter'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=createlists&Itemid=".$item_id)."'>"._UDDEIM_LISTSNEW."</a></th>";
		echo "<th class='sectiontablefooter'>&nbsp;</th>";
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) {
			echo "<th class='sectiontablefooter'>&nbsp;</th>";
		}
		echo "<th class='sectiontablefooter'>&nbsp;</th></tr>\n";
	}
	echo "</table></div>\n";
	echo "</form>\n";

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

	uddeIMprintMenu($myself, 'none', $item_id, $config);
	echo "<div id='uddeim-m'>\n";
	echo "<div id='uddeim-writeform' class='user-list'>\n";

	uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");

	?>
	<script>
	// Bulletproof presave function: Manually constructs the comma separated ID string
	// from whatever is in the right box, ensuring nothing gets lost regardless of PHP array bugs.
	function uddeIMpresaveList(formName) {
		var rightBox = document.getElementById('userlist');
		var hiddenField = document.getElementById('listids');
		if (rightBox && hiddenField) {
			var ids = [];
			for (var i = 0; i < rightBox.options.length; i++) {
				ids.push(rightBox.options[i].value);
			}
			hiddenField.value = ids.join(',');
		}
		return true;
	}
	</script>
	<?php

	$lname = ""; $ldesc = ""; $lids = ""; $lglobal = 0;
	if ($listid) {
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) {
			$this_lists = uddeIMselectUserlistsListFromID($myself, $listid, true);
		} else {
			$this_lists = uddeIMselectUserlistsListFromID($myself, $listid);
		}
		
		if (!empty($this_lists)) {
			$current_list = is_array($this_lists) ? reset($this_lists) : $this_lists;
			if (is_object($current_list)) {
				$lname = isset($current_list->name) ? $current_list->name : "";
				$ldesc = isset($current_list->description) ? $current_list->description : "";
				$lids = isset($current_list->userids) ? trim($current_list->userids) : "";
				$lglobal = isset($current_list->global) ? $current_list->global : 0;
			}
		}
	}

	$total = 0;
	if ($lids) { $total = substr_count($lids, ",")+1; }
	if ($total>=$config->maxonlists) {
		echo "<div id='uddeim-toplines'><p>"._UDDEIM_LISTSLIMIT_1." ".$config->maxonlists.").</p></div>\n";
	}

	echo "<br />";
	echo "<form name='listsform' id='listsform' method='post' action='".uddeIMsefRelToAbs( "index.php?option=com_uddeim&listid=".$listid."&Itemid=".$item_id."&task=savelists" )."' onsubmit='return uddeIMpresaveList(\"listsform\");'>";
	echo _UDDEIM_LISTSNAMEWO."<br />";
	echo "<input type='text' name='listname' size='20' maxlength='40' value='".htmlspecialchars($lname, ENT_QUOTES, 'UTF-8')."' /><br />";
	echo _UDDEIM_LISTSDESC."<br />";
	echo "<textarea name='listdesc' rows='5' cols='40'>".htmlspecialchars($ldesc, ENT_QUOTES, 'UTF-8')."</textarea><br />";

	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))	{
		echo '<input type="radio" '.($lglobal==0 ? 'checked="checked"' : '' ).' name="listglobal" value="0" />'._UDDEIM_LISTGLOBAL_P0.'<br />';
		echo '<input type="radio" '.($lglobal==1 ? 'checked="checked"' : '' ).' name="listglobal" value="1" />'._UDDEIM_LISTGLOBAL_P1.'<br />';
		echo '<input type="radio" '.($lglobal==2 ? 'checked="checked"' : '' ).' name="listglobal" value="2" />'._UDDEIM_LISTGLOBAL_P2.'<br />';
	}

	echo "<input type='hidden' name='listids' id='listids' value='".htmlspecialchars($lids, ENT_QUOTES, 'UTF-8')."' />";
	if (class_exists('\\Joomla\\CMS\\HTML\\HTMLHelper')) {
		echo \Joomla\CMS\HTML\HTMLHelper::_('form.token');
	}
	echo "<br />";
	echo "<table border='0' cellspacing='10' cellpadding='0'><tr><td valign='top' nowrap='nowrap'>";
	
	// Left box 
	echo uddeIMselectComboSelectionlist( $myself, $my_gid, $lids, $config );
	
	echo "</td><td valign='middle' style='padding:0 8px;'>";
	// The buttons
	echo "<input type='button' name='buttonadd' class='btn btn-sm btn-outline-primary' value='&nbsp;&raquo;&nbsp;' onclick='uddeIMaddToSelection( \"listsform\", \"selectionlist\", \"userlist\", ".$config->maxonlists." );' /><br />";
	echo "<input type='button' name='buttonadd' class='btn btn-sm btn-outline-danger' value='&nbsp;&laquo;&nbsp;' onclick='uddeIMremoveFromSelection( \"listsform\", \"userlist\", \"selectionlist\", ".$config->maxonlists." );' />";
	echo "</td><td valign='top'>";
	
	// Right box 
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
	if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
		$listglobal = 0;
	}

	$listname=stripslashes(strip_tags($listname));
	$listname=str_replace(" ", "", $listname);
	$listname=preg_replace("/[^[:alnum:]_\-]/","",$listname);
	if (!$listname) { $listname = "untitled"; }
	
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
	$listdesc=$database->escape(strip_tags($listdesc));

	// Always default to our manually populated hidden field!
	$listids = isset($_POST['listids']) ? $_POST['listids'] : '';

	$raw = ($listids !== '') ? explode(',', $listids) : [];
	$ar_ids2 = [];
	$cnt = 0;
	
	foreach ($raw as $value) {
		$id = (int)$value;
		if ($id <= 0) continue;
		$cnt++;
		if ($cnt > $config->maxonlists) break;
		$ar_ids2[] = $id;
	}

	if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config) &&
		(($config->restrictcon==1 && uddeIMisReggedOnly($my_gid)) ||
		($config->restrictcon==2 && uddeIMisAllNotAdmin($my_gid)) ||
		($config->restrictcon==3)) ) {

		$temp = "";
		if (!empty($ar_ids2)) {
			// FIXED: Use IN logic here to verify only the users that are actually on the list
			$temp = "u.id IN (" . implode(',', $ar_ids2) . ") AND ";
		}
			
		$somanyfriends = 0;
		$users = [];
		
		if (uddeIMcheckCB()) { $users = uddeIMselectCBbuddies($myself, $config, $temp); $somanyfriends = count($users); }
		if (!$somanyfriends) {
			if (uddeIMcheckCBE()) { $users = uddeIMselectCBEbuddies($myself, $config, $temp); $somanyfriends = count($users); }
			if (uddeIMcheckCBE2()) { $users = uddeIMselectCBE2buddies($myself, $config, $temp); $somanyfriends = count($users); }
		}
		if (!$somanyfriends) {
			if (uddeIMcheckJS()) { $users = uddeIMselectJSbuddies($myself, $config, $temp); $somanyfriends = count($users); }
		}

		if ($config->restrictrem) {
			foreach ($ar_ids2 as $key => $value) {
				$found = false;
				foreach ($users as $key2 => $value2) {
					if ($value2->id == $value) { $found = true; break; }
				}
				if (!$found) { unset($ar_ids2[$key]); }
			}
		}
	}

	$listids = implode(",",$ar_ids2);
	
	if ($listid) {
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))	{
			uddeIMupdateUserlist($myself, $listid, $listname, $listdesc, $listids, $listglobal, true);
		} else {
			uddeIMupdateUserlist($myself, $listid, $listname, $listdesc, $listids, $listglobal);
		}
		uddeJSEFredirect("index.php?option=com_uddeim&task=showlists&Itemid=".$item_id, _UDDEIM_LISTSUPDATED);
	} else {
		uddeIMinsertUserlist($myself, $listname, $listdesc, $listids, $listglobal);
		uddeJSEFredirect("index.php?option=com_uddeim&task=showlists&Itemid=".$item_id, _UDDEIM_LISTSSAVED);
	}
}

// THE LEFT BOX: Available Users (The Pool)
function uddeIMselectComboSelectionlist($myself, $my_gid, $lids, $config) {

    $database = uddeIMgetDatabase();

    $ret = '<select multiple="multiple"
        id="selectionlist"
        name="selectionlist[]"
        class="inputbox form-select"
        style="background-color:floralwhite;min-width:10em"
        ondblclick="moveSelectedOptions(\'selectionlist\', \'userlist\')"
        size="10">';

    // FIX: Left box shows users NOT in the list (the available pool)
    if (!empty($lids)) {
        $query = "
            SELECT id, name, username
            FROM #__users
            WHERE block = 0
            AND id NOT IN (" . $lids . ")
            ORDER BY " . ($config->realnames ? "name" : "username");
    } else {
        $query = "
            SELECT id, name, username
            FROM #__users
            WHERE block = 0
            ORDER BY " . ($config->realnames ? "name" : "username");
    }

    $database->setQuery($query);

    $users = $database->loadObjectList();

    if ($users) {
        foreach ($users as $user) {

            $display = $config->realnames
                ? $user->name
                : $user->username;

            $ret .= '<option value="' . (int)$user->id . '">'
                 . htmlspecialchars($display)
                 . '</option>';
        }
    }

    $ret .= '</select>';

    return $ret;
}

// THE RIGHT BOX: Users already in the list
function uddeIMselectComboUserlist($myself, $my_gid, $lids, $config) {

    $database = uddeIMgetDatabase();

    $where = "";

    // FIX: Right box shows only users IN the list (the selected side)
    if (!empty($lids)) {
        $where = "AND id IN (" . $lids . ")";
    }

    $query = "
        SELECT id,
        " . ($config->realnames ? "name" : "username") . " AS displayname
        FROM #__users
        WHERE block = 0
        $where
        ORDER BY displayname";

    $database->setQuery($query);

    $users = $database->loadObjectList();

    $ret = '<select multiple="multiple"
        id="userlist"
        name="userlist[]"
        class="inputbox form-select"
        ondblclick="moveSelectedOptions(\'userlist\', \'selectionlist\')"
        size="10">';

    if ($users) {

        foreach ($users as $user) {

            $ret .= '<option value="' . (int)$user->id . '">'
                 . htmlspecialchars($user->displayname)
                 . '</option>';
        }
    }

    $ret .= '</select>';

    return $ret;
}

function uddeIMdeleteLists($myself, $item_id, $listid, $limit, $limitstart, $config) {
	$my_gid = $config->usergid;
	$lg = 0;
	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) { $lg = true; }
	uddeIMpurgeUserlist($myself, $listid, $lg);
	uddeJSEFredirect("index.php?option=com_uddeim&task=showlists&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
}

function uddeIMdeleteListsMultiple($myself, $item_id, $arcmes, $limit, $limitstart, $config) {
	$my_gid = $config->usergid;
	$lg = 0;
	if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config)) { $lg = true; }

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
