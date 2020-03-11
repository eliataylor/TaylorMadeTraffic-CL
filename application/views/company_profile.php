<div class='userProfile'>
        <h1 class="userName">
        <?php echo $cProfile['company_screenname'];?>    
        <span class='sociallinks'>
            <? if (!empty($cProfile['company_fburl'])):?>
                <a target='_blank' href='<?php echo $cProfile['company_fburl'];?>'>
                <img src="/wwwroot/images/fbIcon.png" title="<?php echo $cProfile['company_fburl'];?>" />
                </a>
            <? endif?>
            <? if (!empty($cProfile['company_linkdinurl'])):?>
                <a target='_blank' href='<?php echo $cProfile['company_linkdinurl'];?>'>
                <img title="<?php echo $cProfile['company_linkdinurl'];?>" src="/wwwroot/images/linkedinIcon.png" />
                </a>
            <? endif?>
            <? if (!empty($cProfile['company_googleurl'])):?><li><a target='_blank' href='<?php echo $cProfile['company_googleurl'];?>'><?php echo $cProfile['company_googleurl'];?></a></li><? endif?>
        </span>
        </h1>
        
        <? if (!empty($cProfile['company_bio'])):?>
        <div class='userBio'>
            <?php echo $this->lang->ugc($cProfile['company_bio']);?>
        </div>
        <? endif?>
    </div>