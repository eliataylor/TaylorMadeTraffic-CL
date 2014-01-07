<?php

class LenguaPlusController extends CI_Controller {    
    
    private $data = array("pages"=>array(), "me"=>array(), 'errors'=>array());
    
    function __construct() {
        parent::__construct();
        $this->data['me'] = $this->thisvisitor->getVisitor();     
        $this->setGlobals();
    }
    
    function _remap() {
        $security = array(
            "lenguaplus/changelanguage"=>array("role"=>0,"title"=>$this->lang->en("Update"),"method"=>"changelanguage"),
            "lenguaplus/login"=>array("role"=>0,"title"=>$this->lang->en("Login"),"method"=>"login"),
            "lenguaplus/myprofile"=>array("role"=>0,"title"=>$this->lang->en("Update"),"method"=>"myprofile"),
            "lenguaplus/authors"=>array("role"=>2,"title"=>$this->lang->en("Update"),"method"=>"authors"),
            "lenguaplus/logout"=>array("role"=>2,"title"=>$this->lang->en("Logout"),"method"=>"logout"),
            "lenguaplus/update"=>array("role"=>3,"title"=>$this->lang->en("Update"),"method"=>"updateLangByKey"),
            "lenguaplus"=>array("role"=>0,"title"=>$this->lang->en("Language"),"method"=>"debug"),
        );
        
        $path = uri_string();
        if (!isset($security[$path])) {
            array_push($this->data['errors'], $this->lang->en("Page Not Found"));
        } elseif ($security[$path]['role'] < 1){
            /* INSECURE PAGE. Do NOTHING */
        } elseif (!$this->thisvisitor->auth($security[$path]['role'])) {
            array_push($this->data['errors'], $this->lang->en("unauthorized")); 
            $this->data['docTitle'] = $this->lang->en("Login");
            return $this->sendOut('loginForm');
        }
        if (count($this->data['errors']) > 0) {
            $this->data['docTitle'] = $this->lang->en("error");
            return $this->sendOut('cms_shell');
        }
        $this->data['docTitle'] = $security[$path]['title'];
        call_user_func_array(array($this, $security[$path]['method']), array());
    }
    
    private function setGlobals() {
        $this->data['qparams']['status'] = $this->input->get_post('status');  
        $this->data['qparams']['type'] = $this->input->get_post('type');        
        $this->data['qparams']['groupby'] = $this->input->get_post('groupby');  
        if (is_array($this->data['qparams']['groupby'])) {
            foreach($this->data['qparams']['groupby'] as $key => $qp) {
                if (empty($qp)) unset($this->data['qparams']['groupby'][$key]);
            }
        } else {
            $this->data['qparams']['groupby'] = array();
        }
    }
    
    private function sendOut($page, $shell="cms_shell") {
                
        $asCSV = $this->input->get_post("csv");
        if ($asCSV == true && isset($this->data['codes']) && !empty($this->data['codes'])) {
            $this->load->helper('file');
            $filename = strtolower($this->data['docTitle']).'_'.date('dMy').'.csv';
            $this->load->helper('csv');
            return array_to_csv($this->data['codes'],TRUE,$filename);                    
        }                
        
        if ($page == $shell) {
          // do nothing  
        } elseif (is_string($page)) {
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
    
    function changelanguage(){
        $con = $this->data['me']['con'];            
        if ($this->input->get_post('lang')) $con['lang'] = $this->input->get_post('lang');
        if ($con['lang'] && in_array($con['lang'], array('es','en'))) {
            $this->thisvisitor->upConstants($con);
            $this->thisvisitor->saveSession();   
        }
        return false;
    }    
    
    function debug(){
        $this->data['headers'] = array(
            "count"=>"Count", 
            "langtracker_key"=>"Key",
            "langtracker_es"=>$this->lang->en("español"), 
            "langtracker_en"=>$this->lang->en("english"), 
            //"langtracker_file"=>$this->lang->en("File"), 
            //"langtracker_linenum"=>$this->lang->en("Line"), 
            "langtracker_urls"=>$this->lang->en("URL"), 
            //"langtracker_language"=>$this->lang->en("Language"), 
            //"langtracker_status"=>$this->lang->en("Status"),
            "langtracker_added"=>$this->lang->en("Added"),
            "langtracker_updated"=>$this->lang->en("Updated"));
        
        $this->data['texts'] = $this->LenguaPlus_model->getLanguageByFilters($this->data['qparams']['status'], $this->data['qparams']['groupby'], $this->data['qparams']['type']);
        return $this->sendOut("language_table");
    }
    
    function publish() {
        
    }
    
    function saveToFile() {
        
    }
    
    function updateLangByKey() {
        $this->output->set_content_type('text/javascript');            
        $langs = $this->input->post('languages');
        $langId = $this->input->post('id');
        $resp = array();
        if (!$langs || !$langId) {
            $resp['errors'] = array($this->lang->en('Invalid URL'));
            return $this->output->set_output(json_encode($resp));
        }
        $test = -1;
        $langs = explode(',',$langs);
        $data = array();
        foreach($langs as $lang) {
            $data['langtracker_'.$lang] = $this->input->post($lang.'_'.$langId);
            if (!$data['langtracker_'.$lang]) {
                $resp['errors'] = array($this->lang->en('Invalid URL'));
           }
       }
       if (!empty($data)) {
           $line = $this->LenguaPlus_model->getLanguageById($langId);
           if ($line) {
               $data['langtracker_status'] = 'edited';
               $test = $this->LenguaPlus_model->updateLangByKey($data, $line->langtracker_key, $this->data['qparams']['status'], $this->data['qparams']['type']);
           } else {
               $resp['errors'] = array($this->lang->en('Invalid URL'));
           }
       }
        
       if ($test == -1) $resp['msg'] = $this->lang->en('Update Failed');
       elseif ($test == 0) $resp['msg'] = $this->lang->en('Nothing Changed');
       else $resp['msg'] = $this->lang->en('Updated ') . $test;
       return $this->output->set_output(json_encode($resp));       
    } 
     
    
    function myprofile() {
        //$this->data['docTitle'] = $this->data['me']['user_screenname'];     
        //$this->data['reports'] = $this->brands->reportsByUser($this->data['me']['user_id'], false);
        var_dump($this->data['me']);
        //return $this->sendOut("myprofile");
    }
    
    function authors() {
        $uid = $this->input->get_post("uid");
        if ($uid) {
            $this->data['user'] = $this->users->getUser($uid);
            //$this->data['edits'] = $this->brands->reportsByUser($uid, false);
            if ($this->data['user']) $this->data['docTitle'] = $this->data['user']['user_screenname'];        
        }
        return $this->sendOut("userprofile");
    }
    
    function login() {
        if ($this->thisvisitor->auth()) $this->sendOut("loginForm"); // do not allow validation on users with a session already!
        $this->data['me'] = $this->thisvisitor->validateUser();      
        $this->data['errors'] = $this->thisvisitor->getErrors();
        if ($this->thisvisitor->auth()) {
            return redirect(TMT_HTTP.'language', 'location', 301); // SUCCESS
        }
        $this->data['user_email'] = $this->input->post("user_email", false); // populate form
        $this->sendOut("loginForm");
    }
    
    function logout() {
        $this->thisvisitor->clear(); // this is resetting group id
        redirect(TMT_HTTP, 'location', 301);
    }
}