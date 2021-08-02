<?php
// ********************************************************************************************
// Title          Module to show statistics about udde Instant Messages (uddeIM)
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

$uddeim_isadmin = 0;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib.php');
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
	$uddmosConfig_offset = uddeIMgetOffset();
	$uddrightnow=time()+(($uddmosConfig_offset+$uddtimezone)*3600);
	return $uddrightnow;
}
