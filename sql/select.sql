select m.name, count(m.id)*m.price as total_cost
from ticket t
         join session s on s.id = t.session_id
         join movie m on m.id = s.movie_id
group by m.id
order by count(m.id)*m.price desc
limit 1
