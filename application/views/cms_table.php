<table class="tablesorter">
    <caption>Total <?=count($tableRows)?></caption>
    <thead><tr>
            <? foreach ($headers as $key=>$head): ?>
                <th class="<?= $key ?>"><?= $head ?></th>
            <? endforeach; ?>
        </tr></thead>    
    <tbody id="tableBody">
        <? foreach ($tableRows as $row): ?>
            <tr>
                <? foreach ($headers as $key=> $head): ?>
                        <td class="<?= $key ?>">    
                        <?if ($key === "tag_key"):?>
                            <a href='/admin?qtags=<?=$qtags?>&qtfilter=<?=$row->tag_key?>' ><?=$row->tag_key?></a>
                        <?elseif (strpos($key, 'url') > 0):?>
                            <a href='<?=$row->$key?>' target="_blank" ><?=$row->$key?></a>
                        <?elseif ($key == 'image_src'):?>
                            <? if (!is_file(STATIC_CD.$row->$key)): ?>
                                404: <?=STATIC_CD.$row->$key?> 
                            <?else:?>
                                <div class="projectImgMask">
                                    <img src='<?=imageSize($row->key, "300x300")?>' 
                                         class="projectImg" />
                                </div>
                            <?endif?>
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