<?php
// *******************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2010 Stephan Slabihoud, © 2006 Benjamin Zweifel
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
// *******************************************************************
// Tên component: 	udde Instant Messages (uddeIM)
// Tác gi&#7843;: 		© 2007-2008 Stephan Slabihoud, © 2006 Benjamin Zweifel
// Mô t&#7843;: 			H&#7879; th&#7889;ng nh&#7855;n tin n&#7897;i b&#7897; cho Joomla 1.0, 1.5, Mambo 4.5 t&#432;&#417;ng thích v&#7899;i Community Builder, JomSocial, Kunena
// B&#7843;n quy&#7873;n:		&#272;ây là ph&#7847;n m&#7873;m t&#7921; do và b&#7841;n có th&#7875; phân ph&#7889;i l&#7841;i d&#432;&#7899;i b&#7843;n quy&#7873;n GPL ( http://www.gnu.org/licenses/gpl.txt )
//					B&#7841;n t&#7921; ch&#7883;u trách nhi&#7879;m v&#7873; vi&#7879;c s&#7917; d&#7909;ng ph&#7847;n m&#7873;m này và chúng tôi không có b&#7845;t kì &#273;&#7843;m b&#7843;o nào &#273;&#7889;i v&#7899;i vi&#7879;c b&#7841;n s&#7917; d&#7909;ng nó.
// Ngôn ng&#7919;(Language): Ti&#7871;ng Vi&#7879;t(Vietnamese)
// Ng&#432;&#7901;i d&#7883;ch(Translator): Bùi Quang Vinh<qvsoft@gmail.com>
// Chú ý(Notice): B&#7843;n d&#7883;ch ch&#7881; g&#7891;m các thành ph&#7847;n hi&#7875;n th&#7883; t&#7841;i FrontEnd(For Frontend Only)
// *******************************************************************
DEFINE ('_UDDEADM_TRANSLATORS_CREDITS', 'Translation by <a href="http://www.J4USolutions.com" target="_new">Bùi Quang Vinh</a>');	// Enter your credits line here, e.g. 'Translation by <a href="http://domain.com" target="_new">John Doe</a>'

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
DEFINE ('_UDDEADM_DONTSEFMSGLINK_HEAD', 'No SEF for %msglink%');
DEFINE ('_UDDEADM_DONTSEFMSGLINK_EXP', 'Do not use SEF for %msglink% placeholder in email notifications.');
DEFINE ('_UDDEADM_STIME_HEAD', 'Use special calendars');
DEFINE ('_UDDEADM_STIME_EXP', 'When enabled on sites using the farsi language file the persian calendar is used.');
DEFINE ('_UDDEADM_RESTRICTREM_HEAD', 'Remove orphaned connections');
DEFINE ('_UDDEADM_RESTRICTREM_EXP', 'Automatically remove orphaned connections when saving an existing contact list.');
DEFINE ('_UDDEADM_RESTRICTCON_HEAD', 'Show connections only');
DEFINE ('_UDDEADM_RESTRICTCON_EXP', 'The users shown in the list can be restricted to CB/CBE/JS connections (hide users from userlist has no effect here when enabled).');
DEFINE ('_UDDEADM_RESTRICTCON0', 'disabled');
DEFINE ('_UDDEADM_RESTRICTCON1', 'registered users');
DEFINE ('_UDDEADM_RESTRICTCON2', 'registered, special users');
DEFINE ('_UDDEADM_RESTRICTCON3', 'all users (incl. admins)');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_10', '...set default for show connections');

// New: 2.4
DEFINE ('_UDDEIM_SECURITYCODE', 'Security Code:');

// New: 2.3
DEFINE ('_UDDEADM_CC_HEAD', 'Button "Show CC: line"');
DEFINE ('_UDDEADM_CC_EXP', 'When enabled a user can choose if uddeIM shall add a CC: line containing all recipients to a message or not.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_9', '...set default for CC: line, and moderation');
DEFINE ('_UDDEIM_TOOLBAR_MCP', 'Message Center');
DEFINE ('_UDDEIM_TOOLBAR_REMOVEMESSAGE', 'Delete message');
DEFINE ('_UDDEIM_TOOLBAR_DELIVERMESSAGE', 'Deliver message');
DEFINE ('_UDDEADM_OOD_MCP', 'Message Center Plugin out of date!');
DEFINE ('_UDDEADM_MCP_STAT', 'Messages to moderate:');
DEFINE ('_UDDEADM_MCP_TRASHED', 'Trashed');
DEFINE ('_UDDEADM_MCP_NOTEDEL', 'Delete this message from database?');
DEFINE ('_UDDEADM_MCP_NOTEDELIVER', 'Deliver this message to recipient?');
DEFINE ('_UDDEADM_MCP_SHOWHIDE', 'Show/Hide');
DEFINE ('_UDDEADM_MCP_EDIT', 'Message Control Center');
DEFINE ('_UDDEADM_MCP_FROM', 'From');
DEFINE ('_UDDEADM_MCP_TO', 'To');
DEFINE ('_UDDEADM_MCP_TEXT', 'Message');
DEFINE ('_UDDEADM_MCP_DELETE', 'Delete');
DEFINE ('_UDDEADM_MCP_DATE', 'Date');
DEFINE ('_UDDEADM_MCP_DELIVER', 'Deliver');
DEFINE ('_UDDEADM_USERSET_MODERATE', 'Mod');
DEFINE ('_UDDEADM_USERSET_SELMODERATE', '- Mod -');
DEFINE ('_UDDEIM_MCP_MODERATED', 'Your messages will be moderated. A moderator will check them before they are delivered to the recipients.');
DEFINE ('_UDDEIM_STATUS_DELAYED', 'Waiting for moderator');
DEFINE ('_UDDEADM_MODNEWUSERS_HEAD', 'Moderate new users');
DEFINE ('_UDDEADM_MODNEWUSERS_EXP', 'When enabled messages from new registered users are moderated by default.');
DEFINE ('_UDDEADM_MODPUBUSERS_HEAD', 'Moderate public users');
DEFINE ('_UDDEADM_MODPUBUSERS_EXP', 'When enabled messages from public users users are moderated.');
DEFINE ('_UDDEIM_MENUICONS_P3', 'No menu');

// New: 2.2
DEFINE ('_UDDEADM_OOD_PF', 'Public Frontend Plugin out of date!');
DEFINE ('_UDDEADM_OOD_A', 'File Attachment Plugin out of date!');
DEFINE ('_UDDEADM_OOD_RSS', 'RSS Plugin out of date!');
DEFINE ('_UDDEADM_OOD_ASC', 'Message Report Center Plugin out of date!');
DEFINE ('_UDDEIM_NOMESSAGES3_FILTERED', '<b>B&#7841;n không có tin nh&#7855;n &#273;ã &#273;&#432;&#7907;c l&#7885;c trong %s.</b>');
DEFINE ('_UDDEIM_FILTER_UNREAD', 'ch&#432;a &#273;&#7885;c');
DEFINE ('_UDDEIM_FILTER_FLAGGED', '&#273;ánh d&#7845;u c&#7901;');
DEFINE ('_UDDEADM_GRAVATAR_HEAD', 'gravatar enabled');
DEFINE ('_UDDEADM_GRAVATAR_EXP', 'Enables gravatar support.');
DEFINE ('_UDDEADM_GRAVATARD_HEAD', 'gravatar imageset');
DEFINE ('_UDDEADM_GRAVATARD_EXP', 'Select the imageset for default images.');
DEFINE ('_UDDEADM_GRAVATARR_HEAD', 'gravatar rating');
DEFINE ('_UDDEADM_GRAVATARR_EXP', 'By default, only "G" rated images are displayed unless you indicate higher ratings. "X" displays all gravatar images.');
DEFINE ('_UDDEADM_GR404', '404');
DEFINE ('_UDDEADM_GRMM', 'mm');
DEFINE ('_UDDEADM_GRIDENTICON', 'identicon');
DEFINE ('_UDDEADM_GRMONSTERID', 'monsterid');
DEFINE ('_UDDEADM_GRWAVATAR', 'wavatar');
DEFINE ('_UDDEADM_GRRETRO', 'retro');
DEFINE ('_UDDEADM_GRDEFAULT', 'default');
DEFINE ('_UDDEADM_GRG', 'G = General');
DEFINE ('_UDDEADM_GRPG', 'PG = Parental Guidance');
DEFINE ('_UDDEADM_GRR', 'R = Restricted');
DEFINE ('_UDDEADM_GRX', 'X = Adult only');
DEFINE ('_UDDEADM_NINJABOARD', 'Ninjaboard');
DEFINE ('_UDDEADM_KUNENA16', 'Kunena 1.6+');
DEFINE ('_UDDEIM_PROCESSING', '&#272;ang x&#7917; lý...');
DEFINE ('_UDDEIM_SEND_NONOTIFY', 'Không g&#7917;i email thông báo');
DEFINE ('_UDDEIM_SYSGM_NONOTIFY', 'Email thông báo s&#7869; không &#273;&#432;&#7907;c g&#7917;i');
DEFINE ('_UDDEIM_SYSGM_FORCEEMBEDDED', 'N&#7897;i dung s&#7869; &#273;&#432;&#7907;c g&#7917;i kèm trong email thông báo');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_8', '...set default for thumbnails');
DEFINE ('_UDDEADM_AVATARWH_HEAD', 'Display size of thumbnails');
DEFINE ('_UDDEADM_AVATARWH_EXP', 'Width and height (in pixels) of thumbnails (0 = size will not be changed).');
DEFINE ('_UDDEIM_SAVE', 'L&#432;u');

// New: 2.1
DEFINE ('_UDDEIM_BODY_SPAMREPORT',
"Hi %you%,\n\n%touser% &#273;ã báo cáo tin nh&#7855;n spam t&#7915; %fromuser%. Vui lòng &#273;&#259;ng nh&#7853;p &#273;&#7875; ki&#7875;m tra!\n\n%livesite%");
DEFINE ('_UDDEIM_SUBJECT_SPAMREPORT', 'M&#7897;t tin nh&#7855;n &#273;ã b&#7883; báo cáo t&#7841;i %site%');
DEFINE ('_UDDEADM_KBYTES', 'KByte');
DEFINE ('_UDDEADM_MBYTES', 'MByte');
DEFINE ('_UDDEIM_ATT_FILEDELETED', '&#272;ã xóa file');
DEFINE ('_UDDEIM_ATT_FILENOTEXISTS', 'L&#7895;i: File không t&#7891;n t&#7841;i');
DEFINE ('_UDDEIM_ATTACHMENTS2', '&#272;ính kèm (T&#7889;i &#273;a. %s / file):');
DEFINE ('_UDDEADM_JOOCM', 'Joo!CM');
DEFINE ('_UDDEADM_UNPROTECTATTACHMENT_HEAD', 'Unprotected file downloads');
DEFINE ('_UDDEADM_UNPROTECTATTACHMENT_EXP', 'Usually uddeIM does not disclose the server path of file attachments, so nobody - even when the filename is known - can download the file. Enabling this option forces uddeIM to return the full server path. For security reasons, uddeIM added a MD5 hash to the original file name. Users can download the file directly when the full path is known. Do only use with care! READ THE FAQ WHEN USING THIS OPTION!');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_7', '...set default for file attachments, public frontend');
DEFINE ('_UDDEIM_FILETYPE_NOTALLOWED', '&#272;&#7883;nh d&#7841;ng file không &#273;&#432;&#7907;c phép');
DEFINE ('_UDDEADM_ALLOWEDEXTENSIONS_HEAD', 'Extensions allowed');
DEFINE ('_UDDEADM_ALLOWEDEXTENSIONS_EXP', 'Enter all extensions allowed (separated by ";"). Leave blank for no restrictions.');
DEFINE ('_UDDEADM_PUBEMAIL_HEAD', 'Email required');
DEFINE ('_UDDEADM_PUBEMAIL_EXP', 'When enabled a public user has to enter an email address.');
DEFINE ('_UDDEADM_WAITDAYS_HEAD', 'Days to wait');
DEFINE ('_UDDEADM_WAITDAYS_EXP', 'Specify how many days a user must wait until he is allowed to send messages (for 3 hours enter 0.125).');
DEFINE ('_UDDEIM_WAITDAYS1', 'B&#7841;n ph&#7843;i &#273;&#7907;i ');
DEFINE ('_UDDEIM_WAITDAYS2', ' ngày &#273;&#7875; có th&#7875; g&#7917;i tin nh&#7855;n.');
DEFINE ('_UDDEIM_WAITDAYS2H', ' gi&#7901; &#273;&#7875; có th&#7875; g&#7917;i tin nh&#7855;n.');

// New: 2.0
DEFINE ('_UDDEADM_RECAPTCHAPRV_HEAD', 'reCaptcha private key');
DEFINE ('_UDDEADM_RECAPTCHAPRV_EXP', 'When you want to use reCaptcha, enter your private key here.');
DEFINE ('_UDDEADM_RECAPTCHAPUB_HEAD', 'reCaptcha public key');
DEFINE ('_UDDEADM_RECAPTCHAPUB_EXP', 'When you want to use reCaptcha, enter your public key here.');
DEFINE ('_UDDEADM_CAPTCHA_INTERNAL', 'Internal');
DEFINE ('_UDDEADM_CAPTCHA_RECAPTCHA', 'reCaptcha');
DEFINE ('_UDDEADM_CAPTCHATYPE_HEAD', 'Captcha service');
DEFINE ('_UDDEADM_CAPTCHATYPE_EXP', 'Which captcha service do you want to use: The build-in service or reCaptcha (see <a href="http://recaptcha.net" target="_new">reCaptcha</a> for more information)?');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_6', '...set default for captcha service');
DEFINE ('_UDDEADM_AUP', 'AlphaUserPoints');
DEFINE ('_UDDEADM_CHECKFILESFOLDER', 'Please move <i>\uddeimfiles</i> to <i>\images\uddeimfiles</i>. Check the documentation!');
DEFINE ('_UDDEADM_CRYPT4', 'Strong encryption');
DEFINE ('_UDDEADM_ALLOWTOALL2_HEAD', 'Allow sending system messages');
DEFINE ('_UDDEADM_ALLOWTOALL2_EXP', 'uddeIM supports system messages. They are sent to all users on your system. Use them sparingly.');
DEFINE ('_UDDEADM_ALLOWTOALL2_0', 'disabled');
DEFINE ('_UDDEADM_ALLOWTOALL2_1', 'admins only');
DEFINE ('_UDDEADM_ALLOWTOALL2_2', 'admins and managers');

// New: 1.9
DEFINE ('_UDDEIM_FILEUPLOAD_FAILED', 'L&#7895;i upload file');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_5', '...set default for file attachments');
DEFINE ('_UDDEADM_ENABLEATTACHMENT_HEAD', 'Enable file attachments');
DEFINE ('_UDDEADM_ENABLEATTACHMENT_EXP', 'This enables sending file attachments for all registered users or admins only.');
DEFINE ('_UDDEADM_MAXSIZEATTACHMENT_HEAD', 'Max. file size');
DEFINE ('_UDDEADM_MAXSIZEATTACHMENT_EXP', 'Maximum file size allowed for file attachments.');
DEFINE ('_UDDEIM_FILESIZE_EXCEEDED', 'V&#432;&#7907;t quá s&#7889; l&#432;&#7907;ng file t&#7889;i &#273;a cho phép');
DEFINE ('_UDDEADM_BYTES', 'Bytes');
DEFINE ('_UDDEADM_MAXATTACHMENTS_HEAD', 'Max. attachments');
DEFINE ('_UDDEADM_MAXATTACHMENTS_EXP', 'Maximum number of attachments per message.');
DEFINE ('_UDDEIM_DOWNLOAD', 'T&#7843;i xu&#7889;ng');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_HEAD', 'File deletions invoked');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_YES', 'by admins only');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_NO', 'by any user');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_MANUALLY', 'manually');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_EXP', 'Automatic deletions create heavy server load. If you choose <b>by admins only</b> automatic deletions are invoked when an admin checks his inbox. Choose this option if an admin is checking the inbox regulary. Small or rarely administered sites may choose <b>by any user</b>.');
DEFINE ('_UDDEADM_FILEMAINTENANCE_PRUNE', 'Prune files now');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_HEAD', 'Invoke file erasing');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_EXP', 'Removes deleted files from the database. This is the same as \'Prune files now\' on the system tab.');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_ERASE', 'ERASE');
DEFINE ('_UDDEIM_ATTACHMENTS', '&#272;ính kèm (T&#7889;i &#273;a: %u bytes trên m&#7897;t file):');
DEFINE ('_UDDEADM_MAINTENANCE_F1', 'Orphaned attachments stored in filesystem: ');
DEFINE ('_UDDEADM_MAINTENANCE_F2', 'Deleting orphaned files');
DEFINE ('_UDDEADM_BACKUP_DONE', 'Backup configuration done.');
DEFINE ('_UDDEADM_RESTORE_DONE', 'Restore configuration done.');
DEFINE ('_UDDEADM_PRUNE_DONE', 'Message pruning done.');
DEFINE ('_UDDEADM_FILEPRUNE_DONE', 'File attachment pruning done.');
DEFINE ('_UDDEADM_FOLDERCREATE_ERROR', 'Error creating folder: ');
DEFINE ('_UDDEADM_ATTINSTALL_WRITEFAILED', 'Error creating file: ');
DEFINE ('_UDDEADM_ATTINSTALL_IGNORE', 'You can ignore this error when you do not own the File attachments premium plugin (see FAQ).');
DEFINE ('_UDDEADM_ATTACHMENTGROUPS_HEAD', 'Allowed groups');
DEFINE ('_UDDEADM_ATTACHMENTGROUPS_EXP', 'Groups which are allowed to send file attachments.');
DEFINE ('_UDDEIM_SELECT', 'Ch&#7885;n');
DEFINE ('_UDDEIM_ATTACHMENT', '&#272;ính kèm');
DEFINE ('_UDDEADM_SHOWLISTATTACHMENT_HEAD', 'Show attachment icons');
DEFINE ('_UDDEADM_SHOWLISTATTACHMENT_EXP', 'Show attachment icons in the message lists (inbox, outbox, archive).');
DEFINE ('_UDDEIM_HELP_ATTACHMENT', 'Tin nh&#7855;n bao g&#7891;m 1 file &#273;ính kèm.');
DEFINE ('_UDDEADM_MAINTENANCE_COUNTFILES', 'File references in database:');
DEFINE ('_UDDEADM_MAINTENANCE_COUNTFILESDISTINCT', 'File attachments stored:');
DEFINE ('_UDDEADM_SHOWMENUCOUNT_HEAD', 'Show counters');
DEFINE ('_UDDEADM_SHOWMENUCOUNT_EXP', 'When set to <b>yes</b>, the menu bar contains message counters. Note: This will require several additional database queries so do not use on weak systems.');
DEFINE ('_UDDEADM_CONFIG_FTPLAYER', 'Configuration (access with FTP layer):');
DEFINE ('_UDDEADM_ENCODEHEADER_HEAD', 'Encode mail headers');
DEFINE ('_UDDEADM_ENCODEHEADER_EXP', 'Set to <b>yes</b>, when mail headers (like the subject) should be rfc 2047 encoded. Useful when you have problems with special characters.');
DEFINE ('_UDDEIM_UP', 's&#7855;p x&#7871;p t&#259;ng d&#7847;n');
DEFINE ('_UDDEIM_DOWN', 's&#7855;p x&#7871;p gi&#7843;m d&#7847;n');
DEFINE ('_UDDEIM_UPDOWN', 'S&#7855;p x&#7871;p');
DEFINE ('_UDDEADM_ENABLESORT_HEAD', 'Enable sorting');
DEFINE ('_UDDEADM_ENABLESORT_EXP', 'Set to <b>yes</b>, when the user should be able to sort the inbox, outbox and archive (creates additional load on the database server).');

// New: 1.8
// %s will be replaced by _UDDEIM_NOMESSAGES_FILTERED_INBOX, _UDDEIM_NOMESSAGES_FILTERED_OUTBOX, _UDDEIM_NOMESSAGES_FILTERED_ARCHIVE
// Translators help: When having problems with the grammar, you can also move some text (e.g. "in your") to _UDDEIM_NOMESSAGES_FILTERED_* variables, e.g.
// instead of "_UDDEIM_NOMESSAGES_FILTERED_INBOX=inbox" you can also use "_UDDEIM_NOMESSAGES_FILTERED_INBOX=in your inbox"
DEFINE ('_UDDEIM_NOMESSAGES2_FR_FILTERED', '<b>B&#7841;n không có tin nh&#7855;n t&#7915; thành viên này trong%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_TO_FILTERED', '<b>B&#7841;n không có tin nh&#7855;n t&#7899;i thành viên này trong%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_UNFR_FILTERED', '<b>B&#7841;n không có tin nh&#7855;n ch&#432;a &#273;&#7885;c t&#7915; thành viên này trong%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_UNTO_FILTERED', '<b>B&#7841;n không có tin nh&#7855;n ch&#432;a &#273;&#7885;c t&#7899;i thành viên này trong%s.</b>');

// New: 1.7
DEFINE ('_UDDEADM_EMAILSTOPPED', '\'Email stop\' enabled.');
DEFINE ('_UDDEIM_ACCOUNTLOCKED', 'Truy c&#7853;p vào h&#7897;p tin nh&#7855;n c&#7911;a b&#7841;n &#273;ã b&#7883; khóa. Vui lòng liên h&#7879; admin &#273;&#7875; bi&#7871;t lí do.');
DEFINE ('_UDDEADM_USERSET_LOCKED', 'Locked');
DEFINE ('_UDDEADM_USERSET_SELLOCKED', '- Locked -');
DEFINE ('_UDDEADM_CBBANNED_HEAD', 'Check for CB banned users');
DEFINE ('_UDDEADM_CBBANNED_EXP', 'When activated uddeIM checks if a user has been banned in CB and does not allow access to uddeIM. Additionally other users are not able to send messages to a banned user.');
DEFINE ('_UDDEIM_YOUAREBANNED', 'Tài kho&#7843;n c&#7911;a b&#7841;n &#273;ã b&#7883; khóa. Vui lòng liên h&#7879; admin &#273;&#7875; bi&#7871;t lí do.');
DEFINE ('_UDDEIM_USERBANNED', '&#272;ã khóa tài kho&#7843;n thành viên.');
DEFINE ('_UDDEADM_JOOBB', 'Joo!BB');
DEFINE ('_UDDEPLUGIN_SEARCHSECTION', 'Tin nh&#7855;n riêng');
DEFINE ('_UDDEPLUGIN_MESSAGES', 'Tin nh&#7855;n riêng');
DEFINE ('_UDDEADM_MAINTENANCEDEL_HEAD', 'Invoke message erasing');
// note "This  is the same as _UDDEADM_MAINTENANCE_PRUNE on the system tab."
DEFINE ('_UDDEADM_MAINTENANCEDEL_EXP', 'Removes deleted messages from the database. This is the same as \'Prune messages now\' on the system tab.');
DEFINE ('_UDDEADM_MAINTENANCEDEL_ERASE', 'ERASE');
DEFINE ('_UDDEADM_REPORTSPAM_HEAD', 'Report message link');
DEFINE ('_UDDEADM_REPORTSPAM_EXP', 'When activated this show a \'Report message\' link that allows users to report SPAM to the admin.');
DEFINE ('_UDDEIM_TOOLBAR_REMOVESPAM', 'Xóa tin nh&#7855;n');
DEFINE ('_UDDEIM_TOOLBAR_REMOVEREPORT', 'H&#7911;y báo cáo');
DEFINE ('_UDDEIM_TOOLBAR_SPAMCONTROL', 'C&#7845;u hình báo cáo');
DEFINE ('_UDDEADM_INFORMATION', 'Information');
DEFINE ('_UDDEADM_SPAMCONTROL_STAT', 'Reported messages:');
DEFINE ('_UDDEADM_SPAMCONTROL_TRASHED', 'Trashed');
DEFINE ('_UDDEADM_SPAMCONTROL_NOTEDEL', 'Delete this message from database?');
DEFINE ('_UDDEADM_SPAMCONTROL_NOTEREMOVE', 'Remove this report?');
DEFINE ('_UDDEADM_SPAMCONTROL_SHOWHIDE', 'Show/Hide');
DEFINE ('_UDDEADM_SPAMCONTROL_EDIT', 'Report Control Center');
DEFINE ('_UDDEADM_SPAMCONTROL_FROM', 'From');
DEFINE ('_UDDEADM_SPAMCONTROL_TO', 'To');
DEFINE ('_UDDEADM_SPAMCONTROL_TEXT', 'Message');
DEFINE ('_UDDEADM_SPAMCONTROL_DELETE', 'Delete');
DEFINE ('_UDDEADM_SPAMCONTROL_REMOVE', 'Remove');
DEFINE ('_UDDEADM_SPAMCONTROL_DATE', 'Date');
DEFINE ('_UDDEADM_SPAMCONTROL_REPORTED', 'Reported');
DEFINE ('_UDDEIM_SPAMCONTROL_REPORT', 'Báo cáo spam');
DEFINE ('_UDDEIM_SPAMCONTROL_MARKED', '&#272;ã báo cáo');
DEFINE ('_UDDEIM_SPAMCONTROL_UNREPORT', 'H&#7911;y báo cáo');
DEFINE ('_UDDEADM_JOMSOCIAL', 'JomSocial');
DEFINE ('_UDDEADM_KUNENA', 'Kunena');
DEFINE ('_UDDEADM_ADMIN_FILTER', 'Filter');
DEFINE ('_UDDEADM_ADMIN_DISPLAY', 'Display #');
DEFINE ('_UDDEADM_TRASHORIGINALSENT_HEAD', 'Trash sent message');
DEFINE ('_UDDEADM_TRASHORIGINALSENT_EXP', 'When activated this will put a checkbox next to the \'Send\' button called \'trash message\' that is not checked by default. Users can check the box if they want to trash a message immediatly after sending it.');
DEFINE ('_UDDEIM_TRASHORIGINALSENT', 'xóa tin nh&#7855;n');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_4', '...set default for delete sent message, report spam, CB banned users');
DEFINE ('_UDDEADM_VERSIONCHECK_IMPORTANT', 'Important links:');
DEFINE ('_UDDEADM_VERSIONCHECK_HOTFIX', 'Hotfix');
DEFINE ('_UDDEADM_VERSIONCHECK_NONE', 'None');
DEFINE ('_UDDEADM_MAINTENANCEFIX_HEAD', "Compatibility maintenance");
DEFINE ('_UDDEADM_MAINTENANCEFIX_EXP', "uddeIM uses two XML files to ensure that packages can be installed on Joomla 1.0 and 1.5. On Joomla 1.5 one XML file is not required and this makes the extension manager to show an incompatibilty warning (which is wrong). This removes the unnecessary files, so the warning is not longer displayed.");
DEFINE ('_UDDEADM_MAINTENANCE_FIX', "FIX");
DEFINE ('_UDDEADM_MAINTENANCE_XML1', "Joomla 1.0 and Joomla 1.5 XML installers for uddeIM packages exists.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML2', "This is required due to install packages on Joomla 1.0 and Joomla 1.5.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML3', "Since it is not required after the installation has been finished, Joomla 1.0 installer can be removed on Joomla 1.5 systems.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML4', "This will be done for following packages:<br />");
DEFINE ('_UDDEADM_MAINTENANCE_FXML1', "Unnecessary XML installers for following uddeIM packages will be removed:<br />");
DEFINE ('_UDDEADM_MAINTENANCE_FXML2', "No unnecessary XML installers for uddeIM packages found!<br />");
DEFINE ('_UDDEADM_SHOWMENUICONS1_HEAD', 'Appearance of menu bar');
DEFINE ('_UDDEADM_SHOWMENUICONS1_EXP', 'Here you can configure if the menu bar should be displayed with icons and/or text.');
DEFINE ('_UDDEIM_MENUICONS_P1', 'Bi&#7875;u t&#432;&#7907;ng và ch&#7919;');
DEFINE ('_UDDEIM_MENUICONS_P2', 'Ch&#7881; có bi&#7875;u t&#432;&#7907;ng');
DEFINE ('_UDDEIM_MENUICONS_P0', 'Ch&#7881; có ch&#7919;');
DEFINE ('_UDDEIM_LISTSLIMIT_2', 'S&#7889; ng&#432;&#7901;i nh&#7853;n t&#7889;i &#273;a trong danh sách:');
DEFINE ('_UDDEADM_ADDEMAIL_ADMIN', 'Admins can select');
DEFINE ('_UDDEAIM_ADDEMAIL_SELECT', 'Thông báo kèm tin nh&#7855;n');
DEFINE ('_UDDEAIM_ADDEMAIL_TITLE', 'Bao g&#7891;m toàn b&#7897; tin nh&#7855;n trong email thông báo.');

// New: 1.6
DEFINE ('_UDDEIM_NOLISTSELECTED', 'Ch&#432;a ch&#7885;n danh sách liên l&#7841;c nào!');
DEFINE ('_UDDEADM_NOPREMIUM', 'Premium plugin not installed');
DEFINE ('_UDDEIM_LISTGLOBAL_CREATOR', 'Ng&#432;&#7901;i t&#7841;o:');
DEFINE ('_UDDEIM_LISTGLOBAL_ENTRIES', 'S&#7889; thành viên');
DEFINE ('_UDDEIM_LISTGLOBAL_TYPE', 'Ki&#7875;u');
DEFINE ('_UDDEIM_LISTGLOBAL_NORMAL', 'Thông th&#432;&#7901;ng');
DEFINE ('_UDDEIM_LISTGLOBAL_GLOBAL', 'Dùng chung');
DEFINE ('_UDDEIM_LISTGLOBAL_RESTRICTED', 'Riêng bi&#7879;t');
DEFINE ('_UDDEIM_LISTGLOBAL_P0', 'Nhóm thông th&#432;&#7901;ng');
DEFINE ('_UDDEIM_LISTGLOBAL_P1', 'Nhóm dùng chung');
DEFINE ('_UDDEIM_LISTGLOBAL_P2', 'Nhóm riêng bi&#7879;t (ch&#7881; các thành viên trong nhóm m&#7899;i có th&#7875; truy c&#7853;p)');
DEFINE ('_UDDEIM_TOOLBAR_USERSETTINGS', 'Thi&#7871;t l&#7853;p c&#7911;a thành viên');
DEFINE ('_UDDEIM_TOOLBAR_REMOVESETTINGS', 'Xóa thi&#7871;t l&#7853;p');
DEFINE ('_UDDEIM_TOOLBAR_CREATESETTINGS', 'T&#7841;o thi&#7871;t l&#7853;p');
DEFINE ('_UDDEIM_TOOLBAR_SAVE', 'L&#432;u');
DEFINE ('_UDDEIM_TOOLBAR_BACK', 'Quay l&#7841;i');
DEFINE ('_UDDEIM_TOOLBAR_TRASHMSGS', 'Xóa tin nh&#7855;n');
DEFINE ('_UDDEIM_CBPLUG_CONT', '[Ti&#7871;p t&#7909;c]');
DEFINE ('_UDDEIM_CBPLUG_UNBLOCKNOW', '[M&#7903; khóa]');
DEFINE ('_UDDEIM_CBPLUG_DOBLOCK', 'Khóa thành viên');
DEFINE ('_UDDEIM_CBPLUG_DOUNBLOCK', 'M&#7903; khóa thành viên');
DEFINE ('_UDDEIM_CBPLUG_BLOCKINGCFG', 'Khóa thành viên');
DEFINE ('_UDDEIM_CBPLUG_BLOCKED', 'B&#7841;n &#273;ã khóa thành viên này.');
DEFINE ('_UDDEIM_CBPLUG_UNBLOCKED', 'Thành viên này có th&#7875; liên l&#7841;c v&#7899;i b&#7841;n.');
DEFINE ('_UDDEIM_CBPLUG_NOWBLOCKED', 'Thành viên &#273;ã b&#7883; khóa.');
DEFINE ('_UDDEIM_CBPLUG_NOWUNBLOCKED', 'Thành viên &#273;ã &#273;&#432;&#7907;c m&#7903; khóa.');
DEFINE ('_UDDEADM_PARTIALIMPORTDONE', 'Partial import of messages from old PMS done. Do not import this part again because doing so will import the messages again and they will show up twice.');
DEFINE ('_UDDEADM_IMPORT_HELP', 'Note: The messages can be imported all at once or in parts. Importing in parts can be necessary when the import dies because of too many messages to import.');
DEFINE ('_UDDEADM_IMPORT_PARTIAL', 'Partial import:');
DEFINE ('_UDDEADM_UPDATEYOURDB', 'Important: You have not updated your database! Please refer to the README how to update uddeIM correctly!');
DEFINE ('_UDDEADM_RESTRALLUSERS_HEAD', 'Restrict "All users" access');
DEFINE ('_UDDEADM_RESTRALLUSERS_EXP', 'You can restrict the access to the "All users" list. Usually the "All users" list is available for all (<i>no restriction</i>).');
DEFINE ('_UDDEADM_RESTRALLUSERS_0', 'no restriction');
DEFINE ('_UDDEADM_RESTRALLUSERS_1', 'special users');
DEFINE ('_UDDEADM_RESTRALLUSERS_2', 'admins only');
DEFINE ('_UDDEIM_MESSAGE_UNARCHIVED', 'Message unarchived.');
DEFINE ('_UDDEADM_AUTOFORWARD_SPECIAL', 'special users');
DEFINE ('_UDDEIM_HELP', 'Tr&#7907; giúp');
DEFINE ('_UDDEIM_HELP_HEADLINE1', 'Tr&#7907; giúp tin nh&#7855;n');
DEFINE ('_UDDEIM_HELP_HEADLINE2', 'T&#7893;ng quan');
DEFINE ('_UDDEIM_HELP_INBOX', '<b>H&#7897;p th&#432; &#273;&#7871;n</b> Gi&#7919; t&#7845;t c&#7843; các tin nh&#7855;n g&#7917;i &#273;&#7871;n b&#7841;n.');
DEFINE ('_UDDEIM_HELP_OUTBOX', '<b>H&#7897;p th&#432; &#273;i</b> Gi&#7919; t&#7845;t c&#7843; các tin nh&#7855;n mà b&#7841;n &#273;ã g&#7917;i, nó cho phép b&#7841;n xem các tin nh&#7855;n mà b&#7841;n &#273;ã g&#7917;i.');
DEFINE ('_UDDEIM_HELP_TRASHCAN', '<b>Thùng rác</b> Gi&#7919; các tin nh&#7855;n &#273;ã b&#7883; xóa. Tin nh&#7855;n b&#7883; xóa s&#7869; l&#432;u tr&#7919; trong thùng rác trong m&#7897;t kho&#7843;ng th&#7901;i gian xác &#273;&#7883;nh. N&#7871;u tin nh&#7855;n ch&#432;a b&#7883; xóa v&#297;nh vi&#7877;n, b&#7841;n có th&#7875; khôi ph&#7909;c l&#7841;i nó.');
DEFINE ('_UDDEIM_HELP_ARCHIVE', '<b>L&#432;u tr&#7919;</b> Gi&#7919; t&#7845;t c&#7843; các tin nh&#7855;n l&#432;u tr&#7919; trong h&#7897;p th&#432; &#273;&#7871;n. B&#7841;n ch&#7881; có th&#7875; l&#432;u tr&#7919; tin nh&#7855;n t&#7915; h&#7897;p th&#432; &#273;&#7871;n. N&#7871;u b&#7841;n mu&#7889;n l&#432;u tr&#7919; tin nh&#7855;n c&#7911;a chính mình, hãy ch&#7885;n <i>G&#7917;i m&#7897;t b&#7843;n sao cho tôi</i> khi b&#7841;n g&#7917;i tin nh&#7855;n.');
DEFINE ('_UDDEIM_HELP_USERLISTS', '<b>Liên h&#7879;</b> cho phép b&#7841;n tào danh sách liên h&#7879;. V&#7899;i sanh sách liên h&#7879; b&#7841;n có th&#7875; g&#7917;i tin nh&#7855;n cho nhi&#7873;u thành viên. Thay vì vi&#7879;c nh&#7853;p tên nhi&#7873;u thành viên, b&#7841;n ch&#7881; c&#7847;n nh&#7853;p <i>#Tên_danh_sách</i>.');
DEFINE ('_UDDEIM_HELP_SETTINGS', '<b>Thi&#7871;t l&#7853;p</b> Bao g&#7891;m t&#7845;t c&#7843; các tùy ch&#7885;n c&#7911;a thành viên.');
DEFINE ('_UDDEIM_HELP_COMPOSE', '<b>So&#7841;n tin</b> cho phép b&#7841;n t&#7841;o tin nh&#7855;n m&#7899;i.');
DEFINE ('_UDDEIM_HELP_IREAD', 'Tin nh&#7855;n &#273;ã &#273;&#432;&#7907;c &#273;&#7885;c (B&#7841;n có th&#7875; thêm Tr&#7841;ng thái).');
DEFINE ('_UDDEIM_HELP_IUNREAD', 'Tin nh&#7855;n v&#7851;n ch&#432;a &#273;&#432;&#7907;c &#273;&#7885;c (B&#7841;n có th&#7875; thêm Tr&#7841;ng thái).');
DEFINE ('_UDDEIM_HELP_OREAD', 'Tin nh&#7855;n &#273;ã &#273;&#432;&#7907;c &#273;&#7885;c.');
DEFINE ('_UDDEIM_HELP_OUNREAD', 'Tin nh&#7855;n v&#7851;n ch&#432;a &#273;&#432;&#7907;c &#273;&#7885;c. B&#7841;n có th&#7875; l&#7845;y l&#7841;i các tin nh&#7855;n ch&#432;a &#273;&#432;&#7907;c &#273;&#7885;c.');
DEFINE ('_UDDEIM_HELP_TREAD', 'Tin nh&#7855;n &#273;ã &#273;&#432;&#7907;c &#273;&#7885;c.');
DEFINE ('_UDDEIM_HELP_TUNREAD', 'Tin nh&#7855;n v&#7851;n ch&#432;a &#273;&#432;&#7907;c &#273;&#7885;c.');
DEFINE ('_UDDEIM_HELP_FLAGGED', 'Tin nh&#7855;n &#273;ã &#273;&#432;&#7907;c g&#7855;n c&#7901;, e.g. Khi nó là tin nh&#7855;n quan tr&#7885;ng (B&#7841;n có th&#7875; thêm Tr&#7841;ng thái).');
DEFINE ('_UDDEIM_HELP_UNFLAGGED', 'Tin nh&#7855;n <i>thông th&#432;&#7901;ng</i> (B&#7841;n có th&#7875; thêm Tr&#7841;ng thái).');
DEFINE ('_UDDEIM_HELP_ONLINE', 'Thành viên này &#273;ang Online.');
DEFINE ('_UDDEIM_HELP_OFFLINE', 'Thành viên này &#273;ang Offline.');
DEFINE ('_UDDEIM_HELP_DELETE', 'Xóa tin nh&#7855;n (Chuy&#7875;n tin nh&#7855;n t&#7899;i thùng rác).');
DEFINE ('_UDDEIM_HELP_FORWARD', 'Chuy&#7875;n ti&#7871;p tin nh&#7855;n t&#7899;i thành viên khác.');
DEFINE ('_UDDEIM_HELP_ARCHIVEMSG', 'L&#432;u tr&#7919; tin nh&#7855;n. Tin nh&#7855;n l&#432;u tr&#7919; s&#7869; không b&#7883; xóa ngay c&#7843; khi ng&#432;&#7901;i qu&#7843;n tr&#7883; gi&#7899;i h&#7841;n th&#7901;i gian t&#7891;n t&#7841;i c&#7911;a tin nh&#7855;n trong h&#7897;p th&#432; &#273;&#7871;n.');
DEFINE ('_UDDEIM_HELP_UNARCHIVEMSG', 'Không l&#432;u tr&#7919; tin nh&#7855;n. Tin nh&#7855;n s&#7869; &#273;&#432;&#7907;c chuy&#7875;n tr&#7903; l&#7841;i h&#7897;p th&#432; &#273;&#7871;n.');
DEFINE ('_UDDEIM_HELP_RECALL', 'L&#7845;y l&#7841;i tin nh&#7855;n. B&#7841;n có th&#7875; l&#7845;y l&#7841;i tin nh&#7855;n khi ng&#432;&#7901;i nh&#7853;n ch&#432;a &#273;&#7885;c nó.');
DEFINE ('_UDDEIM_HELP_RECYCLE', 'Khôi ph&#7909;c tin nh&#7855;n (Chuy&#7875;n tin nh&#7855;n t&#7915; thùng rác vào h&#7897;p th&#432; &#273;&#7871;n ho&#7863;c h&#7897;p th&#432; &#273;i).');
DEFINE ('_UDDEIM_HELP_NOTIFY', 'C&#7845;u hình thông báo qua email khi có tin nh&#7855;n m&#7899;i.');
DEFINE ('_UDDEIM_HELP_AUTORESPONDER', 'T&#7921; &#273;&#7897;ng chuy&#7875;n ti&#7871;p cho phép m&#7895;i ng&#432;&#7901;i nh&#7853;n &#273;&#432;&#7907;c phép tr&#7843; l&#7901;i tr&#7921;c ti&#7871;p.');
DEFINE ('_UDDEIM_HELP_AUTOFORWARD', 'Tin nh&#7855;n m&#7899;i có th&#7875; t&#7921; &#273;&#7897;ng chuy&#7875;n ti&#7871;p t&#7899;i thành viên khác.');
DEFINE ('_UDDEIM_HELP_BLOCKING', 'B&#7841;n có th&#7875; khóa thành viên. Nh&#7919;ng thành viên này s&#7869; không th&#7875; g&#7917;i tin nh&#7855;n t&#7899;i b&#7841;n.');
DEFINE ('_UDDEIM_HELP_MISC', 'C&#7845;u hình thêm');
DEFINE ('_UDDEIM_HELP_FEED', 'B&#7841;n có th&#7875; truy nh&#7853;p vào h&#7897;p th&#432; &#273;&#7871;n qua RSS.');
DEFINE ('_UDDEADM_SEPARATOR_HEAD', 'Separator');
DEFINE ('_UDDEADM_SEPARATOR_EXP', 'Select the separator used for multiple recipients (default is ",").');
DEFINE ('_UDDEADM_SEPARATOR_P0', 'comma (default)');
DEFINE ('_UDDEADM_SEPARATOR_P1', 'semicolon');
DEFINE ('_UDDEADM_RSSLIMIT_HEAD', 'RSS items');
DEFINE ('_UDDEADM_RSSLIMIT_EXP', 'Limit the number of returned RSS items (0 for no limit).');
DEFINE ('_UDDEADM_SHOWHELP_HEAD', 'Show help button');
DEFINE ('_UDDEADM_SHOWHELP_EXP', 'When enabled a help button is displayed.');
DEFINE ('_UDDEADM_SHOWIGOOGLE_HEAD', 'Show iGoogle gadget button');
DEFINE ('_UDDEADM_SHOWIGOOGLE_EXP', 'When enabled an <i>Add to iGoogle</i> button for the uddeIM iGoogle gadget is displayed in the user preferences.');
DEFINE ('_UDDEADM_MOOTOOLS_NONE11', 'do not load MooTools (1.1 is used)');
DEFINE ('_UDDEADM_MOOTOOLS_NONE12', 'do not load MooTools (1.2 is used)');
DEFINE ('_UDDEIM_RSS_INTRO1', 'B&#7841;n có th&#7875; truy nh&#7853;p vào h&#7897;p th&#432; &#273;&#7871;n qua RSS (0.91).');
DEFINE ('_UDDEIM_RSS_INTRO1B', '&#272;&#7883;a ch&#7881; RSS:');
DEFINE ('_UDDEIM_RSS_INTRO2', '&#272;ây là &#273;&#7883;a ch&#7881; RSS riêng hi&#7875;n th&#7883; các tin nh&#7855;n ch&#432;a &#273;&#7885;c trong h&#7897;p th&#432; &#273;&#7871;n c&#7911;a b&#7841;n. Ch&#7881; có b&#7841;n m&#7899;i &#273;&#432;&#7907;c cung c&#7845;p &#273;&#7883;a ch&#7881; này. Không cung c&#7845;p &#273;&#7883;a ch&#7881; này cho ng&#432;&#7901;i khác n&#7871;u không h&#7885; có th&#7875; truy c&#7853;p vào và &#273;&#7885;c các tin nh&#7855;n c&#7911;a b&#7841;n.');
DEFINE ('_UDDEIM_RSS_FEED', 'RSS Tin nh&#7855;n');
DEFINE ('_UDDEIM_RSS_NOOBJECT', 'Không có thành ph&#7847;n l&#7895;i...');
DEFINE ('_UDDEIM_RSS_USERBLOCKED', 'Thành viên b&#7883; khóa...');
DEFINE ('_UDDEIM_RSS_NOTALLOWED', 'T&#7915; ch&#7889;i truy c&#7853;p...');
DEFINE ('_UDDEIM_RSS_WRONGPASSWORD', 'Sai tên &#273;&#259;ng nh&#7853;p ho&#7863;c m&#7853;t kh&#7849;u...');
DEFINE ('_UDDEIM_RSS_NOMESSAGES', 'Không có tin nh&#7855;n');
DEFINE ('_UDDEIM_RSS_NONEWMESSAGES', 'Không có tin nh&#7855;n m&#7899;i');
DEFINE ('_UDDEADM_ENABLERSS_HEAD', 'Enable RSS');
DEFINE ('_UDDEADM_ENABLERSS_EXP', 'When this option is enabled, messages can be received via RSS feed. Users will find the required URL in their profile.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_3', '...set default for RSS, iGoogle, help, separator');
DEFINE ('_UDDEADM_DELETEM_DELETING', 'Deleting messages:');
DEFINE ('_UDDEADM_DELETEM_FROMUSER', 'Deleting messages from user ');
DEFINE ('_UDDEADM_DELETEM_MSGSSENT', '- messages sent: ');
DEFINE ('_UDDEADM_DELETEM_MSGSRECV', '- messages received: ');
DEFINE ('_UDDEIM_PMNAV_THISISARESPONSE', '&#272;ây là tin nh&#7855;n tr&#7843; l&#7901;i cho:');
DEFINE ('_UDDEIM_PMNAV_THEREARERESPONSES', 'Tr&#7843; l&#7901;i cho:');
DEFINE ('_UDDEIM_PMNAV_DELETED', 'Tin nh&#7855;n không có hi&#7879;u l&#7921;c');
DEFINE ('_UDDEIM_PMNAV_EXISTS', 'Chuy&#7875;n t&#7899;i tin nh&#7855;n');
DEFINE ('_UDDEIM_PMNAV_COPY2ME', '(Copy)');
DEFINE ('_UDDEADM_PMNAV_HEAD', 'Allow navigation');
DEFINE ('_UDDEADM_PMNAV_EXP', 'Shows a navigation bar which allows navigating through a thread.');
DEFINE ('_UDDEADM_MAINTENANCE_ALLDAYS', 'Messages:');
DEFINE ('_UDDEADM_MAINTENANCE_7DAYS', 'Messages in 7 days:');
DEFINE ('_UDDEADM_MAINTENANCE_30DAYS', 'Messages in 30 days:');
DEFINE ('_UDDEADM_MAINTENANCE_365DAYS', 'Messages in 365 days:');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD1', 'Sending reminders to (Forgetmenot: %s days):');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD2', 'In %s days sending reminders to:');
DEFINE ('_UDDEADM_MAINTENANCE_NO', 'No:');
DEFINE ('_UDDEADM_MAINTENANCE_USERID', 'User ID:');
DEFINE ('_UDDEADM_MAINTENANCE_TONAME', 'Name:');
DEFINE ('_UDDEADM_MAINTENANCE_MID', 'Message ID:');
DEFINE ('_UDDEADM_MAINTENANCE_WRITTEN', 'Written:');
DEFINE ('_UDDEADM_MAINTENANCE_TIMER', 'Timer:');

// New: 1.5
DEFINE ('_UDDEMODULE_ALLDAYS', ' tin nh&#7855;n');
DEFINE ('_UDDEMODULE_7DAYS', ' tin nh&#7855;n 7 ngày tr&#432;&#7899;c &#273;ây');
DEFINE ('_UDDEMODULE_30DAYS', ' tin nh&#7855;n 30 ngày tr&#432;&#7899;c &#273;ây');
DEFINE ('_UDDEMODULE_365DAYS', ' tin nh&#7855;n 365 ngày tr&#432;&#7899;c &#273;ây');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_WARNING', '<br /><b>Note:<br />When using mosMail, you have to configure a valid email address!</b>');
DEFINE ('_UDDEIM_FILTEREDMESSAGE', 'tin nh&#7855;n &#273;ã &#273;&#432;&#7907;c l&#7885;c');
DEFINE ('_UDDEIM_FILTEREDMESSAGES', 'tin nh&#7855;n &#273;ã &#273;&#432;&#7907;c l&#7885;c');
DEFINE ('_UDDEIM_FILTER', 'B&#7897; l&#7885;c:');
DEFINE ('_UDDEIM_FILTER_TITLE_INBOX', 'Ch&#7881; hi&#7875;n th&#7883; t&#7915; nh&#7919;ng thành viên này');
DEFINE ('_UDDEIM_FILTER_TITLE_OUTBOX', 'Ch&#7881; hi&#7875;n th&#7883; t&#7899;i nh&#7919;ng thành viên này');
DEFINE ('_UDDEIM_FILTER_UNREAD_ONLY', 'Ch&#7881; các tin ch&#432;a &#273;&#7885;c');
DEFINE ('_UDDEIM_FILTER_SUBMIT', 'L&#7885;c tin nh&#7855;n');
DEFINE ('_UDDEIM_FILTER_ALL', '- T&#7845;t c&#7843; -');
DEFINE ('_UDDEIM_FILTER_PUBLIC', '- Thành viên khác -');
DEFINE ('_UDDEADM_FILTER_HEAD', 'Enable filtering');
DEFINE ('_UDDEADM_FILTER_EXP', 'If enabled users can filter their in/outbox to show only one recipient or sender.');
DEFINE ('_UDDEADM_FILTER_P0', 'disabled');
DEFINE ('_UDDEADM_FILTER_P1', 'above message list');
DEFINE ('_UDDEADM_FILTER_P2', 'below message list');
DEFINE ('_UDDEADM_FILTER_P3', 'above and below the list');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED', '<b>B&#7841;n có %s tin nh&#7855;n%s trong%s.</b>');	// see next also six lines
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_UNREAD', ' Ch&#432;a &#273;&#7885;c');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_FROM', ' t&#7915; thành viên này');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_TO', ' t&#7899;i thành viên này');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_INBOX', ' th&#432; &#273;&#7871;n');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_OUBOX', ' th&#432; &#273;i');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_ARCHIVE', ' l&#432;u tr&#7919;');
DEFINE ('_UDDEIM_TODP_TITLE', 'Ng&#432;&#7901;i nh&#7853;n');
DEFINE ('_UDDEIM_TODP_TITLE_CC', 'M&#7897;t ho&#7863;c nhi&#7873;u ng&#432;&#7901;i nh&#7853;n (Cách nhau b&#7903;i d&#7845;u ph&#7849;y)');
DEFINE ('_UDDEIM_ADDCCINFO_TITLE', 'When checked a line containing all recipients will be added to the message.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_2', '...set default for autoresponder, autoforwarding, inputbox, filter');
DEFINE ('_UDDEADM_AUTORESPONDER_HEAD', 'Enable Autoresponder');
DEFINE ('_UDDEADM_AUTORESPONDER_EXP', 'When the autoresponder is enabled the user can enable an autoresponder notification in the personal user settings.');
DEFINE ('_UDDEIM_EMN_AUTORESPONDER', 'B&#7853;t tr&#7843; l&#7901;i t&#7921; &#273;&#7897;ng');
DEFINE ('_UDDEIM_AUTORESPONDER', 'T&#7921; &#273;&#7897;ng tr&#7843; l&#7901;i');
DEFINE ('_UDDEIM_AUTORESPONDER_EXP', 'Ch&#7871; &#273;&#7897; t&#7921; &#273;&#7897;ng tr&#7843; l&#7901;i cho phép b&#7841;n tr&#7843; l&#7901;i các tin nh&#7855;n &#273;&#7871;n v&#7899;i n&#7897;i dung &#273;&#7883;nh tr&#432;&#7899;c.');
DEFINE ('_UDDEIM_AUTORESPONDER_DEFAULT', "Xin l&#7895;i, hi&#7879;n t&#7841;i mình không online.\nMình s&#7869; tr&#7843; l&#7901;i tin nh&#7855;n c&#7911;a b&#7841;n ngay khi mình online.");
DEFINE ('_UDDEADM_USERSET_AUTOR', 'AutoR');
DEFINE ('_UDDEADM_USERSET_SELAUTOR', '- AutoR -');
DEFINE ('_UDDEIM_USERBLOCKED', 'Thành viên b&#7883; khóa.');
DEFINE ('_UDDEADM_AUTOFORWARD_HEAD', 'Enable Autoforwarding');
DEFINE ('_UDDEADM_AUTOFORWARD_EXP', 'When the autoforwarding is enabled the user can forward new messages to another user automatically.');
DEFINE ('_UDDEIM_EMN_AUTOFORWARD', 'B&#7853;t t&#7921; &#273;&#7897;ng chuy&#7875;n ti&#7871;p');
DEFINE ('_UDDEADM_USERSET_AUTOF', 'AutoF');
DEFINE ('_UDDEADM_USERSET_SELAUTOF', '- AutoF -');
DEFINE ('_UDDEIM_AUTOFORWARD', 'T&#7921; &#273;&#7897;ng chuy&#7875;n ti&#7871;p');
DEFINE ('_UDDEIM_AUTOFORWARD_EXP', 'Tin nh&#7855;n g&#7917;i t&#7899;i b&#7841;n s&#7869; &#273;&#432;&#7907;c t&#7921; &#273;&#7897;ng chuy&#7875;n t&#7899;i thành viên &#273;&#432;&#7907;c ch&#7885;n.');
DEFINE ('_UDDEIM_THISISAFORWARD', 'Tin nh&#7855;n t&#7921; &#273;&#7897;ng chuy&#7875;n ti&#7871;p t&#7915; ');
DEFINE ('_UDDEADM_COLSROWS_HEAD', 'Message box (cols/rows)');
DEFINE ('_UDDEADM_COLSROWS_EXP', 'This specifies the columns and rows of the message box (default values are 60/10).');
DEFINE ('_UDDEADM_WIDTH_HEAD', 'Message box (width)');
DEFINE ('_UDDEADM_WIDTH_EXP', 'This specifies the width of the message box in px (default is 0). If this value is 0, the width specified in the CSS style is used.');
DEFINE ('_UDDEADM_CBE', 'CB Enhanced');

// New: 1.4
DEFINE ('_UDDEADM_IMPORT_CAPS', 'IMPORT');

// New: 1.3
DEFINE ('_UDDEADM_MOOTOOLS_HEAD', 'Load MooTools');
DEFINE ('_UDDEADM_MOOTOOLS_EXP', 'This specifies how uddeIM loads MooTools (MooTools is required for Autocompleter): <i>None</i> is useful when your template loads MooTools, <i>Auto</i> is the recommended default (same behavior as in uddeIM 1.2), when using J1.0 you can also force loading MooTools 1.1 or 1.2.');
DEFINE ('_UDDEADM_MOOTOOLS_NONE', 'do not load MooTools');
DEFINE ('_UDDEADM_MOOTOOLS_AUTO', 'auto');
DEFINE ('_UDDEADM_MOOTOOLS_1', 'force loading MooTools 1.1');
DEFINE ('_UDDEADM_MOOTOOLS_2', 'force loading MooTools 1.2');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_1', '...setting default for MooTools');
DEFINE ('_UDDEADM_AGORA', 'Agora');

// New: 1.2
DEFINE ('_UDDEADM_CRYPT3', 'Base64 encoded');
DEFINE ('_UDDEADM_TIMEZONE_HEAD', 'Adjust timezone');
DEFINE ('_UDDEADM_TIMEZONE_EXP', 'When uddeIM shows the wrong time you can adjust the timezone setting here. Usually, when everything is configured correctly, this should be zero. Nevertheless there might be cases you need to change this value.');
DEFINE ('_UDDEADM_HOURS', 'hours');
DEFINE ('_UDDEADM_VERSIONCHECK', 'Version information:');
DEFINE ('_UDDEADM_STATISTICS', 'Statistics:');
DEFINE ('_UDDEADM_STATISTICS_HEAD', 'Show statistics');
DEFINE ('_UDDEADM_STATISTICS_EXP', 'This displays some statistics like number of stored messages etc.');
DEFINE ('_UDDEADM_STATISTICS_CHECK', 'SHOW STATISTICS');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT', 'Messages stored in database: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_RECIPIENT', 'Messages trashed by recipient: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_SENDER', 'Messages trashed by sender: ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_TRASH', 'Messages on hold for purging: ');
DEFINE ('_UDDEADM_OVERWRITEITEMID_HEAD', 'Overwrite Itemid');
DEFINE ('_UDDEADM_OVERWRITEITEMID_EXP', 'Usually uddeIM tries to detect the correct Itemid when it is not set. In some cases it might be necessary to overwrite this value, e.g. when you use several menu links to uddeIM.');
DEFINE ('_UDDEADM_OVERWRITEITEMID_CURRENT', 'Detected Itemid is: ');
DEFINE ('_UDDEADM_USEITEMID_HEAD', 'Use Itemid');
DEFINE ('_UDDEADM_USEITEMID_EXP', 'Use this Itemid instead of the detected one.');
DEFINE ('_UDDEADM_SHOWLINK_HEAD', 'Use profile links');
DEFINE ('_UDDEADM_SHOWLINK_EXP', 'When set to <i>yes</i>, all usernames showing up in uddeIM will be displayed as links to the user profile.');
DEFINE ('_UDDEADM_SHOWPIC_HEAD', 'Show thumbnails');
DEFINE ('_UDDEADM_SHOWPIC_EXP', 'When set to <i>yes</i>, the thumbnail of the respective user will be displayed when reading a message.');
DEFINE ('_UDDEADM_THUMBLISTS_HEAD', 'Show thumbnails in lists');
DEFINE ('_UDDEADM_THUMBLISTS_EXP', 'Set to <i>yes</i> if you want to display thumbnails of users in the message lists overview (inbox, outbox, etc.)');
DEFINE ('_UDDEADM_FIREBOARD', 'Fireboard');
DEFINE ('_UDDEADM_CB', 'Community Builder');
DEFINE ('_UDDEADM_DISABLED', 'Disabled');
DEFINE ('_UDDEADM_ENABLED', 'Enabled');
DEFINE ('_UDDEIM_STATUS_FLAGGED', 'Quan tr&#7885;ng');
DEFINE ('_UDDEIM_STATUS_UNFLAGGED', '');
DEFINE ('_UDDEADM_ALLOWFLAGGED_HEAD', 'Allow message tagging');
DEFINE ('_UDDEADM_ALLOWFLAGGED_EXP', 'Allows message tagging (uddeIM shows a star in lists which can be highlighted to mark important messages).');
DEFINE ('_UDDEADM_REVIEWUPDATE', 'Important: When you have upgraded uddeIM from an earlier version please check the README. Sometimes you have to add or change database tables or fields!');
DEFINE ('_UDDEIM_ADDCCINFO', 'Thêm &#273;&#7891;ng g&#7917;i');
DEFINE ('_UDDEIM_CC', '&#272;&#7891;ng g&#7917;i:');
DEFINE ('_UDDEADM_TRUNCATE_HEAD', 'Truncate quoted text');
DEFINE ('_UDDEADM_TRUNCATE_EXP', 'Truncate quoted text to 2/3 of the maximum text length if it exceeds this limit.');
DEFINE ('_UDDEIM_PLUG_INBOXENTRIES', 'Th&#432; &#273;&#7871;n ');
DEFINE ('_UDDEIM_PLUG_LAST', 'Ti&#7871;p ');
DEFINE ('_UDDEIM_PLUG_ENTRIES', ' th&#432;');
DEFINE ('_UDDEIM_PLUG_STATUS', 'Tình tr&#7841;ng');
DEFINE ('_UDDEIM_PLUG_SENDER', 'Ng&#432;&#7901;i g&#7917;i');
DEFINE ('_UDDEIM_PLUG_MESSAGE', 'Tin nh&#7855;n');
DEFINE ('_UDDEIM_PLUG_EMPTYINBOX', 'Xóa h&#7871;t');

// New: 1.1
DEFINE ('_UDDEADM_NOTRASHACCESS_NOT', 'Access to trashcan not allowed.');
DEFINE ('_UDDEADM_NOTRASHACCESS_HEAD', 'Restrict trashcan access');
DEFINE ('_UDDEADM_NOTRASHACCESS_EXP', 'You can restrict the access to the trashcan. Usually the trashcan is available for all (<i>no restriction</i>). You can restrict the access to special users or to admins only, so groups with lower access rights cannot recycle a message.');
DEFINE ('_UDDEADM_NOTRASHACCESS_0', 'no restriction');
DEFINE ('_UDDEADM_NOTRASHACCESS_1', 'special users');
DEFINE ('_UDDEADM_NOTRASHACCESS_2', 'admins only');
DEFINE ('_UDDEADM_PUBHIDEUSERS_HEAD', 'Hide users from userlist');
DEFINE ('_UDDEADM_PUBHIDEUSERS_EXP', 'Enter user IDs which should be hidden from public userlist (e.g. 65,66,67).');
DEFINE ('_UDDEADM_HIDEUSERS_HEAD', 'Hide users from userlist');
DEFINE ('_UDDEADM_HIDEUSERS_EXP', 'Enter user IDs which should be hidden from userlist (e.g. 65,66,67). Admins will always see the complete list.');
DEFINE ('_UDDEIM_ERRORCSRF', 'CSRF attack recognized');
DEFINE ('_UDDEADM_CSRFPROTECTION_HEAD', 'CSRF protection');
DEFINE ('_UDDEADM_CSRFPROTECTION_EXP', 'This protects all forms against Cross-Site Request Forgery attacks. Usually this should be enabled. Only when you have strange problems switch it off.');
DEFINE ('_UDDEIM_CANTREPLYARCHIVE', 'B&#7841;n không th&#7875; tr&#7843; l&#7901;i tin nh&#7855;n l&#432;u tr&#7919;.');
DEFINE ('_UDDEIM_COULDNOTRECALLPUBLIC', 'Không th&#7875; khôi ph&#7909;c tin nh&#7855;n tr&#7843; l&#7901;i t&#7899;i thành viên ch&#432;a &#273;&#259;ng kí.');
DEFINE ('_UDDEADM_PUBREPLYS_HEAD', 'Allow replies');
DEFINE ('_UDDEADM_PUBREPLYS_EXP', 'Allow direct replies to messages from public users.');
DEFINE ('_UDDEIM_EMN_BODY_PUBLICWITHMESSAGE',
"Chào %user%,\n\n%you% &#273;ã g&#7917;i tin nh&#7855;n cho b&#7841;n t&#7841;i %site%.\n__________________\n%pmessage%");
DEFINE ('_UDDEADM_PUBNAMESTEXT', 'Show realnames');
DEFINE ('_UDDEADM_PUBNAMESDESC', 'Show realnames or usernames in public frontend?');
DEFINE ('_UDDEIM_USERLIST', 'Danh sách');
DEFINE ('_UDDEIM_YOUHAVETOWAIT', 'Xin l&#7895;i, b&#7841;n ph&#7843;i ch&#7901; tr&#432;&#7899;c khi có th&#7875; g&#7917;i tin nh&#7855;n ti&#7871;p theo');
DEFINE ('_UDDEADM_USERSET_LASTSENT', 'Last sent');
DEFINE ('_UDDEADM_TIMEDELAY_HEAD', 'Timedelay');
DEFINE ('_UDDEADM_TIMEDELAY_EXP', 'Time in seconds a user must wait before he can post the next message (0 for no time delay).');
DEFINE ('_UDDEADM_SECONDS', 'seconds');
DEFINE ('_UDDEIM_PUBLICSENT', '&#272;ã g&#7917;i tin nh&#7855;n.');
DEFINE ('_UDDEIM_ERRORINFROMNAME', 'Sai tên ng&#432;&#7901;i g&#7917;i');
DEFINE ('_UDDEIM_ERRORINEMAIL', 'Sai &#273;&#7883;a ch&#7881; email');
DEFINE ('_UDDEIM_YOURNAME', 'Tên b&#7841;n:');
DEFINE ('_UDDEIM_YOUREMAIL', 'Email:');
DEFINE ('_UDDEADM_VERSIONCHECK_USING', 'You are using uddeIM ');
DEFINE ('_UDDEADM_VERSIONCHECK_LATEST', 'You are already using the latest version of uddeIM.');
DEFINE ('_UDDEADM_VERSIONCHECK_CURRENT', 'The current version is ');
DEFINE ('_UDDEADM_VERSIONCHECK_INFO', 'Update information:');
DEFINE ('_UDDEADM_VERSIONCHECK_HEAD', 'Check for updates');
DEFINE ('_UDDEADM_VERSIONCHECK_EXP', 'This contacts uddeIM developer website to receive information about the current uddeIM version.');
DEFINE ('_UDDEADM_VERSIONCHECK_CHECK', 'CHECK NOW');
DEFINE ('_UDDEADM_VERSIONCHECK_ERROR', 'Unable to receive version information.');
DEFINE ('_UDDEIM_NOSUCHLIST', 'Không tìm th&#7845;y nhóm liên l&#7841;c!');
DEFINE ('_UDDEIM_LISTSLIMIT_1', 'V&#432;&#7907;t quá s&#7889; ng&#432;&#7901;i nh&#7853;n (T&#7889;i &#273;a: ');
DEFINE ('_UDDEADM_MAXONLISTS_HEAD', 'Max. number of entries');
DEFINE ('_UDDEADM_MAXONLISTS_EXP', 'Max. number of entries allowed per contact list.');
DEFINE ('_UDDEIM_LISTSNOTENABLED', 'Không cho phép s&#7917; d&#7909;ng nhóm liên l&#7841;c');
DEFINE ('_UDDEADM_ENABLELISTS_HEAD', 'Enable contact lists');
DEFINE ('_UDDEADM_ENABLELISTS_EXP', 'uddeIM allows users to create contact lists. These lists can be used to send messages to multiple users. Do not forget to enable multiple recipients when you want to use contact lists.');
DEFINE ('_UDDEADM_ENABLELISTS_0', 'disabled');
DEFINE ('_UDDEADM_ENABLELISTS_1', 'registered users');
DEFINE ('_UDDEADM_ENABLELISTS_2', 'special users');
DEFINE ('_UDDEADM_ENABLELISTS_3', 'admins only');
DEFINE ('_UDDEIM_LISTSNEW', 'T&#7841;o danh sách liên l&#7841;c m&#7899;i');
DEFINE ('_UDDEIM_LISTSSAVED', '&#272;ã l&#432;u nhóm liên l&#7841;c');
DEFINE ('_UDDEIM_LISTSUPDATED', '&#272;ã c&#7853;p nh&#7853;t nhóm liên l&#7841;c');
DEFINE ('_UDDEIM_LISTSDESC', 'Mô t&#7843;');
DEFINE ('_UDDEIM_LISTSNAME', 'Tên nhóm');
DEFINE ('_UDDEIM_LISTSNAMEWO', 'Tên nhóm(không d&#7845;u cách)');
DEFINE ('_UDDEIM_EDITLINK', 'S&#7917;a');
DEFINE ('_UDDEIM_LISTS', 'Liên l&#7841;c');
DEFINE ('_UDDEIM_STATUS_READ', '&#272;ã &#273;&#7885;c');
DEFINE ('_UDDEIM_STATUS_UNREAD', 'Ch&#432;a &#273;&#7885;c');
DEFINE ('_UDDEIM_STATUS_ONLINE', 'Online');
DEFINE ('_UDDEIM_STATUS_OFFLINE', 'Offline');
DEFINE ('_UDDEADM_CBGALLERY_HEAD', 'Show CB gallery pictures');
DEFINE ('_UDDEADM_CBGALLERY_EXP', 'By default uddeIM does only show avatars users have uploaded. When you enable this setting uddeIM does also display pictures from the CB avatars gallery.');
DEFINE ('_UDDEADM_UNBLOCKCB_HEAD', 'Unblock CB connections');
DEFINE ('_UDDEADM_UNBLOCKCB_EXP', 'You can allow messages to recipients when the registered user is on the recipients CB connection list (even when the recipient is in a group which is blocked). This setting is independent from the individual blocking each user can configure when enabled (see settings above).');
DEFINE ('_UDDEIM_GROUPBLOCKED', 'B&#7841;n không &#273;&#432;&#7907;c phép g&#7917;i tin nh&#7855;n t&#7899;i nhóm này.');
DEFINE ('_UDDEIM_ONEUSERBLOCKS', 'Ng&#432;&#7901;i nh&#7853;n &#273;ã khóa nick b&#7841;n.');
DEFINE ('_UDDEADM_BLOCKGROUPS_HEAD', 'Blocked groups (registered users)');
DEFINE ('_UDDEADM_BLOCKGROUPS_EXP', 'Groups to which registered users are not allowed to send messages to. This is for registered users only. Special users and admins are not affected by this setting. This setting is independent from the individual blocking each user can configure when enabled (see settings above).');
DEFINE ('_UDDEADM_PUBBLOCKGROUPS_HEAD', 'Blocked groups (public users)');
DEFINE ('_UDDEADM_PUBBLOCKGROUPS_EXP', 'Groups to which public users are not allowed to send messages to. This setting is independent from the individual blocking each user can configure when enabled (see settings above). When you block a group, users in this group cannot see the the option to enable the public frontend in their profile settings.');
DEFINE ('_UDDEADM_BLOCKGROUPS_1', 'Public user');
DEFINE ('_UDDEADM_BLOCKGROUPS_2', 'CB connection');
DEFINE ('_UDDEADM_BLOCKGROUPS_18', 'Registered user');
DEFINE ('_UDDEADM_BLOCKGROUPS_19', 'Author');
DEFINE ('_UDDEADM_BLOCKGROUPS_20', 'Editor');
DEFINE ('_UDDEADM_BLOCKGROUPS_21', 'Publisher');
DEFINE ('_UDDEADM_BLOCKGROUPS_23', 'Manager');
DEFINE ('_UDDEADM_BLOCKGROUPS_24', 'Admin');
DEFINE ('_UDDEADM_BLOCKGROUPS_25', 'SuperAdmin');
DEFINE ('_UDDEIM_NOPUBLICMSG', 'Ng&#432;&#7901;i dùng ch&#7881; ch&#7845;p nh&#7853;n tin nh&#7855;n t&#7915; các thành viên &#273;ã &#273;&#259;ng kí.');
DEFINE ('_UDDEADM_PUBHIDEALLUSERS_HEAD', 'Hide from public "All users" list');
DEFINE ('_UDDEADM_PUBHIDEALLUSERS_EXP', 'You can hide certain groups to be listed in the public "All users" list. Note: this hides the names only, the users can still receive messages. Users who have not enabled Public Frontend will never be listed in this list.');
DEFINE ('_UDDEADM_HIDEALLUSERS_HEAD', 'Hide from "All users" list');
DEFINE ('_UDDEADM_HIDEALLUSERS_EXP', 'You can hide certain groups to be listed in the "All users" list. Note: this hides the names only, the users can still receive messages.');
DEFINE ('_UDDEADM_HIDEALLUSERS_0', 'none');
DEFINE ('_UDDEADM_HIDEALLUSERS_1', 'superadmins only');
DEFINE ('_UDDEADM_HIDEALLUSERS_2', 'admins only');
DEFINE ('_UDDEADM_HIDEALLUSERS_3', 'special users');
DEFINE ('_UDDEADM_PUBLIC', 'Public');
DEFINE ('_UDDEADM_PUBMODESHOWALLUSERS_HEAD', 'Behavior of "All users" link');
DEFINE ('_UDDEADM_PUBMODESHOWALLUSERS_EXP', 'Choose if the "All users" link should be suppressed in Public Frontend, displayed or if always all users should be shown.');
DEFINE ('_UDDEADM_USERSET_PUBLIC', 'Public Frontend');
DEFINE ('_UDDEADM_USERSET_SELPUBLIC', '- select public -');
DEFINE ('_UDDEIM_OPTIONS_F', 'Cho phép khách g&#7917;i tin nh&#7855;n');
DEFINE ('_UDDEIM_MSGLIMITREACHED', 'V&#432;&#7907;t quá gi&#7899;i h&#7841;n tin nh&#7855;n!');
DEFINE ('_UDDEIM_PUBLICUSER', 'Khách');
DEFINE ('_UDDEIM_DELETEDUSER', '&#272;ã xóa thành viên');
DEFINE ('_UDDEADM_CAPTCHALEN_HEAD', 'Captcha length');
DEFINE ('_UDDEADM_CAPTCHALEN_EXP', 'Specifies how many characters a user must enter.');
DEFINE ('_UDDEADM_USECAPTCHA_HEAD', 'Captcha spam protection');
DEFINE ('_UDDEADM_USECAPTCHA_EXP', 'Specify who has to enter a captcha when sending a message');
DEFINE ('_UDDEADM_CAPTCHAF0', 'disabled');
DEFINE ('_UDDEADM_CAPTCHAF1', 'public users only');
DEFINE ('_UDDEADM_CAPTCHAF2', 'public and registered users');
DEFINE ('_UDDEADM_CAPTCHAF3', 'public, registered, special users');
DEFINE ('_UDDEADM_CAPTCHAF4', 'all users (incl. admins)');
DEFINE ('_UDDEADM_PUBFRONTEND_HEAD', 'Enable public frontend');
DEFINE ('_UDDEADM_PUBFRONTEND_EXP', 'When enabled public users can send messages to your registered users (those can specify in their personal settings if they want to use this feature).');
DEFINE ('_UDDEADM_PUBFRONTENDDEF_HEAD', 'Public frontend default');
DEFINE ('_UDDEADM_PUBFRONTENDDEF_EXP', 'This is the default value if a public user is allowed to send a message to a registered user.');
DEFINE ('_UDDEADM_PUBDEF0', 'disabled');
DEFINE ('_UDDEADM_PUBDEF1', 'enabled');
DEFINE ('_UDDEIM_WRONGCAPTCHA', 'Sai mã b&#7843;o v&#7879;');

// New: 1.0
DEFINE ('_UDDEADM_NONEORUNKNOWN', 'none or unknown');
DEFINE ('_UDDEADM_DONATE', 'If you like uddeIM and want to support the development please make a small donation.');
// New: 1.0rc2
DEFINE ('_UDDEADM_BACKUPRESTORE_DATE', 'Configuration found in database: ');
DEFINE ('_UDDEADM_BACKUPRESTORE_HEAD', 'Backup and restore configuration');
DEFINE ('_UDDEADM_BACKUPRESTORE_EXP', 'You can backup your configuration to the database and restore it when necessary. This is useful when you update uddeIM or when you want to save a certain configuration because of testing.');
DEFINE ('_UDDEADM_BACKUPRESTORE_BACKUP', 'BACKUP');
DEFINE ('_UDDEADM_BACKUPRESTORE_RESTORE', 'RESTORE');
DEFINE ('_UDDEADM_CANCEL', 'Cancel');
// New: 1.0rc1
DEFINE ('_UDDEADM_LANGUAGECHARSET_HEAD', 'Language file character set');
DEFINE ('_UDDEADM_LANGUAGECHARSET_EXP', 'Usually <b>default</b> (ISO-8859-1) is the correct setting for Joomla 1.0 and <b>UTF-8</b> for Joomla 1.5.');
DEFINE ('_UDDEADM_LANGUAGECHARSET_UTF8', 'UTF-8');
DEFINE ('_UDDEADM_LANGUAGECHARSET_DEFAULT', 'default');
DEFINE ('_UDDEIM_READ_INFO_1', 'Tin nh&#7855;n &#273;ã &#273;&#7885;c s&#7869; &#7903; trong h&#7897;p th&#432; &#273;&#7871;n trong vòng t&#7889;i &#273;a ');
DEFINE ('_UDDEIM_READ_INFO_2', ' ngày tr&#432;&#7899;c khi t&#7921; &#273;&#7897;ng b&#7883; xóa.');
DEFINE ('_UDDEIM_UNREAD_INFO_1', 'Tin nh&#7855;n ch&#432;a &#273;&#7885;c s&#7869; &#7903; trong h&#7897;p th&#432; &#273;&#7871;n trong vòng t&#7889;i &#273;a ');
DEFINE ('_UDDEIM_UNREAD_INFO_2', ' ngày tr&#432;&#7899;c khi t&#7921; &#273;&#7897;ng b&#7883; xóa.');
DEFINE ('_UDDEIM_SENT_INFO_1', 'Tin nh&#7855;n g&#7917;i &#273;i s&#7869; &#7903; trong h&#7897;p th&#432; &#273;i trong vòng t&#7889;i &#273;a ');
DEFINE ('_UDDEIM_SENT_INFO_2', ' ngày tr&#432;&#7899;c khi t&#7921; &#273;&#7897;ng b&#7883; xóa.');
DEFINE ('_UDDEADM_DELETEREADAFTERNOTE_HEAD', 'Show inbox note for read messages');
DEFINE ('_UDDEADM_DELETEREADAFTERNOTE_EXP', 'Show inbox note <i>"Read messages will be deleted after n days"</i>');
DEFINE ('_UDDEADM_DELETEUNREADAFTERNOTE_HEAD', 'Show inbox note for unread messages');
DEFINE ('_UDDEADM_DELETEUNREADAFTERNOTE_EXP', 'Show inbox note <i>"Unread messages will be deleted after n days"</i>');
DEFINE ('_UDDEADM_DELETESENTAFTERNOTE_HEAD', 'Show outbox note for sent messages');
DEFINE ('_UDDEADM_DELETESENTAFTERNOTE_EXP', 'Show outbox note <i>"Sent messages will be deleted after n days"</i>');
DEFINE ('_UDDEADM_DELETETRASHAFTERNOTE_HEAD', 'Show trashcan note for trashed messages');
DEFINE ('_UDDEADM_DELETETRASHAFTERNOTE_EXP', 'Show trashcan note <i>"Trashed messages will be purged after n days"</i>');
DEFINE ('_UDDEADM_DELETESENTAFTER_HEAD', 'Sent messages kept for (days)');
DEFINE ('_UDDEADM_DELETESENTAFTER_EXP', 'Enter the number of days until <b>sent</b> messages will automatically be erased from the outbox.');
DEFINE ('_UDDEIM_SEND_TOALLSPECIAL', 'G&#7917;i t&#7899;i nhóm thành viên &#273;&#7863;c bi&#7879;t');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLSPECIAL', 'Tin nh&#7855;n t&#7899;i <b>t&#7845;t c&#7843; các thành viên &#273;&#7863;c bi&#7879;t</b>');
DEFINE ('_UDDEADM_USERSET_SELUSERNAME', '- select username -');
DEFINE ('_UDDEADM_USERSET_SELNAME', '- select name -');
DEFINE ('_UDDEADM_USERSET_EDITSETTINGS', 'Edit user settings');
DEFINE ('_UDDEADM_USERSET_EXISTING', 'existing');
DEFINE ('_UDDEADM_USERSET_NONEXISTING', 'non existing');
DEFINE ('_UDDEADM_USERSET_SELENTRY', '- select entry -');
DEFINE ('_UDDEADM_USERSET_SELNOTIFICATION', '- select notification -');
DEFINE ('_UDDEADM_USERSET_SELPOPUP', '- select popup -');
DEFINE ('_UDDEADM_USERSET_USERNAME', 'Username');
DEFINE ('_UDDEADM_USERSET_NAME', 'Name');
DEFINE ('_UDDEADM_USERSET_NOTIFICATION', 'Notification');
DEFINE ('_UDDEADM_USERSET_POPUP', 'Popup');
DEFINE ('_UDDEADM_USERSET_LASTACCESS', 'Last access');
DEFINE ('_UDDEADM_USERSET_NO', 'No');
DEFINE ('_UDDEADM_USERSET_YES', 'Yes');
DEFINE ('_UDDEADM_USERSET_UNKNOWN', 'unknown');
DEFINE ('_UDDEADM_USERSET_WHENOFFLINEEXCEPT', 'When offline (except replies)');
DEFINE ('_UDDEADM_USERSET_ALWAYSEXCEPT', 'Always (except replies)');
DEFINE ('_UDDEADM_USERSET_WHENOFFLINE', 'When offline');
DEFINE ('_UDDEADM_USERSET_ALWAYS', 'Always');
DEFINE ('_UDDEADM_USERSET_NONOTIFICATION', 'No notification');
DEFINE ('_UDDEADM_WELCOMEMSG', "Welcome to uddeIM!\n\nYou have succesfully installed uddeIM.\n\nTry viewing this message with different templates. You can set them in the administration backend of uddeIM.\n\nuddeIM is a project in development. If you find bugs or weaknesses, please write them to me so that we can make uddeIM better together.\n\nGood luck and have fun!");
DEFINE ('_UDDEADM_UDDEINSTCOMPLETE', 'uddeIM installation complete.');
DEFINE ('_UDDEADM_REVIEWSETTINGS', 'Please continue to the administration backend and review the settings.');
DEFINE ('_UDDEADM_REVIEWLANG', 'If you are running the CMS in a character set other than ISO 8859-1 make sure to adjust the settings accordingly.');
DEFINE ('_UDDEADM_REVIEWEMAILSTOP', 'After installation, all uddeIM e-mail traffic (e-mail notifications, fotgetmenot e-mails) is disabled so that no e-mails are sent as long as you are testing. Do not forget to disable "stop e-mail" in the backend when you are finished.');
DEFINE ('_UDDEADM_MAXRECIPIENTS_HEAD', 'Max. recipients');
DEFINE ('_UDDEADM_MAXRECIPIENTS_EXP', 'Max. number of recipients which are allowed per message (0=no limitation)');
DEFINE ('_UDDEIM_TOOMANYRECIPIENTS', 'Quá nhi&#7873;u ng&#432;&#7901;i nh&#7853;n');
DEFINE ('_UDDEIM_STOPPEDEMAIL', 'Không th&#7875; g&#7917;i email.');
DEFINE ('_UDDEADM_SEARCHINSTRING_HEAD', 'Inside text searching');
DEFINE ('_UDDEADM_SEARCHINSTRING_EXP', 'Autocompleter searches inside the text (otherwise it searches from the beginning only)');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_HEAD', 'Behavior of "All users" link');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_EXP', 'Choose if the "All users" link should be suppressed, displayed or if always all users should be shown.');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_0', 'Suppress "All Users" link');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_1', 'Show "All Users" link');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_2', 'Always show all users');
DEFINE ('_UDDEADM_CONFIGNOTWRITEABLE', 'Configuration is not writeable:');
DEFINE ('_UDDEADM_CONFIGWRITEABLE', 'Configuration is writeable:');
DEFINE ('_UDDEIM_FORWARDLINK', 'Chuy&#7875;n ti&#7871;p');
DEFINE ('_UDDEIM_RECIPIENTFOUND', 'ng&#432;&#7901;i nh&#7853;n');
DEFINE ('_UDDEIM_RECIPIENTSFOUND', 'ng&#432;&#7901;i nh&#7853;n');
DEFINE ('_UDDEADM_MAILSYSTEM_MOSMAIL', 'mosMail');
DEFINE ('_UDDEADM_MAILSYSTEM_PHPMAIL', 'php mail (default)');
DEFINE ('_UDDEADM_MAILSYSTEM_HEAD', 'Mailsystem');
DEFINE ('_UDDEADM_MAILSYSTEM_EXP', 'Select mailsystem uddeIM should use to send notifications.');
DEFINE ('_UDDEADM_SHOWGROUPS_HEAD', 'Show Joomla groups');
DEFINE ('_UDDEADM_SHOWGROUPS_EXP', 'Show Joomla groups in general message list.');
DEFINE ('_UDDEADM_ALLOWFORWARDS_HEAD', 'Forwarding of messages');
DEFINE ('_UDDEADM_ALLOWFORWARDS_EXP', 'Allow forwarding of messages.');
DEFINE ('_UDDEIM_FWDFROM', 'Tin nh&#7855;n g&#7889;c t&#7915;');
DEFINE ('_UDDEIM_FWDTO', 'chuy&#7875;n ti&#7871;p t&#7899;i');

// New: 0.9+
DEFINE ('_UDDEIM_UNARCHIVE', 'H&#7911;y l&#432;u tr&#7919;');
DEFINE ('_UDDEIM_CANTUNARCHIVE', 'Không th&#7875; h&#7911;y l&#432;u tr&#7919; tin nh&#7855;n');
DEFINE ('_UDDEADM_ALLOWMULTIPLERECIPIENTS_HEAD', 'Allow multiple recipients');
DEFINE ('_UDDEADM_ALLOWMULTIPLERECIPIENTS_EXP', 'Allow multiple recipients (comma separated).');
DEFINE ('_UDDEIM_CHARSLEFT', 'kí t&#7921; còn l&#7841;i');
DEFINE ('_UDDEADM_SHOWTEXTCOUNTER_HEAD', 'Show text counter');
DEFINE ('_UDDEADM_SHOWTEXTCOUNTER_EXP', 'Shows a text counter which displays how many characters are left.');
DEFINE ('_UDDEIM_CLEAR', 'Xóa h&#7871;t');
DEFINE ('_UDDEADM_ALLOWMULTIPLEUSER_HEAD', 'Append selected users to recipients');
DEFINE ('_UDDEADM_ALLOWMULTIPLEUSER_EXP', 'This allows selection of multiple recipients from "All users" list.');
DEFINE ('_UDDEADM_CBALLOWMULTIPLEUSER_HEAD', 'Append selected connections to recipients');
DEFINE ('_UDDEADM_CBALLOWMULTIPLEUSER_EXP', 'This allows selection of multiple recipients from "CB connections" list.');
DEFINE ('_UDDEADM_PMSFOUND', 'PMS found: ');
DEFINE ('_UDDEIM_ENTERNAME', 'Ch&#432;a nh&#7853;p tên');
DEFINE ('_UDDEADM_USEAUTOCOMPLETE_HEAD', 'Use autocomplete');
DEFINE ('_UDDEADM_USEAUTOCOMPLETE_EXP', 'Use autocomplete for receiver names.');
DEFINE ('_UDDEADM_OBFUSCATING_HEAD', 'Key used for obfuscating');
DEFINE ('_UDDEADM_OBFUSCATING_EXP', 'Enter key which is used for message obfuscating. Do not change this value after message obfuscating has been enabled.');
DEFINE ('_UDDEADM_CFGFILE_NOTFOUND', 'Wrong confguration file found!');
DEFINE ('_UDDEADM_CFGFILE_FOUND', 'Version found:');
DEFINE ('_UDDEADM_CFGFILE_EXPECTED', 'Version expected:');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING', 'Converting configuration...');
DEFINE ('_UDDEADM_CFGFILE_DONE', 'Done!');
DEFINE ('_UDDEADM_CFGFILE_WRITEFAILED', 'Critical Error: Failed to write to configuration file:');

// New: 0.8+
DEFINE ('_UDDEIM_ENCRYPTDOWN', 'Tin nh&#7855;n &#273;ã b&#7883; mã hóa! - Không th&#7875; download!');
DEFINE ('_UDDEIM_WRONGPASSDOWN', 'Sai m&#7853;t kh&#7849;u! - Không th&#7875; download!');
DEFINE ('_UDDEIM_WRONGPW', 'Sai m&#7853;t kh&#7849;u! - Vui lòng liên h&#7879; v&#7899;i admin!');
DEFINE ('_UDDEIM_WRONGPASS', 'Sai m&#7853;t kh&#7849;u!');
DEFINE ('_UDDEADM_MAINTENANCE_D1', 'Wrong trash dates (inbox/outbox): ');
DEFINE ('_UDDEADM_MAINTENANCE_D2', 'Correcting wrong trash dates');
DEFINE ('_UDDEIM_TODP', 'G&#7917;i t&#7899;i: ');
DEFINE ('_UDDEADM_MAINTENANCE_PRUNE', 'Prune messages now');
DEFINE ('_UDDEADM_SHOWACTIONICONS_HEAD', 'Show action icons');
DEFINE ('_UDDEADM_SHOWACTIONICONS_EXP', 'When set to <b>yes</b>, action links will be displayed with an icon.');
DEFINE ('_UDDEIM_UNCHECKALL', 'B&#7887; ch&#7885;n');
DEFINE ('_UDDEIM_CHECKALL', 'Ch&#7885;n t&#7845;t c&#7843;');
DEFINE ('_UDDEADM_SHOWBOTTOMICONS_HEAD', 'Show bottom icons');
DEFINE ('_UDDEADM_SHOWBOTTOMICONS_EXP', 'When set to <b>yes</b>, bottom links will be displayed with an icon.');
DEFINE ('_UDDEADM_ANIMATED_HEAD', 'Use animated smileys');
DEFINE ('_UDDEADM_ANIMATED_EXP', 'Use animated smileys instead of the static ones.');
DEFINE ('_UDDEADM_ANIMATEDEX_HEAD', 'More animated smileys');
DEFINE ('_UDDEADM_ANIMATEDEX_EXP', 'Show more animated smileys.');
DEFINE ('_UDDEIM_PASSWORDREQ', 'Tin nh&#7855;n &#273;ã b&#7883; mã hóa - Yêu c&#7847;u m&#7853;t kh&#7849;u');
DEFINE ('_UDDEIM_PASSWORD', '<b>Yêu c&#7847;u m&#7853;t kh&#7849;u</b>');
DEFINE ('_UDDEIM_PASSWORDBOX', 'M&#7853;t kh&#7849;u');
DEFINE ('_UDDEIM_ENCRYPTIONTEXT', ' (n&#7897;i dung mã hóa)');
DEFINE ('_UDDEIM_DECRYPTIONTEXT', ' (n&#7897;i dung gi&#7843;i mã)');
DEFINE ('_UDDEIM_MORE', 'Thêm');
// uddeIM Module
DEFINE ('_UDDEMODULE_PRIVATEMESSAGES', 'Tin nh&#7855;n');
DEFINE ('_UDDEMODULE_NONEW', 'không m&#7899;i');
DEFINE ('_UDDEMODULE_NEWMESSAGES', 'Tin nh&#7855;n m&#7899;i: ');
DEFINE ('_UDDEMODULE_MESSAGE', 'tin nh&#7855;n');
DEFINE ('_UDDEMODULE_MESSAGES', 'tin nh&#7855;n');
DEFINE ('_UDDEMODULE_YOUHAVE', 'B&#7841;n có');
DEFINE ('_UDDEMODULE_HELLO', 'Hi');
DEFINE ('_UDDEMODULE_EXPRESSMESSAGE', 'Tin nh&#7855;n nhanh');

// New: 0.7+
DEFINE ('_UDDEADM_USEENCRYPTION', 'Use encryption');
DEFINE ('_UDDEADM_USEENCRYPTIONDESC', 'Encrypt stored messages');
DEFINE ('_UDDEADM_CRYPT0', 'None');
DEFINE ('_UDDEADM_CRYPT1', 'Obfuscate messages');
DEFINE ('_UDDEADM_CRYPT2', 'Encrypt messages');
DEFINE ('_UDDEADM_NOTIFYDEFAULT_HEAD', 'Default for e-mail notification');
DEFINE ('_UDDEADM_NOTIFYDEFAULT_EXP', 'Default value for e-mail notification (for users who have not changed their preferences yet).');
DEFINE ('_UDDEADM_NOTIFYDEF_0', 'No notification');
DEFINE ('_UDDEADM_NOTIFYDEF_1', 'Always');
DEFINE ('_UDDEADM_NOTIFYDEF_2', 'Notification when offline');
DEFINE ('_UDDEADM_SUPPRESSALLUSERS_HEAD', 'Supress "All users" link');
DEFINE ('_UDDEADM_SUPPRESSALLUSERS_EXP', 'Supress "All users" link in write new message box (useful when lots of users are registered).');
DEFINE ('_UDDEADM_POPUP_HEAD','Popup notification');
DEFINE ('_UDDEADM_POPUP_EXP','Show a popup when a new message arrives (mod_uddeim or patched mod_cblogin is needed)');
DEFINE ('_UDDEIM_OPTIONS', 'Thi&#7871;t l&#7853;p khác');
DEFINE ('_UDDEIM_OPTIONS_EXP', 'B&#7841;n có th&#7875; tùy bi&#7871;n các thi&#7871;t l&#7853;p khác t&#7841;i &#273;ây.');
DEFINE ('_UDDEIM_OPTIONS_P', 'Hi&#7879;n popup khi có tin nh&#7855;n m&#7899;i');
DEFINE ('_UDDEADM_POPUPDEFAULT_HEAD', 'Popup notification by default');
DEFINE ('_UDDEADM_POPUPDEFAULT_EXP', 'Enable popup notification by default (for users who have not changed their preferences yet).');
DEFINE ('_UDDEADM_MAINTENANCE', 'Maintenance');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD', 'Database maintenance');
DEFINE ('_UDDEADM_MAINTENANCE_CHECK', 'CHECK');
DEFINE ('_UDDEADM_MAINTENANCE_TRASH', 'REPAIR');
DEFINE ('_UDDEADM_MAINTENANCE_EXP', "When a user is purged from the database his messages are usually kept in the database. This function checks if it is necessary to trash orphaned messages and you can trash them if it is required.<br />This also checks the database for a few errors which will be corrected.");
DEFINE ('_UDDEADM_MAINTENANCE_MC1', "Checking...<br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC2', "<i>#nnn (Username): [inbox|inbox trashed|outbox|outbox trashed]</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC3', "<i>inbox: messages stored in users inbox</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC4', "<i>inbox trashed: messages trashed from users inbox, but still in someones outbox</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC5', "<i>outbox: messages stored in users outbox</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MC6', "<i>outbox trashed: messages trashed from users outbox, but still in someones inbox</i><br />");
DEFINE ('_UDDEADM_MAINTENANCE_MT1', "Trashing...<br />");
DEFINE ('_UDDEADM_MAINTENANCE_NOTFOUND', "not found (from/to/settings/blocker/blocked):");
DEFINE ('_UDDEADM_MAINTENANCE_MT2', "delete all preferences from user");
DEFINE ('_UDDEADM_MAINTENANCE_MT3', "delete blocking of user");
DEFINE ('_UDDEADM_MAINTENANCE_MT4', "trash all messages sent to deleted user in sender\'s outbox and deleted user\'s inbox");
DEFINE ('_UDDEADM_MAINTENANCE_MT5', "trash all messages sent from deleted user in his outbox and receiver\'s inbox");
DEFINE ('_UDDEADM_MAINTENANCE_NOTHINGTODO', '<b>Nothing to do</b><br />');
DEFINE ('_UDDEADM_MAINTENANCE_JOBTODO', '<b>Maintenance required</b><br />');

// New: 0.6+
DEFINE ('_UDDEADM_NAMESTEXT', 'Show realnames');
DEFINE ('_UDDEADM_NAMESDESC', 'Show realnames or usernames?');
DEFINE ('_UDDEADM_REALNAMES', 'Realnames');
DEFINE ('_UDDEADM_USERNAMES', 'Usernames');
DEFINE ('_UDDEADM_CONLISTBOX', 'Connections listbox');
DEFINE ('_UDDEADM_CONLISTBOXDESC', 'Show my connections in a listbox or in a table?');
DEFINE ('_UDDEADM_LISTBOX', 'Listbox');
DEFINE ('_UDDEADM_TABLE', 'Table');

DEFINE ('_UDDEIM_TRASHCAN_INFO', 'Tin nh&#7855;n s&#7869; &#7903; trong thùng rác 24 gi&#7901; tr&#432;&#7899;c khi b&#7883; xóa v&#297;nh vi&#7877;n. B&#7841;n ch&#7881; có th&#7875; xem nh&#7919;ng t&#7915; &#273;&#7847;u tiên c&#7843;u tin nh&#7855;n. &#272;&#7875; &#273;&#7885;c &#273;&#432;&#7907;c tin nh&#7855;n, b&#7841;n ph&#7843;i khôi ph&#7909;c l&#7841;i nó.');
DEFINE ('_UDDEIM_TRASHCAN_INFO_1', 'Tin nh&#7855;n s&#7869; &#273;&#432;&#7907;c l&#432;u tr&#7919; trong thùng rác trong vòng ');
DEFINE ('_UDDEIM_TRASHCAN_INFO_2', ' gi&#7901; tr&#432;&#7899;c khi b&#7883; xóa v&#297;nh vi&#7877;n. B&#7841;n ch&#7881; có th&#7875; nhìn th&#7845;y t&#7915; &#273;&#7847;u tiên trong n&#7897;i dung tin nh&#7855;n. &#272;&#7875; &#273;&#7885;c &#273;&#432;&#7907;c tin nh&#7855;n b&#7841;n ph&#7843;i khôi ph&#7909;c l&#7841;i tin nh&#7855;n.');
DEFINE ('_UDDEIM_RECALLEDMESSAGE_INFO', 'Tin nh&#7855;n này v&#7915;a &#273;&#432;&#7907;c thu h&#7891;i, b&#7841;n có th&#7875; s&#7917;a và g&#7917;i l&#7841;i nó.');
DEFINE ('_UDDEIM_COULDNOTRECALL', 'Không thu h&#7891;i &#273;&#432;&#7907;c tin nh&#7855;n (có th&#7875; nó &#273;ã &#273;&#432;&#7907;c &#273;&#7885;c ho&#7863;c b&#7883; xóa.)');
DEFINE ('_UDDEIM_CANTRESTORE', 'Khôi ph&#7909;c tin nh&#7855;n th&#7845;t b&#7841;i. (Có th&#7875; tin nh&#7855;n &#273;ã &#273;&#432;&#7907;c chuy&#7875;n t&#7899;i thùng rác trong th&#7901;i gian dài, và &#273;ã b&#7883; xóa.)');
DEFINE ('_UDDEIM_COULDNOTRESTORE', 'Khôi ph&#7909;c tin nh&#7855;n th&#7845;t b&#7841;i.');
DEFINE ('_UDDEIM_DONTSEND', 'Không g&#7917;i');
DEFINE ('_UDDEIM_SENDAGAIN', 'G&#7917;i l&#7841;i');
DEFINE ('_UDDEIM_NOTLOGGEDIN', 'B&#7841;n ch&#432;a &#273;&#259;ng nh&#7853;p.');
DEFINE ('_UDDEIM_NOMESSAGES_INBOX', '<b>B&#7841;n không có tin nh&#7855;n nào.</b>');

DEFINE ('_UDDEIM_NOMESSAGES_OUTBOX', '<b>H&#7897;p th&#432; &#273;i không có th&#432; nào.</b>');
DEFINE ('_UDDEIM_NOMESSAGES_TRASHCAN', '<b>Thùng rác không có th&#432; nào.</b>');
DEFINE ('_UDDEIM_INBOX', 'Th&#432; &#273;&#7871;n');
DEFINE ('_UDDEIM_OUTBOX', 'Th&#432; &#273;i');
DEFINE ('_UDDEIM_TRASHCAN', 'Thùng rác');
DEFINE ('_UDDEIM_CREATE', 'Tin nh&#7855;n m&#7899;i');
DEFINE ('_UDDEIM_UDDEIM', 'Tin nh&#7855;n');
DEFINE ('_UDDEIM_READSTATUS', '&#272;&#7885;c tin');
DEFINE ('_UDDEIM_FROM', 'T&#7915;');
DEFINE ('_UDDEIM_FROM_SMALL', 't&#7915;');
DEFINE ('_UDDEIM_TO', 'T&#7899;i');
DEFINE ('_UDDEIM_TO_SMALL', 't&#7899;i');
DEFINE ('_UDDEIM_OUTBOX_WARNING', 'H&#7897;p th&#432; &#273;i ch&#7913;a các tin nh&#7855;n b&#7841;n &#273;ã g&#7917;i. B&#7841;n có th&#7875; thu l&#7841;i các tin nh&#7855;n &#273;ã g&#7917;i n&#7871;u nó ch&#432;a &#273;&#432;&#7907;c &#273;&#7885;c, và ng&#432;&#7901;i nh&#7853;n s&#7869; không th&#7875; &#273;&#7885;c &#273;&#432;&#7907;c nh&#7919;ng tin nh&#7855;n &#273;ó n&#7919;a.');
	// changed in 0.4

DEFINE ('_UDDEIM_RECALL', 'Thu h&#7891;i');
DEFINE ('_UDDEIM_RECALLTHISMESSAGE', 'Thu h&#7891;i tin nh&#7855;n');
DEFINE ('_UDDEIM_RESTORE', 'Khôi ph&#7909;c');
DEFINE ('_UDDEIM_MESSAGE', 'Tin nh&#7855;n');
DEFINE ('_UDDEIM_DATE', 'Ngày');
DEFINE ('_UDDEIM_DELETED', 'Ngày xóa');
DEFINE ('_UDDEIM_DELETE', 'Xóa');
DEFINE ('_UDDEIM_ONLINEPIC', 'images/icon_online.gif');
DEFINE ('_UDDEIM_OFFLINEPIC', 'images/icon_offline.gif');
DEFINE ('_UDDEIM_DELETELINK', 'Xóa');
DEFINE ('_UDDEIM_MESSAGENOACCESS', 'Tin nh&#7855;n không &#273;&#432;&#7907;c hi&#7875;n th&#7883;. <br />Lí do:<ul><li>B&#7841;n không có quyên &#273;&#7885;c tin nh&#7855;n này.</li><li>Tin nh&#7855;n &#273;ã b&#7883; xóa.</li></ul>');
DEFINE ('_UDDEIM_YOUMOVEDTOTRASH', '<b>B&#7841;n &#273;ã xóa tin nh&#7855;n này.</b>');
DEFINE ('_UDDEIM_MESSAGEFROM', 'Tin nh&#7855;n t&#7915; ');
DEFINE ('_UDDEIM_MESSAGETO', 'Tin nh&#7855;n g&#7917;i t&#7915; b&#7841;n t&#7899;i ');
DEFINE ('_UDDEIM_REPLY', 'Tr&#7843; l&#7901;i');
DEFINE ('_UDDEIM_SUBMIT', 'G&#7917;i');
DEFINE ('_UDDEIM_DELETEREPLIED', 'Xóa tin nh&#7855;n &#273;&#7871;n sau khi tr&#7843; l&#7901;i');
DEFINE ('_UDDEIM_NOID', 'L&#7895;i: Không có ng&#432;&#7901;i nh&#7853;n. Tin nh&#7855;n ch&#432;a &#273;&#432;&#7907;c g&#7917;i &#273;i.');
DEFINE ('_UDDEIM_NOMESSAGE', 'L&#7895;i: Tin nh&#7855;n tr&#7889;ng!');
DEFINE ('_UDDEIM_MESSAGE_REPLIEDTO', '&#272;ã g&#7917;i tr&#7843; l&#7901;i');
DEFINE ('_UDDEIM_MESSAGE_SENT', '&#272;ã g&#7917;i tin nh&#7855;n');
DEFINE ('_UDDEIM_MOVEDTOTRASH', ' và xóa tin nh&#7855;n &#273;&#7871;n');
DEFINE ('_UDDEIM_NOSUCHUSER', 'Không tìm th&#7845;y thành viên!');
DEFINE ('_UDDEIM_NOTTOYOURSELF', 'B&#7841;n không th&#7875; t&#7921; g&#7917;i tin nh&#7855;n cho chính mình!');
DEFINE ('_UDDEIM_VIOLATION', '<b>T&#7915; ch&#7889;i truy c&#7853;p!</b> B&#7841;n không có quy&#7873;n th&#7921;c hi&#7879;n hành &#273;&#7897;ng này!');
DEFINE ('_UDDEIM_PRUNELINK', 'Dành cho admin: L&#432;&#7907;c b&#7899;t');

// Admin

DEFINE ('_UDDEADM_SETTINGS', 'uddeIM Administration');
DEFINE ('_UDDEADM_GENERAL', 'General');
DEFINE ('_UDDEADM_ABOUT', 'About');
DEFINE ('_UDDEADM_DATESETTINGS', 'Date/time');
DEFINE ('_UDDEADM_PICSETTINGS', 'Icons');
DEFINE ('_UDDEADM_DELETEREADAFTER_HEAD', 'Read messages kept for (days)');
DEFINE ('_UDDEADM_DELETEUNREADAFTER_HEAD', 'Unread messages kept for (days)');
DEFINE ('_UDDEADM_DELETETRASHAFTER_HEAD', 'Messages kept in trash for (days)');
DEFINE ('_UDDEADM_DAYS', 'day(s)');
DEFINE ('_UDDEADM_DELETEREADAFTER_EXP', 'Enter the number of days until <b>read</b> messages will be erased automatically from the inbox. If you do not want to erase messages automatically, enter a very high value (e.g. 36524 days are equivalent to one century). But keep in mind that the database can fill up quickly if you keep all messages.');
DEFINE ('_UDDEADM_DELETEUNREADAFTER_EXP', 'Enter the number of days until messages will be erased that have <b>not been read</b> by their intended recipient yet.');
DEFINE ('_UDDEADM_DELETETRASHAFTER_EXP', 'Enter the number of days until messages are erased from the trashcan. Decimal values are possible, e.g. to erase messages from the trashcan after 3 hours enter 0.125 as value.');
DEFINE ('_UDDEADM_DATEFORMAT_HEAD', 'Date display format');
DEFINE ('_UDDEADM_DATEFORMAT_EXP', 'Choose the format used when a date/time is being displayed. Months will be abbreviated according to your local language settings of Joomla (if a matching uddeIM language file is present).');
DEFINE ('_UDDEADM_LDATEFORMAT_HEAD', 'Longer date display');
DEFINE ('_UDDEADM_LDATEFORMAT_EXP', 'When displaying messages there is more space for the date/time string. Choose the date format to display when opening a message. For weekday names and months the local language settings of Joomla will be used (if a matching uddeIM language file is present).');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_HEAD', 'Deletions invoked');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_YES', 'by admins only');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_NO', 'by any user');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_MANUALLY', 'manually');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_EXP', 'Automatic deletions create heavy server load. If you choose <b>by admins only</b> automatic deletions are invoked when an admin checks his inbox. Choose this option if an admin is checking the inbox regulary. Small or rarely administered sites may choose <b>by any user</b>.');

	// above string changed in 0.4 
DEFINE ('_UDDEADM_SAVESETTINGS', 'Save settings');
DEFINE ('_UDDEADM_THISHASBEENSAVED', 'The following settings have been saved to config file:');
DEFINE ('_UDDEADM_SETTINGSSAVED', 'Settings have been saved.');
DEFINE ('_UDDEADM_ICONONLINEPIC_HEAD', 'Icon: User is online');
DEFINE ('_UDDEADM_ICONONLINEPIC_EXP', 'Enter the location of the icon to be displayed next to the username when this user is online.');
DEFINE ('_UDDEADM_ICONOFFLINEPIC_HEAD', 'Icon: User is offline');
DEFINE ('_UDDEADM_ICONOFFLINEPIC_EXP', 'Enter the location of the icon to be displayed next to the username when this user is offline.');
DEFINE ('_UDDEADM_ICONREADPIC_HEAD', 'Icon: Read message');
DEFINE ('_UDDEADM_ICONREADPIC_EXP', 'Enter the location of the icon to be displayed for read messages.');
DEFINE ('_UDDEADM_ICONUNREADPIC_HEAD', 'Icon: Unread message');
DEFINE ('_UDDEADM_ICONUNREADPIC_EXP', 'Enter the location of the icon to be displayed for unread messages.');
DEFINE ('_UDDEADM_MODULENEWMESS_HEAD', 'Module: New Messages Icon');
DEFINE ('_UDDEADM_MODULENEWMESS_EXP', 'This setting refers to the mod_uddeim module. Enter the location of the icon that this module shall display when there are new messages.');

// admin import tab

DEFINE ('_UDDEADM_UDDEINSTALL', 'uddeIM Installation');
DEFINE ('_UDDEADM_FINISHED', 'Installation is finished. Welcome to uddeIM. ');
DEFINE ('_UDDEADM_NOCB', '<span style="color: red;">You do not have Mambo Community Builder installed. You will not be able to use uddeIM.</span><br /><br />You might want to download <a href="http://www.mambojoe.com">Mambo Community Builder</a>.');
DEFINE ('_UDDEADM_CONTINUE', 'continue');
DEFINE ('_UDDEADM_PMSFOUND_1', 'There are ');
DEFINE ('_UDDEADM_PMSFOUND_2', ' messages in the old PMS installation. Do you want to import these messages into uddeIM?');
DEFINE ('_UDDEADM_IMPORT_EXP', 'This will not alter the old PMS messages or your installation. They will be kept intact and you can safely import them into uddeIM, even if you consider to continue using the old PMS. You should save any changes you made to the settings first before running the import! All messages that are already in your uddeIM database will remain intact.');
	// _UDDEADM_IMPORT_EXP above changed in 0.4
	
DEFINE ('_UDDEADM_IMPORT_YES', 'Import old PMS messages into uddeIM now');
DEFINE ('_UDDEADM_IMPORT_NO', 'No, do not import any messages');  
DEFINE ('_UDDEADM_IMPORTING', 'Please wait while messages are being imported.');
DEFINE ('_UDDEADM_IMPORTDONE', 'Done importing messages from old PMS. Do not run this installation script again because doing so will import the messages again and they will show up twice.'); 
DEFINE ('_UDDEADM_IMPORT', 'Import');
DEFINE ('_UDDEADM_IMPORT_HEADER', 'Import messages from old PMS');
DEFINE ('_UDDEADM_PMSNOTFOUND', 'No other PMS installation found. Import not possible.');
DEFINE ('_UDDEADM_ALREADYIMPORTED', '<span style="color: red;">You have already imported the messages from the old PMS into uddeIM.</span>');

// new in 0.3 Frontend
DEFINE ('_UDDEIM_BLOCKS', '&#272;ã khóa');
DEFINE ('_UDDEIM_YOUAREBLOCKED', 'Không g&#7917;i &#273;&#432;&#7907;c (ng&#432;&#7901;i nh&#7853;n &#273;ã khóa nick c&#7911;a b&#7841;n)');
DEFINE ('_UDDEIM_BLOCKNOW', 'Ch&#7863;n');
DEFINE ('_UDDEIM_BLOCKS_EXP', 'D&#432;&#7899;i &#273;ây là danh sách các thành viên b&#7841;n &#273;ã ch&#7863;n. H&#7885; s&#7869; không th&#7875; ti&#7871;p t&#7909;c g&#7917;i tin nh&#7855;n t&#7899;i cho b&#7841;n.');
DEFINE ('_UDDEIM_NOBODYBLOCKED', 'Hi&#7879;n t&#7841;i b&#7841;n không ch&#7863;n tin nh&#7855;n t&#7915; b&#7845;t kì thành viên nào');
DEFINE ('_UDDEIM_YOUBLOCKED_PRE', 'B&#7841;n &#273;ang ch&#7863;n ');
DEFINE ('_UDDEIM_YOUBLOCKED_POST', ' thành viên.');
DEFINE ('_UDDEIM_UNBLOCKNOW', '[M&#7903; khóa]');
DEFINE ('_UDDEIM_BLOCKALERT_EXP_ON', 'Khi các thành viên b&#7883; ch&#7863;n g&#7917;i tin nh&#7855;n cho b&#7841;n, h&#7885; s&#7869; nh&#7853;n &#273;&#432;&#7907;c thông tin h&#7885; &#273;ã b&#7883; ch&#7863;n và tin nh&#7855;n không &#273;&#432;&#7907;c g&#7917;i.');
DEFINE ('_UDDEIM_BLOCKALERT_EXP_OFF', 'Ng&#432;&#7901;i b&#7883; ch&#7863;n s&#7869; không bi&#7871;t r&#7857;ng b&#7841;n &#273;ã ch&#7863;n h&#7885;.');
DEFINE ('_UDDEIM_CANTBLOCKADMINS', 'B&#7841;n không th&#7875; ch&#7863;n admin.');

// new in 0.3 Admin
DEFINE ('_UDDEADM_BLOCKSYSTEM_HEAD', 'Enable blocking system');
DEFINE ('_UDDEADM_BLOCKSYSTEM_EXP', 'When enabled, users can block other users. A blocked user can not send messages to the user who has blocked him. Admins can\'t be blocked.');
DEFINE ('_UDDEADM_BLOCKSYSTEM_YES', 'yes');
DEFINE ('_UDDEADM_BLOCKSYSTEM_NO', 'no');
DEFINE ('_UDDEADM_BLOCKALERT_HEAD', 'Blocked user information');
DEFINE ('_UDDEADM_BLOCKALERT_EXP', 'If set to <b>yes</b>, a blocked user will be informed that the message has not been sent because the recipient has blocked him. If set to <b>no</b>, the blocked user does not get any notification that the message has not been sent.');
DEFINE ('_UDDEADM_BLOCKALERT_YES', 'yes');
DEFINE ('_UDDEADM_BLOCKALERT_NO', 'no');
DEFINE ('_UDDEIM_BLOCKSDISABLED', 'H&#7879; th&#7889;ng ch&#7863;n tin nh&#7855;n &#273;ã t&#7855;t');
// DEFINE ('_UDDEADM_DELETIONS', 'Messages'); 
	// translators info: comment out or delete line above to avoid double definition.
	// new definition right below.
DEFINE ('_UDDEADM_DELETIONS', 'Deletion'); // changed in 0.4
DEFINE ('_UDDEADM_BLOCK', 'Blocking');

// new in 0.4, admin
DEFINE ('_UDDEADM_INTEGRATION', 'Integration');
DEFINE ('_UDDEADM_EMAIL', 'E-mail');
DEFINE ('_UDDEADM_SHOWONLINE_HEAD', 'Show online status');
DEFINE ('_UDDEADM_SHOWONLINE_EXP', 'When set to <b>yes</b>, uddeIM displays every username with a small icon that informs if this user is online or offline.');
DEFINE ('_UDDEADM_ALLOWEMAILNOTIFY_HEAD', 'Allow e-mail notification');
DEFINE ('_UDDEADM_ALLOWEMAILNOTIFY_EXP', 'When set to <b>yes</b>, users can choose if they want to get an e-mail every time a new message arrives in the inbox.');
DEFINE ('_UDDEADM_EMAILWITHMESSAGE_HEAD', 'E-mail contains message');
DEFINE ('_UDDEADM_EMAILWITHMESSAGE_EXP', 'When set to <b>no</b>, this e-mail will only contain information about when and by whom the message was sent, but not the message itself.');
DEFINE ('_UDDEADM_LONGWAITINGEMAIL_HEAD', 'Forgetmenot e-mail');
DEFINE ('_UDDEADM_LONGWAITINGEMAIL_EXP', 'This feature sends an e-mail to users who have unread messages in their inbox for a very long time (set below). This setting is independent from the \'allow e-mail notification\'. If you do not want to send out any e-mail messages you have to turn off both.');
DEFINE ('_UDDEADM_LONGWAITINGDAYS_HEAD', 'Forgetmenot sent after day(s)');
DEFINE ('_UDDEADM_LONGWAITINGDAYS_EXP', 'If the forgetmenot feature (above) is set to <b>yes</b>, set here after how many days e-mail notifications about unread messages shall be dispatched.');
DEFINE ('_UDDEADM_FIRSTWORDSINBOX_HEAD', 'First characters list');
DEFINE ('_UDDEADM_FIRSTWORDSINBOX_EXP', 'You can set here how many characters of a message will be displayed in the inbox, outbox and trashcan.');
DEFINE ('_UDDEADM_MAXLENGTH_HEAD', 'Message maximum length');
DEFINE ('_UDDEADM_MAXLENGTH_EXP', 'Set the maximum length of a message (a message will be truncated automatically when its length exceeds this value). Set to \'0\' to allow for messages of any length (not recommended).');
DEFINE ('_UDDEADM_YES', 'yes');
DEFINE ('_UDDEADM_NO', 'no');
DEFINE ('_UDDEADM_ADMINSONLY', 'admins only');
DEFINE ('_UDDEADM_SYSTEM', 'System');
DEFINE ('_UDDEADM_SYSM_USERNAME_HEAD', 'System messages username');
DEFINE ('_UDDEADM_SYSM_USERNAME_EXP', 'uddeIM supports system messages. They do not have a sender and users can\'t reply to them. Enter here the default username alias for system messages (for example <b>Support</b> or <b>Help desk</b> or <b>Community Master</b>).');
DEFINE ('_UDDEADM_ALLOWTOALL_HEAD', 'Allow admins to send general messages');
DEFINE ('_UDDEADM_ALLOWTOALL_EXP', 'uddeIM supports general messages. They are sent to every user on your system. Use them sparingly.');
DEFINE ('_UDDEADM_EMN_SENDERNAME_HEAD', 'E-mail sender name');
DEFINE ('_UDDEADM_EMN_SENDERNAME_EXP', 'Enter the name from which e-mail notifications come from (for example <b>Your Site</b> or <b>Messaging Service</b>)');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_HEAD', 'E-mail sender address');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_EXP', 'Enter the e-mail address from which e-mail notifications are sent from (this should be the main contact e-mail address of your site.');
DEFINE ('_UDDEADM_VERSION', 'uddeIM version');
DEFINE ('_UDDEADM_ARCHIVE', 'Archive'); // translators info: headline for Archive system
DEFINE ('_UDDEADM_ALLOWARCHIVE_HEAD', 'Enable archive');
DEFINE ('_UDDEADM_ALLOWARCHIVE_EXP', 'Choose if users shall be allowed to store messages in an archive. Messages in the archive will not be deleted automatically.');
DEFINE ('_UDDEADM_MAXARCHIVE_HEAD', 'Max messages in archive');
DEFINE ('_UDDEADM_MAXARCHIVE_EXP', 'Set how many messages every user may store in the archive (no limit for admins).');
DEFINE ('_UDDEADM_COPYTOME_HEAD', 'Allow self copies');
DEFINE ('_UDDEADM_COPYTOME_EXP', 'Allows users to receive copies of messages they are sending. These copies will appear in the inbox.');
DEFINE ('_UDDEADM_MESSAGES', 'Messages');
DEFINE ('_UDDEADM_TRASHORIGINAL_HEAD', 'Suggest to trash original');
DEFINE ('_UDDEADM_TRASHORIGINAL_EXP', 'When activated this will put a checkbox next to the \'Send\' reply button called \'trash original\' that is checked by default. In this case a message will immediately be moved from the inbox to trashcan when a reply has been sent. This function reduces the number of messages kept in the database. Users can uncheck the box if they want to keep a message in the inbox.');
	// translators info: 'Send' is the same as _UDDEIM_SUBMIT, 
	// and 'trash original' the same as _UDDEIM_TRASHORIGINAL
	
DEFINE ('_UDDEADM_PERPAGE_HEAD', 'Messages per page');	
DEFINE ('_UDDEADM_PERPAGE_EXP', 'Define here the number of messages displayed per page in inbox, outbox, trashcan and archive.');
DEFINE ('_UDDEADM_CHARSET_HEAD', 'Used charset');
DEFINE ('_UDDEADM_CHARSET_EXP', 'If you\'re experiencing problems with non-latin character sets displayed, you can enter the charset uddeIM uses to convert database output to HTML code here. The default value is correct for most European languages.');
DEFINE ('_UDDEADM_MAILCHARSET_HEAD', 'Used mail charset');
DEFINE ('_UDDEADM_MAILCHARSET_EXP', 'If you\'re experiencing problems with non-latin character sets displayed, you can enter the charset uddeIM uses to send outgoing e-mails with. The default value is correct for most European languages.');
		// translators info: if you're translating into a language that uses a latin charset
		// (like English, Dutch, German, Swedish, Spanish, ... ) you might want to add a line
		// saying 'For usage in [mylanguage] the default value is correct.'
		
DEFINE ('_UDDEADM_EMN_BODY_NOMESSAGE_EXP', 'This is the content of the e-mail users will receive when the option is set above. The content of the message will not be in the e-mail. Keep the variables %you%, %user% and %site% intact. ');		
DEFINE ('_UDDEADM_EMN_BODY_WITHMESSAGE_EXP', 'This is the content of the e-mail users will receive when the option is set above. This e-mail will include the content of the message. Keep the variables %you%, %user%, %pmessage% and %site% intact. ');		
DEFINE ('_UDDEADM_EMN_FORGETMENOT_EXP', 'This is the content of the forgetmenot e-mail users will receive when the option is set above. Keep the variables %you% and %site% intact. ');		
DEFINE ('_UDDEADM_ENABLEDOWNLOAD_EXP', 'Allow users to download messages from their archive by sending them as e-mail to themselves.');
DEFINE ('_UDDEADM_ENABLEDOWNLOAD_HEAD', 'Allow download');	
DEFINE ('_UDDEADM_EXPORT_FORMAT_EXP', 'This is the format of the e-mail users will receive when they download their own messages from the archive. Keep the variables %user%, %msgdate% and %msgbody% intact. ');	
		// translators info: Don't translate %you%, %user%, etc. in the strings above. 

DEFINE ('_UDDEADM_INBOXLIMIT_HEAD', 'Set inbox limit');		
DEFINE ('_UDDEADM_INBOXLIMIT_EXP', 'You can include the number of messages in the inbox into the maximum number of archived messages. In this case, the number of messages in inbox and archive in total must not exceed the number set above. Alternatively, you can set the inbox limit without an archive. In this case, users may have no more than the number of messages set above in their inboxes. If the number is reached, they will no longer be able to reply to messages or to compose new ones until they delete old messages from the inbox or archive respectively (users will still be able to receive and read messages).');
DEFINE ('_UDDEADM_SHOWINBOXLIMIT_HEAD', 'Show limit usage at inbox');		
DEFINE ('_UDDEADM_SHOWINBOXLIMIT_EXP', 'Display how many messages users have stored (and how many they are allowed to store) in a line below the inbox.');
		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INTRO', 'You have turned off the archive. How do you want to handle messages that are saved in the archive?');		

DEFINE ('_UDDEADM_ARCHIVETOTRASH_LEAVE_LINK', 'Leave them');		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_LEAVE_EXP', 'Leave them in the archive (user will not be able to access the messages and they will still count against message limits).');		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_LINK', 'Move to inbox');		
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_DONE', 'Archived messages moved to inboxes');
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_EXP', 'Messages will be moved to the inbox of the respective user (or to trash if they are older than allowed in the inbox).');		

		
// 0.4 frontend, admins only (no translation necessary)		
DEFINE ('_UDDEIM_VALIDFOR_1', 'Có giá tr&#7883; trong ');
DEFINE ('_UDDEIM_VALIDFOR_2', ' gi&#7901;. 0=v&#297;nh vi&#7877;n (T&#7921; &#273;&#7897;ng xóa sau th&#7901;i gian &#273;&#7883;nh tr&#432;&#7899;c)');
DEFINE ('_UDDEIM_WRITE_SYSM_GM', '[T&#7841;o tin nh&#7855;n h&#7879; th&#7889;ng ho&#7863;c tin nh&#7855;n chung]');
DEFINE ('_UDDEIM_WRITE_NORMAL', '[T&#7841;o tin nh&#7855;n thông th&#432;&#7901;ng]');
DEFINE ('_UDDEIM_NOTALLOWED_SYSM_GM', 'Không cho phép t&#7841;o tin nh&#7855;n h&#7879; th&#7889;ng và tin nh&#7855;n chung.');
DEFINE ('_UDDEIM_SYSGM_TYPE', 'Ki&#7875;u tin nh&#7855;n');
DEFINE ('_UDDEIM_HELPON_SYSGM', 'Tr&#7907; giuso trong h&#7879; th&#7889;ng tin nh&#7855;n');
DEFINE ('_UDDEIM_HELPON_SYSGM_2', '(M&#7903; v&#7899;i c&#7917;a s&#7893; m&#7899;i)');

DEFINE ('_UDDEIM_SYSGM_PLEASECONFIRM', 'B&#7841;n chu&#7849;n b&#7883; g&#7917;i tin nh&#7855;n v&#7899;i n&#7897;i dung d&#432;&#7899;i &#273;ây, vui lòng xác nh&#7853;n l&#7841;i!');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALL', 'G&#7917;i tin nh&#7855;n t&#7899;i <b>t&#7845;t c&#7843; các thành viên</b>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLADMINS', 'G&#7917;i tin nh&#7855;n t&#7899;i <b>nhóm admin</b>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLLOGGED', 'G&#7917;i tin nh&#7855;n t&#7899;i <b>các thành viên &#273;ang online</b>');
DEFINE ('_UDDEIM_SYSGM_WILLDISABLEREPLY', 'Ng&#432;&#7901;i nh&#7853;n không th&#7875; tr&#7843; l&#7901;i tin nh&#7855;n này.');
DEFINE ('_UDDEIM_SYSGM_WILLSENDAS_1', 'Tin nh&#7855;n s&#7869; &#273;&#432;&#7907;c g&#7917;i &#273;i d&#432;&#7899;i tên ng&#432;&#7901;i g&#7917;i là <b>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDAS_2', '</b>');

DEFINE ('_UDDEIM_SYSGM_WILLEXPIRE', 'Tin nh&#7855;n s&#7869; h&#7871;t h&#7841;n và b&#7883; xóa vào lúc ');
DEFINE ('_UDDEIM_SYSGM_WILLNOTEXPIRE', 'Tin nh&#7855;n vô th&#7901;i h&#7841;n');
DEFINE ('_UDDEIM_SYSGM_CHECKLINK', '<b>Ki&#7875;n tra liên k&#7871;t (b&#7857;ng cách nh&#7845;n vào liên k&#7871;t) tr&#432;&#7899;c khi ti&#7871;n hành!</b>');
DEFINE ('_UDDEIM_SYSGM_SHORTHELP', 'Ch&#7881; s&#7917; d&#7909;ng <b>tin nh&#7855;n h&#7879; th&#7889;ng</b>:<br /> [b]<b>In &#273;&#7853;m</b>[/b] [i]<em>In nghiêng</em>[/i]<br />
[url=http://www.someurl.com]some url[/url] ho&#7863;c [url]http://www.someurl.com[/url] là các liên k&#7871;t');
DEFINE ('_UDDEIM_SYSGM_ERRORNORECIPS', 'L&#7895;i: Không có ng&#432;&#7901;i nh&#7853;n này. Tin nh&#7855;n ch&#432;a &#273;&#432;&#7907;c g&#7917;i &#273;i.');		

DEFINE ('_UDDEIM_CANTREPLY', '&#272;ây là tin nh&#7855;n h&#7879; th&#7889;ng. B&#7841;n không th&#7875; tr&#7843; l&#7901;i tin nh&#7855;n này.');
DEFINE ('_UDDEIM_EMNOFF', 'Email thông báo &#273;ã t&#7855;t. ');
DEFINE ('_UDDEIM_EMNON', 'Email thông báo &#273;ã b&#7853;t. ');
DEFINE ('_UDDEIM_SETEMNON', '[b&#7853;t]');
DEFINE ('_UDDEIM_SETEMNOFF', '[t&#7855;t]');
DEFINE ('_UDDEIM_EMN_BODY_NOMESSAGE',
"Chào %you%,\n\n%user% &#273;ã g&#7917;i tin nh&#7855;n cho b&#7841;n t&#7841;i %site%. Hãy &#273;&#259;ng nh&#7853;p &#273;&#7875; &#273;&#7885;c tin nh&#7855;n!");
DEFINE ('_UDDEIM_EMN_BODY_WITHMESSAGE',
"Chào %you%,\n\n%user% &#273;ã g&#7917;i tin nh&#7855;n sau cho b&#7841;n t&#7841;i %site%. Hãy &#273;&#259;ng nh&#7853;p &#273;&#7875; tr&#7843; l&#7901;i tin nh&#7855;n!\n__________________\n%pmessage%");
DEFINE ('_UDDEIM_EMN_FORGETMENOT',
"Chào %you%,\n\nB&#7841;n có tin nh&#7855;n ch&#432;a &#273;&#7885;c t&#7841;i %site%. Hãy &#273;&#259;ng nh&#7853;p &#273;&#7875; &#273;&#7885;c tin nh&#7855;n!");
DEFINE ('_UDDEIM_EXPORT_FORMAT', '
================================================================================
%user% (%msgdate%)
----------------------------------------
%msgbody%
================================================================================');
DEFINE ('_UDDEIM_EMN_SUBJECT', 'Ban co tin nhan tai %site%');
DEFINE ('_UDDEIM_SEND_ASSYSM', 'G&#7917;i tin nh&#7855;n h&#7879; th&#7889;ng (=Ng&#432;&#7901;i nh&#7853;n không th&#7875; tr&#7843; l&#7901;i)');
DEFINE ('_UDDEIM_SEND_TOALL', 'G&#7917;i t&#7899;i t&#7845;t c&#7843; các thành viên');
DEFINE ('_UDDEIM_SEND_TOALLADMINS', 'G&#7917;i t&#7899;i nhóm admin');
DEFINE ('_UDDEIM_SEND_TOALLLOGGED', 'G&#7917;i t&#7899;i t&#7845;t c&#7843; các thành viên online');

DEFINE ('_UDDEIM_UNEXPECTEDERROR_QUIT', 'L&#7895;i x&#7843;y ra: ');
DEFINE ('_UDDEIM_ARCHIVENOTENABLED', 'Không cho phép l&#432;u tr&#7919;.');
DEFINE ('_UDDEIM_ARCHIVE_ERROR', 'L&#7895;i l&#432;u tr&#7919; tin nh&#7855;n.');
DEFINE ('_UDDEIM_ARC_SAVED_1', 'B&#7841;n &#273;ã l&#432;u tr&#7919; ');
DEFINE ('_UDDEIM_ARC_SAVED_NONE', '<b>B&#7841;n ch&#432;a l&#432;u tr&#7919; tin nh&#7855;n nào.</b>'); 
DEFINE ('_UDDEIM_ARC_SAVED_NONE_2', '<b>L&#432;u tr&#7919; không có th&#432; nào.</b>'); 
DEFINE ('_UDDEIM_ARC_SAVED_2', ' tin nh&#7855;n');
DEFINE ('_UDDEIM_ARC_SAVED_ONE', 'B&#7841;n &#273;ã l&#432;u tr&#7919; 1 tin nh&#7855;n');
DEFINE ('_UDDEIM_ARC_SAVED_3', '&#272;&#7875; l&#432;u tr&#7919; thêm tin nh&#7855;n, b&#7841;n ph&#7843;i xóa b&#7899;t vào tin nh&#7855;n &#273;ã l&#432;u tr&#7919;.');
DEFINE ('_UDDEIM_ARC_CANSAVEMAX_1', 'B&#7841;n có th&#7875; l&#432;u tr&#7919; t&#7889;i &#273;a ');
DEFINE ('_UDDEIM_ARC_CANSAVEMAX_2', ' tin nh&#7855;n.');
DEFINE ('_UDDEIM_INBOX_LIMIT_1', 'B&#7841;n có ');
DEFINE ('_UDDEIM_INBOX_LIMIT_2', ' tin nh&#7855;n trong');
DEFINE ('_UDDEIM_INBOX_LIMIT_2_SINGULAR', ' tin nh&#7855;n trong'); // same as _UDDEIM_INBOX_LIMIT_2, but singular (as in one "message in your")
DEFINE ('_UDDEIM_ARC_UNIVERSE_ARC', 'l&#432;u tr&#7919;');
DEFINE ('_UDDEIM_ARC_UNIVERSE_INBOX', 'h&#7897;p th&#432; &#273;&#7871;n');
DEFINE ('_UDDEIM_ARC_UNIVERSE_BOTH', 'h&#7897;p th&#432; &#273;&#7871;n và l&#432;u tr&#7919;');
DEFINE ('_UDDEIM_INBOX_LIMIT_3', 'Cho phép t&#7889;i &#273;a ');
DEFINE ('_UDDEIM_INBOX_LIMIT_4', 'B&#7841;n v&#7851;n có th&#7875; nh&#7853;n và &#273;&#7885;c tin nh&#7855;n nh&#432;ng không th&#7875; g&#7917;i tin nh&#7855;n ho&#7863;c so&#7841;n tin nh&#7855;n m&#7899;i cho &#273;&#7871;n khi b&#7841;n xóa b&#7899;t m&#7897;t vài tin nh&#7855;n.');
DEFINE ('_UDDEIM_SHOWINBOXLIMIT_1', 'Tin nh&#7855;n &#273;ã l&#432;u tr&#7919;: ');
DEFINE ('_UDDEIM_SHOWINBOXLIMIT_2', '(T&#7889;i &#273;a ');

DEFINE ('_UDDEIM_MESSAGE_ARCHIVED', 'L&#432;u tin nh&#7855;n vào h&#7897;p l&#432;u tr&#7919;.');
DEFINE ('_UDDEIM_STORE', 'L&#432;u tr&#7919;');				// translators info: as in: 'store this message in archive now'
DEFINE ('_UDDEIM_BACK', 'Quay l&#7841;i');
DEFINE ('_UDDEIM_TRASHCHECKED', 'Xóa các tin &#273;ã ch&#7885;n');	// translators info: plural!
DEFINE ('_UDDEIM_SHOWALL', 'Xem t&#7845;t c&#7843;');				// translators example "SHOW ALL messages"
DEFINE ('_UDDEIM_ARCHIVE', 'L&#432;u tr&#7919;');				// should be same as _UDDEADM_ARCHIVE
	
DEFINE ('_UDDEIM_ARCHIVEFULL', 'H&#7897;p l&#432;u tr&#7919; &#273;ã &#273;&#7847;y.');	
	
DEFINE ('_UDDEIM_NOMSGSELECTED', 'Không có tin nh&#7855;n nào &#273;&#432;&#7907;c ch&#7885;n.');
DEFINE ('_UDDEIM_THISISACOPY', 'Sao l&#432;u m&#7897;t tin nh&#7855;n &#273;ã g&#7917;i t&#7899;i ');
DEFINE ('_UDDEIM_SENDCOPYTOME', 'G&#7917;i m&#7897;t b&#7843;n sao cho tôi');
DEFINE ('_UDDEIM_SENDCOPYTOARCHIVE', 'Sao l&#432;u vào l&#432;u tr&#7919;');
DEFINE ('_UDDEIM_TRASHORIGINAL', 'Xóa b&#7843;n g&#7889;c');

DEFINE ('_UDDEIM_MESSAGEDOWNLOAD', 'Download tin nh&#7855;n');
DEFINE ('_UDDEIM_EXPORT_MAILED', '&#272;ã g&#7917;i email kèm v&#7899;i các tin nh&#7855;n');
DEFINE ('_UDDEIM_EXPORT_NOW', 'G&#7917;i email cho tôi các tin nh&#7855;n &#273;ã ch&#7885;n');
DEFINE ('_UDDEIM_EXPORT_MAIL_INTRO', 'Email này bao g&#7891;m các tin nh&#7855;n c&#7911;a b&#7841;n.');
DEFINE ('_UDDEIM_EXPORT_COULDNOTSEND', 'Không th&#7875; g&#7917;i email kèm các tin nh&#7855;n.');
DEFINE ('_UDDEIM_LIMITREACHED', 'Tin nh&#7855;n &#273;ã &#273;&#7847;y! Không th&#7875; l&#432;u tr&#7919; ti&#7871;p.');
DEFINE ('_UDDEIM_WRITEMSGTO', 'G&#7917;i tin nh&#7855;n t&#7899;i ');

$udde_smon[1]="Tháng 1";
$udde_smon[2]="Tháng 2";
$udde_smon[3]="Tháng 3";
$udde_smon[4]="Tháng 4";
$udde_smon[5]="Tháng 5";
$udde_smon[6]="Tháng 6";
$udde_smon[7]="Tháng 7";
$udde_smon[8]="Tháng 8";
$udde_smon[9]="Tháng 9";
$udde_smon[10]="Tháng 10";
$udde_smon[11]="Tháng 11";
$udde_smon[12]="Tháng 12";

$udde_lmon[1]="Tháng 1";
$udde_lmon[2]="Tháng 2";
$udde_lmon[3]="Tháng 3";
$udde_lmon[4]="Tháng 4";
$udde_lmon[5]="Tháng 5";
$udde_lmon[6]="Tháng 6";
$udde_lmon[7]="Tháng 7";
$udde_lmon[8]="Tháng 8";
$udde_lmon[9]="Tháng 9";
$udde_lmon[10]="Tháng 10";
$udde_lmon[11]="Tháng 11";
$udde_lmon[12]="Tháng 12";

$udde_lweekday[0]="CN";
$udde_lweekday[1]="Th&#7913; 2";
$udde_lweekday[2]="Th&#7913; 3";
$udde_lweekday[3]="Th&#7913; 4";
$udde_lweekday[4]="Th&#7913; 5";
$udde_lweekday[5]="Th&#7913; 6";
$udde_lweekday[6]="Th&#7913; 7";

$udde_sweekday[0]="Ch&#7911; nh&#7853;t";
$udde_sweekday[1]="Th&#7913; 2";
$udde_sweekday[2]="Th&#7913; 3";
$udde_sweekday[3]="Th&#7913; 4";
$udde_sweekday[4]="Th&#7913; 5";
$udde_sweekday[5]="Th&#7913; 6";
$udde_sweekday[6]="Th&#7913; 7";

// new in 0.5 ADMIN

DEFINE ('_UDDEADM_TEMPLATEDIR_HEAD', 'uddeIM Template');
DEFINE ('_UDDEADM_TEMPLATEDIR_EXP', 'Choose the template you want uddeIM to use');
DEFINE ('_UDDEADM_SHOWCONNEX_HEAD', 'Show connections');
DEFINE ('_UDDEADM_SHOWCONNEX_EXP', 'Use <b>yes</b> if you have CB/CBE/JS installed and want to display the user\'s connections on the compose new message page.');
DEFINE ('_UDDEADM_SHOWSETTINGSLINK_HEAD', 'Show settings');
DEFINE ('_UDDEADM_SHOWSETTINGSLINK_EXP', 'The settings link appears automatically in uddeIM if you have e-mail notification or the blocking system activated. You can specify its position and you can turn it off completely.');
DEFINE ('_UDDEADM_SHOWSETTINGS_ATBOTTOM', 'yes, at bottom');
DEFINE ('_UDDEADM_ALLOWBB_HEAD', 'Allow BB code tags');
DEFINE ('_UDDEADM_FONTFORMATONLY', 'font formats only');
DEFINE ('_UDDEADM_ALLOWBB_EXP', 'Use <b>font formats only</b> to allow users to use the BB code tags for bold, italic, underline, font color and font size. When you set this option to <b>yes</b>, users are allowed to use <b>all</b> supported BB code tags (e.g. links and images).');
DEFINE ('_UDDEADM_ALLOWSMILE_HEAD', 'Allow Emoticons');
DEFINE ('_UDDEADM_ALLOWSMILE_EXP', 'When set to <b>yes</b>, emoticon codes like :-) are replaced with emoticon graphics in message display.');
DEFINE ('_UDDEADM_DISPLAY', 'Display');
DEFINE ('_UDDEADM_SHOWMENUICONS_HEAD', 'Show Menu Icons');
DEFINE ('_UDDEADM_SHOWMENUICONS_EXP', 'When set to <b>yes</b>, menu links will be displayed using an icon.');
DEFINE ('_UDDEADM_SHOWTITLE_HEAD', 'Component Title');
DEFINE ('_UDDEADM_SHOWTITLE_EXP', 'Enter the headline of the private messaging component, for example \'Private Messages\'. Leave empty if you do not want to display a headline.');
DEFINE ('_UDDEADM_SHOWABOUT_HEAD', 'Show About link');
DEFINE ('_UDDEADM_SHOWABOUT_EXP', 'Set to <b>yes</b> to show a link to the uddeIM software credits and license. This link will be placed at the bottom of the uddeIM output.');
DEFINE ('_UDDEADM_STOPALLEMAIL_HEAD', 'Stop e-mail');
DEFINE ('_UDDEADM_STOPALLEMAIL_EXP', 'Check this box to prevent uddeIM from sending out e-mails (e-mail notifications and forgetmenot e-mails) irrespective of the users\' settings, for example when testing the site.');
DEFINE ('_UDDEADM_GETPICLINK_HEAD', 'CB thumbnails in lists');
DEFINE ('_UDDEADM_GETPICLINK_EXP', 'Set to <b>yes</b> if you want to display Community Builder thumbnails in the message lists overview (inbox, outbox, etc.)');

// new in 0.5 FRONTEND

DEFINE ('_UDDEIM_SHOWUSERS', 'Xem thành viên');
DEFINE ('_UDDEIM_CONNECTIONS', 'B&#7841;n bè');
DEFINE ('_UDDEIM_SETTINGS', 'C&#7845;u hình');
DEFINE ('_UDDEIM_NOSETTINGS', 'Không có thi&#7871;t l&#7853;p nào &#273;&#432;&#7907;c áp d&#7909;ng.');
DEFINE ('_UDDEIM_ABOUT', 'About'); // as in "About uddeIM"
DEFINE ('_UDDEIM_COMPOSE', 'So&#7841;n tin'); // as in "write new message", but only one word
DEFINE ('_UDDEIM_EMN', 'Thông báo qua Email');
DEFINE ('_UDDEIM_EMN_EXP', 'C&#7845;u hình thông báo tin nh&#7855;n m&#7899;i.');
DEFINE ('_UDDEIM_EMN_ALWAYS', 'Thông báo qua email n&#7871;u có tin nh&#7855;n m&#7899;i');
DEFINE ('_UDDEIM_EMN_NONE', 'Không thông báo qua email');
DEFINE ('_UDDEIM_EMN_WHENOFFLINE', 'Thông báo qua email khi không online');
DEFINE ('_UDDEIM_EMN_NOTONREPLY', 'Không g&#7917;i thông báo v&#7899;i các th&#432; tr&#7843; l&#7901;i');
DEFINE ('_UDDEIM_BLOCKSYSTEM', 'Ch&#7863;n thành viên'); // Headline for blocking system in settings
DEFINE ('_UDDEIM_BLOCKSYSTEM_EXP', 'B&#7841;n có th&#7875; ch&#7863;n các thành viên &#273;&#7875; ng&#259;n h&#7885; g&#7917;i tin nh&#7855;n t&#7899;i b&#7841;n. Ch&#7885;n <b>ch&#7863;n</b> khi b&#7841;n xem tin nh&#7855;n t&#7915; h&#7885;.'); // block user is the same as _UDDEIM_BLOCKNOW
DEFINE ('_UDDEIM_SAVECHANGE', 'L&#432;u thay &#273;&#7893;i');
DEFINE ('_UDDEIM_TOOLTIP_BOLD', 'BB code tags to produce bold text. Usage: [b]bold[/b]');
DEFINE ('_UDDEIM_TOOLTIP_ITALIC', 'BB code tags to produce italic text. Usage: [i]italic[/i]');
DEFINE ('_UDDEIM_TOOLTIP_UNDERLINE', 'BB code tags to produce underlined text. Usage: [u]underline[/u]');
DEFINE ('_UDDEIM_TOOLTIP_COLORRED', 'BB code tags to produce coloured letters. Usage [color=#XXXXXX]colored[/color] where XXXXXX is the hex code of the colour you want, for example FF0000 for red.');
DEFINE ('_UDDEIM_TOOLTIP_COLORGREEN', 'BB code tags to produce coloured letters. Usage [color=#XXXXXX]colored[/color] where XXXXXX is the hex code of the colour you want, for example 00FF00 for green.');
DEFINE ('_UDDEIM_TOOLTIP_COLORBLUE', 'BB code tags to produce coloured letters. Usage [color=#XXXXXX]colored[/color] where XXXXXX is the hex code of the colour you want, for example 0000FF for blue.');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE1', 'BB code tags to produce very small letters. Usage: [size=1]very small text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE2', 'BB code tags to produce small letters. Usage: [size=2] small text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE4', 'BB code tags to produce big letters. Usage: [size=4]big text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE5', 'BB code tags to produce very big letters. Usage: [size=5]very big text.[/size]');
DEFINE ('_UDDEIM_TOOLTIP_IMAGE', 'BB code tags to insert a link to an image. Usage: [img]Image-URL[/img]');
DEFINE ('_UDDEIM_TOOLTIP_URL', 'BB code tags to insert a hyperlink. Usage: [url]web address[/url]. Do not forget the http:// at the beginning of the web address.');
DEFINE ('_UDDEIM_TOOLTIP_CLOSEALLTAGS', 'Close all open BB code tags.');
