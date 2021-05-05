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
 * index page for local_slider module
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__. '/../../config.php');

$PAGE->set_url(new moodle_url('/local/slider/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('indexslidertitle', 'local_slider'));

require_login();

echo $OUTPUT->header();

//displays the slider editor
$createslider = new moodle_url('/local/slider/insertslider.php?create=1');
$insertslider = new moodle_url('/local/slider/insertslider.php');
$managesliders = new moodle_url('/local/slider/manage.php');

echo '<a href="' . $insertslider . '" class="btn btn-primary">' . get_string('insertslidertitle', 'local_slider') . '</a>&nbsp;';
echo '<a href="' . $createslider . '" class="btn btn-primary">' . get_string('createslidertitle', 'local_slider') . '</a>&nbsp;';
echo '<a href="' . $managesliders . '" class="btn btn-primary">' . get_string('managesliderstitle', 'local_slider') . '</a>&nbsp;';

/*
echo '<hr/>';
echo '<pre>';
var_dump($CFG);
echo '</pre>';
*/

echo $OUTPUT->footer();