
select count(*) from ticket;

/* session  самый дорогой сеанс */
select session_id, movie_id from session where price = (select max(price) from session);

/*прибыль за период*/
explain
select sum(s.price)
from ticket t
inner join session s on s.session_id = t.session_id
where started_at between '2023-12-01' and '2023-12-31';

/*прибыль за период по каждому фильму*/
select m.name, ROUND(sum(s.price) :: numeric, 2)
from ticket t
inner join session s on s.session_id = t.session_id
inner join movie m on m.movie_id = s.movie_id
where started_at between '2022-12-01' and '2022-12-31'
group by m.name
order by sum(s.price) desc;


/*сколько билетов продано  на каждый сеанс, цены */
explain
select s.session_id, count(t.ticket_id), min(s.price), max(s.price), avg(s.price) from ticket t
inner join session s on s.session_id = t.session_id
where started_at between '2022-12-01' and '2022-12-31'
group by s.session_id
order by count(t.ticket_id) desc;

/* какие зоны продаются чаще всего*/
explain
select  z.name, count(t.ticket_id)
from ticket t
         inner join place p on p.place_id = t.place_id
         inner join zone z on z.zone_id = p.zone_id
group by z.name
order by count(t.ticket_id) desc;


/* топ 10 самых прибыльных фильмов*/
explain
select distinct m.name, sum(s.price)
from ticket t
         inner join session s on s.session_id = t.session_id
         inner join movie m on m.movie_id = s.movie_id
group by m.name
order by sum(s.price) desc
limit 10;

















/*
1.какие новые фильмы будут показаны в 2023 году
av.attribute_id = 4 - дата примьера
*/
select m.name, a.name from  attribute_value av
inner join attribute a on a.attribute_id = av.attribute_id
inner join attribute_type at on at.attribute_type_id = a.attribute_type_id
inner join movie m on m.movie_id =  av.movie_id
where (av.v_datetime  between '2022-01-01' and '2022-12-31' ) and  av.attribute_id = 4
order by m.name, a.name;

/*
2.Самые популярные фильмы, с рейтингом выше r.
в определенных жанрах.
*/
select m.name, a.name from  attribute_value av
inner join attribute a on a.attribute_id = av.attribute_id
inner join attribute_type at on at.attribute_type_id = a.attribute_type_id
inner join movie m on m.movie_id =  av.movie_id
where (av.attribute_id = 11 and av.v_text in () )
      and  (av.attribute_id = 10 and av.v_numeric > 7.7)
order by av.v_numeric, m.name, a.name;


/* Все данные по фильму
   where movie_id =
*/
select m.name, at.name, a.name,
       CASE
           WHEN at.name = 'int' THEN av.v_int:: text
           WHEN at.name = 'text' THEN av.v_text::text
           WHEN at.name = 'bool' THEN

               CASE
                   WHEN av.v_bool = 't' THEN 'есть'
                   WHEN av.v_bool = 'f' THEN 'нет'
               end

           WHEN at.name = 'datetime' THEN to_char(av.v_datetime , 'DD-MM-YYYY')
       END atrr_value
from  attribute_value av
inner join attribute a on a.attribute_id = av.attribute_id
inner join attribute_type at on at.attribute_type_id = a.attribute_type_id
inner join movie m on m.movie_id =  av.movie_id
order by m.name, a.name,at.name ;


/* топ 10 самых прибыльных фильмов*/
select distinct m.name, sum(s.price * z.rate)
from ticket t
         inner join place p on p.place_id = t.place_id
         inner join session s on s.session_id = t.session_id
         inner join zone z on z.zone_id = p.zone_id
         inner join movie m on m.movie_id = s.movie_id
group by m.name
order by sum(s.price * z.rate) desc
limit 1;

/*
4. фильм , общая стоимость продаж за период, минимальный билет, самый дорогой, средний

*/










