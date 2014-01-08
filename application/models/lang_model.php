<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lang_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
                
    public function trackLang($obj) {
        if (!is_array($obj)) return false;
        $this->db->insert('langtracker', $obj);
        return $this->db->insert_id();
    }
    
    public function getLanguageByStatus($status=false, $groupby='url', $status=false) {
        $sql = 'SELECT *, count(*) as count FROM langtracker ';
        
        $params = array();
        if (!empty($status)) {
            $sql .= 'where langtracker_status = ?';
            array_push($params, $status);
        }
            
        
        if (is_array($groupby)) $groupby = implode(',',$groupby);
        if ($groupby == 'url') $sql .= ' group by langtracker_url';
        elseif ($groupby == 'key') $sql .= ' group by langtracker_key';
        elseif ($groupby == 'file') $sql .= ' group by langtracker_file';
        elseif ($groupby == 'status') $sql .= ' group by langtracker_status';
        elseif ($groupby == 'file,line') $sql .= ' group by langtracker_file, langtracker_linenum';
        
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }       
    
    public function hasKeyByUrl($obj){
        $sql = 'SELECT langtracker_id FROM langtracker where langtracker_key = ? and langtracker_url = ? limit 1';
        $query = $this->db->query($sql, array($obj['langtracker_key'], $obj['langtracker_url']));
        if ($query->num_rows() > 0) return true;
        return false;
    }
    
    public function hasKeyByFileLine($obj){
        $sql = 'SELECT langtracker_id FROM langtracker where langtracker_key = ? and langtracker_file = ? and langtracker_linenum = ? limit 1';
        $query = $this->db->query($sql, array($obj['langtracker_key'], $obj['langtracker_file'], $obj['langtracker_linenum']));
        if ($query->num_rows() > 0) return true;
        return false;
    }
    
    function updateLang($key, $data) {
        $this->db->where('langtracker_key', $key);
        $this->db->update('users', $data); // unchecked aside controller
        return $this->db->affected_rows();
    }

    function next_id() {
        $query = $this->db->query("SHOW TABLE STATUS LIKE 'langtracker'");
        $row = $query->row_array();
        return intval($row['Auto_increment']);
    }

}