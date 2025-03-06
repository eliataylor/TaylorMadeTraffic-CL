use localdb;
set sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"


select project_id, project_title, project_technotes, project_tech_short, project_devtools from projects order by project_id desc;
desc projects;

-- UPDATE `projects` SET `project_team` = '<a href=\"/team?qtfilter=E.A.Taylor\">E.A.Taylor</a>: Front-End, Back-End.\r\n<a href=\"/team?qtfilter=David Hilliard\">David Hilliard</a>: Brand Development.\r\n<a href=\"/team?qtfilter=Justin Herman\">Justin Herman</a>: Flash Movie Animation.' WHERE `projects`.`project_id` = 23

insert into projects (project_status, project_type, project_startdate,
                      project_startyear, project_title, project_subtitle,
                      project_devurl,  project_client, project_devtools,
                      project_industries, project_companies, project_team, project_technotes,
                      project_desc)
values ('current', 'development', '2023-01-01', '2023', 'Flora',
        'Build your own bath box concept',
        'https://flora.taylormadetraffic.com',
        'Ruhral', 'Drupal, NextJS, NodeJS', 'Health, Wellness, Manufacturing, Lifestyle', 'Ruhral',
        '<a href=\'/team?qtfilter=Samanta Khalil Taylor\'>Samanta Khalil Taylor</a>: Graphic / UX Design & Product Development. <a href=\'/team?qtfilter=E.A.Taylor\'>E.A.Taylor</a>: Die Layouts and logistics.',
        '<ul><li>Build your own box experience for bathboxes</li></ul>',
        '');


insert into projects (project_status, project_type, project_startdate,
                      project_startyear, project_title, project_subtitle,
                      project_devurl,  project_client, project_companies, project_devtools,
                      project_industries, project_team, project_technotes,
                      project_desc)
values ('current', 'development', '2023-01-01', '2023', 'Electrek',
        'Canvassing tool for dispatching and tracking in-person canvass and survey collections.',
        'https://fieldworks.com',
        'FieldWorks', 'FieldWorks', 'Python, Django, React Native, ElasticBeanstalk', 'Analytics, Language, Marketing',
        '<a href=\'/team?qtfilter=Alex Gibson\'>Alex Gibson</a>: CTO. <a href=\'/team?qtfilter=E.A.Taylor\'>E.A.Taylor</a>: Android & iOS Mobile Applications',
        '<ul><li>Revived project and relaunch</li></ul>',
        '');


# Object/Actions:
insert into projects (project_status, project_type, project_startdate,
                      project_startyear, project_title, project_subtitle, project_desc,
                      project_devurl,  project_client, project_companies, project_devtools,
                      project_industries, project_team, project_technotes)
values ('tagged', 'development', '2024-03-02', '2024',
        'Object/Actions',
        'An open source scaffolding tool from spreadsheet to full stack',
         'a tool for helping entrepreneurs document their projects, and scaffold their systems.',
        'https://github.com/eliataylor/object-actions',
        'Taylor Made Traffic', 'Taylor Made Traffic', 'Python, Django, TypeScript, ReactJS, Material-UI, NodeJS, Cypress.io, Google Cloud Platform', 'Technology',
        '<a href=\'/team?qtfilter=E.A.Taylor\'>E.A.Taylor</a>: Developer',
        '<ul>
<li>Wrote CLI tool to parse Object/Actions spreadsheets to generate a Django DRF models, views, urls, serializers, swagger docs and more.</li>
<li>Wrote CLI tool to also generate strict TypeScript of all interfaces and types to define models and API response types</li>
<li>Built extendable ReactJS web app reusuable as basic CMS for all content types</li>
<li>Wrote NodeJS fake world build to generate infinite rows of realistic data following field types using `faker` library</li>
<li>Wrote Cypress.io test suite to automate end-to-end testing on all CRUD operations against API</li>
</ul>');

# prompt automator:

insert into projects (project_status, project_type,
                      project_startdate, project_launchdate,
                      project_startyear, project_launchyear, project_title, project_subtitle, project_desc,
                      project_devurl, project_liveurl, project_client, project_companies, project_devtools,
                      project_industries, project_team, project_technotes)
values ('tagged', 'development', '2024-05-02', '2024-06-02',
        '2024','2024',
        'Prompt Automator',
        'A tool to automate testing and comparing ChatGPT responses based on variations in prompts and configurations',
        'a tool for helping entrepreneurs document their projects, and scaffold their systems.',
        'https://github.com/eliataylor/promptautomator',
         'https://promptautomator.taylormadetraffic.com',
        'Presideo Creative', 'Taylor Made Traffic', 'Python, TypeScript, ReactJS, Material-UI', 'Technology',
        '<a href=\'/team?qtfilter=E.A.Taylor\'>E.A.Taylor</a>: Developer',
        '<ul>
<li>Wrote tool to test performance of different OpenAI use cases allowing speed comparisons between Embeddings, Completions, and Assistants each with different prompt structures</li>
<li>Wrote front end visualization table to filter and compare results</li>
</ul>');


select project_client, project_companies from projects;

# /saman
SELECT min(I.image_weight), count(P.project_id) as count,
# P.*, T.*, I.*
P.project_id, project_status, project_type, project_startdate,
       project_startyear, project_title, project_subtitle,
       project_devurl,  project_client, project_companies, project_devtools,
       project_industries, project_team, project_technotes,
       project_desc

FROM `projects` P
         LEFT JOIN tags T on P.project_id = T.project_id
         LEFT JOIN images I on P.project_id = I.project_id

WHERE project_status != 'deleted'  AND  T.tag_type LIKE 'team_%'
  AND  T.tag_key = 'Sammie Khalil Taylor'
group by P.project_id
order by P.project_launchdate desc, P.project_startdate desc ;


SELECT project_id, count(tag_id) as count, tag_key, tag_type, MAX(tag_date) as tag_date FROM `tags`
WHERE  tag_type = 'technologies'
group by tag_key, project_id  order by project_id, tag_key asc ;


select * from tags where tag_key like 'General Public License (GNU)' order by project_id;
update tags set tag_key = 'Federal Laboratory Consortium' where tag_key like 'Federal%';
update projects set project_technotes = replace(project_technotes, 'Sammie Khalil Taylor', 'Samanta Amna Khalil');

select project_id, project_title, project_technotes, project_devtools, project_team, project_companies from projects where projects.project_companies like '%Track%' order by project_id;
update projects set project_companies = replace(project_companies, 'Federal Laboratory Consortium', 'Federal Labs Consortium');


update projects set project_launchdate = project_startdate where project_launchdate is NULL and project_startdate is not null;

select project_id, project_technotes from projects where project_companies like '%Flexible%';

select * from images
where project_id = 3
order by project_id, image_weight;

select * from tags where tag_key like '%CSS3%' order by tag_date desc;
select project_id, project_title, project_devtools from projects where project_devtools like '%Node-Red%' order by project_startdate desc;

select * from tags where project_id = 49;


select project_id, project_title, project_startdate, project_launchdate from projects where projects.project_type = 'development' order by project_title, project_id desc;

select project_id, project_title, project_startdate, project_launchdate from projects where projects.project_type = 'development' order by project_startdate desc;∂

select project_id, project_status, project_title, project_technotes, project_devtools from projects where projects.project_type = 'development' order by project_id desc;

select project_id, project_title, project_desc, project_subtitle, project_technotes, project_tech_short from projects order by project_id desc;

select project_id, project_title, project_desc, project_subtitle, project_technotes from projects where project_subtitle  like '%timelineNote%' order by project_id desc;

select project_id, project_technotes, project_desc, project_devtools, project_startdate, project_launchdate from projects where project_title like '%Refined%';

select project_id, project_title, project_technotes, project_launchdate from projects order by projects.project_launchdate is null desc, project_launchdate desc;


select project_id, image_id, image_src, image_weight from images where project_id = 53 order by image_weight;

select * from tags where tag_key = 'Neha Kotecha';

update tags set tag_type = replace(tag_type, '.', '') where tag_type like '%.';
<a href="/team?qtfilter=E.A.Taylor">E.A.Taylor</a>: Front-End, Back-End. <a href="/team?qtfilter=Aaron Silverberg">Aaron Silverberg</a>: Vice President. <a href="/team?qtfilter=Saiman Shetty">Saiman Shetty</a>: Project Management


select project_id, project_title, project_technotes, project_tech_short from projects where project_status = 'current' order by project_id desc;

select project_id, project_title, project_devtools, project_technotes, project_tech_short from projects
where project_status = 'current' order by project_id desc;

select project_id, project_title, project_technotes, project_devtools from projects
where project_title like '%Pickup%' order by project_id desc;


INSERT INTO tags (project_id, tag_type, tag_key, tag_date, tag_singular, tag_plural, tag_language)
SELECT 68, tag_type, tag_key, tag_date, tag_singular, tag_plural, tag_language FROM tags
WHERE project_id = 57;


select * from tags where tag_key = '2025';

INSERT INTO tags (project_id, tag_type, tag_key, tag_date)
values (49, 'years', '2025', '2025-01-01');


SELECT P.*, I.*, min(I.image_weight) FROM projects P
    LEFT JOIN images I
    ON P.project_id = I.project_id
    WHERE P.project_id IN (62)
    ORDER BY I.image_weight ASC, I.image_src DESC;
