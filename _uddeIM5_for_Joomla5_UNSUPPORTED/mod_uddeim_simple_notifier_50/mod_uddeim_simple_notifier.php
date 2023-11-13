<?php
/**
mod_uddeim_simple_notifier module file mod_uddeim_simple_notifier.php
update 2014-12-28
mod version 5.0
copyrights 2010 - 2014 Michal Prochaczek
licence GNU/GPL2
http://michal.prochaczek.pl
michal (at ) prochaczek ( dot) pl
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
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

// get the no of messages to display from the helper but only for logged users
$user = Factory::getApplication()->getIdentity();
$id = $user->get('id');
if ($id) $nomessages = ModUddeimSimpleNotifierHelper::getNoMessages($id);
	else $nomessages = -1;

// include the template for display
require ModuleHelper::getLayoutPath('mod_uddeim_simple_notifier', $params->get('layout', 'default'));

