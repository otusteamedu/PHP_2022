CREATE TABLE operation
(
    id SERIAL PRIMARY KEY,
    person VARCHAR(255),
    amount NUMERIC,
    date DATE,
    created_at DATE
);