CREATE TABLE IF NOT EXISTS cinema
(
    c_id    serial       NOT NULL primary key,
    c_title varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS attribute_type
(
    at_id   smallserial NOT NULL primary key,
    at_type varchar(25) NOT NULL
);

CREATE TABLE IF NOT EXISTS attribute
(
    a_id    smallserial  NOT NULL primary key,
    a_title varchar(255) NOT NULL,
    a_at_id int2         NOT NULL REFERENCES attribute_type (at_id)
);

CREATE TABLE IF NOT EXISTS attribute_value
(
    av_id             serial NOT NULL primary key,
    av_c_id           int2   NOT NULL REFERENCES cinema (c_id),
    av_a_id           int2   NOT NULL REFERENCES attribute (a_id),
    av_value_bool     bool,
    av_value_int      int,
    av_value_varchar  varchar,
    av_value_text     text,
    av_value_datetime timestamp with time zone
);