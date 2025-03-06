<?php if (isset($_GET['cv']) && $showGroup === false): ?>
    <?php $this->load->view('project_item_header', ['row' => $row, 'index' => $index]); ?>
<?php else: ?>
    <div class="project_header">
        <h3>
            <a href='/projects?pid=<?php echo $row->project_id; ?>'><?php echo $row->project_title; ?></a>
        </h3>

        <?php
        $dateRange = dateRange($row->project_startdate, $row->project_launchdate, 'month');
        ?>

        <?php if (!empty($dateRange) && isset($_GET['allDates'])): ?>
            <span class="project_dates">
            <?php echo $dateRange; ?>
        </span>
        <?php endif ?>
    </div>
<?php endif; ?>


<?php if (!empty($row->project_desc) && !isset($_GET['cv'])): ?>
    <div class="prjDesc"><?php echo $this->lang->ugc($row->project_desc); ?></div>
<?php endif ?>

<?php if (!empty($row->project_technotes)): ?>
    <div class="technotes">
        <?php if (!empty($row->project_subtitle) && isset($_GET['cv'])): ?>
            <?php echo $this->lang->ugc($row->project_subtitle); ?>
        <?php endif ?>
        <?php echo $this->lang->ugc($row->project_technotes); ?>
    </div>
<?php elseif (!empty($row->project_subtitle) && isset($_GET['cv'])): ?>
    <p class="prjDesc"><?php echo $this->lang->ugc($row->project_subtitle); ?></p>
<?php endif ?>

<div class="projectTags">

    <div class="projectLinks">
        <?php if (!empty($row->project_liveurl)): ?>
        <p class="projectLink">
            <a href="<?php echo $row->project_liveurl; ?>"
               target="_blank"> <?php echo stripos($row->project_liveurl, '//') ? substr($row->project_liveurl, stripos($row->project_liveurl, '//') + 2) : $row->project_liveurl; ?></a>
        </p>
        <?php endif ?>
        <?php if (!empty($row->project_devurl) && $row->project_devurl != $row->project_liveurl): ?>
        <p class="projectLink">
            <a href="<?php echo $row->project_devurl; ?>"
               target="_blank"> <?php echo stripos($row->project_devurl, '//') ? substr($row->project_devurl, stripos($row->project_devurl, '//') + 2) : $row->project_devurl; ?></a>
        </p>
        <?php endif ?>
    </div>

    <?php if (!empty($row->project_devtools)): ?>
    <div class="project_devtools">
        <?php
        $devtools = explode(',', $row->project_devtools);
        echo $this->load->view('devtools', array("devtools" => $devtools), TRUE); ?>
    </div>
    <?php endif ?>

    <p class="project_startdate"><span
                class='lineName'><?php echo $this->lang->en("Started") ?>:</span> <?php echo $row->project_startdate; ?>
    </p>
    <?php if (!empty($row->project_launchdate)): ?><p class="project_launchdate"><span
                class='lineName'><?php echo $this->lang->en("Launched") ?>/<?php echo $this->lang->en("Lasted") ?>:</span> <?php echo $row->project_launchdate; ?>
    </p><?php endif ?>

    <?php if (!empty($row->project_industries)): ?><p class="industries"><span
                class='lineName'><?php echo $this->lang->en("Industries") ?>:</span> <?php echo ucwords($row->project_industries); ?>
    </p><?php endif ?>
    <?php if (!empty($row->project_team)): ?><p class="team"><span
                class='lineName'><?php echo $this->lang->en("Team") ?>:</span> <?php echo $row->project_team; ?>
    </p><?php endif ?>
    <?php if (!empty($row->project_companies)): ?><p class="companies"><span
                class='lineName'><?php echo $this->lang->en("Companies") ?>/<?php echo $this->lang->en("Brands") ?>:</span> <?php echo $row->project_companies; ?>
    </p><?php endif ?>
</div>
