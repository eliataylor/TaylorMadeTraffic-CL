<div class='userProfile'>
        <h1 class="userName">
        <?=$uProfile['user_screenname'];?>    
        <span class='sociallinks'>
            <? if (!empty($uProfile['user_fburl'])):?>
                <a target='_blank' href='<?=$uProfile['user_fburl'];?>'>
                <img src="/wwwroot/images/fbIcon.png" title="<?=$uProfile['user_fburl'];?>" />
                </a>
            <? endif?>
            <? if (!empty($uProfile['user_linkdinurl'])):?>
                <a target='_blank' href='<?=$uProfile['user_linkdinurl'];?>'>
                <img title="<?=$uProfile['user_linkdinurl'];?>" src="/wwwroot/images/linkedinIcon.png" />
                </a>
            <? endif?>
            <? if (!empty($uProfile['user_googleurl'])):?><li><a target='_blank' href='<?=$uProfile['user_googleurl'];?>'><?=$uProfile['user_googleurl'];?></a></li><? endif?>
            
           <?php if ($uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>
                <a target='_blank' href='http://www.upwork.com/o/profiles/users/_~01979dd82b228abbb5/'>
	                <img title="Upwork" src="/wwwroot/images/upwork_68416.png" />
                </a>
                <a target='_blank' href='http://stackoverflow.com/users/624160/e-a-t'>
	                <img title="StackOverflow" src="/wwwroot/images/stackoverflow-icon.png" />
                </a>                                
                <a target='_blank' href='https://github.com/eliataylor'>
	                <img title="Github" src="/wwwroot/images/github-icon.png" />
                </a>
                <a target='_blank' href='http://drupal.stackexchange.com/users/27059/e-a-t'>
	                <img title="StackExchange" src="/wwwroot/images/stackexchange-icon.png" />
                </a>
           <?php endif; ?> 
        </span>
        </h1>
        
        <? if (!empty($uProfile['user_bio'])):?>
        <div class='userBio'>
            <?=$this->lang->ugc($uProfile['user_bio']);?>
        </div>
        <?php if (isset($_GET['education']) && $uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>        
        <div class="userEducation">
			<!-- <h3>EDUCATION</h3> -->
			<h4>San Francisco State University, San Francisco, CA</h4>
				<div>June 2007: Bachelor of Arts, Industrial Design. Dean's List</div>
			<h4>Howard University. Washington D.C.</h4> 
				<div>Legacy Scholarship Recipient (academic merit scholarship)</div>
				<div>Vice President, American Institute of Aeronautics and Astronautics (AIAA), Washington, D.C. Chapter</div>
			<h4>Postbaccalaureate. SFSU Extension / CCSF / Goldate Gate University: <span>2005 - 2008</span></h4>
				<div>Advanced courses in mySQL, Android, Java, Lunix / Virtualization, IP Law, &amp; the SDLC</div>
        </div>
        <?php endif; ?>
        <? endif?>
    </div>