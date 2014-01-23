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
            
            "technologies" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->en("Technologies")),
            "years" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->en("Years")),
            "companies" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->en("Companies")),
            "industries" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->en("Industries")),
            
            "taylormade" => array("role" => 0, 'icon'=>'',  "title" => "TaylorMade"),
            "taylormade/development" => array("role" => 0, 'icon'=>'',  "title" => "TaylorMade " . $this->lang->en("Development")),
            "eli" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Eli")),

            "projects" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Projects")),
            
            "team" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Team")),
            "roles" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->en("Roles")),
            
            "devices" => array("role" => 0, 'icon'=>'',  "title" => "Test Devices"),
        );

        $path = uri_string();        
        if (isset($this->data['qmenu'][$path]) && $this->data['qmenu'][$path]['role'] > 0 &&  !$this->thisvisitor->auth($this->data['qmenu'][$path]['role'])) {
            array_push($this->data['errors'], $this->lang->en("unauthorized")); 
            $this->data['docTitle'] = $this->lang->en("Login");
            return $this->sendOut('loginForm');
        }
        $routing = $this->uri->rsegment_array();
        $method = (count($routing) > 1) ? $routing["2"] : 'technologies';
        if (!method_exists($this, $method)) $method = 'technologies';
        if (isset($this->data['qmenu'][$path])) $this->data['docTitle'] = $this->data['qmenu'][$path]['title'];
        if (!empty($this->data['qtfilter'])) $this->data['docTitle'] .= ' :: ' . $this->data['qtfilter'];
        call_user_func_array(array($this, $method), array());
    }

    private function setGlobals() {
        $this->data['qtags'] = $this->input->get_post('qtags');
        if (empty($this->data['qtags'])) $this->data['qtags'] = $this->uri->segment(1);
        $this->data['qtfilter'] = $this->input->get_post('qtfilter');
        if (empty($this->data['qtfilter'])) $this->data['qtfilter'] = $this->uri->segment(2);
    }

    private function sendOut($page, $shell="shell") {
        if ($page == $shell) {
          // do nothing  
        } elseif (is_string($page)) {
            $this->data['pages'][$page] = $this->load->view($page, $this->data, TRUE);
        } else {
            array_push($this->data['pages'], $page);
        }
        if ($this->input->is_ajax_request()) {
            return $this->output->set_output($this->load->view($page, $this->data, TRUE));
        }
        $cv = $this->input->get_post('cv-format');
        if ($cv) $shell = "cv_format";        
        $this->load->view($shell, $this->data);        
    }

    function error404() {
        $this->data['docTitle'] = $this->lang->en("Page Not Found");
        $this->technologies();
    }
    
    function animatedIntro(){
        if ($this->input->is_ajax_request()) {
            return false;
        }        
        $this->load->view('shell', $this->data);
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
        } else{
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
            'tag_date'=>$this->lang->en("Last Used")
                );            
            if ($this->data['qtags'] == "roles") $this->data['tableRows'] = $this->projects->getTagsTeamRoles();
            else $this->data['tableRows'] = $this->projects->getTagsTeamMembers();
            $this->sendOut('tags_table');
        } else{
            $this->data['headers'] = array('image_src'=>$this->lang->en("Pics"));
            if ($this->data['me']['con']['swidth'] > 600) $this->data['headers']['project_title'] = $this->lang->en("Info");
            if ($this->data['me']['con']['swidth'] > 980) $this->data['headers']['project_startdate'] = $this->lang->en("Tags");
            
            if ($this->data['qtags'] == "roles") $this->data['qtagOptions'] = $this->projects->getTagsTeamRoles();
            else $this->data['qtagOptions'] = $this->projects->getTagsTeamMembers();
            if ($this->data['qtags'] == "roles") {
                $this->data['tableRows'] = $this->projects->getTagsTeamRoles($this->data['qtfilter']);
            } else {
                $this->data['tableRows'] = $this->projects->getProjectsByTag(null, $this->data['qtfilter']); 
            }
            foreach($this->data['tableRows'] as $index=>$row){
                $row->images = $this->projects->getProjectImages($row->project_id);
                $row->totalImages = count($row->images);
            }                
            $this->load->model('Users_model', 'user');
            $this->data['uProfile'] = $this->users->getUserByName($this->data['qtfilter']);
            if (uri_string() == 'cv-format') {
                $this->sendOut('cv_projects', 'cv_shell');
            } else {
                $this->sendOut('projects_table');
            }
        }
    }     
    
    // just URL predefines qtags
    function taylormade(){
        $this->data['qtags'] = 'companies';
        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags']); 
        $this->data['qtfilter'] = 'TaylorMadeTraffic';
        $this->data['cProfile'] = $this->users->getCompanyByName("TaylorMadeTraffic");
        
        // These 5 products were some of my strongest reasons for moving abroad. They have been dreams for 
        
        $this->getTableForProjects();
        
        $seg = $this->uri->segment(2);
        if (!empty($seg)) {
            foreach($this->data['tableRows'] as $index=>$row){
                if ($row->project_type != $seg) {
                    unset($this->data['tableRows'][$index]);
                }
            }
        }
        $this->sendOut('projects_table');
    }
    
    
    function pitch() {
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
    
    function eli(){
        $this->data['qtags'] = 'team';
        $this->data['qtfilter'] = 'E.A.Taylor';        
        $this->team();
    }    
    
    function projects(){
        $pid = $this->input->get_post('pid');
        if (empty($this->data['qtfilter']) && empty($pid)) {
            $this->getTableForProjects();
            $this->sendOut('projects_table');
        } else{
            $this->data['docTitle'] = $this->data['qtfilter'];            
            $val = (empty($this->data['qtfilter'])) ? $pid : $this->data['qtfilter'];
            $this->data['project'] = $this->projects->getProject($val);
            $this->data['project']->images = $this->projects->getProjectImages($this->data['project']->project_id);
            $this->sendOut('project_profile');
        }        
    }    
    
    function images() {      
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

    function getTableForTags() {
        $this->data['headers'] = array(
            'count'=>$this->lang->en("Total"),
            'tag_key'=>$this->data['docTitle'],
            'tag_date'=>$this->lang->en("Last Used")
                );
        $this->data['tableRows'] = $this->projects->getTags($this->data['qtags']); 
    }

    function getTableForProjects() {        
        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags']); 
        $this->data['headers'] = array('image_src'=>$this->lang->en("Pics"));
        if ($this->data['me']['con']['swidth'] > 600) $this->data['headers']['project_title'] = $this->lang->en("Info");
        if ($this->data['me']['con']['swidth'] > 980) $this->data['headers']['project_startdate'] = $this->lang->en("Tags");
        
        $seg = $this->uri->segment(2);
        if ($seg  == 'development' || $seg  == 'design') $this->data['tableRows'] = $this->projects->getProjectsByType($seg, $this->data['qtfilter']); 
        else $this->data['tableRows'] = $this->projects->getProjectsByTag($this->data['qtags'], $this->data['qtfilter']); 
        foreach($this->data['tableRows'] as $index=>$row){
            $row->images = $this->projects->getProjectImages($row->project_id);
            $row->totalImages = count($row->images);
        }         
    }
    
    function viewSettings(){
        $con = $this->data['me']['con'];            
        if ($this->input->get("swidth")) $con['swidth'] = intval ($this->input->get("swidth"));
        if ($this->input->get("sheight")) $con['sheight'] = intval($this->input->get("sheight"));
        if ($this->input->get_post('debug')) $con['debugMode'] = (boolean) $this->input->get_post('debug');
        $this->thisvisitor->upConstants($con);
        $this->thisvisitor->saveSession();   
        return false;
    }
    
    function devices() {
        $this->sendOut('stylesheet', 'cms_shell');
    }
    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */