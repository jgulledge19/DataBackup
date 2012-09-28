<?php
// http://www.phpclasses.org/browse/file/33388.html

$path = $modx->getOption('core_path').'components/databackup/';
require_once $path.'model/mysql/dbbackup.class.php';

// back up my modx database:
$db = new DBBackup($modx );
$backup = $db->backup();
$output = '';
if($backup){
    $output .= 'The MODX data has been backed up';
} else {
    $output .= 'An error has ocurred and MODX did not get backed up correctly: '.$db->getErrors();
}

require_once str_replace('core/', '', $modx->getOption('core_path')).'/bc_config.php';
// website_db
// now backup another database that the modx db user has access to
$db = new DBBackup($modx, array(
    'driver' => 'mysql',
    'host' => $hostname,
    'database' => 'website_db',
    'user' => $username,
    'password' => $password,
    'connect' => true
));
$backup = $db->backup();
if($backup){
    $output .= '<br>The website_db data has been backed up';
} else {
    $output .= '<br>An error has ocurred and website_db did not get backed up correctly: '.$db->getErrors();
}
return $output;
// 


// now backup another database that the modx db user has access to
$db = new DBBackup($modx, array(
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'modx_test',
    'user' => 'modx_user',
    'password' => 'your password',
    'connect' => true
));
$backup = $db->backup();
if($backup){
    $output .= '<br>The MODX Test data has been backed up';
} else {
    $output .= '<br>An error has ocurred and MODX Test did not get backed up correctly: '.$db->getErrors();
}
return $output;