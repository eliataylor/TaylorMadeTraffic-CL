<div class='userProfile'>
    <div class="row userTitleRow">
        <div class="col">
            <h1 class="userName">
                <?php
                echo $uProfile['user_screenname'];
                // $this->load->view('color_spreader', ['word'=>$uProfile['user_screenname'], 'color'=>'56, 101, 7']); ?>
            </h1>
        </div>
        <?php if (!isset($_GET['cv'])): ?>

            <div class="col sociallinks" style="justify-content:flex-end">
                <?php if (!empty($uProfile['user_fburl'])): ?>
                    <a target='_blank' href='<?php echo $uProfile['user_fburl']; ?>'>
                        <img src="/wwwroot/images/fbIcon.png" title="<?php echo $uProfile['user_fburl']; ?>"/>
                    </a>
                <?php endif ?>
                <?php if (!empty($uProfile['user_googleurl'])): ?>
                    <li><a target='_blank'
                           href='<?php echo $uProfile['user_googleurl']; ?>'><?php echo $uProfile['user_googleurl']; ?></a>
                    </li><?php endif ?>

                <?php if ($uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>

                    <a target='_blank' href='https://github.com/eliataylor'>
                        <img width="40" title="Github" src="/wwwroot/images/github.png"/>
                    </a>
                    <a target='_blank' href='https://www.upwork.com/fl/~01979dd82b228abbb5'>
                        <img width="40" title="Upwork" src="/wwwroot/images/upwork.svg"/>
                    </a>
                <?php endif; ?>


                <?php if (!empty($uProfile['user_linkdinurl'])): ?>
                    <a target='_blank' href='<?php echo $uProfile['user_linkdinurl']; ?>'>
                        <img width="40" title="<?php echo $uProfile['user_linkdinurl']; ?>"
                             src="/wwwroot/images/linkedin-icon.svg"/>
                    </a>
                <?php endif ?>
            </div>

        <?php endif; ?>
        <?php if (isset($_GET['summary']) && $uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>
        <div class="col">
            <dl class="detailList">
                <dt>Voicemail</dt> <dd>+1 415-300-0834</dd>
                <dt>E-mail</dt> <dd>eli@taylormadetraffic.com</dd>
                <dt>LinkedIn</dt> <dd>linkedin.com/in/elitaylor</dd>
                <dt>Github</dt> <dd>github.com/eliataylor</dd>
            </dl>
        </div>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['summary']) && $uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>
        <section class="userSummary">
            <p style="text-align: justify">
                For the past 20 years, I've built skills throughout all stacks and life cycles of software development, from planning to deployment.
                Currently, I'm honing my skills with machine learning through cyber security monitoring, and with Computer Vision by automating video effects on sports reels.
                In my free time, I travel with my wife and son, while seeking ways to stay active on land, water and snow.
            </p>
        </section>
    <?php elseif (!empty($uProfile['user_bio'])): ?>
        <div class='userBio'>
            <?php echo $this->lang->ugc($uProfile['user_bio']); ?>
        </div>
    <?php endif; ?>

</div>
