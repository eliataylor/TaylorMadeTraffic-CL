<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projects_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        // fuck it.
        $this->db->query('set sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"');
        //$this->db->query('set sql_mode=""');
    }

    function getTags($type, $value=false, $having=0) {
        if (!in_array($type, array('technologies','years','industries','companies','team'))) $type = 'technologies';

        $sql = "SELECT count(tag_id) as count, tag_key, tag_type, MAX(tag_date) as tag_date FROM `tags` WHERE ";

        if ($type == 'team') {
        	$sql .= " tag_type like 'team_%'";
        } else {
        	$sql .= ' tag_type = ? ';
        	$params = array(':type'=>$type);
        }

        if (!empty($value)) {
        	$sql .= " and tag_key = ?";
        	$params[':value'] = $value;

        }

        $sql .= " group by tag_key ";

        if ($having > 0) {
        	$sql .= ' HAVING count >= ?';
        	$params[':having'] = $having;
        }

        if ($type == 'team') $sql .= ' order by tag_key asc';
        elseif ($type == 'years') $sql .= ' order by tag_key desc';
        elseif ($type == 'companies') $sql .= ' order by tag_date desc, count desc, tag_key asc ';
        elseif ($type == 'technologies') $sql .= ' order by tag_key asc';
        elseif ($type == 'industries') $sql .= ' order by count desc, tag_date desc, tag_key asc';
        else $sql .= ' order by tag_key desc, count desc'; // alphabetically


        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $results = $query->result_object();
            return $results;
        }
        return array();
    }

    function getProjectsByTag($type=false, $value=false, $having=0, $grouping=false) {
        $params = array();
        $sql = "SELECT P.*, T.*, I.*, min(I.image_weight), count(P.project_id) as count
        		FROM `projects` P
        		LEFT JOIN tags T on P.project_id = T.project_id
        		LEFT JOIN images I on P.project_id = I.project_id ";

        if ($this->uri->segment(1) == 'eli' && empty($this->uri->segment(2))) {
            $wheres = array("project_status = 'current' ");
            $wheres[] = "P.project_type = 'development' ";
        } else if ($this->uri->segment(1) == 'eli' && $this->uri->segment(2) === 'cv') {
            $wheres = array("project_status != 'deleted' ");
            $wheres[] = "P.project_type = 'development' ";
        } else {
            $wheres = array("project_status != 'deleted' ");
        }

        if ($type == 'team') {
        	array_push($wheres, " T.tag_type LIKE 'team_%' ");
        } else if (!empty($type)) {
        	array_push($wheres, " T.tag_type = ? ");
        	array_push($params, $type);
        }

        if (!empty($value)) {
            $alltags = explode(',', $value);
            if (count($alltags) > 1) {
                $placeholders = implode(',', array_fill(0, count($alltags), '?'));
                array_push($wheres, " T.tag_key IN ($placeholders)");
                array_push($params, ...$alltags);
            } else {
                array_push($wheres, " T.tag_key = ? ");
                array_push($params, $value);
            }
        }
        if (count($wheres) > 0) {
            $sql .= " WHERE " . implode(" AND ", $wheres);
        }

        $sql .= ' group by P.project_id ';
        if ($having > 0 && empty($grouping)) {
        	$sql .= ' HAVING count >= ?';
        	array_push($params, $having);
        }

        $sql .= ' order by P.project_type desc, P.project_launchdate desc, P.project_startdate desc';
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
          $rows = $query->result_object();
          return $rows;
        }
        return array();
    }

    function getProjectsByType($type=false, $filter=false) {
        $params = array();
        // yeah, i wrote this some ~15 years ago.
        $sql = "SELECT P.*, T.*, I.*, min(I.image_weight) FROM `projects` P LEFT JOIN tags T on P.project_id = T.project_id LEFT JOIN images I on P.project_id = I.project_id ";
        $wheres = array("project_status != 'deleted'");

        if (!empty($type)) {
            array_push($wheres, " P.project_type = ?");
            array_push($params, $type);
        }
        if (!empty($filter)) {
            array_push($wheres, " T.tag_key = ? ");
            array_push($params, $filter);
        }

        if (count($wheres) > 0) {
            $sql .= " WHERE " . implode(" AND ", $wheres);
        }

        $sql .= ' group by P.project_id order by P.project_type desc, P.project_startdate ';
        $sql .= ($type == 'development') ? ' asc' : ' desc';
        $query = $this->db->query($sql, $params);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }

    function getProject($pid) {
        $params = array();
        $sql = "SELECT P.*, I.*, min(I.image_weight) FROM projects P LEFT JOIN images I ON P.project_id = I.project_id WHERE ";
        if (is_numeric($pid)) $sql .= " P.project_id = ? ";
        else $sql .= " P.project_title = ? ";
        $sql .= 'ORDER BY I.image_weight ASC, I.image_src DESC LIMIT 1';
        $query = $this->db->query($sql, array($pid));
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) return $query->row();
        return array();
    }

    function getProjectsByIds($pids) {
        $sql = "SELECT P.* FROM projects P WHERE ";
        if (count($pids) > 1) {
            $placeholders = implode(',', array_fill(0, count($pids), '?'));
            if (is_numeric($pids[0])) {
                $sql .= " P.project_id IN ($placeholders) ";
            } else {
                $sql .= " P.project_title IN ($placeholders) ";
            }
            $params = $pids;
        } else {
            $sql .= " P.project_id = ? ";
            $params = $pids;
        }
        $sql .= 'ORDER BY P.project_startdate DESC';
        $query = $this->db->query($sql, $params);
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }

    function getProjectImages($pid=false) {
        $sql = "SELECT I.* FROM images I WHERE I.project_id = ? order by I.image_weight asc, I.image_src desc";
        $query = $this->db->query($sql, array($pid));
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }

    function getProjectById($pid=false) {
    	$sql = "SELECT * FROM projects WHERE project_id = ? LIMIT 1";
    	$query = $this->db->query($sql, array($pid));
    	if ($query->num_rows() > 0) return $query->row();
    	return array();
    }


    function countProjectImages($pid=false) {
        $sql = "SELECT count(I.image_id) as count FROM images I WHERE I.project_id = ?";
        $query = $this->db->query($sql, array($pid));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->count;
        }
        return 0;
    }

    function getImages() {
        $sql = "SELECT P.project_id, P.project_title, I.* FROM `projects` P, images I WHERE P.project_id = I.project_id order by I.project_id asc, I.image_weight asc, I.image_src desc";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }

    // team members
    function getTagsTeamMembers() {
        $sql = "SELECT COUNT( tag_id ) AS count, tag_key, tag_type, tag_date FROM  `tags`  WHERE tag_type LIKE  'team%' GROUP BY tag_key ORDER BY tag_key asc , count DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) return $query->result_object();
        return array();
    }

    // roles
    function getTagsTeamRoles($type=false) {
        $params = array();
        $sql = "SELECT COUNT( tag_id ) AS count, SUBSTRING(tag_type, 6) as tag_key, tag_type, tag_date FROM tags WHERE ";
        if (!$type) $sql .= " tag_type LIKE 'team%' ";
        else {
            $sql .= " tag_type = ? ";
            array_push($params, 'team_'.$type);
        }
        $sql .= " GROUP BY tag_type ORDER BY tag_date DESC, count DESC";
        $query = $this->db->query($sql, $params);
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

    function fileSrcExists($filename) {
    	$sql = "select * from images where image_src = ?";
    	$query = $this->db->query($sql, array($filename));
    	if ($query->num_rows() > 0) {
    		return true;
    	}
    	return false;
    }

    function hasTag($pid, $tag) {
    	$sql = "select * from tags where project_id = ? and tag_key = ?";
    	$query = $this->db->query($sql, array($pid, $tag));
    	if ($query->num_rows() > 0) {
    		return true;
    	}
    	return false;
    }

    function insertTag($data) {
        if (!is_object($data) && !is_array($data)) return false;
        //$this->db->insert('tags', $data);
        $sql = $this->db->insert_string('tags', $data);
        $sql .= ' ON DUPLICATE KEY UPDATE tag_type = ?';
        $this->db->query($sql, $data->tag_type);
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
