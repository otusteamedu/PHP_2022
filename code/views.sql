CREATE OR REPLACE VIEW service_information AS
    SELECT f.name, t.date_today, t_20.date_today_20 FROM
    (
        SELECT av.entity_id, av.value_date AS date_today
        FROM attribute a
            JOIN attribute_value av ON av.attribute_id = a.id AND av.value_date = current_date + 1
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





/*
    SELECT f.*, av.value_date as DATE_TODAY, av_20.value_date as DATE_20 from film f
        JOIN attribute_type t ON t.id = 4
        JOIN attribute a ON a.attribute_type_id = t.id
        INNER JOIN attribute_value av ON a.id = av.attribute_id AND f.id = av.entity_id AND
                                   av.value_date = current_date + 1
        JOIN attribute_value av_20 ON a.id = av_20.attribute_id AND f.id = av_20.entity_id AND av_20.value_date = current_date + 20;
*/

