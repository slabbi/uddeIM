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

define("_JEXEC", 1 );
define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../..' ));

if (!(defined('_JEXEC'))) { die( 'Direct Access to this location is not allowed.' ); }

require_once ( JPATH_BASE .'/includes/defines.php' );
require_once ( JPATH_BASE .'/includes/framework.php' );

$container = \Joomla\CMS\Factory::getContainer();
$container->alias(\Joomla\Session\SessionInterface::class, 'session.web.site');

$app = $container->get(\Joomla\CMS\Application\SiteApplication::class);

\Joomla\CMS\Factory::$application = $app;
$app->createExtensionNamespaceMap();

/*
* File: CaptchaSecurityImages.php - Class: CaptchaSecurityImages
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 03/08/06
* Updated: 07/02/07
* Requirements: PHP 4/5 with GD and FreeType libraries
* Link: http://www.white-hat-web-design.co.uk/articles/php-captcha.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/

class CaptchaSecurityImages {

	var $font = 'monofont.ttf';
	public $img; 
	
	function generateCode($characters) {
		/* list all possible characters, similar looking characters have been removed */
		$possible = '23456789bcdefghjkmnpqrstvwxyzABCEFGHKMNPRSTUVWXYZ';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}

	function __construct($width='120',$height='40',$characters='6') {
		$code = $this->generateCode($characters);

		$session = Joomla\CMS\Factory::getApplication()->getSession();
        	$session->set('security_code', strtolower($code)); //just save lower case
		
		/* font size will be 80% of the image height */
		$font_size = $height * 0.8;
		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 20, 40, 100);
		$noise_color = imagecolorallocate($image, 100, 120, 180);
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}
		/* create textbox and add text */
	    	$thispath = dirname(__FILE__) . '/';
		$textbox = imageftbbox($font_size, 0, $thispath.$this->font, $code) or die('Error in imageftbbox function');
		$x = intval(($width - $textbox[4])/2);
		$y = intval(($height - $textbox[5])/2);
		imagefttext($image, $font_size, 0, $x, $y, $text_color, $thispath.$this->font , $code) or die('Error in imagefttext function');
		
		/* output captcha image to base54 string */
		//header('Content-Type: image/jpeg');
		ob_start();
		imagejpeg($image);
		$img_data = ob_get_contents ();
        	ob_end_clean();
		imagedestroy($image);
		$this->img = base64_encode($img_data);
	}

	public function __toString() {
        return $this->img;
    	}
}
 
require(dirname(__FILE__)."/../../administrator/components/com_uddeim/config.class.php");
$config = new uddeimconfigclass();

$captcha = new CaptchaSecurityImages($config->captchalen * 20, 30, $config->captchalen);
echo strval($captcha); 

