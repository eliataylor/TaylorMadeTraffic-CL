<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['default_controller'] = "projects";

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

$route['services/annotation(|.+?)'] = "projects/proservice_annotation";

$route['biz'] = "projects/pitch";
$route['deck'] = "projects/pitch";

$route['lenguaplus(|.+?)'] = 'lenguapluscontroller';

$route['upwork/fetchAndNotify'] = 'UpworkJobReader/fetchAndNotify';
$route['upwork/showDifferences'] = 'UpworkJobReader/showDifferences';



$route['404_override'] = 'errors/error_404';
$route['translate_uri_dashes'] = FALSE;


/* End of file routes.php */
/* Location: ./application/config/routes.php */

