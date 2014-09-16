<? foreach ($tableRows as $row): ?>            
    <div style="border-top: 1px solid black; margin:0 0 20px 0;">
        <h3><a href='/projects?pid=<?= $row->project_id; ?>'><?= $row->project_title; ?></a></h3>
    
        <? if (!empty($row->project_pitch)): ?><div class="prjSection prjPitch">
            <?= $this->lang->ugc($row->project_pitch); ?></div>
        <? elseif (!empty($row->project_desc)): ?>
            <p class="prjDesc"><?= $row->project_desc; ?></p>
        <? endif ?>

        <? if (!empty($row->project_bizmodel)): ?>
            <div class="prjSection prjBiz">
                <h4 class="sectTitle"><?=$this->lang->en('Business Model')?></h4>
                <?= $this->lang->ugc($row->project_bizmodel); ?>
            </div>
        <? endif ?>

        <? if (!empty($row->project_competition)): ?>
            <div class="prjSection prjCompetition">
                <h4 class="sectTitle"><?=$this->lang->en('Competition')?></h4>
                <?= $this->lang->ugc($row->project_competition); ?>
            </div>
        <? endif ?>                    

        <? if (!empty($row->project_marketresearch)): ?>
            <div class="prjSection prjResearch">
                <h4 class="sectTitle"><?=$this->lang->en('Target Markets')?> / <?=$this->lang->en('Research')?></h4>
                <?= $this->lang->ugc($row->project_marketresearch); ?>
            </div>
        <? endif ?>                    

        <? if (!empty($row->project_expenses)): ?>
            <div class="prjSection prjCosts">
                <h4 class="sectTitle"><?=$this->lang->en('Costs by Department')?></h4>
                <?= $this->lang->ugc($row->project_expenses); ?>
            </div>
        <? endif ?>

        <? if (!empty($row->project_futuredate)): ?>
            <div class="prjSection prjDates">
                <h4 class="sectTitle"><?=$this->lang->en('Roadmap')?></h4>
                <?= $this->lang->ugc($row->project_futuredate); ?>
            </div>
        <? endif ?>    

        
        <? if (!empty($row->project_technotes)): ?>            
            <div class="technotes">
                <h4 class="sectTitle"><?=$this->lang->en('Technical Notes')?></h4>
                <?= $row->project_technotes; ?>
            </div>
        <? endif ?>
            
    
        <p>
            <span class='lineName'><?= $this->lang->en("Started") ?>:</span> <?= $row->project_startdate; ?>
            <? if (!empty($row->project_launchdate)): ?>. <span class='lineName'><?= $this->lang->en("Launched/Lasted:") ?>:</span> <?= $row->project_launchdate; ?><? endif ?>
        </p>
        <? if (!empty($row->project_liveurl) || !empty($row->project_devurl)): ?>
            <p  class="projectLink">        
            <? if (!empty($row->project_liveurl) || !empty($row->project_devurl)): ?>
                <span class='lineName'><?= $this->lang->en("Live") ?>:</span>                        
                <a href="<?= $row->project_liveurl; ?>" target="_blank"> <?= $row->project_liveurl; ?></a>
            <? endif ?>
            <? if (!empty($row->project_devurl)): ?>
                <span class='lineName'><?= $this->lang->en("Dev") ?>:</span>
                <a href="<?= $row->project_devurl; ?>" target="_blank"> <?= $row->project_devurl; ?></a>
            <? endif ?>
            </p>
        <? endif ?>
    <? if (!empty($row->project_devtools)): ?><p><span class='lineName'><?= $this->lang->en("Technologies") ?>:</span> <?= $row->project_devtools; ?></p><? endif ?>
    <? if (!empty($row->project_industries)): ?><p><span class='lineName'><?= $this->lang->en("Industries") ?>:</span> <?= ucwords($row->project_industries); ?></p><? endif ?>
    <? if(isset($_GET['team'])):?>
        <? if (!empty($row->project_team)): ?><p><span class='lineName'><?= $this->lang->en("Team") ?>:</span> <?= $row->project_team; ?></p><? endif ?>
    <?endif;?>
    <? if (!empty($row->project_companies)): ?><p><span class='lineName'><?= $this->lang->en("Companies/Brands:") ?>:</span> <?= $row->project_companies; ?></p><? endif ?>
    </div>
<? endforeach; ?>