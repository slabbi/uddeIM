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

function uddeIMshowOutbox($myself, $item_id, $limit, $limitstart, $cryptpass, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode) {
	global $uddeicons_onlinepic, $uddeicons_offlinepic, $uddeicons_readpic, $uddeicons_unreadpic, $uddeicons_delayedpic;
	
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
		$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=outbox&sort_mode=0&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
		$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=outbox&sort_mode=2&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
		switch($sort_mode) {
			case 0: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_down.gif' alt='"._UDDEIM_UP."' title='"._UDDEIM_UP."' border='0' />";
					$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=outbox&sort_mode=1&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 1: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_up.gif' alt='"._UDDEIM_DOWN."' title='"._UDDEIM_DOWN."' border='0' />";
					$sort_datum = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=outbox&sort_mode=0&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 2: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_down.gif' alt='"._UDDEIM_UP."' title='"._UDDEIM_UP."' border='0' />";
					$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=outbox&sort_mode=3&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
			case 3: $temppic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/icon_up.gif' alt='"._UDDEIM_DOWN."' title='"._UDDEIM_DOWN."' border='0' />";
					$sort_name  = "&nbsp;<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=outbox&sort_mode=2&Itemid=".$item_id.$addlink)."'>". $temppic ."</a>";
					break;
		}
	}

	// how many messages total?
	$total = uddeIMgetOutboxCount($myself, $filter_user, $filter_unread, $filter_flagged);

	// now load messages as required
	if(!$limitstart)
		$limitstart=0;

	if(!$limit)
		$limit=$config->perpage;
		
	if ($limitstart>=$total)
		$limitstart=max(0,$limitstart - $limit);

	$allmessages = uddeIMselectOutbox($myself, $limitstart, $limit, $config, $filter_user, $filter_unread, $filter_flagged, $sort_mode);

	// write the uddeim menu
	uddeIMprintMenu($myself, 'outbox', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	if ($config->enablefilter==1 || $config->enablefilter==3)
		uddeIMprintFilter($myself, 'outbox', $total, $item_id, $config, $filter_user, $filter_unread, $filter_flagged);

	// if no messages:
	if(count($allmessages)<1) { // no messages to list
		uddeIMshowNoMessage('outbox', $filter_user, $filter_unread, $filter_flagged);
		echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
		return;
	}

	uddeIMaddScript($pathtosite."/components/com_uddeim/js/uddeimtools.js");

	echo "<form method='post' name='messages' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=outboxfork&Itemid=".$item_id)."'>";
	// now open the inbox container and table; write table headings
	echo "<div id='uddeim-overview'><table cellpadding='7' width='100%'>\n";
	// checkcell
	$delall="<input type='checkbox' name='arcmes[]' value='' onclick='wiglwogl(this);' title='"._UDDEIM_CHECKALL."' />";
	echo "<tr><th style='text-align:center;' class='sectiontableheader'>".$delall."</th><th class='sectiontableheader'>&nbsp;</th><th class='sectiontableheader'>"._UDDEIM_TO.$sort_name."</th><th class='sectiontableheader'>"._UDDEIM_MESSAGE."</th><th class='sectiontableheader'>"._UDDEIM_DATE.$sort_datum."</th><th class='sectiontableheader'>&nbsp;</th></tr>\n";

	$i = 1;
	// now write the list
	foreach($allmessages as $themessage) {

		$toname = uddeIMevaluateUsername($themessage->toname, $themessage->toid, $themessage->publicname);

		// show links ???
		$tocell = $toname;
		if ($config->showcblink && $themessage->toname) {
			$tocell = uddeIMshowThumbOrLink($themessage->toid, $toname, $config);
		}

		// is this user currently online?
		if ($config->showonline && $themessage->toname) {
			$isonline = uddeIMisOnline($themessage->toid);
			if($isonline)
				$tocell.="&nbsp;".$uddeicons_onlinepic;
			else
				$tocell.="&nbsp;".$uddeicons_offlinepic;
		}

		if ($themessage->delayed) {
			$readcell=$uddeicons_delayedpic;
		} else {
			if ($themessage->toread)
				$readcell=$uddeicons_readpic;
			else
				$readcell=$uddeicons_unreadpic;
		}
		
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
		$safemessage=str_replace("&amp;&lt;/br&gt;", "</br>", $safemessage);

		if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
			$messagecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showoutpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>".$teasermessage."</a>";
		} else {	// normal message
			$messagecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showout&Itemid=".$item_id."&messageid=".$themessage->id)."'>".$teasermessage."</a>";
		}
		$datumcell=uddeDate($themessage->datum, $config, uddeIMgetUserTZ());

		$fwdcell="";
		if ($config->actionicons) {
			if ($config->allowforwards) {
				if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
 				    $fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutboxpass&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' /></a><br />";
				} else {	// normal message
 				    $fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutbox&Itemid=".$item_id."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/forward.gif' alt='"._UDDEIM_FORWARDLINK."' title='"._UDDEIM_FORWARDLINK."' /></a><br />";
				}
			}
			$sbsdeletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=deletefromoutbox&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'><img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/trash.gif' alt='"._UDDEIM_DELETELINK."' title='"._UDDEIM_DELETELINK."' /></a>";
		} else {
			if ($config->allowforwards) {
				if ($themessage->cryptmode==2 || $themessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
					$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutboxpass&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_FORWARDLINK."</a><br />";
				} else {	// normal message
					$fwdcell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutbox&Itemid=".$item_id."&messageid=".$themessage->id)."'>"._UDDEIM_FORWARDLINK."</a><br />";
				}
			}
			$sbsdeletecell="<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=deletefromoutbox&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart."&messageid=".$themessage->id)."'>"._UDDEIM_DELETELINK."</a>";
		}

		// checkcell
		$delcell="<input type='checkbox' name='arcmes[]' value='".$themessage->id."' />";

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
		} else {
			$recallcell="";
		}

		echo "<tr class='sectiontableentry".$i."'>";
		// checkcell
		echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$delcell."</td>";

		echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$readcell."</td>";
		$st=uddeIMgetStyleForThumb($config);
		echo "<td ".$st.">".$tocell."</td>";
		echo "<td>".$messagecell."</td>";
		echo "<td>".$datumcell."</td>";
		if($config->actionicons) {
			echo "<td style='width:32px; text-align:center; vertical-align:middle'>".$fwdcell.$recallcell.$sbsdeletecell."</td>";
		} else {
			echo "<td class='pathway'>".$fwdcell.$recallcell.$sbsdeletecell."</td>";
		}
		echo "</tr>\n";

		$i++;
		if ($i>2) {
			$i=1;
		}
	}

	$muldel = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=outboxmuldelete&Itemid=".$item_id."&limitstart=0&limit=".$limit);
	if ($config->bottomlineicons) {
		echo "<tr><th style='text-align:center;' class='sectiontablefooter'>";
		echo '<a href="#" onclick="outboxDelete(\''.$muldel.'\'); return false;"><img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/images/trash.gif" alt="'._UDDEIM_TRASHCHECKED.'" title="'._UDDEIM_TRASHCHECKED.'" /></a>';
		echo "</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th><th class='sectiontablefooter'>&nbsp;</th></tr>\n";
	}

	// now close inbox table and container
	echo "</table></div>\n";
	echo "</form>\n";

	// write the inbox navigation links
	$pageNav = new uddeIMmosPageNav($total, $limitstart, $limit);
	$referlink = "index.php?option=com_uddeim&task=outbox&Itemid=".$item_id.$addlink.$addlink2;
	if($total>$limit) {
		$shownav = $pageNav->writePagesLinks($referlink);
		$shownav = uddeIMarrowReplace($shownav, $config->templatedir);
		echo "<div id='uddeim-pagenav'>".$shownav."<br />";
		echo "[<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=outbox&Itemid=".$item_id."&limitstart=0&limit=".$total.$addlink.$addlink2)."'>"._UDDEIM_SHOWALL."</a>]";
		echo "</div>\n";
	}

	echo "<div id='uddeim-bottomlines'>";

	if (!$config->bottomlineicons)
		echo '<p><a href="#" onclick="outboxDelete(\''.$muldel.'\'); return false;">'._UDDEIM_TRASHCHECKED.'</a></p>';

	// outbox warning
	$keephours=($config->SentMessagesLifespan) * 1;  // this are days
	echo "<p>"._UDDEIM_OUTBOX_WARNING."</p>";
	if ($config->SentMessagesLifespanNote)
		echo "<p>"._UDDEIM_SENT_INFO_1.$keephours._UDDEIM_SENT_INFO_2."</p>";

	echo "</div>\n";

	if ($config->enablefilter==2 || $config->enablefilter==3)
		uddeIMprintFilter($myself, 'outbox', $total, $item_id, $config, $filter_user, $filter_unread, $filter_flagged);

	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

// *****************************************************************************************

function uddeIMshowOutmessage($myself, $item_id, $messageid, $isforward, $cryptpass, $config) {
	global $uddeicons_onlinepic, $uddeicons_offlinepic, $uddeicons_readpic, $uddeicons_unreadpic;

	$my_gid = $config->usergid;

	$displaymessages = uddeIMselectOutboxMessage($myself, $messageid, $config, 0);

	if(count($displaymessages)<1) {
		echo _UDDEIM_MESSAGENOACCESS;
		return;
	}

	// write the uddeim menu
	uddeIMprintMenu($myself, 'showOutmessage', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	foreach($displaymessages as $displaymessage) {

		$msgread=$displaymessage->toread;

		$toname = uddeIMevaluateUsername($displaymessage->toname, $displaymessage->toid, $displaymessage->publicname);

		// CRYPT
		$cm = uddeIMgetMessage($displaymessage->message, $cryptpass, $displaymessage->cryptmode, $displaymessage->crypthash, $config->cryptkey);

		// echo str_replace("&amp;#", "&#", nl2br(htmlspecialchars(stripslashes($cm), ENT_QUOTES, $config->charset)));
		$dmessage = nl2br(htmlspecialchars(stripslashes($cm), ENT_QUOTES, $config->charset));
		$dmessage = str_replace("&amp;#", "&#", $dmessage); // unicode workaround
		$dmessage = str_replace("&amp;&lt;/br&gt;", "</br>", $dmessage);

		// if system message or bbcodes allowed, call parser
		if ($displaymessage->systemflag || $config->allowbb)
			$dmessage=uddeIMbbcode_replace($dmessage, $config);
		if ($config->allowsmile)
			$dmessage=uddeIMsmile_replace($dmessage, $config);
		$bodystring=$dmessage;
		
		$replytomessage = uddeIMreplySuggestion($cm, $displaymessage, "", $toname, $isforward, "outbox", $config);
		// We used an placeholder above to insert the "reply suggestion" for the "mailto:" link
		$urlbody = rawurlencode($replytomessage);

		// display the message
		$headerstring="<table class='innermost'><tr>";

		// does CB have a thumbnail image of the receiver?
		if ($config->showcbpic && $displaymessage->toname || $config->gravatar) {
			$topic = uddeIMgetPicOnly($displaymessage->toid, $config);
			if ($topic)
				$headerstring.="<td valign='top' rowspan='2'>".$topic."</td>\n";
		}

		$headerstring.="<td valign='top' width='99%'><div class='uddeim-messagefrom'>";
		$headerstring.=_UDDEIM_MESSAGETO;

		// show links ???
		$temp = $toname;
		if ($config->showcblink && $displaymessage->toname) {
			$temp = uddeIMgetLinkOnly($displaymessage->toid, $toname, $config);
		}
		// display email address
		if ($displaymessage->toname==NULL && !$displaymessage->toid && $displaymessage->publicemail!=NULL)
			$temp .= " &lt;<a href='mailto:".$displaymessage->publicemail."?body=".$urlbody."'>".$displaymessage->publicemail."</a>&gt;";
		$headerstring.=$temp;

		// is this user currently online?
		if ($config->showonline && $displaymessage->toname) {
			$isonline = uddeIMisOnline($displaymessage->toid);
			if($isonline)
				$headerstring.="&nbsp;".$uddeicons_onlinepic;
			else
				$headerstring.="&nbsp;".$uddeicons_offlinepic;
		}

		$headerstring.="<br />";
		$headerstring.=uddeLdate($displaymessage->datum, $config, uddeIMgetUserTZ());
		$headerstring.="</div></td><td valign='top' rowspan='2'><span class='uddeim-clear'>&nbsp;</span><ul>";

		// show delete links
		if ($config->allowforwards) {
			if ($displaymessage->cryptmode==2 || $displaymessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
			   $headerstring.="<li class='uddeim-messageactionlink-forward'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutboxpass&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_FORWARDLINK."</a></li>\n";
			} else {	// normal message
			   $headerstring.="<li class='uddeim-messageactionlink-forward'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutbox&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_FORWARDLINK."</a></li>\n";
			}
		}
		if (!$displaymessage->totrashoutbox) { // but only if not already moved to trash
			$headerstring.="<li class='uddeim-messageactionlink-delete'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=deletefromoutbox&Itemid=".$item_id."&ret=top&messageid=".$displaymessage->id)."'>"._UDDEIM_DELETELINK."</a></li>\n";
		}
		if (!$displaymessage->toread) {	// if not read then a recall is possible
			if ($displaymessage->cryptmode==2 || $displaymessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
			    $headerstring.="<li class='uddeim-messageactionlink-recall'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=recallpass&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_RECALL."</a></li>\n";
			} else {	// normal message
			    $headerstring.="<li class='uddeim-messageactionlink-recall'><a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=recall&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_RECALL."</a></li>\n";
			}
		}

		$headerstring.="</ul></td>";
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

				$orig = uddeIMselectInboxMessage($myself, $replyid, $config, 0);
				$temp = Array();
				foreach($orig as $or)
					$temp = $or;
				$orig = $temp;

				if (count($orig)>0) {		// the message should be stored in the outbox
					if ($orig->cryptmode==2 || $orig->cryptmode==4) {	// Message is encrypted, so go to enter password page
						$msgnavigation .= " <a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showpass&Itemid=".$item_id."&messageid=".$replyid)."'>".$pic."</a>";
					} else {					// normal message
						$msgnavigation .= " <a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$replyid)."'>".$pic."</a>";
					}
				} else {
					$msgnavigation .= " ".$picdel;
				}
			}

			$repls = uddeIMselectMessageReplies($displaymessage->id, 'inbox', $myself);
			if (count($repls)>0) {
				$msgnavigation .= "<br />";
				$msgnavigation .= _UDDEIM_PMNAV_THEREARERESPONSES;
				foreach($repls as $repl) {
					if ($repl->cryptmode==2 || $repl->cryptmode==4) {	// Message is encrypted, so go to enter password page
						$msgnavigation .= " <a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showpass&Itemid=".$item_id."&messageid=".$repl->id)."'>".$pic."</a>";
					} else {					// normal message
						$msgnavigation .= " <a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=show&Itemid=".$item_id."&messageid=".$repl->id)."'>".$pic."</a>";
					}
					$msgnavigation .= " ";
				}
			}
		}

		$headerstring.="<tr><td valign='bottom'><div class='uddeim-messagefrom'>".trim($msgnavigation)."</div></td></tr>";
		$headerstring.="</table>";

		if (!$isforward) {
			echo "<div class='uddeim-messageheader'>".$headerstring."</div>";
			echo "<div class='uddeim-messagebody'>".uddeIMreplyquoteMarkup($bodystring,$config->quotedivider)."</div>";

			// UDDEIMFILE
			if( $config->enableattachment )	// Always show attachments when attachments are enabled
				uddeIMshowAttachments("outbox", $item_id, $displaymessage->id, $config);
		}
	
		$trashmessage = $displaymessage->totrashoutbox;
	}
	
	if ($config->inboxlimit) {				// there is a limit for inbox + archive
		if ($config->allowarchive) {		// have an archive and an "archive and inbox" limit, so get number of messages in inbox and archive
			$universeflag = _UDDEIM_ARC_UNIVERSE_BOTH;	// inbox and archive
			$total = uddeIMgetInboxArchiveCount($myself);
		} else {							// user has switched off archive but there is an limit for "inbox", so count inbox messages only
			$universeflag = _UDDEIM_ARC_UNIVERSE_INBOX;	// inbox
			$total = uddeIMgetInboxCount($myself);
		}
	
		// "You have XX messages in your inbox/inbox+archive."
		$limitreached = _UDDEIM_INBOX_LIMIT_1." ".$total;
		$limitreached.= " ".($total==1 ? _UDDEIM_INBOX_LIMIT_2_SINGULAR : _UDDEIM_INBOX_LIMIT_2)." ";
		$limitreached.= $universeflag;

		if (!uddeIMisAdmin($my_gid) && !uddeIMisAdmin2($my_gid, $config) && ($isforward && $config->allowforwards)) {		// so the warning is only displayed when a forward is possible
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

	

	if ($isforward && $config->allowforwards) {	// it is a forward 
		// show reply form
		if(!$trashmessage) { // but only if not already moved to trash
			$tbackto = uddeIMmosGetParam($_SERVER, 'HTTP_REFERER', null);
			if(stristr($tbackto, "com_uddeim")) {
				$tbackto="";
			}
			uddeIMdrawWriteform($myself, $my_gid, $item_id, $tbackto, "", $replytomessage, 0, 0, 0, 0, $config);
		} else {
			// offer recycle link
			echo "<div id='uddeim-bottomlines'>"._UDDEIM_YOUMOVEDTOTRASH;
			echo "<br />";
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=restore&Itemid=".$item_id."&messageid=".$replytoid)."'>"._UDDEIM_RESTORE."</a></div>\n";
		}
	}
	
	// recall link if unread
	if (!$msgread) {
		echo "<div id='uddeim-bottomlines'>";
		if ($displaymessage->cryptmode==2 || $displaymessage->cryptmode==4) {	// Message is encrypted, so go to enter password page
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=recallpass&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_RECALLTHISMESSAGE."</a>";
		} else {								// normal message
			echo "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=recall&Itemid=".$item_id."&messageid=".$displaymessage->id)."'>"._UDDEIM_RECALLTHISMESSAGE."</a>";
		}
		echo "</div>\n";
	}
	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

function uddeIMshowOutPass($myself, $item_id, $messageid, $config) {
	uddeIMprintMenu($myself, 'showOutPass', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	echo "<div id='uddeim-overview'><p><b>"._UDDEIM_PASSWORD."</b></p>";
	echo "<form name='showoutform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=showout&Itemid=".$item_id."&messageid=".$messageid)."'>";
	echo _UDDEIM_PASSWORDBOX.": ";
	echo "<input name='cryptpass' value='' />"._UDDEIM_DECRYPTIONTEXT."<br /><br />";
	echo "<input type='submit' name='sendoutpass' class='button' value='"._UDDEIM_SUBMIT."' />";
	echo "</form>";
	echo "</div>\n";

	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

function uddeIMforwardOutPass($myself, $item_id, $messageid, $config) {
	uddeIMprintMenu($myself, 'forwardOutPass', $item_id, $config);
	echo "<div id='uddeim-m'>\n";

	echo "<div id='uddeim-overview'><p><b>"._UDDEIM_PASSWORD."</b></p>";
	echo "<form name='showform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=forwardoutbox&Itemid=".$item_id."&messageid=".$messageid)."'>";
	echo _UDDEIM_PASSWORDBOX.": ";
	echo "<input name='cryptpass' value='' />"._UDDEIM_DECRYPTIONTEXT."<br /><br />";
	echo "<input type='submit' name='sendpass' class='button' value='"._UDDEIM_SUBMIT."' />";
	echo "</form>";
	echo "</div>\n";

	echo "</div>\n";
	echo "<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

// *****************************************************************************************

function uddeIMdeleteMessageOutbox($myself, $messageid, $limit, $limitstart, $item_id, $ret, $config) {
	// Delete sets outbox trash flag to true (it does not erase the message from the db, this is only done by PRUNING the messages. So messages deleted from the inbox will be moved to the trash can of the respective user
	$deletetime=uddetime($config->timezone);
	uddeIMdeleteMessageFromOutbox($myself, $messageid, $deletetime);

	if ($ret=='archive' && $config->allowarchive) {
		uddeJSEFredirect("index.php?option=com_uddeim&task=archive&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
	} elseif ($ret=='top') {
		uddeJSEFredirect("index.php?option=com_uddeim&task=outbox&Itemid=".$item_id);
	} else {
		uddeJSEFredirect("index.php?option=com_uddeim&task=outbox&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
	}
}

function uddeIMdeleteOutbox($myself, $item_id, $arcmes, $limit, $limitstart, $config) {
	$n = count($arcmes);
	if (!$n) {
		echo _UDDEIM_NOMSGSELECTED."<br /><a href='javascript:history.go(-1)'>"._UDDEIM_BACK."</a>";
		return;
	}
	for ($i = 0; $i <= ($n-1); $i++) {
		$rightnow=uddetime($config->timezone);
		if($arcmes[$i]>0) {
			uddeIMdeleteMessageFromOutbox($myself, $arcmes[$i], $rightnow);
		}
	}
	uddeJSEFredirect("index.php?option=com_uddeim&task=outbox&Itemid=".$item_id."&limit=".$limit."&limitstart=".$limitstart);
}

// *****************************************************************************************

function uddeIMrecallMessage($myself, $item_id, $messageid, $cryptpass, $config) {
	// this function has three parts
	// first, read the message
	// second, delete the message from the db (complete erase)
	// third, display values for editing

	$my_gid = $config->usergid;

	$displaymessages = uddeIMselectOutboxMessageIfUnread($myself, $messageid, $config);
	if(count($displaymessages)<1) {
		$mosmsg = _UDDEIM_COULDNOTRECALL;
		uddeJSEFredirect("index.php?option=com_uddeim&task=outbox&Itemid=".$item_id, $mosmsg);
	}

	$recipname = "";
	$recalled_message = "";
	foreach($displaymessages as $themessage) {

		// recalling a message to a public user makes no sense since it has been sent anyway
		if ( uddeIMisPublicUser($themessage->toname,$themessage->toid) ) {
			$mosmsg = _UDDEIM_COULDNOTRECALLPUBLIC;
			uddeJSEFredirect("index.php?option=com_uddeim&task=outbox&Itemid=".$item_id, $mosmsg);
		}

		// CRYPT
		$recalled_message = uddeIMgetMessage($themessage->message, $cryptpass, $themessage->cryptmode, $themessage->crypthash, $config->cryptkey);
		$recalled_message = stripslashes($recalled_message);
		$recipname 		  = uddeIMgetNameFromID($themessage->toid, $config);
	}

	// write the uddeim menu
	uddeIMprintMenu($myself, 'new', $item_id, $config);
	echo "<div id='uddeim-m'>\n";
	// delete it from db (after writing the form since I need the message for a query inside of uddeIMdrawWriteform)
	uddeIMpurgeMessageFromUser($myself, $messageid);

	echo "<div id='uddeim-toplines'><p>"._UDDEIM_RECALLEDMESSAGE_INFO."</p></div>\n";
	uddeIMdrawWriteform($myself, $my_gid, $item_id, "", $recipname, $recalled_message, 0, 0, 0, 0, $config);	// allow to select a recipient
	echo "</div>\n<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
}

function uddeIMrecallPass($myself, $item_id, $messageid, $config) {
	uddeIMprintMenu($myself, 'showRecallPass', $item_id, $config);
	echo "<div id='uddeim-m'>\n";
	echo "<div id='uddeim-overview'><p><b>"._UDDEIM_PASSWORD."</b></p>";

	echo "<form name='showform' method='post' action='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=recall&Itemid=".$item_id."&messageid=".$messageid)."'>";
	echo _UDDEIM_PASSWORDBOX.": ";
	echo "<input name='cryptpass' value='' />"._UDDEIM_DECRYPTIONTEXT."<br /><br />";
	echo "<input type='submit' name='sendpass' class='button' value='"._UDDEIM_SUBMIT."' />";
	echo "</form>";

	echo "</div>\n";
	echo "</div>\n";

	echo "<div id='uddeim-bottomborder'>".uddeIMcontentBottomborder($myself, $item_id, 'standard', 'none', $config)."</div>\n";
	return;
}
