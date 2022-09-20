/* Логирование */
CREATE OR REPLACE PROCEDURE prn(IN tbl VARCHAR, IN txt VARCHAR)
    LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO log (tbl, txt) VALUES (tbl, txt);
END;
$$;

/* Генерирует случайное логическое значение */
CREATE OR REPLACE PROCEDURE get_random_value_bool(INOUT random_value_bool BOOLEAN)
    LANGUAGE plpgsql
AS $$
DECLARE
    random_value DECIMAL;
BEGIN
    random_value := round(random());
    IF random_value = 0 THEN
        random_value_bool = false;
    ELSE
        random_value_bool = true;
    END IF;
END;
$$;

/* Генерирует случайную дату в диапазоне от текущей даты до текущая дата + 30 дней */
CREATE OR REPLACE PROCEDURE get_random_value_date(INOUT random_value_date DATE)
    LANGUAGE plpgsql
AS $$
BEGIN
    random_value_date := current_date + round(random() * 30)::INTEGER;
END;
$$;

/* Генерирует случайную строку */
CREATE OR REPLACE PROCEDURE get_random_value_text(INOUT random_value_text VARCHAR)
    LANGUAGE plpgsql
AS $$
BEGIN
    random_value_text := 'Random text ' || round(random() * 10000000)::INTEGER;
END;
$$;

/* Генерирует массив случайных строк */
CREATE OR REPLACE PROCEDURE get_random_value_array_text(INOUT random_value_array_text VARCHAR[])
    LANGUAGE plpgsql
AS $$
DECLARE
    count_values INT;
    random_value_text VARCHAR;
BEGIN
    count_values = round(random() * 10)::INTEGER;
    FOR i IN 1..count_values LOOP
        CALL get_random_value_text(random_value_text);
        random_value_array_text := array_append(random_value_array_text, random_value_text);
    END LOOP;
END;
$$;

/* Добавляет фильмы */
CREATE OR REPLACE PROCEDURE insert_films()
    LANGUAGE plpgsql
AS $$
DECLARE
    count_films INT;
BEGIN
    INSERT INTO film (name) VALUES ('Иван Васильевич меняет профессию'),
                                   ('Зеленая миля'),
                                   ('Побег из Шоушенка'),
                                   ('Бриллиантовая рука'),
                                   ('Джентльмены удачи'),
                                   ('Москва слезам не верит'),
                                   ('Служебный роман'),
                                   ('Собачье сердце'),
                                   ('Начало'),
                                   ('Титаник'),
                                   ('Властелин колец: Возвращение короля'),
                                   ('Властелин колец: Две крепости'),
                                   ('Властелин колец: Братство кольца');

    SELECT count(*) FROM film INTO count_films;
    CALL prn('film', 'Добавлено: ' || count_films || ' фильмов');
END;
$$;

/* Добавляет типы атрибутов */
CREATE OR REPLACE PROCEDURE insert_attribute_types(IN attribute_types VARCHAR ARRAY)
    LANGUAGE plpgsql
AS $$
DECLARE
    attribute_type_name VARCHAR;
    count_attribute_types INT;
BEGIN
    FOREACH attribute_type_name IN ARRAY attribute_types LOOP
        INSERT INTO attribute_type (name) VALUES (attribute_type_name);
    END LOOP;

    SELECT count(*) FROM attribute_type INTO count_attribute_types;
    CALL prn('attribute_type', 'Добавлено: ' || count_attribute_types || ' типов атрибутов');
END;
$$;

/* Добавляет атрибуты */
CREATE OR REPLACE PROCEDURE insert_attributes(IN attribute_types VARCHAR ARRAY, IN attributes VARCHAR ARRAY)
    LANGUAGE plpgsql
AS $$
DECLARE
    count_attributes INT;
    count_attribute_types INT := array_length(attribute_types, 1);
    attribute_type_id INT;
    count_attributes_in_one_attribute_type INT;
BEGIN
    FOR i IN 1..count_attribute_types LOOP
        SELECT id FROM attribute_type WHERE name = attribute_types[i] INTO attribute_type_id;

        count_attributes_in_one_attribute_type := array_length(attributes[1:1], 2);
        FOR j IN 1..count_attributes_in_one_attribute_type LOOP
            INSERT INTO attribute (name, attribute_type_id, value_field_name)
            VALUES (attributes[i][j][1]::VARCHAR, attribute_type_id, attributes[i][j][2]::VARCHAR);
        END LOOP;
    END LOOP;

    SELECT count(*) FROM attribute INTO count_attributes;
    CALL prn('attribute', 'Добавлено: ' || count_attributes || ' атрибутов');
END;
$$;

/* Добавляет значения атрибутов */
CREATE OR REPLACE PROCEDURE insert_attribute_values(IN attribute_types VARCHAR ARRAY, IN attributes VARCHAR ARRAY)
    LANGUAGE plpgsql
AS $$
DECLARE
    count_attribute_values INT;
    film_id INT;
    attribute_rec RECORD;
    random_value_bool BOOLEAN;
    random_value_date DATE;
    random_value_text VARCHAR;
    random_value_array_text VARCHAR[];
BEGIN
    FOR film_id IN SELECT id FROM film LOOP
        FOR attribute_rec IN SELECT * FROM attribute LOOP
            IF attribute_rec.name = 'Рецензии критиков' THEN
                CALL get_random_value_array_text(random_value_array_text);
                CALL insert_attribute_value(film_id, attribute_rec.id, random_value_array_text);
                random_value_array_text := ARRAY[]::VARCHAR[];

            ELSEIF attribute_rec.value_field_name = 'value_text' THEN
                CALL get_random_value_text(random_value_text);
                CALL insert_attribute_value(film_id, attribute_rec.id, random_value_text);

            ELSEIF attribute_rec.value_field_name = 'value_date' THEN
                CALL get_random_value_date(random_value_date);
                CALL insert_attribute_value(film_id, attribute_rec.id, random_value_date);

            ELSEIF attribute_rec.value_field_name = 'value_bool' THEN
                CALL get_random_value_bool(random_value_bool);
                CALL insert_attribute_value(film_id, attribute_rec.id, random_value_bool);
            END IF;
        END LOOP;
    END LOOP;

    SELECT count(*) FROM attribute_value INTO count_attribute_values;
    CALL prn('attribute_value', 'Добавлено: ' || count_attribute_values || ' значений атрибутов');
END;
$$;


DO $$
    DECLARE
        attribute_types VARCHAR ARRAY := ARRAY[
            'Рецензии',
            'Премии',
            'Важные даты',
            'Служебные даты'
        ];
        attributes VARCHAR ARRAY := ARRAY[
            ARRAY[
                ARRAY['Рецензии критиков', 'value_text'],
                ARRAY['Отзыв неизвестной киноакадемии', 'value_text']
            ],
            ARRAY[
                ARRAY['Оскар', 'value_bool'],
                ARRAY['Ника', 'value_bool']
            ],
            ARRAY[
                ARRAY['Мировая премьера', 'value_date'],
                ARRAY['Премьера в РФ', 'value_date']
            ],
            ARRAY[
                ARRAY['Дата начала продажи билетов', 'value_date'],
                ARRAY['Когда запускать рекламу на ТВ', 'value_date']
            ]
        ];
    BEGIN
        CALL insert_films();
        CALL insert_attribute_types(attribute_types);
        CALL insert_attributes(attribute_types, attributes);
        CALL insert_attribute_values(attribute_types, attributes);
    END;
$$;
