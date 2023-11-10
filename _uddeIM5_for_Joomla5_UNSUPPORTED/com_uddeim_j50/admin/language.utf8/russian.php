<?php
// *******************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2011 Stephan Slabihoud, © 2006 Benjamin Zweifel
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
// *******************************************************************

// Language file: Russian  (source file is CP1251)
// Language file: russian.php (saved in UTF-8 without BOM)
// Translation: by Dmitriy Kindeev at www.freedom-ru.net, info@freedom-ru.net, 
// v.1.2:     by Eugene Sivokon at www.joomlaclub.ru, general@cre-active.eu,
// v.2.0/2.1:  by Alexander Smirnov, at www.joomlapolis.com. 23 February 2011.
// v.2.2/2.3/2.4/2.9/3.1/3.5/3.6/3.7:  by Alex (aka Alexej) Khoroshevsky, at www.aleksius.com. 28 May 2015
// v.2.6/2.7: by Alex (aka Alexander) Smirnov, at twitter.com/joomladka, 28 February 2012

// *******************************************************************
DEFINE ('_UDDEADM_TRANSLATORS_CREDITS', 'Перевели на русский язык: <ul><li>Дмитрий Киндеев, www.freedom-ru.net, info@freedom-ru.net</li><li>Евгений Сивоконь, www.joomlaclub.ru, general@cre-active.eu</li><li>Александр Смирнов, twitter.com/joomladka</li><li> Алексей Хорошевский,www.aleksius.com</li></ul> ');	// Empty for English and German language files, enter your credits line here, e.g. 'Translation by <a href="http://domain.com" target="_new">John Doe</a>'

// New: 3.8
DEFINE ('_UDDEADM_CAPTCHA_RECAPTCHA2', 'reCaptcha 2.0');
DEFINE ('_UDDEADM_CB2', 'Community Builder 2.0+');

// New: 3.7
DEFINE ('_UDDEADM_SHOWMENULINK_HEAD', 'Показывать пункт меню');
DEFINE ('_UDDEADM_SHOWMENULINK_EXP', 'Показывать дополнительный пункт меню.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_16', '...установка дополнительных ссылок меню по умолчанию');

// New: 3.6
DEFINE ('_UDDEIM_KUNENA_LINK', 'Форум');
DEFINE ('_UE_PM_USER', 'Отправить личное сообщение');
DEFINE ('_UE_MENU_PM_USER_DESC', 'Отправить личное сообщение этому пользователю');
DEFINE ('_UE_PM_INBOX', 'Показать входящие личные сообщения');
DEFINE ('_UE_MENU_PM_INBOX_DESC', 'Показать полученные личные сообщения');
DEFINE ('_UE_PM_OUTBOX', 'Показать исходящие личные сообщения');
DEFINE ('_UE_MENU_PM_OUTBOX_DESC', 'Показать исходящие личные сообщения');
DEFINE ('_UE_PM_TRASHBOX', 'Показать корзину');
DEFINE ('_UE_MENU_PM_TRASHBOX_DESC', 'Показать личные сообщения в корзине');
DEFINE ('_UE_PM_OPTIONS', 'Показать настройки СЛС');
DEFINE ('_UE_MENU_PM_OPTIONS_DESC', 'Показать настройки СЛС');
DEFINE ('_UE_PM_SENDMESSAGE', 'Сообщение отправлено');
DEFINE ('_UE_PMSTAB', 'Отправить сообщение');

// New: 3.5
DEFINE ('_UDDEADM_GROUPSADMIN_HEAD', 'Дополнительные группы администраторов');
DEFINE ('_UDDEADM_GROUPSADMIN_EXP', 'Введите ID групп, которые должны рассматриваться как группы администраторов (например, 10, 11, 17). ID 7, 8 (Joomla >=1.6) и ID 24, 25 (Joomla <=1.5) это всегда группы администраторов.');
DEFINE ('_UDDEADM_GROUPSSPECIAL_HEAD', 'Дополнительные специальные группы');
DEFINE ('_UDDEADM_GROUPSSPECIAL_EXP', 'Введите ID групп, которые должны рассматриваться как специальные группы (например, 10, 11, 17). ID 3-8 (Joomla >=1.6) и ID 19-25 (Joomla <=1.5) это всегда специальные пользователи.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_15', '...установка дополнительных групп по умолчанию');

// New: 3.3
DEFINE ('_UDDEADM_KUNENA30', 'Kunena 3.0+');

// New: 3.1
DEFINE ('_UDDEIM_BADWORD', 'Определение нецензурных слов');
DEFINE ('_UDDEADM_BADWORDS_HEAD', 'Фильтр нецензурных слов');
DEFINE ('_UDDEADM_BADWORDS_EXP', 'Новые сообщения будут фильтроваться на предмет цензуры. Все нецензурные слова должны разделяться точкой с запятой (;).');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_14', '…настройка по умолчанию фильтра нецензурных слов');
DEFINE ('_UDDEADM_OOD_PB', 'Плагин почтового ящика не актуален!');

// New: 3.0
DEFINE ('_UDDEADM_UDDEIM', 'uddeIM');
DEFINE ('_UDDEADM_REPLYTEXT_HEAD', 'Автоответ');
DEFINE ('_UDDEADM_REPLYTEXT_EXP', 'Оригинальное сообщение будет добавлено автоматически, как только Вы ответите на сообщение.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_13', '...установка настроек по умолчанию для ответов (опции)');

// New: 2.9
DEFINE ('_UDDEADM_KUNENA20', 'Kunena 2.0+');
DEFINE ('_UDDEADM_POSTBOXFULL_HEAD', 'Полный текст сообщения');
DEFINE ('_UDDEADM_POSTBOXFULL_EXP', 'Отображать полный текст сообщения для первого или всех сообщений или не отображать ни для каких.');
DEFINE ('_UDDEADM_POSTBOXFULL_0', 'Ни для каких');
DEFINE ('_UDDEADM_POSTBOXFULL_1', 'Первое');
DEFINE ('_UDDEADM_POSTBOXFULL_2', 'Все');
DEFINE ('_UDDEADM_POSTBOXAVATARS_HEAD', 'Отображать аватары');
DEFINE ('_UDDEADM_POSTBOXAVATARS_EXP', 'Отображать аватары в сообщениях.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_12', '...настройка опций почтового ящика по умолчанию');

// New: 2.8
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_11', '...настройка по умолчанию для почтового ящика');
DEFINE ('_UDDEADM_POSTBOX_HEAD', 'Включить Почтовый ящик');
DEFINE ('_UDDEADM_POSTBOX_EXP', 'Включить Почтовый ящик.');
DEFINE ('_UDDEIM_FILTER_TITLE_POSTBOX', 'Показывать входящие/исходящие только для этого пользователя');
DEFINE ('_UDDEIM_MESSAGES', 'Сообщения');
DEFINE ('_UDDEIM_POSTBOX', ' Почтовый ящик ');
DEFINE ('_UDDEIM_FILTEREDUSER', 'пользователь отфильтрован');
DEFINE ('_UDDEIM_FILTEREDUSERS', 'пользователи отфильтрованы');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_POSTBOX', ' почтовый ящик');
DEFINE ('_UDDEIM_NOMESSAGES_POSTBOX', 'У Вас нет сообщений в почтовом ящике.');
DEFINE ('_UDDEIM_DISPLAY', 'Отобразить');
DEFINE ('_UDDEIM_HELP_POSTBOX', '<b>Почтовый ящик</b> содержит все ваши входящие и исходящие сообщения.');
DEFINE ('_UDDEIM_HELP_PREAD', 'Сообщение прочтено (входящие=Вы можете сменить статус).');
DEFINE ('_UDDEIM_HELP_PUNREAD', 'Сообщение всё ещё не прочтено (входящие=Вы можете сменить статус).');

// New: 2.7
DEFINE ('_UDDEADM_MOOTOOLS_NONEMEIO', 'Не загружать библиотеку MooTools (использовать MEIO)');
DEFINE ('_UDDEADM_MOOTOOLS_13MEIO', 'Принудить загрузку библиотеки MooTools 1.3 (использовать MEIO)');

// New: 2.6
DEFINE ('_UDDEADM_DONTSEFMSGLINK_HEAD', 'Нет ЧПУ для %msglink%');
DEFINE ('_UDDEADM_DONTSEFMSGLINK_EXP', 'Не используйте ЧПУ для %msglink% почтовых уведомлений.');
DEFINE ('_UDDEADM_STIME_HEAD', 'Использовать специальные календари');
DEFINE ('_UDDEADM_STIME_EXP', 'Если активировать данную опцию, то при и использовании языкового файла фарси языка будет использоваться персидский календарь');
DEFINE ('_UDDEADM_RESTRICTREM_HEAD', 'Удалять отсутствующие связи');
DEFINE ('_UDDEADM_RESTRICTREM_EXP', 'Автоматически удалите отсутствующие связи. Это сократит существующий список контактов.');
DEFINE ('_UDDEADM_RESTRICTCON_HEAD', 'Показывать только связи');
DEFINE ('_UDDEADM_RESTRICTCON_EXP', 'Пользователи, показанные в списке, могут быть ограничены связями CB/CBE/JS (не распространяется на пользователей, находящихся вне списка пользователей).');
DEFINE ('_UDDEADM_RESTRICTCON0', 'отключено');
DEFINE ('_UDDEADM_RESTRICTCON1', 'зарегистрированные пользователи');
DEFINE ('_UDDEADM_RESTRICTCON2', 'зарегистрированные, специальные пользователи');
DEFINE ('_UDDEADM_RESTRICTCON3', 'все пользователи (включая администраторов)');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_10', '…установить по умолчанию для отображения связей');

// New: 2.4
DEFINE ('_UDDEIM_SECURITYCODE', 'Код безопасности:');

// New: 2.3
DEFINE ('_UDDEADM_CC_HEAD', 'Кнопка "Показать CC: строку"');
DEFINE ('_UDDEADM_CC_EXP', 'Если включено, пользователи могут выбрать должен ли uddeIM добавлять всех пользователей CC: строки в получатели сообщения или нет.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_9', '...настройка по умолчанию для CC: строка, и модерация');
DEFINE ('_UDDEIM_TOOLBAR_MCP', 'Центр сообщений');
DEFINE ('_UDDEIM_TOOLBAR_REMOVEMESSAGE', 'Удалить сообщение');
DEFINE ('_UDDEIM_TOOLBAR_DELIVERMESSAGE', 'Доставленное сообщение');
DEFINE ('_UDDEADM_OOD_MCP', 'Message Center плагин устарел!');
DEFINE ('_UDDEADM_MCP_STAT', 'Сообщения для модерации:');
DEFINE ('_UDDEADM_MCP_TRASHED', 'Удалено');
DEFINE ('_UDDEADM_MCP_NOTEDEL', 'Удалить эти сообщения из базы данных?');
DEFINE ('_UDDEADM_MCP_NOTEDELIVER', 'Доставить эти сообщения адресату?');
DEFINE ('_UDDEADM_MCP_SHOWHIDE', 'Показать\Скрыть');
DEFINE ('_UDDEADM_MCP_EDIT', 'Центр контроля сообщений');
DEFINE ('_UDDEADM_MCP_FROM', 'от');
DEFINE ('_UDDEADM_MCP_TO', 'к');
DEFINE ('_UDDEADM_MCP_TEXT', 'Сообщение');
DEFINE ('_UDDEADM_MCP_DELETE', 'Удалить');
DEFINE ('_UDDEADM_MCP_DATE', 'Дата');
DEFINE ('_UDDEADM_MCP_DELIVER', 'Доставлено');
DEFINE ('_UDDEADM_USERSET_MODERATE', 'Мод');
DEFINE ('_UDDEADM_USERSET_SELMODERATE', '- Мод -');
DEFINE ('_UDDEIM_MCP_MODERATED', 'Ваши сообщения ожидают модерации. Модератор проверит их перед тем, как они будут доставлены адресату.');
DEFINE ('_UDDEIM_STATUS_DELAYED', 'Ожидает модерации');
DEFINE ('_UDDEADM_MODNEWUSERS_HEAD', 'Модерация новых пользователей');
DEFINE ('_UDDEADM_MODNEWUSERS_EXP', 'Если включено, то сообщения от вновь зарегистрированных пользователей будут проходить модерацию по умолчанию.');
DEFINE ('_UDDEADM_MODPUBUSERS_HEAD', 'Модерация не зарегистрированных пользователей');
DEFINE ('_UDDEADM_MODPUBUSERS_EXP', 'Если включено, то сообщения от не зарегистрированных пользователей будут проходить модерацию.');
DEFINE ('_UDDEIM_MENUICONS_P3', 'Нет меню');

// New: 2.2
DEFINE ('_UDDEADM_OOD_PF', 'Public Frontend плагин устарел!');
DEFINE ('_UDDEADM_OOD_A', 'File Attachment плагин устарел!');
DEFINE ('_UDDEADM_OOD_RSS', 'RSS плагин устарел!');
DEFINE ('_UDDEADM_OOD_ASC', 'Message Report Center плагин устарел!');
DEFINE ('_UDDEIM_NOMESSAGES3_FILTERED', '<b>В папке %s нет сообщений по результатам фильтрации.</b>');
DEFINE ('_UDDEIM_FILTER_UNREAD', 'не прочитано');
DEFINE ('_UDDEIM_FILTER_FLAGGED', 'избранное');
DEFINE ('_UDDEADM_GRAVATAR_HEAD', ' Gravatar  включён');
DEFINE ('_UDDEADM_GRAVATAR_EXP', 'Включить поддержку Gravatar');
DEFINE ('_UDDEADM_GRAVATARD_HEAD', 'Изображения Gravatar ');
DEFINE ('_UDDEADM_GRAVATARD_EXP', 'Выбрать изображения по умолчанию.');
DEFINE ('_UDDEADM_GRAVATARR_HEAD', 'рейтинг Gravatar');
DEFINE ('_UDDEADM_GRAVATARR_EXP', 'По умолчанию только "G" рейтинг изображений показан до тех пор, пока Вы не укажете более высокий. "X" отображаються все изображения Gravatar.');
DEFINE ('_UDDEADM_GR404', '404');
DEFINE ('_UDDEADM_GRMM', 'мм');
DEFINE ('_UDDEADM_GRIDENTICON', 'identicon');
DEFINE ('_UDDEADM_GRMONSTERID', 'monsterid');
DEFINE ('_UDDEADM_GRWAVATAR', 'Gravatar');
DEFINE ('_UDDEADM_GRRETRO', 'ретро');
DEFINE ('_UDDEADM_GRDEFAULT', 'по умолчанию');
DEFINE ('_UDDEADM_GRG', 'G = Основной');
DEFINE ('_UDDEADM_GRPG', 'PG = Родительское руководство');
DEFINE ('_UDDEADM_GRR', 'R = Ограниченный');
DEFINE ('_UDDEADM_GRX', 'X = Только для взрослых');
DEFINE ('_UDDEADM_NINJABOARD', 'Ninjaboard');
DEFINE ('_UDDEADM_KUNENA16', 'Kunena 1.6+');
DEFINE ('_UDDEIM_PROCESSING', 'Обработка...');
DEFINE ('_UDDEIM_SEND_NONOTIFY', 'Не посылать оповещение по emails');
DEFINE ('_UDDEIM_SYSGM_NONOTIFY', 'Email оповещение не будет послано');
DEFINE ('_UDDEIM_SYSGM_FORCEEMBEDDED', 'Текст будет вставлен в оповещение по email');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_8', '… выставить по умолчанию для миниатюры');
DEFINE ('_UDDEADM_AVATARWH_HEAD', 'Показать размер миниатюры');
DEFINE ('_UDDEADM_AVATARWH_EXP', 'Длина и высота (в пикселях) миниатюр (0 = размер не будет изменён).');
DEFINE ('_UDDEIM_SAVE', 'Сохранить');

// New: 2.1
DEFINE ('_UDDEIM_BODY_SPAMREPORT',
"Приветствуем %you%, %touser% доложил о подозрительном сообщении от %fromuser%. Пожалуйста зайдите на сайт и проверьте! %livesite%");
DEFINE ('_UDDEIM_SUBJECT_SPAMREPORT', 'О сообщении было доложено на сайте %site%');
DEFINE ('_UDDEADM_KBYTES', 'КБ');
DEFINE ('_UDDEADM_MBYTES', 'МБ');
DEFINE ('_UDDEIM_ATT_FILEDELETED', 'Файл был удален');
DEFINE ('_UDDEIM_ATT_FILENOTEXISTS', 'Ошибка: файл не существует');
DEFINE ('_UDDEIM_ATTACHMENTS2', 'Вложения файлов (макс. %s на один файл):');
DEFINE ('_UDDEADM_JOOCM', 'Joo!CM');
DEFINE ('_UDDEADM_UNPROTECTATTACHMENT_HEAD', 'Незащищенная загрузка файлов');
DEFINE ('_UDDEADM_UNPROTECTATTACHMENT_EXP', 'Обычно uddeIM не открывает путь к файлу вложения на сервере, чтобы никто, даже если имя файла известно, не смог скачать этот файл. Включение этой опции вынудит uddeIM возвращать полный путь к файлу на сервере. В целях защиты, uddeIM добавляет к начальному имени файла MD5 хэш. Когда полный путь к файлу известен, пользователи могут скачать файл напрямую! Используйте эту опцию осторожно! ПРЕЖДЕ ЧЕМ ЗАДЕЙСТВОВАТЬ ЕЁ, ЧИТАЙТЕ ДОКУМЕНТЫ И FAQ!');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_7', '...настройка по умолчанию для вложения файлов и страниц с общим доступом');
DEFINE ('_UDDEIM_FILETYPE_NOTALLOWED', 'Тип файла не разрешен');
DEFINE ('_UDDEADM_ALLOWEDEXTENSIONS_HEAD', 'Расширения разрешены');
DEFINE ('_UDDEADM_ALLOWEDEXTENSIONS_EXP', 'Введите все разрешенные расширения (разделяя их знаком ";"). В случае отсутствия ограничений на них, оставьте поле незаполненным.');
DEFINE ('_UDDEADM_PUBEMAIL_HEAD', 'Требуется адрес эл.почты');
DEFINE ('_UDDEADM_PUBEMAIL_EXP', 'При включении этой опции посетитель будет вынужден ввести адрес своей эл.почты.');
DEFINE ('_UDDEADM_WAITDAYS_HEAD', 'Количество дней ожидания');
DEFINE ('_UDDEADM_WAITDAYS_EXP', 'Укажите конкретно сколько дней пользователь будет обязан ждать, прежде чем он сможет отправлять сообщения (для трех часов введите 0.125).');
DEFINE ('_UDDEIM_WAITDAYS1', 'Вы должны ждать ');
DEFINE ('_UDDEIM_WAITDAYS2', ' день(дня/дней) до тех пор, прежде чем Вы сможете отправлять сообщения.');
DEFINE ('_UDDEIM_WAITDAYS2H', ' час(а/ов) до тех пор, прежде чем Вы сможете отправлять сообщения.');

// New: 2.0
DEFINE ('_UDDEADM_RECAPTCHAPRV_HEAD', 'Личный ключ reCaptcha');
DEFINE ('_UDDEADM_RECAPTCHAPRV_EXP', 'Введите здесь Ваш частный ключ, когда будете использовать reCaptcha.');
DEFINE ('_UDDEADM_RECAPTCHAPUB_HEAD', 'Общий ключ reCaptcha');
DEFINE ('_UDDEADM_RECAPTCHAPUB_EXP', 'Введите здесь Ваш общий ключ, когда будете использовать reCaptcha.');
DEFINE ('_UDDEADM_CAPTCHA_INTERNAL', 'Внутренне');
DEFINE ('_UDDEADM_CAPTCHA_RECAPTCHA', 'reCaptcha');
DEFINE ('_UDDEADM_CAPTCHATYPE_HEAD', 'Сервис captcha');
DEFINE ('_UDDEADM_CAPTCHATYPE_EXP', 'Какой сервис captcha Вы бы хотели задействовать: встроенный сервис или reCaptcha (смотрите <a href="http://recaptcha.net" target="_new">reCaptcha</a> для подробной информации)?');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_6', '...включить по умолчанию для сервиса сaptcha');
DEFINE ('_UDDEADM_AUP', 'AlphaUserPoints');
DEFINE ('_UDDEADM_CHECKFILESFOLDER', 'Пожалуйста, переместите <i>\uddeimfiles</i> в папку <i>\images\uddeimfiles</i>. Сверьтесь с докумекнтацией!');
DEFINE ('_UDDEADM_CRYPT4', 'Сильное шифрование');
DEFINE ('_UDDEADM_ALLOWTOALL2_HEAD', 'Разрешить отправку системных сообщений');
DEFINE ('_UDDEADM_ALLOWTOALL2_EXP', 'uddeIM поддерживает отправку системных сообщений. Они отправляются всем пользователям Вашей системы. Используйте ее экономно.');
DEFINE ('_UDDEADM_ALLOWTOALL2_0', 'отключено');
DEFINE ('_UDDEADM_ALLOWTOALL2_1', 'только администраторы');
DEFINE ('_UDDEADM_ALLOWTOALL2_2', 'администраторы и менеджеры');

// New: 1.9
DEFINE ('_UDDEIM_FILEUPLOAD_FAILED', 'Неудачная загрузка файла');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_5', '...настройка по умолчанию для вложенных файлов');
DEFINE ('_UDDEADM_ENABLEATTACHMENT_HEAD', 'Позволить вложенные файлы');
DEFINE ('_UDDEADM_ENABLEATTACHMENT_EXP', 'Это позволяет посылать вложенные файлы всем зарегистрированным пользователям или только администраторам.');
DEFINE ('_UDDEADM_MAXSIZEATTACHMENT_HEAD', 'Макс. размер файла');
DEFINE ('_UDDEADM_MAXSIZEATTACHMENT_EXP', 'Максимальный позволенный размер вложенного файла.');
DEFINE ('_UDDEIM_FILESIZE_EXCEEDED', 'Превышен максимальный размер файла');
DEFINE ('_UDDEADM_BYTES', 'Байт');
DEFINE ('_UDDEADM_MAXATTACHMENTS_HEAD', 'Макс. вложений');
DEFINE ('_UDDEADM_MAXATTACHMENTS_EXP', 'Максимальное количество прилагаемых к одному сообщению файлов.');
DEFINE ('_UDDEIM_DOWNLOAD', 'Загрузить');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_HEAD', 'Удаление файлов осуществляются');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_YES', 'только администраторами');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_NO', 'любым пользователем');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_MANUALLY', 'вручную');
DEFINE ('_UDDEADM_FILEADMINIGNITIONONLY_EXP', 'Автоматические удаления вызывают нагрузку на сервер. Если вы выбираете <b>только администраторами</b> автоматические удаления осуществляются, когда администратор проверяет свой ящик для входящих. Выбирайте этот способ, если администратор регулярно проверяет свой ящик. Для мало или редко администрируемых сайтов может быть выбрано <b>любым пользователем</b>.');
DEFINE ('_UDDEADM_FILEMAINTENANCE_PRUNE', 'Удалить файлы');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_HEAD', 'Произвести стирание файлов');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_EXP', 'Удалить удаленные файлы из базы. Это то же, что и \'Удалить файлы\' на системной вкладке.');
DEFINE ('_UDDEADM_FILEMAINTENANCEDEL_ERASE', 'СТЕРЕТЬ');
DEFINE ('_UDDEIM_ATTACHMENTS', 'Вложенный файл (макс. %u байт на один файл):');
DEFINE ('_UDDEADM_MAINTENANCE_F1', 'Осиротевшие вложенные файлы, сохраняемые в файловой системе: ');
DEFINE ('_UDDEADM_MAINTENANCE_F2', 'Удаление осиротевших файлов');
DEFINE ('_UDDEADM_BACKUP_DONE', 'Конфигурация сохранена.');
DEFINE ('_UDDEADM_RESTORE_DONE', 'конфигурация восстановлена.');
DEFINE ('_UDDEADM_PRUNE_DONE', 'Сообщение удалено.');
DEFINE ('_UDDEADM_FILEPRUNE_DONE', 'Вложенный файл удалён.');
DEFINE ('_UDDEADM_FOLDERCREATE_ERROR', 'Ошибка при создании папки: ');
DEFINE ('_UDDEADM_ATTINSTALL_WRITEFAILED', 'Ошибка при создании файла: ');
DEFINE ('_UDDEADM_ATTINSTALL_IGNORE', 'Вы можете игнорировать эту ошибку, когда у вас нет File attachments premium plugin (см. FAQ).');
DEFINE ('_UDDEADM_ATTACHMENTGROUPS_HEAD', 'Позволенные группы');
DEFINE ('_UDDEADM_ATTACHMENTGROUPS_EXP', 'Группы, которым позволено посылать вложенные файлы.');
DEFINE ('_UDDEIM_SELECT', 'Выберите');
DEFINE ('_UDDEIM_ATTACHMENT', 'Вложенный файл');
DEFINE ('_UDDEADM_SHOWLISTATTACHMENT_HEAD', 'Показать иконки вложенных файлов');
DEFINE ('_UDDEADM_SHOWLISTATTACHMENT_EXP', 'Показывать иконки вложенных файлов в списках сообщений (входящих, отправленных, архиве).');
DEFINE ('_UDDEIM_HELP_ATTACHMENT', 'Это сообщение содержит вложенный файл.');
DEFINE ('_UDDEADM_MAINTENANCE_COUNTFILES', 'Ссылки на файл в базе данных:');
DEFINE ('_UDDEADM_MAINTENANCE_COUNTFILESDISTINCT', 'Вложенный файл сохранен:');
DEFINE ('_UDDEADM_SHOWMENUCOUNT_HEAD', 'Показать счетчики');
DEFINE ('_UDDEADM_SHOWMENUCOUNT_EXP', 'Когда установлено <b>да</b>, строка меню содержит счетчики сообщений. Внимание: Это потребует несколько дополнительных запросов к базе данных, поэтому не используйте на слабых системах.');
DEFINE ('_UDDEADM_CONFIG_FTPLAYER', 'Конфигурация (доступ на уровне FTP):');
DEFINE ('_UDDEADM_ENCODEHEADER_HEAD', 'Кодировать заголовки письма');
DEFINE ('_UDDEADM_ENCODEHEADER_EXP', 'Установите <b>да</b>, когда заголовки письма (например, тему) необходимо кодировать rfc 2047. полезно, когда у вас проблемы со специальными символами.');
DEFINE ('_UDDEIM_UP', 'восходящий порядок');
DEFINE ('_UDDEIM_DOWN', 'нисходящий порядок');
DEFINE ('_UDDEIM_UPDOWN', 'порядок');
DEFINE ('_UDDEADM_ENABLESORT_HEAD', 'Позволить сортировку');
DEFINE ('_UDDEADM_ENABLESORT_EXP', 'Установите <b>да</b>, когда пользователь должен иметь право сортировать входящие, отправленные и архивы (создает дополнительную нагрузку на сервер базы данных).');

// New: 1.8
// %s will be replaced by _UDDEIM_NOMESSAGES_FILTERED_INBOX, _UDDEIM_NOMESSAGES_FILTERED_OUTBOX, _UDDEIM_NOMESSAGES_FILTERED_ARCHIVE
// Translators help: When having problems with the grammar, you can also move some text (e.g. "in your") to _UDDEIM_NOMESSAGES_FILTERED_* variables, e.g.
// instead of "_UDDEIM_NOMESSAGES_FILTERED_INBOX=inbox" you can also use "_UDDEIM_NOMESSAGES_FILTERED_INBOX=in your inbox"
DEFINE ('_UDDEIM_NOMESSAGES2_FR_FILTERED', '<b>У вас нет сообщений от данного пользователя в папке%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_TO_FILTERED', '<b>У вас нет сообщений данному пользователю в папке%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_UNFR_FILTERED', '<b>У вас нет непрочитанных сообщений от данного пользователя в папке%s.</b>');
DEFINE ('_UDDEIM_NOMESSAGES2_UNTO_FILTERED', '<b>У вас нет непрочитанных сообщений данному пользователю в папке%s.</b>');

// New: 1.7
DEFINE ('_UDDEADM_EMAILSTOPPED', 'Отправка по e-mail отключена');
DEFINE ('_UDDEIM_ACCOUNTLOCKED', 'Доступ к личным сообщениям закрыт. Пожалуйста, свяжитесь с администратором сайта.');
DEFINE ('_UDDEADM_USERSET_LOCKED', 'Закрыт');
DEFINE ('_UDDEADM_USERSET_SELLOCKED', '- Закрыт -');
DEFINE ('_UDDEADM_CBBANNED_HEAD', 'Проверить наличие забаненных в Community Builder пользователей');
DEFINE ('_UDDEADM_CBBANNED_EXP', 'Если включено, uddeIM проверяет был ли пользователь забанен в Community Builder и закрывает ему доступ к uddeIM. Другие пользователи так же не смогут писать этому пользователю.');
DEFINE ('_UDDEIM_YOUAREBANNED', 'Вам был закрыт доступ. Пожалуйста, свяжитесь с администратором или модератором.');
DEFINE ('_UDDEIM_USERBANNED', 'Пользователь забанен');
DEFINE ('_UDDEADM_JOOBB', 'Joo!BB');
DEFINE ('_UDDEPLUGIN_SEARCHSECTION', 'Личные сообщения');
DEFINE ('_UDDEPLUGIN_MESSAGES', 'Личные сообщения');
DEFINE ('_UDDEADM_MAINTENANCEDEL_HEAD', 'Удаление сообщений'); // note "This  is the same as _UDDEADM_MAINTENANCE_PRUNE on the system tab."
DEFINE ('_UDDEADM_MAINTENANCEDEL_EXP', 'Стирает удаленные сообщения из базы данных. Аналогично опции \'Удалить сообщения сейчас?\' в закладке "Система".');
DEFINE ('_UDDEADM_MAINTENANCEDEL_ERASE', 'СТЕРЕТЬ');
DEFINE ('_UDDEADM_REPORTSPAM_HEAD', 'Пожаловаться на сообщение');
DEFINE ('_UDDEADM_REPORTSPAM_EXP', 'Если активировано, пользователь может сообщить администратору о спаме, нажав на ссылку "Пожаловаться на сообщение".');
DEFINE ('_UDDEIM_TOOLBAR_REMOVESPAM', 'Удалить сообщение');
DEFINE ('_UDDEIM_TOOLBAR_REMOVEREPORT', 'Ужалить жалобу');
DEFINE ('_UDDEIM_TOOLBAR_SPAMCONTROL', 'Управление жалобами');
DEFINE ('_UDDEADM_INFORMATION', 'Информация');
DEFINE ('_UDDEADM_SPAMCONTROL_STAT', 'Всего жалоб:');
DEFINE ('_UDDEADM_SPAMCONTROL_TRASHED', 'Удаленных');
DEFINE ('_UDDEADM_SPAMCONTROL_NOTEDEL', 'Удалить это сообщение из базы данных?');
DEFINE ('_UDDEADM_SPAMCONTROL_NOTEREMOVE', 'Удалить эту жалобу?');
DEFINE ('_UDDEADM_SPAMCONTROL_SHOWHIDE', 'Показать/Скрыть');
DEFINE ('_UDDEADM_SPAMCONTROL_EDIT', 'Центр управления жалобами');
DEFINE ('_UDDEADM_SPAMCONTROL_FROM', 'От');
DEFINE ('_UDDEADM_SPAMCONTROL_TO', 'Кому');
DEFINE ('_UDDEADM_SPAMCONTROL_TEXT', 'Сообщение');
DEFINE ('_UDDEADM_SPAMCONTROL_DELETE', 'Удалить');
DEFINE ('_UDDEADM_SPAMCONTROL_REMOVE', 'Убрать');
DEFINE ('_UDDEADM_SPAMCONTROL_DATE', 'Дата');
DEFINE ('_UDDEADM_SPAMCONTROL_REPORTED', 'Полученных');
DEFINE ('_UDDEIM_SPAMCONTROL_REPORT', 'Пожаловаться на сообщение');
DEFINE ('_UDDEIM_SPAMCONTROL_MARKED', 'Жалоба на сообщение отправлена.');
DEFINE ('_UDDEIM_SPAMCONTROL_UNREPORT', 'Отозвать жалобу');
DEFINE ('_UDDEADM_JOMSOCIAL', 'JomSocial');
DEFINE ('_UDDEADM_KUNENA', 'Kunena');
DEFINE ('_UDDEADM_ADMIN_FILTER', 'Фильтр');
DEFINE ('_UDDEADM_ADMIN_DISPLAY', 'Показать #');
DEFINE ('_UDDEADM_TRASHORIGINALSENT_HEAD', 'Удалить отправленное сообщение');
DEFINE ('_UDDEADM_TRASHORIGINALSENT_EXP', 'Если включено, рядом с кнопкой "Отправить" появится пункт "Удалить сообщение", отключенный по умолчанию. Пользователь может его отметить, и тогда сообщение будет удалено сразу же после отправки.');
DEFINE ('_UDDEIM_TRASHORIGINALSENT', 'Удалить сообщение');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_4', '...настройка по умолчанию для удаления отправленных сообщений, жалоб на спам и забаненных в Community Builder пользователей');
DEFINE ('_UDDEADM_VERSIONCHECK_IMPORTANT', 'Важные ссылки:');
DEFINE ('_UDDEADM_VERSIONCHECK_HOTFIX', 'Hotfix');
DEFINE ('_UDDEADM_VERSIONCHECK_NONE', 'Ничего нет');
DEFINE ('_UDDEADM_MAINTENANCEFIX_HEAD', "Совместимость");
DEFINE ('_UDDEADM_MAINTENANCEFIX_EXP', "uddeIM использует два XML-файла, чтобы была возможность устанавливать расширения как на Joomla 1.0, так и на 1.5. В Joomla 1.5 один из XML-файлов не требуется, и это может вызвать ошибку совместимости расришения (что не так). Данная опция удаляет лишние файлы, чтобы предупреждение больше не выводилось.");
DEFINE ('_UDDEADM_MAINTENANCE_FIX', "ИСПРАВИТЬ");
DEFINE ('_UDDEADM_MAINTENANCE_XML1', "XML-файлы uddeIM для Joomla 1.0 и Joomla 1.5 существуют.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML2', "Это требуется, чтобы была возможность устанавливать расширения на Joomla 1.0 и Joomla 1.5.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML3', "После того, как установка будет закончена, можно удалить установщик для Joomla 1.0 на системах, использующих 1.5.<br />");
DEFINE ('_UDDEADM_MAINTENANCE_XML4', "Это будет сделано для следующих расширений:<br />");
DEFINE ('_UDDEADM_MAINTENANCE_FXML1', "Лишние XML-файлы будут удалены для следующих расширений:<br />");
DEFINE ('_UDDEADM_MAINTENANCE_FXML2', "Лишние XML-файлы не обнаружены!<br />");
DEFINE ('_UDDEADM_SHOWMENUICONS1_HEAD', 'Вид меню');
DEFINE ('_UDDEADM_SHOWMENUICONS1_EXP', 'Здесь вы можете настроить, как будет отображаться меню - с иконками и/или с текстом.');
DEFINE ('_UDDEIM_MENUICONS_P1', 'Иконки и текст');
DEFINE ('_UDDEIM_MENUICONS_P2', 'Только иконки');
DEFINE ('_UDDEIM_MENUICONS_P0', 'Только текст');
DEFINE ('_UDDEIM_LISTSLIMIT_2', 'Максимальное количество получателей в списке:');
DEFINE ('_UDDEADM_ADDEMAIL_ADMIN', 'Администраторы могут выбирать');
DEFINE ('_UDDEAIM_ADDEMAIL_SELECT', 'Уведомить сообщением');
DEFINE ('_UDDEAIM_ADDEMAIL_TITLE', 'Вложить само сообщение в уведомление по e-mail.');

// New: 1.6

DEFINE ('_UDDEIM_NOLISTSELECTED', 'Не выбран список пользователей!');
DEFINE ('_UDDEADM_NOPREMIUM', 'Премиальный плагин не установлен!');
DEFINE ('_UDDEIM_LISTGLOBAL_CREATOR', 'Автор:');
DEFINE ('_UDDEIM_LISTGLOBAL_ENTRIES', 'Записей');
DEFINE ('_UDDEIM_LISTGLOBAL_TYPE', 'Тип');
DEFINE ('_UDDEIM_LISTGLOBAL_NORMAL', 'Обычный');
DEFINE ('_UDDEIM_LISTGLOBAL_GLOBAL', 'Общий');
DEFINE ('_UDDEIM_LISTGLOBAL_RESTRICTED', 'Закрытый');
DEFINE ('_UDDEIM_LISTGLOBAL_P0', 'Обычный список');
DEFINE ('_UDDEIM_LISTGLOBAL_P1', 'Общий список');
DEFINE ('_UDDEIM_LISTGLOBAL_P2', 'Закрытый список (только перечисленные пользователи имеют к нему доступ)');
DEFINE ('_UDDEIM_TOOLBAR_USERSETTINGS', 'Настройки пользователей');
DEFINE ('_UDDEIM_TOOLBAR_REMOVESETTINGS', 'Удалить настройки');
DEFINE ('_UDDEIM_TOOLBAR_CREATESETTINGS', 'Создать настройки');
DEFINE ('_UDDEIM_TOOLBAR_SAVE', 'Сохранить');
DEFINE ('_UDDEIM_TOOLBAR_BACK', 'Назад');
DEFINE ('_UDDEIM_TOOLBAR_TRASHMSGS', 'Удаленные сообщения');
DEFINE ('_UDDEIM_CBPLUG_CONT', '[Далее]');
DEFINE ('_UDDEIM_CBPLUG_UNBLOCKNOW', '[Разблокировать]');
DEFINE ('_UDDEIM_CBPLUG_DOBLOCK', 'Заблокировать пользователя');
DEFINE ('_UDDEIM_CBPLUG_DOUNBLOCK', 'Разблокировать пользователя');
DEFINE ('_UDDEIM_CBPLUG_BLOCKINGCFG', 'Блокировка');
DEFINE ('_UDDEIM_CBPLUG_BLOCKED', 'Вы заблокировали данного пользователя.');
DEFINE ('_UDDEIM_CBPLUG_UNBLOCKED', 'Данный пользователь теперь сможет вам писать.');
DEFINE ('_UDDEIM_CBPLUG_NOWBLOCKED', 'В настоящий момент пользователь заблокирован.');
DEFINE ('_UDDEIM_CBPLUG_NOWUNBLOCKED', 'Пользователь разблокирован.');
DEFINE ('_UDDEADM_PARTIALIMPORTDONE', 'Частичное импортирование из старой системы личных сообщений завершено. Не повторяйте его для одной и той же части базы, поскольку в противном случае все сообщения продублируются.');
DEFINE ('_UDDEADM_IMPORT_HELP', 'Важно: Сообщения можно импортировать разом или частично. Частичное импортирование может понадобиться, когда общее количество импортируемых сообщений слишком велико.');
DEFINE ('_UDDEADM_IMPORT_PARTIAL', 'Частичное импортирование:');
DEFINE ('_UDDEADM_UPDATEYOURDB', 'Важно: Вы не обновили базу данных! Пожалуйста, обратитесь к файлу README, чтобы узнать, как правильно провести обновление!');
DEFINE ('_UDDEADM_RESTRALLUSERS_HEAD', 'Запретить доступ к списку "Все пользователи"');
DEFINE ('_UDDEADM_RESTRALLUSERS_EXP', 'Вы можете запретить доступ к списку "Все пользователи". Как правило, он доступен всем (без ограничений).');
DEFINE ('_UDDEADM_RESTRALLUSERS_0', 'Без ограничений');
DEFINE ('_UDDEADM_RESTRALLUSERS_1', 'Особые пользователи');
DEFINE ('_UDDEADM_RESTRALLUSERS_2', 'Только администраторы');
DEFINE ('_UDDEIM_MESSAGE_UNARCHIVED', 'Сообщение убрано из архива.');
DEFINE ('_UDDEADM_AUTOFORWARD_SPECIAL', 'Особые пользователи');
DEFINE ('_UDDEIM_HELP', 'Помощь');
DEFINE ('_UDDEIM_HELP_HEADLINE1', 'Помощь по использованию системы личных сообщений.');
DEFINE ('_UDDEIM_HELP_HEADLINE2', 'Краткое описание всех функций:');
DEFINE ('_UDDEIM_HELP_INBOX', 'В этой папке содержатся все входящие сообщения, которые приходят вам.');
DEFINE ('_UDDEIM_HELP_OUTBOX', 'В этой папке содержатся копии всех отправленных вами писем, и вы всегда можете просмотреть их.');
DEFINE ('_UDDEIM_HELP_TRASHCAN', 'В этой папке находятся все удаленные сообщения. Они не удаляются сразу же, а хранятся определенное количество времени. До тех пор вы можете их восстановить.');
DEFINE ('_UDDEIM_HELP_ARCHIVE', 'В этой папке хранятся все сообщения, которые были отправлены туда из папки "Входящие". Вы можете отправлять в архив сообщения только из папки "Входящие". Если вы хотите сохранить ваше собственное сообщение, поставьте галочку "Сохранить копию" во время отправки.');
DEFINE ('_UDDEIM_HELP_USERLISTS', 'Пункт "Контакты" позволяет вести список контактов (список рассылки). Он позволяет отправлять сообщения нескольким пользователям сразу. Вместо того, чтобы добавлять получателей по одному, просто укажите <b>#имя_списка</b>.');
DEFINE ('_UDDEIM_HELP_SETTINGS', 'Пункт "Настройки" содержит все доступные настройки системы сообщений.');
DEFINE ('_UDDEIM_HELP_COMPOSE', 'Здесь вы можете создать новое личное сообщение.');
DEFINE ('_UDDEIM_HELP_IREAD', 'Сообщение прочитано (статус можно изменить).');
DEFINE ('_UDDEIM_HELP_IUNREAD', 'Сообщение не прочитано (статус можно изменить).');
DEFINE ('_UDDEIM_HELP_OREAD', 'Сообщение прочитано.');
DEFINE ('_UDDEIM_HELP_OUNREAD', 'Сообщение не прочитано. Непрочитанные сообщения нельзя возвращать.');
DEFINE ('_UDDEIM_HELP_TREAD', 'Сообщение прочитано.');
DEFINE ('_UDDEIM_HELP_TUNREAD', 'Сообщение не было прочитано.');
DEFINE ('_UDDEIM_HELP_FLAGGED', 'Сообщение отмечено; например, если оно важное (статус можно изменить).');
DEFINE ('_UDDEIM_HELP_UNFLAGGED', 'Обычное сообщение (статус можно изменить).');
DEFINE ('_UDDEIM_HELP_ONLINE', 'Пользователь находится на сайте.');
DEFINE ('_UDDEIM_HELP_OFFLINE', 'Пользователя нет на сайте.');
DEFINE ('_UDDEIM_HELP_DELETE', 'Удалить сообщение (переместить в корзину).');
DEFINE ('_UDDEIM_HELP_FORWARD', 'Переслать сообщение другому пользователю.');
DEFINE ('_UDDEIM_HELP_ARCHIVEMSG', 'Отправить в архив. Сообщения в архиве не будут удалены автоматически, даже если администратор установил временное ограничение на хранение писем в папке "Входящие".');
DEFINE ('_UDDEIM_HELP_UNARCHIVEMSG', 'Убрать из архива. Сообщение вернется в папку "Входящие".');
DEFINE ('_UDDEIM_HELP_RECALL', 'Вернуть сообщение. Отправленное сообщения можно вернуть, только если оно еще не было прочитано получателем.');
DEFINE ('_UDDEIM_HELP_RECYCLE', 'Восстановить сообщение (переместить из корзины обратно в папку "Входящие" или "Отправленные").');
DEFINE ('_UDDEIM_HELP_NOTIFY', 'Настройка уведомлений о получении нового сообщения.');
DEFINE ('_UDDEIM_HELP_AUTORESPONDER', 'Если автоответчик включен, отправителю тут же придет ответ, указанный в настройках.');
DEFINE ('_UDDEIM_HELP_AUTOFORWARD', 'Новые сообщения могут пересылаться пользователю автоматически.');
DEFINE ('_UDDEIM_HELP_BLOCKING', 'Вы можете блокировать пользователей. Они больше не смогут отправлять вам личные сообщения.');
DEFINE ('_UDDEIM_HELP_MISC', 'Здесь вы найдете дополнительные настройки.');
DEFINE ('_UDDEIM_HELP_FEED', 'Вы можете просматривать папку "Входящие", используя RSS.');
DEFINE ('_UDDEADM_SEPARATOR_HEAD', 'Разделитель');
DEFINE ('_UDDEADM_SEPARATOR_EXP', 'Выберите разделитель, использующийся при отправке писем нескольким пользователям (по умолчанию - запятая).');
DEFINE ('_UDDEADM_SEPARATOR_P0', 'Запятая (по умолчанию)');
DEFINE ('_UDDEADM_SEPARATOR_P1', 'Точка с запятой');
DEFINE ('_UDDEADM_RSSLIMIT_HEAD', 'Элементы RSS');
DEFINE ('_UDDEADM_RSSLIMIT_EXP', 'Ограничить количество возвращаемых элементов RSS (0 - не ограничено).');
DEFINE ('_UDDEADM_SHOWHELP_HEAD', 'Показывать кнопку "Помощь"');
DEFINE ('_UDDEADM_SHOWHELP_EXP', 'Если включено, на странице будет отображаться кнопка "Помощь".');
DEFINE ('_UDDEADM_SHOWIGOOGLE_HEAD', 'Показывать кнопку гаджета iGoogle');
DEFINE ('_UDDEADM_SHOWIGOOGLE_EXP', 'Если включено, в настройках пользователя будет отображаться кнопка "Добавить в iGoogle".');
DEFINE ('_UDDEADM_MOOTOOLS_NONE11', 'Не загружать MooTools (используется версия 1.1)');
DEFINE ('_UDDEADM_MOOTOOLS_NONE12', 'Не загружать MooTools (используется версия 1.2)');
DEFINE ('_UDDEIM_RSS_INTRO1', 'Вы можете просматривать свою папку входящих сообщений, используя RSS (0.91).');
DEFINE ('_UDDEIM_RSS_INTRO1B', 'Ссылка на поток:');
DEFINE ('_UDDEIM_RSS_INTRO2', 'Не давайте эту ссылку другим пользователям, поскольку по ней можно просматривать Вашу папку с входящими сообщениями!');
DEFINE ('_UDDEIM_RSS_FEED', 'Сообщения RSS');
DEFINE ('_UDDEIM_RSS_NOOBJECT', 'Нет объекта...');
DEFINE ('_UDDEIM_RSS_USERBLOCKED', 'Пользователь заблокирован...');
DEFINE ('_UDDEIM_RSS_NOTALLOWED', 'Доступ запрещен...');
DEFINE ('_UDDEIM_RSS_WRONGPASSWORD', 'Неправильное имя пользователя или пароль...');
DEFINE ('_UDDEIM_RSS_NOMESSAGES', 'Нет сообщений');
DEFINE ('_UDDEIM_RSS_NONEWMESSAGES', 'Нет новых сообщений');
DEFINE ('_UDDEADM_ENABLERSS_HEAD', 'Включить RSS');
DEFINE ('_UDDEADM_ENABLERSS_EXP', 'Если включено, пользователи могут получать сообщения с помощью RSS. Ссылка на поток RSS находится в настройках uddeIM каждого пользователя.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_3', '...настройка по умолчанию для RSS, iGoogle, справки и разделителя');
DEFINE ('_UDDEADM_DELETEM_DELETING', 'Удаляются сообщения:');
DEFINE ('_UDDEADM_DELETEM_FROMUSER', 'Удаляются сообщения от пользователя ');
DEFINE ('_UDDEADM_DELETEM_MSGSSENT', '- сообщение(ия/ий) отправлено: ');
DEFINE ('_UDDEADM_DELETEM_MSGSRECV', '- сообщение(ия/ий) получено: ');
DEFINE ('_UDDEIM_PMNAV_THISISARESPONSE', 'Это ответ на:');
DEFINE ('_UDDEIM_PMNAV_THEREARERESPONSES', 'Ответов на это:');
DEFINE ('_UDDEIM_PMNAV_DELETED', 'Сообщение не доступно');
DEFINE ('_UDDEIM_PMNAV_EXISTS', 'Перейти к сообщению');
DEFINE ('_UDDEIM_PMNAV_COPY2ME', '(Копировать)');
DEFINE ('_UDDEADM_PMNAV_HEAD', 'Разрешить перемещение');
DEFINE ('_UDDEADM_PMNAV_EXP', 'Показывает меню перемещения по ветке дискуссии.');
DEFINE ('_UDDEADM_MAINTENANCE_ALLDAYS', 'Сообщений:');
DEFINE ('_UDDEADM_MAINTENANCE_7DAYS', 'Сообщений за 7 дней:');
DEFINE ('_UDDEADM_MAINTENANCE_30DAYS', 'Сообщений за 30 дней:');
DEFINE ('_UDDEADM_MAINTENANCE_365DAYS', 'Сообщений за 365 дней:');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD1', 'Отправляются напоминания пользователям (интервал - %s дней):');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD2', 'Через %s дней будут отправлены напоминания пользователям:');
DEFINE ('_UDDEADM_MAINTENANCE_NO', 'Нет:');
DEFINE ('_UDDEADM_MAINTENANCE_USERID', 'ID пользователя:');
DEFINE ('_UDDEADM_MAINTENANCE_TONAME', 'Имя:');
DEFINE ('_UDDEADM_MAINTENANCE_MID', 'ID сообщения:');
DEFINE ('_UDDEADM_MAINTENANCE_WRITTEN', 'Написано:');
DEFINE ('_UDDEADM_MAINTENANCE_TIMER', 'Таймер:');

// New: 1.5

DEFINE ('_UDDEMODULE_ALLDAYS', ' сообщение(ия/ий)');
DEFINE ('_UDDEMODULE_7DAYS', ' сообщение(ия/ий) за последние 7 дней');
DEFINE ('_UDDEMODULE_30DAYS', ' сообщение(ия/ий) за последние 30 дней');
DEFINE ('_UDDEMODULE_365DAYS', ' сообщение(ия/ий) за последние 365 дней');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_WARNING', '<br /><b>Важно: Если вы используете mosMail, вам неоходимо указать реальный электронный адрес!</b>');
DEFINE ('_UDDEIM_FILTEREDMESSAGE', 'сообщение отфильтровано');
DEFINE ('_UDDEIM_FILTEREDMESSAGES', 'сообщения(ий) отфильтровано');
DEFINE ('_UDDEIM_FILTER', 'Фильтр:');
DEFINE ('_UDDEIM_FILTER_TITLE_INBOX', 'Только от этого пользователя');
DEFINE ('_UDDEIM_FILTER_TITLE_OUTBOX', 'Только этому пользователю');
DEFINE ('_UDDEIM_FILTER_UNREAD_ONLY', 'Только непрочтенные');
DEFINE ('_UDDEIM_FILTER_SUBMIT', 'Фильтровать');
DEFINE ('_UDDEIM_FILTER_ALL', '- Все -');
DEFINE ('_UDDEIM_FILTER_PUBLIC', '- Гости -');
DEFINE ('_UDDEADM_FILTER_HEAD', 'Включить фильтр');
DEFINE ('_UDDEADM_FILTER_EXP', 'Если включено, пользователи могут фильтровать свои папки входящих и отправленных, чтобы показывать только одного отправителя или получателя.');
DEFINE ('_UDDEADM_FILTER_P0', 'Не включать');
DEFINE ('_UDDEADM_FILTER_P1', 'Над списком сообщений');
DEFINE ('_UDDEADM_FILTER_P2', 'Под списком сообщений');
DEFINE ('_UDDEADM_FILTER_P3', 'Над и под списком сообщений');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED', '<b>У вас %s сообщение(ия/ий) %s в папке %s.</b>');	// see next  six lines
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_FROM', ' от этого пользователя');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_TO', ' этому пользователю');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_INBOX', ' "Входящие"');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_OUTBOX', ' "Отправленные"');
DEFINE ('_UDDEIM_NOMESSAGES_FILTERED_ARCHIVE', ' "Архив"');
DEFINE ('_UDDEIM_TODP_TITLE', 'Получатель');
DEFINE ('_UDDEIM_TODP_TITLE_CC', 'Один или более получателей (разделенных знаком ;)');
DEFINE ('_UDDEIM_ADDCCINFO_TITLE', 'Если включено, в сообщение будет добавлена строка, содержащая всех получателей.');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_2', '...настройка по умолчанию для автоответчика, автоматического перенаправления, поля ввода и фильтра');
DEFINE ('_UDDEADM_AUTORESPONDER_HEAD', 'Включить автоответчик');
DEFINE ('_UDDEADM_AUTORESPONDER_EXP', 'Если использование автоответчика разрешено, пользователь может включить в настройках автоматическое уведомление отправителям входящих писем.');
DEFINE ('_UDDEIM_EMN_AUTORESPONDER', 'Включить автоответчик');
DEFINE ('_UDDEIM_AUTORESPONDER', 'Автоответчик');
DEFINE ('_UDDEIM_AUTORESPONDER_EXP', 'Если автоответчик включен, отправителю тут же придет ответ, указанный в настройках.');
DEFINE ('_UDDEIM_AUTORESPONDER_DEFAULT', 'Извините, в настоящий момент я не доступен. Отвечу вам при первой же возможности.');
DEFINE ('_UDDEADM_USERSET_AUTOR', 'АвтоО');
DEFINE ('_UDDEADM_USERSET_SELAUTOR', '- АвтоО -');
DEFINE ('_UDDEIM_USERBLOCKED', 'Пользователь заблокирован.');
DEFINE ('_UDDEADM_AUTOFORWARD_HEAD', 'Автоматическая пересылка');
DEFINE ('_UDDEADM_AUTOFORWARD_EXP', 'Если включена автоматическая пересылка, сообщения одному пользователю сразу перенаправляются другому.');
DEFINE ('_UDDEIM_EMN_AUTOFORWARD', 'Включить автоматическую пересылку');
DEFINE ('_UDDEADM_USERSET_AUTOF', 'АвтоП');
DEFINE ('_UDDEADM_USERSET_SELAUTOF', '- АвтоП -');
DEFINE ('_UDDEIM_AUTOFORWARD', 'Автоматическая пересылка');
DEFINE ('_UDDEIM_AUTOFORWARD_EXP', 'Входящие сообщения можно автоматически перенаправлять другому пользователю.');
DEFINE ('_UDDEIM_THISISAFORWARD', 'Автоматическая пересылка сообщения, изначально отправленного пользователю ');
DEFINE ('_UDDEADM_COLSROWS_HEAD', 'Размер поля текста (колонок/рядов)');
DEFINE ('_UDDEADM_COLSROWS_EXP', 'Устанавливает количество колонок и рядов поля ввода текста сообщения (по умолчанию - 60/10).');
DEFINE ('_UDDEADM_WIDTH_HEAD', 'Ширина поля текста');
DEFINE ('_UDDEADM_WIDTH_EXP', 'Устанавливает ширину поля ввода текста сообщения в пикселях (по умолчанию - 0). Если установлено 0, ширина определяется на основе файла стилей CSS.');
DEFINE ('_UDDEADM_CBE', 'CB Enhanced');
// New: 1.4

DEFINE ('_UDDEADM_IMPORT_CAPS', 'ИМПОРТИРОВАНИЕ');
// New: 1.3

DEFINE ('_UDDEADM_MOOTOOLS_HEAD', 'Использовать MooTools');
DEFINE ('_UDDEADM_MOOTOOLS_EXP', 'Данная опция определяет, как uddeIM будет использовать MooTools (требуется для корректной работы функции автозаполнения). Установите "Не использовать вовсе", если ваш шаблон сам загружает MooTools. По умолчанию рекомендуется выставить "Автоматически" (аналогично использованию в uddeIM 1.2). Если же вы используете Joomla 1.0, поставьте принудительное использование MooTools 1.1 или 1.2.');
DEFINE ('_UDDEADM_MOOTOOLS_NONE', 'Не использовать вовсе');
DEFINE ('_UDDEADM_MOOTOOLS_AUTO', 'Автоматически');
DEFINE ('_UDDEADM_MOOTOOLS_1', 'Принудительно использовать MooTools 1.1');
DEFINE ('_UDDEADM_MOOTOOLS_2', 'Принудительно использовать MooTools 1.2');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING_1', '...настройка MooTools по умолчанию');
DEFINE ('_UDDEADM_AGORA', 'Agora');
// New: 1.2

DEFINE ('_UDDEADM_CRYPT3', 'В кодировке Base64');
DEFINE ('_UDDEADM_TIMEZONE_HEAD', 'Установка часового пояса');
DEFINE ('_UDDEADM_TIMEZONE_EXP', 'Если uddeIM отображает неверное время, вы можете настроить часовой пояс отдельно. Обычно, если все настроено правильно, следует выставить ноль. В противном случае потребуется изменить это значение.');
DEFINE ('_UDDEADM_HOURS', 'часов');
DEFINE ('_UDDEADM_VERSIONCHECK', 'Информация о версии:');
DEFINE ('_UDDEADM_STATISTICS', 'Статистика:');
DEFINE ('_UDDEADM_STATISTICS_HEAD', 'Показать статистику');
DEFINE ('_UDDEADM_STATISTICS_EXP', 'Здесь отображается статистика вроде числа сохраненных сообщений и т. п.');
DEFINE ('_UDDEADM_STATISTICS_CHECK', 'Показать');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT', 'Сообщения сохранены в базе данных. ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_RECIPIENT', 'Испорченных сообщений (по получателям): ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_SENDER', 'Испорченных сообщений (по отправителям): ');
DEFINE ('_UDDEADM_MAINTENANCE_COUNT_TRASH', 'Сообщения, ожидающие удаления: ');
DEFINE ('_UDDEADM_OVERWRITEITEMID_HEAD', 'Изменить параметр Itemid');
DEFINE ('_UDDEADM_OVERWRITEITEMID_EXP', 'Обычно uddeIM пытается определить правильный Itemid в случае, если он не выставлен. Но иногда возникает необходимость изменить это значение - например, когда вы используете  в меню несколько ссылок на uddeIM.');
DEFINE ('_UDDEADM_OVERWRITEITEMID_CURRENT', 'Определенные значения Itemid: ');
DEFINE ('_UDDEADM_USEITEMID_HEAD', 'Использовать Itemid');
DEFINE ('_UDDEADM_USEITEMID_EXP', 'Использовать данное значение Itemid вместо определенного.');
DEFINE ('_UDDEADM_SHOWLINK_HEAD', 'Использовать ссылки на профиль');
DEFINE ('_UDDEADM_SHOWLINK_EXP', 'Если установлено "Да", все имена пользователей будут отображаться в виде ссылок на профиль.');
DEFINE ('_UDDEADM_SHOWPIC_HEAD', 'Показывать аватары');
DEFINE ('_UDDEADM_SHOWPIC_EXP', 'Если установлено "Да", аватар соответствующего пользователя будет отображаться при чтении сообщения.');
DEFINE ('_UDDEADM_THUMBLISTS_HEAD', 'Показывать аватары в списках');
DEFINE ('_UDDEADM_THUMBLISTS_EXP', 'Установите "Да", если хотите отображать аватары пользователей в имеющихся списках сообщений (входящие, отправленные и т. д.).');
DEFINE ('_UDDEADM_FIREBOARD', 'Fireboard');
DEFINE ('_UDDEADM_CB', 'Community Builder');
DEFINE ('_UDDEADM_DISABLED', 'Выключен');
DEFINE ('_UDDEADM_ENABLED', 'Включен');
DEFINE ('_UDDEIM_STATUS_FLAGGED', 'Важное!');
DEFINE ('_UDDEIM_STATUS_UNFLAGGED', '');
DEFINE ('_UDDEADM_ALLOWFLAGGED_HEAD', 'Разрешить отмечать сообщения');
DEFINE ('_UDDEADM_ALLOWFLAGGED_EXP', 'Разрешить пользователям отмечать сообщения (в списках сообщений отображается звездочка, что позволяет отметить отдельные сообщения как важные).');
DEFINE ('_UDDEADM_REVIEWUPDATE', 'Важно: когда Вы обновляете uddeIM с ранней версии, пожалуйста, прочтите README файл. В некоторых случаях Вам понадобится добавить или изменить значения или поля в Базе Данных!');
DEFINE ('_UDDEIM_ADDCCINFO', 'Добавить строку с получателями');
DEFINE ('_UDDEIM_CC', 'CC:');
DEFINE ('_UDDEADM_TRUNCATE_HEAD', 'Обрезать цитируемый текст');
DEFINE ('_UDDEADM_TRUNCATE_EXP', 'Обрезать цитируемый текст на 2/3 максимальной длины сообщения если привышен установленный лимит.');
DEFINE ('_UDDEIM_PLUG_INBOXENTRIES', 'Записи папки "Входящие"');
DEFINE ('_UDDEIM_PLUG_LAST', 'Последняя(ие) ');
DEFINE ('_UDDEIM_PLUG_ENTRIES', ' записи');
DEFINE ('_UDDEIM_PLUG_STATUS', 'Статус');
DEFINE ('_UDDEIM_PLUG_SENDER', 'Отправитель');
DEFINE ('_UDDEIM_PLUG_MESSAGE', 'Сообщение');
DEFINE ('_UDDEIM_PLUG_EMPTYINBOX', 'Папка "Входящие" пуста');
// New: 1.1

DEFINE ('_UDDEADM_NOTRASHACCESS_NOT', 'Доступ к корзине запрещен.');
DEFINE ('_UDDEADM_NOTRASHACCESS_HEAD', 'Ограничить доступ к корзине');
DEFINE ('_UDDEADM_NOTRASHACCESS_EXP', 'Вы можете ограничить доступ пользователей к корзине для того, чтобы пользователи не смогли восстанавливать сообщения.');
DEFINE ('_UDDEADM_NOTRASHACCESS_0', 'Нет ограничения');
DEFINE ('_UDDEADM_NOTRASHACCESS_1', 'Особые пользователи');
DEFINE ('_UDDEADM_NOTRASHACCESS_2', 'Только администраторы');
DEFINE ('_UDDEADM_PUBHIDEUSERS_HEAD', 'Скрыть определенных пользователей в списке');
DEFINE ('_UDDEADM_PUBHIDEUSERS_EXP', 'Введите ID одного или нескольких пользователей, чтобы скрыть их (например: 65,66,67).');
DEFINE ('_UDDEADM_HIDEUSERS_HEAD', 'Скрыть определенных пользователей в списке');
DEFINE ('_UDDEADM_HIDEUSERS_EXP', 'Введите ID одного или нескольких пользователей, чтобы скрыть их (пример: 65,66,67). Администраторы всегда видят полный список.');
DEFINE ('_UDDEIM_ERRORCSRF', 'Обнаружена CSRF-атака');
DEFINE ('_UDDEADM_CSRFPROTECTION_HEAD', 'Защита от CSRF');
DEFINE ('_UDDEADM_CSRFPROTECTION_EXP', 'Данная опция защищает от всех типов атак Cross-Site Request Forgery (так называемая "Подделка межсайтовых запросов"). Рекомендуем включить ее. Отключайте только, если у вас возникли какие-то проблемы.');
DEFINE ('_UDDEIM_CANTREPLYARCHIVE', 'Вы не можете отвечать на сообщения в архиве.');
DEFINE ('_UDDEIM_COULDNOTRECALLPUBLIC', 'Сообщения незарегистрированных пользователей не могут быть восстановлены.');
DEFINE ('_UDDEADM_PUBREPLYS_HEAD', 'Прямые ответы на сообщения от гостей');
DEFINE ('_UDDEADM_PUBREPLYS_EXP', 'Разрешить прямые ответы на сообщения от гостей.');
DEFINE ('_UDDEIM_EMN_BODY_PUBLICWITHMESSAGE', 'Здравствуйте, %you%, %user% прислал вам следующее сообщение %site%. "%pmessage%"');
DEFINE ('_UDDEADM_PUBNAMESTEXT', 'Показывать реальное имя или имя пользователя');
DEFINE ('_UDDEADM_PUBNAMESDESC', 'Показывать реальное имя или имя пользователя гостям');
DEFINE ('_UDDEIM_USERLIST', 'Список пользователей');
DEFINE ('_UDDEIM_YOUHAVETOWAIT', 'Извините, прежде чем отправить новое сообщение необходимо немного подождать.');
DEFINE ('_UDDEADM_USERSET_LASTSENT', 'Последние отправленные');
DEFINE ('_UDDEADM_TIMEDELAY_HEAD', 'Интервал между отправкой сообщений');
DEFINE ('_UDDEADM_TIMEDELAY_EXP', 'Количество секунд, которые необходимо выждать перед отправкой следующего сообщения (0 - без ограничений).');
DEFINE ('_UDDEADM_SECONDS', 'секунд');
DEFINE ('_UDDEIM_PUBLICSENT', 'Сообщение отправлено.');
DEFINE ('_UDDEIM_ERRORINFROMNAME', 'Ошибка имени пользователя');
DEFINE ('_UDDEIM_ERRORINEMAIL', 'Ошибка электронного адреса');
DEFINE ('_UDDEIM_YOURNAME', 'Ваше имя:');
DEFINE ('_UDDEIM_YOUREMAIL', 'Ваш e-mail:');
DEFINE ('_UDDEADM_VERSIONCHECK_USING', 'Вы используете uddeIM ');
DEFINE ('_UDDEADM_VERSIONCHECK_LATEST', 'Вы используете последнюю версию uddeIM.');
DEFINE ('_UDDEADM_VERSIONCHECK_CURRENT', 'Текущая версия ');
DEFINE ('_UDDEADM_VERSIONCHECK_INFO', 'Информация обновления:');
DEFINE ('_UDDEADM_VERSIONCHECK_HEAD', 'Проверка обновлений');
DEFINE ('_UDDEADM_VERSIONCHECK_EXP', 'Проверьте наличие новой версии uddeIM.');
DEFINE ('_UDDEADM_VERSIONCHECK_CHECK', 'Проверить сейчас!');
DEFINE ('_UDDEADM_VERSIONCHECK_ERROR', 'Невозможно получить информацию о версии uddeIM.');
DEFINE ('_UDDEIM_NOSUCHLIST', 'Список не найден!');
DEFINE ('_UDDEIM_LISTSLIMIT_1', 'Превышено максимальное количество получателей (макс. ');
DEFINE ('_UDDEADM_MAXONLISTS_HEAD', 'Максимальное количество записей');
DEFINE ('_UDDEADM_MAXONLISTS_EXP', 'Максимальное количество записей в списке контактов.');
DEFINE ('_UDDEIM_LISTSNOTENABLED', 'Список контактов запрещен');
DEFINE ('_UDDEADM_ENABLELISTS_HEAD', 'Включить списки контактов');
DEFINE ('_UDDEADM_ENABLELISTS_EXP', 'Разрешить пользователям создавать списки контактов. Эти списки могут использоваться для отправки сообщений сразу нескольким  пользователям. Не забудьте включить соответствующую опцию в разделе "Система"');
DEFINE ('_UDDEADM_ENABLELISTS_0', 'Отключено');
DEFINE ('_UDDEADM_ENABLELISTS_1', 'Зарегистрированные пользователи');
DEFINE ('_UDDEADM_ENABLELISTS_2', 'Специальные пользователи');
DEFINE ('_UDDEADM_ENABLELISTS_3', 'Только администраторы');
DEFINE ('_UDDEIM_LISTSNEW', 'Создать список контактов');
DEFINE ('_UDDEIM_LISTSSAVED', 'Список контактов сохранен');
DEFINE ('_UDDEIM_LISTSUPDATED', 'Список контактов обновлен');
DEFINE ('_UDDEIM_LISTSDESC', 'Описание');
DEFINE ('_UDDEIM_LISTSNAME', 'Имя');
DEFINE ('_UDDEIM_LISTSNAMEWO', 'Имя (без пробелов)');
DEFINE ('_UDDEIM_EDITLINK', 'Редактировать');
DEFINE ('_UDDEIM_LISTS', 'Контакты');
DEFINE ('_UDDEIM_STATUS_READ', 'Прочитано');
DEFINE ('_UDDEIM_STATUS_UNREAD', 'Не прочитано');
DEFINE ('_UDDEIM_STATUS_ONLINE', 'На сайте');
DEFINE ('_UDDEIM_STATUS_OFFLINE', 'Не на сайте');
DEFINE ('_UDDEADM_CBGALLERY_HEAD', 'Показывать аватары из галереи Community Builder');
DEFINE ('_UDDEADM_CBGALLERY_EXP', 'По умолчанию uddeIM показывает только загруженные аватары. Данная функция позволит показывать аватары из галереи Сommunity Вuilder.');
DEFINE ('_UDDEADM_UNBLOCKCB_HEAD', 'Разблокировать связи в Community Builder');
DEFINE ('_UDDEADM_UNBLOCKCB_EXP', 'Вы можете разблокировать списки связей Community Builder, даже если включена общая блокировка.');
DEFINE ('_UDDEIM_GROUPBLOCKED', 'Вам запрещено отправлять сообщения данной группе.');
DEFINE ('_UDDEIM_ONEUSERBLOCKS', 'Получатель заблокировал вас.');
DEFINE ('_UDDEADM_BLOCKGROUPS_HEAD', 'Заблокировать группы (для зарегистрированных пользователей)');
DEFINE ('_UDDEADM_BLOCKGROUPS_EXP', 'Группы, которым зарегистрированным пользователям запрещено отправлять сообщения. На особых пользователей и администраторов данное условие не распространяется. Эта опция не зависит от индивидуальных настроек блокировки пользователя (см. настройки выше).');
DEFINE ('_UDDEADM_PUBBLOCKGROUPS_HEAD', 'Заблокировать группы (для гостей)');
DEFINE ('_UDDEADM_PUBBLOCKGROUPS_EXP', 'Группы, которым гостям запрещено отправлять сообщения. На особых пользователей и администраторов данное условие не распространяется. Эта опция не зависит от индивидуальных настроек блокировки пользователя (см. настройки выше). Если группа заблокирована, пользователям, входящим в нее, не доступна соответствующая опция в настройках профиля.');
DEFINE ('_UDDEADM_BLOCKGROUPS_1', 'Гости');
DEFINE ('_UDDEADM_BLOCKGROUPS_2', 'Community Builder');
DEFINE ('_UDDEADM_BLOCKGROUPS_18', 'Зарегистрированные');
DEFINE ('_UDDEADM_BLOCKGROUPS_19', 'Авторы');
DEFINE ('_UDDEADM_BLOCKGROUPS_20', 'Редакторы');
DEFINE ('_UDDEADM_BLOCKGROUPS_21', 'Издатели');
DEFINE ('_UDDEADM_BLOCKGROUPS_23', 'Менеджеры');
DEFINE ('_UDDEADM_BLOCKGROUPS_24', 'Администраторы');
DEFINE ('_UDDEADM_BLOCKGROUPS_25', 'Суперадминистраторы');
DEFINE ('_UDDEIM_NOPUBLICMSG', 'Пользователь принимает сообщения только от зарегистрированных пользователей.');
DEFINE ('_UDDEADM_PUBHIDEALLUSERS_HEAD', 'Скрыть список пользователей от гостей');
DEFINE ('_UDDEADM_PUBHIDEALLUSERS_EXP', 'Вы можете скрыть список пользователей от гостей. Будет запрещен просмотр самого списка, но отправку или прием сообщений.');
DEFINE ('_UDDEADM_HIDEALLUSERS_HEAD', 'Скрыть группы пользователей в списке');
DEFINE ('_UDDEADM_HIDEALLUSERS_EXP', 'Вы можете скрыть определенные группы пользоваетлей в списке.');
DEFINE ('_UDDEADM_HIDEALLUSERS_0', 'Нет');
DEFINE ('_UDDEADM_HIDEALLUSERS_1', 'Только суперадминистраторов');
DEFINE ('_UDDEADM_HIDEALLUSERS_2', 'Только администраторов');
DEFINE ('_UDDEADM_HIDEALLUSERS_3', 'Особых пользователей');
DEFINE ('_UDDEADM_PUBLIC', 'Доступ');
DEFINE ('_UDDEADM_PUBMODESHOWALLUSERS_HEAD', 'Ссылка "Все пользователи"');
DEFINE ('_UDDEADM_PUBMODESHOWALLUSERS_EXP', 'Выберите, необходимо ли отображать ссылку "Все пользователи" во фронтальной, публичной части сайта.');
DEFINE ('_UDDEADM_USERSET_PUBLIC', 'Публичный доступ');
DEFINE ('_UDDEADM_USERSET_SELPUBLIC', '- Выбрать -');
DEFINE ('_UDDEIM_OPTIONS_F', 'Позволить гостям отправлять сообщения');
DEFINE ('_UDDEIM_MSGLIMITREACHED', 'Вы достигли максимального количества сообщений!');
DEFINE ('_UDDEIM_PUBLICUSER', 'Гость');
DEFINE ('_UDDEIM_DELETEDUSER', 'Пользователь удален');
DEFINE ('_UDDEADM_CAPTCHALEN_HEAD', 'Количество символов Captcha');
DEFINE ('_UDDEADM_CAPTCHALEN_EXP', 'Количество символов, которые пользователь будет вводить.');
DEFINE ('_UDDEADM_USECAPTCHA_HEAD', 'Защита от спама Captcha');
DEFINE ('_UDDEADM_USECAPTCHA_EXP', 'Определите, кто должен вводить защитный код при отправке сообщения/');
DEFINE ('_UDDEADM_CAPTCHAF0', 'Оключено');
DEFINE ('_UDDEADM_CAPTCHAF1', 'Только гости');
DEFINE ('_UDDEADM_CAPTCHAF2', 'Гости и пользователи');
DEFINE ('_UDDEADM_CAPTCHAF3', 'Гости, пользователи, особые пользователи');
DEFINE ('_UDDEADM_CAPTCHAF4', 'Все (включая администраторов)');
DEFINE ('_UDDEADM_PUBFRONTEND_HEAD', 'Включить публичный доступ');
DEFINE ('_UDDEADM_PUBFRONTEND_EXP', 'При включении данной функции, гости сайта смогут отправлять сообщения зарегистрированным пользователям. Зарегистрированные пользователи могут отключить или включить эту функцию в своих настройках.');
DEFINE ('_UDDEADM_PUBFRONTENDDEF_HEAD', 'Публичный доступ по умолчанию');
DEFINE ('_UDDEADM_PUBFRONTENDDEF_EXP', 'Значение по умолчанию у всех зарегистрированных пользователей.');
DEFINE ('_UDDEADM_PUBDEF0', 'Отключен');
DEFINE ('_UDDEADM_PUBDEF1', 'Включен');
DEFINE ('_UDDEIM_WRONGCAPTCHA', 'Неверный код безопасности');

// New: 1.0

DEFINE ('_UDDEADM_NONEORUNKNOWN', 'неизвестно');
DEFINE ('_UDDEADM_DONATE', 'Пожалуйста, поддержите разработку Uddeim.');

// New: 1.0rc2

DEFINE ('_UDDEADM_BACKUPRESTORE_DATE', '<br/><strong>Найдена конфигурация базы данных от:</strong> ');
DEFINE ('_UDDEADM_BACKUPRESTORE_HEAD', 'Резервная копия и восстановление конфигурации');
DEFINE ('_UDDEADM_BACKUPRESTORE_EXP', 'Вы можете сделать копию вашей конфигурации базы данных и восстановить при необходимости. Это полезно, если вы обновляете uddeIM или хотите сохранить определенную конфигурацию.');
DEFINE ('_UDDEADM_BACKUPRESTORE_BACKUP', 'Копировать ');
DEFINE ('_UDDEADM_BACKUPRESTORE_RESTORE', ': Восстановить');
DEFINE ('_UDDEADM_CANCEL', 'Закрыть');

// New: 1.0rc1

DEFINE ('_UDDEADM_LANGUAGECHARSET_HEAD', 'Кодировка языкового файла');
DEFINE ('_UDDEADM_LANGUAGECHARSET_EXP', 'Рекомендуется параметр по умолчанию');
DEFINE ('_UDDEADM_LANGUAGECHARSET_UTF8', 'UTF-8');
DEFINE ('_UDDEADM_LANGUAGECHARSET_DEFAULT', 'По умолчанию');
DEFINE ('_UDDEIM_READ_INFO_1', 'Прочитанные сообщения будут храниться в папке "Входящие"  ');
DEFINE ('_UDDEIM_READ_INFO_2', ' день(дня/дней), а затем будут автоматически удалены.');
DEFINE ('_UDDEIM_UNREAD_INFO_1', 'Непрочитанные сообщения будут храниться в папке "Входящие" ');
DEFINE ('_UDDEIM_UNREAD_INFO_2', ' день(дня/дней), а затем будут автоматически удалены.');
DEFINE ('_UDDEIM_SENT_INFO_1', 'Отправленные сообщения будут храниться в папке "Отправленные" ');
DEFINE ('_UDDEIM_SENT_INFO_2', ' день(дня/дней), а затем будут автоматически удалены.');
DEFINE ('_UDDEADM_DELETEREADAFTERNOTE_HEAD', 'Уведомление о хранении прочитанных сообщений');
DEFINE ('_UDDEADM_DELETEREADAFTERNOTE_EXP', 'Будет показанно количество оставшихся дней до автоматического удаления прочитанных входящих сообщений.');
DEFINE ('_UDDEADM_DELETEUNREADAFTERNOTE_HEAD', 'Уведомление о хранении непрочитанных сообщений');
DEFINE ('_UDDEADM_DELETEUNREADAFTERNOTE_EXP', 'Будет показанно количество оставшихся дней до автамотического удаления непрочитанных входящих сообщений.');
DEFINE ('_UDDEADM_DELETESENTAFTERNOTE_HEAD', 'Уведомление о хранении отправленных сообщений');
DEFINE ('_UDDEADM_DELETESENTAFTERNOTE_EXP', 'Будет показано количество оставшихся дней до автамотического удаления отправленных сообщений.');
DEFINE ('_UDDEADM_DELETETRASHAFTERNOTE_HEAD', 'Уведомление о хранении сообщений в корзине');
DEFINE ('_UDDEADM_DELETETRASHAFTERNOTE_EXP', 'Будет показано количество оставшихся дней до автамотического удаления сообщений в корзине.');
DEFINE ('_UDDEADM_DELETESENTAFTER_HEAD', 'Хранить отправленные сообщения');
DEFINE ('_UDDEADM_DELETESENTAFTER_EXP', 'Укажите, сколько дней хранить в базе отправленные сообщения.');
DEFINE ('_UDDEIM_SEND_TOALLSPECIAL', 'отправить всем специальным пользователям');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLSPECIAL', 'Сообщение <strong>всем специальным пользователям</strong>');
DEFINE ('_UDDEADM_USERSET_SELUSERNAME', '- Выберите имя пользователя -');
DEFINE ('_UDDEADM_USERSET_SELNAME', '- Вберите имя -');
DEFINE ('_UDDEADM_USERSET_EDITSETTINGS', 'Редактор настроек пользователей');
DEFINE ('_UDDEADM_USERSET_EXISTING', 'Существующий');
DEFINE ('_UDDEADM_USERSET_NONEXISTING', 'Не существующий');
DEFINE ('_UDDEADM_USERSET_SELENTRY', '- Выберите статус -');
DEFINE ('_UDDEADM_USERSET_SELNOTIFICATION', '- Способ уведомления -');
DEFINE ('_UDDEADM_USERSET_SELPOPUP', '- Режим высплывающего окна -');
DEFINE ('_UDDEADM_USERSET_USERNAME', 'Имя пользователя');
DEFINE ('_UDDEADM_USERSET_NAME', 'Имя');
DEFINE ('_UDDEADM_USERSET_NOTIFICATION', 'Уведомления');
DEFINE ('_UDDEADM_USERSET_POPUP', 'Всплывающее окно');
DEFINE ('_UDDEADM_USERSET_LASTACCESS', 'Последний раз был');
DEFINE ('_UDDEADM_USERSET_NO', 'Нет');
DEFINE ('_UDDEADM_USERSET_YES', 'Да');
DEFINE ('_UDDEADM_USERSET_UNKNOWN', 'неизвестно');
DEFINE ('_UDDEADM_USERSET_WHENOFFLINEEXCEPT', 'Когда не на сайте (кроме ответов)');
DEFINE ('_UDDEADM_USERSET_ALWAYSEXCEPT', 'Всегда (кроме ответов)');
DEFINE ('_UDDEADM_USERSET_WHENOFFLINE', 'Когда на сайте');
DEFINE ('_UDDEADM_USERSET_ALWAYS', 'Всегда');
DEFINE ('_UDDEADM_USERSET_NONOTIFICATION', 'Нет уведомлений');
DEFINE ('_UDDEADM_WELCOMEMSG', 'Добро пожаловать в uddeIM! Вы успешно установили компонент личных сообщений uddeIM и можете теперь попробовать просмотреть это сообщение с различными шаблонами (стиль меняется в панели управления). uddeIM - проект постоянно развивающийся. Поэтому, если вы обнаружите какие либо ошибки, обязательно напишите мне о них. Удачи вам! Авторы перевода: [url=http://www.provitiligo.com/]Дмитрий Чернов[/url], [url=http://www.aleksius.com/] Алексей Хорошевский[/url]');
DEFINE ('_UDDEADM_UDDEINSTCOMPLETE', 'uddeIM полностью установлен.');
DEFINE ('_UDDEADM_REVIEWSETTINGS', 'Пожалуйста, перейдите в меню настроек компонента.');
DEFINE ('_UDDEADM_REVIEWLANG', 'Если вы используете кодировку Joomla, отличную от ISO 8859-1, вам также необходимо настроить ее в панели управления uddeIM.');
DEFINE ('_UDDEADM_REVIEWEMAILSTOP', 'После установки проверьте работу uddeIM с уведомлениями по e-mail и при необходимости произведите дополнительные настройки.');
DEFINE ('_UDDEADM_MAXRECIPIENTS_HEAD', 'Максимальное количество получателей');
DEFINE ('_UDDEADM_MAXRECIPIENTS_EXP', 'Количество получателей за одно отправление (0 - нет ограничений).');
DEFINE ('_UDDEIM_TOOMANYRECIPIENTS', 'слишком много получателей');
DEFINE ('_UDDEIM_STOPPEDEMAIL', 'Использование электронной почты отключено.');
DEFINE ('_UDDEADM_SEARCHINSTRING_HEAD', 'Поиск внутри текста');
DEFINE ('_UDDEADM_SEARCHINSTRING_EXP', 'Во время автозаполнения происходит поиск внутри текста (в противном случае - только с начала).');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_HEAD', 'Показывать список "Все пользователи"');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_EXP', 'Выберите, показывать или нет список всех пользователей.');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_0', 'Скрыть');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_1', 'Показать ссылку');
DEFINE ('_UDDEADM_MODESHOWALLUSERS_2', 'Показать список');
DEFINE ('_UDDEADM_CONFIGNOTWRITEABLE', 'Файл конфигурации не доступен для записи:');
DEFINE ('_UDDEADM_CONFIGWRITEABLE', 'Файл конфигурации доступен для записи:');
DEFINE ('_UDDEIM_FORWARDLINK', 'Переслать');
DEFINE ('_UDDEIM_RECIPIENTFOUND', 'получатель найден');
DEFINE ('_UDDEIM_RECIPIENTSFOUND', 'получателей найдено');
DEFINE ('_UDDEADM_MAILSYSTEM_MOSMAIL', 'Функцию mosMail');
DEFINE ('_UDDEADM_MAILSYSTEM_PHPMAIL', 'Функцию php mail (по умолчанию)');
DEFINE ('_UDDEADM_MAILSYSTEM_HEAD', 'Для отправки почты использовать:');
DEFINE ('_UDDEADM_MAILSYSTEM_EXP', 'Выберите систему для отправки email.');
DEFINE ('_UDDEADM_SHOWGROUPS_HEAD', 'Показывать группы пользователей');
DEFINE ('_UDDEADM_SHOWGROUPS_EXP', 'В общем списке будут показаны группы пользователей.');
DEFINE ('_UDDEADM_ALLOWFORWARDS_HEAD', 'Разрешить пересылку сообщений');
DEFINE ('_UDDEADM_ALLOWFORWARDS_EXP', 'Разрешить пользователям пересылать сообщения.');
DEFINE ('_UDDEIM_FWDFROM', 'Оригинал сообщения от');
DEFINE ('_UDDEIM_FWDTO', 'Получатель');

// New: 0.9+

DEFINE ('_UDDEIM_UNARCHIVE', 'Убрать&nbsp;из&nbsp;архива');
DEFINE ('_UDDEIM_CANTUNARCHIVE', 'Невозможно отправить сообщение в архив');
DEFINE ('_UDDEADM_ALLOWMULTIPLERECIPIENTS_HEAD', 'Разрешить отправлять сообщения нескольким пользователям');
DEFINE ('_UDDEADM_ALLOWMULTIPLERECIPIENTS_EXP', 'Разрешить отправлять сообщения сразу нескольким получателям (разделенным запятой).');
DEFINE ('_UDDEIM_CHARSLEFT', 'Максимальное количество символов');
DEFINE ('_UDDEADM_SHOWTEXTCOUNTER_HEAD', 'Показать поле "Максимальное количество символов"?');
DEFINE ('_UDDEADM_SHOWTEXTCOUNTER_EXP', 'Показать или скрыть данное поле.');
DEFINE ('_UDDEIM_CLEAR', 'Очистить');
DEFINE ('_UDDEADM_ALLOWMULTIPLEUSER_HEAD', 'Разрешить выбор получателей в автоматическом режиме');
DEFINE ('_UDDEADM_ALLOWMULTIPLEUSER_EXP', 'Данная функция позволяет пользователю выбирать получателей из выпадающего списка и автоматически подставлять в поле "Получатель".');
DEFINE ('_UDDEADM_CBALLOWMULTIPLEUSER_HEAD', 'Добавлять выбранные связи к списку получателей');
DEFINE ('_UDDEADM_CBALLOWMULTIPLEUSER_EXP', 'Разрешить пользователям выбирать получателей из списка связей Community Builder.');
DEFINE ('_UDDEADM_PMSFOUND', 'PMS : ');
DEFINE ('_UDDEIM_ENTERNAME', 'введите имя');
DEFINE ('_UDDEADM_USEAUTOCOMPLETE_HEAD', 'Использовать автозаполнение');
DEFINE ('_UDDEADM_USEAUTOCOMPLETE_EXP', 'Позволяет использовать автозаполнение.');
DEFINE ('_UDDEADM_OBFUSCATING_HEAD', 'Ключ шифрования');
DEFINE ('_UDDEADM_OBFUSCATING_EXP', 'Введите ключ для шифрования сообщений (не меняйте, если не знаете что это такое!).');
DEFINE ('_UDDEADM_CFGFILE_NOTFOUND', 'Файл конфигурации не найден!');
DEFINE ('_UDDEADM_CFGFILE_FOUND', 'Найденная версия:');
DEFINE ('_UDDEADM_CFGFILE_EXPECTED', 'Ожидаемая версия:');
DEFINE ('_UDDEADM_CFGFILE_CONVERTING', 'Преобразование конфигурации...');
DEFINE ('_UDDEADM_CFGFILE_DONE', 'Готово!');
DEFINE ('_UDDEADM_CFGFILE_WRITEFAILED', 'Конфигурации не сохранена! Критическая ошибка в файле:');

// New: 0.8+

DEFINE ('_UDDEIM_ENCRYPTDOWN', 'Зашифрованное сообщение. Невозможно скачать!');
DEFINE ('_UDDEIM_WRONGPASSDOWN', 'Неправильный пароль. Невозможно скачать!');
DEFINE ('_UDDEIM_WRONGPW', 'Неправильный пароль. Пожалуйста, свяжитесь с администратором!');
DEFINE ('_UDDEIM_WRONGPASS', 'Неправильный пароль.');
DEFINE ('_UDDEADM_MAINTENANCE_D1', 'Неверные даты в корзине (входящие/отправленные): ');
DEFINE ('_UDDEADM_MAINTENANCE_D2', 'Исправление неверных дат');
DEFINE ('_UDDEIM_TODP', 'Получатель: ');
DEFINE ('_UDDEADM_MAINTENANCE_PRUNE', 'Удалить сообщения сейчас?');
DEFINE ('_UDDEADM_SHOWACTIONICONS_HEAD', 'Показывать иконки действий');
DEFINE ('_UDDEADM_SHOWACTIONICONS_EXP', 'Если установлено "Да", ссылки будут отображаться в виде иконок.');
DEFINE ('_UDDEIM_UNCHECKALL', 'Снять все');
DEFINE ('_UDDEIM_CHECKALL', 'Отметить все');
DEFINE ('_UDDEADM_SHOWBOTTOMICONS_HEAD', 'Показывать иконку снизу');
DEFINE ('_UDDEADM_SHOWBOTTOMICONS_EXP', 'Если установлено "Да", ссылки будут отображаться в виде иконок.');
DEFINE ('_UDDEADM_ANIMATED_HEAD', 'Использовать анимированные смайлики');
DEFINE ('_UDDEADM_ANIMATED_EXP', 'Использовать анимированные смайлики вместо статичных.');
DEFINE ('_UDDEADM_ANIMATEDEX_HEAD', 'Больше анимированных смайликов');
DEFINE ('_UDDEADM_ANIMATEDEX_EXP', 'Показывать все анимированные смайлики.');
DEFINE ('_UDDEIM_PASSWORDREQ', 'Зашифрованное сообщение - требуется пароль');
DEFINE ('_UDDEIM_PASSWORD', 'Требуется пароль');
DEFINE ('_UDDEIM_PASSWORDBOX', 'Пароль');
DEFINE ('_UDDEIM_ENCRYPTIONTEXT', ' (зашифрованный текст)');
DEFINE ('_UDDEIM_DECRYPTIONTEXT', ' (расшифрованный текст)');
DEFINE ('_UDDEIM_MORE', 'БОЛЬШЕ');

// uddeIM Module

DEFINE ('_UDDEMODULE_PRIVATEMESSAGES', 'Личные сообщения');
DEFINE ('_UDDEMODULE_NONEW', 'Новых: нет');
DEFINE ('_UDDEMODULE_NEWMESSAGES', 'Новых: ');
DEFINE ('_UDDEMODULE_MESSAGE', 'сообщение');
DEFINE ('_UDDEMODULE_MESSAGES', 'сообщения(ий)');
DEFINE ('_UDDEMODULE_YOUHAVE', 'Вы имеете');
DEFINE ('_UDDEMODULE_HELLO', 'Привет');
DEFINE ('_UDDEMODULE_EXPRESSMESSAGE', 'Экспресс сообщение');

// New: 0.7+

DEFINE ('_UDDEADM_USEENCRYPTION', 'Использовать шифрование');
DEFINE ('_UDDEADM_USEENCRYPTIONDESC', 'Шифровать сохраненные сообщения');
DEFINE ('_UDDEADM_CRYPT0', 'Нет');
DEFINE ('_UDDEADM_CRYPT1', 'Обфускцировать сообщения');
DEFINE ('_UDDEADM_CRYPT2', 'Шифровать сообщения');
DEFINE ('_UDDEADM_NOTIFYDEFAULT_HEAD', 'Уведомления отправляются по умолчанию');
DEFINE ('_UDDEADM_NOTIFYDEFAULT_EXP', 'Уведомление отправляются на e-mail по умолчанию (будет применено для всех пользователей).');
DEFINE ('_UDDEADM_NOTIFYDEF_0', 'Не отправлять');
DEFINE ('_UDDEADM_NOTIFYDEF_1', 'Отправлять всегда');
DEFINE ('_UDDEADM_NOTIFYDEF_2', 'Только когда нет на сайте');
DEFINE ('_UDDEADM_SUPPRESSALLUSERS_HEAD', 'Скрыть список "Все пользователи"');
DEFINE ('_UDDEADM_SUPPRESSALLUSERS_EXP', 'Скрыть общий список пользователей (полезно когда на сайте много пользователей).');
DEFINE ('_UDDEADM_POPUP_HEAD','Показывать всплывающее окно');
DEFINE ('_UDDEADM_POPUP_EXP','Показывать всплывающее окно, когда приходит новое сообщение (необходимо установить исправленный модуль mod_cblogin)');
DEFINE ('_UDDEIM_OPTIONS', 'Дополнительные настройки');
DEFINE ('_UDDEIM_OPTIONS_EXP', 'Здесь вы можете настроить дополнительные параметры сообщений.');
DEFINE ('_UDDEIM_OPTIONS_P', 'Показывать всплывающее окно, когда приходит новое сообщение.');
DEFINE ('_UDDEADM_POPUPDEFAULT_HEAD', 'Всплывающее окно по умолчанию');
DEFINE ('_UDDEADM_POPUPDEFAULT_EXP', 'Показывать вспывающее окно по умолчанию (для всех пользователей).');
DEFINE ('_UDDEADM_MAINTENANCE', 'Обслуживание');
DEFINE ('_UDDEADM_MAINTENANCE_HEAD', 'Обслуживание базы данных');
DEFINE ('_UDDEADM_MAINTENANCE_CHECK', 'Проверить ');
DEFINE ('_UDDEADM_MAINTENANCE_TRASH', ': Починить');
DEFINE ('_UDDEADM_MAINTENANCE_EXP', 'Если пользователь удален из базы, его сообщения, как правило, хранятся. Данная опция проверяет, нет ли лишних сообщений, и позволяет вам удалить их при необходимости. Также она проверяет базу данных на наличие ошибок и исправляет их.');
DEFINE ('_UDDEADM_MAINTENANCE_MC1', 'Проверка...<br />');
DEFINE ('_UDDEADM_MAINTENANCE_MC2', '#nnn (Имя пользователя): [Входящие|Удаленные входящие|Отправленные|Удаленные отправленные]<br /><br />');
DEFINE ('_UDDEADM_MAINTENANCE_MC3', '<b>Входящие</b> - сообщения, сохраненные в папке "Входящие".<br />');
DEFINE ('_UDDEADM_MAINTENANCE_MC4', '<b>Удаленные входящие</b> - удаленные сообщения, оставшиеся в папке "Отправленные" у отправителя.<br />');
DEFINE ('_UDDEADM_MAINTENANCE_MC5', '<b>Отправленные</b> - сообщения, сохраненные в папке "Отправленные".<br />');
DEFINE ('_UDDEADM_MAINTENANCE_MC6', '<b>Удаленные отправленные</b> - удаленные сообщения, оставшиеся в папке "Входящие" у получателя.<br />');
DEFINE ('_UDDEADM_MAINTENANCE_MT1', 'Удаление...<br />');
DEFINE ('_UDDEADM_MAINTENANCE_NOTFOUND', "not found (from/to/settings/blocker/blocked):");
DEFINE ('_UDDEADM_MAINTENANCE_MT2', "delete all preferences from user");
DEFINE ('_UDDEADM_MAINTENANCE_MT3', "delete blocking of user");
DEFINE ('_UDDEADM_MAINTENANCE_MT4', "trash all messages sent to deleted user in sender\'s outbox and deleted user\'s inbox");
DEFINE ('_UDDEADM_MAINTENANCE_MT5', "trash all messages sent from deleted user in his outbox and receiver\'s inbox");
DEFINE ('_UDDEADM_MAINTENANCE_NOTHINGTODO', '<b>Все в порядке</b><br />');
DEFINE ('_UDDEADM_MAINTENANCE_JOBTODO', '<b>Требуемое обслуживание</b><br />');

// New: 0.6+

DEFINE ('_UDDEADM_NAMESTEXT', 'Показать реальное имя');
DEFINE ('_UDDEADM_NAMESDESC', 'Показывать реальное имя или имя пользователя.');
DEFINE ('_UDDEADM_REALNAMES', 'Реальное имя');
DEFINE ('_UDDEADM_USERNAMES', 'Имя пользователя');
DEFINE ('_UDDEADM_CONLISTBOX', 'Список связей');
DEFINE ('_UDDEADM_CONLISTBOXDESC', 'Показывать связи в виде списка или в виде таблицы.');
DEFINE ('_UDDEADM_LISTBOX', 'Список');
DEFINE ('_UDDEADM_TABLE', 'Таблица');
DEFINE ('_UDDEIM_TRASHCAN_INFO', 'Сообщение будет находиться в корзине 24 часа, после чего будет удалено. Вы можете видеть только первые слова. Чтобы прочитать все сообщение, его надо восстановить.');

// версия 0.4

DEFINE ('_UDDEIM_TRASHCAN_INFO_1', 'Сообщение будет находиться в корзине ');
DEFINE ('_UDDEIM_TRASHCAN_INFO_2', ' часов, после чего будет удалено. Вы можете видеть только первые слова. Чтобы прочитать все сообщение, его надо восстановить.');
DEFINE ('_UDDEIM_RECALLEDMESSAGE_INFO', 'Cообщение отозвано. Теперь вы можете его изменить и снова отправить.');
DEFINE ('_UDDEIM_COULDNOTRECALL', 'Сообщение нельзя отозвать (оно было прочитано или удалено).');
DEFINE ('_UDDEIM_CANTRESTORE', 'Не удалось восстановить сообщение. Вероятно, оно было удалено при автоматической чистке корзины.');
DEFINE ('_UDDEIM_COULDNOTRESTORE', 'Не удалось восстановить сообщение.');
DEFINE ('_UDDEIM_DONTSEND', 'Не отправлять');
DEFINE ('_UDDEIM_SENDAGAIN', 'Отправить снова');
DEFINE ('_UDDEIM_NOTLOGGEDIN', 'Вы не авторизованы.');
DEFINE ('_UDDEIM_NOMESSAGES_INBOX', 'В папке "Входящие" нет сообщений.');
DEFINE ('_UDDEIM_NOMESSAGES_OUTBOX', 'В папке "Отправленные" нет сообщений.');
DEFINE ('_UDDEIM_NOMESSAGES_TRASHCAN', 'Нет сообщений в корзине.');
DEFINE ('_UDDEIM_INBOX', 'Входящие');
DEFINE ('_UDDEIM_OUTBOX', 'Отправленные');
DEFINE ('_UDDEIM_TRASHCAN', 'Корзина');
DEFINE ('_UDDEIM_CREATE', 'Новое');
DEFINE ('_UDDEIM_UDDEIM', 'Личные сообщения'); // this is the headline/name of the component as it appears in Mambo
DEFINE ('_UDDEIM_READSTATUS', 'Прочитано'); // as in 'this message has been "read"'
DEFINE ('_UDDEIM_FROM', 'Отправитель');
DEFINE ('_UDDEIM_FROM_SMALL', 'Отправитель:');
DEFINE ('_UDDEIM_TO', 'Получатель');
DEFINE ('_UDDEIM_TO_SMALL', 'Получатель:');
DEFINE ('_UDDEIM_OUTBOX_WARNING', 'Папка "<strong>Отправленные</strong>" содержит все отправленные сообщения (если вы их не удалили). Вы можете отозвать сообщение, если получатель еще не прочитал его. В этом случае, он его и не прочитает. ');
DEFINE ('_UDDEIM_RECALL', 'Отозвать');
DEFINE ('_UDDEIM_RECALLTHISMESSAGE', 'Отозвать сообщение');
DEFINE ('_UDDEIM_RESTORE', 'Восстановить');
DEFINE ('_UDDEIM_MESSAGE', 'Сообщение');
DEFINE ('_UDDEIM_DATE', 'Дата');
DEFINE ('_UDDEIM_DELETED', 'Удалено');
DEFINE ('_UDDEIM_DELETE', 'Удалить');
DEFINE ('_UDDEIM_DELETELINK', 'Удалить');
DEFINE ('_UDDEIM_MESSAGENOACCESS', 'Сообщение не может быть отображено. <br />Возможные причины:<ul><li>У вас нет прав на просмотр этого сообщения.</li><li>Сообщение было удалено.</li></ul>');
DEFINE ('_UDDEIM_YOUMOVEDTOTRASH', '<b>Вы перенесли это сообщение в корзину.</b>');
DEFINE ('_UDDEIM_MESSAGEFROM', 'Отправитель ');
DEFINE ('_UDDEIM_MESSAGETO', 'Сообщение для ');
DEFINE ('_UDDEIM_REPLY', 'Ответ');
DEFINE ('_UDDEIM_SUBMIT', 'Отправить');
DEFINE ('_UDDEIM_NOMESSAGE', 'Ошибка: Пустое сообщение! Сообщение не отправлено.');
DEFINE ('_UDDEIM_MESSAGE_REPLIEDTO', 'Ответ отправлен!');
DEFINE ('_UDDEIM_MESSAGE_SENT', 'Сообщение отправлено!');
DEFINE ('_UDDEIM_MOVEDTOTRASH', ' и оригинальное сообщение помещено в корзину');
DEFINE ('_UDDEIM_NOSUCHUSER', 'Нет пользователя с таким именем пользователя!');
DEFINE ('_UDDEIM_NOTTOYOURSELF', 'Нельзя послать сообщение самому себе!');
DEFINE ('_UDDEIM_PRUNELINK', 'Администраторы: Очистка');
DEFINE ('_UDDEIM_BLOCKS', 'Заблокировано');
DEFINE ('_UDDEIM_YOUAREBLOCKED', 'Сообщение не отправлено. Получатель заблокировал вас.');
DEFINE ('_UDDEIM_BLOCKNOW', 'Заблокировать');
DEFINE ('_UDDEIM_BLOCKS_EXP', 'Список пользователей, получение сообщений от которых вы заблокировали.');
DEFINE ('_UDDEIM_NOBODYBLOCKED', 'Нет заблокированных пользователей.');
DEFINE ('_UDDEIM_YOUBLOCKED_PRE', 'В данный момент заблокировано ');
DEFINE ('_UDDEIM_YOUBLOCKED_POST', ' пользователей.');
DEFINE ('_UDDEIM_UNBLOCKNOW', '[Разблокировать]');
DEFINE ('_UDDEIM_BLOCKALERT_EXP_ON', 'Если заблокированный пользователь попытается отправить вам сообщение, он будет поставлен в известность.');
DEFINE ('_UDDEIM_BLOCKALERT_EXP_OFF', 'Заблокированный пользователь не может видеть факта блокировки.');
DEFINE ('_UDDEIM_CANTBLOCKADMINS', 'Нельзя блокировать сообщения от администраторов.');
DEFINE ('_UDDEIM_BLOCKSDISABLED', 'Система блокировки выключена');
DEFINE ('_UDDEIM_CANTREPLY', 'Вы не можете ответить на это сообщение.');
DEFINE ('_UDDEIM_EMNOFF', 'Уведомление по e-mail отключено. ');
DEFINE ('_UDDEIM_EMNON', 'Уведомление по e-mail включено. ');
DEFINE ('_UDDEIM_SETEMNON', '[Включить]');
DEFINE ('_UDDEIM_SETEMNOFF', '[Выключить]');
DEFINE ('_UDDEIM_EMN_BODY_NOMESSAGE', 'Здравствуйте, %you% 



%user% отправил вам личное сообщение на %site%.

Пожалуйста, зайдите на сайт, чтобы прочитать его!');
DEFINE ('_UDDEIM_EMN_BODY_WITHMESSAGE', 'Здравствуйте, %you%  



%user% отправил вам личное сообщение на %site%.

Чтобы ответить на него, зайдите на сайт!



*****************



%pmessage%

');
DEFINE ('_UDDEIM_EMN_FORGETMENOT', 'Здравствуйте, %you%



на сайте %site% ожидают непрочитанные личные сообщения.

Пожалуйста, зайдите на сайт, чтобы прочитать их!

');
DEFINE ('_UDDEIM_EXPORT_FORMAT', '

================================================================================

%user% (%msgdate%)

----------------------------------------

%msgbody%

================================================================================');
DEFINE ('_UDDEIM_EMN_SUBJECT', 'Личные сообщения на %site%');
DEFINE ('_UDDEIM_ARCHIVE_ERROR', 'Не удалось сохранить сообщение в архиве.');
DEFINE ('_UDDEIM_ARC_SAVED_NONE', 'В архиве нет сохраненных сообщений.');
DEFINE ('_UDDEIM_ARC_SAVED_1', 'В архиве ');
DEFINE ('_UDDEIM_ARC_SAVED_2', ' сообщения(ий).');
DEFINE ('_UDDEIM_ARC_SAVED_ONE', 'В архиве одно сообщение');
DEFINE ('_UDDEIM_ARC_SAVED_3', 'Чтобы хранить сообщения в архиве, необходимо предварительно освободить место.');
DEFINE ('_UDDEIM_ARC_CANSAVEMAX_1', 'Вы можете хранить не более ');
DEFINE ('_UDDEIM_ARC_CANSAVEMAX_2', ' сообщения(ий).');
DEFINE ('_UDDEIM_INBOX_LIMIT_1', 'Сохранено ');
DEFINE ('_UDDEIM_INBOX_LIMIT_2', ' сообщений в папке');
DEFINE ('_UDDEIM_ARC_UNIVERSE_ARC', ' "Архив"');
DEFINE ('_UDDEIM_ARC_UNIVERSE_INBOX', ' "Входящие"');
DEFINE ('_UDDEIM_ARC_UNIVERSE_BOTH', ' "Архив" и "Входящие"');  // The lines above are to make up a sentence like "You have | 126 | messages in your | inbox and archive"
DEFINE ('_UDDEIM_INBOX_LIMIT_3', 'Разрешено максимум ');
DEFINE ('_UDDEIM_INBOX_LIMIT_4', 'Вы по-прежнему можете получать сообщения, но не сможете отвечать или создавать новые, пока не очистите старые.');
DEFINE ('_UDDEIM_SHOWINBOXLIMIT_1', 'Сохранено сообщений: ');
DEFINE ('_UDDEIM_SHOWINBOXLIMIT_2', '(максимум ');  // don't add closing bracket
DEFINE ('_UDDEIM_MESSAGE_ARCHIVED', 'Сообщение сохранено в архиве.');
DEFINE ('_UDDEIM_STORE', 'В архив'); // translators info: as in: 'store this message in archive now'
DEFINE ('_UDDEIM_BACK', 'назад');
DEFINE ('_UDDEIM_TRASHCHECKED', 'Удалить отмеченные'); // translators info: plural! (as in "delete checked" messages)
DEFINE ('_UDDEIM_SHOWALL', 'показать все'); // translators example "SHOW ALL messages"
DEFINE ('_UDDEIM_ARCHIVE', 'Архив'); // should be same as _UDDEADM_ARCHIVE
DEFINE ('_UDDEIM_ARCHIVEFULL', 'Архив переполнен. Сообщение не сохранено.');
DEFINE ('_UDDEIM_NOMSGSELECTED', 'Не выбраны сообщения.');
DEFINE ('_UDDEIM_THISISACOPY', 'Копия сообщения, отправленого пользователю ');
DEFINE ('_UDDEIM_SENDCOPYTOME', 'Сохранить копию'); // as in 'send a "copy to me"' or cc: me
DEFINE ('_UDDEIM_SENDCOPYTOARCHIVE', 'Копировать в архив');
DEFINE ('_UDDEIM_TRASHORIGINAL', 'Удалить оригинал');
DEFINE ('_UDDEIM_MESSAGEDOWNLOAD', 'Загрузка сообщения');
DEFINE ('_UDDEIM_EXPORT_MAILED', 'На ваш электронный адрес отправлено письмо с выбранными сообщениями.');
DEFINE ('_UDDEIM_EXPORT_NOW', 'Отправить выбранные сообщения на почту'); // as in "send the messages checked above by E-Mail to me"
DEFINE ('_UDDEIM_EXPORT_MAIL_INTRO', 'Это письмо содержит ваши личные сообщения.');
DEFINE ('_UDDEIM_EXPORT_COULDNOTSEND', 'Невозможно отправить письмо с сообщениями.');
DEFINE ('_UDDEIM_LIMITREACHED', 'Лимит исчерпан! Сообщение не восстановлено.');
DEFINE ('_UDDEIM_WRITEMSGTO', 'Написать сообщение пользователю '); // as in "write a message to" (a person)

// months and weeknames (please translate according to your language)

$udde_smon[1]="Янв";
$udde_smon[2]="Фев";
$udde_smon[3]="Мар";
$udde_smon[4]="Апр";
$udde_smon[5]="Май";
$udde_smon[6]="Июн";
$udde_smon[7]="Июл";
$udde_smon[8]="Авг";
$udde_smon[9]="Сен";
$udde_smon[10]="Окт";
$udde_smon[11]="Ноя";
$udde_smon[12]="Дек";

$udde_lmon[1]="Январь";
$udde_lmon[2]="Февраль";
$udde_lmon[3]="Март";
$udde_lmon[4]="Апрель";
$udde_lmon[5]="Май";
$udde_lmon[6]="Июнь";
$udde_lmon[7]="Июль";
$udde_lmon[8]="Август";
$udde_lmon[9]="Сентябрь";
$udde_lmon[10]="Октябрь";
$udde_lmon[11]="Ноябрь";
$udde_lmon[12]="Декабрь";

$udde_lweekday[0]="Воскреснье";
$udde_lweekday[1]="Понедельник";
$udde_lweekday[2]="Вторник";
$udde_lweekday[3]="Среда";
$udde_lweekday[4]="Четверг";
$udde_lweekday[5]="Пятница";
$udde_lweekday[6]="Суббота";

$udde_sweekday[0]="Вс";
$udde_sweekday[1]="Пн";
$udde_sweekday[2]="Вт";
$udde_sweekday[3]="Ср";
$udde_sweekday[4]="Чт";
$udde_sweekday[5]="Пт";
$udde_sweekday[6]="Сб";

// *********************************************************
// the following can remain English
// *********************************************************

DEFINE ('_UDDEIM_NOID', 'Ошибка: Такого пользователя не существует.');
DEFINE ('_UDDEIM_VIOLATION', '<b>Нарушение доступа!</b> У вас нет прав для данного действия!');
DEFINE ('_UDDEIM_UNEXPECTEDERROR_QUIT', 'Неизвестная ошибка: ');
DEFINE ('_UDDEIM_ARCHIVENOTENABLED', 'Архив не доступен.');

// *********************************************************
// No translation necessary below this line
// *********************************************************

DEFINE ('_UDDEIM_ONLINEPIC', 'images/icon_online.gif');
DEFINE ('_UDDEIM_OFFLINEPIC', 'images/icon_offline.gif');

// Admin

DEFINE ('_UDDEADM_SETTINGS', 'Администратор');
DEFINE ('_UDDEADM_GENERAL', 'Общие');
DEFINE ('_UDDEADM_ABOUT', 'О нас');
DEFINE ('_UDDEADM_DATESETTINGS', 'Дата и время');
DEFINE ('_UDDEADM_PICSETTINGS', 'Смайлики');
DEFINE ('_UDDEADM_DELETEREADAFTER_HEAD', 'Хранить прочитанные сообщения');
DEFINE ('_UDDEADM_DELETEUNREADAFTER_HEAD', 'Хранить непрочитанные сообщения');
DEFINE ('_UDDEADM_DELETETRASHAFTER_HEAD', 'Хранить сообщения в корзине');
DEFINE ('_UDDEADM_DAYS', 'дней');
DEFINE ('_UDDEADM_DELETEREADAFTER_EXP', 'Укажите, сколько времени вы желаете хранить сообщения (при больших значениях потребляются значительные ресурсы базы данных).');
DEFINE ('_UDDEADM_DELETEUNREADAFTER_EXP', 'Укажите, сколько дней хранить в базе непрочитанные сообщения.');
DEFINE ('_UDDEADM_DELETETRASHAFTER_EXP', 'Укажите, сколько дней хранить сообщения в корзине (рекомендуется указывать значение в пределах от 1 до 4 дней).');
DEFINE ('_UDDEADM_DATEFORMAT_HEAD', 'Формат даты');
DEFINE ('_UDDEADM_DATEFORMAT_EXP', 'Выберите формат отображения даты и времени сообщения. Месяцы будут сокращены, согласно настройкам Joomla. (если присутствует соответствующий языковой файл uddeIM).');
DEFINE ('_UDDEADM_LDATEFORMAT_HEAD', 'Расширенный формат даты');
DEFINE ('_UDDEADM_LDATEFORMAT_EXP', 'Выберите формат даты и времени, который будет отображаться в открытом сообщении. Для названий дней недели и месяцев будут использованы локальные настройки Joomla (если присутствует соответствующий языковой файл uddeIM).');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_HEAD', 'Разрешить автоматическое удаление');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_YES', 'Только администратору');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_NO', 'Любому пользователю');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_EXP', 'Автоматическое удаление создает большую нагрузку на сервер и базу данных! Вариант "Только администратору" рекомендуется для больших сайтов, "Любому пользователю" - для маленьких.');
DEFINE ('_UDDEADM_SAVESETTINGS', 'Сохранить');
DEFINE ('_UDDEADM_THISHASBEENSAVED', 'Следующие параметры относятся к файлу конфигурации:');
DEFINE ('_UDDEADM_SETTINGSSAVED', 'Настройки были сохранены.');
DEFINE ('_UDDEADM_ICONONLINEPIC_HEAD', '"Пользователь на сайте"');
DEFINE ('_UDDEADM_ICONONLINEPIC_EXP', 'Иконка пользователя, находящегося на сайте.');
DEFINE ('_UDDEADM_ICONOFFLINEPIC_HEAD', '"Пользователь не на сайте"');
DEFINE ('_UDDEADM_ICONOFFLINEPIC_EXP', 'Иконка пользователя, которого нет на сайте.');
DEFINE ('_UDDEADM_ICONREADPIC_HEAD', '"Читать сообщение"');
DEFINE ('_UDDEADM_ICONREADPIC_EXP', 'Иконка прочитанных сообщений.');
DEFINE ('_UDDEADM_ICONUNREADPIC_HEAD', '"Непрочитанное сообщение"');
DEFINE ('_UDDEADM_ICONUNREADPIC_EXP', 'Иконка непрочитанных сообщений.');
DEFINE ('_UDDEADM_MODULENEWMESS_HEAD', 'Модуль новых сообщений');
DEFINE ('_UDDEADM_MODULENEWMESS_EXP', 'Настройка модуля mod_uddeim_new. Укажите изображение, которое модуль должен показывать при новых сообщениях.');
DEFINE ('_UDDEADM_UDDEINSTALL', 'Установка uddeIM');
DEFINE ('_UDDEADM_FINISHED', 'Установка закончена. Добро пожаловать в uddeIM!');
DEFINE ('_UDDEADM_NOCB', '<span style="color: red;">Установите Community Builder! В противном случае вы не сможете использовать uddeIM!</span><br /><br />Загрузить Community Builder сейчас? <a href="http://communitybuilder.ru/">Русская дружина Community Builder</a>.');
DEFINE ('_UDDEADM_CONTINUE', 'Продолжить');
DEFINE ('_UDDEADM_PMSFOUND_1', 'Есть ');
DEFINE ('_UDDEADM_PMSFOUND_2', ' сообщений в myPMS. Вы хотите импортировать их в uddeIM?');
DEFINE ('_UDDEADM_IMPORT_EXP', 'Это не повлияет на сообщения myPMS, они будут сохранены в целости и сохранности. Вы можете спокойно импортировать их в uddeIM, даже если будете продолжать использовать myPMS (рекомендуется, сначала сделать модернизацию сайта!). Любые сообщения, которые уже находятся в базе данных uddeIM, останутся целыми и невредимыми.');
DEFINE ('_UDDEADM_IMPORT_YES', 'Импортировать myPMS в uddeIM');
DEFINE ('_UDDEADM_IMPORT_NO', 'Не импортировать сообщения');  
DEFINE ('_UDDEADM_IMPORTING', 'Пожалуйста, подождите окончание импортирования и не предпринимайте никаких действий!');
DEFINE ('_UDDEADM_IMPORTDONE', 'Импортирование старых сообщений окончено. Не повторяйте его, поскольку те же сообщения будут импортированы повторно.'); 
DEFINE ('_UDDEADM_IMPORT', 'Импортирование');
DEFINE ('_UDDEADM_IMPORT_HEADER', ' myPMS сообщений импортировано');
DEFINE ('_UDDEADM_PMSNOTFOUND', 'myPMS не найден. Импортирование невозможно.');
DEFINE ('_UDDEADM_ALREADYIMPORTED', 'Вы уже импортировали сообщения из myPMS в uddeIM.');
DEFINE ('_UDDEADM_BLOCKSYSTEM_HEAD', 'Включить систему блокировки');
DEFINE ('_UDDEADM_BLOCKSYSTEM_EXP', 'Если разрешено, пользователи могут блокировать других пользователей. Заблокированный пользователь не сможет отправлять сообщения тому, кто его заблокировал. Администратор не может быть заблокирован.');
DEFINE ('_UDDEADM_BLOCKSYSTEM_YES', 'Да');
DEFINE ('_UDDEADM_BLOCKSYSTEM_NO', 'Нет');
DEFINE ('_UDDEADM_BLOCKALERT_HEAD', 'Разрешить получать сообщения заблокированным пользователям');
DEFINE ('_UDDEADM_BLOCKALERT_EXP', 'Если установлено "Да", заблокированному пользователю будет сообщено о том, что его сообщение не отправлено по причине блокировки. Если "Нет" - заблокированный пользователь не получит никакого уведомления.');
DEFINE ('_UDDEADM_BLOCKALERT_YES', 'Да');
DEFINE ('_UDDEADM_BLOCKALERT_NO', 'Нет');
DEFINE ('_UDDEADM_DELETIONS', 'Удаление');
DEFINE ('_UDDEADM_BLOCK', 'Блокирование');
DEFINE ('_UDDEADM_INTEGRATION', 'Интеграция');
DEFINE ('_UDDEADM_EMAIL', 'E-mail');
DEFINE ('_UDDEADM_SHOWCBLINK_HEAD', 'Интеграция с Community Builder');
DEFINE ('_UDDEADM_SHOWCBLINK_EXP', 'Когда установлено "Да", то все имена пользователей, обнаруженные в uddeIM, будут показаны в CB.');
DEFINE ('_UDDEADM_SHOWCBPIC_HEAD', 'Показать аватар Community Builder');
DEFINE ('_UDDEADM_SHOWCBPIC_EXP', '');
DEFINE ('_UDDEADM_SHOWONLINE_HEAD', 'Показывать присутствие на сайте');
DEFINE ('_UDDEADM_SHOWONLINE_EXP', 'Если установлено "Да", рядом с именем пользователя показывается маленькое изображение, которое сообщает, находится ли этот пользователь на сайте.');
DEFINE ('_UDDEADM_ALLOWEMAILNOTIFY_HEAD', 'Разрешить использовать уведомления по e-mail');
DEFINE ('_UDDEADM_ALLOWEMAILNOTIFY_EXP', 'Если установлено "Да", каждый пользователь сможет выбрать, хочет ли он получать уведомления на свой электронный адрес.');
DEFINE ('_UDDEADM_EMAILWITHMESSAGE_HEAD', 'Уведомление содержит текст сообщения?');
DEFINE ('_UDDEADM_EMAILWITHMESSAGE_EXP', 'Если включено "Нет", письмо будет содержать только информацию о том, когда и кем отправлено сообщение.');
DEFINE ('_UDDEADM_LONGWAITINGEMAIL_HEAD', 'Напоминание по e-mail');
DEFINE ('_UDDEADM_LONGWAITINGEMAIL_EXP', 'Если входящее сообщение не будет прочитано в течение слишком долгого срока, пользователю на почту отправляется сообщение с напоминанием. Эта опция не зависит от настроек пункта "Разрешить использовать уведомления по e-mail". ');
DEFINE ('_UDDEADM_LONGWAITINGDAYS_HEAD', 'Напомнить через Х дней');
DEFINE ('_UDDEADM_LONGWAITINGDAYS_EXP', 'Интервал напоминания (исчисляется в днях).');
DEFINE ('_UDDEADM_FIRSTWORDSINBOX_HEAD', 'Количество первых знаков');
DEFINE ('_UDDEADM_FIRSTWORDSINBOX_EXP', 'Какое количество знаков от начала сообщения будет выводиться в списках сообщений.');
DEFINE ('_UDDEADM_MAXLENGTH_HEAD', 'Максимальная длина сообщения (количество символов)');
DEFINE ('_UDDEADM_MAXLENGTH_EXP', 'Задайте максимальную длину сообщения. Введите "0"  для снятия ограничения длины сообщения (не рекомендуется).');
DEFINE ('_UDDEADM_YES', 'Да');
DEFINE ('_UDDEADM_NO', 'Нет');
DEFINE ('_UDDEADM_ADMINSONLY', 'Только администратор');
DEFINE ('_UDDEADM_SYSTEM', 'Система');
DEFINE ('_UDDEADM_SYSM_USERNAME_HEAD', 'Имя отправителя системных сообщений');
DEFINE ('_UDDEADM_SYSM_USERNAME_EXP', 'uddeIM поддерживает отправку системных сообщений. Они не имеют видимого отправителя, и пользователи не могут отвечать на них. Укажите псевдоним для сообщений системы ( примеры: "Служба поддержки" или "Администратор"');
DEFINE ('_UDDEADM_ALLOWTOALL_HEAD', 'Администратор может посылать сообщения всем пользователям');
DEFINE ('_UDDEADM_ALLOWTOALL_EXP', 'В uddeIM включена поддержка общих рассылок. В этом случае сообщение отправляется всем пользователям сайта. Используйте эту функцию с умом.');
DEFINE ('_UDDEADM_EMN_SENDERNAME_HEAD', 'Имя отправителя');
DEFINE ('_UDDEADM_EMN_SENDERNAME_EXP', 'Введите имя, от которого будут посылаться уведомления на почту (например: "Администратор")');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_HEAD', 'E-mail адрес отправителя');
DEFINE ('_UDDEADM_EMN_SENDERMAIL_EXP', 'Это должен быть основной электронный адрес вашего сайта.');
DEFINE ('_UDDEADM_VERSION', 'uddeIM версия');
DEFINE ('_UDDEADM_ARCHIVE', 'Архив'); // translators info: headline for Archive system
DEFINE ('_UDDEADM_ALLOWARCHIVE_HEAD', 'Включить архив');
DEFINE ('_UDDEADM_ALLOWARCHIVE_EXP', 'Выберите, будет ли пользователям разрешено хранить сообщения в архиве. Сообщения в архиве не удаляются автоматически.');
DEFINE ('_UDDEADM_MAXARCHIVE_HEAD', 'Максимальное количество сообщений в архиве');
DEFINE ('_UDDEADM_MAXARCHIVE_EXP', 'Сколько сообщений будет храниться в архиве отдельного пользователя.');
DEFINE ('_UDDEADM_COPYTOME_HEAD', 'Разрешить копии');
DEFINE ('_UDDEADM_COPYTOME_EXP', 'Позволяет пользователям сохранять копии отпраляемых сообщений. Копии хранятся в папке "Входящие".');
DEFINE ('_UDDEADM_MESSAGES', 'Сообщения');
DEFINE ('_UDDEADM_TRASHORIGINAL_HEAD', 'Предлагать удалять оригинал'); // 'trash original' the same as _UDDEIM_TRASHORIGINAL
DEFINE ('_UDDEADM_TRASHORIGINAL_EXP', 'Пользователям будет предложено удалить оригинал сообщения.');

// translators info: 'Send' is the same as _UDDEIM_SUBMIT, 


DEFINE ('_UDDEADM_PERPAGE_HEAD', 'Сообщений на страницу');  
DEFINE ('_UDDEADM_PERPAGE_EXP', 'Определите количество сообщений, показываемых на странице.');
DEFINE ('_UDDEADM_CHARSET_HEAD', 'Кодировка сообщений');
DEFINE ('_UDDEADM_CHARSET_EXP', 'Изменяйте это только в случае, если у вас появились проблемы с отображением сообщений в нужной кодировке.');
DEFINE ('_UDDEADM_MAILCHARSET_HEAD', 'Кодировка писем на e-mail');
DEFINE ('_UDDEADM_MAILCHARSET_EXP', 'Изменяйте это только в случае, если у вас появились проблемы с отображением писем в нужной кодировке.'); // translators info: if you're translating into a language that uses a latin charset (like English, Dutch, German, Swedish, Spanish, ... ) you might want to add a line saying 'For usage in [mylanguage] the default value is correct.'
DEFINE ('_UDDEADM_EMN_BODY_NOMESSAGE_EXP', 'Данные теги будут заменены переменными и отправлены по электронной почте. Не нарушайте синтаксис тегов %you%, %user% and %site%.');            
DEFINE ('_UDDEADM_EMN_BODY_WITHMESSAGE_EXP', 'Данные теги будут заменены переменными и отправлены по электронной почте. Не нарушайте синтаксис тегов %you%, %user%, %pmessage% and %site% intact. ');
DEFINE ('_UDDEADM_EMN_FORGETMENOT_EXP', 'Данные теги будут заменены переменными и отправлены по электронной почте при упоминаниях и уведомлениях. Не нарушайте синтаксис тегов  %you% и %site% . ');
DEFINE ('_UDDEADM_ENABLEDOWNLOAD_EXP', 'Разрешить пользователям скачивать сообщения из архива, отправляя их на собственный электронный адрес.');
DEFINE ('_UDDEADM_ENABLEDOWNLOAD_HEAD', 'Разрешить скачивание сообщений');
DEFINE ('_UDDEADM_EXPORT_FORMAT_EXP', 'Эти тэги будут заменены переменными, когда пользователь загружает собственные сообщения из архива. Держите переменные %user%, %msgdate% и %msgbody% без изменения. '); // translators info: Don't translate %you%, %user%, etc. in the strings above.
DEFINE ('_UDDEADM_INBOXLIMIT_HEAD', 'Включить ограничение входящих сообщений');         
DEFINE ('_UDDEADM_INBOXLIMIT_EXP', 'Если превышен установленный лимит, пользователи не смогут оставлять новые сообщения, пока не очистят папки "Входящие" и "Архив", но смогут получать новые сообщения');
DEFINE ('_UDDEADM_SHOWINBOXLIMIT_HEAD', 'Показывать пользователям, сколько сообщений они могут хранить');           
DEFINE ('_UDDEADM_SHOWINBOXLIMIT_EXP', 'Пользователю будет показано, общее число сохраненных сообщений и сколько всего позволено хранить.');
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INTRO', 'Вы выключили архив?');         
DEFINE ('_UDDEADM_ARCHIVETOTRASH_LEAVE_LINK', 'Оставить');            
DEFINE ('_UDDEADM_ARCHIVETOTRASH_LEAVE_EXP', 'Оставить в архиве (пользователь не будет иметь доступа к сообщениям, но они будут числиться за ним и влиять на установленный лимит).');             
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_LINK', 'Переместить во "Входящие"');         
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_DONE', 'Сообщения перемещены из архива в папку "Входящие"');
DEFINE ('_UDDEADM_ARCHIVETOTRASH_INBOX_EXP', 'Сообщения будут перемещены в папку "Входящие" соответствующего пользователя (или в корзину, если они древнее установленного для папки лимита).');              

// 0.4 frontend, but visible admins only (no translation necessary)             

DEFINE ('_UDDEIM_SEND_ASSYSM', 'Послать как системное сообщение (получатели не смогут ответить)');
DEFINE ('_UDDEIM_SEND_TOALL', 'Всем пользователям');
DEFINE ('_UDDEIM_SEND_TOALLADMINS', 'Всем администраторам');
DEFINE ('_UDDEIM_SEND_TOALLLOGGED', 'Всем пользователям на сайте');
DEFINE ('_UDDEIM_VALIDFOR_1', 'Действительно ');
DEFINE ('_UDDEIM_VALIDFOR_2', ' часов. 0 - неограничено (применяется автоматическое удаление)');
DEFINE ('_UDDEIM_WRITE_SYSM_GM', 'Создать системное или общее сообщение');
DEFINE ('_UDDEIM_WRITE_NORMAL', 'Создать обычное сообщение]');
DEFINE ('_UDDEIM_NOTALLOWED_SYSM_GM', 'Системные и общие сообщения запрещены.');
DEFINE ('_UDDEIM_SYSGM_TYPE', 'Тип сообщения');
DEFINE ('_UDDEIM_HELPON_SYSGM', 'Помощь');
DEFINE ('_UDDEIM_HELPON_SYSGM_2', '(открывается в новом окне)');
DEFINE ('_UDDEIM_SYSGM_PLEASECONFIRM', 'Проверьте еще раз сообщение и подтвердите отправку!');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALL', 'Сообщение <strong>всем пользователям</strong>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLADMINS', 'Сообщение <strong>всем администраторам</strong>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDTOALLLOGGED', 'Сообщение <strong>всем пользователям на сайте</strong>');
DEFINE ('_UDDEIM_SYSGM_WILLDISABLEREPLY', 'Получатели не смогут ответить на это сообщение.');
DEFINE ('_UDDEIM_SYSGM_WILLSENDAS_1', 'Сообщение будет отправлено <strong>');
DEFINE ('_UDDEIM_SYSGM_WILLSENDAS_2', '</strong> как имя пользователя');
DEFINE ('_UDDEIM_SYSGM_WILLEXPIRE', 'Срок сообщения истекает ');
DEFINE ('_UDDEIM_SYSGM_WILLNOTEXPIRE', 'Бессрочное сообщение');
DEFINE ('_UDDEIM_SYSGM_CHECKLINK', '<b>Проверьте ссылку перед переходом!</b>');
DEFINE ('_UDDEIM_SYSGM_SHORTHELP', 'В системных сообщениях можно использовать только: [b]<strong>жирный шрифт</strong>[/b] или [i]<em>курсив</em>[/i] - для текста, [url=http://www.someurl.com]ссылка[/url] или [url]http://www.someurl.com[/url] - для ссылок');
DEFINE ('_UDDEIM_SYSGM_ERRORNORECIPS', 'Ошибка: Не указан получатель! Сообщение не отправлено.');                

// new in 0.5 ADMIN

DEFINE ('_UDDEADM_TEMPLATEDIR_HEAD', 'Шаблон оформления');
DEFINE ('_UDDEADM_TEMPLATEDIR_EXP', 'Выберите шаблон оформления компонента.');
DEFINE ('_UDDEADM_SHOWCONNEX_HEAD', 'Показывать связи');
DEFINE ('_UDDEADM_SHOWCONNEX_EXP', 'Выберите <b>Да</b> если у Вас установлен CB/CBE/JS и если Вы хотите показывать связи между пользователями при написании нового сообщения.');
DEFINE ('_UDDEADM_SHOWSETTINGSLINK_HEAD', 'Показывать настройки');
DEFINE ('_UDDEADM_SHOWSETTINGSLINK_EXP', 'Показывать пользователям меню настроек. ');
DEFINE ('_UDDEADM_SHOWSETTINGS_ATBOTTOM', 'Да, внизу');
DEFINE ('_UDDEADM_ALLOWBB_HEAD', 'Позволить использовать <strong>BB</strong>-коды');
DEFINE ('_UDDEADM_FONTFORMATONLY', 'Только для шрифтов');
DEFINE ('_UDDEADM_ALLOWBB_EXP', 'Если выбрано "Только для шрифтов", то пользователи имеют право использовать ВВ-коды только для форматировния шрифтов. Если установлено "Да" - доступны все <strong>BB</strong>-коды.');
DEFINE ('_UDDEADM_ALLOWSMILE_HEAD', 'Разрешить использовать смайлики');
DEFINE ('_UDDEADM_ALLOWSMILE_EXP', 'Если установлено  "Да", то пользователям будет разрешено использовать смайлики.');
DEFINE ('_UDDEADM_DISPLAY', 'Вид');
DEFINE ('_UDDEADM_SHOWMENUICONS_HEAD', 'Показать иконки меню');
DEFINE ('_UDDEADM_SHOWMENUICONS_EXP', 'Если установлено "Да", то ссылки будут отображаться в виде иконок.');
DEFINE ('_UDDEADM_SHOWTITLE_HEAD', 'Заголовок компонента');
DEFINE ('_UDDEADM_SHOWTITLE_EXP', 'Здесь вы можете ввести заголовок компонента, который будет показан всем пользователям.');
DEFINE ('_UDDEADM_SHOWABOUT_HEAD', 'Показывать копирайт');
DEFINE ('_UDDEADM_SHOWABOUT_EXP', 'Установите "Да", если хотите показывать копирайт uddeIM.');
DEFINE ('_UDDEADM_STOPALLEMAIL_HEAD', 'Отключить отправку по e-mail');
DEFINE ('_UDDEADM_STOPALLEMAIL_EXP', 'Включите эту опцию, чтобы блокировать отправку по e-mail, независимо от установленных выше настроек.');
DEFINE ('_UDDEADM_ADMINIGNITIONONLY_MANUALLY', 'вручную');
DEFINE ('_UDDEADM_GETPICLINK_HEAD', 'Аватары Community Builder в списках');
DEFINE ('_UDDEADM_GETPICLINK_EXP', 'Автоматическое удаление создает дополнительную нагрузку на сервер. Если выбрано "Только администратору" автоматическое удаление будет запускаться только, когда администратор будет проверять свою папку "Входящие". Включайте эту опцию только, если администратор регулярно проверяет свои сообщения. Для небольших сайтов и в случае, когда администратор редко посещает ресурс, лучше выбрать "Любому пользователю"');

// new in 0.5 FRONTEND

DEFINE ('_UDDEIM_SHOWUSERS', 'Все пользователи');
DEFINE ('_UDDEIM_CONNECTIONS', 'Связи');
DEFINE ('_UDDEIM_SETTINGS', 'Настройки');
DEFINE ('_UDDEIM_NOSETTINGS', 'Нет доступных настроек.');
DEFINE ('_UDDEIM_ABOUT', 'О программе'); // as in "About uddeIM"
DEFINE ('_UDDEIM_COMPOSE', 'Новое'); // as in "write new message", but only one word
DEFINE ('_UDDEIM_EMN', 'Уведомление о новых сообщениях');
DEFINE ('_UDDEIM_EMN_EXP', 'Вы можете получать уведомление о новых сообщениях на свой электронный адрес.');
DEFINE ('_UDDEIM_EMN_ALWAYS', 'Отправлять всегда');
DEFINE ('_UDDEIM_EMN_NONE', 'Не отправлять');
DEFINE ('_UDDEIM_EMN_WHENOFFLINE', 'Отправлять только, когда я не на сайте');
DEFINE ('_UDDEIM_EMN_NOTONREPLY', 'Не посылать уведомления на ответы');
DEFINE ('_UDDEIM_BLOCKSYSTEM', 'Блокировка пользователей'); // Headline for blocking system in settings
DEFINE ('_UDDEIM_BLOCKSYSTEM_EXP', 'Вы можете заблокировать получение сообщений от некоторых пользователей. Это можно сделать при просмотре сообщения от конкретного пользователя.'); // block user is the same as _UDDEIM_BLOCKNOW
DEFINE ('_UDDEIM_SAVECHANGE', 'Сохранить изменения');
DEFINE ('_UDDEIM_TOOLTIP_BOLD', 'Жирный');
DEFINE ('_UDDEIM_TOOLTIP_ITALIC', 'Курсив');
DEFINE ('_UDDEIM_TOOLTIP_UNDERLINE', 'Подчеркнутый');
DEFINE ('_UDDEIM_TOOLTIP_COLORRED', 'Красный');
DEFINE ('_UDDEIM_TOOLTIP_COLORGREEN', 'Зеленый');
DEFINE ('_UDDEIM_TOOLTIP_COLORBLUE', 'Синий');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE1', 'Очень маленькие буквы');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE2', 'Маленькие буквы');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE4', 'Большие буквы');
DEFINE ('_UDDEIM_TOOLTIP_FONTSIZE5', 'Очень большие буквы');
DEFINE ('_UDDEIM_TOOLTIP_IMAGE', 'BB-код для ссылки на картинку. Пример: [img]ссылка на картинку[/img]');
DEFINE ('_UDDEIM_TOOLTIP_URL', 'Ссылка. Не забывайте ставить префикс http:// в начале каждого адреса (если его нет)');
DEFINE ('_UDDEIM_TOOLTIP_CLOSEALLTAGS', 'Закрыть все теги.');
DEFINE ('_UDDEIM_INBOX_LIMIT_2_SINGULAR', ' сообщений в папке'); // same as _UDDEIM_INBOX_LIMIT_2, but singular (as in 1 "message in your")
DEFINE ('_UDDEIM_ARC_SAVED_NONE_2', '<strong>Нет сообщений в архиве.</strong>'); 

?>