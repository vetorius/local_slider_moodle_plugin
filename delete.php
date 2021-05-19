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
 * delete slider page
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__. '/../../config.php');

$deleteid = required_param('id', PARAM_INT);
$confirm = optional_param('confirm', 0, PARAM_INT);

$context = \context_system::instance();
$PAGE->set_url(new moodle_url('/local/slider/deleteslider.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('deleteslidertitle', 'local_slider'));
$PAGE->set_heading(get_string('deleteslidertitle', 'local_slider'));

require_login();
require_capability('local/slider:managesliders', $context);

if ($confirm && confirm_sesskey()){
    // delete the slider if confirmed
    if ($DB->delete_records('local_slider', array('id'=>$deleteid))) {
        redirect(new moodle_url('/local/slider/index.php'),
                get_string('successdeleteslider', 'local_slider'),
                null,
                \core\output\notification::NOTIFY_SUCCESS);
    } else {
        // if the slider id given doesn't exist returns to index with error message
        redirect(new moodle_url('/local/slider/index.php'),
            get_string('error', 'local_slider'),
            null,
            \core\output\notification::NOTIFY_ERROR);
    }
}

// if the slider exists, ask for confirmation
if ($recordData = $DB->get_record('local_slider', array('id'=>$deleteid), 'id, name')){
    echo $OUTPUT->header();
    $paramsyes = array('sesskey' => sesskey(), 'confirm' => 1, 'id' => $recordData->id);
    $paramsno = array();
    echo $OUTPUT->confirm(get_string('commentdelete', 'local_slider', $recordData->name),
                            new moodle_url('/local/slider/delete.php', $paramsyes),
                            new moodle_url('/local/slider/index.php', $paramsno));
    echo $OUTPUT->footer();
} else {
    // if the slider id given doesn't exist returns to index with error message
    redirect(new moodle_url('/local/slider/index.php'),
        get_string('error', 'local_slider'),
        null,
        \core\output\notification::NOTIFY_ERROR);
}