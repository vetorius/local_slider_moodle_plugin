<?php

/**
 * Version details
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__. '/../../config.php');

// get slidername parameter
// $slidername = optional_param('slidername', '', PARAM_ALPHA);
// $sliderExtensionUrl =  new moodle_url('/local/slider/getslider.php');
// $PAGE->set_url($sliderExtensionUrl);

// only logged users can access
require_login();

// get slider data from database



// send mime type and encoding
@header('Content-Type: application/json; charset=utf-8');

// we do not want html markup
@ini_set('html_errors', 'off');

// send json data
echo '{ "sesiones": [ { "name": "S-1", "actividades": []}, { "name": "S-2", "actividades": []} ]}';