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

defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );

function uddeIMinitGetPicLink($config) {
	$id = 0;
	switch($config->showcblink) {
		case 1:		$id = uddeIMgetItemidComponent("com_comprofiler", $config);		// CB
					break;
		case 2:		$id = uddeIMgetItemidComponent("com_fireboard", $config);		// FB
					break;
		case 3:		$id = uddeIMgetItemidComponent("com_agora", $config); 			// Agora
					break;
		case 4:		$id = uddeIMgetItemidComponent("com_cbe", $config);				// CBE
					break;
		case 5:	
		case 9:	
		case 11:
		case 12:	$id = uddeIMgetItemidComponent("com_kunena", $config);			// KUNENA, KUNENA 1.6+, 2.0, 3.0
					break;
		case 6:		$id = uddeIMgetItemidComponent("com_community", $config);		// JOMSOCIAL
					break;
		case 7:		$id = uddeIMgetItemidComponent("com_alphauserpoints", $config);	// AlphaUserPoints
					break;
		case 8:		$id = uddeIMgetItemidComponent("com_joocm", $config);			// JooCM
					break;
		case 10:	$id = uddeIMgetItemidComponent("com_ninjaboard", $config);		// NINJABOARD
					break;
		case 13:	$id = uddeIMgetItemidComponent("com_comprofiler", $config);		// CB 2
					break;
	}
	return $id;
}

function uddeIMshowThumbOrLink($id, $name, $config) {

	if ($config->getpiclink) {		// show lists with picture
		$ret = uddeIMgetPicLink($id, $name, $config);
	} else {						// show lists without picture
		$ret = uddeIMgetLinkOnly($id, $name, $config);
	}
	return $ret;
}

// these functions are only called when $config->showcblink=1
function uddeIMgetPicLink($ofanid, $ofaname, $config) {	// PICTURE + LINK
	$gimmeback = uddeIMgetPicOnly($ofanid, $config);
	if ($gimmeback)
		$gimmeback .= "<br />";
	$gimmeback .= uddeIMgetLinkOnly($ofanid, $ofaname, $config);
	return $gimmeback;
}


function uddeIMgetLinkOnly($ofanid, $ofaname, $config) {	// LINK only
	$database = uddeIMgetDatabase();
	$itemid = "";
	if ($config->cbitemid)
		$itemid = "&Itemid=".$config->cbitemid;
	$gimmeback = "";

	if ($config->showcblink==1) {			// CB
		$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_comprofiler&task=userProfile&user=".(int)$ofanid.$itemid)."'>".$ofaname."</a>";
	} elseif ($config->showcblink==2) {		// FB
		$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_fireboard&task=showprf&func=fbprofile&userid=".(int)$ofanid.$itemid)."'>".$ofaname."</a>";
	} elseif ($config->showcblink==3) {		// Agora
		$sql = "SELECT id FROM `#__agora_users` WHERE jos_id=".(int)$ofanid;
		$database->setQuery($sql);
		$agoraid = (int)$database->loadResult($sql);
		if ($agoraid)
			$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_agora&task=profile&id=".(int)$agoraid.$itemid)."'>".$ofaname."</a>";
		else
			$gimmeback = $ofaname;			// user has not visited the forum before, so no agora profile exists
	} elseif ($config->showcblink==4) {		// CBE
		$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_cbe&task=userProfile&user=".(int)$ofanid.$itemid)."'>".$ofaname."</a>";
	} elseif ($config->showcblink==5) {		// KUNENA
		$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_kunena&task=showprf&func=fbprofile&userid=".(int)$ofanid.$itemid)."'>".$ofaname."</a>";
	} elseif ($config->showcblink==6) {		// JOMSOCIAL
		$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_community&view=profile&userid=".(int)$ofanid.$itemid)."'>".$ofaname."</a>";
	} elseif ($config->showcblink==7) {		// AUP
		$api_AUP = JPATH_SITE.'/components/com_alphauserpoints/helper.php';
		if (file_exists($api_AUP)) {
			require_once($api_AUP);
			$linktoAUPprofil = AlphaUserPointsHelper::getAupLinkToProfil($ofanid);
			$gimmeback = "<a href='".$linktoAUPprofil."'>".$ofaname."</a>";
		}
	} elseif ($config->showcblink==8) {		// JooCM
		$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_joocm&view=profile&layout=joocm&id=".(int)$ofanid.$itemid)."'>".$ofaname."</a>";
	} elseif ($config->showcblink==9) {		// KUNENA 1.6
		$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_kunena&func=profile&userid=".(int)$ofanid.$itemid)."'>".$ofaname."</a>";
	} elseif ($config->showcblink==10) {	// NINJABOARD
		$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_ninjaboard&view=person&id=".(int)$ofanid.$itemid)."'>".$ofaname."</a>";
	} elseif ($config->showcblink==11) {	// KUNENA 2.0
		$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_kunena&func=profile&userid=".(int)$ofanid.$itemid)."'>".$ofaname."</a>";
	} elseif ($config->showcblink==12) {	// KUNENA 3.0
		$gimmeback = "<a href='".uddeIMsefRelToAbs("index.php?option=com_kunena&func=profile&userid=".(int)$ofanid.$itemid)."'>".$ofaname."</a>";
	} elseif ($config->showcblink==13) {	// CB 2.0

		global $_PLUGINS;
		if ( ( ! file_exists( JPATH_SITE . '/libraries/CBLib/CBLib/Core/CBLib.php' ) ) || ( ! file_exists( JPATH_ADMINISTRATOR . '/components/com_comprofiler/plugin.foundation.php' ) ) ) {
			return 'CB not installed';
		}
		include_once( JPATH_ADMINISTRATOR . '/components/com_comprofiler/plugin.foundation.php' );

		$gimmeback = CBuser::getInstance( (int) $ofanid, false )->getField( 'formatname', null, 'html', 'none', 'list', 0, true );
	} else {
		$gimmeback = $ofaname;
	}
	return $gimmeback;
}

function uddeIMgetPicOnly($ofanid, $config, $noanchor=false) {		// PIC only
	$mosConfig_lang = uddeIMgetLang(); 
	$database = uddeIMgetDatabase();
	$gimmeback = "";

	$grsize = 80;
	if ($config->avatarw)
		$grsize = $config->avatarw;

	$picstyle = "";
	if ($config->avatarw || $config->avatarh) {
		$picstyle = " style='";
		if ($config->avatarw)
			$picstyle .= "max-width: ".$config->avatarw."px; ";
		if ($config->avatarh)
			$picstyle .= "max-height: ".$config->avatarh."px; ";
		$picstyle .= "'";
	}

	if ($config->showcbpic==1) {	// CB

		if (is_dir(uddeIMgetPath('absolute_path')."/components/com_comprofiler/plugin/language/".$mosConfig_lang."/images"))
			$fileLang=$mosConfig_lang;
		else
			$fileLang="default_language";

		$sql="SELECT avatar FROM `#__comprofiler` WHERE user_id=".(int)$ofanid." LIMIT 1";
		$database->setQuery($sql);
		$ofanavatar=$database->loadResult();

		$filenamelocal  = "/images/comprofiler/tn".$ofanavatar;									// Thumbnail
		$filenamelive   = uddeIMgetPath('live_site')    ."/images/comprofiler/tn".$ofanavatar;	// Thumbnail

		$filenameglocal = "/images/comprofiler/".$ofanavatar;									// Gallery
		$filenameglive  = uddeIMgetPath('live_site')    ."/images/comprofiler/".$ofanavatar;	// Gallery

		// NOPHOTO for CB
		$filename2local = "/components/com_comprofiler/plugin/language/".$fileLang."/images/tnnophoto.jpg";
		$filename2live  = uddeIMgetPath('live_site')    ."/components/com_comprofiler/plugin/language/".$fileLang."/images/tnnophoto.jpg";

		// NOPHOTO for CBE
		$filename3local = "/images/".$fileLang."/tnnophoto.jpg";
		$filename3live  = uddeIMgetPath('live_site')    ."/images/".$fileLang."/tnnophoto.jpg";

		// NOPHOTO for CB 2.0
		$filename4local = "/components/com_comprofiler/plugin/templates/default/images/avatar/tnnophoto_n.png";
		$filename4live  = uddeIMgetPath('live_site')    ."/components/com_comprofiler/plugin/templates/default/images/avatar/tnnophoto_n.png";


		if (uddeIMfileExists($filenamelocal)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filenamelive."' alt='' />";
		} elseif (uddeIMfileExists($filenameglocal) && $config->CBgallery) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filenameglive."' alt='' />";
		} elseif ($config->gravatar) {
			$email = uddeIMgetEMailFromID((int)$ofanid, $config);
			$grurl = uddeIMgetGravatar($email, $grsize, $config->gravatard, $config->gravatarr);
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$grurl."' alt='' />";
		} elseif (uddeIMfileExists($filename4local)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename4live."' alt='' />";
		} elseif (uddeIMfileExists($filename2local)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename2live."' alt='' />";
		} elseif (uddeIMfileExists($filename3local)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename3live."' alt='' />";
		} else {
			$imgurl = "NOPHOTO";
		}
		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	} elseif ($config->showcbpic==2) {		// FB

		$sql="SELECT avatar FROM `#__fb_users` WHERE userid=".(int)$ofanid." LIMIT 1";
		$database->setQuery($sql);
		$ofanavatar=$database->loadResult();

		$filenameglocal = "/images/fbfiles/avatars/".$ofanavatar;									// Gallery
		$filenameglive  = uddeIMgetPath('live_site')    ."/images/fbfiles/avatars/".$ofanavatar;	// Gallery

		$filename2local = "/images/fbfiles/avatars/s_nophoto.jpg";
		$filename2live  = uddeIMgetPath('live_site')    ."/images/fbfiles/avatars/s_nophoto.jpg";

		if (uddeIMfileExists($filenameglocal)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filenameglive."' alt='' />";
		} elseif ($config->gravatar) {
			$email = uddeIMgetEMailFromID((int)$ofanid, $config);
			$grurl = uddeIMgetGravatar($email, $grsize, $config->gravatard, $config->gravatarr);
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$grurl."' alt='' />";
		} elseif (uddeIMfileExists($filename2local)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename2live."' alt='' />";
		}

		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	} elseif ($config->showcbpic==3) {		// Agora

		$adir = "";
		$useavatars = 0;
		if (uddeIMfileExists("/components/com_agora/cache/cache_config.php")) {
			include(uddeIMgetPath('absolute_path')."/components/com_agora/cache/cache_config.php");
			if (isset($agora_config['o_avatars_dir'])) {
				$adir = $agora_config['o_avatars_dir'];
			}
			if (isset($agora_config['o_avatars'])) {
				$useavatars = $agora_config['o_avatars'];
			}
		}
		if (!$adir)
			return $gimmeback;

		$sql = "SELECT id, show_avatars FROM `#__agora_users` WHERE jos_id=".(int)$ofanid;
		$database->setQuery($sql);

		$results = $database->loadObjectList();
		if (!$results) {
			$agoraid = "notfound";
			$showavatars = 0;
		} else {
			foreach($results as $result) {
				$agoraid 	 = $result->id;
				$showavatars = $result->show_avatars;
			}
		}

		$pic1 = "/".$agoraid.".gif";
		$pic2 = "/".$agoraid.".jpg";
		$pic3 = "/".$agoraid.".png";
		
		$filename1local = "/".$adir.$pic1;
		$filename1live  = uddeIMgetPath('live_site')    ."/".$adir.$pic1;
		$filename2local = "/".$adir.$pic2;
		$filename2live  = uddeIMgetPath('live_site')    ."/".$adir.$pic2;
		$filename3local = "/".$adir.$pic3;
		$filename3live  = uddeIMgetPath('live_site')    ."/".$adir.$pic3;
		$filename4local = "/".$adir."/noavatar_sm.gif";
		$filename4live  = uddeIMgetPath('live_site')    ."/".$adir."/noavatar_sm.gif";

		if (uddeIMfileExists($filename1local) && $useavatars && $showavatars) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename1live."' alt='' />";
		} elseif (uddeIMfileExists($filename2local) && $useavatars && $showavatars) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename2live."' alt='' />";
		} elseif (uddeIMfileExists($filename3local) && $useavatars && $showavatars) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename3live."' alt='' />";
		} elseif ($config->gravatar) {
			$email = uddeIMgetEMailFromID((int)$ofanid, $config);
			$grurl = uddeIMgetGravatar($email, $grsize, $config->gravatard, $config->gravatarr);
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$grurl."' alt='' />";
		} elseif (uddeIMfileExists($filename4local)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename4live."' alt='' />";
		}

		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	} elseif ($config->showcbpic==4) {	// CBE (new)

		if (is_dir(uddeIMgetPath('absolute_path')."/components/com_cbe/plugin/language/".$mosConfig_lang."/images"))
			$fileLang=$mosConfig_lang;
		else
			$fileLang="default_language";

		$sql="SELECT avatar FROM `#__cbe` WHERE user_id=".(int)$ofanid." LIMIT 1";
		$database->setQuery($sql);
		$ofanavatar=$database->loadResult();

		$filenamelocal  = "/images/cbe/tn".$ofanavatar;									// Thumbnail
		$filenamelive   = uddeIMgetPath('live_site')    ."/images/cbe/tn".$ofanavatar;	// Thumbnail

		$filenameglocal = "/images/cbe/".$ofanavatar;									// Gallery
		$filenameglive  = uddeIMgetPath('live_site')    ."/images/cbe/".$ofanavatar;	// Gallery

		// NOPHOTO for CBE new
		$filename3local = "/components/com_cbe/images/".$fileLang."/tnnophoto.jpg";
		$filename3live  = uddeIMgetPath('live_site')    ."/components/com_cbe/images/".$fileLang."/tnnophoto.jpg";

		if (uddeIMfileExists($filenamelocal)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filenamelive."' alt='' />";
		} elseif (uddeIMfileExists($filenameglocal) && $config->CBgallery) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filenameglive."' alt='' />";
		} elseif ($config->gravatar) {
			$email = uddeIMgetEMailFromID((int)$ofanid, $config);
			$grurl = uddeIMgetGravatar($email, $grsize, $config->gravatard, $config->gravatarr);
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$grurl."' alt='' />";
		} elseif (uddeIMfileExists($filename3local)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename3live."' alt='' />";
		}

		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	} elseif ($config->showcbpic==5) {		// KUNENA

		$sql="SELECT avatar FROM `#__fb_users` WHERE userid=".(int)$ofanid." LIMIT 1";
		$database->setQuery($sql);
		$ofanavatar=$database->loadResult();

		$filenameglocal = "/images/fbfiles/avatars/".$ofanavatar;									// Gallery
		$filenameglive  = uddeIMgetPath('live_site')    ."/images/fbfiles/avatars/".$ofanavatar;	// Gallery

		$filename2local = "/images/fbfiles/avatars/s_nophoto.jpg";
		$filename2live  = uddeIMgetPath('live_site')    ."/images/fbfiles/avatars/s_nophoto.jpg";

		if (uddeIMfileExists($filenameglocal)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filenameglive."' alt='' />";
		} elseif ($config->gravatar) {
			$email = uddeIMgetEMailFromID((int)$ofanid, $config);
			$grurl = uddeIMgetGravatar($email, $grsize, $config->gravatard, $config->gravatarr);
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$grurl."' alt='' />";
		} elseif (uddeIMfileExists($filename2local)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename2live."' alt='' />";
		}

		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	} elseif ($config->showcbpic==6) {		// JOMSOCIAL, no gravatar

		if (class_exists('CFactory')) {
			$jsuser = CFactory::getUser((int)$ofanid);
			$filenameglive = $jsuser->getThumbAvatar();
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filenameglive."' alt='' />";
		}

		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	} elseif ($config->showcbpic==7) {		// AUP, no gravatar

		$api_AUP = JPATH_SITE.'/components/com_alphauserpoints/helper.php';
		if ( file_exists($api_AUP) ) {
			require_once($api_AUP);
			if ($config->avatarw && $config->avatarh)
				$avatar = AlphaUserPointsHelper::getAupAvatar($ofanid, 0, $config->avatarw, $config->avatarh);
			else
				$avatar = AlphaUserPointsHelper::getAupAvatar($ofanid, 0);	// [int $width], [int $height]
			$imgurl = $avatar;
		}

		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	} elseif ($config->showcbpic==8) {		// JooCM

		$avatarFile = "";
		$sql = "SELECT a.* FROM `#__joocm_avatars` AS a INNER JOIN `#__joocm_users` AS u ON u.id_avatar = a.id WHERE u.id = ".(int)$ofanid;
		$database->setQuery($sql);
		$avatar = $database->loadObject();
		if (is_object($avatar)) {
			$pos = strpos($avatar->avatar_file, 'http://');
			if ($pos === false) {
				if ($avatar->avatar_file) {
					$avatarFile = uddeIMgetPath('live_site')."/media/joocm/avatars/";
					if ($avatar->id_user) {
						$avatarFile .= $avatar->id_user.'/'.$avatar->avatar_file;
					} else {
						$avatarFile .= 'standard/'.$avatar->avatar_file;
					}
				}
			} else {
				$avatarFile = $avatar->avatar_file;
			}
		}
		if (!$avatarFile) {
			if ($config->gravatar) {
				$email = uddeIMgetEMailFromID((int)$ofanid, $config);
				$avatarFile = uddeIMgetGravatar($email, $grsize, $config->gravatard, $config->gravatarr);
			} else {
				$avatarFile = uddeIMgetPath('live_site').'/media/joocm/avatars/standard/_cm_noavatar.png';
			}
		}

		if ($avatarFile) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$avatarFile."' alt='' />";
		}

		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	} elseif ($config->showcbpic==9) {		// KUNENA 1.6+

		$sql="SELECT avatar FROM `#__kunena_users` WHERE userid=".(int)$ofanid." LIMIT 1";
		$database->setQuery($sql);
		$ofanavatar=$database->loadResult();

		$filenameglocal = "/media/kunena/avatars/".$ofanavatar;
		$filenameglive  = uddeIMgetPath('live_site')    ."/media/kunena/avatars/".$ofanavatar;

		$filename2local = "/media/kunena/avatars/s_nophoto.jpg";
		$filename2live  = uddeIMgetPath('live_site')    ."/media/kunena/avatars/s_nophoto.jpg";

		if (uddeIMfileExists($filenameglocal)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filenameglive."' alt='' />";
		} elseif ($config->gravatar) {
			$email = uddeIMgetEMailFromID((int)$ofanid, $config);
			$grurl = uddeIMgetGravatar($email, $grsize, $config->gravatard, $config->gravatarr);
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$grurl."' alt='' />";
		} elseif (uddeIMfileExists($filename2local)) {
			$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filename2live."' alt='' />";
		}

		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	} elseif ($config->showcbpic==10) {		// NINJABOARD

		$filenameglive  = uddeIMgetPath('live_site')    ."/index.php?view=avatar&id=".$ofanid."&thumbnail=large";
		$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$filenameglive."' alt='' />";

		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	} elseif ($config->showcbpic==11 || $config->showcbpic==12) {		// KUNENA 2.0+, 3.0+

		$sizex = $sizey = $grsize;
		$class = 'avatar';
		
		KunenaForum::setup();
	    $isInstalled = KunenaForum::installed ();
		if ($isInstalled) {

			$user = KunenaUserHelper::get($ofanid);
			$avatarUrl = $user->getAvatarURL($sizex, $sizey);
			// Get avatar <img> tag
			$avatarHtml = $user->getAvatarImage($class, $sizex, $sizey);
			// Get profile link with avatar pointing to profile page
			$userLink = $user->getLink(null, $avatarHtml);

			$filenameglocal = $avatarUrl;
			$filenameglive  = $avatarHtml;

	  		if (!empty($avatarUrl)) {			
				$imgurl = $filenameglive;
			} elseif ($config->gravatar) {
				$email = uddeIMgetEMailFromID((int)$ofanid, $config);
				$grurl = uddeIMgetGravatar($email, $grsize, $config->gravatard, $config->gravatarr);
				$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$grurl."' alt='' />";
			} else {
				$imgurl = "";
			}

			if ($noanchor)
				$gimmeback = $imgurl;
			else
				$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

		} 
	} elseif ($config->showcbpic==13) {	// CB 2.0

		global $_PLUGINS;
		if ( ( ! file_exists( JPATH_SITE . '/libraries/CBLib/CBLib/Core/CBLib.php' ) ) || ( ! file_exists( JPATH_ADMINISTRATOR . '/components/com_comprofiler/plugin.foundation.php' ) ) ) {
			return 'CB not installed';
		}
		include_once( JPATH_ADMINISTRATOR . '/components/com_comprofiler/plugin.foundation.php' );
 
		global $_CB_framework;
		$cbUser =& CBuser::getInstance( $ofanid );
		if ( !$cbUser )
			$cbUser =& CBuser::getInstance( null );
		$avatar	= $cbUser->getField( 'avatar', null, 'html', 'none', 'list', 0, true );
		$name   = $cbUser->getField( 'formatname', null, 'html', 'none', 'list', 0, true );

		if ($noanchor)
			$gimmeback = $avatar;
		else
			$gimmeback = $avatar;

	} elseif ($config->showcbpic==0 && $config->gravatar) {		// disabled, but gravatar enabled
		$email = uddeIMgetEMailFromID((int)$ofanid, $config);
		$grurl = uddeIMgetGravatar($email, $grsize, $config->gravatard, $config->gravatarr);
		$imgurl = "<img class='uddeim-tn'".$picstyle." src='".$grurl."' alt='' />";

		if ($noanchor)
			$gimmeback = $imgurl;
		else
			$gimmeback = uddeIMgetLinkOnly($ofanid, $imgurl, $config);

	}
	return $gimmeback;
}

function uddeIMgetStyleForThumb($config) {
	$st = "style='text-align:center; vertical-align:middle";
	if ($config->getpiclink) {
		if ($config->avatarw)
			$st .= "; width:".((int)$config->avatarw + 64)."px";
		if ($config->avatarh)
			$st .= "; height:".((int)$config->avatarh + 16)."px";
	}
	$st .= ";'";
	return $st;
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function uddeIMgetGravatar($email, $s=80, $d='mm', $r='g', $img=false, $atts=array()) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' '.$key.'="'.$val.'"';
        $url .= ' />';
    }
    return $url;
}
