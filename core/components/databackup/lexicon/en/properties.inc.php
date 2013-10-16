<?php

$_lang['prop_databackup.dataFolder_desc'] = 'This is the folder path that will save you .sql files to. PHP must have write permissions to this folder.';
$_lang['prop_databackup.tempFolder_desc'] = 'This is the folder path that will create temp files before saving to .sql. PHP must have write permissions to this folder.';
$_lang['prop_databackup.purge_desc'] = 'Purge old files that are older then the current time - seconds. Default is 1814400 (21 days).';
$_lang['prop_databackup.includeTables_desc'] = 'Comma separated list of tables to include. All other tables will be excluded if this option is used.';
$_lang['prop_databackup.excludeTables_desc'] = 'Comma separated list of tables to exclude. All other tables will be included.';
$_lang['prop_databackup.writeFile_desc'] = 'This will write one large SQL dump file.';
$_lang['prop_databackup.writeTableFiles_desc'] = 'This will write each tables as a individual SQL dump file.';
$_lang['prop_databackup.commentPrefix_desc'] = 'This are the SQL comment prefix.';
$_lang['prop_databackup.commentSuffix_desc'] = 'If the comment for SQL need an ending suffix.';
$_lang['prop_databackup.newLine_desc'] = 'The value to print a new line in SQL files. ';
$_lang['prop_databackup.useDrop_desc'] = 'Use the the DROP TABLE in the SQL files';
$_lang['prop_databackup.createDatabase_desc'] = 'Use a CREATE DATABASE command in the SQL files';
