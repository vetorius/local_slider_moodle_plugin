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
 * Library of slider local module
 *
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Add link into navigation drawer if user has manageslider capability
 *      
 * @param global_navigation $root Node representing the global navigation tree.
 */
function local_slider_extend_navigation(global_navigation $root) {

    if (!has_capability('local/slider:managesliders', \context_system::instance())) {
        return;
    }
    $node = navigation_node::create(
        get_string('menutext', 'local_slider'),
        new moodle_url('/local/slider/index.php'),
        navigation_node::TYPE_CUSTOM,
        null,
        null,
        new pix_icon('e/split_cells', '')
    );
    $node->showinflatnavigation = true;

    $root->add_node($node);
}

