DO
    $$
        DECLARE

            generate_count_films integer := 1000000;
            generate_count_film_attributes integer := 1000000;
            generate_count_film_attribute_values integer := 1000000;

            film_attribute_id integer := 0;
            film_attribute_type varchar := '';
            film_id integer := 0;

        BEGIN
            TRUNCATE films RESTART IDENTITY CASCADE;
            TRUNCATE film_attribute_types RESTART IDENTITY CASCADE;
            TRUNCATE film_attributes RESTART IDENTITY CASCADE;
            TRUNCATE film_attribute_values RESTART IDENTITY CASCADE;

            INSERT INTO film_attribute_types(type, title)
            VALUES ('text', 'Текст'),
                   ('date', 'Дата'),
                   ('boolean', 'Да/Нет'),
                   ('integer', 'Число'),
                   ('float', 'Число с пллавующей точкой');

            FOR i IN 1..generate_count_films LOOP
                INSERT INTO films (title, rating,  release_date)
                VALUES
                    (concat('film-',  random_string(3)),
                     random_between(1, 10)::integer,
                     NOW() + (random() * (NOW()+'-30 year' - NOW())) + '-1 day'
                     );
            END LOOP;


            FOR i IN 1..generate_count_film_attributes LOOP
                INSERT INTO film_attributes (film_type_id, title)
                    VALUES (random_between(1, 5)::integer,concat('attribute-', random_string(50))  );
            END LOOP;

            FOR i IN 1..generate_count_film_attribute_values LOOP

                film_id := random_between(1, generate_count_films)::integer;
                film_attribute_id := random_between(1, generate_count_film_attributes)::integer;

                SELECT fat.type INTO film_attribute_type
                    FROM film_attributes as fa JOIN film_attribute_types fat on fat.id = fa.film_type_id
                        WHERE fa.id = film_attribute_id;

                CASE
                    WHEN film_attribute_type = 'text' THEN
                        INSERT INTO film_attribute_values (film_id, attribute_id, value)
                            VALUES (film_id, film_attribute_id, concat('value-', random_string(3)));
                    WHEN film_attribute_type = 'date' THEN
                        INSERT INTO film_attribute_values (film_id, attribute_id, value_date)
                            VALUES (film_id, film_attribute_id, cast(now() - '1 year'::interval * random()  as date ));
                    WHEN film_attribute_type = 'boolean' THEN
                        INSERT INTO film_attribute_values (film_id, attribute_id, value_boolean)
                            VALUES (film_id, film_attribute_id, (round(random())::int)::boolean);
                    WHEN film_attribute_type = 'integer' THEN
                        INSERT INTO film_attribute_values (film_id, attribute_id, value_int)
                            VALUES (film_id, film_attribute_id, random_int(4)::int);
                    WHEN film_attribute_type = 'float' THEN
                        INSERT INTO film_attribute_values (film_id, attribute_id, value_float)
                            VALUES (film_id, film_attribute_id, (random() + random_int(4))::float);
                    ELSE
                END CASE;
            END LOOP;

        END;
    $$;
