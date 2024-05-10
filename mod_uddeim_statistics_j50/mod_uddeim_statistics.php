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

$uddeim_isadmin = 0;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
}

$uddpathtoadmin = uddeIMgetPath('admin');
$uddpathtouser  = uddeIMgetPath('user');
$uddpathtosite  = uddeIMgetPath('live_site');
$udddatabase 	= uddeIMgetDatabase();
$uddmosConfig_lang = uddeIMgetLang();

require_once($uddpathtoadmin.'/config.class.php');
$uddconfig = new uddeimconfigclass();

if(!defined('_UDDEIM_INBOX')) {
	$uddpostfix = "";
	if ($uddconfig->languagecharset)
		$uddpostfix = ".utf8";
	if (file_exists($uddpathtoadmin.'/language'.$uddpostfix.'/'.$uddmosConfig_lang.'.php')) {
		include_once($uddpathtoadmin.'/language'.$uddpostfix.'/'.$uddmosConfig_lang.'.php');
	} elseif (file_exists($uddpathtoadmin.'/language'.$uddpostfix.'/english.php')) {
		include_once($uddpathtoadmin.'/language'.$uddpostfix.'/english.php');
	} elseif (file_exists($uddpathtoadmin.'/language/english.php')) {
		include_once($uddpathtoadmin.'/language/english.php');
	}
}

$uddshowall		= $params->get( 'uddshowall', 1 );
$uddshow7		= $params->get( 'uddshow7', 1 );
$uddshow30		= $params->get( 'uddshow30', 1 );
$uddshow365		= $params->get( 'uddshow365', 1 );

if ( defined( 'JPATH_ADMINISTRATOR' ) ) {	// this works in Joomla 1.5+
	if (file_exists($uddpathtouser.'/templates/'.$uddconfig->templatedir.'/css/uddemodule.css')) {
		$css = $uddpathtosite."/components/com_uddeim/templates/".$uddconfig->templatedir."/css/uddemodule.css"; 
		uddeIMaddCSS($css);
	} elseif(file_exists($uddpathtouser.'/templates/default/css/uddemodule.css')) {
		$css = $uddpathtosite."/components/com_uddeim/templates/default/css/uddemodule.css"; 
		uddeIMaddCSS($css);
	}
} else {
	if (file_exists($uddpathtouser.'/templates/'.$uddconfig->templatedir.'/css/uddemodule.css')) {
		echo '<link rel="stylesheet" href="'.$uddpathtosite.'/components/com_uddeim/templates/'.$uddconfig->templatedir.'/css/uddemodule.css" type="text/css" />';
	} elseif(file_exists($uddpathtouser.'/templates/default/css/uddemodule.css')) {
		echo '<link rel="stylesheet" href="'.$uddpathtosite.'/components/com_uddeim/templates/default/css/uddemodule.css" type="text/css" />';
	}
}

$uddout = "<div id='uddeim-module'>";

$uddsql="SELECT max(id) FROM `#__uddeim`";
$udddatabase->setQuery($uddsql);
$uddresult=(int)$udddatabase->loadResult();
$max = $uddresult;
if ( $uddshowall ) {
	$uddout .= "<p class='uddeim-module-body'>";
	$uddout .= $uddresult._UDDEMODULE_ALLDAYS;
	$uddout .= "</p>";
}

if ( $uddshow7 ) {
	$uddrightnow=moduddestatisticstime((int)$uddconfig->timezone);
	$uddtimeframe=$uddrightnow-(86400*7);

	$uddsql="SELECT min(datum) FROM `#__uddeim` WHERE datum>=".(int)$uddtimeframe;
	$udddatabase->setQuery($uddsql);
	$uddresult=(int)$udddatabase->loadResult();
	
	if (!$uddresult) {
		$uddresult = 0;
	} else {
		$uddsql="SELECT id FROM `#__uddeim` WHERE datum=".(int)$uddresult." LIMIT 1";
		$udddatabase->setQuery($uddsql);
		$uddresult=(int)$udddatabase->loadResult();
		$uddresult = $max - $uddresult + 1;
	}
	$uddout .= "<p class='uddeim-module-body'>";
	$uddout .= $uddresult._UDDEMODULE_7DAYS;
	$uddout .= "</p>";
}

if ( $uddshow30 ) {
	$uddrightnow=moduddestatisticstime((int)$uddconfig->timezone);
	$uddtimeframe=$uddrightnow-(86400*30);

	$uddsql="SELECT min(datum) FROM `#__uddeim` WHERE datum>=".(int)$uddtimeframe;
	$udddatabase->setQuery($uddsql);
	$uddresult=(int)$udddatabase->loadResult();
	
	if (!$uddresult) {
		$uddresult = 0;
	} else {
		$uddsql="SELECT id FROM `#__uddeim` WHERE datum=".(int)$uddresult." LIMIT 1";
		$udddatabase->setQuery($uddsql);
		$uddresult=(int)$udddatabase->loadResult();
		$uddresult = $max - $uddresult + 1;
	}
	$uddout .= "<p class='uddeim-module-body'>";
	$uddout .= $uddresult._UDDEMODULE_30DAYS;
	$uddout .= "</p>";
}

if ( $uddshow365 ) {
	$uddrightnow=moduddestatisticstime((int)$uddconfig->timezone);
	$uddtimeframe=$uddrightnow-(86400*365);

	$uddsql="SELECT min(datum) FROM `#__uddeim` WHERE datum>=".(int)$uddtimeframe;
	$udddatabase->setQuery($uddsql);
	$uddresult=(int)$udddatabase->loadResult();
	
	if (!$uddresult) {
		$uddresult = 0;
	} else {
		$uddsql="SELECT id FROM `#__uddeim` WHERE datum=".(int)$uddresult." LIMIT 1";
		$udddatabase->setQuery($uddsql);
		$uddresult=(int)$udddatabase->loadResult();
		$uddresult = $max - $uddresult + 1;
	}
	$uddout .= "<p class='uddeim-module-body'>";
	$uddout .= $uddresult._UDDEMODULE_365DAYS;
	$uddout .= "</p>";
}

$uddout .= "</div>";

echo $uddout;

function moduddestatisticstime($uddtimezone = 0) {
	//$uddmosConfig_offset = uddeIMgetOffset();
    $timezone = new \DateTimeZone(uddeIMgetOffset());
    $uddmosConfig_offset = $timezone->getOffset(new \DateTime)/3600;
    $uddrightnow=time()+(($uddmosConfig_offset+$uddtimezone)*3600);
	return $uddrightnow;
}
