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
                For the past 20 years, I've mastered the front and backend of several stacks, while leading and working through all life cycles of software development, from planning to deployment.
            </p>
            <p style="text-align: justify">
                This resume begins in 2017 when I married an amazing Graphic Designer and we launched a joint design and development firm. We've spent the past 7 years wearing many hats, while traveling the world and starting a family.
            </p>
            <p style="text-align: justify">
                Along all these years, Cypher and Flexible Assembly Systems have remained my consistent clients and their recommendations on my LinkedIn attest to my work ethic and customer satisfaction. As for code quality, I approach every project with the best practices of test-driven development, while pen-testing my servers and interfaces for security and performance under high traffic. A more recent project - PickupMVP - has been a successful soft launch validating the viability of the architecture and our UX for crowd sourcing pickup games with real rewards and AI assisted highlight reels.
            </p>
            <p style="text-align: justify">
                Now that our son is 3.3, we've decided to move back home to the Bay Area to be near family and put him into a more steady school. In turn, now seems like a good opportunity to explore opportunities like yours.
            </p>
        </section>
    <?php elseif (!empty($uProfile['user_bio'])): ?>
        <div class='userBio'>
            <?php echo $this->lang->ugc($uProfile['user_bio']); ?>
        </div>
    <?php endif; ?>

</div>
