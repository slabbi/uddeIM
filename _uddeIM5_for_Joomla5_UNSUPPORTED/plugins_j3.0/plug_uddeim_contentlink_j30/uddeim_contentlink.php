<?php
// ********************************************************************************************
// Title          Plugin to create links to uddeIM (uddeIM PMS Content Link)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2008 Stephan Slabihoud
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	$ver = new JVersion();
	if (!strncasecmp($ver->RELEASE, "1.5", 3)) {
		//$mainframe->registerEvent('onPrepareContent', 'uddeIMpmsLink15');
		JApplication::registerEvent('onPrepareContent', 'uddeIMpmsLink15');
	} else {
		// jimport( 'joomla.plugin.plugin' );
		// $_PLUGINS->registerFunction( 'onPrepareContent', 'uddeIMpmsLink15' );
		jimport('joomla.plugin.plugin');
		class plgContentUddeim_contentlink extends JPlugin {
			public function onContentPrepare( $context, &$article, &$params, $limitstart=0) {
				global $mainframe;
				uddeIMpmsLink15( $article, $params, $limitstart );
			}
		}
	}
} else {
	$_MAMBOTS->registerFunction( 'onPrepareContent', 'uddeIMpmsLink' );
}

function uddeIMpmsLink15( &$row, &$params, $page=0 ) {
	uddeIMpmsLink( true, $row, $params, $page );
}

function uddeIMpmsLink( $published, &$row, &$params, $page=0 ) {

	if ( strpos( $row->text, 'pmslink' ) === false )
		return true;

	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		$pathtosite = substr_replace(JURI::root(), '', -1, 1);
		$pathtoadmin = JPATH_ADMINISTRATOR."/components/com_uddeim";
		$user = JFactory::getUser();
		$userid = $user->id;
		$database = JFactory::getDBO();
	} else {
		global $mainframe,$database,$my;
		$pathtosite  = $mainframe->getCfg('live_site');
		$pathtoadmin = $mainframe->getCfg('absolute_path')."/administrator/components/com_uddeim";
		$userid = $my->id;

		$query = "SELECT id FROM `#__mambots` WHERE element = 'uddeim_pms_contentlink' AND folder = 'content'";
		$database->setQuery( $query );
		$id = $database->loadResult();
		$mambot = new mosMambot( $database );
		$mambot->load( $id );
	}
	require($pathtoadmin."/config.class.php");
	$config = new uddeimconfigclass();

	$regexp1 = "{pmslink:id=\d+(,[\w\.! ]+)?}";					// id
	$regexp2 = "{pmslink:username=[\w ]+(,[\w\.! ]+)?}";		// username
	$regexp3 = "{pmslink:realname=[\w ]+(,[\w\.! ]+)?}";		// realname
	
	if (preg_match('/'.$regexp1.'/', $row->text)) {
		if ($published && ($userid || $config->pubfrontend)) {
			$fulltext = $row->text;
			if (preg_match_all('/'.$regexp1.'/', $fulltext, $matches, PREG_PATTERN_ORDER) > 0) {
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
			if (preg_match_all('/'.$regexp2.'/', $fulltext, $matches, PREG_PATTERN_ORDER) > 0) {
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
			if (preg_match_all('/'.$regexp3.'/', $fulltext, $matches, PREG_PATTERN_ORDER) > 0) {
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
