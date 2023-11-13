<?php
/**
mod_uddeim_simple_notifier helper.php
update 2014-12-28
mod version 3.5.0
copyrights 2010 - 2014 Michal Prochaczek
licence GNU/GPL2
http://michal.prochaczek.pl
michal (at ) prochaczek ( dot) pl
*/

// No direct access
defined('_JEXEC') or die; 

use Joomla\CMS\Factory;
// class definition
class ModUddeimSimpleNotifierHelper {

/**
 * Returns a number of unreaded messages per user
 */

 public static function getNoMessages($userid) {
        // Obtain a database connection
		$db = Factory::getContainer()->get('DatabaseDriver');
		// Retrieve the shout
		$query = $db->getQuery(true)
            ->select('COUNT(' . $db->quoteName('toread') . ') AS ' . $db->quoteName('number') ) 
            ->from($db->quoteName('#__uddeim'))
            ->where($db->quoteName(toid) . ' = ' . (int)$userid . ' AND ' . $db->quoteName(toread) . ' =0');
		
		// Prepare the query
		$db->setQuery($query);
		
		// Load the list
		$result = $db->loadObjectList();
		$messages = $result[0]->number;
		// Return value
		return $messages;
    } //end getNoMessages
} //end ModUddeimSimpleNotifierHelper
