-- Добавить тип атрибута. --
CREATE OR REPLACE FUNCTION add_attribute_type(
    at_title TEXT,
    at_type TEXT DEFAULT 'TEXT'
) RETURNS UUID AS $$
DECLARE at_id UUID;
BEGIN

    at_id = (SELECT id FROM attributes_type WHERE title = at_title);

    IF (at_id IS NULL) THEN
        INSERT INTO attributes_type (title, type)
        VALUES (at_title, at_type)
        RETURNING id INTO at_id;
    END IF;

    RETURN at_id;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION add_attribute_type IS 'Добавить тип атрибута.';

-- Добавить атрибут. --
CREATE OR REPLACE FUNCTION add_attribute(
    a_title TEXT,
    at_id UUID
) RETURNS UUID AS $$
DECLARE
    a_id UUID;
BEGIN

    a_id = (SELECT id FROM attributes WHERE title = a_title AND type_id = at_id);

    IF (a_id IS NULL) THEN
        INSERT INTO attributes (title, type_id)
        VALUES (a_title, at_id)
        RETURNING id INTO a_id;
    END IF;

    RETURN a_id;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION add_attribute IS 'Добавить атрибут.';

-- Задачи на сегодня. --
CREATE OR REPLACE FUNCTION today_movies_tasks(movies) RETURNS TEXT AS $$
BEGIN
    RETURN (
        SELECT string_agg(a.title, ', ')
        FROM attributes_values AS v
            LEFT JOIN attributes AS a ON v.attribute_id = a.id
            LEFT JOIN attributes_type AS t ON a.type_id = t.id
        WHERE v.entity_id = $1.id AND
              v.text_value = CURRENT_DATE::TEXT AND
              t.title = 'Служебная дата'
    );
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION today_movies_tasks IS 'Задачи на сегодня.';

-- Задачи через 20 дней. --
CREATE OR REPLACE FUNCTION after_20_days_movies_tasks(movies) RETURNS TEXT AS $$
BEGIN
    RETURN (
        SELECT string_agg(a.title, ', ')
        FROM attributes_values AS v
            LEFT JOIN attributes AS a ON v.attribute_id = a.id
            LEFT JOIN attributes_type AS t ON a.type_id = t.id
        WHERE v.entity_id = $1.id AND
                v.text_value = (CURRENT_DATE + INTERVAL '20 days')::DATE::TEXT AND
                t.title = 'Служебная дата'
    );
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION after_20_days_movies_tasks IS 'Задачи через 20 дней.';
