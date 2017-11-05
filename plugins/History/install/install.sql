CREATE TABLE IF NOT EXISTS `deployee_history` (
  `name` CHAR(255) NOT NULL,
  `deploytime` DATETIME NOT NULL,
  PRIMARY KEY (`name`)
)
  COLLATE='utf8_general_ci'
  ENGINE=InnoDB
;

CREATE TABLE IF NOT EXISTS `deployee_history_deployments` (
  `name` VARCHAR(255) NOT NULL,
  `deploytime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `exitcode` TINYINT(1) UNSIGNED NOT NULL,
  `output` TEXT NULL,
  `erroroutput` TEXT NULL,
  PRIMARY KEY (`name`)
)
  COLLATE='utf8_general_ci'
  ENGINE=InnoDB
;

# Update old installations
REPLACE INTO `deployee_history_deployments` (`name`, `deploytime`) SELECT `name`, `deploytime` FROM `deployee_history`;

DROP TABLE `deployee_history`;