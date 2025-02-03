<?php
$variant = ($index || 1) % 2 == 0 ? 'footer' : 'header';
?>

<div class="container companyHead">
    <div class="row <?php if (!isset($_GET['cv'])): ?>letterhead<?php endif; ?>">
        <div class="col">
            <div>
                <h3>
                    <a href='/projects?pid=<?php echo $row->project_id; ?>'><?php echo $row->project_title; ?></a>
                </h3>
                <?php if (!isset($_GET['hide_subtitle']) && !empty($row->project_subtitle)): ?>
                    <small><em><?php echo $row->project_subtitle; ?></em></small>
                <?php endif; ?>

                <?php
                $dateRange = dateRange($row->project_startdate, $row->project_launchdate, 'month');
                ?>

                <?php if (!empty($dateRange) && isset($_GET['allDates'])): ?>
                    <span class="project_dates">
            <?php echo $dateRange; ?>
        </span>
                <?php endif ?>
            </div>
        </div>

        <div class="col">
            <?php if ($row->company_myrole): ?>
                <div class="myrole"><?php echo htmlentities($row->company_myrole) ?></div>
            <?php endif; ?>
        </div>

        <div class="col" style="text-align: right;">
            <div class="companyRegion">
                <div class="locale">
                    <?php echo $row->company_screenname; ?>
                </div>
                <small>
                    <?php if (isset($row->company_city) && $row->company_city !== $row->company_state): ?>
                        <?php echo $row->company_city ?>,
                    <?php endif; ?>
                    <?php if (isset($row->company_country) && $row->company_country !== 'USA'): ?>
                        <?php echo $row->company_country ?>
                    <?php else: ?>
                        <?php echo $row->company_state ?>
                    <?php endif; ?>
                </small>

                <?php if ($row->company_telecommuting == 1): ?>
                    - <small>remote</small>
                <?php elseif ($row->company_telecommuting == 0): ?>
                    - <small>hybrid</small>
                <?php endif; ?>

            </div>

            <span class="caret closed">
                <svg width="24" height="24" viewBox="0 -960 960 960" xmlns="http://www.w3.org/2000/svg">
                  <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/>
                </svg>
            </span>
        </div>
        <?php if (!isset($_GET['cv'])): ?>
            <?php $this->load->view('letterhead', ['variant' => $variant, "style" => "opacity:1;"]); ?>
        <?php endif; ?>
    </div>
    <?php if (isset($_GET['cv'])): ?>
        <div class="letterhead">
            <?php $this->load->view('letterhead', ['variant' => $variant, "style" => "opacity:1;"]); ?>
        </div>
    <?php endif; ?>
</div>
