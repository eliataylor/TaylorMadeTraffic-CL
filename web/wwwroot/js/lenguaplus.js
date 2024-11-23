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
        init : function(holder){
          $('.langFilter').change(function(e) {
              var qname = encodeURIComponent($(this).attr('name'));
              var href = langer.upParam(qname, encodeURIComponent($(this).val()));
              document.location.href = href;
          });
          
          $('#allStatusChanger').change(function(){
              var val = $(this).val();
              if (val == '') return false;
              $('#tableBody').find("select[name='statusChange']").val(val);
          });                   
          
          $('.langBtn').click(function(e) {
              var href = langer.upParam('lang', encodeURIComponent($(this).attr('data-language')));
              document.location.href = href;
          });      
          
          $('#publishBtn').click(function(e) {
              $.ajax({
                   type: "GET",
                   url: '/lenguaplus/publish',
                   dataType: 'json'
               }).done(function(json) {
                   if (typeof json.errors != 'undefined' && json.errors.length > 0) tmt.softNotice(json.errors);
                   else if (typeof json.msg != 'undefined') tmt.softNotice(json.msg);
                   else tmt.softNotice('Unknown Response');
               });
               return false;
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
               langRow.find('textarea,input,select').each(function(){
                  var key = $(this).attr('name');
                  var value = $(this).val();
                  obj[key] = value; 
                  if ($(this).attr('data-language') && $(this).attr('data-language') != '') obj.languages.push($(this).attr('data-language'));
               });
              obj.languages = obj.languages.join(',');
               
               $.ajax({
                   type: "POST",
                   url: '/lenguaplus/update',
                   data : obj,
                   dataType: 'json'
               }).done(function(json) {
                   if (typeof json.errors != 'undefined' && json.errors.length > 0) tmt.softNotice(json.errors);
                   else if (typeof json.msg != 'undefined') tmt.softNotice(json.msg);
                   else tmt.softNotice('Unknown Response');
               });
               return false;
          });
        },
        initTable : function(holder) {
          var myHeaders = {};
          $(holder).find(".tablesorter").find('th').each(function (i, e) {
                myHeaders[$(this).index()] = { sorter: !$(this).hasClass('nosort') };
          });
          $(holder).find(".tablesorter").tablesorter({widgets: ['zebra'],headers:myHeaders});
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
    langer.init(document.body);
    langer.initTable(document.body);
});