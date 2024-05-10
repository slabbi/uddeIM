<?php
// ********************************************************************************************
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
use Joomla\CMS\Version;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;

if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	//$ver = new Version();
      
		class plgContentUddeim_contentlink extends CMSPlugin {
			public function onContentPrepare( $context, &$article, &$params, $limitstart=0) {
				global $mainframe;
				uddeIMpmsLink( true, $article, $params, $limitstart );
			}
		}
}
else
return;


function uddeIMpmsLink( $published, &$row, &$params, $page=0 ) {

	if ( strpos( $row->text, 'pmslink' ) === false )
		return true;

		$pathtosite = substr_replace(URI::root(), '', -1, 1);
		$pathtoadmin = JPATH_ADMINISTRATOR."/components/com_uddeim";
		//$user = Factory::getApplication()->getIdentity();
		$userid = Factory::getApplication()->getIdentity()->id;
		$database = Factory::getContainer()->get('DatabaseDriver');

	require($pathtoadmin."/config.class.php");
	$config = new uddeimconfigclass();

	$regexp1 = "{pmslink:id=\d+(,[\w\.! ]+)?}";					// id
	$regexp2 = "{pmslink:username=[\w ]+(,[\w\.! ]+)?}";		// username
	$regexp3 = "{pmslink:realname=[\w ]+(,[\w\.! ]+)?}";		// realname
	
	if (preg_match('/'.$regexp1.'/', $row->text)) {
		if ($published && ($userid || $config->pubfrontend)) {
			$fulltext = $row->text;
			if (preg_match_all('/'.$regexp1.'/', $fulltext ?? '', $matches, PREG_PATTERN_ORDER) > 0) {
				foreach ($matches[0] as $match) {
					$mosaddbanner_output = "";
					$match = str_replace("{pmslink:id=", "", $match);
					$match = str_replace("}", "", $match);
					$par = Array();
					$par = explode(",", $match);
					
					$uid = (int)$par[0];
					$database->setQuery( "SELECT id FROM `#__users` WHERE id='".$uid."'");
					$uid = (int)$database->loadResult();
					if ($uid) {
						$link  = "<a href='index.php?option=com_uddeim&task=new&recip=".$uid."&nouserlist=7'>";
						if (!$par[1])
							$pic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/envelope.gif' hspace='0' vspace='0' border='0' alt='' title='' />";
						else
							$pic = trim($par[1]);
						$link .= $pic;
						$link .= "</a>";
					} else {
						$link = "Invalid Id";
					}
					$fulltext = preg_replace('/'.$regexp1.'/', $link, $fulltext, 1);
				}
				$row->text = $fulltext;
			}
		} else {
			$row->text = preg_replace ('/'.$regexp1.'/', "", $row->text);
		}
	}

	if (preg_match('/'.$regexp2.'/', $row->text)) {
		if ($published && ($userid || $config->pubfrontend)) {
			$fulltext = $row->text;
			if (preg_match_all('/'.$regexp2.'/', $fulltext ?? '', $matches, PREG_PATTERN_ORDER) > 0) {
				foreach ($matches[0] as $match) {
					$mosaddbanner_output = "";
					$match = str_replace("{pmslink:username=", "", $match);
					$match = str_replace("}", "", $match);
					$par = Array();
					$par = explode(",", $match);

					$uname = trim($par[0]);
					$database->setQuery( "SELECT id FROM `#__users` WHERE username='".$uname."'");
					$uid = (int)$database->loadResult();
					if ($uid) {
						$link  = "<a href='index.php?option=com_uddeim&task=new&recip=".$uid."&nouserlist=7'>";
						if (!$par[1])
							$pic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/envelope.gif' hspace='0' vspace='0' border='0' alt='".$uname."' title='".$uname."' />";
						else
							$pic = trim($par[1]);
						$link .= $pic;
						$link .= "</a>";
					} else {
						$link = "Invalid Username";
					}
					$fulltext = preg_replace('/'.$regexp2.'/', $link, $fulltext, 1);
				}
				$row->text = $fulltext;
			}
		} else {
			$row->text = preg_replace ('/'.$regexp2.'/', "", $row->text);
		}
	}
	
	if (preg_match('/'.$regexp3.'/', $row->text)) {
		if ($published && ($userid || $config->pubfrontend)) {
			$fulltext = $row->text;
			if (preg_match_all('/'.$regexp3.'/', $fulltext ?? '', $matches, PREG_PATTERN_ORDER) > 0) {
				foreach ($matches[0] as $match) {
					$mosaddbanner_output = "";
					$match = str_replace("{pmslink:realname=", "", $match);
					$match = str_replace("}", "", $match);
					$par = Array();
					$par = explode(",", $match);

					$uname = trim($par[0]);
					$database->setQuery( "SELECT id FROM `#__users` WHERE name='".$uname."'");
					$uid = (int)$database->loadResult();
					if ($uid) {
						$link  = "<a href='index.php?option=com_uddeim&task=new&recip=".$uid."&nouserlist=7'>";
						if (!$par[1])
							$pic = "<img src='".$pathtosite."/components/com_uddeim/templates/".$config->templatedir."/images/envelope.gif' hspace='0' vspace='0' border='0' alt='".$uname."' title='".$uname."' />";
						else
							$pic = trim($par[1]);
						$link .= $pic;
						$link .= "</a>";
					} else {
						$link = "Invalid Realname";
					}
					$fulltext = preg_replace('/'.$regexp3.'/', $link, $fulltext, 1);
				}
				$row->text = $fulltext;
			}
		} else {
			$row->text = preg_replace ('/'.$regexp3.'/', "", $row->text);
		}
	}
	return true;
}
