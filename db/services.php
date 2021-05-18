<?php

// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * WebServices interface for slider plugin
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// We defined the web service functions to install.

$functions = array(
    'local_slider_get_sliders' => array(
        'classname'     => 'local_slider_external',
        'methodname'    => 'get_sliders',
        'classpath'     => 'local/slider/externallib.php',
        'description'   => 'Return array of sliders.',
        'type'          => 'read',
        'ajax'          => true,
        'capabilities'  => 'local/slider:readsliders',
    ),
    'local_slider_get_new_sliders' => array(
        'classname'     => 'local_slider_external',
        'methodname'    => 'get_new_sliders',
        'classpath'     => 'local/slider/externallib.php',
        'description'   => 'Return array of sliders newer than a given date. Requires a date as a parameter',
        'type'          => 'read',
        'ajax'          => true,
        'capabilities'  => 'local/slider:readsliders',
    ),
);

// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = array(
    'Slider API service'  => array(
        'functions' => array (  'local_slider_get_sliders',
                                'local_slider_get_new_sliders'),
        'requiredcapability' => 'local/slider:readsliders',
        'restrictedusers' => 0,
        'enabled' => 1,
        'shortname' => 'Slider',
        'downloadfiles' => 0,
        'uploadfiles' => 0,
    ),
);
