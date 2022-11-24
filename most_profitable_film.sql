select f.id, f.name, sum(sp.price)
from films f
         join film_sessions fs on f.id = fs.film_id
         join session_prices sp on fs.id = sp.session_id
         join tickets t on sp.id = t.session_price_id
group by f.id, f.name
order by sum(sp.price) desc
limit 1;