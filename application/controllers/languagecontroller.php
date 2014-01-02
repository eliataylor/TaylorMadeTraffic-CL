<?php

class LanguageController extends CI_Controller {    
    
    private $data = array("pages"=>array(), "me"=>array(), 'errors'=>array());
    
    function __construct() {
        parent::__construct();
        $this->load->model('Language_model', 'language');
        $this->data['me'] = $this->thisvisitor->getVisitor();     
        $this->setGlobals();
    }
    
    function _remap() {
        $security = array(
            "language"=>array("role"=>3,"title"=>$this->lang->line("Debug Language"),"method"=>"debug"),
            "language/debug"=>array("role"=>3,"title"=>$this->lang->line("Debug Language"),"method"=>"debug")
        );
        
        $path = uri_string();
        if (!isset($security[$path])) 
            array_push($this->data['errors'], $this->lang->line("page404"));
        elseif ($security[$path]['role'] === -1){/* INSECURE PAGE. Do NOTHING */}              
        elseif (!$this->thisvisitor->auth($security[$path]['role'], $this->input->get_post('bid'))) 
            array_push($this->data['errors'], $this->lang->line("unauthorized")); 
        if (count($this->data['errors']) > 0) {
            $this->data['docTitle'] = $this->lang->line("error");
            return $this->sendOut('forms/loginForm', "shell");
        }
        $this->data['docTitle'] = $security[$path]['title'];
        call_user_func_array(array($this, $security[$path]['method']), array());
    }
    
    private function setGlobals() {
        $this->data['subnav'] = array("/"=>$this->lang->line('nav_start'), "/language/debug"=>$this->lang->line('Debug Language'));
        if ($this->thisvisitor->auth(3, $this->input->get_post('bid'))) {
            $this->data['subnav']["/language/editor"] = $this->lang->line('Language Editor');
        }
    }
    
    private function sendOut($page, $shell="shell") {
                
        $asCSV = $this->input->get_post("csv");
        if ($asCSV == true && isset($this->data['codes']) && !empty($this->data['codes'])) {
            $this->load->helper('file');
            $filename = strtolower($this->data['docTitle']).'_'.date('dMy').'.csv';
            $this->load->helper('csv');
            return array_to_csv($this->data['codes'],TRUE,$filename);                    
        }                
        
        if (is_string($page)) {
            $this->data['pages'][$page] = $this->load->view($page, $this->data, TRUE);
        } else {
            array_push($this->data['pages'], $page);
        }
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('text/javascript');
            return $this->output->set_output(json_encode($page));
        }
        
        $this->load->view($shell, $this->data);
    }

    function debug(){
        $this->data['headers'] = array(
            "count"=>"Count", 
            "langtracker_key"=>"Key", 
            "langtracker_es"=>$this->lang->line("español"), 
            "langtracker_en"=>$this->lang->line("english"), 
            "langtracker_file"=>$this->lang->line("File"), 
            "langtracker_linenum"=>$this->lang->line("Line"), 
            "langtracker_url"=>$this->lang->line("URL"), 
            "langtracker_language"=>$this->lang->line("Language"), 
            "langtracker_status"=>$this->lang->line("Status"),
            "langtracker_added"=>$this->lang->line("Added"),
            "langtracker_updated"=>$this->lang->line("Updated"));
        
        $groupby = $this->input->get_post('groupby');
        $status = $this->input->get_post('status');  
        $this->data['texts'] = $this->language->getLanguageByStatus('debug', $groupby, $status);
        return $this->sendOut("language_table");
    }
    
    
}