-- 1. DML

-- Страны
INSERT INTO public.country
    (title, status)
VALUES
    ('Россия', true),
    ('Индия', true),
    ('Китай', true);

-- Жанры
INSERT INTO public.genre
    (title, status)
VALUES
    ('Боевик', true),
    ('Комедия', true),
    ('Ужасы', true),
    ('Фантастика', true),
    ('Мелодрама', true);

-- Залы
INSERT INTO public.hall
    (title, status)
VALUES
    ('Зал 1', true),
    ('Зал 2', true),
    ('Зал 3', true),
    ('Зал 4', true),
    ('Зал 5', true),
    ('Зал 6', true),
    ('Зал 7', true);

-- Ограничения
INSERT INTO public.restriction
    (title, status)
VALUES
    ('0+', true),
    ('6+', true),
    ('12+', true),
    ('16+', true),
    ('18+', true);

DO
$$
	DECLARE
		row_number_max integer := 20;
		seat_number_max integer := 35;
		max_record_count_customer integer := 10000;
		max_record_count_movie integer := 100;
		t_hall record;
	BEGIN

-- Схемы залов
        FOR t_hall IN (SELECT id FROM hall) LOOP
            FOR i IN 1..row_number_max LOOP
                FOR j IN 1..seat_number_max LOOP
                    INSERT INTO public.hall_scheme
                        (hall_id, row_number, seat_number)
                    VALUES
                        (t_hall.id, i, j);
                END LOOP;
            END LOOP;	
        END LOOP;	

-- Клиенты
        FOR i IN 1..max_record_count_customer LOOP
		    INSERT INTO public.customer
		        (firstname, lastname, status)
		    VALUES
			    ((substr(md5(random()::text)::text, 0, 15)), (substr(md5(random()::text)::text, 0, 15)), true);
		END LOOP;

-- Фильмы
		FOR i IN 1..max_record_count_movie LOOP
		    INSERT INTO public.movie
		        (title, status, description, country_id, restriction_id, genre_id, release_date, image_url, duration)
			VALUES(
				(substr(md5(random()::text)::text, 0, 15)), 
				true, 
				(substr(md5(random()::text)::text, 0, 15)), 
				(select random_in_range(1, 3)), 
                (select random_in_range(1, 5)),
                (select random_in_range(1, 5)),
				((timestamp '2023-01-01 20:00:00' +
			       random() * (timestamp '2023-03-31 20:00:00' -
			                   timestamp '2023-01-01 10:00:00'))::date), 
				'https://image-test.com/' || substr(md5(random()::text)::text, 0, 15) || '.png', 
                (select random_in_range(80, 120))
			);
		END LOOP;
	END;
$$


-- 1.1 DML на 1000 сеансов и 10000 записей билетов
DO
$$
	DECLARE
		max_record_count_session integer := 1000;
		max_record_count_ticket integer := 100000;
		max_record_count_customer integer := 0;
		max_record_count_movie integer := 0;
		insert_count integer := 0;
		step_n integer := 0;
        t_session record;
	BEGIN

		max_record_count_movie := (SELECT COUNT(id) FROM public."movie");

-- Сеансы    
		WHILE (step_n < max_record_count_session) LOOP
			INSERT INTO public."session"
				(hall_id, movie_id, start_time, price, status)
			VALUES(
                (select random_in_range(1, 7)),
                (select random_in_range(1, max_record_count_movie)),
				(((date '2023-01-01' + floor( random() * (date '2023-03-31' - date '2023-01-01' + 1) )::integer)::character varying
					|| ' ' || (round(random() * (24 - 1) + 1)) || ':00:00')::character varying)::timestamp,
                (select random_in_range(1, 10) * 100), 
			    true
			)
			ON CONFLICT DO NOTHING;
			GET DIAGNOSTICS insert_count = ROW_COUNT;
			IF (insert_count > 0) THEN
				step_n := step_n + 1;
			END IF;
		END LOOP;
	        
		insert_count := 0;
		step_n := 0;
		max_record_count_customer := (SELECT COUNT(id) FROM public."customer");

-- Билеты	
		WHILE (step_n < max_record_count_ticket) LOOP
			FOR t_session IN SELECT id, price, start_time
				FROM session
				WHERE id >= (
					SELECT random_in_range(
						(SELECT min(id) FROM session),
						(SELECT max(id) FROM session)
					)
				)
				ORDER BY id ASC
				LIMIT 1
			LOOP
				INSERT INTO public.ticket
					(code, customer_id, session_id, hall_scheme_id, total, created_at)
				VALUES(
					(substr(md5(random()::text)::text, 0, 10)), 
	                (select random_in_range(1, max_record_count_customer)),
					t_session.id, 
	                (select random_in_range(1, 4900)),
					t_session.price, 
					t_session.start_time - make_interval(days => random_in_range(0, 5))
				)
				ON CONFLICT DO NOTHING;
				GET DIAGNOSTICS insert_count = ROW_COUNT;
				IF (insert_count > 0) THEN
					step_n := step_n + 1;
				END IF;
			END LOOP;
		END LOOP;
	END;
$$

-- 1.2 DML на 100000 сеансов и 10000000 записей билетов
DO
$$
	DECLARE
		max_record_count_session integer := 100000;
		max_record_count_ticket integer := 10000000;
		max_record_count_customer integer := 0;
		max_record_count_movie integer := 0;
		insert_count integer := 0;
		step_n integer := 0;
        t_session record;
	BEGIN

		max_record_count_movie := (SELECT COUNT(id) FROM public."movie");
        step_n := (SELECT COUNT(id) FROM public."session");

-- Сеансы    
		WHILE (step_n < max_record_count_session) LOOP
			INSERT INTO public."session"
				(hall_id, movie_id, start_time, price, status)
			VALUES(
                (select random_in_range(1, 7)),
                (select random_in_range(1, max_record_count_movie)),
				(((date '2023-01-01' + floor( random() * (date '2023-03-31' - date '2023-01-01' + 1) )::integer)::character varying
					|| ' ' || (round(random() * (24 - 1) + 1)) || ':00:00')::character varying)::timestamp,
                (select random_in_range(1, 10) * 100), 
			    true
			)
			ON CONFLICT DO NOTHING;
			GET DIAGNOSTICS insert_count = ROW_COUNT;
			IF (insert_count > 0) THEN
				step_n := step_n + 1;
			END IF;
		END LOOP;
	        
		insert_count := 0;
		step_n := (SELECT COUNT(id) FROM public.ticket);
		max_record_count_customer := (SELECT COUNT(id) FROM public."customer");

-- Билеты	
		WHILE (step_n < max_record_count_ticket) LOOP
			FOR t_session IN SELECT id, price, start_time
				FROM session
				WHERE id >= (
					SELECT random_in_range(
						(SELECT min(id) FROM session),
						(SELECT max(id) FROM session)
					)
				)
				ORDER BY id ASC
				LIMIT 1
			LOOP
				INSERT INTO public.ticket
					(code, customer_id, session_id, hall_scheme_id, total, created_at)
				VALUES(
					(substr(md5(random()::text)::text, 0, 10)), 
	                (select random_in_range(1, max_record_count_customer)),
					t_session.id, 
	                (select random_in_range(1, 4900)),
					t_session.price, 
					t_session.start_time - make_interval(days => random_in_range(0, 5))
				)
				ON CONFLICT DO NOTHING;
				GET DIAGNOSTICS insert_count = ROW_COUNT;
				IF (insert_count > 0) THEN
					step_n := step_n + 1;
				END IF;
			END LOOP;
		END LOOP;
	END;
$$