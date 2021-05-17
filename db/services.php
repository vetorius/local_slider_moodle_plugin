<?php
/**
 * Esto es un fichero para nombrar los servicios que se van a establecer
 * para logmarsupial
 * 
 */

$functions = array(
	// FUNCIONES GENERALES
	"servicio1" => array(
		"classname" 	=> "slider_external",
		"methodname" 	=> "servicio1",
		"classpath" 	=> "local/slider/externallib.php",
		"description"	=> "Esto es un ejemplo",
		"type"			=> "read",
		"capabilities"	=> "",
	)
);

$services = array(
	'slider'  => array(
		'functions' => array (
			// FUNCIONES GENERALES
			'servicio1',
        ),
        'enabled' => 1,
        'restrictedusers' => 0,
        'shortname' => 'slider',
        'downloadfiles' => 0,
        'uploadfiles' => 0
    ),
);
