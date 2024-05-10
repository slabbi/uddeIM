<?php
/// ********************************************************************************************
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

$uddeim_isadmin = 0;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
}

$udd_pathtoadmin = uddeIMgetPath('admin');
$udd_pathtouser  = uddeIMgetPath('user');
$udd_pathtosite  = uddeIMgetPath('live_site');
$udd_database    = uddeIMgetDatabase();
$udd_mosConfig_lang = uddeIMgetLang();

require_once($udd_pathtoadmin."/admin.shared.php");
require_once($udd_pathtouser.'/crypt.class.php');
require_once($udd_pathtoadmin.'/config.class.php');
$udd_config = new uddeimconfigclass();

if(!defined('_UDDEIM_INBOX')) {
	$udd_postfix = "";
	if ($udd_config->languagecharset)
		$udd_postfix = ".utf8";
	if (file_exists($udd_pathtoadmin.'/language'.$udd_postfix.'/'.$udd_mosConfig_lang.'.php')) {
		include_once($udd_pathtoadmin.'/language'.$udd_postfix.'/'.$udd_mosConfig_lang.'.php');
	} elseif (file_exists($udd_pathtoadmin.'/language'.$udd_postfix.'/english.php')) {
		include_once($udd_pathtoadmin.'/language'.$udd_postfix.'/english.php');
	} elseif (file_exists($udd_pathtoadmin.'/language/english.php')) {
		include_once($udd_pathtoadmin.'/language/english.php');
	}
	$GLOBALS['udde_smon'] = $udde_smon;
	$GLOBALS['udde_lmon'] = $udde_lmon;
	$GLOBALS['udde_sweekday'] = $udde_sweekday;
	$GLOBALS['udde_lweekday'] = $udde_lweekday;
}

$udd_par_hidenotifier = (int)$params->get( 'uddhidenotifier', '0' );
$udd_par_showmsg      = (int)$params->get( 'uddshowmsg', '1' );
$udd_par_maxchars     = (int)$params->get( 'uddmaxchars', '24' );
$udd_par_manylines    = (int)$params->get( 'uddmanylines', '5' );
$udd_cbDHTMLPopup     = (int)$params->get( 'uddeDHTMLpopup', 2);
$udd_cbenablepopup    = (int)$params->get( 'uddeenablepopup', 0 );
$udd_uddeenableajax   = (int)$params->get( 'uddeenableajax', 0 );
$udd_uddeajaxtime     = (int)$params->get( 'uddeajaxtime', 0 );
$udd_nametype         = (int)$params->get( 'uddnametype', 0 );
$udd_sound         	  = (int)$params->get( 'uddeSound', 0 );
$udd_rightpos         = (int)$params->get( 'uddrightpos', '10' );
$udd_timeout          = (int)$params->get( 'uddtimeout', '10000' );
$udd_rightspeed       = (int)$params->get( 'uddrightspeed', '20' );
$udd_leftspeed        = (int)$params->get( 'uddleftspeed', '20' );

if (!$udd_par_maxchars)		$udd_par_maxchars = 24;
if ($udd_par_manylines<0)	$udd_par_manylines = 0;
if ($udd_uddeajaxtime<5)	$udd_uddeajaxtime = 5;

$udd_userid = uddeIMgetUserID();
$udd_mygroupid = uddeIMgetGroupID();

$udd_moduleSubPath = $udd_pathtosite."/modules/mod_uddeim/mod_uddeim";
//joomla and mambo switch deleted

	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {	// this works in Joomla 1.5+
		if (file_exists($udd_pathtouser.'/templates/'.$udd_config->templatedir.'/css/uddemodule.css')) {
			$css = $udd_pathtosite."/components/com_uddeim/templates/".$udd_config->templatedir."/css/uddemodule.css"; 
			uddeIMaddCSS($css);
		} elseif(file_exists($udd_pathtouser.'/templates/default/css/uddemodule.css')) {
			$css = $udd_pathtosite."/components/com_uddeim/templates/default/css/uddemodule.css"; 
			uddeIMaddCSS($css);
		}
	} else {
		if (file_exists($udd_pathtouser.'/templates/'.$udd_config->templatedir.'/css/uddemodule.css')) {
			echo '<link rel="stylesheet" href="'.$udd_pathtosite.'/components/com_uddeim/templates/'.$udd_config->templatedir.'/css/uddemodule.css" type="text/css" />';
		} elseif(file_exists($udd_pathtouser.'/templates/default/css/uddemodule.css')) {
			echo '<link rel="stylesheet" href="'.$udd_pathtosite.'/components/com_uddeim/templates/default/css/uddemodule.css" type="text/css" />';
		}
	}

if (!$udd_userid) {
	if (!$udd_par_hidenotifier) {
		echo "<div id='uddeim-module'>";
		echo "<p class='uddeim-module-head'>"._UDDEIM_NOTLOGGEDIN."</p>";
		echo "</div>";
	}
	return;
}

switch($udd_nametype) {
	case 0 : $udd_query = "SELECT name FROM `#__users` WHERE id = ". (int)$udd_userid; break;
	case 1 : $udd_query = "SELECT username FROM `#__users` WHERE id = ". (int)$udd_userid; break;
	case 2 : if (file_exists(uddeIMgetPath('absolute_path')."/components/com_comprofiler/comprofiler.php")) { //if (uddeIMmodCheckCB()) {
				$udd_query = "SELECT firstname FROM `#__comprofiler` WHERE id = ". (int)$udd_userid;
			 } else {
				$udd_query = "SELECT name FROM `#__users` WHERE id = ". (int)$udd_userid; break;
			 }
			 break;
}
$udd_database->setQuery( $udd_query );
$udd_name = htmlspecialchars($udd_database->loadResult() ?? '');
$lang = Factory::getApplication()->getLanguage();


//first check if itemid overwrite is set
if ($udd_config->overwriteitemid && $udd_config->useitemid)
	$udd_item_id = (int)$udd_config->useitemid;

else {
// then try to find a published link assuming the lowest id is uddeim main
//add &view as all valid uddeim menulinks are created with the new &view&select=
//edit the access to the new joomla viewlevels starting with 1 (joomla 1.5 started with 0)
$udd_sql = "SELECT MIN(id) FROM `#__menu` WHERE link LIKE '%com_uddeim&view%' AND published=1 AND access".($udd_mygroupid==1 ? "=" : "<=").$udd_mygroupid;
if (uddeIMcheckJversion()>=2) {		// Joomla 1.6+
	$udd_sql .= " AND language IN (" . $udd_database->Quote($lang->get('tag')) . ",'*')";
}
//$udd_sql .= " LIMIT 1";  //using MIN returns only a single row
$udd_database->setQuery($udd_sql);
$udd_item_id = (int)$udd_database->loadResult();
}
if (!$udd_item_id) {
	// when no published link has been found, try to find an unpublished one
	$udd_sql="SELECT MIN(id) FROM `#__menu` WHERE link LIKE '%com_uddeim%' AND published=0 AND access".($udd_mygroupid==1 ? "=" : "<=").$udd_mygroupid;
	if (uddeIMcheckJversion()>=2) {		// Joomla 1.6+
		$udd_sql .= " AND language IN (" . $udd_database->Quote($lang->get('tag')) . ",'*')";
	}
	//$udd_sql .= " LIMIT 1";
	$udd_database->setQuery($udd_sql);
	$udd_item_id = (int)$udd_database->loadResult();
}

$udd_pms_link = uddeIMsefRelToAbs("index.php?option=com_uddeim&task=inbox".($udd_item_id ? "&Itemid=".$udd_item_id : ""));

$udd_sql="SELECT a.*, b.".($udd_config->realnames ? "name" : "username")." AS displayname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE `a`.`delayed`=0 AND a.toread=0 AND a.totrash=0 AND a.toid=".(int)$udd_userid." ORDER BY a.datum";
//if ($udd_par_manylines>0) {
//	$udd_sql.=" LIMIT ".$udd_par_manylines;
//}
$udd_database->setQuery($udd_sql);
$udd_allmessages=$udd_database->loadObjectList();
$udd_totalmessages=count($udd_allmessages);

$udd_uddeicons_modulenewmess    = $udd_pathtosite.'/components/com_uddeim/templates/'.$udd_config->templatedir.'/images/env_ani.gif';
$udd_uddeicons_modulenonewmess  = $udd_pathtosite.'/components/com_uddeim/templates/'.$udd_config->templatedir.'/images/env.gif';
$udd_luddeicons_modulenewmess   = $udd_pathtouser.'/templates/'.$udd_config->templatedir.'/images/env_ani.gif';
$udd_luddeicons_modulenonewmess = $udd_pathtouser.'/templates/'.$udd_config->templatedir.'/images/env.gif';


$udd_javascript = "<script type=\"text/javascript\" language=\"javascript\"><!--\n";

if ($udd_sound==1) {
	echo "\n<span id=\"uddsound\"></span>\n";
	$udd_soundcode = "
    function playSound(soundfile) {
	document.getElementById(\"uddsound\").innerHTML = \"<embed src=\\\"\"+soundfile+\"\\\" hidden=\\\"true\\\" autostart=\\\"true\\\" loop=\\\"false\\\" />\";
    }";
	$udd_javascript .= $udd_soundcode;
}
if ($udd_sound==2) {
	echo "\n<audio preload=\"auto\" autobuffer id=\"uddsound\">
    <source src=\"".$udd_moduleSubPath."/alert.mp3"."\" type=\"audio/mpeg\" />
    <source src=\"".$udd_moduleSubPath."/alert.ogg"."\" type=\"audio/ogg\" />
    </audio>\n";
}

if ($udd_cbenablepopup) {		// NEW MESSAGES, so do notification popups when enabled
	// ALERT-POPUP-CODE ##################################################################################
	$udd_DoAlert = 0;
	$udd_query_popup = "SELECT popup FROM `#__uddeim_emn` WHERE userid=". (int)$udd_userid;
	$udd_database->setQuery( $udd_query_popup );
	$udd_dopopup = (int)$udd_database->loadResult();
	if ($udd_dopopup && $udd_totalmessages>0)
		$udd_DoAlert = 1;
	// do not show popup when PMS component is active
	if (stristr($_SERVER['REQUEST_URI'],'option=com_uddeim')!==FALSE)
		$udd_DoAlert = 0;
	if (stristr($_SERVER['REQUEST_URI'],'/uddeim')!==FALSE)
		$udd_DoAlert = 0;
		// ToDo: Set flag, message has been displayed
		switch( $udd_cbDHTMLPopup ) {
			case 0:		$udd_javascript .= uddepmscallsound($udd_DoAlert, $udd_moduleSubPath, $udd_sound);
						break;
			case 1:		$udd_message = _UDDEMODULE_HELLO . " " . $udd_name . "<br />";
						$udd_message .= _UDDEMODULE_YOUHAVE." <span id=\"uddcount\">".$udd_totalmessages." ".($udd_totalmessages == 1 ? _UDDEMODULE_MESSAGE : _UDDEMODULE_MESSAGES)."</span>";
						$udd_javascript .= uddepmscalldhtml($udd_DoAlert, $udd_message, $udd_pms_link, $udd_moduleSubPath, $udd_sound);
						break;
			case 2:		
			default:	$udd_message = _UDDEMODULE_HELLO . " " . $udd_name . "<br />";
						$udd_message .= _UDDEMODULE_YOUHAVE." <span id='uddcount'>".$udd_totalmessages." ".($udd_totalmessages == 1 ? _UDDEMODULE_MESSAGE : _UDDEMODULE_MESSAGES)."</span>";
						$udd_javascript .= uddepmscalldhtmlfloater($udd_DoAlert, $udd_timeout, $udd_rightpos, $udd_rightspeed, $udd_leftspeed, $udd_uddeicons_modulenewmess, $udd_message, $udd_pms_link, $udd_moduleSubPath, $udd_sound);
						break;
		}
}


	if (class_exists('Joomla\CMS\HTML\HTMLHelper'))  //should be in Joomla5
		$udd_completeURL = "index.php?option=com_uddeim&task=ajaxGetNewMessages&no_html=1&format=raw";
    else
        $udd_completeURL = "index.php?option=com_uddeim&task=ajaxGetNewMessages";

	if ($udd_uddeenableajax && $udd_cbenablepopup) {
		$udd_ajaxcode = "
        uddSetTimer();
        function uddSetTimer() {
	        var uddMin = ".$udd_uddeajaxtime."*1000;
	        var uddTimer = setInterval('uddShowUser()', uddMin);
        }

        var uddXMLHttp;
        var uddTotal = ".$udd_totalmessages.";

        function uddShowUser() {
	        uddXMLHttp = uddGetXmlHttpObject()
	        if (uddXMLHttp==null) {		// alert ('Browser does not support HTTP Request');
		    return;
	        }
	        var uddURL = '".$udd_completeURL."';
	        uddXMLHttp.onreadystatechange = function () {
	        uddStateChanged(uddstart,uddfloatOut);
		    };
	        uddXMLHttp.open('GET',uddURL,true);
	        uddXMLHttp.send(null);
        }

        function uddStateChanged(fStart,fOut) {
	        if (uddXMLHttp.readyState==4 || uddXMLHttp.readyState=='complete') {
		        var uddAllValue = uddXMLHttp.responseText;
		        uddChkval = uddAllValue.split('~');

		    if (uddChkval[0]!=0) {
			if (document.getElementById('uddeim-nomessage'))            /* +uddChkval[0] checks if it is a number*/
				document.getElementById('uddeim-nomessage').innerHTML = (+uddChkval[0] ? '"._UDDEMODULE_NEWMESSAGES." ' : '') + uddChkval;
			if (document.getElementById('uddeim-noimage'))
				document.getElementById('uddeim-noimage').src = '".$udd_uddeicons_modulenewmess."';
		    } else {
			if (document.getElementById('uddeim-nomessage'))
				document.getElementById('uddeim-nomessage').innerHTML = '"._UDDEMODULE_NONEW."';
			if (document.getElementById('uddeim-noimage'))
				document.getElementById('uddeim-noimage').src = '".$udd_uddeicons_modulenonewmess."';
		    }

            if (uddTotal!=uddChkval[0] && uddChkval[0]>uddTotal) { \n";
			switch( $udd_cbDHTMLPopup ) {
				case 1:		break;
				case 2:
				default:
							$udd_ajaxcode .= "
								if (document.getElementById('uddcount'))
									document.getElementById('uddcount').innerHTML = uddChkval[0]+' '+(uddChkval[0] == 1 ? '"._UDDEMODULE_MESSAGE."' : '"._UDDEMODULE_MESSAGES."');
							";
							$udd_ajaxcode .= " fStart();\n";
							$udd_ajaxcode .= " setTimeout(fOut, ".$udd_timeout.");";
							break;
			    }
			$udd_ajaxcode .= " uddTotal = uddChkval[0];\n";
		    $udd_ajaxcode .= "}\n";
		    $udd_ajaxcode .= "
	    }
    }

        function uddGetXmlHttpObject() {
	        var uddXMLHttp=null;
	        try {
		    uddXMLHttp = new XMLHttpRequest(); /*Firefox, Opera 8.0+, Safari*/
	        }
	        catch (e) {
		        try {
			    uddXMLHttp=new ActiveXObject('Msxml2.XMLHTTP'); /*Internet Explorer*/
		        }
		        catch (e) {
			    uddXMLHttp=new ActiveXObject('Microsoft.XMLHTTP');
	    	    }
	        }
	return uddXMLHttp;
}
";
		$udd_javascript .= $udd_ajaxcode;
	}

$udd_javascript .= "\n//-->\n</script>\n";
echo $udd_javascript;


if (!$udd_par_hidenotifier) {
	$udd_headline = "<a href='".$udd_pms_link."'>"._UDDEMODULE_PRIVATEMESSAGES."</a>";

	if ($udd_totalmessages>0) {		// NEW MESSAGES

		echo "<div id='uddeim-modulenew'>";
		echo "<p class='uddeim-module-head'>".$udd_headline;
		if (file_exists($udd_luddeicons_modulenewmess))
			echo " <a href='".$udd_pms_link."'><img id='uddeim-noimage' border='0' src='".$udd_uddeicons_modulenewmess."' alt='' /></a>";
		echo "</p>";

		if ($udd_par_showmsg==0 || $udd_par_showmsg==3) {	// DONT SHOW NEW MESSAGES
			if ($udd_par_showmsg==0)	// Show new msg counter only
				echo "<p class='uddeim-module-body'><a id='uddeim-nomessage' href='".$udd_pms_link."'>"._UDDEMODULE_NEWMESSAGES." <span class='badge bg-success'><b>".$udd_totalmessages."</b></span></a></p>";
		} else {				// SHOW NEW MESSAGES

			$udd_count=1;
			foreach($udd_allmessages as $udd_themessage) {
				if ($udd_count<=$udd_par_manylines || $udd_count==0) {
					if($udd_themessage->systemmessage) {
						$udd_whofrom=$udd_themessage->systemmessage;
					} else {
						$udd_whofrom=$udd_themessage->displayname;
					}
					if (function_exists('bcdiv')) {
						$udd_halfchars=bcdiv($udd_par_maxchars,2,0);
					} elseif (function_exists('floor')) {
						$udd_halfchars=floor($udd_par_maxchars/2);
					} else {
						$udd_halfchars=($udd_par_maxchars/2);
					}
					if(strlen($udd_whofrom)>=($udd_halfchars-1)) {
						$udd_whofrom=substr($udd_whofrom, 0, ($udd_halfchars-1));
						$udd_whofrom=$udd_whofrom.".";
					}

					$udd_cm = uddeIMgetMessage($udd_themessage->message, "", $udd_themessage->cryptmode, "", $udd_config->cryptkey);
					$udd_displaymessage=stripslashes($udd_cm);
					if($udd_themessage->systemmessage || $udd_config->allowbb) {
						require_once ($udd_pathtouser."/bbparser.php");
						$udd_displaymessage=uddeIMbbcode_strip($udd_displaymessage);
					}
					$udd_displaymessage=htmlspecialchars($udd_displaymessage, ENT_QUOTES, $udd_config->charset);
					$udd_displaymessage=str_replace("&amp;#", "&#", $udd_displaymessage); 

					$udd_maxlen=$udd_par_maxchars-strlen($udd_whofrom)-1;	// one space
					if($udd_maxlen<5)
						$udd_maxlen=5;

					if ($udd_themessage->cryptmode==2) {
						$udd_pms_show = uddeIMsefRelToAbs("index.php?option=com_uddeim".($udd_item_id ? "&Itemid=".$udd_item_id : "")."&task=showpass&messageid=".$udd_themessage->id);
					} else {
						$udd_pms_show = uddeIMsefRelToAbs("index.php?option=com_uddeim".($udd_item_id ? "&Itemid=".$udd_item_id : "")."&task=show&messageid=".$udd_themessage->id);
					}
					if ($udd_par_showmsg==2) {
						echo "<p class='uddeim-module-row'>";
						echo "<a href='".$udd_pms_show."'>".$udd_whofrom."</a>";
						echo "</p>";
					} else {
						echo "<p class='uddeim-module-row'>".$udd_whofrom." ";
						echo "<a href='".$udd_pms_show."'>".uddTeaserHead($udd_displaymessage, $udd_maxlen, $udd_config->quotedivider, $udd_config->languagecharset)."</a>";
						echo "</p>";
					}
				}
				$udd_count++;
			}
		}
		echo "</div>";			// uddeim-modulenew
	} else {					// NO NEW MESSAGES

		echo "<div id='uddeim-module'>";
		echo "<p class='uddeim-module-head'>".$udd_headline;
		if (file_exists($udd_luddeicons_modulenonewmess))
			echo " <a href='".$udd_pms_link."'><img id='uddeim-noimage' border='0' src='".$udd_uddeicons_modulenonewmess."' alt='' /></a>";
		echo "</p>";
		echo "<p id='uddeim-nomessage' class='uddeim-module-body'>"._UDDEMODULE_NONEW."</p>";
		echo "</div>";	  

	}
}

if (!function_exists('uddeIMmodCheckCB')){ //no longer needed - integrated
function uddeIMmodCheckCB() {
	$udd_pathtocb = uddeIMgetPath('absolute_path')."/components/com_comprofiler/comprofiler.php";
	if (file_exists($udd_pathtocb))
		return true;
	return false;
}}
  
function uddTeaserHead($ofwhat, $howlong, $quotedivider, $utf8) {
	$msgparts=explode($quotedivider, $ofwhat, 2);
	$words=explode(" ", $msgparts[0]);
	$howmanywords=count($words);
	$x=0;
	if (!$howlong)
		$howlong=10;
	$trailstring="";
	if (uddeIM_utf8_strlen($utf8,$msgparts[0])>$howlong) {
		$howlong = $howlong-3;
		$trailstring = "...";
	}
	$construct="";
	if (uddeIM_utf8_strlen($utf8,$words[0])>$howlong) {
		$construct = uddeIM_utf8_substr($utf8, $words[0], 0, $howlong);
	} else {
		for($x=0; $x < $howmanywords; $x++) {
			$posslen = uddeIM_utf8_strlen($utf8,$construct) + uddeIM_utf8_strlen($utf8,$words[$x]);
			if ($posslen<=$howlong) {
				$construct .= " ".$words[$x];
			} else {
				break;
			}
		}
	}
	$construct .= $trailstring;
	$construct = ltrim($construct);
	if (empty($construct))
		$construct="...";
	return $construct;
}

function uddepmscalldhtml($udd_DoAlert, $udd_message, $udd_pms_link, $udd_moduleSubPath, $udd_sound){
	$udd_link = '<a href="'.$udd_pms_link.'"><div style="text-align: justify; padding: 2px 5px; font-size: 13px; font-family: Arial; width: 250px; background-color: #FFFFFF; color: #000000;">'.$udd_message.'</div></a>';
//	$udd_link = '<div style="text-align: justify; padding: 2px 5px; font-size: 13px; font-family: Arial; background-color: #FFFFFF; color: #000000;">'.$udd_message.'</div>';
        $udd_title = _UDDEMODULE_EXPRESSMESSAGE;
        //$udd_title = "<img src=\"$udd_mosConfig_live_site/modules/mod_uddeim/close.gif\" style=\"vertical-align: bottom;\" width=\"16\" height=\"14\" />".$udd_title;

	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		$css = $udd_moduleSubPath."/popup.css";
		uddeIMaddCSS($css);
		$temp = $udd_moduleSubPath."/domLib.js";
		uddeIMaddScript($temp);
		$temp = $udd_moduleSubPath."/domTT.js";
		uddeIMaddScript($temp);
		$temp = $udd_moduleSubPath."/domTT_drag.js";
		uddeIMaddScript($temp);
	} else {
		echo "<link href=\"".$udd_moduleSubPath."/popup.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
		echo "<script language=\"Javascript\" src=\"".$udd_moduleSubPath."/domLib.js\"></script>\n"
			. "<script language=\"Javascript\" src=\"".$udd_moduleSubPath."/domTT.js\"></script>\n"
			. "<script language=\"Javascript\" src=\"".$udd_moduleSubPath."/domTT_drag.js\"></script>\n";
	}
	$udd_ret = 
		  " var domTT_styleClass = 'domTTWin';\n"
		. "	var domTT_draggable = true;\n"
		. "	var domTT_closeLink = '<img src=\"".$udd_moduleSubPath."/close.gif\" style=\"vertical-align: bottom;\" width=\"16\" height=\"14\" alt=\"\" />';\n";

	$udd_ret .=
		  "function uddfloatOut() {\n"
		. "}\n"
		. "function uddstart() {\n"
		. "}\n";	// dummy functions
	if ($udd_DoAlert)
		$udd_ret .= "	window.onload = function(in_event) {\n"
				 . "	  domTT_addPredefined('popup', 'caption', '$udd_title', 'content', '$udd_link', 'type', 'sticky');\n"
				 . "	  domTT_activate('popup1', in_event, 'predefined', 'popup', 'x', 400, 'y', 150, 'delay', 200 );\n"	// 'width', 273, 
				 . "	};\n"
				 . "	window.onmousemove = function(in_event) {};\n";	// compatibility fix for overlib_mini.js
	return $udd_ret;
}

function uddepmscalldhtmlfloater($udd_DoAlert, $udd_timeout, $udd_rightpos, $udd_rightspeed, $udd_leftspeed, $udd_uddeicons_modulenewmess, $udd_message, $udd_pms_link, $udd_moduleSubPath, $udd_sound){
	$udd_link = "<a href='".$udd_pms_link."'>".$udd_message."</a>";
	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		$css = $udd_moduleSubPath."/popupex.css";
		uddeIMaddCSS($css);
	} else {
		echo "<link href='".$udd_moduleSubPath."/popupex.css' rel='stylesheet' type='text/css' />\n";
	}

	echo "<div style='left: -450px;visibility:hidden;' id='floaterDiv' class='floaterTranslucent'>";
	echo " <div class='floaterTitle'>"._UDDEMODULE_EXPRESSMESSAGE;
	echo "  <a href='javascript:uddfloatOut()'><img src='".$udd_moduleSubPath."/close.gif' border='0' alt='' /></a>";
	echo " </div>";
	echo " <div class='floaterBody'><br />".$udd_link."<br /><br /><img src='".$udd_moduleSubPath."/mail.gif' border='0' alt='' /></div>\n";
	echo "</div>\n";
	$udd_ret = '
function uddfloatIn() {
	if (document.getElementById) {
		obj = document.getElementById("floaterDiv");
		if (parseInt(obj.style["left"]) <  rightpos) {
			obj.style["left"] = parseInt(obj.style["left"]) + 20 + "px";
			setTimeout("uddfloatIn()", '.$udd_rightspeed.');
		}
	}
}

function uddfloatOut() {
	if (document.getElementById) {
		obj = document.getElementById("floaterDiv");
		if (parseInt(obj.style["left"]) > -450) {
			obj.style["left"] = parseInt(obj.style["left"]) - 20 + "px";
			setTimeout("uddfloatOut()", '.$udd_leftspeed.');
		} else {
			obj.style.visibility = "hidden";
		}
	}
}

function uddstart() {
	if (document.getElementById) {
		obj = document.getElementById("floaterDiv");
		obj.style["left"] = "-450px";
		obj.style.visibility = "visible";
	}
	uddfloatIn();
}

function uddaddOnloadEvent(fnc){
  if ( typeof window.addEventListener != "undefined" )
    window.addEventListener( "load", fnc, false );
  else if ( typeof window.attachEvent != "undefined" ) {
    window.attachEvent( "onload", fnc );
  }
  else {
    if ( window.onload != null ) {
      var oldOnload = window.onload;
      window.onload = function ( e ) {
        oldOnload( e );
        window[fnc]();
      };
    }
    else
      window.onload = fnc;
  }
}

var rightpos = '.$udd_rightpos.';
if (document.getElementById) {
	if (rightpos<0) {
		rightpos = document.body.clientWidth + rightpos;
	}
}';
if ($udd_DoAlert) {
	$udd_ret .= '
setTimeout("uddfloatOut();", '.$udd_timeout.');
// window.onload = uddstart;
// addOnloadEvent(function(){ uddstart(\'\') });
';
if ($udd_sound==1) {
	$udd_ret .= 'playSound(\''.$udd_moduleSubPath.'/alert.mp3'.'\');';
}
if ($udd_sound==2) {
	$udd_ret .= 'var uddaudio = document.getElementById("uddsound");
uddaudio.play();';
}
	$udd_ret .= '
uddaddOnloadEvent(uddstart);
';
	}
	return $udd_ret;
}

function uddepmscallsound($udd_DoAlert, $udd_moduleSubPath, $udd_sound) {
	if ($udd_DoAlert) {
		$udd_ret = "";
		if ($udd_sound==1) {
			$udd_ret .= 'playSound(\''.$udd_moduleSubPath.'/alert.mp3'.'\');';
		}
		if ($udd_sound==2) {
			$udd_ret .= 'var uddaudio = document.getElementById("uddsound");
		uddaudio.play();';
		}
		//$udd_ret .= '
		//uddaddOnloadEvent(uddstart);
		//';
	}
	return $udd_ret;
}
