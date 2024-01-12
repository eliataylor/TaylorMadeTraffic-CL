<div class='userProfile'>
    <div class="row userTitleRow">
        <div class="col">
            <h1 class="userName">
                <?php echo $uProfile['user_screenname'];?>
            </h1>
        </div>
        <div class="col sociallinks" style="justify-content:flex-end" >
	            <?php if (!empty($uProfile['user_fburl'])):?>
                    <a target='_blank' href='<?php echo $uProfile['user_fburl'];?>'>
	                <img src="/wwwroot/images/fbIcon.png" title="<?php echo $uProfile['user_fburl'];?>" />
	                </a>
                <?php endif?>
        <?php if (!empty($uProfile['user_googleurl'])):?><li><a target='_blank' href='<?php echo $uProfile['user_googleurl'];?>'><?php echo $uProfile['user_googleurl'];?></a></li><?php endif?>

        <?php if ($uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>

            <a target='_blank' href='https://github.com/eliataylor'>
                <img width="40" title="Github" src="/wwwroot/images/github-sq-blackbg.png" />
            </a>
            <a target='_blank' href='https://www.upwork.com/fl/~01979dd82b228abbb5'>
		                <img width="40" title="Upwork" src="/wwwroot/images/upwork.svg" />
	                </a>
        <?php endif; ?>


        <?php if (!empty($uProfile['user_linkdinurl'])):?>
            <a target='_blank' href='<?php echo $uProfile['user_linkdinurl'];?>'>
	                <img width="40" title="<?php echo $uProfile['user_linkdinurl'];?>" src="/wwwroot/images/linkedin-icon.svg" />
	                </a>
        <?php endif?>
        </div>
    </div>

        <?php if (!empty($uProfile['user_bio'])):?>
        <div class='userBio'>
            <?php echo $this->lang->ugc($uProfile['user_bio']);?>
        </div>
        <?php if (isset($_GET['summary']) && $uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>
        <section class="userSummary">
            <p>
                Eli has over 20 years of experience throughout the stacks and life cycles of software development.
                Lately Eli has specialized in training computer vision models with custom data sets and annotations.
                In his spare time, Eli spends time with his wife and son, and stays active on surfboards, soccer fields, and basketball courts near you.

                <!--
                Eli has over 20 years of experience in throughout the stack of software development, building systems of all sizes and needs.
                As an entrepreneur by nature, Eli measures success by finding the perfect balance between scalability, time, and budget.
                As an artist at heart, Eli's approach to programming is led by a passion for implementing beautiful designed systems and interfaces.
                In his spare time, Eli spends time with his wife and son, and teaches youth courses on the software development life cycle for the Hidden Genius Project.
                -->
            </p>


        </section>
        <?php endif; ?>
        <?php if (isset($_GET['education']) && $uProfile['user_email'] == 'eli@taylormadetraffic.com'): ?>
        <section class="userEducation">
			<h3>EDUCATION</h3>

			<h4>San Francisco State University. San Francisco, CA
				<span>2002 - 2005</span>
			</h4>
			<ul>
				<li>June 2005: Bachelor of Arts, Industrial Design. Dean's List</li>
			</ul>

			<h4>Howard University. Washington D.C.
				<span>2000 - 2002</span>
			</h4>
			<ul>
				<li>Legacy Scholarship Recipient (academic merit scholarship)</li>
				<li>Vice President, American Institute of Aeronautics and Astronautics (AIAA), Washington, D.C. Chapter</li>
			</ul>

			<h4>Postbaccalaureate Studies at SFSU, CCSF, CSULA, &amp; Golden Gate University:
				<span>2005 - 2008</span>
			</h4>
			<ul>
				<li>Various elective courses in mySQL, Android, Java, Lunix / Virtualization, IP Law, &amp; the SDLC</li>
			</ul>
        </section>
        <?php endif; ?>
        <?php endif?>
    </div>
