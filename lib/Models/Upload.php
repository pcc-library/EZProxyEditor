<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-18
 * Time: 13:26
 */

namespace PCC_EPE\Models;

use PCC_EPE\Controllers\MessageController;

use phpseclib\Net\SFTP;
use \Exception;


class Upload
{
//    public static $sftp_host = 'vmlib3.pcc.edu';
//    public static $sftp_user = 'libsftptemp';
//    public static $sftp_password = 'DonnGust$7383';

    public static $sftp_host = 'vmwplibtestw01.pcc.edu';
    public static $sftp_user = 'gustavo.lanzas';
    public static $sftp_password = 'V-dM$-z9em';
    public static $server_path = "/var/www/html/library/wp-content/uploads/";


    public static function uploadFile($filename) {

        $messages = new MessageController();

        try {
            // connect to the sftp host
            $sftp = new SFTP(self::$sftp_host);

            if (!$sftp->login(self::$sftp_user, self::$sftp_password)) {

                $messages->addMessage(false, 'Login Failed');

                return false;

            } else {

                // copies filename.local to filename.remote on the SFTP server
                $sftp->put(self::$server_path.$filename, $filename, SFTP::SOURCE_LOCAL_FILE);

                $messages->addMessage(true, 'Login Success');

                return true;

            }

        } catch (Exception $e) {

            $messages->addMessage(false, $e->getMessage());

        }

    }

}