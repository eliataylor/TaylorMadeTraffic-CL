<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" lang="en">
    <head>
        <title>TMT CMS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="author" content="Eli A Taylor" />
        <meta name="language" content="en-us" />
        <link type="text/css" rel="stylesheet" href="/wwwroot/css/cubes.css?v=1367262681" />
        <link type="text/css" rel="stylesheet" href="/wwwroot/css/backend-tools.css?v=1375248321" />
        <? if (!isset($_SERVER['SERVER_NAME']) || strpos($_SERVER['SERVER_NAME'], "localhost") === false): ?>        
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>            
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
            <link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <? else:?>
            <script type="text/javascript" src="/wwwroot/js/jquery.min.js"></script>
            <link type="text/css" rel="stylesheet" href="/wwwroot/css/jquery-ui.css" />
            <script type="text/javascript" src="/wwwroot/js/jquery-ui.js"></script>
        <?endif;?>
        <script type="text/javascript" src="/wwwroot/js/jquery.tablesorter.min.js?v=1358932174"></script>          
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
        <link rel="stylesheet" href="/wwwroot/css/cubes.css" />
    </head>
    <body id="trackauthority" class="<?= ($me['con']['swidth'] < 900) ? "narrowscreen" : "widescreen"; ?>" >
        <div class="master">  
            <?if (isset($qmenu)):?>
            <div class="moduleBlock qParams" style="margin:10px 0;">
                <?foreach($qmenu as $key=>$param):?>
                    <?if($param['role'] < 0):?>
                        <a class='navItem <? if($key == $this->uri->segment(1)):?>selected<?endif;?>' href="<?=$key?>" data-tag-key="<?=$key?>">
                        <?=$param['title']?>
                        </a>
                    <?endif;?>
                <?endforeach;?>
            </div>            
            <?endif;?>  
            
            <?if (isset($qtfilter) && !empty($qtfilter)):?>
            <div class="moduleBlock qParams" style="margin:10px 0;">
                <h2><?=$qtfilter?>
                    
                <?if (isset($tableRows) && count($tableRows) > 1):?>    
                    <span style="float:right;" class="pageTotal">
                        <?=count($tableRows)?>
                        <?=$this->lang->line('Projects')?>
                    </span>
                <?endif?>
                </h2>                
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
            <? if (isset($pages)): ?>
                <? foreach ($pages as $key => $value): ?> 
                    <div class="moduleBlock <?= $key ?>" >
                        <?= $value ?>
                    </div>
                <? endforeach; ?>                    
            <? endif; ?>
        </div>
        <script type="text/javascript" src="/wwwroot/js/cubemanager.js?v=1368477918"></script>
        <div class="clearer"></div>
        <script language="javascript" type="text/javascript">
            $(document).ready(function(){
                $(".tablesorter").each(function(){
                   if ($(this).find('tr').length > 3) // more than header + one content row + one spacer
                       $(".tablesorter").tablesorter({widgets: ['zebra']});
                });                
            });
        </script>            
        <? if (ENVIRONMENT == 'production'):?>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            try {
                var pageTracker = _gat._getTracker("UA-7929826-3");
                pageTracker._trackPageview();
            } catch(err) {}</script>          
        <?endif;?>
    </body>
</html>