<?php
// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2010 Stephan Slabihoud
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

global $uddeim_isadmin;

function uddeIMcompTitle($title) {
	// not available
}

function uddeIMredirectIndex() {
	$index = "index.php";
	return $index;
}

// Class checks to ensure that wrapper classes are only defined when legacy mode is not enabled

if (!class_exists('mosMenuBar')) {
	// JLoader::register('JToolbarHelper' , JPATH_ADMINISTRATOR.DS.'includes'.DS.'toolbar.php');
	class mosMenuBar extends JToolbarHelper {
		function startTable() {
			return;
		}
		function endTable() {
			return;
		}
		function addNew($task = 'new', $alt = 'New') {
			parent::addNew($task, $alt);
		}
		function addNewX($task = 'new', $alt = 'New') {
			parent::addNew($task, $alt);
		}
		function saveedit() {
			parent::save('saveedit');
		}
	}
}

// function jimport( $path ) {
//  return require_once(JPATH_LIBRARIES.'/libraries/'. str_replace('.','/',$path) . '.php');
//}
if (!class_exists('mosTabs')) {
	// jimport('joomla.html.pane');
	JLoader::register('JPaneTabs', JPATH_LIBRARIES.DS.'joomla'.DS.'html'.DS.'pane.php');
	class mosTabs extends JPaneTabs {
		var $useCookies = false;
		function __construct( $useCookies, $xhtml = null) {
			parent::__construct( array('useCookies' => $useCookies) );
		}
		function startTab( $tabText, $paneid ) {
			echo $this->startPanel( $tabText, $paneid);
		}
		function endTab() {
			echo $this->endPanel();
		}
		function startPane( $tabText ){
			echo parent::startPane( $tabText );
		}
		function endPane(){
			echo parent::endPane();
		}
	}
}

if (!class_exists('mosHTML')) {
	class mosHTML {
		function makeOption( $value, $text='', $value_name='value', $text_name='text' ) {
			return JHTML::_('select.option', $value, $text, $value_name, $text_name);
		}
		function selectList( &$arr, $tag_name, $tag_attribs, $key, $text, $selected=NULL, $idtag=false, $flag=false ) {
			return JHTML::_('select.genericlist', $arr, $tag_name, $tag_attribs, $key, $text, $selected, $idtag, $flag );
		}
		function radioList( &$arr, $tag_name, $tag_attribs, $selected=null, $key='value', $text='text', $idtag=false ) {
			return JHTML::_('select.radiolist', $arr, $tag_name, $tag_attribs, $key, $text,  $selected, $idtag) ;
		}
		function yesnoRadioList( $tag_name, $tag_attribs, $selected, $yes='yes', $no='no', $id=false ) {
			return JHTML::_('select.booleanlist',  $tag_name, $tag_attribs, $selected, $yes, $no, $id ) ;
		}
		function yesnoSelectList( $tag_name, $tag_attribs, $selected, $yes='yes', $no='no' ) {
			$arr = array(
				mosHTML::makeOption( 0, JText::_( $no ) ),
				mosHTML::makeOption( 1, JText::_( $yes ) ),
			);
			return mosHTML::selectList( $arr, $tag_name, $tag_attribs, 'value', 'text', (int) $selected );
		}
	}
}
