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
 * Synchronize sliders task for slider plugin
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_slider\task;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot. '/local/slider/locallib.php');

/**
 * An example of a scheduled task.
 */
class sync_sliders extends \core\task\scheduled_task {
 
    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string('syncsliders', 'local_slider');
    }
 
    /**
     * Execute the task.
     */
    public function execute() {
        if (get_config('local_slider', 'enableupdate')){
            $slidersnuevos = obtain_new_remote_sliders();
            synchonize_sliders($slidersnuevos);
        }
    }
}