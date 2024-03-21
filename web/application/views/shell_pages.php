<?php if (isset($pages)): ?>
    <?php foreach ($pages as $key => $value): ?>
        <div class="moduleBlock <?php echo  $key ?>" >
            <?php echo  $value ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
