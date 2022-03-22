DELETE
FROM attr_film
WHERE film_id IS NOT NULL;
DELETE
FROM films
WHERE id IS NOT NULL;
DELETE
FROM attrs
WHERE id IS NOT NULL;
DELETE
FROM attr_types
WHERE id IS NOT NULL;
DELETE
FROM attr_names
WHERE id IS NOT NULL;

ALTER SEQUENCE films_id_seq RESTART;
ALTER SEQUENCE attrs_id_seq RESTART;
ALTER SEQUENCE attr_types_id_seq RESTART;
ALTER SEQUENCE attr_names_id_seq RESTART;

INSERT INTO films (name)
VALUES ('film_1'),
       ('film_2'),
       ('film_3');

INSERT INTO attr_types (value)
VALUES ('BOOL'),
       ('TEXT'),
       ('FLOAT'),
       ('TIMESTAMP');

INSERT INTO attr_names (value)
VALUES ('reviews'),
       ('is_premium'),
       ('world_premiere');

INSERT INTO attrs (attr_type_id, attr_name_id, text_value)
VALUES (2, 1, 'bad_1'),
       (2, 1, 'good_1');

INSERT INTO attrs (attr_type_id, attr_name_id, bool_value)
VALUES (1, 2, false),
       (1, 2, true);

INSERT INTO attrs (attr_type_id, attr_name_id, timestamp_value)
VALUES (4, 3, now() - interval '1 day'),
       (4, 3, now()),
       (4, 3, now() - interval '5 day');


INSERT INTO attr_film (film_id, attr_id)
VALUES (1, 1),
       (1, 3),
       (1, 5),
       (2, 2),
       (2, 4),
       (2, 6),
       (3, 2),
       (3, 4),
       (3, 7)
;
