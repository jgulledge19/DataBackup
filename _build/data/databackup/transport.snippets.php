<?php
/**
 * MyComponent transport snippets
 * Copyright 2011 Your Name <you@yourdomain.com>
 * @author Your Name <you@yourdomain.com>
 * 1/1/11
 *
 * MyComponent is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * MyComponent is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * MyComponent; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package mycomponent
 */
/**
 * Description:  Array of snippet objects for MyComponent package
 * @package mycomponent
 * @subpackage build
 */

if (! function_exists('getSnippetContent')) {
    function getSnippetContent($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<?php','',$o);
        $o = str_replace('?>','',$o);
        $o = trim($o);
        return $o;
    }
}
$snippets = array();

$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1, // set this in order not the ID for the snippet
    'name' => 'backup',
    'description' => 'Create a SQL dump of your MODX database.',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.backup.php'),
),'',true,true);
$properties = include $sources['data'].'/properties/properties.backup.php';
$snippets[1]->setProperties($properties);
unset($properties);

$snippets[2]= $modx->newObject('modSnippet');
$snippets[2]->fromArray(array(
    'id' => 2, // set this in order not the ID for the snippet
    'name' => 'backupmany',
    'description' => 'An example snippet that will allow you to create a SQL dump of many databases.',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.backupmany.php'),
),'',true,true);


return $snippets;