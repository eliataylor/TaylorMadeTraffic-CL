<table class="tablesorter tags_table">
    <thead><tr>
            <?php $index = 1;?>
            <? foreach ($headers as $key=>$head): ?>
                <th class="col<?php echo $index?> <?php echo $key ?>
                  <?php if ($key=='tag_date' && $qtags == 'companies') echo 'headerSortUp';
                  else if ($key=='tag_key' && $qtags == 'technologies') echo 'headerSortUp';
                  else if ($key=='tag_key' && $qtags == 'years') echo 'headerSortUp';
                  else if ($key=='count' && $qtags == 'industries') echo 'headerSortUp'; ?>"
                    >
                    <?php echo ($key != "tag_key") ? $head : '<p>'.$this->lang->en('Tags').'</p>'; ?>
                </th>
            <? $index++;  endforeach; ?>
        </tr></thead>
    <tbody id="tableBody">
        <? foreach ($tableRows as $rowNum=>$row): ?>
            <tr class="<?php echo ($rowNum&1)? 'odd' : 'even' ?>" id="tag_<?php echo $rowNum?>" data-qtype="<?php echo $row->tag_type?>" data-qtfilter="<?php echo $row->tag_key?>" >
                <?php $index = 1; ?>
                <? foreach ($headers as $key=> $head): ?>
                        <td class="col<?php echo $index?> <?php echo  $key ?>">
                        <?if ($key === "tag_key"):?>
                            <? if ($qtags == 'roles'):?>
                            <a href='/roles?qtfilter=<?php echo $row->tag_key?>' ><?php echo ucwords($this->lang->msg($row->tag_key))?></a>
                            <?else:?>
                            <a href='/<?php echo (strpos($row->tag_type, 'team') === 0) ? 'team' : $row->tag_type;?>?qtfilter=<?php echo $row->tag_key?>' ><?php echo   ucwords($this->lang->msg($row->tag_key))?></a>
                            <?endif;?>
                        <?else:?>
                            <?php echo  (!isset($row->$key) || empty($row->$key)) ? "" : ucwords(ellipse($row->$key, 40)) ?>
                        <?endif;?>
                        </td>
                        <?php $index++; ?>
                <? endforeach; ?>
            </tr>
            <? endforeach; ?>
    </tbody>
</table>
