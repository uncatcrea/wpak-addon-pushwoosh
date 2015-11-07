<?php

if ( !class_exists( 'WpakPushWooshAdmin' ) ) {
    /**
     * PushWoosh backoffice forms manager class.
     */
    class WpakPushWooshAdmin {
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
         * Register PushWoosh configuration meta box for WP-AppKit applications forms.
         */
        public static function add_meta_boxes() {
            add_meta_box(
                'wpak_pushwoosh_config',
                __( 'PushWoosh Configuration', WpAppKitPushWhoosh::i18n_domain ),
                array( __CLASS__, 'inner_config_box' ),
                'wpak_apps',
                'normal',
                'default'
            );
        }

        /**
         * Displays PushWoosh configuration meta box on backoffice form.
         *
         * @param WP_Post               $post           The app object.
         * @param array                 $current_box    The box settings.
         */
        public static function inner_config_box( $post, $current_box ) {
            $options = WpakOptions::get_app_options( $post->ID );
            ?>
            <!-- <a href="#" class="hide-if-no-js wpak_help"><?php _e( 'Help me', WpAppKitPushWhoosh::i18n_domain ); ?></a> -->
            <div class="wpak_settings field-group">
                <div class="field-group">
                    <label for="wpak_pushwoosh_pwid"><?php _e( 'PushWoosh ID', WpAppKitPushWhoosh::i18n_domain ) ?></label>
                    <input id="wpak_pushwoosh_pwid" type="text" name="wpak_app_options[pushwoosh][pwid]" value="<?php echo $options['pushwoosh']['pwid'] ?>" />
                    <span class="description"><?php // TODO: add a description here? _e( '', WpAppKitPushWhoosh::i18n_domain ) ?></span>
                </div>
                <div class="field-group">
                    <label for="wpak_pushwoosh_googleid"><?php _e( 'Google Project ID', WpAppKitPushWhoosh::i18n_domain ) ?></label>
                    <input id="wpak_pushwoosh_googleid" type="text" name="wpak_app_options[pushwoosh][googleid]" value="<?php echo $options['pushwoosh']['googleid'] ?>" />
                    <span class="description"><?php // TODO: add a description here? _e( '', WpAppKitPushWhoosh::i18n_domain ) ?></span>
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
         * @return array            $default            Options with PushWoosh keys.
         */
        public static function wpak_default_options( $default ) {
            $default['pushwoosh'] = array(
                'pwid' => '',
                'googleid' => '',
            );

            return $default;
        }

    }

    WpakPushWooshAdmin::hooks();
}
