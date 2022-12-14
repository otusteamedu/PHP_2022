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

DO
$$
    DECLARE
        place_id integer = 1;
    BEGIN
        FOR hall_id IN 1..15
            LOOP
                FOR place_number IN 1..10
                    LOOP
                        INSERT INTO "Place"(id, "Number", "Hall", "PriceModifier")
                        VALUES (place_id, place_number, hall_id, 300);
                        place_id = place_id + 1;
                    END LOOP;
                FOR place_number IN 11..20
                    LOOP
                        INSERT INTO "Place"(id, "Number", "Hall", "PriceModifier")
                        VALUES (place_id, place_number, hall_id, 200);
                        place_id = place_id + 1;
                    END LOOP;
                FOR place_number IN 21..30
                    LOOP
                        INSERT INTO "Place"(id, "Number", "Hall", "PriceModifier")
                        VALUES (place_id, place_number, hall_id, 100);
                        place_id = place_id + 1;
                    END LOOP;
            END LOOP;
    END;
$$;

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

-- INIT SCHEDULE VALUES --

DO
$$
    DECLARE
        hall_id    integer;
        shedule_id integer = 1;
    BEGIN
        FOR cinema_id IN 1..3
            LOOP
                FOR movie_id IN 1..5
                    LOOP
                        hall_id = 5 * (cinema_id - 1) + movie_id;

                        INSERT INTO "Schedule"(id, "Date", "Time", "Hall", "Movie", "BasePrice")
                        VALUES (shedule_id, '2022-12-14', '12:00:00', hall_id, movie_id, 1000);
                        shedule_id = shedule_id + 1;

                        INSERT INTO "Schedule"(id, "Date", "Time", "Hall", "Movie", "BasePrice")
                        VALUES (shedule_id, '2022-12-14', '14:00:00', hall_id, movie_id, 1200);
                        shedule_id = shedule_id + 1;

                        INSERT INTO "Schedule"(id, "Date", "Time", "Hall", "Movie", "BasePrice")
                        VALUES (shedule_id, '2022-12-14', '16:00:00', hall_id, movie_id, 1500);
                        shedule_id = shedule_id + 1;

                        INSERT INTO "Schedule"(id, "Date", "Time", "Hall", "Movie", "BasePrice")
                        VALUES (shedule_id, '2022-12-14', '18:00:00', hall_id, movie_id, 1600);
                        shedule_id = shedule_id + 1;

                    END LOOP;
            END LOOP;
    END;
$$;

-- INIT CLIENT VALUES --

DO
$$
    BEGIN
        FOR client_id IN 1..1000
            LOOP
                INSERT INTO "Client"
                VALUES (client_id, 'test' || client_id || '@example.com', '');
            END LOOP;
    END;
$$;

-- INIT TICKET VALUES --
-- ATTENTION! POSSIBLE LONG TIME EXECUTION

DO
$$
    DECLARE
        client_id      integer;
        shedule_id     integer;
        place_id       integer;
        base_price     integer;
        modifier_price integer;
    BEGIN
        FOR ticket_id IN 1..5000000
            LOOP
                client_id = FLOOR(RANDOM() * 1000) + 1;
                shedule_id = FLOOR(RANDOM() * 60) + 1;
                place_id = FLOOR(RANDOM() * 450) + 1;
                SELECT "BasePrice" FROM "Schedule" WHERE "Schedule".id = shedule_id INTO base_price;
                SELECT "PriceModifier" FROM "Place" WHERE "Place".id = place_id INTO modifier_price;
                INSERT INTO "Ticket"(id, "Client", "Price", "Place", "Schedule", "PurchaseTime")
                VALUES (ticket_id, client_id, base_price + modifier_price, place_id, shedule_id, DEFAULT);
            END LOOP;
    END;
$$;