CREATE TABLE `propositions` (
  `uuid`      CHAR(36)     NOT NULL,
  `ticket_id` CHAR(36)     NOT NULL,
  `comment`   VARCHAR(190) NOT NULL,
  PRIMARY KEY (`uuid`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
