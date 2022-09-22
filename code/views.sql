/* Служебные данные */
CREATE OR REPLACE VIEW service_information AS
    SELECT f.name, t.date_today, t_20.date_today_20 FROM
    (
        SELECT av.entity_id, av.value_date AS date_today
        FROM attribute a
            JOIN attribute_value av ON av.attribute_id = a.id AND av.value_date = current_date
        WHERE a.attribute_type_id = 4
    ) t
    FULL JOIN
    (
        SELECT av.entity_id AS entity_id_20, av.value_date AS date_today_20
        FROM attribute a
            JOIN attribute_value av on av.attribute_id = a.id AND av.value_date = current_date + 20
        WHERE a.attribute_type_id = 4
    ) t_20 ON t.entity_id = t_20.entity_id_20
    JOIN film f ON f.id = coalesce(t.entity_id, t_20.entity_id_20);

/* Данные для маркетинга (все атрибуты) */
CREATE OR REPLACE VIEW all_attributes AS
    SELECT f.name AS film, at.name AS attribute_type_name, a.name AS attribute_name, v.value FROM
        (
            SELECT av.entity_id, av.attribute_id, get_value(av.entity_id, av.attribute_id) AS value
            FROM attribute_value av
            GROUP BY av.entity_id, av.attribute_id
            ORDER BY av.entity_id, av.attribute_id
        ) v
    JOIN film f ON f.id = v.entity_id
    JOIN attribute a ON a.id = v.attribute_id
    JOIN attribute_type at on a.attribute_type_id = at.id;
