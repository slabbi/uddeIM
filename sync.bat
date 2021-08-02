@echo off

echo This script syncs J1.6 and 3.0 code basis.
echo.
echo.
pause

@echo on

rem =====================================================================================

copy /b .\com_uddeim\templates\default\css\admin.uddeim.* 		.\..\..\uddeIMtemplates\trunk\uddeim_templates\tcplc\css\
copy /b .\com_uddeim\templates\default\css\admin.uddeim.* 		.\..\..\uddeIMtemplates\trunk\uddeim_templates\noir\css\
copy /b .\com_uddeim\templates\default\css\admin.uddeim.* 		.\..\..\uddeIMtemplates\trunk\uddeim_templates\monorange\css\
copy /b .\com_uddeim\templates\default\css\admin.uddeim.* 		.\..\..\uddeIMtemplates\trunk\uddeim_templates\monopink\css\
copy /b .\com_uddeim\templates\default\css\admin.uddeim.* 		.\..\..\uddeIMtemplates\trunk\uddeim_templates\monogram\css\
copy /b .\com_uddeim\templates\default\css\admin.uddeim.* 		.\..\..\uddeIMtemplates\trunk\uddeim_templates\monoblue\css\
copy /b .\com_uddeim\templates\default\css\admin.uddeim.* 		.\..\..\uddeIMtemplates\trunk\uddeim_templates\modernblue\css\
copy /b .\com_uddeim\templates\default\css\admin.uddeim.* 		.\..\..\uddeIMtemplates\trunk\uddeim_templates\default_ex\css\
copy /b .\com_uddeim\templates\default\css\admin.uddeim.* 		.\..\..\slabbi\com_uddeim\premium\templates\default_ex_pink\css\

rem =====================================================================================

copy /b .\com_uddeim\js\*.js 									.\com_uddeim_j16\site\js\
copy /b .\com_uddeim\language\*.php				 				.\com_uddeim_j16\admin\language\
copy /b .\com_uddeim\language.utf8\*.php					 	.\com_uddeim_j16\admin\language.utf8\
copy /b .\com_uddeim\ReCaptcha\*.php							.\com_uddeim_j16\site\ReCaptcha\
copy /b .\com_uddeim\ReCaptcha\RequestMethod\*.php				.\com_uddeim_j16\site\ReCaptcha\RequestMethod\

copy /b .\com_uddeim\admin*.php							 		.\com_uddeim_j16\admin\
copy /b .\com_uddeim\config.class.php 							.\com_uddeim_j16\admin\
copy /b .\com_uddeim\toolbar.uddeim.php						 	.\com_uddeim_j16\admin\

copy /b .\com_uddeim\templates\images\*.* 						.\com_uddeim_j16\site\templates\images\
copy /b .\com_uddeim\templates\default\*.* 						.\com_uddeim_j16\site\templates\default\
copy /b .\com_uddeim\templates\default\animated\*.* 			.\com_uddeim_j16\site\templates\default\animated\
copy /b .\com_uddeim\templates\default\animated-extended\*.* 	.\com_uddeim_j16\site\templates\default\animated-extended\
copy /b .\com_uddeim\templates\default\css\*.* 					.\com_uddeim_j16\site\templates\default\css\
copy /b .\com_uddeim\templates\default\images\*.* 				.\com_uddeim_j16\site\templates\default\images\

copy /b .\com_uddeim\archive.php 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\autoload.php 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\bbparser.php 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\captcha.php 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\captcha15.php 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\cb_extra.php 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\crypt.class.php 		.\com_uddeim_j16\site\
copy /b .\com_uddeim\getpiclink.php 		.\com_uddeim_j16\site\
copy /b .\com_uddeim\inbox.php 				.\com_uddeim_j16\site\
copy /b .\com_uddeim\includes.db.php 		.\com_uddeim_j16\site\
copy /b .\com_uddeim\includes.php 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\index.html				.\com_uddeim_j16\site\
copy /b .\com_uddeim\json.php 				.\com_uddeim_j16\site\
copy /b .\com_uddeim\monofont.ttf 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\outbox.php 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\recaptchalib.php 		.\com_uddeim_j16\site\
copy /b .\com_uddeim\trashcan.php 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\uddeim.api.php 		.\com_uddeim_j16\site\
copy /b .\com_uddeim\uddeim.php 			.\com_uddeim_j16\site\
copy /b .\com_uddeim\uddeim_igoogle.xml 	.\com_uddeim_j16\site\
copy /b .\com_uddeim\uddeimlib*.php 		.\com_uddeim_j16\site\
copy /b .\com_uddeim\userlists.php 			.\com_uddeim_j16\site\

copy /b .\mod_uddeim\mod_uddeim.php			.\mod_uddeim_j16\
copy /b .\mod_uddeim\mod_uddeim\*.*			.\mod_uddeim_j16\mod_uddeim\

copy /b .\mod_uddeim_mailbox\mod_uddeim_mailbox.php 		.\mod_uddeim_mailbox_j16\
copy /b .\mod_uddeim_statistics\mod_uddeim_statistics.php 	.\mod_uddeim_statistics_j16\
copy /b .\plug_uddeim_contentlink\uddeim_contentlink.php 	.\plug_uddeim_contentlink_j16\
copy /b .\plug_uddeim_searchbot\uddeim_searchbot.php 		.\plug_uddeim_searchbot_j16\

rem =====================================================================================

copy /b .\com_uddeim\js\*.js 									.\com_uddeim_j30\site\js\
copy /b .\com_uddeim\language\*.php 							.\com_uddeim_j30\admin\language\
copy /b .\com_uddeim_j16\admin\language\en-GB\					.\com_uddeim_j30\admin\language\en-GB\
copy /b .\com_uddeim_j16\admin\language\es-ES\					.\com_uddeim_j30\admin\language\es-ES\
copy /b .\com_uddeim_j16\admin\language\sv-SE\					.\com_uddeim_j30\admin\language\sv-SE\
copy /b .\com_uddeim\language.utf8\*.php 						.\com_uddeim_j30\admin\language.utf8\
copy /b .\com_uddeim\ReCaptcha\*.php							.\com_uddeim_j30\site\ReCaptcha\
copy /b .\com_uddeim\ReCaptcha\RequestMethod\*.php				.\com_uddeim_j30\site\ReCaptcha\RequestMethod\

copy /b .\com_uddeim\admin*.php		 							.\com_uddeim_j30\admin\
copy /b .\com_uddeim\config.class.php 							.\com_uddeim_j30\admin\
copy /b .\com_uddeim\toolbar.uddeim.php 						.\com_uddeim_j30\admin\

copy /b .\com_uddeim\templates\images\*.* 						.\com_uddeim_j30\site\templates\images\
copy /b .\com_uddeim\templates\default\*.* 						.\com_uddeim_j30\site\templates\default\
copy /b .\com_uddeim\templates\default\animated\*.* 			.\com_uddeim_j30\site\templates\default\animated\
copy /b .\com_uddeim\templates\default\animated-extended\*.* 	.\com_uddeim_j30\site\templates\default\animated-extended\
copy /b .\com_uddeim\templates\default\css\*.* 					.\com_uddeim_j30\site\templates\default\css\
copy /b .\com_uddeim\templates\default\images\*.* 				.\com_uddeim_j30\site\templates\default\images\

copy /b .\com_uddeim\archive.php 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\autoload.php 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\bbparser.php 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\captcha.php 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\captcha15.php 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\cb_extra.php 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\crypt.class.php 		.\com_uddeim_j30\site\
copy /b .\com_uddeim\getpiclink.php 		.\com_uddeim_j30\site\
copy /b .\com_uddeim\inbox.php 				.\com_uddeim_j30\site\
copy /b .\com_uddeim\includes.db.php 		.\com_uddeim_j30\site\
copy /b .\com_uddeim\includes.php 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\index.html				.\com_uddeim_j30\site\
copy /b .\com_uddeim\json.php 				.\com_uddeim_j30\site\
copy /b .\com_uddeim\monofont.ttf 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\outbox.php 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\recaptchalib.php 		.\com_uddeim_j30\site\
copy /b .\com_uddeim\trashcan.php 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\uddeim.api.php 		.\com_uddeim_j30\site\
copy /b .\com_uddeim\uddeim.php 			.\com_uddeim_j30\site\
copy /b .\com_uddeim\uddeim_igoogle.xml 	.\com_uddeim_j30\site\
copy /b .\com_uddeim\uddeimlib*.php 		.\com_uddeim_j30\site\
copy /b .\com_uddeim\userlists.php 			.\com_uddeim_j30\site\

copy /b .\mod_uddeim\mod_uddeim.php			.\mod_uddeim_j30\
copy /b .\mod_uddeim\mod_uddeim\*.*			.\mod_uddeim_j30\mod_uddeim\

copy /b .\mod_uddeim_mailbox\mod_uddeim_mailbox.php 		.\mod_uddeim_mailbox_j30\
copy /b .\mod_uddeim_statistics\mod_uddeim_statistics.php 	.\mod_uddeim_statistics_j30\
copy /b .\plug_uddeim_contentlink\uddeim_contentlink.php 	.\plug_uddeim_contentlink_j30\
copy /b .\plug_uddeim_searchbot\uddeim_searchbot.php 		.\plug_uddeim_searchbot_j30\

rem ===================================================================================== ENGLISH ONLY

copy /b .\com_uddeim_j16\admin\							.\com_uddeim_j16_english_only\admin\
copy /b .\com_uddeim_j16\admin\language\eng*.php		.\com_uddeim_j16_english_only\admin\language\
copy /b .\com_uddeim_j16\admin\language\index.*			.\com_uddeim_j16_english_only\admin\language\
copy /b .\com_uddeim_j16\admin\language\en-GB\			.\com_uddeim_j16_english_only\admin\language\en-GB\
copy /b .\com_uddeim_j16\admin\language\es-ES\			.\com_uddeim_j16_english_only\admin\language\es-ES\
copy /b .\com_uddeim_j16\admin\language\sv-SE\			.\com_uddeim_j16_english_only\admin\language\sv-SE\
copy /b .\com_uddeim_j16\admin\language.utf8\eng*.php	.\com_uddeim_j16_english_only\admin\language.utf8\
copy /b .\com_uddeim_j16\admin\language.utf8\index.*	.\com_uddeim_j16_english_only\admin\language.utf8\
copy /b .\com_uddeim_j16\admin\sql\						.\com_uddeim_j16_english_only\admin\sql\
copy /b .\com_uddeim_j16\admin\sql\updates\				.\com_uddeim_j16_english_only\admin\sql\updates\
copy /b .\com_uddeim_j16\ReCaptcha\*.php				.\com_uddeim_j16_english_only\site\ReCaptcha\
copy /b .\com_uddeim_j16\ReCaptcha\RequestMethod\*.php	.\com_uddeim_j16_english_only\site\ReCaptcha\RequestMethod\

copy /b .\com_uddeim\templates\images\*.* 						.\com_uddeim_j16_english_only\site\templates\images\
copy /b .\com_uddeim\templates\default\*.* 						.\com_uddeim_j16_english_only\site\templates\default\
copy /b .\com_uddeim\templates\default\animated\*.* 			.\com_uddeim_j16_english_only\site\templates\default\animated\
copy /b .\com_uddeim\templates\default\animated-extended\*.* 	.\com_uddeim_j16_english_only\site\templates\default\animated-extended\
copy /b .\com_uddeim\templates\default\css\*.* 					.\com_uddeim_j16_english_only\site\templates\default\css\
copy /b .\com_uddeim\templates\default\images\*.* 				.\com_uddeim_j16_english_only\site\templates\default\images\

copy /b .\com_uddeim_j16\site\							.\com_uddeim_j16_english_only\site\
copy /b .\com_uddeim_j16\site\js\						.\com_uddeim_j16_english_only\site\js\
copy /b .\com_uddeim_j16\site\language\en-GB\			.\com_uddeim_j16_english_only\site\language\en-GB\
copy /b .\com_uddeim_j16\site\language\es-ES\			.\com_uddeim_j16_english_only\site\language\es-ES\
copy /b .\com_uddeim_j16\site\language\sv-SE\			.\com_uddeim_j16_english_only\site\language\sv-SE\
copy /b .\com_uddeim_j16\site\views\select\tmpl\		.\com_uddeim_j16_english_only\site\views\select\tmpl\

copy /b .\com_uddeim_j16\*.*							.\com_uddeim_j16_english_only\

rem ===================================================================================== JOOMLA 3.0

copy /b .\com_uddeim_j16\script.php						.\com_uddeim_j30\
copy /b .\com_uddeim_j16\admin\access.xml				.\com_uddeim_j30\admin\
copy /b .\com_uddeim_j16\admin\config.xml				.\com_uddeim_j30\admin\

copy /b .\com_uddeim_j16\admin\sql\						.\com_uddeim_j30\admin\sql\
copy /b .\com_uddeim_j16\admin\sql\updates\				.\com_uddeim_j30\admin\sql\updates\

rem ===================================================================================== CB 2.0

copy /b .\cb_plug_pms_uddeim\*.php						.\cb2_plug_pms_uddeim\
copy /b .\cb_plug_pms_uddeim_blocking\*.php				.\cb2_plug_pms_uddeim_blocking\
copy /b .\cb_plug_pms_uddeim_inbox\*.php				.\cb2_plug_pms_uddeim_inbox\
copy /b .\cb_plug_pms_uddeim_profilelink\*.php			.\cb2_plug_pms_uddeim_profilelink\

pause
