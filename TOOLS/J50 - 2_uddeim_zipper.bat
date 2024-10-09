set path=%path%;"C:\Program Files\7-Zip"
set uddeim=uddeIM_5.6

cd %uddeIM%_j50_unzip1st\
7z a -tzip -r cb2_plug_pms_uddeim_j50.zip 					cb2_plug_pms_uddeim_j50\*.*
7z a -tzip -r cb2_plug_pms_uddeim_blocking_j50.zip 			cb2_plug_pms_uddeim_blocking_j50\*.*
7z a -tzip -r cb2_plug_pms_uddeim_inbox_j50.zip 			cb2_plug_pms_uddeim_inbox_j50\*.*
7z a -tzip -r cb2_plug_pms_uddeim_profilelink_j50.zip 		cb2_plug_pms_uddeim_profilelink_j50\*.*

7z a -tzip -r com_uddeim_j50.zip 							com_uddeim_j50\*.*

7z a -tzip -r mod_uddeim_j50.zip 							mod_uddeim_j50\*.*
7z a -tzip -r mod_uddeim_mailbox_j50.zip 					mod_uddeim_mailbox_j50\*.*
7z a -tzip -r mod_uddeim_simple_notifier_j50.zip 			mod_uddeim_simple_notifier_j50\*.*
7z a -tzip -r mod_uddeim_statistics_j50.zip 				mod_uddeim_statistics_j50\*.*

7z a -tzip -r pkg_uddeim_search_j50.zip 					pkg_uddeim_search_j50\*.*

7z a -tzip -r plug_uddeim_contentlink_j50.zip 				plug_uddeim_contentlink_j50\*.*
7z a -tzip -r plug_uddeim_hooks_j50.zip 					plug_uddeim_hooks_j50\*.*
7z a -tzip -r plug_uddeim_searchbot_j50.zip 				plug_uddeim_searchbot_j50\*.*
cd ..

pause
