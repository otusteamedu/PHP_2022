do $$
    declare
        rows_num integer := 10000; -- Суммарное кол-во записей с текстовым полем в hall, movie и movie_attribute_value
        movie_id integer := 0;
        hall_id integer := 0;
        reviews_attr_id integer := 0;

    begin
        truncate hall cascade;
        truncate movie cascade;
        truncate session cascade;
        truncate movie_attribute_type cascade;
        truncate movie_attribute cascade;

        insert into movie_attribute_type (type) values ('text');
        insert into movie_attribute (name, type) VALUES ('reviews', 'text') returning id into reviews_attr_id;

        for i in 1..rows_num*0.1 loop
                insert into hall (name, number_of_seats) values (random_string(50), floor(random()*1000)) RETURNING id into hall_id;

                insert into movie (name) values(random_string(50)) RETURNING id into movie_id;

                for j in 1..floor(rows_num*0.0008) loop
                        insert into movie_attribute_value (attribute_id, movie_id, value_text) values (reviews_attr_id, movie_id, random_string(50));
                    end loop;

                for i in 1..floor(random()*10) loop
                        insert into session (hall_id, movie_id, start_time, price) VALUES (hall_id, movie_id, now() + trunc(random()*1000) * '1 hour'::interval, random()*1000);
                    end loop;
            end loop;
    end;
$$;
