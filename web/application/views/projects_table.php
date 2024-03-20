<?php if (isset($cProfile) && !empty($cProfile)) {
    $this->load->view('company_profile', $this);
} elseif (isset($qtfilter) && !empty($qtfilter)) {
    echo $this->load->view('projects_table_meta_header', ['qfilter'=>$qtfilter, 'projects_count'=>$projects_count], TRUE);
}
?>

<?php if (isset($_GET['cv'])): ?>
    <h3>EXPERIENCE</h3>
<?php endif; ?>

<section>

    <div class="projects_table <?php echo isset($_GET['noPics']) ? 'noPics' : ''; ?>">
        <?php foreach ($groups as $company): ?>

            <div class="companySection" data-company="<?php echo $company['company_tagname']; ?>">

                <?php

                if (isset($showGroup) && count($company['projects']) > 0) {
                    if ($qhaving > 0 && $qhaving > count($company['projects'])) {
                        continue; // don't show group
                    }
                    $groupname = $company['company_tagname'];
                    $this->load->view('company_header', ['company' => $company, 'groupname' => $groupname]);
                }

                ?>

                <?php foreach ($company['projects'] as $row): ?>
                    <div class="container projectRow"
                         id="pid_<?php echo $row->project_id ?>"
                         data-pid="<?php echo $row->project_id ?>"
                         <?php if (isset($groupname)): ?>data-group="<?php echo $groupname ?>"<?php endif; ?>>
                        <div class="row">
                            <?php if (!isset($_GET['noPics'])): ?>
                                <div class="col image_src">
                                    <?php $this->load->view('project_images', ['row' => $row]); ?>
                                </div>
                            <?php endif; ?>
                            <div class="col project_title">
                                <?php $this->load->view('project_item', ['row' => $row]); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endforeach; ?>
    </div>

</section>
