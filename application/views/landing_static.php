<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <?php if (!isset($docTitle)) $docTitle = $this->uri->segment(1);
              if (empty($docTitle) || strlen($docTitle) < 2) $docTitle = "Home"; 
              else $docTitle = ucfirst(trim($docTitle)); ?>
        <title><?php echo  $docTitle ?> :: ID Dashboard</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta property="fb:admins" content="100000210646549"/>
        <meta name="author" content="Eli A Taylor &copy; <?php echo  date("Y"); ?>" />
        <meta name="language" content="en-us" />
        <LINK REL="SHORTCUT ICON" HREF="/wwwroot/images/tmm_menu.jpg">
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta http-equiv="Cache-control" content="public" />
        <meta HTTP-EQUIV="Pragma" CONTENT="public" />
        <meta name="expires" content="<?php echo  date(DATE_RFC822, strtotime("+3 month")) ?>" />
        <? if ($me['con']['isMobile']): ?>
            <meta name="viewport" content="width=device-width; initial-scale=1.0" />
            <meta name="apple-mobile-web-app-capable" content="yes"  />
            <meta name="apple-mobile-web-app-status-bar-style" content="translucent" />
            <link rel="stylesheet" href="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
            <script src="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
        <? endif; ?>
        <meta name="format-detection" content="telephone=no" />
        <script language="javascript" type="text/javascript">
        var TMT_HTTP = "<?php echo  TMT_HTTP ?>";
        <? if ($this->thisvisitor->auth()): ?>
            var CUR_VISITOR = <?php echo  $me['user_id'] ?>;
        <? else: ?>
            var CUR_VISITOR = false;
        <? endif; ?>
        var VSETTINGS = <?php echo  json_encode($me['con']) ?>;
        </script>
        <? if (!isset($_SERVER['SERVER_NAME']) || strpos($_SERVER['SERVER_NAME'], "localhost") === false): ?>        
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>            
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <? else: ?>
            <script type="text/javascript" src="/wwwroot/js/jquery.min.js"></script>
            <script type="text/javascript" src="/wwwroot/js/jquery-ui.min.js"></script>
        <? endif; ?>
        <link rel="stylesheet" href="/wwwroot/css/cubes.css" />
    </head>
    <body <? if (isset($mobile)): ?>class="isMobile <?php echo  $mobile ?>"<? endif; ?>  >
        <span id="tmmOpening" ref="0" style="display:none; top:50px; left:50px;"></span>
        <span id="tmmCube" style="display:none;"></span>  

        <div style="display:none" id="navMenu" >
            <div style="padding-left: 1px;"  class="menuEmpty menuBox"><span style="display:none" id="menuBtn" onclick="tmt.showFullMenu();">MENU</span></div>
            
            <div data-page="eat_menu" title="E.A.Taylor" class="menuBox tc">
                <img src="/wwwroot/images/eat_menu.png" />
            </div>
            
            <div class="menuEmpty menuBox" ><span id="menuLabel"></span></div>
            
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
                    <a href="/#eat"><li title="E.A.Taylor" data-page="eat_menu">History...<img src="/wwwroot/images/eat_menu.png" /></li></a>
                    <a href="/#quotes"><li title="why?" data-page="quote_menu">Why?<img src="http://graph.facebook.com/100000210646549/picture" /></li></a>
                    <!--<a href="/#kh"><li title="Kapuna Hale" data-page="kh_menu">Kapuna Hale<img src="/wwwroot/images/kh_menu.png" /></li></a>-->
                    <a href="/#ta"><li title="Track Authority Music" title="2013+"  data-page="ta_menu">Track Authority Music<img src="/wwwroot/images/ta_menu.png" /></li></a>
                    <a href="/#hl"><li title="Healthline Networks LLC" title="2009-2012" data-page="hl_menu">Healthline Networks LLC<img src="/wwwroot/images/hl_menu.png" /></li></a>
                    <a href="/#means"><li title="The Means..." data-page="2009">The Means<img src="/wwwroot/images/means_menu.png" /></li></a>
                    <a href="/#tmm"><li title="Taylor Made Traffic" title="2008-" data-page="tmm_menu">Taylor Made Traffic<img src="/wwwroot/images/tmm_menu.png" /></li></a>
                </ul>
            </div>
        </div>
        
        <div class="starSprite" style="display:none;" id="taPreloader" > </div>
        <img style="display:none;" id="pageImg" src="/wwwroot/images/eat_big.png"  />

        <div style="display:none;" class="page">
            <h2 class="pageTitle">Collectiv... LLC</h2>
            <div class="pageBlock">

                <div class="eat_menu">
                    <ul> 
                        <li class="pItem">
                            <h3 style="text-align:left;">My name is Eli and this domain - www.TaylorMadeTraffic.com - was the first I ever owned.</h3>
                            <br />
                            <p>"<a href="http://traffic.taylormadetraffic.com/traffic.html" target="_blank">Traffic</a>" was an annual Arts &amp; Business festival I began in the summer of 2003. It was free to the public and outdoors in San Francisco's Union Square Plaza with music, merchandise, fashion shows, art exhibits, vocal competitions, and community outreach. In the 2004 edition, I up'd-the-ante on a business credit card, and lost $25,000 USD across the 4 surrounding, cover-charged, concert events that were intended to fund the whole thing. I will write another entry about how that was not my fault, but for now will admit that I was always a really shitty promoter anyway.</p>
                            <p>Meanwhile, my major was Astrophysics at <a href="http://www.sfsu.edu" target="_blank">SFSU</a> just so that I could tell you that one day. I did love the pure sciences, but I had to face it: I was 23, way to ADD, and not about to spend another 10 years broke in school.</p>
                            <p>I never took classes with a Degree in mind so had tons of credits, but did mind that immediate <a href="http://en.wikipedia.org/wiki/Return_on_investment" target="_blank">ROI</a> on each class. Plus, it turned out  I could finish in 1 year for a BA in Graphic Design and freelance a bit along the way... Done Deal.</p>
                            <p>Luckily, <a href="http://design.sfsu.edu/" target="_blank">DAI's</a> Flash MX class introduced me to <a href="http://en.wikipedia.org/wiki/ActionScript" target="_blank">ActionScript</a> and a few awesome professors. As I improved through AS2, AS3, and MXML (Flex), I started to see the patterns and how easy programming is. </p>
                            <p>But as soon as I finished my degree requirements, I moved to Los Angeles without a bother to walk the stage. I wasn't a big fan of LaLa Land, but it was - at first - very lucrative; providing me the spare time for trail-and-error programming. Thankfully, I did a lot of that because the spare-time-money did dry up; but I had improved enough to take on some big clients still using <a href="http://en.wikipedia.org/wiki/Adobe_Flash" target="_blank">Flash</a>.</p>                      
                            <p>Meanwhile, the huge problems with Adobe Flash were obvious. So I started checking out books for more complete <a href="http://en.wikipedia.org/wiki/LAMP_(software_bundle)" target="_blank">L.A.M.P</a> environments and enrolled in a few courses at Cal State LA.</p>
                            <p>Eventually after learning a lot and exhausting myself completely with LA, I put my stuff in storage and moved to Rio De Janeiro to stay with one of my oldest friends - <a href="https://www.google.com.co/search?q=akintoye+moses" target="_blank">Akintoye Moses</a> - and complete an freelance contract. 
                               But the work was way too consuming to explore or enjoy Basil to the fullest. So when my visa ran up, and a job came up back in the Bay Area, I had to move home. 
                               Soon later I took up an opportunity with Healthline Networks to rebuild an interesting, but ambitious product from their R&amp;D budget that included learning <a href="http://en.wikipedia.org/wiki/Java_(programming_language)" target="_blank">Java</a> on-the-job. Win-Win!</p>
                            <p>After 3 years of that, I quit to retry <em>some</em> of my errors above that came from greater visions. And now, 10 years later from the beginning of this story, I'm back in the Heart of <a href="http://wikitravel.org/en/Bogot%C3%A1#Get_around" target="_blank">Traffic</a> - Bogota, Colombia - hoping to see them again and will try share each experience along the way.</p>
                        </li>
                    </ul>
                    <br />
                    <ul>
                        <li class="pItem">
                            <p>Sincerely Mine,<br />
                                <span class="redtxt">E.A.Taylor</span><br />
                                eli@taylormadetraffic.com<br />
                            </p>
                        </li>
                    </ul>
                    <br />
                    <ul>
                        <li class="pItem">
                            <p>P.S. use the cube/menu above for snapshots of a few visions in-development and from my past</p>
                        </li>
                    </ul>                    
                </div>                          

                <div class="hl_menu">
                    <ul>
                        <li class="pItem">
                            <h3><a target="_blank" href="http://www.healthline.com/corporate/navigator/prod/demo.html">Navigator</a></h3>
                            <p>A Contextual Enrichment Tool Of Rich-Media Health Information and Ads</p>
                            <h4>
                                <div class="thWrap"><img src="/wwwroot/images/sites/healthline/sharecare_allergies.png" align="left" /></div>
                                <span class="graytxt">made:</span> 2009-2012 
                                <span class="graytxt">with:</span> Native JS / Java / SQL
                                <span class="graytxt"><?php echo  date("Y"); ?> &copy; </span> Healthline Networks
                            </h4>
                        </li>

                        <li class="pItem">
                            <h3><a target="_blank" href="http://nav.healthline.com/healthstat/nav/dashboard/login">NavDashboard</a></h3>
                            <p>Reporting and Configuration Tool to target regions of pages for skinned content widgets and ads</p>
                            <h4>
                                <span class="thWrap"><img src="/wwwroot/images/sites/healthline/DashboardCampaingBuilder.png" align="left" /></span>
                                <span class="graytxt">made:</span> 2010, 2012
                                <span class="graytxt">with:</span> jQuery,YUI / Flex / Java / SQL
                                <span class="graytxt"><?php echo  date("Y"); ?> &copy; </span> Healthline Networks
                            </h4>
                        </li>
                        <li class="pItem">
                            <h3><a target="_blank" href="http://www.healthline.com/corporate/navigator/prod/crawler.html?domain=healthline">computeQA</a></h3>
                            <p>Automated Quality Assurance & Monitoring Through Interactive, Intelligent Browser-Based Crawling</p>
                            <h4>
                                <span class="thWrap"><img src="/wwwroot/images/sites/healthline/th/computeQA.png" align="left" /></span>
                                <span class="graytxt">made:</span> 2012
                                <span class="graytxt">with:</span> Native JS / Chrome Extensions / Local Storage &amp; Lawnchiar (websql-lite)
                                <span class="graytxt"><?php echo  date("Y"); ?> &copy; </span> Healthline Networks
                            </h4>
                        </li>
                    </ul>
                </div> 

                <div class="tmm_menu">
                    <p>Below are a few projects I've done over the past few years outside of my fulltime employment with Healthline Networks</p>
                    <ul>
                        <li class="pItem">
                            <h3><a href="http://www.bcbg.com" target="_blank">BCBG</a> / <a href="http://www.herveleger.com" target="_blank">Herveleger</a></h3>
                            <h4>
                                <span class="thWrap"><img src="/wwwroot/images/sites/bcbg/th/bcbg_02.jpg" align="left" /></span>
                                <span class="graytxt">made:</span> 2009
                                <span class="graytxt">with:</span> AS2
                                <span class="graytxt">license:</span> BCBGMaxAzriaGroup &copy; <?php echo  date("Y"); ?>
                            </h4>
                        </li>                        
                        <li class="pItem">
                            <h3><a href="http://www.weddinglocation.com/clientpass/index.php" target="_blank">EliteWeddingLocations.com</a></h3>
                            <h4>
                                <span class="thWrap"><img src="/wwwroot/images/sites/wl/th/wl_th_performance.jpg" align="left" /></span>
                                <span class="graytxt">made:</span> 2008
                                <span class="graytxt">with:</span> jQuery / PHP / mySQL
                                <span class="graytxt">license:</span> Beverly Clark Enterprises &copy; <?php echo  date("Y"); ?>
                            </h4>
                        </li>  
                        <li class="pItem">
                            <h3><a href="http://www.goodlifewithgabby.com" target="_blank">GoodLifeWithGabby.com</a></h3>
                            <h4>
                                <span class="thWrap"><img src="/wwwroot/images/sites/gabby/th/gabby_11.jpg" align="left" /></span>
                                <span class="graytxt">made:</span> 2008
                                <span class="graytxt">with:</span>  AS3
                                <span class="graytxt">license:</span> GoodLife With Gabby &copy; <?php echo  date("Y"); ?>
                            </h4>
                        </li>                                                 
                        <li class="pItem">
                            <h3><a href="http://www.mycubi.com" target="_blank">MyCubi.com</a></h3>
                            <h4>
                                <span class="thWrap"><img src="/wwwroot/images/sites/mycubi/th/cubi_11.jpg" align="left" /></span>
                                <span class="graytxt">made:</span> 2009
                                <span class="graytxt">with:</span> jQuery / Google Maps API v2 / PHP with CodeIgnitor
                                <span class="graytxt">license:</span> MyCubi &copy; <?php echo  date("Y"); ?>
                            </h4>
                        </li>   
                        <li class="pItem">
                            <p>For other older projects I've worked on, visit my early Flash-based site:</p>
                            <h3><a href="http://flash.taylormadetraffic.com/" target="_blank">flash.TaylorMadeTraffic.com</a></h3>
                            <h4>
                                <span class="thWrap"><img src="/wwwroot/images/sites/tmm/th/tmm_04.jpg" align="left" /></span>
                                <span class="graytxt">made:</span> 2008
                                <span class="graytxt">with:</span>  AS3 / MXML (Flex) / XML
                                <span class="graytxt">license:</span> Taylor Made Traffic &copy; 2012</span>
                            </h4>
                        </li>                                                 
                    </ul>
                </div>

                <div class="means_menu">
                    <ul>
                        <li class="pItem">
                            <h3 style="margin-bottom:10px;"><a href="http://www.themeans.info" target="_blank">The Means.info</a></h3>
                            <p>A vision from <a href="http://www.google.com.co/search?q=biko+eisen-martin" target="_blank">Biko Eisen-Martin</a> for his students at <a href="http://bhs.berkeleyschools.net/" target="_blank">Berkeley High School</a> to post essays. We did that to support a semester of essays still worth reading on the site, but the project lost momentum as we both moved cities.</p>
                            <p>This project's greatest potential was in a version-controller for teachers to review, grade and provide feedback on student's essays, while peer reviews drove friendly competition between writer and school rankings.</p>
                            <p>If you are in Education, and feel this could help your classroom and/or school district, <a target="_blank" href="mailto:eli@taylormadetraffic.com">email me</a> and I'd love bring this back to life own our spare time.</p>
                            <input type="hidden" class="secondImgs" value="/wwwroot/images/sites/means/means_07.jpg,/wwwroot/images/sites/means/means_03.jpg,/wwwroot/images/sites/means/means_05.jpg,/wwwroot/images/sites/means/means_04.jpg" />
                        </li>
                    </ul>
                </div>

                <div class="collectiv_menu">
                    <ul>
                        <li class="pItem">
                            <h3><a href="http://www.collectiv.com" target="_blank">Collectiv.com</a></h3>
                            <h4>Empowering The Hip-Hop Community Through Education And Entrepreneurship Since 2001...</h4>
                            <br />
                            <p>In 2001, before MySpace or any social media as we know it, Collectiv.com was built by <a href="http://www.google.com.co/search?q=Sok%20The%20Virgo" target="_blank">Drew</a> and <a href="http://www.facebook.com/bari.a.williams/info" target="_blank">Jaime Williams</a>, then fully incorporated with myself and <a href="http://www.google.com.co/search?q=tommy+goodwin+eventbrite" target="_blank">Tommy Goodwin</a>.</p>
                            <p>Over this past decade, we have each grown on many ideas that  fullfilled it's mission statement above.</p>
                            <p>Currently, the site is only maintained to promote independent artists will a monthly playlist.</p>
                        </li>
                    </ul>
                </div>

                <div class="ta_menu">
                    <ul>
                        <li class="pItem">
                            <h3 style="text-align:right; letter-spacing:1px; font-size: 15px; "><em>...</em>a way for music lovers to play, exchange, and reward musical taste.</h3>
                            <p>Very basically an online game where you enter songs against playlist ideas to win prizes.</p>
                            <p><a href="http://trackauthoritymusic.com" target="_blank">Track Authority Music</a> is currently invite only. But <a href="http://trackauthoritymusic.com/forms/register">ask</a> and you shall receive.</p>
<!--                            <p>Originally envisioned with <a href="http://www.google.com.co/search?q=Sok%20The%20Virgo" target="_blank">Drew Williams</a> as a music community to curate and compose music compilations for event tickets and sponsored prizes.</p>-->
<!--                            <p>Today, a platform for groups to challenge and reward each other for sharing good music.</p>-->
                            <input type="hidden" class="secondImgs" value="/wwwroot/images/sites/ta/onepage.jpg,/wwwroot/images/sites/ta/playlists.jpg" />
                            <br />
                            <p>Taylor Made Traffic &copy; <?php echo  date("Y"); ?></p>
                        </li>
                    </ul>
                </div>

                <div class="quote_menu">
                    <ul>   
                        <li class="pItem" style="margin:50px 25px; text-align:left;">
                            <h3>The navigation on this site is not really meant to be practical.</h3>
                            The essence of effective marketing starts with Design.

                            Regardless of your strategy, visual impressions are the first, and often best, opportunity to communicate a message and command a response.

                            While Art can be criticized and acclaimed, effective marketing design is based on impulse and a universal order of how information is absorbed by the human eye. Basically, aesthetics are a matter of taste to target demographics. As important as those are, marketing design first depends on precise layout, color, and typography to be effective.

                            Strategies then decides how subtle or aggressive your approach, and Style is your angle to convince your audience and match their identity to yours.

                            All this is done through Simplicity.
                            
                            <p>I just need one place to host a few top links for my more dedicated projects and clients.</p>
                            <p>So in 2 days I rewrote all animations here in JavaScript as inspired from my old Flash work: <a href="http://flash.taylormadetraffic.com/" target="_blank">flash.TaylorMadeTraffic.com</a>.</p>
                            <p>In other words, it's just for fun.</p>
                        </li>
                    </ul>                    
                </div>
                
<!--                <div class="kh_menu">
                    <ul>   
                        <li class="pItem">
                            <h3><a target="_blank" href="http://www.kapunahale.com/">KapunaHale.com</a></h3>
                            <p>A family vision for building the perfect retirement home, party house, and wedding venue - all in one - on the most gorgeous Hawaiian Garden Island of Kauai.</p>
                            <p>Now teamed up with <a href="http://www.facebook.com/carl.sandstrom.31" target="_blank">Carl Sandstrom</a> and the <a href="http://www.google.com.co/search?q=house+of+mamasan&oq=house+of+mamasan&sugexp=chrome,mod=1&sourceid=chrome&ie=UTF-8" target="_blank">House of Mamasan</a> it's finally coming together with features well beyond your average Estate Amenities:
                            <ul class="list"><em>including...</em>
                                <li>Professional Size Sand Volleyball Court (30x60 ft.)</li>
                                <li>Skate Half Pipe (16" wide, 32" long, 3" tall)</li>
                                <li>3 Acre Golf Pitching Ranch</li>
                                <li>Artery Ranch</li>
                                <li>2 10"x6" projectors for Video Conferencing and Movies</li>
                                <li>2 outdoor hot tubs</li>
                                <li>and much more</li>
                            </ul>
                            <p class="redtxt">Happy-Birthday-Carl, Construction &amp; Launch Party Saturday, April 27th, 2013...</p>
                            <br />
                            <input type="hidden" class="secondImgs" value="/wwwroot/images/sites/kapuna/th/kp_black_400.jpg,/wwwroot/images/sites/kapuna/with-fam.jpg" />
                        </li>
                    </ul>                    
                </div>-->
            </div>   
        </div>

    <script type="text/javascript" >
        <? if (isset($mobile)): ?>
                var mobile = "<?php echo  $mobile; ?>";           
        <? endif ?>
        </script>
        <script type="text/javascript" src="/wwwroot/js/cubebuilder.js?v=1368477918"></script>
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