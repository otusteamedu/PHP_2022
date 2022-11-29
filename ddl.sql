CREATE TABLE Halls
(
    id   int PRIMARY KEY,
    name varchar(256) NOT NULL
);

CREATE TABLE Movies
(
    id       int PRIMARY KEY,
    name     varchar(256) NOT NULL,
    duration time         NOT NULL
);

CREATE TABLE Displays
(
    id         int PRIMARY KEY,
    hall_id    int       NOT NULL,
    movie_id   int       NOT NULL,
    start_date timestamp NOT NULL,
    initial_price int NOT NULL,
    CONSTRAINT fk_hall FOREIGN KEY (hall_id) REFERENCES Halls (id),
    CONSTRAINT fk_movie FOREIGN KEY (movie_id) REFERENCES Movies (id)
);

CREATE TABLE Places
(
    id      int PRIMARY KEY,
    row     int NOT NULL,
    number     int NOT NULL,
    extra_charge int NOT NULL,
    hall_id int NOT NULL,
    CONSTRAINT fk_hall FOREIGN KEY (hall_id) REFERENCES Halls (id)
);

CREATE TABLE Tickets
(
    id           int PRIMARY KEY,
    display_id   int NOT NULL,
    place_id     int NOT NULL,
    is_purchased boolean DEFAULT false,
    CONSTRAINT fk_display FOREIGN KEY (display_id) REFERENCES Displays (id),
    CONSTRAINT fk_place FOREIGN KEY (place_id) REFERENCES Places (id)
);