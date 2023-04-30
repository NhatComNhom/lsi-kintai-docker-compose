-- Database: lsi_kintaikanri

-- DROP DATABASE IF EXISTS lsi_kintaikanri;

CREATE DATABASE lsi_kintaikanri
    WITH
    OWNER = lsi_kintaikanri
    ENCODING = 'UTF8'
    LC_COLLATE = 'en_US.UTF8'
    LC_CTYPE = 'en_US.UTF8'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;

ALTER DATABASE lsi_kintaikanri
    SET "TimeZone" TO 'utc';

ALTER DEFAULT PRIVILEGES FOR ROLE postgres
GRANT ALL ON TABLES TO lsi_kintaikanri;

ALTER DEFAULT PRIVILEGES FOR ROLE postgres
GRANT ALL ON SEQUENCES TO lsi_kintaikanri;

ALTER DEFAULT PRIVILEGES FOR ROLE postgres
GRANT EXECUTE ON FUNCTIONS TO lsi_kintaikanri;

CREATE TABLE IF NOT EXISTS tbl_checkinout (
    check_id serial PRIMARY KEY,
    user_id integer NOT NULL,
    action varchar(50),
    check_time timestamp,
    latitude varchar(50),
    longitude varchar(50),
    remote boolean NOT NULL DEFAULT false
);

CREATE TABLE IF NOT EXISTS tbl_employees (
    id serial PRIMARY KEY,
    name varchar(50) NOT NULL,
    username varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    password varchar(255) NOT NULL,
    role integer NOT NULL DEFAULT 0
);

INSERT INTO tbl_employees (name, username, email, password, role)
VALUES
('ADMIN', 'admin', 'admin@lsi-dev.co.jp', '$2y$10$NEUntzaSR3rzP7Du7NpsRufVd71.Ag.joxcicpgbXWgdh3XZqdd26', 1),
('A氏', 'ashi', 'ashi@lsi-dev.co.jp', '$2y$10$pZ4yrOnO3otW0AKXz683JOXnSkznrdn./3DRy.TtEHOLDdL4cvH6C', 0),
('B氏', 'bshi', 'bshi@lsi-dev.co.jp', '$2y$10$9gMJaI4wAs66KSRH6JFe9OxOCpM1lWxRphvtegZ9oC0TpWp2.Zuga', 0),
('C氏', 'cshi', 'cshi@lsi-dev.co.jp', '$2y$10$ErmPiu0PAY/CRu1uV605Z.f0h1ZpYvQWVngtnd5skhi1uYkNeRwDC', 0);

ALTER TABLE tbl_checkinout
ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES tbl_employees (id);

-- Bổ sung index
CREATE INDEX idx_user_id ON tbl_checkinout(user_id);
CREATE INDEX idx_location_id ON tbl_checkinout(latitude);
