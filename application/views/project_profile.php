<table class="tablesorter">
    <tbody id="tableBody">
            <tr id="even pid_<?=$project->project_id?>" data-pid="<?=$project->project_id?>" >
                <td style="width:60%" class="col2">    
                    <h3><?=$project->project_title;?></h3>
                    <?if(!empty($project->project_desc)):?><p class="prjDesc"><?=$this->lang->ugc($project->project_desc);?></p><?endif?>
                    <?if(!empty($project->project_technotes)):?><p><div class="technotes"><?=$this->lang->ugc($project->project_technotes);?></div></p><?endif?>                    
                <? if ($me['con']['swidth'] > 980):?>
                </td>
                <td style="width:40%" class="col3">  
                <?endif;?>
                    
                    <p><span class='lineName'><?=$this->lang->en("Started:")?>:</span> <?=$project->project_startdate;?></p>
                    <?if(!empty($project->project_launchdate)):?><p><span class='lineName'><?=$this->lang->en("Launched/Lasted:")?>:</span> <?=$project->project_launchdate;?></p><?endif?>
                    <?if(!empty($project->project_liveurl)):?><p><span class='lineName'><?=$this->lang->en("Live")?>:</span><a href="<?=$project->project_liveurl;?>" target="_blank"> <?=$project->project_liveurl;?></a></p><?endif?>
                    <?if(!empty($project->project_devurl)):?><p><span class='lineName'><?=$this->lang->en("Dev")?>:</span><a href="<?=$project->project_devurl;?>" target="_blank"> <?=$project->project_devurl;?></a></p><?endif?>
                    <?if(!empty($project->project_devtools)):?><p><span class='lineName'><?=$this->lang->en("Tools")?>:</span> <?=$project->project_devtools;?></p><?endif?>
                    <?if(!empty($project->project_team)):?><p><span class='lineName'><?=$this->lang->en("Team")?>:</span> <?=$project->project_team;?></p><?endif?>
                    <?if(!empty($project->project_client)):?><p><span class='lineName'><?=$this->lang->en("Client")?>:</span> <?=$project->project_client;?></p><?endif?>
                    <?if(!empty($project->project_copyright)):?><p><span class='lineName'><?=$this->lang->en("Copyright")?>:</span> <?=$project->project_copyright;?></p><?endif?>
                    <?if(!empty($project->project_industries)):?><p><span class='lineName'><?=$this->lang->en("Industries")?>:</span> <?=$project->project_industries;?></p><?endif?>
                    <?if(!empty($project->license_id)):?><p><span class='lineName'><?=$this->lang->en("License")?>:</span> <?=$project->license_id;?></p><?endif?>
                </td>
            </tr>
    </tbody>
</table>

<? if (!empty($project->images)): ?>
<div class="galleryBlock">    
    <?if (count($project->images) > 1):?>
        <div class="galleryTopBar">    
        <?foreach($project->images as $img):?>
            <img onclick="$('#galleryImg<?=$project->project_id?>').attr('src',this.getAttribute('data-oimage')).css({maxWidth:this.getAttribute('data-owidth')});return false;" 
                 src='<?=imageSize(trim($img->image_src), "150x150")?>' 
                 data-oimage="<?=trim($img->image_src)?>"
                 data-owidth="<?=$img->image_width?>" data-oheight="<?=$img->image_height?>"
                 />
        <?endforeach?>
        </div>
    <?endif;?>
    <div class="galleryImg">
        <img id="galleryImg<?=$project->project_id?>" src='<?= trim($project->images[0]->image_src) ?>'
             style="max-width:<?=$project->image_width?>px;"
             />
    </div>
</div>
<?endif?>