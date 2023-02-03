-- Доработки на основе планов

-- simple bool_attribute_title
CREATE INDEX bool_atribute ON attribute (a_id)  WHERE a_at_id = 2;

-- simple movie_date_attribute_today
create index date_attribute on attribute_value ((timezone('UTC', av_value_datetime)::DATE));
----- изменение запроса для использования совместно с индексом по дате
EXPLAIN SELECT av_c_id,av_a_id FROM attribute_value WHERE timezone('UTC', av_value_datetime)::date = (timezone('UTC', now()))::date ORDER BY av_c_id ASC;;

-- simple movie_with_five_prefix
create index cinema_title_prefix on cinema (c_title varchar_pattern_ops) include (c_id);

-- with join marketing_attr_view
create index cinema_title on cinema(c_title) include (c_id);
CREATE INDEX attrubute_value_cinema_id ON attribute_value(av_c_id);


-- with join events_attr_view
CREATE INDEX date_attribute ON attribute_value ((timezone('UTC', av_value_datetime)::DATE));
----- изменение запроса для использования совместно с индексом по дате
WITH today AS (SELECT av_c_id, a.a_title, av_value_datetime
               FROM attribute_value AS av
                        JOIN attribute AS a ON a.a_id = av.av_a_id
               WHERE (timezone('UTC',av_value_datetime))::date = (timezone('UTC', now()))::date),
     in20days AS (SELECT av_c_id, a.a_title, av_value_datetime
                  FROM attribute_value AS av
                           JOIN attribute AS a ON a.a_id = av.av_a_id
                  WHERE (timezone('UTC',av_value_datetime))::date = (timezone('UTC', now() + interval '20 days' ))::date),
--     OUTER EXCLUDING JOIN  все непустые события по выбранным датам / без пересечения
     allevents AS (SELECT t.av_c_id as today_c_id, i.av_c_id as in20day_c_id, t.a_title as today_event, i.a_title as in20day_event
                   FROM today AS t
                            FULL OUTER JOIN in20days AS i on t.av_c_id = i.av_c_id
                   WHERE i.av_c_id IS NULL
                      OR t.av_c_id IS NULL)
SELECT c.c_title, ae.today_event as today, ae.in20day_event as in20days
FROM cinema c
         JOIN allevents AS ae ON c.c_id IN (ae.today_c_id, ae.in20day_c_id)
ORDER BY c.c_title ASC;


-- with join most_truthful_attribute
CREATE INDEX attribute_value_bool ON attribute_value(av_value_bool) include (av_a_id);