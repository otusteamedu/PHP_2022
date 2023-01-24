//Заполнение films тестовыми данными.
INSERT INTO films (id, title, description)
SELECT id, md5(random()::text), md5(random()::text)
FROM generate_series(4, 10000) id;

//Заполнение type_attribute тестовыми данными.
INSERT INTO type_attribute  (id, name_type)
SELECT id, md5(random()::text)
FROM generate_series(6, 10000) id;

//Заполнение attributes тестовыми данными.
INSERT INTO attributes  (id, id_type, name_attribute)
SELECT id, (random()*(5-1)+1), md5(random()::text)
FROM generate_series(5, 10000) id;

//Заполнение values тестовыми данными.
INSERT INTO values (id, id_attribute, id_film, value_string)
SELECT id, 1, random()*(10000-1)+1, md5(random()::text)
    FROM generate_series(11, 2000) id;
INSERT INTO values (id, id_attribute, id_film, value_bool)
SELECT id, 2, random()*(10000-1)+1, RANDOM()::INT::BOOLEAN
    FROM generate_series(2001, 4000) id;
INSERT INTO values (id, id_attribute, id_film, value_date)
SELECT id, 3, random()*(10000-1)+1, cast(now() - '1 year'::interval * random())
    FROM generate_series(4001, 600) id;
INSERT INTO values (id, id_attribute, id_film, value_int)
SELECT id, 5, random()*(10000-1)+1, RANDOM()::INT
FROM generate_series(8001, 10000) id;

