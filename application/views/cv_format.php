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
        <meta name="viewport" content="initial-scale=1, width=device-width" />
        <? if ($me['con']['isMobile']): ?>
            <meta name="apple-mobile-web-app-capable" content="yes"  />
            <meta name="apple-mobile-web-app-status-bar-style" content="translucent" />
        <? endif; ?>      

		<link rel="stylesheet" type="text/css" href="/wwwroot/css/jquery.fancybox.css?v=2.1.5" media="screen" />        
        <link type="text/css" rel="stylesheet" href="/wwwroot/css/cubes.css?v=1467202940" /> 
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
 
 .companyHead.flexGroup {
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#cccccc+5,ffffff+33,ffffff+66,cccccc+95 */
background: rgb(204,204,204); /* Old browsers */
background: -moz-linear-gradient(-45deg, rgba(204,204,204,1) 5%, rgba(255,255,255,1) 33%, rgba(255,255,255,1) 66%, rgba(204,204,204,1) 95%); /* FF3.6-15 */
background: -webkit-linear-gradient(-45deg, rgba(204,204,204,1) 5%,rgba(255,255,255,1) 33%,rgba(255,255,255,1) 66%,rgba(204,204,204,1) 95%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(135deg, rgba(204,204,204,1) 5%,rgba(255,255,255,1) 33%,rgba(255,255,255,1) 66%,rgba(204,204,204,1) 95%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cccccc', endColorstr='#cccccc',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

-moz-border-radius:5px 5px 0 0; -webkit-border-radius:5px 5px 0 0; -o-border-radius:5px 5px 0 0; 

}
 
.flexGroup {
     display: -webkit-box;
	  display: -moz-box;
	  display: -ms-flexbox;
	  display: flex;
    flex-flow: row wrap;
    float: left;
    width:100%;
    flex-wrap:wrap;
	justify-content:center;
	align-items: center;
	align-content: center;
}
.flexItem {
	align-self:center;
	vertical-align:middle;
}
.flexItem.half {
	width:50%;
}
.flexItem.quarter {
	width:25%;
}
.flexItem.third {
	width:33%;
}

.flexItemMain {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  flex-grow:1;	
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
 	<div id="cv-format">
 	<? if (isset($uProfile) && !empty($uProfile)):?>
    <?=$this->load->view('user_profile');?>    
<?php endif; ?>
<? if (isset($cProfile) && !empty($cProfile)):?>
    <?=$this->load->view('company_profile');?>
<? endif; ?>
<section class="userExperience">
        <?php if (isset($_GET['education']) && $uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>        
        	<h3>EXPERIENCE</h3>
        <?php endif; ?>


<div class="tablesorter projects_table">
    <div id="tableBody">        
    
<? foreach ($groups as $company): ?> 
		
		<?php 
		$groupname = $company['company_tagname']; ?>
		
		<?php if (isset($showGroup) && count($company['projects']) > 0): ?>
		
			
			<?php if ($qhaving > 0 && $qhaving > count($company['projects'])) {
				continue; // dont show group
			}?>
			
			<div class="rowMargin"></div>
			<div class="flexGroup companyHead" data-group="<?=$groupname?>"  
				data-projectcount="<?=count($company['projects'])?>">
				<div class="flexItemMain flexItem col1"><h2>
					<?php if (isset($company['company_logo']) && isset($_GET['logos'])): ?>
						<img title="<?=$company['company_screenname']?>" alt="<?=$company['company_screenname']?>"  class="companyLogo" src="<?=$company['company_logo']?>" /> 				
						<span class="company_screenname"><?=$company['company_screenname'];?></span> 
					<?php else: ?>
						<?=$company['company_screenname'];?> 
					<?php endif; ?>
				</h2></div>
				<div class="flexItem col2">
						<?=fDate($company['startDate'], 'month')?>
						- 
						<?=fDate($company['endDate'], 'month')?>
				</div>
				<div class="flexItem col3">
					<span class="myrole"><?=htmlentities($company['company_myrole'])?></span>
					<?php if (isset($company['company_city'])): ?>
						<?=$company['company_city']?>
						<?php if ($company['company_telecommuting']): ?>
						(remote)
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	    <?php foreach ($company['projects'] as $row): ?>
	            <div id="pid_<?= $row->project_id ?>" data-pid="<?= $row->project_id ?>"
	            	class="projectRow"
	            	<?php if (isset($groupname)):?>data-group="<?=$groupname?>"<?php endif; ?>
	             >

	                <div class="col2 project_title" colspan="2" >
	                    <h3><a href='/projects?pid=<?= $row->project_id; ?>'><?= $row->project_title; ?></a></h3>
	                    
	                    <? if (!empty($row->project_desc)): ?><div class="prjDesc"><?= $this->lang->ugc($row->project_desc); ?></div><? endif ?>
	                    <? if (!empty($row->project_technotes)): ?><div class="technotes"><?= $this->lang->ugc($row->project_technotes); ?></div><? endif ?>
	                    
	                    <div class="projectTags">
	                        <p class="project_startdate"><span class='lineName'><?= $this->lang->en("Started") ?>:</span> <?= $row->project_startdate; ?></p>
	                        <? if (!empty($row->project_launchdate)): ?><p class="project_launchdate"><span class='lineName'><?= $this->lang->en("Launched") ?>/<?= $this->lang->en("Lasted") ?>:</span> <?= $row->project_launchdate; ?></p><? endif ?>
	                        <? if (!empty($row->project_liveurl)): ?>
	                        <p class="projectLink">                       
	                            <a href="<?= $row->project_liveurl; ?>" target="_blank"> <?= $row->project_liveurl; ?></a>
	                        </p>
	                        <? endif ?>
	                        <? if (!empty($row->project_devurl) && $row->project_devurl != $row->project_liveurl): ?>
	                        <p class="projectLink"><a href="<?= $row->project_devurl; ?>" target="_blank"> <?= $row->project_devurl; ?></a></p><? endif ?>
	                        <? if (!empty($row->project_devtools)): ?><p class="project_devtools"><span class='lineName'><?= $this->lang->en("Technologies") ?>:</span> <?= $row->project_devtools; ?></p><? endif ?>
	                        <? if (!empty($row->project_industries)): ?><p class="industries"><span class='lineName'><?= $this->lang->en("Industries") ?>:</span> <?= ucwords($row->project_industries); ?></p><? endif ?>
	                        <? if (!empty($row->project_team)): ?><p  class="team"><span class='lineName'><?= $this->lang->en("Team") ?>:</span> <?= $row->project_team; ?></p><? endif ?>
	                        <? if (!empty($row->project_companies)): ?><p class="companies"><span class='lineName'><?= $this->lang->en("Companies") ?>/<?= $this->lang->en("Brands") ?>:</span> <?= $row->project_companies; ?></p><? endif ?>
	                        <? if (!empty($row->license_id)): ?><!--<p><span class='lineName'><?= $this->lang->en("License") ?>:</span> <?= $row->license_id; ?></p>--><? endif ?>
	                    </div>
	                </div>
	            </div>
			<? endforeach; ?>
		<? endforeach; ?>
    </div>
</div>
</section>
 	
 	
 	</div>
</body>
</html>