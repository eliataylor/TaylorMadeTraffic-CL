(function(wrap, cont) {   
    cont[wrap] = { 
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
        init : function(){
          $('.langFilter').change(function(e) {
              var qname = encodeURIComponent($(this).attr('name'));
              var href = langer.upParam(qname, encodeURIComponent($(this).val()));
              document.location.href = href;
          });
          
          $('.langBtn').click(function(e) {
              var href = langer.upParam('lang', encodeURIComponent($(this).attr('data-language')));
              document.location.href = href;
          });          
          
          $('.updateLang').click(function(e) {
               e.preventDefault();
               var langRow = $(this).parents('tr:first');
               var obj = {
                   'groupby[]':$('#groupbySel').val(),
                   'status':$('#statusSel').val(),
                   'type':$('#typeSel').val(),
                   'id':langRow.attr('data-langid'),
                   'languages':[]
               };
               langRow.find('textarea,input').each(function(){
                  var key = $(this).attr('name');
                  var value = $(this).val();
                  obj[key] = value; 
                  obj.languages.push($(this).attr('data-language'));
               });
              obj.languages = obj.languages.join(',');
               
               $.ajax({
                   type: "POST",
                   url: 'lenguaplus/update',
                   data : obj,
                   dataType: 'json'
               }).done(function(json) {
                   tmt.softNotice(json.msg);
               });
               return false;
          });
        },
        initTable : function(cont) {
            $(cont).find(".tablesorter").tablesorter({widgets: ['zebra']});
           //{sortList: [[0,0], [1,0]]} 
        },         
        qParam : function(name, url) {
            name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
            var regexS = "[\\?&]" + name + "=([^&#]*)";
            var regex = new RegExp(regexS);
            var results = null;
            if (url) results = regex.exec(url);
            else if (window.location.hash && window.location.hash.length > 1) {
                results = regex.exec(window.location.hash);
            } else results = regex.exec(window.location.search);
            if(results == null) return false;
            else return decodeURIComponent(results[1].replace(/\+/g, " "));
        }, 
        upParam : function(param, val, href) {
            if (!href) {
                if (document.location.hash && document.location.hash.indexOf("#!href=") > -1) { // take of hash if exits
                    var hash = document.location.hash;
                    href = hash.substring(hash.indexOf("#!href=") + "#!href=".length); // assumes last hash parameter
                } else {
                    href = document.location.pathname + document.location.search;
                }
            }
            var style = cont[wrap].qParam(param, href);
            if (style && style != "") {
                href = href.replace("=" + style, "=" + val); // with =, 'list' replaces playlists=                
            } else if (href.indexOf("?") > -1) {
                href += "&" + param + "=" + val;
            } else {
                href += "?" + param + "=" + val;
            }
            return href;
        }
    };
})("langer", this);

$(document).ready(function() {
    langer.initTable(document.body);
    langer.init(document.body);
});