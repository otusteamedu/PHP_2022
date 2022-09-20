/* Создание таблицы film (фильмы) */
CREATE TABLE film (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id));

/* Создание таблицы attribute_type (типы атрибутов) */
CREATE TABLE attribute_type (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id));

/* Создание таблицы attribute (атрибуты) */
CREATE TABLE attribute (
    id SERIAL NOT NULL,
    name VARCHAR(255) NOT NULL,
    attribute_type_id INT NOT NULL,
    /*multiple BOOLEAN DEFAULT FALSE,   атрибут имеет множество значений */
    value_field_name VARCHAR(255) NOT NULL, /* имя поля таблицы attribute_value, в котором хранятся значения данного типа атрибута */
    PRIMARY KEY(id)
);
CREATE INDEX attribute__attribute_type_id__ind ON attribute (attribute_type_id);
ALTER TABLE attribute ADD CONSTRAINT attribute__attribute_type_id__fk FOREIGN KEY (attribute_type_id) REFERENCES attribute_type (id);

/* Создание таблицы attribute_value (значения атрибутов) */
CREATE TABLE attribute_value (
    id INT NOT NULL, /*SERIAL NOT NULL,*/
    value_id INT NOT NULL,
    entity_id INT NOT NULL,
    attribute_id INT NOT NULL,
    value_int INT,
    value_text VARCHAR(2048),
    value_date DATE,
    value_bool BOOLEAN,
    PRIMARY KEY(id)
);
CREATE SEQUENCE attribute_value_id_seq AS INTEGER;
ALTER SEQUENCE attribute_value_id_seq OWNER TO "user";
ALTER SEQUENCE attribute_value_id_seq OWNED BY attribute_value.id;
CREATE INDEX attribute_value__attribute_id__ind ON attribute_value (attribute_id);
CREATE INDEX attribute_value__entity_id__ind ON attribute_value (entity_id);
CREATE INDEX attribute_value__value_id__ind ON attribute_value (value_id);
ALTER TABLE attribute_value ADD CONSTRAINT attribute_value__attribute_id__fk FOREIGN KEY (attribute_id) REFERENCES attribute (id);
ALTER TABLE attribute_value ADD CONSTRAINT attribute_value__entity_id__fk FOREIGN KEY (entity_id) REFERENCES film (id);

/* Создание таблицы log для отладки */
CREATE TABLE log (id SERIAL NOT NULL, tbl VARCHAR(100), txt VARCHAR(2048), PRIMARY KEY(id));
CREATE INDEX log__tbl__ind ON log (tbl);


/* Добавляет значение аттрибута типа int */
CREATE OR REPLACE PROCEDURE insert_attribute_value(IN entity_id INT, IN attribute_id INT, IN value INT)
    LANGUAGE plpgsql
AS $$
DECLARE
    seq_id INT;
BEGIN
    SELECT pg_catalog.nextval('attribute_value_id_seq') INTO seq_id;
    INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_int)
    VALUES (seq_id, seq_id, entity_id, attribute_id, value);
END;
$$;

/* Добавляет значение аттрибута типа varchar */
CREATE OR REPLACE PROCEDURE insert_attribute_value(IN entity_id INT, IN attribute_id INT, IN value VARCHAR)
    LANGUAGE plpgsql
AS $$
DECLARE
    seq_id INT;
BEGIN
    SELECT pg_catalog.nextval('attribute_value_id_seq') INTO seq_id;
    INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_text)
    VALUES (seq_id, seq_id, entity_id, attribute_id, value);
END;
$$;

/* Добавляет значение аттрибута типа date */
CREATE OR REPLACE PROCEDURE insert_attribute_value(IN entity_id INT, IN attribute_id INT, IN value DATE)
    LANGUAGE plpgsql
AS $$
DECLARE
    seq_id INT;
BEGIN
    SELECT pg_catalog.nextval('attribute_value_id_seq') INTO seq_id;
    INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_date)
    VALUES (seq_id, seq_id, entity_id, attribute_id, value);
END;
$$;

/* Добавляет значение аттрибута типа bool */
CREATE OR REPLACE PROCEDURE insert_attribute_value(IN entity_id INT, IN attribute_id INT, IN value BOOLEAN)
    LANGUAGE plpgsql
AS $$
DECLARE
    seq_id INT;
BEGIN
    SELECT pg_catalog.nextval('attribute_value_id_seq') INTO seq_id;
    INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_bool)
    VALUES (seq_id, seq_id, entity_id, attribute_id, value);
END;
$$;


/* Добавляет значения аттрибута типа int[] */
CREATE OR REPLACE PROCEDURE insert_attribute_value(IN entity_id INT, IN attribute_id INT, IN value INT[])
    LANGUAGE plpgsql
AS $$
DECLARE
    seq_id INT;
    value_id INT;
    count_values INT := array_length(value, 1);
BEGIN
    SELECT pg_catalog.nextval('attribute_value_id_seq') INTO value_id;

    FOR i IN 1..count_values LOOP
        IF i = 1 THEN
            INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_int)
            VALUES (value_id, value_id, entity_id, attribute_id, value[i]);
        ELSE
            SELECT pg_catalog.nextval('attribute_value_id_seq') INTO seq_id;
            INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_int)
            VALUES (seq_id, value_id, entity_id, attribute_id, value[i]);
        END IF;
    END LOOP;
END;
$$;

/* Добавляет значения аттрибута типа varchar[] */
CREATE OR REPLACE PROCEDURE insert_attribute_value(IN entity_id INT, IN attribute_id INT, IN value VARCHAR[])
    LANGUAGE plpgsql
AS $$
DECLARE
    seq_id INT;
    value_id INT;
    count_values INT := array_length(value, 1);
BEGIN
    SELECT pg_catalog.nextval('attribute_value_id_seq') INTO value_id;

    FOR i IN 1..count_values LOOP
        IF i = 1 THEN
            INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_text)
            VALUES (value_id, value_id, entity_id, attribute_id, value[i]);
        ELSE
            SELECT pg_catalog.nextval('attribute_value_id_seq') INTO seq_id;
            INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_text)
            VALUES (seq_id, value_id, entity_id, attribute_id, value[i]);
        END IF;
    END LOOP;
END;
$$;

/* Добавляет значения аттрибута типа date[] */
CREATE OR REPLACE PROCEDURE insert_attribute_value(IN entity_id INT, IN attribute_id INT, IN value DATE[])
    LANGUAGE plpgsql
AS $$
DECLARE
    seq_id INT;
    value_id INT;
    count_values INT := array_length(value, 1);
BEGIN
    SELECT pg_catalog.nextval('attribute_value_id_seq') INTO value_id;

    FOR i IN 1..count_values LOOP
        IF i = 1 THEN
            INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_date)
            VALUES (value_id, value_id, entity_id, attribute_id, value[i]);
        ELSE
            SELECT pg_catalog.nextval('attribute_value_id_seq') INTO seq_id;
            INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_date)
            VALUES (seq_id, value_id, entity_id, attribute_id, value[i]);
        END IF;
    END LOOP;
END;
$$;

/* Добавляет значения аттрибута типа bool[] */
CREATE OR REPLACE PROCEDURE insert_attribute_value(IN entity_id INT, IN attribute_id INT, IN value BOOLEAN[])
    LANGUAGE plpgsql
AS $$
DECLARE
    seq_id INT;
    value_id INT;
    count_values INT := array_length(value, 1);
BEGIN
    SELECT pg_catalog.nextval('attribute_value_id_seq') INTO value_id;

    FOR i IN 1..count_values LOOP
        IF i = 1 THEN
            INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_bool)
            VALUES (value_id, value_id, entity_id, attribute_id, value[i]);
        ELSE
            SELECT pg_catalog.nextval('attribute_value_id_seq') INTO seq_id;
            INSERT INTO attribute_value (id, value_id, entity_id, attribute_id, value_bool)
            VALUES (seq_id, value_id, entity_id, attribute_id, value[i]);
        END IF;
    END LOOP;
END;
$$;
