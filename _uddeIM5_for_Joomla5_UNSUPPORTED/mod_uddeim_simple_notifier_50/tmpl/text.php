<?php
/**
mod_uddeim_simple_notifier template file text.php
Shows icon and full text about number of messages
update 2014-12-28
mod version 3.5.0
copyrights 2010 - 2014 Michal Prochaczek
licence GNU/GPL2
http://michal.prochaczek.pl
michal (at ) prochaczek ( dot) pl
*/

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
//set title - cases adjusted - see language files
	$LabelMessages = Text::plural('MOD_UDDEIM_SIMPLE_NUMBER_OF_MESSAGES', $nomessages);

$ClassText = '<div class="uddeim-notifier' . $moduleclass_sfx . '">';
echo $ClassText;

//displays notification image
if (($id) AND ($nomessages>0)) {
	echo '<a href="/index.php?option=com_uddeim">' .
	'<img src="' . URI::root() . 'media/mod_uddeim_simple_notifier/icons/' .
	$IconImg . '" title="' . $LabelMessages . '" alt="' . $nomessages . '"/></a>';
}

//displays number of messages
if (($DisplayNo) AND ($id) AND ($nomessages)) {
		echo '<a href="/index.php?option=com_uddeim" title="' . $LabelMessages . '"> &nbsp;' . $LabelMessages . ' </a>'; 
	} 
// displays no messages information
if ($DisplayZero==1) { 
		echo '<a href="/index.php?option=com_uddeim" title="' . $LabelMessages . '"> &nbsp;' . $LabelMessages . ' </a>'; 
	} 
	elseif ($DisplayZero==2) {
		echo '<a href="/index.php?option=com_uddeim" title="' . $LabelMessages . '"> &nbsp;' . $nomessages . ' </a>';
	}

echo '</div>';