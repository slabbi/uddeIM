@echo off

echo This script converts all ISO files (used by Joomla 1.0)
echo to UTF-8 (used by Joomla 1.5), so only the ISO part
echo must be maintained.
echo.
echo Some files do not exist as ISO (e.g. greek.php). These
echo files are copied without conversion from the ISO folder
echo to the UTF-8 folder.
echo.
echo You can run this script to convert/update all files at 
echo once.
echo.
echo.
echo vietnamese.php - DO NOTHING DUE TO USED CHARACTER SET
echo                  cannot be converted automatically
echo.
echo.
pause

rem LATIN-1 to UTF-8
if exist ..\language\brazilian_portuguese.php 	iconv -f latin1 -t utf-8 ..\language\brazilian_portuguese.php > ..\language.utf8\brazilian_portuguese.php
if exist ..\language\catalan.php	     	iconv -f latin1 -t utf-8 ..\language\catalan.php     > ..\language.utf8\catalan.php
if exist ..\language\danish.php  	    	iconv -f latin1 -t utf-8 ..\language\danish.php      > ..\language.utf8\danish.php
if exist ..\language\dutch.php    	   	iconv -f latin1 -t utf-8 ..\language\dutch.php       > ..\language.utf8\dutch.php
if exist ..\language\english.php  	   	iconv -f latin1 -t utf-8 ..\language\english.php     > ..\language.utf8\english.php
if exist ..\language\finnish.php  	   	iconv -f latin1 -t utf-8 ..\language\finnish.php     > ..\language.utf8\finnish.php
if exist ..\language\french.php   	   	iconv -f latin1 -t utf-8 ..\language\french.php      > ..\language.utf8\french.php
if exist ..\language\germanf.php   	  	iconv -f latin1 -t utf-8 ..\language\germanf.php     > ..\language.utf8\germanf.php
if exist ..\language\germani.php  	   	iconv -f latin1 -t utf-8 ..\language\germani.php     > ..\language.utf8\germani.php
if exist ..\language\italian.php  	   	iconv -f latin1 -t utf-8 ..\language\italian.php     > ..\language.utf8\italian.php
if exist ..\language\norwegian.php  	 	iconv -f latin1 -t utf-8 ..\language\norwegian.php   > ..\language.utf8\norwegian.php
if exist ..\language\romanian.php  	  	iconv -f latin1 -t utf-8 ..\language\romanian.php    > ..\language.utf8\romanian.php
if exist ..\language\spanish.php   	  	iconv -f latin1 -t utf-8 ..\language\spanish.php     > ..\language.utf8\spanish.php
if exist ..\language\swedish.php  	   	iconv -f latin1 -t utf-8 ..\language\swedish.php     > ..\language.utf8\swedish.php

rem already UTF-8
if exist ..\language\czech.php  		copy /b /y ..\language\czech.php   		..\language.utf8\czech.php
if exist ..\language\greek.php   		copy /b /y ..\language\greek.php   		..\language.utf8\greek.php
if exist ..\language\serbian.php   		copy /b /y ..\language\serbian.php   		..\language.utf8\serbian.php
if exist ..\language\serbian_lat.php   	copy /b /y ..\language\serbian_lat.php   	..\language.utf8\serbian_lat.php
if exist ..\language\simplified_chinese.php	copy /b /y ..\language\simplified_chinese.php   ..\language.utf8\simplified_chinese.php
if exist ..\language\traditional_chinese.php	copy /b /y ..\language\traditional_chinese.php  ..\language.utf8\traditional_chinese.php

rem ISO-8859-2
if exist ..\language\polish.php  	iconv -f iso-8859-2 -t utf-8 ..\language\polish.php  > ..\language.utf8\polish.php
if exist ..\language\hungarian.php 	iconv -f iso-8859-2 -t utf-8 ..\language\hungarian.php > ..\language.utf8\hungarian.php

rem ISO-8859-9
if exist ..\language\turkish.php 	iconv -f iso-8859-9 -t utf-8 ..\language\turkish.php > ..\language.utf8\turkish.php

rem CP1250
if exist ..\language\hrvatski.php    	iconv -f cp1250 -t utf-8 ..\language\hrvatski.php    > ..\language.utf8\hrvatski.php

rem CP1251
if exist ..\language\bulgarian.php   	iconv -f cp1251 -t utf-8 ..\language\bulgarian.php   > ..\language.utf8\bulgarian.php
if exist ..\language\russian.php     	iconv -f cp1251 -t utf-8 ..\language\russian.php     > ..\language.utf8\russian.php

rem CP1255
if exist ..\language\hebrew.php      	iconv -f cp1255 -t utf-8 ..\language\hebrew.php      > ..\language.utf8\hebrew.php

rem CP1256
if exist ..\language\arabic.php      	iconv -f cp1256 -t utf-8 ..\language\arabic.php      > ..\language.utf8\arabic.php

pause
