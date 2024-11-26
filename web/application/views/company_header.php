<?php
$variant = ($index || 1) % 2 == 0 ? 'footer' : 'header';
?>

<div class="container companyHead" data-group="<?php echo $groupname ?>"
     data-projectcount="<?php echo count($company['projects']) ?>">
    <div class="row <?php if (!isset($_GET['cv'])): ?>letterhead<?php endif; ?>">
        <div class="col">
            <div>
                <h2>
                    <div class="company_screenname"><?php echo $company['company_screenname']; ?></div>
                    <?php if (isset($company['company_logo']) && isset($_GET['logos'])): ?>
                        <img title="<?php echo $company['company_screenname'] ?>"
                             alt="<?php echo $company['company_screenname'] ?>" class="companyLogo"
                             src="<?php echo $company['company_logo'] ?>"/>
                    <?php endif; ?>
                </h2>
                <div class="daterange">
                    <?php echo fDate($company['startDate'], 'month') ?>
                    -
                    <?php echo (empty($company['company_enddate'])) ? 'Present' : fDate($company['endDate'], 'month'); ?>
                </div>
            </div>
        </div>

        <div class="col">
            <?php if ($company['company_myrole']): ?>
                <div class="myrole"><?php echo htmlentities($company['company_myrole']) ?></div>
            <?php endif; ?>
        </div>

        <div class="col"  style="text-align: right;">
            <div class="companyRegion">

                <?php if (isset($company['company_city'])): ?>
                    <div class="locale">
                        <?php echo $company['company_city'] ?>
                    </div>
                <?php endif; ?>
                <small>
                    <?php if (isset($company['company_country']) && $company['company_country'] !== 'USA'): ?>
                        <?php echo $company['company_country'] ?>
                    <?php else: ?>
                        <?php echo $company['company_state'] ?>
                    <?php endif; ?>
                </small>

                <?php if ($company['company_telecommuting'] == 1): ?>
                    - <small>remote</small>
                <?php elseif ($company['company_telecommuting'] == 0): ?>
                    - <small>hybrid</small>
                <?php endif; ?>

            </div>

            <span  class="caret closed" >
                <svg width="24" height="24" viewBox="0 -960 960 960" xmlns="http://www.w3.org/2000/svg">
                  <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
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
