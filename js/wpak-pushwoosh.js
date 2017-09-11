define( function( require ) {
    "use strict";

    var Phonegap    = require( 'core/phonegap/utils' );
    var Config      = require( 'root/config' );
    var Hooks       = require( 'core/lib/hooks' );

    var pushwoosh = {};
    var pushNotification = null;

    pushwoosh.init = function() {
        if( !Phonegap.isLoaded() || "undefined" == typeof Config.options.pushwoosh ) {
            return;
        }

        pushNotification = cordova.require( 'pushwoosh-cordova-plugin.PushNotification' );

        //set push notifications handler
        document.addEventListener( 'push-notification', pushwoosh.handleNotif );

        //initialize Pushwoosh with projectid: "GOOGLE_PROJECT_ID", pw_appid : "PUSHWOOSH_APP_ID". This will trigger all pending push notifications on start.
        pushNotification.onDeviceReady( { projectid: Config.options.pushwoosh.googleid, pw_appid : Config.options.pushwoosh.pwid } );

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
                window.wpak_open_url = userData.route;
            }
        }

        /**
         * "wpak-pushwoosh-notification" filter: use this filter to display a push notification content as soon as the user clicked on it to open the app.
         *
         * @param {string} title: The content of the notification
         * @param {JSON Object} userData: A JSON object (can be empty) containing custom additional data provided from Pushwoosh interface
         * @param {Object} notification: Original notification event object
         */
        Hooks.applyFilters( 'wpak-pushwoosh-notification', title, [userData, notification] );
    };

    var resetBadges = function() {
        if( null === pushNotification || "undefined" === typeof pushNotification.setApplicationIconBadgeNumber ) {
            return;
        }

        pushNotification.setApplicationIconBadgeNumber(0);
    };

    return pushwoosh;
});