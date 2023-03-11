select s.date, f.name from seances s
   join films f on s.film_id = f.id
where s.date = current_date;


select count(o.id) from orders o
where o.date >= date_trunc('week',current_date)


select s.date, f.name, s.date, s.price from seances s
    join films f on s.film_id = f.id
where s.date = current_date;


SELECT f.name, sum(o.count) FROM orders o
     inner join seances s on s.id = o.seance_id
     inner join films f on f.id = s.film_id
where o.date >= date_trunc('week',current_date)
GROUP BY f.id
HAVING sum(o.count) = (SELECT sum(o.count) FROM orders o
    inner join seances s on s.id = o.seance_id
    inner join films f on f.id = s.film_id
GROUP BY f.id ORDER BY sum(o.count) desc LIMIT 1)


select * from seances s;

select f.name, s.date, max(s.price), min(s.price) from seances s
   inner join films f on s.film_id = f.id
group by f.id, s.date






