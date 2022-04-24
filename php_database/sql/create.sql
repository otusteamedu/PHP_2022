CREATE TABLE company (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    address VARCHAR(50),
    phone VARCHAR(15),
    email VARCHAR(50)
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    surname VARCHAR(50)
);