<?php if (isset($uProfile) && !empty($uProfile)):?>
    <div class='userProfile'>
        <h1 class="userName">
        <?php echo $uProfile['user_screenname'];?>
        <span class='sociallinks'>
            <?php if (!empty($uProfile['user_fburl'])):?>
                <a target='_blank' href='<?php echo $uProfile['user_fburl'];?>'>
                <img src="/wwwroot/images/fbIcon.png" title="<?php echo $uProfile['user_fburl'];?>" />
                </a>
            <?php endif?>
            <?php if (!empty($uProfile['user_linkdinurl'])):?>
                <a target='_blank' href='<?php echo $uProfile['user_linkdinurl'];?>'>
                <img title="<?php echo $uProfile['user_linkdinurl'];?>" src="/wwwroot/images/linkedinIcon.png" />
                </a>
            <?php endif?>
            <?php if (!empty($uProfile['user_googleurl'])):?><li><a target='_blank' href='<?php echo $uProfile['user_googleurl'];?>'><?php echo $uProfile['user_googleurl'];?></a></li><?php endif?>
        </span>
        </h1>

        <?php if (!empty($uProfile['user_bio'])):?>
        <div class='userBio'>
            <?php echo $this->lang->ugc($uProfile['user_bio']);?>
        </div>
        <?php endif?>
    </div>
<?php elseif (isset($cProfile) && !empty($cProfile)):?>
    <div class='userProfile'>
        <h1 class="userName">
        <?php echo $cProfile['company_screenname'];?>
        <span class='sociallinks'>
            <?php if (!empty($cProfile['company_fburl'])):?>
                <a target='_blank' href='<?php echo $cProfile['company_fburl'];?>'>
                <img src="/wwwroot/images/fbIcon.png" title="<?php echo $cProfile['company_fburl'];?>" />
                </a>
            <?php endif?>
            <?php if (!empty($cProfile['company_linkdinurl'])):?>
                <a target='_blank' href='<?php echo $cProfile['company_linkdinurl'];?>'>
                <img title="<?php echo $cProfile['company_linkdinurl'];?>" src="/wwwroot/images/linkedinIcon.png" />
                </a>
            <?php endif?>
            <?php if (!empty($cProfile['company_googleurl'])):?><li><a target='_blank' href='<?php echo $cProfile['company_googleurl'];?>'><?php echo $cProfile['company_googleurl'];?></a></li><?php endif?>
        </span>
        </h1>

        <?php if (!empty($cProfile['company_bio'])):?>
        <div class='userBio'>
            <?php echo $this->lang->ugc($cProfile['company_bio']);?>
        </div>
        <?php endif?>
    </div>
<?php endif; ?>

<table class="tablesorter projects_table biz_plans">
    <tbody id="tableBody">
    <?php foreach ($tableRows as $row): ?>
            <tr id="pid_<?php echo  $row->project_id ?>" data-pid="<?php echo  $row->project_id ?>" >

                <td class="col1 image_src">
                        <a class="fancybox" data-fancybox-group="gallery<?php echo $row->project_id?>" href="<?php echo  $row->image_src; ?>">
                            <img  data-owidth="<?php echo  $row->image_width ?>"
                                  data-oheight="<?php echo  $row->image_height ?>"
                                  src='<?php echo ($row->image_width > 1000) ? imageSize($row->image_src, "300x300") : $row->image_src; ?>'
                                  class="projectImg" />
                        </a>
                        <?php if (isset($row->images) && count($row->images) > 1):?>
                            <?php foreach($row->images as $index=>$img):?>
                                <?php if ($index==0):?>
                                    <a class="fancybox" data-fancybox-group="gallery<?php echo $row->project_id?>" href="<?php echo  $row->image_src; ?>"><?php echo  $row->totalImages -1 ?> <?php echo $this->lang->en('more images')?></a>
                                <?php else:?>
                                    <a style="display:none;" class="fancybox" href="<?php echo $img->image_src?>" data-fancybox-group="gallery<?php echo $row->project_id?>" ></a>
                                <?php endif;?>
                            <?php endforeach?>
                        <?php endif;?>
                </td>
                <td class="col2 project_title">
                    <h3><a href='/projects?pid=<?php echo  $row->project_id; ?>'><?php echo  $row->project_title; ?></a></h3>

                    <?php if (!empty($row->project_liveurl) || !empty($row->project_devurl)): ?>
                        <div class="prjSection prjLinks">
                                <?php if (!empty($row->project_liveurl)): ?>
                                    <a href="<?php echo  $row->project_liveurl; ?>" target="_blank"> <?php echo  $row->project_liveurl; ?></a>
                                <?php endif ?>
                                <?php if (!empty($row->project_devurl)): ?>
                                    <a href="<?php echo  $row->project_devurl; ?>" target="_blank"> <?php echo  $row->project_devurl; ?></a>
                                <?php endif ?>
                        </div>
                    <?php endif ?>
                    <?php if (!empty($row->project_pitch)): ?><div class="prjSection prjPitch">
                        <?php echo  $this->lang->ugc($row->project_pitch); ?></div>
                    <?php endif ?>

                    <?php if (!empty($row->project_bizmodel)): ?>
                        <div class="prjSection prjBiz">
                            <h4 class="sectTitle">
                                <?php echo $this->lang->en('Business Model')?>
                            </h4>
                            <?php echo  $this->lang->ugc($row->project_bizmodel); ?>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($row->project_competition)): ?>
                        <div class="prjSection prjCompetition">
                            <h4 class="sectTitle">
                                <?php echo $this->lang->en('Competition')?>
                            </h4>
                            <?php echo  $this->lang->ugc($row->project_competition); ?>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($row->project_marketresearch)): ?>
                        <div class="prjSection prjResearch">
                            <h4 class="sectTitle">
                                <?php echo $this->lang->en('Target Markets')?> / <?php echo $this->lang->en('Research')?>
                            </h4>
                            <?php echo  $this->lang->ugc($row->project_marketresearch); ?>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($row->project_expenses)): ?>
                        <div class="prjSection prjCosts">
                            <h4 class="sectTitle">
                                <?php echo $this->lang->en('Costs by Department')?>
                            </h4>
                            <?php echo  $this->lang->ugc($row->project_expenses); ?>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($row->project_futuredate)): ?>
                        <div class="prjSection prjDates">
                            <h4 class="sectTitle">
                                <?php echo $this->lang->en('Roadmap')?>
                            </h4>
                            <?php echo  $this->lang->ugc($row->project_futuredate); ?>
                        </div>
                    <?php endif ?>

                </td>
            </tr>
<?php endforeach; ?>
    </tbody>
</table>
