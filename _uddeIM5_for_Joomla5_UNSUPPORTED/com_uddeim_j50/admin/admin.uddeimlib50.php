<?php
// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         � 2007-2010 Stephan Slabihoud
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\HTML\Helpers;
//use Joomla\CMS\HTML\Helpers\Bootstrap;

global $uddeim_isadmin;

function uddeIMcompTitle($title) {
    ToolBarHelper::title($title);
}

function uddeIMredirectIndex() {
    $index = "index.php";
    return $index;
}

// Class checks to ensure that wrapper classes are only defined when legacy mode is not enabled

if (!class_exists('mosMenuBar')) {
    //JLoader::register('ToolbarHelper' , JPATH_ADMINISTRATOR.'/includes/toolbar.php');
class mosMenuBar extends ToolbarHelper {
        static function startTable() {
            return;
        }
        static function endTable() {
            return;
        }
        static function addNew($task = 'new', $alt = 'New', $check = false) {
            parent::addNew($task, $alt, $check);
        }
        static function addNewX($task = 'new', $alt = 'New') {
            parent::addNew($task, $alt);
        }
        static function customX($task = 'new', $icon = '', $iconOver = '', $alt = 'New', $listSelect = false) {
            parent::custom($task, $icon, $iconOver, $alt, $listSelect);
        }
        static function saveedit() {
            parent::save('saveedit');
        }
    }
}

// function jimport( $path ) {
//  return require_once(JPATH_LIBRARIES.'/libraries/'. str_replace('.','/',$path) . '.php');
//}
if (!class_exists('mosTabs')) {
    // jimport('joomla.html.pane');
    //jimport( 'joomla.html.html.tabs' );
    // JLoader::register('JPaneTabs', JPATH_LIBRARIES.'/joomla/html/pane.php');
    class mosTabs {
        var $tuseCookies = false;
        var $tpane = false;
        function __construct( $useCookies, $xhtml = null) {
            $this->tuseCookies = $useCookies;
        }
        function startTab( $tabText, $paneid ) {
            echo HTMLHelper::_('bootstrap.addTab', $this->tpane, $paneid, $tabText);
        }
        function endTab() {
            echo HTMLHelper::_('bootstrap.endTab');
        }
        function startPane( $tabText ){
            $options = array(
                'active' => 'home',
                'useCookie' => $this->tuseCookies
            );
            $this->tpane = $tabText;
            echo HTMLHelper::_('bootstrap.startTabSet', $tabText, $options);
        }
        function endPane(){
            echo HTMLHelper::_('bootstrap.endTabSet', $this->tpane);
        }
    }
}

if (!class_exists('mosHTML')) {
    class mosHTML {
        static function makeOption( $value, $text='', $value_name='value', $text_name='text' ) {
            $temp = HTMLHelper::_('select.option', $value, $text, $value_name, $text_name);
            return $temp;
        }
        static function selectList( &$arr, $tag_name, $tag_attribs, $key, $text, $selected=NULL, $idtag=false, $flag=false ) {
            return HTMLHelper::_('select.genericlist', $arr, $tag_name, $tag_attribs, $key, $text, $selected, $idtag, $flag );
        }
        static function radioList( &$arr, $tag_name, $tag_attribs, $selected=null, $key='value', $text='text', $idtag=false ) {
            $temp  = '<fieldset id="jform_'.$tag_name.'" class="radio">';
            $temp .= HTMLHelper::_('select.radiolist', $arr, $tag_name, $tag_attribs, $key, $text,  $selected, $idtag) ;
            $temp .= '</fieldset>';
            return $temp;
        }
        static function yesnoRadioList( $tag_name, $tag_attribs, $selected, $yes='yes', $no='no', $id=false ) {
            $temp  = '<fieldset id="jform_'.$tag_name.'" class="radio">';
            $temp .= HTMLHelper::_('select.booleanlist',  $tag_name, $tag_attribs, $selected, $yes, $no, $id );
            $temp .= '</fieldset>';
            return $temp;
        }
        static function yesnoSelectList( $tag_name, $tag_attribs, $selected, $yes='yes', $no='no' ) {
            $arr = array(
                mosHTML::makeOption( 0, JText::_( $no ) ),
                mosHTML::makeOption( 1, JText::_( $yes ) ),
            );
            return mosHTML::selectList( $arr, $tag_name, $tag_attribs, 'value', 'text', (int) $selected );
        }
    }
}
