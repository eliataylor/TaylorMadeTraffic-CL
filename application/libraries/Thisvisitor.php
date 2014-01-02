<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Thisvisitor {

    private $visitor = array("con"=>array(), "errors"=>array());

    function __construct() {
        $CI = &get_instance();
        $CI->load->model('Projects_model', 'projects');
        $CI->load->library('user_agent');
        $this->setDefaults();
    }
        
    private function setDefaults() {
         $CI = &get_instance();
         
         $this->visitor['con']['lang'] = (!isset($this->visitor['con']['lang'])) ? "english" : $this->visitor['con']['lang'];
         //$CI->lang->load('messages', $this->visitor['con']['lang']);
         
         $pstyle = $CI->input->get_post('pstyle');
         if (!in_array($pstyle, array('pBlack','pWhite'))) $pstyle = 'pBlack';
         $this->visitor['con']['pstyle'] = $pstyle;         
         
         if ($CI->input->get_post('debug')) {
             if (ENVIRONMENT == 'production'){
                 $CI->output->set_profiler_sections(array(
                     'config'=>FALSE, 'queries'=>FALSE
                 ));
             }
             $CI->output->enable_profiler(TRUE);
             $this->visitor['con']['debugMode'] = true;
         }
         if ($CI->agent->is_mobile("iPad")) {
            if (!isset($this->visitor['con']['swidth'])) $this->visitor['con']['swidth'] = 930;
            if (!isset($this->visitor['con']['sheight'])) $this->visitor['con']['sheight'] = 644;
            $this->visitor['con']['isMobile'] = true;
         } elseif ($CI->agent->is_mobile("iPhone")) {
            if (!isset($this->visitor['con']['swidth'])) $this->visitor['con']['swidth'] = 406;
            if (!isset($this->visitor['con']['sheight'])) $this->visitor['con']['sheight'] = 784;
            $this->visitor['con']['isMobile'] = true;
         } elseif ($CI->agent->is_mobile()) {
            if (!isset($this->visitor['con']['swidth'])) $this->visitor['con']['swidth'] = 550; // intentionally 1 off to tell me it's default
            if (!isset($this->visitor['con']['sheight'])) $this->visitor['con']['sheight'] = 643;
            $this->visitor['con']['isMobile'] = true;
         } else {
            if (!isset($this->visitor['con']['swidth'])) $this->visitor['con']['swidth'] = 940;
            if (!isset($this->visitor['con']['sheight'])) $this->visitor['con']['sheight'] = 550;
            $this->visitor['con']['isMobile'] = false;
        } 
        
        $test = $CI->session->userdata('con');
        if(empty($test)) {
            $this->saveSession();
        } else {
            foreach($test as $key => $t) {
                if (!isset($this->visitor['con'][$key]) || $this->visitor['con'][$key] != $t) {
                    $this->saveSession();
                    break;
                }
            }
        }
        
    }
        
    function validateUser() {
        $CI = & get_instance();
        
        $pass = $CI->input->post('password');
        $email = $CI->input->post('username');
                
         if ($pass && $email) {
            $this->visitor['con']['lAttempts'] = (isset($this->visitor['con']['lAttempts'])) ? $this->visitor['con']['lAttempts'] + 1 : 1;
            $user = $CI->users->checkUserByPass(md5($pass . $CI->config->item('encryption_key')), $email);
            if ($user) {
                $this->visitor = array_merge($this->visitor,  $user); 
            } else {            
                array_push($this->visitor['errors'], $CI->lang->line('bad_pass_or_email'));
                $this->updateSession('con', $this->visitor['con']); // update lAttempts                
            }
        }

        if ($this->auth()) {
            $this->visitor["user_2ndlast_login"] = ($this->visitor["user_last_login"] > 0) ? $this->visitor["user_last_login"] : time();
            $this->visitor["user_last_login"] = time();
            $CI->users->updateUser($this->visitor['user_id'], array("user_last_login"=>$this->visitor['user_last_login'], "user_2ndlast_login"=>$this->visitor['user_2ndlast_login']));
            $this->saveSession();
        }
        return $this->visitor;
    } 
    
    function getVisitor() { // makes global assignment
        $this->visitor = array_merge($this->visitor, $this->getSession());    
        if ($this->visitor['errors'] == null) $this->visitor['errors'] = array();
        return $this->visitor;
    }
    
    private function getSession() {
        $CI = &get_instance();
        return $this->arrayToVisitor($CI->session->all_userdata());
    }

    public function saveSession() {
        $CI = &get_instance();
        $ref = &$this->visitor;
        $copy = $ref;
        unset($copy['errors']);
        $CI->session->set_userdata($copy);
    }

    public function upConstants($arr){
        if (!is_array($arr)) return $this->visitor['con'];
        $this->visitor['con'] = array_merge($this->visitor['con'], $arr);
        return $this->visitor['con'];
    }
    
    public function arrayToVisitor($arr) { // todo: security issue: private or change return value;
        if (!is_array($arr)) return $this->visitor;
        foreach ($arr as $key => $value) {
            $this->visitor[$key] = $value;
        }
        return $this->visitor;
    }
    
    public function updateSession($prop, $val) { // todo: security issue?
        if ($prop == 'user_id' || $prop == "user_status" || $prop == "user_added") return false;
        if (isset($this->visitor[$prop])) {
            $this->visitor[$prop] = $val;            
        }
        $this->saveSession();
    }    
    
    public function auth($isAdmin=2, $bid=false) {
        if (isset($this->visitor['user_id']) && isset($this->visitor['user_status']) && (int)$this->visitor['user_status'] >= 1) {
            if ($isAdmin > 1) { // admin
                if (is_numeric($bid)) {
                    $CI = &get_instance();
                    $brand = $CI->brands->checkBrandMembership($bid, $this->visitor['user_id'], $isAdmin, FALSE); // probably could cache these full role matrix to avoid another query every time here
                    if ($brand) return true;
                    else return false;
                } 
                elseif($this->visitor['user_status'] >= $isAdmin) return true;
                else return false;
            } 
            else return true;
        }
        return false;
    }    

    public function getErrors() {
        return $this->visitor['errors'];
    }
    
    
    public function clear() {
        $CI = &get_instance();
        $CI->session->sess_destroy();
        $CI->load->helper('cookie');
        delete_cookie($CI->config->item('cookie_prefix') . $CI->config->item('sess_cookie_name')); // http://stackoverflow.com/questions/12669791/codeigniters-sess-destroy-doesnt-work
        $CI->session->sess_create();
        $this->visitor = array("con"=>array(), "errors"=>array());
        $this->setDefaults(); // using unset does this http://stackoverflow.com/questions/14599104/502-bad-gateway-and-codeigniter-nginx-apache-code-or-server-issue
        $this->saveSession(); 
        return $this->visitor;
    }

}