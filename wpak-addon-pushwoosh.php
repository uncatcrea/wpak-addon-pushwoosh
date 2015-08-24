<?php
/*
  Plugin Name: WP AppKit PushWhoosh Addon
  Description: Send push notifications to your WP-AppKit generated apps through PushWoosh service
  Version: 0.1
 */

if ( !class_exists( 'WpAppKitPushWhoosh' ) ) {

    class WpAppKitPushWhoosh {

        const slug = 'wpak-addon-pushwoosh';

        public static function hooks() {
            add_filter( 'wpak_addons', array( __CLASS__, 'wpak_addons' ) );
        }

        public static function wpak_addons( $addons ) {
            $addon = new WpakAddon( 'WP AppKit PushWhoosh', self::slug );

            $addon->set_location( __FILE__ );

            $addon->add_js( 'js/wpak-pushwoosh.js', 'module' );
            $addon->add_js( 'js/wpak-pushwoosh-app.js', 'init', 'before' );

            $addons[] = $addon;

            return $addons;
        }

    }

    WpAppKitPushWhoosh::hooks();
}