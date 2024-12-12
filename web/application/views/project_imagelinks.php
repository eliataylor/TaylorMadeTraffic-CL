<div class="projectImgMask">
    <a href='/projects?pid=<?php echo $row->project_id; ?>'>
        <?php if (substr($row->image_src, -4) === '.mp4'): ?>
            <video src='<?php echo $row->image_src; ?>'
                   class="projectImg" muted="true" controls autoplay loop playsinline
                <?php if (count($row->images) > 1): ?>
                    poster="<?php echo $row->images[1]->image_src ?>"
                <?php endif; ?>
            />
        <?php else: ?>
            <img data-owidth="<?php echo $row->image_width ?>"
                 data-oheight="<?php echo $row->image_height ?>"
                 src='<?php echo ($row->image_width > 1000) ? imageSize($row->image_src, "300x300") : $row->image_src; ?>'
                 class="projectImg"/>
        <?php endif; ?>
    </a>

    <?php if (isset($row->images) && count($row->images) > 1): ?>
        <div class="morePics">
            <?php foreach ($row->images as $index => $img): ?>
                <?php if ($index == 0): ?>
                    <a class="fancybox" data-fancybox-group="gallery<?php echo $row->project_id ?>"
                       href="<?php echo $row->image_src; ?>"><?php echo $row->totalImages - 1 ?><?php echo $this->lang->en('more images') ?></a>
                <?php else: ?>
                    <a class="fancybox" data-fancybox-group="gallery<?php echo $row->project_id ?>"
                       href="<?php echo $img->image_src ?>"
                       style="display:none;"
                    ></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!--                    TODO, leave for old browser support from reflection <div class="blackOutFadeBG"></div>-->
<div class="reflectionMask">
    <?php if (substr($row->image_src, -4) === '.mp4'): ?>
        <video src='<?php echo $row->image_src; ?>'
               class="reflection" muted="true" loop autoplay playsinline/>
    <?php else: ?>
        <img class="reflection"
             src='<?php echo ($row->image_width > 1000) ? imageSize($row->image_src, "300x300") : $row->image_src; ?>'/>
    <?php endif; ?>
</div>
