<?php

/**
 * Version details
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