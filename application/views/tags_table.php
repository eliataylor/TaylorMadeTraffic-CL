<table class="tablesorter">
    <caption><?=count($tableRows)?> <?=$this->lang->line('Tags')?></caption>
    <thead><tr>
            <? foreach ($headers as $key=>$head): ?>
                <th class="blackShadowBG <?= $key ?>"><?= $head ?></th>
            <? endforeach; ?>
        </tr></thead>    
    <tbody id="tableBody">
        <? foreach ($tableRows as $index=>$row): ?>
            <tr class="spacer"></tr>
            <tr id="tag_<?=$index?>" data-qtype="<?=$row->tag_type?>" data-qtfilter="<?=$row->tag_key?>" >
                <? foreach ($headers as $key=> $head): ?>
                        <td class="<?= $key ?>">    
                        <?if ($key === "tag_key"):?>
                            <? if ($qtags == 'roles'):?>
                            <a href='/roles?qtfilter=<?=$row->tag_key?>' ><?=$row->tag_key?></a>
                            <?else:?>
                            <a href='/<?=(strpos($row->tag_type, 'team') === 0) ? 'team' : $row->tag_type;?>?qtfilter=<?=$row->tag_key?>' ><?=$row->tag_key?></a>
                            <?endif;?>
                        <?else:?>                            
                            <?= (!isset($row->$key) || empty($row->$key)) ? "" : ellipse($row->$key, 40) ?>
                        <?endif;?>
                        </td>
                <? endforeach; ?>
            </tr>
            <tr class="spacer"></tr>
        <? endforeach; ?>
    </tbody>
</table>