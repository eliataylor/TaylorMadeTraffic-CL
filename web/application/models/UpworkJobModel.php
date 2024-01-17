<?php

// application/models/UpworkJobModel.php

defined('BASEPATH') or exit('No direct script access allowed');

class UpworkJobModel extends CI_Model
{

    protected $rssFilePath;

    public function __construct()
    {
        parent::__construct();
        $this->linkId = 'eli';
        $this->rssFilePath = APPPATH . 'cache/upwork_jobs.xml';
        $this->load->model('projects');
    }

    private function getLink($linkId)
    {
        if ($linkId === 'saman') {
            $this->linkId = 'saman';
            $link = 'https://www.upwork.com/ab/feed/jobs/rss?q=UX%2BDesign&budget=100-499%2C500-999%2C1000-4999%2C5000-&client_hires=1-9%2C10-&verified_payment_only=1&sort=recency&paging=0%3B10&api_params=1&securityToken=447e79e00224ad4e7afdebd4bb32657c53a4d2e0504394fd6c451199fe56894f03047e7611e8941c2c90d79464fe13ce70a96ab0795b737ae66033d6c6f2e8d1&userUid=750475063883165696&orgUid=820460219548565505';
            $this->rssFilePath = APPPATH . 'cache/upwork_sammie.xml';
        } else if ($linkId === 'eli-all') {
            $link = 'https://www.upwork.com/ab/feed/jobs/rss?category2_uid=531770282580668420%2C531770282580668419%2C531770282580668418&q=developer&job_type=hourly%2Cfixed&budget=500-&hourly_rate=100-&sort=recency&paging=0%3B10&api_params=1&securityToken=316c29312fae11998afcc79025d43413448494ef73d43d01bdac747a91e7cdff4dc60abc04cddced60b0f1f686a7f179d90d7fe6e026cf5269d89284956b26a8&userUid=472375103315812352&orgUid=472375103382921217';
            $this->rssFilePath = APPPATH . 'cache/upwork_eli.xml';
        } else if ($linkId === 'eli-hashires-cheap') {
            $link = 'https://www.upwork.com/ab/feed/jobs/rss?budget=500-&category2_uid=531770282580668420%2C531770282580668419%2C531770282580668418&client_hires=1-9%2C10-&hourly_rate=100-&location=United+States&paging=0%3B10&q=developer&sort=recency&job_type=hourly%2Cfixed&api_params=1&securityToken=316c29312fae11998afcc79025d43413448494ef73d43d01bdac747a91e7cdff4dc60abc04cddced60b0f1f686a7f179d90d7fe6e026cf5269d89284956b26a8&userUid=472375103315812352&orgUid=472375103382921217';
            $this->rssFilePath = APPPATH . 'cache/upwork_eli_us_hashires.xml';
        } else {
            $link = 'https://www.upwork.com/ab/feed/jobs/rss?budget=5000-&category2_uid=531770282580668420%2C531770282580668419%2C531770282580668418&client_hires=1-9%2C10-&hourly_rate=120-&location=United+States&paging=0%3B10&q=developer&sort=recency&job_type=hourly%2Cfixed&api_params=1&securityToken=316c29312fae11998afcc79025d43413448494ef73d43d01bdac747a91e7cdff4dc60abc04cddced60b0f1f686a7f179d90d7fe6e026cf5269d89284956b26a8&userUid=472375103315812352&orgUid=472375103382921217'
            $this->rssFilePath = APPPATH . 'cache/upwork_eli_us_hashires_5k.xml';
        }
        return $link;
    }

    public function fetchAndCompare($linkId)
    {
        $link = $this->getLink($linkId);
        if ($this->input->get_post('all')) {
            $lastFetchedJobTitles = [];
        } else {
            $lastFetchedJobTitles = $this->getLastFetchedJobTitles($link);
        }

        $rss = simplexml_load_file($link);

        $newJobs = [];

        foreach ($rss->channel->item as $item) {
            $jobTitle = (string)$item->title;
            $jobLink = (string)$item->link;

            if (!in_array($jobTitle, $lastFetchedJobTitles)) {
                $newJobs[] = [
                    'title' => $jobTitle,
                    'link' => $jobLink,
                    'pubDate' => (string)$item->pubDate,
                    'description' => $this->parseDescriptionAsRawHtml((string)$item->description),
                ];
            }
        }

        $this->saveRssToFile($rss);

        return $newJobs;
    }

    private function getLastFetchedJobTitles($link)
    {
        $lastFetchedJobTitles = [];
        $rss = simplexml_load_file($link);
        foreach ($rss->channel->item as $item) {
            $lastFetchedJobTitles[] = (string)$item->title;
        }
        return $lastFetchedJobTitles;
    }

    private function saveRssToFile($rss)
    {
        $rss->asXML($this->rssFilePath);
    }

    private function parseDescriptionAsHtml($description)
    {
        // Parse the description as raw HTML
        $descriptionHtml = strip_tags($description, '<p><b><br><ul><ol><li><strong><em>');

        // Extract budget and skills nodes from the description (adjust as per actual structure)
        preg_match('/\<b\>Budget\<\/b\>:\s*(.*?)<\/p>/', $descriptionHtml, $budgetMatches);
        preg_match('/Skills:\s*(.*?)<\/p>/', $descriptionHtml, $skillsMatches);

        $budget = isset($budgetMatches[1]) ? $budgetMatches[1] : 'Not specified';
        $skills = isset($skillsMatches[1]) ? $skillsMatches[1] : 'Not specified';

        // Add the extracted information to the description HTML
        $descriptionHtml .= "<p><strong>Budget:</strong> $budget</p>";
        $descriptionHtml .= "<p><strong>Skills:</strong> $skills</p>";

        return $descriptionHtml;
    }

    private function parseDescriptionAsRawHtml($description)
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($description);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $descriptionHtml = ''; //  $dom->saveHTML();

        $bNodes = $xpath->query("//b[following-sibling::text()[contains(., ':')]]");

        if ($bNodes->length > 0) {
            $nodeMap = ['Budget' => 0, 'Category' => 2, 'Skills' => 3, 'Country' => 5];
            foreach ($nodeMap as $label => $commonkey) {
                $val = $this->findNodeVal($bNodes, $label);
                if (!empty($val)) {
                    if ($label === 'Skills' && $this->linkId === 'eli') {
                        $skills = explode(',', $val);
                        $mylinks = [];
                        foreach ($skills as $skillstr) {
                            $skill = trim($skillstr);
                            $match = $this->projects->getTags('technologies', $skill, 1);
                            if (!empty($match)) {
                                $link = 'https://taylormadetraffic.com/technologies?qtfilter=' . $skill;
                                array_unshift($mylinks, "<a href='$link' target='_blank'>" . $skill . '</a>');
                            } else {
                                $mylinks[] = $skill;
                            }
                        }
                        $descriptionHtml .= "<p><strong>Skills:</strong> " . implode(', ', $mylinks) . "</p>";
                    } else {
                        $descriptionHtml .= "<p><strong>" . $label . ":</strong> " . $val . "</p>";
                    }
                }
            }
        } else {
            $descriptionHtml = $dom->saveHTML();
        }
        return $descriptionHtml;
    }

    private function findNodeVal($bNodes, $label)
    {
        foreach ($bNodes as $bNode) {
            $test = trim($bNode->textContent);
            if ($test === $label) {
                if (!empty($bNode->nextSibling)) {
                    $val = trim(str_replace(':', '', $bNode->nextSibling->textContent));
                    return $val;
                }
            }
        }
        return '';
    }

}
