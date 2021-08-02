<?php
// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2010 Stephan Slabihoud, © 2006 Benjamin Zweifel
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************
//                This code uses portions of the bbcode script from phpBB (C) 2001 The phpBB Group
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

function uddeIMbbcode_replace($string, $config) {

	if($config->allowbb > 0) {
	
		// replace font formatting [b] [i] [u] [color= [size=
		// bold
    	$string = preg_replace("/(\[b\])(.*?)(\[\/b\])/si","<span style=\"font-weight: bold\">\\2</span>",$string);

		// underline
    	$string = preg_replace("/(\[u\])(.*?)(\[\/u\])/si","<span style=\"text-decoration: underline\">\\2</span>",$string);

		// italic
		$string = preg_replace("/(\[i\])(.*?)(\[\/i\])/si","<span style=\"font-style: italic\">\\2</span>",$string);

		// ol
		$string = preg_replace("/(\[ol\])(.*?)(\[\/ol\])/si","<ol>\\2</ol>",$string);
		// ul
		$string = preg_replace("/(\[ul\])(.*?)(\[\/ul\])/si","<ul>\\2</ul>",$string);
		// li
		$string = preg_replace("/(\[li\])(.*?)(\[\/li\])/si","<li>\\2</li>",$string);

		// max size is 7
		$string = preg_replace("/\[size=([1-7])\](.+?)\[\/size\]/si","<font size=\\1\">\\2</font>",$string);

		// color
		$string = preg_replace("%\[color=#(.{1,6}?)\](.*?)\[/color\]%si","<span style=\"color: #\\1\">\\2</span>",$string);
	
		// more font formatters opened than closed
//		do {
//			$string.="</span>";
			// close them
//		} while (substr_count($string,"<span") > substr_count($string,"</span>"));
		while (substr_count($string,"<span") > substr_count($string,"</span>")) {
			$string.="</span>";
		}

		// more font formatters closed than opened (less likely case)	
//		do {
//			$string="<span>".$string;
			// add a dummy container to balance that out
//		} while (substr_count($string,"<span") < substr_count($string,"</span>"));
		while (substr_count($string,"<span") < substr_count($string,"</span>")) {
			$string="<span>".$string;
		}
	}

	if($config->allowbb > 1) {

		// http, https, ftp, mailto
		$passes = Array();
		$passes[] = "url";
		$passes[] = "topurl";

		foreach ($passes as $pass) {
			$string=str_replace("[".$pass."=index.php", "#*#LINK".$pass."INDEX=#*#", $string);
			$string=str_replace("[".$pass."=http://", "#*#LINK".$pass."HTTP=#*#", $string);
			$string=str_replace("[".$pass."=ftp://", "#*#LINK".$pass."FTP=#*#", $string);
			$string=str_replace("[".$pass."=file://", "#*#LINK".$pass."FILE=#*#", $string);
			$string=str_replace("[".$pass."=https://", "#*#LINK".$pass."HTTPS=#*#", $string);
			$string=str_replace("[".$pass."=mailto:", "#*#LINK".$pass."MAILTO=#*#", $string);	

			$string=str_replace("[".$pass."]index.php", "#*#LINK".$pass."INDEX]#*#", $string);		
			$string=str_replace("[".$pass."]http://", "#*#LINK".$pass."HTTP]#*#", $string);
			$string=str_replace("[".$pass."]ftp://", "#*#LINK".$pass."FTP]#*#", $string);
			$string=str_replace("[".$pass."]file://", "#*#LINK".$pass."FILE]#*#", $string);
			$string=str_replace("[".$pass."]https://", "#*#LINK".$pass."HTTPS]#*#", $string);
			$string=str_replace("[".$pass."]mailto:", "#*#LINK".$pass."MAILTO]#*#", $string);				

			$string=str_replace("[".$pass."]", "[".$pass."]http://", $string);
			$string=str_replace("[".$pass."=", "[".$pass."=http://", $string);
			
			$string=str_replace("#*#LINK".$pass."HTTP=#*#", "[".$pass."=http://", $string);
			$string=str_replace("#*#LINK".$pass."FTP=#*#", "[".$pass."=ftp://", $string);
			$string=str_replace("#*#LINK".$pass."FILE=#*#", "[".$pass."=file://", $string);
			$string=str_replace("#*#LINK".$pass."HTTPS=#*#", "[".$pass."=https://", $string);
			$string=str_replace("#*#LINK".$pass."MAILTO=#*#", "[".$pass."=mailto:", $string);			
			$string=str_replace("#*#LINK".$pass."INDEX=#*#", "[".$pass."=index.php", $string);			
						
			$string=str_replace("#*#LINK".$pass."HTTP]#*#", "[".$pass."]http://", $string);
			$string=str_replace("#*#LINK".$pass."FTP]#*#", "[".$pass."]ftp://", $string);
			$string=str_replace("#*#LINK".$pass."FILE]#*#", "[".$pass."]file://", $string);
			$string=str_replace("#*#LINK".$pass."HTTPS]#*#", "[".$pass."]https://", $string);
			$string=str_replace("#*#LINK".$pass."MAILTO]#*#", "[".$pass."]mailto:", $string);
			$string=str_replace("#*#LINK".$pass."INDEX]#*#", "[".$pass."]index.php", $string);		
		}
		
		$string = preg_replace("/\[img size=([0-9][0-9][0-9])\](http\:\/\/.*?)\[\/img\]/si","[#*#img size=$1]$2[/#*#img]",$string);
		$string = preg_replace("/\[img size=([0-9][0-9])\](http\:\/\/.*?)\[\/img\]/si","[#*#img size=$1]$2[/#*#img]",$string);
		$string = preg_replace("/\[img\](http\:\/\/.*?)\[\/img\]/si","[#*#img]$1[/#*#img]",$string);

		$string = preg_replace("/\[img size=([0-9][0-9][0-9])\](.*?)\[\/img\]/si","[img size=$1]http://$2[/img]",$string);
		$string = preg_replace("/\[img size=([0-9][0-9])\](.*?)\[\/img\]/si","[img size=$1]http://$2[/img]",$string);
		$string = preg_replace("/\[img\](.*?)\[\/img\]/si","[img]http://$1[/img]",$string);
		
		$string = str_replace("[#*#img", "[img", $string);
		$string = str_replace("[/#*#img", "[/img", $string);
		
		// ul li replacements
        // $string = preg_replace("/(\[ul\])(.*?)(\[\/ul\])/si","<ul>\\2</ul>",$string);
        // $string = preg_replace("/(\[ol\])(.*?)(\[\/ol\])/si","<ol type=1>\\2</ol>",$string);
        // $string = preg_replace("/(\[li\])(.*?)(\[\/li\])/si","<li>\\2</li>",$string);

        // make regular HTML URL links targets _blank, bbCode URL translation
		// this is very bad: since when we have two links (a link without comprofiler and a link with comprofiler) this matches both
		// but it is even worse when we do not remove javascript links...
        $string = preg_replace('/\[(top)?url\](.*?)javascript(.*?)\[\/\\1url\]/si','<span style=\'text-decoration: line-through\'>javascript link</span>',$string);
        $string = preg_replace('/\[(top)?url=(.*?)javascript(.*?)\](.*?)\[\/\\1url\]/si','<span style=\'text-decoration: line-through\'>javascript link</span>',$string);

		// if comprofiler in link, make link to top instead of blank
		// this is very bad: since when we have two links (a link without comprofiler and a link with comprofiler) this matches both
		// $string = preg_replace("/\[url\](.*?)comprofiler(.*?)\[\/url\]/si","<a href=\\1comprofiler\\2 target=\"_top\">\\1comprofiler\\2</a>",$string);
		// $string = preg_replace("/\[url=(.*?)comprofiler(.*?)\](.*?)\[\/url\]/si","<a href=\"\\1comprofiler\\2\" target=\"_top\">\\3</a>",$string);	
	
		// now the rest of the links to blank
        $string = preg_replace("/\[url\](.*?)\[\/url\]/si", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $string);
        $string = preg_replace("/\[url=(.*?)\](.*?)\[\/url\]/si", "<a href=\"\\1\" target=\"_blank\">\\2</a>", $string);	
        $string = preg_replace("/\[topurl\](.*?)\[\/topurl\]/si", "<a href=\"\\1\">\\1</a>", $string);
        $string = preg_replace("/\[topurl=(.*?)\](.*?)\[\/topurl\]/si", "<a href=\"\\1\">\\2</a>", $string);	
	
		// img replacement
        $string = preg_replace("/\[img size=([0-9][0-9][0-9])\](.*?)\[\/img\]/si", "<img src=\"$2\" border=\"0\" width=\"$1\" />", $string);
        $string = preg_replace("/\[img size=([0-9][0-9])\](.*?)\[\/img\]/si", "<img src=\"$2\" border=\"0\" width=\"$1\" />", $string);
        $string = preg_replace("/\[img\](.*?)\[\/img\]/si", "<img src=\"$1\" border=\"0\" />", $string);
        $string = preg_replace("/<img(.*?)javascript(.*?)>/si", '<span style=\'text-decoration: line-through\'>javascript link</span>', $string);	

	}

	return $string;
	
}
	
function uddeIMsmile_replace($string, $config) {	
	$pathtouser  = uddeIMgetPath('user');
	$pathtosite  = uddeIMgetPath('live_site');

	// now replace smilies if that option is turned on 
	// Use Joomlaboard smilies if that is installed, otherwise uddeim's

	$iconfolder="images";
	if ($config->animated) {
		$iconfolder="animated"; }

	$message_emoticons=array(
      ":))"        => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_laughing.gif"  alt="" border="0" align="middle" />',		
	  ":D"         => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_laughing.gif"  alt="" border="0" align="middle" />',		
      ":*"         => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_heart.gif"     alt="" border="0" align="middle" />',
      ":?"         => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_wondering.gif" alt="" border="0" align="middle" />',
      ":x"         => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_crossed.gif"   alt="" border="0" align="middle" />',
      "B)"         => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_cool.gif"      alt="" border="0" align="middle" />',
      ":("         => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_sad.gif"       alt="" border="0" align="middle" />',
      ":)"         => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_smile.gif"     alt="" border="0" align="middle" />',
      ":-("        => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_sad.gif"       alt="" border="0" align="middle" />',
      ":-)"        => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_smile.gif"     alt="" border="0" align="middle" />',
      ":laugh:"    => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_laughing.gif"  alt="" border="0" align="middle" />',
      ":grin:"     => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_laughing.gif"  alt="" border="0" align="middle" />',
      ";)"         => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_wink.gif"      alt="" border="0" align="middle" />',
      ";-)"        => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_wink.gif"      alt="" border="0" align="middle" />',
      ":P"         => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_tongue.gif"    alt="" border="0" align="middle" />',
      ":mad:"      => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_angry.gif"     alt="" border="0" align="middle" />',
      ":angry:"    => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_angry.gif"     alt="" border="0" align="middle" />',
      ":ohmy:"     => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_shocked.gif"   alt="" border="0" align="middle" />',
	  ":o"         => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_shocked.gif"   alt="" border="0" align="middle" />',
      ":shock:"    => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_shocked.gif"   alt="" border="0" align="middle" />',
      ":blush:"    => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_blush.gif"     alt="" border="0" align="middle" />',
      ":kiss:"     => '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/emoticon_kiss.gif"      alt="" border="0" align="middle" />',
      );

	if ($config->animatedex) { 
		$iconfolder="animated-extended";
		$smileys = $pathtouser."/templates/".$config->templatedir."/".$iconfolder."/";
		if (is_dir($smileys)) {
			$folder=opendir ($smileys); 
			while ($file = readdir ($folder)) {
				if($file != "." && $file != ".." && (substr($file, strrpos($file, '.'))=='.gif')) {
					$ext = strrchr($file, '.');
					if($ext !== false) {
						$noextname = substr($file, 0, -strlen($ext));
					} else {
						$noextname = $file;
					}
					$name = ":".$noextname.":";
					$message_emoticons[$name] = '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/'.$iconfolder.'/'.$noextname.'.gif" alt="" border="0" align="middle" />';
				}
			}
			closedir($folder);
		}
	}
	  
	reset($message_emoticons);
	while (list($emo_txt,$emo_src)=each($message_emoticons)) {
		$string=str_replace($emo_txt,$emo_src,$string);
	}
	return $string;
}

function uddeIMbbcode_strip($string) {

	// bold
    $string = preg_replace("/(\[b\])(.*?)(\[\/b\])/si", "\\2", $string);

	// underline
    $string = preg_replace("/(\[u\])(.*?)(\[\/u\])/si", "\\2", $string);

	// italic
	$string = preg_replace("/(\[i\])(.*?)(\[\/i\])/si", "\\2", $string);

	// size Max size is 7
	$string = preg_replace("/\[size=([1-7])\](.+?)\[\/size\]/si", "\\2", $string);

	// color
	$string = preg_replace("%\[color=(.*?)\](.*?)\[/color\]%si", "\\2", $string);
	
	// ul li replacements
	$string = preg_replace("/(\[ul\])(.*?)(\[\/ul\])/si", "\\2", $string);
	$string = preg_replace("/(\[ol\])(.*?)(\[\/ol\])/si", "\\2", $string);
	$string = preg_replace("/(\[li\])(.*?)(\[\/li\])/si", "\\2\\n", $string);
	
	// sanitize javascript
	$string = preg_replace("/\[(top)?url\](.*?)javascript(.*?)\[\/\\1url\]/si", "", $string);
	$string = preg_replace("/\[(top)?url=(.*?)javascript(.*?)\](.*?)\[\/\\1url\]/si", "", $string);

	// convert urls
	$string = preg_replace("/\[(top)?url\](.*?)\[\/\\1url\]/si", "\\2", $string);
	$string = preg_replace("/\[(top)?url=(.*?)\](.*?)\[\/\\1url\]/si", "\\3 (\\2)", $string);	
	
	// only front tag present
	$string = preg_replace("/\[(top)?url=(.*?)\]/si","",$string);	
	
	// img replacement
	$string = preg_replace("/\[img size=([0-9][0-9][0-9])\](.*?)\[\/img\]/si", "", $string);
	$string = preg_replace("/\[img size=([0-9][0-9])\](.*?)\[\/img\]/si", "", $string);
	$string = preg_replace("/\[img\](.*?)\[\/img\]/si", "", $string);
	$string = preg_replace("/<img(.*?)javascript(.*?)>/si", '', $string);	

	// only front tag present
	$string = preg_replace("/\[img size=([0-9][0-9][0-9])\]]/si", "", $string);
	$string = preg_replace("/\[img size=([0-9][0-9])\]]/si", "", $string);
	
	// cut remaining single tags
	$string = str_replace("[i]", "", $string);
	$string = str_replace("[/i]", "", $string);
	$string = str_replace("[b]", "", $string);
	$string = str_replace("[/b]", "", $string);
	$string = str_replace("[u]", "", $string);
	$string = str_replace("[/u]", "", $string);
	$string = str_replace("[ul]", "", $string);
	$string = str_replace("[/ul]", "", $string);
	$string = str_replace("[ol]", "", $string);
	$string = str_replace("[/ol]", "", $string);
	$string = str_replace("[li]", "", $string);
	$string = str_replace("[/li]", "", $string);

    $string = preg_replace("/\[(top)?url=(.*?)javascript(.*?)\]/si", "", $string);	
    $string = preg_replace("/\[img size=([0-9][0-9][0-9])\]/si", "", $string);
    $string = preg_replace("/\[img size=([0-9][0-9])\]/si", "", $string);
    $string = preg_replace("/\[size=([1-7])\]/si", "", $string);
    $string = preg_replace("/\[color=(.*?)\]/si", "", $string);
    $string = preg_replace("/\[(top)?url\]/si", "", $string);	
    $string = preg_replace("/\[\/(top)?url\]/si", "", $string);	
	$string = str_replace("[img]", "", $string);
	$string = str_replace("[/img]", "", $string);
	$string = str_replace("[/color]", "", $string);
	$string = str_replace("[/size]", "", $string);		

	return $string;
}
