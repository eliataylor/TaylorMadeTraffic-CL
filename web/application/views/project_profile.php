<?php echo $this->load->view('project_item', ['row' => $project], TRUE); ?>

<?php if (!empty($project->images)): ?>
    <div class="galleryBlock">
        <div class="galleryTopBar">
            <?php foreach ($project->images as $img): ?>
                <a class="fancybox" href="<?php echo $img->image_src ?>"
                   data-fancybox-group="gallery<?php echo $project->project_id ?>">
                    <?php if (substr($img->image_src, -4) === '.mp4'): ?>
                        <video src='<?php echo $img->image_src; ?>'
                               class="projectImg" muted="true"
                               autoplay="true" playsinline
                               data-oimage="<?php echo $img->image_src ?>"
                               data-owidth="<?php echo $img->image_width ?>"
                               data-oheight="<?php echo $img->image_height ?>"
                        />
                    <?php else: ?>
                        <img src='<?php echo imageSize($img->image_src, "150x150") ?>'
                             data-oimage="<?php echo $img->image_src ?>"
                             data-owidth="<?php echo $img->image_width ?>"
                             data-oheight="<?php echo $img->image_height ?>"
                        />
                    <?php endif; ?>
                </a>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>
