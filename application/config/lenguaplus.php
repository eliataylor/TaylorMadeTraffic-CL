<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'languages'=>array('es'=>'English','en'=>'Espanol'),
    'use_ugc_database'=>FALSE,
    'use_msg_database'=>FALSE,
    'track_ugc_production'=>FALSE,
    'track_msg_production'=>FALSE,
    'oauthor'=>NULL, // original authors
    'eauthor'=>NULL, // editors
    'lang_status'=>'edited', // enum('debug','edited','live','deleted','propername')
    'environment'=>ENVIRONMENT, // 'production', 'development', 'testing' (constant is defined in constants.php
);
    
    
?>