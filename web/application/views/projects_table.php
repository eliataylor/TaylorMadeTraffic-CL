<?php if (empty($groups)): ?>
    <p style="margin:50px auto; font-size: 17px; text-align: center"><strong>OOPS.</strong> We still need to tag
        projects with this filter</p>
<?php else: ?>

    <section class="<?php echo isset($_GET['noPics']) ? 'noPics' : ''; ?>" aria-groupby="<?php echo $qgroup; ?>">
        <?php if (isset($_GET['cv'])): ?>
            <h3>EXPERIENCE</h3>
        <?php endif; ?>


        <?php if ($this->uri->segment(2) === 'cv'): ?>
        <div id="toggleAll" class="alink" >Open All</div>
        <?php endif; ?>

        <?php foreach ($groups as $index => $company): ?>

            <div class="companySection" data-index="<?php echo $index; ?>"
                 data-company="<?php echo $company['company_tagname']; ?>">

                <?php

                if (isset($showGroup) && $showGroup === true && count($company['projects']) > 0) {
                    if ($qhaving > 0 && $qhaving > count($company['projects'])) {
                        continue; // don't show group
                    }
                    $groupname = $company['company_tagname'];
                    $this->load->view('company_header', ['company' => $company, 'groupname' => $groupname, 'index' => $index]);
                }

                ?>

                <?php foreach ($company['projects'] as $project_index=>$row): ?>
                    <div class="container projectRow"
                         id="pid_<?php echo $row->project_id ?>"
                         data-pid="<?php echo $row->project_id ?>"
                         <?php if (isset($groupname)): ?>data-group="<?php echo $groupname ?>"<?php endif; ?>>
                        <div class="row">
                            <?php if (!isset($_GET['noPics'])): ?>
                                <div class="col image_src"
                                    <?php if (isset($_GET['picSize']) && $_GET['picSize'] > 0): ?>
                                        style="width:<?php echo $_GET['picSize']; ?>%; min-width:<?php echo $_GET['picSize']; ?>%;"
                                    <?php endif; ?>
                                >
                                    <?php $this->load->view(isset($_GET['picCount']) ? 'project_images' : 'project_imagelinks', ['row' => $row]); ?>
                                </div>
                            <?php endif; ?>
                            <div class="col project_title">
                                <?php $this->load->view('project_item', ['row' => $row, 'index'=>$project_index]); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endforeach; ?>
    </section>
<?php endif; ?>
