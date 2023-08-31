CREATE TABLE IF NOT EXISTS `#__uddeim` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `replyid` int(11) NOT NULL default '0',
  `fromid` int(11) NOT NULL default '0',
  `toid` int(11) NOT NULL default '0',
  `message` text NOT NULL,
  `datum` int(11) default NULL,
  `toread` int(1) NOT NULL default '0',
  `totrash` int(1) NOT NULL default '0',
  `totrashdate` int(11) default NULL,
  `totrashoutbox` int(1) NOT NULL default '0',
  `totrashdateoutbox` int(11) default NULL,
  `expires` int(11) NOT NULL default '0',
  `disablereply` int(1) NOT NULL default '0',  
  `systemflag` int(1) NOT NULL default '0',
  `delayed` int(1) NOT NULL default '0',
  `systemmessage` varchar(60) default NULL,
  `archived` int(1) NOT NULL default '0',    
  `cryptmode` int(1) NOT NULL default '0',
  `flagged` int(1) NOT NULL default '0',
  `crypthash` varchar(32) default NULL,
  `publicname` text default NULL,
  `publicemail` text default NULL,
  PRIMARY KEY  (`id`),
  KEY `toid_toread` (`toid`,`toread`),
  KEY `fromid` (`fromid`),
  KEY `replyid` (`replyid`),
  KEY `datum` (`datum`),
  KEY `totrashdate` (`totrashdate`),
  KEY `totrashdateoutbox_datum` ( `totrashdateoutbox` , `datum` ),
  KEY `toread_totrash_datum` (`toread`,`totrash`,`datum`),
  KEY `totrash_totrashdate` (`totrash`,`totrashdate`),
  KEY `archived_totrash_toid_datum` (`archived`,`totrash`,`toid`,`datum`),
  KEY `systemflag` (`systemflag`),
  KEY `delayed` (`delayed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__uddeim_blocks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `blocker` int(11) NOT NULL default '0',
  `blocked` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__uddeim_emn` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  `popup` int(1) NOT NULL default '0',
  `public` int(1) NOT NULL default '0',
  `remindersent` int(11) NOT NULL default '0',
  `lastsent` int(11) NOT NULL default '0',
  `autoresponder` INT(1) NOT NULL DEFAULT '0',
  `autorespondertext` TEXT NOT NULL,
  `autoforward` INT(1) NOT NULL DEFAULT '0',
  `autoforwardid` INT(1) NOT NULL DEFAULT '0',
  `locked` INT(1) NOT NULL DEFAULT '0',
  `moderated` INT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__uddeim_config` (
  `varname` tinytext NOT NULL,
  `value` tinytext NOT NULL,
  PRIMARY KEY  (`varname`(30))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__uddeim_userlists` (
   `id` int(11) NOT NULL auto_increment,
   `userid` int(11) NOT NULL default '0',
   `name` varchar(40) NOT NULL default '',
   `description` text NOT NULL,
   `userids` text NOT NULL,
   `global` int(1) NOT NULL default '0',
   PRIMARY KEY  (`id`),
   KEY `userid` (`userid`),
   KEY `global` (`global`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__uddeim_spam` (
   `id` int(10) unsigned NOT NULL auto_increment,
   `mid` int(11) NOT NULL default '0',
   `datum` int(11) default NULL,
   `reported` int(11) default NULL,
   `fromid` int(1) NOT NULL default '0',
   `toid` int(1) NOT NULL default '0',
   `message` TEXT NOT NULL,
   PRIMARY KEY  (`id`),
   KEY `mid` (`mid`),
   KEY `fromid` (`fromid`),
   KEY `toid` (`toid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__uddeim_attachments` (
   `id` int(10) unsigned NOT NULL auto_increment,
   `mid` int(1) NOT NULL default '0',
   `tempname` TEXT NOT NULL,
   `filename` TEXT NOT NULL,
   `fileid` varchar(32) NOT NULL,
   `size` int(1) NOT NULL default '0',
   `datum` int(11) default NULL,
   PRIMARY KEY  (`id`),
   KEY `mid` (`mid`),
   KEY `fileid` (`fileid`),
   KEY `datum` (`datum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
