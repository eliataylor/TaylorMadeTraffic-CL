
<?php if (isset($cProfile) && !empty($cProfile)): ?>
    <?php $this->load->view('company_profile'); ?>
<?php endif; ?>

<section>

    <?php if (empty($uProfile) && isset($qtfilter) && !empty($qtfilter)): ?>
        <div class="projectsTitle row">
            <div class="col">
                <h2>
                    <?php echo $qtfilter; ?>
                </h2>
            </div>
            <div class="col">
                <?php if (isset($groups) && count($groups) === 1): ?>
                    <?php $count = array_keys($groups);
                    $count = $count[0];
                    $count = count($groups[$count]['projects']); ?>
                    <span style="float:right;" class="pageTotal">
                        <?php echo $count ?>
                        <?php echo ($count == 1) ? $this->lang->en('Project') : $this->lang->en('Projects'); ?>
                    </span>

                <?php endif ?>
            </div>
        </div>
    <?php elseif (isset($_GET['cv'])): ?>
        <h3>EXPERIENCE</h3>
    <?php endif; ?>

    <div class="projects_table <?php echo isset($_GET['noPics']) ? 'noPics' : ''; ?>">
        <?php foreach ($groups as $company): ?>

            <div class="companySection" data-company="<?php echo $company['company_tagname']; ?>">
            <?php if (isset($showGroup) && count($company['projects']) > 0): ?>

                <?php if ($qhaving > 0 && $qhaving > count($company['projects'])) {
                    continue; // don't show group
                } ?>

                <?php $groupname = $company['company_tagname']; ?>

                <div class="container companyHead" data-group="<?php echo $groupname ?>"
                     data-projectcount="<?php echo count($company['projects']) ?>">
                    <div class="row">
                        <div class="col"><h2>
                                <?php if (isset($company['company_logo']) && isset($_GET['logos'])): ?>
                                    <img title="<?php echo $company['company_screenname'] ?>"
                                         alt="<?php echo $company['company_screenname'] ?>" class="companyLogo"
                                         src="<?php echo $company['company_logo'] ?>"/>
                                    <span class="company_screenname"><?php echo $company['company_screenname']; ?></span>
                                <?php else: ?>
                                    <?php echo $company['company_screenname']; ?>
                                <?php endif; ?>
                            </h2>
                        </div>
                        <div class="col">
                            <?php echo fDate($company['startDate'], 'month') ?>
                            -
                            <?php echo ($company['endDate'] === 'Present') ? $company['endDate'] : fDate($company['endDate'], 'month') ?>
                        </div>
                        <div class="col">
                            <div style="text-align: right">
                            <?php if ($company['company_myrole']): ?>
                                <div class="myrole"><?php echo htmlentities($company['company_myrole']) ?></div>
                            <?php endif; ?>

                            <?php if (isset($company['company_city'])): ?>
                                <div class="locale">
                                <?php echo $company['company_city'] ?>
                                <?php if ($company['company_telecommuting']): ?>
                                    (remote)
                                <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="letterheader">
                        <?php $this->load->view('letterhead', ['variant'=>'header', "style"=>"opacity:1;"]); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php foreach ($company['projects'] as $row): ?>
                <div class="container">
                    <div class="row projectRow"
                         id="pid_<?php echo $row->project_id ?>"
                         data-pid="<?php echo $row->project_id ?>"
                         <?php if (isset($groupname)): ?>data-group="<?php echo $groupname ?>"<?php endif; ?>
                    >
                        <?php if (!isset($_GET['noPics'])): ?>
                            <div class="col-2 image_src">
                                <?php $this->load->view('project_images', ['row' => $row]); ?>
                            </div>
                        <?php endif; ?>
                        <div class="col project_title" >
                            <?php $this->load->view('project_item', ['row' => $row]); ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
            </div>

        <?php endforeach; ?>
    </div>
</section>
