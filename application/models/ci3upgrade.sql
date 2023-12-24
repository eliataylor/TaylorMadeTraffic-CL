CREATE TABLE IF NOT EXISTS `tmt_sessions2`
(
    `id`         varchar(128) NOT NULL,
    `ip_address` varchar(45)  NOT NULL,
    `timestamp`  int(10) unsigned DEFAULT 0 NOT NULL,
    `data`       blob         NOT NULL,
    KEY          `ci_sessions_timestamp`(`timestamp`
)
    );

ALTER TABLE tmt_sessions2
    ADD PRIMARY KEY(id, ip_address);
