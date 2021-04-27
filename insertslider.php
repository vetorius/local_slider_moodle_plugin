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

$PAGE->set_url(new moodle_url('/local/slider/insertslider.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Insertar nuevo slider');

require_login();

// initialize the form
$mform = new insertslider_form();


echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();