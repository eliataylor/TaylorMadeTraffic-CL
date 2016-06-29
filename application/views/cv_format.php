<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" lang="<?=$me['con']['lang']?>">
    <head>
        <?php if (!isset($docTitle)) $docTitle = $this->uri->segment(1);
              if (empty($docTitle) || strlen($docTitle) < 2) $docTitle = $qtags; 
              else $docTitle = ucfirst(trim($docTitle)); ?>
        <title><?= $docTitle ?> :: TaylorMadeTraffic.com</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="author" content="Eli A Taylor" />
        <meta name="language" content="en" />
		<link rel="stylesheet" type="text/css" href="/wwwroot/css/jquery.fancybox.css?v=2.1.5" media="screen" />        
        <meta name="viewport" content="initial-scale=1, width=device-width" />
        <? if ($me['con']['isMobile']): ?>
            <meta name="apple-mobile-web-app-capable" content="yes"  />
            <meta name="apple-mobile-web-app-status-bar-style" content="translucent" />
        <? endif; ?>      
<style type="text/css">


dl.detailList { padding: 0; margin:4px 0 0 0}
.detailList dt {
    float: left;
    clear: left;
    margin:0;
    font-size:80%;
    vertical-align:middle;
  }
.detailList dd {
    margin:0 0 8px 128px;
    padding: 0;
    vertical-align:middle;
 }
   
</style>          
        <link rel="shortcut icon" href="/wwwroot/images/favicon.ico" />
        <? if (ENVIRONMENT == 'production'):?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-7929826-3', 'auto');
            ga('set', '&uid', '<?=$me['session_id']?>'); 
            //ga('require', 'linkid', 'linkid.js');
            ga('send', 'pageview');

          </script>
        <?endif;?>        
    </head>
    <body id="trackauthority" class="<?=$me['con']['pstyle'];?>" >
    	<h1>Eli A Taylor</h1>
    	<dl class="detailList" style="margin-bottom:20px;">	
	    	<dt>Cell</dt>
	    	<dd>+1 808-855-5665</dd>
	
	    	<dt>Voicemail</dt>
	    	<dd>+1 415-300-0834</dd>
	
	    	<dt>E-mail</dt>
	    	<dd>eli@taylormadetraffic.com</dd>
	
	    	<dt>Skype</dt>
	    	<dd>skye_eli</dd>
	    	
	    	<dt>Google Hangouts</dt>
	    	<dd>eliabrahamtaylor</dd>
    	</dl>
    	
<?php if (!isset($groups)) $groups = array('all'=>$tableRows); 
	else $showGroup = true;
?>
    
<? foreach ($groups as $groupname=>$tableRows): ?>     
		<?php if (isset($showGroup)): ?>
			<h2>&raquo; <?=$groupname;?></h2>
			<div class="groupBlock" style="margin-left:20px;">
		<?php endif; ?>

<? foreach ($tableRows as $row): ?>     
	    <div style="border-top: 1px solid black; margin:0 0 20px 0;">
        <h3><a href='/projects?pid=<?= $row->project_id; ?>'><?= $row->project_title; ?></a></h3>

		<?php if (!isset($_GET['bizinterest'])):?>
	            <p class="prjDesc"><?= $row->project_desc; ?></p>
        <? endif ?>
    
		<?php if (isset($_GET['bizinterest'])):?>
	        <? if (!empty($row->project_pitch)): ?><div class="prjSection prjPitch">
	            <?= $this->lang->ugc($row->project_pitch); ?></div>
	        <? elseif (!empty($row->project_desc)): ?>
	            <p class="prjDesc"><?= $row->project_desc; ?></p>
	        <? endif ?>
	
	        <? if (!empty($row->project_bizmodel)): ?>
	            <div class="prjSection prjBiz">
	                <h4 class="sectTitle"><?=$this->lang->en('Business Model')?></h4>
	                <?= $this->lang->ugc($row->project_bizmodel); ?>
	            </div>
	        <? endif ?>
		
	        <? if (!empty($row->project_competition)): ?>
	            <div class="prjSection prjCompetition">
	                <h4 class="sectTitle"><?=$this->lang->en('Competition')?></h4>
	                <?= $this->lang->ugc($row->project_competition); ?>
	            </div>
	        <? endif ?>                    
	
	        <? if (!empty($row->project_marketresearch)): ?>
	            <div class="prjSection prjResearch">
	                <h4 class="sectTitle"><?=$this->lang->en('Target Markets')?> / <?=$this->lang->en('Research')?></h4>
	                <?= $this->lang->ugc($row->project_marketresearch); ?>
	            </div>
	        <? endif ?>                    

	        <? if (!empty($row->project_expenses)): ?>
	            <div class="prjSection prjCosts">
	                <h4 class="sectTitle"><?=$this->lang->en('Costs by Department')?></h4>
	                <?= $this->lang->ugc($row->project_expenses); ?>
	            </div>
	        <? endif ?>
		<?php endif; ?>
		
        <? if (!empty($row->project_futuredate)): ?>
            <div class="prjSection prjDates">
                <h4 class="sectTitle"><?=$this->lang->en('Roadmap')?></h4>
                <?= $this->lang->ugc($row->project_futuredate); ?>
            </div>
        <? endif ?>    

        
        <? if (!empty($row->project_technotes)): ?>            
            <div class="technotes">
                <h4 class="sectTitle"><?=$this->lang->en('Technical Notes')?></h4>
                <?= $row->project_technotes; ?>
            </div>
        <? endif ?>
            
    
        <p>
            <span class='lineName'><?= $this->lang->en("Started") ?>:</span> <?= $row->project_startdate; ?>
            <? if (!empty($row->project_launchdate)): ?>. <span class='lineName'><?= $this->lang->en("Launched/Lasted:") ?>:</span> <?= $row->project_launchdate; ?><? endif ?>
        </p>
        <? if (!empty($row->project_liveurl) || !empty($row->project_devurl)): ?>
            <p  class="projectLink">        
            <? if (!empty($row->project_liveurl) || !empty($row->project_devurl)): ?>
                <span class='lineName'><?= $this->lang->en("Live") ?>:</span>                        
                <a href="<?= $row->project_liveurl; ?>" target="_blank"> <?= $row->project_liveurl; ?></a>
            <? endif ?>
            <? if (!empty($row->project_devurl)): ?>
                <span class='lineName'><?= $this->lang->en("Dev") ?>:</span>
                <a href="<?= $row->project_devurl; ?>" target="_blank"> <?= $row->project_devurl; ?></a>
            <? endif ?>
            </p>
        <? endif ?>
    <? if (!empty($row->project_devtools)): ?><p><span class='lineName'><?= $this->lang->en("Technologies") ?>:</span> <?= $row->project_devtools; ?></p><? endif ?>
    <? if (!empty($row->project_industries)): ?><p><span class='lineName'><?= $this->lang->en("Industries") ?>:</span> <?= ucwords($row->project_industries); ?></p><? endif ?>
    <? if(isset($_GET['team'])):?>
        <? if (!empty($row->project_team)): ?><p><span class='lineName'><?= $this->lang->en("Team") ?>:</span> <?= $row->project_team; ?></p><? endif ?>
    <?endif;?>
    <? if (!empty($row->project_companies)): ?><p><span class='lineName'><?= $this->lang->en("Companies/Brands:") ?>:</span> <?= $row->project_companies; ?></p><? endif ?>
    </div>
<? endforeach; ?>
		<?php if (isset($showGroup)): ?>
			</div>
		<?php endif; ?>

<? endforeach; ?>
</body>
</html>