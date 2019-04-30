CREATE TABLE `members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `date_signedup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `tracker_campaigns` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `campaign_name` varchar(200) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `tracker_leads` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `no_of_domains` int(11) DEFAULT '0',
  `status` varchar(200) DEFAULT 'Not contacted',
  `campaign_id` bigint(11) DEFAULT '0',
  `company` varchar(200) DEFAULT NULL,
  `notes` text,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `tracker_leads_socials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` bigint(20) NOT NULL,
  `social_name` varchar(100) DEFAULT NULL,
  `social_url` varchar(200) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `tracker_leads_domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(100) NOT NULL,
  `member_id` int(11) NOT NULL,
  `appraise_value` decimal(10,2) DEFAULT '0.00',
  `registrar` varchar(200) DEFAULT NULL,
  `expire_date` varchar(100) DEFAULT NULL,
  `owner` varchar(200) DEFAULT NULL,
  `campaign_id` int(11) NOT NULL,
  `lead_id` bigint(20) NOT NULL,
  `category_id` int(11) DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



