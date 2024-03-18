<?php if (isset($uProfile) && !empty($uProfile)): ?>
    <?php $this->load->view('user_profile'); ?>
<?php endif; ?>


<?php if (isset($cProfile) && !empty($cProfile)): ?>
    <?php $this->load->view('company_profile'); ?>
<?php endif; ?>


<section class="userExperience">
    <?php if (isset($_GET['education']) && $uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>
        <h3>EXPERIENCE</h3>
    <?php endif; ?>
    <?php if (empty($uProfile) && isset($qtfilter) && !empty($qtfilter)): ?>

        <div class="projectsTitle row">
            <div class="col">
            <h2>
                <?php echo $qtfilter; ?>
            </h2>
            </div>
            <div class="col">
                <?php if (isset($groups) && count($groups) === 1): ?>
                    <?php $count = array_keys($groups);
                    $count = $count[0];
                    $count = count($groups[$count]['projects']); ?>
                    <span style="float:right;" class="pageTotal">
                        <?php echo $count ?>
                        <?php echo ($count == 1) ? $this->lang->en('Project') : $this->lang->en('Projects'); ?>
                    </span>

                <?php endif ?>
            </div>
        </div>
    <?php endif; ?>

    <table class="tablesorter projects_table <?php echo isset($_GET['noPics']) ? 'noPics' : ''; ?>">
        <tbody id="tableBody">

        <?php foreach ($groups as $company): ?>

            <?php if (isset($showGroup) && count($company['projects']) > 0): ?>

                <?php if ($qhaving > 0 && $qhaving > count($company['projects'])) {
                    continue; // don't show group
                } ?>
                <?php $groupname = $company['company_tagname']; ?>

                <tr class="companyHead" data-group="<?php echo $groupname ?>"
                    data-projectcount="<?php echo count($company['projects']) ?>">
                    <td class="col1"><h2>
                            <?php if (isset($company['company_logo']) && isset($_GET['logos'])): ?>
                                <img title="<?php echo $company['company_screenname'] ?>"
                                     alt="<?php echo $company['company_screenname'] ?>" class="companyLogo"
                                     src="<?php echo $company['company_logo'] ?>"/>
                                <span class="company_screenname"><?php echo $company['company_screenname']; ?></span>
                            <?php else: ?>
                                <?php echo $company['company_screenname']; ?>
                            <?php endif; ?>
                        </h2>
                    </td>
                    <td class="col2">
                        <?php echo fDate($company['startDate'], 'month') ?>
                        -
                        <?php echo ($company['endDate'] === 'Present') ? $company['endDate'] : fDate($company['endDate'], 'month') ?>
                    </td>
                    <td class="col3">

                        <?php if ($company['company_myrole']): ?><span
                                class="myrole"><?php echo htmlentities($company['company_myrole']) ?></span><?php endif; ?>
                        <?php if (isset($company['company_city'])): ?>
                            <?php echo $company['company_city'] ?>
                            <?php if ($company['company_telecommuting']): ?>
                                (remote)
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($company['projects'] as $row): ?>
                <tr class="projectRow"
                    id="pid_<?php echo $row->project_id ?>"
                    data-pid="<?php echo $row->project_id ?>"
                    <?php if (isset($groupname)): ?>data-group="<?php echo $groupname ?>"<?php endif; ?>
                >
                    <?php if (!isset($_GET['noPics'])): ?>
                        <td class="col1 image_src">
                            <?php $this->load->view('project_images', ['row'=>$row]); ?>
                        </td>
                    <?php endif; ?>
                    <td class="col2 project_title" colspan="<?php echo isset($_GET['noPics']) ? 3 : 2 ?>">
                        <?php $this->load->view('project_item', ['row'=>$row]); ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (!isset($_GET['cv'])): ?>

    <div id="qTagSelectorBlock" class="row" style="margin-top:50px">
        <div>
            <?php if (isset($qtagOptions) && !empty($qtagOptions)): ?>
                <h6 class="caption">Other <?php echo $this->lang->msg($qtags); ?></h6>
                <select id="qTagSelector"
                        onchange="if (this.options[this.selectedIndex].value != '') tmt.ajaxPage(this.options[this.selectedIndex].value); return false;">

                    <option value=""><?php echo $this->lang->en('Other') . ' ' . $qtags ?></option>

                    <?php foreach ($qtagOptions as $option): ?>
                        <option

                            <?php $qurl = '/';
                            if ($qtags == 'roles') {
                                $qurl .= 'roles?qtfilter=' . $option->tag_key;
                            } else {
                                $qurl .= (strpos($option->tag_type, 'team') === 0) ? 'team' : $option->tag_type;
                                $qurl .= '?qtfilter=' . $option->tag_key;
                            }
                            ?>
                            <?php if ($qtfilter == $option->tag_key): ?>
                                selected='selected'
                            <?php endif; ?>

                                value="<?php echo $qurl ?>">
                            <?php echo $this->lang->msg($option->tag_key) ?>

                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>
        <div class="col"><?php if (isset($uProfile) && empty($uProfile)): ?>
                <a class='teamInviteLink'
                   href=''><?php echo $this->lang->en('Are You') . ' ' . $qtfilter . '?' ?></a>
            <?php endif; ?>
        </div>
    </div>

    <?php endif; ?>
</section>
