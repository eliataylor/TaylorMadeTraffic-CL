<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" lang="<?php echo $me['con']['lang']?>">
    <head>
        <?php if (!isset($docTitle)) $docTitle = $this->uri->segment(1);
              if (empty($docTitle) || strlen($docTitle) < 2) $docTitle = $qtags; 
              else $docTitle = ucfirst(trim($docTitle)); ?>
        <title><?php echo  $docTitle ?> :: TaylorMadeTraffic.com</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="author" content="Eli A Taylor" />
        <meta name="language" content="en" />
        <meta name="viewport" content="initial-scale=1, width=device-width" />
        <?php if ($me['con']['isMobile']): ?>
            <meta name="apple-mobile-web-app-capable" content="yes"  />
            <meta name="apple-mobile-web-app-status-bar-style" content="translucent" />
        <?php endif; ?>      

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
        <?php if (ENVIRONMENT == 'production'):?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-7929826-3', 'auto');
            ga('set', '&uid', '<?php echo $me['session_id']?>'); 
            //ga('require', 'linkid', 'linkid.js');
            ga('send', 'pageview');

          </script>
        <?php endif;?>        
    </head>
    <body id="trackauthority" class="<?php echo $me['con']['pstyle'];?>" >
 	<div id="cv-format">
 	<?php if (isset($uProfile) && !empty($uProfile)):?>
    <?php echo $this->load->view('user_profile');?>    
<?php endif; ?>
<?php if (isset($cProfile) && !empty($cProfile)):?>
    <?php echo $this->load->view('company_profile');?>
<?php endif; ?>
<section class="userExperience">
        <?php if (isset($_GET['education']) && $uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>        
        	<h3>EXPERIENCE</h3>
        <?php endif; ?>


<div class="tablesorter projects_table">
    <div id="tableBody">        
    
<?php foreach ($groups as $company): ?> 
		
		<?php 
		$groupname = $company['company_tagname']; ?>
		
		<?php if (isset($showGroup) && count($company['projects']) > 0): ?>
		
			
			<?php if ($qhaving > 0 && $qhaving > count($company['projects'])) {
				continue; // dont show group
			}?>
			
			<div class="rowMargin"></div>
			<div class="flexGroup companyHead" data-group="<?php echo $groupname?>"  
				data-projectcount="<?php echo count($company['projects'])?>">
				<div class="flexItemMain flexItem col1"><h2>
					<?php if (isset($company['company_logo']) && isset($_GET['logos'])): ?>
						<img title="<?php echo $company['company_screenname']?>" alt="<?php echo $company['company_screenname']?>"  class="companyLogo" src="<?php echo $company['company_logo']?>" /> 				
						<span class="company_screenname"><?php echo $company['company_screenname'];?></span> 
					<?php else: ?>
						<?php echo $company['company_screenname'];?> 
					<?php endif; ?>
				</h2></div>
				<div class="flexItem col2">
						<?php echo fDate($company['startDate'], 'month')?>
						- 
						<?php echo fDate($company['endDate'], 'month')?>
				</div>
				<div class="flexItem col3">
					<span class="myrole"><?php echo htmlentities($company['company_myrole'])?></span>
					<?php if (isset($company['company_city'])): ?>
						<?php echo $company['company_city']?>
						<?php if ($company['company_telecommuting']): ?>
						(remote)
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	    <?php foreach ($company['projects'] as $row): ?>
	            <div id="pid_<?php echo  $row->project_id ?>" data-pid="<?php echo  $row->project_id ?>"
	            	class="projectRow"
	            	<?php if (isset($groupname)):?>data-group="<?php echo $groupname?>"<?php endif; ?>
	             >

	                <div class="col2 project_title" colspan="2" >
	                    <h3><a href='/projects?pid=<?php echo  $row->project_id; ?>'><?php echo  $row->project_title; ?></a></h3>
	                    
	                    <?php if (!empty($row->project_desc)): ?><div class="prjDesc"><?php echo  $this->lang->ugc($row->project_desc); ?></div><?php endif ?>
	                    <?php if (!empty($row->project_technotes)): ?><div class="technotes"><?php echo  $this->lang->ugc($row->project_technotes); ?></div><?php endif ?>
	                    
	                    <div class="projectTags">
	                        <p class="project_startdate"><span class='lineName'><?php echo  $this->lang->en("Started") ?>:</span> <?php echo  $row->project_startdate; ?></p>
	                        <?php if (!empty($row->project_launchdate)): ?><p class="project_launchdate"><span class='lineName'><?php echo  $this->lang->en("Launched") ?>/<?php echo  $this->lang->en("Lasted") ?>:</span> <?php echo  $row->project_launchdate; ?></p><?php endif ?>
	                        <?php if (!empty($row->project_liveurl)): ?>
	                        <p class="projectLink">                       
	                            <a href="<?php echo  $row->project_liveurl; ?>" target="_blank"> <?php echo  $row->project_liveurl; ?></a>
	                        </p>
	                        <?php endif ?>
	                        <?php if (!empty($row->project_devurl) && $row->project_devurl != $row->project_liveurl): ?>
	                        <p class="projectLink"><a href="<?php echo  $row->project_devurl; ?>" target="_blank"> <?php echo  $row->project_devurl; ?></a></p><?php endif ?>
	                        <?php if (!empty($row->project_devtools)): ?><p class="project_devtools"><span class='lineName'><?php echo  $this->lang->en("Technologies") ?>:</span> <?php echo  $row->project_devtools; ?></p><?php endif ?>
	                        <?php if (!empty($row->project_industries)): ?><p class="industries"><span class='lineName'><?php echo  $this->lang->en("Industries") ?>:</span> <?php echo  ucwords($row->project_industries); ?></p><?php endif ?>
	                        <?php if (!empty($row->project_team)): ?><p  class="team"><span class='lineName'><?php echo  $this->lang->en("Team") ?>:</span> <?php echo  $row->project_team; ?></p><?php endif ?>
	                        <?php if (!empty($row->project_companies)): ?><p class="companies"><span class='lineName'><?php echo  $this->lang->en("Companies") ?>/<?php echo  $this->lang->en("Brands") ?>:</span> <?php echo  $row->project_companies; ?></p><?php endif ?>
	                        <?php if (!empty($row->license_id)): ?><!--<p><span class='lineName'><?php echo  $this->lang->en("License") ?>:</span> <?php echo  $row->license_id; ?></p>--><?php endif ?>
	                    </div>
	                </div>
	            </div>
			<?php endforeach; ?>
		<?php endforeach; ?>
    </div>
</div>
</section>
 	
 	
 	</div>
</body>
</html>