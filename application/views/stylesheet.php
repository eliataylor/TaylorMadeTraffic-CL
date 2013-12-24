<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Copyright 2012 Taylor Made Management & Eli Taylor  All Rights Reserved -->
<html>
    <head>
        <meta name="fragment" content="!">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" >
        <title>Taylor Made Management &copy; <?= date("Y"); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="Taylor Made Mangement" />
        <meta name="keywords" content="Taylor Made Management" />
        <meta name="author" content="Eli A Taylor" />
        <meta name="language" content="en-us" />
        <LINK REL="SHORTCUT ICON" HREF="/wwwroot/images/TMM_Logo_flat.ico">
        <!--<link href="http://localhost.taylormadetraffic.com/wwwroot/css/cubes.css" rel="stylesheet" type="text/css" />
        <base href="http://localhost.taylormadetraffic.com/" target="_self" />-->
        <style type="text/css">
            <?= $cubeCSS; ?>            
            .page, .pageTitle, .pageBlock { float:left; clear:both; width:100%; }
            .page { height:500px; margin:20px; }
            iframe { width:98%; height:500px; }
        </style>
<!--       <script type="text/javascript" src="/wwwroot/js/jquery.js"></script>-->
<!--       <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>-->
        <!-- TODO: 
            - more pictures for healthline projects w/ image zooming 
            - Initial cube fall, and zoom at 50,50 (instead of animate to 50,50) -- Requires <img> tag instead of background-image
        -->
    </head>
    <body <? if (isset($mobile)): ?>class="isMobile <?= $mobile ?>"<? endif; ?>  >
        
        <div class="page">
            <h2 class="pageTitle">Mobile</h2>
            <div class="pageBlock">
                <iframe src="/?mobile=true#means" seamless="seamless" ></iframe>
            </div>   
        </div>
        
        <div class="clearer"></div>
        
        <div class="page">
            <h2 class="pageTitle">Fullscreen</h2>
            <div class="pageBlock">
                <iframe src="/#kh" seamless="seamless" ></iframe>
            </div>   
        </div>

        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            try {
                var pageTracker = _gat._getTracker("UA-7929826-3");
                pageTracker._trackPageview();
            } catch(err) {}</script>            
    </body>
</html>