-- фильм, тип атрибута, атрибут, значение (значение выводим как текст)
CREATE VIEW v_attributes AS
    select
        m.name  movie,
        a.name  type_name,
        aa.name attribute_name,
        CASE a.id
            WHEN 'int' THEN av.value_int::varchar
            WHEN 'float' THEN av.value_numeric::varchar
            WHEN 'text' THEN av.value_text::varchar
            WHEN 'bool' THEN av.value_bool::varchar
            WHEN 'date' THEN av.value_date::varchar
            WHEN 'task' THEN av.value_date::varchar
        END as attribute_value
    from
        movies m
        inner join aev_values av on m.id = av.movie_id
        inner join aev_attributes aa on av.attribute_id = aa.id
        inner join aev_types a on aa.type_id = a.id
    order by movie, type_name, attribute_name;