<?php
// ------------------  standard plugin initialize function - don't change 
global $sh_LANG, $sefConfig;  
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change 

// ------------------  load language file - adjust as needed ----------------------------------------
$shLangIso = shLoadPluginLanguage( 'com_uddeim', $shLangIso, '_COM_SEF_SH_UDDE_MY-MESSAGES');
// ------------------  load language file - adjust as needed ----------------------------------------

shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('lang');
shRemoveFromGETVarsList('task');
shRemoveFromGETVarsList('Itemid');
shRemoveFromGETVarsList('messageid');
// optional removal of limit and limitstart
if (!empty($limit))      // use empty to test $limit as $limit is not allowed to be zero
  shRemoveFromGETVarsList('limit'); 
if (isset($limitstart))  // use isset to test $limitstart, as it can be zero
  shRemoveFromGETVarsList('limitstart');

$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_MY-MESSAGES'];

$task = isset($task) ? @$task : null;
switch ($task) {
case 'inbox':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_INBOX'];
	break;
case 'outbox':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_OUTBOX'];
	break;
case 'trashcan':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_TRASHCAN'];
	break;
case 'archive':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_ARCHIVE'];
	break;
case 'new':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_COMPOSE'];
	break;
case 'show':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_SHOW'].'/'.$messageid;
	break;
case 'showlists':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_SHOWLISTS'];
	break;
case 'createlists':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_CREATELISTS'].'/'.$listid;
	shRemoveFromGETVarsList('listid');
	break;
case 'editlists':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_EDITLISTS'].'/'.$listid;
	shRemoveFromGETVarsList('listid');
	break;
case 'deletelists':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_DELETELISTS'].'/'.$listid;
	shRemoveFromGETVarsList('listid');
	break;
case 'settings':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_SETTINGS'];
	break;
case 'restore':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_RESTORE'].'/'.$messageid;
	break;
case 'blockuser':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_BLOCKUSER'].'/'.$recip;
	shRemoveFromGETVarsList('recip');
	break;	
case 'delete':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_DELETE'].'/'.$messageid;
	break;
case 'forward':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_FORWARD'].'/'.$messageid;
	break;
case 'archivemessage':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_ARCHIVEMESSAGE'].'/'.$messageid;
	break;
case 'unarchive':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_UNARCHIVE'].'/'.$messageid;
	break;
case 'showout':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_SHOWOUT'].'/'.$messageid;
	break;
case 'forwardoutbox':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_FORWARDOUTBOX'].'/'.$messageid;
	break;
case 'deletefromoutbox':
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_DELETEOUTBOX'].'/'.$messageid;
	break;	
default:
	$title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_UDDE_INBOX'];	// slabbi: modification so SEF works with home page
	// $dosef = false;
	break;
	}



// ------------------  standard plugin finalize function - don't change 
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
      (isset($shLangName) ? @$shLangName : null));
}     
// ------------------  standard plugin finalize function - don't change 
