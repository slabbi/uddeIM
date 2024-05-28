set path=%path%;"C:\Program Files (x86)\WinZip"
set uddeim=uddeIM_5.4

md %uddeIM%_j50_unzip1st
rem xcopy /e "..\github\uddeIM-github\3rd party"						"%uddeIM%_j50_unzip1st\3rd party\"
xcopy /e "..\github\uddeIM-github\DEVELOPER"							"%uddeIM%_j50_unzip1st\DEVELOPER\"
xcopy /e "..\github\uddeIM-github\EXTRAS"								"%uddeIM%_j50_unzip1st\EXTRAS\"
xcopy /e "..\github\uddeIM-github\LANGUAGES"							"%uddeIM%_j50_unzip1st\LANGUAGES\"
xcopy /e "..\github\uddeIM-github\LICENSES"								"%uddeIM%_j50_unzip1st\LICENSES\"
xcopy /e "..\github\uddeIM-github\README"								"%uddeIM%_j50_unzip1st\README\"
xcopy /e "..\github\uddeIM-github\cb2_plug_pms_uddeim_j50"				"%uddeIM%_j50_unzip1st\cb2_plug_pms_uddeim_j50\"
xcopy /e "..\github\uddeIM-github\cb2_plug_pms_uddeim_blocking_j50"		"%uddeIM%_j50_unzip1st\cb2_plug_pms_uddeim_blocking_j50\"
xcopy /e "..\github\uddeIM-github\cb2_plug_pms_uddeim_inbox_j50"		"%uddeIM%_j50_unzip1st\cb2_plug_pms_uddeim_inbox_j50\"
xcopy /e "..\github\uddeIM-github\cb2_plug_pms_uddeim_profilelink_j50"	"%uddeIM%_j50_unzip1st\cb2_plug_pms_uddeim_profilelink_j50\"
xcopy /e "..\github\uddeIM-github\com_uddeim_j50"						"%uddeIM%_j50_unzip1st\com_uddeim_j50\"
xcopy /e "..\github\uddeIM-github\mod_uddeim_j50"						"%uddeIM%_j50_unzip1st\mod_uddeim_j50\"
xcopy /e "..\github\uddeIM-github\mod_uddeim_mailbox_j50"				"%uddeIM%_j50_unzip1st\mod_uddeim_mailbox_j50\"
xcopy /e "..\github\uddeIM-github\mod_uddeim_simple_notifier_j50"		"%uddeIM%_j50_unzip1st\mod_uddeim_simple_notifier_j50\"
xcopy /e "..\github\uddeIM-github\mod_uddeim_statistics_j50"			"%uddeIM%_j50_unzip1st\mod_uddeim_statistics_j50\"
xcopy /e "..\github\uddeIM-github\plug_uddeim_contentlink_j50"			"%uddeIM%_j50_unzip1st\plug_uddeim_contentlink_j50\"
xcopy /e "..\github\uddeIM-github\plug_uddeim_hooks_j50"				"%uddeIM%_j50_unzip1st\plug_uddeim_hooks_j50\"
xcopy /e "..\github\uddeIM-github\plug_uddeim_searchbot_j50"			"%uddeIM%_j50_unzip1st\plug_uddeim_searchbot_j50\"
echo. >	"%uddeIM%_j50_unzip1st\%uddeIM%.txt"
rem copy     "..\github\uddeIM-github\MANUALS\FAQ.pdf"					"%uddeIM%_j50_unzip1st\"							

pause
