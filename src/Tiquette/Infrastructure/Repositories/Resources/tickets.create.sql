CREATE TABLE `tickets` (
  `uuid`              CHAR(36)         NOT NULL,
  `event_name`        VARCHAR(190)     NOT NULL DEFAULT '',
  `event_description` TEXT             NOT NULL,
  `event_date`        DATETIME         NOT NULL,
  `bought_at_price`   INT(10) UNSIGNED NOT NULL,
  `price_currency`    CHAR(3)          NOT NULL DEFAULT ''
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
