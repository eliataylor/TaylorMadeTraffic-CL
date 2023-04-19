<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['404_override'] = 'projects/error404';

$route['default_controller'] = "projects/animatedIntro";

$route['.well-known/acme-challenge/AokEJYwWYMEzWsLb_V8FTOMJ2H-CbJRjxqflxt_m-L4'] = 'projects/certbot';

$route['years/design'] = "projects/years";
$route['years'] = "projects/years";
$route['technologies/development'] = "projects/technologies";
$route['technologies'] = "projects/technologies";

$route['companies'] = "projects/companies";
$route['industries'] = "projects/industries";

$route['settings'] = "projects/viewSettings";

$route['taylormade/development'] = "projects/taylormade";
$route['taylormade/design'] = "projects/taylormade";
$route['taylormade'] = "projects/taylormade";

$route['eli'] = "projects/eli";

$route['team'] = "projects/team";
$route['roles'] = "projects/team";

$route['projects(|.+?)'] = "projects/projects";
$route['devices(|.+?)'] = "projects/devices";

$route['biz'] = "projects/pitch";
$route['deck'] = "projects/pitch";

$route['lenguaplus(|.+?)'] = 'lenguapluscontroller';


/* End of file routes.php */
/* Location: ./application/config/routes.php */

