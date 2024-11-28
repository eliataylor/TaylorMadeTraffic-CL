<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" lang="<?php echo $me['con']['lang']?>">
<head>
    <?php if (!isset($docTitle)) $docTitle = $this->uri->segment(1);
    if (empty($docTitle) || strlen($docTitle) < 2) $docTitle = $qtags;
    else $docTitle = ucfirst(trim($docTitle)); ?>
    <title><?php echo  $docTitle ?> :: TaylorMadeTraffic.com</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Eli A Taylor" />
    <meta name="language" content="<?php echo $me['con']['lang']?>" />
    <link rel="stylesheet" type="text/css" href="/wwwroot/css/jquery.fancybox.css?v=2.1.5" media="screen" />
    <link type="text/css" rel="stylesheet" media="all" href="/wwwroot/css/cubes.css" />
    <link type="text/css" rel="stylesheet" media="<?php echo (isset($_GET['cv'])) ? 'all' : 'print'; ?>" href="/wwwroot/css/print.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <?php if ($me['con']['isMobile']): ?>
        <meta name="apple-mobile-web-app-capable" content="yes"  />
        <meta name="apple-mobile-web-app-status-bar-style" content="translucent" />
    <?php endif; ?>
    <link rel="shortcut icon" href="/wwwroot/images/favicon.ico" />
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
<body id="trackauthority pWhite" >
<div class="master" id="master">
    <div id="pageBlock" >
        <?php if (isset($pages)): ?>
            <?php foreach ($pages as $key => $value): ?>
                <div class="moduleBlock <?php echo  $key ?>" >
                    <?php echo  $value ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <!--<p style="margin-top: 30px; font-size: 11px; color:#757575; font-style: italic">This resume is a print-friendly version of <u>TaylorMadeTraffic.com<?php echo $_SERVER['REQUEST_URI']?></u></p>-->
    </div>
</div>
</body>
</html>
