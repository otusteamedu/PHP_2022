CREATE TABLE users (
   id SERIAL PRIMARY KEY ,
   first_name varchar(255) NOT NULL,
   last_name varchar(255) NOT NULL,
   email varchar(400) NOT NULL,
   approved bool NOT NULL DEFAULT false
);