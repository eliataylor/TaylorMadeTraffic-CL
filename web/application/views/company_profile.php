<?php if (!empty($cProfile['company_bio'])):?>
<div class='userProfile'>
        <h1 class="userName">
        <?php echo $cProfile['company_screenname'];?>
        <span class='sociallinks'>
            <?php if (!empty($cProfile['company_fburl'])):?>
                <a target='_blank' href='<?php echo $cProfile['company_fburl'];?>'>
                <img src="/wwwroot/images/fbIcon.png" title="<?php echo $cProfile['company_fburl'];?>" />
                </a>
            <?php endif?>
            <?php if (!empty($cProfile['company_linkdinurl'])):?>
                <a target='_blank' href='<?php echo $cProfile['company_linkdinurl'];?>'>
                <img title="<?php echo $cProfile['company_linkdinurl'];?>" src="/wwwroot/images/linkedinIcon.png" />
                </a>
            <?php endif?>
            <?php if (!empty($cProfile['company_googleurl'])):?><li><a target='_blank' href='<?php echo $cProfile['company_googleurl'];?>'><?php echo $cProfile['company_googleurl'];?></a></li><?php endif?>
        </span>
        </h1>

        <?php if (!empty($cProfile['company_bio'])):?>
        <div class='userBio'>
            <?php echo $this->lang->ugc($cProfile['company_bio']);?>
        </div>
        <?php endif?>
    </div>
<?php endif?>
