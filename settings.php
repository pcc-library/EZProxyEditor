<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-17
 * Time: 21:45
 */

define( 'EZPEPATH', __DIR__.'/' );
define( 'EZPEWRITEABLE', $_SERVER['DOCUMENT_ROOT'].'/library/wp-content/uploads/ezpe/');

define( 'BASEURL','/library/ezproxyeditor');

// Full Hostname of your CAS Server
define('CAS_HOST','login.pcc.edu');
// Context of the CAS Server
define('CAS_CONTEXT','cas');
// Port of your CAS server. Normally for a https server it's 443
define('CAS_PORT', 443);
// Path to the ca chain that issued the cas server certificate