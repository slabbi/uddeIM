#!/bin/sh

echo This script syncs J1.6 and 3.0 code basis.
echo
echo

# =====================================================================================

cp -vr ./com_uddeim/templates/default/css/admin.uddeim.* 		./../../uddeIMtemplates/trunk/uddeim_templates/tcplc/css/
cp -vr ./com_uddeim/templates/default/css/admin.uddeim.* 		./../../uddeIMtemplates/trunk/uddeim_templates/noir/css/
cp -vr ./com_uddeim/templates/default/css/admin.uddeim.* 		./../../uddeIMtemplates/trunk/uddeim_templates/monorange/css/
cp -vr ./com_uddeim/templates/default/css/admin.uddeim.* 		./../../uddeIMtemplates/trunk/uddeim_templates/monopink/css/
cp -vr ./com_uddeim/templates/default/css/admin.uddeim.* 		./../../uddeIMtemplates/trunk/uddeim_templates/monogram/css/
cp -vr ./com_uddeim/templates/default/css/admin.uddeim.* 		./../../uddeIMtemplates/trunk/uddeim_templates/monoblue/css/
cp -vr ./com_uddeim/templates/default/css/admin.uddeim.* 		./../../uddeIMtemplates/trunk/uddeim_templates/modernblue/css/
cp -vr ./com_uddeim/templates/default/css/admin.uddeim.* 		./../../uddeIMtemplates/trunk/uddeim_templates/default_ex/css/
cp -vr ./com_uddeim/templates/default/css/admin.uddeim.* 		./../../slabbi/com_uddeim/premium/templates/default_ex_pink/css/

# =====================================================================================

cp -vr ./com_uddeim/js/*.js 									./com_uddeim_j16/site/js/
cp -vr ./com_uddeim/language/*.php				 				./com_uddeim_j16/admin/language/
cp -vr ./com_uddeim/language.utf8/*.php					 	./com_uddeim_j16/admin/language.utf8/
cp -vr ./com_uddeim/ReCaptcha/*.php							./com_uddeim_j16/site/ReCaptcha/
cp -vr ./com_uddeim/ReCaptcha/RequestMethod/*.php				./com_uddeim_j16/site/ReCaptcha/RequestMethod/

cp -vr ./com_uddeim/admin*.php							 		./com_uddeim_j16/admin/
cp -vr ./com_uddeim/config.class.php 							./com_uddeim_j16/admin/
cp -vr ./com_uddeim/toolbar.uddeim.php						 	./com_uddeim_j16/admin/

cp -vr ./com_uddeim/templates/images/*.* 						./com_uddeim_j16/site/templates/images/
cp -vr ./com_uddeim/templates/default/*.* 						./com_uddeim_j16/site/templates/default/
cp -vr ./com_uddeim/templates/default/animated/*.* 			./com_uddeim_j16/site/templates/default/animated/
cp -vr ./com_uddeim/templates/default/animated-extended/*.* 	./com_uddeim_j16/site/templates/default/animated-extended/
cp -vr ./com_uddeim/templates/default/css/*.* 					./com_uddeim_j16/site/templates/default/css/
cp -vr ./com_uddeim/templates/default/images/*.* 				./com_uddeim_j16/site/templates/default/images/

cp -vr ./com_uddeim/archive.php 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/autoload.php 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/bbparser.php 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/captcha.php 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/captcha15.php 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/cb_extra.php 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/crypt.class.php 		./com_uddeim_j16/site/
cp -vr ./com_uddeim/getpiclink.php 		./com_uddeim_j16/site/
cp -vr ./com_uddeim/inbox.php 				./com_uddeim_j16/site/
cp -vr ./com_uddeim/includes.db.php 		./com_uddeim_j16/site/
cp -vr ./com_uddeim/includes.php 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/index.html				./com_uddeim_j16/site/
cp -vr ./com_uddeim/json.php 				./com_uddeim_j16/site/
cp -vr ./com_uddeim/monofont.ttf 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/outbox.php 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/recaptchalib.php 		./com_uddeim_j16/site/
cp -vr ./com_uddeim/trashcan.php 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/uddeim.api.php 		./com_uddeim_j16/site/
cp -vr ./com_uddeim/uddeim.php 			./com_uddeim_j16/site/
cp -vr ./com_uddeim/uddeim_igoogle.xml 	./com_uddeim_j16/site/
cp -vr ./com_uddeim/uddeimlib*.php 		./com_uddeim_j16/site/
cp -vr ./com_uddeim/userlists.php 			./com_uddeim_j16/site/

cp -vr ./mod_uddeim/mod_uddeim.php			./mod_uddeim_j16/
cp -vr ./mod_uddeim/mod_uddeim/*.*			./mod_uddeim_j16/mod_uddeim/

cp -vr ./mod_uddeim_mailbox/mod_uddeim_mailbox.php 		./mod_uddeim_mailbox_j16/
cp -vr ./mod_uddeim_statistics/mod_uddeim_statistics.php 	./mod_uddeim_statistics_j16/
cp -vr ./plug_uddeim_contentlink/uddeim_contentlink.php 	./plug_uddeim_contentlink_j16/
cp -vr ./plug_uddeim_searchbot/uddeim_searchbot.php 		./plug_uddeim_searchbot_j16/

# =====================================================================================

cp -vr ./com_uddeim/js/*.js 									./com_uddeim_j30/site/js/
cp -vr ./com_uddeim/language/*.php 							./com_uddeim_j30/admin/language/
cp -vr ./com_uddeim_j16/admin/language/en-GB/					./com_uddeim_j30/admin/language/en-GB/
cp -vr ./com_uddeim_j16/admin/language/es-ES/					./com_uddeim_j30/admin/language/es-ES/
cp -vr ./com_uddeim_j16/admin/language/sv-SE/					./com_uddeim_j30/admin/language/sv-SE/
cp -vr ./com_uddeim/language.utf8/*.php 						./com_uddeim_j30/admin/language.utf8/
cp -vr ./com_uddeim/ReCaptcha/*.php							./com_uddeim_j30/site/ReCaptcha/
cp -vr ./com_uddeim/ReCaptcha/RequestMethod/*.php				./com_uddeim_j30/site/ReCaptcha/RequestMethod/

cp -vr ./com_uddeim/admin*.php		 							./com_uddeim_j30/admin/
cp -vr ./com_uddeim/config.class.php 							./com_uddeim_j30/admin/
cp -vr ./com_uddeim/toolbar.uddeim.php 						./com_uddeim_j30/admin/

cp -vr ./com_uddeim/templates/images/*.* 						./com_uddeim_j30/site/templates/images/
cp -vr ./com_uddeim/templates/default/*.* 						./com_uddeim_j30/site/templates/default/
cp -vr ./com_uddeim/templates/default/animated/*.* 			./com_uddeim_j30/site/templates/default/animated/
cp -vr ./com_uddeim/templates/default/animated-extended/*.* 	./com_uddeim_j30/site/templates/default/animated-extended/
cp -vr ./com_uddeim/templates/default/css/*.* 					./com_uddeim_j30/site/templates/default/css/
cp -vr ./com_uddeim/templates/default/images/*.* 				./com_uddeim_j30/site/templates/default/images/

cp -vr ./com_uddeim/archive.php 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/autoload.php 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/bbparser.php 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/captcha.php 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/captcha15.php 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/cb_extra.php 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/crypt.class.php 		./com_uddeim_j30/site/
cp -vr ./com_uddeim/getpiclink.php 		./com_uddeim_j30/site/
cp -vr ./com_uddeim/inbox.php 				./com_uddeim_j30/site/
cp -vr ./com_uddeim/includes.db.php 		./com_uddeim_j30/site/
cp -vr ./com_uddeim/includes.php 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/index.html				./com_uddeim_j30/site/
cp -vr ./com_uddeim/json.php 				./com_uddeim_j30/site/
cp -vr ./com_uddeim/monofont.ttf 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/outbox.php 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/recaptchalib.php 		./com_uddeim_j30/site/
cp -vr ./com_uddeim/trashcan.php 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/uddeim.api.php 		./com_uddeim_j30/site/
cp -vr ./com_uddeim/uddeim.php 			./com_uddeim_j30/site/
cp -vr ./com_uddeim/uddeim_igoogle.xml 	./com_uddeim_j30/site/
cp -vr ./com_uddeim/uddeimlib*.php 		./com_uddeim_j30/site/
cp -vr ./com_uddeim/userlists.php 			./com_uddeim_j30/site/

cp -vr ./mod_uddeim/mod_uddeim.php			./mod_uddeim_j30/
cp -vr ./mod_uddeim/mod_uddeim/*.*			./mod_uddeim_j30/mod_uddeim/

cp -vr ./mod_uddeim_mailbox/mod_uddeim_mailbox.php 		./mod_uddeim_mailbox_j30/
cp -vr ./mod_uddeim_statistics/mod_uddeim_statistics.php 	./mod_uddeim_statistics_j30/
cp -vr ./plug_uddeim_contentlink/uddeim_contentlink.php 	./plug_uddeim_contentlink_j30/
cp -vr ./plug_uddeim_searchbot/uddeim_searchbot.php 		./plug_uddeim_searchbot_j30/

# ===================================================================================== ENGLISH ONLY

cp -vr ./com_uddeim_j16/admin/							./com_uddeim_j16_english_only/admin/
cp -vr ./com_uddeim_j16/admin/language/eng*.php		./com_uddeim_j16_english_only/admin/language/
cp -vr ./com_uddeim_j16/admin/language/index.*			./com_uddeim_j16_english_only/admin/language/
cp -vr ./com_uddeim_j16/admin/language/en-GB/			./com_uddeim_j16_english_only/admin/language/en-GB/
cp -vr ./com_uddeim_j16/admin/language/es-ES/			./com_uddeim_j16_english_only/admin/language/es-ES/
cp -vr ./com_uddeim_j16/admin/language/sv-SE/			./com_uddeim_j16_english_only/admin/language/sv-SE/
cp -vr ./com_uddeim_j16/admin/language.utf8/eng*.php	./com_uddeim_j16_english_only/admin/language.utf8/
cp -vr ./com_uddeim_j16/admin/language.utf8/index.*	./com_uddeim_j16_english_only/admin/language.utf8/
cp -vr ./com_uddeim_j16/admin/sql/						./com_uddeim_j16_english_only/admin/sql/
cp -vr ./com_uddeim_j16/admin/sql/updates/				./com_uddeim_j16_english_only/admin/sql/updates/
cp -vr ./com_uddeim_j16/ReCaptcha/*.php				./com_uddeim_j16_english_only/site/ReCaptcha/
cp -vr ./com_uddeim_j16/ReCaptcha/RequestMethod/*.php	./com_uddeim_j16_english_only/site/ReCaptcha/RequestMethod/

cp -vr ./com_uddeim/templates/images/*.* 						./com_uddeim_j16_english_only/site/templates/images/
cp -vr ./com_uddeim/templates/default/*.* 						./com_uddeim_j16_english_only/site/templates/default/
cp -vr ./com_uddeim/templates/default/animated/*.* 			./com_uddeim_j16_english_only/site/templates/default/animated/
cp -vr ./com_uddeim/templates/default/animated-extended/*.* 	./com_uddeim_j16_english_only/site/templates/default/animated-extended/
cp -vr ./com_uddeim/templates/default/css/*.* 					./com_uddeim_j16_english_only/site/templates/default/css/
cp -vr ./com_uddeim/templates/default/images/*.* 				./com_uddeim_j16_english_only/site/templates/default/images/

cp -vr ./com_uddeim_j16/site/							./com_uddeim_j16_english_only/site/
cp -vr ./com_uddeim_j16/site/js/						./com_uddeim_j16_english_only/site/js/
cp -vr ./com_uddeim_j16/site/language/en-GB/			./com_uddeim_j16_english_only/site/language/en-GB/
cp -vr ./com_uddeim_j16/site/language/es-ES/			./com_uddeim_j16_english_only/site/language/es-ES/
cp -vr ./com_uddeim_j16/site/language/sv-SE/			./com_uddeim_j16_english_only/site/language/sv-SE/
cp -vr ./com_uddeim_j16/site/views/select/tmpl/		./com_uddeim_j16_english_only/site/views/select/tmpl/

cp -vr ./com_uddeim_j16/*.*							./com_uddeim_j16_english_only/

# ===================================================================================== JOOMLA 3.0

cp -vr ./com_uddeim_j16/script.php						./com_uddeim_j30/
cp -vr ./com_uddeim_j16/admin/access.xml				./com_uddeim_j30/admin/
cp -vr ./com_uddeim_j16/admin/config.xml				./com_uddeim_j30/admin/

cp -vr ./com_uddeim_j16/admin/sql/						./com_uddeim_j30/admin/sql/
cp -vr ./com_uddeim_j16/admin/sql/updates/				./com_uddeim_j30/admin/sql/updates/

# ===================================================================================== CB 2.0

cp -vr ./cb_plug_pms_uddeim/*.php						./cb2_plug_pms_uddeim/
cp -vr ./cb_plug_pms_uddeim_blocking/*.php				./cb2_plug_pms_uddeim_blocking/
cp -vr ./cb_plug_pms_uddeim_inbox/*.php				./cb2_plug_pms_uddeim_inbox/
cp -vr ./cb_plug_pms_uddeim_profilelink/*.php			./cb2_plug_pms_uddeim_profilelink/

echo Done
