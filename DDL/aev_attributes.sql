DROP TABLE IF EXISTS aev_attributes;
CREATE TABLE aev_attributes (
    id         SERIAL PRIMARY KEY,
    type_id    VARCHAR(10) NOT NULL,
    name       VARCHAR(255),
    created_at TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (type_id) REFERENCES aev_types (id)
);