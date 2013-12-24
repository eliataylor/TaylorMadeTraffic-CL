<table class="tablesorter">
    <caption>Total <?=count($tableRows)?></caption>
    <thead><tr>
            <? foreach ($headers as $key=>$head): ?>
                <th class="<?= $key ?>"><?= $head ?></th>
            <? endforeach; ?>
        </tr></thead>    
    <tbody id="tableBody">
        <? foreach ($tableRows as $index=>$row): ?>
            <tr id="tag_<?=$index?>" data-qtype="<?=$row->tag_type?>" data-qtfilter="<?=$row->tag_key?>" >
                <? foreach ($headers as $key=> $head): ?>
                        <td class="<?= $key ?>">    
                        <?if ($key === "tag_key"):?>
                            <a href='/<?=$row->tag_type?>?qtfilter=<?=$row->tag_key?>' ><?=$row->tag_key?></a>
                        <?else:?>                            
                            <?= (!isset($row->$key) || empty($row->$key)) ? "" : ellipse($row->$key, 40) ?>
                        <?endif;?>
                        </td>
                <? endforeach; ?>
            </tr>
        <? endforeach; ?>
    </tbody>
</table>