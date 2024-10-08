<?php
// ********************************************************************************************
// @title         udde Instant Messages (uddeIM)
// @description   Instant Messages System for Joomla 5, admin library
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

use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\HTML\Helpers;
use Joomla\CMS\Language\Text;
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
        static function yesnoButton($tag_name, $selected=null, $condition=false, $key='value'){
            $temp = '<fieldset id="jform_'.$tag_name.'" class="radio btn-group"' .($condition ? 'disabled="disabled"' : ''). '>';
            $temp .= '<input type="radio" id="'.$tag_name.'0" value="0" name="'.$tag_name.'" '.(!$selected ? 'checked="checked"' : '').' />';
            $temp .= '<label class="btn btn-outline-danger" for="'.$tag_name.'0" >'._UDDEADM_NO.'</label>';
            $temp .= '<input type="radio" id="'.$tag_name.'1" value="1" name="'.$tag_name.'" '.($selected ? 'checked="checked"' : '').' />';
            $temp .= '<label class="btn btn-outline-success" for="'.$tag_name.'1">'._UDDEADM_YES.'</label>';
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
                mosHTML::makeOption( 0, Text::_( $no ) ),
                mosHTML::makeOption( 1, Text::_( $yes ) ),
            );
            return mosHTML::selectList( $arr, $tag_name, $tag_attribs, 'value', 'text', (int) $selected );
        }
    }
}
