<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class UpworkJobReader extends CI_Controller {


    public function fetchAndNotify()
    {
        $this->load->model('UpworkJobModel');

        try {
            $newJobs = $this->UpworkJobModel->fetchAndCompare($this->input->get_post('linkId'));

            if (!empty($newJobs)) {
                foreach ($newJobs as $newJob) {
                    $this->sendEmail($newJob['title'], $newJob['link']);
                    echo "Email sent for job: {$newJob['title']}\n";
                }
            }

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }

    public function showDifferences()
    {
        $this->load->model('UpworkJobModel');

        try {
            $newJobs = $this->UpworkJobModel->fetchAndCompare($this->input->get_post('linkId'));

            $data['newJobs'] = $newJobs;
            $this->load->view('upworkjobs', $data);

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }


    private function sendEmail($jobTitle, $jobLink)
    {
        // Implement email sending logic here
        // You can use CodeIgniter's Email library or any other method you prefer
        // Example: $this->email->send();
    }
}
