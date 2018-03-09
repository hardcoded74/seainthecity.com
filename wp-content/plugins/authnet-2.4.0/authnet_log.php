<?php header("Location: /"); exit(); ?>
/********************* Authorize.net log file *********************/
2013-04-01 11:41:42 - INFO  --> Activating/Installing plugin 
2013-04-01 11:41:42 - INFO  --> Creating table: wp_authnet_user_subscription 
2013-04-01 11:41:42 - DEBUG --> CREATE TABLE  `wp_authnet_user_subscription` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `user_id` bigint unsigned NOT NULL,
  `billingFirstName` varchar(255) NOT NULL,
  `billingLastName` varchar(255) NOT NULL,
  `billingCompany` varchar(255) NOT NULL,
  `billingAddress` varchar(255) NOT NULL,
  `billingCity` varchar(255) NOT NULL,
  `billingState` varchar(255) NOT NULL,
  `billingZip` varchar(45) NOT NULL,
  `billingCountry` varchar(255) NOT NULL default 'United States',
  `billingPhone` varchar(45) NOT NULL,
  `shippingFirstName` varchar(255) NULL,
  `shippingLastName` varchar(255) NULL,
  `shippingCompany` varchar(255) NULL,
  `shippingAddress` varchar(255) NULL,
  `shippingCity` varchar(255) NULL,
  `shippingState` varchar(255) NULL,
  `shippingZip` varchar(45) NULL,
  `shippingCountry` varchar(255) NULL default 'United States',
  `shippingPhone` varchar(45) NULL,
  `emailAddress` varchar(255) NOT NULL,
  `xSubscriptionId` varchar(255) NULL,
  `lastFourDigitsOfCreditCard` char(4) NULL,
  `lastFourDigitsOfBankAccountNumber` char(4) NULL,
  `startDate` datetime NULL,
  `MWXAccountLinked` datetime NULL,
  `isRecurring` int(10) NULL,
  `endRecurringDate` datetime NULL,
  `subscriptionNotes` TEXT NULL,
  PRIMARY KEY  USING BTREE (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='this table corresponds to user in wordpress'; 
2013-04-01 11:41:42 - INFO  --> Creating table: wp_authnet_subscription 
2013-04-01 11:41:42 - DEBUG --> CREATE TABLE  `wp_authnet_subscription` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `processSinglePayment` int(10) unsigned NOT NULL ,
  `processRecurringPayment` int(10) unsigned NOT NULL ,
  `variablePaymentTemplate` int(10) unsigned NOT NULL ,
  `name` varchar(255) NOT NULL,
  `initialAmount` decimal(10,2) NULL,
  `initialDescription` varchar(255) NULL,
  `initialInvoiceNum` varchar(255) NULL,
  `recurringRefId` varchar(255) NULL,
  `recurringIntervalLength` int(10) unsigned NULL ,
  `recurringIntervalUnit` varchar(255) NULL,
  `recurringTotalOccurrences` int(10) unsigned NULL ,
  `recurringTrialOccurrences` INT(10) UNSIGNED NOT NULL DEFAULT 0 ,
  `recurringConcealTrial` int(10) unsigned NULL ,
  `recurringAmount` decimal(10,2) NULL,
  `recurringTrialAmount` DECIMAL(10,2) NOT NULL DEFAULT '0.00' ,
  `wishlistLevel` varchar(255) NOT NULL,
  `submLevel` varchar(45) NOT NULL,
  `specificStartDate` DATE NOT NULL DEFAULT '0000-00-00', 
  `xDaysDelayStartDate` INT(10) NOT NULL DEFAULT 0,
  `thankyou_page` VARCHAR(255) NULL DEFAULT '',
  PRIMARY KEY  USING BTREE (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='this table defines a template for subscription processing'; 
2013-04-01 11:41:42 - INFO  --> Creating table: wp_authnet_payment 
2013-04-01 11:41:42 - DEBUG --> CREATE TABLE  `wp_authnet_payment` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `user_subscription_id` bigint unsigned NOT NULL,
  `xAuthCode` varchar(255) NOT NULL,
  `xTransId` varchar(255) NOT NULL,
  `xAmount` decimal(10,2) NOT NULL,
  `xMethod` varchar(255) NOT NULL,
  `xType` varchar(255) NOT NULL,
  `xSubscriptionId` varchar(255) NULL,
  `xSubscriptionPaynum` int(10) NULL,
  `paymentDate` datetime NOT NULL,
  `expiryDate` datetime NULL,
  `xTransStatus` varchar(255) NULL,
  `fullAuthorizeNetResponse` blob NULL,
  PRIMARY KEY  USING BTREE (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='payment table is child to user_subscription'; 
2013-04-01 11:41:42 - INFO  --> Creating table: wp_authnet_cancellation 
2013-04-01 11:41:42 - DEBUG --> CREATE TABLE  `wp_authnet_cancellation` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `user_subscription_id` bigint unsigned NOT NULL,
  `refId` varchar(255) NOT NULL,
  `reason` blob NULL,
  `xSubscriptionId` int(10) NOT NULL,
  `cancellationDate` datetime NOT NULL,
  `fullAuthorizeNetResponse` blob NOT NULL,
  PRIMARY KEY  USING BTREE (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='cancellation table is child to user_subscription'; 
2013-04-01 11:41:42 - INFO  --> Creating table: wp_authnet_cart_items 
2013-04-01 11:41:42 - DEBUG --> CREATE TABLE  `wp_authnet_cart_items` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `user_subscription_id` bigint unsigned NOT NULL,
  `subscription_id` int(10) unsigned NOT NULL,
  `unitPrice` decimal(10,2) NULL,
  `quantity` int(10) NULL,
  `totalPrice` decimal(10,2) NULL,
  `memberwing_transaction_id` varchar(255) NOT NULL,
  PRIMARY KEY  USING BTREE (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='cart items'; 
2013-04-01 11:41:43 - INFO  --> Creating table: wp_authnet_refund 
2013-04-01 11:41:43 - DEBUG --> CREATE TABLE  `wp_authnet_refund` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `user_subscription_id` bigint unsigned NOT NULL,
  `xTransId` varchar(255) NULL,
  `refTransId` varchar(255) NOT NULL,
  `refTransStatus` varchar(255) NOT NULL,
  `refundDate` datetime NOT NULL,
  PRIMARY KEY  USING BTREE (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='redfund table is child to user_subscription'; 
2013-04-01 11:41:43 - INFO  --> added survey field to wp_authnet_subscription 
2013-04-01 11:41:43 - INFO  --> Creating one-time variable payment template... 
2013-04-01 11:41:43 - ERROR --> Failed to add One-time variable payment template to wp_authnet_subscription 
2013-04-01 11:41:43 - INFO  --> Creating monthly variable payment template... 
2013-04-01 11:41:43 - ERROR --> Failed to add Monthly variable payment template to wp_authnet_subscription 
2013-04-01 11:41:43 - INFO  --> Creating quarterly variable payment template... 
2013-04-01 11:41:43 - ERROR --> Failed to add Quarterly variable payment template to wp_authnet_subscription 
2013-04-01 11:41:43 - DEBUG --> Page: checkout ready for creation/update 
2013-04-01 11:41:43 - INFO  --> Updating Page: checkout 
2013-04-02 12:49:53 - DEBUG --> SELECT * FROM wp_authnet_subscription ORDER BY ID ASC 
2013-04-02 13:17:25 - DEBUG --> SELECT * FROM wp_authnet_subscription ORDER BY ID ASC 
2013-10-24 13:16:43 - INFO  --> Deactivating plugin 
2013-10-24 17:31:31 - INFO  --> Activating/Installing plugin 
2013-10-24 17:31:31 - INFO  --> Creating table: wp_authnet_user_subscription 
2013-10-24 17:31:31 - INFO  --> Table: wp_authnet_user_subscription already exists 
2013-10-24 17:31:31 - INFO  --> Creating table: wp_authnet_subscription 
2013-10-24 17:31:31 - INFO  --> Table: wp_authnet_subscription already exists 
2013-10-24 17:31:31 - INFO  --> Creating table: wp_authnet_payment 
2013-10-24 17:31:31 - INFO  --> Table: wp_authnet_payment already exists 
2013-10-24 17:31:31 - INFO  --> Creating table: wp_authnet_cancellation 
2013-10-24 17:31:31 - INFO  --> Table: wp_authnet_cancellation already exists 
2013-10-24 17:31:31 - INFO  --> Creating table: wp_authnet_cart_items 
2013-10-24 17:31:31 - INFO  --> Table: wp_authnet_cart_items already exists 
2013-10-24 17:31:31 - INFO  --> Creating table: wp_authnet_refund 
2013-10-24 17:31:31 - INFO  --> Table: wp_authnet_refund already exists 
2013-10-24 17:31:31 - INFO  --> Creating one-time variable payment template... 
2013-10-24 17:31:31 - ERROR --> Failed to add One-time variable payment template to wp_authnet_subscription 
2013-10-24 17:31:31 - INFO  --> Creating monthly variable payment template... 
2013-10-24 17:31:31 - ERROR --> Failed to add Monthly variable payment template to wp_authnet_subscription 
2013-10-24 17:31:31 - INFO  --> Creating quarterly variable payment template... 
2013-10-24 17:31:31 - ERROR --> Failed to add Quarterly variable payment template to wp_authnet_subscription 
2013-10-24 17:31:31 - DEBUG --> Page: checkout ready for creation/update 
2013-10-24 17:31:31 - INFO  --> Updating Page: checkout 
2013-10-24 17:33:41 - INFO  --> Deactivating plugin 
