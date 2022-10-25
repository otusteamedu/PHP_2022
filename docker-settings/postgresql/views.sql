CREATE OR REPLACE VIEW price_movie_by_schedule_id AS
SELECT
    movie.price AS movie_price, schedule.id AS schedule_id
FROM schedule
    JOIN session ON
        session.id = schedule.session_id
    JOIN movie ON
        movie.id = session.movie_id
;

CREATE OR REPLACE VIEW price_session_by_schedule_id AS
SELECT
    session.price AS session_price, schedule.id AS schedule_id
FROM schedule
    JOIN session ON
        session.id = schedule.session_id
;

CREATE OR REPLACE VIEW get_movie_name_by_schedule_id AS
SELECT
    movie.name AS movie_name, schedule.id AS schedule_id
FROM schedule
    JOIN session ON
        session.id = schedule.session_id
    JOIN movie ON
        movie.id = session.movie_id
;

CREATE OR REPLACE VIEW get_movie_data AS
SELECT
    *
FROM
    movie
;

CREATE OR REPLACE VIEW get_random_movie_name AS
SELECT
    movie.name as movie_name
FROM
    movie
ORDER BY random()
    LIMIT 1
;

CREATE OR REPLACE VIEW get_random_movie_id AS
SELECT
    movie.id as movie_id
FROM
    movie
ORDER BY random()
    LIMIT 1
;

CREATE OR REPLACE VIEW get_random_cinema_hall_id AS
SELECT
    id as cinema_hall_id
FROM
    cinema_hall
ORDER BY random()
    LIMIT 1
;

CREATE OR REPLACE VIEW get_random_customer_id AS
SELECT
    id as customer_id
FROM
    customer
ORDER BY random()
    LIMIT 1
;

CREATE OR REPLACE VIEW get_random_schedule_id AS
SELECT
    id as schedule_id
FROM
    schedule
ORDER BY random()
    LIMIT 1
;

CREATE OR REPLACE VIEW get_cinema_hall_row_by_ticket_id AS
SELECT
    cinema_hall_configuration.row AS cinema_hall_row, ticket.id AS ticket_id
FROM
    cinema_hall_configuration
        JOIN session ON
            session.cinema_hall_id = cinema_hall_configuration.cinema_hall_id
        JOIN schedule ON
            session.id = schedule.session_id
        JOIN ticket ON
            schedule.id = ticket.schedule_id
;

CREATE OR REPLACE VIEW get_cinema_hall_places_by_ticket_id AS
SELECT
    cinema_hall_configuration.places_in_row AS cinema_hall_place, ticket.id AS ticket_id
FROM
    cinema_hall_configuration
        JOIN session ON
            session.cinema_hall_id = cinema_hall_configuration.cinema_hall_id
        JOIN schedule ON
            session.id = schedule.session_id
        JOIN ticket ON
            schedule.id = ticket.schedule_id
;

CREATE OR REPLACE VIEW get_cinema_hall_id_by_ticket_id AS
SELECT
    cinema_hall.id AS cinema_hall_id, ticket.id AS ticket_id
FROM
    cinema_hall
        JOIN session ON
            cinema_hall.id = session.cinema_hall_id
        JOIN schedule ON
            session.id = schedule.session_id
        JOIN ticket ON
            schedule.id = ticket.schedule_id
;