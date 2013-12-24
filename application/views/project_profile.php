<div id="pid_<?= $project->project_id ?>" data-pid="<?= $project->project_id ?>" >
<h3><?= $project->project_title; ?></h3>
<? if (!empty($project->project_desc)): ?><p class="prjDesc"><?= $project->project_desc; ?></p><? endif ?>
<? if (!empty($project->project_technotes)): ?><p><div class="technotes"><?= $project->project_technotes; ?></div></p><? endif ?>
<p><span class='lineName'><?= $this->lang->line("Started:") ?>:</span> <?= $project->project_startdate; ?></p>
<? if (!empty($project->project_launchdate)): ?><p><span class='lineName'><?= $this->lang->line("Launched/Lasted:") ?>:</span> <?= $project->project_launchdate; ?></p><? endif ?>
<? if (!empty($project->project_liveurl)): ?><p><span class='lineName'><?= $this->lang->line("Live") ?>:</span><a href="<?= $project->project_liveurl; ?>" target="_blank"> <?= $project->project_liveurl; ?></a></p><? endif ?>
<? if (!empty($project->project_devurl)): ?><p><span class='lineName'><?= $this->lang->line("Dev") ?>:</span><a href="<?= $project->project_devurl; ?>" target="_blank"> <?= $project->project_devurl; ?></a></p><? endif ?>
<? if (!empty($project->project_devtools)): ?><p><span class='lineName'><?= $this->lang->line("Tools") ?>:</span> <?= $project->project_devtools; ?></p><? endif ?>
<? if (!empty($project->project_team)): ?><p><span class='lineName'><?= $this->lang->line("Team") ?>:</span> <?= $project->project_team; ?></p><? endif ?>
<? if (!empty($project->project_client)): ?><p><span class='lineName'><?= $this->lang->line("Client") ?>:</span> <?= $project->project_client; ?></p><? endif ?>
<? if (!empty($project->project_copyright)): ?><p><span class='lineName'><?= $this->lang->line("Copyright") ?>:</span> <?= $project->project_copyright; ?></p><? endif ?>
<? if (!empty($project->license_id)): ?><p><span class='lineName'><?= $this->lang->line("License") ?>:</span> <?= $project->license_id; ?></p><? endif ?>
</div>

<? if (!empty($project->image_srcs)): ?>
    <?php $project->image_srcs = explode(',', $project->image_srcs); ?>
    <?foreach($project->image_srcs as $img):?>
        <img src='wwwroot/<?= trim($img) ?>' class="projectImg" />   
    <?endforeach?>
<?endif?>
