<?php
// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2010 Stephan Slabihoud, © 2006 Benjamin Zweifel
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

function uddeIMarchive($myself, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode) {
	global $uddeicons_flagged, $uddeicons_unflagged, $uddeicons_onlinepic, $uddeicons_offlinepic, $uddeicons_readpic, $uddeicons_unreadpic;
	
	if(!$config->allowarchive) {
		uddeIMprintMenu($myself, 'archive', $item_id, $config);
		echo "<div id='uddeim-m'>\n";
		echo "<div id='uddeim-overview'><p><b>"._UDDEIM_ARCHIVENOTENABLED."</b></p></div>\n";
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

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
		$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archive&sort_mode=0&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
		$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archive&sort_mode=2&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
		switch($sort_mode) {
			case 0: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_down.gif' alt='"._UDDEIM_UP."' title='"._UDDEIM_UP."' border='0' />";
					$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archive&sort_mode=1&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 1: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_up.gif' alt='"._UDDEIM_DOWN."' title='"._UDDEIM_DOWN."' border='0' />";
					$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archive&sort_mode=0&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 2: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_down.gif' alt='"._UDDEIM_UP."' title='"._UDDEIM_UP."' border='0' />";
					$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archive&sort_mode=3&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 3: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_up.gif' alt='"._UDDEIM_DOWN."' title='"._UDDEIM_DOWN."' border='0' />";
					$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archive&sort_mode=2&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
		}
	}

	$my_gid = $config->usergid;

	// message limit for archive?
	if ($config->inboxlimit) {
		$universeflag = _UDDEIM_ARC_UNIVERSE_BOTH;	// inbox and archive.
	} else {
		$universeflag = _UDDEIM_ARC_UNIVERSE_ARC;	// archive.
	}

	// how many messages total in archive?
	$totalarchive = uddeIMgetArchiveCount($myself, $filter_user, $filter_unread, $filter_flagged);

	if ($config->inboxlimit) {		// inbox + archive
		$total = uddeIMgetInboxArchiveCount($myself);
	} else {
		$total = uddeIMgetArchiveCount($myself);
	}
	
	$limitwarning = "";
	// "You have XX messages in your inbox/inbox+archive."
	$limitreached = _UDDEIM_INBOX_LIMIT_1." ".$total;
	$limitreached.= " ".($total==1 ? _UDDEIM_INBOX_LIMIT_2_SINGULAR : _UDDEIM_INBOX_LIMIT_2)." ";
	$limitreached.= $universeflag;

	if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
		// "The allowed maximum is XX."
		// $limitreached.= _UDDEIM_INBOX_LIMIT_3." ".$config->maxarchive.". ";
		$limitreached.= " "._UDDEIM_SHOWINBOXLIMIT_2." ".$config->maxarchive.").";	// (of max. )
		if ($total > $config->maxarchive) {
			$limitwarning = _UDDEIM_ARC_SAVED_3;
			// To save messages, you have to delete other messages first.
		}
	}

	// now load messages as required
	if (!$limitstart)
		$limitstart=0;
	
	if(!$limit)
		$limit=$config->perpage;
	
	if ($limitstart>=$totalarchive)
		$limitstart=max(0,$limitstart - $limit);

	// read from archive db all msg where toid is me 
	// this query should return all messages stored by me
	$allmessages = uddeIMselectArchive($myself, $limitstart, $limit, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);

	// write the uddeim menu
	uddeIMprintMenu($myself, 'archive', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	if ($config->enablefilter==1 || $config->enablefilter==3)
		uddeIMprintFilter($myself, 'archive', $totalarchive, $item_id, $config, $filter_user, $filter_unread, $filter_flagged);

	if (count($allmessages)<1) { // no messages to list
		uddeIMshowNoMessage('archive', $filter_user, $filter_unread, $filter_flagged);
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

	uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");

	echo "<form method='post' name='messages' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archivefork&Itemid=".$item_id)."'>\n";
	echo "<div id='uddeim-overview'><table cellpadding='7' width='100%'>\n";
	echo "\t<tr><th style='text-align:center;' class='sectiontableheader'>";
	echo "<input type='checkbox' name='arcmes[]' value='' onclick='wiglwogl(this);' title='"._UDDEIM_CHECKALL."' />";
	echo "</th>";
	echo "<th class='sectiontableheader'>&nbsp;</th><th class='sectiontableheader'>"._UDDEIM_FROM.$sort_name."</th><th class='sectiontableheader'>"._UDDEIM_MESSAGE."</th><th class='sectiontableheader'>"._UDDEIM_DATE.$sort_datum."</th><th class='sectiontableheader'>&nbsp;</th></tr>";

	$i=1;
	// now write the list
	foreach($allmessages as $themessage) {
		
		$fromname = uddeIMevaluateUsername($themessage->fromname, $themessage->fromid, $themessage->publicname);

		if($themessage->systemflag)
			$fromname=$themessage->systemmessage;

		$personalsys=0;
		if($themessage->systemmessage==$fromname)
			$personalsys=1;

		// show links ???
		$fromcell=$fromname;
		if ($themessage->fromid) {
			if ($config->showcblink && $themessage->fromname) {
				if (!$themessage->systemflag || $personalsys) {
					$fromcell = uddeIMshowThumbOrLink($themessage->fromid, $fromname, $config);
				}
			}

			// is this user currently online?
			if ($config->showonline && $themessage->fromname) {
				if (!$themessage->systemflag || $personalsys) {
					$isonline = uddeIMisOnline($themessage->fromid);
					if ($isonline)
						$fromcell.="&nbsp;".$uddeicons_onlinepic;
					else
						$fromcell.="&nbsp;".$uddeicons_offlinepic;
				}
			}
		}

		$flagcell = "";
		if($config->allowflagged) {
			if($themessage->flagged)
				$flagcell="<br /><br /><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=unflag&ret=archive&Itemid=".$item_id."&messageid=".$themessage->id."&limit=".$limit."&limitstart=".$limitstart)."'>".$uddeicons_flagged."</a>";
			else
				$flagcell="<br /><br /><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=flag&ret=archive&Itemid=".$item_id."&messageid=".$themessage->id."&limit=".$limit."&limitstart=".$limitstart)."'>".$uddeicons_unflagged."</a>";
		}

		// as all messages in archive are READ by design, so this is basically nonsense but consistent with inbox/outbox handling
		if($themessage->toread)
			$readcell=$uddeicons_readpic;
		else
			$readcell=$uddeicons_unreadpic;

		if ($config->showlistattachment) {
			$cnt = uddeIMgetAttachmentCount($themessage->id);
			if ($cnt)
				$readcell .= "<br /><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/attachment.gif' alt='"._UDDEIM_ATTACHMENT."' title='"._UDDEIM_ATTACHMENT."' border='0' />";
		}

		// CRYPT
		$cm = uddeIMgetMessage($themessage->message, $cryptpass, $themessage->cryptmode, $themessage->crypthash, $config->cryptkey);
		
		$teasermessage = $cm;
		// if it is a system message or bb codes allowed, parse BB codes
		if ($themessage->systemflag || $config->allowbb)
			$teasermessage = uddeIMbbcode_strip($teasermessage);

		$teasermessage=uddeIMteaser(stripslashes($teasermessage), $config->firstwordsinbox, $config->quotedivider, $config->languagecharset);			
		$teasermessage=htmlspecialchars($teasermessage, ENT_QUOTES, $config->charset);
		$teasermessage=str_replace("&amp;#", "&#", $teasermessage);
		$teasermessage=str_replace("&amp;&lt;/br&gt;", " ", $teasermessage);
		
		$safemessage=htmlspecialchars(stripslashes($cm), ENT_QUOTES, $config->charset);
		$safemessage=str_replace("&amp;&lt;/br&gt;", "</br>", $safemessage);

		if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
			$messagecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>".$teasermessage."</a>";
		} else {							// normal message
			$messagecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$themessage->id)."'>".$teasermessage."</a>";
		}
		$datumcell=uddeDate($themessage->datum, $config, uddeIMgetUserTZ());

		$fwdcell="";
		if($config->actionicons) {
			$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=delete&ret=archive&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' /></a>";
			if ($config->allowforwards) {
				if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
					$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardpass&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' /></a><br />";
				} else {							// normal message
					$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forward&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' /></a><br />";
				}
			}
			$unarchivecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=unarchive&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/unarchive.gif' alt='"._UDDEIM_UNARCHIVE."' title='"._UDDEIM_UNARCHIVE."' /></a><br />";
		} else {
			$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=delete&ret=archive&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'>"._UDDEIM_DELETELINK."</a>";
			if ($config->allowforwards) {
				if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
					$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_FORWARDLINK."</a><br />";
				} else {							// normal message
					$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forward&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_FORWARDLINK."</a><br />";
				}
			}
			$unarchivecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=unarchive&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_UNARCHIVE."</a><br />";
		}

		// for displaying a checkbox (for mass delete, mass download)
		$delcell = "<input type='checkbox' name='arcmes[]' value='".$themessage->id."' />";

		echo "\t<tr class='sectiontableentry".$i."'>";
		// checkcell
		echo "\t<td style='width:32px; text-align:center; vertical-align:middle'>".$delcell."</td>";
		echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$readcell.$flagcell."</td>";
		$st=uddeIMgetStyleForThumb($config);
		echo "<td ".$st.">".$fromcell."</td>";
		echo "<td>".$messagecell."</td>";
		echo "<td>".$datumcell."</td>";
		if($config->actionicons) {
			echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$fwdcell.$unarchivecell.$deletecell."</td>";
		} else {
			echo "<td class='pathway'>".$fwdcell.$unarchivecell.$deletecell."</td>";
		}
		echo "</tr>\n";

		$i++;
		if ($i>2) {
			$i=1;
		}
	}

	$muldown = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archivedownload&Itemid=".$item_id."&limitstart=0&limit=".$limit);
	$multrash = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archivetrash&Itemid=".$item_id."&limitstart=0&limit=".$limit);
	if($config->bottomlineicons) {
		echo "<tr><th style='text-align:left;' class='sectiontablefooter' colspan='2'>";	// colspan=2 for more space
		if ($config->enabledownload) {
			echo '<a href="#" onclick="archiveDownload(\''.$muldown.'\'); return false;"><img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/images/email.gif" alt="'._UDDEIM_EXPORT_NOW.'" title="'._UDDEIM_EXPORT_NOW.'" /></a>&nbsp;';
		}
		echo '<a href="#" onclick="archiveTrash(\''.$multrash.'\'); return false;"><img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/images/trash.gif" alt="'._UDDEIM_TRASHCHECKED.'" title="'._UDDEIM_TRASHCHECKED.'" /></a>';
		echo "</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th></tr>\n";
	}

	// now close inbox table and container
	echo "</table></div>\n";
	echo "</form>\n";

	// write the inbox navigation links
	$pageNav = new uddeIMmosPageNav($totalarchive, $limitstart, $limit);
	$referlink = "index.php?option=com_uddeim&task=archive&Itemid=".$item_id.$addlink.$addlink2;
	if ($totalarchive>$limit) {
		$shownav = $pageNav->writePagesLinks($referlink);
		$shownav = uddeIMarrowReplace($shownav, $config->templatedir);
		echo "<div id='uddeim-pagenav'>".$shownav."<br />";
		echo "[<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archive&Itemid=".$item_id."&limitstart=0&limit=".$totalarchive.$addlink.$addlink2)."'>"._UDDEIM_SHOWALL."</a>]";
		echo "</div>\n";
	}

	$showinboxlimit_borderbottom = "";
	if ($limitwarning) {
		$showinboxlimit_borderbottom = "<span class='uddeim-warning'>";
		$showinboxlimit_borderbottom.= $limitreached." ";
		$showinboxlimit_borderbottom.= $limitwarning;
		$showinboxlimit_borderbottom.= "</span>";
	}

	echo "<div id='uddeim-bottomlines'>";
	if (!$config->bottomlineicons) {
		echo "<p>";
		if ($config->enabledownload) {
			echo '<a href="#" onclick="archiveDownload(\''.$muldown.'\'); return false;">'._UDDEIM_EXPORT_NOW.'</a> | ';
		}
		echo '<a href="#" onclick="archiveTrash(\''.$multrash.'\'); return false;">'._UDDEIM_TRASHCHECKED.'</a>';
		echo "</p>";
	}
	if ($showinboxlimit_borderbottom)
		echo "<p>".$showinboxlimit_borderbottom."</p>";
	echo "</div>\n";

	if ($config->enablefilter==2 || $config->enablefilter==3)
		uddeIMprintFilter($myself, 'archive', $totalarchive, $item_id, $config, $filter_user, $filter_unread, $filter_flagged);

	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', $limitreached, $config)."</div>\n";
}

function uddeIMunarchiveMessage($myself, $messageid, $limit, $limitstart, $item_id, $config) {
	// code to unarchive a message, only do own messages
	$exists = uddeIMexistsMessageToUser($myself, $messageid);
	if (!$exists) {
		$mosmsg = _UDDEIM_CANTUNARCHIVE;
		uddeJSEFredirect("index.php?option=com_uddeim&task=archive&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart, $mosmsg);
		return;
	}
	uddeIMupdateArchivedToid($myself, $messageid, 0);
	$mosmsg = _UDDEIM_MESSAGE_UNARCHIVED;
	uddeJSEFredirect("index.php?option=com_uddeim&task=archive&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart, $mosmsg);
}

		
function uddeIMarchiveMessage ($myself, $item_id, $messageid, $cryptpass, $config) {

	$my_gid = $config->usergid;

	if (!$config->allowarchive) {
		$mosmsg=_UDDEIM_ARCHIVENOTENABLED;
		uddeJSEFredirect("HTTP_REFERER", $mosmsg, "archive");
	}
	
	$exists = uddeIMexistsMessageToUser($myself, $messageid);
	if(!$exists) {
		$mosmsg=_UDDEIM_ARCHIVE_ERROR." (ERR: no message found)"; // debug
		uddeJSEFredirect("HTTP_REFERER", $mosmsg, "archive");
	}
	
	// is the message already saved in archive? 
	$isarchived = uddeIMgetArchived($messageid);
	if($isarchived) {
		$mosmsg=_UDDEIM_MESSAGE_ARCHIVED;
		uddeJSEFredirect("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$messageid, $mosmsg);
	}

	$total = uddeIMgetArchiveCount($myself);
	if ($total>=$config->maxarchive && !uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config)) {
//		echo "<p>"._UDDEIM_ARC_SAVED_1.$total._UDDEIM_ARC_SAVED_2."</p>\n";
//		echo "<p>"._UDDEIM_ARC_SAVED_3."</p>\n";
		$mosmsg = _UDDEIM_ARCHIVEFULL;
//		uddeJSEFredirect("HTTP_REFERER", $mosmsg, "archive");
		uddeJSEFredirect("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$messageid, $mosmsg);
	}

	uddeIMupdateArchivedToid($myself, $messageid, 1);

	// redirect to archived message
	$mosmsg=_UDDEIM_MESSAGE_ARCHIVED;
	uddeJSEFredirect("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$messageid, $mosmsg);
}

function uddeIMarchiveTrash($myself, $item_id, $arcmes, $limit, $limitstart, $config) {
	// mass trash
	if (!$config->allowarchive) {
		$mosmsg=_UDDEIM_ARCHIVENOTENABLED;
		uddeJSEFredirect("HTTP_REFERER", $mosmsg, "archive");
	}
	
	$n = count($arcmes);
	if(!$n) {
		echo _UDDEIM_NOMSGSELECTED."<br /><a href='javascript:history.go(-1)'>"._UDDEIM_BACK."</a>";
		return;
	}
	for($i = 0; $i <= ($n-1); $i++) {
		$rightnow=uddetime($config->timezone);
		if($arcmes[$i]>0) {
			uddeIMdeleteMessageFromArchive($myself, $arcmes[$i], $rightnow);
		}
	}
	uddeJSEFredirect("index.php?option=com_uddeim&task=archive&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
}


function uddeIMarchiveDownload($myself, $item_id, $arcmes, $limit, $limitstart, $cryptpass, $config) {
	$mosConfig_sitename = uddeIMgetSitename();
	
	// if e-mail traffic stopped, don't send.
	if (!$config->emailtrafficenabled) {
		$mosmsg = _UDDEIM_STOPPEDEMAIL;
		uddeJSEFredirect("index.php?option=com_uddeim&task=archive&Itemid=".$item_id, $mosmsg);
	}
	
	if (!$config->allowarchive || !$config->enabledownload) {
		$mosmsg = _UDDEIM_ARCHIVENOTENABLED;
		uddeJSEFredirect("HTTP_REFERER", $mosmsg, "archive");
	}

	$n = count($arcmes);
	if(!$n) {
		echo _UDDEIM_NOMSGSELECTED."<br /><a href='javascript:history.go(-1)'>"._UDDEIM_BACK."</a>";
		return;
	}

	$clrf=chr(10);
	$rightnow=uddetime($config->timezone);
	
	$htmlstring="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"><html><head><title>";
	$htmlstring.=$mosConfig_sitename." "._UDDEIM_MESSAGEDOWNLOAD;
	$htmlstring.="</title></head><body><h2>";
	$htmlstring.=_UDDEIM_MESSAGEDOWNLOAD." - ".$mosConfig_sitename;
	$htmlstring.="</h2><h4>".uddeLdate($rightnow, $config, uddeIMgetUserTZ())."</h4><!-- generated by uddeIM messaging component --><table cellspacing=0 cellpadding=4 border=0>";
	
	$exportstring=_UDDEIM_MESSAGEDOWNLOAD." - ".$mosConfig_sitename.$clrf;
	$exportstring.=uddeLdate($rightnow, $config, uddeIMgetUserTZ());
	$exportstring.=$clrf.$clrf.$clrf;
	
	$maindivider="================================================================================".$clrf;
	
	$exportstring.=$maindivider;
	
	for($i = 0; $i <= ($n-1); $i++)	{

		$trashs = uddeIMselectArchiveMessage($myself, $arcmes[$i], $config);
		foreach($trashs as $trash) {

			$fromname = uddeIMevaluateUsername($trash->fromname, $trash->fromid, $trash->publicname);
			if($trash->systemflag)
				$fromname = $trash->systemmessage;

			// $headstring.=" (".uddeLdate($trash->datum, $config, uddeIMgetUserTZ()).")";
			// $headdivider=str_repeat("=", strlen($headstring));
			// $exportstring.="     ".$headstring.$clrf."     ".$headdivider.$clrf.$clrf;
			$cm = uddeIMgetMessage($trash->message, $cryptpass, $trash->cryptmode, $trash->crypthash, $config->cryptkey);
	
			$dlmsg = stripslashes($cm);
			$dlmsg = uddeIMbbcode_strip($dlmsg);
			// $exportstring.=stripslashes($dlmsg);
			// $exportstring.=$clrf.$clrf.$clrf.$clrf;
			// $exportstring.=$maindivider;
			$exportstring.=_UDDEIM_EXPORT_FORMAT;
			$exportstring=str_replace("%user%", $fromname, $exportstring);
			$exportstring=str_replace("%msgdate%", uddeLdate($trash->datum, $config, uddeIMgetUserTZ()), $exportstring);
			$exportstring=str_replace("%msgbody%", $dlmsg, $exportstring);				
		
			$htmlstring.="\n\t<tr bgcolor=#cccccc><td><strong>".$fromname."</strong></td><td align=right>".uddeLdate($trash->datum, $config, uddeIMgetUserTZ())."</td></tr><tr><td>&nbsp;</td><td>";
			$htmlstring.=nl2br(stripslashes($dlmsg));
			$htmlstring.="</td></tr>";
		}
	}
	$htmlstring.="\n</table>\n</body>\n</html>\n";
	
	// we now have $exportstring and $htmlstring (text and html respecitvely) as files with all checked messages (in arcmes[])
//	$ret = uddeIMgetNameEmailFromID($myself, $var_toname, $var_tomail, $config);
	$var_toname = uddeIMgetNameFromID($myself, $config);
	$var_tomail = uddeIMgetEMailFromID($myself, $config);

	if (!$var_tomail) {
		$mosmsg = _UDDEIM_EXPORT_COULDNOTSEND;
		uddeJSEFredirect("index.php?option=com_uddeim&task=archive&Itemid=".$item_id, $mosmsg);
	}
	if (!$var_toname)
		$var_toname = "Anonymous";

	$subject = $mosConfig_sitename." "._UDDEIM_MESSAGEDOWNLOAD;
	$var_fromname = $config->emn_sendername;
	$var_frommail = $config->emn_sendermail;

	if(uddeIMsendmail($var_fromname, $var_frommail, $var_toname, $var_tomail, $subject, $exportstring, $var_frommail, "", "", $config)) {
		$mosmsg = _UDDEIM_EXPORT_MAILED;
	} else {
		$mosmsg = _UDDEIM_EXPORT_COULDNOTSEND;
	}
	uddeJSEFredirect("index.php?option=com_uddeim&task=archive&Itemid=".$item_id, $mosmsg);
}
