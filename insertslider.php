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

$create = optional_param('create', 0, PARAM_INT);
$slidername = optional_param('name', '', PARAM_RAW);

$context = \context_system::instance();
$PAGE->set_url(new moodle_url('/local/slider/insertslider.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('insertslidertitle', 'local_slider'));

require_login();
require_capability('local/slider:managesliders', $context);

// initialize the form
$mform = new insertslider_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Go back to main page
    redirect(new moodle_url('/local/slider/index.php'), get_string('cancel', 'local_slider'));

} else if ($fromform = $mform->get_data()) {
    //insert the data into the database
    $recordtoinsert = new stdClass();
    $recordtoinsert->name = $fromform->name;
    $recordtoinsert->data = $fromform->data;

    if ($lastsliderdata = $DB->get_record('local_slider', array('name'=>$fromform->name))) {
        // if the slidername exists, update the record and saves a BACKUP record with name slidername+.BACKUP
        // first of all delete previous BACKUP record if exists
        $bckpname = $lastsliderdata->name . '.BACKUP';
        if ($lastbackup = $DB->get_record('local_slider', array('name'=>$bckpname))){
            $DB->delete_records('local_slider', array('id'=>$lastbackup->id));
        }
        // update last slider data with new data
        $recordtoinsert->id = $lastsliderdata->id;
        $recordtoinsert->timemodified = time();
        $DB->update_record('local_slider', $recordtoinsert);
        // create new BACKUP record with last slider data
        $lastsliderdata->name = $bckpname;
        $DB->insert_record('local_slider', $lastsliderdata);
        // redirect to index
        redirect($CFG->wwwroot . '/local/slider/index.php', get_string('successupdateslider', 'local_slider'),null, \core\output\notification::NOTIFY_SUCCESS);
    } else {
        // if slidername doesn't exist creates the record
        $recordtoinsert->timecreated = time();
        $recordtoinsert->timemodified = time();
        $DB->insert_record('local_slider', $recordtoinsert);
        redirect($CFG->wwwroot . '/local/slider/index.php', get_string('successcreateslider', 'local_slider'),null, \core\output\notification::NOTIFY_SUCCESS);
    }
}

if ($CFG->theme == "essential") {
    $PAGE->requires->js(new moodle_url('/local/slider/editorassets/b2/app.js'));
    $PAGE->requires->js(new moodle_url('/local/slider/editorassets/b2/chunk-vendors.js'));
    $PAGE->requires->css(new moodle_url('/local/slider/editorassets/b2/app.css'));
} else {
    $PAGE->requires->js(new moodle_url('/local/slider/editorassets/b4/app.js'));
    $PAGE->requires->js(new moodle_url('/local/slider/editorassets/b4/chunk-vendors.js'));
    $PAGE->requires->css(new moodle_url('/local/slider/editorassets/b4/app.css'));
}

//displays the slider editor if create parameter is 1
if ($create==1){ 
    $PAGE->set_heading(get_string('createslidertitle', 'local_slider'));
    echo $OUTPUT->header();
    echo '<div id="app"></div>';
} else if ($slidername!='') {
    if ($lastsliderdata = $DB->get_record('local_slider', array('name'=>$slidername), 'name, data')) {
        $PAGE->set_heading(get_string('modifyslidertitle', 'local_slider'));
        echo $OUTPUT->header();
        $mform->set_data($lastsliderdata);
        echo '<div id="app"></div>';
    }
} else {
    $PAGE->set_heading(get_string('insertslidertitle', 'local_slider'));
        echo $OUTPUT->header();
}
//displays the form
$mform->display();

echo $OUTPUT->footer();