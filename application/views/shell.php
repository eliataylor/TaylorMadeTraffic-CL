<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <?php if (!isset($docTitle)) $docTitle = $this->uri->segment(1);
              if (empty($docTitle) || strlen($docTitle) < 2) $docTitle = $qtags; 
              else $docTitle = ucfirst(trim($docTitle)); ?>
        <title><?= $docTitle ?> :: TaylorMadeTraffic.com</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta property="fb:admins" content="100000210646549"/>
        <meta name="author" content="Eli A Taylor &copy; <?= date("Y"); ?>" />
        <meta name="language" content="en-us" />
        <LINK REL="SHORTCUT ICON" HREF="/wwwroot/images/tmm_menu.jpg">
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta http-equiv="Cache-control" content="public" />
        <meta HTTP-EQUIV="Pragma" CONTENT="public" />
        <meta name="expires" content="<?= date(DATE_RFC822, strtotime("+3 month")) ?>" />
        <? if ($me['con']['isMobile']): ?>
            <meta name="viewport" content="width=device-width; initial-scale=1.0" />
            <meta name="apple-mobile-web-app-capable" content="yes"  />
            <meta name="apple-mobile-web-app-status-bar-style" content="translucent" />
            <link rel="stylesheet" href="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
            <script src="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
        <? endif; ?>
        <meta name="format-detection" content="telephone=no" />
        <script language="javascript" type="text/javascript">
        var TMT_HTTP = "<?= TMT_HTTP ?>";
        <? if ($this->thisvisitor->auth()): ?>
            var CUR_VISITOR = <?= $me['user_id'] ?>;
        <? else: ?>
            var CUR_VISITOR = false;
        <? endif; ?>
        var VSETTINGS = <?= json_encode($me['con']) ?>;
        </script>
        <? if (!isset($_SERVER['SERVER_NAME']) || strpos($_SERVER['SERVER_NAME'], "localhost") === false): ?>        
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>            
        <? else: ?>
            <script type="text/javascript" src="/wwwroot/js/jquery.min.js"></script>
        <? endif; ?>
        <link rel="stylesheet" href="/wwwroot/css/cubes.css" />
    </head>
    <body <? if (isset($mobile)): ?>class="isMobile <?= $mobile ?>"<? endif; ?>  >
        <span id="tmmOpening" ref="0" style="display:none; top:50px; left:50px;"></span>
        <span id="tmmCube" style="display:none;"></span>  

        <div style="display:none" id="navMenu" >
            <div style="padding-left: 1px;"  class="menuEmpty menuBox"><span style="display:none" id="menuBtn" onclick="tmt.showFullMenu();">MENU</span></div>
            
            <div data-page="eat_menu" title="E.A.Taylor" class="menuBox tc">
                <img src="/wwwroot/images/eat_menu.png" />
            </div>
            
            <div class="menuEmpty menuBox" ><span id="menuLabel"></span></div>
            
            <? foreach($qmenu as $menu):?>
            
            <? endforeach; ?>
            
            <!--<div data-page="kh_menu" title="Kapuna Hale" class="menuBox ll">
                <img src="/wwwroot/images/kh_menu.png" />
            </div>-->
<!--            <div data-big="" data-page="gabby_menu" title="Gabby" class="menuBox ll">
                <img src="/wwwroot/images/gabby_menu.png" />
            </div>-->
            
            <div data-big="http://graph.facebook.com/100000210646549/picture?width=300&height=300" id="quote_boxbtn" data-page="quote_menu" title="why?" class="menuBox ll">
                <img src="http://graph.facebook.com/100000210646549/picture?type=square" width="45" height="45"  />
            </div>
            
            <div data-page="tmm_menu" title="Taylor Made Traffic" class="menuBox lc">
                <img src="/wwwroot/images/tmm_menu.png" />                
            </div>
            
            <div data-page="means_menu" title="The Means..." class="menuBox rc">
                <img src="/wwwroot/images/means_menu.png" />
            </div>
            
            <div data-page="ta_menu" title="Track Authority Music" class="menuBox rr">
                <img src="/wwwroot/images/ta_menu.png" />
            </div>
            
            <div class="menuEmpty menuBox" style="margin-right:1px; clear:left;"><span onclick="tmt.startClose();" style="display:none" id="closeBtn">CLOSE</span></div>
            
            <div data-page="hl_menu" title="Healthline Networks LLC" class="menuBox bc">
                <img src="/wwwroot/images/hl_menu.png" />
            </div> 
            
            <div class="menuEmpty menuBox" style="height:auto; width:auto;" >
                <ul id="menuList" style="display:none"  >
                    <?foreach($qmenu as $menu):?>
                    <?endforeach?>
                    <a href="/#eat"><li title="E.A.Taylor" data-page="eat_menu">History...<img src="/wwwroot/images/eat_menu.png" /></li></a>
                    <a href="/#quotes"><li title="why?" data-page="quote_menu">Why?<img src="http://graph.facebook.com/100000210646549/picture" /></li></a>
                    <a href="/#ta"><li title="Track Authority Music" title="2013+"  data-page="ta_menu">Track Authority Music<img src="/wwwroot/images/ta_menu.png" /></li></a>
                    <a href="/#hl"><li title="Healthline Networks LLC" title="2009-2012" data-page="hl_menu">Healthline Networks LLC<img src="/wwwroot/images/hl_menu.png" /></li></a>
                    <a href="/#means"><li title="The Means..." data-page="2009">The Means<img src="/wwwroot/images/means_menu.png" /></li></a>
                    <a href="/#tmm"><li title="Taylor Made Traffic" title="2008-" data-page="tmm_menu">Taylor Made Traffic<img src="/wwwroot/images/tmm_menu.png" /></li></a>
                </ul>
            </div>
        </div>
        
        <div class="starSprite" style="display:none;" id="taPreloader" > </div>
        <img style="display:none;" id="pageImg" src="/wwwroot/images/eat_big.png"  />

        <script type="text/javascript" src="/wwwroot/js/cubemanager.js?v=1368477918"></script>
        <div class="clearer"></div>
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