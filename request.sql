Select (count(t.session_id) * s.price) as sum, s.film_id, f.title
from tickets as t
         Join sessions as s ON(t.session_id = s.film_id)
         Join films as f ON(f.id = s.id)
group by s.price, s.film_id, f.title Order by sum DESC LIMIT 1;
