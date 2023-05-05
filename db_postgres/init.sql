-- Database: lsi_kintaikanri

-- DROP DATABASE IF EXISTS lsi_kintaikanri;

CREATE TYPE action_enum AS ENUM ('check_in', 'check_out', 'start_break', 'end_break');

CREATE TABLE IF NOT EXISTS tbl_checkinout (
    check_id serial PRIMARY KEY,
    user_id integer NOT NULL,
    action action_enum NOT NULL,
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

-- them test data 
INSERT INTO tbl_checkinout (user_id, action, check_time, latitude, longitude, remote)
SELECT 
    user_id, 
    CAST(action AS action_enum), 
    CASE action
        WHEN 'check_in' THEN (date_trunc('month', '2023-05-01'::date) + interval '1 day' * days.day + interval '9 hours')::timestamp
        WHEN 'start_break' THEN (date_trunc('month', '2023-05-01'::date) + interval '1 day' * days.day + interval '12 hours')::timestamp
        WHEN 'end_break' THEN (date_trunc('month', '2023-05-01'::date) + interval '1 day' * days.day + interval '13 hours')::timestamp
        WHEN 'check_out' THEN (date_trunc('month', '2023-05-01'::date) + interval '1 day' * days.day + interval '18 hours')::timestamp
        ELSE null -- xử lý lỗi nếu action không hợp lệ
    END,
    34.4458203, 
    132.7108268, 
    false 
FROM
    (SELECT 2 AS user_id UNION SELECT 3 UNION SELECT 4) AS users
    CROSS JOIN LATERAL (SELECT generate_series(0, 365) AS day) AS days
    CROSS JOIN (SELECT 'check_in' AS action UNION SELECT 'start_break' UNION SELECT 'end_break' UNION SELECT 'check_out') AS actions
WHERE 
    EXTRACT(ISODOW FROM (date_trunc('month', '2023-05-01'::date) + interval '1 day' * days.day)) NOT IN (6, 7);
