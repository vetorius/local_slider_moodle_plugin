<?php

/**
 * Version details
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__. '/../../config.php');
require_once(__DIR__. '/classes/form/insertslider.php');

global $DB;

$PAGE->set_url(new moodle_url('/local/slider/insertslider.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Insertar nuevo slider');

require_login();

// initialize the form
$mform = new insertslider_form();


//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Go back to main page
    redirect($CFG->wwwroot . '/local/slider/insertslider.php', 'Has cancelado la creación del slider');

} else if ($fromform = $mform->get_data()) {
    //insert the data into the database
    $recordtoinsert = new stdClass();
    $recordtoinsert->name = $fromform->name;
    $recordtoinsert->data = $fromform->data;

    $DB->insert_record('local_slider', $recordtoinsert);

    redirect($CFG->wwwroot . '/local/slider/insertslider.php', 'Datos insertados');
    
}

echo $OUTPUT->header();

//displays the form
$mform->display();

echo $OUTPUT->footer();