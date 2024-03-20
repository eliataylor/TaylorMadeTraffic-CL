<div class="container companyHead" data-group="<?php echo $groupname ?>"
     data-projectcount="<?php echo count($company['projects']) ?>">
    <div class="row <?php if (!isset($_GET['cv'])): ?>letterhead<?php endif; ?>">
        <div class="col">
            <h2>
                <div class="company_screenname"><?php echo $company['company_screenname']; ?></div>
                <?php if (isset($company['company_logo']) && isset($_GET['logos'])): ?>
                    <img title="<?php echo $company['company_screenname'] ?>"
                         alt="<?php echo $company['company_screenname'] ?>" class="companyLogo"
                         src="<?php echo $company['company_logo'] ?>" />
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
        <?php if (!isset($_GET['cv'])): ?>
            <?php $this->load->view('letterhead', ['variant'=>'header', "style"=>"opacity:1;"]); ?>
        <?php endif; ?>
    </div>
    <?php if (isset($_GET['cv'])): ?>
        <div class="letterhead">
            <?php $this->load->view('letterhead', ['variant'=>'header', "style"=>"opacity:1;"]); ?>
        </div>
    <?php endif; ?>
</div>
