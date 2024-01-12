<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class UpworkJobReader extends CI_Controller
{

    public function fetchAndNotify()
    {
        $this->load->model('UpworkJobModel');
        $newJobs = $this->UpworkJobModel->fetchAndCompare($this->input->get_post('linkId'));
        return $this->sendEmail($newJobs);
    }

    public function showDifferences()
    {
        $this->load->model('UpworkJobModel');
        $newJobs = $this->UpworkJobModel->fetchAndCompare($this->input->get_post('linkId'));
        $this->load->view('upworkjobs', ['newJobs'=>$newJobs]);
    }


    private function sendEmail($newJobs)
    {
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.ionos.com';
        $config['smtp_user'] = 'jobs@taylormadetraffic.com';
        $config['smtp_pass'] = $this->config->item('smtp_pass');
        $config['smtp_port'] = 587;
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';

        $this->email->initialize($config);

        $this->email->from('jobs@taylormadetraffic.com', 'Jobs Alert');
        $this->email->to('eli@taylormadetraffic.com');
        $this->email->subject('TMT new upwork jobs');

        $emailContent = $this->load->view('upworkjobs', ['newJobs' => $newJobs], TRUE);

        $this->email->message($emailContent);

        if ($this->email->send()) {
            echo '<h1>Email sent successfully</h1>' . $emailContent;
        } else {
            echo 'Error: ' . $this->email->print_debugger();
        }
    }
}
