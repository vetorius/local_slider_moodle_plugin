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
 * Decompress records from API request and create an array
 * from the incoming data as a tab+newline separated string
 * 
 * @param string $string compressed tab+newline separated string data
 * 
 * @return array a multidimensional array with field names in the first row
 */
function decompress_records($string){

    $data = gzdecode($string);

    $result = array();

    foreach (explode("\n", $data) as $row) {
        $result[] = explode("\t", $row);
    }

    return $result;    
}

/**
 * Create an associative data array from a multidimentional array.
 * The first row represents the names for association
 * 
 * @param array $data
 * 
 * @return array asociative array, with the first row of $data as the names for association
 */
function associate_data($data) {
    $associations = array_shift($data);

    $associativeArray = array();

    foreach ($data as $row) {
        $dataBlock = array();
        $index = 0;
        foreach ($row as $element) {
            $dataBlock[$associations[$index++]] = $element;
        }

        $associativeArray[] = $dataBlock;
    }

    return $associativeArray;
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

/**
 * Request the web service to get the data
 * 
 * @param string $functionname name of the remote function
 * @param array $params parameters passed to the remote function 
 * 
 * @return array The response of the webservice
 */
function call_api($functionname, $params=array()){

    $apiurl = get_config('local_slider', 'updateurl');
    $apikey = get_config('local_slider', 'apikey');
    echo '<p>ejecuntando call_api</p>';
    $serverurl = $apiurl . '/webservice/xmlrpc/server.php'. '?wstoken=' . $apikey;
//    require_once(dirname(__FILE__) . '/classes/curl.php');
    $myapi = new curl;
    $post = xmlrpc_encode_request($functionname, $params);
    echo $serverurl . '<hr/>';
    var_dump($post);
    $response = $myapi->post($serverurl, $post);
    $resp = xmlrpc_decode($response);
    echo  '<hr/>' . $response . '<hr/>';
    // decompress raw data
    // $data = decompress_records($resp['data']);
    // $sliders = associate_data($data);

    return $resp;
}