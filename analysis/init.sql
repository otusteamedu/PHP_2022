-- INIT ADDRESS VALUES --

INSERT INTO "Address"(id, "City", "Location")
VALUES (1, 'Москва', 'Цветной бульвар 32');

INSERT INTO "Address"(id, "City", "Location")
VALUES (2, 'Москва', 'Новый Арбат 7');

INSERT INTO "Address"(id, "City", "Location")
VALUES (3, 'Санкт-Петербург', 'Невский проспект 1');

-- INIT CINEMA VALUES --

INSERT INTO "Cinema"(id, "Name", "Address")
VALUES (1, 'Юпитер', 1);

INSERT INTO "Cinema"(id, "Name", "Address")
VALUES (2, 'Сатурн', 2);

INSERT INTO "Cinema"(id, "Name", "Address")
VALUES (3, 'Нептун', 3);

-- INIT MOVIE VALUES --

INSERT INTO "Movie"(id, "Name")
VALUES (1, 'Терминатор-2');

INSERT INTO "Movie"(id, "Name")
VALUES (2, 'Операция Ы');

INSERT INTO "Movie"(id, "Name")
VALUES (3, '2001 год: Космическая одиссея');

INSERT INTO "Movie"(id, "Name")
VALUES (4, 'Большой Лебовски');

INSERT INTO "Movie"(id, "Name")
VALUES (5, 'Кунг-фу панда');

-- INIT HALL VALUES --

DO
$$
    DECLARE
        hall_id integer = 1;
    BEGIN
        FOR cinema_id IN 1..3
            LOOP
                FOR hall_number IN 1..5
                    LOOP
                        INSERT INTO "Hall"(id, "Name", "Cinema")
                        VALUES (hall_id, 'Зал' || hall_number, cinema_id);
                        hall_id = hall_id + 1;
                    END LOOP;
            END LOOP;
    END;
$$;

-- INIT PLACE VALUES --
-- every hall have 5 rows with 10 places --

DO
$$
    DECLARE
        place_id       integer = 1;
        price_modifier integer;
    BEGIN
        FOR hall_id IN 1..15
            LOOP
                price_modifier = 500;
                FOR row IN 1..5
                    LOOP
                        FOR place_number IN 1..10
                            LOOP
                                INSERT INTO "Place"(id, "Row", "Number", "Hall", "PriceModifier")
                                VALUES (place_id, row, place_number, hall_id, price_modifier);
                                place_id = place_id + 1;
                            END LOOP;
                        price_modifier = price_modifier - 100;
                    END LOOP;
            END LOOP;
    END;
$$;

DO
$$
    DECLARE
        hall_id              integer;
        schedule_id          integer = 0;
        schedules            integer;
        days                 integer = 30;
        start_period         integer = -15;
        end_period           integer = start_period + days;
        client_id            integer;
        place_id             integer;
        number_of_tickets    integer = 10000000; -- 10 000  -- 10 000 000
        number_of_clients    integer = 5000000; -- 5 000  -- 5 000 000
        sh_base_price        integer;
        place_price_modifier integer;
        sh_date              date;

    BEGIN
        -- INIT SCHEDULE VALUES --

        FOR day IN start_period..end_period
            LOOP
                FOR cinema_id IN 1..3
                    LOOP
                        FOR movie_id IN 1..5
                            LOOP
                                hall_id = 5 * (cinema_id - 1) + movie_id;

                                schedule_id = schedule_id + 1;
                                INSERT INTO "Schedule"(id, "Date", "Time", "Hall", "Movie", "BasePrice")
                                VALUES (schedule_id, CURRENT_DATE + day, '12:00:00', hall_id, movie_id, 1000);

                                schedule_id = schedule_id + 1;
                                INSERT INTO "Schedule"(id, "Date", "Time", "Hall", "Movie", "BasePrice")
                                VALUES (schedule_id, CURRENT_DATE + day, '14:00:00', hall_id, movie_id, 1200);

                                schedule_id = schedule_id + 1;
                                INSERT INTO "Schedule"(id, "Date", "Time", "Hall", "Movie", "BasePrice")
                                VALUES (schedule_id, CURRENT_DATE + day, '16:00:00', hall_id, movie_id, 1500);

                                schedule_id = schedule_id + 1;
                                INSERT INTO "Schedule"(id, "Date", "Time", "Hall", "Movie", "BasePrice")
                                VALUES (schedule_id, CURRENT_DATE + day, '18:00:00', hall_id, movie_id, 1600);

                            END LOOP;
                    END LOOP;
            END LOOP;

        schedules = schedule_id;

        -- INIT CLIENT VALUES --
        FOR client_id IN 1..number_of_clients
            LOOP
                INSERT INTO "Client"
                VALUES (client_id, 'test' || client_id || '@example.com', '');
            END LOOP;

        -- INIT TICKET VALUES --
        FOR ticket_id IN 1..number_of_tickets
            LOOP
                client_id = FLOOR(RANDOM() * number_of_clients) + 1;
                schedule_id = FLOOR(RANDOM() * schedules) + 1;
                place_id = FLOOR(RANDOM() * 450) + 1;
                SELECT "BasePrice", "Date"
                FROM "Schedule"
                WHERE "Schedule".id = schedule_id
                INTO sh_base_price, sh_date;
                SELECT "PriceModifier" FROM "Place" WHERE "Place".id = place_id INTO place_price_modifier;
                INSERT INTO "Ticket"(id, "Client", "Price", "Place", "Schedule", "PurchaseTime")
                VALUES (ticket_id, client_id, sh_base_price + place_price_modifier, place_id, schedule_id,
                        sh_date - 1);
            END LOOP;
    END ;
$$;
