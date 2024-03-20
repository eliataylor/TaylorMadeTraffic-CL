<div class='userProfile'>
    <div class="row userTitleRow">
        <div class="col" style="flex-grow:1">
            <h1 class="userName">
                <?php
                echo $uProfile['user_screenname'];
                ?>
            </h1>
            <span>eli@taylormadetraffic.com &bullet; 808-855-5665</span>
        </div>

        <?php if (isset($_GET['cv'])): ?>
            <div class="col">
                <div class="aline">
                    <a target='_blank' href='<?php echo $uProfile['user_linkdinurl']; ?>' class="nolink">
                        <img width="18" title="<?php echo $uProfile['user_linkdinurl']; ?>"
                             src="/wwwroot/images/linkedin-icon.svg"/>
                    </a>
                    <span>linkedin.com/in/elitaylor</span>
                </div>
                <div class="aline">
                    <a target='_blank' href='https://github.com/eliataylor' class="nolink">
                        <img width="18" title="Github" src="/wwwroot/images/github-mark.png"/>
                    </a>
                    <span>github.com/eliataylor</span>
                </div>
            </div>
        <?php else: ?>

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

                <a target='_blank' href='https://github.com/eliataylor'>
                    <img width="40" title="Github" src="/wwwroot/images/github-mark.png"/>
                </a>
                <a target='_blank' href='https://www.upwork.com/fl/~01979dd82b228abbb5'>
                    <img width="40" title="Upwork" src="/wwwroot/images/upwork.svg"/>
                </a>


                <?php if (!empty($uProfile['user_linkdinurl'])): ?>
                    <a target='_blank' href='<?php echo $uProfile['user_linkdinurl']; ?>'>
                        <img width="40" title="<?php echo $uProfile['user_linkdinurl']; ?>"
                             src="/wwwroot/images/linkedin-icon.svg"/>
                    </a>
                <?php endif ?>
            </div>
        
        <?php endif; ?>

    </div>

</div>
