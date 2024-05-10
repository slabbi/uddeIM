<?php
/**
@title mod_uddeim_simple_notifier
@description file mod_uddeim_simple_notifier.php
update 2024-03-28
@version mod version 5.0
@copyright 2010 - 2014 Michal Prochaczek
@license GNU/GPL2
@link http://michal.prochaczek.pl
@author michal (at ) prochaczek ( dot) pl
*/

// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

// Include the syndicate functions only once
require_once( dirname(__FILE__) . '/helper.php' );

// get a parameter from the module's configuration
$DisplayNo = $params->get('displaynumber', '1');
$DisplayZero = $params->get('displayzero', '0');
$IconImg = $params->get('icon', 'default.png');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx',''));

// get the no of messages to display from the helper but only for logged users
$user = Factory::getApplication()->getIdentity();
$id = $user->get('id');
if ($id) $nomessages = ModUddeimSimpleNotifierHelper::getNoMessages($id);
	else $nomessages = -1;

// include the template for display
require ModuleHelper::getLayoutPath('mod_uddeim_simple_notifier', $params->get('layout', 'default'));

