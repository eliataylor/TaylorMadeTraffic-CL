<div class="row userHeader">
    <div class="col" style="flex-grow:1">
        <h1 class="userName">
            <?php
            echo $uProfile['user_screenname'];
            ?>
        </h1>
        <div class="userContact"><span><?php echo $uProfile['user_email']; ?></span> &bullet; <span><?php echo $uProfile['user_phone']; ?></span></div>
    </div>

    <?php if (isset($_GET['cv'])): ?>

        <?php

        $linkMap = [
            'user_linkdin' => '/wwwroot/images/linkedin-icon.svg',
            'user_github' => '/wwwroot/images/github-mark.png'];

        ?>

        <div class="col" style="align-items:flex-end">
            <?php foreach ($linkMap as $key => $img): ?>
                <?php if (!empty($uProfile[$key])): ?>
                    <div class="aline">
                        <a target='_blank' href='<?php echo $uProfile[$key]; ?>' class="nolink">
                            <img width="18" title="<?php echo $uProfile[$key]; ?>"
                                 src="<?php echo $img; ?>"/>
                        </a>
                        <span><?php echo displayLink($uProfile[$key]); ?></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <?php

        $linkMap = [
            'user_github' => '/wwwroot/images/github.png',
            'user_upwork' => '/wwwroot/images/upwork.svg',
            'user_linkdin' => '/wwwroot/images/linkedin-icon.svg',
            'user_fburl' => '/wwwroot/images/fbIcon.svg',
        ];

        ?>

        <div class="row sociallinks" style="justify-content:flex-end">

            <?php foreach ($linkMap as $key => $img): ?>
                <?php if (!empty($uProfile[$key])): ?>
                    <a target='_blank' href='<?php echo $uProfile[$key]; ?>' class="nolink">
                        <img height="40" title="<?php echo $uProfile[$key]; ?>"
                             src="<?php echo $img; ?>"/>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>
