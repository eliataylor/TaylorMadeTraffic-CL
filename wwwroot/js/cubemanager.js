(function(cls, ctx) {   
    ctx[cls] = { 
        tNotice : 0,        
        growInterval : null, spinInterval : null, floatInterval : null,
        spinDeg : 0, growing : 1, opened : 0,       
        mousePos : [400, 400],
        openSpeed : 30, spinSpeed : 25, floatSpeed : 25,
        opening : document.getElementById("tmmOpening"),
        cube : document.getElementById("tmmCube"),
        curPage : "",
        autoSize : function() {
            window.addEventListener('onorientationchange', ctx[cls].autoSize);
            VSETTINGS.swidth = Math.round($(window).width()); // set by isMobile / configs
            VSETTINGS.sheight = Math.round($(window).height()); 
            $.ajax({type:'GET', async:false, url:"/settings?swidth=" + VSETTINGS.swidth + "&sheight=" + VSETTINGS.sheight});

            if (VSETTINGS.swidth < 960 && $("body").hasClass("widescreen")) {
                $("body").removeClass("widescreen").addClass("narrowscreen");
            } else if ($("body").hasClass("narrowscreen") && VSETTINGS.swidth >= 960) {
                $("body").addClass("widescreen").removeClass("narrowscreen");
            }

        },
        initPage : function(cont) {
            if ($(cont).find(".tags_table").length > 0) {
               $(cont).find(".tablesorter").tablesorter({widgets: ['zebra']});               
            }
           
            $(cont).find('a').click(function(e){
               var href = $(this).attr('href');
		if (href.indexOf('http') < 0) { // not on external links      
		    e.preventDefault();
                    if (href && href != '')  ctx[cls].ajaxPage(href);
		}
            });
            
            $(cont).find('.teamInviteLink').click(function(e){
               e.preventDefault();
               ctx[cls].softNotice('Email me to setup (or hide) your account');
            });
        },
        ajaxPage : function(href) {
           document.location.hash="!href=" + href;
           $.ajax({
               type: "GET",
               url: href,
               dataType: 'html'
           }).done(function(html) {
               $('#pageBlock').html(html);
               ctx[cls].initPage('#pageBlock');
               ctx[cls].curPage = href;
           });
           
           var title = (href.indexOf("?") > -1) ? href.substring(0, href.indexOf('?')) : href;
           if (title.indexOf("/") === 0) title = title.substring(1);
           title = title.charAt(0).toUpperCase() + title.slice(1);
           try {
                $("title:first").html( title );
           } catch(e) { //ios
                document.getElementsByTagName("title")[0].nodeValue = title;
           }
           $("#navMenu").find('a').each(function(){
              if ($(this).attr('href') == href) {
                  $(this).addClass('selected');
              } else {
                  $(this).removeClass('selected');
              }
           });
           $(".navItem").each(function(){
              if ($(this).attr('href') == href) {
                  $(this).addClass('selected');
              } else {
                  $(this).removeClass('selected');
              }
           });
        },
        initMouseIntro:function(autostart) {
            var wid = $("body").width();
            if (!wid || wid < 10) wid = 400;
            ctx[cls].cube.style.left = (wid - 50) + "px";
            
            wid = ($("body").height() && $("body").height() > 10) ? $("body").height() : 400;
            ctx[cls].cube.style.top = (wid - 50) + "px";            
            $(ctx[cls].cube).show();            
            
            ctx[cls].spinInterval = setInterval("tmt.spinCube();", ctx[cls].spinSpeed);
            ctx[cls].floatInterval = setInterval("tmt.floatCube();", ctx[cls].floatSpeed);                     
            
            if (autostart){
                ctx[cls].moveToMenu();
            } else {
                document.onmousemove = ctx[cls].setMousePos;
                window.onmousemove = ctx[cls].setMousePos;
                $(ctx[cls].cube).click(function(){
                    ctx[cls].moveToMenu();
                });
            }
            
            if ($("body").hasClass("narrowscreen")) {
                mousePos : [$(window).width() - 50, $(window).height() - 50];
            }
            
            $("#navMenu").find('a').hover(
                function(){
                    if (!$(this).hasClass('selected')) {
                        $(this).find('img:first').animate({opacity:1}, 250);
                    }
                    $("#menuLabel").html($(this).attr("title"));
                },function(){
                    if (!$(this).hasClass('selected')) {
                        $(this).find('img:first').animate({opacity:.5}, 250);
                    }
                }
            );
            $("#navMenu").mouseout(function(){
                $("#menuLabel").html('');
            });

            /*
            $("#menuList").find('li').each(function(){
                var el = $(this).get(0);
                if (el.getAttribute('href'))  {
                    el.onmouseover = function() {
                        this.style.backgroundColor = '#'+Math.floor(Math.random()*16777215).toString(16);
                        document.getElementById("menuLabel").innerHTML = this.getAttribute("title");
                    }, 
                    el.onmouseout = function() { 
                        this.style.backgroundColor = '#000000';
                    }
                }
            });
            */

        },
        initAutoIntro:function() {
            ctx[cls].spinInterval = setInterval("tmt.spinCube();", ctx[cls].spinSpeed);
            $(ctx[cls].cube).click(function(){
                ctx[cls].moveToMenu();
            });
            
            if ($("body").hasClass("narrowscreen")) {
                mousePos : [$(window).width() - 50, $(window).height() - 50];
            }
            
            var wid = $("body").width();
            if (!wid || wid < 10) wid = 400;
            ctx[cls].cube.style.left = (wid - 50) + "px";
            
            wid = ($("body").height() && $("body").height() > 10) ? $("body").height() : 400;
            ctx[cls].cube.style.top = (wid - 50) + "px";
            $(ctx[cls].cube).show();
        },        
        growMenu : function() {   
            var kill = false;
            $(".menuBox").each(function(){
                var dim = $(this).width();                
                $(this).width(dim + 1);
                $(this).height(dim + 1);
                if (dim > 43) {
                    kill = true;
                }
            });
            if (kill === true) {
                clearInterval(ctx[cls].growInterval);
                //$("#menuBtn").fadeIn();    
                //$("#closeBtn").fadeIn();    
                $("#tagLinks").fadeIn();
                $('#menuLabelBox').width(210); // allows better title
                if (ctx[cls].curPage.length === 0) {
                    ctx[cls].ajaxPage('/technologies');
                }
            }
        },
        shrinkMenu : function() {            
            var kill = false;
            $(".menuBox").each(function(){
                var dim = $(this).width();
                $(this).width(dim - 1);
                $(this).height(dim - 1);
                if (dim == 18) {
                    kill = true;
                }
            });
            if (kill == true) {
                clearInterval(ctx[cls].growInterval);
                $(ctx[cls].opening).show();
                ctx[cls].closeCube();
            }
        },
        spinCube:function() {
            ctx[cls].spinDeg = (ctx[cls].spinDeg >= 5900) ? 0 : ctx[cls].spinDeg + 100; // 98.3; 
            ctx[cls].cube.style.backgroundPosition = "0 -" + ctx[cls].spinDeg + "px";
        }, 
        floatCube:function(e) {
            if (ctx[cls].mousePos) {
                var x = (!parseInt(ctx[cls].cube.style.left)) ? 50 : parseInt(ctx[cls].cube.style.left);
                var y = (!parseInt(ctx[cls].cube.style.top)) ? 50 : parseInt(ctx[cls].cube.style.top);
                if (x == 50 && y == 50 && ctx[cls].mousePos[0] == 50 && ctx[cls].mousePos[1] == 50) {
                    ctx[cls].cube.style.top = "auto";
                    ctx[cls].cube.style.left = "auto";
                    ctx[cls].cube.style.right = "50px";
                    ctx[cls].cube.style.bottom = "50px";
                } else {
                    var stepX = (ctx[cls].mousePos[0] - x - ctx[cls].cube.offsetWidth/2) / 20;
                    var stepY = (ctx[cls].mousePos[1] - y - ctx[cls].cube.offsetHeight/2) / 20;
                    ctx[cls].cube.style.left = Math.round(x+stepX) + "px";
                    ctx[cls].cube.style.top = Math.round(y+stepY) + "px";
                }
            }
        }, 
        moveToMenu:function() {
            document.onmousemove = null; 
            window.onmousemove = null; 
            ctx[cls].spinSpeed = 5; // speed up spin
            clearTimeout(ctx[cls].floatInterval);
            ctx[cls].floatInterval = null;
            var wid = $("body").width(), x = -7, y = -12;
            var offset = $('.master:first').offset();
            x += offset.left;
            y += offset.top;
//            if (wid < 800) {
//                x = 5;
//                y = 10;           
//                document.getElementById("navMenu").style.marginLeft = (x + 10) + "px";
//                document.getElementById("navMenu").style.marginTop = (y + 7) + "px";
//                ctx[cls].opening.style.top = y + "px";
//                ctx[cls].opening.style.left = x + "px";
//            }
            var moveTime = 1000; // TODO: relate to distance from target coordinate
            $(ctx[cls].cube).animate({left: x,top:y
            }, moveTime, function() {
                ctx[cls].floatInterval = setInterval("tmt.checkForFrame1();", 10);
            });
        },
        checkForFrame1:function() {
            if (ctx[cls].spinDeg == 0) {
                clearTimeout(ctx[cls].floatInterval);
                clearTimeout(ctx[cls].spinInterval);
                $(ctx[cls].cube).hide();
                ctx[cls].openCube();
                ctx[cls].spinSpeed = 30; // reset for if reopened
                $(ctx[cls].opening).show();
            }                    
        },
        startClose : function() {
            $("#closeBtn").fadeOut(function() {
                ctx[cls].growInterval = setInterval("tmt.shrinkMenu();", ctx[cls].openSpeed);
            });    
            
        },
        closeCube:function() {
            var openDeg = parseInt(ctx[cls].opening.getAttribute("ref"));
            if (openDeg <= 0) {
                $(ctx[cls].cube).show();
                $(ctx[cls].opening).hide();
                document.onmousemove = ctx[cls].setMousePos; 
                window.onmousemove = ctx[cls].setMousePos; 
                window.onclick = function(e){
                    ctx[cls].setMousePos(e); 
                    ctx[cls].moveToMenu(e); 
                };
                window.onclick = ctx[cls].moveToMenu; 
                ctx[cls].spinInterval = setInterval("tmt.spinCube();", ctx[cls].openSpeed);
                ctx[cls].floatInterval = setInterval("tmt.floatCube();", ctx[cls].openSpeed);                     
                return;
            }
            else {
                openDeg = openDeg - 101; 
                ctx[cls].opening.setAttribute("ref", openDeg);
                ctx[cls].opening.style.backgroundPosition = "0 -" + openDeg + "px";
                setTimeout("tmt.closeCube();", ctx[cls].openSpeed);
            }
        },
        openCube:function() {
            var openDeg = parseInt(ctx[cls].opening.getAttribute("ref"));
            if (openDeg > 5656) {
                $("#navMenu").css({opacity:1});
                $(ctx[cls].opening).fadeOut(function(){
                    ctx[cls].growInterval = setInterval("tmt.growMenu();", ctx[cls].openSpeed);
                });
            } else {
                openDeg = openDeg + 101; 
                ctx[cls].opening.setAttribute("ref", openDeg);
                ctx[cls].opening.style.backgroundPosition = "0 -" + openDeg + "px";
                setTimeout("tmt.openCube();", ctx[cls].openSpeed);
            }
        }, 
        setMousePos: function (e) {
            var posx = 50;
            var posy = 50;
            if (!e) e = window.event;
            if (e.pageX || e.pageY) 	{
                posx = e.pageX;
                posy = e.pageY;
            } else if (e.clientX || e.clientY) 	{
                posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
                posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
            }
            if (!posx || !posy) ctx[cls].mousePos = [$("body").width()/2, $("body").height()/2];
            else ctx[cls].mousePos = [posx, posy];
        },
        showTaPreloader : function(isFirst) {
            if (!isFirst && $("#taPreloader").is(":visible")) {
                return false;
            } else if (isFirst) {
                $("#taPreloader").show();
                ctx[cls].spinInterval = 0;
            }
            var next = (ctx[cls].spinInterval >= 24) ? 0 : ctx[cls].spinInterval + 1;
            ctx[cls].spinInterval = next;
            document.getElementById("taPreloader").style.backgroundPosition = "0 -" + (next * 175) + "px";
            setTimeout('tmt.showTaPreloader(false);', 50);                        
        },
        softNotice : function(msg, stayopen) {
            var html = "";
            if (typeof msg == 'object') {
                for(var i in msg) {
                    html += "<p class='"+i+"'>" + msg[i] + "</p>";
                }
            } else {
                html = msg;
                if (msg.length < 30) $("#softNoticeBody").css({'font-size':30});
                else $("#softNoticeBody").css({'font-size':15});
            }
            $("#softNoticeBody").html(html);
            $("#softNotice").fadeIn();
            ctx[cls].tNotice = 1;
            if (!stayopen) ctx[cls].closeNoticeIf();
        }, 
        closeNoticeIf : function() {
            if (ctx[cls].tNotice > 4) {
                $('#softNotice').fadeOut(400);
                ctx[cls].tNotice = -1;
            } else if (ctx[cls].tNotice > -1) {
                ctx[cls].tNotice++;
                setTimeout("tmt.closeNoticeIf();", 1000);
            }
        }, closeNotice : function() {
            ctx[cls].tNotice = -1;
            $("#softNotice").fadeOut();
        }
    };
})("tmt", this);
        
$(document).ready(function() {
    tmt.autoSize();
    tmt.curPage = document.location.pathname + document.location.search;
    
    var href = document.location.hash;
    if (href && href.indexOf('!href=') > -1) {
        href = href.substring(href.indexOf('!href=') + '!href='.length);
        if (href != '' && href != document.location.pathname) {
            tmt.ajaxPage(href);
        }        
    }
    if ($(tmt.cube).length == 1) {
        if(typeof window.orientation !== 'undefined') {
            tmt.initAutoIntro();
        } else {
            var autostart = ((href && href.length > 1) || (document.location.pathname.length > 1))  ? true : false;
            tmt.initMouseIntro(autostart);
        }
    }
    tmt.initPage(document.body);
});