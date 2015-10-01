define( function( require ) {
    "use strict";

    var Phonegap    = require( 'core/phonegap/utils' );
    var Config      = require( 'root/config' );

    var pushwoosh = {};
    var pushNotification = null;

    pushwoosh.init = function() {
        if( !Phonegap.isLoaded() || "undefined" == typeof Config.pushwoosh ) {
            return;
        }

        pushNotification = cordova.require( 'com.pushwoosh.plugins.pushwoosh.PushNotification' );

        //set push notifications handler
        document.addEventListener( 'push-notification', pushwoosh.handleNotif );

        //initialize Pushwoosh with projectid: "GOOGLE_PROJECT_ID", pw_appid : "PUSHWOOSH_APP_ID". This will trigger all pending push notifications on start.
        pushNotification.onDeviceReady( { projectid: Config.pushwoosh.googleid, pw_appid : Config.pushwoosh.pwid } );

        //register for pushes
        pushNotification.registerDevice();

        //reset badges on app start (iOS only)
        resetBadges();
    };

    pushwoosh.handleNotif = function( event ) {
        var notification = event.notification,
            title = notification.title || notification.aps.alert,
            userData = notification.userdata || notification.u;

        //clear the app badge (iOS only)
        resetBadges();

        if( "undefined" !== typeof userData ) {
            if( "undefined" !== typeof userData.route ) {
                // Don't need the protocol, userData.route should contain something like "single/posts/1"
                wpak_open_url = userData.route;
            }
        }

        alert( title );
    };

    var resetBadges = function() {
        if( null === pushNotification || "undefined" === typeof pushNotification.setApplicationIconBadgeNumber ) {
            return;
        }

        pushNotification.setApplicationIconBadgeNumber(0);
    };

    return pushwoosh;
});