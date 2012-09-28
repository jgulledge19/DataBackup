<?php
/** Array of system settings for Mycomponent package
 * @package mycomponent
 * @subpackage build
 */


/* This section is ONLY for new System Settings to be added to
 * The System Settings grid. If you include existing settings,
 * they will be removed on uninstall. Existing setting can be
 * set in a script resolver (see install.script.php).
 */
$settings = array();

$settings['databackup.folder']= $modx->newObject('modSystemSetting');
$settings['databackup.folder']->fromArray(array (
    'key' => 'databackup.folder',
    'value' => '{core_path}components/databackup/dumps/ ',
    'xtype' => 'textfield',
    'namespace' => 'databackup',
    'area' => 'File System',
), '', true, true);

$settings['databackup.purge']= $modx->newObject('modSystemSetting');
$settings['databackup.purge']->fromArray(array (
    'key' => 'databackup.purge',
    'value' => '1814400',
    'xtype' => 'textfield',
    'namespace' => 'databackup',
    'area' => 'File System',
), '', true, true);


return $settings;