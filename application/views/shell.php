<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" lang="<?=$me['con']['lang']?>">
    <head>
        <?php if (!isset($docTitle)) $docTitle = $this->uri->segment(1);
              if (empty($docTitle) || strlen($docTitle) < 2) $docTitle = $qtags; 
              else $docTitle = ucfirst(trim($docTitle)); ?>
        <title><?= $docTitle ?> :: TaylorMadeTraffic.com</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="author" content="Eli A Taylor" />
        <meta name="language" content="<?=$me['con']['lang']?>" />
	<link rel="stylesheet" type="text/css" href="/wwwroot/css/jquery.fancybox.css?v=2.1.5" media="screen" />        
        <link type="text/css" rel="stylesheet" href="/wwwroot/css/cubes.css?v=1389164035" />
        <? if ($me['con']['isMobile']): ?>
            <meta name="viewport" content="width=device-width; initial-scale=1.0" />
            <meta name="apple-mobile-web-app-capable" content="yes"  />
            <meta name="apple-mobile-web-app-status-bar-style" content="translucent" />
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
	<script type="text/javascript" src="/wwwroot/js/jquery.fancybox.pack.js?v=2.1.5"></script>
    </head>
    <body id="trackauthority" class="narrowscreen <?=$me['con']['pstyle'];?>" >
        <span id="tmmCube" style="display:none;">
            <?php $cubespins = scandir(ROOT_CD . "/wwwroot/images/cubespins"); $index=0;?>
            <?foreach($cubespins as $img):?>
                <? if($img != '.' && $img != '..' && !strpos($img, '.db')):?>
                    <img data-index="<?=$index?>" <? if($index > 0):?>style='display:none;'<?endif;?>  src="/wwwroot/images/cubespins/<?=$img?>" />
                    <?php $index++; ?>
                <?endif;?>
            <?endforeach;?>
        </span>
        <div class="master">  
            <span id="tmmOpening" ref="0" style="display:none;top:-6px;left:-5px;"></span>
            <div class='topHeader'>
                <?if (isset($qmenu)):?>
                <div style="opacity:0; filter:alpha(opacity=0); " id="navMenu" >
                    <div style="padding-left: 1px;"  class="menuEmpty menuBox"></div>

                    <a href="/eli" title="E.A.Taylor" class="menuBox tc">
                        <img src="/wwwroot/images/eat_menu.png" />
                    </a>

                    <div class="menuEmpty menuBox" id="menuLabelBox" ><span id="menuLabel"></span></div>

                    <a href="/years" title="<?=ucwords($this->lang->en('Years'))?>" class="menuBox ll">
                        <img src="/wwwroot/images/calendar.png" />
                    </a>

                    <a style="margin-top:2px" href="/companies" title="<?=ucwords($this->lang->en('Companies'))?>" class="menuBox lc">
                        <img src="/wwwroot/images/companies.png" />
                    </a>
                    
                    <a href="/industries" title="<?=ucwords($this->lang->en('Industries'))?>" class="menuBox rc">
                        <img src="/wwwroot/images/industries.png" />
                    </a>
                    
                    <a href="/technologies" title="<?=ucwords($this->lang->en('Technologies'))?>" class="menuBox rr">
                        <img src="/wwwroot/images/technologies.png" />
                    </a>

                    <div class="menuEmpty menuBox" style="margin-right:1px; clear:left;">
                        <ul id="menuList" style="display:none" >
                           <img title="<?=$this->lang->msg('english')?>"
                               <?if ($me['con']['lang'] != 'en'):?> style="opacity:.60; filter:alpha(opacity=60);"<?endif;?>
                               onclick="tmt.changeLang('en')" src="/wwwroot/images/United-States_16x16-32.png" />
                           <img 
                               title="<?=$this->lang->msg('español')?>"
                               <?if ($me['con']['lang'] != 'es'):?> style="opacity:.60; filter:alpha(opacity=60);"<?endif;?>
                               onclick="tmt.changeLang('es')" src="/wwwroot/images/Colombia_16x16-32.png" />
                        </ul>                      
                    </div>

                    <a id="menuBoxBottom" href="/taylormade" title="<?=$this->lang->en("Taylor Made")?>" class="menuBox bc">
<!--                        <img src="/wwwroot/images/cubeCorner.png" />-->
                    </a>

                    <div class="menuEmpty menuBox" ></div>
                </div>

                <div id="tagLinks" class="moduleBlock mainNav">
                    <?foreach($qmenu as $key=>$param):?>
                        <?if($param['role'] < 0):?>
                            <?php $seg1 = $this->uri->segment(1); ?>
                            <a class='navItem<? if($key == $seg1 || (empty($seg1) && $key == 'technologies')):?> selected<?endif;?>' href="/<?=$key?>" ><?=ucwords($param['title'])?></a>
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
        <script type="text/javascript" src="/wwwroot/js/cubemanager.js?v=1389255115"></script>
	<link rel="stylesheet" type="text/css" href="/wwwroot/js/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="/wwwroot/js/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
        
        <? if (ENVIRONMENT == 'production'):?>
        <script type="text/javascript">
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-7929826-17', 'trackauthoritymusic.com');
          ga('send', 'pageview');
        </script>        
        <?endif;?>
    </body>
</html>