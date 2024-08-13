<?php // Editor Settings

use PCC_EPE\Models\Config;

return [
    // Directory to write config files to
    'write_path' => '/library/wp-content/uploads/ezpe/',

    /**
     * Base URL of the application.
     *
     * This is dynamically set using the `getServerBaseUrl()` method from the Config class.
     */
    'baseurl' => Config::getServerBaseUrl() . '/library/ezproxyeditor',

    // cas settings
    'cas_host' => 'login.pcc.edu',
    'cas_context' => 'cas',
    'cas_port' => 443,

    // sftp settings
    'sftp_host' => 'vmlib3.pcc.edu',
    'sftp_user' => 'libsftptemp',
    'sftp_password' => 'DonnGust$7383',

    // ezproxy admin settings
    "ezproxy_admin_url" => "https://libproxy.pcc.edu",
    "user" => "pccit",
    "pass" => "2001sP0AA"

];
