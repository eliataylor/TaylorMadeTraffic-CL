<? if (isset($uProfile) && !empty($uProfile)):?>
    <div class='userProfile'>
        <h1 class="userName">
        <?=$uProfile['user_screenname'];?>    
        <span class='sociallinks'>
            <? if (!empty($uProfile['user_fburl'])):?>
                <a target='_blank' href='<?=$uProfile['user_fburl'];?>'>
                <img src="/wwwroot/images/fbIcon.png" title="<?=$uProfile['user_fburl'];?>" />
                </a>
            <? endif?>
            <? if (!empty($uProfile['user_linkdinurl'])):?>
                <a target='_blank' href='<?=$uProfile['user_linkdinurl'];?>'>
                <img title="<?=$uProfile['user_linkdinurl'];?>" src="/wwwroot/images/linkedinIcon.png" />
                </a>
            <? endif?>
            <? if (!empty($uProfile['user_googleurl'])):?><li><a target='_blank' href='<?=$uProfile['user_googleurl'];?>'><?=$uProfile['user_googleurl'];?></a></li><? endif?>
        </span>
        </h1>
        
        <? if (!empty($uProfile['user_bio'])):?>
        <div class='userBio'>
            <?=$this->lang->ugc($uProfile['user_bio']);?>
        </div>
        <? endif?>
    </div>
<? elseif (isset($cProfile) && !empty($cProfile)):?>
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
<? endif; ?>

<table class="tablesorter projects_table biz_plans">
    <tbody id="tableBody">        
    <? foreach ($tableRows as $row): ?>
            <tr id="pid_<?= $row->project_id ?>" data-pid="<?= $row->project_id ?>" >
                
                <td class="col1 image_src">
                        <a href='/projects?pid=<?= $row->project_id; ?>'>
                            <img  data-owidth="<?= $row->image_width ?>" 
                                  data-oheight="<?= $row->image_height ?>" 
                                  src='<?=($row->image_width > 1000) ? imageSize($row->image_src, "300x300") : $row->image_src; ?>'
                                  class="projectImg" />
                        </a>
                            <?if (isset($row->totalImages) && $row->totalImages > 1):?>
                                <a href="/projects?pid=<?= $row->project_id; ?>"><?= $row->totalImages -1 ?> <?=$this->lang->en('more images')?></a>
                            <?endif;?>
                </td>
                <td class="col2 project_title">
                    <h3><a href='/projects?pid=<?= $row->project_id; ?>'><?= $row->project_title; ?></a></h3>
                    
                    <div class="prjSection  prjLinks">
                        <? if (!empty($row->project_liveurl) || !empty($row->project_devurl)): ?>
                        <p  class="projectLink">                            
                            <? if (!empty($row->project_liveurl)): ?>
                                <a href="<?= $row->project_liveurl; ?>" target="_blank"> <?= $row->project_liveurl; ?></a>
                            <? endif ?>
                            <? if (!empty($row->project_devurl)): ?>
                                <a href="<?= $row->project_devurl; ?>" target="_blank"> <?= $row->project_devurl; ?></a>
                            <? endif ?>
                        </p>
                        <? endif ?>
                    </div>
                    <? if (!empty($row->project_pitch)): ?><div class="prjSection prjPitch">
                        <?= $this->lang->ugc($row->project_pitch); ?></div>
                    <? endif ?>
                    
                    <? if (!empty($row->project_bizmodel)): ?>
                        <div class="prjSection prjBiz">
                            <h4 class="sectTitle"><?=$this->lang->en('Business Model')?></h4>
                            <?= $this->lang->ugc($row->project_bizmodel); ?>
                        </div>
                    <? endif ?>
                    
                    <? if (!empty($row->project_competition)): ?>
                        <div class="prjSection prjCompetition">
                            <h4 class="sectTitle"><?=$this->lang->en('Competition')?></h4>
                            <?= $this->lang->ugc($row->project_competition); ?>
                        </div>
                    <? endif ?>                    
                   
                    <? if (!empty($row->project_marketresearch)): ?>
                        <div class="prjSection prjResearch">
                            <h4 class="sectTitle"><?=$this->lang->en('Target Markets')?> / <?=$this->lang->en('Research')?></h4>
                            <?= $this->lang->ugc($row->project_marketresearch); ?>
                        </div>
                    <? endif ?>                    
                    
                    <? if (!empty($row->project_expenses)): ?>
                        <div class="prjSection prjCosts">
                            <h4 class="sectTitle"><?=$this->lang->en('Costs by Department')?></h4>
                            <?= $this->lang->ugc($row->project_expenses); ?>
                        </div>
                    <? endif ?>
                    
                    <? if (!empty($row->project_futuredate)): ?>
                        <div class="prjSection prjDates">
                            <h4 class="sectTitle"><?=$this->lang->en('Roadmap')?></h4>
                            <?= $this->lang->ugc($row->project_futuredate); ?>
                        </div>
                    <? endif ?>
                    
                </td>
            </tr>
<? endforeach; ?>
    </tbody>
</table>