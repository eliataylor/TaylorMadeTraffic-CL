<style type="text/css">
    .page, .pageTitle, .pageBlock { float:left; clear:both; width:100%; }
    .page { height:500px; margin:20px; }
    iframe {  height:500px; border:1px solid #fff; }
    .page a, .page a:visited { color:#ED2024 }
    .page {  float:right; clear:none; margin:40px 0; width:100%;  } 
    .pageTitle { margin:-30px 0 0 0; clear:both; position: relative; }
    .pageBlock { text-align: justify; height:100%; clear:both; position: relative; overflow-y:auto; margin:0 10px 0 10px; }
    .postDate { float: right; font-size: 16px; vertical-align: bottom; color: red; }

</style>
<div class="page">
    <h2 class="pageTitle">Mobile</h2>
    <div class="pageBlock">
        <iframe width="320" height="444" src="/<?php echo $this->uri->segment(2)?>?device=phone" seamless="seamless" ></iframe>
    </div>   
</div>

<div class="page">
    <h2 class="pageTitle">tablet</h2>
    <div class="pageBlock">
        <iframe width="768" height="928"  src="/<?php echo $this->uri->segment(2)?>?device=tablet" seamless="seamless" ></iframe>
    </div>   
</div>


<div class="clearer"></div>

<div class="page">
    <h2 class="pageTitle">Fullscreen</h2>
    <div class="pageBlock">
        <iframe width="1000" src="/<?php echo $this->uri->segment(2)?>" seamless="seamless" ></iframe>
    </div>   
</div>