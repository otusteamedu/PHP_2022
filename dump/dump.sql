CREATE TABLE "cinema_hall" (
    "id" serial NOT NULL,
    "name" varchar(255) NOT NULL,
    "description" TEXT NOT NULL,
    "max_places" integer NOT NULL --,
--     CONSTRAINT "cinema_hall_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );

CREATE TABLE "cinema_hall_place" (
    "id" serial NOT NULL,
    "cinema_session_id" integer NOT NULL --,
--     CONSTRAINT "cinema_hall_place_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );

CREATE TABLE "cinema_sessions" (
    "id" serial NOT NULL,
    "date_time_start" TIMESTAMP NOT NULL,
    "cinema_hall_id" integer NOT NULL,
    "film_id" integer NOT NULL --,
--     CONSTRAINT "cinema_sessions_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );

CREATE TABLE "tickets" (
    "id" serial NOT NULL,
    "cinema_hall_place_id" integer NOT NULL,
    "price_history_id" integer NOT NULL --,
--     CONSTRAINT "tickets_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );

CREATE TABLE "film" (
    "id" serial NOT NULL,
    "name" varchar(500) NOT NULL,
    "description" TEXT NOT NULL,
    "film_time_minutes" integer NOT NULL,
    "rating" integer NOT NULL,
    "date_start" DATE NOT NULL,
    "date_finish" DATE NOT NULL,
    CONSTRAINT "film_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );

CREATE TABLE "type_price" (
    "id" serial NOT NULL,
    "name" varchar(255) NOT NULL,
    "description" TEXT NOT NULL,
    "cost" DECIMAL(5, 2) NOT NULL,
    CONSTRAINT "type_price_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );

CREATE TABLE "price_history" (
    "id" serial NOT NULL,
    "type_price_id" integer NOT NULL,
    "date_time" TIMESTAMP NOT NULL,
    "price" DECIMAL(5, 2) NOT NULL,
    CONSTRAINT "price_history_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );


-- Dump first data

INSERT INTO cinema_hall (name, description, max_places)
VALUES ('Зал 1', 'Description', 50),
       ('Зал 2', 'Description', 40),
       ('Зал 3', 'Description', 40),
       ('Зал 4', 'Description', 20),
       ('Зал 5', 'Description', 20);

INSERT INTO film (name, description, film_time_minutes, rating, date_start, date_finish)
VALUES  ('Бесконечность', 'Эван узнает, что способен перерождаться, сохраняя свою личность. Фантастический боевик с Марком Уолбергом', 106, 4, '2021-08-23', '2022-03-31'),
        ('Брат', 'Дембель Данила Багров защищает слабых в Петербурге 1990-х. Фильм, сделавший Сергея Бодрова народным героем', 100, 5, '2022-03-24', '2022-05-31'),
        ('Анчартед: На картах не значится', 'Uncharted12', 115, 4, '2022-02-22', '2022-05-31');

INSERT INTO public.type_price (name, description, cost)
VALUES  ('VIP билеты', 'VIP билеты', 900.00),
        ('Дневной сеанс', 'Дневной сеанс', 200.00),
        ('Вечерний сеанс', 'Вечерний сеанс', 250.00),
        ('Студенческий', 'Студенческий', 170.00),
        ('Скидка 10%', 'Акция 10%', 180.00),
        ('Бесплатный', 'Акция невиданной щедрости', 0.00);



--  GENERATIVE POOL

DO
$$
    BEGIN
        FOR i IN 1..1000000 LOOP
                INSERT INTO price_history (type_price_id, date_time, price)
                VALUES (
                           (SELECT (random() * 4 + 1)::int),
                           now() - i * interval '1 minutes',
                           (SELECT random() * 800 + 1)
                       );
            END LOOP;
    END;
$$;


DO
$$
    BEGIN
        FOR i IN 1..1000000 LOOP
                INSERT INTO cinema_sessions (date_time_start, cinema_hall_id, film_id)
                VALUES (
                               now() - i * interval '10 minutes',
                               (SELECT (random() * 5 + 1)::int),
                               (SELECT (random() * 2 + 1)::int)
                       );
            END LOOP;
    END;
$$;


DO
$$
    DECLARE myvar integer;
    BEGIN
        SELECT (SELECT max(id) - 1 FROM cinema_sessions) INTO myvar;

        FOR i IN 1..(SELECT count(id) FROM price_history) LOOP
            INSERT INTO cinema_hall_place (cinema_session_id)
            VALUES (
               (SELECT (random() * myvar + 1)::int)
            );

        END LOOP;
    END;
$$;


DO
$$
    BEGIN
        FOR i IN 1..(SELECT count(id) FROM price_history) LOOP
                INSERT INTO tickets (cinema_hall_place_id, price_history_id)
                VALUES (
                           (SELECT id from cinema_hall_place LIMIT 1 OFFSET i - 1),
                           (SELECT id from price_history LIMIT 1 OFFSET i - 1)
                       );
            END LOOP;
    END;
$$;




-- -- FOREIGN KEYS

-- ALTER TABLE "cinema_hall_place" ADD CONSTRAINT "cinema_hall_place_fk0" FOREIGN KEY ("cinema_session_id") REFERENCES "cinema_sessions" ("id");
--
-- ALTER TABLE "cinema_sessions" ADD CONSTRAINT "cinema_sessions_fk0" FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_hall" ("id");
-- ALTER TABLE "cinema_sessions" ADD CONSTRAINT "cinema_sessions_fk1" FOREIGN KEY ("film_id") REFERENCES "film" ("id");
--
-- ALTER TABLE "tickets" ADD CONSTRAINT "tickets_fk0" FOREIGN KEY ("cinema_hall_place_id") REFERENCES "cinema_hall_place" ("id");
-- ALTER TABLE "tickets" ADD CONSTRAINT "tickets_fk1" FOREIGN KEY ("price_history_id") REFERENCES "price_history" ("id");
--
--  ALTER TABLE "price_history" ADD CONSTRAINT "price_history_fk0" FOREIGN KEY ("type_price_id") REFERENCES "type_price" ("id");