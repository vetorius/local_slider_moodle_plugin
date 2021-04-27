<?php

/**
 * Version details
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->libdir/formslib.php");
 
class insertslider_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;
 
        $mform = $this->_form; // Don't forget the underscore! 
 
        $mform->addElement('text', 'name', 'Nombre del slider', 'size="50"');
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', '');

        $mform->addElement('textarea', 'data', 'JSON del slider', 'wrap="virtual" rows="10" cols="80"');
        $mform->setType('data', PARAM_RAW);
        $mform->setDefault('data', '');
        
        $this->add_action_buttons();

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}