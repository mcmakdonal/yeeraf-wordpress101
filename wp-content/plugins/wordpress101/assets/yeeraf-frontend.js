console.log("Hi Frontend", frontend_ajax_object);



jQuery.get(
    frontend_ajax_object.ajaxurl,
    {
        'action': 'hello_yeeraf'
    },
    function (response) {
        console.log('The server responded: ', response);
    }
);