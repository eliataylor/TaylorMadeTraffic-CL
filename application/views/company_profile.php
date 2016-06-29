<div class='userProfile'>
        <h1 class="userName">
        <?=$cProfile['company_screenname'];?>    
        <span class='sociallinks'>
            <? if (!empty($cProfile['company_fburl'])):?>
                <a target='_blank' href='<?=$cProfile['company_fburl'];?>'>
                <img src="/wwwroot/images/fbIcon.png" title="<?=$cProfile['company_fburl'];?>" />
                </a>
            <? endif?>
            <? if (!empty($cProfile['company_linkdinurl'])):?>
                <a target='_blank' href='<?=$cProfile['company_linkdinurl'];?>'>
                <img title="<?=$cProfile['company_linkdinurl'];?>" src="/wwwroot/images/linkedinIcon.png" />
                </a>
            <? endif?>
            <? if (!empty($cProfile['company_googleurl'])):?><li><a target='_blank' href='<?=$cProfile['company_googleurl'];?>'><?=$cProfile['company_googleurl'];?></a></li><? endif?>
        </span>
        </h1>
        
        <? if (!empty($cProfile['company_bio'])):?>
        <div class='userBio'>
            <?=$this->lang->ugc($cProfile['company_bio']);?>
        </div>
        <? endif?>
    </div>