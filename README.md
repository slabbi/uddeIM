## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)

## General info
This project was created by a great Joomla and Joomlapolis (Community Builder) contributor @slabbi (https://github.com/slabbi).
With this repository we want to help to keep this great project updated to work with all versions of Joomla
	
## Technologies
Project is created with:
* Mambo 1.x
* Joomla version: 1.x
* Joomla version: 2.x
* Joomla version: 3.x
* Joomla version: 4.1.x

* Community Builder version: X.y

All Joomla versions work with diffrent PHP and mostly mySQL versions out there.
Of course, we recommend to stay updated, so please update your Joomla to the most recent version.
	
## Setup
To run this project, You need a Joomla CMS system. You will need to install the packages according to the Joomla version you have.

#### PLEASE READ THE FAQ FOR MORE INFORMATION! (https://github.com/slabbi/uddeIM/blob/main/README/FAQ.pdf)

Install com_uddeim (_j16, _j30) with the component installer and create a link in the menu for registered users (set the access level to "public users" when you plan to enable uddeIM's public frontend feature) to this component.

Please read "README uddeIM x.x" for more information.


####NOTE:
A package without "_" suffix can be used with Joomla 1.0 and 1.5 only! The suffix "_j16" indicates that this package can be used with Joomla 1.6, 1.7 and 2.5. The suffix "_j30" indicates that this package can be used with Joomla 3.0 and above.
Community Builder ("cb_" and "cb2_") packages can be used with all Joomla versions.

com_uddeim        the main component for Joomla 1.0, 1.5
com_uddeim_j16    the main component for Joomla 1.6, 1.7, 2.5
com_uddeim_j30    the main component for Joomla 3.0, 3.1, 3.2


###com_uddeim - COMPONENT
com_uddeim        uddeIM - the main component

###mod_uddeim - MODULE
A message notifier module. Install this module with the module installer. The module provides popup notifications introduced with uddeIM 0.8.

###mod_uddeim_mailbox (MODULE)
A mailbox module for uddeIM. Install this module with the module installer. The module shows some statistics and links to the inbox, outbox, trashcan, archive, settings and compose form.
Note: This module does several database queries. Do not install when you have performance problems on your server.

###mod_uddeim_statistics (MODULE)
A statistics module for uddeIM. Install this module with the module installer. The module shows some statistics about numbers of PMs written with uddeIM (all, last 7/30/365 days).
Note: This module does several database queries. Do not install when you have performance problems on your server.

###Mambo

####plug_uddeim_contentlink (MAMBOT/PLUGIN)
A content mambot/plugin which creates a simple link allowing to compose a message to a certain user. Please refer to the FAQ for more information about this Joomla plugin.

####plug_uddeim_searchbot (MAMBOT/PLUGIN)
A search mambot/plugin which integrates uddeIM into Joomla search. Note: It does not search inside obfuscated, encrypted or encoded messages. Please refer to the FAQ for more information about this Joomla plugin.

###plug_uddeim_hooks (PLUGIN)
A system plugin which enables the uddeIM hook mechanism. Please refer to the FAQ for more information about this Joomla plugin.

###Commnity Builder
####Community Builder PMS Plugin

cb_plug_pms_uddeim                 (COMMUNITY BUILDER 1.x PLUGIN)
cb2_plug_pms_uddeim                (COMMUNITY BUILDER 2.x PLUGIN)

A plugin for the Community Builder that allows to send a "Quick message" from a user's profile. Install this with the plugin installer in CB. You have also to publish and configure a tab in CB.

Note: This plugin does currently not recognize the timedelay and CAPTCHA settings. So do only use the "Quick message" feature when you do not need CAPTCHA or timedelay protection.

You can also use plug_pms_mypmspro instead (note that it does not offer all features of plug_pms_uddeim).
plug_pms_uddeim is the uddeIM-only (extended) version of plug_pms_mypmspro.

####Community Builder PMS Inbox Plugin

cb_plug_pms_uddeim_inbox           (COMMUNITY BUILDER 1.x PLUGIN)
cb2_plug_pms_uddeim_inbox          (COMMUNITY BUILDER 2.x PLUGIN)

A plugin for the Community Builder that shows the content of the inbox in a profile tab. Install this with the plugin installer in CB and you have also to publish and configure a tab in CB.

####Community Builder PMS Blocking Plugin

cb_plug_pms_uddeim_blocking        (COMMUNITY BUILDER 1.x PLUGIN)
cb2_plug_pms_uddeim_blocking       (COMMUNITY BUILDER 2.x PLUGIN)

This plugin adds a "Blocking" tab so you can block and unblock users quite easy. Note that the same functionality is already implemented in the uddeIM main component (to block a user open a message and choose "block user", to unblock users open the settings and choose the users you want to unblock).

####Community Builder PMS Profile link Plugin
cb_plug_pms_uddeim_profilelink     (COMMUNITY BUILDER 1.x PLUGIN)
cb2_plug_pms_uddeim_profilelink    (COMMUNITY BUILDER 2.x PLUGIN)

This plugin adds a simple link that points to the uddeIM compose page to the users' profile page. Please read the FAQ for more information about this plugin (you may also use CB's field substitution feature for that).

###Templates
uddeim_templates (ADDITIONAL TEMPLATES)
Templates for uddeIM. Upload these templates into \components\com_uddeim\templates\


##Important:

Check the README folder and read the README before you install uddeIM!

There is also a comprehensive FAQ (https://github.com/slabbi/uddeIM/blob/main/README/FAQ.pdf) that explains most problems:
 - SQL error messages
 - problems with the character encoding
 - and lots of more...

