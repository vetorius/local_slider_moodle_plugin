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
 * manage sliders form class
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");
 
class managesliders_form extends moodleform {
    //Add elements to form
    public function definition() {
        
        global $DB;
 
        $mform = $this->_form; // Don't forget the underscore!

        $actionsarray = array(
            'edit' => get_string('edit', 'local_slider'),
            'delete' => get_string('delete', 'local_slider'),
            'rename' => get_string('rename', 'local_slider')
        );
 
        $mform->addElement('select', 'action', get_string('action', 'local_slider'), $actionsarray);
        $mform->getElement('action')->setSelected('edit');

        $slidersarray = array();        
        $sliderdata = $DB->get_records('local_slider', null, '', 'name');
        foreach ($sliderdata as $key => $slider) {
            $slidersarray[$slider->name] = $slider->name;
        }

        $mform->addElement('searchableselector', 'name', get_string('slidername', 'local_slider'), $slidersarray);
        $mform->addRule('name', get_string('required'), 'required');

        $mform->addElement('text', 'newname', get_string('newslidername', 'local_slider'), 'size="50"');
        $mform->setType('newname', PARAM_NOTAGS);
        $mform->hideIf('newname', 'action', 'neq', 'rename');
        
        $this->add_action_buttons(true, get_string('sendaction', 'local_slider'));

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}