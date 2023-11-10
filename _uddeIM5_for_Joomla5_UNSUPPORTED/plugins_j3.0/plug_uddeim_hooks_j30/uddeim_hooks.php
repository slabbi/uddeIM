<?php
// ********************************************************************************************
// Title          Plugin to use uddeIM Hooks (uddeIM Hooks)
// Description    Instant Messages System for Mambo and Joomla
// Author         © 2007-2014 Stephan Slabihoud
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

jimport('joomla.plugin.plugin');
class plgContentUddeim_hooks extends JPlugin {
	public function onAfterInitialise() {
		return true;
	}
}

class uddeIMhookclass {
	private $callbacks = Array();
	public function registerCallback($event, $callback) {
		$this->callbacks["$event"][] = $callback;
	}
	public function emit($event, $params) {
		if (array_key_exists("$event", $this->callbacks)) {
			foreach ($this->callbacks["$event"] as $callback) {
				if (is_callable($callback))
					call_user_func($callback, $params);
			}
		}
	}
}
global $uddeIMhook;
$uddeIMhook = new uddeIMhookclass();
