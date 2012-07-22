<?php
// http://www.phpclasses.org/browse/file/33388.html

$path = $modx->getOption('core_path').'components/databackup/';
require_once $path.'model/mysql/dbbackup.class.php';

$output = '';
// back up my modx database:
$data_folder = $modx->getOption('databackup.folder', $scriptProperties, $path.'dumps/');
$purge_time = $modx->getOption('databackup.purge', $scriptProperties, 1814400);
// includeTables should be a comma separtaed list
$includeTables = $modx->getOption('includeTables', $scriptProperties, NULL);
// excludeTables should be a comma separtaed list
$excludeTables = $modx->getOption('excludeTables', $scriptProperties, NULL);

$write_file = $modx->getOption('writeFile', $scriptProperties, true);
if ( $write_file === 'false' ) {
    $write_file = false;
    $output .= ' <br>Do not write main file<br>';
}
$write_table_files = $modx->getOption('writeTableFiles', $scriptProperties, true);
if ( $write_table_files === 'false' ) {
    $write_table_files = false;
    $output .= ' <br>Do not write table files<br>';
}
// these are to change how the data file is written
$comment_prefix = $modx->getOption('commentPrefix', $scriptProperties, '--');
$comment_suffix = $modx->getOption('commentSuffix', $scriptProperties, '');
$new_line = $modx->getOption('newLine', $scriptProperties, "\n");
// use the sql drop command
$use_drop = $modx->getOption('useDrop', $scriptProperties, true);
if ( $use_drop === 'false' ) {
    $use_drop = false;
}
$database = $modx->getOption('database', $scriptProperties, 'modx');
// use the sql create database command
$create_database = $modx->getOption('createDatabase', $scriptProperties, false);
if ( $create_database === 'false' ) {
    $create_database = false;
}

$db = new DBBackup($modx,
    array(
        'comment_prefix' => $comment_prefix,
        'comment_suffix' => $comment_suffix,
        'new_line' => $new_line,
        'base_path' => $data_folder,
        'write_file' => $write_file,
        'write_table_files' => $write_table_files,
        'use_drop' => $use_drop,
        'database' => $database,
        'create_database' => $create_database,
        'includeTables' => $includeTables,
        'excludeTables' => $excludeTables,
         
    ));

$backup = $db->backup();
if($backup){
    $output .= 'The MODX data has been backed up';
} else {
    $output .= 'An error has ocurred and MODX did not get backed up correctly: '.$db->getErrors();
}
$db->purge($purge_time);

return $output;

// restore: http://efreedom.com/Question/1-898440/PDO-SQL-Server-RESTORE-DATABASE-Query-Wait-Finished
// $pdo->exec('RESTORE DATABASE [blah] FROM DISK = \'c:\blah.bak\' WITH NOUNLOAD');
