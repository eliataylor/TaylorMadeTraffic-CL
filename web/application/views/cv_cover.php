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
            This resume highlights the projects that most fit your job description.
            Each project offers a brief summary of relevant work.
            In the interested of brevity,
            Those projects are grouped by company headers and
            Because of that, the timeline show gaps or spans that overlap.
            Over all these years, I've worked complete
        </p>
        <p>
            Through those years, Cypher and Flexible Assembly Systems have remained my most consistent clients. Their
            recommendations on my LinkedIn attest to my work ethic and customer satisfaction. As for code quality, I
            approach every project with the best practices of test-driven development, while pen-testing my servers and
            interfaces for security and performance under high traffic.</p>
        <p>
            In parallel, I have dedicated time to building proprietary and passion projects - PickupMVP, Track Authority, and Objects/Actions - that have significantly enriched my professional skill set. These projects have allowed me to explore cutting-edge technologies like TensorFlow for computer vision and OpenAI for LLM driven applications. This work has not only fueled my personal growth but also directly contributed to the innovative solutions I’ve implemented for my clients. By staying at the forefront of emerging tech trends, I ensure my work is both forward-thinking and impactful.
        </p>
        <p>
            Feel free to ask for references, documentation or demos on any of my work listed below or throughout my <strong>online portfolio: <a href="https://taylormadetraffic.com/eli" target="_blank">taylormadetraffic.com/eli</a></strong>
        </p>
        <p>
            Now that our son is 4, we've decided to settle back home to the Bay Area to be near family and put him into
            a better school. In turn, it seems like now a good time to explore opportunities like yours.
        </p>
    </section>

    <div class="col"></div>


    <footer class="letterhead" >
    </footer>

</div>
<div class="pageBreak"></div>
