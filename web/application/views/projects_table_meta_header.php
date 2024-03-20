<div class="projectsTitle row">
    <div class="col" style="flex-grow: 1">
        <h2>
            <?php echo $qtfilter; ?>
        </h2>
    </div>
    <div class="col projects_count" style="text-align: right">
        <?php echo $projects_count; ?>
        <?php echo ($projects_count == 1) ? $this->lang->en('Project') : $this->lang->en('Projects'); ?>
    </div>
</div>
