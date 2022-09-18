-- ### ЗАПОЛНЕНИЕ ТАБЛИЦ ### --

-- CUSTOMER --
DO
$$
    BEGIN
        FOR i IN 1..10000 LOOP
            INSERT INTO "customer" ("name", "surname", "email", "phone")
            VALUES (generate_customer_name(), generate_customer_surname(), generate_customer_email(), generate_customer_phonenumber());
        END LOOP;
    END
$$;

-- CINEMA_HALL --
INSERT INTO "cinema_hall" ("id", "name")
VALUES (1, 'VIP');
INSERT INTO "cinema_hall" ("id", "name")
VALUES (2, 'IMAX');
INSERT INTO "cinema_hall" ("id", "name")
VALUES (3, 'RELAX');

-- CINEMA_HALL_CONFIGURATION  --

INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (1, 1, 1, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (2, 1, 2, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (3, 1, 3, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (4, 1, 4, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (5, 1, 5, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (6, 1, 6, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (7, 1, 7, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (8, 1, 8, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (9, 1, 9, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (10, 1, 10, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (11, 2, 1, 23);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (12, 2, 2, 23);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (13, 2, 3, 23);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (14, 2, 4, 23);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (15, 2, 5, 15);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (16, 2, 6, 15);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (17, 2, 7, 15);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (18, 2, 8, 15);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (19, 2, 9, 15);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (20, 2, 10, 15);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (21, 3, 1, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (22, 3, 2, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (23, 3, 3, 10);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (24, 3, 4, 5);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (25, 3, 5, 5);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (26, 3, 6, 5);
INSERT INTO "cinema_hall_configuration" ("id", "cinema_hall_id", "row", "places_in_row")
VALUES (27, 3, 7, 5);

-- MOVIE --

DO
$$
    DECLARE
        mv_name text;
        count_loop integer := 0;
    BEGIN
        WHILE count_loop < 40 LOOP
            mv_name := generate_movie_name();

            IF (SELECT COUNT(id) FROM movie WHERE name = mv_name) != 0
                THEN CONTINUE;
            END IF;

            INSERT INTO "movie" ("name", "description", "release_date", "duration", "price")
            VALUES (
                mv_name,
                generate_movie_description(50),
                generate_movie_release_date(),
                generate_movie_duartion(),
                generate_movie_price()
            );

            count_loop := count_loop + 1;
        END LOOP;
    END
$$;

-- SESSION --

DO
$$
    DECLARE
        mv_name text;
        movie_id integer;
        count_loop integer := 0;
    BEGIN
        WHILE count_loop < 300 LOOP
            mv_name := (SELECT movie_name FROM get_random_movie_name);
            movie_id := (SELECT id FROM get_movie_data WHERE name = mv_name);

            INSERT INTO
                "session" ("name", "movie_id", "cinema_hall_id", "price")
            VALUES (
                mv_name,
                movie_id,
                (SELECT cinema_hall_id FROM get_random_cinema_hall_id),
                generate_session_price()
            );

            count_loop := count_loop + 1;
        END LOOP;
    END
$$;

-- SCHEDULE --

DO
$$
    DECLARE
        mv_id integer;
        ses_id integer;
        start_session_time time;
        curr_schedule_data record;
    BEGIN
        FOR i IN 1..300 LOOP
            ses_id := i;

            start_session_time := '08:00:00';

            -- таким образом проверяем ранее добавленные сеансы в расписание --
            FOR curr_schedule_data IN (SELECT * FROM schedule) LOOP
                -- если if выполнится, значит сеанс в этом кинозале уже есть --
                IF (SELECT COUNT(session.cinema_hall_id) FROM session JOIN schedule ON session.id=schedule.session_id WHERE schedule.id = curr_schedule_data.id) != 0
                    -- получаем время уже добавленного сеанса --
                    THEN mv_id := (SELECT movie.id FROM movie JOIN session ON movie.id=session.movie_id JOIN schedule ON session.id=schedule.session_id WHERE schedule.id=curr_schedule_data.id);
                    start_session_time := curr_schedule_data.start_time_session + ((SELECT duration FROM get_movie_data where id=mv_id) || ' minutes')::interval;

                    -- если сеанс не был ранее добавлен, то добавляем в таблицу такой сеанс; иначе пропускаем --
                    IF (SELECT COUNT(schedule.id) FROM schedule WHERE schedule.id=curr_schedule_data.id) = 0
                        THEN INSERT INTO
                            "schedule" ("session_id", "start_date_session", "start_time_session")
                        VALUES (
                            ses_id,
                            generate_schedule_date(),
                            start_session_time
                        );
                        ELSE
                            CONTINUE;
                    END IF;
                END IF;
            END LOOP;

            IF (SELECT COUNT(schedule.id) FROM schedule WHERE schedule.id=ses_id) = 0
                THEN INSERT INTO
                    "schedule" ("session_id", "start_date_session", "start_time_session")
                VALUES (
                    ses_id,
                    generate_schedule_date(),
                    start_session_time
                );
            ELSE
                CONTINUE;
            END IF;
        END LOOP;
    END
$$;

-- TICKET --

DO
$$
    DECLARE
		tmp_schedule_id integer;
    BEGIN
        FOR i IN 1..1000000 LOOP
                tmp_schedule_id := (SELECT schedule_id FROM get_random_schedule_id);
            INSERT INTO
                "ticket" ("date_of_sale", "time_of_sale", "customer_id", "schedule_id", "total_price", "movie_name")
            VALUES (
                generate_date(),
                generate_time(),
                (SELECT customer_id FROM get_random_customer_id),
                tmp_schedule_id,
                (SELECT movie_price FROM price_movie_by_schedule_id WHERE schedule_id = tmp_schedule_id) + (SELECT session_price FROM price_session_by_schedule_id WHERE schedule_id = tmp_schedule_id),
                (SELECT movie_name FROM get_movie_name_by_schedule_id WHERE schedule_id = tmp_schedule_id)
            );
        END LOOP;
    END
$$;

-- OCCUPIED_CINEMA_HALL_SEATS --

DO
$$
    DECLARE
        cnma_hall_id integer;
        cnma_hall_row integer;
        cnma_hall_places integer;
        cnma_hall_place integer;
        ticket_data record;
        count_loop integer;
    BEGIN
        FOR ticket_data IN (SELECT * FROM ticket) LOOP
            cnma_hall_id = (SELECT cinema_hall_id FROM get_cinema_hall_id_by_ticket_id WHERE ticket_id = ticket_data.id);

            cnma_hall_row := (SELECT cinema_hall_row FROM get_cinema_hall_row_by_ticket_id WHERE ticket_id = ticket_data.id ORDER BY random() LIMIT 1);

            cnma_hall_places := (SELECT cinema_hall_place FROM get_cinema_hall_places_by_ticket_id WHERE ticket_id = ticket_data.id ORDER BY random() LIMIT 1);
            cnma_hall_place := (SELECT * FROM floor(random() * cnma_hall_places));

            INSERT INTO
                "occupied_cinema_hall_seats" ("ticket_id", "cinema_hall_id", "row", "place")
            VALUES (
                ticket_data.id,
                    cnma_hall_id,
                    cnma_hall_row,
                    cnma_hall_place
                );
        END LOOP;
    END
$$;
