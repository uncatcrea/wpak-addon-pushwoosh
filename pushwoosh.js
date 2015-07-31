define( function( require ) {
    "use strict";

    var Phonegap = require( 'core/phonegap/utils' );

    var pushwoosh = {};

    pushwoosh.init = function() {
        if( !Phonegap.isLoaded() ) {
            return;
        }

        var pushNotification = cordova.require( 'com.pushwoosh.plugins.pushwoosh.PushNotification' );

        //set push notifications handler
        document.addEventListener( 'push-notification', pushwoosh.handleNotif );

        //initialize Pushwoosh with projectid: "GOOGLE_PROJECT_ID", pw_appid : "PUSHWOOSH_APP_ID". This will trigger all pending push notifications on start.
        pushNotification.onDeviceReady( { projectid: "931420113985", pw_appid : "9CD6D-E5A2B" } );

        //register for pushes
        pushNotification.registerDevice(
            function( status ) {
                var pushToken = status;
                console.warn( 'push token: ' + pushToken );
            },
            function( status ) {
                console.warn( JSON.stringify( ['failed to register ', status] ) );
            }
        );
    };

    pushwoosh.handleNotif = function( event ) {
        var title = event.notification.title;
        var userData = event.notification.userdata;

        if( "undefined" !== typeof userData ) {
            if( "undefined" !== typeof userData.route ) {
                // Don't need the protocol, userData.route contains something like "single/posts/1"
                wpak_open_url = userData.route;
            }
        }

        alert( title );
    };

    return pushwoosh;
});