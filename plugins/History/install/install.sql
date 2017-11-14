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
  `success` TINYINT(1) UNSIGNED NOT NULL,
  INDEX `name_success` (`name`, `success`)
)
  COLLATE='utf8_general_ci'
  ENGINE=InnoDB
;


# Update old installations
REPLACE INTO `deployee_history_deployments` (`name`, `deploytime`, `success`) SELECT `name`, `deploytime`, 1 FROM `deployee_history`;

DROP TABLE `deployee_history`;