<?php
// ********************************************************************************************
// @title         udde Instant Messages (uddeIM)
// @description   Instant Messages System for Joomla 5
// @author        Stephan Slabihoud, Benjamin Zweifel
// @copyright     © 2007-2024 Stephan Slabihoud, © 2024 v5 joomod.de, © 2006 Benjamin Zweifel
// @license       GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
//                This program is free software: you may redistribute it and/or modify under the
//                terms of the GNU General Public License as published by the Free Software Foundation,
//                either version 3 of the License, or (at your option) any later version.
//
//                uddeIM is distributed in the hope to be useful but comes with absolutely NO WARRENTY.
//                You should have received a copy of the GNU General Public License along with this program.
//                Use at your own risk. For details, see the license at http://www.gnu.org/licenses/gpl.txt
//                Other licenses may be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );


define('CRYPT_MODE_BINARY'     		 ,  0);		// Vernam
define('CRYPT_MODE_BASE64'     		 ,  1);
define('CRYPT_MODE_HEXADECIMAL'		 ,  2);
define('CRYPT_MODE_STOREBINARY'		 , 16);		// Store only
define('CRYPT_MODE_STOREBASE64'		 , 17);
define('CRYPT_MODE_STOREHEXADECIMAL' , 18);
define('CRYPT_MODE_3DESBINARY'		 , 32);		// 3-DES
define('CRYPT_MODE_3DESBASE64'		 , 33);
define('CRYPT_MODE_3DESHEXADECIMAL'	 , 34);
define('CRYPT_MODE_OSSL_AES_128'     , 40);
define('CRYPT_MODE_OSSL_AES_256'     , 41);   // Openssl used
define('OSSL_AES_256_CBC' , 'AES-256-CBC');   // block size important
define('OSSL_AES_256_CTR' , 'AES-256-CTR');   // easy method

define('CRYPT_HASH_MD5' , 'md5');
define('CRYPT_HASH_SHA1', 'sha1');

function uddeIMgetMessage($message, $cryptpass, $cryptmode, $crypthash, $cryptkey) {
	$ret = "";
	if ($cryptmode==1) {
		if ($crypthash && md5($cryptkey)!=$crypthash)
			$ret = _UDDEIM_WRONGPW;
		else
			$ret = uddeIMdecrypt($message, $cryptkey, CRYPT_MODE_BASE64);
	} elseif ($cryptmode==2 && !strlen($cryptpass ?? '')) {
		$ret = _UDDEIM_PASSWORDREQ;
	} elseif ($cryptmode==2 && strlen($cryptpass)) {
		if (md5($cryptpass)==$crypthash)
			$ret = uddeIMdecrypt($message, $cryptpass, CRYPT_MODE_BASE64);
		else
			$ret = _UDDEIM_WRONGPASS;
	} elseif ($cryptmode==3) {
		$ret = uddeIMdecrypt($message, "", CRYPT_MODE_STOREBASE64);
	} elseif ($cryptmode==4 && !strlen($cryptpass ?? '')) {
		$ret = _UDDEIM_PASSWORDREQ;
	} elseif ($cryptmode==4 && strlen($cryptpass)) {
		if (md5($cryptpass)==$crypthash)
			$ret = uddeIMdecrypt($message, $cryptpass, CRYPT_MODE_OSSL_AES_256);
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

		@$encrypt = uddeIMdoEncrypt_OSSL($data, $key, OSSL_AES_256_CBC);
        return @$encrypt;
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
	elseif ($mode2 == CRYPT_MODE_BASE64)
		$crypt = (string)base64_decode($crypt);
	elseif ($mode>=0 && $mode<16) {
		for ($i=0;$i<strlen($crypt);$i++)
			@$data .= $crypt[$i] ^ $key[$i % strlen($key)];
	}
	elseif ($mode>=16 && $mode<32) {
		@$data = $crypt;
	}
    elseif ($mode>=32 && $mode<48) {
		@$data = uddeIMdoDecrypt_OSSL($crypt, $key, OSSL_AES_256_CBC);
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

/*** mcrypt support ended with php7.2 ***/


function uddeIMdoEncrypt_OSSL(string $data, string $key, string $method): string
{
    $ivsize = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivsize);
    $key256 = openssl_digest( $key , 'sha256', true);

    $encrypted = openssl_encrypt($data, $method, $key256, OPENSSL_RAW_DATA, $iv);
    // For storage/transmission, we simply concatenate the IV and cipher text
    $encrypted = base64_encode($iv . $encrypted);
    //return openssl_error_string();

    return $encrypted;
}

function uddeIMdoDecrypt_OSSL(string $data, string $key, string $method): string
{
    $data = base64_decode($data);
    $ivsize = openssl_cipher_iv_length($method);
    $key256 = openssl_digest( $key , 'sha256', true);
    $iv = substr($data, 0, $ivsize);

    $data = openssl_decrypt(substr($data, $ivsize), $method, $key256, OPENSSL_RAW_DATA, $iv);
    //return openssl_error_string();
    return $data;
}
