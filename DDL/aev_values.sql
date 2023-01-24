DROP TABLE IF EXISTS aev_values;
CREATE TABLE aev_values (
    id            SERIAL PRIMARY KEY,
    movie_id      INT       NOT NULL,
    attribute_id  INT       NOT NULL,
    value_int     INT NULL,
    value_numeric NUMERIC NULL,
    value_text    TEXT NULL,
    value_date    DATE NULL,
    value_bool    BOOLEAN NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (attribute_id) REFERENCES aev_attributes (id)
);