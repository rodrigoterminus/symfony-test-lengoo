'use strict';

var application = (function() {
    var ip = '187.183.24.33';

    var init = function() {
        getLocation();
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