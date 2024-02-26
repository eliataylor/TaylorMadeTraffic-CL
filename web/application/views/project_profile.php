<table class="tablesorter">
    <tbody id="tableBody">
            <tr id="even pid_<?php echo $project->project_id?>" data-pid="<?php echo $project->project_id?>" >
                <td style="width:60%" class="col2">
                    <h3><?php echo $project->project_title;?>
                    <?php if(!empty($project->project_subtitle)):?>
                      <br />
                      <small style='font-size:65%;'><em><?php echo $project->project_subtitle;?></em></small>
                    <?php endif; ?>
                    </h3>

                    <?php if(!empty($project->project_desc)):?><p class="prjDesc"><?php echo $this->lang->ugc($project->project_desc);?></p><?php endif?>
                    <?php if(!empty($project->project_technotes)):?><p><div class="technotes"><?php echo $this->lang->ugc($project->project_technotes);?></div></p><?php endif?>
                <?php if (false || $me['con']['swidth'] > 980):?>
                </td>
                <td style="width:40%" class="col3">
                <?php endif;?>

                    <p><span class='lineName'><?php echo $this->lang->en("Started")?>:</span> <?php echo $project->project_startdate;?></p>
                    <?php if(!empty($project->project_launchdate)):?><p><span class='lineName'><?php echo $this->lang->en("Launched/Lasted:")?>:</span> <?php echo $project->project_launchdate;?></p><?php endif?>
                    <?php if(!empty($project->project_liveurl)):?><p><span class='lineName'><?php echo $this->lang->en("Live")?>:</span><a href="<?php echo $project->project_liveurl;?>" target="_blank"> <?php echo $project->project_liveurl;?></a></p><?php endif?>
                    <?php if(!empty($project->project_devurl)):?><p><span class='lineName'><?php echo $this->lang->en("Dev")?>:</span><a href="<?php echo $project->project_devurl;?>" target="_blank"> <?php echo $project->project_devurl;?></a></p><?php endif?>
                    <?php if(!empty($project->project_devtools)):?><p><span class='lineName'><?php echo $this->lang->en("Tools")?>:</span> <?php echo $project->project_devtools;?></p><?php endif?>
                    <?php if(!empty($project->project_team)):?><p><span class='lineName'><?php echo $this->lang->en("Team")?>:</span> <?php echo $project->project_team;?></p><?php endif?>
                    <?php if(!empty($project->project_companies)):?><p><span class='lineName'><?php echo $this->lang->en("Companies")?>:</span> <?php
                        echo mergeStringsUniquely($project->project_companies, $project->project_client, $project->project_copyright);
                        ?>
                        </p><?php endif?>
                    <?php if(!empty($project->project_industries)):?><p><span class='lineName'><?php echo $this->lang->en("Industries")?>:</span> <?php echo $project->project_industries;?></p><?php endif?>
                    <?php if(!empty($project->license_id)):?><p><span class='lineName'><?php echo $this->lang->en("License")?>:</span> <?php echo $project->license_id;?></p><?php endif?>
                </td>
            </tr>
    </tbody>
</table>

<?php if (!empty($project->images)): ?>
<div class="galleryBlock">
    <?php if (count($project->images) > 0):?>
        <div class="galleryTopBar">
        <?php foreach($project->images as $img):?>
            <a class="fancybox" href="<?php echo $img->image_src?>" data-fancybox-group="gallery<?php echo $project->project_id?>" >
                <?php if (substr($img->image_src, -4) === '.mp4'): ?>
                    <video src='<?php echo $img->image_src; ?>'
                      class="projectImg" muted="true" />
                <?php else: ?>
                        <img src='<?php echo imageSize($img->image_src, "150x150")?>'
                             data-oimage="<?php echo $img->image_src?>"
                             data-owidth="<?php echo $img->image_width?>" data-oheight="<?php echo $img->image_height?>"
                             />
                <?php endif; ?>
            </a>
        <?php endforeach?>
        </div>
    <?php endif;?>
</div>
<?php endif?>
