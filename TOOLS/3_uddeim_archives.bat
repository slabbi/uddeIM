set path=%path%;"C:\Program Files (x86)\WinZip"
set uddeim=uddeIM_4.0

cd %uddeIM%_unzip1st\
rd /s /q 	cb_plug_pms_uddeim
rd /s /q 	cb_plug_pms_uddeim_blocking
rd /s /q 	cb_plug_pms_uddeim_inbox
rd /s /q 	cb_plug_pms_uddeim_profilelink
rd /s /q 	cb2_plug_pms_uddeim
rd /s /q 	cb2_plug_pms_uddeim_blocking
rd /s /q 	cb2_plug_pms_uddeim_inbox
rd /s /q 	cb2_plug_pms_uddeim_profilelink

rd /s /q 	com_uddeim

rd /s /q 	mod_uddeim
rd /s /q 	mod_uddeim_mailbox
rd /s /q 	mod_uddeim_statistics

rd /s /q 	plug_uddeim_contentlink
rd /s /q 	plug_uddeim_searchbot
cd ..

cd %uddeIM%_j16_unzip1st\
rd /s /q 	cb_plug_pms_uddeim
rd /s /q 	cb_plug_pms_uddeim_blocking
rd /s /q 	cb_plug_pms_uddeim_inbox
rd /s /q 	cb_plug_pms_uddeim_profilelink
rd /s /q 	cb2_plug_pms_uddeim
rd /s /q 	cb2_plug_pms_uddeim_blocking
rd /s /q 	cb2_plug_pms_uddeim_inbox
rd /s /q 	cb2_plug_pms_uddeim_profilelink

rd /s /q 	com_uddeim_j16
rd /s /q 	com_uddeim_j16_english_only

rd /s /q 	mod_uddeim_j16
rd /s /q 	mod_uddeim_mailbox_j16
rd /s /q 	mod_uddeim_statistics_j16

rd /s /q 	plug_uddeim_contentlink_j16
rd /s /q 	plug_uddeim_searchbot_j16
cd ..

cd %uddeIM%_j30_unzip1st\
rd /s /q 	cb_plug_pms_uddeim
rd /s /q 	cb_plug_pms_uddeim_blocking
rd /s /q 	cb_plug_pms_uddeim_inbox
rd /s /q 	cb_plug_pms_uddeim_profilelink
rd /s /q 	cb2_plug_pms_uddeim
rd /s /q 	cb2_plug_pms_uddeim_blocking
rd /s /q 	cb2_plug_pms_uddeim_inbox
rd /s /q 	cb2_plug_pms_uddeim_profilelink

rd /s /q 	com_uddeim_j30

rd /s /q 	mod_uddeim_j30
rd /s /q 	mod_uddeim_mailbox_j30
rd /s /q 	mod_uddeim_statistics_j30

rd /s /q 	plug_uddeim_contentlink_j30
rd /s /q 	plug_uddeim_hooks_j30
rd /s /q 	plug_uddeim_searchbot_j30
cd ..

wzzip -arP 	%uddeIM%_unzip1st.zip 					%uddeIM%_unzip1st\*.*
wzzip -arP 	%uddeIM%_j16_unzip1st.zip 				%uddeIM%_j16_unzip1st\*.*
wzzip -arP 	%uddeIM%_j30_unzip1st.zip 				%uddeIM%_j30_unzip1st\*.*
pause
