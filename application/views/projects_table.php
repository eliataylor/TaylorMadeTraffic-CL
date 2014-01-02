<?if (isset($qtfilter) && !empty($qtfilter)):?>
<div class="projectsTitle" >
    <h2>
    <?if (isset($qtagOptions) && !empty($qtagOptions)):?>    
    <select id="qTagSelector" onchange="if (this.options[this.selectedIndex].value != '') tmt.ajaxPage(this.options[this.selectedIndex].value); return false;" >
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
                <? if ($qtfilter == $option->tag_key): ?>
                    selected='selected'
                <? endif; ?>

                value="<?=$qurl?>"  >
                        <?=$option->tag_key?>

            </option>
        <?endforeach;?>
    </select>    
    <?endif;?>

    <?if (isset($tableRows) && count($tableRows) > 1):?>    
        <span style="float:right;" class="pageTotal">
            <?=count($tableRows)?>
            <?= (count($tableRows) == 1) ? $this->lang->line('Project') : $this->lang->line('Projects');?>
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
                                  src='<?=($row->image_height < 1000) ? imageSize($row->image_src, "300x300") : $row->image_src; ?>'
                                  class="projectImg blackOutFade" />                            
                        </a>
                        <div class="blackOutFadeBG"></div>
                    </div>
                    <?endif;?>
                    
                <? if ($me['con']['swidth'] > 600): ?>    
                </td>
                <td class="col2 project_title">
                    <h3><a href='/projects?pid=<?= $row->project_id; ?>'><?= $row->project_title; ?></a></h3>
                <? endif; ?>
                    <? if (!empty($row->project_desc)): ?><p class="prjDesc"><?= $row->project_desc; ?></p><? endif ?>
                    <? if (!empty($row->project_technotes)): ?><p><div class="technotes"><?= $row->project_technotes; ?></div></p><? endif ?>
                    
                <? if ($me['con']['swidth'] > 980): ?>    
                </td>
                <td class="col3 project_startdate">
                <? endif; ?>
                    
                    <p><span class='lineName'><?= $this->lang->line("Started:") ?>:</span> <?= $row->project_startdate; ?></p>
                    <? if (!empty($row->project_launchdate)): ?><p><span class='lineName'><?= $this->lang->line("Launched/Lasted:") ?>:</span> <?= $row->project_launchdate; ?></p><? endif ?>
                    <? if (!empty($row->project_liveurl)): ?><p  class="projectLink"><span class='lineName'><?= $this->lang->line("Live") ?>:</span>                        
                        <a href="<?= $row->project_liveurl; ?>" target="_blank"> <?= $row->project_liveurl; ?></a>
                    </p><? endif ?>
                    <? if (!empty($row->project_devurl)): ?><p class="projectLink"><span class='lineName'><?= $this->lang->line("Dev") ?>:</span><a href="<?= $row->project_devurl; ?>" target="_blank"> <?= $row->project_devurl; ?></a></p><? endif ?>
                    <? if (!empty($row->project_devtools)): ?><p><span class='lineName'><?= $this->lang->line("Technologies") ?>:</span> <?= $row->project_devtools; ?></p><? endif ?>
                    <? if (!empty($row->project_industries)): ?><p><span class='lineName'><?= $this->lang->line("Industries") ?>:</span> <?= ucwords($row->project_industries); ?></p><? endif ?>
                    <? if (!empty($row->project_team)): ?><p><span class='lineName'><?= $this->lang->line("Team") ?>:</span> <?= $row->project_team; ?></p><? endif ?>
                    <? if (!empty($row->project_companies)): ?><p><span class='lineName'><?= $this->lang->line("Companies/Brands:") ?>:</span> <?= $row->project_companies; ?></p><? endif ?>
                    <? if (!empty($row->license_id)): ?><p><span class='lineName'><?= $this->lang->line("License") ?>:</span> <?= $row->license_id; ?></p><? endif ?>
                </td>
            </tr>
<? endforeach; ?>
    </tbody>
</table>