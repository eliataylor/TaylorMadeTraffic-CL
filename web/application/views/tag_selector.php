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
