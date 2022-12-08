select m.name, sum(t.price) as total
from ticket t
         join session s on s.id = t.session_id
         join movie m on m.id = s.movie_id
group by m.name
order by total desc