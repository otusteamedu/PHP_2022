do $$
    declare
        rows_num integer := 10000; -- Суммарное кол-во записей с текстовым полем в hall, movie и movie_attribute_value
        movie_id integer := 0;
        hall_id integer := 0;
        reviews_attr_id integer := 0;
        halls_and_movies_num integer := 0;
        reviews_per_movie integer := 0;

    begin
        truncate session cascade;
        truncate hall cascade;
        truncate movie cascade;
        truncate movie_attribute_type cascade;
        truncate movie_attribute cascade;
        truncate movie_attribute_value cascade;
        halls_and_movies_num := floor(rows_num*0.2);
        reviews_per_movie := floor(rows_num*0.6/halls_and_movies_num);

        insert into movie_attribute_type (type) values ('text');
        insert into movie_attribute (name, type) VALUES ('reviews', 'text') returning id into reviews_attr_id;

        for i in 1..halls_and_movies_num loop
                insert into hall (name, number_of_seats) values (random_string(10), floor(random()*1000)) RETURNING id into hall_id;

                insert into movie (name) values(random_string(10)) RETURNING id into movie_id;

                insert into movie_attribute_value (attribute_id, movie_id, value_text)
                select reviews_attr_id, movie_id, random_string(10) from generate_series(1, reviews_per_movie) as n;

                for i in 1..floor(random()*5) loop
                        insert into session (hall_id, movie_id, start_time, price) VALUES (hall_id, movie_id, now() + trunc(random()*1000) * '1 hour'::interval, random()*1000);
                    end loop;
            end loop;
    end;
$$;
