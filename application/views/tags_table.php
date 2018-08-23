<table class="tablesorter tags_table">
    <thead><tr>
            <?php $index = 1;?>
            <? foreach ($headers as $key=>$head): ?>
                <th class="col<?=$index?> <?= $key ?>
                  <?php if ($key=='tag_date' && $qtags == 'companies') echo 'headerSortUp';
                  else if ($key=='tag_key' && $qtags == 'technologies') echo 'headerSortUp';
                  else if ($key=='tag_key' && $qtags == 'years') echo 'headerSortUp';
                  else if ($key=='count' && $qtags == 'industries') echo 'headerSortUp'; ?>"
                    >
                    <?=($key != "tag_key") ? $head : '<p>'.$this->lang->en('Tags').'</p>'; ?>
                </th>
            <? $index++;  endforeach; ?>
        </tr></thead>
    <tbody id="tableBody">
        <? foreach ($tableRows as $rowNum=>$row): ?>
            <tr class="<?=($rowNum&1)?'odd' : 'even'?>" id="tag_<?=$rowNum?>" data-qtype="<?=$row->tag_type?>" data-qtfilter="<?=$row->tag_key?>" >
                <?php $index = 1; ?>
                <? foreach ($headers as $key=> $head): ?>
                        <td class="col<?=$index?> <?= $key ?>">
                        <?if ($key === "tag_key"):?>
                            <? if ($qtags == 'roles'):?>
                            <a href='/roles?qtfilter=<?=$row->tag_key?>' ><?=ucwords($this->lang->msg($row->tag_key))?></a>
                            <?else:?>
                            <a href='/<?=(strpos($row->tag_type, 'team') === 0) ? 'team' : $row->tag_type;?>?qtfilter=<?=$row->tag_key?>' ><?=  ucwords($this->lang->msg($row->tag_key))?></a>
                            <?endif;?>
                        <?else:?>
                            <?= (!isset($row->$key) || empty($row->$key)) ? "" : ucwords(ellipse($row->$key, 40)) ?>
                        <?endif;?>
                        </td>
                        <?php $index++; ?>
                <? endforeach; ?>
            </tr>
            <? endforeach; ?>
    </tbody>
</table>
