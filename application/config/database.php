<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$active_group = 'default';
$active_record = TRUE;

if (ENVIRONMENT == 'production') {
    $db['default']['hostname'] = 'db508038747.db.1and1.com';
    $db['default']['username'] = 'dbo508038747';
    $db['default']['password'] = 'pxYetMY6FEFVCTj5';
    $db['default']['database'] = 'db508038747';
} else {
    $db['default']['hostname'] = 'localhost';
    $db['default']['username'] = 'taylormade';
    $db['default']['password'] = 'pxYetMY6FEFVCTj5';
    $db['default']['database'] = 'tmm_porfolio';
}
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */