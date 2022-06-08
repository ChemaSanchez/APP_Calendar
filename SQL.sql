DROP DATABASE app_calendar;
CREATE DATABASE app_calendar;
USE app_calendar;
CREATE TABLE IF NOT EXISTS calendar(
    id      bigint(10)   NOT NULL AUTO_INCREMENT,
    name    varchar(255) NOT NULL DEFAULT '',
    subject VARCHAR(255) NOT NULL DEFAULT 'Cita',
    hour    varchar(255) NOT NULL DEFAULT '',
    telf    varchar(255) NOT NULL DEFAULT '',
    date    varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8mb4
  ROW_FORMAT = COMPRESSED;