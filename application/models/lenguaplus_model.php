<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class LenguaPlus_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
                
    public function trackLang($obj) {
        if (!is_array($obj)) return false;
        $this->db->insert('langtracker', $obj);
        return $this->db->insert_id();
    }
    
    public function getLanguageByFilters($status=false, $groupby=false, $type=false, $from=0, $want=300) {
        if (empty($groupby)) $sql = 'SELECT *, langtracker_url as langtracker_urls FROM langtracker ';
        else $sql = 'SELECT *, count(*) as count, group_concat(langtracker_url) as langtracker_urls FROM langtracker ';
        
        $params = array();
        $wheres = array();
        if (!empty($status)) {
            array_push($wheres, 'langtracker_status = ?');
            array_push($params, $status);
        }  else {
            array_push($wheres, 'langtracker_status != \'deleted\' ');
        }
        if (!empty($type)) {
            array_push($wheres, 'langtracker_type = ?');
            array_push($params, $type);
        }
        
        $sql .= ' WHERE ' . implode(' AND ', $wheres);
        
        if (is_array($groupby)) $groupby = implode(',',$groupby);
        if ($groupby == 'url') $sql .= ' group by langtracker_key, langtracker_url';
        elseif ($groupby == 'key') $sql .= ' group by langtracker_key';
        elseif ($groupby == 'file') $sql .= ' group by langtracker_key, langtracker_file';
        elseif ($groupby == 'status') $sql .= ' group by langtracker_key, langtracker_status';
        elseif ($groupby == 'file,line') $sql .= ' group by langtracker_key, langtracker_file, langtracker_linenum';
        
        if (!is_numeric($from) || $from < 0)$from = 0;
        if (!is_numeric($want)) $want = 300; // allow all for publisher
        $sql .= " LIMIT $from, $want";
        
        $query = $this->db->query($sql, $params);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }       
    
    public function getLanguageById($lid, $status=NULL) {
        $sql = 'SELECT * FROM langtracker where langtracker_id = ?';
        $params = array($lid);
        if (!empty($status) && in_array($status, array('edited','live','debug')))  {
            $sql .= " and langtracker_status = ?";
            array_push($params, $status);
        }
        $sql .= ' LIMIT 1';
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) return $query->row();
        return array();
    }  
    public function getLanguageByKey($key, $status=NULL) {
        $sql = 'SELECT * FROM langtracker where langtracker_key = ?';
        $params = array($key);
        if (!empty($status) && in_array($status, array('edited','live','debug')))  {
            $sql .= " and langtracker_status = ?";
            array_push($params, $status);
        }
        $sql .= ' LIMIT 1';
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) return $query->row();
        return false;
    }      
        
    public function hasKeyByUrl($obj){
        $sql = 'SELECT langtracker_id FROM langtracker where langtracker_key = ? and langtracker_url = ? limit 1';
        $query = $this->db->query($sql, array($obj['langtracker_key'], $obj['langtracker_url']));
        if ($query->num_rows() > 0) return true;
        return false;
    }
    
    public function hasKeyByFileLineInDebug($obj){
        $sql = 'SELECT langtracker_id FROM langtracker where langtracker_status = \'debug\' and langtracker_key = ? and langtracker_file = ? and langtracker_linenum = ? limit 1';
        $query = $this->db->query($sql, array($obj['langtracker_key'], $obj['langtracker_file'], $obj['langtracker_linenum']));
        if ($query->num_rows() > 0) return true;
        return false;
    }
    
    function updateLangByFilters($data, $status=false, $type=false){
        
        if (!empty($status)) 
            $this->db->where('langtracker_status', $status);
        
        if (!empty($type))
            $this->db->where('langtracker_type', $type);
        
        $this->db->update('langtracker', $data); // unchecked aside controller
        return $this->db->affected_rows();
    }

    function updateLangByKey($data, $key){
        $this->db->where('langtracker_key', $key);
        $this->db->update('langtracker', $data); // unchecked aside controller
        return $this->db->affected_rows();
    }
    function updateLangById($data, $id){
        $this->db->where('langtracker_id', $id);
        $this->db->update('langtracker', $data); // unchecked aside controller
        return $this->db->affected_rows();
    }    
    
    function next_id() {
        $query = $this->db->query("SHOW TABLE STATUS LIKE 'langtracker'");
        $row = $query->row_array();
        return intval($row['Auto_increment']);
    }

}