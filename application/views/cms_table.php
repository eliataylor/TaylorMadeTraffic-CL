<table class="tablesorter">
    <caption>Total <?php echo count($tableRows)?></caption>
    <thead><tr>
            <?php foreach ($headers as $key=>$head): ?>
                <th class="<?php echo  $key ?>"><?php echo  $head ?></th>
            <?php endforeach; ?>
        </tr></thead>    
    <tbody id="tableBody">
        <?php foreach ($tableRows as $row): ?>
            <tr>
                <?php foreach ($headers as $key=> $head): ?>
                        <td class="<?php echo  $key ?>">    
                        <?php if ($key === "tag_key"):?>
                            <a href='/admin?qtags=<?php echo $qtags?>&qtfilter=<?php echo $row->tag_key?>' ><?php echo $row->tag_key?></a>
                        <?php elseif (strpos($key, 'url') > 0):?>
                            <a href='<?php echo $row->$key?>' target="_blank" ><?php echo $row->$key?></a>
                        <?php elseif ($key == 'image_src'):?>
                            <?php if (!is_file(STATIC_CD.$row->$key)): ?>
                                404: <?php echo STATIC_CD.$row->$key?> 
                            <?php else:?>
                                <div class="projectImgMask">
                                    <img src='<?php echo imageSize($row->key, "300x300")?>' 
                                         class="projectImg" />
                                </div>
                            <?php endif?>
                        <?php else:?>                            
                            <?php echo  (!isset($row->$key) || empty($row->$key)) ? "" : ellipse($row->$key, 40) ?>
                        <?php endif;?>
                        </td>
                <?php endforeach; ?>
            </tr>
            <tr class="spacer"></tr>
        <?php endforeach; ?>
    </tbody>
</table>