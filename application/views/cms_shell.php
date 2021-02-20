<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" lang="en">
    <head>
        <?php if (!isset($docTitle)) $docTitle = $this->uri->segment(1);
              if (empty($docTitle) || strlen($docTitle) < 2) $docTitle = $qtags;
              else $docTitle = ucfirst(trim($docTitle)); ?>
        <title><?php echo  $docTitle ?> :: TaylorMadeTraffic.com</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="author" content="Eli A Taylor" />
        <meta name="language" content="en-us" />
        <link type="text/css" rel="stylesheet" href="/wwwroot/css/cubes.css?v=1613818573" />
        <meta name="viewport" content="initial-scale=1, width=device-width" />
        <?php if ($me['con']['isMobile']): ?>
            <meta name="apple-mobile-web-app-capable" content="yes"  />
            <meta name="apple-mobile-web-app-status-bar-style" content="translucent" />
            <link rel="stylesheet" href="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
            <script src="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
        <?php endif; ?>
        <?php if (!isset($_SERVER['SERVER_NAME']) || strpos($_SERVER['SERVER_NAME'], "localhost") === false): ?>
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <?php else:?>
            <script type="text/javascript" src="/wwwroot/js/jquery.min.js"></script>
        <?php endif;?>
        <link rel="shortcut icon" href="/wwwroot/images/favicon.ico" />
        <script type="text/javascript" src="/wwwroot/js/jquery.tablesorter.min.js"></script>
        <script language="javascript" type="text/javascript">
            var TMT_HTTP = "<?php echo  TMT_HTTP ?>";
            var taTools = {};
            var VSETTINGS = <?php echo  (is_array($me) && isset($me['con'])) ? json_encode($me['con']) : "{}" ?>;
            <?php if ($this->thisvisitor->auth()): ?>
                var CUR_VISITOR = <?php echo  $me['user_id'] ?>;
                <?php if(isset($qparams)):?>
                var QPARAMS = <?php echo  json_encode($qparams); ?>;
                <?php endif;?>
            <?php else: ?>
                var CUR_VISITOR = false;
            <?php endif; ?>
        </script>
        <?php if($this->uri->segment(1) == 'lenguaplus'):?>
            <script type="text/javascript" src="/wwwroot/js/lenguaplus.js"></script>
            <link type="text/css" rel="stylesheet" href="/wwwroot/css/lenguaplus.css" />
        <?php endif;?>
        <?php if (ENVIRONMENT == 'production'):?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-7929826-3', 'auto');
            ga('set', '&uid', '<?php echo $me['session_id']?>');
            ga('send', 'pageview');

          </script>
        <?php endif;?>
    </head>
    <body id="trackauthority" class="narrowscreen <?php echo $me['con']['pstyle'];?>" >
        <div class="master">
             <?php if (!empty($errors)): ?>
                <div class="serverErrors">
                    <ul>
                    <?php foreach ($errors as $key => $value): ?>
                        <li><?php echo  $value ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div id="pageBlock" class="clearer">
            <?php if (isset($pages)): ?>
                <?php foreach ($pages as $key => $value): ?>
                    <div class="moduleBlock <?php echo  $key ?>" >
                        <?php echo  $value ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>
        <div id='softNotice' style="display:none;">
            <div onclick='tmt.closeNotice();' class='closeBtn'>x</div>
            <div id='softNoticeBody'></div>
        </div>
        <div class="starSprite" style="display:none;" id="taPreloader" > </div>
    </body>
</html>
