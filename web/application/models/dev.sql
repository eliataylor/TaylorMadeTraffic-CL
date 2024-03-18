use tmt_portfolio;
set sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"


select project_id, project_title, project_technotes, project_subtitle from projects order by project_id desc;
desc projects;

use tmt_portfolio;
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

select project_id, project_title, project_technotes, project_devtools, project_team, project_companies from projects where projects.project_companies like '%Federal%' order by project_id;
update projects set project_companies = replace(project_companies, 'Federal Laboratory Consortium', 'Federal Labs Consortium');

select project_id, project_technotes from projects where project_companies like '%Flexible%';

select * from images
where project_id = 3
order by project_id, image_weight;

select * from tags where tag_key like '%CSS3%' order by tag_date desc;
select project_id, project_title, project_devtools from projects where project_devtools like '%Node-Red%' order by project_startdate desc;


select project_id, project_title, project_technotes, project_devtools from projects where projects.project_devtools like '%drupal%';

select project_id, project_technotes, project_desc, project_devtools, project_startdate, project_launchdate from projects where project_title like '%Refined%';

select * from images where project_id = 59 order by image_weight;


update tags set tag_type = replace(tag_type, '.', '') where tag_type like '%.';
<a href="/team?qtfilter=E.A.Taylor">E.A.Taylor</a>: Front-End, Back-End. <a href="/team?qtfilter=Aaron Silverberg">Aaron Silverberg</a>: Vice President. <a href="/team?qtfilter=Saiman Shetty">Saiman Shetty</a>: Project Management


select project_id, project_title, project_technotes, project_tech_short from projects where project_status = 'current' order by project_id desc;

select project_id, project_title, project_devtools, project_technotes, project_tech_short from projects where project_status = 'current' order by project_id desc;

select project_id, project_title, project_technotes, project_tech_short from projects where project_status = 'current' order by project_id desc;

