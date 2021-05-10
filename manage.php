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
 * manage sliders page for local_slider module
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__. '/../../config.php');
require_once(__DIR__. '/classes/form/managesliders.php');

global $DB;

$context = \context_system::instance();
$PAGE->set_url(new moodle_url('/local/slider/manage.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('managesliderstitle', 'local_slider'));

$PAGE->set_heading(get_string('managesliderstitle', 'local_slider'));

require_login();
require_capability('local/slider:managesliders', $context);

// initialize the form
$mform = new managesliders_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Go back to main page
    redirect($CFG->wwwroot . '/local/slider/index.php');

} else if ($fromform = $mform->get_data()) {
    switch ($fromform->action){
        case 'edit':
            redirect(new moodle_url('/local/slider/insertslider.php?name=' . $fromform->name));
            break;

        case 'delete':
            $DB->delete_records('local_slider', array('name'=>$fromform->name));
            redirect(new moodle_url('/local/slider/index.php'), get_string('successdeleteslider', 'local_slider'),null, \core\output\notification::NOTIFY_SUCCESS);
            break;
        case 'rename':
            if ($recordtoupdate = $DB->get_record('local_slider', array('name'=>$fromform->name))){
                $recordtoupdate->name = $fromform->newname;
                $DB->update_record('local_slider', $recordtoupdate);
                redirect(new moodle_url('/local/slider/index.php'), get_string('successrenameslider', 'local_slider'),null, \core\output\notification::NOTIFY_SUCCESS);
            } else {
                redirect(new moodle_url('/local/slider/index.php'), get_string('error', 'local_slider'),null, \core\output\notification::NOTIFY_ERROR);
            }
            
            break;
    }
}

echo $OUTPUT->header();

//displays the form
$mform->display();

echo $OUTPUT->footer();