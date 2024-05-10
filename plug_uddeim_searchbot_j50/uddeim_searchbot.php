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
use Joomla\CMS\Plugin\CMSPlugin;

$uddeim_isadmin = 0;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
}

if ( defined( 'JPATH_ADMINISTRATOR' ) ) {

		class plgSearchUddeim_searchbot extends CMSPlugin {
			public function onContentSearch($text, $phrase='', $ordering='', $areas=null) {
				$limit = $this->params->get('search_limit', 50);
				return plgSearchUddeIM16( $text, $phrase, $ordering, $areas, $limit );
			}
			public function onContentSearchAreas() {
				$areas = plgSearchUddeIMAreas();
				return $areas;
			}
		}
	}


$uddpathtoadmin = uddeIMgetPath('admin');
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

function plgSearchUddeIMAreas() {
	$areas = array(
		'messages' => _UDDEPLUGIN_MESSAGES
	);
	return $areas;
}



function plgSearchUddeIM16( $text, $phrase='', $ordering='', $areas=null, $limit=50 ) {
	$rows = plgSearchUddeIMmain( $text, $phrase, $ordering, $areas, $limit );
	$return = array();
	foreach($rows AS $key => $category) {
		if (checkNoHTML($category, $text, array('name', 'title', 'text'))) {
			$return[] = $category;
		}
	}
	return $return;
}

function checkNoHtml($object, $searchTerm, $fields) //copied from the old SearchHelper, don't know how to replace it
	{
		$searchRegex = array(
			'#<script[^>]*>.*?</script>#si',
			'#<style[^>]*>.*?</style>#si',
			'#<!.*?(--|]])>#si',
			'#<[^>]*>#i'
		);
		$terms = explode(' ', $searchTerm);

		if (empty($fields))
		{
			return false;
		}

		foreach ($fields as $field)
		{
			if (!isset($object->$field))
			{
				continue;
			}

			$text = remove_accents($object->$field);

			foreach ($searchRegex as $regex)
			{
				$text = preg_replace($regex, '', $text);
			}

			foreach ($terms as $term)
			{
				$term = remove_accents($term);

				if (Joomla\String\StringHelper::stristr($text, $term) !== false)
				{
					return true;
				}
			}
		}
		return false;
	}


function remove_accents($str) //copied from the old SearchHelper, don't know how to replace it
	{
		$str = Joomla\CMS\Language\Transliterate::utf8_latin_to_ascii($str);
		return preg_replace("/[\"'^]([a-z])/ui", '\1', $str);
	}



function plgSearchUddeIMmain( $text, $phrase='', $ordering='', $areas=null, $limit=50 ) {
	if (is_array( $areas )) {
		if (!array_intersect( $areas, array_keys( plgSearchUddeIMAreas() ) )) {
			return array();
		}
	}
	return botSearchUddeIM( $text, $phrase, $ordering, $limit );
}

function botSearchUddeIM( $text, $phrase='', $ordering='', $limit=50 ) {

	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		$database = Factory::getContainer()->get('DatabaseDriver');
		$user	  = Factory::getApplication()->getIdentity();
		$userid	  = $user->id;

	} else {
		global $database, $my;
		$userid = $my->id;
	}

	$text = trim( $text );
	if ($text == '') {
		return array();
	}

	$section = _UDDEPLUGIN_SEARCHSECTION;

	switch ( $ordering ) {
		case 'alpha':	$order = 'b.name ASC';
						break;
		case 'newest':	$order = 'a.datum DESC';
						break;
		case 'oldest':	$order = 'a.datum ASC';
						break;
		case 'category':
		case 'popular':
		default:		$order = 'a.datum ASC';
						break;
	}

	// ItemID missing
	$text = $database->Quote( '%'.$database->escape( $text, true ).'%' );
	$tsection = $database->Quote( $database->escape( $section, true ) );

	$query = "SELECT b.name AS title,"
	. "\n a.message AS text,"
	. "\n FROM_UNIXTIME(a.datum) AS created,"
	. "\n ".$tsection." AS section,"
	. "\n '2' AS browsernav,"
	. "\n a.cryptmode,"
	. "\n CONCAT( 'index.php?option=com_uddeim&task=show&messageid=', a.id ) AS href"
	. "\n FROM `#__uddeim` AS a"
	. "\n INNER JOIN `#__users` AS b ON a.fromid = b.id"
	. "\n WHERE ( a.message LIKE ".$text
	. "\n OR b.name LIKE ".$text
	. "\n OR b.username LIKE ".$text
	. "\n )"
	. "\n AND a.toid = ".(int)$userid
	. "\n AND a.totrash = 0"
//	. "\n AND a.cryptmode <= 1"
	. "\n AND a.cryptmode = 0"
	. "\n AND `a`.`delayed` = 0"
	. "\n GROUP BY a.id"
	. "\n ORDER BY $order";
	$database->setQuery( $query, 0, $limit );
	$rows = $database->loadObjectList();
//	$uddconfig = new uddeimconfigclass();
//	foreach($rows as $key => $row) {
//		$rows[$key]->href = 'index.php?option=com_uddeim&...';
//		$temp = uddeIMgetMessage($row->text, "", $row->cryptmode, $row->crypthash, $uddconfig->cryptkey);
//		$row->text = stripslashes($temp);
//	}
	return $rows;
}
