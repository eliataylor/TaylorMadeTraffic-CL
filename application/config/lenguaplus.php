<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'languages'=>array('en'=>'English','es'=>'Espanol'),
    'lang_2_track'=>'en',
    'use_ugc_static'=>TRUE,
    'track_ugc_static'=>TRUE,
    'use_ugc_database'=>FALSE,
    'use_msg_database'=>FALSE,
    'track_ugc_production'=>TRUE,
    'track_msg_production'=>FALSE,
    'status_2_watch'=>'live', // enum('debug','edited','live','deleted','propername')
    'environment'=>ENVIRONMENT, // 'production', 'development', 'testing' (constant is defined in constants.php
);
    
    
?>