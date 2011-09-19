<?php
// http://www.phpclasses.org/browse/file/33388.html

$path = $modx->getOption('core_path').'components/databackup/';
require_once $path.'model/mysql/dbbackup.class.php';

/*
 * Need to create purge date and data folder options
 */

// back up my modx database:
$data_folder = $modx->getOption('databackup.folder', $scriptProperties, $path.'dumps/');
$purge_time = $modx->getOption('databackup.pruge', $scriptProperties, 1814400);

$db = new DBBackup($modx,array('base_path' => $data_folder ) );

$backup = $db->backup();
$output = '';
if($backup){
    $output .= 'The MODX data has been back up';
} else {
    $output .= 'An error has ocurred and MODX did not get backed up correctly: '.$db->getErrors();
}
$db->purge($purge_time);

return $output;

// restore: http://efreedom.com/Question/1-898440/PDO-SQL-Server-RESTORE-DATABASE-Query-Wait-Finished
// $pdo->exec('RESTORE DATABASE [blah] FROM DISK = \'c:\blah.bak\' WITH NOUNLOAD');
