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

function uddeIMshowInbox($myself, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode) {
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
		$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inbox&sort_mode=0&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
		$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inbox&sort_mode=2&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
		switch($sort_mode) {
			case 0: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_down.gif' alt='"._UDDEIM_UP."' title='"._UDDEIM_UP."' border='0' />";
					$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inbox&sort_mode=1&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 1: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_up.gif' alt='"._UDDEIM_DOWN."' title='"._UDDEIM_DOWN."' border='0' />";
					$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inbox&sort_mode=0&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 2: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_down.gif' alt='"._UDDEIM_UP."' title='"._UDDEIM_UP."' border='0' />";
					$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inbox&sort_mode=3&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 3: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_up.gif' alt='"._UDDEIM_DOWN."' title='"._UDDEIM_DOWN."' border='0' />";
					$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inbox&sort_mode=2&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
		}
	}

	// invoke pruning if set so
	$my_gid = $config->usergid;

	if	($config->adminignitiononly==1) {			// admin only
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))				// call pruneMsgs, when it is an admin or superadmin
			uddeIMpruneMessages($myself, $item_id, $my_gid, 'inbox', $config);
	} elseif ($config->adminignitiononly==0) {		// all users are allowed to prune messages,
		uddeIMpruneMessages($myself, $item_id, $my_gid, 'inbox', $config);	// when all users can prune then gid is not really neccessary
	}

	if	($config->fileadminignitiononly==1) {		// admin only
		if (uddeIMisAdmin($my_gid) || uddeIMisAdmin2($my_gid, $config))				// call pruneMsgs, when it is an admin or superadmin
			uddeIMpruneFiles($myself, $item_id, $my_gid, 'inbox', $config);
	} elseif ($config->fileadminignitiononly==0) {	// all users are allowed to prune messages,
		uddeIMpruneFiles($myself, $item_id, $my_gid, 'inbox', $config);	// when all users can prune then gid is not really neccessary
	}

	// set the remindersent to now, because looking into inbox counts as remindersent
	uddeIMupdateEMNreminder($myself, uddetime($config->timezone));

	// message limit for inbox?
	if ($config->inboxlimit && $config->allowarchive) {
		$universeflag = _UDDEIM_ARC_UNIVERSE_BOTH;	// inbox and archive
	} else {
		$universeflag = _UDDEIM_ARC_UNIVERSE_INBOX;	// inbox
	}

	// how many messages total in inbox?
	$totalinbox = uddeIMgetInboxCount($myself, $filter_user, $filter_unread, $filter_flagged);	// also used for navigation

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

	// now load messages as required
	if(!$limitstart)
		$limitstart = 0;

	if(!$limit)
		$limit=$config->perpage;

	if ($limitstart>=$totalinbox)
		$limitstart=max(0,$limitstart - $limit);

	$allmessages = uddeIMselectInbox($myself, $limitstart, $limit, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);

	// write the uddeim menu
	uddeIMprintMenu($myself, 'inbox', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	if ($config->enablefilter==1 || $config->enablefilter==3)
		uddeIMprintFilter($myself, 'inbox', $totalinbox, $item_id, $config, $filter_user, $filter_unread, $filter_flagged);

//	if ($limitreached) {		// BUGBUG, not required, planned for level meter
//		echo "<div id='uddeim-toplines'><p>".$limitreached."</p></div>\n";
//	}

	// if no messages:
	if (count($allmessages)<1) { // no messages to list
		uddeIMshowNoMessage('inbox', $filter_user, $filter_unread, $filter_flagged);
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

	uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");

	echo "<form method='post' name='messages' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inboxfork&Itemid=".$item_id)."'>\n";
	// now open the inbox container and table; write table headings
	echo "<div id='uddeim-overview'><table cellpadding='7' width='100%'>\n";
	// checkcell
	$delall="<input type=\"checkbox\" name=\"arcmes[]\" value=\"\" onclick=\"wiglwogl(this);\" title=\""._UDDEIM_CHECKALL."\" />";
	echo "<tr><th style='text-align:center;' class='sectiontableheader'>".$delall."</th><th class='sectiontableheader'>&nbsp;</th><th class='sectiontableheader'>"._UDDEIM_FROM.$sort_name."</th><th class='sectiontableheader'>"._UDDEIM_MESSAGE."</th><th class='sectiontableheader'>"._UDDEIM_DATE.$sort_datum."</th><th class='sectiontableheader'>&nbsp;</th></tr>\n";

	$i = 1;
	// now write the list
	foreach($allmessages as $themessage) {

		$fromname = uddeIMevaluateUsername($themessage->fromname, $themessage->fromid, $themessage->publicname);

		$personalsys = 0;
		if($themessage->systemflag && $themessage->systemmessage == $fromname)			// || $themessage->toid==$myself) {	dann wird auch ein Bild bei "Copy2me" angezeigt.
			$personalsys = 1;

		if($themessage->systemflag)
			$fromname = $themessage->systemmessage;

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
				$flagcell="<br /><br /><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=unflag&Itemid=".$item_id."&messageid=".$themessage->id."&limit=".$limit."&limitstart=".$limitstart)."'>".$uddeicons_flagged."</a>";
			else
				$flagcell="<br /><br /><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=flag&Itemid=".$item_id."&messageid=".$themessage->id."&limit=".$limit."&limitstart=".$limitstart)."'>".$uddeicons_unflagged."</a>";
		}

		if($themessage->toread)
			$readcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=markunread&Itemid=".$item_id."&messageid=".$themessage->id."&limit=".$limit."&limitstart=".$limitstart)."'>".$uddeicons_readpic."</a>";
		else
			$readcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=markread&Itemid=".$item_id."&messageid=".$themessage->id."&limit=".$limit."&limitstart=".$limitstart)."'>".$uddeicons_unreadpic."</a>";

		if ($config->showlistattachment) {
			$cnt = uddeIMgetAttachmentCount($themessage->id);
			if ($cnt)
				$readcell .= "<br /><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/attachment.gif' alt='"._UDDEIM_ATTACHMENT."' title='"._UDDEIM_ATTACHMENT."' border='0' />";
		}

		// CRYPT
		$cm = uddeIMgetMessage($themessage->message, $cryptpass, $themessage->cryptmode, $themessage->crypthash, $config->cryptkey);

		$teasermessage=$cm;
		// if it is a system message or bb codes allowed, parse BB codes
		if ($themessage->systemflag || $config->allowbb)
			$teasermessage=uddeIMbbcode_strip($teasermessage);

		$teasermessage=uddeIMteaser(stripslashes($teasermessage), $config->firstwordsinbox, $config->quotedivider, $config->languagecharset);
		$teasermessage=htmlspecialchars($teasermessage, ENT_QUOTES, $config->charset);
		$teasermessage=str_replace("&amp;#", "&#", $teasermessage);
		$teasermessage=str_replace("&amp;&lt;/br&gt;", " ", $teasermessage);

		$safemessage=htmlspecialchars(stripslashes($cm), ENT_QUOTES, $config->charset);
		$safemessage=str_replace("&amp;#", "&#", $safemessage);
		$safemessage=str_replace("&amp;&lt;/br&gt;", "</br>", $safemessage);

		if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
			$messagecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>".$teasermessage."</a>";
		} else {							// normal message
			$messagecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$themessage->id)."'>".$teasermessage."</a>";
		}
		$datumcell=uddeDate($themessage->datum, $config, uddeIMgetUserTZ());

		$archivecell="";
		$fwdcell="";
		if ($config->actionicons) {
			$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=delete&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' /></a>";
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
			$deletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=delete&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'>"._UDDEIM_DELETELINK."</a>";
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

		// checkcell
		$delcell="<input type='checkbox' name='arcmes[]' value='".$themessage->id."' />";

		echo "<tr class='sectiontableentry".$i."'>";
		echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$delcell."</td>";		// checkcell
		echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$readcell.$flagcell."</td>";
		$st=uddeIMgetStyleForThumb($config);
		echo "<td ".$st.">".$fromcell."</td>";
		echo "<td>".$messagecell."</td>";
		echo "<td>".$datumcell."</td>";
		if ($config->actionicons) {
			echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$fwdcell.$archivecell.$deletecell."</td>";
		} else {
			echo "<td class='pathway'>".$fwdcell.$archivecell.$deletecell."</td>";
		}
		echo "</tr>\n";

		$i++;
		if ($i>2) {
			$i=1;
		}
	}

	$muldel = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=muldelete&Itemid=".$item_id."&limitstart=0&limit=".$limit);
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
	$pageNav = new uddeIMmosPageNav($totalinbox, $limitstart, $limit);
	$referlink = "index.php?option=com_uddeim&task=inbox&Itemid=".$item_id.$addlink.$addlink2;
	if ($totalinbox>$limit) {
		$shownav = $pageNav->writePagesLinks($referlink);
		$shownav = uddeIMarrowReplace($shownav, $config->templatedir);
		echo "<div id='uddeim-pagenav'>".$shownav."<br />";
		echo "[<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id."&limitstart=0&limit=".$totalinbox.$addlink.$addlink2)."'>"._UDDEIM_SHOWALL."</a>]";
		echo "</div>\n";
	} else {
		echo "<div id='uddeim-pagenav'></div>\n";
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
		uddeIMprintFilter($myself, 'inbox', $totalinbox, $item_id, $config, $filter_user, $filter_unread, $filter_flagged);

	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', $limitreached, $config)."</div>\n";
//	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', $showinboxlimit_borderbottom, $config)."</div>\n";
}

// *****************************************************************************************

function uddeIMshowMessage($myself, $item_id, $messageid, $isforward, $cryptpass, $config) {
	global $uddeicons_onlinepic, $uddeicons_offlinepic, $uddeicons_readpic, $uddeicons_unreadpic;

	$my_gid = $config->usergid;

	$displaymessages = uddeIMselectInboxMessage($myself, $messageid, $config, 0);

	if (count($displaymessages)<1) {
		echo _UDDEIM_MESSAGENOACCESS;
		return;
	}

	// write the uddeim menu
	uddeIMprintMenu($myself, 'showMessage', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	foreach($displaymessages as $displaymessage) {

		$is_spam = 0;
		if ($config->reportspam)		// save one database query if possible
			$is_spam = uddeIMgetSpamStatus($messageid);

		$fromname = uddeIMevaluateUsername($displaymessage->fromname, $displaymessage->fromid, $displaymessage->publicname);
		if ($displaymessage->systemflag)
			$fromname = $displaymessage->systemmessage;

		$personalsys = 0;
		if ($displaymessage->systemflag && $displaymessage->systemmessage==$displaymessage->fromname)
			$personalsys = 1;

		// CRYPT
		$cm = uddeIMgetMessage($displaymessage->message, $cryptpass, $displaymessage->cryptmode, $displaymessage->crypthash, $config->cryptkey);

		// echo str_replace("&amp;#", "&#", nl2br(htmlspecialchars(stripslashes($cm), ENT_QUOTES, $config->charset)));
		$dmessage = nl2br(htmlspecialchars(stripslashes($cm), ENT_QUOTES, $config->charset));
		$dmessage = str_replace("&amp;#", "&#", $dmessage);		// unicode workaround
		$dmessage = str_replace("&amp;&lt;/br&gt;", "</br>", $dmessage);
		
		// if system message or bbcodes allowed, call parser
		if ($displaymessage->systemflag || $config->allowbb)
			$dmessage = uddeIMbbcode_replace($dmessage, $config);
		if ($config->allowsmile)
			$dmessage = uddeIMsmile_replace($dmessage, $config);
		$bodystring = $dmessage;			// converted message for email body

		$replytomessage = "";
		if ($config->replytext)
			$replytomessage = uddeIMreplySuggestion($cm, $displaymessage, $fromname, "", $isforward, "inbox", $config);
		// We used an placeholder above to insert the "reply suggestion" for the "mailto:" link
		$urlbody = rawurlencode($replytomessage);

		// display the message
		$headerstring="<table class='innermost'><tr>";

		// does CB have a thumbnail image of the sender?
		if ($config->showcbpic && $displaymessage->fromname || $config->gravatar) {
			$frompic = uddeIMgetPicOnly($displaymessage->fromid, $config);
			if ($frompic && ($personalsys || !$displaymessage->systemflag))
				$headerstring.="<td valign='top' rowspan='2'>".$frompic."</td>\n";
		}

		$headerstring.="<td valign='top' width='99%'><div class='uddeim-messagefrom'>";
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
			if (!$displaymessage->systemflag || $personalsys) {
				$temp = uddeIMgetLinkOnly($displaymessage->fromid, $fromname, $config);
			}
		}
		// display email address
		if ($displaymessage->fromname==NULL && !$displaymessage->fromid && $displaymessage->publicemail!=NULL)
			$temp .= " &lt;<a href='mailto:".$displaymessage->publicemail."?body=".$urlbody."'>".$displaymessage->publicemail."</a>&gt;";
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

		$headerstring.="<br />";
		$headerstring.=uddeLdate($displaymessage->datum, $config, uddeIMgetUserTZ());
		$headerstring.="</div></td><td valign='top'><span class='uddeim-clear'>&nbsp;</span><ul>";

		// show delete & block links
		if ($config->allowforwards) {
			if ($displaymessage->cryptmode==2 || $displaymessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
			   $headerstring.="<li class='uddeim-messageactionlink-forward'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardpass&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_FORWARDLINK."</a></li>\n";
			} else {	// normal message
			   $headerstring.="<li class='uddeim-messageactionlink-forward'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forward&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_FORWARDLINK."</a></li>\n";
			}
		}
		if (!$displaymessage->archived && $config->allowarchive)
			$headerstring.="<li class='uddeim-messageactionlink-archive'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=archivemessage&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_STORE."</a></li>\n";
		if ( $displaymessage->archived && $config->allowarchive)
			$headerstring.="<li class='uddeim-messageactionlink-archive'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=unarchive&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_UNARCHIVE."</a></li>\n";
		if (!$displaymessage->totrash) { // but only if not already moved to trash
			$headerstring.="<li class='uddeim-messageactionlink-delete'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=delete&Itemid=".$item_id."&ret=top&messageid=".$displaymessage->id)."'>"._UDDEIM_DELETELINK."</a></li>\n";
			if ($config->blocksystem && !$displaymessage->systemflag && $displaymessage->fromid) {
				$headerstring.="<li class='uddeim-messageactionlink-block'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=blockuser&Itemid=".$item_id."&recip=".$displaymessage->fromid)."'>"._UDDEIM_BLOCKNOW."</a></li>\n";
			}
		}

		if ($config->reportspam) {		// uddeIMcheckPlugin('spamcontrol') &&  not required since uddeIMcheckConfig sets this 0 if plugin is missing
			if ($is_spam)
				$headerstring.="<br /><li class='uddeim-messageactionlink-spam'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=unreportspam&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_SPAMCONTROL_UNREPORT."</a></li>";
			else
				$headerstring.="<br /><li class='uddeim-messageactionlink-spam'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=reportspam&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_SPAMCONTROL_REPORT."</a></li>";
		}

		$headerstring.="</ul>";
		$headerstring.="</td>";
		$headerstring.="</tr>";

		$msgnavigation = "&nbsp;";
		if ($config->enablereply) {
			$msgnavigation = "";
			$pathtosite = uddeIMgetPath('live_site');
			$pic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/envelope.gif' alt='"._UDDEIM_PMNAV_EXISTS."' title='"._UDDEIM_PMNAV_EXISTS."' />";
			$picdel = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/envelope_deleted.gif' alt='"._UDDEIM_PMNAV_DELETED."' title='"._UDDEIM_PMNAV_DELETED."' />";

			$replyid = $displaymessage->replyid;
			if ($replyid) {
				$msgnavigation .= _UDDEIM_PMNAV_THISISARESPONSE;
				$copy2me = ($displaymessage->toid==$displaymessage->fromid && $displaymessage->fromid==$myself);

				if ($copy2me) // this is a copy2me message, so the original is also stored in inbox
					$orig = uddeIMselectInboxMessage($myself, $replyid, $config, 0);
				else
					$orig = uddeIMselectOutboxMessage($myself, $replyid, $config, 0);
				$temp = Array();
				foreach($orig as $or)
					$temp = $or;
				$orig = $temp;

				if (count($orig)>0) {		// the message should be stored in the outbox
					$goto = "showout";
					$c2me = "";
					if ($copy2me) // this is a copy2me message, so the original is also stored in inbox
						$goto = "show";
					if ($orig->cryptmode==2 || $orig->cryptmode==4) {	// Message is encrypted, so go to enter password page
						$msgnavigation .= " <a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=".$goto."pass&Itemid=".$item_id."&messageid=".$replyid)."'>".$pic."</a>";
					} else {					// normal message
						$msgnavigation .= " <a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=".$goto."&Itemid=".$item_id."&messageid=".$replyid)."'>".$pic."</a>";
					}
				} else {
					$msgnavigation .= " ".$picdel;
				}
			}

			$repls = uddeIMselectMessageReplies($displaymessage->id, 'outbox', $myself);
			if (count($repls)>0) {
				$msgnavigation .= "<br />";
				$msgnavigation .= _UDDEIM_PMNAV_THEREARERESPONSES;
				foreach($repls as $repl) {
					$goto = "showout";
					$c2me = "";
					if ($repl->toid==$repl->fromid)	{	// copy2me are stored in the inbox
						$goto = "show";
						$c2me = " "._UDDEIM_PMNAV_COPY2ME;		// BUGBUG
					}
					if ($repl->cryptmode==2 || $repl->cryptmode==4) {	// Message is encrypted, so go to enter password page
						$msgnavigation .= " <a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=".$goto."pass&Itemid=".$item_id."&messageid=".$repl->id)."'>".$pic."</a>".$c2me;
					} else {					// normal message
						$msgnavigation .= " <a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=".$goto."&Itemid=".$item_id."&messageid=".$repl->id)."'>".$pic."</a>".$c2me;
					}
					$msgnavigation .= " ";
				}
			}
		}

		$headerstring.="<tr>";
		$headerstring.="<td valign='bottom'><div class='uddeim-messagefrom'>".trim($msgnavigation)."</div></td>";

		$headerstring.="<td valign='bottom'>";
		if ($config->reportspam) {		// uddeIMcheckPlugin('spamcontrol') &&  not required since uddeIMcheckConfig sets this 0 if plugin is missing
			if ($is_spam)
				$headerstring.="<div class='uddeim-messagefrom-spam'>"._UDDEIM_SPAMCONTROL_MARKED."</div>";
		}
		$headerstring.="</td>";

		$headerstring.="</tr>";
		$headerstring.="</table>";

		// output the message

		if (!$isforward) {
			echo "<div class='uddeim-messageheader'>".$headerstring."</div>";
			echo "<div class='uddeim-messagebody'>".uddeIMreplyquoteMarkup($bodystring,$config->quotedivider)."</div>";
			// UDDEIMFILE
			if( $config->enableattachment )	// Always show attachments when attachments are enabled
				uddeIMshowAttachments("inbox", $item_id, $displaymessage->id, $config);
		}

		$trashmessage = $displaymessage->totrash;
		$to_id 		  = $displaymessage->fromid;
		$replytoid 	  = $displaymessage->id;
		$disablereply = $displaymessage->disablereply;
		
		// now check, if we can send a reply
		if (!$config->pubreplies) {				// we do not allow replies to public users, so check if it is a public user
			if ( uddeIMisPublicUser($displaymessage->fromname,$displaymessage->fromid) )	// it is $displaymessage->fromname which specifies if it is a public user or not
				$disablereply = 1;
		} else {								// we allow replies to public users, so check if it is a public user...
			if ( uddeIMisPublicUser($displaymessage->fromname,$displaymessage->fromid) && 
							(!$displaymessage->publicemail || $displaymessage->publicemail==NULL))
				$disablereply = 1;				// ..its a public user and there is no email address given, we could send a reply to
		}
		if ( uddeIMisDeletedUser($displaymessage->fromname,$displaymessage->fromid) )
			$disablereply = 1;					// ..its a deleted user so disable replies
		if ($displaymessage->archived)
			$disablereply = 1;					// ..no reply to archived messages

		if ($displaymessage->fromid==$myself &&
		    $displaymessage->fromid==$displaymessage->toid)
			$disablereply = 1;					// ...no reply to copy2me messages
	}

	// read flag set to true, but only when its a forward
	if (!$isforward)
		uddeIMupdateToread($myself, $displaymessage->id, 1);

	if ($config->inboxlimit) {				// there is a limit for inbox + archive
		if ($config->allowarchive) {		// have an archive and an "archive and inbox" limit, so get number of messages in inbox and archive
			$universeflag = _UDDEIM_ARC_UNIVERSE_BOTH;	// inbox and archive
			$total = uddeIMgetInboxArchiveCount($myself);
		} else {							// user has switched of archive but there is an limit for "inbox and archive", so count inbox messages only
			$universeflag = _UDDEIM_ARC_UNIVERSE_INBOX;	// inbox
			$total = uddeIMgetInboxCount($myself);
		}
	
		// "You have XX messages in your inbox/inbox+archive."
		$limitreached = _UDDEIM_INBOX_LIMIT_1." ".$total;
		$limitreached.= " ".($total==1 ? _UDDEIM_INBOX_LIMIT_2_SINGULAR : _UDDEIM_INBOX_LIMIT_2)." ";
		$limitreached.= $universeflag;

		if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config) && (!$disablereply || ($isforward && $config->allowforwards))) {		// so the warning is only displayed when a forward or reply is possible
			// "The allowed maximum is XX."
			// $limitreached.= _UDDEIM_INBOX_LIMIT_3." ".$config->maxarchive.". ";
			$limitreached.= " "._UDDEIM_SHOWINBOXLIMIT_2." ".$config->maxarchive.").";	// (of max. )

			if ($total > $config->maxarchive) {
				// "You have XX messages in your inbox/inbox+archive."
				$limitreached = _UDDEIM_INBOX_LIMIT_1." ".$total;
				$limitreached.= " ".($total==1 ? _UDDEIM_INBOX_LIMIT_2_SINGULAR : _UDDEIM_INBOX_LIMIT_2)." ";
				$limitreached.= $universeflag;
				// You can still receive and read messages but you will not be able to reply or to compose new ones until you delete messages.
				$limitwarning = _UDDEIM_INBOX_LIMIT_4;

				$showinboxlimit_borderbottom = "<span class='uddeim-warning'>";
				$showinboxlimit_borderbottom.= $limitreached." ";
				$showinboxlimit_borderbottom.= $limitwarning;
				$showinboxlimit_borderbottom.= "</span>";
				echo "<div id='uddeim-bottomlines'>".$showinboxlimit_borderbottom."</div>";
				// close main container
				echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', $limitreached, $config)."</div>\n";
				return;
			}
		}
	}

	

	if (($isforward && $config->allowforwards) || !$disablereply) {	// it is a forward or you can reply to the message
		// show reply form
		if(!$trashmessage) { // but only if not already moved to trash
			// echo "<div id='uddeim-writeform'><b>"._UDDEIM_REPLY."</b><br />";
			// which page did refer to this "show Message" page? we want to send back the user where he came from
			$tbackto = uddeIMmosGetParam($_SERVER, 'HTTP_REFERER', null);
			if(stristr($tbackto, "com_uddeim")) {
				$tbackto="";
			}
			if ($isforward && $config->allowforwards) {		// it is a forward, so allow selecting a recipient
				uddeIMdrawWriteform($myself, $my_gid, $item_id, $tbackto, "", $replytomessage, 0, 0, 0, 0, $config);
			} else {										// it is a reply, so reply to $to_id {
				uddeIMdrawWriteform($myself, $my_gid, $item_id, $tbackto, $to_id, $replytomessage, $replytoid, 1, 0, 0, $config); // isreply, errorcode, sysmsg
			}
		} else {
			// offer restore link
			echo "<div id='uddeim-bottomlines'>"._UDDEIM_YOUMOVEDTOTRASH;
			echo "<br />";
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=restore&Itemid=".$item_id."&messageid=".$replytoid)."'>"._UDDEIM_RESTORE."</a></div>\n";
		}
	} else {
		// don't allow replies ($disablereply)
		if ($displaymessage->archived)
			echo "<div id='uddeim-bottomlines'>"._UDDEIM_CANTREPLYARCHIVE."</div>\n";
		else
			echo "<div id='uddeim-bottomlines'>"._UDDEIM_CANTREPLY."</div>\n";
	}
	// close container
	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

function uddeIMshowPass($myself, $item_id, $messageid, $config) {
	uddeIMprintMenu($myself, 'showPass', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	echo "<div id='uddeim-overview'><p><b>"._UDDEIM_PASSWORD."</b></p>";
	echo "<form name='showform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$messageid)."'>";
	echo _UDDEIM_PASSWORDBOX.": ";
	echo "<input name='cryptpass' value='' />"._UDDEIM_DECRYPTIONTEXT."<br /><br />";
	echo "<input type='submit' name='sendpass' class='button' value='"._UDDEIM_SUBMIT."' />";
	echo "</form>";
	echo "</div>\n";

	echo "</div>\n";
	echo "<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

function uddeIMforwardPass($myself, $item_id, $messageid, $config) {
	uddeIMprintMenu($myself, 'forwardPass', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	echo "<div id='uddeim-overview'><p><b>"._UDDEIM_PASSWORD."</b></p>";
	echo "<form name='showform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forward&Itemid=".$item_id."&messageid=".$messageid)."'>";
	echo _UDDEIM_PASSWORDBOX.": ";
	echo "<input name='cryptpass' value='' />"._UDDEIM_DECRYPTIONTEXT."<br /><br />";
	echo "<input type='submit' name='sendpass' class='button' value='"._UDDEIM_SUBMIT."' />";
	echo "</form>";
	echo "</div>\n";

	echo "</div>\n";
	echo "<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

// *****************************************************************************************

function uddeIMdeleteMessageInbox($myself, $messageid, $limit, $limitstart, $item_id, $ret, $config) {
	// Delete sets trash flag to true (it does not erase the message from the db, this is only done by PRUNING the messages. So messages deleted from the inbox will be moved to the trash can of the respective user
	$deletetime=uddetime($config->timezone);
	// uddeIMupdateToread($myself, $messageid, 1);
	uddeIMdeleteMessageFromInbox($myself, $messageid, $deletetime);
	
	if ($ret=='archive' && $config->allowarchive) {
		uddeJSEFredirect("index.php?option=com_uddeim&task=archive&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
	} elseif ($ret=='top') {
		uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id);
	} else {
		uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
	}
}

function uddeIMdeleteInbox($myself, $item_id, $arcmes, $limit, $limitstart, $config) {
	$n = count($arcmes);
	if (!$n) {
		echo _UDDEIM_NOMSGSELECTED."<br /><a href='javascript:history.go(-1)'>"._UDDEIM_BACK."</a>";
		return;
	}
	for ($i = 0; $i <= ($n-1); $i++) {
		$rightnow=uddetime($config->timezone);
		if ($arcmes[$i]>0) {
			// uddeIMupdateToread($myself, $arcmes[$i], 1);
			uddeIMdeleteMessageFromInbox($myself, $arcmes[$i], $rightnow);
			// when it is a message from me to me and I trash the message then also trash the message from the outbox
//			$sql="UPDATE `#__uddeim` SET totrashoutbox=1, totrashdateoutbox=".$rightnow." WHERE toid=fromid AND toid=".(int)$myself." AND id=".(int)$arcmes[$i];
//			$___atabase->setQuery($sql);
//			if (!$___atabase->query()) {
//				die("SQL error when attempting to trash a message" . $___atabase->stderr(true));
//			}
		}
	}
	uddeJSEFredirect("index.php?option=com_uddeim&task=inbox&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
}

