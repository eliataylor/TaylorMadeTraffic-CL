<table class="tablesorter">
    <thead><tr>            
            <?php $index = 1;?>
            <? foreach ($headers as $key=>$head): ?>
                <th class="col<?=$index?> <?= $key ?> <?= ($key=='tag_date' && $qtags == 'companies') ? 'headerSortUp' : ''; ?>">
                    <?=($key != "tag_key") ? $head : ''; ?>
                </th>
            <? $index++;  endforeach; ?>
        </tr></thead>        
    <tbody id="tableBody">
        <? foreach ($tableRows as $index=>$row): ?>
            <tr class="spacer static"><? foreach ($headers as $head): ?><td></td><?endforeach?></tr>
            <tr id="tag_<?=$index?>" data-qtype="<?=$row->tag_type?>" data-qtfilter="<?=$row->tag_key?>" >
                <?php $index = 1; ?>
                <? foreach ($headers as $key=> $head): ?>
                        <td class="col<?=$index?> <?= $key ?>">    
                        <?if ($key === "tag_key"):?>
                            <? if ($qtags == 'roles'):?>
                            <a href='/roles?qtfilter=<?=$row->tag_key?>' ><?=ucwords($row->tag_key)?></a>
                            <?else:?>
                            <a href='/<?=(strpos($row->tag_type, 'team') === 0) ? 'team' : $row->tag_type;?>?qtfilter=<?=$row->tag_key?>' ><?=  ucwords($row->tag_key)?></a>
                            <?endif;?>
                        <?else:?>                            
                            <?= (!isset($row->$key) || empty($row->$key)) ? "" : ucwords(ellipse($row->$key, 40)) ?>
                        <?endif;?>
                        </td>
                        <?php $index++; ?>
                <? endforeach; ?>
            </tr>
            <tr class="spacer static"><? foreach ($headers as $head): ?><td></td><?endforeach?></tr>
            <? endforeach; ?>
    </tbody>
</table>