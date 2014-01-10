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
        <link type="text/css" rel="stylesheet" href="/wwwroot/css/cubes.css?v=1389164033" />
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
        <link rel="shortcut icon" href="/wwwroot/images/favicon.ico" />
        <script type="text/javascript" src="/wwwroot/js/jquery.tablesorter.min.js"></script>          
        <script language="javascript" type="text/javascript">
            var TMT_HTTP = "<?= TMT_HTTP ?>";
            var taTools = {};
            var VSETTINGS = <?= (is_array($me) && isset($me['con'])) ? json_encode($me['con']) : "{}" ?>;
            <? if ($this->thisvisitor->auth()): ?>
                var CUR_VISITOR = <?= $me['user_id'] ?>;
                <? if(isset($qparams)):?> 
                var QPARAMS = <?= json_encode($qparams); ?>;
                <?endif;?>
            <? else: ?>
                var CUR_VISITOR = false;
            <? endif; ?>
        </script>
        <? if($this->uri->segment(1) == 'lenguaplus'):?>
            <script type="text/javascript" src="/wwwroot/js/lenguaplus.js"></script>
            <link type="text/css" rel="stylesheet" href="/wwwroot/css/lenguaplus.css" />
        <?endif;?>
    </head>
    <body id="trackauthority" class="<?= ($me['con']['swidth'] < 900) ? "narrowscreen" : "widescreen"; ?> <?=$me['con']['pstyle'];?>" >
        <span id="tmmCube" >
            <?php $cubespins = scandir(ROOT_CD . "/wwwroot/images/cubespins"); $index=0;?>
            <?foreach($cubespins as $img):?>
                <? if($img != '.' && $img != '..' && !strpos($img, '.db')):?>
                    <img data-index="<?=$index?>" <? if($index > 0):?>style='display:none;'<?endif;?>  src="/wwwroot/images/cubespins/<?=$img?>" />
                    <?php $index++; ?>
                <?endif;?>
            <?endforeach;?>
        </span>
        <div class="master">  
            <span id="tmmOpening" ref="0" style="display:none; top: -7px;left: -12px;;"></span>
            <div class='topHeader'>
                <?if (isset($qmenu)):?>
                <div style="opacity:0; filter:alpha(opacity=0); " id="navMenu" >
                    <div style="padding-left: 1px;"  class="menuEmpty menuBox">
                        <span onclick="tmt.startClose();" style="display:none" id="closeBtn">CLOSE</span>
                    </div>

                    <a href="/eli" title="E.A.Taylor" class="menuBox tc">
                        <img src="/wwwroot/images/eat_menu.png" />
                    </a>

                    <div class="menuEmpty menuBox" id="menuLabelBox" ><span id="menuLabel"></span></div>

                    <a href="/years" title="<?=$this->lang->en('Years')?>" class="menuBox ll">
                        <img src="/wwwroot/images/calendar.png" />
                    </a>

                    <a style="margin-top:2px" href="/companies" title="<?=$this->lang->en('Companies')?>" class="menuBox lc">
                        <img src="/wwwroot/images/companies.png" />
                    </a>
                    
                    <a href="/industries" title="<?=$this->lang->en('Industries')?>" class="menuBox rc">
                        <img src="/wwwroot/images/industries.png" />
                    </a>
                    
                    <a href="/technologies" title="<?=$this->lang->en('Technologies')?>" class="menuBox rr">
                        <img src="/wwwroot/images/technologies.png" />
                    </a>

                    <div class="menuEmpty menuBox" style="margin-right:1px; clear:left;"></div>

                    <a id="menuBoxBottom" href="/taylormade" title="<?=$this->lang->en("Taylor Made")?>" class="menuBox bc">
<!--                        <img src="/wwwroot/images/cubeCorner.png" />-->
                    </a>

                    <div class="menuEmpty menuBox" style="height:auto; width:auto;" >
                        <ul id="menuList" style="display:none" ></ul>
                    </div>
                </div>

                <div id="tagLinks" class="moduleBlock mainNav">
                    <?foreach($qmenu as $key=>$param):?>
                        <?if($param['role'] < 0):?>
                            <?php $seg1 = $this->uri->segment(1); ?>
                            <a class='navItem<? if($key == $seg1 || (empty($seg1) && $key == 'technologies')):?> selected<?endif;?>' href="/<?=$key?>" ><?=trim($param['title'])?></a>
                        <?endif;?>
                    <?endforeach;?>
                </div>            
                <?endif;?>  
            </div>
            
             <? if (!empty($errors)): ?>
                <div class="serverErrors">  
                    <ul>
                    <? foreach ($errors as $key => $value): ?> 
                        <li><?= $value ?></li>
                    <? endforeach; ?>                    
                    </ul>
                </div>
            <? endif; ?>            
            <div id="pageBlock" class="clearer">
            <? if (isset($pages)): ?>
                <? foreach ($pages as $key => $value): ?> 
                    <div class="moduleBlock <?= $key ?>" >
                        <?= $value ?>
                    </div>
                <? endforeach; ?>                    
            <? endif; ?>
            </div>
        </div>
        <div id='softNotice' style="display:none;">
            <div onclick='tmt.closeNotice();' class='closeBtn'>x</div>
            <div id='softNoticeBody'></div>
        </div>
        <div class="starSprite" style="display:none;" id="taPreloader" > </div>            
        <script type="text/javascript" src="/wwwroot/js/cubemanager.js?v=1389255112"></script>
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