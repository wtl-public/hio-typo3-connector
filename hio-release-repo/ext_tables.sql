CREATE TABLE tx_hiotypo3connector_domain_model_project
(
    object_id INT(11)  DEFAULT '0' NOT NULL,
    title     LONGTEXT DEFAULT '',
    details   MEDIUMBLOB,
    search_index MEDIUMBLOB,
);

CREATE TABLE tx_hiotypo3connector_domain_model_publication
(
    object_id    INT(11)  DEFAULT '0' NOT NULL,
    title        VARCHAR(255) DEFAULT '',
    details      MEDIUMBLOB,
    search_index MEDIUMBLOB,
    type         VARCHAR(255) DEFAULT '',
    release_year VARCHAR(255) DEFAULT NULL,
);

CREATE TABLE tx_hiotypo3connector_domain_model_person
(
    object_id    INT(11)  DEFAULT '0' NOT NULL,
    name         LONGTEXT DEFAULT '',
    details      MEDIUMBLOB,
    search_index MEDIUMBLOB,
    publications INT(11) DEFAULT '0' NOT NULL,
    projects     INT(11) DEFAULT '0' NOT NULL,
    patents      INT(11) DEFAULT '0' NOT NULL,
    doctoral_programs      INT(11) DEFAULT '0' NOT NULL,
    habilitations      INT(11) DEFAULT '0' NOT NULL,
);

CREATE TABLE tx_hiotypo3connector_domain_model_patent
(
    object_id INT(11)  DEFAULT '0' NOT NULL,
    title     LONGTEXT DEFAULT '',
    details   MEDIUMBLOB,
    search_index MEDIUMBLOB,
);

CREATE TABLE tx_hiotypo3connector_domain_model_doctoralprogram
(
    object_id INT(11)  DEFAULT '0' NOT NULL,
    title     LONGTEXT DEFAULT '',
    details   MEDIUMBLOB,
    search_index MEDIUMBLOB,
);

CREATE TABLE tx_hiotypo3connector_domain_model_habilitation
(
    object_id INT(11)  DEFAULT '0' NOT NULL,
    title     LONGTEXT DEFAULT '',
    details   MEDIUMBLOB,
    search_index MEDIUMBLOB,
);

CREATE TABLE tx_hiotypo3connector_domain_model_citationstyle
(
    label     VARCHAR(255) DEFAULT '',
);
