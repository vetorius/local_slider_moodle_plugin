/**
 * footable parameters for slidertable at index page
 * 
 * @package    local_slider
 * @author     Víctor M. Sanchez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *  
 */

$(function($){
    $('#slidertable').footable({
        "paging": {
			"enabled": true,
            "position": "center",
            "size": 10,
		},
        "filtering": {
			"enabled": true,
            "delay": 500,
            "focus": true,
            "min": 3,
		},
    });
});