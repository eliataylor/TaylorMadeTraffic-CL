<div class="col cv_cover">
    <div>
    <?php if (isset($uProfile) && !empty($uProfile)): ?>
        <?php $this->load->view('user_header'); ?>
    <?php endif; ?>
    <div class="letterhead" style="height: 4px;margin-top: 4px;">
        <?php $this->load->view('letterhead', ['variant' => 'footer', "style" => "opacity:.7;"]); ?>
    </div>
    </div>

    <section style="font-size: 100%; line-height: 22px; margin:0 auto 0 auto; text-align: justify">
        <p style="font-weight: 800">
            Over the past 20 years, I've mastered the frontend and backend of several stacks, while leading and assisting
            through all life cycles of software development, from planning to deployment.
        </p>
        <p>
            This resume begins in 2017 when I married a talented Graphic Designer and we launched a joint design and
            development firm. We've spent the past 7 years wearing many hats, while traveling the world and starting a
            family.
        </p>
        <p>
            Through those years, Cypher and Flexible Assembly Systems have remained my consistent clients. Their
            recommendations on my LinkedIn attest to my work ethic and customer satisfaction. As for code quality, I
            approach every project with the best practices of test-driven development, while pen-testing my servers and
            interfaces for security and performance under high traffic. My more recent project - PickupMVP - has been a
            successful soft launch validating the viability of my architecture and our UX for crowd sourcing pickup
            games with real rewards and AI assisted highlight reels.
        </p>
        <p>
            Feel free to ask for profiles, references, documentation or demos on any of my work listed below or throughout my <strong>online portfolio: <a href="https://taylormadetraffic.com/eli" target="_blank">taylormadetraffic.com/eli</a></strong>
        </p>
        <p>
            Now that our son is 4, we've decided to move back home to the Bay Area to be near family and put him into
            a better school. In turn, it seems like now a good time to explore opportunities like yours.
        </p>
    </section>

    <div class="col"></div>

    <footer class="letterhead" >
        <?php $devtools = ['Full Stack', 'Machine Learning', 'Quality Assurance', 'Testing', 'Automation', 'Architecture']; ?>
        <div class="chip-container" >
            <?php foreach ($devtools as $tool): ?>
                <div class="chip"><?php echo $tool; ?></div>
            <?php endforeach; ?>
        </div>

        <?php $this->load->view('letterhead', ['variant' => 'footer', "style" => "opacity:1;"]); ?>
    </footer>

</div>
<div class="pageBreak"></div>
