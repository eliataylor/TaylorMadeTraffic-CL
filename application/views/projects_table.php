<?php if (isset($uProfile) && !empty($uProfile)): ?>
    <?php echo $this->load->view('user_profile'); ?>
<?php endif; ?>
<?php if (isset($cProfile) && !empty($cProfile)):?>
    <?php echo $this->load->view('company_profile');?>
<?php endif; ?>
<section class="userExperience">
        <?php if (isset($_GET['education']) && $uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>
        	<h3>EXPERIENCE</h3>
        <?php endif; ?>
<?php if (isset($qtfilter) && !empty($qtfilter)):?>
<div class="projectsTitle" >
    <h2>
    <?php if (isset($qtagOptions) && !empty($qtagOptions)):?>
    <select
    	<?php if (isset($uProfile) && !empty($uProfile) && !empty($uProfile['user_bio'])):?>
    		style="float:right;"
    	<?php endif; ?>
    	id="qTagSelector" onchange="if (this.options[this.selectedIndex].value != '') tmt.ajaxPage(this.options[this.selectedIndex].value); return false;" >
        <?php if ( (isset($cProfile) && !empty($cProfile)) || (isset($uProfile) && !empty($uProfile))):?>
        <option value=""><?php echo $this->lang->en('Other') . ' ' . $qtags?></option>
        <?php endif;?>
        <?php foreach($qtagOptions as $option):?>
            <option

                <?php $qurl = '/';
                if ($qtags == 'roles') {
                    $qurl .= 'roles?qtfilter='.$option->tag_key;
                } else {
                     $qurl .= (strpos($option->tag_type, 'team') === 0) ? 'team' : $option->tag_type;
                     $qurl .= '?qtfilter='.$option->tag_key;
                }
                ?>
                <?php if ($qtfilter == $option->tag_key && empty($cProfile) && empty($uProfile)): ?>
                    selected='selected'
                <?php endif; ?>

                value="<?php echo $qurl?>"  >
                        <?php echo $this->lang->msg($option->tag_key)?>

            </option>
        <?php endforeach; ?>
    </select>
    <?php endif;?>
    <?php if (isset($uProfile) && empty($uProfile)):?>
        <a class='teamInviteLink' href=''><?php echo $this->lang->en('Are You') . ' ' . $qtfilter . '?'?></a>
    <?php endif;?>

    <?php if (isset($groups) && count($groups) === 1):?>
    	<?php $count = array_keys($groups); $count = $count[0]; $count = count($groups[$count]['projects']); ?>
        <span style="float:right;" class="pageTotal">
            <?php echo $count?>
            <?php echo  ($count == 1) ? $this->lang->en('Project') : $this->lang->en('Projects');?>
        </span>
    <?php endif?>
    </h2>
</div>
<?php endif;?>

<table class="tablesorter projects_table">
    <tbody id="tableBody">

<?php foreach ($groups as $company): ?>


		<?php if (isset($showGroup) && count($company['projects']) > 0): ?>

			<?php if ($qhaving > 0 && $qhaving > count($company['projects'])) {
				continue; // dont show group
			}?>
      <?php $groupname = $company['company_tagname']; ?>

			<tr class="rowMargin"><td colspan="3"></td></tr>
			<tr class="companyHead" data-group="<?php echo $groupname?>"
				data-projectcount="<?php echo count($company['projects'])?>">
				<td class="col1"><h2>
					<?php if (isset($company['company_logo']) && isset($_GET['logos'])): ?>
						<img title="<?php echo $company['company_screenname']?>" alt="<?php echo $company['company_screenname']?>"  class="companyLogo" src="<?php echo $company['company_logo']?>" />
						<span class="company_screenname"><?php echo $company['company_screenname'];?></span>
					<?php else: ?>
						<?php echo $company['company_screenname'];?>
					<?php endif; ?>
				</h2></td>
				<td class="col2">
						<?php echo fDate($company['startDate'], 'month')?>
						-
						<?php echo fDate($company['endDate'], 'month')?>
				</td>
				<td class="col3">
					<span class="myrole"><?php echo htmlentities($company['company_myrole'])?></span>
					<?php if (isset($company['company_city'])): ?>
						<?php echo $company['company_city']?>
						<?php if ($company['company_telecommuting']): ?>
						(remote)
						<?php endif; ?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endif; ?>
	    <?php foreach ($company['projects'] as $row): ?>
	            <tr id="pid_<?php echo  $row->project_id ?>" data-pid="<?php echo  $row->project_id ?>"
	            	class="projectRow"
	            	<?php if (isset($groupname)):?>data-group="<?php echo $groupname?>"<?php endif; ?>
	             >

	                <td class="col1 image_src" >
	                    <?php if (!isset($_GET['noPics'])):?>
		                    <div class="projectImgMask">
                                <a href='/projects?pid=<?php echo  $row->project_id; ?>'>
                                    <?php if (substr($row->image_src, -4) === '.mp4'): ?>
                                        <video src='<?php echo $row->image_src; ?>'
                                               class="projectImg" muted="true" controls autoplay loop />
                                    <?php else: ?>
                                        <img  data-owidth="<?php echo  $row->image_width ?>"
                                              data-oheight="<?php echo  $row->image_height ?>"
                                              src='<?php echo ($row->image_width > 1000) ? imageSize($row->image_src, "300x300") : $row->image_src; ?>'
                                              class="projectImg" />
                                    <? endif; ?>
                                </a>
		                    </div>
		<!--                    TODO, leave for old browser support from reflection <div class="blackOutFadeBG"></div>-->
		                    <div class="reflectionMask">
                                <?php if (substr($row->image_src, -4) === '.mp4'): ?>
                                    <video src='<?php echo $row->image_src; ?>'
                                           class="reflection" muted="true" loop />
                                <?php else: ?>
                                    <img class="reflection" src='<?php echo ($row->image_width > 1000) ? imageSize($row->image_src, "300x300") : $row->image_src; ?>' />
                                <? endif; ?>

		                    </div>
		                    <?php if (isset($row->images) && count($row->images) > 1):?>
		                        <?php foreach($row->images as $index=>$img):?>
		                            <?php if ($index==0):?>
		                                <a class="fancybox" data-fancybox-group="gallery<?php echo $row->project_id?>" href="<?php echo  $row->image_src; ?>"><?php echo  $row->totalImages -1 ?> <?php echo $this->lang->en('more images')?></a>
		                            <?php else:?>
		                                <a style="display:none;" class="fancybox" href="<?php echo $img->image_src?>" data-fancybox-group="gallery<?php echo $row->project_id?>" ></a>
		                            <?php endif;?>
		                        <?php endforeach?>
		                    <?php endif;?>
	                    <?php endif;?>
	                </td>
	                <td class="col2 project_title" colspan="2" >
	                    <h3><a href='/projects?pid=<?php echo  $row->project_id; ?>'><?php echo  $row->project_title; ?></a>
                      <?php if(!empty($row->project_subtitle)):?>
                        <br />
                        <small style='font-size:50%;'><em><?php echo $row->project_subtitle;?></em></small>
                      <?php endif; ?>
                      </h3>

	                    <?php if (!empty($row->project_desc)): ?><div class="prjDesc"><?php echo  $this->lang->ugc($row->project_desc); ?></div><?php endif ?>
	                    <?php if (!empty($row->project_technotes)): ?><div class="technotes"><?php echo  $this->lang->ugc($row->project_technotes); ?></div><?php endif ?>

	                    <div class="projectTags">
	                        <p class="project_startdate"><span class='lineName'><?php echo  $this->lang->en("Started") ?>:</span> <?php echo  $row->project_startdate; ?></p>
	                        <?php if (!empty($row->project_launchdate)): ?><p class="project_launchdate"><span class='lineName'><?php echo  $this->lang->en("Launched") ?>/<?php echo  $this->lang->en("Lasted") ?>:</span> <?php echo  $row->project_launchdate; ?></p><?php endif ?>
	                        <?php if (!empty($row->project_liveurl)): ?>
	                        <p class="projectLink">
	                            <a href="<?php echo  $row->project_liveurl; ?>" target="_blank"> <?php echo  $row->project_liveurl; ?></a>
	                        </p>
	                        <?php endif ?>
	                        <?php if (!empty($row->project_devurl) && $row->project_devurl != $row->project_liveurl): ?>
	                        <p class="projectLink"><a href="<?php echo  $row->project_devurl; ?>" target="_blank"> <?php echo  $row->project_devurl; ?></a></p><?php endif ?>
	                        <?php if (!empty($row->project_devtools)): ?><p class="project_devtools"><span class='lineName'><?php echo  $this->lang->en("Technologies") ?>:</span> <?php echo  $row->project_devtools; ?></p><?php endif ?>
	                        <?php if (!empty($row->project_industries)): ?><p class="industries"><span class='lineName'><?php echo  $this->lang->en("Industries") ?>:</span> <?php echo  ucwords($row->project_industries); ?></p><?php endif ?>
	                        <?php if (!empty($row->project_team)): ?><p  class="team"><span class='lineName'><?php echo  $this->lang->en("Team") ?>:</span> <?php echo  $row->project_team; ?></p><?php endif ?>
	                        <?php if (!empty($row->project_companies)): ?><p class="companies"><span class='lineName'><?php echo  $this->lang->en("Companies") ?>/<?php echo  $this->lang->en("Brands") ?>:</span> <?php echo  $row->project_companies; ?></p><?php endif ?>
	                        <?php if (!empty($row->license_id)): ?><!--<p><span class='lineName'><?php echo  $this->lang->en("License") ?>:</span> <?php echo  $row->license_id; ?></p>--><?php endif ?>
	                    </div>
	                </td>
	            </tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
    </tbody>
</table>
</section>
