<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Version;

class com_uddeimInstallerScript
{
	function install($parent) {
        echo '<p>' . Text::_('COM_UDDEIM_INSTALL_TEXT') . '</p>';
		uddeIM_com_install();
        // $parent->getParent()->setRedirectURL('index.php?option=com_uddeim');
    }
 
    function uninstall($parent) {
        echo '<p>' . Text::_('COM_UDDEIM_UNINSTALL_TEXT') . '</p>';
    }
 
    function update($parent) {
        echo '<p>' . Text::_('COM_UDDEIM_UPDATE_TEXT') . '</p>';
    }
 
    function preflight($type, $parent) {
        // $type is the type of change (install, update or discover_install)
        echo '<p>' . Text::_('COM_UDDEIM_PREFLIGHT_' . $type . '_TEXT') . '</p>';

        $ver = new Version();
		// Installing component manifest file version
		$this->release = $parent->getManifest()->version;
 		// Manifest file minimum Joomla version
		$this->minimum_joomla_release = $parent->getManifest()->attributes()->version;

        if ( version_compare( $ver->getShortVersion(), $this->minimum_joomla_release, 'lt' ) ) {
            Factory::getApplication()->enqueueMessage('Cannot install uddeIM in a Joomla release prior to '.$this->minimum_joomla_release, 'warning');
            return false;
        }

        if ( $type=='update' ) {
            $oldRelease = $this->getParam('version');
            $rel = $oldRelease . ' to ' . $this->release;
            if ( version_compare( $this->release, $oldRelease, 'lt' ) ) {		// lt/le
                Factory::getApplication()->enqueueMessage('Cannot upgrade ' . $rel, 'warning');
                return false;
            }
        }
	}
 
    function postflight($type, $parent) {
        // $type is the type of change (install, update or discover_install)
        echo '<p>' . Text::_('COM_UDDEIM_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
    }
	
	function getParam( $name ) {
		$db = Factory::getContainer()->get('DatabaseDriver');
		$db->setQuery('SELECT manifest_cache FROM `#__extensions` WHERE name = "uddeim"');
		$manifest = json_decode( $db->loadResult(), true );
		return $manifest[ $name ];
	}
	
	function setParams($param_array) {
		if ( count($param_array) > 0 ) {
			// read the existing component value(s)
			$db = Factory::getContainer()->get('DatabaseDriver');
			$db->setQuery('SELECT params FROM `#__extensions` WHERE name = "uddeim"');
			$params = json_decode( $db->loadResult(), true );
			// add the new variable(s) to the existing one(s)
			foreach ( $param_array as $name => $value ) {
				$params[ (string) $name ] = (string) $value;
			}
			// store the combined new and existing values back as a JSON string
			$paramsString = json_encode( $params );
			$db->setQuery('UPDATE `#__extensions` SET params = ' .
				$db->quote( $paramsString ) .
				' WHERE name = "uddeim"' );
				$db->execute();
		}
	}
}

function uddeIM_com_install() {
	$ver = new Version();

	if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
		require_once(JPATH_SITE.'/components/com_uddeim/uddeimlib50.php');
		require_once(JPATH_SITE.'/administrator/components/com_uddeim/admin.uddeimlib50.php');
	} else {
		global $mainframe;
		require_once($mainframe->getCfg('absolute_path').'/components/com_uddeim/uddeimlib50.php');
		require_once($mainframe->getCfg('absolute_path').'/administrator/components/com_uddeim/admin.uddeimlib50.php');
	}

	require_once(uddeIMgetPath('absolute_path')."/administrator/components/com_uddeim/config.class.php");
	require_once(uddeIMgetPath('absolute_path')."/administrator/components/com_uddeim/admin.shared.php");
	require_once(uddeIMgetPath('absolute_path')."/administrator/components/com_uddeim/admin.includes.php");

	$mosConfig_locale = uddeIMgetLocale();
	$mosConfig_sitename = uddeIMgetSitename();
	$mosConfig_lang = uddeIMgetLang();
	$database = uddeIMgetDatabase();
	$version = uddeIMgetVersion();
	$pathtoadmin = uddeIMgetPath('admin');
	$pathtouser  = uddeIMgetPath('user');
	$config = new uddeimconfigclass();

	// set initial values
	$config->cryptkey = 'uddeIMcryptkey';
	$config->version = '5.0';
	$config->datumsformat = 'j M, H:i';
	$config->ldatumsformat = 'j F Y, H:i';
	$config->emn_sendermail = 'webmaster';
	$config->emn_sendername = 'Messaging';
	$config->sysm_username = 'System';
	$config->charset = 'ISO-8859-1';
	$config->mailcharset = 'ISO-8859-1';
	$config->emn_body_nomessage = '';
	$config->emn_body_withmessage = '';
	$config->emn_forgetmenot = '';
	$config->export_format = '';
	$config->showtitle = '';
	$config->templatedir = 'default';
	$config->quotedivider= '__________';
	$config->blockgroups = '';
	$config->pubblockgroups = '';
	$config->hideusers = '62';
	$config->pubhideusers = '62';
	$config->attachmentgroups = '';
	$config->recaptchaprv = '';
	$config->recaptchapub = '';
	$config->allowedextensions = '';
	$config->badwords = '';
	$config->gravatard = '';
	$config->gravatarr = '';
	$config->groupsadmin = '';
	$config->groupsspecial = '';

	$config->ReadMessagesLifespan = 36524;
	$config->UnreadMessagesLifespan = 36524;
	$config->SentMessagesLifespan = 36524;
	$config->TrashLifespan = 2;
	$config->ReadMessagesLifespanNote = 0;
	$config->UnreadMessagesLifespanNote = 0;
	$config->SentMessagesLifespanNote = 0;
	$config->TrashLifespanNote = 1;
	$config->adminignitiononly = 1;
	$config->pmsimportdone = 0;
	$config->blockalert = 0;
	$config->blocksystem = 0;
	$config->allowemailnotify = 0;
	$config->notifydefault = 0;
	$config->popupdefault = 0;
	$config->allowsysgm = 0;
	$config->emailwithmessage = 0;
	$config->firstwordsinbox = 40;
	$config->longwaitingdays = 75;
	$config->longwaitingemail = 0;
	$config->maxlength = 2500;
	$config->showcblink = 0;
	$config->showmenulink = 0;
	$config->showcbpic = 0;
	$config->showonline = 1;
	$config->allowarchive = 0;
	$config->maxarchive = 100;
	$config->allowcopytome = 1;
	$config->trashoriginal = 1;
	$config->perpage = 8;
	$config->enabledownload = 0;
	$config->inboxlimit = 0;
	$config->showinboxlimit = 0;
	$config->allowpopup = 0;
	$config->allowbb = 1;
	$config->allowsmile = 1;
	$config->animated = 0;
	$config->animatedex = 0;
	$config->showmenuicons = 1;
	$config->bottomlineicons = 1;
	$config->actionicons = 1;
	$config->showconnex = 0;
	$config->showsettingslink = 2;
	$config->connex_listbox = 1;
	$config->forgetmenotstart = 0;
	$config->showabout = 0;
	$config->emailtrafficenabled = 0;
	$config->getpiclink = 0;
	$config->realnames = 0;
	$config->cryptmode = 0;
	$config->modeshowallusers = 1;
	$config->useautocomplete = 0;
	$config->allowmultipleuser = 1;
	$config->connexallowmultipleuser = 1;
	$config->allowmultiplerecipients = 1;
	$config->showtextcounter = 1;
	$config->allowforwards = 1;
	$config->showgroups = 0;
	$config->mailsystem = 0;
	$config->searchinstring = 1;
	$config->maxrecipients = 0;
	$config->languagecharset = 0;
	$config->usecaptcha = 0;
	$config->captchalen = 4;
	$config->pubfrontend = 0;
	$config->pubfrontenddefault = 0;
	$config->pubmodeshowallusers = 1;
	$config->hideallusers = 0;
	$config->pubhideallusers = 0;
	$config->unblockCBconnections = 1;
	$config->CBgallery = 0;
	$config->enablelists = 0;
	$config->maxonlists = 100;
	$config->timedelay = 0;
	$config->pubrealnames = 0;
	$config->pubreplies = 0;
	$config->pubemail = 0;
	$config->csrfprotection = 0;
	$config->trashrestriction = 0;
	$config->replytruncate = 0;
	$config->allowflagged = 0;
	$config->overwriteitemid = 0;
	$config->useitemid = 0;
	$config->timezone = 0;
	$config->pubsearchinstring = 1;
	$config->pubuseautocomplete = 0;
	$config->mootools = 1;
	$config->autoresponder = 0;
	$config->autoforward = 0;
	$config->rows = 10;
	$config->cols = 60;
	$config->width = 0;
	$config->enablefilter = 0;
	$config->enablereply = 0;
	$config->enablerss = 0;
	$config->showigoogle = 1;
	$config->showhelp = 0;
	$config->separator = 0;
	$config->rsslimit = 20;
	$config->restrictallusers = 0;
	$config->trashoriginalsent = 0;
	$config->reportspam = 0;
	$config->checkbanned = 0;
	$config->enableattachment = 0;
	$config->maxsizeattachment = 16384;
	$config->maxattachments = 1;
	$config->fileadminignitiononly = 1;
	$config->showlistattachment = 1;
	$config->showmenucount = 0;
	$config->encodeheader = 0;
	$config->enablesort = 0;
	$config->captchatype = 0;
	$config->unprotectdownloads = 0;
	$config->waitdays = 0;
	$config->avatarw = 0;
	$config->avatarh = 0;
	$config->gravatar = 0;
	$config->addccline = 0;
	$config->modnewusers = 0;
	$config->modpubusers = 0;
	$config->restrictcon = 0;
	$config->restrictrem = 0;
	$config->stime = 0;
	$config->dontsefmsglink = 0;
	$config->enablepostbox = 0;
	$config->postboxfull = 0;
	$config->postboxavatars = 0;
	$config->replytext = 1;
	// temporary variables
	$config->flags = 0;
	$config->userid = 0;
	$config->usergid = 0;
	$config->cbitemid = 0;

	$config->languagecharset = 1;					// use UTF-8 on Joomla != 1.0

	// try to determine the best settings for uddeIM on this installation 
	// is uddeIM already installed and are messages in the archive?
	$sql="SELECT count(id) FROM `#__uddeim` WHERE archived=1";
	$database->setQuery($sql);
	$archivedmessages=$database->loadResult();
	$config->allowarchive = 0;
	$config->enabledownload = 0;
	if ($archivedmessages) {
		$config->allowarchive = 1;
		$config->enabledownload = 1;	
	}

	switch ($mosConfig_lang) {
		case "germani":
		case "germanf":
		case "german":
			$config->datumsformat = 'j M, H:i';
			$config->ldatumsformat = 'j. F Y, H:i';
			break;
		default:
			$config->datumsformat = 'j M, H:i';
			$config->ldatumsformat = 'j F Y, H:i';
			break;
	}

	// is CB installed? CB only, NOT CBE!
	$config->showcblink = 0;
	$config->showcbpic = 0;
	$config->showconnex = 0;
	$config->checkbanned = 0;
	$config->realnames = 0;
	if (uddeIMfileExists("/components/com_comprofiler/comprofiler.php")) {
		$config->showcblink = 1;
		$config->showcbpic = 1;
		$config->showconnex = 1;
		$config->checkbanned = 1;
		// now look for the CB config file
		// if realnames are used in CB, use realnames in uddeIM as well
		if (uddeIMfileExists("/administrator/components/com_comprofiler/ue_config.php")) {
			global $ueConfig;
			include_once(uddeIMgetPath('absolute_path')."/administrator/components/com_comprofiler/ue_config.php");
			if (isset($ueConfig['name_format'])) {
				if ($ueConfig['name_format']=='1') {
					$config->realnames=1;
					$config->pubrealnames=1;
				}
			}
		}
	}
	if (uddeIMfileExists("/components/com_cbe/cbe.php")) {
		$config->showcblink = 4;
		$config->showcbpic = 4;
		$config->showconnex = 1;
		$config->checkbanned = 1;
		// now look for the CBE config file
		// if realnames are used in CBE, use realnames in uddeIM as well
		if (uddeIMfileExists("/administrator/components/com_cbe/ue_config.php")) {
			global $ueConfig;
			include_once(uddeIMgetPath('absolute_path')."/administrator/components/com_cbe/ue_config.php");
			if (isset($ueConfig['name_format'])) {
				if ($ueConfig['name_format']=='1') {
					$config->realnames=1;
					$config->pubrealnames=1;
				}
			}
		}
	}
	if (uddeIMfileExists("/administrator/components/com_comprofiler/ue_config.php")) {
		global $ueConfig;
		include_once(uddeIMgetPath('absolute_path')."/administrator/components/com_comprofiler/ue_config.php");
		if (isset($ueConfig['thumbWidth'])) {
			if ($ueConfig['thumbWidth'])
				$config->avatarw = (int)$ueConfig['thumbWidth'];
		}
		if (isset($ueConfig['thumbHeight'])) {
			if ($ueConfig['thumbHeight'])
				$config->avatarh = (int)$ueConfig['thumbHeight'];
		}
	} elseif (uddeIMfileExists("/administrator/components/com_cbe/ue_config.php")) {
		global $ueConfig;
		include_once(uddeIMgetPath('absolute_path')."/administrator/components/com_cbe/ue_config.php");
		if (isset($ueConfig['thumbWidth'])) {
			if ($ueConfig['thumbWidth'])
				$config->avatarw = (int)$ueConfig['thumbWidth'];
		}
		if (isset($ueConfig['thumbHeight'])) {
			if ($ueConfig['thumbHeight'])
				$config->avatarh = (int)$ueConfig['thumbHeight'];
		}
	}

	$postfix = "";
	if ($config->languagecharset)
		$postfix = ".utf8";
	// is the correct lang file installed?
	if (file_exists($pathtoadmin.'/language'.$postfix.'/'.$mosConfig_lang.'.php')) {
		include_once($pathtoadmin.'/language'.$postfix.'/'.$mosConfig_lang.'.php');
		$langinfo="";
	} elseif (file_exists($pathtoadmin.'/language'.$postfix.'/english.php')) {
		include_once($pathtoadmin.'/language'.$postfix.'/english.php');
		$langinfo="<p>There is no <b>".ucfirst($mosConfig_lang)." (UTF-8)</b> language file installed. uddeIM will use English (UTF-8).</p>";
	} elseif (file_exists($pathtoadmin.'/language/english.php')) {
		include_once($pathtoadmin.'/language/english.php');
		$langinfo="<p>There is no <b>".ucfirst($mosConfig_lang)."</b> language file installed. uddeIM will use English.</p>";
		$config->languagecharset=0;
	}

	// see http://www.iana.org/assignments/character-sets
	// http://www.w3.org/WAI/ER/IG/ert/iso639.htm
	// http://www.loc.gov/standards/iso639-2/php/code_list.php
	// en, fr_FR, es_ES, it_IT, pt_PT
	// http://code.elxis.org/20080/nav.html?includes/Core/locale.php.source.html
	$tag = strtolower(substr($mosConfig_locale,0,2));
	switch ($tag) {
		case "bg":
		case "ru":	
			$config->charset = 'cp1251';
			$config->mailcharset = 'Windows-1251';
			break;
		case "sr":
		case "vi":
		case "ar":	// and others
		case "el":	// and others
		case "sr":
		case "zh":	// and others
		case "ja":
			$config->charset = 'UTF-8';
			$config->mailcharset = 'UTF-8';
			break;
		default:
			$config->charset = 'ISO-8859-1';
			$config->mailcharset = 'ISO-8859-1';
			break;
	}
	if ($config->languagecharset==1) {
		$config->charset = 'UTF-8';
		$config->mailcharset = 'UTF-8';
	}

	// Now save these settings
	uddeIMsaveConfig($pathtoadmin, $config);

	// Now write a welcome message to the Admin
	$userid = uddeIMgetUserID();
	if ($userid) {
		if ($config->languagecharset) {			// UTF-8 fix, not tested so far
			$sql = "SET NAMES utf8;";
			$database->setQuery($sql);
			try {
				$isok = $database->execute();
			} catch(Exception $e) {
				$isok = false;
			}
		}

		$rightnow = uddetime($config->timezone);
		$welcome_time = $rightnow;
		$welcome_user = "uddeIM";
		$welcome_msg = _UDDEADM_WELCOMEMSG;
		// its not a reply, so replyid=0
		$sql="INSERT INTO `#__uddeim` (fromid, toid, toread, message, datum, systemflag, disablereply, systemmessage, totrashoutbox, totrashdateoutbox) VALUES (".$userid.", ".$userid.", 0, '".$welcome_msg."', ".$welcome_time.", 1, 1, '".$welcome_user."', 1, ".$welcome_time.")";
		$database->setQuery($sql);
		try {
			$database->execute();
		} catch(Exception $e) {
			throw new Exception("SQL error when attempting to save a message. " . get_class($e));
		}
	}

	// create folder for attachments
	$folder = "/images/uddeimfiles";
	if (!uddeIMfolderExists($folder)) {
		if (!uddeIMmkdir($folder)) {
			echo "<b><span style='color: red;'>"._UDDEADM_FOLDERCREATE_ERROR.$folder."</span></b>";
		} else {
			// uddeIMchmod($folder, "766");		// BUGBUG: Joomla send CHMOD instead of SITE CHMOD
			$file = $folder."/index.html";
			if (!uddeIMfileExists($file)) {
				$cf  = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
				$cf .= "<html><head></head><body></body></html>";
				uddeIMwriteFile($file, $cf);
			}

			$file = $folder."/.htaccess";
			if (!uddeIMfileExists($file)) {
				$cf  = "# Having a .htaccess prevents users from directly\n";
				$cf .= "# accessing the files in your /images/uddeimfiles folder\n";
				$cf .= "#\n";
				$cf .= "deny from all\n";
				uddeIMwriteFile($file, $cf);
			}
		}
	}
	
	echo "<div style='width: 600px; text-align: left;'>";
	echo "<p><b>"._UDDEADM_UDDEINSTCOMPLETE."</b></p>";
	echo $langinfo;
	echo "<p>"._UDDEADM_REVIEWSETTINGS."</p>";
	echo "<ul>";
	echo "<li>"._UDDEADM_REVIEWLANG."</li>";
	echo "<li>"._UDDEADM_REVIEWEMAILSTOP."</li>";
	echo "<li>"._UDDEADM_REVIEWUPDATE."</li>";
	$folder = "/uddeimfiles";
	if (uddeIMfolderExists($folder)) {
		echo "<li>"._UDDEADM_CHECKFILESFOLDER."</li>";
	}
	echo "</ul>";

	// redirect to settings
	echo "<p><a href='".uddeIMredirectIndex()."?option=com_uddeim'>".ucfirst(_UDDEADM_CONTINUE)."</a></p>";
	echo "</div>";
}
