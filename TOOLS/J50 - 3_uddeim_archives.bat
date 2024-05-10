set path=%path%;"C:\Program Files\7-Zip"
set uddeim=uddeIM_5.3

cd %uddeIM%_j50_unzip1st\
rd /s /q 	cb2_plug_pms_uddeim_j50
rd /s /q 	cb2_plug_pms_uddeim_blocking_j50
rd /s /q 	cb2_plug_pms_uddeim_inbox_j50
rd /s /q 	cb2_plug_pms_uddeim_profilelink_j50

rd /s /q 	com_uddeim_j50

rd /s /q 	mod_uddeim_j50
rd /s /q 	mod_uddeim_mailbox_j50
rd /s /q 	mod_uddeim_simple_notifier_j50
rd /s /q 	mod_uddeim_statistics_j50

rd /s /q 	plug_uddeim_contentlink_j50
rd /s /q 	plug_uddeim_hooks_j50
rd /s /q 	plug_uddeim_searchbot_j50
cd ..

7z a -tzip -r	%uddeIM%_j50_unzip1st.zip 		%uddeIM%_j50_unzip1st\*.*
pause
