-- выборка данных для маркетинга
CREATE VIEW marketing_attr_view AS
SELECT c.c_title,
       at.at_type,
       a.a_title,
       concat(av.av_value_int::text, av.av_value_varchar::text, av.av_value_text::text, av.av_value_bool::text,
              av.av_value_datetime::text) AS attribute_value
FROM cinema c
         JOIN attribute_value av on av.av_c_id = c.c_id
         JOIN attribute a on a.a_id = av.av_a_id
         JOIN attribute_type at on a.a_at_id = at.at_id
ORDER BY c.c_title ASC;

-- выборка событий с текущей датой и через 20 дней
CREATE VIEW events_attr_view AS
--     today, in20days  - выборка всех служебных дат(с префиксом service_date_) по соответсвующей дате
WITH today AS (SELECT av_c_id, a.a_title, av_value_datetime
               FROM attribute_value AS av
                        JOIN attribute AS a ON a.a_id = av.av_a_id
               WHERE av_value_datetime::date = now()::date AND a.a_title ILIKE 'service_date_%'),
     in20days AS (SELECT av_c_id, a.a_title, av_value_datetime
                  FROM attribute_value AS av
                           JOIN attribute AS a ON a.a_id = av.av_a_id
                  WHERE av_value_datetime::date = now()::date + interval '20 days' AND a.a_title ILIKE 'service_date_%'),
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

