<?php
// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0, 1.5, 1.6, 1.7, 2.5
// Author         © 2007-2012 Stephan Slabihoud
// License        This plugin is published under copyright.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk.
//                Redistributing this file is not allowed.
// ********************************************************************************************
// Version 3.5
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

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
				$cm = htmlspecialchars($cm, ENT_QUOTES, $config->charset);
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
	echo "<title>".stripslashes(htmlspecialchars($sitename))."</title>\n";
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
