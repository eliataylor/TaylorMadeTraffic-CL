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

<?if (isset($qtfilter) && !empty($qtfilter)):?>
<div class="projectsTitle" >
    <h2>
    <?if (isset($qtagOptions) && !empty($qtagOptions)):?>    
    <select id="qTagSelector" onchange="if (this.options[this.selectedIndex].value != '') tmt.ajaxPage(this.options[this.selectedIndex].value); return false;" >
        <? if ( (isset($cProfile) && !empty($cProfile)) || (isset($uProfile) && !empty($uProfile))):?>
        <option value=""><?=$this->lang->en('Other') . ' ' . $qtags?></option>
        <?endif;?>
        <?foreach($qtagOptions as $option):?>                        
            <option 

                <?php $qurl = '/';
                if ($qtags == 'roles') {
                    $qurl .= 'roles?qtfilter='.$option->tag_key;
                } else {
                     $qurl .= (strpos($option->tag_type, 'team') === 0) ? 'team' : $option->tag_type;
                     $qurl .= '?qtfilter='.$option->tag_key;
                }
                ?>
                <? if ($qtfilter == $option->tag_key && empty($cProfile) && empty($uProfile)): ?>
                    selected='selected'
                <? endif; ?>

                value="<?=$qurl?>"  >
                        <?=$this->lang->msg($option->tag_key)?>

            </option>
        <?endforeach;?>
    </select>   
    <?endif;?>
    <? if (isset($uProfile) && empty($uProfile)):?>
        <a class='teamInviteLink' href=''><?=$this->lang->en('Are You') . ' ' . $qtfilter . '?'?></a>
    <?endif;?>    

    <?if (isset($tableRows) && count($tableRows) > 1):?>    
        <span style="float:right;" class="pageTotal">
            <?=count($tableRows)?>
            <?= (count($tableRows) == 1) ? $this->lang->en('Project') : $this->lang->en('Projects');?>
        </span>
    <?endif?>


    </h2>                
</div>            
<?endif;?>

<table class="tablesorter projects_table">
    <tbody id="tableBody">        
    <? foreach ($tableRows as $row): ?>
            <tr id="pid_<?= $row->project_id ?>" data-pid="<?= $row->project_id ?>" >
                
                <td class="col1 image_src">
                    
                    <? if ($me['con']['swidth'] <= 600): ?>    
                    <h3><a href='/projects?pid=<?= $row->project_id; ?>'><?= $row->project_title; ?></a></h3>
                    <?endif;?>
                    
                    <? if (!isset($_GET['noPics'])):?>
                    <div class="projectImgMask">
                        <a href='/projects?pid=<?= $row->project_id; ?>'>
                            <img  data-owidth="<?= $row->image_width ?>" 
                                  data-oheight="<?= $row->image_height ?>" 
                                  src='<?=($row->image_width > 1000) ? imageSize($row->image_src, "300x300") : $row->image_src; ?>'
                                  class="projectImg" />                            
                        </a>
                    </div>
<!--                    TODO, leave for old browser support from reflection <div class="blackOutFadeBG"></div>-->
                    <div class="reflectionMask">
                        <img  class="reflection" src='<?=($row->image_width > 1000) ? imageSize($row->image_src, "300x300") : $row->image_src; ?>' />                            
                    </div>
                    <?if (isset($row->images) && count($row->images) > 1):?>
                        <?foreach($row->images as $index=>$img):?>            
                            <?if ($index==0):?>
                                <a class="fancybox" data-fancybox-group="gallery<?=$row->project_id?>" href="<?= $row->image_src; ?>"><?= $row->totalImages -1 ?> <?=$this->lang->en('more images')?></a>
                            <?else:?>
                                <a style="display:none;" class="fancybox" href="<?=$img->image_src?>" data-fancybox-group="gallery<?=$row->project_id?>" ></a>
                            <?endif;?>
                        <?endforeach?>
                    <?endif;?>
                        
                    <?endif;?>
                    
                <? if ($me['con']['swidth'] > 600): ?>    
                </td>
                <td class="col2 project_title">
                    <h3><a href='/projects?pid=<?= $row->project_id; ?>'><?= $row->project_title; ?></a></h3>
                <? endif; ?>
                    <? if (!empty($row->project_desc)): ?><div class="prjDesc"><?= $this->lang->ugc($row->project_desc); ?></div><? endif ?>
                    <? if (!empty($row->project_technotes)): ?><div class="technotes"><?= $this->lang->ugc($row->project_technotes); ?></div><? endif ?>
                    
                <? if ($me['con']['swidth'] > 980): ?>    
                </td>
                <td class="col3 project_startdate">
                <? endif; ?>
                    <div class="projectTags">
                        <p><span class='lineName'><?= $this->lang->en("Started") ?>:</span> <?= $row->project_startdate; ?></p>
                        <? if (!empty($row->project_launchdate)): ?><p><span class='lineName'><?= $this->lang->en("Launched") ?>/<?= $this->lang->en("Lasted") ?>:</span> <?= $row->project_launchdate; ?></p><? endif ?>
                        <? if (!empty($row->project_liveurl)): ?><p  class="projectLink"><span class='lineName'><?= $this->lang->en("Live") ?>:</span>                        
                            <a href="<?= $row->project_liveurl; ?>" target="_blank"> <?= $row->project_liveurl; ?></a>
                        </p><? endif ?>
                        <? if (!empty($row->project_devurl)): ?><p class="projectLink"><span class='lineName'><?= $this->lang->en("Dev") ?>:</span><a href="<?= $row->project_devurl; ?>" target="_blank"> <?= $row->project_devurl; ?></a></p><? endif ?>
                        <? if (!empty($row->project_devtools)): ?><p><span class='lineName'><?= $this->lang->en("Technologies") ?>:</span> <?= $row->project_devtools; ?></p><? endif ?>
                        <? if (!empty($row->project_industries)): ?><p><span class='lineName'><?= $this->lang->en("Industries") ?>:</span> <?= ucwords($row->project_industries); ?></p><? endif ?>
                        <? if (!empty($row->project_team)): ?><p><span class='lineName'><?= $this->lang->en("Team") ?>:</span> <?= $row->project_team; ?></p><? endif ?>
                        <? if (!empty($row->project_companies)): ?><p><span class='lineName'><?= $this->lang->en("Companies") ?>/<?= $this->lang->en("Brands") ?>:</span> <?= $row->project_companies; ?></p><? endif ?>
                        <? if (!empty($row->license_id)): ?><!--<p><span class='lineName'><?= $this->lang->en("License") ?>:</span> <?= $row->license_id; ?></p>--><? endif ?>
                    </div>
                </td>
            </tr>
<? endforeach; ?>
    </tbody>
</table>