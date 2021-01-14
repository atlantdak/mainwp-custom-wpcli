<?php

class TTMainWPExtendedWPCLIFunctions extends WP_CLI_Command {

    /**
     * List information about plugin updates
     *
     * ## OPTIONS
     *
     *
     * --domain=<domain>
     * : Domain which need to add to MainWP
     *
     * --user_login=<user_login>
     * : Login of administrator for relate adding domain
     *
     * ## EXAMPLES
     *
     *     wp mainwp add_site --domain="domain.com" --user_login="admin"
     *     wp mainwp add_site --domain=yourdomain.com --user_login=admin
     *
     * ## Synopsis --domain --user_login
     *
     * @param mixed $args
     * @param mixed $assoc_args
     */
    public function add_site($args, $assoc_args) {
        WP_CLI::line($assoc_args['domain']);
        WP_CLI::line($assoc_args['user_login']);
        if($assoc_args['domain']==''){
            WP_CLI::error('The "domain" field should not be empty.');
        }
        if($assoc_args['user_login']==''){
            WP_CLI::error('The "user_login" field should not be empty.');
        }
        //all fields: url, name, wpadmin, unique_id, groupids, ssl_verify, ssl_version, http_user, http_pass
        $params = array(
            'url' => $assoc_args['domain'],
            'name' => $assoc_args['domain'],
            'wpadmin' => $assoc_args['user_login'],
            'unique_id' => false,
            'groupids' => false,
            'ssl_verify' => false,
            'ssl_version' => false,
            http_user => false,
            http_pass => false
        );
        $result = apply_filters('mainwp_addsite', $params);
        
        var_dump($result);
        
        WP_CLI::line($result);
    }

}
