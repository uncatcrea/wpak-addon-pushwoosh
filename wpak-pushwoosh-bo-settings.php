<?php

if ( !class_exists( 'WpakPushwooshAdmin' ) ) {
    /**
     * Pushwoosh backoffice forms manager class.
     */
    class WpakPushwooshAdmin {
        /**
         * Main entry point.
         *
         * Adds needed callbacks to some hooks.
         */
        public static function hooks() {
            if( is_admin() ) {
                add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
                add_filter( 'wpak_default_options', array( __CLASS__, 'wpak_default_options' ) );
            }
        }

        /**
         * Attached to 'add_meta_boxes' hook.
         *
         * Register Pushwoosh configuration meta box for WP-AppKit applications forms.
         */
        public static function add_meta_boxes() {
            add_meta_box(
                'wpak_pushwoosh_config',
                __( 'Pushwoosh Configuration', WpAppKitPushwoosh::i18n_domain ),
                array( __CLASS__, 'inner_config_box' ),
                'wpak_apps',
                'normal',
                'default'
            );
        }

        /**
         * Displays Pushwoosh configuration meta box on backoffice form.
         *
         * @param WP_Post               $post           The app object.
         * @param array                 $current_box    The box settings.
         */
        public static function inner_config_box( $post, $current_box ) {
            $options = WpakOptions::get_app_options( $post->ID );
            ?>
            <a href="#" class="hide-if-no-js wpak_help"><?php _e( 'Help me', WpAppKitPushwoosh::i18n_domain ); ?></a>
            <div class="wpak_settings field-group">
                <div class="field-group">
                    <label for="wpak_pushwoosh_pwid"><?php _e( 'Pushwoosh Application code', WpAppKitPushwoosh::i18n_domain ) ?></label>
                    <input id="wpak_pushwoosh_pwid" type="text" name="wpak_app_options[pushwoosh][pwid]" value="<?php echo $options['pushwoosh']['pwid'] ?>" />
                    <span class="description"><?php _e( 'Provided in the Pushwoosh interface: open your app and it is right under the app\'s name', WpAppKitPushwoosh::i18n_domain ) ?></span>
                </div>
                <div class="field-group platform-specific android">
                    <label for="wpak_pushwoosh_googleid"><?php _e( 'Sender ID', WpAppKitPushwoosh::i18n_domain ) ?></label>
                    <input id="wpak_pushwoosh_googleid" type="text" name="wpak_app_options[pushwoosh][googleid]" value="<?php echo $options['pushwoosh']['googleid'] ?>" />
                    <span class="description"><?php _e( 'Provided in the Firebase console: open your project, click the gear icon in the left menu to access parameters and open the Cloud Messaging tab to find your Sender ID', WpAppKitPushwoosh::i18n_domain ) ?></span>
                </div>
            </div>
            <?php
        }

        /**
         * Attached to 'wpak_default_options' hook.
         *
         * Filter default options available for an app in WP-AppKit.
         *
         * @param array             $default            The default options.
         *
         * @return array            $default            Options with Pushwoosh keys.
         */
        public static function wpak_default_options( $default ) {
            $default['pushwoosh'] = array(
                'pwid' => '',
                'googleid' => '',
            );

            return $default;
        }

    }

    WpakPushwooshAdmin::hooks();
}
