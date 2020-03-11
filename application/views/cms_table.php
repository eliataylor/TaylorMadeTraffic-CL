<table class="tablesorter">
    <caption>Total <?php echo count($tableRows)?></caption>
    <thead><tr>
            <? foreach ($headers as $key=>$head): ?>
                <th class="<?php echo  $key ?>"><?php echo  $head ?></th>
            <? endforeach; ?>
        </tr></thead>    
    <tbody id="tableBody">
        <? foreach ($tableRows as $row): ?>
            <tr>
                <? foreach ($headers as $key=> $head): ?>
                        <td class="<?php echo  $key ?>">    
                        <?if ($key === "tag_key"):?>
                            <a href='/admin?qtags=<?php echo $qtags?>&qtfilter=<?php echo $row->tag_key?>' ><?php echo $row->tag_key?></a>
                        <?elseif (strpos($key, 'url') > 0):?>
                            <a href='<?php echo $row->$key?>' target="_blank" ><?php echo $row->$key?></a>
                        <?elseif ($key == 'image_src'):?>
                            <? if (!is_file(STATIC_CD.$row->$key)): ?>
                                404: <?php echo STATIC_CD.$row->$key?> 
                            <?else:?>
                                <div class="projectImgMask">
                                    <img src='<?php echo imageSize($row->key, "300x300")?>' 
                                         class="projectImg" />
                                </div>
                            <?endif?>
                        <?else:?>                            
                            <?php echo  (!isset($row->$key) || empty($row->$key)) ? "" : ellipse($row->$key, 40) ?>
                        <?endif;?>
                        </td>
                <? endforeach; ?>
            </tr>
            <tr class="spacer"></tr>
        <? endforeach; ?>
    </tbody>
</table>