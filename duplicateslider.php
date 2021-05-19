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
 * duplicate slider page
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__. '/../../config.php');

$sliderid = required_param('id', PARAM_INT);

$context = \context_system::instance();
$PAGE->set_url(new moodle_url('/local/slider/duplicateslider.php'));
$PAGE->set_context($context);

require_login();
require_capability('local/slider:managesliders', $context);

if ($sliderdata = $DB->get_record('local_slider', array('id'=>$sliderid))) {
    $recordtoinsert = new stdClass();
    $recordtoinsert->name = $sliderdata->name . '.COPY';
    // delete previous copy if exists
    if ($previouscopy = $DB->get_record('local_slider', array('name'=>$recordtoinsert->name))){
        $DB->delete_records('local_slider', array('id'=>$previouscopy->id));
    }
    $recordtoinsert->data = $sliderdata->data;
    $recordtoinsert->timecreated = time();
    $recordtoinsert->timemodified = time();
    $DB->insert_record('local_slider', $recordtoinsert);
    redirect(new moodle_url('/local/slider/index.php'),
        get_string('successcreateslider', 'local_slider'),
        null,
        \core\output\notification::NOTIFY_SUCCESS);
} else {
    // slider doesn't exist error
    redirect(new moodle_url('/local/slider/index.php'),
        get_string('error', 'local_slider'),
        null,
        \core\output\notification::NOTIFY_ERROR);
}