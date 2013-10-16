<?php
/**
 * Default English Lexicon Entries for GroupELetters
 *
 * @package Databackup
 * @subpackage lexicon
 */

//general
$_lang['groupeletters'] = 'Databackup';
$_lang['groupeletters.desc'] = 'Backup your MODX database';


//system settings
$_lang['setting_databackup.folder'] = 'Folder/Directory';
$_lang['setting_databackup.folder_desc'] = 'This is the folder path where the .sql files written/saved. PHP must have write permissions to this folder.';

$_lang['setting_databackup.temp'] = 'Temp Directory';
$_lang['setting_databackup.temp_desc'] = 'This is the directory path where temp files are created and delted to build the .sql files. PHP must have write permissions to this folder.';

$_lang['setting_databackup.pruge'] = 'Pruge Files';
$_lang['setting_databackup.pruge_desc'] = 'Purge old files that are older then the current time - seconds. Default is 1814400 (21 days). ';
