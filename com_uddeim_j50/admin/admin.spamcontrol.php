<?php
// ********************************************************************************************
// @title         udde Instant Messages (uddeIM)
// @description   Instant Messages System for Joomla 5, spamcontrol
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
// Version 5.3
// ********************************************************************************************

defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );

function uddeIMcheckPluginASC() {
	return 7;
}

function uddeIMshowSpamControl($option, $task, $act, $config) {
	$mosConfig_offset = uddeIMgetOffset();
	$database = uddeIMgetDatabase();
	$version = uddeIMgetVersion();
	$emnid = intval( uddeIMmosGetParam( $_POST, 'id', '' ) );
	
	uddeIMaddScript(uddeIMgetPath('live_site')."/components/com_uddeim/js/uddeimtools.js");

	switch($act) {
		case "delete":	uddeIMdeleteOneReportSPAM($option, $task, $act, $emnid, $config);		break;
		case "remove":	uddeIMdeleteOneReportSPAM($option, $task, $act, $emnid, $config);		break;
	}

	// get parameter from filter
	$f_param = array();
	$f_where = array();

	$f_param[0] = uddeIMmosGetParam($_POST, 'f_username', '');
	if($f_param[0]!="") $f_where[] = "ufrom.username LIKE '$f_param[0]%'";

	$f_param[1] = uddeIMmosGetParam($_POST, 'f_name', '');
	if($f_param[1]!="") $f_where[] = "ufrom.name LIKE '$f_param[1]%'";

	$limit      = intval( uddeIMmosGetParam( $_POST, 'limit', 10 ) );
	$limitstart = intval( uddeIMmosGetParam( $_POST, 'limitstart', 0 ) );
	$where = count($f_where) ? " WHERE " . implode(' AND ', $f_where) : "";

	$sql  = "SELECT count(ufrom.id) AS cid, a.*, ufrom.name AS fromname, 
						   uto.name AS toname,
						 ufrom.username AS fromusername, 
						   uto.username AS tousername
				FROM ((#__uddeim_spam AS a LEFT JOIN `#__users` AS ufrom ON a.fromid = ufrom.id) 
									       LEFT JOIN `#__users` AS uto   ON a.toid   = uto.id)
										   LEFT JOIN `#__uddeim` AS b    ON a.mid    = b.id".$where;
    
	
	$database->setQuery($sql);
	$rows = $database->loadObjectList();
	$cid = $rows[0]->cid;
	$total = $cid;

	if ($limit==0) {
		$limit = $total;
		$limitstart = 0;
	}
	if ($limitstart>=$total)
		$limitstart = 0;


	$sql  = "SELECT b.totrash AS trashinbox, b.totrashoutbox AS trashoutbox, a.*, ufrom.name AS fromname, 
						   uto.name AS toname,
						 ufrom.username AS fromusername, 
						   uto.username AS tousername
				FROM ((#__uddeim_spam AS a LEFT JOIN `#__users` AS ufrom ON a.fromid = ufrom.id) 
									       LEFT JOIN `#__users` AS uto   ON a.toid   = uto.id)
										   LEFT JOIN `#__uddeim` AS b    ON a.mid    = b.id";
	$sql .= $where;
	$sql .= " ORDER BY a.id DESC LIMIT $limitstart,$limit";
	$database->setQuery($sql);
	$rows = $database->loadObjectList();

	$pageNav = new uddeIMmosPageNav( $total, $limitstart, $limit  );

	$query="SELECT username,name FROM `#__users` WHERE block!='1' ORDER BY username";
	$database->setQuery($query);
	$results = $database->loadObjectList();

	$results = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	
	$the_username='<select id="f_username" class="form-select" name="f_username" size="1"><option value=""';
	if ($f_param[0]=="") $the_username.=' selected';
	$the_username.='>'._UDDEADM_USERSET_SELUSERNAME.'</option>';
	foreach($results as $result) {
		$the_username.='<option value="'.$result.'"';
		if ($result==$f_param[0]) $the_username.=' selected';
		$the_username.='>'.$result.'...</option>';
	}
	$the_username.="</select>";

	$the_name='<select id="f_name" class="form-select" name="f_name" size="1"><option value=""';
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
			<h4><?php echo _UDDEADM_SPAMCONTROL_EDIT; ?></h4>
		</td>
		<td class="sectionname" align="right">
			<img align="middle" style="display: inline; border:1px solid lightgray;" src="<?php echo uddeIMgetPath('live_site')."/components/com_uddeim/templates/images/uddeim_logo.png"; ?>" />
		</td>
	</tr>
	</table>
	</div>

	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist uddfilter">
	<tr>
		<td width="15%" align="left"><?php echo $pageNav->writeLimitBox('?option=$option&task=$task'); ?></td>
		<td align="right"><?php echo $the_username; ?></td>
		<td><?php echo $the_name; ?></td>
		<td>
			<input type="submit" class="btn btn-success" value="<?php echo _UDDEADM_ADMIN_FILTER; ?>" />
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
		<th class="title" width="4%"><?php echo "ID"; ?></th>
		<th class="title" width="4%"><?php echo "MID"; ?></th>
		<th class="title" width="4%"><?php echo _UDDEADM_SPAMCONTROL_TRASHED; ?></th>
		<th class="title" nowrap="nowrap"><?php echo _UDDEADM_SPAMCONTROL_FROM; ?></th>
		<th class="title" width="4%"><?php echo _UDDEADM_SPAMCONTROL_TRASHED; ?></th>
		<th class="title" nowrap="nowrap"><?php echo _UDDEADM_SPAMCONTROL_TO; ?></th>
		<th class="title"><?php echo _UDDEADM_SPAMCONTROL_REMOVE; ?></th>
		<th class="title"><?php echo _UDDEADM_SPAMCONTROL_DELETE; ?></th>
		<th class="title" nowrap="nowrap"><?php echo _UDDEADM_SPAMCONTROL_DATE; ?></th>
		<th class="title" nowrap="nowrap"><?php echo _UDDEADM_SPAMCONTROL_REPORTED; ?></th>
	</tr>
<?php
	$k = 0;
	for($i=0, $n=count( $rows ); $i < $n; $i++)
	{
		$row = &$rows[$i];
		echo "<tr class='row$k'>";
		if (uddeIMcheckJversion()>=7) {		// Joomla 3.2 or higher
			echo "<td width='5%'><input type='checkbox' id='cb$i' name='uddeid[]' value='$row->id' onclick='Joomla.isChecked(this.checked);' /></td>";
		} else {
			echo "<td width='5%'><input type='checkbox' id='cb$i' name='uddeid[]' value='$row->id' onclick='isChecked(this.checked);' /></td>";
		}
		echo "<td align='left'>$row->id</td>";
		echo "<td align='left'>$row->mid</td>";
		echo "<td align='left'>";
			echo uddeIMshowValueNULL($row->trashoutbox);
		echo "</td>";
		echo "<td align='left'>$row->fromname ($row->fromusername)</td>";
		echo "<td align='left'>";
			echo uddeIMshowValueNULL($row->trashinbox);
		echo "</td>";
		echo "<td align='left'>$row->toname ($row->tousername)</td>";
		echo "<td align='left'>";
			echo "<a href='#' onclick='document.adminForm.act.value=\"remove\"; document.adminForm.id.value=\"".$row->id."\"; if (confirm(\""._UDDEADM_SPAMCONTROL_NOTEREMOVE."\")) document.adminForm.submit(); return false;'>";
			uddeIMshowTick(false,false);	// show cross, not opaque
			echo "</a>";
		echo "</td>";
		echo "<td align='left'>";
			if (is_null($row->trashoutbox) && is_null($row->trashinbox)) {
				// message already deleted
			} else {
				echo "<a href='#' onclick='document.adminForm.act.value=\"delete\"; document.adminForm.id.value=\"".$row->id."\"; if (confirm(\""._UDDEADM_SPAMCONTROL_NOTEDEL."\")) document.adminForm.submit(); return false;'>";
				uddeIMshowTick(false,($row->trashoutbox && $row->trashinbox));	// show cross, not opaque (opaque, wenn beide true)
				echo "</a>";
			}
		echo "</td>";
		echo "<td align='left'>";
			echo date("Y-m-d H:i:s", $row->datum + (3600*uddeIMgetUserTZ()));
		echo "</td>";
		echo "<td align='left'>";
			echo date("Y-m-d H:i:s", $row->reported + (3600*uddeIMgetUserTZ()));
		echo "</td>";
		echo "</tr>\n";
		
		echo "<tr class='row$k'>";
		echo "<td align='left'></td>";
		echo "<td align='left'></td>";
		echo "<td align='left'></td>";
		echo "<td align='left' colspan='8'>";
			echo "<div style='text-align:right;'><a href='javascript:uddeIMtoggleLayer(\"".$i."\");'>"._UDDEADM_SPAMCONTROL_SHOWHIDE."</a></div>";
			echo "<div id='uddeimdivlayer_".$i."' style='display:none;'>";
			$dm = uddeIMdecrypt($row->message, "", CRYPT_MODE_STOREBASE64);
			echo $dm;
			echo "</div>";
		echo "</td>";
		echo "</tr>\n";

		$k = 1 - $k;
	}
?>
<tr>
	<th align="center" colspan="11"><?php echo $pageNav->writePagesLinks(); ?></th>
</tr>
<tr>
	<td align="center" colspan="11"><?php echo $pageNav->writePagesCounter(); ?></td>
</tr>
</table>
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="<?php echo $task;?>" />
	<input type="hidden" name="act" value="" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="hidemainmenu" value="0" />
</form>
<?php
}

function uddeIMdeleteOneReportSPAM($option, $task, $act, $emnid, $config) {
	$database = uddeIMgetDatabase();

	$sql = "SELECT mid FROM `#__uddeim_spam` WHERE id=".(int)$emnid;		// not required when $act=remove but who cares
	$database->setQuery($sql);
	$mid = (int)$database->loadResult();

	$sql = "DELETE FROM `#__uddeim_spam` WHERE id=".(int)$emnid;
	$database->setQuery($sql);
	if (!$database->execute())
		die("SQL error when attempting to remove a report" . $db->stderr(true));

	if ($act=='delete') {
		$sql = "DELETE FROM `#__uddeim` WHERE id=".(int)$mid;
		$database->setQuery($sql);
		if (!$database->execute())
			die("SQL error when attempting to remove a spam message" . $database->stderr(true));
	}
}

function uddeIMremoveReportSPAM($option, $task, $uddeid, $config) {
	$database = uddeIMgetDatabase();
	if (count($uddeid)) {
		if ($task=='spamremove') {
			foreach($uddeid AS $id) {
				uddeIMdeleteOneReportSPAM($option, $task, 'delete', (int)$id, $config);
			}
		}
		if ($task=='reportremove') {
			foreach($uddeid AS $id) {
				uddeIMdeleteOneReportSPAM($option, $task, 'remove', (int)$id, $config);
			}
		}
	}
	$redirecturl = uddeIMredirectIndex()."?option=$option&task=spamcontrol";
	uddeIMmosRedirect($redirecturl); 
}
