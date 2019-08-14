<?php

$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS `webgility_settings` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `csp_key` varchar(150) DEFAULT NULL,
  `csp_password` varchar(150) DEFAULT NULL,
  `webgility_key` varchar(50) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `Meter_no` varchar(50) DEFAULT NULL,
  `enable` int(2) NOT NULL DEFAULT '0',
  `fedex_name` varchar(50) NOT NULL,
  `fedex_company` varchar(50) NOT NULL,
  `fedex_address1` varchar(50) NOT NULL,
  `fedex_address2` varchar(50) NOT NULL,
  `fedex_city` varchar(20) NOT NULL,
  `fedex_state` varchar(10) NOT NULL,
  `fedex_zip` varchar(50) NOT NULL,
  `fedex_phone` varchar(15) NOT NULL,
  `fedex_fax` varchar(10) NOT NULL,
  `fedex_email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


CREATE TABLE IF NOT EXISTS `webgility_orders` (
  `orderid` varchar(20) NOT NULL,
  `qb_posted` varchar(20) DEFAULT NULL,
  `qb_posted_date` varchar(20) DEFAULT NULL,
  `id` int(4) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;


");

$installer->endSetup();
