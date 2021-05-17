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
 * local library for slider module.
 * Contains functions that are called from within the module only.
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(dirname(__FILE__) . '/../../config.php');

/**
 * converts the recordset in a tab+newline separated string
 * and compress it with gzip
 *
 * @param array $dataarray The response of a query to the local_slider table.
 * 
 * @return string The compressed string
 */
function compress_records($dataarray) {

    // prepare first line with field names
    $fieldnames = new stdClass();
    $fieldnames->name = 'name';
    $fieldnames->data = 'data';
    $fieldnames->timecreated = 'timecreated';
    $fieldnames->timemodified = 'timemodified';

    // prepare the sliders array
    $sliders[] = (array)$fieldnames;

    foreach ($dataarray as $data) {
        $slider = new stdClass();
        $slider->name = $data->name;
        $slider->data = $data->data;
        $slider->timecreated = $data->timecreated;
        $slider->timemodified = $data->timemodified;

        $sliders[] =  (array)$slider;
    }

    // implode sliders into a tab+newline separated string...
    $callback = function($value) {
        return implode("\t", $value);
    };
    $rawdata = implode("\n", array_map($callback, $sliders));

    // compress using gzip compression - employ maximum compression
    $gzdata = gzencode($rawdata, 9);

    return $gzdata;
}

/**
 * Returns an array with all the data in local_slider table
 * 
 * @return array The response of the database request
 */
function get_slider_data(){
    
    global $DB;

    $sliders = $DB->get_records('local_slider');

    return $sliders;
}

/**
 * Returns an array with records in local_slider table newer than a given date
 * 
 * @param integer $date timestamp for the date to request newer records
 * 
 * @return array The response of the database request
 */
function get_new_slider_data($date){

    global $DB;

    $sql = 'SELECT * FROM {local_slider} WHERE timemodified > :date';
    $params = array('date'=>$date);
    $sliders = $DB->get_records_sql($sql, $params);

    return $sliders;
}