<?php
// ***********************************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         ? 2007-2010 Stephan Slabihoud, ? 2006 Benjamin Zweifel
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
// ***********************************************************************************************************
// Language file: 					Dutch (source file is Latin-1)
// Translator:    					Michaël Jonkers <webmaster@mjwebhosting.nl>
// Language file version:		1.0(30-01-2008 23:00)
// Additional translation (uddeIM v. 1.1-1.7) by fastcat v2.0 (23-04-2009)
// Additional translation & corrections (uddeIM v. 0.5-1.9) by Ghostdivision v7734 (30-08-2009)
// Additionele vertaling en correcties 17-09-2011 door Jerry Janson (www.jeejeestudio.nl)
// ***********************************************************************************************************
DEFINE ('_UDDEADM_TRANSLATORS_CREDITS', 'Translated by Michaël Jonkers');	// Enter your credits line here, e.g. 'Translation by <a href="http://domain.com" target="_new">John Doe</a>'

// New: 3.8
DEFINE ('_UDDEADM_CAPTCHA_RECAPTCHA2', 'reCaptcha 2.0');
DEFINE ('_UDDEADM_CB2', 'Community Builder 2.0+');

// New: 3.7
DEFINE ('_UDDEADM_SHOWMENULINK_HEAD', 'Show menu entry');
DEFINE ('_UDDEADM_SHOWMENULINK_EXP', 'Show additional menu entry.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_16', '...set default for additonal menu link');

// New: 3.6
DEFINE ('_UDDEIM_KUNENA_LINK', 'Forum');
DEFINE ('_UDDEIM_PM_USER', 'Send private message');
DEFINE ('_UDDEIM_PM_USER_DESC', 'Send a private message to this user');
DEFINE ('_UDDEIM_PM_INBOX', 'Show private Inbox');
DEFINE ('_UDDEIM_PM_INBOX_DESC', 'Show received private messages');
DEFINE ('_UDDEIM_PM_OUTBOX', 'Show private Outbox');
DEFINE ('_UDDEIM_PM_OUTBOX_DESC', 'Show sent private messages');
DEFINE ('_UDDEIM_PM_TRASHBOX', 'Show trash');
DEFINE ('_UDDEIM_PM_TRASHBOX_DESC', 'Show trashed private messages');
DEFINE ('_UDDEIM_PM_OPTIONS', 'Show PMS options');
DEFINE ('_UDDEIM_PM_OPTIONS_DESC', 'Show PMS options');
DEFINE ('_UDDEIM_PM_ARCHIVE', 'Show private Archive');
DEFINE ('_UDDEIM_PM_ARCHIVE_DESC', 'Show archived private messages');
DEFINE ('_UDDEIM_PM_SENDMESSAGE', 'Message sent');
DEFINE ('_UDDEIM_PM_PMSTAB', 'Send message');
DEFINE ('_UDDEIM_PM_PROFILEMSG', 'Quick message');
DEFINE ('_UDDEIM_PM_SENTSUCCESS', 'Successfully sent.');
DEFINE ('_UDDEIM_PM_SESSIONTIMEOUT', 'Session timeout.');
DEFINE ('_UDDEIM_PM_NOTSENT', 'Message not sent.');
DEFINE ('_UDDEIM_PM_TRYAGAIN', 'Try again.');
DEFINE ('_UDDEIM_PM_EMPTYMESSAGE', 'Empty message.');
DEFINE ('_UDDEIM_PM_EMAILFORMSUBJECT', 'Subject');
DEFINE ('_UDDEIM_PM_EMAILFORMMESSAGE', 'Message');
DEFINE ('_UDDEIM_PM_TABINBOX', 'Inbox');
DEFINE ('_UDDEIM_PM_PMSLINK', 'Private Messaging');

// New: 3.5
DEFINE ('_UDDEADM_GROUPSADMIN_HEAD', 'Additional Admin groups');
DEFINE ('_UDDEADM_GROUPSADMIN_EXP', 'Enter group IDs which should be treated as admin groups (e.g. 10, 11, 17). IDs 7, 8 (Joomla >=1.6) and IDs 24, 25 (Joomla <=1.5) are always admins.');
DEFINE ('_UDDEADM_GROUPSSPECIAL_HEAD', 'Additional Special groups');
DEFINE ('_UDDEADM_GROUPSSPECIAL_EXP', 'Enter group IDs which should be treated as special groups (e.g. 10, 11, 17). IDs 3-8 (Joomla >=1.6) and IDs 19-25 (Joomla <=1.5) are always special users.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_15', '...set default for additonal groups');

// New: 3.3
DEFINE ('_UDDEADM_KUNENA30', 'Kunena 3.0+');

// New: 3.1
DEFINE ('_UDDEIM_BADWORD', 'Bad word detected');
DEFINE ('_UDDEADM_BADWORDS_HEAD', 'Badwords filter');
DEFINE ('_UDDEADM_BADWORDS_EXP', 'New messages will be filtered for badwords. All badwords have to be seperated by a semicolon (;).');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_14', '...set default for badwords filter');
DEFINE ('_UDDEADM_OOD_PB', 'Postbox Plugin out of date!');

// New: 3.0
DEFINE ('_UDDEADM_UDDEIM', 'uddeIM');
DEFINE ('_UDDEADM_REPLYTEXT_HEAD', 'Auto reply');
DEFINE ('_UDDEADM_REPLYTEXT_EXP', 'The original message will be included automatically when you reply to a message.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_13', '...set default for replys (options)');

// New: 2.9
DEFINE ('_UDDEADM_KUNENA20', 'Kunena 2.0+');
DEFINE ('_UDDEADM_POSTBOXFULL_HEAD', 'Full message text');
DEFINE ('_UDDEADM_POSTBOXFULL_EXP', 'Show full message text of none, first or all messages.');
DEFINE ('_UDDEADM_POSTBOXFULL_0', 'None');
DEFINE ('_UDDEADM_POSTBOXFULL_1', 'First');
DEFINE ('_UDDEADM_POSTBOXFULL_2', 'All');
DEFINE ('_UDDEADM_POSTBOXAVATARS_HEAD', 'Display Avatars');
DEFINE ('_UDDEADM_POSTBOXAVATARS_EXP', 'Display Avatars in message view.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_12', '...set default for postbox (options)');

// New: 2.8
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_11', '...set default for postbox');
DEFINE ('_UDDEADM_POSTBOX_HEAD', 'Enable Postbox');
DEFINE ('_UDDEADM_POSTBOX_EXP', 'Enables the Postbox.');
DEFINE ('_UDDEIM_FILTER_TITLE_POSTBOX', 'Show from/to this user only');
DEFINE ('_UDDEIM_MESSAGES', 'Messages');
DEFINE ('_UDDEIM_POSTBOX', 'Postbox');
DEFINE ('_UDDEIM_FILTEREDUSER', 'user filtered');
DEFINE ('_UDDEIM_FILTEREDUSERS', 'users filtered');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_POSTBOX', ' postbox');
DEFINE ('_UDDEIM_NOMESSAGES_POSTBOX', 'You have no messages in your postbox.');
DEFINE ('_UDDEIM_DISPLAY', 'Display');
DEFINE ('_UDDEIM_HELP_POSTBOX', 'The <b>Postbox</b> holds all your incoming and outgoing messages.');
DEFINE ('_UDDEIM_HELP_PREAD', 'The message has been read (inbox=you can toggle the status).');
DEFINE ('_UDDEIM_HELP_PUNREAD', 'The message is still unread (inbox=you can toggle the status).');

// New: 2.7
DEFINE ('_UDDEADM_MOOTOOLS_NONEMEIO', 'do not load MooTools (use MEIO)');
DEFINE ('_UDDEADM_MOOTOOLS_13MEIO', 'force loading MooTools 1.3 (use MEIO)');

// New: 2.6
DEFINE ('_UDDEADM_DONTSEFMSGLINK_HEAD', 'Geen SEF voor %msglink%');
DEFINE ('_UDDEADM_DONTSEFMSGLINK_EXP', 'Gebruik geen SEF in %msglink% voor in email berichten');
DEFINE ('_UDDEADM_STIME_HEAD', 'Gebruik speciale kalender');
DEFINE ('_UDDEADM_STIME_EXP', 'When enabled on sites using the farsi language file the persian calendar is used.');
DEFINE ('_UDDEADM_RESTRICTREM_HEAD', 'Verwijder alleenstaande verbindingen');
DEFINE ('_UDDEADM_RESTRICTREM_EXP', 'Automatisch alleenstaande verbindingen verwijderen als de contactenlijst word bewaard');
DEFINE ('_UDDEADM_RESTRICTCON_HEAD', 'Laat alleen verbindingen zien');
DEFINE ('_UDDEADM_RESTRICTCON_EXP', 'The users shown in the list can be restricted to CB/CBE/JS connections (hide users from userlist has no effect here when enabled).');
DEFINE ('_UDDEADM_RESTRICTCON0', 'Uitgeschakeld');
DEFINE ('_UDDEADM_RESTRICTCON1', 'Geregistreerde gebruikers');
DEFINE ('_UDDEADM_RESTRICTCON2', 'Geregistreerde gebruikers en speciale gebruikers');
DEFINE ('_UDDEADM_RESTRICTCON3', 'Alle gebruikers (ook Beheerders!)');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_10', '...standaard maken voor verbindingen laten zien');

// New: 2.4
DEFINE ('_UDDEIM_SECURITYCODE', 'Captcha:');

// New: 2.3
DEFINE ('_UDDEADM_CC_HEAD', 'Button "Show CC: line"');
DEFINE ('_UDDEADM_CC_EXP', 'Indien geactiveerd kan een gebruiker kiezen of uddeIM wel of niet een CC: lijn toevoegd met alle ontvangers van een bericht.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_9', '...standaard geactiveerd voor CC: lijn, en aanpassing');
DEFINE ('_UDDEIM_TOOLBAR_MCP', 'Berichten Centrum');
DEFINE ('_UDDEIM_TOOLBAR_REMOVEMESSAGE', 'Wis bericht');
DEFINE ('_UDDEIM_TOOLBAR_DELIVERMESSAGE', 'Lever bericht af');
DEFINE ('_UDDEADM_OOD_MCP', 'Berichten Centrum Plugin te oud!');
DEFINE ('_UDDEADM_MCP_STAT', 'Aan te passen berichten:');
DEFINE ('_UDDEADM_MCP_TRASHED', 'Gewist');
DEFINE ('_UDDEADM_MCP_NOTEDEL', 'Dit bericht uit database verwijderen?');
DEFINE ('_UDDEADM_MCP_NOTEDELIVER', 'Dit bericht afleveren bij ontvanger?');
DEFINE ('_UDDEADM_MCP_SHOWHIDE', 'Toon/Verberg');
DEFINE ('_UDDEADM_MCP_EDIT', 'Bericht Controle Centrum');
DEFINE ('_UDDEADM_MCP_FROM', 'Van');
DEFINE ('_UDDEADM_MCP_TO', 'Aan');
DEFINE ('_UDDEADM_MCP_TEXT', 'Bericht');
DEFINE ('_UDDEADM_MCP_DELETE', 'Verwijder');
DEFINE ('_UDDEADM_MCP_DATE', 'Datum');
DEFINE ('_UDDEADM_MCP_DELIVER', 'Afleveren');
DEFINE ('_UDDEADM_USERSET_MODERATE', 'Mod');
DEFINE ('_UDDEADM_USERSET_SELMODERATE', '- Mod -');
DEFINE ('_UDDEIM_MCP_MODERATED', 'Uw berichten wordt gecontroleerd. Een moderator zal ze eerst controleren voordat ze afgeleverd worden bij de ontvangers.');
DEFINE ('_UDDEIM_STATUS_DELAYED', 'Wacht op moderator');
DEFINE ('_UDDEADM_MODNEWUSERS_HEAD', 'Nieuwe gebruikers controleren');
DEFINE ('_UDDEADM_MODNEWUSERS_EXP', 'Indien geactiveerd worden berichten van nieuwe geregistreerde gebruikers standaard eerst gecontroleerd.');
DEFINE ('_UDDEADM_MODPUBUSERS_HEAD', 'Modereer publieke gebruikers');
DEFINE ('_UDDEADM_MODPUBUSERS_EXP', 'Indien geactiveerd worden berichten van publieke gebruikers eerst gecontroleerd.');
DEFINE ('_UDDEIM_MENUICONS_P3', 'Geen menu');

// New: 2.2
DEFINE ('_UDDEADM_OOD_PF', 'Publieke Frontend Plugin te oud!');
DEFINE ('_UDDEADM_OOD_A', 'Bestand toevoeg Plugin te oud!');
DEFINE ('_UDDEADM_OOD_RSS', 'RSS Plugin te oud!');
DEFINE ('_UDDEADM_OOD_ASC', 'Bericht Rapport Centrum Plugin te oud!');
DEFINE ('_UDDEIM_NOMESSAGES3_FILTERED', '<b>Je hebt geen gefilterde berichten in je%s.</b>');
DEFINE ('_UDDEIM_FILTER_UNREAD', 'ongelezen');
DEFINE ('_UDDEIM_FILTER_FLAGGED', 'gevlagd');
DEFINE ('_UDDEADM_GRAVATAR_HEAD', 'gravatar geactiveerd');
DEFINE ('_UDDEADM_GRAVATAR_EXP', 'Activeerd gravatar ondersteuning.');
DEFINE ('_UDDEADM_GRAVATARD_HEAD', 'gravatar fotoset');
DEFINE ('_UDDEADM_GRAVATARD_EXP', 'Selecteer de fotoset voor de standaard fotos.');
DEFINE ('_UDDEADM_GRAVATARR_HEAD', 'gravatar waardering');
DEFINE ('_UDDEADM_GRAVATARR_EXP', 'Standaard worden alleen met "G" gewaardeerde fotos getoond tenzij je een hogere waardering instelt. "X" toont alle gravatar fotos.');
DEFINE ('_UDDEADM_GR404', '404');
DEFINE ('_UDDEADM_GRMM', 'mm');
DEFINE ('_UDDEADM_GRIDENTICON', 'identicon');
DEFINE ('_UDDEADM_GRMONSTERID', 'monsterid');
DEFINE ('_UDDEADM_GRWAVATAR', 'wavatar');
DEFINE ('_UDDEADM_GRRETRO', 'retro');
DEFINE ('_UDDEADM_GRDEFAULT', 'standaard');
DEFINE ('_UDDEADM_GRG', 'G = Algemeen');
DEFINE ('_UDDEADM_GRPG', 'PG = Ouderlijk Toezicht');
DEFINE ('_UDDEADM_GRR', 'R = Beperkt');
DEFINE ('_UDDEADM_GRX', 'X = Alleen Volwassenen');
DEFINE ('_UDDEADM_NINJABOARD', 'Ninjaboard');
DEFINE ('_UDDEADM_KUNENA16', 'Kunena 1.6+');
DEFINE ('_UDDEIM_PROCESSING', 'Verwerken...');
DEFINE ('_UDDEIM_SEND_NONOTIFY', 'Zend geen kennisgeving e-mails');
DEFINE ('_UDDEIM_SYSGM_NONOTIFY', 'E-mail kennisgevingen worden niet verstuurd');
DEFINE ('_UDDEIM_SYSGM_FORCEEMBEDDED', 'De tekst wordt samengevoegd in de kennisgeving e-mail');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_8', '...standaard voor thumbnails');
DEFINE ('_UDDEADM_AVATARWH_HEAD', 'Getoond formaat van thumbnails');
DEFINE ('_UDDEADM_AVATARWH_EXP', 'Breedte en hoogte (in pixels) van thumbnails (0 = formaat wijzigd niet).');
DEFINE ('_UDDEIM_SAVE', 'Opslaan');

// New: 2.1
DEFINE ('_UDDEIM_BODY_SPAMREPORT',
"Hoi %you%,\n\n%touser% Heeft een verdacht bericht gerapporteerd van %fromuser%. Log A.U.B. in en controleer!\n\n%livesite%");
DEFINE ('_UDDEIM_SUBJECT_SPAMREPORT', 'Een bericht is gerapporteerd op %site%');
DEFINE ('_UDDEADM_KBYTES', 'KByte');
DEFINE ('_UDDEADM_MBYTES', 'MByte');
DEFINE ('_UDDEIM_ATT_FILEDELETED', 'Bestand is verwijderd');
DEFINE ('_UDDEIM_ATT_FILENOTEXISTS', 'Error: Bestand bestaat niet');
DEFINE ('_UDDEIM_ATTACHMENTS2', 'Bijlage (max. %s per bestand):');
DEFINE ('_UDDEADM_JOOCM', 'Joo!CM');
DEFINE ('_UDDEADM_UNPROTECTATTACHMENT_HEAD', 'Onbeschermd bestand download');
DEFINE ('_UDDEADM_UNPROTECTATTACHMENT_EXP', ' Normaal gebruikt uddeIM het server pad niet van bestanden, Dus niemand kan het bestand downloaden, ook niet wanneer het bestand bekend is. Aanzetten van deze opties forceerd uddeim tot het gebruik van het volledige server pad. Voor beveilings redenen, heeft uddeim een MD5 hash toegevoegd aan het orginele bestand. Gebruikers kunnen het bestand direct downloaden wanneer het volledige pad bekend is. Gebruik deze optie voorzichtig..! Lees de FAQ wanneer deze optie gebruikt wordt!');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_7', '...Zet default voor bestanden , publieke front');
DEFINE ('_UDDEIM_FILETYPE_NOTALLOWED', 'Bestandstype niet juist');
DEFINE ('_UDDEADM_ALLOWEDEXTENSIONS_HEAD', 'Extensies geaccepteerd');
DEFINE ('_UDDEADM_ALLOWEDEXTENSIONS_EXP', 'Vul hier de extensies in die geaccepteerd worden(Gescheiden door ";"). Laat leeg voor geen ristricties.');
DEFINE ('_UDDEADM_PUBEMAIL_HEAD', 'E-mail verplicht');
DEFINE ('_UDDEADM_PUBEMAIL_EXP', 'Wanneer geactiveerd moet een publieke gebruiker een emailadres invoeren.');
DEFINE ('_UDDEADM_WAITDAYS_HEAD', 'Dagen te wachten');
DEFINE ('_UDDEADM_WAITDAYS_EXP', 'Specifeer hoeveel dagen een gebruiker moet wachten voordat hij berichten mag zenden. (voor 3 uren enter 0.125).');
DEFINE ('_UDDEIM_WAITDAYS1', 'Je moet ');
DEFINE ('_UDDEIM_WAITDAYS2', ' dagen wachten voordat je berichten kan zenden.');
DEFINE ('_UDDEIM_WAITDAYS2H', ' uren wachten voordat je berichten kan zenden.');

// New: 2.0
DEFINE ('_UDDEADM_RECAPTCHAPRV_HEAD', 'reCaptcha Prive code');
DEFINE ('_UDDEADM_RECAPTCHAPRV_EXP', 'Vul hier je Prive code in wanneer je gebruik wilt maken van rechaptcha.');
DEFINE ('_UDDEADM_RECAPTCHAPUB_HEAD', 'reCaptcha Publieke code');
DEFINE ('_UDDEADM_RECAPTCHAPUB_EXP', 'Vul hier je Publieke code in wanneer je gebruik wilt maken van rechaptcha.');
DEFINE ('_UDDEADM_CAPTCHA_INTERNAL', 'ingebouwd');
DEFINE ('_UDDEADM_CAPTCHA_RECAPTCHA', 'reCaptcha');
DEFINE ('_UDDEADM_CAPTCHATYPE_HEAD', 'Captcha services');
DEFINE ('_UDDEADM_CAPTCHATYPE_EXP', 'Welke captcha service wil je gebriuken: De ingebouwde service of reCaptcha (see <a href="http://www.google.com/recaptcha" target="_new">reCaptcha</a> Voor meer informatie)?');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_6', '...Zet standaard voor captcha services');
DEFINE ('_UDDEADM_AUP', 'AlphaUserPoints');
DEFINE ('_UDDEADM_CHECKFILESFOLDER', 'Verplaats graag <i>\uddeimfiles</i> naar <i>\images\uddeimfiles</i>. Controleer de documentatie!');
DEFINE ('_UDDEADM_CRYPT4', 'Sterke encryptie');
DEFINE ('_UDDEADM_ALLOWTOALL2_HEAD', 'akkoord om systeemberichten te verzenden');
DEFINE ('_UDDEADM_ALLOWTOALL2_EXP', 'uddeIM support berichten systeem. Deze worden naar alle gebrukers gestuurd op uw systeem. Spaarzaam gebruiken.');
DEFINE ('_UDDEADM_ALLOWTOALL2_0', 'Uitgeschakeld');
DEFINE ('_UDDEADM_ALLOWTOALL2_1', 'Alleen Administrators');
DEFINE ('_UDDEADM_ALLOWTOALL2_2', 'administrator en beheerders');

// New: 1.9
DEFINE ('_UDDEIM_FILEUPLOAD_FAILED', 'Uploaden van bestand is mislukt');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_5', '...stel als standaard in voor bijlagen');
DEFINE ('_UDDEADM_ENABLEATTACHMENT_HEAD', 'Stel in staat om bijlagen te versturen');
DEFINE ('_UDDEADM_ENABLEATTACHMENT_EXP', 'Dit maakt het mogelijk om bestands bijlagen te versturen voor alle geregistreerde gebruikers, of enkel voor admins.');
DEFINE ('_UDDEADM_MAXSIZEATTACHMENT_HEAD', 'Max. bestands grootte');
DEFINE ('_UDDEADM_MAXSIZEATTACHMENT_EXP', 'Maximum grootte voor bestands bijlagen.');
DEFINE ('_UDDEIM_FILESIZE_EXCEEDED', 'Maximum bestandsgroote overschreden');
DEFINE ('_UDDEADM_BYTES', 'Bytes');
DEFINE ('_UDDEADM_MAXATTACHMENTS_HEAD', 'Max. bestands bijlagen');
DEFINE ('_UDDEADM_MAXATTACHMENTS_EXP', 'Maximum bijlagen per bericht.');
DEFINE ('_UDDEIM_DOWNLOAD', 'Download');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_HEAD', 'Bestand verwijderen inschakelen');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_YES', 'enkel door admins');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_NO', 'door iedereen');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_MANUALLY', 'handmatig');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_EXP', 'Automatische verwijderingen zorgen voor een zware belasting voor de server. Als je voor de optie kiest <b>enkel door admins</b> zal het automatisch verwijderen aangeroepen worden wanneer deze admin zijn inbox controleert. Kies alleen voor deze optie als de admin ook geregeld zijn inbox controleert. Kleine of bijna niet geadministreerde sites kunnen het beste kiezen voor <b>door iedereen</b>.');
DEFINE ('_UDDEADM_FILEMAINTENANCE_PRUNE', 'Verwijder bestanden nu');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_HEAD', 'Leidt het verwijderen van bestanden in');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_EXP', 'Wist verwijderde bestanden uit de database. Dit is hetzelfde als \'Verwijder bestanden nu\' op het systeem tabblad.');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_ERASE', 'WISSEN');
DEFINE ('_UDDEIM_ATTACHMENTS', 'Bestands bijlagen (max. %u bytes per bestand):');
DEFINE ('_UDDEADM_MAINTENANCE_F1', 'Selecteer aangekoppelde bestanden opgeslagen in het bestandssysteem: ');
DEFINE ('_UDDEADM_MAINTENANCE_F2', 'Geselecteerde bestanden worden verwijderd');
DEFINE ('_UDDEADM_BACKUP_DONE', 'Backup van de configuratie is voltooid.');
DEFINE ('_UDDEADM_RESTORE_DONE', 'Herstel van de configuratie is voltooid.');
DEFINE ('_UDDEADM_PRUNE_DONE', 'Het bijwerken van de berichten is voltooid.');
DEFINE ('_UDDEADM_FILEPRUNE_DONE', 'Het bijwerken van bestands bijlagen is voltooid.');
DEFINE ('_UDDEADM_FOLDERCREATE_ERROR', 'Fout bij het aanmaken van een map: ');
DEFINE ('_UDDEADM_ATTINSTALL_WRITEFAILED', 'Fout bij het aanmaken van een bestand: ');
DEFINE ('_UDDEADM_ATTINSTALL_IGNORE', 'je kunt deze fout negeren indien je niet in het bezit bent van de premium "Attachement" plugin (zie FAQ).');
DEFINE ('_UDDEADM_ATTACHMENTGROUPS_HEAD', 'Toegestane groepen');
DEFINE ('_UDDEADM_ATTACHMENTGROUPS_EXP', 'Groepen die het toegestaan zijn om bestands bijlagen te versturen.');
DEFINE ('_UDDEIM_SELECT', 'Selecteer');
DEFINE ('_UDDEIM_ATTACHMENT', 'Bestands bijlage');
DEFINE ('_UDDEADM_SHOWLISTATTACHMENT_HEAD', 'Laat bijlage icoontjes zien');
DEFINE ('_UDDEADM_SHOWLISTATTACHMENT_EXP', 'Laat bijlage icoontjes zien in de berichtenlijst (inbox, outbox, archief).');
DEFINE ('_UDDEIM_HELP_ATTACHMENT', 'Het bericht bevat een bestands bijlage.');
DEFINE ('_UDDEADM_MAINTENANCE_COUNTFILES', 'Bestands referentie in de database:');
DEFINE ('_UDDEADM_MAINTENANCE_COUNTFILESDISTINCT', 'Bestands bijlage opgeslagen:');
DEFINE ('_UDDEADM_SHOWMENUCOUNT_HEAD', 'Laat tellers zien');
DEFINE ('_UDDEADM_SHOWMENUCOUNT_EXP', 'Indien op <b>ja</b> ingesteld, zal de menubalk berichtentellers bevatten. Houdt er rekening mee dat dit verschillende additionele database inlichtingen met zich meebrengt, dus gebruik dit niet op zwakke systemen.');
DEFINE ('_UDDEADM_CONFIG_FTPLAYER', 'Configuratie (toegang via de FTP laag):');
DEFINE ('_UDDEADM_ENCODEHEADER_HEAD', 'Encodeer mail headers');
DEFINE ('_UDDEADM_ENCODEHEADER_EXP', 'Indien op <b>ja</b> ingesteld, wanneer er mail headers (zoals het onderwerp) moeten deze rfc 2047 ge-encodeerd worden. Handig als je met sommige letters moeilijkheden hebt.');
DEFINE ('_UDDEIM_UP', 'sorteer oplopend');
DEFINE ('_UDDEIM_DOWN', 'sorteer aflopend');
DEFINE ('_UDDEIM_UPDOWN', 'sorteer');
DEFINE ('_UDDEADM_ENABLESORT_HEAD', 'Maak sorteren mogelijk');
DEFINE ('_UDDEADM_ENABLESORT_EXP', 'Indien op <b>ja</b> ingesteld, zal de gebruiker in staat moeten zijn om de inbox, uitbox en archief te sorteren (creeërt extra data belasting van de database server).');

// New: 1.8
// %s will be replaced by _UDDEIM_NOMESSAGES_FILTERED_INBOX, _UDDEIM_NOMESSAGES_FILTERED_OUTBOX, _UDDEIM_NOMESSAGES_FILTERED_ARCHIVE
// Translators help: When having problems with the grammar, you can also move some text (e.g. "in your") to _UDDEIM_NOMESSAGES_FILTERED_* variables, e.g.
// instead of "_UDDEIM_NOMESSAGES_FILTERED_INBOX=inbox" you can also use "_UDDEIM_NOMESSAGES_FILTERED_INBOX=in your inbox"
DEFINE ('_UDDEIM_NOMESSAGES2_FR_FILTERED', '<b>Je hebt geen berichten van deze gebruiker in je%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_TO_FILTERED', '<b>Je hebt geen berichten aan deze gebruiker in je%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_UNFR_FILTERED', '<b>Je hebt geen ongelezen berichten van deze gebruiker in je%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_UNTO_FILTERED', '<b>Je hebt geen ongelezen berichten aan deze gebruiker in je%s.</b>');

// New: 1.7
DEFINE ('_UDDEADM_EMAILSTOPPED', '\'Email stop\' ingeschakeld.');
DEFINE ('_UDDEIM_ACCOUNTLOCKED', 'De toegang tot je mailbox is geblokkeerd. Neem contact op met de administrator');
DEFINE ('_UDDEADM_USERSET_LOCKED', 'Geblokkeerd');
DEFINE ('_UDDEADM_USERSET_SELLOCKED', '- Geblokkeerd -');
DEFINE ('_UDDEADM_CBBANNED_HEAD', 'Controleer op gebruikers die geblokkeerd zijn in CB');
DEFINE ('_UDDEADM_CBBANNED_EXP', 'Als deze optie is geactiveerd controleert uddeIM of een gebruiker geblokkeerd is in CB en geeft dan geen toegang tot uddeIM. Bovendien kunnen andere gebruikers deze gebruiker geen berichten sturen');

DEFINE ('_UDDEIM_YOUAREBANNED', 'Je bent gebanned. Neem contact op met de administrator');
DEFINE ('_UDDEIM_USERBANNED', 'Gebruiker is gebanned');
DEFINE ('_UDDEADM_JOOBB', 'Joo!BB');
DEFINE ('_UDDEPLUGIN_SEARCHSECTION', 'Privé communicatie');
DEFINE ('_UDDEPLUGIN_MESSAGES', 'Privé Berichten');
DEFINE ('_UDDEADM_MAINTENANCEDEL_HEAD', 'Roep bericht wissen aan');
// note "Dit is het zelfde als _UDDEADM_MAINTENANCE_PRUNE op het systeem tabblad."
DEFINE ('_UDDEADM_MAINTENANCEDEL_EXP', 'Verwijdert verwijderde berichten uit de database. Dit is het zelfde als \'Prune messages now\' op het systeem tabblad.');
DEFINE ('_UDDEADM_MAINTENANCEDEL_ERASE', 'VERWIJDER');
DEFINE ('_UDDEADM_REPORTSPAM_HEAD', 'Rapporteer dit bericht link');
DEFINE ('_UDDEADM_REPORTSPAM_EXP', 'Indien geactiveerd toont dit een \'Rapporteer dit bericht\' link waarmee gebruikers SPAM kunnen rapporteren aan de administrator.');
DEFINE ('_UDDEIM_TOOLBAR_REMOVESPAM', 'Verwijder bericht');
DEFINE ('_UDDEIM_TOOLBAR_REMOVEREPORT', 'Verwijder rapportage');
DEFINE ('_UDDEIM_TOOLBAR_SPAMCONTROL', 'Rapporteer spamcontrole');
DEFINE ('_UDDEADM_INFORMATION', 'Informatie');
DEFINE ('_UDDEADM_SPAMCONTROL_STAT', 'Gerapporteerde berichten:');
DEFINE ('_UDDEADM_SPAMCONTROL_TRASHED', 'Verwijderd');
DEFINE ('_UDDEADM_SPAMCONTROL_NOTEDEL', 'Verwijder bericht uit database?');
DEFINE ('_UDDEADM_SPAMCONTROL_NOTEREMOVE', 'Verwijder deze rapportage?');
DEFINE ('_UDDEADM_SPAMCONTROL_SHOWHIDE', 'Toon/Verberg');
DEFINE ('_UDDEADM_SPAMCONTROL_EDIT', 'Rapporteer controle centrum');
DEFINE ('_UDDEADM_SPAMCONTROL_FROM', 'Van');
DEFINE ('_UDDEADM_SPAMCONTROL_TO', 'Aan');
DEFINE ('_UDDEADM_SPAMCONTROL_TEXT', 'Bericht');
DEFINE ('_UDDEADM_SPAMCONTROL_DELETE', 'Verwijder');
DEFINE ('_UDDEADM_SPAMCONTROL_REMOVE', 'Verplaats');
DEFINE ('_UDDEADM_SPAMCONTROL_DATE', 'Datum');
DEFINE ('_UDDEADM_SPAMCONTROL_REPORTED', 'Gerapporteerd');
DEFINE ('_UDDEIM_SPAMCONTROL_REPORT', 'Rapporteer dit bericht');
DEFINE ('_UDDEIM_SPAMCONTROL_MARKED', 'Het bericht is gerapporteerd');
DEFINE ('_UDDEIM_SPAMCONTROL_UNREPORT', 'Herroep dit rapport');
DEFINE ('_UDDEADM_JOMSOCIAL', 'JomSocial');
DEFINE ('_UDDEADM_KUNENA', 'Kunena');
DEFINE ('_UDDEADM_ADMIN_FILTER', 'Filter');
DEFINE ('_UDDEADM_ADMIN_DISPLAY', 'Toon #');
DEFINE ('_UDDEADM_TRASHORIGINALSENT_HEAD', 'Verwijder verstuurde bericht');
DEFINE ('_UDDEADM_TRASHORIGINALSENT_EXP', 'Indien geactiveerd zal dit een selectievakje naast de \'Verstuur\' knop getiteld \'verwijder bericht\' tonen welke niet standaard aangevinkt is. Gebruiker kan de keuze aanvinken als het bericht verwijderd kan worden na het versturen.');
DEFINE ('_UDDEIM_TRASHORIGINALSENT', 'verwijder bericht');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_4', '...standaard waarde voor verwijder het verstuurde bericht, rapporteer spam');
DEFINE ('_UDDEADM_VERSIONCHECK_IMPORTANT', 'Belangrijke links:');
DEFINE ('_UDDEADM_VERSIONCHECK_HOTFIX', 'Hotfix');
DEFINE ('_UDDEADM_VERSIONCHECK_NONE', 'Geen');
DEFINE ('_UDDEADM_MAINTENANCEFIX_HEAD', "Compatibiliteits onderhoud");
DEFINE ('_UDDEADM_MAINTENANCEFIX_EXP', "uddeIM gebruikt twee XML bestanden om er zeker van te zijn dat het pakket geïnstalleerd kan worden op Joomla 1.0 en 1.5. Bij Joomla 1.5 is een XML bestand nodig waardoor de extensie manager een incompatibilteits waarschuwing zal geven (dit is echter niet zo). Hierdoor worden de overbodige bestanden verwijderd, hierna wordt de waarschuwing niet langer getoond.");
DEFINE ('_UDDEADM_MAINTENANCE_FIX', "REPAREER");
DEFINE ('_UDDEADM_MAINTENANCE_XML1', "Joomla 1.0 en Joomla 1.5 XML installeerders voor uddeIM pakket zijn aanwezig.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML2', "Dit is nodig om het pakket te installeren op Joomla 1.0 and Joomla 1.5.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML3', "Omdat het niet meer bebruikt wordt nadat de installatie is voltooid, kan de installer worden verwijderd op Joomla 1.0  en Joomla 1.5 systemen.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML4', "Dit zal gebeuren voor de onderhavige pakketten:<br />");
DEFINE ('_UDDEADM_MAINTENANCE_FXML1', "Overbodige XML installeerders voor de volgende uddeIM pakketten worden verwijderd:<br />");
DEFINE ('_UDDEADM_MAINTENANCE_FXML2', "Geen overbodige XML installers voor uddeIM packages gevonden!<br />");
DEFINE ('_UDDEADM_SHOWMENUICONS1_HEAD', 'Tonen van de menubalk');
DEFINE ('_UDDEADM_SHOWMENUICONS1_EXP', 'Hier kun je de menubalk configureren of er bebruik moet worden gemaakt van tekst en/of icoontjes.');
DEFINE ('_UDDEIM_MENUICONS_P1', 'Knoppen en tekst');
DEFINE ('_UDDEIM_MENUICONS_P2', 'Alleen knoppen');
DEFINE ('_UDDEIM_MENUICONS_P0', 'Alleen tekst');
DEFINE ('_UDDEIM_LISTSLIMIT_2', 'Maximum aantal ontvangers per lijst:');
DEFINE ('_UDDEADM_ADDEMAIL_ADMIN', 'Administrator kan selecteren');
DEFINE ('_UDDEAIM_ADDEMAIL_SELECT', 'Stel in kennis met bericht');
DEFINE ('_UDDEAIM_ADDEMAIL_TITLE', 'Sluit het volledige bericht in bij e-mail inkennisstelling.');

// New: 1.6
DEFINE ('_UDDEIM_NOLISTSELECTED', 'Geen gebruikerslijst geselecteerd!');
DEFINE ('_UDDEADM_NOPREMIUM', 'Premium plugin niet geïnstalleerd');
DEFINE ('_UDDEIM_LISTGLOBAL_CREATOR', 'Ontwerper:');
DEFINE ('_UDDEIM_LISTGLOBAL_ENTRIES', 'Inzendingen');
DEFINE ('_UDDEIM_LISTGLOBAL_TYPE', 'Type');
DEFINE ('_UDDEIM_LISTGLOBAL_NORMAL', 'Normaal');
DEFINE ('_UDDEIM_LISTGLOBAL_GLOBAL', 'Globaal');
DEFINE ('_UDDEIM_LISTGLOBAL_RESTRICTED', 'Beperkt');
DEFINE ('_UDDEIM_LISTGLOBAL_P0', 'Normale gebruikerslijst');
DEFINE ('_UDDEIM_LISTGLOBAL_P1', 'Globale gebruikerslijst');
DEFINE ('_UDDEIM_LISTGLOBAL_P2', 'Beperkte gebruikerslijst (alleen lijstgebruikers kunnen deze lijst inzien)');
DEFINE ('_UDDEIM_TOOLBAR_USERSETTINGS', 'Gebruikers instellingen');
DEFINE ('_UDDEIM_TOOLBAR_REMOVESETTINGS', 'Verwijder instellingen');
DEFINE ('_UDDEIM_TOOLBAR_CREATESETTINGS', 'Kies instellingen');
DEFINE ('_UDDEIM_TOOLBAR_SAVE', 'Opslaan');
DEFINE ('_UDDEIM_TOOLBAR_BACK', 'Terug');
DEFINE ('_UDDEIM_TOOLBAR_TRASHMSGS', 'Verwijder bericht');
DEFINE ('_UDDEIM_CBPLUG_CONT', '[Ga door]');
DEFINE ('_UDDEIM_CBPLUG_UNBLOCKNOW', '[deblokkeer]');
DEFINE ('_UDDEIM_CBPLUG_DOBLOCK', 'Blokkeer gebruiker');
DEFINE ('_UDDEIM_CBPLUG_DOUNBLOCK', 'Deblokkeer gebruiker');
DEFINE ('_UDDEIM_CBPLUG_BLOCKINGCFG', 'Geblokkeerd');
DEFINE ('_UDDEIM_CBPLUG_BLOCKED', 'Deze gebruiker is door jou geblokkeerd.');
DEFINE ('_UDDEIM_CBPLUG_UNBLOCKED', 'Deze gebruiker kan jou contacteren.');
DEFINE ('_UDDEIM_CBPLUG_NOWBLOCKED', 'De gebruiker is nu geblokkeerd.');
DEFINE ('_UDDEIM_CBPLUG_NOWUNBLOCKED', 'De gebruiker is niet langer geblokkeerd.');
DEFINE ('_UDDEADM_PARTIALIMPORTDONE', 'Gedeeltelijke importeren van berichten uit het oude PMS is voltooid. Herhaal deze importeer bewerking niet omdat er dan dubbele berichten getoond kunnen worden.');
DEFINE ('_UDDEADM_IMPORT_HELP', 'Let op: De berichten kunnen in zijn geheel of in delen geïmporteerd worden. Importeren in delen is wenselijk als het importeren niet lukt omdat er teveel berichten zijn.');
DEFINE ('_UDDEADM_IMPORT_PARTIAL', 'Importeren in delen:');
DEFINE ('_UDDEADM_UPDATEYOURDB', 'Belangrijk: Je hebt je database niet geüpdate! Lees in de LEESMIJ hoe uddeIM correct geupdate kan worden!');
DEFINE ('_UDDEADM_RESTRALLUSERS_HEAD', 'Beperk "Alle gebruikers" toegang');
DEFINE ('_UDDEADM_RESTRALLUSERS_EXP', 'Je kunt de toegang beperken voor de "Alle gebruikers" lijst. Normaal gesproken is de "Alle gebruikers" lijst beschikbaar voor iedereen (<i>geen beperking</i>).');
DEFINE ('_UDDEADM_RESTRALLUSERS_0', 'geen beperking');
DEFINE ('_UDDEADM_RESTRALLUSERS_1', 'speciale gebruiker');
DEFINE ('_UDDEADM_RESTRALLUSERS_2', 'enkel administrators');
DEFINE ('_UDDEIM_MESSAGE_UNARCHIVED', 'Bericht uit het archief gehaald.');
DEFINE ('_UDDEADM_AUTOFORWARD_SPECIAL', 'speciale gebruiker');
DEFINE ('_UDDEIM_HELP', 'Help');
DEFINE ('_UDDEIM_HELP_HEADLINE1', 'uddeIM Help');
DEFINE ('_UDDEIM_HELP_HEADLINE2', 'Kort overzicht van alle functies');
DEFINE ('_UDDEIM_HELP_INBOX', 'De <b>Inbox</b> herbergt al je ontvangen berichten, ieder ontvangen bericht staat daar.');
DEFINE ('_UDDEIM_HELP_OUTBOX', 'De <b>Uitbox</b> bewaart een kopie van ieder verzonden bericht, je kunt zo altijd terug zien wat je verstuurd hebt .');
DEFINE ('_UDDEIM_HELP_TRASHCAN', 'De <b>Prullebak</b> bewaart alle verwijderde berichten. Berichten worden nooit direct verwijderd maar worden hier voor een bepaalde tijd bewaard. Zolang het bericht in de prullebak staat kan het worden terug gezet .');
DEFINE ('_UDDEIM_HELP_ARCHIVE', 'Het <b>Archief</b> bewaart alle gearchiveerde berichten uit de inbox. Je kunt alleen berichten uit de inbox archiveren. Als je een door jou geschreven bericht wilt archiveren vergewis je ervan dat je <i>kopie aan mezelf </i> aanvinkt hebt als je het bericht verstuurt.');
DEFINE ('_UDDEIM_HELP_USERLISTS', '<b>Contacten</b> Staat toe de gebruikerslijst aan te passen (ook bekend als distributielijsten). Deze lijst maakt het mogelijk Privé Berichten te sturen aan meerdere ontvangers. In plaats van meerdere ontvangers toe te voegen, kun je heel simpel de <i>#lijstnaam</i> ingeven.');
DEFINE ('_UDDEIM_HELP_SETTINGS', '<b>Instellingen</b> bevat alle configureerbare gebruikersopties.');
DEFINE ('_UDDEIM_HELP_COMPOSE', '<b>Schrijven</b> maakt het mogelijk een nieuw bericht te schrijven.');
DEFINE ('_UDDEIM_HELP_IREAD', 'Het bericht is gelezen (je kunt de status aanpassen).');
DEFINE ('_UDDEIM_HELP_IUNREAD', 'Het bericht is nog niet gelezen (je kunt de status aanpassen).');
DEFINE ('_UDDEIM_HELP_OREAD', 'Het bericht is gelezen.');
DEFINE ('_UDDEIM_HELP_OUNREAD', 'Het bericht is nog niet gelezen. Ongelezen berichten kunnen herroepen worden.');
DEFINE ('_UDDEIM_HELP_TREAD', 'Het bericht is gelezen.');
DEFINE ('_UDDEIM_HELP_TUNREAD', 'Het bericht is nog niet gelezen.');
DEFINE ('_UDDEIM_HELP_FLAGGED', 'Het bericht is gemarkeerd, bijvoorbeeld wanneer het gaat om een belangrijk bericht (je kunt de status veranderen).');
DEFINE ('_UDDEIM_HELP_UNFLAGGED', '<i>Normaal</i> bericht (je kunt de status veranderen).');
DEFINE ('_UDDEIM_HELP_ONLINE', 'De gebruiker is online.');
DEFINE ('_UDDEIM_HELP_OFFLINE', 'De gebruiker is offline.');
DEFINE ('_UDDEIM_HELP_DELETE', 'Verwijder bericht (verplaats het bericht naar de prullenbak).');
DEFINE ('_UDDEIM_HELP_FORWARD', 'Stuur het bericht door naar een andere gebruiker.');
DEFINE ('_UDDEIM_HELP_ARCHIVEMSG', 'Archiveer een bericht. Gearchiveerde berichten worden niet automatisch verwijderd wanneer de administrator een tijdslimiet heeft ingesteld voor het opslaan van berichten in de inbox.');
DEFINE ('_UDDEIM_HELP_UNARCHIVEMSG', 'Haal het bericht uit het archief. Het bericht wordt terug gezet in de inbox.');
DEFINE ('_UDDEIM_HELP_RECALL', 'Herroep een bericht. Een bericht kan herroepen worden als de ontvanger het bericht nog niet heeft gelezen.');
DEFINE ('_UDDEIM_HELP_RECYCLE', 'Plaats een bericht terug (zet het verwijderde bericht terug in de inbox of de uitbox).');
DEFINE ('_UDDEIM_HELP_NOTIFY', 'Instellingen van de email notificatie als een nieuw bericht wordt bezorgd.');
DEFINE ('_UDDEIM_HELP_AUTORESPONDER', 'Indien de autoresponder is geactiveerd wordt elk ontvangen bericht meteen beantwoord.');
DEFINE ('_UDDEIM_HELP_AUTOFORWARD', 'Nieuwe berichten kunnen automatisch worden doorgestuurd naar een andere gebruiker.');
DEFINE ('_UDDEIM_HELP_BLOCKING', 'Je kunt gebruikers blokkeren. Deze gebruikers kunnen je dan geen privé berichten sturen.');
DEFINE ('_UDDEIM_HELP_MISC', 'Hier vind je meer configuratie-instellingen.');
DEFINE ('_UDDEIM_HELP_FEED', 'Je kunt toegang verkrijgen tot je inbox met behulp van een RSS-feed.');
DEFINE ('_UDDEADM_SEPARATOR_HEAD', 'Scheidingsteken');
DEFINE ('_UDDEADM_SEPARATOR_EXP', 'Gebruik het scheidingsteken voor meerdere gebruikers (standaard is ",").');
DEFINE ('_UDDEADM_SEPARATOR_P0', 'komma (standaard)');
DEFINE ('_UDDEADM_SEPARATOR_P1', 'puntkomma');
DEFINE ('_UDDEADM_RSSLIMIT_HEAD', 'RSS onderwerpen');
DEFINE ('_UDDEADM_RSSLIMIT_EXP', 'Beperk het aantal geretourneerde RSS onderwerpen (0 ongelimiteerd).');
DEFINE ('_UDDEADM_SHOWHELP_HEAD', 'Toon help knop');
DEFINE ('_UDDEADM_SHOWHELP_EXP', 'Indien geactiveerd wordt een help knop getoond.');
DEFINE ('_UDDEADM_SHOWIGOOGLE_HEAD', 'Toon iGoogle gadget knop');
DEFINE ('_UDDEADM_SHOWIGOOGLE_EXP', 'Indien geactiveerd wordt <i>Voeg toe aan iGoogle</i> voor het uddeIM iGoogle gadget getoond in de gebruikers voorkeurs instellingen.');
DEFINE ('_UDDEADM_MOOTOOLS_NONE11', 'laad geen MooTools (1.1 wordt gebruikt)');
DEFINE ('_UDDEADM_MOOTOOLS_NONE12', 'laad geen MooTools (1.2 wordt gebruikt)');
DEFINE ('_UDDEIM_RSS_INTRO1', 'Je kunt toegang verkrijgen tot je inbox met behulp van een RSS-feed (0.91).');
DEFINE ('_UDDEIM_RSS_INTRO1B', 'De toegangs URL is:');
DEFINE ('_UDDEIM_RSS_INTRO2', 'Geef deze URL niet aan andere gebruikers omdat deze URL toegang geeft tot jouw inbox.');
DEFINE ('_UDDEIM_RSS_FEED', 'Bericht RSS-Feed');
DEFINE ('_UDDEIM_RSS_NOOBJECT', 'Geen object fout...');
DEFINE ('_UDDEIM_RSS_USERBLOCKED', 'Gebruiker geblokkeerd...');
DEFINE ('_UDDEIM_RSS_NOTALLOWED', 'Geen toegang...');
DEFINE ('_UDDEIM_RSS_WRONGPASSWORD', 'Foutieve gebruikersnaam en/of wachtwoord...');
DEFINE ('_UDDEIM_RSS_NOMESSAGES', 'Geen bericht');
DEFINE ('_UDDEIM_RSS_NONEWMESSAGES', 'Geen nieuw bericht');
DEFINE ('_UDDEADM_ENABLERSS_HEAD', 'Activeer RSS');
DEFINE ('_UDDEADM_ENABLERSS_EXP', 'Indien deze instelling is geactiveerd, kunnen berichten worden ontvangen via RSS-feed. Gebruikers kunnen de URL in hun gebruikersprofiel vinden.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_3', '...kies standaard voor RSS, iGoogle, help, scheidingsteken');
DEFINE ('_UDDEADM_DELETEM_DELETING', 'Berichten worden verwijderd:');
DEFINE ('_UDDEADM_DELETEM_FROMUSER', 'Verwijderen van berichten van gebruiker: ');
DEFINE ('_UDDEADM_DELETEM_MSGSSENT', '- bericht verzonden: ');
DEFINE ('_UDDEADM_DELETEM_MSGSRECV', '- bericht ontvangen: ');
DEFINE ('_UDDEIM_PMNAV_THISISARESPONSE', 'Dit is een reactie op:');
DEFINE ('_UDDEIM_PMNAV_THEREARERESPONSES', 'Reacties op dit:');
DEFINE ('_UDDEIM_PMNAV_DELETED', 'Bericht niet beschikbaar');
DEFINE ('_UDDEIM_PMNAV_EXISTS', 'Ga naar bericht');
DEFINE ('_UDDEIM_PMNAV_COPY2ME', '(Kopie)');
DEFINE ('_UDDEADM_PMNAV_HEAD', 'Sta navigatie toe');
DEFINE ('_UDDEADM_PMNAV_EXP', 'Toont een navigatiebalk welke navigatie door onderwerpen mogelijk maakt.');
DEFINE ('_UDDEADM_MAINTENANCE_ALLDAYS', 'Berichten:');
DEFINE ('_UDDEADM_MAINTENANCE_7DAYS', 'Berichten in de afgelopen 7 dagen:');
DEFINE ('_UDDEADM_MAINTENANCE_30DAYS', 'Berichten in de afgelopen 30 dagen:');
DEFINE ('_UDDEADM_MAINTENANCE_365DAYS', 'Berichten in de afgelopen 365 dagen:');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD1', 'Verstuur een herinnering aan (Vergeetmijniet: %s days):');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD2', 'Stuur over %s dagen een herinnering aan:');
DEFINE ('_UDDEADM_MAINTENANCE_NO', 'Nee:');
DEFINE ('_UDDEADM_MAINTENANCE_USERID', 'Gebruikers ID:');
DEFINE ('_UDDEADM_MAINTENANCE_TONAME', 'Naam:');
DEFINE ('_UDDEADM_MAINTENANCE_MID', 'Bericht ID:');
DEFINE ('_UDDEADM_MAINTENANCE_WRITTEN', 'Geschreven:');
DEFINE ('_UDDEADM_MAINTENANCE_TIMER', 'Timer:');

// New: 1.5
DEFINE ('_UDDEMODULE_ALLDAYS', ' Berichten');
DEFINE ('_UDDEMODULE_7DAYS', ' Berichten in de afgelopen 7 dagen');
DEFINE ('_UDDEMODULE_30DAYS', ' Berichten in de afgelopen 30 dagen');
DEFINE ('_UDDEMODULE_365DAYS', ' Berichten in de afgelopen 365 dagen');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_WARNING', '<br /><b>Belangrijk:<br />indien je mosMail gebruikt, moet je een geldig e-mailaddres instellen!</b>');
DEFINE ('_UDDEIM_FILTEREDMESSAGE', 'Bericht gefilterd');
DEFINE ('_UDDEIM_FILTEREDMESSAGES', 'Berichten gefilterd');
DEFINE ('_UDDEIM_FILTER', 'Filter:');
DEFINE ('_UDDEIM_FILTER_TITLE_INBOX', 'Laat alleen van deze gebruiker zien');
DEFINE ('_UDDEIM_FILTER_TITLE_OUTBOX', 'Laat alleen aan deze gebruiker zien');
DEFINE ('_UDDEIM_FILTER_UNREAD_ONLY', 'alleen ongelezen');
DEFINE ('_UDDEIM_FILTER_SUBMIT', 'Filter');
DEFINE ('_UDDEIM_FILTER_ALL', '- alle -');
DEFINE ('_UDDEIM_FILTER_PUBLIC', '- Openbare gebruikers -');
DEFINE ('_UDDEADM_FILTER_HEAD', 'Schakel Filter in');
DEFINE ('_UDDEADM_FILTER_EXP', 'Indien ingeschakeld kunnen gebruikers hun in/uitbox filteren op één ontvanger of afzender.');

DEFINE ('_UDDEADM_FILTER_P0', 'Uitgeschakeld');
DEFINE ('_UDDEADM_FILTER_P1', 'Bovenaan berichtenlijst');
DEFINE ('_UDDEADM_FILTER_P2', 'Onderaan berichtenlijst');
DEFINE ('_UDDEADM_FILTER_P3', 'Bovenaan en onderaan berichtenlijst');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED', '<b>Je hebt geen%s berichten%s in je%s.</b>');	// see next  six lines
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_UNREAD', ' Ongelezen');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_FROM', ' van deze gebruiker');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_TO', ' aan deze gebruiker');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_INBOX', ' Inbox');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_OUTBOX', ' Uitbox');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_ARCHIVE', ' Archief');
DEFINE ('_UDDEIM_TODP_TITLE', 'Ontvanger');
DEFINE ('_UDDEIM_TODP_TITLE_CC', 'Een of meer ontvangers (door komma gescheiden)');
DEFINE ('_UDDEIM_ADDCCINFO_TITLE', 'Indien aangevinkt wordt een regel met alle ontvangers toegevoegd aan het bericht');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_2', '...stel als standaard in voor autoresponder, autoforwarding, inputbox, filter');
DEFINE ('_UDDEADM_AUTORESPONDER_HEAD', 'Schakel de Automatische Beantwoorder in');
DEFINE ('_UDDEADM_AUTORESPONDER_EXP', 'Als de automatische beantwoorder is ingeschakeld kan de gebruiker een automatisch antwoord bericht instellen in de persoonlijke gebruikersvoorkeuren.');
DEFINE ('_UDDEIM_EMN_AUTORESPONDER', 'Schakel automatische beantwoorder in');
DEFINE ('_UDDEIM_AUTORESPONDER', 'Automatische beantwoorder');
DEFINE ('_UDDEIM_AUTORESPONDER_EXP', 'als de automatische beantwoorder is ingeschakeld wordt elk binnen gekomen bericht meteen beantwoord');
DEFINE ('_UDDEIM_AUTORESPONDER_DEFAULT', "Sorry, ik ben op dit moment niet beschikbaar. \nIk verwerk mijn berichten zo snel mogelijk");
DEFINE ('_UDDEADM_USERSET_AUTOR', 'AutoR');
DEFINE ('_UDDEADM_USERSET_SELAUTOR', '- AutoR -');
DEFINE ('_UDDEIM_USERBLOCKED', 'Gebruiker is geblokkeerd');
DEFINE ('_UDDEADM_AUTOFORWARD_HEAD', 'Schakel automatisch doorsturen in');
DEFINE ('_UDDEADM_AUTOFORWARD_EXP', 'als automatisch doorsturen is ingeschakeld kan de gebruiker nieuwe berichten meteen laten doorsturen naar een andere gebruiker');

DEFINE ('_UDDEIM_EMN_AUTOFORWARD', 'Schakel Automatisch Doorsturen in');
DEFINE ('_UDDEADM_USERSET_AUTOF', 'AutoF');
DEFINE ('_UDDEADM_USERSET_SELAUTOF', '- AutoF -');
DEFINE ('_UDDEIM_AUTOFORWARD', 'Automatisch Doorsturen');
DEFINE ('_UDDEIM_AUTOFORWARD_EXP', 'Nieuwe berichten kunnen meteen worden doorgestuurd naar een andere gebruiker');

DEFINE ('_UDDEIM_THISISAFORWARD', 'Automatisch doorsturen van een bericht oorspronkelijk gestuurd naar ');
DEFINE ('_UDDEADM_COLSROWS_HEAD', 'Berichtenbox (kol/rijen)');
DEFINE ('_UDDEADM_COLSROWS_EXP', 'Specificeer hier de kolommen en rijen van de berichenbox (standaard waarde is 60/10).');
DEFINE ('_UDDEADM_WIDTH_HEAD', 'Berichtenbox (breedte)');
DEFINE ('_UDDEADM_WIDTH_EXP', 'Specificeer hier de breedte van de berichtenbox in px (standaard waarde is 0). Indien deze waarde 0 is, zal de breedte in het CSS bestand gebruikt worden');
DEFINE ('_UDDEADM_CBE', 'CB Geavanceerd');

// New: 1.4
DEFINE ('_UDDEADM_IMPORT_CAPS', 'IMPORTEER');

// New: 1.3
DEFINE ('_UDDEADM_MOOTOOLS_HEAD', 'Laadt MooTools');
DEFINE ('_UDDEADM_MOOTOOLS_EXP', 'Specificeer hier hoe uddeIM MooTools laadt (MooTools is benodigd voor het Autoaanvullen): <i>Geen</i> is handig als je template MooTools laadt, <i>Auto</i> is de standaaard waarde en wordt aangeraden (zelfde gedrag als uddeIM 1.2), indien je J1.0 gebruikt kun je ook het forceren om MooTools 1.1 or 1.2 te laden.');
DEFINE ('_UDDEADM_MOOTOOLS_NONE', 'MooTools niet laden');
DEFINE ('_UDDEADM_MOOTOOLS_AUTO', 'automatisch');
DEFINE ('_UDDEADM_MOOTOOLS_1', 'forceer het laden van MooTools 1.1');
DEFINE ('_UDDEADM_MOOTOOLS_2', 'forceer het laden van MooTools 1.2');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_1', '...instellen standaard waarde voor MooTools');
DEFINE ('_UDDEADM_AGORA', 'Agora');

// New: 1.2
DEFINE ('_UDDEADM_CRYPT3', 'Base64 ge-encodeerd');
DEFINE ('_UDDEADM_TIMEZONE_HEAD', 'Aanpassen tijdzone');
DEFINE ('_UDDEADM_TIMEZONE_EXP', 'als uddeIM de verkeerde tijd toont kun je hier de instellingen voor de tijdzone aanpassen. Normaal gesproken, als alles goed is ingesteld, zou dit 0 moeten zijn. Toch kunnen er omstandigheden voorkomen waarin je deze waarde aan dient te passen.');

DEFINE ('_UDDEADM_HOURS', 'uur');
DEFINE ('_UDDEADM_VERSIONCHECK', 'Versie informatie:');
DEFINE ('_UDDEADM_STATISTICS', 'Statistieken:');
DEFINE ('_UDDEADM_STATISTICS_HEAD', 'Toon statistieken');
DEFINE ('_UDDEADM_STATISTICS_EXP', 'Dit laat enkele statistieken zien zoals het aantal opgeslagen berichten etc.');
DEFINE ('_UDDEADM_STATISTICS_CHECK', 'TOON STATISTIEKEN');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT', 'Berichten opgeslagen in de database: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_RECIPIENT', 'Berichten weggegooid door de ontvanger: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_SENDER', 'Berichten weggegooid door de afzender: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_TRASH', 'Berichten in de wachtrij om opgeschoond te worden: ');
DEFINE ('_UDDEADM_OVERWRITEITEMID_HEAD', 'Overschrijf Itemid');
DEFINE ('_UDDEADM_OVERWRITEITEMID_EXP', 'Normaal gesproken probeert uddeIM het juiste Itemid te detecteren indien niet ingesteld. In sommige gevallen kan het nodig zijn deze waarde te overschrijven, bijvoorbeeld indien je meerdere menulinks naar uddeIM hebt.');

DEFINE ('_UDDEADM_OVERWRITEITEMID_CURRENT', 'Gedetecteerd Itemid is: ');
DEFINE ('_UDDEADM_USEITEMID_HEAD', 'Gebruik Itemid');
DEFINE ('_UDDEADM_USEITEMID_EXP', 'Gebruik dit Itemid in plaats van het gedetecteerde.');
DEFINE ('_UDDEADM_SHOWLINK_HEAD', 'Gebruik profiellinks');
DEFINE ('_UDDEADM_SHOWLINK_EXP', 'indien dit op <i>ja</i> staat, worden alle gebruikersnamen die je ziet in uddeIM getoond als links naar het gebruikersprofiel.');
DEFINE ('_UDDEADM_SHOWPIC_HEAD', 'Toon thumbnails');
DEFINE ('_UDDEADM_SHOWPIC_EXP', 'indien dit op <i>ja</i> staat, worden de thumbnails van de gebruiker getoond bij het lezen van een bericht.');

DEFINE ('_UDDEADM_THUMBLISTS_HEAD', 'Toon thumbnails in lijst vorm');
DEFINE ('_UDDEADM_THUMBLISTS_EXP', 'Zet op <i>ja</i> als je de thumbnails van gebruikers wilt tonen in de berichtenlijst (inbox, uitbox, etc.)');
DEFINE ('_UDDEADM_FIREBOARD', 'Vuurboord');
DEFINE ('_UDDEADM_CB', 'Communiteit bouwer');
DEFINE ('_UDDEADM_DISABLED', 'Uitgeschakeld');
DEFINE ('_UDDEADM_ENABLED', 'Ingeschakeld');
DEFINE ('_UDDEIM_STATUS_FLAGGED', 'Belangrijk');
DEFINE ('_UDDEIM_STATUS_UNFLAGGED', '');
DEFINE ('_UDDEADM_ALLOWFLAGGED_HEAD', 'Sta markeren van berichten toe');
DEFINE ('_UDDEADM_ALLOWFLAGGED_EXP', 'Sta markeren van berichten toe (uddeIM toont een ster in de lijsten die gemarkeerd kunnen worden om belangrijke berichten te markeren).');
DEFINE ('_UDDEADM_REVIEWUPDATE', 'Belangrijk: als je uddeIM hebt geüpdate vanuit een oudere versie lees het README bestand. Soms is het nodig database tabellen of velden toe te voegen of te wijzigen!');
DEFINE ('_UDDEIM_ADDCCINFO', 'Voeg CC: regel toe');
DEFINE ('_UDDEIM_CC', 'CC:');
DEFINE ('_UDDEADM_TRUNCATE_HEAD', 'Afkappen gequote tekst');
DEFINE ('_UDDEADM_TRUNCATE_EXP', 'Kap gequote tekst af bij 2/3 van de maximale tekstlengte indien deze limiet wordt overschreden.');

DEFINE ('_UDDEIM_PLUG_INBOXENTRIES', 'Inbox berichten ');
DEFINE ('_UDDEIM_PLUG_LAST', 'Laatste ');
DEFINE ('_UDDEIM_PLUG_ENTRIES', ' berichten');
DEFINE ('_UDDEIM_PLUG_STATUS', 'Status');
DEFINE ('_UDDEIM_PLUG_SENDER', 'Afzender');
DEFINE ('_UDDEIM_PLUG_MESSAGE', 'Bericht');
DEFINE ('_UDDEIM_PLUG_EMPTYINBOX', 'Maak Inbox leeg');

// New: 1.1
DEFINE ('_UDDEADM_NOTRASHACCESS_NOT', 'Toegang tot de prullenbak geweigerd.');
DEFINE ('_UDDEADM_NOTRASHACCESS_HEAD', 'Beperk de toegang tot de prullenbak');
DEFINE ('_UDDEADM_NOTRASHACCESS_EXP', 'Je kunt de toegang tot de prullenbak beperken. Meestal is de prullenbak voor iedereen beschikbaar. (<i>geen beperking</i>). Je kunt de toegang beperken voor enkel speciale gebruikers of enkel voor admins, waardoor groepen met minder rechten een verwijderd bericht niet terug kunnen halen.');

DEFINE ('_UDDEADM_NOTRASHACCESS_0', 'geen beperkingen');
DEFINE ('_UDDEADM_NOTRASHACCESS_1', 'speciale gebruikers');
DEFINE ('_UDDEADM_NOTRASHACCESS_2', 'enkel admins');
DEFINE ('_UDDEADM_PUBHIDEUSERS_HEAD', 'Verberg gebruikers van de gebruikerslijst');
DEFINE ('_UDDEADM_PUBHIDEUSERS_EXP', 'Voer het ID in van de gebruikers die verborgen moeten blijven in openbare gebruikerslijsten (bv. 65,66,67).');
DEFINE ('_UDDEADM_HIDEUSERS_HEAD', 'Verberg gebruikers in de gebruikerslijst');
DEFINE ('_UDDEADM_HIDEUSERS_EXP', 'Voer het ID in van de gebruikers die verborgen moeten blijven in de gebruikerslijst (e.g. 65,66,67). Admins zien altijd de complete lijst.');
DEFINE ('_UDDEIM_ERRORCSRF', 'CSRF aanval herkend');
DEFINE ('_UDDEADM_CSRFPROTECTION_HEAD', 'CSRF bescherming');
DEFINE ('_UDDEADM_CSRFPROTECTION_EXP', 'Dit beschermt alle formulieren tegen Cross-Site Request Forgery aanvallen. Dit moet normaal gesproken aan staan. Allen uitschakelen indien je vreemde problemen ervaardt.');

DEFINE ('_UDDEIM_CANTREPLYARCHIVE', 'Je kunt niet antwoorden op gearchiveerde berichten.');
DEFINE ('_UDDEIM_COULDNOTRECALLPUBLIC', 'Antwoorden aan ongeregistreerde gebruikers kunnen niet herroepen worden.');
DEFINE ('_UDDEADM_PUBREPLYS_HEAD', 'Antwoorden toestaan');
DEFINE ('_UDDEADM_PUBREPLYS_EXP', 'Toestaan directe antwoorden op berichten van openbare gebruikers.');
DEFINE ('_UDDEADM_PUBNAMESTEXT', 'Toon echte naam');
DEFINE ('_UDDEADM_PUBNAMESDESC', 'Echte namen of gebruikersnamen tonen in de openbare frontend?');
DEFINE ('_UDDEIM_USERLIST', 'Gebruikerslijst');
DEFINE ('_UDDEIM_YOUHAVETOWAIT', 'Sorry, je moet wachten voor je meer berichten kunt sturen');
DEFINE ('_UDDEADM_USERSET_LASTSENT', 'Laatst gestuurd');
DEFINE ('_UDDEADM_TIMEDELAY_HEAD', 'Wachttijd');
DEFINE ('_UDDEADM_TIMEDELAY_EXP', 'Tijd in seconden die een gebruiker moet wachten eer hij het volgende bericht kan sturen (0 voor geen wachttijd).');

DEFINE ('_UDDEADM_SECONDS', 'seconden');
DEFINE ('_UDDEIM_PUBLICSENT', 'Bericht is verstuurd.');
DEFINE ('_UDDEIM_ERRORINFROMNAME', 'Fout in naam van verzender');
DEFINE ('_UDDEIM_ERRORINEMAIL', 'Fout in e-mail addres');
DEFINE ('_UDDEIM_YOURNAME', 'Je naam:');
DEFINE ('_UDDEIM_YOUREMAIL', 'Je e-mail:');
DEFINE ('_UDDEADM_VERSIONCHECK_USING', 'Je gebruikt uddeIM ');
DEFINE ('_UDDEADM_VERSIONCHECK_LATEST', 'Je gebruikt al de nieuwste versie van uddeIM.');
DEFINE ('_UDDEADM_VERSIONCHECK_CURRENT', 'De huidige versie is ');
DEFINE ('_UDDEADM_VERSIONCHECK_INFO', 'Update informatie:');
DEFINE ('_UDDEADM_VERSIONCHECK_HEAD', 'Controleer op updates');
DEFINE ('_UDDEADM_VERSIONCHECK_EXP', 'Hiermee wordt contact gelegd met de website van de ontwikkelaar van om informatie te krijgen over de huidige uddeIM versie.');

DEFINE ('_UDDEADM_VERSIONCHECK_CHECK', 'CONTROLEER NU');
DEFINE ('_UDDEADM_VERSIONCHECK_ERROR', 'Niet mogelijk versie informatie op te halen.');
DEFINE ('_UDDEIM_NOSUCHLIST', 'Contactlijst niet gevonden!');
DEFINE ('_UDDEIM_LISTSLIMIT_1', 'Maximum aantal ontvangers overschreden (max. ');
DEFINE ('_UDDEADM_MAXONLISTS_HEAD', 'Max. aantal items');
DEFINE ('_UDDEADM_MAXONLISTS_EXP', 'Max. aantal items toegestaan per contactlijst.');
DEFINE ('_UDDEIM_LISTSNOTENABLED', 'Contactlijsten is niet ingeschakeld');
DEFINE ('_UDDEADM_ENABLELISTS_HEAD', 'Contactlijsten inschakelen');
DEFINE ('_UDDEADM_ENABLELISTS_EXP', 'uddeIM staat gebruikers toe contactlijsten aan te maken. Deze lijsten kunnen worden gebruikt om berichten aan meerdere gebruikers te versturen. Vergeet niet meerdere ontvangers in te schakelen indien je contactlijsten wilt gebruiken.');

DEFINE ('_UDDEADM_ENABLELISTS_0', 'uitgeschakeld');
DEFINE ('_UDDEADM_ENABLELISTS_1', 'geregistreerde gebruikers');
DEFINE ('_UDDEADM_ENABLELISTS_2', 'speciale gebruikers');
DEFINE ('_UDDEADM_ENABLELISTS_3', 'alleen admins');
DEFINE ('_UDDEIM_LISTSNEW', 'Maak een nieuwe contactlijst');
DEFINE ('_UDDEIM_LISTSSAVED', 'Contactlijst opgeslagen');
DEFINE ('_UDDEIM_LISTSUPDATED', 'Contactlijst bijgewerkt');
DEFINE ('_UDDEIM_LISTSDESC', 'Beschrijving');
DEFINE ('_UDDEIM_LISTSNAME', 'Naam');
DEFINE ('_UDDEIM_LISTSNAMEWO', 'Naam (zonder spaties)');
DEFINE ('_UDDEIM_EDITLINK', 'wijzig');
DEFINE ('_UDDEIM_LISTS', 'Contacten');
DEFINE ('_UDDEIM_STATUS_READ', 'gelezen');
DEFINE ('_UDDEIM_STATUS_UNREAD', 'ongelezen');
DEFINE ('_UDDEIM_STATUS_ONLINE', 'online');
DEFINE ('_UDDEIM_STATUS_OFFLINE', 'offline');
DEFINE ('_UDDEADM_CBGALLERY_HEAD', 'toon CB gallerie afbeeldingen');
DEFINE ('_UDDEADM_CBGALLERY_EXP', 'Standaard toont uddeIM alleen avatars die gebruikers hebben geupload. Als je deze optie inschakelt toont uddeIM ook afbeeldingen uit de CB avatars gallerie.');
DEFINE ('_UDDEADM_UNBLOCKCB_HEAD', 'Deblokkeer CB connecties');
DEFINE ('_UDDEADM_UNBLOCKCB_EXP', 'Je kunt ook toestaan om berichten te sturen aan ontvangers die als geregistreerde gebruiker op de CB connectielijst staat (zelfs indien de gebruiker in een geblokkeerde groep zit). Deze instelling is niet afhankelijk van de individuele blokkering die elke gebruiker kan instellen (zie instellingen hierboven).');
DEFINE ('_UDDEIM_GROUPBLOCKED', 'Het is je niet toegstaan naar deze groep te sturen.');
DEFINE ('_UDDEIM_ONEUSERBLOCKS', 'De ontvanger heeft je geblokkeerd.');
DEFINE ('_UDDEADM_BLOCKGROUPS_HEAD', 'Geblokkeerde groepen (geregistreerde gebruikers)');
DEFINE ('_UDDEADM_BLOCKGROUPS_EXP', 'Groepen waar geregistreerde gebruikers geen berichten naar toe mogen sturen. Dit is enkel voor geregistreerde gebruikers. Speciale gebruikers en admins worden hier niet door betroffen. Deze instelling is onafhankelijk van de individuele blokkering die elke gebruiker kan instellen (zie instellingen hierboven).');
DEFINE ('_UDDEADM_PUBBLOCKGROUPS_HEAD', 'Geblokkeerde groepen (openbare gebruikers)');
DEFINE ('_UDDEADM_PUBBLOCKGROUPS_EXP', 'Groepen waar openbare gebruikers  geen berichten naar toe mogen sturen. Deze instelling is niet afhankelijk van de individuele blokkering die elke gebruiker kan instellen indien ingeschakeld (zie instellingen hierboven). Als je een groep bokkeert, kunnen gebruikers in deze groep de optie om de openbare frontend niet zien in hun profiel instellingen.');

DEFINE ('_UDDEADM_BLOCKGROUPS_1', 'openbare gebruikers');
DEFINE ('_UDDEADM_BLOCKGROUPS_2', 'CB connecties');
DEFINE ('_UDDEADM_BLOCKGROUPS_18', 'Geregistreerde gebruiker');
DEFINE ('_UDDEADM_BLOCKGROUPS_19', 'auteur');
DEFINE ('_UDDEADM_BLOCKGROUPS_20', 'Wijziger');
DEFINE ('_UDDEADM_BLOCKGROUPS_21', 'Publiceerder');
DEFINE ('_UDDEADM_BLOCKGROUPS_23', 'Manager');
DEFINE ('_UDDEADM_BLOCKGROUPS_24', 'Admin');
DEFINE ('_UDDEADM_BLOCKGROUPS_25', 'SuperAdmin');
DEFINE ('_UDDEIM_NOPUBLICMSG', 'Gebruiker accepteert enkel berichten van geregistreerde gebruiker.');

DEFINE ('_UDDEADM_PUBHIDEALLUSERS_HEAD', 'Verberg in de openbare "Alle gebruikers" lijst');
DEFINE ('_UDDEADM_PUBHIDEALLUSERS_EXP', 'Je kunt groepen Verbergen in de openbare "Alle gebruikers" lijst. Let op: hiermee verberg je alleen de namen, de gebruikers kunnen nog steeds berichten ontvangen. Gebruikers die hebben aangegeven dat ze niet zichtbaar willen zijn voor openbare gebruikers zullen nooit zichtbaar zijn in deze lijst.');

DEFINE ('_UDDEADM_HIDEALLUSERS_HEAD', 'Verberg in de "Alle gebruikers" lijst');
DEFINE ('_UDDEADM_HIDEALLUSERS_EXP', 'Je kunt groepen Verbergen in de "Alle gebruikers" lijst. Let op: hiermee verberg je alleen de namen, de gebruikers kunnen nog steeds berichten ontvangen.');
DEFINE ('_UDDEADM_HIDEALLUSERS_0', 'geen');
DEFINE ('_UDDEADM_HIDEALLUSERS_1', 'enkel superadmins');
DEFINE ('_UDDEADM_HIDEALLUSERS_2', 'enkel admins');
DEFINE ('_UDDEADM_HIDEALLUSERS_3', 'speciale gebruikers');
DEFINE ('_UDDEADM_PUBLIC', 'Openbaar');
DEFINE ('_UDDEADM_PUBMODESHOWALLUSERS_HEAD', 'Gedrag van de link "Alle gebruikers" ');
DEFINE ('_UDDEADM_PUBMODESHOWALLUSERS_EXP', 'Kies of de link "Alle gebruikers" onderdrukt of getoond moet worden op de openbare site of dat altijd alle gebruikers getoond moeten worden.');

DEFINE ('_UDDEADM_USERSET_PUBLIC', 'openbare site');
DEFINE ('_UDDEADM_USERSET_SELPUBLIC', '- selecteer openbaar -');
DEFINE ('_UDDEIM_OPTIONS_F', 'Sta gebruikers toe berichten te sturen');
DEFINE ('_UDDEIM_MSGLIMITREACHED', 'Berichtenlimiet bereikt!');
DEFINE ('_UDDEIM_PUBLICUSER', 'openbare gebruikers');
DEFINE ('_UDDEIM_DELETEDUSER', 'gebruiker verwijderd');
DEFINE ('_UDDEADM_CAPTCHALEN_HEAD', 'Captcha lengte');
DEFINE ('_UDDEADM_CAPTCHALEN_EXP', 'Specificeer hoeveel karakters een gebruiker moet invoeren.');
DEFINE ('_UDDEADM_USECAPTCHA_HEAD', 'Captcha spam bescherming');
DEFINE ('_UDDEADM_USECAPTCHA_EXP', 'Specificeer wie captcha moet invullen om een bericht te kunnen versturen.');
DEFINE ('_UDDEADM_CAPTCHAF0', 'uitgeschakeld');
DEFINE ('_UDDEADM_CAPTCHAF1', 'alleen openbare gebruikers');
DEFINE ('_UDDEADM_CAPTCHAF2', 'openbare en geregistreerde gebruikers');
DEFINE ('_UDDEADM_CAPTCHAF3', 'openbare, geregistreerde en speciale gebruikers');
DEFINE ('_UDDEADM_CAPTCHAF4', 'alle gebruikers (incl. admins)');
DEFINE ('_UDDEADM_PUBFRONTEND_HEAD', 'Schakel optie Openbare Site in');
DEFINE ('_UDDEADM_PUBFRONTEND_EXP', 'Indien ingeschakeld kunnen openbare gebruikers berichten sturen aan geregistreerde gebruikers (die kunnen in hun persoonlijke instellingen aangeven of ze dit willen).');

DEFINE ('_UDDEADM_PUBFRONTENDDEF_HEAD', 'openbare site standaard');
DEFINE ('_UDDEADM_PUBFRONTENDDEF_EXP', 'Dit is de standaard waarde of openbare gebruikers berichten mogen sturen aan geregistreerde gebruikers.');
DEFINE ('_UDDEADM_PUBDEF0', 'uitgeschakeld');
DEFINE ('_UDDEADM_PUBDEF1', 'ingeschakeld');
DEFINE ('_UDDEIM_WRONGCAPTCHA', 'verkeerde beveiligingscode');

// New: 1.0
DEFINE ('_UDDEADM_NONEORUNKNOWN', 'geen of niet bekend');
DEFINE ('_UDDEADM_DONATE', 'Indien je uddeIM gebruikt en bent er tevreden mee overweeg dan om een donatie te doen.');
// New: 1.0rc2
DEFINE ('_UDDEADM_BACKUPRESTORE_DATE', 'Configuratie gevonden in database: ');
DEFINE ('_UDDEADM_BACKUPRESTORE_HEAD', 'Back-up en terugzetten van configuratie');
DEFINE ('_UDDEADM_BACKUPRESTORE_EXP', 'Je kunt je back-up opslaan in de database. Dit kan handig zijn als je uddeIM wilt gaat updaten of een andere instelling wilt uitproberen.');
DEFINE ('_UDDEADM_BACKUPRESTORE_BACKUP', 'Back-up');
DEFINE ('_UDDEADM_BACKUPRESTORE_RESTORE', 'Terugzetten');
DEFINE ('_UDDEADM_CANCEL', 'Annuleren');
// New: 1.0rc1
DEFINE ('_UDDEADM_LANGUAGECHARSET_HEAD', 'Taalbestand karakterset');
DEFINE ('_UDDEADM_LANGUAGECHARSET_EXP', 'Gewoonlijk gebruiken we <strong>Standaard</strong> (ISO-8859-1) voor Joomla 1.0 en <strong>UTF-8</strong> voor Joomla 1.5.');
DEFINE ('_UDDEADM_LANGUAGECHARSET_UTF8', 'UTF-8');
DEFINE ('_UDDEADM_LANGUAGECHARSET_DEFAULT', 'Standaard');
DEFINE ('_UDDEIM_READ_INFO_1', 'Gelezen berichten zullen maximaal  ');
DEFINE ('_UDDEIM_READ_INFO_2', ' dagen in de inbox blijven voordat ze automatisch verwijderd worden.');
DEFINE ('_UDDEIM_UNREAD_INFO_1', 'Ongelezen berichten zullen maximaal ');
DEFINE ('_UDDEIM_UNREAD_INFO_2', ' dagen in de inbox blijven voordat ze automatisch verwijderd worden.');
DEFINE ('_UDDEIM_SENT_INFO_1', 'Verzonden berichten zullen maximaal ');
DEFINE ('_UDDEIM_SENT_INFO_2', ' dagen in de outbox blijven voordat ze automatisch verwijderd worden.');
DEFINE ('_UDDEADM_DELETEREADAFTERNOTE_HEAD', 'Geef inbox notificatie weer voor gelezen berichten');
DEFINE ('_UDDEADM_DELETEREADAFTERNOTE_EXP', 'Geef inbox notificatie "Gelezen berichten zullen worden verwijderd na n dagen" weer');
DEFINE ('_UDDEADM_DELETEUNREADAFTERNOTE_HEAD', 'Geef inbox notificatie weer voor ongelezen berichten');
DEFINE ('_UDDEADM_DELETEUNREADAFTERNOTE_EXP', 'Geef inbox notificatie "Ongelezen berichten zullen worden verwijderd na n dagen" weer');
DEFINE ('_UDDEADM_DELETESENTAFTERNOTE_HEAD', 'Geef outbox notificatie weer voor verzonden berichten');
DEFINE ('_UDDEADM_DELETESENTAFTERNOTE_EXP', 'Geef outbox notificatie "Verzonden berichten zullen worden verwijderd na n dagen" weer');
DEFINE ('_UDDEADM_DELETETRASHAFTERNOTE_HEAD', 'Geef prullenbak notificatie weer voor verwijderd berichten');
DEFINE ('_UDDEADM_DELETETRASHAFTERNOTE_EXP', 'Geef prullenbak notificatie "Verwijderde berichten zullen worden verwijderd na n dagen" weer');
DEFINE ('_UDDEADM_DELETESENTAFTER_HEAD', 'Verzonden berichten bewaren (dagen)');
DEFINE ('_UDDEADM_DELETESENTAFTER_EXP', 'Vul het aantal dagen in waarna <b>verzonden</b> berichten automatisch uit de outbox zullen worden verwijderd.');
DEFINE ('_UDDEIM_SEND_TOALLSPECIAL', 'verstuur aan alle speciale gebruikers');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLSPECIAL', 'Bericht aan <strong>alle speciale gebruikers</strong>');
DEFINE ('_UDDEADM_USERSET_SELUSERNAME', '- Selecteer gebruikersnaam -');
DEFINE ('_UDDEADM_USERSET_SELNAME', '- Selecteer naam -');
DEFINE ('_UDDEADM_USERSET_EDITSETTINGS', 'Wijzig gebruikers instellingen');
DEFINE ('_UDDEADM_USERSET_EXISTING', 'bestaand');
DEFINE ('_UDDEADM_USERSET_NONEXISTING', 'niet bestaand');
DEFINE ('_UDDEADM_USERSET_SELENTRY', '- Selecteer invoeging -');
DEFINE ('_UDDEADM_USERSET_SELNOTIFICATION', '- Selecteer informatie -');
DEFINE ('_UDDEADM_USERSET_SELPOPUP', '- Selecteer popup -');

DEFINE ('_UDDEADM_USERSET_USERNAME', 'Gebruikersnaam');
DEFINE ('_UDDEADM_USERSET_NAME', 'Naam');
DEFINE ('_UDDEADM_USERSET_NOTIFICATION', 'Notificatie');
DEFINE ('_UDDEADM_USERSET_POPUP', 'Popup');
DEFINE ('_UDDEADM_USERSET_LASTACCESS', 'Laatste toegang');
DEFINE ('_UDDEADM_USERSET_NO', 'Nee');
DEFINE ('_UDDEADM_USERSET_YES', 'Ja');
DEFINE ('_UDDEADM_USERSET_UNKNOWN', 'Onbekend');
DEFINE ('_UDDEADM_USERSET_WHENOFFLINEEXCEPT', 'Offline (behalve bij antwoorden)');
DEFINE ('_UDDEADM_USERSET_ALWAYSEXCEPT', 'Altijd (behalve bij antwoorden)');
DEFINE ('_UDDEADM_USERSET_WHENOFFLINE', 'Offline');
DEFINE ('_UDDEADM_USERSET_ALWAYS', 'Altijd');
DEFINE ('_UDDEADM_USERSET_NONOTIFICATION', 'Informatie');
DEFINE ('_UDDEADM_WELCOMEMSG', "Welkom bij uddeIM!\n\nJe hebt uddeIM succesvol geïnstalleerd.\n\nProbeer dit bericht met meerdere templates te bekijken. Je kunt een template kiezen in het backend van uddeIM.\n\nuddeIM is een project waaraan veel wordt gewerkt en waar dus ook fouten kunnen insluipen. Vind je een fout of iets anders wat niet in orde is, stuur mij dan ajb een e-mail waardoor wij uddeIM nog beter kunnen maken.\n\nVeel plezier met uddeIM.");
DEFINE ('_UDDEADM_UDDEINSTCOMPLETE', 'uddeIM installatie is voltooid.');
DEFINE ('_UDDEADM_REVIEWSETTINGS', 'Ga nu eerst verder met de configuratie van uddeIM.');
DEFINE ('_UDDEADM_REVIEWLANG', 'Als je een ander karakter set gebruikt in je CMS dan ISO 8859-1, pas de instellingen daar dan ook op aan.');
DEFINE ('_UDDEADM_REVIEWEMAILSTOP', 'Na installatie is alle uddeIM e-mail berichtgeving uitgeschakeld. Dit is handig bij het testen van de uddeIM. Vergeet niet om na het testen om het "Stop e-mails verzenden" in de configuratie uit te zetten .');
DEFINE ('_UDDEADM_MAXRECIPIENTS_HEAD', 'Maximaal aantal ontvangers');
DEFINE ('_UDDEADM_MAXRECIPIENTS_EXP', 'Maximaal aantal ontvangers toegestaan per bericht(0 = onbeperkt)');
DEFINE ('_UDDEIM_TOOMANYRECIPIENTS', 'te veel ontvangers');
DEFINE ('_UDDEIM_STOPPEDEMAIL', 'Versturen van e-mails uitgeschakeld.');
DEFINE ('_UDDEADM_SEARCHINSTRING_HEAD', 'Uitgebreid zoeken');
DEFINE ('_UDDEADM_SEARCHINSTRING_EXP', 'Automatisch aanvullen doorzoekt ook delen van de tekst(dus niet alleen vanaf het begin en het hele woord)');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_HEAD', 'Gedrag van de "Alle gebruikers" link');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_EXP', 'Maak een keuze of de link "Alle gebruikers" moet worden weggelaten, weergegeven of dat alle gebruikers zichtbaar moeten zijn.');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_0', 'Laat de link "Alle gebruikers" weg');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_1', 'Geef de link "Alle gebruikers" weer');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_2', 'Geef altijd alle gebruikers weer');
DEFINE ('_UDDEADM_CONFIGNOTWRITEABLE', 'Configuratie is onschrijfbaar:');
DEFINE ('_UDDEADM_CONFIGWRITEABLE', 'Configuratie is schrijfbaar:');
DEFINE ('_UDDEIM_FORWARDLINK', 'doorsturen');
DEFINE ('_UDDEIM_RECIPIENTFOUND', 'ontvanger gevonden');
DEFINE ('_UDDEIM_RECIPIENTSFOUND', 'ontvangers gevonden');
DEFINE ('_UDDEADM_MAILSYSTEM_MOSMAIL', 'mosMail');
DEFINE ('_UDDEADM_MAILSYSTEM_PHPMAIL', 'php mail (standaard)');
DEFINE ('_UDDEADM_MAILSYSTEM_HEAD', 'E-mailsysteem');
DEFINE ('_UDDEADM_MAILSYSTEM_EXP', 'Selecteer het e-mailsysteem dat moet worden gebruikt door uddeIM voor het versturen van informatieve berichten.');
DEFINE ('_UDDEADM_SHOWGROUPS_HEAD', 'Geef Joomla! groepen weer');
DEFINE ('_UDDEADM_SHOWGROUPS_EXP', 'Geef Joomla! groepen weer in standaard lijsten.');
DEFINE ('_UDDEADM_ALLOWFORWARDS_HEAD', 'Doorsturen van berichten');
DEFINE ('_UDDEADM_ALLOWFORWARDS_EXP', 'Sta het doorsturen van berichten toe.');
DEFINE ('_UDDEIM_FWDFROM', 'Orgineel bericht van');
DEFINE ('_UDDEIM_FWDTO', 'aan');

// New: 0.9+
DEFINE ('_UDDEIM_UNARCHIVE', 'De-archiveer bericht');
DEFINE ('_UDDEIM_CANTUNARCHIVE', 'Kan het bericht niet de-archiveren');
DEFINE ('_UDDEADM_ALLOWMULTIPLERECIPIENTS_HEAD', 'Sta meerdere ontvangers toe');
DEFINE ('_UDDEADM_ALLOWMULTIPLERECIPIENTS_EXP', 'Sta meerdere ontvangers toe(geschieden door komma).');
DEFINE ('_UDDEIM_CHARSLEFT', 'Tekens over');
DEFINE ('_UDDEADM_SHOWTEXTCOUNTER_HEAD', 'Geef tekens-teller weer');
DEFINE ('_UDDEADM_SHOWTEXTCOUNTER_EXP', 'Laat een teller zien waarop aangegeven staat hoeveel tekens je nog kunt gebruiken in het bericht.');
DEFINE ('_UDDEIM_CLEAR', 'Wissen');
DEFINE ('_UDDEADM_ALLOWMULTIPLEUSER_HEAD', 'Voeg geselecteerde ontvangers toe aan lijst');
DEFINE ('_UDDEADM_ALLOWMULTIPLEUSER_EXP', 'Dit geeft de mogelijkheid om naar meerdere gebruikers te sturen.');
DEFINE ('_UDDEADM_CBALLOWMULTIPLEUSER_HEAD', 'Voeg CB connecties toe aan lijst');
DEFINE ('_UDDEADM_CBALLOWMULTIPLEUSER_EXP', 'Dit geeft de mogelijkheid om naar meerdere gebruikers te sturen.');
DEFINE ('_UDDEADM_PMSFOUND', 'Prive Berichten Gevonden: ');
DEFINE ('_UDDEIM_ENTERNAME', 'vul een naam in');
DEFINE ('_UDDEADM_USEAUTOCOMPLETE_HEAD', 'Gebruik automatisch aanvullen');
DEFINE ('_UDDEADM_USEAUTOCOMPLETE_EXP', 'Gebruik automatisch aanvullen voor het aanvullen van gebruikersnamen.');
DEFINE ('_UDDEADM_OBFUSCATING_HEAD', 'Sleutel gebruikt voor het versleutelen van de berichten');
DEFINE ('_UDDEADM_OBFUSCATING_EXP', 'Vul sleutel in die wordt gebruikt voor het versleutelen van berichten. LET OP!!! Wijzig deze sleutel niet meer nadat je het versleutelen hebt aangezet.');
DEFINE ('_UDDEADM_CFGFILE_NOTFOUND', 'Fout configuratie bestand gevonden!');
DEFINE ('_UDDEADM_CFGFILE_FOUND', 'Versie gevonden:');
DEFINE ('_UDDEADM_CFGFILE_EXPECTED', 'Versie verwacht:');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING', 'Converteren van configuratie');
DEFINE ('_UDDEADM_CFGFILE_DONE', 'Klaar!');
DEFINE ('_UDDEADM_CFGFILE_WRITEFAILED', 'Kritieke Fout: Het schrijven naar het configuratie bestand is mislukt:');

// New: 0.8+
DEFINE ('_UDDEIM_ENCRYPTDOWN', 'Versleuteld bericht! - Downloaden is niet mogelijk!');
DEFINE ('_UDDEIM_WRONGPASSDOWN', 'Foutief wachtwoord! - Downloaden is niet mogelijk!');
DEFINE ('_UDDEIM_WRONGPW', 'Foutief wachtwoord! - Neem contact op met de database beheerder!');
DEFINE ('_UDDEIM_WRONGPASS', 'Foutief wachtwoord!');
DEFINE ('_UDDEADM_MAINTENANCE_D1', 'Foute verwijderings datums (inbox/outbox): ');
DEFINE ('_UDDEADM_MAINTENANCE_D2', 'Herstellen van foute verwijderings datums');
DEFINE ('_UDDEIM_TODP', 'Aan: ');
DEFINE ('_UDDEADM_MAINTENANCE_PRUNE', 'Verwijder berichten');
DEFINE ('_UDDEADM_SHOWACTIONICONS_HEAD', 'Geef iconen voor de actielink weer');
DEFINE ('_UDDEADM_SHOWACTIONICONS_EXP', 'Indien ingesteld op <i>ja</i>,  zullen de actielinks worden weergegeven als iconen.');
DEFINE ('_UDDEIM_UNCHECKALL', 'deselecteer alles');
DEFINE ('_UDDEIM_CHECKALL', 'selecteer alles');
DEFINE ('_UDDEADM_SHOWBOTTOMICONS_HEAD', 'Geef links beneden weer als iconen.');
DEFINE ('_UDDEADM_SHOWBOTTOMICONS_EXP', 'Indien ingesteld op <i>ja</i>, worden de links beneden weergegeven als iconen.');
DEFINE ('_UDDEADM_ANIMATED_HEAD', 'Gebruik bewegende emoticons');
DEFINE ('_UDDEADM_ANIMATED_EXP', 'Gebruik bewegende emoticons in plaats van statische emoticons.');
DEFINE ('_UDDEADM_ANIMATEDEX_HEAD', 'Meer bewegende emoticons');
DEFINE ('_UDDEADM_ANIMATEDEX_EXP', 'Geef meer bewegende emoticons weer(wordt als popup link weergegeven).');
DEFINE ('_UDDEIM_PASSWORDREQ', 'Versleuteld bericht - Wachtwoord nodig');
DEFINE ('_UDDEIM_PASSWORD', 'Wachtwoord nodig');
DEFINE ('_UDDEIM_PASSWORDBOX', 'Wachtwoord');
DEFINE ('_UDDEIM_ENCRYPTIONTEXT', ' (codeer tekst)');
DEFINE ('_UDDEIM_DECRYPTIONTEXT', ' (decodeer tekst)');
DEFINE ('_UDDEIM_MORE', 'Meer');

// uddeIM Module
DEFINE ('_UDDEMODULE_PRIVATEMESSAGES', 'Prive Berichten');
DEFINE ('_UDDEMODULE_NONEW', 'geen nieuwe');
DEFINE ('_UDDEMODULE_NEWMESSAGES', 'Nieuwe berichten: ');
DEFINE ('_UDDEMODULE_MESSAGE', 'bericht');
DEFINE ('_UDDEMODULE_MESSAGES', 'berichten');
DEFINE ('_UDDEMODULE_YOUHAVE', 'Je hebt');
DEFINE ('_UDDEMODULE_HELLO', 'Hallo');
DEFINE ('_UDDEMODULE_EXPRESSMESSAGE', 'BELANGRIJK bericht');

// New: 0.7+
DEFINE ('_UDDEADM_USEENCRYPTION', 'Gebruik codering');
DEFINE ('_UDDEADM_USEENCRYPTIONDESC', 'Codeer opgeslagen berichten');
DEFINE ('_UDDEADM_CRYPT0', 'Geen');
DEFINE ('_UDDEADM_CRYPT1', 'Vertroebel berichten');
DEFINE ('_UDDEADM_CRYPT2', 'Versleutel berichten');
DEFINE ('_UDDEADM_NOTIFYDEFAULT_HEAD', 'Standaard instellingen voor e-mail notificatie');
DEFINE ('_UDDEADM_NOTIFYDEFAULT_EXP', 'Standaard instellingen voor e-mail notificatie (voor gebruikers die hun instellingen nog niet hebben gewijzigd).');
DEFINE ('_UDDEADM_NOTIFYDEF_0', 'Geen');
DEFINE ('_UDDEADM_NOTIFYDEF_1', 'Altijd');
DEFINE ('_UDDEADM_NOTIFYDEF_2', 'Alleen als gebruiker offline is');
DEFINE ('_UDDEADM_SUPPRESSALLUSERS_HEAD', 'Verwijder de link "Alle gebruikers"');
DEFINE ('_UDDEADM_SUPPRESSALLUSERS_EXP', 'Verwijder de link "Alle gebruikers" bij nieuw berichten pagina (handig indien je veel gebruikers hebt).');
DEFINE ('_UDDEADM_POPUP_HEAD','Popup informatie');
DEFINE ('_UDDEADM_POPUP_EXP','Geef een popup weer indien er een nieuw bericht binnenkomt. (Kan alleen gebruikt worden met mod_uddeIM)');
DEFINE ('_UDDEIM_OPTIONS', 'Meer instellingen');
DEFINE ('_UDDEIM_OPTIONS_EXP', 'Hier kun je nog wat extra instellingen veranderen.');
DEFINE ('_UDDEIM_OPTIONS_P', 'Geeft een popup weer wanneer er een nieuw bericht komt');
DEFINE ('_UDDEADM_POPUPDEFAULT_HEAD', 'Popup notificatie als standaard');
DEFINE ('_UDDEADM_POPUPDEFAULT_EXP', 'Zet popup notificatie aan (voor gebruikers die hun instellingen nog niet hebben gewijzigd).');
DEFINE ('_UDDEADM_MAINTENANCE', 'Onderhoud');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD', 'Database onderhoud');
DEFINE ('_UDDEADM_MAINTENANCE_CHECK', 'Controleer');
DEFINE ('_UDDEADM_MAINTENANCE_TRASH', 'Repareer');
DEFINE ('_UDDEADM_MAINTENANCE_EXP', "Indien een gebruiker is verwijderd uit de database worden zijn berichten normaliter bewaard. Deze functie controleert of het nodig is om verweesde berichten te verwijderen.<br />Deze optie controleert ook meteen de database op fouten die dan worden gecorrigeerd.");
DEFINE ('_UDDEADM_MAINTENANCE_MC1', "Controleren...<br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC2', "<i>#nnn (Gebruikersnaam): [inbox|inbox verwijderd|outbox|outbox verwijderd]</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC3', "<i>inbox: berichten opgeslagen in de inbox van de gebruiker</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC4', "<i>inbox verwijderd: berichten verwijderd uit de inbox van de gebruiker, maar nog steeds in de uitbox van iemand anders. </i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC5', "<i>outbox: berichten opgeslagen in de uitbox van de gebruiker</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC6', "<i>outbox verwijderd: berichten verwijderd uit de outbox van de gebruiker, maar nog steeds in de inbox van iemand anders</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MT1', "Verwijderen...<br />");
DEFINE ('_UDDEADM_MAINTENANCE_NOTFOUND', "Niet gevonden (van/aan/instellingen/blokkade/geblokkeerd):");
DEFINE ('_UDDEADM_MAINTENANCE_MT2', "verwijder alle voorkeuren van de gebruiker");
DEFINE ('_UDDEADM_MAINTENANCE_MT3', "verwijder blokkade gebruiker");
DEFINE ('_UDDEADM_MAINTENANCE_MT4', "verwijder alle berichten verzonden aan verwijderde gebruiker uit de uitbox en uit de inbox van de ontvanger");
DEFINE ('_UDDEADM_MAINTENANCE_MT5', "verwijderd alle  berichten verzonden door verwijderde gebruiker uit de uitbox en uit de inbox van de ontvangers");
DEFINE ('_UDDEADM_MAINTENANCE_NOTHINGTODO', '<b>Niets te doen<b><br />');
DEFINE ('_UDDEADM_MAINTENANCE_JOBTODO', '<b>Onderhoud Benodigd<b><br />');

// New: 0.6+
DEFINE ('_UDDEADM_NAMESTEXT', 'Geef echte namen weer');
DEFINE ('_UDDEADM_NAMESDESC', 'Echte namen of gebruikersnamen weergeven?');
DEFINE ('_UDDEADM_REALNAMES', 'Echte namen');
DEFINE ('_UDDEADM_USERNAMES', 'Gebruikersnaam');
DEFINE ('_UDDEADM_CONLISTBOX', 'Connectie Lijst');
DEFINE ('_UDDEADM_CONLISTBOXDESC', 'Connecties weergeven in een lijst of in een tabel?');
DEFINE ('_UDDEADM_LISTBOX', 'Lijst');
DEFINE ('_UDDEADM_TABLE', 'Tabel');

DEFINE ('_UDDEIM_TRASHCAN_INFO', 'Berichten in de prullenbak worden automatisch na 48 uur gewist. Je kunt alleen de eerste woorden van het bericht zien. Om het hele bericht te lezen moet je het bericht terug zetten.');
DEFINE ('_UDDEIM_TRASHCAN_INFO_1', 'Berichten in de prullenbak worden na ');
DEFINE ('_UDDEIM_TRASHCAN_INFO_2', ' uur automatisch gewist. Je kunt alleen de eerste woorden van het bericht zien. Om het hele bericht te lezen moet je het bericht terug zetten.');
DEFINE ('_UDDEIM_RECALLEDMESSAGE_INFO', 'Dit bericht is geannuleerd. Je kunt het bericht bewerken en opnieuw zenden, of verwijderen.');
DEFINE ('_UDDEIM_COULDNOTRECALL', 'Het bericht kon niet worden geannuleerd (waarschijnlijk omdat het reeds gelezen of verwijderd is.)');
DEFINE ('_UDDEIM_CANTRESTORE', 'Het terugzetten is mislukt. (Waarschijnlijk is het bericht zojuist automatisch gewist.)');
DEFINE ('_UDDEIM_COULDNOTRESTORE', 'Het terugzetten is mislukt.');
DEFINE ('_UDDEIM_DONTSEND', 'Verwijderen');
DEFINE ('_UDDEIM_SENDAGAIN', 'Opnieuw verzenden');
DEFINE ('_UDDEIM_NOTLOGGEDIN', 'Je bent niet ingelogd.');
DEFINE ('_UDDEIM_NOMESSAGES_INBOX', 'Je hebt geen berichten in je Inbox.');
	
DEFINE ('_UDDEIM_NOMESSAGES_OUTBOX', 'Je hebt geen berichten in je Uitbox.');
DEFINE ('_UDDEIM_NOMESSAGES_TRASHCAN', 'Je hebt geen berichten in de prullenbak.');
DEFINE ('_UDDEIM_INBOX', 'Inbox');
DEFINE ('_UDDEIM_OUTBOX', 'Uitbox');
DEFINE ('_UDDEIM_TRASHCAN', 'Prullenbak');
DEFINE ('_UDDEIM_CREATE', 'Nieuw bericht');
DEFINE ('_UDDEIM_UDDEIM', 'Privé berichten');
DEFINE ('_UDDEIM_READSTATUS', 'Lezen');
DEFINE ('_UDDEIM_FROM', 'Van');
DEFINE ('_UDDEIM_FROM_SMALL', 'van');
DEFINE ('_UDDEIM_TO', 'Aan');
DEFINE ('_UDDEIM_TO_SMALL', 'aan');
DEFINE ('_UDDEIM_OUTBOX_WARNING', 'Je Outbox bevat de berichten die je hebt verzonden en nog niet door de ander zijn verwijderd. Je kunt een bericht in je uitbox annuleren of bewerken indien de ontvanger het bericht nog niet gelezen heeft. ');
	// changed in 0.4

DEFINE ('_UDDEIM_RECALL', 'annuleren');
DEFINE ('_UDDEIM_RECALLTHISMESSAGE', 'Annuleer dit bericht');

DEFINE ('_UDDEIM_RESTORE', 'terug zetten');
DEFINE ('_UDDEIM_MESSAGE', 'Bericht');
DEFINE ('_UDDEIM_DATE', 'Datum');
DEFINE ('_UDDEIM_DELETED', 'Verwijderd');
DEFINE ('_UDDEIM_DELETE', 'Verwijder');
DEFINE ('_UDDEIM_ONLINEPIC', 'images/icon_online.gif');
DEFINE ('_UDDEIM_OFFLINEPIC', 'images/icon_offline.gif');
DEFINE ('_UDDEIM_DELETELINK', 'verwijder');
DEFINE ('_UDDEIM_MESSAGENOACCESS', 'Dit bericht kan niet worden weergegeven. <br />Mogelijke redenen:<ul><li>Je hebt geen rechten om dit bericht te lezen</li><li>Het bericht is verwijderd</li></ul>');
DEFINE ('_UDDEIM_YOUMOVEDTOTRASH', '<b>Je hebt dit bericht naar de prullenbak verplaatst.</b>');
DEFINE ('_UDDEIM_MESSAGEFROM', 'Bericht van ');

DEFINE ('_UDDEIM_MESSAGETO', 'Bericht van jezelf aan ');
DEFINE ('_UDDEIM_REPLY', 'Antwoorden');
DEFINE ('_UDDEIM_SUBMIT', 'Verstuur');
// DEFINE ('_UDDEIM_DELETEREPLIED', 'Verplaats na het antwoorden het originele bericht naar de prullenbak ');
	// translators info: _UDDEIM_DELETEREPLIED is obsolete in 0.4. You can delete it.
DEFINE ('_UDDEIM_NOID', 'Er is een fout opgetreden: Deze gebruiker bestaat niet. Het bericht is niet verzonden.');
DEFINE ('_UDDEIM_NOMESSAGE', 'Er is een fout opgetreden: Het bericht bevat geen tekst! Het bericht is niet verzonden.');
DEFINE ('_UDDEIM_MESSAGE_REPLIEDTO', 'Antwoord is verzonden');
DEFINE ('_UDDEIM_MESSAGE_SENT', 'Bericht is verzonden');
DEFINE ('_UDDEIM_MOVEDTOTRASH', ' en het originele bericht is naar de prullenbak verplaatst');
DEFINE ('_UDDEIM_NOSUCHUSER', 'Er is geen gebruiker met deze naam!');
DEFINE ('_UDDEIM_NOTTOYOURSELF', 'Het is niet mogelijk berichten aan jezelf te sturen!');
DEFINE ('_UDDEIM_VIOLATION', '<b>Toegangs overtreding!</b> Je hebt geen rechten om deze bewerking uit te voeren!');
DEFINE ('_UDDEIM_PRUNELINK', 'Alleen voor Admins: Snoeien');

// Admin

DEFINE ('_UDDEADM_SETTINGS', 'uddeIM Administratie');
DEFINE ('_UDDEADM_GENERAL', 'Algemeen');
DEFINE ('_UDDEADM_ABOUT', 'Over');
DEFINE ('_UDDEADM_DATESETTINGS', 'Datum/tijd');
DEFINE ('_UDDEADM_PICSETTINGS', 'Iconen');

DEFINE ('_UDDEADM_DELETEREADAFTER_HEAD', 'Gelezen berichten worden bewaard');
DEFINE ('_UDDEADM_DELETEUNREADAFTER_HEAD', 'Ongelezen berichten worden bewaard');
DEFINE ('_UDDEADM_DELETETRASHAFTER_HEAD', 'Verwijderde berichten worden bewaard');
DEFINE ('_UDDEADM_DAYS', 'dag(en)');
DEFINE ('_UDDEADM_DELETEREADAFTER_EXP', 'Vul het aantal dagen in eer <b>gelezen</b> berichten automatisch zullen worden verwijderd vanuit de inbox. Als je niet wilt dat berichten automatisch worden verwijderd kun je een hoog aantal dagen invullen, bijvoorbeeld 36524 dagen welk gelijk staat aan 100 jaar. Onthoud wel dat de database snel vol kan raken indien je alle berichten bewaard.');
DEFINE ('_UDDEADM_DELETEUNREADAFTER_EXP', 'Vul het aantal dagen in eer <b>ongelezen</b> berichten automatisch worden verwijderd.');
DEFINE ('_UDDEADM_DELETETRASHAFTER_EXP', 'Vul het aantal dagen in eer <b>verwijderde</b> berichten automatisch worden. Waardes kleiner dan 1 kunnen ook worden gebruikt. Je kunt bijvoorbeeld 0.125 gebruiken waardoor berichten na 3 uur verwijderd zullen worden.');
DEFINE ('_UDDEADM_DATEFORMAT_HEAD', 'Formaat van datum weergave');
DEFINE ('_UDDEADM_DATEFORMAT_EXP', 'Kies het formaat waarin de datum en tijd weergegeven moeten worden. Maanden zullen worden aangepast aan de lokale instellingen van je server.');
DEFINE ('_UDDEADM_LDATEFORMAT_HEAD', 'Lange datum weergave');
DEFINE ('_UDDEADM_LDATEFORMAT_EXP', 'Wanneer de berichten daar worden weergeven is er meer plaats voor de datum. Hier kun je dus aangeven hoe de lange datum  moet worden weergegeven.');

DEFINE ('_UDDEADM_ADMINIGNITIONONLY_HEAD', 'Automatisch verwijderen alleen voor admins');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_YES', 'Ja, enkel door admins');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_NO', 'Nee, door iedere gebruiker');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_EXP', 'Automatisch verwijderen is een erg zware belasting voor je server en database. Indien je kiest voor <i>Ja</i> worden de berichten automatisch verwijderd op het moment dat een admin zijn inbox of uitbox bekijkt. Meestal logt een admin meer dan eens per dag in (dit geldt zeker indien er meerdere admins zijn). Als je een kleine website hebt waar de admin niet vaak zijn inbox controleert raden wij je aan om <i>Nee</i> te kiezen. Indien je deze optie niet snapt raden wij ook aan om deze opties op <i>Nee</i> te zetten.');

	// above string changed in 0.4 
DEFINE ('_UDDEADM_SAVESETTINGS', 'Sla instellingen op');
DEFINE ('_UDDEADM_THISHASBEENSAVED', 'De volgende instellingen zijn opgeslagen in het configuratie bestand:');
DEFINE ('_UDDEADM_SETTINGSSAVED', 'Instellingen zijn opgeslagen.');
DEFINE ('_UDDEADM_ICONONLINEPIC_HEAD', 'Icon: Gebruiker is online');
DEFINE ('_UDDEADM_ICONONLINEPIC_EXP', 'Vul de locatie in van het icoon dat weergegeven moet worden naast de gebruikersnaam indien deze gebruiker online is.');
DEFINE ('_UDDEADM_ICONOFFLINEPIC_HEAD', 'Icon: Gebruiker is offline');
DEFINE ('_UDDEADM_ICONOFFLINEPIC_EXP', 'Vul de locatie in van het icoon dat weergegeven moet worden naast de gebruikersnaam indien deze gebruiker offline is.');
DEFINE ('_UDDEADM_ICONREADPIC_HEAD', 'Icon: Gelezen bericht');
DEFINE ('_UDDEADM_ICONREADPIC_EXP', 'Vul de locatie in van het icoon dat gelezen berichten weergeeft.');
DEFINE ('_UDDEADM_ICONUNREADPIC_HEAD', 'Icon: Ongelezen bericht');
DEFINE ('_UDDEADM_ICONUNREADPIC_EXP', 'Vul de locatie in van het icoon dat ongelezen berichten weergeeft.');
DEFINE ('_UDDEADM_MODULENEWMESS_HEAD', 'Module: Nieuwe berichten Icon');
DEFINE ('_UDDEADM_MODULENEWMESS_EXP', 'Deze instelling is voor de mod_uddeim_new module. Vul de locatie in van het icoon dat wordt weergegeven indien er nieuwe berichten zijn.');

// admin import tab

DEFINE ('_UDDEADM_UDDEINSTALL', 'uddeIM Installatie');
DEFINE ('_UDDEADM_FINISHED', 'Installatie is afgerond. Welkom bij uddeIM. ');
DEFINE ('_UDDEADM_NOCB', '<span style="color: red;">Je hebt Community Builder niet geinstalleerd. Om goed gebruik van uddeIM te maken raden wij je aan om Community Builder te installeren.');
DEFINE ('_UDDEADM_CONTINUE', 'Ga verder');
DEFINE ('_UDDEADM_PMSFOUND_1', 'Er zijn ');
DEFINE ('_UDDEADM_PMSFOUND_2', ' berichten uit je vorige PMS component. Wil je ze importeren in uddeIM?');

DEFINE ('_UDDEADM_IMPORT_EXP', 'Dit zal de berichten uit je vorige PMS component niet wijzigen. Zij zullen worden bewaard. Je kunt zonder gevaar de berichten importeren in uddeIM, zelfs als je uddeIM alleen uitprobeerd en later weer wil verwijderen omdat het tegenvalt. Let er wel op, je zult eerst de eventueel gemaakte wijzigingen moeten opslaan voordat je begint met importeren.');
	// _UDDEADM_IMPORT_EXP above changed in 0.4
	
DEFINE ('_UDDEADM_IMPORT_YES', 'Importeer oude PMS berichten nu naar uddeIM');
DEFINE ('_UDDEADM_IMPORT_NO', 'Nee, importeer geen PMS berichten');  
DEFINE ('_UDDEADM_IMPORTING', 'Wacht aub totdat alle berichten geimporteerd zijn.');
DEFINE ('_UDDEADM_IMPORTDONE', 'Klaar met het importeren van berichten uit oudere PMS systemen. Gebruik dit script maar één keer, indien je het nogmaals gebruikt kunnen de berichten dubbel in de database voorkomen.'); 
DEFINE ('_UDDEADM_IMPORT', 'Importeer');
DEFINE ('_UDDEADM_IMPORT_HEADER', 'Importeer berichten vanuit oude PMS systemen');
DEFINE ('_UDDEADM_PMSNOTFOUND', 'Geen andere PMS installatie gevonden. Importeren is niet mogelijk.');
DEFINE ('_UDDEADM_ALREADYIMPORTED', '<span style="color: red;">Je heeft al berichten geimporteerd uit het oude PMS systeem.</span>');

// new in 0.3 Frontend
DEFINE ('_UDDEIM_BLOCKS', 'Blokkeringen');

DEFINE ('_UDDEIM_YOUAREBLOCKED', 'Niet verzonden (de gebruiker heeft je geblokkeerd)');
DEFINE ('_UDDEIM_BLOCKNOW', 'blokkeer&nbsp;gebruiker');
DEFINE ('_UDDEIM_BLOCKS_EXP', 'Dit is een lijst van gebruikers die je hebt geblokkeerd. Deze gebruikers kunnen je geen berichten sturen.');
DEFINE ('_UDDEIM_NOBODYBLOCKED', 'Je hebt momenteel niemand geblokkeerd.');
DEFINE ('_UDDEIM_YOUBLOCKED_PRE', 'Je hebt momenteel ');
DEFINE ('_UDDEIM_YOUBLOCKED_POST', ' gebruiker(s) geblokkeerd.');
DEFINE ('_UDDEIM_UNBLOCKNOW', '[deblokkeren]');
DEFINE ('_UDDEIM_BLOCKALERT_EXP_ON', 'Als een geblokkeerde gebruiker een bericht aan je probeert te versturen, zal hij het bericht krijgen dat jij deze persoon hebt geblokkeerd en dat het bericht niet verzonden is en zal worden.');
DEFINE ('_UDDEIM_BLOCKALERT_EXP_OFF', 'Een geblokkeerde gebruiker kan niet zien dat hij door jou geblokkeerd is.');
DEFINE ('_UDDEIM_CANTBLOCKADMINS', 'Je kunt geen administrators blokkeren.');

// new in 0.3 Admin
DEFINE ('_UDDEADM_BLOCKSYSTEM_HEAD', 'Activeer blokkade systeem');
DEFINE ('_UDDEADM_BLOCKSYSTEM_EXP', 'Indien ingeschakeld, kunnen gebruikers andere gebruikers blokkeren. Een geblokkeerde gebruiker kan geen berichten sturen naar de gebruiker die hem heeft geblokkeerd. Admins kunnen niet worden geblokkeerd.');
DEFINE ('_UDDEADM_BLOCKSYSTEM_YES', 'ja');
DEFINE ('_UDDEADM_BLOCKSYSTEM_NO', 'nee');

DEFINE ('_UDDEADM_BLOCKALERT_HEAD', 'Geblokkeerde gebruiker krijgt bericht');
DEFINE ('_UDDEADM_BLOCKALERT_EXP', 'Ingesteld op <i>ja</i>, wordt de geblokkeerde gebruiker geinformeerd dat zijn bericht niet is verzonden vanwege het feit dat hij is geblokkeerd. Ingesteld op <i>nee</i>, wordt de geblokkeerde gebruiker niet geinformeerd over het feit dat hij geblokkeerd is.');
DEFINE ('_UDDEADM_BLOCKALERT_YES', 'ja');
DEFINE ('_UDDEADM_BLOCKALERT_NO', 'nee');
DEFINE ('_UDDEIM_BLOCKSDISABLED', 'Blokkeer systeem niet ingeschakeld');
// DEFINE ('_UDDEADM_DELETIONS', 'Messages'); 
	// translators info: comment out or delete line above to avoid double definition.
	// new definition right below.
DEFINE ('_UDDEADM_DELETIONS', 'Verwijderingen'); // changed in 0.4
DEFINE ('_UDDEADM_BLOCK', 'Blokkades');


// new in 0.4, admin
DEFINE ('_UDDEADM_INTEGRATION', 'Intergratie');
DEFINE ('_UDDEADM_EMAIL', 'E-mail');
DEFINE ('_UDDEADM_SHOWONLINE_HEAD', 'Geeft online status weer');
DEFINE ('_UDDEADM_SHOWONLINE_EXP', 'Indien ingesteld op <i>ja</i> zal het al of niet online zijn van een persoon worden weergegeven.');
DEFINE ('_UDDEADM_ALLOWEMAILNOTIFY_HEAD', 'Sta e-mail notificatie toe');
DEFINE ('_UDDEADM_ALLOWEMAILNOTIFY_EXP', 'Indien ingesteld op <i>ja</i>, kan iedere gebruiker kiezen of hij/zij e-mail wil hebben bij ieder nieuw bericht.');

DEFINE ('_UDDEADM_EMAILWITHMESSAGE_HEAD', 'E-mail bevat bericht');
DEFINE ('_UDDEADM_EMAILWITHMESSAGE_EXP', 'Indien ingesteld op <i>nee</i> zal deze e-mail alleen informatie weergeven over het feit dat er een bericht is maar niet de inhoud ervan.');
DEFINE ('_UDDEADM_LONGWAITINGEMAIL_HEAD', 'Vergeetmeniet e-mail');
DEFINE ('_UDDEADM_LONGWAITINGEMAIL_EXP', 'Deze instelling verstuurd onafhankelijk van de profielinstellingen een e-mail naar een gebruiker indien een ongelezen bericht al een geruime tijd in de inbox staat. Deze instelling werkt onafhankelijk van de e-mail notificaties. Indien je helemaal geen e-mails gestuurd wilt krijgen moet je dus beide functies uitschakelen.');
DEFINE ('_UDDEADM_LONGWAITINGDAYS_HEAD', 'Vergeetmeniet verzonden na ');
DEFINE ('_UDDEADM_LONGWAITINGDAYS_EXP', 'Indien de vergeetmeniet optie ingesteld staat is op <i>ja</i> vul dan hier in na hoeveel dagen het versturen moet gebeuren.');
DEFINE ('_UDDEADM_FIRSTWORDSINBOX_HEAD', 'Eerste tekens in lijsten');
DEFINE ('_UDDEADM_FIRSTWORDSINBOX_EXP', 'Hier kun je aangeven hoeveel tekens van een bericht worden weergegeven in de inbox, uitbox, prullenbak.');
DEFINE ('_UDDEADM_MAXLENGTH_HEAD', 'Maximale lengte van bericht');
DEFINE ('_UDDEADM_MAXLENGTH_EXP', 'Geef aan wat de maximale lengte van een bericht is. Het bericht zal na deze lengte worden stopgezet. Je kunt hem ook op \'0\' zetten waardoor er geen maximale lengte is.');
DEFINE ('_UDDEADM_YES', 'ja');
DEFINE ('_UDDEADM_NO', 'nee');
DEFINE ('_UDDEADM_ADMINSONLY', 'enkel voor admins');

DEFINE ('_UDDEADM_SYSTEM', 'Systeem');
DEFINE ('_UDDEADM_SYSM_USERNAME_HEAD', 'Systeem berichten gebruikersnaam');
DEFINE ('_UDDEADM_SYSM_USERNAME_EXP', 'uddeIM ondersteund systeem berichten. Er is bij systeem berichten geen gebruiker die ze verstuurd en er is dus ook geen mogelijkheid om te antwoorden op de berichten. Hier kun je een standaard waarde invullen voor de afzender van de systeem berichten');
DEFINE ('_UDDEADM_ALLOWTOALL_HEAD', 'Laat admins systeem berichten versturen');
DEFINE ('_UDDEADM_ALLOWTOALL_EXP', 'uddeIM ondersteund systeem berichten. Zij worden verstuurd aan iedere gebruiker van het systeem. Gebruik deze optie niet te vaak.');
DEFINE ('_UDDEADM_EMN_SENDERNAME_HEAD', 'Afzender E-mail');
DEFINE ('_UDDEADM_EMN_SENDERNAME_EXP', 'Vul de naam in waar vandaan de e-mail notificaties afkomstig zijn. Bijvoorbeeld de naam van je website');

DEFINE ('_UDDEADM_EMN_SENDERMAIL_HEAD', 'E-mail adres van afzender');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_EXP', 'Vul het e-mail adres in waar vandaan de e-mail notificaties afkomstig zijn. Bijvoorbeeld het e-mail adres gebruikt op je website');
DEFINE ('_UDDEADM_VERSION', 'uddeIM versie');
DEFINE ('_UDDEADM_ARCHIVE', 'Archief'); // translators info: headline for Archive system
DEFINE ('_UDDEADM_ALLOWARCHIVE_HEAD', 'Schakel archief in');
DEFINE ('_UDDEADM_ALLOWARCHIVE_EXP', 'Kies of gebruikers de mogelijkheid hebben om berichten te archieveren. Berichten in het archief worden niet verwijderd.');
DEFINE ('_UDDEADM_MAXARCHIVE_HEAD', 'Maximaal aantal berichten in het archief');
DEFINE ('_UDDEADM_MAXARCHIVE_EXP', 'Geef aan hoeveel berichten iedere gebruiker in zijn/haar archief mag hebben. Voor admins is er geen limiet.');
DEFINE ('_UDDEADM_COPYTOME_HEAD', 'Sta het versturen van kopieën naar jezelf toe');
DEFINE ('_UDDEADM_COPYTOME_EXP', 'Geef gebruikers de mogelijkheid om een kopie van hun eigen berichten te ontvangen. Deze kopieeen zullen aakomen in de inbox.');
DEFINE ('_UDDEADM_MESSAGES', 'Berichten');
DEFINE ('_UDDEADM_TRASHORIGINAL_HEAD', 'Adviseer om het orgineel te verwijderen');
DEFINE ('_UDDEADM_TRASHORIGINAL_EXP', 'Wanneer deze optie is geactiveerd, zal er een checkbox naast de \'Sturen\' knop worden geplaatst met de optie om het originele bericht te verwijderen. In dat geval wordt het bericht meteen verplaats naar de prullenbak. Deze optie zorgt ervoor dat er niet teveel berichten in de database komen. Gebruikers kunnen altijd deze optie uitvinken indien zij van mening zijn dat dit nodig is.');
	// translators info: 'Send' is the same as _UDDEIM_SUBMIT, 
	// and 'trash original' the same as _UDDEIM_TRASHORIGINAL

	
DEFINE ('_UDDEADM_PERPAGE_HEAD', 'Berichten per pagina');	
DEFINE ('_UDDEADM_PERPAGE_EXP', 'Geef hier aan hoeveel berichten er op elke pagina mogen staan.');
DEFINE ('_UDDEADM_CHARSET_HEAD', 'Gebruikte tekenset');
DEFINE ('_UDDEADM_CHARSET_EXP', 'Als je problemen hebt met niet-latijnse teken sets, kun je het tekenset invullen dat door uddeIM gebruikt moet worden om van database uitvoer naar HTML uitvoer te converteren. Als je niet weet waarover dit gaat moet je deze optie niet wijzigen!!!');
DEFINE ('_UDDEADM_MAILCHARSET_HEAD', 'Gebruikte e-mail tekenset');
DEFINE ('_UDDEADM_MAILCHARSET_EXP', 'Indien je problemen hebt met niet-latijnse tekensets, kun je het tekenset invullen dat door uddeIM gebruikt moet worden om e-mail berichten te converteren. Indien je niet weet waarover dit gaat moet je deze optie niet wijzigen!!!');
		// translators info: if you're translating into a language that uses a latin charset
		// (like English, Dutch, German, Swedish, Spanish, ... ) you might want to add a line
		// saying 'For usage in [mylanguage] the default value is correct.'

		
DEFINE ('_UDDEADM_EMN_BODY_NOMESSAGE_EXP', 'Dit is de inhoud van de e-mail die de gebruikers zullen ontvangen als ze de bovenstaande optie hebben aangevinkt. De inhoud van het bericht zal niet in de e-mail zijn. Houdt de variabelen %you%, %user% and %site% intact. ');		
DEFINE ('_UDDEADM_EMN_BODY_WITHMESSAGE_EXP', 'Dit is de inhoud van de e-mail die de gebruikers zullen ontvangen als ze de bovenstaande optie hebben aangevinkt. In deze e-mail is de inhoud van het bericht zichtbaar. Houdt de variabelen %you%, %user%, %pmessage% and %site% intact. ');		
DEFINE ('_UDDEADM_EMN_FORGETMENOT_EXP', 'Dit is de inhoud van het Vergeetmeniet e-mailtje dat de gebruikers zullen ontvangen indien de optie is aangevinkt. Houdt de variabelen %you% and %site% intact. ');		
DEFINE ('_UDDEADM_ENABLEDOWNLOAD_EXP', 'Sta gebruikers toe om berichten te downloaden door ze als e-mail naar zichzelf te sturen.');
DEFINE ('_UDDEADM_ENABLEDOWNLOAD_HEAD', 'Sta downloaden toe');	
DEFINE ('_UDDEADM_EXPORT_FORMAT_EXP', 'Dit is het formaat van de e-mail die de gebruikers zullen ontvangen als zij hun eigen berichten uit het archief downloaden. Houdt de variablen %user%, %msgdate% and %msgbody% intact. ');	
		// translators info: Don't translate %you%, %user%, etc. in the strings above. 

DEFINE ('_UDDEADM_INBOXLIMIT_HEAD', 'Stel inbox limiet in');		
DEFINE ('_UDDEADM_INBOXLIMIT_EXP', 'je kunt er voor kiezen om het aantal berichten in de inbox mee te laten tellen voor de berichtgenlimiet van het archief. In dat geval mag het totaal aantal berichten in de inbox en in het archief niet boven de hierboven gestelde limiet uitkomen. Het is ook mogelijk een limiet voor de inbox in te stellen zonder archief. In dat geval mogen gebruikers niet meer dan de hierboven gestelde limiet aan berichten in hun inbox hebben. Als dit aantal is bereikt kunnen ze niet langer berichten beantwoorden of nieuwe berichten scrijven totdat men de oude berichten uit hun inbox respectievelijk archief heeft verwijderd (gebruikers kunnen wel nog steeds berichten ontvangen en lezen.)');

DEFINE ('_UDDEADM_SHOWINBOXLIMIT_HEAD', 'Geeft het verbruik van de inbox weer');		
DEFINE ('_UDDEADM_SHOWINBOXLIMIT_EXP', 'Geeft in een regel onderaan in de inbox aan hoeveel berichten de gebruiker heeft(en hoeveel dat hij/zij er mag gebruiken) .');
		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INTRO', 'Je hebt het archief uitgeschakeld. Hoe wil je dat er wordt omgegaan met de berichten in het archief?');		


DEFINE ('_UDDEADM_ARCHIVETOTRASH_LEAVE_LINK', 'Laat ze in archief');  
DEFINE ('_UDDEADM_ARCHIVETOTRASH_LEAVE_EXP', 'Laat ze in het archief (gebruikers hebben geen mogelijkheid om de berichten te bekijken en de berichten zullen nog steeds meetellen voor de berichtenlimiet).');  
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_LINK', 'Verplaats berichten naar inbox');  
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_DONE', 'Gearchiveerde berichten zijn verplaatst naar de inbox');
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_EXP', 'Bericht zal worden verplaatst naar de inbox van de gebruiker (of naar de prullebak indien ze ouder zijn dan de ingestelde limiet voor de inbox).');		

		
// 0.4 frontend, admins only (no translation necessary)		
DEFINE ('_UDDEIM_VALIDFOR_1', 'geldig voor ');
DEFINE ('_UDDEIM_VALIDFOR_2', ' uren. 0=oneindig (wordt automatisch verwijderd)');
DEFINE ('_UDDEIM_WRITE_SYSM_GM', '[Maak systeem of algemeen bericht aan]');
DEFINE ('_UDDEIM_WRITE_NORMAL', '[Maak een normaal (standaard) bericht aan]');
DEFINE ('_UDDEIM_NOTALLOWED_SYSM_GM', 'Systeem en algemene berichten niet toegestaan.');
DEFINE ('_UDDEIM_SYSGM_TYPE', 'Soort bericht');
DEFINE ('_UDDEIM_HELPON_SYSGM', 'Hulp bij systeem berichten');
DEFINE ('_UDDEIM_HELPON_SYSGM_2', '(opent in nieuw scherm)');


DEFINE ('_UDDEIM_SYSGM_PLEASECONFIRM', 'Je staat op het punt het onderstaande bericht te verzenden. Kijk het na en bevestig of annuleer het bericht!');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALL', 'Bericht aan <strong>alle gebruikers</strong>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLADMINS', 'Bericht aan <strong>alle admins</strong>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLLOGGED', 'Bericht aan <strong>alle ingelogde gebruikers</strong>');
DEFINE ('_UDDEIM_SYSGM_WILLDISABLEREPLY', 'Ontvangers kunnen dit bericht niet beantwoorden.');
DEFINE ('_UDDEIM_SYSGM_WILLSENDAS_1', 'Bericht zal worden verstuurd met <strong>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDAS_2', '</strong> als gebruikersnaam');


DEFINE ('_UDDEIM_SYSGM_WILLEXPIRE', 'Bericht zal verlopen');
DEFINE ('_UDDEIM_SYSGM_WILLNOTEXPIRE', 'Bericht zal niet verlopen');
DEFINE ('_UDDEIM_SYSGM_CHECKLINK', '<b>Bekijk de link (door er op te klikken) voordat je verder gaat!</b>');
DEFINE ('_UDDEIM_SYSGM_SHORTHELP', 'Gebruik <strong>enkel in het berichtensysteem </strong>:<br />[b]<strong>vet</strong>[/b] [i]<em>schuin</em>[/i]<br />
[url=http://www.mijnwebsite.nl] Website adres [/url] of [url]http://www.mijnwebsite.nl[/url] zijn links.');
DEFINE ('_UDDEIM_SYSGM_ERRORNORECIPS', 'Waarschuwing: Geen ontvangers gevonden. Bericht zal niet worden verstuurd.');	

		
		
// 0.4 frontend (all users, translation needed)
DEFINE ('_UDDEIM_CANTREPLY', 'Je kunt niet antwoorden op dit bericht.');
DEFINE ('_UDDEIM_EMNOFF', 'E-mail notificatie staat uit. ');
DEFINE ('_UDDEIM_EMNON', 'E-mail notificatie staat aan. ');
DEFINE ('_UDDEIM_SETEMNON', '[aanzetten]');
DEFINE ('_UDDEIM_SETEMNOFF', '[uitzetten]');

DEFINE ('_UDDEIM_EMN_SUBJECT', 'Je hebt nieuwe berichten op %site%');
DEFINE ('_UDDEIM_SEND_ASSYSM', 'verstuur als systeem bericht (=ontvangers kunnen niet antwoorden)');
DEFINE ('_UDDEIM_SEND_TOALL', 'verstuur naar alle gebruikers');
DEFINE ('_UDDEIM_SEND_TOALLADMINS', 'verstuur naar alle admins');

DEFINE ('_UDDEIM_SEND_TOALLLOGGED', 'verstuur naar alle online gebruikers');



DEFINE ('_UDDEIM_UNEXPECTEDERROR_QUIT', 'Een fout is opgetreden: ');
DEFINE ('_UDDEIM_ARCHIVENOTENABLED', 'Archief is niet actief.');
DEFINE ('_UDDEIM_ARCHIVE_ERROR', 'Het verplaatsen naar het archief is mislukt.');
DEFINE ('_UDDEIM_ARC_SAVED_1', 'Je hebt in het archief ');
DEFINE ('_UDDEIM_ARC_SAVED_NONE', '<strong>Je hebt geen berichten in het archief.</strong>'); 
DEFINE ('_UDDEIM_ARC_SAVED_2', ' berichten');
DEFINE ('_UDDEIM_ARC_SAVED_ONE', 'Je hebt één bewaard ');
DEFINE ('_UDDEIM_ARC_SAVED_3', 'Om berichten te bewaren in het archief, moet je eerst andere berichten verwijderen.');
DEFINE ('_UDDEIM_ARC_CANSAVEMAX_1', 'Je kan maximaal ');
DEFINE ('_UDDEIM_ARC_CANSAVEMAX_2', ' berichten bewaren.');
DEFINE ('_UDDEIM_INBOX_LIMIT_1', 'Je hebt ');

DEFINE ('_UDDEIM_INBOX_LIMIT_2', ' berichten in jouw');
DEFINE ('_UDDEIM_ARC_UNIVERSE_ARC', 'archief');
DEFINE ('_UDDEIM_ARC_UNIVERSE_INBOX', 'inbox');
DEFINE ('_UDDEIM_ARC_UNIVERSE_BOTH', 'inbox en archief');
DEFINE ('_UDDEIM_INBOX_LIMIT_3', 'Het toegestane maximum is ');
DEFINE ('_UDDEIM_INBOX_LIMIT_4', 'Je kunt nog steeds berichten ontvangen en lezen, maar niet antwoorden of nieuwe berichten sturen zolang het aantal berichten in je inbox de toegestane limiet overschrijdt.');
DEFINE ('_UDDEIM_SHOWINBOXLIMIT_1', 'Aantal berichten in Inbox: ');
DEFINE ('_UDDEIM_SHOWINBOXLIMIT_2', '(van max. ');

DEFINE ('_UDDEIM_MESSAGE_ARCHIVED', 'Bericht in archief geplaatst.');
DEFINE ('_UDDEIM_STORE', 'archief');
		// translators info: as in: 'store this message in archive now'

DEFINE ('_UDDEIM_BACK', 'terug');

DEFINE ('_UDDEIM_TRASHCHECKED', 'verwijder geselecteerde');

	// translators info: plural!
	
DEFINE ('_UDDEIM_SHOWALL', 'laat alles zien');
	// translators example "SHOW ALL messages"
	
DEFINE ('_UDDEIM_ARCHIVE', 'Archief');
	// should be same as _UDDEADM_ARCHIVE
	
DEFINE ('_UDDEIM_ARCHIVEFULL', 'Archief is vol. Bericht is niet verplaatst.');	
	
DEFINE ('_UDDEIM_NOMSGSELECTED', 'Geen berichten geselecteerd.');
DEFINE ('_UDDEIM_THISISACOPY', 'Kopie van het bericht dat je hebt verzonden naar ');
DEFINE ('_UDDEIM_SENDCOPYTOME', 'kopieer naar mijzelf');
DEFINE ('_UDDEIM_SENDCOPYTOARCHIVE', 'kopieer naar archief');

DEFINE ('_UDDEIM_TRASHORIGINAL', 'verwijder origineel');

DEFINE ('_UDDEIM_MESSAGEDOWNLOAD', 'Berichten Download');
DEFINE ('_UDDEIM_EXPORT_MAILED', 'E-mail met gekozen berichten is verzonden');
DEFINE ('_UDDEIM_EXPORT_NOW', 'e-mail geselecteerde berichten aan mij');
DEFINE ('_UDDEIM_EXPORT_MAIL_INTRO', 'Het versturen van de e-mail is mislukt .');

DEFINE ('_UDDEIM_LIMITREACHED', 'Berichten limiet bereikt! Niet terug gezet.');

DEFINE ('_UDDEIM_WRITEMSGTO', 'Schrijf een nieuw bericht aan ');


// new in 0.5 ADMIN

DEFINE ('_UDDEADM_TEMPLATEDIR_HEAD', 'uddeIM Template');
DEFINE ('_UDDEADM_TEMPLATEDIR_EXP', 'Kies de template welke moet worden gebruikt door uddeIM');
DEFINE ('_UDDEADM_SHOWCONNEX_HEAD', 'Geef connecties weer');
DEFINE ('_UDDEADM_SHOWCONNEX_EXP', 'Gebruik <i>ja</i> indien je CB/CBE/JSgeinstalleerd hebt en je wilt dat gebruikers zijn/haar connecties kunnen zien op de pagina waar je moet zijn om een nieuw bericht te maken.');

DEFINE ('_UDDEADM_SHOWSETTINGSLINK_HEAD', 'Geef instellingen weer');
DEFINE ('_UDDEADM_SHOWSETTINGSLINK_EXP', 'De instellingen link wordt weergegeven wanneer je gebruikt maakt van e-mail notificaties, het blokkadesysteem of de popup notificaties. Hier kun je deze instellingen uitzetten indien nodig. ');
DEFINE ('_UDDEADM_SHOWSETTINGS_ATBOTTOM', 'Ja, onderaan de pagina');
DEFINE ('_UDDEADM_ALLOWBB_HEAD', 'Sta BB Codes toe');
DEFINE ('_UDDEADM_FONTFORMATONLY', 'Alleen lettertypen');
DEFINE ('_UDDEADM_ALLOWBB_EXP', 'Gebruik <i>enkel het formaat voor lettertypes</i> om gebruikers toe te staan vet, schuin, onderstreept, lettertypekleur en lettergrootte aan te geven. Indien je deze optie op <i>ja</i> zet hebben alle gebruikers toegang tot <strong>alle</strong> ondersteunende BB Codes in hun berichten (zelfs links en afbeeldingen).');
DEFINE ('_UDDEADM_ALLOWSMILE_HEAD', 'Sta emoticons toe');
DEFINE ('_UDDEADM_ALLOWSMILE_EXP', 'Indien ingesteld op <i>ja</i> worden emoticons zoals :-) vervangen door hun grafische variant.');

DEFINE ('_UDDEADM_DISPLAY', 'Weergave');
DEFINE ('_UDDEADM_SHOWMENUICONS_HEAD', 'Geef menu iconen weer');
DEFINE ('_UDDEADM_SHOWMENUICONS_EXP', 'Indien ingesteld op <i>ja</i> worden de menu en actie links weergegeven met inconen.');
DEFINE ('_UDDEADM_SHOWTITLE_HEAD', 'Component titel');
DEFINE ('_UDDEADM_SHOWTITLE_EXP', 'Vul de header in van de component. Deze header komt boven de component te staan. Indien je geen header wilt hoef je niets in te vullen.');
DEFINE ('_UDDEADM_SHOWABOUT_HEAD', 'Geef "About" link weer');
DEFINE ('_UDDEADM_SHOWABOUT_EXP', 'Ingesteld op <i>ja</i> zal de link verwijzen naar informatie over uddeIM zoals credits en de licentie. Deze link wordt  helemaal onderaan de pagina geplaatst.');
DEFINE ('_UDDEADM_STOPALLEMAIL_HEAD', 'Stop onmiddelijke alle e-mail verkeer');
DEFINE ('_UDDEADM_STOPALLEMAIL_EXP', 'Vink deze checkbox aan om ervoor te zorgen dat uddeIM meteen stopt met het versturen van alle e-mails. Onafhankelijk van de instellingen zoals ingesteld door de gebruikers. Dit is bijvoorbeeld handig bij het testen van nieuwe opties. Wil je dat er überhaupt nooit een e-mail wordt verzonden dan kun je het beste de opties hierboven allemaal uitzetten.');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_MANUALLY', 'Handmatig');

DEFINE ('_UDDEADM_GETPICLINK_HEAD', 'CB thumbnails in lijsten');
DEFINE ('_UDDEADM_GETPICLINK_EXP', 'Stel in op <i>ja</i> indien je wilt dat de CB thumbnails worden weergegeven in de berichten lijsten zoals inbox, outbox etc.');

// new in 0.5 FRONTEND

DEFINE ('_UDDEIM_SHOWUSERS', 'Gebruikerslijst');
DEFINE ('_UDDEIM_CONNECTIONS', 'Vriendenlijst');
DEFINE ('_UDDEIM_SETTINGS', 'Mijn Instellingen');
DEFINE ('_UDDEIM_NOSETTINGS', 'Er zijn geen instellingen.');
DEFINE ('_UDDEIM_ABOUT', 'over'); // as in "About uddeIM"
DEFINE ('_UDDEIM_COMPOSE', 'Nieuw'); // as in "write new message", but only one word
DEFINE ('_UDDEIM_EMN', 'E-Mail-Notificatie');
DEFINE ('_UDDEIM_EMN_EXP', 'Je kunt op verschillende manieren de notificaties per email ontvangen.');
DEFINE ('_UDDEIM_EMN_ALWAYS', 'E-mail-notificatie bij nieuwe berichten');

DEFINE ('_UDDEIM_EMN_NONE', 'Geen e-mail-notificaties');
DEFINE ('_UDDEIM_EMN_WHENOFFLINE', 'Wel E-mail-notificaties sturen maar niet als ik al online ben');
DEFINE ('_UDDEIM_EMN_NOTONREPLY', 'Geen notificaties sturen als ik antwoorden ontvang op mijn berichten.');
DEFINE ('_UDDEIM_BLOCKSYSTEM', 'Het blokkeren van vervelende gebruikers.'); // Headline for blocking system in settings
DEFINE ('_UDDEIM_BLOCKSYSTEM_EXP', 'Je kunt berichten van vervelende gebruikers blokkeren. Kies <i>Blokkeer gebruiker</i> indien je een bericht leest van de desbetreffende gebruiker.'); // block user is the same as _UDDEIM_BLOCKNOW
DEFINE ('_UDDEIM_SAVECHANGE', 'Opslaan');
DEFINE ('_UDDEIM_TOOLTIP_BOLD', 'BB Code tags om de tekst vet te maken : [b]bold[/b]');
DEFINE ('_UDDEIM_TOOLTIP_ITALIC', 'BB Code tags om de tekst cursief te maken. : [i]italic[/i]');
DEFINE ('_UDDEIM_TOOLTIP_UNDERLINE', 'BB Code tags om de tekst onderstreept te maken : [u]underline[/u]');
DEFINE ('_UDDEIM_TOOLTIP_COLORRED', 'BB Code tags om de letters te kleuren : [color=#XXXXXX]colored[/color] waar XXXXXX Is de hex van de kleur die je wilt, Als voorbeeld FF0000 voor groen.');
DEFINE ('_UDDEIM_TOOLTIP_COLORGREEN', 'BB Code tags om de letters te kleuren : [color=#XXXXXX]colored[/color] waar XXXXXX Is de hex van de kleur die je wilt, Als voorbeeld 00FF00 voor groen.');
DEFINE ('_UDDEIM_TOOLTIP_COLORBLUE', 'BB Code tags om de letters te kleuren : [color=#XXXXXX]colored[/color] waar XXXXXX Is de hex van de kleur die je wilt, Als voorbeeld 0000FF voor blue.');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE1', 'BB Code tags om de letters heel klein te maken : [size=1]very small text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE2', 'BB Code tags om de letters klein te maken : [size=2] small text.[/size]');

DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE4', 'BB Code tags om de letters groter te maken : [size=4]big text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE5', 'BB Code tags om de letters heel groot te maken : [size=5]very big text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_IMAGE', 'BB Code tags om een link naar een plaatje in te voegen : [img]Image-URL[/img]');
DEFINE ('_UDDEIM_TOOLTIP_URL', 'BB Code tags om een weblink in te voegen : [url]web address[/url]. Vergeet niet de http:// aan het begin van het adres toe te voegen.');
DEFINE ('_UDDEIM_TOOLTIP_CLOSEALLTAGS', 'Sluit alle BB tags automatisch af.');
DEFINE ('_UDDEIM_INBOX_LIMIT_2_SINGULAR', ' bericht in uw'); // same as _UDDEIM_INBOX_LIMIT_2, but singular (as in 1 "message in your")
DEFINE ('_UDDEIM_ARC_SAVED_NONE_2', '<strong>Je heeft geen berichten in je archief.</strong>'); 
// *******************************************************************

$udde_smon[1]="Jan";
$udde_smon[2]="Feb";
$udde_smon[3]="Maa";
$udde_smon[4]="Apr";
$udde_smon[5]="Mei";
$udde_smon[6]="Jun";
$udde_smon[7]="Jul";
$udde_smon[8]="Aug";
$udde_smon[9]="Sep";
$udde_smon[10]="Okt";
$udde_smon[11]="Nov";
$udde_smon[12]="Dec";

$udde_lmon[1]="Januari";
$udde_lmon[2]="Februari";
$udde_lmon[3]="Maart";
$udde_lmon[4]="April";
$udde_lmon[5]="Mei";
$udde_lmon[6]="Juni";
$udde_lmon[7]="Juli";
$udde_lmon[8]="Augustus";
$udde_lmon[9]="September";
$udde_lmon[10]="Oktober";
$udde_lmon[11]="November";
$udde_lmon[12]="December";

$udde_lweekday[0]="Zondag";
$udde_lweekday[1]="Maandag";
$udde_lweekday[2]="Dinsdag";
$udde_lweekday[3]="Woensdag";
$udde_lweekday[4]="Donderdag";
$udde_lweekday[5]="Vrijdag";
$udde_lweekday[6]="Zaterdag";

$udde_sweekday[0]="Zo";
$udde_sweekday[1]="Ma";
$udde_sweekday[2]="Di";
$udde_sweekday[3]="Wo";
$udde_sweekday[4]="Do";
$udde_sweekday[5]="Vr";
$udde_sweekday[6]="Za";

DEFINE ('_UDDEIM_EMN_BODY_PUBLICWITHMESSAGE',
"Hallo %you%,\n\n%user% heeft je het volgende nieuwe prive bericht gestuurd vanaf %site%.\n__________________\n%pmessage%");
DEFINE ('_UDDEIM_EMN_BODY_NOMESSAGE',
"Hallo %you%,\n\n%user% heeft je een prive bericht gestuurd vanaf %site%. Om het bericht te lezen, dien je in te loggen op\n\n%livesite%");
DEFINE ('_UDDEIM_EMN_BODY_WITHMESSAGE',
"Hallo %you%,\n\n%user% heeft je een prive bericht gestuurd vanaf %site%. Om het bericht te beantwoorden, dien je in te loggen \n\n%livesite%\n__________________\n%pmessage%");
DEFINE ('_UDDEIM_EMN_FORGETMENOT',
"Hallo %you%,\n\nje hebt nog een ongelezen bericht vanaf %site%. Om het bericht te lezen dien je in te loggen.\n\n%livesite%");
DEFINE ('_UDDEIM_EXPORT_FORMAT', '
================================================================================
%user% (%msgdate%)
----------------------------------------
%msgbody%
================================================================================');
