<table class="tablesorter">
    <tbody id="tableBody">
            <tr id="even pid_<?=$project->project_id?>" data-pid="<?=$project->project_id?>" >
                <td style="width:60%" class="col2">    
                    <h3><?=$project->project_title;?></h3>
                    <?if(!empty($project->project_desc)):?><p class="prjDesc"><?=$project->project_desc;?></p><?endif?>
                    <?if(!empty($project->project_technotes)):?><p><div class="technotes"><?=$project->project_technotes;?></div></p><?endif?>
                    
                <? if ($me['con']['swidth'] > 980):?>    
                </td>
                <td style="width:40%" class="col3">  
                <?endif;?>
                    
                    <p><span class='lineName'><?=$this->lang->line("Started:")?>:</span> <?=$project->project_startdate;?></p>
                    <?if(!empty($project->project_launchdate)):?><p><span class='lineName'><?=$this->lang->line("Launched/Lasted:")?>:</span> <?=$project->project_launchdate;?></p><?endif?>
                    <?if(!empty($project->project_liveurl)):?><p><span class='lineName'><?=$this->lang->line("Live")?>:</span><a href="<?=$project->project_liveurl;?>" target="_blank"> <?=$project->project_liveurl;?></a></p><?endif?>
                    <?if(!empty($project->project_devurl)):?><p><span class='lineName'><?=$this->lang->line("Dev")?>:</span><a href="<?=$project->project_devurl;?>" target="_blank"> <?=$project->project_devurl;?></a></p><?endif?>
                    <?if(!empty($project->project_devtools)):?><p><span class='lineName'><?=$this->lang->line("Tools")?>:</span> <?=$project->project_devtools;?></p><?endif?>
                    <?if(!empty($project->project_team)):?><p><span class='lineName'><?=$this->lang->line("Team")?>:</span> <?=$project->project_team;?></p><?endif?>
                    <?if(!empty($project->project_client)):?><p><span class='lineName'><?=$this->lang->line("Client")?>:</span> <?=$project->project_client;?></p><?endif?>
                    <?if(!empty($project->project_copyright)):?><p><span class='lineName'><?=$this->lang->line("Copyright")?>:</span> <?=$project->project_copyright;?></p><?endif?>
                    <?if(!empty($project->license_id)):?><p><span class='lineName'><?=$this->lang->line("License")?>:</span> <?=$project->license_id;?></p><?endif?>
                </td>
            </tr>
    </tbody>
</table>

<? if (!empty($project->image_srcs)): ?>
<?php $project->image_srcs = explode(',', $project->image_srcs); ?>
<div class="galleryBlock">    
    <div class="gallerySideBar">    
    <?for($i=0; $i < count($project->image_srcs); $i++):?>
        <img onclick="$('#galleryImg<?=$project->project_id?>').attr('src',this.src);return false;" src='wwwroot/<?= trim($project->image_srcs[$i]) ?>' class="projectImg" />   
    <?endfor?>
    </div>
    <div class="galleryImg">
        <img id="galleryImg<?=$project->project_id?>" src='wwwroot/<?= trim($project->image_srcs[0]) ?>' />   
    </div>
</div>
<?endif?>
