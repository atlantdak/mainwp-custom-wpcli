<?php
/*
Plugin Name: MainWP extended WP-CLI
Description: Add website to MainWP via wp-cli. Using: wp mainwp addsite --domain=yourdomain.com --login=admin
Author: Kishkin Dmitriy
Version:  1.0.0
License: GPL2
*/

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if (!is_plugin_active('mainwp/mainwp.php')) {
    add_action('init', array('MainWPExtendedWPCLI', 'deactivate_plugin'));
    add_action('admin_notices', array('MainWPExtendedWPCLI', 'deactivate_plugin_message'));
}

class MainWPExtendedWPCLI {

    private $plugin_path;
    private $plugin_url;
    public static $plugin_name = 'TT MainWP extended WP-CLI';

    function __construct() {
        // Set up default vars
        $this->plugin_path = plugin_dir_path( __FILE__ );
        $this->plugin_url = plugin_dir_url( __FILE__ );
        // Set up activation hooks
        
        // Set up l10n
        load_plugin_textdomain( 'tt-mainwp-extended-wpcli', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
        
        $this->init();
    }
    
    private function init() {
        if ( defined('WP_CLI') && WP_CLI ) {
            require_once( $this->plugin_path . 'inc/MainWPExtendedWPCLIFunctions.php' );
            WP_CLI::add_command( 'mainwp', 'MainWPExtendedWPCLIFunctions' );
        }        
    }
    /**
     * Если плагин активировали из WP-CLI выводим сообщение об ошибке, 
     * Деактивируем плагин.
     */
    public static function deactivate_plugin() {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        if ( defined('WP_CLI') && WP_CLI ) {
            WP_CLI::warning( 
                __( 'Плагин', 'tt-mainwp-extended-wpcli' ) . ' ' . self::$plugin_name . ' ' .
                __( 'был отключен, так как для его работы должен быть включен плагин', 'tt-mainwp-extended-wpcli' ) . ' MainWP');
        }
    }
    /**
     * Выводим уведомление о том что плагин был отключён в панель администратора.
     */
    public static function deactivate_plugin_message() {
        
        $message = '<div class="error"><p>';
        $message .= __( 'Плагин', 'tt-mainwp-extended-wpcli' );
        $message .= ' <strong>' . self::$plugin_name . '</strong>';
        $message .= __( ' был отключен, так как для его работы должен быть включен плагин', 'tt-mainwp-extended-wpcli' );
        $message .= ' <strong>MainWP</strong></p></div>';
        
        echo $message;
        // также сносим параметр из URL, чтобы не выполнилось ничего лишнего
        if ( isset( $_GET['activate'] ) )
            unset( $_GET['activate'] );
         
    }
}
new MainWPExtendedWPCLI();

?>
