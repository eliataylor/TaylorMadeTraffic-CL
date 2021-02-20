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
        <link type="text/css" rel="stylesheet" href="/wwwroot/css/cubes.css?v=1613818573" />
        <meta name="viewport" content="initial-scale=1, width=device-width" />
        <?php if ($me['con']['isMobile']): ?>
            <meta name="apple-mobile-web-app-capable" content="yes"  />
            <meta name="apple-mobile-web-app-status-bar-style" content="translucent" />
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
	<script type="text/javascript" src="/wwwroot/js/jquery.fancybox.pack.js?v=2.1.5"></script>
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
    <body id="trackauthority" class="<?php echo $me['con']['pstyle'];?>" >
    	<img src="/wwwroot/images/cubespins/TUMBLE0054.png" id="printLogo" />
        <span id="tmmCube" style="display:none;">
            <?php $cubespins = scandir(ROOT_CD . "/wwwroot/images/cubespins"); $index=0;?>
            <?php foreach($cubespins as $img):?>
                <?php if($img != '.' && $img != '..' && !strpos($img, '.db')):?>
                    <img data-index="<?php echo $index?>" <?php if($index > 0):?>style='display:none;'<?php endif;?>  src="/wwwroot/images/cubespins/<?php echo $img?>" />
                    <?php $index++; ?>
                <?php endif;?>
            <?php endforeach;?>
        </span>

        <div class="master" id="master">
            <span id="tmmOpening" ref="0" style="display:none;top:-6px;left:-5px;"></span>
            <div class='topHeader'>
                <?php if (isset($qmenu)):?>
                <div style="opacity:0; filter:alpha(opacity=0); visibility: hidden; " id="navMenu" >
                    <div style="padding-left: 1px;"  class="menuEmpty menuBox"></div>

                    <a href="/eli" title="E.A.Taylor" class="menuBox tc">
                        <img src="/wwwroot/images/eat_menu.png" />
                    </a>

                    <div class="menuEmpty menuBox" id="menuLabelBox" ><span id="menuLabel"></span></div>

                    <a href="/years" title="<?php echo ucwords($this->lang->en('Years'))?>" class="menuBox ll">
                        <img src="/wwwroot/images/calendar.png" />
                    </a>

                    <a style="margin-top:2px" href="/companies" title="<?php echo ucwords($this->lang->en('Companies'))?>" class="menuBox lc">
                        <img src="/wwwroot/images/companies.png" />
                    </a>

                    <a href="/industries" title="<?php echo ucwords($this->lang->en('Industries'))?>" class="menuBox rc">
                        <img src="/wwwroot/images/industries.png" />
                    </a>

                    <a href="/technologies" title="<?php echo ucwords($this->lang->en('Technologies'))?>" class="menuBox rr">
                        <img src="/wwwroot/images/technologies.png" />
                    </a>

                    <div class="menuEmpty menuBox" style="margin-right:1px; clear:left;">
                        <ul id="menuList" style="display:none" >
                           <img title="<?php echo $this->lang->msg('english')?>"
                               <?php if ($me['con']['lang'] != 'en'):?> style="opacity:.60; filter:alpha(opacity=60);"<?php endif;?>
                               onclick="tmt.changeLang('en')" src="/wwwroot/images/United-States_16x16-32.png" />
                           <img
                               title="<?php echo $this->lang->msg('español')?>"
                               <?php if ($me['con']['lang'] != 'es'):?> style="opacity:.60; filter:alpha(opacity=60);"<?php endif;?>
                               onclick="tmt.changeLang('es')" src="/wwwroot/images/Colombia_16x16-32.png" />
                        </ul>
                    </div>

                    <a id="menuBoxBottom" href="/taylormade" title="<?php echo $this->lang->en("Taylor Made")?>" class="menuBox bc">
<!--                        <img src="/wwwroot/images/cubeCorner.png" />-->
                    </a>

                    <div class="menuEmpty menuBox" ></div>
                </div>

                <div id="tagLinks" class="mainNav">
                    <?php foreach($qmenu as $key=>$param):?>
                        <?php if($param['role'] < 0):?>
                            <?php $seg1 = $this->uri->segment(1); ?>
                            <a class='navItem<?php if($key == $seg1 || (empty($seg1) && $key == 'technologies')):?> selected<?php endif;?>' href="/<?php echo $key?>" ><?php echo ucwords($param['title'])?></a>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
                <?php endif;?>
            </div>

             <?php if (!empty($errors)): ?>
                <div class="serverErrors">
                    <ul>
                    <?php foreach ($errors as $key => $value): ?>
                        <li><?php echo  $value ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div id="pageBlock" >
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
        <script type="text/javascript" src="/wwwroot/js/cubemanager.js?v=1613473164"></script>
	<link rel="stylesheet" type="text/css" href="/wwwroot/js/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="/wwwroot/js/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    </body>
</html>
