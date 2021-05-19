<?php

// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * WebServices interface for slider module
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/externallib.php");
require_once(dirname(__FILE__)."/locallib.php");

class local_slider_external extends external_api {
    
    public static function get_sliders_parameters() {
        // no parameters required
        return new external_function_parameters(array( ));
    }

    public static function get_sliders() {		
 
        //Parameter validation
        $params = self::validate_parameters(self::get_sliders_parameters(), array());

        // check capabilities here if needed 

        $allsliders = compress_records(get_slider_data());
        $message = base64_encode($allsliders);
        $results = [
            'data' => $message,
        ];

        return $results;
    }
        
    public static function get_sliders_returns() {
        return 
            new external_single_structure(
                array(
                    'data' => new external_value(PARAM_TEXT, 'All slider data as a compressed array'),
                )
            );
    }
    
    public static function get_new_sliders_parameters() {
        return new external_function_parameters(
            array('date' => new external_value(PARAM_INT, 'The date to return sliders from', VALUE_REQUIRED))
        );
    }

    public static function get_new_sliders($date) {		
        
        //Parameter validation
        $params = self::validate_parameters(self::get_new_sliders_parameters(),
                array('date'=> $date));
        
        // check capabilities here if needed 

        $newsliders = compress_records(get_new_slider_data($date));
        $message = base64_encode($newsliders);
        $results = [
            'data' => $message,
        ];

        return $results;
    }
        
    public static function get_new_sliders_returns() {
        return 
        new external_single_structure(
            array(
                'data' => new external_value(PARAM_TEXT, 'All slider data as a compressed array'),
            )
        );
    }
}


