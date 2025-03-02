SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+01:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- etws_db
--

DROP SCHEMA IF EXISTS etws_db;
CREATE SCHEMA IF NOT EXISTS etws_db;

-- --------------------------------------------------------

--
-- company
--

DROP TABLE IF EXISTS company;
CREATE TABLE IF NOT EXISTS company
(
    company_id   int(7)       NOT NULL AUTO_INCREMENT,
    name         varchar(255) NOT NULL,
    kvk          int(8)       NOT NULL,
    country      varchar(100) NOT NULL,
    streetnumber int(5)       NOT NULL,
    street       varchar(100) NOT NULL,
    zipcode      varchar(6)   NOT NULL,
    city         varchar(100) NOT NULL,
    province     varchar(100) NOT NULL,
    PRIMARY KEY (company_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- etws_product
--

DROP TABLE IF EXISTS etws_product;
CREATE TABLE IF NOT EXISTS etws_product
(
    product_id        int(7)     NOT NULL AUTO_INCREMENT,
    installation_date date       NOT NULL,
    status            tinyint(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (product_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO etws_product (installation_date, status)
VALUES (curdate(), 1),
       (curdate() - 100, 1);

-- --------------------------------------------------------

--
-- etws_data
--

DROP TABLE IF EXISTS etws_data;
CREATE TABLE IF NOT EXISTS etws_data
(
    data_id  int(7)      NOT NULL AUTO_INCREMENT,
    product  int(7)      NOT NULL,
    kilowatt float(4, 2) NOT NULL,
    date     date        NOT NULL,
    PRIMARY KEY (data_id),
    FOREIGN KEY (product) REFERENCES etws_product (product_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO etws_data (product, kilowatt, date)
VALUES (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL 2 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL 1 DAY),
       (1, rand() * (0.00 - 2.00) + 2.00, curdate()),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL rand() * (0 - 50) + 50 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL 3 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate() - INTERVAL 1 DAY),
       (2, rand() * (0.00 - 2.00) + 2.00, curdate());

-- --------------------------------------------------------

--
-- user
--

DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS user
(
    user_id      int(7)       NOT NULL AUTO_INCREMENT,
    company      int(7)                DEFAULT NULL,
    product      int(7)       NOT NULL,
    email        varchar(255) NOT NULL,
    password     blob         NOT NULL,
    join_date    date         NOT NULL,
    activated    tinyint(1)   NOT NULL DEFAULT 0,
    firstname    varchar(255) NOT NULL,
    insertion    varchar(50)           DEFAULT NULL,
    lastname     varchar(255) NOT NULL,
    birthdate    date         NOT NULL,
    phone        int(10)      NOT NULL,
    country      varchar(100) NOT NULL,
    province     varchar(100) NOT NULL,
    city         varchar(100) NOT NULL,
    zipcode      varchar(6)   NOT NULL,
    street       varchar(100) NOT NULL,
    streetnumber int(5)       NOT NULL,
    user_role    tinyint(1)   NOT NULL DEFAULT 1,
    PRIMARY KEY (user_id),
    FOREIGN KEY (company) REFERENCES company (company_id),
    FOREIGN KEY (product) REFERENCES etws_product (product_id),
    UNIQUE KEY email_UNIQUE (email),
    UNIQUE KEY phone_UNIQUE (phone)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO user (product, email, password, join_date, activated, firstname, lastname, birthdate, phone, country, province, city, zipcode, street, streetnumber)
VALUES (1, 'henk@mail.nl', '$2y$10$U4zPov6wzvpQrN.5fdXL2.MwTWBmkNBK4svt496t5zzplhftj.V5a', '2020-11-21', 1, 'Henk', 'De Vries', '1982-04-06', 0612345678, 'Nederland', 'Utrecht', 'Utrecht', '3522AB', 'Nieuwestraat', 133),
       (2, 'sara@mail.nl', '$2y$10$U4zPov6wzvpQrN.5fdXL2.MwTWBmkNBK4svt496t5zzplhftj.V5a', '2021-01-12', 1, 'Sara', 'De Groot', '1995-08-15', 0687654321, 'Nederland', 'Zuid-Holland', 'Den Haag', '1022AB', 'Groteweg', 45);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
