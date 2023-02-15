CREATE OR REPLACE FUNCTION random_string(length integer) RETURNS TEXT AS
$$
DECLARE
    chars  text[]  := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text    := '';
    i      integer := 0;
BEGIN
    IF length < 0 THEN
        RAISE EXCEPTION 'Given length cannot be less than 0';
    END IF;
    FOR i IN 1..length
        LOOP
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        END LOOP;
    RETURN result;
END;
$$ language plpgsql;

DO
$$
    DECLARE
        number_of_cinema     integer = 10; -- 5   10
        id_val               integer;
        number_of_movies     integer = 1000;
        number_of_halls      integer = 5; -- 3   5
        hall_id              integer = 1;
        place_id             integer = 1;
        price_modifier       integer;
        number_of_rows       integer = 10; -- 5 10
        number_of_places     integer = 20; -- 10 20
        number_of_clients    integer = 5000000; -- 5 000  -- 5 000 000
        schedule_id          integer = 0;
        movie_id             integer;
        days                 integer = 365; -- 10   365
        start_period         integer = -345; -- -7  -345
        end_period           integer = start_period + days;
        start_time           time;
        base_price           integer;
        ticket_id            integer = 1;
        client_id            integer;
        place_price_modifier integer;
    BEGIN
        -- INIT ADDRESS, CINEMA VALUES --

        FOR id_val IN 1..number_of_cinema
            LOOP
                INSERT INTO "Address"(id, "City", "Location")
                VALUES (id_val, random_string(10), random_string(30));
                INSERT INTO "Cinema"(id, "Name", "Address")
                VALUES (id_val, random_string(10), id_val);

                -- INIT HALLS VALUES --
                FOR hall_number IN 1..number_of_halls
                    LOOP
                        INSERT INTO "Hall"(id, "Name", "Cinema")
                        VALUES (hall_id, 'Зал' || hall_number, id_val);

                        price_modifier = 700;

                        -- INIT PLACES VALUES --
                        FOR row IN 1..number_of_rows
                            LOOP
                                FOR place_number IN 1..number_of_places
                                    LOOP
                                        INSERT INTO "Place"(id, "Row", "Number", "Hall", "PriceModifier")
                                        VALUES (place_id, row, place_number, hall_id, price_modifier);
                                        place_id = place_id + 1;
                                    END LOOP;
                                price_modifier = price_modifier - 100;
                            END LOOP;
                        hall_id = hall_id + 1;
                    END LOOP;
            END LOOP;

        -- INIT MOVIES VALUES --
        FOR id_val IN 1..number_of_movies
            LOOP
                INSERT INTO "Movie"(id, "Name")
                VALUES (id_val, random_string(20));
            END LOOP;

        -- INIT CLIENT VALUES --
        FOR client_id IN 1..number_of_clients
            LOOP
                INSERT INTO "Client"
                VALUES (client_id, 'test' || client_id || '@example.com', '');
            END LOOP;

        -- INIT SCHEDULE VALUES --

        FOR day IN start_period..end_period
            LOOP
                FOR hall_id IN 1..(number_of_halls * number_of_cinema)
                    LOOP
                        movie_id = FLOOR(RANDOM() * number_of_movies) + 1;
                        start_time = '12:00:00';
                        base_price = 1000;
                        FOR counter IN 1..6
                            LOOP
                                schedule_id = schedule_id + 1;
                                INSERT INTO "Schedule"(id, "Date", "Time", "Hall", "Movie", "BasePrice")
                                VALUES (schedule_id, CURRENT_DATE + day, start_time, hall_id, movie_id,
                                        base_price);
                                FOR row IN 1..number_of_rows
                                    LOOP
                                        FOR place_number IN 1..number_of_places
                                            LOOP
                                                IF (FLOOR(RANDOM() * 2) + 1 > 1)
                                                THEN
                                                    client_id = FLOOR(RANDOM() * number_of_clients) + 1;
                                                    SELECT "PriceModifier", id
                                                    FROM "Place"
                                                    WHERE "Place"."Hall" = hall_id
                                                      AND "Place"."Row" = row
                                                      AND "Place"."Number" = place_number
                                                    INTO place_price_modifier, place_id;
                                                    INSERT INTO "Ticket"(id, "Client", "Price", "Place", "Schedule", "PurchaseTime")
                                                    VALUES (ticket_id, client_id,
                                                            base_price + place_price_modifier, place_id,
                                                            schedule_id,
                                                            CURRENT_DATE + day - (FLOOR(RANDOM() * 14) + 1)::int);
                                                    ticket_id = ticket_id + 1;
                                                END IF;
                                            END LOOP;
                                    END LOOP;
                                base_price = base_price + 200;
                                start_time = start_time + '02:00:00';
                            END LOOP;
                    END LOOP;
            END LOOP;
    END;
$$;
