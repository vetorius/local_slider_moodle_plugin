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
 * slider table with search class
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * This class represents a table with one row for each slider
 * with butons to manage sliders
 *
 * An ajaxy search UI shown at the top, if JavaScript is on.
 */

class local_slider_manage_table {

    /** The slider list. Initialised from database. */
    protected $sliders = array();

    /** Added as an id="" attribute to the table on output. */
    protected $id;

    /** Added to the class="" attribute on output. */
    protected $classes = array('table');

    /** Default number of capabilities in the table for the search UI to be shown. */
    const NUM_SLIDER_FOR_SEARCH = 3;

    /**
     * Constructor.
     * @param string $id what to put in the table id="" attribute.
     */
    public function __construct($id) {
        global $DB;

        $this->sliders = $DB->get_records('local_slider', null, 'name', 'id, name, timecreated, timemodified');
        $this->id = $id;
    }

    /**
     * Display the table.
     */
    public function display() {
        if (count($this->sliders) > self::NUM_SLIDER_FOR_SEARCH) {
            global $PAGE;
            
            $PAGE->requires->js(new moodle_url('https://code.jquery.com/jquery-3.4.1.js'));      
            $PAGE->requires->js(new moodle_url('/local/slider/js/footable.min.js'));
            $PAGE->requires->js(new moodle_url('/local/slider/js/slider-selector.js'));
        }
        echo '<div class="container"><table class="' . implode(' ', $this->classes) . '" id="' . $this->id . '">';
        echo "\n<thead>\n<tr>";
        echo '<th>' . get_string('slidername', 'local_slider') . '</th>';
        echo '<th>' . get_string('timecreated', 'local_slider') . '</th>';
        echo '<th>' . get_string('timemodified', 'local_slider') . '</th>';
        echo '<th data-filterable="false">' . get_string('actions', 'local_slider') . '</th>';
        // add more columns
        echo "</tr>\n</thead>\n<tbody>\n";

        foreach ($this->sliders as $slider) {
            $rowattributes = array(); 
            $created = userdate($slider->timecreated, get_string('timeformat', 'local_slider'));
            $modified = userdate($slider->timemodified, get_string('timeformat', 'local_slider'));
            $contents = "<td>$slider->name</td><td>$created</td><td>$modified</td>";
            $contents .= "<td>" . $this->create_buttons($slider->id) . "</td>";

            echo html_writer::tag('tr', $contents, $rowattributes);
        }

        // End of the table.
        echo "</tbody>\n</table>\n</div>";
    }

    /**
     * Create the edition buttons
     */
    private function create_buttons($id){

        $buttons = '';
        //add edit button
        $editLink = new moodle_url("/local/slider/insertslider.php?id=$id");
        $buttons .= '<a href="' . $editLink . '" class="btn btn-primary">';
        $buttons .= '<span class="fooicon fooicon-pencil"></span></a>&nbsp;';
        //add duplicate button
        $copyLink = new moodle_url("/local/slider/duplicateslider.php?id=$id");
        $buttons .= '<a href="' . $copyLink . '" class="btn btn-primary">';
        $buttons .= '<span class="fooicon fooicon-clone"></span></a>&nbsp;';
        //generate pdf button
        $pdfLink = '#'; //new moodle_url("/local/slider/...");
        $buttons .= '<a href="' . $pdfLink . '" class="btn btn-primary" disabled>';
        $buttons .= '<span class="fooicon fooicon-pdf"></span></a>&nbsp;';
        //add delete button
        $deleteLink = new moodle_url("/local/slider/delete.php?id=$id");
        $buttons .= '<a href="' . $deleteLink . '" class="btn btn-danger">';
        $buttons .= '<span class="fooicon fooicon-trash"></span></a>&nbsp;';

        return $buttons;
    }


}