This version of uddeIM (5.x) is based on version 4.x and recoded 
to run on Joomla v5.0+ only.

Because of the strict namespace requirements this code is not 
backward compatible to earlier Joomla versions.

Earlier libraries included in v4.x have been removed so there are 
only the two libs included for use with Joomla 5:
- admin.uddeimlib50.php
- uddeimlib50.php

The many version checks within the different files have not been 
removed, but the admin.uddeimlib.php, which selects the right 
library, is gone.
Caution: if you use cb-plugins the uddeimlib.php is NEEDED.

for the backend styling there is a new admin.uddeim5.css file,
which takes the new backend styling and now is placed in an
admin folder within the templates folder.

if you want to create your own admin css within a special
template schema you must also name it admin.uddeim5.css
(the script first looks in the template folders)

Also all old modules and plugins have been removed. Included 
modules and plugins have been tested to run on Joomla 5.

Premium files must not be installed separately and are included
in the main package.

The Postbox Plugin is still experimental. Use it on your own risk!

Please refer to the "File attachments plugin" chapter in the FAQ
when installing the File attachments plugin. When doing an upgrade
you need to create a folder manually and you should copy two files
into that folder, so people cannot access files directly. 
These files - "index.html" and ".htaccess" - can be found in the 
folder "support".

More information can be found in the FAQ.

Have Fun

