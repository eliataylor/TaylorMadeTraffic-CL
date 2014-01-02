<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" lang="en">
    <head>
        <?php if (!isset($docTitle)) $docTitle = $this->uri->segment(1);
              if (empty($docTitle) || strlen($docTitle) < 2) $docTitle = $qtags; 
              else $docTitle = ucfirst(trim($docTitle)); ?>
        <title><?= $docTitle ?> :: TaylorMadeTraffic.com</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="author" content="Eli A Taylor" />
        <meta name="language" content="en-us" />
        <link type="text/css" rel="stylesheet" href="/wwwroot/css/cubes.css?v=1367262683" />
        <? if ($me['con']['isMobile']): ?>
            <meta name="viewport" content="width=device-width; initial-scale=1.0" />
            <meta name="apple-mobile-web-app-capable" content="yes"  />
            <meta name="apple-mobile-web-app-status-bar-style" content="translucent" />
            <link rel="stylesheet" href="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
            <script src="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
        <? endif; ?>        
        <? if (!isset($_SERVER['SERVER_NAME']) || strpos($_SERVER['SERVER_NAME'], "localhost") === false): ?>        
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>            
        <? else:?>
            <script type="text/javascript" src="/wwwroot/js/jquery.min.js"></script>
        <?endif;?>
        <script type="text/javascript" src="/wwwroot/js/jquery.tablesorter.min.js"></script>          
        <script language="javascript" type="text/javascript">
            var TMT_HTTP = "<?= TMT_HTTP ?>";
            var taTools = {};
            var VSETTINGS = <?= (is_array($me) && isset($me['con'])) ? json_encode($me['con']) : "{}" ?>;
            <? if ($this->thisvisitor->auth()): ?>
                var CUR_VISITOR = <?= $me['user_id'] ?>;
                var QPARAMS = <?=json_encode($qparams);?>;
            <? else: ?>
                var CUR_VISITOR = false;
            <? endif; ?>
        </script>
    </head>
    <body id="trackauthority" class="<?= ($me['con']['swidth'] < 900) ? "narrowscreen" : "widescreen"; ?> <?=$me['con']['pstyle'];?>" >
        <div class="master">  
            <?if (isset($qmenu)):?>
            <div class="moduleBlock mainNav">
                <?foreach($qmenu as $key=>$param):?>
                    <?if($param['role'] < 0):?>
                        <?php $seg1 = $this->uri->segment(1); ?>
                        <a class='navItem <? if($key == $seg1 || (empty($seg1) && $key == 'technologies')):?>selected<?endif;?>' href="<?=$key?>" data-tag-key="<?=$key?>"><?=trim($param['title'])?></a>
                    <?endif;?>
                <?endforeach;?>
            </div>            
            <?endif;?>  
            
             <? if (!empty($errors)): ?>
                <div class="serverErrors">  
                    <ul>
                    <? foreach ($errors as $key => $value): ?> 
                        <li><?= $value ?></li>
                    <? endforeach; ?>                    
                    </ul>
                </div>
            <? endif; ?>            
            <div id="pageBlock">
            <? if (isset($pages)): ?>
                <? foreach ($pages as $key => $value): ?> 
                    <div class="moduleBlock <?= $key ?>" >
                        <?= $value ?>
                    </div>
                <? endforeach; ?>                    
            <? endif; ?>
            </div>
        </div>
        <script type="text/javascript" src="/wwwroot/js/cubemanager.js?v=1367262683"></script>
        <? if (ENVIRONMENT == 'production'):?>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));            
            try {
                var pageTracker = _gat._getTracker("UA-7929826-3");
                pageTracker._trackPageview();
            } catch(err) {}</script>          
        <?endif;?>
    </body>
</html>