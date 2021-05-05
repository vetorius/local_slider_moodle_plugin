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
 * insertslider page
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__. '/../../config.php');
require_once(__DIR__. '/classes/form/insertslider.php');

global $DB;

$create = optional_param('create', 0, PARAM_INT);
$slidername = optional_param('name', '', PARAM_RAW);

$PAGE->set_url(new moodle_url('/local/slider/insertslider.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('insertslidertitle', 'local_slider'));

require_login();

// initialize the form
$mform = new insertslider_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Go back to main page
    redirect($CFG->wwwroot . '/local/slider/index.php', get_string('cancelcreateslider', 'local_slider'));

} else if ($fromform = $mform->get_data()) {
    //insert the data into the database
    $recordtoinsert = new stdClass();
    $recordtoinsert->name = $fromform->name;
    $recordtoinsert->data = $fromform->data;
    if ($sliderdata = $DB->get_record('local_slider', array('name'=>$fromform->name))) {
        $recordtoinsert->id = $sliderdata->id;
        $DB->update_record('local_slider', $recordtoinsert);
        redirect($CFG->wwwroot . '/local/slider/index.php', get_string('successupdateslider', 'local_slider'));
    } else {
        $DB->insert_record('local_slider', $recordtoinsert);
        redirect($CFG->wwwroot . '/local/slider/index.php', get_string('successcreateslider', 'local_slider'));
    }
}

$PAGE->requires->js(new moodle_url('/local/slider/editorassets/app.9044506f.js'));
$PAGE->requires->js(new moodle_url('/local/slider/editorassets/chunk-vendors.365116bf.js'));

$PAGE->requires->css(new moodle_url('/local/slider/editorassets/app.02092411.css'));

echo $OUTPUT->header();

//displays the slider editor if create parameter is 1
if ($create==1){ 
    echo '<div id="app"></div>';
}
if ($slidername!='') {
    if ($sliderdata = $DB->get_record('local_slider', array('name'=>$slidername), 'name, data')) {
        $mform->set_data($sliderdata);
        echo '<div id="app"></div>';
    }
}
//displays the form
$mform->display();

echo $OUTPUT->footer();