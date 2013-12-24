<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projects_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function getTags($type) {
        if ($type=='technologies') return $this->getTagsCodes();
        if ($type=='years') return $this->getTagsYears();
        if ($type=='companies') return $this->getTagsCompanies();
        if ($type=='team_members') return $this->getTagsTeamMembers();
        if ($type=='team_roles') return $this->getTagsTeamRoles();        
        else return $this->getTagsCodes();
    } 
    
    function getImages($pid=false) {
        $sql = "SELECT P.project_id, P.project_title, I.* FROM `projects` P, images I WHERE P.project_id = I.project_id order by I.project_id asc, I.image_weight asc";
        $query = $this->db->query($sql, array($type));
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }  
    
    // projects
    function getProjectsByTag($type=false, $value=false) {
        $params = array();
        $sql = "SELECT P.*, T.*, I.*, min(I.image_weight) FROM `projects` P LEFT JOIN tags T on P.project_id = T.project_id LEFT JOIN images I on P.project_id = I.project_id ";
        if (!empty($type) && !empty($value)) {
            $sql .= " WHERE T.tag_type = ? and T.tag_key = ?";
            array_push($params, $type, $value);
        }
        $sql .= 'group by P.project_id order by P.project_startdate desc';        
        $query = $this->db->query($sql, $params);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }       

    // code 
    function getTagsCodes() {
        $sql = "SELECT count(tag_id) as count, tag_key, tag_type, tag_date FROM `tags` where tag_type = 'technologies' group by tag_key order by tag_date desc, count desc;";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }      
    
    // years
    function getTagsYears() {
        $sql = "SELECT COUNT( tag_id ) AS count, tag_key, tag_type, tag_date FROM  `tags`  WHERE tag_type =  'years' GROUP BY tag_key ORDER BY tag_key DESC , count DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }      
    
    // companies
    function getTagsCompanies() {
        $sql = "SELECT COUNT( tag_id ) AS count, tag_key, tag_type, tag_date FROM  `tags`  WHERE tag_type =  'companies' GROUP BY tag_key ORDER BY tag_date desc , count DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }      
    
    // team members
    function getTagsTeamMembers() {
        $sql = "SELECT COUNT( tag_id ) AS count, tag_key, tag_type, tag_date FROM  `tags`  WHERE tag_type LIKE  'team%' GROUP BY tag_key ORDER BY tag_date desc , count DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }      

    // roles
    function getTagsTeamRoles() {
        $sql = "SELECT COUNT( tag_id ) AS count, SUBSTRING(tag_type, 6) as tag_key, tag_type, tag_date FROM  `tags`  WHERE tag_type LIKE  'team%' GROUP BY tag_type ORDER BY tag_date desc , count DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }      
    
    function getUser($uid) {
        $sql = "SELECT * from users WHERE user_id = ? and user_status > 0";
        $query = $this->db->query($sql, $uid);
        if ($query->num_rows() > 0) {
            $user = $this->splitEmails($query->row_array());
            unset($user['user_passhash']);
            return $user;
        }
        return false;
    }

    private function splitEmails($user) {
        $emails = explode(",", $user['user_email']);
        $user['allemails'] = $emails; // always as array: checks against in_array()
        if (count($emails) > 1) {
            $user['user_email'] = $emails[0];
        }
        return $user;
    }

    function checkUserByPass($passhash, $email) {
        if (!is_string($passhash) || !$email) return false;

        $sql = "SELECT * from users WHERE user_status > 0";
        $sql .= " AND user_passhash = " . $this->db->escape($passhash) . " AND lower(user_email) like '%" . $this->db->escape_like_str(strtolower($email)) . "%'";
        $sql .= " LIMIT 1"; // like is slow anyway

        $query = $this->db->query($sql);
        
        if ($query->num_rows() == 1) {
            $user = $this->splitEmails($query->row_array());
            unset($user['user_passhash']);
            return $user;
        }
        return false;
    }

    function userPropExists($prop, $val) {
        if (!is_string($prop) || !$val) return false;
        $query = $this->db->query(sprintf("select user_id from users where %s = %s", $prop, $this->db->escape($val)));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return (int) $row['user_id'];
        }
        return false;
    }

    function userEmailExists($email) {
        $sql = "select user_id, user_email from users where lower(user_email) like '%" . $this->db->escape_like_str($email) . "%' and user_status > -1 LIMIT 1"; // -1 is deleted, 0 is unverified, 1 is normal user, 10 is GOD
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $user = $this->splitEmails($query->row_array());
            if (in_array($email, $user['allemails'])) {
                return (int) $user['user_id'];
            }
        }
        return false;
    }
    
    function insertProject($data) {
        if (!is_object($data) && !is_array($data)) return false;
        $this->db->insert('projects', $data);
        return $this->db->insert_id();
    }

    function insertImage($data) {
        if (!is_object($data) && !is_array($data)) return false;
        $this->db->insert('images', $data);
        return $this->db->insert_id();
    }
    
    function insertTag($data) {
        if (!is_object($data) && !is_array($data)) return false;
        $this->db->insert('tags', $data);
        return $this->db->insert_id();
    }    
    
    function updateProject($pid, $data) {
        if (!is_object($data) && !is_array($data)) return false;
        $this->db->where('project_id', $pid);
        $this->db->update('projects', $data); // unchecked aside controller
        return $this->db->affected_rows();
    }

    function next_id($table) {
        $query = $this->db->query("SHOW TABLE STATUS LIKE '%".$this->db->escape_like_str($table)."%'");
        $row = $query->row_array();
        return intval($row['Auto_increment']);
    }

        function getTableHeaders($table) {
            return $this->db->list_fields($table);
        }    
    
}