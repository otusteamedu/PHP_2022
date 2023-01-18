DO
$$
    DECLARE
        count_movie                 INT := 2500000;
        count_movie_attribute_type  INT := 2500000;
        count_movie_attribute       INT := 2500000;
        count_movie_attribute_value INT := 2500000;
    BEGIN
        TRUNCATE movie RESTART IDENTITY CASCADE;

        INSERT INTO movie (name)
        SELECT random_string((1 + random() * 10):: INT)
        FROM generate_series(1, count_movie);


        TRUNCATE movie_attribute_type RESTART IDENTITY CASCADE;

        INSERT INTO movie_attribute_type (name, type)
        SELECT random_string((1 + random() * 10):: INT),
               random_type()
        FROM generate_series(1, count_movie_attribute_type);


        TRUNCATE movie_attribute RESTART IDENTITY CASCADE;

        INSERT INTO movie_attribute (name, movie_attribute_type_id)
        SELECT random_string((1 + random() * 10):: INT),
               random_range(1, count_movie_attribute_type)
        FROM generate_series(1, count_movie_attribute);


        TRUNCATE movie_attribute_value RESTART IDENTITY CASCADE;

        FOR i IN 1..count_movie_attribute_value
            LOOP
                DECLARE
                    rand_movie_id             INT           := random_range(1, count_movie)::INT;
                    rand_movie_attribute_id   INT           := random_range(1, count_movie_attribute)::INT;
                    rand_movie_attribute_type VARCHAR(3000) := (SELECT mat.type
                                                                FROM movie_attribute as ma
                                                                         JOIN movie_attribute_type mat on mat.id = ma.movie_attribute_type_id
                                                                WHERE ma.id = rand_movie_attribute_id)::VARCHAR(3000);
                BEGIN
                    CASE
                        WHEN rand_movie_attribute_type = 'int'
                            THEN INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, value_int)
                                 VALUES (rand_movie_id,
                                         rand_movie_attribute_id,
                                         random_range(1, 1000)::INT);
                        WHEN rand_movie_attribute_type = 'bool'
                            THEN INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, value_bool)
                                 VALUES (rand_movie_id,
                                         rand_movie_attribute_id,
                                         (round(random())::INT)::BOOL);
                        WHEN rand_movie_attribute_type = 'date'
                            THEN INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, value_date)
                                 VALUES (rand_movie_id,
                                         rand_movie_attribute_id,
                                         to_timestamp(random_range(power(10, 8)::INT, power(10, 9)::INT))::DATE);
                        WHEN rand_movie_attribute_type = 'string'
                            THEN INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, value_string)
                                 VALUES (rand_movie_id,
                                         rand_movie_attribute_id,
                                         random_string(10)::VARCHAR(3000));
                        WHEN rand_movie_attribute_type = 'float'
                            THEN INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, value_float)
                                 VALUES (rand_movie_id,
                                         rand_movie_attribute_id,
                                         random_range(1, 1000)::FLOAT);
                        ELSE
                        END CASE;
                END;
            END LOOP;
    END;
$$