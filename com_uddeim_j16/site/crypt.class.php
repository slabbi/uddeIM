<?php 
// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2010 Stephan Slabihoud
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

if (!(defined('_JEXEC') || defined('_VALID_MOS'))) { die( 'Direct Access to this location is not allowed.' ); }

define('CRYPT_MODE_BINARY'     		 ,  0);		// Vernam
define('CRYPT_MODE_BASE64'     		 ,  1);
define('CRYPT_MODE_HEXADECIMAL'		 ,  2);
define('CRYPT_MODE_STOREBINARY'		 , 16);		// Store only
define('CRYPT_MODE_STOREBASE64'		 , 17);
define('CRYPT_MODE_STOREHEXADECIMAL' , 18);
define('CRYPT_MODE_3DESBINARY'		 , 32);		// 3-DES
define('CRYPT_MODE_3DESBASE64'		 , 33);
define('CRYPT_MODE_3DESHEXADECIMAL'	 , 34);

define('CRYPT_HASH_MD5' , 'md5');
define('CRYPT_HASH_SHA1', 'sha1');

function uddeIMgetMessage($message, $cryptpass, $cryptmode, $crypthash, $cryptkey) {
	$ret = "";
	if ($cryptmode==1) {
		if ($crypthash && md5($cryptkey)!=$crypthash)
			$ret = _UDDEIM_WRONGPW;
		else
			$ret = uddeIMdecrypt($message, $cryptkey, CRYPT_MODE_BASE64);
	} elseif ($cryptmode==2 && !strlen($cryptpass)) {
		$ret = _UDDEIM_PASSWORDREQ;
	} elseif ($cryptmode==2 && strlen($cryptpass)) {
		if (md5($cryptpass)==$crypthash)
			$ret = uddeIMdecrypt($message, $cryptpass, CRYPT_MODE_BASE64);
		else
			$ret = _UDDEIM_WRONGPASS;
	} elseif ($cryptmode==3) {
		$ret = uddeIMdecrypt($message, "", CRYPT_MODE_STOREBASE64);
	} elseif ($cryptmode==4 && !strlen($cryptpass)) {
		$ret = _UDDEIM_PASSWORDREQ;
	} elseif ($cryptmode==4 && strlen($cryptpass)) {
		if (md5($cryptpass)==$crypthash)
			$ret = uddeIMdecrypt($message, $cryptpass, CRYPT_MODE_3DESBASE64);
		else
			$ret = _UDDEIM_WRONGPASS;
	} else {
		$ret = $message;
	}
	return $ret;
}

function uddeIMencrypt($data,$key,$mode) {
	$data = (string) $data;
	if ($mode>=0 && $mode<16) {
		for ($i=0;$i<strlen($data);$i++)
			@$encrypt .= $data[$i] ^ $key[$i % strlen($key)];
	}
	if ($mode>=16 && $mode<32) {
		@$encrypt = $data;
	}
	if ($mode>=32 && $mode<48) {
		@$encrypt = uddeIMdoEncrypt3DES($data, $key);
	}

	$mode = $mode & 0x0f;
	if ($mode == CRYPT_MODE_BINARY)
		return @$encrypt;
	@$encrypt = base64_encode(@$encrypt);
	if ($mode == CRYPT_MODE_BASE64)
		return @$encrypt;
	if ($mode == CRYPT_MODE_HEXADECIMAL)
		return uddeIMdoEncodeHexadecimal(@$encrypt);
}

function uddeIMdecrypt($crypt,$key,$mode) {
	$mode2 = $mode & 0x0f;
	if ($mode2 == CRYPT_MODE_HEXADECIMAL)
		$crypt = uddeIMdoDecodeHexadecimal($crypt);
	if ($mode2 == CRYPT_MODE_BASE64)
		$crypt = (string)base64_decode($crypt);
	if ($mode>=0 && $mode<16) {
		for ($i=0;$i<strlen($crypt);$i++)
			@$data .= $crypt[$i] ^ $key[$i % strlen($key)];
	}
	if ($mode>=16 && $mode<32) {
		@$data = $crypt;
	}
	if ($mode>=32 && $mode<48) {
		@$data = uddeIMdoDecrypt3DES($crypt, $key);
	}
	return @$data;
}

function uddeIMdoEncodeHexadecimal($data) {
	$data = (string) $data;
	for ($i=0;$i<strlen($data);$i++)
		@$hexcrypt .= dechex(ord($data[$i]));
	return @$hexcrypt;
}

function uddeIMdoDecodeHexadecimal($hexcrypt) {
	$hexcrypt = (string) $hexcrypt;
	for ($i=0;$i<strlen($hexcrypt);$i+=2)
		@$data .= chr(hexdec(substr($hexcrypt, $i, 2)));
	return @$data;
}

function uddeIMdoEncrypt3DES($string, $key) {
	srand((double) microtime() * 1000000);	// for sake of MCRYPT_RAND
	$key = md5($key);						// to improve variance
	/* Open module, and create IV */
	$td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CFB, '');
	$key = substr($key, 0, mcrypt_enc_get_key_size($td));
	$iv_size = mcrypt_enc_get_iv_size($td);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	/* Initialize encryption handle */
	if (mcrypt_generic_init($td, $key, $iv) != -1) {
		/* Encrypt data */
		$c_t = mcrypt_generic($td, $string);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		$c_t = $iv.$c_t;
		return $c_t;
	}
	return NULL;
}

function uddeIMdoDecrypt3DES($string,$key) {
	$key = md5($key);
	/* Open module, and create IV */
	$td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CFB, '');
	$key = substr($key, 0, mcrypt_enc_get_key_size($td));
	$iv_size = mcrypt_enc_get_iv_size($td);
	$iv = substr($string,0,$iv_size);
	$string = substr($string,$iv_size);
	/* Initialize encryption handle */
	if (mcrypt_generic_init($td, $key, $iv) != -1) {
		/* Encrypt data */
		$c_t = mdecrypt_generic($td, $string);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return $c_t;
	}
	return NULL;
}
