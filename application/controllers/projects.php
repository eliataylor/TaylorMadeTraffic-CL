<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller {

    private $data = array("pages" => array(), "me" => array(), 'errors' => array());

    function __construct() {
        parent::__construct();
        $this->load->model('Projects_model', 'projects');
        $this->data['me'] = $this->thisvisitor->getVisitor();
        $this->setGlobals();
    }

    function _remap() {
        $this->data['qmenu'] = array(
            "" => array("role" => 0, 'icon'=>'' , "title" => $this->lang->line("Technologies"), "method" => "technologies"),
            "creative" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->line("Cube Animation"), "method" => "staticPage"),
            "settings" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->line("Settings"), "method" => "viewSettings"),
            
            "technologies" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->line("Technologies"), "method" => "technologies"),
            "years" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->line("Years"), "method" => "years"),
            "companies" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->line("Companies"), "method" => "companies"),
            "industries" => array("role" => -1, 'icon'=>'',  "title" => $this->lang->line("Industries"), "method" => "industries"),
            
            "taylormade" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->line("TaylorMade"), "method" => "taylormade"),
            "eli" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->line("Eli"), "method" => "eli"),

            "projects" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->line("Projects"), "method" => "projects"),
            
            "team" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->line("Team"), "method" => "team"),
            "roles" => array("role" => 0, 'icon'=>'',  "title" => $this->lang->line("Roles"), "method" => "team"),
            
            "cv-format" => array("role" => 1, 'icon'=>'',  "title" => $this->lang->line("CV"), "method" => "cvPrint"),
            "stylesheet" => array("role" => 1, 'icon'=>'',  "title" => $this->lang->line("stylesheet"), "method" => "stylesheet"),
            "import" => array("role" => 1, 'icon'=>'', "title" => $this->lang->line("import"), "method" => "importXML")
        );

        $path = uri_string();
        if (!isset($this->data['qmenu'][$path]))
            array_push($this->data['errors'], $this->lang->line("page404"));
        elseif ($this->data['qmenu'][$path]['role'] < 2) {
            /* INSECURE PAGE. Do NOTHING */
        } elseif (!$this->thisvisitor->auth($this->data['qmenu'][$path]['role']))
            array_push($this->data['errors'], $this->lang->line("unauthorized"));
        if (count($this->data['errors']) > 0) {
            $this->data['docTitle'] = $this->lang->line("error");
            return $this->sendOut('cv_projects', "cv_shell");
        }
        $this->data['docTitle'] = $this->data['qmenu'][$path]['title'];
        if (!empty($this->data['qtfilter'])) $this->data['docTitle'] .= ' :: ' . $this->data['qtfilter'];
        call_user_func_array(array($this, $this->data['qmenu'][$path]['method']), array());
    }

    private function setGlobals() {
        $this->data['qtags'] = $this->input->get_post('qtags');
        if (empty($this->data['qtags'])) $this->data['qtags'] = $this->uri->segment(1);
        $this->data['qtfilter'] = $this->input->get_post('qtfilter');
        if (empty($this->data['qtfilter'])) $this->data['qtfilter'] = $this->uri->segment(2);
    }

    private function sendOut($page, $shell="shell") {
        $this->data['pages'][$page] = $this->load->view($page, $this->data, TRUE);
        if ($this->input->is_ajax_request()) {
            return $this->output->set_output(
                    $this->load->view($page, $this->data, TRUE)
                    );
        }

        $this->load->view($shell, $this->data);
    }

    public function staticPage() {$this->load->view('landing', $this->data);}
    public function stylesheet() {$this->load->view('stylesheet', $this->data);}
    
            
    // tag list views
    public function technologies() {
        $this->data['qtags'] = 'technologies';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table', 'cms_shell');
        } else{
            $this->getTableForProjects();
            $this->sendOut('projects_table', 'cms_shell');
        }
    }
    public function years() {
        $this->data['qtags'] = 'years';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table', 'cms_shell');
        } else{
            $this->getTableForProjects();
            $this->sendOut('projects_table', 'cms_shell');
        }
    }
    public function industries() {
        $this->data['qtags'] = 'industries';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table', 'cms_shell');
        } else{
            $this->getTableForProjects();
            $this->sendOut('projects_table', 'cms_shell');
        }
    }
    public function companies() {
        $this->data['qtags'] = 'companies';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table', 'cms_shell');
        } else{
            $this->getTableForProjects();
            $this->sendOut('projects_table', 'cms_shell');
        }
    }
    
    public function team() {
        if (empty($this->data['qtfilter'])) {
            $this->data['headers'] = array(
            'count'=>$this->lang->line("Total"),
            'tag_key'=>$this->data['docTitle'],
            'tag_date'=>$this->lang->line("Last Used")
                );            
            if ($this->data['qtags'] == "roles") $this->data['tableRows'] = $this->projects->getTagsTeamRoles();
            else $this->data['tableRows'] = $this->projects->getTagsTeamMembers();
            $this->sendOut('tags_table', 'cms_shell');
        } else{
            $this->data['headers'] = array('image_src'=>$this->lang->line("Pics"));
            if ($this->data['me']['con']['swidth'] > 600) $this->data['headers']['project_title'] = $this->lang->line("Info");
            if ($this->data['me']['con']['swidth'] > 980) $this->data['headers']['project_startdate'] = $this->lang->line("Tags");
            
            if ($this->data['qtags'] == "roles") $this->data['qtagOptions'] = $this->projects->getTagsTeamRoles();
            else $this->data['qtagOptions'] = $this->projects->getTagsTeamMembers();
            if ($this->data['qtags'] == "roles") {
                $this->data['tableRows'] = $this->projects->getTagsTeamRoles($this->data['qtfilter']);
            } else {
                $this->data['tableRows'] = $this->projects->getProjectsByTag(null, $this->data['qtfilter']); 
            }
            if (uri_string() == 'cv-format') {
                $this->sendOut('cv_projects', 'cv_shell');
            } else {
                $this->sendOut('projects_table', 'cms_shell');
            }
        }
    }     
    
    // just URL predefines qtags
    function taylormade(){
        $this->data['qtags'] = 'companies';
        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags']); 
        $this->data['qtfilter'] = 'TaylorMadeTraffic';
        $this->getTableForProjects();
        $this->sendOut('projects_table', 'cms_shell');
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
            $this->sendOut('projects_table', 'cms_shell');
        } else{
            $this->data['docTitle'] = $this->data['qtfilter'];            
            $val = (empty($this->data['qtfilter'])) ? $pid : $this->data['qtfilter'];
            $this->data['project'] = $this->projects->getProject($val);
            $this->data['project']->images = $this->projects->getProjectImages($this->data['project']->project_id);
            $this->sendOut('project_profile', 'cms_shell');
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
        $this->sendOut('cms_table', 'cms_shell');
    }   

    function getTableForTags() {
        $this->data['headers'] = array(
            'count'=>$this->lang->line("Total"),
            'tag_key'=>$this->data['docTitle'],
            'tag_date'=>$this->lang->line("Last Used")
                );
        $this->data['tableRows'] = $this->projects->getTags($this->data['qtags']); 
    }

    function getTableForProjects() {        
        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags']); 
        $this->data['headers'] = array('image_src'=>$this->lang->line("Pics"));
        if ($this->data['me']['con']['swidth'] > 600) $this->data['headers']['project_title'] = $this->lang->line("Info");
        if ($this->data['me']['con']['swidth'] > 980) $this->data['headers']['project_startdate'] = $this->lang->line("Tags");
        $this->data['tableRows'] = $this->projects->getProjectsByTag($this->data['qtags'], $this->data['qtfilter']); 
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
    
    public function cvPrint() {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file("wwwroot/folioXML.xml");
        $html = '';
        foreach ($xml->children() as $child) {
            $project_type = $child->getName(); // obsolete difference only in xml
            foreach ($child->children() as $item) {
                if (!empty($item->technotes) || !empty($item->desc)) {
                    $html .= "<h4>" . $item->title . "</h4>"; 
                    if (!empty($item->desc)) $html .= "<p>" . $item->desc . "</p>";
                    if (!empty($item->technotes)) $html .= "<p>" . $item->technotes . "</p>";
                }
            }   
        }
        echo $html;
    }

    public function importXML() {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file("wwwroot/folioXML.xml");

        foreach ($xml->children() as $child) {
            $project_type = $child->getName(); // obsolete difference only in xml
            foreach ($child->children() as $item) {
                $obj = new stdClass();
                
                $pid = $this->projects->next_id('projects');
                $obj->project_id = $pid;
                        
                foreach ($item->children() as $col) {
                    $key = (strpos($col->getName(),'_id') < 1) ? 'project_' . $col->getName() : $col->getName();
                    $col = (string)$col;
                    if (!empty($col))  {
                        $obj->$key = trim((string) $col);
                    }
                }
                
                if (isset($obj->project_startdate) && !empty($obj->project_startdate)) {
                    $obj->project_startdate = date("Y-m-d H:i:s", strtotime($obj->project_startdate));                
                    $obj->project_startyear = date("Y", strtotime($obj->project_startdate));                
                } elseif (isset($obj->project_startyear) && !empty($obj->project_startyear)) {
                    $obj->project_startdate = date("Y-m-d H:i:s", strtotime($obj->project_startyear));                
                    $obj->project_startyear = $obj->project_startyear;                
                } else {
                    var_dump($obj);
                    die('NO START DATE');
                }
                if (isset($obj->project_launchdate) && !empty($obj->project_launchdate)) {
                    $obj->project_launchdate = date("Y-m-d H:i:s", strtotime($obj->project_launchdate));                
                    $obj->project_launchyear = date("Y", strtotime($obj->project_launchdate));                
                } else {
                     unset($obj->project_launchdate);
                }
                
                if ((isset($obj->project_xlSrc) && !empty($obj->project_xlSrc)) || (isset($obj->project_xlDir) && !empty($obj->project_xlDir))) {
                    if (isset($obj->project_xlDir) && !empty($obj->project_xlDir)) {
                        $dir = $obj->project_xlDir;
                    } else {
                        $dir = explode(',', $obj->project_xlSrc);
                        $dir = trim($dir[0]);
                        $dir = substr($dir, 0, strpos($dir, strrchr($dir, '/')));
                    }
                    $files1 = scandir(ROOT_CD . $dir);
                    $index = 0;
                    foreach($files1 as $img) {
                        if($img === '.' || $img === '..' || strpos($img, '.db') > -1 || strpos(strtolower($img), '.swf') > 0 ||
                                strpos($img, '_150x150') > -1 || 
                                strpos($img, '_300x300') > -1) continue;
                        $filename = $dir."/".$img;        
                        //echo '<h1>' . $filename . '</h1>';
                        if(is_file(ROOT_CD . $filename)) {
                            $meta = getimagesize (ROOT_CD . $filename);
                            $t = new StdClass();
                            $t->image_src = $filename;
                            $t->image_weight = $index + 1;
                            $t->image_width = (int)$meta[0];
                            $t->image_height = (int)$meta[1];
                            $t->project_id = $pid;
                            $this->projects->insertImage($t);
                            $index++;
                        }
                    }
                }                

                if (isset($obj->project_thumbSrc)) unset($obj->project_thumbSrc);
                if (isset($obj->project_xlSrc)) unset($obj->project_xlSrc);
                if (isset($obj->project_thumbDir)) unset($obj->project_thumbDir);
                if (isset($obj->project_xlDir)) unset($obj->project_xlDir);
                
                $humanStr = array();
                //'technology','year','companies','team'
                if (isset($obj->project_devtools)) {
                    $tags = explode(',',$obj->project_devtools);
                    foreach($tags as $tag) {
                        $tag = trim($tag);
                        if (empty($tag)) continue;
                        array_push($humanStr, $tag);
                        $t = new StdClass();
                        $t->tag_type = 'technologies';
                        $t->tag_key = $tag;
                        if (isset($obj->project_launchdate) && !empty($obj->project_launchdate))  $t->tag_date = $obj->project_launchdate;
                        elseif (isset($obj->project_startdate) && !empty($obj->project_startdate))  $t->tag_date = $obj->project_startdate;
                        $t->project_id = $pid;
                        $this->projects->insertTag($t);
                    }
                    $obj->project_devtools = implode(', ', $humanStr); 
                }
                
                $humanStr = array();
                if (isset($obj->project_copyright)) {
                    $tags = explode(',',$obj->project_copyright);
                    foreach($tags as $tag) {
                        $tag = trim($tag);
                        if (empty($tag)) return true;
                        array_push($humanStr, $tag);
                        $t = new StdClass();
                        $t->tag_type = 'companies';
                        $t->tag_key = $tag;
                        if (isset($obj->project_launchdate) && !empty($obj->project_launchdate))  $t->tag_date = $obj->project_launchdate;
                        elseif (isset($obj->project_startdate) && !empty($obj->project_startdate))  $t->tag_date = $obj->project_startdate;
                        $t->project_id = $pid;
                        $this->projects->insertTag($t);
                    }
                }
                
                if (isset($obj->project_client)) {
                    $tags = explode(',',$obj->project_client);
                    foreach($tags as $tag) {
                        $tag = trim($tag);
                        if (empty($tag)) return true;
                        array_push($humanStr, $tag);
                        $t = new StdClass();
                        $t->tag_type = 'companies';
                        $t->tag_key = $tag;
                        if (isset($obj->project_launchdate) && !empty($obj->project_launchdate))  $t->tag_date = $obj->project_launchdate;
                        elseif (isset($obj->project_startdate) && !empty($obj->project_startdate))  $t->tag_date = $obj->project_startdate;
                        $t->project_id = $pid;
                        $this->projects->insertTag($t);
                    }
                    $obj->project_companies = implode(', ', $humanStr); 
                }
                
                $humanStr = array();
                if (isset($obj->project_industries)) {
                    $tags = explode(',',$obj->project_industries);
                    foreach($tags as $tag) {
                        $tag = trim($tag);
                        if (empty($tag)) return true;
                        array_push($humanStr, $tag);
                        $t = new StdClass();
                        $t->tag_type = 'industries';
                        $t->tag_key = $tag;
                        if (isset($obj->project_launchdate) && !empty($obj->project_launchdate))  $t->tag_date = $obj->project_launchdate;
                        elseif (isset($obj->project_startdate) && !empty($obj->project_startdate))  $t->tag_date = $obj->project_startdate;
                        $t->project_id = $pid;
                        $this->projects->insertTag($t);
                    }
                    $obj->project_industries = implode(', ', $humanStr); 
                }                
                
                $humanStr = array();
                if (isset($obj->project_team) && !empty($obj->project_team)) {
                    $role_users = explode(';',$obj->project_team);
                    foreach($role_users as $role_user) {
                        $role_user = explode(':',$role_user);
                        $users = explode(',',$role_user[1]);
                        foreach($users as $user) {
                            $humanStr[$user] = (!isset($humanStr[$user])) ? $user . ': ' . $role_user[0] : $humanStr[$user] . ', ' . $role_user[0];
                            $t = new StdClass();
                            $t->tag_type = 'team_' . strtolower($role_user[0]);
                            $t->tag_key = $user;
                            if (isset($obj->project_launchdate) && !empty($obj->project_launchdate))  $t->tag_date = $obj->project_launchdate;
                            elseif (isset($obj->project_startdate) && !empty($obj->project_startdate))  $t->tag_date = $obj->project_startdate;
                            $t->project_id = $pid;
                            $this->projects->insertTag($t);
                        }                        
                    }
                    if (!empty($humanStr)) $obj->project_team = implode('. ', array_values($humanStr));
                }       
                
                
                // industry: art,health,commerce,education,analytics                
                $max = (isset($obj->project_launchyear)) ? (int)$obj->project_launchyear : (int)$obj->project_startyear;
                for($i=(int)$obj->project_startyear; $i <= $max; $i++) {
                    $t = new StdClass();
                    $t->tag_type = 'years';
                    $t->tag_key = $i;
                    $t->tag_date = $obj->project_startdate;
                    $t->project_id = $pid;
                    $this->projects->insertTag($t);                    
                }
                
                $test = $this->projects->insertProject($obj); 

                if ($test > 0){
                    //echo "<h1>SUCCESS</h1>";
                } else {
                    echo "<h1>FAILED</h1>";
                }

                var_dump($obj);                
                
            }

            
        }
    }   

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */