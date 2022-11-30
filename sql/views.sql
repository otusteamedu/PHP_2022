create view movie_tasks(name, today_tasks, day_20_task) as
SELECT tbl.name,
       string_agg(tbl.today_task::text, ', '::text)  AS today_tasks,
       string_agg(tbl.day_20_task::text, ', '::text) AS day_20_task
FROM (SELECT m.name,
             mav.value_datetime,
             ma.name AS ma_name,
             CASE
                 WHEN mav.value_datetime >= CURRENT_DATE AND mav.value_datetime < (CURRENT_DATE + '1 day'::interval)
                     THEN ma.name
                 ELSE NULL::character varying
                 END AS today_task,
             CASE
                 WHEN mav.value_datetime >= (CURRENT_DATE + '20 days'::interval) AND
                      mav.value_datetime < (CURRENT_DATE + '21 days'::interval) THEN ma.name
                 ELSE NULL::character varying
                 END AS day_20_task
      FROM movie m
               JOIN movie_attribute_value mav ON m.id = mav.movie_id
               JOIN movie_attribute ma ON mav.attribute_id = ma.id
      WHERE ma.name::text = ANY
            (ARRAY ['start_tv_ads'::character varying, 'start_selling_tickets'::character varying]::text[])) tbl
GROUP BY tbl.name;

alter table movie_tasks
    owner to "user";

create view attr_values(name, type, attr, value) as
SELECT m.name,
       ma.type,
       ma.name AS attr,
       CASE
           WHEN ma.type::text = 'boolean'::text THEN mav.value_boolean::text
           WHEN ma.type::text = 'int'::text THEN mav.value_int::text
           WHEN ma.type::text = 'text'::text THEN mav.value_text
           WHEN ma.type::text = 'float'::text THEN mav.value_float::text
           WHEN ma.type::text = 'datetime'::text THEN mav.value_datetime::text
           WHEN ma.type::text = 'date'::text THEN mav.value_date::text
           WHEN ma.type::text = 'numeric'::text THEN mav.value_numeric::text
           ELSE NULL::text
           END AS value
FROM movie m
         JOIN movie_attribute_value mav ON m.id = mav.movie_id
         JOIN movie_attribute ma ON mav.attribute_id = ma.id;

alter table attr_values
    owner to "user";

