<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getAllUsers() {
        $sql = "SELECT * from users";
        $query = $this->db->query($sql);
        $rows = $query->result_array();
        foreach($rows as &$row) {
            $row = $this->splitEmails($row);
        }
        return $rows;
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

        $sql = "SELECT * from users WHERE user_status > 0 ";
//        $sql .= " AND user_passhash = " . $this->db->escape($passhash) . " AND lower(user_email) like '%" . $this->db->escape_like_str(strtolower($email)) . "%'"; // TODO: this needs to be an exact match
        $sql .= " AND user_passhash = ? AND lower(user_email) = ?"; 
        $sql .= " LIMIT 1"; // like is slow anyway

        $query = $this->db->query($sql, array($passhash, strtolower($email)));
        if ($query->num_rows() == 1) {
            $user = $query->row_array();
            //$user = $this->splitEmails($query->row_array());
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
        //$sql = "select user_id, user_email from users where lower(user_email) like '%" . $this->db->escape_like_str($email) . "%' and user_status > -1 LIMIT 1"; // -1 is deleted, 0 is unverified, 1 is normal user, 10 is GOD
        $sql = "select user_id, user_email from users where lower(user_email) = ? and user_status > -1 LIMIT 1"; // -1 is deleted, 0 is unverified, 1 is normal user, 10 is GOD
        $query = $this->db->query($sql, array($email));
        if ($query->num_rows() > 0) {
            $user = $this->splitEmails($query->row_array());
            if (in_array($email, $user['allemails'])) {
                return (int) $user['user_id'];
            }
        }
        return false;
    }
    
    function insertUser($data) {
        if (!is_array($data))
            return false;
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    function updateUser($uid = -1, $data) {
        if (empty($data) || !is_array($data)) return -1;
        $this->db->where('user_id', $uid);
        $this->db->update('users', $data); // unchecked aside controller
        return $this->db->affected_rows();
    }


    function next_id() {
        $query = $this->db->query("SHOW TABLE STATUS LIKE 'users'");
        $row = $query->row_array();
        return intval($row['Auto_increment']);
    }

}