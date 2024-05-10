<?php
// ********************************************************************************************
// @title         udde Instant Messages (uddeIM)
// @description   Instant Messages System for Joomla 5, admin user settings
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

function uddeIMshowUsersettings($option, $task, $act, $config) {
	$database = uddeIMgetDatabase();
	$emnid = intval( uddeIMmosGetParam( $_POST, 'id', '' ) );

	switch($act) {
	//	case "autor":	uddeIMchangeAutor($option, $task, $emnid, $config);		break;
		case "popup":		uddeIMchangePopup($option, $task, $emnid, $config);		break;
		case "public":		uddeIMchangePublic($option, $task, $emnid, $config);	break;
		case "status":		uddeIMchangeStatus($option, $task, $emnid, $config);	break;
		case "locked":		uddeIMchangeLocked($option, $task, $emnid, $config);	break;
		case "moderated":	uddeIMchangeModerated($option, $task, $emnid, $config);	break;
	}

	// get parameter from filter
	$f_param = array();
	$f_where = array();

	$f_param[0] = uddeIMmosGetParam($_POST, 'f_username', '');
	if($f_param[0]!="") $f_where[] = "b.username LIKE '$f_param[0]%'";

	$f_param[1] = uddeIMmosGetParam($_POST, 'f_name', '');
	if($f_param[1]!="") $f_where[] = "b.name LIKE '$f_param[1]%'";

	$f_param[2] = uddeIMmosGetParam($_POST, 'f_status', '');
	if($f_param[2]!="") $f_where[] = "a.status='$f_param[2]'";

	$f_param[3] = uddeIMmosGetParam($_POST, 'f_popup', '');
	if($f_param[3]!="") $f_where[] = "a.popup='$f_param[3]'";

	$f_param[4] = uddeIMmosGetParam($_POST, 'f_public', '');
	if($f_param[4]!="") $f_where[] = "a.public='$f_param[4]'";

	$f_param[5] = uddeIMmosGetParam($_POST, 'f_id', '');
	if($f_param[5]!="") $f_where[] = "a.id IS $f_param[5]";

	$f_param[6] = uddeIMmosGetParam($_POST, 'f_autor', '');
	if($f_param[6]!="") $f_where[] = "a.autoresponder='$f_param[6]'";

	$f_param[7] = uddeIMmosGetParam($_POST, 'f_autof', '');
	if($f_param[7]!="") $f_where[] = "a.autoforward='$f_param[7]'";

	$f_param[8] = uddeIMmosGetParam($_POST, 'f_locked', '');
	if($f_param[8]!="") $f_where[] = "a.locked='$f_param[8]'";

	$f_param[9] = uddeIMmosGetParam($_POST, 'f_moderated', '');
	if($f_param[9]!="") $f_where[] = "a.moderated='$f_param[9]'";

	$limit      = intval( uddeIMmosGetParam( $_POST, 'limit', 10 ) );
	$limitstart = intval( uddeIMmosGetParam( $_POST, 'limitstart', 0 ) );
	$where = count($f_where) ? " WHERE " . implode(' AND ', $f_where) : "";

	$sql="SELECT count(b.id) FROM `#__uddeim_emn` AS a RIGHT JOIN `#__users` AS b ON a.userid=b.id".$where;
	$database->setQuery($sql);
	$total = (int)$database->loadResult();
	if ($limit==0) {
		$limit = $total;
		$limitstart = 0;
	}
	if ($limitstart>=$total)
		$limitstart = 0;


	$sql  = "SELECT a.*,b.id AS uid,b.name,b.username,b.block ";
	$sql .= "FROM `#__uddeim_emn` AS a RIGHT JOIN `#__users` AS b ON a.userid=b.id";
	$sql .= $where;
	$sql .= " ORDER BY name LIMIT $limitstart,$limit";
	$database->setQuery($sql);
	$rows = $database->loadObjectList();

	$pageNav = new uddeIMmosPageNav( $total, $limitstart, $limit  );

	$sql="SELECT username,name FROM `#__users` WHERE block!='1' ORDER BY username";
	$database->setQuery($sql);
	$results = $database->loadObjectList();

	$results = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	
	$the_username='<select id="f_username" class="text" name="f_username" size="1"><option value=""';
	if ($f_param[0]=="") $the_username.=' selected';
	$the_username.='>'._UDDEADM_USERSET_SELUSERNAME.'</option>';
	foreach($results as $result) {
		$the_username.='<option value="'.$result.'"';
		if ($result==$f_param[0]) $the_username.=' selected';
		$the_username.='>'.$result.'...</option>';
	}
	$the_username.="</select>";

	$the_name='<select id="f_name" class="text" name="f_name" size="1"><option value=""';
	if ($f_param[1]=="") $the_name.=' selected';
	$the_name.='>'._UDDEADM_USERSET_SELNAME.'</option>';
	foreach($results as $result) {
		$the_name.='<option value="'.$result.'"';
		if ($result==$f_param[1]) $the_name.=' selected';
		$the_name.='>'.$result.'...</option>';
	}
	$the_name.="</select>";

    ?>
    <form action="<?php echo uddeIMredirectIndex(); ?>" method="post" name="adminForm" id='adminForm'>

	<div align="center">
    <table cellpadding="4" cellspacing="0" border="0" width="98%">
	<tr>
		<td class="sectionname" align="left">
			<h4><?php echo _UDDEADM_USERSET_EDITSETTINGS; ?></h4>
		</td>
		<td class="sectionname" align="right">
			<img align="middle" style="display: inline; border:1px solid lightgray;" src="<?php echo uddeIMgetPath('live_site')."/components/com_uddeim/templates/images/uddeim_logo.png"; ?>" />
		</td>
	</tr>
	</table>
	</div>

	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<td nowrap="nowrap" width="100%" align="left"><?php echo $pageNav->writeLimitBox('?option=$option&task=$task'); ?></td>
		<td>
<?php
	$id_items_arr[] = mosHTML::makeOption('', _UDDEADM_USERSET_SELENTRY);
	$id_items_arr[] = mosHTML::makeOption('NOT NULL', _UDDEADM_USERSET_EXISTING);
	$id_items_arr[] = mosHTML::makeOption('NULL', _UDDEADM_USERSET_NONEXISTING);
	echo mosHTML::selectList($id_items_arr, 'f_id', 'size="1" class="text"', 'value', 'text', $f_param[5]);
?>
		</td>
		<td><?php echo $the_username; ?></td>
		<td><?php echo $the_name; ?></td>
		<td>
<?php
	$status_arr[] = mosHTML::makeOption('', _UDDEADM_USERSET_SELNOTIFICATION);
	$status_arr[] = mosHTML::makeOption('0', _UDDEADM_USERSET_NONOTIFICATION);
	$status_arr[] = mosHTML::makeOption('1', _UDDEADM_USERSET_ALWAYS);
	$status_arr[] = mosHTML::makeOption('2', _UDDEADM_USERSET_WHENOFFLINE);
	$status_arr[] = mosHTML::makeOption('10', _UDDEADM_USERSET_ALWAYSEXCEPT);
	$status_arr[] = mosHTML::makeOption('20', _UDDEADM_USERSET_WHENOFFLINEEXCEPT);
	echo mosHTML::selectList($status_arr, 'f_status', 'size="1" class="text"', 'value', 'text', $f_param[2]);
?>
		</td>
		<td>
<?php
	$popup_items_arr[] = mosHTML::makeOption('', _UDDEADM_USERSET_SELPOPUP);
	$popup_items_arr[] = mosHTML::makeOption('0', _UDDEADM_USERSET_NO);
	$popup_items_arr[] = mosHTML::makeOption('1', _UDDEADM_USERSET_YES);
	echo mosHTML::selectList($popup_items_arr, 'f_popup', 'size="1" class="text"', 'value', 'text', $f_param[3]);
?>
		</td>
		<td>
<?php
	$public_items_arr[] = mosHTML::makeOption('', _UDDEADM_USERSET_SELPUBLIC);
	$public_items_arr[] = mosHTML::makeOption('0', _UDDEADM_USERSET_NO);
	$public_items_arr[] = mosHTML::makeOption('1', _UDDEADM_USERSET_YES);
	echo mosHTML::selectList($public_items_arr, 'f_public', 'size="1" class="text"', 'value', 'text', $f_param[4]);
?>
		</td>
		<td>
<?php
	$autor_items_arr[] = mosHTML::makeOption('', _UDDEADM_USERSET_SELAUTOR);
	$autor_items_arr[] = mosHTML::makeOption('0', _UDDEADM_USERSET_NO);
	$autor_items_arr[] = mosHTML::makeOption('1', _UDDEADM_USERSET_YES);
	echo mosHTML::selectList($autor_items_arr, 'f_autor', 'size="1" class="text"', 'value', 'text', $f_param[6]);
?>
		</td>
		<td>
<?php
	$autof_items_arr[] = mosHTML::makeOption('', _UDDEADM_USERSET_SELAUTOF);
	$autof_items_arr[] = mosHTML::makeOption('0', _UDDEADM_USERSET_NO);
	$autof_items_arr[] = mosHTML::makeOption('1', _UDDEADM_USERSET_YES);
	echo mosHTML::selectList($autof_items_arr, 'f_autof', 'size="1" class="text"', 'value', 'text', $f_param[7]);
?>
		</td>
		<td>
<?php
	$moderated_items_arr[] = mosHTML::makeOption('', _UDDEADM_USERSET_SELMODERATE);
	$moderated_items_arr[] = mosHTML::makeOption('0', _UDDEADM_USERSET_NO);
	$moderated_items_arr[] = mosHTML::makeOption('1', _UDDEADM_USERSET_YES);
	echo mosHTML::selectList($moderated_items_arr, 'f_moderated', 'size="1" class="text"', 'value', 'text', $f_param[9]);
?>
		</td>
		<td>
<?php
	$locked_items_arr[] = mosHTML::makeOption('', _UDDEADM_USERSET_SELLOCKED);
	$locked_items_arr[] = mosHTML::makeOption('0', _UDDEADM_USERSET_NO);
	$locked_items_arr[] = mosHTML::makeOption('1', _UDDEADM_USERSET_YES);
	echo mosHTML::selectList($locked_items_arr, 'f_locked', 'size="1" class="text"', 'value', 'text', $f_param[8]);
?>
		</td>
		<td>
			<input type="submit" class="button" value="<?php echo _UDDEADM_ADMIN_FILTER; ?>" />
		</td>
	</tr>
	</table>

	<br />

	<table class="adminlist">
	<tr>
<?php if (uddeIMcheckJversion()>=7) {		// Joomla 3.2 or higher ?>
	<th class="title" width="4%"><input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" /></th>
<?php } else { ?>
	<th class="title" width="4%"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" /></th>
<?php } ?>
		<th class="title" width="4%"><?php echo "UID"; ?></th>
		<th class="title" width="4%"><?php echo "ID"; ?></th>
		<th class="title" nowrap="nowrap"><?php echo _UDDEADM_USERSET_USERNAME; ?></th>
		<th class="title"><?php echo _UDDEADM_USERSET_NAME; ?></th>
		<th class="title"><?php echo _UDDEADM_USERSET_NOTIFICATION; ?></th>
		<th class="title"><?php echo _UDDEADM_USERSET_POPUP; ?></th>
		<th class="title"><?php echo _UDDEADM_USERSET_PUBLIC; ?></th>
		<th class="title"><?php echo _UDDEADM_USERSET_AUTOR; ?></th>
		<th class="title"><?php echo _UDDEADM_USERSET_AUTOF; ?></th>
		<th class="title"><?php echo _UDDEADM_USERSET_MODERATE; ?></th>
		<th class="title"><?php echo _UDDEADM_USERSET_LOCKED; ?></th>
		<th class="title" nowrap="nowrap"><?php echo _UDDEADM_USERSET_LASTACCESS; ?></th>
		<th class="title" nowrap="nowrap"><?php echo _UDDEADM_USERSET_LASTSENT; ?></th>
	</tr>
<?php
	$k = 0;
	for($i=0, $n=count( $rows ); $i < $n; $i++)
	{
		$row = &$rows[$i];
		echo "<tr class='row$k'>";
		if (uddeIMcheckJversion()>=7) {		// Joomla 3.2 or higher
			echo "<td width='5%'><input type='checkbox' id='cb$i' name='uddeid[]' value='$row->uid' onclick='Joomla.isChecked(this.checked);' /></td>";
		} else {
			echo "<td width='5%'><input type='checkbox' id='cb$i' name='uddeid[]' value='$row->uid' onclick='isChecked(this.checked);' /></td>";
		}
		echo "<td align='left'>$row->uid</td>";
		echo "<td align='left'>". (is_null($row->id) ? "-" : "$row->id") ."</td>";
		echo "<td align='left'>$row->username</td>";
		echo "<td align='left'>$row->name</td>";
		echo "<td align='left'>";
		if (is_null($row->status)) { 
			echo "(";
			switch($config->notifydefault) {
				case 0: echo _UDDEADM_USERSET_NONOTIFICATION; break;
				case 1: echo _UDDEADM_USERSET_ALWAYS; break;
				case 2: echo _UDDEADM_USERSET_WHENOFFLINE; break;
				case 10: echo _UDDEADM_USERSET_ALWAYSEXCEPT; break;
				case 20: echo _UDDEADM_USERSET_WHENOFFLINEEXCEPT; break;
				default: echo _UDDEADM_USERSET_UNKNOWN; break;
			}
			echo ")";
		} else {
			echo "<a href='javascript:document.adminForm.act.value=\"status\"; document.adminForm.id.value=\"".$row->id."\"; document.adminForm.submit();'>";

			switch($row->status) {
				case 0: echo _UDDEADM_USERSET_NONOTIFICATION; break;
				case 1: echo _UDDEADM_USERSET_ALWAYS; break;
				case 2: echo _UDDEADM_USERSET_WHENOFFLINE; break;
				case 10: echo _UDDEADM_USERSET_ALWAYSEXCEPT; break;
				case 20: echo _UDDEADM_USERSET_WHENOFFLINEEXCEPT; break;
				default: echo _UDDEADM_USERSET_UNKNOWN; break;
			}
			echo "</a>";
		}
		echo "</td>";
		echo "<td align='left'>";
		if (is_null($row->popup)) { 
			uddeIMshowTick($config->popupdefault,true);
		} else {
			echo "<a href='javascript:document.adminForm.act.value=\"popup\"; document.adminForm.id.value=\"".$row->id."\"; document.adminForm.submit();'>";
			uddeIMshowTick($row->popup);
			echo "</a>";
		}
		echo "</td>";
		echo "<td align='left'>";
		if (is_null($row->public)) { 
			uddeIMshowTick($config->pubfrontenddefault,true);
		} else {
			echo "<a href='javascript:document.adminForm.act.value=\"public\"; document.adminForm.id.value=\"".$row->id."\"; document.adminForm.submit();'>";
			uddeIMshowTick($row->public);
			echo "</a>";
		}
		echo "</td>";
		echo "<td align='left'>";
		if (is_null($row->autoresponder)) { 
			uddeIMshowTick(0,true);	// default is 0"
		} else {
			echo "<a href='javascript:document.adminForm.task.value=\"editautoresponder\"; document.adminForm.id.value=\"".$row->id."\"; document.adminForm.submit();'>";
			uddeIMshowTick($row->autoresponder);
			echo "</a>";
		}
		echo "</td>";
		echo "<td align='left'>";
		if (is_null($row->autoforward)) { 
			uddeIMshowTick(0,true);	// default is "0"
		} else {
			echo "<a href='javascript:document.adminForm.task.value=\"editautoforward\"; document.adminForm.id.value=\"".$row->id."\"; document.adminForm.submit();'>";
			uddeIMshowTick($row->autoforward);
			echo "</a>";
		}
		echo "</td>";
		echo "<td align='left'>";
		if (is_null($row->moderated)) { 
			uddeIMshowTick(0,true);	// default is "0"
		} else {
			echo "<a href='javascript:document.adminForm.act.value=\"moderated\"; document.adminForm.id.value=\"".$row->id."\"; document.adminForm.submit();'>";
			uddeIMshowTick($row->moderated);
			echo "</a>";
		}
		echo "</td>";
		echo "<td align='left'>";
		if (is_null($row->locked)) { 
			uddeIMshowTick(0,true);	// default is "0"
		} else {
			echo "<a href='javascript:document.adminForm.act.value=\"locked\"; document.adminForm.id.value=\"".$row->id."\"; document.adminForm.submit();'>";
			uddeIMshowTick($row->locked);
			echo "</a>";
		}
		echo "</td>";
		echo "<td align='left'>";
		if (is_null($row->remindersent)) { 
			echo "---";
		} else {
			echo $row->remindersent ? date("Y-m-d H:i:s", $row->remindersent + (3600*uddeIMgetUserTZ())) : "-";
		}
		echo "</td>";
		echo "<td align='left'>";
		if (is_null($row->lastsent)) { 
			echo "---";
		} else {
			echo $row->lastsent ? date("Y-m-d H:i:s", $row->lastsent + (3600*uddeIMgetUserTZ())) : "-";
		}
		echo "</td>";
		echo "</tr>\n";
		$k = 1 - $k;
	}
?>
<tr>
	<th align="center" colspan="14" ><div id='uddeim-pagenav'><?php echo $pageNav->writePagesLinks(); ?></div></th>
</tr>
<tr>
	<td align="center" colspan="14"><?php echo $pageNav->writePagesCounter(); ?></td>
</tr>
</table>
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="<?php echo $task;?>" />
	<input type="hidden" name="act" value="" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="hidemainmenu" value="0" />
<?php
	if (uddeIMcheckJversion()>=1) {
		echo "<input type=\"hidden\" name=\"limitstart\" value=\"".(int)$limitstart."\" />";
	}
?>
</form>
<?php
}

function uddeIMusermessagesremove($option, $task, $uddeid, $config) {
	$database = uddeIMgetDatabase();
	$rightnow=uddetime($config->timezone);
	echo "<div style='text-align:left'>";
	echo "<p><b>"._UDDEADM_DELETEM_DELETING."</b></p>";
	if (count($uddeid)) {
		foreach($uddeid AS $id) {
			echo _UDDEADM_DELETEM_FROMUSER.(int)$id.":<br />";

			$sql="SELECT count(id) FROM `#__uddeim` WHERE totrashoutbox=0 AND fromid=".(int)$id;
			$database->setQuery($sql);
			$entryexists=$database->loadResult();
			echo _UDDEADM_DELETEM_MSGSSENT.(int)$entryexists."<br />";
			if ($entryexists) {
				$sql="UPDATE `#__uddeim` SET totrashoutbox=1, totrashdateoutbox=".(int)$rightnow." WHERE totrashoutbox=0 AND fromid=".(int)$id;
				$database->setQuery($sql);
				$database->execute();
			}
			$sql="SELECT count(id) FROM `#__uddeim` WHERE totrash=0 AND toid=".(int)$id;
			$database->setQuery($sql);
			$entryexists=$database->loadResult();
			echo _UDDEADM_DELETEM_MSGSRECV.(int)$entryexists."<br />";
			if ($entryexists) {
				$sql="UPDATE `#__uddeim` SET totrash=1, toread=1, totrashdate=".(int)$rightnow." WHERE totrash=0 AND toid=".(int)$id;
				$database->setQuery($sql);
				$database->execute();
			}
		}
	}
	echo "<p><b><a href=".uddeIMredirectIndex()."?option=$option&task=usersettings>"._UDDEADM_CONTINUE."</a></b></p>";
	echo "</div>";
}

function uddeIMdolistEMN($option, $task, $uddeid, $config) {
	$database = uddeIMgetDatabase();
	if ($task=="usersettingsremove" && count($uddeid)) {
		foreach($uddeid AS $id) {
			$sql="SELECT count(id) FROM `#__uddeim_emn` WHERE userid=".(int)$id;
			$database->setQuery($sql);
			$entryexists=$database->loadResult();
			if ($entryexists) {
				$sql="DELETE FROM `#__uddeim_emn` WHERE userid=".(int)$id;
				$database->setQuery($sql);
				$database->execute();
			}
		}
	} elseif ($task=="usersettingsnew" && count($uddeid)) {
		foreach($uddeid AS $id) {
			$sql="SELECT count(id) FROM `#__uddeim_emn` WHERE userid=".(int)$id;
			$database->setQuery($sql);
			$entryexists=$database->loadResult();
			if (!$entryexists) {
				$sql="INSERT INTO `#__uddeim_emn` (status, popup, public, userid, autorespondertext) VALUES (".$config->notifydefault.", ".$config->popupdefault.", ".$config->pubfrontenddefault.", ".$id.", '')";
				$database->setQuery($sql);
				$database->execute();
			}
		}
	}
	$redirecturl = uddeIMredirectIndex()."?option=$option&task=usersettings";
	uddeIMmosRedirect($redirecturl); 
}

function uddeIMsaveAutoresponder($option, $task, $act, $config) {
	$database = uddeIMgetDatabase();
	$emnid = intval( uddeIMmosGetParam( $_POST, 'id', '' ) );

	$autorespondercheck = (int)uddeIMmosGetParam ($_POST, 'autorespondercheck', 0);
	$autorespondertext  = uddeIMmosGetParam ($_POST, 'autorespondertext');

	$autoresponder = 0;
	if ($autorespondercheck)
		$autoresponder=1;

	if ($config->maxlength>0)		// because if 0 do not use any maxlength
		$autorespondertext = uddeIM_utf8_substr($config->languagecharset, $autorespondertext, 0, $config->maxlength);
	
	$sql="UPDATE `#__uddeim_emn` SET autoresponder=".(int)$autoresponder." WHERE id=".(int)$emnid;
	$database->setQuery($sql);
	$database->execute();

	if ($autoresponder>0) {
		$sql="UPDATE `#__uddeim_emn` SET autorespondertext='".addslashes(strip_tags($autorespondertext))."' WHERE id=".(int)$emnid;
		$database->setQuery($sql);
		$database->execute();
	}
	$redirecturl = uddeIMredirectIndex()."?option=$option&task=usersettings";
	uddeIMmosRedirect($redirecturl); 
}

function uddeIMeditAutoresponder($option, $task, $act, $config) {
	$database = uddeIMgetDatabase();
	$emnid = intval( uddeIMmosGetParam( $_POST, 'id', '' ) );

	$sql="SELECT userid FROM `#__uddeim_emn` WHERE id=".(int)$emnid;
	$database->setQuery($sql);
	$userid = (int)$database->loadResult();

	$name = "unknown";
	$username = "unknown";
	$sql="SELECT name, username FROM `#__users` WHERE id=".(int)$userid;
	$database->setQuery($sql);
	$results = $database->loadObjectList();
	foreach($results as $result) {
		$username = $result->username;
		$name     = $result->name;
	}


	$emptysettings='';
	$emn_responder_checkstatus='';

	$sql="SELECT autoresponder FROM `#__uddeim_emn` WHERE id=".(int)$emnid;
	$database->setQuery($sql);
	$ison = (int)$database->loadResult();

	if ($ison==1) {
		$emn_responder_checkstatus='checked="checked"';
	}

	$sql="SELECT autorespondertext FROM `#__uddeim_emn` WHERE id=".(int)$emnid;
	$database->setQuery($sql);
	$autorespondertext = $database->loadResult();
	$autorespondertext = stripslashes($autorespondertext);
	if (!$autorespondertext) {
		$autorespondertext = _UDDEIM_AUTORESPONDER_DEFAULT;
	}
	if ($config->maxlength>0)		// because if 0 do not use any maxlength
		$autorespondertext = uddeIM_utf8_substr($config->languagecharset, $autorespondertext, 0, $config->maxlength);

	echo "<h4 style='text-align:left;'>"._UDDEIM_AUTORESPONDER.": ".$name." (".$username.")</h4>";
	echo "<p style='text-align:left;'>"._UDDEIM_AUTORESPONDER_EXP."</p>";
	echo "<form name='adminForm' id='adminForm' method='post' action='".uddeIMredirectIndex()."' class='adminForm' style='text-align:left;'>";
	echo '<input onclick="document.adminForm.autorespondercheck.checked ? document.adminForm.autorespondertext.disabled=false : document.adminForm.autorespondertext.disabled=true;" type="checkbox" '.$emn_responder_checkstatus.' value="1" name="autorespondercheck" />'._UDDEIM_EMN_AUTORESPONDER.'<br />';
	echo "<textarea name='autorespondertext' class='inputbox' rows='4' cols='60'".($ison==1 ? '' : 'disabled="disabled"').">".htmlentities($autorespondertext,ENT_QUOTES, $config->charset)."</textarea><br />";
	// echo '<input type="submit" name="reply" class="button" value="'._UDDEIM_SAVECHANGE.'" />';
	echo '<input type="hidden" name="option" value="'.$option.'" />';
	echo '<input type="hidden" name="task" value="'.$task.'" />';
	echo '<input type="hidden" name="act" value="" />';
	echo '<input type="hidden" name="id" value="'.$emnid.'" />';
	echo '<input type="hidden" name="boxchecked" value="0" />';
	echo '<input type="hidden" name="hidemainmenu" value="0" />';
	echo "</form>";
}

function uddeIMsaveAutoforward($option, $task, $act, $config) {
	$database = uddeIMgetDatabase();
	$emnid = intval( uddeIMmosGetParam( $_POST, 'id', '' ) );

	$autoforwardcheck = (int)uddeIMmosGetParam ($_POST, 'autoforwardcheck', 0);
	$autoforwardid    = intval( uddeIMmosGetParam ($_POST, 'autoforwardid', '') );

	$autoforward = 0;
	if ($autoforwardcheck)
		$autoforward=1;
	
	$sql="UPDATE `#__uddeim_emn` SET autoforward=".(int)$autoforward." WHERE id=".(int)$emnid;
	$database->setQuery($sql);
	$database->execute();

	if ($autoforward>0) {
		$sql="UPDATE `#__uddeim_emn` SET autoforwardid=".(int)$autoforwardid." WHERE id=".(int)$emnid;
		$database->setQuery($sql);
		$database->execute();
	}
	$redirecturl = uddeIMredirectIndex()."?option=$option&task=usersettings";
	uddeIMmosRedirect($redirecturl); 
}

function uddeIMeditAutoforward($option, $task, $act, $config) {
	$database = uddeIMgetDatabase();
	$emnid = intval( uddeIMmosGetParam( $_POST, 'id', '' ) );

	$sql="SELECT userid FROM `#__uddeim_emn` WHERE id=".(int)$emnid;
	$database->setQuery($sql);
	$userid = (int)$database->loadResult();

	$name = "unknown";
	$username = "unknown";
	$sql="SELECT name, username FROM `#__users` WHERE id=".(int)$userid;
	$database->setQuery($sql);
	$results = $database->loadObjectList();
	foreach($results as $result) {
		$username = $result->username;
		$name     = $result->name;
	}

	$emptysettings='';
	$emn_forward_checkstatus='';

	$sql="SELECT autoforward FROM `#__uddeim_emn` WHERE id=".(int)$emnid;
	$database->setQuery($sql);
	$ison = (int)$database->loadResult();

	if ($ison==1) {
		$emn_forward_checkstatus='checked="checked"';
	}

	$sql="SELECT autoforwardid FROM `#__uddeim_emn` WHERE id=".(int)$emnid;
	$database->setQuery($sql);
	$autoforwardid = (int)$database->loadResult();

	echo "<h4 style='text-align:left;'>"._UDDEIM_AUTOFORWARD.": ".$name." (".$username.")</h4>";
	echo "<p style='text-align:left;'>"._UDDEIM_AUTOFORWARD_EXP."</p>";
	echo "<form name='adminForm' id='adminForm' method='post' action='".uddeIMredirectIndex()."' class='adminForm' style='text-align:left;'>";
	echo '<input onclick="document.adminForm.autoforwardcheck.checked ? document.adminForm.autoforwardid.disabled=false : document.adminForm.autoforwardid.disabled=true;" type="checkbox" '.$emn_forward_checkstatus.' value="1" name="autoforwardcheck" />'._UDDEIM_EMN_AUTOFORWARD.'<br />';

	uddeIMdoShowAllUsers(0, Array(_UDDEIM_GID_SADMIN), $config, 2, $ison, $autoforwardid);		// show all users, I am an admin, $config, mode=2 forwarding box, enabled=$ison, selected name=$autoforwardid
	echo "<br />";
	echo '<input type="hidden" name="option" value="'.$option.'" />';
	echo '<input type="hidden" name="task" value="'.$task.'" />';
	echo '<input type="hidden" name="act" value="" />';
	echo '<input type="hidden" name="id" value="'.$emnid.'" />';
	echo '<input type="hidden" name="boxchecked" value="0" />';
	echo '<input type="hidden" name="hidemainmenu" value="0" />';
	echo "</form>";
}

function uddeIMchangeStatus($option, $task, $emnid, $config) {
	$database = uddeIMgetDatabase();
	$database->setQuery("SELECT status FROM `#__uddeim_emn` WHERE id=".(int)$emnid);
	$value = (int)$database->loadResult();
	switch($value) {
		case 0: $value=1; break;
		case 1: $value=2; break;
		case 2: $value=10; break;
		case 10: $value=20; break;
		case 20: $value=0; break;
		default: $value=0; break;
	}
	$database->setQuery("UPDATE `#__uddeim_emn` SET status=".(int)$value." WHERE id=".(int)$emnid);
	$database->execute();
}

function uddeIMchangePopup($option, $task, $emnid, $config) {
	$database = uddeIMgetDatabase();
	$database->setQuery("SELECT popup FROM `#__uddeim_emn` WHERE id=".(int)$emnid);
	$value = (int)$database->loadResult();
	$value = 1 - $value;
	$database->setQuery("UPDATE `#__uddeim_emn` SET popup=".(int)$value." WHERE id=".(int)$emnid);
	$database->execute();
}

function uddeIMchangePublic($option, $task, $emnid, $config) {
	$database = uddeIMgetDatabase();
	$database->setQuery("SELECT public FROM `#__uddeim_emn` WHERE id=".(int)$emnid);
	$value = (int)$database->loadResult();
	$value = 1 - $value;
	$database->setQuery("UPDATE `#__uddeim_emn` SET public=".(int)$value." WHERE id=".(int)$emnid);
	$database->execute();
}

function uddeIMchangeLocked($option, $task, $emnid, $config) {
	$database = uddeIMgetDatabase();
	$database->setQuery("SELECT locked FROM `#__uddeim_emn` WHERE id=".(int)$emnid);
	$value = (int)$database->loadResult();
	$value = 1 - $value;
	$database->setQuery("UPDATE `#__uddeim_emn` SET locked=".(int)$value." WHERE id=".(int)$emnid);
	$database->execute();
}

function uddeIMchangeModerated($option, $task, $emnid, $config) {
	$database = uddeIMgetDatabase();
	$database->setQuery("SELECT moderated FROM `#__uddeim_emn` WHERE id=".(int)$emnid);
	$value = (int)$database->loadResult();
	$value = 1 - $value;
	$database->setQuery("UPDATE `#__uddeim_emn` SET moderated=".(int)$value." WHERE id=".(int)$emnid);
	$database->execute();
}


