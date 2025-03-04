<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller
{

    private $data = array("docTitle" => "", "pages" => array(), "me" => array(), 'errors' => array());

    function __construct()
    {
        parent::__construct();
        $this->load->model('Projects_model', 'projects');
        $this->data['me'] = $this->thisvisitor->getVisitor();
        $this->setGlobals();
    }

    function _remap()
    {
        $this->data['qmenu'] = array(
            "" => array("role" => 0, 'icon' => '', "title" => $this->lang->en("Technologies")),
            "settings" => array("role" => 0, 'icon' => '', "title" => $this->lang->en("Settings")),

            "biz" => array("role" => 0, 'icon' => '', "title" => $this->lang->en("Product Deck")),
            "deck" => array("role" => 0, 'icon' => '', "title" => $this->lang->en("Product Deck")),

            "industries" => array("role" => -1, 'icon' => '', "title" => $this->lang->en("Industries")),
            "technologies" => array("role" => -1, 'icon' => '', "title" => $this->lang->en("Technologies")),
            "companies" => array("role" => -1, 'icon' => '', "title" => $this->lang->en("Companies")),
            "years" => array("role" => -1, 'icon' => '', "title" => $this->lang->en("Years")),

            "taylormade" => array("role" => 0, 'icon' => '', "title" => "TaylorMade"),
            "taylormade/development" => array("role" => 0, 'icon' => '', "title" => "TaylorMade " . $this->lang->en("Development")),
            "eli" => array("role" => 0, 'icon' => '', "title" => $this->lang->en("Eli")),
            "eli/cv" => array("role" => 0, 'icon' => '', "title" => $this->lang->en("CV")),
            "saman" => array("role" => 0, 'icon' => '', "title" => $this->lang->en("Saman")),

            "projects" => array("role" => 0, 'icon' => '', "title" => $this->lang->en("Projects")),

            "team" => array("role" => 0, 'icon' => '', "title" => $this->lang->en("Team")),
            "roles" => array("role" => 0, 'icon' => '', "title" => $this->lang->en("Roles")),

            "devices" => array("role" => 0, 'icon' => '', "title" => "Test Devices"),
        );

        $path = uri_string();
        if (empty($path)) return $this->animatedIntro();

        if (isset($this->data['qmenu'][$path]) && $this->data['qmenu'][$path]['role'] > 0 && !$this->thisvisitor->auth($this->data['qmenu'][$path]['role'])) {
            array_push($this->data['errors'], $this->lang->en("unauthorized"));
            $this->data['docTitle'] = $this->lang->en("Login");
            return $this->sendOut('loginForm');
        }
        $routing = $this->uri->rsegment_array();
        $method = (count($routing) > 1) ? $routing["2"] : 'technologies';
        if (!method_exists($this, $method)) $method = 'technologies';

        if (isset($this->data['qmenu'][$path])) $this->data['docTitle'] = $this->data['qmenu'][$path]['title'];
        if (!empty($this->data['qtfilter'])) $this->data['docTitle'] .= ' :: ' . $this->data['qtfilter'];
        call_user_func_array(array($this, $method), array());
    }

    private function setGlobals()
    {
        $this->data['qtags'] = $this->input->get_post('qtags');
        if (empty($this->data['qtags'])) $this->data['qtags'] = $this->uri->segment(1);
        if (empty($this->data['qtags'])) $this->data['qtags'] = 'technologies';

        $this->data['qtfilter'] = $this->input->get_post('qtfilter');

        $this->data['qgroup'] = $this->input->get_post('qgroup');
        if (empty($this->data['qgroup'])) $this->data['qgroup'] = $this->uri->segment(3);
        if (empty($this->data['qgroup'])) $this->data['qgroup'] = 'project_client';

        $this->data['qgroup'] = preg_replace('/\s/', '', $this->data['qgroup']);

        $this->data['qhaving'] = (int)$this->input->get_post('qhaving');
        if (empty($this->data['qhaving'])) $this->data['qhaving'] = (int)$this->uri->segment(4);
    }

    private function sendOut($page, $shell = "shell")
    {

        if ($page == $shell) {
            // do nothing
        } elseif (is_string($page)) {
            $this->data['pages'][$page] = $this->load->view($page, $this->data, TRUE);
        } else {
            array_push($this->data['pages'], $page);
        }

        if (isset($this->data['uProfile']) && !empty($this->data['uProfile'])) {
            if ($this->data['uProfile']['user_email'] === 'eli@taylormadetraffic.com') {
                if (isset($_GET['cover'])) {
                    array_unshift($this->data['pages'], $this->load->view('letterhead_bg', $this->data, TRUE));
                    array_unshift($this->data['pages'], $this->load->view('user_header', $this->data, TRUE));
                    array_unshift($this->data['pages'], $this->load->view('cv_cover', $this->data, TRUE));

                } elseif (isset($_GET['bio']) || !isset($_GET['cv'])) {
                    array_unshift($this->data['pages'], $this->load->view('user_profile', $this->data, TRUE));
                } else {
                    array_unshift($this->data['pages'], $this->load->view('letterhead_bg', $this->data, TRUE));
                    array_unshift($this->data['pages'], $this->load->view('user_header', $this->data, TRUE));
                }
                if (isset($_GET['education'])) {
                    $this->data['pages'][] = $this->load->view('user_education', $this->data, TRUE);
                }
            } else if (!isset($_GET['cv'])) {
                array_unshift($this->data['pages'], $this->load->view('user_profile', $this->data, TRUE));
                array_push($this->data['pages'], $this->load->view('tag_selector', $this->data, TRUE));
            }
        } else if (isset($this->data['cProfile']) && !empty($this->data['cProfile'])) {
            array_unshift($this->data['pages'], $this->load->view('company_profile', $this->data, TRUE));
        } elseif (isset($this->data['projects_count']) && !empty($this->data['projects_count'])) {
            array_unshift($this->data['pages'], $this->load->view('projects_table_meta_header', $this->data, TRUE));
        }

        if ($this->input->is_ajax_request()) {
            return $this->output->set_output($this->load->view('shell_pages', $this->data, TRUE));
        }

        if (isset($_GET['cv'])) $shell = "cv_format";
        $this->load->view($shell, $this->data);
    }


    function error404()
    {
        $this->data['docTitle'] = $this->lang->en("Page Not Found");
        $this->industries();
    }

    private function animatedIntro()
    {
        if ($this->input->is_ajax_request()) {
            return $this->industries();
        }
        $this->getTableForTags();
        $this->sendOut('tags_table');
    }

    // tag list views
    public function technologies()
    {
        $this->data['qtags'] = 'technologies';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table');
        } else {
            $this->getTableForProjects();

            if (isset($_GET['cv'])) {
                $this->load->model('Users_model', 'user');

                array_unshift($this->data['pages'], $this->load->view('tag_story', $this->data, TRUE));

                $this->data['uProfile'] = $this->users->getUserByName('E.A.Taylor');

            }

            $this->sendOut('projects_table');
        }
    }

    public function years()
    {
        $this->data['qtags'] = 'years';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table');
        } else {
            $this->getTableForProjects();
            $this->sendOut('projects_table');
        }
    }

    public function industries()
    {
        $this->data['qtags'] = 'industries';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table');
        } else {
            $this->getTableForProjects();
            $this->sendOut('projects_table');
        }
    }

    public function companies()
    {
        $this->data['qtags'] = 'companies';
        if (empty($this->data['qtfilter'])) {
            $this->getTableForTags();
            $this->sendOut('tags_table');
        } else {
            $this->data['cProfile'] = $this->users->getCompanyByName($this->data['qtfilter']);
            if (empty($this->data['cProfile'])) unset($this->data['cProfile']);
            $this->getTableForProjects();
            $this->sendOut('projects_table');
        }
    }

    public function team()
    {

        if (empty($this->data['qtfilter'])) {
            $this->data['headers'] = array(
                'count' => $this->lang->en("Total"),
                'tag_key' => $this->data['docTitle'],
                'tag_date' => $this->lang->en("Last Connect")
            );
            if ($this->data['qtags'] == "roles") $this->data['tableRows'] = $this->projects->getTagsTeamRoles();
            else $this->data['tableRows'] = $this->projects->getTagsTeamMembers();
            $this->sendOut('tags_table');
        } else {


            if ($this->data['qtags'] == "roles") $this->data['qtagOptions'] = $this->projects->getTagsTeamRoles();
            else $this->data['qtagOptions'] = $this->projects->getTagsTeamMembers();

            if ($this->data['qtags'] == "roles") {
                $this->data['tableRows'] = $this->projects->getTagsTeamRoles($this->data['qtfilter']);
            } else {
                $this->data['tableRows'] = $this->projects->getProjectsByTag($this->data['qtags'], $this->data['qtfilter'], $this->data['qhaving'], $this->data['qgroup']);
            }


            $this->regroupProjects();

            if (isset($_GET['intro'])) {
                array_unshift($this->data['pages'], $this->load->view('cv_intro', $this->data, TRUE));
            }

            $this->load->model('Users_model', 'user');
            $this->data['uProfile'] = $this->users->getUserByName($this->data['qtfilter']);
            $this->sendOut('projects_table');
        }
    }

    private function regroupProjects()
    {
        $groups = array();

        if ($this->data['qgroup'] !== 'project_title' && $this->uri->segment(1) === 'eli') {
            $this->data['showGroup'] = true;
        } else {
            $this->data['showGroup'] = false;
        }


        $this->data['projects_count'] = 0;
        foreach ($this->data['tableRows'] as $index => &$row) {
            $row->images = $this->projects->getProjectImages($row->project_id);
            $row->totalImages = count($row->images);
            if (!empty($row->images)) {
                $row = (object)array_merge((array)$row, (array)$row->images[0]); // since queries suck
            }
            $this->data['projects_count']++;

            if (empty($row->project_startdate)) $row->project_startdate = date('Y-m-d');
            // if (empty($row->project_launchdate)) $row->project_launchdate = $row->project_startdate;

            $minYear = $this->input->get_post('year_min');
            if ($minYear && intval($minYear)) {
                if (intval($minYear) > intval($row->project_launchyear)) {
                    continue;
                }
            }

            $companyName = $row->{$this->data['qgroup']};
            $companyGroup = $companyName;
            if ($this->data['qgroup'] === 'project_title') {
                $companyName = $row->project_client;
                $companyGroup = $row->project_id;
            }
            if (!isset($groups[$companyGroup])) {
                $company = $this->users->getCompanyByName($companyName);
                $company['startDate'] = (isset($company['company_startdate']) && !empty($company['company_startdate'])) ?
                    strtotime($company['company_startdate']) :
                    strtotime($row->project_startdate);
                $company['endDate'] = (isset($company['company_enddate']) && !empty($company['company_enddate'])) ?
                    strtotime($company['company_enddate']) :
                    time();
                $company['projects'] = array();
                $groups[$companyGroup] = $company;
            } else {
                $company = $groups[$companyGroup];
            }
            $company['startDate'] = min($company['startDate'], strtotime($row->project_startdate));
            if ($this->data['showGroup'] === false && isset($_GET['cv'])) {
                $row = (object)array_merge((array)$row, (array)$company);
                unset($row->projects);
            }
            array_push($groups[$companyGroup]['projects'], $row);
        }

        if (count($groups) > 0 && $this->data['showGroup'] === true) {
            usort($groups, function ($a, $b) {

                $diffa = $a['endDate'] - $a['startDate'];
                $diffb = $b['endDate'] - $b['startDate'];

                if ($diffa > 31556926 * 2 && $diffb > 31556926 * 2) {
                    // return $a['endDate'] > $b['endDate'] ? 1 : -1;
                    return $diffa > $diffb ? -1 : 1;
                }
                /*
                if ($diffa > 31556926 * 2) {
                    return -1;
                }
                if ($diffb > 31556926 * 2) {
                   return 1;
                }
                */

                return $a['endDate'] > $b['endDate'] ? -1 : 1;
            });

        }

        $this->data['groups'] = $groups;
    }

    public function certbot()
    {
        die('AokEJYwWYMEzWsLb_V8FTOMJ2H-CbJRjxqflxt_m-L4.5HgURcqD_GgzIOxgwT0BxhvPd3KERWoPqZUqCU0CKMk');
    }

    // just URL predefines qtags
    public function taylormade()
    {
        $this->data['qtfilter'] = 'Taylor Made Traffic';
        $this->data['qtags'] = 'companies';
        $this->data['qgroup'] = 'project_title';

        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags'], $this->data['qtfilter'], $this->data['qhaving']);
        $this->data['tableRows'] = $this->projects->getProjectsByTag($this->data['qtags'], $this->data['qtfilter'], $this->data['qhaving']);
        $this->data['cProfile'] = $this->users->getCompanyByName($this->data['qtfilter']);

        $this->getTableForProjects();
        $this->regroupProjects();

        $this->sendOut('projects_table');
    }


    public function pitch()
    {
        $this->data['qtags'] = 'companies';
        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags']);
        $this->data['qtfilter'] = 'Taylor Made Traffic';
        $this->data['cProfile'] = $this->users->getCompanyByName("TaylorMadeManagement");

        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags']);
        $this->data['headers'] = array('image_src' => $this->lang->en("Pics"));
        if ($this->data['me']['con']['swidth'] > 600) $this->data['headers']['project_title'] = $this->lang->en("Info");

        $this->data['tableRows'] = $this->projects->getProjectsByType('development', $this->data['qtfilter']);
        foreach ($this->data['tableRows'] as $index => $row) {
            $row->images = $this->projects->getProjectImages($row->project_id);
            $row->totalImages = count($row->images);
        }
        $this->sendOut('biz_projects');
    }

    public function eli()
    {
        if (empty($this->data['qtfilter'])) {
            $this->data['qtags'] = 'team';
            $this->data['qtfilter'] = 'E.A.Taylor';
        } else {
            $this->data['qtags'] = 'technologies';
        }
        // $this->data['qgroup'] = 'project_client';
        //$this->data['qhaving'] = 2
        $this->team();
    }

    public function saman()
    {
        $this->data['qtags'] = 'team';
        $this->data['qtfilter'] = 'Samanta Amna Khalil';
        // $this->data['qgroup'] = 'project_client';

        // $con = [];
        // $con['pstyle'] = 'pWhite';
        // $this->thisvisitor->upConstants($con);
        // $this->data['me'] = $this->thisvisitor->getVisitor(false);

        $this->team();
    }

    public function projects()
    {
        $pid = $this->input->get_post('pid');
        if (empty($this->data['qtfilter']) && empty($pid)) {
            $this->getTableForProjects();
            $this->sendOut('projects_table');
        } else {
            $this->data['docTitle'] = $this->data['qtfilter'];
            $val = (empty($this->data['qtfilter'])) ? $pid : $this->data['qtfilter'];
            if (is_numeric($val)) {
                $this->data['project'] = $this->projects->getProject($val);
                if (empty($this->data['project'])) die('invalid project id');
                $this->data['project']->images = $this->projects->getProjectImages($this->data['project']->project_id);
                $this->sendOut('project_profile');
            } else {
                $this->getTableForProjects();
                $this->sendOut('projects_table');
            }
        }
    }

    public function projects_list()
    {
        $this->getTableForProjects();
        if (isset($_GET['intro'])) {
            array_unshift($this->data['pages'], $this->load->view('cv_intro', $this->data, TRUE));
        }
        if (isset($_GET['cv'])) {

            $this->load->model('Users_model', 'user');
            array_unshift($this->data['pages'], $this->load->view('tag_story', $this->data, TRUE));
            $this->data['uProfile'] = $this->users->getUserByName('E.A.Taylor');

        }
        $this->sendOut('projects_table');
    }

    private function images()
    {
        $this->data['headers'] = array();
        $this->data['tableRows'] = $this->projects->getImages();
        $head = $this->projects->getTableHeaders('images');
        array_unshift($head, 'project_id');
        array_unshift($head, 'project_title');
        foreach ($head as $h) {
            $this->data['headers'][$h] = (strpos($h, 'image_') === 0) ? substr($h, strlen('image_')) : $h;
        }
        $this->sendOut('cms_table');
    }

    private function getTableForTags()
    {
        $this->data['headers'] = array(
            'count' => $this->lang->en("Total"),
            'tag_key' => $this->data['docTitle']
        );

        $this->data['headers']['tag_date'] = '-'; // years
        if ($this->data['qtags'] === 'technologies') {
            $this->data['headers']['tag_date'] = $this->lang->en("Last Tagged");
        } else if ($this->data['qtags'] === 'companies' || $this->data['qtags'] === 'industries') {
            $this->data['headers']['tag_date'] = $this->lang->en("Last Project");
        }

        $this->data['tableRows'] = $this->projects->getTags($this->data['qtags'], $this->data['qtfilter'], $this->data['qhaving']);

    }

    private function getTableForProjects()
    {
        $this->data['qtagOptions'] = $this->projects->getTags($this->data['qtags'], false, $this->data['qhaving']);
        $this->data['headers'] = array('image_src' => $this->lang->en("Pics"));
        $this->data['headers']['project_title'] = $this->lang->en("Info");
        $this->data['headers']['project_startdate'] = $this->lang->en("Tags");

        $seg = $this->uri->segment(2);
        if ($seg == 'development' || $seg == 'design') $this->data['tableRows'] = $this->projects->getProjectsByType($seg);
        else if ($this->input->get_post('pids')) {
            $pids = explode(',', $this->input->get_post('pids'));
            $this->data['tableRows'] = $this->projects->getProjectsByIds($pids);
        } else $this->data['tableRows'] = $this->projects->getProjectsByTag($this->data['qtags'], $this->data['qtfilter'], $this->data['qhaving']);

        $this->regroupProjects();
    }

    private function viewSettings()
    {
        $con = $this->data['me']['con'];
        if ($this->input->get("swidth")) $con['swidth'] = intval($this->input->get("swidth"));
        if ($this->input->get("sheight")) $con['sheight'] = intval($this->input->get("sheight"));
        if ($this->input->get_post('debug')) $con['debugMode'] = (boolean)$this->input->get_post('debug');
        $this->thisvisitor->upConstants($con);
        $this->thisvisitor->saveSession();
        return false;
    }

    private function devices()
    {
        $this->sendOut('stylesheet', 'cms_shell');
    }


    private function rewriteTeam()
    {

    }

    public function proservice_annotation()
    {
        $this->sendOut('proservice_annotation');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
