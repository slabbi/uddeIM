<?php

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

$uddeim_isadmin = 0;
if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib.php');
} else {
	global $mainframe;
	require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib.php');
}

if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	$ver = new JVersion();
	if (!strncasecmp($ver->RELEASE, "1.5", 3)) {
		JApplication::registerEvent( 'onSearch', 'plgSearchUddeIM15' );
		JApplication::registerEvent( 'onSearchAreas', 'plgSearchUddeIMAreas' );
		// $mainframe->registerEvent( 'onSearch', 'plgSearchUddeIM' );
		// $mainframe->registerEvent( 'onSearchAreas', 'plgSearchUddeIMAreas' );
	} else {
		jimport('joomla.plugin.plugin');
		class plgSearchUddeim_searchbot extends JPlugin {
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
} else {
	global $mainframe;
	$_MAMBOTS->registerFunction( 'onSearch', 'plgSearchUddeIM10' );
}

//$uddpathtouser  = uddeIMgetPath('user');
$uddpathtoadmin = uddeIMgetPath('admin');
$uddmosConfig_lang = uddeIMgetLang();

//require_once($uddpathtouser.'/crypt.class.php');
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

function plgSearchUddeIM10( $text, $phrase='', $ordering='' ) {
	global $database, $_MAMBOTS;
	if ( !isset($_MAMBOTS->_search_mambot_params['uddeim_searchbot']) ) {
		$query = "SELECT params FROM `#__mambots` WHERE element = 'uddeim_searchbot' AND folder = 'search'";
		$database->setQuery( $query );
		$database->loadObject($mambot);		
		$_MAMBOTS->_search_mambot_params['uddeim_searchbot'] = $mambot;
	}
	$mambot = $_MAMBOTS->_search_mambot_params['uddeim_searchbot'];	
	$botParams = new mosParameters( $mambot->params );
	$limit = $botParams->def( 'search_limit', 50 );
	$rows = plgSearchUddeIMmain( $text, $phrase, $ordering, null, $limit );
	return $rows;
}

function plgSearchUddeIM15( $text, $phrase='', $ordering='', $areas=null ) {
	$plugin = JPluginHelper::getPlugin('search', 'uddeim_searchbot');
	$pluginParams = new JParameter( $plugin->params );
	$limit = $pluginParams->def( 'search_limit', 50 );
	$rows = plgSearchUddeIMmain( $text, $phrase, $ordering, $areas, $limit );
	$return = array();
	foreach($rows AS $key => $category) {
		if (searchHelper::checkNoHTML($category, $text, array('name', 'title', 'text'))) {
			$return[] = $category;
		}
	}
	return $return;
}

function plgSearchUddeIM16( $text, $phrase='', $ordering='', $areas=null, $limit=50 ) {
	$rows = plgSearchUddeIMmain( $text, $phrase, $ordering, $areas, $limit );
	$return = array();
	foreach($rows AS $key => $category) {
		if (searchHelper::checkNoHTML($category, $text, array('name', 'title', 'text'))) {
			$return[] = $category;
		}
	}
	return $return;
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
		$database = JFactory::getDBO();
		$user	= JFactory::getUser();
		$userid	= $user->id;

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
	$text = $database->Quote( '%'.$database->getEscaped( $text, true ).'%' );
	$tsection = $database->Quote( $database->getEscaped( $section, true ) );

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
