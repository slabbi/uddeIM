<?php
// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo & Joomla
// Author         © 2007-2015 Stephan Slabihoud
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

global $uddeim_isadmin;
global $ver;

if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	$ver = new JVersion();
	if (!strncasecmp($ver->RELEASE, "3.8", 3)) {
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib38.php');
	} elseif (!strncasecmp($ver->RELEASE, "3.3", 3) ||
			  !strncasecmp($ver->RELEASE, "3.4", 3) ||
			  !strncasecmp($ver->RELEASE, "3.5", 3) ||
			  !strncasecmp($ver->RELEASE, "3.6", 3) ||
			  !strncasecmp($ver->RELEASE, "3.7", 3)) {
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib33.php');
	} elseif (!strncasecmp($ver->RELEASE, "3.2", 3)) {
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib32.php');
	} elseif (!strncasecmp($ver->RELEASE, "3.1", 3)) {
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib31.php');
	} elseif (!strncasecmp($ver->RELEASE, "3.0", 3)) {
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib30.php');
	} elseif (!strncasecmp($ver->RELEASE, "2.5", 3)) {
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib25.php');
	} elseif (!strncasecmp($ver->RELEASE, "1.5", 3)) {
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib15.php');
	} elseif (!strncasecmp($ver->RELEASE, "1.6", 3)) {
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib16.php');
	} elseif (!strncasecmp($ver->RELEASE, "1.7", 3)) {
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib17.php');
	} else {
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib38.php');
	}
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/administrator/components/com_uddeim/admin.uddeimlib10.php');
}
