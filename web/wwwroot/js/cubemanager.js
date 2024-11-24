/*
before you do what i know you're gunna do and FREAK OUT!!!,
just know i wrote this good 'ol jQuery back 08'.
YEAH!!! ...so go take your modern day frameworks and webpackery and shove it!


i'll be done the same :/

*/

(function(cls, ctx) {
    ctx[cls] = {
        tNotice : 0,
        growInterval : null, spinInterval : null, floatInterval : null, pulseInterval : null,
        spinDeg : 0, growing : 1, opened : 0,
        mousePos : [400, 400],
        openSpeed : 30, spinSpeed : 25, floatSpeed : 25, pulseSpeed : 25,
        opening : document.getElementById("tmmOpening"),
        cube : document.getElementById("tmmCube"),
        curPage : "",
        initPage : function(cont) {

            if ($('.companyHead').length > 0) {
            	ctx[cls].toggleGroupRows('all');
            } else if ($(cont).find(".tags_table").length > 0) {
               $(cont).find(".tablesorter").tablesorter({widgets: ['zebra']});
            }

            $(cont).find('.companyHead').click(function() {
            	var groupname = $(this).attr('data-group');
                var caret = $(this).find('.caret');
                if (caret.hasClass('opened')) {
                    caret.removeClass('opened').addClass('closed');
                } else {
                    caret.removeClass('closed').addClass('opened');
                }
            	ctx[cls].toggleGroupRows(groupname);
            });

            $(cont).find('a').click(function(e){
               var href = $(this).attr('href');
				if (href.indexOf('http') < 0 && !$(this).hasClass('fancybox')) { // not on external links
				    e.preventDefault();
		                    if (href && href != '')  ctx[cls].ajaxPage(href);
				}
            });

            $(cont).find('.teamInviteLink').click(function(e){
               e.preventDefault();
               ctx[cls].softNotice('Email eli@taylormadetraffic.com to setup (or hide) your account');
            });


            if ($(cont).find('.fancybox').length > 0) {
                $(cont).find('.fancybox').click(function(){
                    //onclick="$('#galleryImg<?=$project->project_id?>').attr('src',this.getAttribute('data-oimage')).css({maxWidth:this.getAttribute('data-owidth')});return false;"
                    $('.fancybox').fancybox({
                            helpers : {
                                thumbs : {
                                        width  : 50,
                                        height : 50
                                }
                            }
                    });

                });

            }


            $(window).bind( 'hashchange', function( event ) {
                 var hash = window.location.hash;
                 if (hash.indexOf("#!href=") > -1)
                 	hash = hash.substring(hash.indexOf("#!href=") + "#!href=".length);
                 if (hash != ctx[cls].curPage) {
                     ctx[cls].ajaxPage(hash);
                 }
             });

        },
        toggleCaret: function() {
            $(this).find('.caret').toggle('open');
            $(this).find('.caret').toggle('closed');
        },
        toggleGroupRows : function(groupname) {
        	$('.projectRow').each(function(){
        		if ($(this).attr('data-group') == groupname || groupname == 'all') {
        			if (!$(this).is(":visible")) $(this).slideDown();
        			else $(this).slideUp();
        		} else {
        			$(this).slideUp();
        		}
        	});
        },
        ajaxPage : function(href) {
           if (ctx[cls].cube.id == 'menuPreloader') {
                //$(ctx[cls].cube).find('img:first').css({opacity:1});
                clearInterval(ctx[cls].spinInterval);
                ctx[cls].spinInterval = setInterval("tmt.spinCube();", ctx[cls].spinSpeed);
           }

           ctx[cls].curPage = href;
           document.location.hash="!href=" + href;
           $.ajax({
               type: "GET",
               url: href,
               dataType: 'html'
           }).done(function(html) {
               $('#pageBlock').html(html);
               ctx[cls].initPage('#pageBlock');
               if (ctx[cls].cube.id == 'menuPreloader') {
                   clearInterval(ctx[cls].spinInterval);
               }
           });

           var title = (href.indexOf("?") > -1) ? href.substring(0, href.indexOf('?')) : href;
           if (title.indexOf("/") === 0) title = title.substring(1);
           title = title.charAt(0).toUpperCase() + title.slice(1);
           try {
                $("title:first").html( title );
           } catch(e) { //ios
                document.getElementsByTagName("title")[0].nodeValue = title;
           }
           $("a.menuBox").each(function(){
              if ($(this).attr('href') == href) {
                  $(this).addClass('selected');
                  $(this).find('img').css({opacity:1});
              } else {
                  $(this).find('img').css({opacity:.5});
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
        changeLang : function(lang) {

            var href = document.location.hash;
            if (href && href.indexOf('!href=') > -1)
                href = href.substring(href.indexOf('!href=') + '!href='.length); //  assumes last hash param
            if (!href || href == '')
                href = document.location.pathname;

            if (lang == 'en') lang = 'www';
            var host = location.hostname.split('.');
            if (host.length > 2) {
                host = lang + "." + host[1] + "." + host[2];
            } else {
                host = lang + "." + location.hostname;
            }
            document.location.href = 'http://' + host + href;
        },
        initMouseIntro:function(autostart) {
            ctx[cls].cube.style.left = $(window).width() + "px";
            ctx[cls].cube.style.top = 100 + "px";
            $(ctx[cls].cube).show();

            clearInterval(ctx[cls].spinInterval);
            ctx[cls].spinInterval = setInterval("tmt.spinCube();", ctx[cls].spinSpeed);
            ctx[cls].floatInterval = setInterval("tmt.floatCube();", ctx[cls].floatSpeed);
            ctx[cls].pulseInterval = setInterval("tmt.pulseCube();", ctx[cls].pulseSpeed);

            if (autostart){
                ctx[cls].moveToMenu();
            } else {
                document.onmousemove = ctx[cls].setMousePos;
                window.onmousemove = ctx[cls].setMousePos;
                $(ctx[cls].cube).click(function(){
                    ctx[cls].moveToMenu();
                });
            }

            if (VSETTINGS.swidth >= 960 && $('#pageBlock').height() < 1000) {
                mousePos : [$(window).width() - 50, $(window).height() - 50];
            }

            $("a.menuBox").hover(
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
                $('a.menuBox').each(function() {
                    if ($(this).hasClass('selected') || ctx[cls].curPage == $(this).attr('href')) $(this).find('img:first').animate({opacity:1});
                    else $(this).find('img:first').animate({opacity:.5});
                });
                ctx[cls].cube = document.getElementById('menuPreloader');
                clearInterval(ctx[cls].growInterval);
                $('#menuList').fadeIn();
                if ($(window).width() > 550) $('#menuLabelBox').width(210); // allows longer titles
                if (ctx[cls].curPage.length < 2) { // slash not included
                    ctx[cls].ajaxPage('/technologies');
                } else {
                    $('a.menuBox').each(function(e){
                       if ($(this).attr('href') == ctx[cls].curPage) {
                           $(this).find('img').css({opacity:1});
                           return false;
                       }
                    });
                }
            }
        },
        initPreloader : function() {
            var cube = ctx[cls].cube.cloneNode(true);
            cube.id = 'menuPreloader';
            cube.setAttribute('style', '');
            var imgs = cube.getElementsByTagName('img');
            ctx[cls].spinDeg = 6;
            imgs[0].src = imgs[ctx[cls].spinDeg].src;
            $('#menuBoxBottom').html(cube);
        },
        pulseCube : function() {
            if (ctx[cls].cube.id != 'menuPreloader') {
                var wid = $(ctx[cls].cube).width();
                var hei = $(ctx[cls].cube).height();
                var inc = parseInt($(ctx[cls].cube).attr('data-pulsedir')) || -1;
                var minWid = ( (document.location.hash.length > 4 || document.location.pathname.length > 1) && typeof window.orientation == 'undefined')  ? 25 : 50; // if it's moving with the mouse and depends on a click to open, don't go so small
                if (wid > 120) {
                    inc = -1;
                } else if (wid <= minWid) {
                    inc = 1;
                }
                $(ctx[cls].cube).attr('data-pulsedir', inc);
                ctx[cls].cube.style.width = (wid+inc) + "px";
                ctx[cls].cube.style.height = (hei+inc) + "px";
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
            var imgs = ctx[cls].cube.getElementsByTagName('img');
            ctx[cls].spinDeg = (ctx[cls].spinDeg > 58) ? 0 : ctx[cls].spinDeg+1;
            imgs[0].src = imgs[ctx[cls].spinDeg].src;
        },
        floatCube:function(e) {
            if (ctx[cls].mousePos) {
                var wid = $(ctx[cls].cube).width();
                var hei = $(ctx[cls].cube).height();
                var x = (!parseInt(ctx[cls].cube.style.left)) ? wid : parseInt(ctx[cls].cube.style.left);
                var y = (!parseInt(ctx[cls].cube.style.top)) ? hei : parseInt(ctx[cls].cube.style.top);
                if (x == wid && y == hei && ctx[cls].mousePos[0] == wid && ctx[cls].mousePos[1] == hei) {
                    ctx[cls].cube.style.top = "auto";
                    ctx[cls].cube.style.left = "auto";
                    ctx[cls].cube.style.right = wid + "px";
                    ctx[cls].cube.style.bottom = hei + "px";
                } else {
                    var stepX = (ctx[cls].mousePos[0] - x - wid/2) / 20;
                    var stepY = (ctx[cls].mousePos[1] - y - hei/2) / 20;
                    ctx[cls].cube.style.left = Math.round(x+stepX) + "px";
                    ctx[cls].cube.style.top = Math.round(y+stepY) + "px";
                }
            }
        },
        moveToMenu:function() {
            $('a.menuBox img').css({opacity:0});
            document.onmousemove = null;
            window.onmousemove = null;
            ctx[cls].spinSpeed = 5; // speed up spin
            clearInterval(ctx[cls].floatInterval);
            ctx[cls].floatInterval = null;
            var wid = $("body").width(), x = -12, y = -5;
            var offset = $('.master:first').offset();
            x += offset.left;
            y += offset.top;
            var cubeOff = $(ctx[cls].cube).offset();
            // relate to distance from target coordinate x // 0 offset should be around 1 second, 1700 should around 3 seconds
            var moveTime = Math.max((cubeOff.left - x), (cubeOff.top - y));
            moveTime = moveTime + (2500);
            $(ctx[cls].cube).animate({left: x,top:y
            }, moveTime, function() {
                ctx[cls].floatInterval = setInterval("tmt.checkForFrame1();", 10);
            });
        },
        checkForFrame1:function() {
            var cubeWid = $(ctx[cls].cube).width();
            if (cubeWid == 100) {
                clearInterval(ctx[cls].pulseInterval);
                if (ctx[cls].spinDeg == 0) {
                    clearInterval(ctx[cls].spinInterval);
                }
            }
            if (ctx[cls].spinDeg == 0 && cubeWid == 100) {
                clearInterval(ctx[cls].floatInterval); // recalls checkforFrame1, but wait for both
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
                $("#navMenu").css({opacity:1, visibility:'visible'});
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
    tmt.curPage = document.location.pathname + document.location.search;
    var href = document.location.hash;
    if (href && href.indexOf('!href=') > -1) {
        href = href.substring(href.indexOf('!href=') + '!href='.length);
        if (href != '' && href != document.location.pathname) {
            tmt.ajaxPage(href);
        }
    }
    if ($(tmt.cube).length == 1) { // cms pages
        tmt.initMouseIntro(true);
        tmt.initPreloader();
    }
    tmt.initPage(document.body);
    /*
    var xAngle = 0, yAngle = 0;
    document.addEventListener('keydown', function(e) {
      switch(e.keyCode) {

        case 37: // left
          yAngle -= 90;
          break;

        case 38: // up
          xAngle += 90;
          break;

        case 39: // right
          yAngle += 90;
          break;

        case 40: // down
          xAngle -= 90;
          break;
      };

      document.getElementById('domCube').style.webkitTransform = "rotateX("+xAngle+"deg) rotateY("+yAngle+"deg)";
    }, false);
    */
});
