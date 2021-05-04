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
 * Plugin settigs
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

// Ensure the configurations for this site are set
if ( $hassiteconfig ){
 
	// Create the new settings page
	// - in a local plugin this is not defined as standard, so normal $settings->methods will throw an error as
	// $settings will be NULL
	$settings = new admin_settingpage( 'local_slider', 'Ajustes de slider' );
 
	// Create 
	$ADMIN->add( 'localplugins', $settings );
 
	// Add update url field to the settings
	$settings->add( new admin_setting_configtext(
 
		// This is the reference you will use to your configuration
		'local_slider/updateurl',
 
		// This is the friendly title for the config, which will be displayed
		get_string('updateurl', 'local_slider'),
 
		// This is helper text for this config field
		get_string('updateurldesc', 'local_slider'),
 
		// This is the default value
		'No Key Defined',
 
		// This is the type of Parameter this config is
		PARAM_TEXT
 
	) );

	// Add API key url field to the settings
	$settings->add( new admin_setting_configtext(
 
		// This is the reference you will use to your configuration
		'local_slider/apikey',
 
		// This is the friendly title for the config, which will be displayed
		get_string('apikey', 'local_slider'),
 
		// This is helper text for this config field
		get_string('apikeydesc', 'local_slider'),
 
		// This is the default value
		'No Key Defined',
 
		// This is the type of Parameter this config is
		PARAM_TEXT
 
	) );
 
}