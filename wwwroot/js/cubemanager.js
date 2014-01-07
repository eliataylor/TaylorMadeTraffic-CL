(function(wrap, cont) {   
    cont[wrap] = { 
        tNotice : 0,
        spinDeg : 0,
        growInterval : null,
        spinInterval : null,
        floatInterval : null,
        growing : 1,
        menuOpen : false,
        opened : 0,       
        mousePos : [400, 400],
        openSpeed : 30,
        spinSpeed : 25,
        floatSpeed : 25,
        opening : document.getElementById("tmmOpening"),
        cube : document.getElementById("tmmCube"),
        curPage : "eat_menu",
        cubeTabs : ["eat_menu", "collectiv_menu", "quote_menu", "tmm_menu", "means_menu", "ta_menu", "hl_menu"],  // "kh_menu", 
        preinit:function() {
            $("#pageImg").hide();            
            $(".page").hide();
            $("#navMenu").hide();    
            $("#menuBtn").hide();    
            $("#closeBtn").hide();    
            $("#menuList").hide();
        }, 
        autoSize : function() {
            window.addEventListener('onorientationchange', tmt.autoSize);
            VSETTINGS.swidth = Math.round($(window).width()); // set by isMobile / configs
            var swid = (swid > 1000) ? 1000 : VSETTINGS.swidth; // max
            $.ajax({type:'GET', async:false, url:"/settings?swidth=" + VSETTINGS.swidth + "&sheight=" + VSETTINGS.sheight});

            if (VSETTINGS.swidth <= 980 && $("body").hasClass("widescreen")) {
                $("body").removeClass("widescreen").addClass("narrowscreen");
            } else if ($("body").hasClass("narrowscreen") && VSETTINGS.swidth >= 1000) {
                $("body").addClass("widescreen").removeClass("narrowscreen");
            }

        },
        initTable : function(cont) {
            if ($(cont).find(".tags_table").length > 0)
               $(cont).find(".tablesorter").tablesorter({widgets: ['zebra']});
           
            $(cont).find('a').click(function(e){
               e.preventDefault();
               var href = $(this).attr('href');
               if (href && href != '') 
                   tmt.ajaxPage(href)
            })
        },
        ajaxPage : function(href) {
           document.location.hash="!href=" + href;
           $.ajax({
               type: "GET",
               url: href,
               dataType: 'html'
           }).done(function(html) {
               $("#pagePreloader").fadeOut("fast");
               $('#pageBlock').html(html);
               tmt.initTable('#pageBlock');
           });
           
           var title = (href.indexOf("?") > -1) ? href.substring(0, href.indexOf('?')) : href;
           if (title.indexOf("/") === 0) title = title.substring(1);
           title = title.charAt(0).toUpperCase() + title.slice(1);
           try {
                $("title:first").html( title );
           } catch(e) { //ios
                document.getElementsByTagName("title")[0].nodeValue = title;
           }
           
        },
        init:function() {
            $("#pageImg").hide();            
            document.onmousemove = tmt.setMousePos; 
            window.onmousemove = tmt.setMousePos; 
            document.onclick = tmt.moveToMenu; 
            window.onclick = tmt.moveToMenu; 
            
            if ($("body").hasClass("isMobile")) {
                mousePos : [$(window).width() - 50, $(window).height() - 50];
            }
            
            document.getElementById("navMenu").onmouseout = function() {
                document.getElementById("menuLabel").innerHTML = "";  
                var els = document.getElementById("navMenu").getElementsByTagName("IMG"), i = 0;
                for (i=0; i < els.length; i++) {
                    if (els[i].getAttribute('data-page') && tmt.curPage != els[i].getAttribute('data-page') && $(els[i]).css('opacity') > 0)  
                        $(els[i]).animate({opacity:.50}, 250);
                }            
            }
            var wid = $("body").width();
            if (wid < 800) document.body.className += " narrow";
            if (!wid || wid < 10) wid = 400;
            tmt.cube.style.left = (wid - 50) + "px";
            
            wid = ($("body").height() && $("body").height() > 10) ? $("body").height() : 400;
            tmt.cube.style.top = (wid - 50) + "px";            
            $(tmt.cube).show();            

            tmt.spinInterval = setInterval("tmt.spinCube();", tmt.spinSpeed);
            tmt.floatInterval = setInterval("tmt.floatCube();", tmt.floatSpeed);                     
            tmt.activateMenu();
            //tmt.growMenu();
            
            if (document.location.hash != "" && document.location.hash != "#") {                
                var hash = document.location.hash.substr(1);
                for (i =0 ; i < tmt.cubeTabs.length; i++){
                    if (tmt.cubeTabs[i].indexOf(hash) == 0){
                        tmt.curPage = tmt.cubeTabs[i];
                        tmt.moveToMenu();
                        return true;
                    }
                }                
            }
            
        },
        activateMenu : function() {
            var els = tmt.getElementsByClassName("menuBox", document.getElementById("navMenu")), i = 0;
            for (i=0; i < els.length; i++) {
                if (els[i].getAttribute("title") && els[i].getAttribute('data-page'))  {
                    
                    els[i].getElementsByTagName("IMG")[0].setAttribute("data-page", els[i].getAttribute('data-page'));
                    
                    els[i].onmouseover = function() {
                        document.getElementById("menuLabel").innerHTML = this.getAttribute("title");
                        var img = this.getElementsByTagName("IMG")[0];
                        if ($(img).css('opacity') < 1)
                            $(img).animate({opacity:1}, 500);                        
                    }, 
                    els[i].getElementsByTagName("IMG")[0].onmouseout = function() { 
                        if (tmt.curPage != this.getAttribute('data-page') && $(this).css('opacity') > 0) 
                            $(this).animate({opacity:.50}, 250);
                    }
                    els[i].onclick = function() {
                        tmt.loadPage(this.getAttribute('data-page'), this.getAttribute('title') );
                        return false;
                    }
                }
            }
            
            els = document.getElementById("menuList").getElementsByTagName("LI"), i = 0;
            for (i=0; i < els.length; i++) {
                if (els[i].getAttribute('data-page'))  {
                    els[i].onmouseover = function() {
                        this.style.backgroundColor = '#'+Math.floor(Math.random()*16777215).toString(16);
                        document.getElementById("menuLabel").innerHTML = this.getAttribute("title");
                    }, 
                    els[i].onmouseout = function() { 
                        this.style.backgroundColor = '#000000';
                    }
                    els[i].onclick = function() {
                        tmt.loadPage(this.getAttribute('data-page'), this.getAttribute("title"));
                        return false;
                    }
                }
            }            
        },  
        showFullMenu : function() {
            if (document.getElementById("menuList").style.display == "none") {
                $('#menuList').slideDown();            
                tmt.menuOpen = true;
            } else {
                $('#menuList').slideUp();            
                tmt.menuOpen = false;
            }
        },
        loadPage : function(page, title) {
            
            tmt.curPage = page;
            $(".pageTitle").html( (title == "E.A.Taylor" ) ? "Hello World <span class='postDate'>Dec. 1st, 2012</span>" : title );

            var pages = this.cubeTabs, i =0;            
            for (i=0; i < pages.length; i++) {
                if (pages[i] != page) {
                    if ($(".page").is(":hidden")) $("." + pages[i]).hide();
                    else $("." + pages[i]).slideUp();
                }
            }
            if ($(".page").is(":hidden")) $(".page").slideDown();
            $("." + page).slideDown();
            
            var img = document.getElementById("pageImg");   
            var basename = page.replace("_menu", "");
            if (document.getElementById(basename + "_boxbtn") && document.getElementById(basename + "_boxbtn").getAttribute("data-big")) {
                img.src = document.getElementById(basename + "_boxbtn").getAttribute("data-big");
            } else {
                img.src = "/wwwroot/images/" + basename + "_big" + ".png";
            }
            
            var els = tmt.getElementsByClassName("menuBox");
            for (i=0; i < els.length-1; i++) { // -1 last one is empty anyway
                var img = els[i].getElementsByTagName("IMG")[0];
                if (els[i].getAttribute("data-page") == tmt.curPage && $(img).css('opacity') < 1) 
                    $(img).animate({opacity:1});
            }
            
            $("." + page + " .secondImgs").each(function() {
                var paths = $(this).val();
                els = paths.split(",");
                for (i = 0; i < els.length; i++) {
                    var img = document.createElement("IMG");
                    img.className = "pageSnap";
                    img.src = els[i];
                    $(this).before(img);
                };
                $(this).removeClass("secondImgs");
            });
            
//            if (basename == 'ta') {
//                $(img).hide();
//                tmt.showTaPreloader(true);
//            } else {
//                $("#taPreloader").hide();
//            }
            if ($("#pageImg").is(":hidden")) {
                $("#pageImg").fadeIn();
            }
            
            document.location.hash = page.replace("_menu", ""); // already on stage
            
        }, 
        growMenu : function() {            
            var kill = false, els = tmt.getElementsByClassName("menuBox"), title = "All";
            for (var i=0; i < els.length-1; i++) {
                var dim = $(els[i]).width();                
                $(els[i]).width(dim + 1);
                $(els[i]).height(dim + 1);
                if (dim > 43) {
                    kill = true;
                }
                if (els[i].getAttribute("data-page") == tmt.curPage) title = els[i].getAttribute("title");
            }
            if (kill == true) {
                clearInterval(this.growInterval);
                $("#menuBtn").fadeIn();    
                $("#closeBtn").fadeIn();    
                tmt.loadPage(tmt.curPage, title);
            }
        },
        shrinkMenu : function() {            
            var kill = false, els = tmt.getElementsByClassName("menuBox");
            for (var i=0; i < els.length-1; i++) {
                var dim = $(els[i]).width();
                $(els[i]).width(dim - 1);
                $(els[i]).height(dim - 1);
                if (dim == 18) {
                    kill = true;
                }
            }
            if (kill == true) {
                clearInterval(this.growInterval);
                $(tmt.opening).show();
                $("#pageImg").fadeOut("slow");            
                $(".page").slideUp();
                $("#navMenu").fadeOut(function(){
                    tmt.closeCube();
                });
            }
        },
        spinCube:function() {
            this.spinDeg = (this.spinDeg >= 5900) ? 0 : this.spinDeg + 100; // 98.3; 
            tmt.cube.style.backgroundPosition = "0 -" + this.spinDeg + "px";
        }, 
        floatCube:function(e) {
            if (tmt.mousePos) {
                var x = (!parseInt(tmt.cube.style.left)) ? 50 : parseInt(tmt.cube.style.left);
                var y = (!parseInt(tmt.cube.style.top)) ? 50 : parseInt(tmt.cube.style.top);
                if (x == 50 && y == 50 && tmt.mousePos[0] == 50 && tmt.mousePos[1] == 50) {
                    tmt.cube.style.top = "auto";
                    tmt.cube.style.left = "auto";
                    tmt.cube.style.right = "50px";
                    tmt.cube.style.bottom = "50px";
                } else {
                    var stepX = (tmt.mousePos[0] - x - tmt.cube.offsetWidth/2) / 20;
                    var stepY = (tmt.mousePos[1] - y - tmt.cube.offsetHeight/2) / 20;
                    tmt.cube.style.left = Math.round(x+stepX) + "px";
                    tmt.cube.style.top = Math.round(y+stepY) + "px";
                }
            }
        }, 
        moveToMenu:function() {
            tmt.spinSpeed = 5; // speed up spin
            clearTimeout(tmt.floatInterval);
            tmt.floatInterval = null;
            document.onmousemove = null; 
            document.onclick = null; 
            window.onmousemove = null; 
            window.onclick = null; 
            
            var wid = $("body").width(), x = 50, y = 50;
            if (wid < 800) {
                x = 5;
                y = 10;           
                document.getElementById("navMenu").style.marginLeft = (x + 10) + "px";
                document.getElementById("navMenu").style.marginTop = (y + 7) + "px";
                tmt.opening.style.top = y + "px";
                tmt.opening.style.left = x + "px";
                $(".page").width(wid-35);
            }
            $('#tmmCube').animate({
                left: x, 
                top:y
            }, 1000, function() {
                tmt.floatInterval = setInterval("tmt.checkForFrame1();", 10);
            });                    
        },
        checkForFrame1:function() {
            if (tmt.spinDeg == 0) {
                clearTimeout(tmt.floatInterval);
                clearTimeout(tmt.spinInterval);
                tmt.cube.style.display = "none";
                tmt.openCube();
                tmt.spinSpeed = 30; // reset for if reopened
                tmt.opening.style.display = "";
            }                    
        },
        startClose : function() {
            if (document.getElementById("menuList").style.display != "none") {
                $('#menuList').slideUp();            
                tmt.menuOpen = false;
            }
            $("#menuBtn").fadeOut();    
            $("#closeBtn").fadeOut(function() {
                tmt.growInterval = setInterval("tmt.shrinkMenu();", tmt.openSpeed);
            });    
            
        },
        closeCube:function() {
            var openDeg = parseInt(tmt.opening.getAttribute("ref"));
            if (openDeg <= 0) {
                tmt.cube.style.display = "";
                tmt.opening.style.display = "none";
                document.onmousemove = tmt.setMousePos; 
                window.onmousemove = tmt.setMousePos; 
                window.onclick = function(e){
                    tmt.setMousePos(e); 
                    tmt.moveToMenu(e); 
                };
                window.onclick = tmt.moveToMenu; 
                tmt.spinInterval = setInterval("tmt.spinCube();", tmt.openSpeed);
                tmt.floatInterval = setInterval("tmt.floatCube();", tmt.openSpeed);                     
                return;
            }
            else {
                openDeg = openDeg - 101; 
                tmt.opening.setAttribute("ref", openDeg);
                tmt.opening.style.backgroundPosition = "0 -" + openDeg + "px";
                setTimeout("tmt.closeCube();", tmt.openSpeed);
            }
        },
        openCube:function() {
            var openDeg = parseInt(tmt.opening.getAttribute("ref"));
            if (openDeg > 5656) {
                $("#navMenu").show();
                $(tmt.opening).fadeOut(function(){
                    tmt.growInterval = setInterval("tmt.growMenu();", tmt.openSpeed);
                });
                return;
            }
            else {
                openDeg = openDeg + 101; 
                tmt.opening.setAttribute("ref", openDeg);
                tmt.opening.style.backgroundPosition = "0 -" + openDeg + "px";
                setTimeout("tmt.openCube();", tmt.openSpeed);
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
            if (!posx || !posy) tmt.mousePos = [$("body").width()/2, $("body").height()/2];
            else tmt.mousePos = [posx, posy];
        }, 
        getElementsByClassName : function (searchClass, node, tag) {
            var matches = [];
            if (!node) node = document;
            if (!node) {
                this.tracer(node, "ERROR: no such node to start looking for a class name");
            } else if (document.getElementsByClassName) { // use native method when available
                matches = node.getElementsByClassName(searchClass);
            } else {
                if (!tag) tag = '*',
                    els = node.getElementsByTagName(tag),
                    pattern = new RegExp("(^|\\s)" + searchClass + "(\\s|$)");

                for (var i = 0,j = 0,l = els.length; i < l; i++) {
                    if (pattern.test(els[i].className)) {
                        matches[j] = els[i];
                        j++;
                    }
                }
            }
            return matches;
        },
        showTaPreloader : function(isFirst) {
            if (!isFirst && $("#taPreloader").is(":visible")) {
                return false;
            } else if (isFirst) {
                $("#taPreloader").show();
                tmt.spinInterval = 0;
            }
            var next = (tmt.spinInterval >= 24) ? 0 : tmt.spinInterval + 1;
            tmt.spinInterval = next;
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
            tmt.tNotice = 1;
            if (!stayopen) tmt.closeNoticeIf();
        }, 
        closeNoticeIf : function() {
            if (tmt.tNotice > 4) {
                $('#softNotice').fadeOut(400);
                tmt.tNotice = -1;
            } else if (tmt.tNotice > -1) {
                tmt.tNotice++;
                setTimeout("tmt.closeNoticeIf();", 1000);
            }
        }, closeNotice : function() {
            tmt.tNotice = -1;
            $("#softNotice").fadeOut();
        }
    };
})("tmt", this);
        
//tmt.preinit();

$(document).ready(function() {
    //tmt.init();
    var href = document.location.hash;
    if (href && href.indexOf('!href=') > -1) {
        href = href.substring(href.indexOf('!href=') + '!href='.length);
        if (href != '' && href != document.location.pathname) {
            tmt.ajaxPage(href);
        }        
    }
    
    tmt.autoSize();
    tmt.initTable(document.body);
});