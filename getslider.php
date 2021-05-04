<?php

/**
 * This file is part of Moodle - http://moodle.org/
 *
 * Moodle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Moodle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * getslider service returns JSON 
 * optional paramenter slidername
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__. '/../../config.php');

global $DB;

// get slidername parameter
$slidername = optional_param('slidername', '', PARAM_RAW);

$PAGE->set_url(new moodle_url('/local/slider/getslider.php'));


// only logged users can access
require_login();

// get slider data from database
if ($sliderdata = $DB->get_record('local_slider', array('name'=>$slidername), 'data')) {
    $jsondata = $sliderdata->data;
} else {
    $jsondata = '{ }';
}


// send mime type and encoding
@header('Content-Type: application/json; charset=utf-8');
//@header('Content-Type: text/plain; charset=utf-8');
// we do not want html markup
@ini_set('html_errors', 'off');

// send json data
echo $jsondata;