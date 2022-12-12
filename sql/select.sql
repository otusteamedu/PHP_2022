select m.name, sum(t.price) as total
from ticket t
         join session s on t.session_id = s.id
         join movie m on s.movie_id = m.id
group by m.name
order by total desc