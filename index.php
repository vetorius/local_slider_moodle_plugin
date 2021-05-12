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

echo $OUTPUT->header();

//displays the slider editor
$createslider = new moodle_url('/local/slider/insertslider.php?create=1');
$insertslider = new moodle_url('/local/slider/insertslider.php');
$managesliders = new moodle_url('/local/slider/manage.php');
$manual = new moodle_url('/local/slider/manual.php');

echo '<a href="' . $insertslider . '" class="btn btn-primary">' . get_string('insertslidertitle', 'local_slider') . '</a>&nbsp;';
echo '<a href="' . $createslider . '" class="btn btn-primary">' . get_string('createslidertitle', 'local_slider') . '</a>&nbsp;';
echo '<a href="' . $managesliders . '" class="btn btn-primary">' . get_string('managesliderstitle', 'local_slider') . '</a>&nbsp;';
echo '<a href="' . $manual . '" class="btn btn-primary">' . get_string('manualslidertitle', 'local_slider') . '</a>&nbsp;';


/**
 * 
 * A partir de aquí y antes de mostrar el footer hay código de chequeo para probar cosas
 * 
 */

/* echo '<hr/>';
echo '<pre>';
var_dump($CFG);
echo '<p>' . time() . '</p>';
echo '<p>' . userdate(time(), '%d %B %Y, %H:%M:%S') . '</p>';
echo '</pre>'; */

/* if ($sliders = $DB->get_records('local_slider', null, 'name', 'id, name, timecreated, timemodified')){
    echo '<div class="row"><table class="table table-sm">';
    echo '<thead><tr><th>id</th><th>name</th><th>timecreated</th><th>timemodified</th></tr></thead>';
    foreach ($sliders as $key => $value) {
        $created = userdate($value->timecreated, get_string('timeformat', 'local_slider'));
        $modified = userdate($value->timemodified, get_string('timeformat', 'local_slider'));
        echo "<tr><td>$value->id</td><td>$value->name</td><td>$created</td><td>$modified</td></tr>";
    }
    echo '</table></div>';
} */
    $table = new local_slider_manage_table('slidertable');
    $table->display();

$sql = 'SELECT MAX(timemodified) AS lastmodified FROM {local_slider}';
if ($data = $DB->get_record_sql($sql)){
    echo '<div class="row"><p>La última fecha de actualización es: ';
    echo userdate($data->lastmodified, get_string('timeformat', 'local_slider'));
    echo '</p></div>';
}


echo $OUTPUT->footer();