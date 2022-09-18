CREATE OR REPLACE FUNCTION generate_customer_name() RETURNS TEXT LANGUAGE plpgsql AS
$$
    DECLARE
        name text[] := array['Августин', 'Арсен', 'Фаддей', 'Вадим', 'Давид', 'Павел', 'Гавриил', 'Михаил', 'Сергей', 'Митрофан', 'Олег', 'Оливер', 'Мартин', 'Марат', 'Модест', 'Лукьян', 'Николай', 'Роберт', 'Роман'];
    BEGIN
        RETURN (name::text[])[ceil(random()*array_length(name::text[], 1))];
    END
$$;

CREATE OR REPLACE FUNCTION generate_customer_surname() RETURNS TEXT LANGUAGE plpgsql AS
$$
    DECLARE
        surname text[] := array['Поляков', 'Лазарев', 'Никитин', 'Зуев', 'Быков', 'Моисеев', 'Елисеев', 'Кабанов', 'Калашников', 'Якушев', 'Богданов', 'Дорофеев', 'Калинин', 'Петухов', 'Анисимов', 'Антонов', 'Беляев', 'Макаров', 'Андреев'];
    BEGIN
        RETURN (surname::text[])[ceil(random()*array_length(surname::text[], 1))];
    END
$$;

CREATE OR REPLACE FUNCTION generate_customer_email() RETURNS TEXT LANGUAGE plpgsql AS
$$
    DECLARE
        domain_name text[] := array['polyakov', 'lazarev', 'nikitin', 'zyev', 'bykov', 'moiseev', 'eliseev', 'kabanov', 'kalashnikov', 'yakyshev', 'bogdanov', 'dorofeev', 'kalinin', 'petyhov', 'anisimov', 'antonov', 'belyiev', 'makarov', 'andreev'];
        email_domain text[] := array['mail.ru', 'yandex.ru', 'yahoo.com', 'gmail.com', 'test.com', 'super.ru', 'brit.ua'];
    BEGIN
        RETURN (domain_name::text[])[ceil(random()*array_length(domain_name::text[], 1))] || '@' || (email_domain::text[])[ceil(random()*array_length(email_domain::text[], 1))];
    END
$$;

CREATE OR REPLACE FUNCTION generate_customer_phonenumber() RETURNS TEXT LANGUAGE plpgsql AS
$$
    DECLARE
        number_1 int := floor(random() * 9 + 1)::int;
        number_2 int := floor(random() * 9 + 1)::int;
        number_3 int := floor(random() * 9 + 1)::int;
        number_4 int := floor(random() * 9 + 1)::int;
        number_5 int := floor(random() * 9 + 1)::int;
        number_6 int := floor(random() * 9 + 1)::int;
        number_7 int := floor(random() * 9 + 1)::int;
        number_8 int := floor(random() * 9 + 1)::int;
        number_9 int := floor(random() * 9 + 1)::int;
        number_10 int := floor(random() * 9 + 1)::int;
    BEGIN
        RETURN '+7' || '-' || number_1 || number_2 || number_3 || '-' || number_4 || number_5 || number_6 || '-' || number_7 || number_8 || '-' || number_9 || number_10;
    END
$$;

CREATE OR REPLACE FUNCTION generate_movie_release_date() RETURNS DATE LANGUAGE plpgsql AS
$$
    BEGIN
        RETURN '2000-01-01'::timestamp + (random() * ('2000-01-01'::timestamp  + '3650 days' - '2000-01-01'::timestamp )) + '3650 days';
    END
$$;

CREATE OR REPLACE FUNCTION generate_date() RETURNS DATE LANGUAGE plpgsql AS
$$
    BEGIN
        IF random() < 0.5 THEN
            RETURN (now() - random() * (interval '181 days'))::timestamp::date;
        END IF;
        RETURN (now() + random() * (interval '184 days'))::timestamp::date;
    END
$$;

CREATE OR REPLACE FUNCTION generate_time() RETURNS TIME LANGUAGE plpgsql AS
$$
    BEGIN
        IF random() < 0.5 THEN
            RETURN (now() - random() * (interval '23 hours'))::timestamp(0)::time without time zone;
        END IF;
        RETURN (now() + random() * (interval '24 hours'))::timestamp(0)::time without time zone;
    END
$$;

CREATE OR REPLACE FUNCTION generate_movie_name() RETURNS TEXT LANGUAGE plpgsql AS
$$
    DECLARE
        movie_name_first_part text[] := array['Битва', 'Бой', 'У камина', 'Память', 'Любовь', 'Ад', 'Рай', 'Дьявол', 'Детали', 'Весна', 'Лето', 'Осень', 'Зима', 'Настроение', 'Город', 'Ненависть', 'Расчет', 'Дети', 'Муж', 'Жена', 'Изгнание'];
        movie_name_second_part text[] := array['с тенью', 'на мосту', 'как жизнь', 'непонятное', 'уставший', 'на Луне', 'присутствия', 'других', 'радости', 'на заречной улице', 'как смерть', 'жизни', 'и голуби', 'на Земле', 'под мостом', 'носит прада', 'в деталях', 'и сын', 'с друзьями', 'из уст', 'дьявола'];
    BEGIN
        RETURN (movie_name_first_part::text[])[ceil(random()*array_length(movie_name_first_part::text[], 1))] || ' ' || (movie_name_second_part::text[])[ceil(random()*array_length(movie_name_second_part::text[], 1))];
    END;
$$;

CREATE OR REPLACE FUNCTION generate_movie_description(quantity integer) RETURNS TEXT LANGUAGE plpgsql AS
$$
    DECLARE
        words text[] := array['lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit', 'a', 'ac', 'accumsan', 'ad', 'aenean', 'aliquam', 'aliquet', 'ante', 'aptent', 'arcu', 'at', 'auctor', 'augue', 'bibendum', 'blandit', 'class', 'commodo', 'condimentum', 'congue', 'consequat', 'conubia', 'convallis', 'cras', 'cubilia', 'cum', 'curabitur', 'curae', 'cursus', 'dapibus', 'diam', 'dictum', 'dictumst', 'dignissim', 'dis', 'donec', 'dui', 'duis', 'egestas', 'eget', 'eleifend', 'elementum', 'enim', 'erat', 'eros', 'est', 'et', 'etiam', 'eu', 'euismod', 'facilisi', 'facilisis', 'fames', 'faucibus', 'felis', 'fermentum', 'feugiat', 'fringilla', 'fusce', 'gravida', 'habitant', 'habitasse', 'hac', 'hendrerit', 'himenaeos', 'iaculis', 'id', 'imperdiet', 'in', 'inceptos', 'integer', 'interdum', 'justo', 'lacinia', 'lacus', 'laoreet', 'lectus', 'leo', 'libero', 'ligula', 'litora', 'lobortis', 'luctus', 'maecenas', 'magna', 'magnis', 'malesuada', 'massa', 'mattis', 'mauris', 'metus', 'mi', 'molestie', 'mollis', 'montes', 'morbi', 'mus', 'nam', 'nascetur', 'natoque', 'nec', 'neque', 'netus', 'nibh', 'nisi', 'nisl', 'non', 'nostra', 'nulla', 'nullam', 'nunc', 'odio', 'orci', 'ornare', 'parturient', 'pellentesque', 'penatibus', 'per', 'pharetra', 'phasellus', 'placerat', 'platea', 'porta', 'porttitor', 'posuere', 'potenti', 'praesent', 'pretium', 'primis', 'proin', 'pulvinar', 'purus', 'quam', 'quis', 'quisque', 'rhoncus', 'ridiculus', 'risus', 'rutrum', 'sagittis', 'sapien', 'scelerisque', 'sed', 'sem', 'semper', 'senectus', 'sociis', 'sociosqu', 'sodales', 'sollicitudin', 'suscipit', 'suspendisse', 'taciti', 'tellus', 'tempor', 'tempus', 'tincidunt', 'torquent', 'tortor', 'tristique', 'turpis', 'ullamcorper', 'ultrices', 'ultricies', 'urna', 'ut', 'varius', 'vehicula', 'vel', 'velit', 'venenatis', 'vestibulum', 'vitae', 'vivamus', 'viverra', 'volutpat', 'vulputate'];
        return_value text := '';
        random integer;
        ind integer;
    BEGIN
        FOR ind IN 1 .. quantity LOOP
            ind := (random() * (array_upper(words, 1) - 1))::integer + 1;
            return_value := return_value || ' ' || words[ind];
        END LOOP;
        RETURN return_value;
    END
$$;

CREATE OR REPLACE FUNCTION generate_movie_duartion() RETURNS NUMERIC LANGUAGE plpgsql AS
$$
    BEGIN
        RETURN floor(random() * (215 - 120 + 1) + 120)::int;
    END
$$;

CREATE OR REPLACE FUNCTION generate_movie_price() RETURNS DECIMAL LANGUAGE plpgsql AS
$$
    BEGIN
        RETURN round((random() * (650.00 - 200.00 + 1) + 200.00)::decimal, 2);
    END
$$;

CREATE OR REPLACE FUNCTION generate_session_price() RETURNS DECIMAL LANGUAGE plpgsql AS
$$
    BEGIN
        RETURN round((random() * (65.00 - 20.00 + 1) + 20.00)::decimal, 2);
    END
$$;

CREATE OR REPLACE FUNCTION generate_schedule_date() RETURNS DATE LANGUAGE plpgsql AS
$$
    BEGIN
        RETURN '2020-01-01'::timestamp + (random() * ('2020-01-01'::timestamp  + '365 days' - '2020-01-01'::timestamp )) + '365 days';
    END
$$;