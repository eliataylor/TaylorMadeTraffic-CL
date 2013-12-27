<table class="tablesorter">
    <?if (count($tableRows) > 1):?>
    <thead><tr>
            <?php $index = 1; ?>
            <? foreach ($headers as $key=>$head): ?>
                <th class="col<?=$index?> <?= $key ?>"><?= $head ?></th>
            <? $index++;  endforeach; ?>
        </tr></thead>    
    <?endif;?>
    <tbody id="tableBody">
        <? foreach ($tableRows as $row): ?>
            <tr class="spacer static"><? foreach ($headers as $head): ?><td></td><?endforeach?></tr>
            <tr id="pid_<?=$row->project_id?>" data-pid="<?=$row->project_id?>" >
                <?php $index = 1; ?>
                <? foreach ($headers as $key=> $head): ?>
                        <td class="col<?=$index?> <?= $key ?>">    
                        <?if ($key == 'image_src'):?>
                            <div class="projectImgMask">
                                <a href='/projects?pid=<?=$row->project_id;?>'>
                                    <img  data-owidth="<?=$row->image_width?>" data-oheight="<?=$row->image_height?>" src='/wwwroot/<?=$row->$key?>' class="projectImg blackOutFade" />
                                </a>
                                <div class="blackOutFadeBG"></div>
                            </div>
                        <?elseif ($key === "project_title"):?>
                            <h3><a href='/projects?pid=<?=$row->project_id;?>'><?=$row->project_title;?></a></h3>
                            <?if(!empty($row->project_desc)):?><p class="prjDesc"><?=$row->project_desc;?></p><?endif?>
                            <?if(!empty($row->project_technotes)):?><p><div class="technotes"><?=$row->project_technotes;?></div></p><?endif?>
                        <?elseif ($key === "project_startdate"):?>
                            <p><span class='lineName'><?=$this->lang->line("Started:")?>:</span> <?=$row->project_startdate;?></p>
                            <?if(!empty($row->project_launchdate)):?><p><span class='lineName'><?=$this->lang->line("Launched/Lasted:")?>:</span> <?=$row->project_launchdate;?></p><?endif?>
                            <?if(!empty($row->project_liveurl)):?><p  class="projectLink"><span class='lineName'><?=$this->lang->line("Live")?>:</span><a href="<?=$row->project_liveurl;?>" target="_blank"> <?=$row->project_liveurl;?></a></p><?endif?>
                            <?if(!empty($row->project_devurl)):?><p class="projectLink"><span class='lineName'><?=$this->lang->line("Dev")?>:</span><a href="<?=$row->project_devurl;?>" target="_blank"> <?=$row->project_devurl;?></a></p><?endif?>
                            <?if(!empty($row->project_devtools)):?><p><span class='lineName'><?=$this->lang->line("Technologies")?>:</span> <?=$row->project_devtools;?></p><?endif?>
                            <?if(!empty($row->project_industries)):?><p><span class='lineName'><?=$this->lang->line("Industries")?>:</span> <?=ucwords($row->project_industries);?></p><?endif?>
                            <?if(!empty($row->project_team)):?><p><span class='lineName'><?=$this->lang->line("Team")?>:</span> <?=$row->project_team;?></p><?endif?>
                            <?if(!empty($row->project_companies)):?><p><span class='lineName'><?=$this->lang->line("Companies/Brands:")?>:</span> <?=$row->project_companies;?></p><?endif?>
                            <?if(!empty($row->license_id)):?><p><span class='lineName'><?=$this->lang->line("License")?>:</span> <?=$row->license_id;?></p><?endif?>
                        <? endif; ?>
                        </td>
                        <?php $index++; ?>
                <? endforeach; ?>
            </tr>
            <tr class="spacer static"><? foreach ($headers as $head): ?><td></td><?endforeach?></tr>
        <? endforeach; ?>
    </tbody>
</table>