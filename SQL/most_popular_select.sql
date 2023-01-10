select m.id, m.name, sum(hs.price) total_price
from tickets as t
inner join hall_shows hs on t.hall_show_id = hs.id
inner join movies m on hs.movie_id = m.id
group by m.id
order by total_price desc
limit 1;