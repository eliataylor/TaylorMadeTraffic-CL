<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */


// local configuration when testing off apps.facebook.com/trackauthority with host file change and xampp's docuemnt root as /trackauthority
// local configuration when testing off apps.facebook.com/trackauthority with host file change and xampp's docuemnt root as /trackauthority
define('APP_HTTP','http://taylormadetraffic.com/');

if (php_sapi_name() == 'cli' || defined('STDIN') || defined('STDOUT') || isset($_SERVER['SHELL'])) {
    define('TMT_HTTP', "http://taylormadetraffic.com/");
    define('ROOT_CD', getcwd());
} else {
    $allowed = array('taylormadetraffic.com','cube.taylormadetraffic.com','www.taylormadetraffic.com','www.eliataylor.com','eliataylor.com');
    if (ENVIRONMENT != "production") {
        $allowed = array_merge($allowed, array('localhost.taylormadetraffic.com'));
    }
}

if (in_array(strtolower($_SERVER['SERVER_NAME']), $allowed)) {
    $servername = strtolower($_SERVER['SERVER_NAME']);
    if ($_SERVER['SERVER_PORT'] == 443 || isset($_SERVER['HTTPS']) || isset($_SERVER['https']) || strtolower($_SERVER['SERVER_PROTOCOL']) == "https") {
        define('TMT_HTTP', "https://" . $servername . "/"); // most links 
    } else {
        define('TMT_HTTP', "http://" . $servername . "/");
    }
    unset($servername);
} else {
    die("illegal server name!!");
}
unset($allowed);

if (isset($_POST['signed_request'])) define('BOTH_HTTP', APP_HTTP);
else define('BOTH_HTTP', TMT_HTTP);

define('ROOT_CD', (isset($_SERVER['DOCUMENT_ROOT'])) ? $_SERVER['DOCUMENT_ROOT'] : __DIR__);
define('STATIC_CD', ROOT_CD . '/wwwroot/');
