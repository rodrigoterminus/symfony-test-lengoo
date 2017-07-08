'use strict';

var application = (function() {
    var ip = '';

    var init = function() {
        getLocation();

        $('form').on('submit', function() {
            $('#appbundle_application_submit')
                .text('Applying...')
                .attr({
                    'disabled': 'disabled'
                });
        });
    };

    var getLocation = function () {
        $.get('http://ip-api.com/json/'+ ip)
            .done(function (response) {
                $('#appbundle_application_location').val(JSON.stringify(response));
            })
    };

    return {
        init: init
    };
})($);