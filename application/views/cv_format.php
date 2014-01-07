<? foreach ($tableRows as $row): ?>            
    <div style="border-top: 1px solid black; margin:0 0 20px 0;">
        <h3><a href='/projects?pid=<?= $row->project_id; ?>'><?= $row->project_title; ?></a></h3>
        <? if (!empty($row->project_desc)): ?><p class="prjDesc"><?= $row->project_desc; ?></p><? endif ?>
        <? if (!empty($row->project_technotes)): ?><p><div class="technotes"><?= $row->project_technotes; ?></div></p><? endif ?>
    <p><span class='lineName'><?= $this->lang->en("Started:") ?>:</span> <?= $row->project_startdate; ?></p>
    <? if (!empty($row->project_launchdate)): ?><p><span class='lineName'><?= $this->lang->en("Launched/Lasted:") ?>:</span> <?= $row->project_launchdate; ?></p><? endif ?>
    <? if (!empty($row->project_liveurl)): ?><p  class="projectLink"><span class='lineName'><?= $this->lang->en("Live") ?>:</span>                        
            <a href="<?= $row->project_liveurl; ?>" target="_blank"> <?= $row->project_liveurl; ?></a>
        </p><? endif ?>
    <? if (!empty($row->project_devurl)): ?><p class="projectLink"><span class='lineName'><?= $this->lang->en("Dev") ?>:</span><a href="<?= $row->project_devurl; ?>" target="_blank"> <?= $row->project_devurl; ?></a></p><? endif ?>
    <? if (!empty($row->project_devtools)): ?><p><span class='lineName'><?= $this->lang->en("Technologies") ?>:</span> <?= $row->project_devtools; ?></p><? endif ?>
    <? if (!empty($row->project_industries)): ?><p><span class='lineName'><?= $this->lang->en("Industries") ?>:</span> <?= ucwords($row->project_industries); ?></p><? endif ?>
    <? if (!empty($row->project_team)): ?><p><span class='lineName'><?= $this->lang->en("Team") ?>:</span> <?= $row->project_team; ?></p><? endif ?>
    <? if (!empty($row->project_companies)): ?><p><span class='lineName'><?= $this->lang->en("Companies/Brands:") ?>:</span> <?= $row->project_companies; ?></p><? endif ?>
    <? if (!empty($row->license_id)): ?><p><span class='lineName'><?= $this->lang->en("License") ?>:</span> <?= $row->license_id; ?></p><? endif ?>
    </div>
<? endforeach; ?>