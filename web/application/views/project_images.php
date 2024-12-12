<?php if (isset($row->images) && count($row->images) > 0): ?>
    <?php foreach ($row->images as $index => $img): ?>
        <div class='imageGridItem'>
            <?php if (substr($img->image_src, -4) === '.mp4'): ?>
                <video src='<?php echo $img->image_src; ?>' muted="true" controls autoplay loop playsinline/>
            <?php else: ?>
                <img src='<?php echo $img->image_src; ?>'/>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
