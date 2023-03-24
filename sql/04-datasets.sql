DO
$$
DECLARE
    -- movies --
    movie_count_rows INT = 3;
    movies_ids UUID[];
    -- attribute type --
    review_type_id UUID;
    award_type_id UUID;
    internal_date_id UUID;
    important_date_id UUID;
    -- attributes --
    attr_review_by_critics_id UUID;
    attr_academy_awards_id UUID;
    attr_nick_award_id UUID;
    attr_rf_remiere_id UUID;
    attr_world_premiere_id UUID;
    attr_ticket_sales_start_date_id UUID;
    attr_social_networks_adv_id UUID;
    attr_tv_adv_id UUID;
    -- attributes values --
    attr_world_premiere_values TEXT[];
BEGIN

    -- Типы атрибутов. --
    SELECT add_attribute_type('Рецензия') INTO review_type_id;
    SELECT add_attribute_type('Премия') INTO award_type_id;
    SELECT add_attribute_type('Служебная дата', 'DATE') INTO internal_date_id;
    SELECT add_attribute_type('Важная дата', 'DATE') INTO important_date_id;

    -- Атрибуты. --
    SELECT add_attribute('Рецензия критиков', review_type_id) INTO attr_review_by_critics_id;
    SELECT add_attribute('Оскар', award_type_id) INTO attr_academy_awards_id;
    SELECT add_attribute('Ника', award_type_id) INTO attr_nick_award_id;
    SELECT add_attribute('Премьера в РФ', important_date_id) INTO attr_rf_remiere_id;
    SELECT add_attribute('Мировая премьера', important_date_id) INTO attr_world_premiere_id;
    SELECT add_attribute('Начало продажи билетов', internal_date_id) INTO attr_ticket_sales_start_date_id;
    SELECT add_attribute('Реклама в соцсетях', internal_date_id) INTO attr_social_networks_adv_id;
    SELECT add_attribute('Реклама на ТВ', internal_date_id) INTO attr_tv_adv_id;

    -- Фильмы. --
    WITH src AS (
        INSERT INTO movies (title)
        SELECT CONCAT('Санта-Барбара: ', series, '-серия')
        FROM GENERATE_SERIES(1, movie_count_rows) AS series
        RETURNING id
    )
    SELECT array_agg(id)
    FROM src
    INTO movies_ids;

    -- Мировые премьеры --
    SELECT array_agg(series::DATE::TEXT)
    FROM GENERATE_SERIES(CURRENT_DATE - ((movie_count_rows - 1) || ' days')::INTERVAL, CURRENT_DATE, INTERVAL '1 day') AS series
    INTO attr_world_premiere_values;

    FOR i IN 1..movie_count_rows
    LOOP
        INSERT INTO attributes_values(entity_id, attribute_id, text_value)
        VALUES (movies_ids[i], attr_world_premiere_id, attr_world_premiere_values[i]);
    END LOOP;

    -- Дата начала продажи билетов. --
    FOR i IN 1..movie_count_rows
    LOOP
        INSERT INTO attributes_values(entity_id, attribute_id, text_value)
        VALUES (movies_ids[i], attr_ticket_sales_start_date_id, (CURRENT_DATE - ((i - 1) || ' days')::INTERVAL)::DATE::TEXT);
    END LOOP;

    -- Даты запуска рекламы - соцсети/тв. --
    INSERT INTO attributes_values(entity_id, attribute_id, text_value)
    VALUES (movies_ids[1], attr_tv_adv_id, CURRENT_DATE::TEXT),
           (movies_ids[1], attr_social_networks_adv_id, (CURRENT_DATE + INTERVAL '20 days')::DATE::TEXT),
           (movies_ids[2], attr_social_networks_adv_id, CURRENT_DATE::TEXT),
           (movies_ids[3], attr_social_networks_adv_id, (CURRENT_DATE + INTERVAL '20 days')::DATE::TEXT);

END;
$$ language plpgsql;
