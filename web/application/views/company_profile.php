<div class="companyProfile">
    <div class="row">
        <div class="col" >
            <h2 class="userName" >
                <?php echo $cProfile['company_screenname']; ?>
            </h2>
        </div>
        <div class="col projects_count" >
            <?php echo $projects_count; ?> <?php echo ($projects_count == 1) ? $this->lang->en('Project') : $this->lang->en('Projects'); ?>
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
