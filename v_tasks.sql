-- фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
CREATE VIEW v_tasks AS
    select
        m.name movie,
        (
            select
                array_to_string(array_agg(aev_attributes.name), ';')
            from
                aev_values
                inner join aev_attributes on attribute_id = aev_attributes.id
            where
                movie_id = m.id
                and type_id = 'task'
                and value_date = current_date
        ) as   tasks_today,
        (
            select
                array_to_string(array_agg(aev_attributes.name), ';')
            from
                aev_values
                inner join aev_attributes on attribute_id = aev_attributes.id
            where
                movie_id = m.id
                and type_id = 'task'
                and value_date = current_date + 20
        ) as   tasks_after_20
    from
        movies as m
    order by
        m.name;