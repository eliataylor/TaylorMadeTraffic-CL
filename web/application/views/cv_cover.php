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
            Over the past 20 years, I've mastered the frontend and backend of several stacks, while both leading and assisting teams
            through all life cycles of software development, from planning to deployment.
        </p>
        <p>
            This resume highlights the projects most relevant to your job description and is listed by date rather than company.
            By the nature of freelance contracting, my work with clients has spanned many years with gaps in between sprints.
        </p>
        <p>
            Cypher and Flexible Assembly Systems have been my most consistent clients over the past 7 years. Their
            recommendations on my LinkedIn attest to my work ethic and customer satisfaction. As for code quality, I
            approach every project with the best practices of test-driven development, while pen-testing my servers and
            interfaces for security and performance under high traffic.</p>
        <p>
            In parallel, I invested time in myself through open source and proprietary ventures that have significantly enriched my professional skill set. This work has not only fueled my personal growth but also directly contributed to the innovative solutions I’ve implemented for my clients.
        </p>
        <p>
            For screenshots, videos, links and team members on each project visit my <strong>online portfolio: <a href="https://taylormadetraffic.com" target="_blank">taylormadetraffic.com</a></strong>
        </p>
    </section>

    <div class="col"></div>


    <footer class="letterhead" >
    </footer>

</div>
<div class="pageBreak"></div>
