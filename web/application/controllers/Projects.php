<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller {

    private $data = array("docTitle"=>"",  "pages" => array(), "me" => array(), 'errors' => array());

    function __construct() {
        parent::__construct();
        $this->load->model('Projects_model', 'projects');
        $this->data['me'] = $this->thisvisitor->getVisitor();
        $this->setGlobals();
    }

    function _remap() {
        $this->data['qmenu'] = array(
            "" => array("role" => 0, 'icon'=>'' , "title" => $this->lang->en("Technologies")),
            "settings" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Settings")),

            "biz" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Product Deck")),
            "deck" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Product Deck")),

            "industries" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->en("Industries")),
            "technologies" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->en("Technologies")),
            "companies" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->en("Companies")),
            "years" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->en("Years")),

            "taylormade" => array("role" => 0, 'icon'=>'',  "title" => "TaylorMade"),
            "taylormade/development" => array("role" => 0, 'icon'=>'',  "title" => "TaylorMade " . $this->lang->en("Development")),
            "eli" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Eli")),
            "saman" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Saman")),

            "projects" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Projects")),

            "team" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Team")),
            "roles" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Roles")),

            "devices" => array("role" => 0, 'icon'=>'',  "title" => "Test Devices"),
        );

        $path = uri_string();
        if (empty($path)) return $this->animatedIntro();

        if (isset($this->data['qmenu'][$path]) && $this->data['qmenu'][$path]['role'] > 0 &&  !$this->thisvisitor->auth($this->data['qmenu'][$path]['role'])) {
            array_push($this->data['errors'], $this->lang->en("unauthorized"));
            $this->data['docTitle'] = $this->lang->en("Login");
            return $this->sendOut('loginForm');
        }
        $routing = $this->uri->rsegment_array();
        $method = (count($routing) > 1) ? $routing["2"] : 'industries';
        if (!method_exists($this, $method)) $method = 'industries';
        if (isset($this->data['qmenu'][$path])) $this->data['docTitle'] = $this->data['qmenu'][$path]['title'];
        if (!empty($this->data['qtfilter'])) $this->data['docTitle'] .= ' :: ' . $this->data['qtfilter'];
        call_user_func_array(array($this, $method), array());
    }

    private function setGlobals() {
        $this->data['qtags'] = $this->input->get_post('qtags');
        if (empty($this->data['qtags'])) $this->data['qtags'] = $this->uri->segment(1);
        if (empty($this->data['qtags'])) $this->data['qtags'] = 'industries';
        $this->data['qtfilter'] = $this->input->get_post('qtfilter');
        if (empty($this->data['qtfilter'])) $this->data['qtfilter'] = $this->uri->segment(2);

        $this->data['qgroup'] = $this->input->get_post('qgroup');
        if (empty($this->data['qgroup'])) $this->data['qgroup'] = $this->uri->segment(3);

        $this->data['qhaving'] =(int) $this->input->get_post('qhaving');
        if (empty($this->data['qhaving'])) $this->data['qhaving'] = (int)$this->uri->segment(4);


    }

    private function sendOut($page, $shell="shell") {
        if ($page == $shell) {
          // do nothing
        } elseif (is_string($page)) {
            $this->data['pages'][$page] = $this->load->view($page, $this->data, TRUE);
        } else {
            array_push($this->data['pages'], $page);
        }

        if (isset($this->data['uProfile']) && isset($this->data['uProfile']['user_email']) && $this->data['uProfile']['user_email'] == 'eli@taylormadetraffic.com') {
            if (isset($_GET['education'])) {
                array_push($this->data['pages'], $this->load->view('user_education', $this->data, TRUE));
            }

            if (isset($_GET['summary'])) {
                array_push($this->data['pages'], '<p style="margin-top: 30px; font-size: 11px; color:#757575; font-style: italic">This resume is a print-friendly version of <u>TaylorMadeTraffic.com/eli</u>?'.$_SERVER['QUERY_STRING'].'</p>');
            }
        }


        if ($this->input->is_ajax_request()) {
            return $this->output->set_output($this->load->view($page, $this->data, TRUE));
        }



        if (isset($_GET['cv'])) $shell = "cv_format";
        $this->load->view($shell, $this->data);
    }

    function error404() {
        $this->data['docTitle'] = $this->lang->en("Page Not Found");
        $this->industries();
    }

    private function animatedIntro(){
        if ($this->input->is_ajax_request()) {
            return $this->industries();
        }
        $this->getTableForTags();
        $this->sendOut('tags_table');
    }

    // tag list views
    public function technologies() {
        $this->data['qtags'] = 'technologies';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table');
        } else {
            $this->getTableForProjects();
            $this->sendOut('projects_table');
        }
    }
    public function years() {
        $this->data['qtags'] = 'years';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table');
        } else{
            $this->getTableForProjects();
            $this->sendOut('projects_table');
        }
    }
    public function industries() {
        $this->data['qtags'] = 'industries';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table');
        } else{
            $this->getTableForProjects();
            $this->sendOut('projects_table');
        }
    }

    public function companies() {
        $this->data['qtags'] = 'companies';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table');
        } else {
            $this->data['cProfile'] = $this->users->getCompanyByName($this->data['qtfilter']);
            if (empty($this->data['cProfile'])) unset($this->data['cProfile']);
            $this->getTableForProjects();
            $this->sendOut('projects_table');
        }
    }

    public function team() {
        if (empty($this->data['qtfilter'])) {
            $this->data['headers'] = array(
            'count'=>$this->lang->en("Total"),
            'tag_key'=>$this->data['docTitle'],
            'tag_date'=>$this->lang->en("Last Connect")
            );
            if ($this->data['qtags'] == "roles") $this->data['tableRows'] = $this->projects->getTagsTeamRoles();
            else $this->data['tableRows'] = $this->projects->getTagsTeamMembers();
            $this->sendOut('tags_table');
        } else {
            if (empty($this->data['qgroup'])) $this->data['qgroup'] = 'project_client';

        	$this->data['headers'] = array('image_src'=>$this->lang->en("Pics"));
            if ($this->data['me']['con']['swidth'] > 600) $this->data['headers']['project_title'] = $this->lang->en("Info");
            if ($this->data['me']['con']['swidth'] > 980) $this->data['headers']['project_startdate'] = $this->lang->en("Tags");

            if ($this->data['qtags'] == "roles") $this->data['qtagOptions'] = $this->projects->getTagsTeamRoles();
            else $this->data['qtagOptions'] = $this->projects->getTagsTeamMembers();
            if ($this->data['qtags'] == "roles") {
                $this->data['tableRows'] = $this->projects->getTagsTeamRoles($this->data['qtfilter']);
            } else {
                $this->data['tableRows'] = $this->projects->getProjectsByTag($this->data['qtags'], $this->data['qtfilter'], $this->data['qhaving'], $this->data['qgroup']);
            }

            $this->regroupProjects();

            $this->load->model('Users_model', 'user');
            $this->data['uProfile'] = $this->users->getUserByName($this->data['qtfilter']);
            $this->sendOut('projects_table');
        }
    }

    private function regroupProjects(){
    	if (empty($this->data['qgroup'])) {
    		$this->data['qgroup'] = 'project_client';
    	}
    	$groups = array();
    	foreach($this->data['tableRows'] as $index=>&$row) {
    		$row->images = $this->projects->getProjectImages($row->project_id);
    		$row->totalImages = count($row->images);
    		if (!empty($row->images)) {
                $row = (object) array_merge((array) $row, (array)$row->images[0]); // since queries suck
            }

            if (empty($row->project_startdate)) $row->project_startdate = date('Y-m-d');
            if (empty($row->project_launchdate)) $row->project_launchdate = $row->project_startdate;

            $minYear = $this->input->get_post('year_min');
            if ($minYear && intval($minYear)) {
                if (intval($minYear) > intval($row->project_launchyear)) {
                    continue;
                }
            }

            if (!isset($row->{$this->data['qgroup']})) {
  				$this->data['qgroup'] = 'project_client'; // should never happen
  			}
            $company = $row->{$this->data['qgroup']};
            if (!isset($groups[$company])) {
                $groups[$company] = $this->users->getCompanyByName($company);
                if (!$groups[$company]) {
                    $groups[$company] = array('company_tagname'=>$company, 'company_screenname'=>$company, 'company_status'=>1);
                    if (empty( $groups[$company]['company_startdate'] ))
                        $groups[$company]['company_startdate'] = $row->project_startdate;
                    if (empty( $groups[$company]['company_enddate'] ))
                        $groups[$company]['company_enddate'] = $row->project_launchdate;
                    $groups[$company]['company_id'] = $this->users->insertCompany($groups[$company]);
                }
                $groups[$company] = $this->users->getCompanyByName($company);
                $groups[$company]['startDate'] =  (!empty( $groups[$company]['company_startdate'] )) ?
                    strtotime($groups[$company]['company_startdate']) :
                    strtotime($row->project_startdate);
                $groups[$company]['endDate'] =  (!empty( $groups[$company]['company_enddate'] )) ?
                    strtotime($groups[$company]['company_enddate']) :
                    strtotime($row->project_launchdate);
                $groups[$company]['projects'] = array();
            }
            $groups[$company]['startDate'] = min($groups[$company]['startDate'], strtotime($row->project_startdate));
            array_push($groups[$company]['projects'], $row);
    	}

    	if (count($groups) > 0) {
     		usort($groups, function($a, $b) {
          return $a['endDate'] - $a['startDate'] < $b['endDate'] - $b['startDate'] ? 1 : -1;
     		});
            if ($groups[0]['company_tagname'] === 'Cypher LLC') {
                $groups[0]['endDate'] = 'Present';
            }
    	}

        if ($this->data['qtfilter'] == 'E.A.Taylor') {
            $this->data['showGroup'] = true;
        }
    	$this->data['groups'] = $groups;
    }

    public function certbot() {
        die('AokEJYwWYMEzWsLb_V8FTOMJ2H-CbJRjxqflxt_m-L4.5HgURcqD_GgzIOxgwT0BxhvPd3KERWoPqZUqCU0CKMk');
    }

    // just URL predefines qtags
    public function taylormade(){
        $this->data['qtfilter'] = 'TaylorMadeTraffic';
        $this->data['qtags'] = 'companies';
        $this->data['qgroup'] = 'project_copyright';

        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags'], $this->data['qtfilter'], $this->data['qhaving']);
        $this->data['tableRows'] = $this->projects->getProjectsByTag($this->data['qtags'], $this->data['qtfilter'], $this->data['qhaving']);
        $this->data['cProfile'] = $this->users->getCompanyByName($this->data['qtfilter']);

        $this->getTableForProjects();
        $this->regroupProjects();

        $this->sendOut('projects_table');
    }


    public function pitch() {
        $this->data['qtags'] = 'companies';
        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags']);
        $this->data['qtfilter'] = 'TaylorMadeTraffic';
        $this->data['cProfile'] = $this->users->getCompanyByName("TaylorMadeManagement");

        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags']);
        $this->data['headers'] = array('image_src'=>$this->lang->en("Pics"));
        if ($this->data['me']['con']['swidth'] > 600) $this->data['headers']['project_title'] = $this->lang->en("Info");

        $this->data['tableRows'] = $this->projects->getProjectsByType('development', $this->data['qtfilter']);
        foreach($this->data['tableRows'] as $index=>$row){
            $row->images = $this->projects->getProjectImages($row->project_id);
            $row->totalImages = count($row->images);
        }
        $this->sendOut('biz_projects');
    }

    public function eli(){
        $this->data['qtags'] = 'team';
        $this->data['qtfilter'] = 'E.A.Taylor';
        $this->data['qgroup'] = 'project_client';
        //$this->data['qhaving'] = 2
        $this->team();
    }

    public function saman(){
        $this->data['qtags'] = 'team';
        $this->data['qtfilter'] = 'Samanta Amna Khalil';
        $this->data['qgroup'] = 'project_client';
        //$this->data['qhaving'] = 2
        $this->team();
    }

    public function projects(){
        $pid = $this->input->get_post('pid');
        if (empty($this->data['qtfilter']) && empty($pid)) {
            $this->getTableForProjects();
            $this->sendOut('projects_table');
        } else {
            $this->data['docTitle'] = $this->data['qtfilter'];
            $val = (empty($this->data['qtfilter'])) ? $pid : $this->data['qtfilter'];
            if (is_numeric($val)) {
              $this->data['project'] = $this->projects->getProject($val);
              if (empty($this->data['project'])) die('invalid project id');
              $this->data['project']->images = $this->projects->getProjectImages($this->data['project']->project_id);
              $this->sendOut('project_profile');
            } else {
              $this->getTableForProjects();
              $this->sendOut('projects_table');
            }
        }
    }

    private function images() {
        $this->data['headers'] = array();
        $this->data['tableRows'] = $this->projects->getImages();
        $head = $this->projects->getTableHeaders('images');
        array_unshift($head, 'project_id');
        array_unshift($head, 'project_title');
        foreach($head as $h) {
            $this->data['headers'][$h] = (strpos($h,'image_') === 0) ? substr($h, strlen('image_')) : $h;
        }
        $this->sendOut('cms_table');
    }

    private function getTableForTags() {
        $this->data['headers'] = array(
            'count'=>$this->lang->en("Total"),
            'tag_key'=>$this->data['docTitle']
        );

        $this->data['headers']['tag_date'] = '-'; // years
        if ($this->data['qtags'] === 'technologies') {
          $this->data['headers']['tag_date'] = $this->lang->en("Last Tagged");
        } else if ($this->data['qtags'] === 'companies' || $this->data['qtags'] === 'industries') {
          $this->data['headers']['tag_date'] = $this->lang->en("Last Project");
        }

        $this->data['tableRows'] = $this->projects->getTags($this->data['qtags'], $this->data['qtfilter'], $this->data['qhaving']);
    }

    private function getTableForProjects() {
        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags'], false, $this->data['qhaving']);
        $this->data['headers'] = array('image_src'=>$this->lang->en("Pics"));
        if ($this->data['me']['con']['swidth'] > 600) $this->data['headers']['project_title'] = $this->lang->en("Info");
        if ($this->data['me']['con']['swidth'] > 980) $this->data['headers']['project_startdate'] = $this->lang->en("Tags");

        $seg = $this->uri->segment(2);
        if ($seg  == 'development' || $seg  == 'design') $rows = $this->projects->getProjectsByType($seg);
        else $rows = $this->projects->getProjectsByTag($this->data['qtags'], $this->data['qtfilter'], $this->data['qhaving']);

        /*
        if (count($rows) === 1 && $this->input->is_ajax_request() == false) { // not ajax
            $this->load->helper('url');
            redirect(TMT_HTTP. 'projects?pid='.$rows[0]->project_id, 'location', '302');
        }
        */

        $groups = array();
        foreach($rows as $index=>&$row){
        	if (!isset($row->{$this->data['qgroup']})) {
        		$this->data['qgroup'] = 'project_client';
        	}
        	$company = $row->{$this->data['qgroup']};
        	if (!isset($groups[$company])) {
        		$groups[$company] = $this->users->getCompanyByName($company);
        		$groups[$company]['projects'] = array();
        	}
            $images = $this->projects->getProjectImages($row->project_id);
            $row =  (object) array_merge((array)$row, (array) $images[0]);
            $row->images = $images;
            $row->totalImages = count($row->images);
            array_push($groups[$company]['projects'], $row);
        }
        $this->data['groups'] = $groups;
    }

    private function viewSettings(){
        $con = $this->data['me']['con'];
        if ($this->input->get("swidth")) $con['swidth'] = intval ($this->input->get("swidth"));
        if ($this->input->get("sheight")) $con['sheight'] = intval($this->input->get("sheight"));
        if ($this->input->get_post('debug')) $con['debugMode'] = (boolean) $this->input->get_post('debug');
        $this->thisvisitor->upConstants($con);
        $this->thisvisitor->saveSession();
        return false;
    }

    private function devices() {
        $this->sendOut('stylesheet', 'cms_shell');
    }


    private function rewriteTeam(){

    }

    public function proservice_annotation() {
        $this->sendOut('proservice_annotation');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
