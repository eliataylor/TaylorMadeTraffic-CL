<div class="companyProfile">
    <div class="row">
        <div class="col" style="flex-grow: 1">
            <h2 class="userName" style="flex-grow: 1">
                <?php echo $cProfile['company_screenname']; ?>
            </h2>
        </div>
        <div class="col projects_count">
            <?php echo $projects_count; ?> <?php echo ($projects_count == 1) ? $this->lang->en('Project') : $this->lang->en('Projects'); ?>
        </div>
        <div class="col">
            <span class='sociallinks'>
                <?php if (!empty($cProfile['company_fburl'])): ?>
                    <a target='_blank' href='<?php echo $cProfile['company_fburl']; ?>'>
                    <img src="/wwwroot/images/fbIcon.png" title="<?php echo $cProfile['company_fburl']; ?>"/>
                    </a>
                <?php endif ?>
                <?php if (!empty($cProfile['company_linkdinurl'])): ?>
                    <a target='_blank' href='<?php echo $cProfile['company_linkdinurl']; ?>'>
                    <img title="<?php echo $cProfile['company_linkdinurl']; ?>" src="/wwwroot/images/linkedinIcon.png"/>
                    </a>
                <?php endif ?>
                <?php if (!empty($cProfile['company_googleurl'])): ?>
                    <li><a target='_blank'
                           href='<?php echo $cProfile['company_googleurl']; ?>'><?php echo $cProfile['company_googleurl']; ?></a>
                    </li><?php endif ?>
            </span>
        </div>
    </div>

    <?php if (!empty($cProfile['company_bio'])): ?>
        <div class='userBio'>
            <?php echo $this->lang->ugc($cProfile['company_bio']); ?>
            <div class="letterhead">
                <?php $this->load->view('letterhead', ['variant' => 'header', "style" => "opacity:1;"]); ?>
            </div>
        </div>

    <?php endif ?>
</div>
