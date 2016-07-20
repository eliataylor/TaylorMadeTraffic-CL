<? if (isset($uProfile) && !empty($uProfile)):?>
    <?=$this->load->view('user_profile');?>    
<?php endif; ?>
<? if (isset($cProfile) && !empty($cProfile)):?>
    <?=$this->load->view('company_profile');?>
<? endif; ?>

<?if (isset($qtfilter) && !empty($qtfilter)):?>
<div class="projectsTitle" >
    <h2>
    <?if (isset($qtagOptions) && !empty($qtagOptions)):?>    
    <select 
    	<? if (isset($uProfile) && !empty($uProfile) && !empty($uProfile['user_bio'])):?>
    		style="float:right;"
    	<?php endif; ?>
    	id="qTagSelector" onchange="if (this.options[this.selectedIndex].value != '') tmt.ajaxPage(this.options[this.selectedIndex].value); return false;" >
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

    <?if (isset($groups) && count($groups) === 1):?>
    	<?php $count = array_keys($groups); $count = $count[0]; $count = count($groups[$count]['projects']); ?>
        <span style="float:right;" class="pageTotal">
            <?=$count?>
            <?= ($count == 1) ? $this->lang->en('Project') : $this->lang->en('Projects');?>
        </span>
    <?endif?>
    </h2>                
</div>            
<?endif;?>

<table class="tablesorter projects_table">
    <tbody id="tableBody">        
    
<? foreach ($groups as $company): ?> 
		
		<?php 
		$groupname = $company['company_tagname']; ?>
		
		<?php if (isset($showGroup) && count($company['projects']) > 0): ?>
		
			
			<?php if ($qhaving > 0 && $qhaving > count($company['projects'])) {
				continue; // dont show group
			}?>
			
			<tr class="rowMargin"><td colspan="3"></td></tr>
			<tr class="companyHead" data-group="<?=$groupname?>"  
				data-projectcount="<?=count($company['projects'])?>">
				<td class="col1"><h2>
					<?php if (isset($company['company_logo'])): ?>
						<img title="<?=$company['company_screenname']?>" alt="<?=$company['company_screenname']?>"  class="companyLogo" src="<?=$company['company_logo']?>" /> 				
						<span class="company_screenname"><?=$company['company_screenname'];?></span> 
					<?php else: ?>
						<?=$company['company_screenname'];?> 
					<?php endif; ?>
				</h2></td>
				<td class="col2">
						<?=fDate($company['startDate'], 'month')?>
						- 
						<?=fDate($company['endDate'], 'month')?>
				</td>
				<td class="col3">
					<?php if (isset($company['company_city'])): ?>
						<?=$company['company_city']?>
						<?php if ($company['company_telecommuting']): ?>
						(remote)
						<?php endif; ?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endif; ?>
	    <?php foreach ($company['projects'] as $row): ?>
	            <tr id="pid_<?= $row->project_id ?>" data-pid="<?= $row->project_id ?>"
	            	class="projectRow"
	            	<?php if (isset($groupname)):?>data-group="<?=$groupname?>"<?php endif; ?>
	             >
	                
	                <td class="col1 image_src" >	                   
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
	                </td>
	                <td class="col2 project_title" colspan="2" >
	                    <h3><a href='/projects?pid=<?= $row->project_id; ?>'><?= $row->project_title; ?></a></h3>
	                    
	                    <? if (!empty($row->project_desc)): ?><div class="prjDesc"><?= $this->lang->ugc($row->project_desc); ?></div><? endif ?>
	                    <? if (!empty($row->project_technotes)): ?><div class="technotes"><?= $this->lang->ugc($row->project_technotes); ?></div><? endif ?>
	                    
	                    <div class="projectTags">
	                        <p><span class='lineName'><?= $this->lang->en("Started") ?>:</span> <?= $row->project_startdate; ?></p>
	                        <? if (!empty($row->project_launchdate)): ?><p><span class='lineName'><?= $this->lang->en("Launched") ?>/<?= $this->lang->en("Lasted") ?>:</span> <?= $row->project_launchdate; ?></p><? endif ?>
	                        <? if (!empty($row->project_liveurl)): ?><p  class="projectLink"><span class='lineName'><?= $this->lang->en("Live") ?>:</span>                        
	                            <a href="<?= $row->project_liveurl; ?>" target="_blank"> <?= $row->project_liveurl; ?></a>
	                        </p><? endif ?>
	                        <? if (!empty($row->project_devurl) && $row->project_devurl != $row->project_liveurl): ?><p class="projectLink"><span class='lineName'><?= $this->lang->en("Dev") ?>:</span><a href="<?= $row->project_devurl; ?>" target="_blank"> <?= $row->project_devurl; ?></a></p><? endif ?>
	                        <? if (!empty($row->project_devtools)): ?><p><span class='lineName'><?= $this->lang->en("Technologies") ?>:</span> <?= $row->project_devtools; ?></p><? endif ?>
	                        <? if (!empty($row->project_industries)): ?><p class="industries"><span class='lineName'><?= $this->lang->en("Industries") ?>:</span> <?= ucwords($row->project_industries); ?></p><? endif ?>
	                        <? if (!empty($row->project_team)): ?><p  class="team"><span class='lineName'><?= $this->lang->en("Team") ?>:</span> <?= $row->project_team; ?></p><? endif ?>
	                        <? if (!empty($row->project_companies)): ?><p class="companies"><span class='lineName'><?= $this->lang->en("Companies") ?>/<?= $this->lang->en("Brands") ?>:</span> <?= $row->project_companies; ?></p><? endif ?>
	                        <? if (!empty($row->license_id)): ?><!--<p><span class='lineName'><?= $this->lang->en("License") ?>:</span> <?= $row->license_id; ?></p>--><? endif ?>
	                    </div>
	                </td>
	            </tr>
			<? endforeach; ?>
		<? endforeach; ?>
    </tbody>
</table>