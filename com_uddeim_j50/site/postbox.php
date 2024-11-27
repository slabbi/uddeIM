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
// version 5.4.4
// ***************************************************************************
defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );

function uddeIMcheckPluginPB() {
	return 7;
}

function uddeIMselectPostbox($myself, $limitstart, $limit, $config, $filter_user=0, $filter_unread=0, $filter_flagged=0, $sort_mode=0) {
	$database = uddeIMgetDatabase();
	$filter = " WHERE 0=0";
	if ($filter_user) $filter = " WHERE id=".(int)$filter_user;
	if ($filter_user==-1) $filter = " WHERE id=0";
	if ($filter_unread) $filter .= " AND toread=0";
	if ($filter_flagged) $filter .= " AND flagged<>0";

	$sort = " ORDER BY datum";	// default
	switch($sort_mode) {
		case 0:
		case 1: $sort = " ORDER BY toread ASC, datum"; break;		// default
		case 2:
		case 3: $sort = " ORDER BY toread ASC, displayname"; break;
	}
	if ($sort_mode % 2)
		$sort .= " ASC";		// 1= ASC
	else
		$sort .= " DESC";		// 0 = DESC

	$sql = "SELECT count(id) AS cnt, MIN(toread) AS toread, MAX(readid) AS readid, MAX(flagged) AS flagged, MAX(flagid) AS flagid, MAX(datum) AS datum, id, displayname FROM (
			(SELECT a.toid AS id, 1 AS toread, 0 AS readid, 0 AS flagged, 0 AS flagid, a.datum AS datum, b.".($config->realnames ? "name" : "username")." AS displayname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.toid=b.id WHERE a.fromid=".(int)$myself." AND a.totrashoutbox=0 )
			UNION
			(SELECT a.fromid AS id, toread, CASE WHEN a.toread=0 THEN a.id ELSE 0 END AS readid, flagged, CASE WHEN a.flagged=1 THEN a.id ELSE 0 END AS flagid, a.datum AS datum, b.".($config->realnames ? "name" : "username")." AS displayname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$myself." AND a.totrash=0 AND a.archived=0 AND a.delayed=0 )
			) AS comb_table".$filter." GROUP BY id".$sort." LIMIT ".(int)$limitstart.", ".(int)$limit;
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMselectPostboxUser($myself, $userid, $limitstart, $limit, $config) {
	$database = uddeIMgetDatabase();

	$sql = "
			SELECT a.*, ufrom.".($config->realnames ? "name" : "username")." AS fromname, 
						  uto.".($config->realnames ? "name" : "username")." AS toname
			FROM (#__uddeim AS a FORCE INDEX(PRIMARY) LEFT JOIN `#__users` AS ufrom ON a.fromid = ufrom.id) 
								 LEFT JOIN `#__users` AS uto   ON a.toid   = uto.id
			WHERE (a.totrash=0    AND a.toid=".(int)$myself." AND a.fromid=".(int)$userid." AND a.archived=0 AND a.delayed=0)
			   OR (a.totrashoutbox=0 AND a.fromid=".(int)$myself." AND a.toid=".(int)$userid.")
			ORDER BY datum DESC LIMIT ".(int)$limitstart.", ".(int)$limit;
	$database->setQuery($sql);
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();
	return $value;
}

function uddeIMgetPostboxCount($myself, $userid, $filter_user=0, $filter_unread=0, $filter_flagged=0) {
	$database = uddeIMgetDatabase();
	$filter=" WHERE 0=0";
	if ($filter_user) $filter = " WHERE id=".(int)$filter_user;
	if ($filter_user==-1) $filter = " WHERE id=0";
	if ($filter_unread) $filter .= " AND toread=0";
	if ($filter_flagged) $filter .= " AND flagged<>0";

	$sql = "SELECT COUNT(*) FROM (
			SELECT count(id) AS cnt, MIN(toread) AS toread, MAX(flagged) AS flagged FROM (
			(SELECT a.toid AS id, 1 AS toread, 0 AS flagged FROM `#__uddeim` AS a WHERE a.fromid=".(int)$myself." AND a.totrashoutbox=0 ) 
			UNION 
			(SELECT a.fromid AS id, toread, flagged FROM `#__uddeim` AS a WHERE a.toid=".(int)$myself." AND a.totrash=0 AND a.archived=0 AND a.delayed=0 )
			) AS comb_table".$filter." GROUP BY id
			) AS comb2_table";
	$database->setQuery($sql);
	$total = (int)$database->loadResult();
	return $total;
}

function uddeIMgetPostboxUserCount($myself, $userid, $filter_user=0, $filter_unread=0, $filter_flagged=0) {
	$database = uddeIMgetDatabase();
	$filter="";
	if ($filter_user) $filter = " WHERE a.fromid=".(int)$filter_user;
	if ($filter_user==-1) $filter = " WHERE a.fromid=0";
	if ($filter_unread) $filter .= " AND a.toread=0";
	if ($filter_flagged) $filter .= " AND a.flagged<>0";

	$filterout = "";
	if ($filter_user) $filterout = " AND a.toid=".(int)$filter_user;
	if ($filter_user==-1) $filterout = " AND a.toid=0";
	$sql = "
			SELECT count(a.id) 		 
			FROM `#__uddeim` AS a 		 
			WHERE (a.totrash=0    AND a.toid=".(int)$myself." AND a.fromid=".(int)$userid.$filter.")
			   OR (a.totrashoutbox=0 AND a.fromid=".(int)$myself." AND a.toid=".(int)$userid.$filterout.")";
	$database->setQuery($sql);
	$total = (int)$database->loadResult();
	return $total;
}



function uddeIMshowPostbox($myself, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode) {
	global $uddeicons_flagged, $uddeicons_unflagged, $uddeicons_onlinepic, $uddeicons_offlinepic, $uddeicons_readpic, $uddeicons_unreadpic;
	
	$pathtosite = uddeIMgetPath('live_site');

	$addlink = "";
	$addlink2 = "";
	if ($filter_user)
		$addlink .= "&filter_user=".(int)$filter_user;
	if ($filter_unread)
		$addlink .= "&filter_unread=".(int)$filter_unread;
	if ($filter_flagged)
		$addlink .= "&filter_flagged=".(int)$filter_flagged;
	if ($sort_mode)
		$addlink2 .= "&sort_mode=".(int)$sort_mode;

	// TODO $sort_datum/name leer, wenn nicht aktiviert
	$sort_datum = "";
	$sort_name = "";
	if ($config->enablesort) {
		$temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_updown.gif' alt='"._UDDEIM_UPDOWN."' title='"._UDDEIM_UPDOWN."' border='0' />";
		$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postbox&sort_mode=0&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
		$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postbox&sort_mode=2&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
		switch($sort_mode) {
			case 0: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_down.gif' alt='"._UDDEIM_UP."' title='"._UDDEIM_UP."' border='0' />";
					$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postbox&sort_mode=1&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 1: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_up.gif' alt='"._UDDEIM_DOWN."' title='"._UDDEIM_DOWN."' border='0' />";
					$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postbox&sort_mode=0&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 2: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_down.gif' alt='"._UDDEIM_UP."' title='"._UDDEIM_UP."' border='0' />";
					$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postbox&sort_mode=3&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 3: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_up.gif' alt='"._UDDEIM_DOWN."' title='"._UDDEIM_DOWN."' border='0' />";
					$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postbox&sort_mode=2&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
		}
	}

	// invoke pruning if set so
	$my_gid = $config->usergid;

	if	($config->adminignitiononly==1) {			// admin only
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))				// call pruneMsgs, when it is an admin or superadmin
			uddeIMpruneMessages($myself, $item_id, $my_gid, 'postbox', $config);
	} elseif ($config->adminignitiononly==0) {		// all users are allowed to prune messages,
		uddeIMpruneMessages($myself, $item_id, $my_gid, 'postbox', $config);	// when all users can prune then gid is not really neccessary
	}

	if	($config->fileadminignitiononly==1) {		// admin only
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))				// call pruneMsgs, when it is an admin or superadmin
			uddeIMpruneFiles($myself, $item_id, $my_gid, 'postbox', $config);
	} elseif ($config->fileadminignitiononly==0) {	// all users are allowed to prune messages,
		uddeIMpruneFiles($myself, $item_id, $my_gid, 'postbox', $config);	// when all users can prune then gid is not really neccessary
	}

	// set the remindersent to now, because looking into inbox counts as remindersent
	uddeIMupdateEMNreminder($myself, uddetime($config->timezone));

	// message limit for inbox?
	if ($config->inboxlimit && $config->allowarchive) {
		$universeflag = _UDDEIM_ARC_UNIVERSE_BOTH;	// inbox and archive
	} else {
		$universeflag = _UDDEIM_ARC_UNIVERSE_INBOX;	// inbox
	}

	if ($config->inboxlimit && $config->allowarchive) {		// inbox + archive, already stored messages in archive are not counted, when archive is disabled
		$total = uddeIMgetInboxArchiveCount($myself);
	} else {
		$total = uddeIMgetInboxCount($myself);				// also used for navigation
	}

	$limitwarning = "";
	// "You have XX messages in your inbox/inbox+archive."
	$limitreached = _UDDEIM_INBOX_LIMIT_1." ".$total;
	$limitreached.= " ".($total==1 ? _UDDEIM_INBOX_LIMIT_2_SINGULAR : _UDDEIM_INBOX_LIMIT_2)." ";
	$limitreached.= $universeflag;

	if ($config->inboxlimit) {		// there is a limit for inbox + archive
		if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
			// "The allowed maximum is XX."
			// $limitreached.= _UDDEIM_INBOX_LIMIT_3." ".$config->maxarchive.". ";
			$limitreached.= " "._UDDEIM_SHOWINBOXLIMIT_2." ".$config->maxarchive.").";	// (of max. )

			if ($total > $config->maxarchive) {
				$limitwarning = _UDDEIM_INBOX_LIMIT_4;		// You can still receive and read messages but you will not be able to reply or to compose new ones until you delete messages.
			}
		}
	} else {						// there is a limit for the archive only
		$limitreached.= ".";		// so inbox is unlimited
	}

	// how many users total in postbox?
	$totalpostbox = uddeIMgetPostboxCount($myself, 0, $filter_user, $filter_unread, $filter_flagged);

	// now load messages as required
	if(!$limitstart)
		$limitstart = 0;

	if(!$limit)
		$limit=$config->perpage;

	if ($limitstart>=$totalpostbox)
		$limitstart=max(0,$limitstart - $limit);

	$allmessages = uddeIMselectPostbox($myself, $limitstart, $limit, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);


	// write the uddeim menu
	uddeIMprintMenu($myself, 'postbox', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	if ($config->enablefilter==1 || $config->enablefilter==3)
		uddeIMprintFilter($myself, 'postbox', $totalpostbox, $item_id, $config, $filter_user, $filter_unread, $filter_flagged);

	// if no messages:
	if (empty($allmessages)) { // no messages to list
		uddeIMshowNoMessage('postbox', $filter_user, $filter_unread, $filter_flagged);
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

	uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");

	echo "<form method='post' name='messages' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postboxfork&Itemid=".$item_id)."'>\n";
	// now open the inbox container and table; write table headings
	echo "<div id='uddeim-overview'><table cellpadding='7' width='100%'>\n";
	// checkcell
	$delall="<input type=\"checkbox\" name=\"arcmes[]\" value=\"\" onclick=\"wiglwogl(this);\" title=\""._UDDEIM_CHECKALL."\" />";
	echo "<tr><th style='text-align:center;' class='sectiontableheader'>".$delall."</th><th class='sectiontableheader'>&nbsp;</th><th class='sectiontableheader'>"._UDDEIM_FROM.$sort_name."</th><th class='sectiontableheader'>"._UDDEIM_MESSAGES."</th><th class='sectiontableheader'>"._UDDEIM_DATE.$sort_datum."</th><th class='sectiontableheader'>&nbsp;</th></tr>\n";

	$i = 1;
	// now write the list
	foreach($allmessages as $themessage) {

		$username = $themessage->displayname;
		$userid = $themessage->id;
		
		$fromname = NULL;
		if ($username==NULL && !$userid) {
			$fromname = _UDDEIM_PUBLICUSER;
		} elseif ($username==NULL) {
			$fromname = _UDDEIM_DELETEDUSER;
		} else {
			$fromname = $username;
		}


		$fromcell = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postboxuser&Itemid=".$item_id."&recip=".$userid)."'>".$fromname."</a>";
		if ($userid) {
			if ($config->showcblink && $username) {
				//$fromcell = uddeIMshowThumbOrLink($userid, $fromname, $config);
				$pic = uddeIMgetPicOnly($userid, $config, true);
				if ($pic) {
					$pic = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postboxuser&Itemid=".$item_id."&recip=".$userid)."'>".$pic."</a>";
					$pic .= "<br />";
				}
				$fromcell = $pic.$fromcell;
			}

			// is this user currently online?
			if ($config->showonline && $username) {
				$isonline = uddeIMisOnline($userid);
				if ($isonline)
					$fromcell.="&nbsp;".$uddeicons_onlinepic;
				else
					$fromcell.="&nbsp;".$uddeicons_offlinepic;
			}
		}

		$readcell = $themessage->toread ? $uddeicons_readpic :
                    "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postboxuser&Itemid=".$item_id."&recip=".$userid."&ret=postboxuser#m".$themessage->readid)."'>".$uddeicons_unreadpic."</a>";

		$flagcell= !$config->allowflagged ? "" :
                    "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postboxuser&Itemid=".$item_id."&recip=".$userid."&ret=postboxuser#m".$themessage->flagid)."'>"
                    .($themessage->flagged ? $uddeicons_flagged : $uddeicons_unflagged)."</a><br />";                              //&limit=".$limit."&limitstart=".$limitstart."
		            //alt:  $flagcell = "<br />".$uddeicons_unflagged;

		$datumcell=uddeDate($themessage->datum, $config, uddeIMgetUserTZ());

		// ############################################################################# task=deletealluser
		if ($config->actionicons) {
			$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=deletealluser&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&recip=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' /></a>";
		} else {
			$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=deletealluser&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&recip=".$themessage->id)."'>"._UDDEIM_DELETELINK."</a>";
		}

		// checkcell
		$delcell="<input type='checkbox' name='arcmes[]' value='".$themessage->id."' />";

		echo "<tr class='sectiontableentry".$i."'>";
		echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$delcell."</td>";		// checkcell
		echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$readcell.$flagcell."</td>";
		$st=uddeIMgetStyleForThumb($config);
		echo "<td ".$st.">".$fromcell."</td>";

		echo "<td>".$themessage->cnt."</td>";

		echo "<td>".$datumcell."</td>";
		if ($config->actionicons) {
			echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$deletecell."</td>";
		} else {
			echo "<td class='pathway'>".$deletecell."</td>";
		}
		echo "</tr>\n";

		$i++;
		if ($i>2) {
			$i=1;
		}
	}

	$muldel = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=muldeletealluser&Itemid=".$item_id."&limitstart=0&limit=".$limit);
	if($config->bottomlineicons) {
		echo "<tr><th style='text-align:center;' class='sectiontablefooter'>";
		echo '<a href="#" onclick="inboxDelete(\''.$muldel.'\'); return false;"><img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/images/trash.gif" alt="'._UDDEIM_TRASHCHECKED.'" title="'._UDDEIM_TRASHCHECKED.'"/></a>';
		echo "</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th></tr>\n";
	}
	
	// now close inbox table and container
	echo "</table></div>\n";
	// checkcell
	echo "</form>\n";

	// write the inbox navigation links
	$pageNav = new uddeIMmosPageNav($totalpostbox, $limitstart, $limit);
	$referlink = "index.php?option=com_uddeim&task=postbox&Itemid=".$item_id.$addlink.$addlink2;
	if ($totalpostbox>$limit) {
		$shownav = $pageNav->writePagesLinks($referlink);
		$shownav = uddeIMarrowReplace($shownav, $config->templatedir);
		echo "<div id='uddeim-pagenav'>".$shownav."<br />";
		echo "<a class='btn btn-sm btn-info' href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postbox&Itemid=".$item_id."&limitstart=0&limit=".$totalpostbox.$addlink.$addlink2)."'>"._UDDEIM_SHOWALL."</a>";
		echo "</div>\n";
	}

	$showinboxlimit_borderbottom = "";
	if ($limitwarning) {
		$showinboxlimit_borderbottom = "<span class='uddeim-warning'>";
		$showinboxlimit_borderbottom.= $limitreached." ";
		$showinboxlimit_borderbottom.= $limitwarning;
		$showinboxlimit_borderbottom.= "</span>";
	}

	$keephours1=($config->ReadMessagesLifespan) * 1;  // this are days
	$keephours2=($config->UnreadMessagesLifespan) * 1;  // this are days
	echo "<div id='uddeim-bottomlines'>";
	if(!$config->bottomlineicons)
		echo '<p><a href="#" onclick="inboxDelete(\''.$muldel.'\'); return false;">'._UDDEIM_TRASHCHECKED.'</a></p>';
	if ($config->ReadMessagesLifespanNote)
		echo "<p>"._UDDEIM_READ_INFO_1.$keephours1._UDDEIM_READ_INFO_2."</p>";
	if ($config->UnreadMessagesLifespanNote)
		echo "<p>"._UDDEIM_UNREAD_INFO_1.$keephours2._UDDEIM_UNREAD_INFO_2."</p>";
	if ($showinboxlimit_borderbottom)
		echo "<p>".$showinboxlimit_borderbottom."</p>";
	echo "</div>\n";

	if ($config->enablefilter==2 || $config->enablefilter==3)
		uddeIMprintFilter($myself, 'postbox', $totalpostbox, $item_id, $config, $filter_user, $filter_unread, $filter_flagged);

	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', $limitreached, $config)."</div>\n";
}



function uddeIMshowPostboxUser($myself, $userid, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode) {
	global $uddeicons_delayedpic, $uddeicons_flagged, $uddeicons_unflagged, $uddeicons_onlinepic, $uddeicons_offlinepic, $uddeicons_readpic, $uddeicons_unreadpic, $uddeicons_sentunread;
	
	$pathtosite = uddeIMgetPath('live_site');

	// invoke pruning if set so
	$my_gid = $config->usergid;

	// message limit for inbox?
	if ($config->inboxlimit && $config->allowarchive) {
		$universeflag = _UDDEIM_ARC_UNIVERSE_BOTH;	// inbox and archive
	} else {
		$universeflag = _UDDEIM_ARC_UNIVERSE_INBOX;	// inbox
	}

	if ($config->inboxlimit && $config->allowarchive) {		// inbox + archive, already stored messages in archive are not counted, when archive is disabled
		$total = uddeIMgetInboxArchiveCount($myself);
	} else {
		$total = uddeIMgetInboxCount($myself);				// also used for navigation
	}

	$limitwarning = "";
	// "You have XX messages in your inbox/inbox+archive."
	$limitreached = _UDDEIM_INBOX_LIMIT_1." ".$total;
	$limitreached.= " ".($total==1 ? _UDDEIM_INBOX_LIMIT_2_SINGULAR : _UDDEIM_INBOX_LIMIT_2)." ";
	$limitreached.= $universeflag;

	if ($config->inboxlimit) {		// there is a limit for inbox + archive
		if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
			// "The allowed maximum is XX."
			// $limitreached.= _UDDEIM_INBOX_LIMIT_3." ".$config->maxarchive.". ";
			$limitreached.= " "._UDDEIM_SHOWINBOXLIMIT_2." ".$config->maxarchive.").";	// (of max. )

			if ($total > $config->maxarchive) {
				$limitwarning = _UDDEIM_INBOX_LIMIT_4;		// You can still receive and read messages but you will not be able to reply or to compose new ones until you delete messages.
			}
		}
	} else {						// there is a limit for the archive only
		$limitreached.= ".";		// so inbox is unlimited
	}

	$totalpostbox = uddeIMgetPostboxUserCount($myself, $userid, $filter_user, $filter_unread, $filter_flagged);

	// now load messages as required
	if(!$limitstart)
		$limitstart = 0;

	if(!$limit)
		$limit=$config->perpage;

	if ($limitstart>=$totalpostbox)
		$limitstart=max(0,$limitstart - $limit);

	// $allmessages = uddeIMselectInbox($myself, $limitstart, $limit, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);
	$allmessages = uddeIMselectPostboxUser($myself, $userid, $limitstart, $limit, $config);


	// write the uddeim menu
	uddeIMprintMenu($myself, 'inbox', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	//if ($config->enablefilter==1 || $config->enablefilter==3)
	//	uddeIMprintFilter($myself, 'postboxuser', $totalpostbox, $item_id, $config, $filter_user, $filter_unread, $filter_flagged);

	// if no messages:
	if (empty($allmessages)) { // no messages to list
		uddeIMshowNoMessage('postbox', $filter_user, $filter_unread, $filter_flagged);
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

	uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");


	if ($config->blocksystem) {
		if ($userid && $userid!=$myself) {
			$isblocked = uddeIMcheckBlockerBlocked($myself, $userid);
			if (!$isblocked) {
				echo "<div id='uddeim-block'>";
				echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td align='left'>";
				$blockcell = "<div style='text-align:right;'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=blockuser&Itemid=".$item_id."&recip=".$userid."&ret=postboxuser")."'>"._UDDEIM_BLOCKNOW."</a></div>";
				echo $blockcell;
				echo "</td></tr></table>";
				echo "</div>";
			}
		}
	}

    $conuser = $allmessages[0]->toid == $myself ? $allmessages[0]->fromname : $allmessages[0]->toname;

	echo "<form method='post' name='messages' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inboxfork&Itemid=".$item_id)."'>\n";
	// now open the inbox container and table; write table headings
	echo "<div id='uddeim-overview'>";
	echo "<table cellpadding='7' width='100%'>\n";
	// checkcell
	$delall="<input type=\"checkbox\" name=\"arcmes[]\" value=\"\" onclick=\"wiglwogl(this);\" title=\""._UDDEIM_CHECKALL."\" />";
	echo "<tr>";
	echo "<th style='border:none; text-align:center;' class='sectiontableheader'>".$delall."</th>";
	echo "<th style='border:none;' class='sectiontableheader'>&nbsp;</th>";
	echo "<th style='border:none;' class='sectiontableheader'>"._UDDEIM_FROM."&ensp;<span class='badge'>".$conuser."</span></th>";
	echo "<th style='border:none;' class='sectiontableheader'>"._UDDEIM_DATE."</th>";
	echo "<th style='border:none;' class='sectiontableheader'>&nbsp;</th>";
	echo "</tr>\n";


	$k = 1;
	$i = 1;
	// now write the list
	foreach($allmessages as $themessage) {


		$isinbox = 0;
		$isoutbox = 0;
		if ($myself==$themessage->toid && $myself!=$themessage->fromid) {
			$isinbox = 1;
		} elseif ($myself==$themessage->fromid && $myself!=$themessage->toid) {
			$isoutbox = 1;
		} else {	// this case appears when a copy to me message has been trashed my myself
			$isinbox = 1;
		}

		$is_spam = 0;
		if ($config->reportspam)		// save one database query if possible
			$is_spam = uddeIMgetSpamStatus($themessage->id);

		$flagcell = "";
		$archivecell = "";
		$fwdcell = "";
		$deletecell = "";
		$recallcell = "";
		$attachcell = "";
		$spamcell = "";
		$spamcellflag = "";

		if ($isinbox) {
			if($config->allowflagged) {
				if($themessage->flagged)
                    $flagcell = "<a href='javascript:uddeIMflgSwitch(\"unflag\",\"".$themessage->id."\",\"".$userid."\");'>".$uddeicons_flagged."</a><br />";
					//$flagcell="<br /><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=unflag&recip=".$userid."&ret=postboxuser&Itemid=".$item_id."&messageid=".$themessage->id."&limit=".$limit."&limitstart=".$limitstart)."'>".$uddeicons_flagged."</a>";
				else
                    $flagcell = "<a href='javascript:uddeIMflgSwitch(\"flag\",\"".$themessage->id."\",\"".$userid."\");'>".$uddeicons_unflagged."</a><br />";
                    //$flagcell="<br /><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=flag&recip=".$userid."&ret=postboxuser&Itemid=".$item_id."&messageid=".$themessage->id."&limit=".$limit."&limitstart=".$limitstart)."'>".$uddeicons_unflagged."</a>";
			}
			if($themessage->toread)
                $readcell = "<a href='javascript:uddeIMtoggleread(\"".$i."\",false,\"markunread\",\"".$themessage->id."\",\"".$userid."\");'>".$uddeicons_readpic."</a><br />";
                //$readcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=markunread&recip=".$userid."&ret=postboxuser&Itemid=".$item_id."&messageid=".$themessage->id."&limit=".$limit."&limitstart=".$limitstart)."'>".$uddeicons_readpic."</a>";
			else
                $readcell = "<a href='javascript:uddeIMtoggleread(\"".$i."\",false,\"markread\",\"".$themessage->id."\",\"".$userid."\");'>".$uddeicons_unreadpic."</a><br />";
                //$readcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=markread&recip=".$userid."&ret=postboxuser&Itemid=".$item_id."&messageid=".$themessage->id."&limit=".$limit."&limitstart=".$limitstart)."'>".$uddeicons_unreadpic."</a>";

			if ($config->showlistattachment) {
				$cnt = uddeIMgetAttachmentCount($themessage->id);
				if ($cnt)
					$attachcell = "<br /><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/attachment.gif' alt='"._UDDEIM_ATTACHMENT."' title='"._UDDEIM_ATTACHMENT."' border='0' />";
			}

			if ($config->actionicons) {
				$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postboxdeleteinbox&recip=".$userid."&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' /></a>";
				if ($config->allowforwards) {
					if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
						$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardpass&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' /></a><br />";
					} else {	// normal message
						$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forward&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' /></a><br />";
					}
				}
				if ($config->allowarchive && $themessage->toread)
					$archivecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archivemessage&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/archive.gif' alt='"._UDDEIM_STORE."' title='"._UDDEIM_STORE."' /></a><br />";
			} else {
				$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postboxdeleteinbox&recip=".$userid."&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'>"._UDDEIM_DELETELINK."</a>";
				if ($config->allowforwards) {
					if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
						$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_FORWARDLINK."</a><br />";
					} else {	// normal message
						$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forward&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_FORWARDLINK."</a><br />";
					}
				}
				if ($config->allowarchive && $themessage->toread)
					$archivecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archivemessage&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'>"._UDDEIM_STORE."</a><br />";
			}

			if ($config->reportspam) {		// uddeIMcheckPlugin('spamcontrol') &&  not required since uddeIMcheckConfig sets this 0 if plugin is missing
				if ($is_spam) {
                    $spamcell = "<a class='uddeim-messageactionlink-spam unreport' href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=unreportspam&Itemid=".$item_id."&messageid=".$themessage->id."&recip=".$userid."&ret=postboxuser")."'>"._UDDEIM_SPAMCONTROL_UNREPORT."</a>&nbsp;";
					$spamcellflag = "<br /><div class='uddeim-messagefrom-spam badge bg-success'>"._UDDEIM_SPAMCONTROL_MARKED."</div>";
                } else {
                    $spamcell = "<a class='uddeim-messageactionlink-spam' href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=reportspam&Itemid=".$item_id."&messageid=".$themessage->id."&recip=".$userid."&ret=postboxuser")."'>"._UDDEIM_SPAMCONTROL_REPORT."</a>&nbsp;";
				}
			}
		}

		if ($isoutbox) {
			if ($themessage->delayed) {
				$readcell=$uddeicons_delayedpic;
			} else {
				if ($themessage->toread)
					$readcell=$uddeicons_readpic;
				else
					$readcell=$uddeicons_sentunread; //$uddeicons_unreadpic;
			}

			if ($config->showlistattachment) {
				$cnt = uddeIMgetAttachmentCount($themessage->id);
				if ($cnt)
					$attachcell = "<br /><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/attachment.gif' alt='"._UDDEIM_ATTACHMENT."' title='"._UDDEIM_ATTACHMENT."' border='0' />";
			}

			if ($config->actionicons) {
				$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postboxdeleteoutbox&recip=".$userid."&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' /></a>";
				if ($config->allowforwards) {
					if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
						$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutboxpass&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' /></a><br />";
					} else {	// normal message
						$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutbox&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' /></a><br />";
					}
				}
			} else {
				$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postboxdeleteoutbox&recip=".$userid."&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'>"._UDDEIM_DELETELINK."</a>";
				if ($config->allowforwards) {
					if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
						$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutboxpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_FORWARDLINK."</a><br />";
					} else {	// normal message
						$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutbox&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_FORWARDLINK."</a><br />";
					}
				}
			}
			if(!$themessage->toread) {	// if not read then a recall is possible
				if($config->actionicons) {
					if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
						$recallcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=recallpass&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/restore.gif' alt='"._UDDEIM_RECALL."' title='"._UDDEIM_RECALL."' /></a><br />";
					} else {	// normal message
						$recallcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=recall&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/restore.gif' alt='"._UDDEIM_RECALL."' title='"._UDDEIM_RECALL."' /></a><br />";
					}
				} else {
					if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
						$recallcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=recallpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_RECALL."</a><br />";
					} else {	// normal message
						$recallcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=recall&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_RECALL."</a><br />";
					}
				}
			}
		}


		if ($isinbox) {
			if ($config->actionicons) {
				$newemail = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=reply&recip=".$userid."&Itemid=".$item_id."&messageid=".$themessage->id)."'>";
				$newemail .= "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_new.gif' alt='"._UDDEIM_COMPOSE."' title='"._UDDEIM_COMPOSE."' />";
				$newemail .= "</a>";
			} else {
				$newemail = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=reply&recip=".$userid."&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_COMPOSE."</a>";
			}
		}
		if ($isoutbox) {
			if ($config->actionicons) {
				$newemail = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=new&recip=".$userid."&Itemid=".$item_id)."'>";
				$newemail .= "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/menu_new.gif' alt='"._UDDEIM_COMPOSE."' title='"._UDDEIM_COMPOSE."' />";
				$newemail .= "</a>";
			} else {
				$newemail = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=new&recip=".$userid."&Itemid=".$item_id)."'>"._UDDEIM_COMPOSE."</a>";
			}
		}


		// CRYPT
		$cm = uddeIMgetMessage($themessage->message, $cryptpass, $themessage->cryptmode, $themessage->crypthash, $config->cryptkey);
		$teasermessage=$cm;
		// if it is a system message or bb codes allowed, parse BB codes
		if ($themessage->systemflag || $config->allowbb)
			$teasermessage=uddeIMbbcode_strip($teasermessage);

		$teasermessage=uddeIMteaser(stripslashes($teasermessage ?? ''), $config->firstwordsinbox, $config->quotedivider, $config->languagecharset);
		$teasermessage=htmlspecialchars($teasermessage, ENT_QUOTES, $config->charset);
		$teasermessage=str_replace("&amp;#", "&#", $teasermessage);
		$teasermessage=str_replace("&amp;&lt;/br&gt;", " ", $teasermessage);

		$safemessage=htmlspecialchars(stripslashes($cm ?? ''), ENT_QUOTES, $config->charset);
		$safemessage=str_replace("&amp;&lt;/br&gt;", "</br>", $safemessage);

		$showemail = "";
		if ($isinbox) {
			if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
				$messagecell= "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>".$teasermessage."</a>";
				$showemail  = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>";
				$showemail .= "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/reply.gif' alt='"._UDDEIM_DOREPLY."' title='"._UDDEIM_DOREPLY."' />";;
				$showemail .= "</a>";
			} else {							// normal message
				// $messagecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$themessage->id)."'>".$teasermessage."</a>";
				$messagecell = $themessage->toread ?
                               "<a href='javascript:uddeIMtoggleread(\"".$i."\",true);'>".$teasermessage."</a>"
                             : "<a href='javascript:uddeIMtoggleread(\"".$i."\",true,\"markread\",\"".$themessage->id."\",\"".$userid."\");'>".$teasermessage."</a>";
				$showemail  = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$themessage->id)."'>";
				$showemail .= "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/reply.gif' alt='"._UDDEIM_DOREPLY."' title='"._UDDEIM_DOREPLY."' />";;
				$showemail .= "</a>";
			}
		}
		if ($isoutbox) {
			if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
				$messagecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showoutpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>".$teasermessage."</a>";
				$showemail  = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showoutpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>";
				$showemail .= "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/page_white_magnify.gif' alt='"._UDDEIM_DISPLAY."' title='"._UDDEIM_DISPLAY."' />";;
				$showemail .= "</a>";
			} else {	// normal message
				// $messagecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showout&Itemid=".$item_id."&messageid=".$themessage->id)."'>".$teasermessage."</a>";
				$messagecell="<a href='javascript:uddeIMtoggleread(\"".$i."\",true);'>".$teasermessage."</a>";
				$showemail  = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showout&Itemid=".$item_id."&messageid=".$themessage->id)."'>";
				$showemail .= "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/page_white_magnify.gif' alt='"._UDDEIM_DISPLAY."' title='"._UDDEIM_DISPLAY."' />";;
				$showemail .= "</a>";
			}
		}

		$datumcell=uddeDate($themessage->datum, $config, uddeIMgetUserTZ());

		// checkcell
		$delcell="<input type='checkbox' name='arcmes[]' value='".$themessage->id."' />";

		//echo "<tr class='sectiontableentry1'>";
		echo "<tr class='uddeim-messagebody2header' id='m".$themessage->id."'>";
		echo "<td style='padding:4px; border-bottom:none; border-right:none; width:32px; text-align:center; vertical-align:top'>".$delcell."</td>";		// checkcell
		echo "<td style='padding:4px; border-bottom:none; border-right:none; width:32px; text-align:center; vertical-align:top'>".
						$readcell.$attachcell.$flagcell.
						"</td>";
		$st=uddeIMgetStyleForThumb($config);
		//echo "<td ".$st.">";
		echo "<td style='padding:4px; border-bottom:none; border-right:none; vertical-align:top'>";
		if ($isinbox)
			echo uddeIMdoInboxHeader($myself, $themessage, $config);
		if ($isoutbox)
			echo uddeIMdoOutboxHeader($myself, $themessage, $config);
		echo "</td>";
		echo "<td style='padding:4px; border-bottom:none; border-right:none; vertical-align:top'>";
		echo $datumcell;
		echo $spamcellflag.$spamcell;
		echo "</td>";
		if ($config->actionicons) {
			echo "<td style='padding:4px; border-bottom:none; width:32px; text-align:center; vertical-align:top'>".
//						$fwdcell.$recallcell.$archivecell.$deletecell."<br /><br />".$newemail.
						$fwdcell.$recallcell.$archivecell.$deletecell.
						"</td>";
		} else {
			echo "<td style='padding:4px; border-bottom:none; vertical-align:top' class='pathway'>".
						$fwdcell.$recallcell.$archivecell.$deletecell."<br /><br />".$newemail.
						"</td>";
		}
		echo "</tr>\n";

		
//		if ($themessage->cryptmode!=2 && $themessage->cryptmode!=4) {	// Message is encrypted, so display no message

			// ############################################################# MESSSAGE

			$cm = uddeIMgetMessage($themessage->message, $cryptpass, $themessage->cryptmode, $themessage->crypthash, $config->cryptkey);

			// echo str_replace("&amp;#", "&#", nl2br(htmlspecialchars(stripslashes($cm), ENT_QUOTES, $config->charset)));
			$dmessage = nl2br(htmlspecialchars(stripslashes($cm ?? ''), ENT_QUOTES, $config->charset));
			$dmessage = str_replace("&amp;#", "&#", $dmessage);		// unicode workaround
			// if system message or bbcodes allowed, call parser
			if ($themessage->systemflag || $config->allowbb)
				$dmessage = uddeIMbbcode_replace($dmessage, $config);
			if ($config->allowsmile)
				$dmessage = uddeIMsmile_replace($dmessage, $config);
			$bodystring = $dmessage;			// converted message for email body


if (0) {
			echo "<tr class='uddeim-messagebody2body'>";
			echo "<td colspan='3' style='border-style:none; padding:0 8px 0 8px; text-align:left; vertical-align:bottom'>";
				echo str_replace("<br />", "", $fwdcell."&nbsp".$recallcell."&nbsp".$archivecell."&nbsp".$deletecell."&nbsp;&nbsp;&nbsp;".$newemail);
			echo "</td>";
			echo "<td colspan='2' style='border-style:none; padding:0 8px 0 8px; text-align:right; vertical-align:middle'>";
				echo str_replace("<br />", "", $readcell.$attachcell.$flagcell);
			echo "</td>";
			echo "</tr>";
}

			echo "<tr class='uddeim-messagebody2body'>";
			echo "<td colspan='4' style='padding:8px; border-top:none; border-right:none;'>";
				// echo "<div style='text-align:right;'><a href='javascript:uddeIMtoggleLayer2(\"".$i."\");'>"._UDDEADM_SPAMCONTROL_SHOWHIDE."</a></div>";

			if (($config->postboxfull==2 && $themessage->toread) ||
                ($i==1 && $config->postboxfull==1 && $themessage->toread)) {
					$st_preview = "display:none;";
					$st_normal = "display:inline;";
			} else {
                    $st_preview = "display:inline;";
					$st_normal = "display:none;";
            }
				
				echo "<div id='uddeimdivlayerpreview_".$i."' style='".$st_preview."'>";
                echo "<div class='uddeim-messagebody2'>".$messagecell."</div>";
				echo "</div>\n";

				echo "<div id='uddeimdivlayer_".$i."' style='".$st_normal."'>";
				    $messagecell="<a href='javascript:uddeIMtoggleread(\"".$i."\",true);'>".uddeIMreplyquoteMarkup($bodystring,$config->quotedivider)."</a>";
				echo "<div class='uddeim-messagebody2'>".$messagecell."</div>";
				// UDDEIMFILE
				if( $config->enableattachment )	{ // Always show attachments when attachments are enabled
					if ($isinbox)
						uddeIMshowAttachments("inbox", $item_id, $themessage->id, $config);
					if ($isoutbox)
						uddeIMshowAttachments("outbox", $item_id, $themessage->id, $config);
				}
				echo "</div>\n";

			echo "</td>\n";
			echo "<td style='padding:4px; border-top:none; border-left:none; width:32px; text-align:center; vertical-align:top'>";
				echo $newemail."<br />".$showemail;
			echo "</td>\n";
			echo "</tr>\n";

		$i++;
		$k++;
		if ($k > 2)
			$k = 1;
	}

	$muldel = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=mulpostboxdelete&Itemid=".$item_id."&recip=".$userid."&limitstart=0&limit=".$limit);
	if($config->bottomlineicons) {
		echo "<tr><th style='border:none; text-align:center;' class='sectiontablefooter'>";
		echo '<a href="#" onclick="inboxDelete(\''.$muldel.'\'); return false;"><img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/images/trash.gif" alt="'._UDDEIM_TRASHCHECKED.'" title="'._UDDEIM_TRASHCHECKED.'"/></a>';
		echo "</th><th style='border:none;' class='sectiontablefooter'>&nbsp;</th><th style='border:none;' class='sectiontablefooter'>&nbsp;</th><th style='border:none;' class='sectiontablefooter'>&nbsp;</th><th style='border:none;' class='sectiontablefooter'>&nbsp;</th></tr>\n";
	}
	
	// now close inbox table and container
	echo "</table></div>\n";
	// checkcell
	echo "</form>\n";

	// write the inbox navigation links
	$pageNav = new uddeIMmosPageNav($totalpostbox, $limitstart, $limit);
	$referlink = "index.php?option=com_uddeim&task=postboxuser&recip=".$userid."&Itemid=".$item_id;
	if ($totalpostbox>$limit) {
		$shownav = $pageNav->writePagesLinks($referlink);
		//couldn't find where/why the recip is cut out, so we have to injet it again
        $shownav = str_replace("postboxuser","postboxuser&recip=".$userid,$shownav);
		$shownav = uddeIMarrowReplace($shownav, $config->templatedir);
		echo "<div id='uddeim-pagenav'>".$shownav."<br />";
		echo "<a class='btn btn-sm btn-info' href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=postboxuser&Itemid=".$item_id."&recip=".$userid."&limitstart=0&limit=".$totalpostbox)."'>"._UDDEIM_SHOWALL."</a>";
		echo "</div>\n";
	}

	$showinboxlimit_borderbottom = "";
	if ($limitwarning) {
		$showinboxlimit_borderbottom = "<span class='uddeim-warning'>";
		$showinboxlimit_borderbottom.= $limitreached." ";
		$showinboxlimit_borderbottom.= $limitwarning;
		$showinboxlimit_borderbottom.= "</span>";
	}

	$keephours1=($config->ReadMessagesLifespan) * 1;  // this are days
	$keephours2=($config->UnreadMessagesLifespan) * 1;  // this are days
	echo "<div id='uddeim-bottomlines'>";
	if(!$config->bottomlineicons)
		echo '<p><a href="#" onclick="inboxDelete(\''.$muldel.'\'); return false;">'._UDDEIM_TRASHCHECKED.'</a></p>';
	if ($config->ReadMessagesLifespanNote)
		echo "<p>"._UDDEIM_READ_INFO_1.$keephours1._UDDEIM_READ_INFO_2."</p>";
	if ($config->UnreadMessagesLifespanNote)
		echo "<p>"._UDDEIM_UNREAD_INFO_1.$keephours2._UDDEIM_UNREAD_INFO_2."</p>";
	if ($showinboxlimit_borderbottom)
		echo "<p>".$showinboxlimit_borderbottom."</p>";
	echo "</div>\n";

	//if ($config->enablefilter==2 || $config->enablefilter==3)
	//	uddeIMprintFilter($myself, 'postboxuser', $totalpostbox, $item_id, $config, $filter_user, $filter_unread, $filter_flagged);

	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', $limitreached, $config)."</div>\n";
}



function uddeIMdoInboxHeader($myself, $displaymessage, $config) {
	global $uddeicons_flagged, $uddeicons_unflagged, $uddeicons_onlinepic, $uddeicons_offlinepic, $uddeicons_readpic, $uddeicons_unreadpic;

	$fromname = uddeIMevaluateUsername($displaymessage->fromname, $displaymessage->fromid, $displaymessage->publicname);
	if ($displaymessage->systemflag)
		$fromname = $displaymessage->systemmessage;

	$personalsys = 0;
	if ($displaymessage->systemflag && $displaymessage->systemmessage==$displaymessage->fromname)
		$personalsys = 1;

	$headerstring = "";

	if ($config->postboxavatars==0) {
		if ($displaymessage->toid!=$displaymessage->fromid) { // not a copy to myself
			$headerstring.=_UDDEIM_MESSAGEFROM;
		} else {
			// $headerstring.=_UDDEIM_MESSAGE." ";			// BUGBUG: "Message admin"   -   sollte besser "Copy to yourself" sein
			if ( 0 == strncasecmp($displaymessage->systemmessage, _UDDEIM_TO_SMALL." ", strlen(_UDDEIM_TO_SMALL)+1 ) )
				$headerstring.=_UDDEIM_MESSAGE." ";			// systemmsg is "to XXX", so suppress the from (copy2me)
			else
				$headerstring.=_UDDEIM_MESSAGEFROM." ";		// systemmsg is a name
		}

		// show links ???
		$temp = $fromname;
		if ($config->showcblink && $displaymessage->fromname) {
//			if (!$displaymessage->systemflag || $personalsys) {
				$temp = uddeIMgetLinkOnly($displaymessage->fromid, $fromname, $config);
//			}
		}
		// display email address
		if ($displaymessage->fromname==NULL && !$displaymessage->fromid && $displaymessage->publicemail!=NULL)
			$temp .= " &lt;<a href='mailto:".$displaymessage->publicemail."'>".$displaymessage->publicemail."</a>&gt;";
	} else {
		$temp = $fromname;
		if ($config->showcblink && $displaymessage->fromname)
			if (!$displaymessage->systemflag || $personalsys)
				$temp = uddeIMgetPicOnly($displaymessage->fromid, $config, false);

		// display email address
		if ($displaymessage->fromname==NULL && !$displaymessage->fromid && $displaymessage->publicemail!=NULL)
			$temp .= " &lt;<a href='mailto:".$displaymessage->publicemail."'>".$displaymessage->publicemail."</a>&gt;";
	}
	
	$headerstring.=$temp;

	// is this user currently online?
	if ($config->showonline && $displaymessage->fromname) {
		if (!$displaymessage->systemflag || $personalsys) {
			$isonline = uddeIMisOnline($displaymessage->fromid);
			if ($isonline)
				$headerstring.="&nbsp;".$uddeicons_onlinepic;
			else
				$headerstring.="&nbsp;".$uddeicons_offlinepic;
		}
	}

	return $headerstring;
}

function uddeIMdoOutboxHeader($myself, $displaymessage, $config) {
	global $uddeicons_flagged, $uddeicons_unflagged, $uddeicons_onlinepic, $uddeicons_offlinepic, $uddeicons_readpic, $uddeicons_unreadpic;

	$toname = uddeIMevaluateUsername($displaymessage->toname, $displaymessage->toid, $displaymessage->publicname);

	// display the message
	$headerstring = "";

	if ($config->postboxavatars==0) {
		$headerstring.=_UDDEIM_MESSAGETO;

		// show links ???
		$temp = $toname;
		if ($config->showcblink && $displaymessage->toname) {
			$temp = uddeIMgetLinkOnly($displaymessage->toid, $toname, $config);
		}
		// display email address
		if ($displaymessage->toname==NULL && !$displaymessage->toid && $displaymessage->publicemail!=NULL)
			$temp .= " &lt;<a href='mailto:".$displaymessage->publicemail."'>".$displaymessage->publicemail."</a>&gt;";
			
	} else {

		$temp = uddeIMgetPicOnly($displaymessage->fromid, $config, false);

		// display email address
		if ($displaymessage->toname==NULL && !$displaymessage->toid && $displaymessage->publicemail!=NULL)
			$temp .= " &lt;<a href='mailto:".$displaymessage->publicemail."'>".$displaymessage->publicemail."</a>&gt;";
	}

	$headerstring.=$temp;

    //showonline (in outbox) should be corresponding to avatar ($displaymessage->fromid)
    if ($config->showonline && $displaymessage->fromid == $myself)
    $headerstring.="&nbsp;".$uddeicons_onlinepic;    //myself = online

	return $headerstring;
}

// *****************************************************************************************

function uddeIMdeletePostbox($myself, $arcmes, $limit, $limitstart, $item_id, $config) {

	if (empty($arcmes)) {
	    echo _UDDEIM_NOMSGSELECTED."<br /><a href='javascript:history.go(-1)'>"._UDDEIM_BACK."</a>";
		return;
	}
    $n = count($arcmes);
	for ($i = 0; $i <= ($n-1); $i++) {
		$deletetime=uddetime($config->timezone);
		if ($arcmes[$i]>0) {
			$totalpostbox = uddeIMgetPostboxUserCount($myself, $arcmes[$i], 0, 0, 0);
			$allmessages = uddeIMselectPostboxUser($myself, $arcmes[$i], 0, $totalpostbox, $config);
			foreach($allmessages as $themessage) {
				if ($myself==$themessage->toid && $myself!=$themessage->fromid) {
					uddeIMupdateToread($myself, $themessage->id, 1);
					uddeIMdeleteMessageFromInbox($myself, $themessage->id, $deletetime);
				} elseif ($myself==$themessage->fromid && $myself!=$themessage->toid) {
					uddeIMdeleteMessageFromOutbox($myself, $themessage->id, $deletetime);
				} else {	// this case appears when a copy to me message has been trashed my myself
					uddeIMupdateToread($myself, $themessage->id, 1);
					uddeIMdeleteMessageFromInbox($myself, $themessage->id, $deletetime);
				}
			}
		}
	}
	uddeJSEFredirect("index.php?option=com_uddeim&task=postbox&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
}

function uddeIMdeletePostboxUser($myself, $recip, $limit, $limitstart, $item_id, $config) {
	$arcmes = Array( $recip );
	uddeIMdeletePostbox($myself, $arcmes, $limit, $limitstart, $item_id, $config);
}

function uddeIMdeleteMessagePostbox($myself, $messageid, $userid, $box, $limit, $limitstart, $item_id, $config) {
	// Delete sets outbox trash flag to true (it does not erase the message from the db, this is only done by PRUNING the messages. So messages deleted from the inbox will be moved to the trash can of the respective user
	$deletetime=uddetime($config->timezone);
	
	if ($box=="inbox") {
		uddeIMupdateToread($myself, $messageid, 1);
		uddeIMdeleteMessageFromInbox($myself, $messageid, $deletetime);
	}
	if ($box=="outbox") {
		uddeIMdeleteMessageFromOutbox($myself, $messageid, $deletetime);
	}

	uddeJSEFredirect("index.php?option=com_uddeim&task=postboxuser&recip=".$userid."&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
}

function uddeIMdeleteMessagePostboxMultiple($myself, $userid, $arcmes, $limit, $limitstart, $item_id, $config) {

	if (empty($arcmes)) {
		echo _UDDEIM_NOMSGSELECTED."<br /><a href='javascript:history.go(-1)'>"._UDDEIM_BACK."</a>";
		return;
	}
    $n = count($arcmes);
	for ($i = 0; $i <= ($n-1); $i++) {
		$deletetime=uddetime($config->timezone);
		if ($arcmes[$i]>0) {
			$allmessages = uddeIMselectMessage($myself, $arcmes[$i], $config, $trashed=-1);
			foreach($allmessages as $themessage) {
				if ($myself==$themessage->toid && $myself!=$themessage->fromid) {
					uddeIMupdateToread($myself, $themessage->id, 1);
					uddeIMdeleteMessageFromInbox($myself, $themessage->id, $deletetime);
				} elseif ($myself==$themessage->fromid && $myself!=$themessage->toid) {
					uddeIMdeleteMessageFromOutbox($myself, $themessage->id, $deletetime);
				} else {	// this case appears when a copy to me message has been trashed my myself
					uddeIMupdateToread($myself, $themessage->id, 1);
					uddeIMdeleteMessageFromInbox($myself, $themessage->id, $deletetime);
				}
			}
		}
	}
	uddeJSEFredirect("index.php?option=com_uddeim&task=postboxuser&Itemid=".$item_id."&recip=".$userid."&limit=".$limit."&limitstart=".$limitstart);
}
