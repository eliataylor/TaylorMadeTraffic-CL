<?php

class LenguaPlusController extends CI_Controller {

    private $data = array("pages"=>array(), "me"=>array(), 'errors'=>array());

    function __construct() {
        parent::__construct();
        $this->data['me'] = $this->thisvisitor->getVisitor();
        $this->setGlobals();
    }

    // TODO: remove method!!! not sure if you can access that part of routing
    function _remap() {
        $security = array(
            "lenguaplus/changelanguage"=>array("role"=>0,"title"=>$this->lang->en("Update"),"method"=>"changelanguage"),
            "lenguaplus/login"=>array("role"=>0,"title"=>$this->lang->en("Login"),"method"=>"login"),
            //"lenguaplus/populateFromStatic"=>array("role"=>0,"title"=>$this->lang->en("Login"),"method"=>"populateFromStatic"),
            "lenguaplus/tutorial"=>array("role"=>0,"title"=>$this->lang->en("Tutorial"),"method"=>"tutorial"),
            "lenguaplus/myprofile"=>array("role"=>2,"title"=>$this->lang->en("Update"),"method"=>"myprofile"),
            "lenguaplus/authors"=>array("role"=>2,"title"=>$this->lang->en("Update"),"method"=>"authors"),
            "lenguaplus/logout"=>array("role"=>2,"title"=>$this->lang->en("Logout"),"method"=>"logout"),
            "lenguaplus/update"=>array("role"=>3,"title"=>$this->lang->en("Update"),"method"=>"updateLangByKey"),
            "lenguaplus/publish"=>array("role"=>3,"title"=>$this->lang->en("Publish"),"method"=>"publish"),
            "lenguaplus/import" => array("role" => 3, 'icon'=>'', "title" => $this->lang->en("import"), "method"=>'importXML'),
            "lenguaplus/update-images" => array("role" => 3, 'icon'=>'', "title" => $this->lang->en("Images from Dir"), "method"=>'runUpdate'),

            "lenguaplus"=>array("role"=>2,"title"=>$this->lang->en("Language"),"method"=>"debug")
        );

        $path = uri_string();
        if (!isset($security[$path])) {
            array_push($this->data['errors'], $this->lang->en("Page Not Found"));
        } elseif ($security[$path]['role'] < 1){
            /* INSECURE PAGE. Do NOTHING */
        } elseif (!$this->thisvisitor->auth($security[$path]['role'])) {
            array_push($this->data['errors'], $this->lang->en("unauthorized"));
        }
        if (count($this->data['errors']) > 0) {
            $this->data['docTitle'] = $this->lang->en("error");
            return $this->sendOut('loginForm');
        }
        $this->data['docTitle'] = $security[$path]['title'];
        call_user_func_array(array($this, $security[$path]['method']), array());
    }

     private function setGlobals() {
        $this->data['qparams']['from'] = $this->input->get_post('from');
        $this->data['qparams']['want'] = $this->input->get_post('want');
        $this->data['qparams']['status'] = $this->input->get_post('status');
        $this->data['qparams']['likeUrl'] = $this->input->get_post('likeUrl');
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
        $this->LenguaPlus_model->setCount(true);
        $this->data['totalTexts'] = $this->LenguaPlus_model->getLanguageByFilters(
                $this->data['qparams']['status'],
                $this->data['qparams']['type'],
                $this->data['qparams']['likeUrl'],
                $this->data['qparams']['groupby'],
                $this->data['qparams']['from'],
                $this->data['qparams']['want']);
        $this->LenguaPlus_model->setCount(false);
        $this->data['texts'] = $this->LenguaPlus_model->getLanguageByFilters(
                $this->data['qparams']['status'],
                $this->data['qparams']['type'],
                $this->data['qparams']['likeUrl'],
                $this->data['qparams']['groupby'],
                $this->data['qparams']['from'],
                $this->data['qparams']['want']);
        $this->data['headers'] = array();

        $this->data['headers'] = array(
            "langtracker_status"=>$this->lang->en("Status"),
            //"langtracker_language"=>$this->lang->en("Language"),
            "langtracker_key"=>"Key",
            "langtracker_es"=>$this->lang->en("espaÃ±ol"),
            "langtracker_en"=>$this->lang->en("english"),
            //"langtracker_file"=>$this->lang->en("File"),
            //"langtracker_linenum"=>$this->lang->en("Line"),
            "langtracker_urls"=>$this->lang->en("URL"),
            //"langtracker_added"=>$this->lang->en("Added"),
            );

        if ($this->data['me']['con']['swidth'] > 940) {
            $this->data['headers']["langtracker_updated"] = $this->lang->en("Updated");
        }
        return $this->sendOut("language_table");
    }

    function tutorial(){
        return $this->sendOut("lenguaplus_tutorial");
    }

    function populateFromStatic(){
        include(APPPATH .'language/es/langplus_ugc_lang.php');
        $updated = 0;
        $inserted = array();
        foreach($lang as $key=>$es) {
            $lData = $this->LenguaPlus_model->getLanguageByKey($key); // any status!
            if (!empty($lData)) {
                $obj = array('langtracker_es' => $es, 'langtracker_status' => "live");
                $updated += $this->LenguaPlus_model->updateLangByKey($obj, $key);
            } else {
                $lData = array();
                $lData['langtracker_linenum'] = -1;
                $lData['langtracker_type'] = 'msg';
                $lData['langtracker_file'] = '';
                $lData['langtracker_key'] = $key;
                $lData['langtracker_es'] = $es;
                $lData['langtracker_added'] = time();
                $lData['langtracker_host'] = $_SERVER['HTTP_HOST'];
                $lData['langtracker_language'] = 'es';
                $lData['langtracker_url'] = '';
                $lData['langtracker_status'] = "live";
                //array_push($inserted, $this->LenguaPlus_model->trackLang($lData));
            }
        }
        echo "<h1>Inserted: ".print_r($inserted,TRUE)."</h1>";
        echo "<h1>Updated: ".$updated."</h1>";
    }

    function publish() {
        $languages = $this->config->item('languages');

        $types = $this->data['qparams']['type'];
        if (!$types || !in_array($type, array('msg','ugc','msg,ugc')))
            $types = 'msg,ugc';
        $types = explode(',', $types);
        $final = array();
        foreach($types as $type) {

            $fileRows = array(); // all lanuages of ugc OR msg data
            //$dbRows = $this->LenguaPlus_model->getLanguageByFilters($this->config->item('status_2_watch'), 'key', $type);
            $dbRows = $this->LenguaPlus_model->getLanguageByFilters(
                $this->config->item('status_2_watch'),
                $this->data['qparams']['type'],
                null,
                null,
                $this->data['qparams']['from'],
                30000000);

            foreach($dbRows as $row) {
                foreach($languages as $langCode=>$langLabel) { // usually just ÃƒÂ©s,en
                    if (!isset($fileRows[$langCode])) $fileRows[$langCode] =  array();
                    $langCol = 'langtracker_'.$langCode;
                    if (empty($row->$langCol) || ($row->$langCol === $row->langtracker_key))
                        continue;

                    if ($type == 'ugc' && strlen($row->langtracker_key) > 50) {
                        $dir = APPPATH .'language/ugc/';
                        if (!is_dir($dir)) die('invalid directory');
                        $filename = 'lang_' . $row->langtracker_id . '_' . $langCode.'.txt';
                        file_put_contents($dir . $filename, $row->$langCol); // just a text file
                        $lineItem = array('key'=>$row->langtracker_key, 'val'=>$dir.$filename);
                    } else {
                        $lineItem = array('key'=>$row->langtracker_key, 'val'=>$row->$langCol);
                    }
                    array_push($fileRows[$langCode], $lineItem);
                }
            }

            foreach($languages as $langCode=>$langLabel) { // todo: could be done with 1 loop above
                if (!empty($fileRows[$langCode])) {
                    $dir = ROOT_CD . '/application/language/'. $langCode . '/';
                    if (!is_dir($dir)) die('invalid directory 2');
                    $filename = 'langplus_' . $type . '_lang.php';
                    $arrStr = '';
                    foreach($fileRows[$langCode] as $key=>$val) {
                        $arrStr .= "\$lang['".str_replace('\'', '\\\'', $val['key'])."'] = '" . str_replace('\'', '\\\'', $val['val']) . "'; ";
                    }
                    array_push($final, $fileRows);
                    //echo "<h1>".$dir . $filename."</h1>" . $arrStr;
                    file_put_contents($dir . $filename, '<?php ' . $arrStr);
                }
            }
        }
        if ($this->input->is_ajax_request()) {
            return $this->output->set_output(json_encode(array('msg'=>$this->lang->en('success'))));
        } else {
            $this->output->set_output(json_encode($final));
        }

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
            if (empty($data['langtracker_'.$lang])) $data['langtracker_'.$lang] = NULL;
       }

       $line = $this->LenguaPlus_model->getLanguageById($langId); // some keys are huge UGC strings. i'd rather not send those in the post
       if ($line) {
           $data['langtracker_status'] = $this->input->get_post('statusChange'); // overwrite
            if (!in_array($data['langtracker_status'], array('debug','edited','live','deleted','propername'))) // security check
                $data['langtracker_status'] = 'edited';
           $test = $this->LenguaPlus_model->updateLangByKey($data, $line->langtracker_key);
       } else {
           $resp['errors'] = array($this->lang->en('Invalid URL'));
       }

       if ($test == -1) $resp['msg'] = $this->lang->en('Update Failed');
       elseif ($test == 0) $resp['msg'] = $this->lang->en('Nothing Changed');
       else $resp['msg'] = $this->lang->en('Updated') . ' ' . $test . ' ' . (($test > 1) ?  $this->lang->en('rows') : $this->lang->en('row'));
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
            return redirect(TMT_HTTP.'lenguaplus', 'location', 301); // SUCCESS
        }
        $this->data['user_email'] = $this->input->post("user_email", false); // populate form
        $this->sendOut("loginForm");
    }

    function logout() {
        $this->thisvisitor->clear(); // this is resetting group id
        redirect(TMT_HTTP, 'location', 301);
    }

    public function updateProjectFromLanguage($pid) {

    }

    public function runUpdate() {
      // http://localhost.taylormadetraffic.com/lenguaplus/update-images?pid=52
    	// http://localhost.taylormadetraffic.com/lenguaplus/update-images?pid=40&dir=/wwwroot/images/sites/blingby
    	$pid = $this->input->get_post('pid');
    	$dir = $this->input->get_post('dir');
    	$count = 0;
    	if (!empty($pid) && !empty($dir)) {
    		$count = $this->updateProjectImages($pid, $dir);
        	return $this->output->set_output($count . ' updated');
    	} else if (!empty($pid)) {
    		// http://localhost.taylormadetraffic.com/lenguaplus/update-images?pid=40
    		$obj = $this->projects->getProjectById($pid);
    		if (!empty($obj)) $obj = $this->updateProjectTags($pid, $obj);
        $this->output->set_content_type('text/javascript');
        return $this->output->set_output(json_encode($obj));
    	}
    	return $this->output->set_output('invalid');
    }



    function cleanExt($ext) {
      $qpos = strpos($ext, "?");
      if ($qpos!==false) $ext = substr($ext, 0, $qpos);
      return $ext;
    }
    function abstractName($str, $directory, $overwrite=true){
      $ext = $this->cleanExt(pathinfo($str, PATHINFO_EXTENSION));
      $filename = preg_replace('/[^\w-]/', '', strtolower($str)); // allows accented alpha characters
      if ($overwrite === FALSE) {
        $index = 1;  // WARN: breaks cachable opportunity!
        $basename = $directory.'/'.$str;
        $filename = $basename;
        if (!empty($ext)) {
          $filename .= "." . $ext;
        }
        while(file_exists($filename)) {
          $filename .= $basename. "__".$index;
          if (!empty($ext)) {
            $filename .= "." . $ext;
          }
        }
      }
      return $filename;
    }


    private function updateProjectImages($pid, $dir) {
    	$files1 = scandir(ROOT_CD . $dir);
    	$index = 0;
    	foreach($files1 as $img) {
    		if($img === '.' || $img === '..' || strpos($img, '.db') > -1 || strpos($img, '.DS') > -1 || strpos(strtolower($img), '.swf') > 0 ||
    				strpos($img, '_150x150') > -1 ||
    				strpos($img, '_300x300') > -1) continue;

            if (strpos($img, ' ') > -1) {
              $newname = str_replace(' ', '_', strtolower($img)); // DO THIS right
              $newname = str_replace('.', '_', strtolower($newname));
              $newname = str_replace('_png', '.png', strtolower($newname)); // doesn't handle jpg
              rename (ROOT_CD.$dir.'/'.$img, ROOT_CD.$dir.'/'.$newname);
              $img = $newname;
            }

    				$filename = $dir."/".$img;
//     				echo '<h1>' . $filename . '</h1>';
//     				echo '<h3>' . $img . '</h3>';
    				$indb = $this->projects->fileSrcExists($filename);
    				if(!is_file(ROOT_CD .$filename) && $indb) {
    					// delete from db
    				} else if(is_file(ROOT_CD .$filename) && !$indb) {
    					$meta = getimagesize (ROOT_CD .$filename);
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
    	return $index;
    }

    private function updateProjectTags($pid, $obj) {
    	$humanStr = array();
    	//'technology','year','companies','team'
    	if (isset($obj->project_devtools)) {
    		$tags = explode(',',$obj->project_devtools);
    		foreach($tags as $tag) {
    			$tag = trim($tag);
    			if (empty($tag) || isset($humanStr[$tag])) continue;
    			$humanStr[$tag] = $tag;
    			if ($this->projects->hasTag($pid, $tag)) continue; // still keep in in humanStr
    			$t = new StdClass();
    			$t->tag_type = 'technologies';
    			$t->tag_key = $tag;
    			if (isset($obj->project_launchdate) && !empty($obj->project_launchdate))  $t->tag_date = $obj->project_launchdate;
    			elseif (isset($obj->project_startdate) && !empty($obj->project_startdate))  $t->tag_date = $obj->project_startdate;
    			$t->project_id = $pid;
    			$this->projects->insertTag($t);
    		}
    		$obj->project_devtools = implode(', ', $humanStr); // strips out empty strings
    	}

    	$humanStr = array();
    	$obj->project_companies = '';
    	if (isset($obj->project_copyright)) {
    		$tags = explode(',',$obj->project_copyright);
    		foreach($tags as $tag) {
    			$tag = trim($tag);
          if (empty($tag) || isset($humanStr[$tag])) continue;
    			$humanStr[$tag] = $tag;
    			$t = new StdClass();
    			$t->tag_type = 'companies';
    			$t->tag_key = $tag;
    			if (isset($obj->project_launchdate) && !empty($obj->project_launchdate))  $t->tag_date = $obj->project_launchdate;
    			elseif (isset($obj->project_startdate) && !empty($obj->project_startdate))  $t->tag_date = $obj->project_startdate;
    			$t->project_id = $pid;
    			$this->projects->insertTag($t);
    		}
    		$obj->project_companies .= implode(', ', $humanStr);
    	}

    	if (isset($obj->project_client)) {
    		$tags = explode(',',$obj->project_client);
    		foreach($tags as $tag) {
    			$tag = trim($tag);
          if (empty($tag) || isset($humanStr[$tag])) continue;
    			$humanStr[$tag] = $tag;
    			$t = new StdClass();
    			$t->tag_type = 'companies';
    			$t->tag_key = $tag;
    			if (isset($obj->project_launchdate) && !empty($obj->project_launchdate))  $t->tag_date = $obj->project_launchdate;
    			elseif (isset($obj->project_startdate) && !empty($obj->project_startdate))  $t->tag_date = $obj->project_startdate;
    			$t->project_id = $pid;
    			$this->projects->insertTag($t);
    		}
    		$obj->project_companies .= implode(', ', $humanStr);
    	}

    	$humanStr = array();
    	if (isset($obj->project_industries)) {
    		$tags = explode(',',$obj->project_industries);
    		foreach($tags as $tag) {
    			$tag = trim($tag);
          if (empty($tag) || isset($humanStr[$tag])) continue;
    			$humanStr[$tag] = $tag;
    			if ($this->projects->hasTag($pid, $tag)) continue; // still keep in in humanStr
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

      // WARN doesn't prevent duplicates
    	$humanStr = array();
    	if (isset($obj->project_team) && !empty($obj->project_team)) {
        $role_users = preg_split('/(?<=[.])\s+/', $obj->project_team, -1, PREG_SPLIT_NO_EMPTY);  // space is important since i use E.A.Taylor
    		foreach($role_users as $role_user) {
    			$role_user = explode(':',trim($role_user));
          $role_user[1] = trim($role_user[1]);
    			$roles = explode(',',$role_user[1]);
    			$user = trim($role_user[0]);
    			if (preg_match("/<a[^>]*>(.*)<\/a>/s", $user, $match)) {
    				$user = $match[1];
    			}
    			foreach($roles as $role) {
            $role = trim($role);
    				$href = "<a href='/team?qtfilter=" . $user . "'>".$user."</a>";
    				$humanStr[$user] = (!isset($humanStr[$user])) ? $href . ': ' . $role : $humanStr[$user] . ', ' . $role;
    				$t = new StdClass();
    				$t->tag_type = 'team_' . strtolower($role);
    				if ($this->projects->hasTag($pid, $t->tag_type)) continue; // still keep in in humanStr
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
    		if ($this->projects->hasTag($pid, $i)) continue; // still keep in in humanStr
    		$t->tag_date = $obj->project_startdate;
    		$t->project_id = $pid;
    		$this->projects->insertTag($t);
    	}

    	return $obj;
    }

    public function importXML() {
        die("DISABLED");
        $projects = $this->projects->getProjectsByTag();
        if (count($projects) > 0) die('first truncate');


        libxml_use_internal_errors(true);
        $xml = simplexml_load_file("wwwroot/folioXML.xml");

        foreach ($xml->children() as $child) {
            $project_type = $child->getName(); // obsolete difference only in xml
            foreach ($child->children() as $item) {
                $obj = new stdClass();

                $pid = $this->projects->next_id('projects');
                $obj->project_id = $pid;
                $obj->project_type = $project_type;

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
                    $this->updateProjectImages($pid, $dir);
                }

                if (isset($obj->project_thumbSrc)) unset($obj->project_thumbSrc);
                if (isset($obj->project_xlSrc)) unset($obj->project_xlSrc);
                if (isset($obj->project_thumbDir)) unset($obj->project_thumbDir);
                if (isset($obj->project_xlDir)) unset($obj->project_xlDir);

                $this->updateProjectTags($pid, $obj);

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
