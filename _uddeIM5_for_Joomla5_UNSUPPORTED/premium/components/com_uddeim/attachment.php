<?php
// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0, 1.5, 1.6, 1.7, 2.5
// Author         © 2007-2012 Stephan Slabihoud
// License        This plugin is published under copyright.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk.
//                Redistributing this file is not allowed.
// ********************************************************************************************
// Version 4.1
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

function uddeIMcheckPluginA() {
	return 7;
}

function uddeIMshowUploadButtons($config) {
	echo "<div class='uddeim-attachmentbox'>";
	$temp2 = uddeIMformatFilesize($config->maxsizeattachment);
	$temp = sprintf(_UDDEIM_ATTACHMENTS2, $temp2);
	echo "<p>".$temp."</p>";
	for ($i=1;$i<=$config->maxattachments;$i++) {
		echo "<input class='uddeim-attachment' type='file' name='uddeimfile[]' /><br />";
	}
	echo "</div>";
}

function uddeIMhandleAttachments(&$uploadfile_temppathname, &$uploadfile_original, &$uploadfile_id, &$uploadfile_size, &$uploadfile_error, $config) {
	$noerror = true;
	$uploadfile_temppathname = Array();
	$uploadfile_original = Array();
	$uploadfile_id = Array(); 
	$uploadfile_size = Array(); 
	$uploadfile_error = Array();
	if ($config->enableattachment) {
		$i = 0;

		$tmp_files = uddeIMmosGetParam ($_FILES, 'uddeimfile', array("tmp_name" => array()));

		foreach ($tmp_files["tmp_name"] as $key => $value) {
			$tmp_name 	= $tmp_files["tmp_name"][$key];
			$name 		= $tmp_files["name"][$key];
			$size 		= $tmp_files["size"][$key];
			$i++;

			$temp = pathinfo($name);
			$ext = "";
			if (isset($temp['extension']))
				$ext = $temp['extension'];

			$blocked_extensions = "php;php3;php4;php5;cgi;pl;phtml;shtml";
			$block = in_array($ext, explode(';', $blocked_extensions));

			$allowed_extensions = $config->allowedextensions;
			if ($allowed_extensions) {
				// when we have a whitelist, assume everything is blocked except these
				$block = !in_array($ext, explode(';', $allowed_extensions));
			}

			if ( $tmp_name && $block ) {

				if (file_exists($tmp_name))
					unlink($tmp_name);
				$uploadfile_error[$key] = -3;		// file type not allowed
				$noerror = false;

			} elseif ( $tmp_name && $size > $config->maxsizeattachment ) {

				if (file_exists($tmp_name))
					unlink($tmp_name);
				$uploadfile_error[$key] = -2;		// upload exceeds the max file size
				$noerror = false;

			} elseif ( $i<=$config->maxattachments && $tmp_name && $size > 0 ) {

				$uploadfile_original[$key] = $name;
				$temp = pathinfo($name);
				$ext = $temp['extension'];
				$filename = basename($name, ".".$ext);

				$uploaddir  = uddeIMgetPath('absolute_path')."/images/uddeimfiles";
				$id = md5(rand() * time());
				if (!$config->unprotectdownloads) {
					$uploadfile_temppathname[$key] = $uploaddir.'/file_'.date("Ymd").'_'.$id.'.'.$ext;
				} else {
					$uploadfile_temppathname[$key] = $uploaddir.'/'.$filename.'_'.$id.'.'.$ext;
				}

				if (!move_uploaded_file($tmp_name, $uploadfile_temppathname[$key])) {
					if (file_exists($uploadfile_temppathname[$key]))
						unlink($uploadfile_temppathname[$key]);
					if (file_exists($tmp_name))
						unlink($tmp_name);
					unset($uploadfile_temppathname[$key]);
					unset($uploadfile_original[$key]);
					$uploadfile_error[$key] = -1;		// something went wrong
					$noerror = false;
				} else {
					$uploadfile_size[$key] = $size;		// we need this
					$uploadfile_error[$key] = 1;		// upload was fine for that file
					$uploadfile_id[$key] = $id;
				}

			} else {
				// Nothing was uploaded, thats ok for us so we do not need an errorcode here or any variables
			}
		}
	}
	return $noerror;
}

function uddeIMsaveAttachments($insID, $uploadfile_temppathname, $uploadfile_original, $uploadfile_id, $uploadfile_size, $savedatum, $config) {
	$database = uddeIMgetDatabase();

	foreach ($uploadfile_temppathname as $key => $value) {
		// store only the name, not the complete path to the file
		$temp = basename($uploadfile_temppathname[$key]);
		$sql="INSERT INTO `#__uddeim_attachments` (mid, tempname, filename, fileid, size, datum) VALUES (".
			(int)$insID.", ".
			$database->Quote($temp).", ".
			$database->Quote($uploadfile_original[$key]).", ".
			$database->Quote($uploadfile_id[$key]).", ".
			(int)$uploadfile_size[$key].", ".
			(int)$savedatum.
			")";
		$database->setQuery($sql);
		if (!$database->execute())
			die("SQL error when attempting to save the attachment" . $database->stderr(true));
	}
}

function uddeIMpreSaveAttachments($uploadfile_temppathname, $uploadfile_original, $uploadfile_id, $uploadfile_size, $savedatum, $config) {
	$database = uddeIMgetDatabase();
	$insID = -1;	// its a dummy message ID used for temporary file markers
	foreach ($uploadfile_temppathname as $key => $value) {
		// store only the name, not the complete path to the file
		$temp = basename($uploadfile_temppathname[$key]);
		$sql="INSERT INTO `#__uddeim_attachments` (mid, tempname, filename, fileid, size, datum) VALUES (".
			(int)$insID.", ".
			$database->Quote($temp).", ".
			$database->Quote($uploadfile_original[$key]).", ".
			$database->Quote($uploadfile_id[$key]).", ".
			(int)$uploadfile_size[$key].", ".
			(int)$savedatum.
			")";
		$database->setQuery($sql);
		if (!$database->execute())
			die("SQL error when attempting to save the attachment" . $database->stderr(true));
	}
}

function uddeIMpreSaveAttachmentsFinish($config) {
	$database = uddeIMgetDatabase();
	$sql = "DELETE FROM `#__uddeim_attachments` WHERE mid=-1";
	$database->setQuery($sql);
	if (!$database->execute())
		die("SQL error when attempting to delete temporary attachment markers" . $database->stderr(true));
}

function uddeIMunlinkTempfiles($uploadfile_temppathname, $config) {
	if (count($uploadfile_temppathname)>0) {
		foreach ($uploadfile_temppathname as $key => $row) {
			if (file_exists($uploadfile_temppathname[$key]))
				unlink($uploadfile_temppathname[$key]);
		}
	}
}

function uddeIMshowAttachments($box, $item_id, $messageid, $config) {
	$database = uddeIMgetDatabase();
	$pathtosite = uddeIMgetPath('live_site');
	$uploaddir = uddeIMgetPath('absolute_path')."/images/uddeimfiles";

	$temp = "downloadInbox";
	if ($box=="outbox")
		$temp = "downloadOutbox";
	
	$sql = "SELECT * FROM `#__uddeim_attachments` WHERE mid=".(int)$messageid;
	$database->setQuery( $sql );
	$value = $database->loadObjectList();
	if (!$value)
		$value = Array();

	if (count($value)>0) {
		echo "<div class='uddeim-messageattachments'><table class='innermost' width='100%'><tr style='border:0px none !important;'><td style='border:0px none !important;' valign='top'>";
		echo "<table style='border:0px none !important; padding: 4px !important;'>";
		foreach ($value as $key => $row) {
			$pic = '<img src="'.$pathtosite.'/components/com_uddeim/templates/'.$config->templatedir.'/images/disk.gif" alt="'. _UDDEIM_DOWNLOAD .'" title="'. _UDDEIM_DOWNLOAD .'" />';

			if (!$config->unprotectdownloads) {
				if (class_exists('JHTML')) {
					// $link = "<a href='index.php?option=com_uddeim&task=".$temp."&Itemid=".$item_id."&messageid=".$row->mid."&fileid=".$row->id."&no_html=1'>";
					$link = "<a href='".uddeIMsefRelToAbs("index.php?option=com_uddeim&task=".$temp."&Itemid=".$item_id."&messageid=".$row->mid."&fileid=".$row->id."&no_html=1")."'>";
				} else {
					// $link = "<a href='index2.php?option=com_uddeim&task=".$temp."&Itemid=".$item_id."&messageid=".$row->mid."&fileid=".$row->id."&no_html=1'>";
					$link = "<a href='".uddeIMsefRelToAbs("index2.php?option=com_uddeim&task=".$temp."&Itemid=".$item_id."&messageid=".$row->mid."&fileid=".$row->id."&no_html=1")."'>";
				}
			} else {
				$link = "<a href='".$pathtosite."/images/uddeimfiles/".$row->tempname."'>";
			}

			$piclink = $link.$pic."</a>";
			$textlink = $link.$row->filename."</a>";

			if (file_exists($uploaddir."/".$row->tempname)) {
				echo "<tr style='border:0px none !important;'><td style='border:0px none !important;'>". $piclink ."</td><td style='border:0px none !important;'>".$textlink.     "</td><td style='border:0px none !important;'>(".uddeIMformatFilesize($row->size).")</td></tr>";
			} else {
				echo "<tr style='border:0px none !important;'><td style='border:0px none !important;'>". $pic     ."</td><td style='border:0px none !important;'>".$row->filename."</td><td >(".uddeIMformatFilesize($row->size).")</td><td>"._UDDEIM_ATT_FILEDELETED."</td></tr>";
			}
		}
		echo "</td></tr></table>";
		echo "</td></tr></table></div>";
	}
}

function uddeIMdownloadAttachments($box, $userid, $item_id, $messageid, $fileid, $config) {
	$database = uddeIMgetDatabase();

	$sql = "";
	if ($box=="downloadOutbox")
		$sql = "SELECT a.* FROM `#__uddeim_attachments` AS a LEFT JOIN `#__uddeim` AS b ON a.mid=b.id WHERE a.mid=".(int)$messageid." AND a.id=".(int)$fileid." AND b.fromid=".$userid;
	if ($box=="downloadInbox")
		$sql = "SELECT a.* FROM `#__uddeim_attachments` AS a LEFT JOIN `#__uddeim` AS b ON a.mid=b.id WHERE a.mid=".(int)$messageid." AND a.id=".(int)$fileid." AND b.toid=".$userid;

	if ($sql) {
		$database->setQuery( $sql );
		$value = $database->loadObjectList();
		if (!$value)
			$value = Array();

		if (count($value)>0) {

			foreach ($value as $key => $row) {
				
				$uploaddir  = uddeIMgetPath('absolute_path')."/images/uddeimfiles";
				if (file_exists($uploaddir."/".$row->tempname)) {

					$temp = pathinfo($row->filename);
					$ext = $temp['extension'];
					// $ct = "application/force-download";
					$ct = uddeIMext2mime($ext);

					// fix for IE catching or PHP bug issue
					header("Pragma: public");
					header("Expires: 0"); // set expiration time
					header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					// download
					header("Cache-Control: public");
					header("Content-Description: File Transfer");
					header("Content-Disposition: attachment; filename=\"".$row->filename."\"");
					header("Content-Type: ".$ct);
					header("Content-Transfer-Encoding: binary"); 
					header("Content-Length: ".(int)$row->size);
					error_reporting(0);
					ob_clean();
					// flush();
					readfile($uploaddir."/".$row->tempname);
					exit;	// only one file
				} else {
					echo _UDDEIM_ATT_FILENOTEXISTS;
					exit;
				}
			}
		} else {
			echo _UDDEIM_MESSAGENOACCESS;
		}
	}
	exit;
}

function uddeIMformatFilesize($bytes) {
	if ($bytes >= 1048576) {			// 1024^2
		$strbytes = sprintf("%1.1f", $bytes/1048576 )." "._UDDEADM_MBYTES;
	} else if ($bytes >= 1024) {		// 1024^1
		$strbytes = sprintf("%1.1f", $bytes/1024 )." "._UDDEADM_KBYTES;
	} else {
		$strbytes =  $bytes." "._UDDEADM_BYTES;
	}
	return $strbytes;
}

function uddeIMext2mime($ext) {
	$map = array(
		'3ds' => 'image/x-3ds',
		'BLEND' => 'application/x-blender',
		'C' => 'text/x-c++src',
		'CSSL' => 'text/css',
		'NSV' => 'video/x-nsv',
		'XM' => 'audio/x-mod',
		'Z' => 'application/x-compress',
		'a' => 'application/x-archive',
		'abw' => 'application/x-abiword',
		'abw.gz' => 'application/x-abiword',
		'ac3' => 'audio/ac3',
		'adb' => 'text/x-adasrc',
		'ads' => 'text/x-adasrc',
		'afm' => 'application/x-font-afm',
		'ag' => 'image/x-applix-graphics',
		'ai' => 'application/illustrator',
		'aif' => 'audio/x-aiff',
		'aifc' => 'audio/x-aiff',
		'aiff' => 'audio/x-aiff',
		'al' => 'application/x-perl',
		'arj' => 'application/x-arj',
		'as' => 'application/x-applix-spreadsheet',
		'asc' => 'text/plain',
		'asf' => 'video/x-ms-asf',
		'asp' => 'application/x-asp',
		'asx' => 'video/x-ms-asf',
		'au' => 'audio/basic',
		'avi' => 'video/x-msvideo',
		'aw' => 'application/x-applix-word',
		'bak' => 'application/x-trash',
		'bcpio' => 'application/x-bcpio',
		'bdf' => 'application/x-font-bdf',
		'bib' => 'text/x-bibtex',
		'bin' => 'application/octet-stream',
		'blend' => 'application/x-blender',
		'blender' => 'application/x-blender',
		'bmp' => 'image/bmp',
		'bz' => 'application/x-bzip',
		'bz2' => 'application/x-bzip',
		'c' => 'text/x-csrc',
		'c++' => 'text/x-c++src',
		'cc' => 'text/x-c++src',
		'cdf' => 'application/x-netcdf',
		'cdr' => 'application/vnd.corel-draw',
		'cer' => 'application/x-x509-ca-cert',
		'cert' => 'application/x-x509-ca-cert',
		'cgi' => 'application/x-cgi',
		'cgm' => 'image/cgm',
		'chrt' => 'application/x-kchart',
		'class' => 'application/x-java',
		'cls' => 'text/x-tex',
		'cpio' => 'application/x-cpio',
		'cpio.gz' => 'application/x-cpio-compressed',
		'cpp' => 'text/x-c++src',
		'cpt' => 'application/mac-compactpro',
		'crt' => 'application/x-x509-ca-cert',
		'cs' => 'text/x-csharp',
		'csh' => 'application/x-shellscript',
		'css' => 'text/css',
		'csv' => 'text/x-comma-separated-values',
		'cur' => 'image/x-win-bitmap',
		'cxx' => 'text/x-c++src',
		'dat' => 'video/mpeg',
		'dbf' => 'application/x-dbase',
		'dc' => 'application/x-dc-rom',
		'dcl' => 'text/x-dcl',
		'dcm' => 'image/x-dcm',
		'dcr' => 'application/x-director',
		'deb' => 'application/x-deb',
		'der' => 'application/x-x509-ca-cert',
		'desktop' => 'application/x-desktop',
		'dia' => 'application/x-dia-diagram',
		'diff' => 'text/x-patch',
		'dir' => 'application/x-director',
		'djv' => 'image/vnd.djvu',
		'djvu' => 'image/vnd.djvu',
		'dll' => 'application/octet-stream',
		'dms' => 'application/octet-stream',
		'doc' => 'application/msword',
		'dsl' => 'text/x-dsl',
		'dtd' => 'text/x-dtd',
		'dvi' => 'application/x-dvi',
		'dwg' => 'image/vnd.dwg',
		'dxf' => 'image/vnd.dxf',
		'dxr' => 'application/x-director',
		'egon' => 'application/x-egon',
		'el' => 'text/x-emacs-lisp',
		'eps' => 'image/x-eps',
		'epsf' => 'image/x-eps',
		'epsi' => 'image/x-eps',
		'etheme' => 'application/x-e-theme',
		'etx' => 'text/x-setext',
		'exe' => 'application/x-executable',
		'ez' => 'application/andrew-inset',
		'f' => 'text/x-fortran',
		'fig' => 'image/x-xfig',
		'fits' => 'image/x-fits',
		'flac' => 'audio/x-flac',
		'flc' => 'video/x-flic',
		'fli' => 'video/x-flic',
		'flw' => 'application/x-kivio',
		'fo' => 'text/x-xslfo',
		'g3' => 'image/fax-g3',
		'gb' => 'application/x-gameboy-rom',
		'gcrd' => 'text/x-vcard',
		'gen' => 'application/x-genesis-rom',
		'gg' => 'application/x-sms-rom',
		'gif' => 'image/gif',
		'glade' => 'application/x-glade',
		'gmo' => 'application/x-gettext-translation',
		'gnc' => 'application/x-gnucash',
		'gnucash' => 'application/x-gnucash',
		'gnumeric' => 'application/x-gnumeric',
		'gra' => 'application/x-graphite',
		'gsf' => 'application/x-font-type1',
		'gtar' => 'application/x-gtar',
		'gz' => 'application/x-gzip',
		'h' => 'text/x-chdr',
		'h++' => 'text/x-chdr',
		'hdf' => 'application/x-hdf',
		'hh' => 'text/x-c++hdr',
		'hp' => 'text/x-chdr',
		'hpgl' => 'application/vnd.hp-hpgl',
		'hqx' => 'application/mac-binhex40',
		'hs' => 'text/x-haskell',
		'htm' => 'text/html',
		'html' => 'text/html',
		'icb' => 'image/x-icb',
		'ice' => 'x-conference/x-cooltalk',
		'ico' => 'image/x-ico',
		'ics' => 'text/calendar',
		'idl' => 'text/x-idl',
		'ief' => 'image/ief',
		'ifb' => 'text/calendar',
		'iff' => 'image/x-iff',
		'iges' => 'model/iges',
		'igs' => 'model/iges',
		'ilbm' => 'image/x-ilbm',
		'iso' => 'application/x-cd-image',
		'it' => 'audio/x-it',
		'jar' => 'application/x-jar',
		'java' => 'text/x-java',
		'jng' => 'image/x-jng',
		'jp2' => 'image/jpeg2000',
		'jpg' => 'image/jpeg',
		'jpe' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'jpr' => 'application/x-jbuilder-project',
		'jpx' => 'application/x-jbuilder-project',
		'js' => 'application/x-javascript',
		'kar' => 'audio/midi',
		'karbon' => 'application/x-karbon',
		'kdelnk' => 'application/x-desktop',
		'kfo' => 'application/x-kformula',
		'kil' => 'application/x-killustrator',
		'kon' => 'application/x-kontour',
		'kpm' => 'application/x-kpovmodeler',
		'kpr' => 'application/x-kpresenter',
		'kpt' => 'application/x-kpresenter',
		'kra' => 'application/x-krita',
		'ksp' => 'application/x-kspread',
		'kud' => 'application/x-kugar',
		'kwd' => 'application/x-kword',
		'kwt' => 'application/x-kword',
		'la' => 'application/x-shared-library-la',
		'latex' => 'application/x-latex',
		'lha' => 'application/x-lha',
		'lhs' => 'text/x-literate-haskell',
		'lhz' => 'application/x-lhz',
		'log' => 'text/x-log',
		'ltx' => 'text/x-tex',
		'lwo' => 'image/x-lwo',
		'lwob' => 'image/x-lwo',
		'lws' => 'image/x-lws',
		'lyx' => 'application/x-lyx',
		'lzh' => 'application/x-lha',
		'lzo' => 'application/x-lzop',
		'm' => 'text/x-objcsrc',
		'm15' => 'audio/x-mod',
		'm3u' => 'audio/x-mpegurl',
		'man' => 'application/x-troff-man',
		'md' => 'application/x-genesis-rom',
		'me' => 'text/x-troff-me',
		'mesh' => 'model/mesh',
		'mgp' => 'application/x-magicpoint',
		'mid' => 'audio/midi',
		'midi' => 'audio/midi',
		'mif' => 'application/x-mif',
		'mkv' => 'application/x-matroska',
		'mm' => 'text/x-troff-mm',
		'mml' => 'text/mathml',
		'mng' => 'video/x-mng',
		'moc' => 'text/x-moc',
		'mod' => 'audio/x-mod',
		'moov' => 'video/quicktime',
		'mov' => 'video/quicktime',
		'movie' => 'video/x-sgi-movie',
		'mp2' => 'video/mpeg',
		'mp3' => 'audio/x-mp3',
		'mpe' => 'video/mpeg',
		'mpeg' => 'video/mpeg',
		'mpg' => 'video/mpeg',
		'mpga' => 'audio/mpeg',
		'ms' => 'text/x-troff-ms',
		'msh' => 'model/mesh',
		'msod' => 'image/x-msod',
		'msx' => 'application/x-msx-rom',
		'mtm' => 'audio/x-mod',
		'mxu' => 'video/vnd.mpegurl',
		'n64' => 'application/x-n64-rom',
		'nc' => 'application/x-netcdf',
		'nes' => 'application/x-nes-rom',
		'nsv' => 'video/x-nsv',
		'o' => 'application/x-object',
		'obj' => 'application/x-tgif',
		'oda' => 'application/oda',
		'odb' => 'application/vnd.oasis.opendocument.database',
		'odc' => 'application/vnd.oasis.opendocument.chart',
		'odf' => 'application/vnd.oasis.opendocument.formula',
		'odg' => 'application/vnd.oasis.opendocument.graphics',
		'odi' => 'application/vnd.oasis.opendocument.image',
		'odm' => 'application/vnd.oasis.opendocument.text-master',
		'odp' => 'application/vnd.oasis.opendocument.presentation',
		'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		'odt' => 'application/vnd.oasis.opendocument.text',
		'ogg' => 'application/ogg',
		'old' => 'application/x-trash',
		'oleo' => 'application/x-oleo',
		'otg' => 'application/vnd.oasis.opendocument.graphics-template',
		'oth' => 'application/vnd.oasis.opendocument.text-web',
		'otp' => 'application/vnd.oasis.opendocument.presentation-template',
		'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
		'ott' => 'application/vnd.oasis.opendocument.text-template',
		'p' => 'text/x-pascal',
		'p12' => 'application/x-pkcs12',
		'p7s' => 'application/pkcs7-signature',
		'pas' => 'text/x-pascal',
		'patch' => 'text/x-patch',
		'pbm' => 'image/x-portable-bitmap',
		'pcd' => 'image/x-photo-cd',
		'pcf' => 'application/x-font-pcf',
		'pcf.Z' => 'application/x-font-type1',
		'pcl' => 'application/vnd.hp-pcl',
		'pdb' => 'application/vnd.palm',
		'pdf' => 'application/pdf',
		'pem' => 'application/x-x509-ca-cert',
		'perl' => 'application/x-perl',
		'pfa' => 'application/x-font-type1',
		'pfb' => 'application/x-font-type1',
		'pfx' => 'application/x-pkcs12',
		'pgm' => 'image/x-portable-graymap',
		'pgn' => 'application/x-chess-pgn',
		'pgp' => 'application/pgp',
		'php' => 'application/x-php',
		'php3' => 'application/x-php',
		'php4' => 'application/x-php',
		'pict' => 'image/x-pict',
		'pict1' => 'image/x-pict',
		'pict2' => 'image/x-pict',
		'pl' => 'application/x-perl',
		'pls' => 'audio/x-scpls',
		'pm' => 'application/x-perl',
		'png' => 'image/png',
		'pnm' => 'image/x-portable-anymap',
		'po' => 'text/x-gettext-translation',
		'pot' => 'application/vnd.ms-powerpoint',
		'ppm' => 'image/x-portable-pixmap',
		'pps' => 'application/vnd.ms-powerpoint',
		'ppt' => 'application/vnd.ms-powerpoint',
		'ppz' => 'application/vnd.ms-powerpoint',
		'ps' => 'application/postscript',
		'ps.gz' => 'application/x-gzpostscript',
		'psd' => 'image/x-psd',
		'psf' => 'application/x-font-linux-psf',
		'psid' => 'audio/prs.sid',
		'pw' => 'application/x-pw',
		'py' => 'application/x-python',
		'pyc' => 'application/x-python-bytecode',
		'pyo' => 'application/x-python-bytecode',
		'qif' => 'application/x-qw',
		'qt' => 'video/quicktime',
		'qtvr' => 'video/quicktime',
		'ra' => 'audio/x-pn-realaudio',
		'ram' => 'audio/x-pn-realaudio',
		'rar' => 'application/x-rar',
		'ras' => 'image/x-cmu-raster',
		'rdf' => 'text/rdf',
		'rej' => 'application/x-reject',
		'rgb' => 'image/x-rgb',
		'rle' => 'image/rle',
		'rm' => 'audio/x-pn-realaudio',
		'roff' => 'application/x-troff',
		'rpm' => 'application/x-rpm',
		'rss' => 'text/rss',
		'rtf' => 'application/rtf',
		'rtx' => 'text/richtext',
		's3m' => 'audio/x-s3m',
		'sam' => 'application/x-amipro',
		'scm' => 'text/x-scheme',
		'sda' => 'application/vnd.stardivision.draw',
		'sdc' => 'application/vnd.stardivision.calc',
		'sdd' => 'application/vnd.stardivision.impress',
		'sdp' => 'application/vnd.stardivision.impress',
		'sds' => 'application/vnd.stardivision.chart',
		'sdw' => 'application/vnd.stardivision.writer',
		'sgi' => 'image/x-sgi',
		'sgl' => 'application/vnd.stardivision.writer',
		'sgm' => 'text/sgml',
		'sgml' => 'text/sgml',
		'sh' => 'application/x-shellscript',
		'shar' => 'application/x-shar',
		'shtml' => 'text/html',
		'siag' => 'application/x-siag',
		'sid' => 'audio/prs.sid',
		'sik' => 'application/x-trash',
		'silo' => 'model/mesh',
		'sit' => 'application/x-stuffit',
		'skd' => 'application/x-koan',
		'skm' => 'application/x-koan',
		'skp' => 'application/x-koan',
		'skt' => 'application/x-koan',
		'slk' => 'text/spreadsheet',
		'smd' => 'application/vnd.stardivision.mail',
		'smf' => 'application/vnd.stardivision.math',
		'smi' => 'application/smil',
		'smil' => 'application/smil',
		'sml' => 'application/smil',
		'sms' => 'application/x-sms-rom',
		'snd' => 'audio/basic',
		'so' => 'application/x-sharedlib',
		'spd' => 'application/x-font-speedo',
		'spl' => 'application/x-futuresplash',
		'sql' => 'text/x-sql',
		'src' => 'application/x-wais-source',
		'stc' => 'application/vnd.sun.xml.calc.template',
		'std' => 'application/vnd.sun.xml.draw.template',
		'sti' => 'application/vnd.sun.xml.impress.template',
		'stm' => 'audio/x-stm',
		'stw' => 'application/vnd.sun.xml.writer.template',
		'sty' => 'text/x-tex',
		'sun' => 'image/x-sun-raster',
		'sv4cpio' => 'application/x-sv4cpio',
		'sv4crc' => 'application/x-sv4crc',
		'svg' => 'image/svg+xml',
		'swf' => 'application/x-shockwave-flash',
		'sxc' => 'application/vnd.sun.xml.calc',
		'sxd' => 'application/vnd.sun.xml.draw',
		'sxg' => 'application/vnd.sun.xml.writer.global',
		'sxi' => 'application/vnd.sun.xml.impress',
		'sxm' => 'application/vnd.sun.xml.math',
		'sxw' => 'application/vnd.sun.xml.writer',
		'sylk' => 'text/spreadsheet',
		't' => 'application/x-troff',
		'tar' => 'application/x-tar',
		'tar.Z' => 'application/x-tarz',
		'tar.bz' => 'application/x-bzip-compressed-tar',
		'tar.bz2' => 'application/x-bzip-compressed-tar',
		'tar.gz' => 'application/x-compressed-tar',
		'tar.lzo' => 'application/x-tzo',
		'tcl' => 'text/x-tcl',
		'tex' => 'text/x-tex',
		'texi' => 'text/x-texinfo',
		'texinfo' => 'text/x-texinfo',
		'tga' => 'image/x-tga',
		'tgz' => 'application/x-compressed-tar',
		'theme' => 'application/x-theme',
		'tif' => 'image/tiff',
		'tiff' => 'image/tiff',
		'tk' => 'text/x-tcl',
		'torrent' => 'application/x-bittorrent',
		'tr' => 'application/x-troff',
		'ts' => 'application/x-linguist',
		'tsv' => 'text/tab-separated-values',
		'ttf' => 'application/x-font-ttf',
		'txt' => 'text/plain',
		'tzo' => 'application/x-tzo',
		'ui' => 'application/x-designer',
		'uil' => 'text/x-uil',
		'ult' => 'audio/x-mod',
		'uni' => 'audio/x-mod',
		'uri' => 'text/x-uri',
		'url' => 'text/x-uri',
		'ustar' => 'application/x-ustar',
		'vcd' => 'application/x-cdlink',
		'vcf' => 'text/x-vcalendar',
		'vcs' => 'text/x-vcalendar',
		'vct' => 'text/x-vcard',
		'vfb' => 'text/calendar',
		'vob' => 'video/mpeg',
		'voc' => 'audio/x-voc',
		'vor' => 'application/vnd.stardivision.writer',
		'vrml' => 'model/vrml',
		'vsd' => 'application/vnd.visio',
		'wav' => 'audio/x-wav',
		'wax' => 'audio/x-ms-wax',
		'wb1' => 'application/x-quattropro',
		'wb2' => 'application/x-quattropro',
		'wb3' => 'application/x-quattropro',
		'wbmp' => 'image/vnd.wap.wbmp',
		'wbxml' => 'application/vnd.wap.wbxml',
		'wk1' => 'application/vnd.lotus-1-2-3',
		'wk3' => 'application/vnd.lotus-1-2-3',
		'wk4' => 'application/vnd.lotus-1-2-3',
		'wks' => 'application/vnd.lotus-1-2-3',
		'wm' => 'video/x-ms-wm',
		'wma' => 'audio/x-ms-wma',
		'wmd' => 'application/x-ms-wmd',
		'wmf' => 'image/x-wmf',
		'wml' => 'text/vnd.wap.wml',
		'wmlc' => 'application/vnd.wap.wmlc',
		'wmls' => 'text/vnd.wap.wmlscript',
		'wmlsc' => 'application/vnd.wap.wmlscriptc',
		'wmv' => 'video/x-ms-wmv',
		'wmx' => 'video/x-ms-wmx',
		'wmz' => 'application/x-ms-wmz',
		'wpd' => 'application/wordperfect',
		'wpg' => 'application/x-wpg',
		'wri' => 'application/x-mswrite',
		'wrl' => 'model/vrml',
		'wvx' => 'video/x-ms-wvx',
		'xac' => 'application/x-gnucash',
		'xbel' => 'application/x-xbel',
		'xbm' => 'image/x-xbitmap',
		'xcf' => 'image/x-xcf',
		'xcf.bz2' => 'image/x-compressed-xcf',
		'xcf.gz' => 'image/x-compressed-xcf',
		'xht' => 'application/xhtml+xml',
		'xhtml' => 'application/xhtml+xml',
		'xi' => 'audio/x-xi',
		'xls' => 'application/vnd.ms-excel',
		'xla' => 'application/vnd.ms-excel',
		'xlc' => 'application/vnd.ms-excel',
		'xld' => 'application/vnd.ms-excel',
		'xll' => 'application/vnd.ms-excel',
		'xlm' => 'application/vnd.ms-excel',
		'xlt' => 'application/vnd.ms-excel',
		'xlw' => 'application/vnd.ms-excel',
		'xm' => 'audio/x-xm',
		'xml' => 'text/xml',
		'xpm' => 'image/x-xpixmap',
		'xsl' => 'text/x-xslt',
		'xslfo' => 'text/x-xslfo',
		'xslt' => 'text/x-xslt',
		'xwd' => 'image/x-xwindowdump',
		'xyz' => 'chemical/x-xyz',
		'zabw' => 'application/x-abiword',
		'zip' => 'application/zip',
		'zoo' => 'application/x-zoo',
		'123' => 'application/vnd.lotus-1-2-3',
		'669' => 'audio/x-mod'
    );
	if (isset($map[$ext])) {
		return $map[$ext];
	}
	// return 'x-extension/' . $ext;
	// return 'application/octet-stream';
	return 'application/force-download';
}
