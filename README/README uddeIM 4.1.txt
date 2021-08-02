====================================================================================================
HOW TO INSTALL / UPDATE - read below for update instructions
====================================================================================================
Joomla 1.5 users please read "INSTALLATION (JOOMLA 1.5+)" in the FAQ before installing uddeIM.
====================================================================================================
Joomla 1.6 - 3.6 users please read "INSTALLATION (JOOMLA 1.6+)" in the FAQ before installing uddeIM.
====================================================================================================

IMPORTANT: There is a comprehensive FAQ in the README folder which gives lots of more
           information about the first installation and the upgrade of uddeIM.

CONTENT

 * HOW TO UPGRADE FROM UDDEIM 2.8-3.9 TO UDDEIM 4.0 (new method, using Joomla Extension Manager)
   - How to upgrade
   - Optional steps

 * HOW TO UPGRADE FROM UDDEIM 2.3-3.9 TO UDDEIM 4.0 (old method, manually)
   - How to upgrade
   - Optional steps

 * HOW TO UPGRADE FROM UDDEIM 2.2 OR EARLIER TO UDDEIM 4.0

 * FIRST INSTALL OF UDDEIM
   - Installation
   - Optional steps

 * HOW TO CREATE FOLDER "/uddeimfiles"
 * NOTES FOR DONATORS
 * APPENDIX A - Folder structure


====================================================================================================
HOW TO UPGRADE FROM UDDEIM 2.8-3.9 TO UDDEIM 4.0 (new method, using Joomla Extension Manager)
====================================================================================================

How to upgrade:
---------------

 1. a) Optional: Backup your uddeIM template (if you do not use uddeIM's default templates)

    b) Optional: Backup your database (at least all tables prefixed "uddeim", when using 
	             phpMyAdmin you can copy the tables given the copy a new name, e.g. jos_uddeim_backup).


 2. Backup your configuration using the internal backup function

        uddeIM backend -> Maintenance -> Backup

            or backup the config file:

        /administrator/components/com_uddeim/config.class.php


 3. Install uddeIM using Joomla's Extension Manager. The old installation of uddeIM should be
    overwritten with the new version. The database should be upgraded automatically when required.


 4. Restore your uddeIM template (from step 1, when you do not use uddeIM's default templates).


 5. Restore your configuration. When you have used the internal backup feature its just one click
    (uddeIM backend->Maintenance->Restore), otherwiese restore config.class.php from step 2. 
    After doing that it is important that you review the new added settings and save the new 
    configuration!


 6. Check Community Builder settings (it is not required to use CB with uddeIM but it is
    highly recommended for a community platform). There are uddeIM settings for the 
    "cblogin" module and "mypms" plugin of the Community Builder. When possible choose
    the uddeIM version you have installed otherwise the next lower version e.g. "uddeIM 2.3". 
	It is recommended to install the uddeIM specific modules (see the important note below).


 7. Check the menu link to uddeIM. When the Itemid to uddeIM is not valid, update the menu link
    or create a new one.


When the upgrade process fails or uddeIM does not work as expected please upgrade uddeIM 
manually again.



====================================================================================================
HOW TO UPGRADE FROM UDDEIM 2.3-3.9 TO UDDEIM 4.0 (old method, manually)
====================================================================================================

How to upgrade:
---------------

 1. a) Optional: Backup your uddeIM template (if you do not use uddeIM's default templates)

    b) Optional: Backup your database (at least all tables prefixed "uddeim", when using 
	             phpMyAdmin you can copy the tables given the copy a new name, e.g. jos_uddeim_backup).


 2. Backup your configuration using the internal backup function

        uddeIM backend -> Maintenance -> Backup

            or backup the config file:

        /administrator/components/com_uddeim/config.class.php

    I recommend to uninstall the previous version of uddeIM and then upgrade to the new version
    using the component installer, so above is required to restore your settings.

    When you are an experienced user you can also overwrite the existing files with the new
    files from the archive. Please check Appendix A for the correct folder structure
    (please check if there are new files which have to be uploaded).

    Joomla 1.6 users: You can update the component usind the component installer. There is no need
    need to deinstall the old version first. Nevertheless you have to update the database manually
    (see next step).
	

 3. Update your database tables (go to phpMyAdmin and enter following SQL statements in the SQL box, 
    this will create the missing fields).

    You will find a short tutorial in the FAQ (chapter 1.3.x "How can I upgrade uddeIM’s tables?").


    When you upgrade 2.3 - 3.9 to 4.0:
    ==================================
        nothing to do



 4. Install uddeIM. When you have installed uddeIM using the Joomla installer it should have created
    a folder "/images/uddeimfiles" containing two files (".htaccess" and ".index.html").

    If this folder is not present uddeIM has no write access to the Joomla root folder.
    In that case you should create this folder manually, see chapter 
	"HOW TO CREATE FOLDER '/images/uddeimfiles'"


 5. Restore your uddeIM template (from step 1, when you do not use uddeIM's default templates).

    ATTENTION:

    There might be new icons (depending on the version of uddeIM you are updating from):
        \components\com_uddeim\templates\default\images\disk.gif
        \components\com_uddeim\templates\default\images\envelope.gif
        \components\com_uddeim\templates\default\images\envelope_deleted.gif
        \components\com_uddeim\templates\default\images\staron.gif
        \components\com_uddeim\templates\default\images\staroff.gif
        \components\com_uddeim\templates\default\images\icon_spam.gif
        \components\com_uddeim\templates\default\images\icon_updown.gif
        \components\com_uddeim\templates\default\images\icon_up.gif
        \components\com_uddeim\templates\default\images\icon_down.gif
        \components\com_uddeim\templates\images\rss_logo.png

		New in uddeIM 2.3+:
        \components\com_uddeim\templates\images\uddeim-favicon.png
        \components\com_uddeim\templates\images\delayed_im.gif

		New in uddeIM 2.6+:
        \components\com_uddeim\templates\default\images\icon_forward.gif

	When updating manually don't forget to upload these files!


 6. Restore your configuration. When you have used the internal backup feature its just one click
    (uddeIM backend->Maintenance->Restore), otherwiese restore config.class.php from step 2. 
    After doing that it is important that you review the new added settings and save the new 
    configuration!


 7. Check Community Builder settings (it is not required to use CB with uddeIM but it is
    highly recommended for a community platform). There are uddeIM settings for the 
    "cblogin" module and "mypms" plugin of the Community Builder. When possible choose
    the uddeIM version you have installed otherwise the next lower version e.g. "uddeIM 2.3". 
	It is recommended to install the uddeIM specific modules (see the important note below).


 8. Check the menu link to uddeIM. Usually you have to update the link (Joomla 1.5+) or you
    have to re-create the link (Joomla 1.0) so the Itemid to uddeIM is valid.

    On existing Joomla 1.0 sites use "Database maintanance->Repair" to add a missing menu 
    icon without reinstalling the component.


 Optional: When you want to use message obfuscating check the "key" which can be set in uddeIM
           administration. Default is "uddeIMcryptkey" but it can be changed to whatever you 
           like. This "key" is used to obfuscate all new messages.
           You cannot change this value later. You have to set it before the first new message 
           has been written and obfuscating of messages is enabled in the preferences.



====================================================================================================
HOW TO UPGRADE FROM UDDEIM 2.2 OR EARLIER TO UDDEIM 4.0
====================================================================================================

Upgrades from uddeIM 2.2 and below are not longer supported and explained in this document.

 1. When upgrading from uddeIM 1.7+ please upgrade to uddeIM 2.8 using the instructions found in 
    uddeIM 2.8 package first before upgrading to uddeIM 3.9.

 2. When you are upgrading from uddeIM 1.6 or earlier use the instructions found in uddeIM 1.7 
    package first before upgrading to 2.8 and from there to a newer one.



====================================================================================================
FIRST INSTALL OF UDDEIM
====================================================================================================

Installation:
-------------

 1. Use the Joomla installer to install this component.


 2. Check the configuration in the backend before starting to use uddeIM.
    Configuration setting printed in red are not available since a component is not
    installed on your system (e.g. Community Builder).
	

 3. Check Community Builder settings (it is not required to use CB with uddeIM but it is
    highly recommended for a community platform). There are uddeIM settings for the 
    "cblogin" module and "mypms" plugin of the Community Builder. When possible choose
    "uddeIM 2.8" otherwise the next lower version e.g. "uddeIM 1.3". It is recommended 
    to install the uddeIM specific modules (see the important note below).


 4. Check if uddeIM has created a folder "/images/uddeimfiles" containing two files 
    (".htaccess" and ".index.html").
    If this folder is not present uddeIM has no write access to "/images". In that case 
	you should create this folder manually, see chapter
	"HOW TO CREATE FOLDER '/images/uddeimfiles'"


 5. Create a menu link to uddeIM. This is important because uddeIM requires a unique Itemid.
    When you want to use the public front end feature set public access for the menu link 
	otherwise set registered access.


 Optional: When you want to use message obfuscating check the "key" which can be set in uddeIM
           administration. Default is "uddeIMcryptkey" but it can be changed to whatever you 
           like. This "key" is used to obfuscate all new messages.
           You cannot change this value later. You have to set it before the first new message 
           has been written and obfuscating of messages is enabled in the preferences.



====================================================================================================
HOW TO CREATE FOLDER "/images/uddeimfiles"
====================================================================================================

Create a folder "uddeimfiles" in "/images" and set the access rights that Joomla can access it. 
When you are unsure use "0777" (usually 0766 should be fine).

To ensure that people do not access this directory directly, you should create
following files (you will also find these files in the "SUPPORT" folder in the
premium plugin package):

index.html
----------
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html><head></head><body></body></html>

.htaccess
---------
# Having a .htaccess prevents users from directly
# accessing the files in your /images/uddeimfiles folder
#
deny from all

Since uddeIM uses temporary names for file attachments stored in the file system,
both files are not explicitely required when the directory is not displayed by default
(Options +Indexes).

To improve security you can add "Options -Indexes" to the ".htaccess" file
(when your server allows doing this).



====================================================================================================
NOTES FOR DONATORS
====================================================================================================

When upgrading uddeIM you have to reinstall the premium plugins. If you forget how to do that, 
check the FAQ or the README provided with the premium plugin package. 

You don't have to reinstall the premium plugins:
- when you install a "hotfix" for uddeIM (except it is explicitly mentioned)
- you are an experienced user and overwrite the existing files with the new files from the archive 
  when upgrading (e.g. upgrading from 2.3 to 4.0).



====================================================================================================
APPENDIX A - Folder structure
====================================================================================================

In /components/com_uddeim/

	uddeim.php
	inbox.php
	outbox.php
	archive.php
	trashcan.php
	userlists.php
	includes.php
	includes.db.php
	bbparser.php
	crypt.class.php
	getpiclink.php
	cb_extra.php
	json.php
	index.html
	uddeim_igoogle.xml
	recaptchalib.php
	captcha.php
	captcha15.php
	uddeimlib10.php
	uddeimlib15.php
	uddeimlib16.php
	uddeimlib17.php
	uddeimlib25.php
	uddeimlib30.php
	uddeimlib31.php
	uddeimlib32.php
	uddeimlib33.php
	uddeim.api.php
	uddeim.xml
	monofont.ttf
	js/*
	templates/*

	Optional:

	pfrontend.php
	rss.php
	attachment.php
	postbox.php



In /administrator/components/com_uddeim/

	admin.uddeim.php
	admin.shared.php
	admin.includes.php
	admin.usersettings.php
	admin.uddeimlib10.php
	admin.uddeimlib15.php
	admin.uddeimlib16.php
	admin.uddeimlib17.php
	admin.uddeimlib25.php
	admin.uddeimlib30.php
	admin.uddeimlib31.php
	admin.uddeimlib32.php
	admin.uddeimlib33.php
	toolbar.uddeim.php
	install.uddeim.php
	uninstall.uddeim.php
	config.class.php
	uddeim.xml (Joomla 1.0)
	uddeim.j15.xml (Joomla 1.5)
	index.html
	language/*
	language.utf8/*

	Optional:

	admin.spamcontrol.php
	admin.mcp.php
