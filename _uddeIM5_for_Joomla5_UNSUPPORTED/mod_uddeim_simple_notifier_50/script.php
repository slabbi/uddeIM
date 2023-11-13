<?php
// No direct access to this file
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
/**
 * Script file of uddeIM Simple Notifier module, version 3.5.0
 */
class mod_uddeim_simple_notifierInstallerScript
{
	/**
	 * Method to install the extension
	 * $parent is the class calling this method
	 *
	 * @return void
	 */
	function install($parent) 
	{
		// $parent is the class calling this method
		// go to modules list
		// $parent->getParent()->setRedirectURL('index.php?option=com_modules');
		
		//echo '<p>' . JText::_('MOD_UDDEIM_SIMPLE_XML_DESCRIPTION') . '</p>';
		echo '<p>' . Text::_('MOD_UDDEIM_SIMPLE_INSTALL_TEXT') . '</p>';
		
	}
 
	/**
	 * Method to uninstall the extension
	 * $parent is the class calling this method
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		// $parent is the class calling this method
		//echo '<p>' . JText::_('MOD_UDDEIM_SIMPLE_XML_DESCRIPTION') . '</p>';
		echo '<p>' . Text::_('MOD_UDDEIM_SIMPLE_UNINSTALL_TEXT') . '</p>';
	}
 
	/**
	 * Method to update the extension
	 * $parent is the class calling this method
	 *
	 * @return void
	 */
	function update($parent) 
	{
		// $parent is the class calling this method
		//echo '<p>' . JText::_('MOD_UDDEIM_SIMPLE_XML_DESCRIPTION') . '</p>';
		echo '<p>' . Text::sprintf('MOD_UDDEIM_SIMPLE_UPDATE_TEXT', $parent->get('manifest')->version) . '</p>';
	}
 
	/**
	 * Method to run before an install/update/uninstall method
	 * $parent is the class calling this method
	 * $type is the type of change (install, update or discover_install)
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . Text::_('MOD_UDDEIM_SIMPLE_PREFLIGHT_' . $type . '_TEXT') . '</p>';
	}
 
	/**
	 * Method to run after an install/update/uninstall method
	 * $parent is the class calling this method
	 * $type is the type of change (install, update or discover_install)
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . Text::_('MOD_UDDEIM_SIMPLE_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
	}
}