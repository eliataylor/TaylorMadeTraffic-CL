<table class="tablesorter">
    <thead><tr>
            <? foreach ($headers as $key=>$head): ?>
                <th class="blackShadowBG <?= $key ?>"><?= $head ?></th>
            <? endforeach; ?>
        </tr></thead>    
    <tbody id="tableBody">
        <? foreach ($tableRows as $row): ?>
            <tr class="spacer"></tr>
            <tr id="pid_<?=$row->project_id?>" data-pid="<?=$row->project_id?>" >
                <? foreach ($headers as $key=> $head): ?>
                        <td class="<?= $key ?>">    
                        <?if ($key == 'image_src'):?>
                            <div class="projectImgMask">
                                <img src='/wwwroot/<?=$row->$key?>' class="projectImg" />
                            </div>
                        <?elseif ($key === "project_title"):?>
                            <h3><a href='/projects?pid=<?=$row->project_id;?>'><?=$row->project_title;?></a></h3>
                            <?if(!empty($row->project_desc)):?><p class="prjDesc"><?=$row->project_desc;?></p><?endif?>
                            <?if(!empty($row->project_technotes)):?><p><div class="technotes"><?=$row->project_technotes;?></div></p><?endif?>
                        <?elseif ($key === "project_startdate"):?>
                            <p><span class='lineName'><?=$this->lang->line("Started:")?>:</span> <?=$row->project_startdate;?></p>
                            <?if(!empty($row->project_launchdate)):?><p><span class='lineName'><?=$this->lang->line("Launched/Lasted:")?>:</span> <?=$row->project_launchdate;?></p><?endif?>
                            <?if(!empty($row->project_liveurl)):?><p><span class='lineName'><?=$this->lang->line("Live")?>:</span><a href="<?=$row->project_liveurl;?>" target="_blank"> <?=$row->project_liveurl;?></a></p><?endif?>
                            <?if(!empty($row->project_devurl)):?><p><span class='lineName'><?=$this->lang->line("Dev")?>:</span><a href="<?=$row->project_devurl;?>" target="_blank"> <?=$row->project_devurl;?></a></p><?endif?>
                            <?if(!empty($row->project_devtools)):?><p><span class='lineName'><?=$this->lang->line("Tools")?>:</span> <?=$row->project_devtools;?></p><?endif?>
                            <?if(!empty($row->project_team)):?><p><span class='lineName'><?=$this->lang->line("Team")?>:</span> <?=$row->project_team;?></p><?endif?>
                            <?if(!empty($row->project_client)):?><p><span class='lineName'><?=$this->lang->line("Client")?>:</span> <?=$row->project_client;?></p><?endif?>
                            <?if(!empty($row->project_copyright)):?><p><span class='lineName'><?=$this->lang->line("Copyright")?>:</span> <?=$row->project_copyright;?></p><?endif?>
                            <?if(!empty($row->license_id)):?><p><span class='lineName'><?=$this->lang->line("License")?>:</span> <?=$row->license_id;?></p><?endif?>
                        <?endif;?>
                        </td>
                <? endforeach; ?>
            </tr>
            <tr class="spacer"></tr>
        <? endforeach; ?>
    </tbody>
</table>