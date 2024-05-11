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

// library switch just used in CB to call the new uddeimlib50.php

defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );
require_once(JPATH_SITE . '/components/com_uddeim/uddeimlib50.php');


// may be for future settings
/*use Joomla\CMS\Version;

defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );

global $uddeim_isadmin;
global $ver;

    $ver = new Version();
    $shortVersion = $ver->getShortVersion();
    if (!strncasecmp($shortVersion, "5.3", 3) ||
        !strncasecmp($shortVersion, "5.2", 3) ||
        !strncasecmp($shortVersion, "5.1", 3) ||
        !strncasecmp($shortVersion, "5.0", 3) ||
        !strncasecmp($shortVersion, "4.4", 3) ||
        !strncasecmp($shortVersion, "4.3", 3)) {
        require_once(JPATH_SITE . '/components/com_uddeim/uddeimlib50.php');
    }
 */