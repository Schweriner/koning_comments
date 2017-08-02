#
# Table structure for table 'tx_koningcomments_domain_model_comment'
#
CREATE TABLE tx_koningcomments_domain_model_comment (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    editlock tinyint(4) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,

    date int(11) DEFAULT '0' NOT NULL,
    url tinytext,
    body text,
    user int(11) DEFAULT '0' NOT NULL,
    nonuser_username varchar(255) DEFAULT '' NOT NULL,
    nonuser_email varchar(255) DEFAULT '' NOT NULL,
    nonuser_www varchar(255) DEFAULT '' NOT NULL,
    reply_to int(11) DEFAULT '0' NOT NULL,
    replies int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);
