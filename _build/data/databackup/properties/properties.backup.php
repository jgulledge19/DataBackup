<?php

$properties = array(
    array(
          'name' => 'dataFolder',
          'desc' => 'prop_databackup.dataFolder_desc',
          'type' => 'textfield',
          'options' => '',
          'value' => '',
          'lexicon' => 'databackup:properties'
          ),
    array(
          'name' => 'purge',
          'desc' => 'prop_databackup.purge_desc',
          'type' => 'textfield',
          'options' => '',
          'value' => '',
          'lexicon' => 'databackup:properties'
          ),
    array(
          'name' => 'includeTables',
          'desc' => 'prop_databackup.includeTables_desc',
          'type' => 'textfield',
          'options' => '',
          'value' => '',
          'lexicon' => 'databackup:properties'
          ),
    array(
          'name' => 'excludeTables',
          'desc' => 'prop_databackup.excludeTables_desc',
          'type' => 'textfield',
          'options' => '',
          'value' => '',
          'lexicon' => 'databackup:properties'
          ),
    array(
          'name' => 'writeFile',
          'desc' => 'prop_databackup.writeFile_desc',
          'type' => 'combo-boolean',
          'options' => '',
          'value' => 1,
          'lexicon' => 'databackup:properties'
          ),
    array(
          'name' => 'writeTableFiles',
          'desc' => 'prop_databackup.writeTableFiles_desc',
          'type' => 'combo-boolean',
          'options' => '',
          'value' => 1,
          'lexicon' => 'databackup:properties'
          ),
    array(
          'name' => 'commentPrefix',
          'desc' => 'prop_databackup.commentPrefix_desc',
          'type' => 'textfield',
          'options' => '',
          'value' => '-- ',
          'lexicon' => 'databackup:properties'
          ),
    array(
          'name' => 'commentSuffix',
          'desc' => 'prop_databackup.commentSuffix_desc',
          'type' => 'textfield',
          'options' => '',
          'value' => '',
          'lexicon' => 'databackup:properties'
          ),
    array(
          'name' => 'newLine',
          'desc' => 'prop_databackup.newLine_desc',
          'type' => 'textfield',
          'options' => '',
          'value' => "\n",
          'lexicon' => 'databackup:properties'
          ),
    array(
          'name' => 'useDrop',
          'desc' => 'prop_databackup.useDrop_desc',
          'type' => 'combo-boolean',
          'options' => '',
          'value' => 1,
          'lexicon' => 'databackup:properties'
          ),
    array(
          'name' => 'createDatabase',
          'desc' => 'prop_databackup.createDatabase_desc',
          'type' => 'combo-boolean',
          'options' => '',
          'value' => 0,
          'lexicon' => 'databackup:properties'
          )
);

return $properties;