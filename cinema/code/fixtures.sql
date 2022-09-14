-- заполняем залы
insert into cinema_hall (
  code
)
select
     x.code
  from (select
             'зеленый' as code
        union select
             'синий' as code
       ) as x
  where x.code not in (select
                            z.code
                         from cinema_hall as z
                      )
;

-- заполняем места зеленого зала
insert into cinema_hall_seat (
   row
  ,number
  ,cinema_hall_id
  ,price
  ,is_available
)
select
     x.row
    ,x.number
    ,h.id
    ,x.price
    ,1
  from (select
             1      as row
            ,1      as number
            ,120.00 as price
        union select
             1      as row
            ,2      as number
            ,120.00 as price
        union select
             2      as row
            ,1      as number
            ,240.00 as price
        union select
             2      as row
            ,2      as number
            ,240.00 as price
       ) as x
  left join cinema_hall as h on h.code = 'зеленый'

  where concat(x.row, ':', x.number) not in (select
                                                  concat(y.row, ':', y.number)
                                               from cinema_hall as z
                                               inner join cinema_hall_seat as y on y.cinema_hall_id = z.id
                                                                               and z.code = 'зеленый'
                                            )
;

-- заполняем места синего зала
insert into cinema_hall_seat (
   row
  ,number
  ,cinema_hall_id
  ,price
  ,is_available
)
select
     x.row
    ,x.number
    ,h.id
    ,x.price
    ,1
  from (select
             1      as row
            ,1      as number
            ,120.00 as price
        union select
             1      as row
            ,2      as number
            ,120.00 as price
        union select
             2      as row
            ,1      as number
            ,240.00 as price
        union select
             2      as row
            ,2      as number
            ,240.00 as price
       ) as x
  left join cinema_hall as h on h.code = 'синий'

  where concat(x.row, ':', x.number) not in (select
                                                  concat(y.row, ':', y.number)
                                               from cinema_hall as z
                                               inner join cinema_hall_seat as y on y.cinema_hall_id = z.id
                                                                               and z.code = 'синий'
                                            )
;


-- заполняем каталог фильмов
insert into film (
   name
  ,duration
  ,description
)
select
     x.name
    ,x.duration
    ,x.description
  from (select 
             'Мстители: Финал' as name
            ,152               as duration
            ,'Долгожданный финал саги бесконечности' as description
        union select
             'Терминатор Генезис' as name
            ,134                  as duration
            ,'Продолжение истории о терминаторе'    as description
       ) as x

  where x.name not in (select
                            z.name
                         from film as z
                      )

-- заполняем сеансы
insert ignore into film_session (
   film_id
  ,cinema_hall_id
  ,start_date
)
select
     f.id
    ,h.id
    ,x.start_date
  from (select
             'зеленый'                as cinema_hall_code
            ,'Терминатор Генезис'     as film_name
            ,'2021-11-25 10:00:00'    as start_date
        union select
             'синий'                  as cinema_hall_code
            ,'Мстители: Финал'        as film_name
            ,'2021-11-25 10:30:00'    as start_date
        union select
             'зеленый'                as cinema_hall_code
            ,'Мстители: Финал'        as film_name
            ,'2021-11-25 14:50:00'    as start_date
        union select
             'синий'                  as cinema_hall_code
            ,'Мстители: Финал'        as film_name
            ,'2021-11-25 15:10:00'    as start_date
       ) as x

  inner join film        as f on f.name = x.film_name

  inner join cinema_hall as h on h.code = x.cinema_hall_code


-- заполняем билеты
insert ignore into ticket (
   cinema_hall_seat_id
  ,film_session_id
  ,price_on_sale
)
select
     h.id
    ,s.id
    ,h.price
  from (select
             2                     as row
            ,2                     as number
            ,'Мстители: Финал'     as film_name
            ,'2021-11-25 10:30:00' as start_date
        union select
             1                     as row
            ,1                     as number
            ,'Терминатор Генезис'  as film_name
            ,'2021-11-25 10:00:00' as start_date
        union select
             1                     as row
            ,2                     as number
            ,'Терминатор Генезис'  as film_name
            ,'2021-11-25 10:00:00' as start_date
        union select
             2                     as row
            ,1                     as number
            ,'Терминатор Генезис'  as film_name
            ,'2021-11-25 10:00:00' as start_date
        union select
             2                     as row
            ,2                     as number
            ,'Терминатор Генезис'  as film_name
            ,'2021-11-25 10:00:00' as start_date
        union select
             2                     as row
            ,1                     as number
            ,'Мстители: Финал'     as film_name
            ,'2021-11-25 14:50:00' as start_date
        union select
             2                     as row
            ,2                     as number
            ,'Мстители: Финал'     as film_name
            ,'2021-11-25 14:50:00' as start_date
        union select
             1                     as row
            ,1                     as number
            ,'Мстители: Финал'     as film_name
            ,'2021-11-25 15:10:00' as start_date
        union select
             2                     as row
            ,1                     as number
            ,'Мстители: Финал'     as film_name
            ,'2021-11-25 15:10:00' as start_date
        union select
             2                     as row
            ,2                     as number
            ,'Мстители: Финал'     as film_name
            ,'2021-11-25 15:10:00' as start_date
       ) as x

  inner join film             as f on f.name = x.film_name

  inner join film_session     as s on s.film_id    = f.id
                                  and s.start_date = x.start_date

  inner join cinema_hall_seat as h on h.row            = x.row
                                  and h.number         = x.number
                                  and s.cinema_hall_id = s.cinema_hall_id
;