<?php
defined('MOODLE_INTERNAL') || die;
require_once("{$CFG->dirroot}/mod/sallenet/locallib.php");
require_once("$CFG->libdir/externallib.php");
require_once("$CFG->libdir/weblib.php");

class slider_external extends external_api {
	
	public static function servicio1_parameters() {
		return new external_function_parameters(
			array(
				'name' => new external_value(PARAM_TEXT, 'Nombre', VALUE_REQUIRED),
				'courseid' => new external_value(PARAM_INT, 'Nombre', VALUE_REQUIRED),
			)
		);
	}
	
	public static function servicio1_returns() {
		return 
			new external_single_structure(
				array(
					"name" => new external_value(PARAM_INT, "Id del usuario"),
					"description" => new external_value(PARAM_TEXT, "ISBN del libro"),
					"date" => new external_value(PARAM_INT, "Fecha"),
				)
			);
			
	}
	
	public static function servicio1($name, $courseid) {
		global $USER;		
		//se programa el servicio web aqui
		$results = [
			'name' => 'ggjfjgffgg',
			'description' => "fdfdfdsfsd",
			'date' => time(),
			
		];
		return $results;
	}
	
	
	
}


