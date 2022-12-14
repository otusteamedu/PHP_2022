CREATE VIEW marketing_data AS
    SELECT
        film.name, move_attribute.name AS move_attribute, move_attribute_type.name AS move_attribute_type,
        CASE
            WHEN move_value.value_int IS NOT NULL THEN move_value.value_int::text
            WHEN move_value.value_string IS NOT NULL THEN move_value.value_string
            WHEN move_value.value_text IS NOT NULL THEN move_value.value_text
            WHEN move_value.value_jsonb IS NOT NULL THEN move_value.value_jsonb::text
            WHEN move_value.value_timestamp IS NOT NULL THEN move_value.value_timestamp::text
            WHEN move_value.value_decimal IS NOT NULL THEN move_value.value_decimal::text
        END AS move_value
    FROM move_entity as film
        JOIN move_value ON
            film.id=move_value.move_entity_id
        JOIN move_attribute ON
            move_attribute.id=move_value.move_attribute_id
        JOIN move_attribute_type ON
            move_attribute_type.id=move_attribute.move_attribute_type_id
    ORDER BY film
;