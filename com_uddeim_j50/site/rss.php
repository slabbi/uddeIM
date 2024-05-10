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
// version 5.3
// **************************************************************************
defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );

// for the rss we have
// all libs
// the configuration file
// the language file
//
// Note: $my->id might be ZERO
//
// all REQUEST vars must be evaluated here for security reasons

function uddeIMcheckPluginRSS() {
	return 7;
}

function uddeIMrssFeedPlugin($versionstring, $userid, $config) {
	$database = uddeIMgetDatabase();
	$sitename = uddeIMgetSitename();
	$live_site = uddeIMgetPath('live_site');

	$Itemid 	= uddeIMmosGetParam( $_REQUEST, 'Itemid');
	if (!$Itemid || !isset($Itemid) || empty( $Itemid )) {
		$Itemid = uddeIMgetItemid($config);
	} else if ($config->overwriteitemid) {
		$Itemid = (int)$config->useitemid;
	}
	$item_id = (int)$Itemid;

	$username = stripslashes( strval( uddeIMmosGetParam ($_REQUEST, 'user', '') ));
	$passwd   = stripslashes( strval( uddeIMmosGetParam ($_REQUEST, 'pass', '') ));
	$showall  = (int) uddeIMmosGetParam ($_REQUEST, 'showall', 0);
	$type  	  = (int) uddeIMmosGetParam ($_REQUEST, 'type', 0);

	$row = uddeIMselectUserrecordFromUsername($username, $config);
	if ($row) {
		if ($row->block) {
			uddeIMrssOutputHeader($versionstring);
			uddeIMrssOutputItem($type, "Code=5", _UDDEIM_RSS_USERBLOCKED, "");
			uddeIMrssOutputFooter();
			return;
		}
		$gid = uddeIMgetGID($row->id);	// $userid
		if (!$config->enablerss || ($config->enablerss==2 && !uddeIMisAdmin($gid) && !uddeIMisAdmin2($gid, $config))) {
			uddeIMrssOutputHeader($versionstring);
			uddeIMrssOutputItem($type, "Code=2", _UDDEIM_RSS_NOTALLOWED, "");
			uddeIMrssOutputFooter();
			return;
		}
		
		if ((strpos($row->password, ':') === false) && $row->password == md5($passwd)) {
			// Old password hash storage but authentic ... lets convert it
			$salt = uddeIMmosMakePassword(16);
			$crypt = md5($passwd.$salt);
			$row->password = $crypt.':'.$salt;
		}
		list($hash, $salt) = explode(':', $row->password);

		$hash_db   = sha1($hash);		// the hash value from the user database
		$hash_post = $passwd;
		if ($hash_db != $hash_post) {
			uddeIMrssOutputHeader($versionstring);
			uddeIMrssOutputItem($type, "Code=3", _UDDEIM_RSS_WRONGPASSWORD, "");
			uddeIMrssOutputFooter();
			return;
		}

		uddeIMrssOutputHeader($versionstring);

		$filter = "";
		if (!$showall) {
			$filter = "AND a.toread=0 ";
		}

		$limit = "";
		if ($config->rsslimit)
			$limit = " LIMIT ".(int)$config->rsslimit;
			
		$userid = uddeIMgetIDfromUsername($username, $config, true);
		$sql = "SELECT a.*, b.".($config->realnames ? "name" : "username")." AS fromname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE a.toid=".(int)$userid." AND a.totrash=0 AND a.archived=0 AND `a`.`delayed`=0 ".$filter."ORDER BY a.datum DESC".$limit;

		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if (!$rows) {
			$pms_show = uddeIMsefRelToAbs("index.php?option=com_uddeim&Itemid=".$item_id);
			uddeIMrssOutputItem($type,($showall ? "Code=0" : "Code=1"),
									  ($showall ? _UDDEIM_RSS_NOMESSAGES : _UDDEIM_RSS_NONEWMESSAGES), 
									  "", $pms_show);
		} else {
			foreach ($rows as $row) {
				$fromname = uddeIMevaluateUsername($row->fromname, $row->fromid, $row->publicname);
				if($row->systemmessage)
					$fromname = $row->systemmessage;
				if ($row->cryptmode==2)
					$pms_show = uddeIMsefRelToAbs("index.php?option=com_uddeim&Itemid=".$item_id."&task=showpass&messageid=".$row->id);
				else
					$pms_show = uddeIMsefRelToAbs("index.php?option=com_uddeim&Itemid=".$item_id."&task=show&messageid=".$row->id);
				$cm = uddeIMgetMessage($row->message, "", $row->cryptmode, "", $config->cryptkey);
				$cm = stripslashes($cm);
				if($row->systemflag || $config->allowbb) {					
					$cm = uddeIMbbcode_strip($cm);
				}
				$cm = htmlspecialchars($cm ?? '', ENT_QUOTES, $config->charset);
				$cm = str_replace("&amp;#", "&#", $cm); 
				$cm = str_replace("&amp;&lt;/br&gt;", " ", $cm);

				$title = $fromname.": ".substr($cm,0,30);
				$pubdate = date("r",$row->datum);
				$desc = substr($cm,0,500);
				uddeIMrssOutputItem(0, "", $title, $desc, $pms_show, $pubdate);
			}
		}
		uddeIMrssOutputFooter();

	} else {
		uddeIMrssOutputHeader($versionstring);
		uddeIMrssOutputItem($type, "Code=4", _UDDEIM_RSS_NOOBJECT, "");
		uddeIMrssOutputFooter();
	}
}


function uddeIMrssOutputItem($type, $code, $title, $desc, $link=null, $pdate=null) {
	echo "<item>\n";
	if ($type) {
		if (!is_null($code))	echo "<title>".$code."</title>\n";
	} else {
		if (!is_null($title))	echo "<title>".$title."</title>\n";
	}
	if (!is_null($link))	echo "<link>".$link."</link>\n";
	if (!is_null($desc))	echo "<description>".$desc."</description>\n";
	if (!is_null($pdate))	echo "<pubDate>".$pdate."</pubDate>\n";
	echo "</item>\n";
}

function uddeIMrssOutputHeader($versionstring) {
	$sitename = uddeIMgetSitename();
	$live_site = uddeIMgetPath('live_site');

	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		$encoding = "utf-8";
	} else {
		$temp = split("=", _ISO);
		$encoding = $temp[1];
	}
	header('Content-type: application/xml');
	echo "<?xml version=\"1.0\" encoding=\"".$encoding."\"?>\n";
	echo "<!DOCTYPE rss PUBLIC \"-//Netscape Communications//DTD RSS 0.91//EN\"\n";
	echo "   \"http://my.netscape.com/publish/formats/rss-0.91.dtd\">\n";
	echo "<!-- ".$versionstring." -->\n";
	echo "<rss version=\"0.91\">\n";
	echo "<channel>\n";
	echo "<title>".stripslashes(htmlspecialchars($sitename ?? ''))."</title>\n";
	echo "<link>".$live_site."</link>\n";
	echo "<description>".uddeIMgetMetaDesc()."</description>\n";
	echo "<language>en-us</language>\n";
	echo "<lastBuildDate>".date("r")."</lastBuildDate>\n";
	echo "<image>\n";
	echo "<title>Powered by uddeIM</title>\n";
	echo "<url>".$live_site."/components/com_uddeim/templates/images/rss_logo.png</url>\n";
	echo "<link>".$live_site."</link>\n";
	echo "<width>128</width>\n";
	echo "</image>\n";
}

function uddeIMrssOutputFooter() {
	echo "</channel>\n";
	echo "</rss>\n";
}
