#
# Table structure for table `khat`
#

CREATE TABLE khat (
    khatid  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    salon   INT(5) UNSIGNED  NOT NULL DEFAULT '0',
    uid     INT(5) UNSIGNED  NOT NULL DEFAULT '0',
    person  VARCHAR(20)      NOT NULL DEFAULT '',
    heure   INT(10) UNSIGNED NOT NULL DEFAULT '0',
    message TEXT             NOT NULL,
    PRIMARY KEY (khatid),
    FULLTEXT KEY `search` (`message`)
)
    ENGINE = ISAM;

INSERT INTO khat
VALUES (1, 0, 0, "kyex", 1030296709, 'Bienvenue sur khat mon petit chat ;-)');
