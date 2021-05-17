
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