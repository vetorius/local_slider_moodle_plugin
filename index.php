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
require_once(__DIR__. '/classes/manage_table.php');

$context = \context_system::instance();
$PAGE->set_url(new moodle_url('/local/slider/index.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('indexslidertitle', 'local_slider'));

$PAGE->set_heading(get_string('indexslidertitle', 'local_slider'));

require_login();
require_capability('local/slider:managesliders', $context);

$PAGE->requires->css(new moodle_url('/local/slider/css/footable.standalone.min.css'));

echo $OUTPUT->header();

//displays the slider editor
$createslider = new moodle_url('/local/slider/insertslider.php?create=1');
$insertslider = new moodle_url('/local/slider/insertslider.php');
$manual = new moodle_url('/local/slider/manual.php');

echo '<div class="row">';
echo '<a href="' . $insertslider . '" class="btn btn-primary">' . get_string('insertslidertitle', 'local_slider') . '</a>&nbsp;';
echo '<a href="' . $createslider . '" class="btn btn-primary">' . get_string('createslidertitle', 'local_slider') . '</a>&nbsp;';
echo '<a href="' . $manual . '" class="btn btn-primary">' . get_string('manualslidertitle', 'local_slider') . '</a>&nbsp;';
echo '</div><hr/>';

$table = new local_slider_manage_table('slidertable');
$table->display();

echo '<div class="row"><p>';
echo get_string('countofsliders', 'local_slider') . $table->count_sliders();
echo '</p></div>';

echo $OUTPUT->footer();