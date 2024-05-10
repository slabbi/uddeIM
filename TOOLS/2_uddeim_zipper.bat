set path=%path%;"C:\Program Files (x86)\WinZip"
set uddeim=uddeIM_4.0

cd %uddeIM%_unzip1st\
wzzip -arP 	cb_plug_pms_uddeim.zip 					cb_plug_pms_uddeim\*.*
wzzip -arP 	cb_plug_pms_uddeim_blocking.zip 		cb_plug_pms_uddeim_blocking\*.*
wzzip -arP 	cb_plug_pms_uddeim_inbox.zip 			cb_plug_pms_uddeim_inbox\*.*
wzzip -arP 	cb_plug_pms_uddeim_profilelink.zip	 	cb_plug_pms_uddeim_profilelink\*.*
wzzip -arP 	cb2_plug_pms_uddeim.zip 				cb2_plug_pms_uddeim\*.*
wzzip -arP 	cb2_plug_pms_uddeim_blocking.zip 		cb2_plug_pms_uddeim_blocking\*.*
wzzip -arP 	cb2_plug_pms_uddeim_inbox.zip 			cb2_plug_pms_uddeim_inbox\*.*
wzzip -arP 	cb2_plug_pms_uddeim_profilelink.zip 	cb2_plug_pms_uddeim_profilelink\*.*

wzzip -arP 	com_uddeim.zip 							com_uddeim\*.*

wzzip -arP 	mod_uddeim.zip 							mod_uddeim\*.*
wzzip -arP 	mod_uddeim_mailbox.zip 					mod_uddeim_mailbox\*.*
wzzip -arP 	mod_uddeim_statistics.zip 				mod_uddeim_statistics\*.*

wzzip -arP 	plug_uddeim_contentlink.zip 			plug_uddeim_contentlink\*.*
wzzip -arP 	plug_uddeim_searchbot.zip 				plug_uddeim_searchbot\*.*
cd ..

cd %uddeIM%_j16_unzip1st\
wzzip -arP 	cb_plug_pms_uddeim.zip 					cb_plug_pms_uddeim\*.*
wzzip -arP 	cb_plug_pms_uddeim_blocking.zip 		cb_plug_pms_uddeim_blocking\*.*
wzzip -arP 	cb_plug_pms_uddeim_inbox.zip 			cb_plug_pms_uddeim_inbox\*.*
wzzip -arP 	cb_plug_pms_uddeim_profilelink.zip	 	cb_plug_pms_uddeim_profilelink\*.*
wzzip -arP 	cb2_plug_pms_uddeim.zip 				cb2_plug_pms_uddeim\*.*
wzzip -arP 	cb2_plug_pms_uddeim_blocking.zip 		cb2_plug_pms_uddeim_blocking\*.*
wzzip -arP 	cb2_plug_pms_uddeim_inbox.zip 			cb2_plug_pms_uddeim_inbox\*.*
wzzip -arP 	cb2_plug_pms_uddeim_profilelink.zip 	cb2_plug_pms_uddeim_profilelink\*.*

wzzip -arP 	com_uddeim_j16.zip 						com_uddeim_j16\*.*
wzzip -arP 	com_uddeim_j16_english_only.zip 		com_uddeim_j16_english_only\*.*

wzzip -arP 	mod_uddeim_j16.zip 						mod_uddeim_j16\*.*
wzzip -arP 	mod_uddeim_mailbox_j16.zip 				mod_uddeim_mailbox_j16\*.*
wzzip -arP 	mod_uddeim_statistics_j16.zip 			mod_uddeim_statistics_j16\*.*

wzzip -arP 	plug_uddeim_contentlink_j16.zip 		plug_uddeim_contentlink_j16\*.*
wzzip -arP 	plug_uddeim_searchbot_j16.zip 			plug_uddeim_searchbot_j16\*.*
cd ..

cd %uddeIM%_j30_unzip1st\
wzzip -arP 	cb_plug_pms_uddeim.zip 					cb_plug_pms_uddeim\*.*
wzzip -arP 	cb_plug_pms_uddeim_blocking.zip 		cb_plug_pms_uddeim_blocking\*.*
wzzip -arP 	cb_plug_pms_uddeim_inbox.zip 			cb_plug_pms_uddeim_inbox\*.*
wzzip -arP 	cb_plug_pms_uddeim_profilelink.zip	 	cb_plug_pms_uddeim_profilelink\*.*
wzzip -arP 	cb2_plug_pms_uddeim.zip 				cb2_plug_pms_uddeim\*.*
wzzip -arP 	cb2_plug_pms_uddeim_blocking.zip 		cb2_plug_pms_uddeim_blocking\*.*
wzzip -arP 	cb2_plug_pms_uddeim_inbox.zip 			cb2_plug_pms_uddeim_inbox\*.*
wzzip -arP 	cb2_plug_pms_uddeim_profilelink.zip 	cb2_plug_pms_uddeim_profilelink\*.*

wzzip -arP 	com_uddeim_j30.zip 						com_uddeim_j30\*.*

wzzip -arP 	mod_uddeim_j30.zip 						mod_uddeim_j30\*.*
wzzip -arP 	mod_uddeim_mailbox_j30.zip 				mod_uddeim_mailbox_j30\*.*
wzzip -arP 	mod_uddeim_statistics_j30.zip 			mod_uddeim_statistics_j30\*.*

wzzip -arP 	plug_uddeim_contentlink_j30.zip 		plug_uddeim_contentlink_j30\*.*
wzzip -arP 	plug_uddeim_hooks_j30.zip 				plug_uddeim_hooks_j30\*.*
wzzip -arP 	plug_uddeim_searchbot_j30.zip 			plug_uddeim_searchbot_j30\*.*
cd ..

pause
