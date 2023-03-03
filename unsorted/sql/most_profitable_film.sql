select f.id, f.title, sum(t.price)
from films f
         join film_sessions fs on f.id = fs.film_id
         join tickets t on fs.id = t.film_session_id
group by f.id, f.title
order by sum(t.price) desc
limit 1;