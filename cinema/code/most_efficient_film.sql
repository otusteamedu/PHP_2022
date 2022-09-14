select
     r.film_id
    ,r.film_name
    ,r.total_sum

  from (select
             f.id                 as film_id
            ,f.name               as film_name
            ,sum(t.price_on_sale) as total_sum

          from ticket as t

          inner join film_session_id as s on s.id = t.film_session_id

          inner join film            as f on f.id = s.film_id

          group by
              f.id
       ) as r

  order by
    r.total_sum desc

  limit 1
;
