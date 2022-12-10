select m.name, sum(tc.price) as total
from ticket t
         join session s on t.session_id = s.id
         join movie m on s.movie_id = m.id
         join ticket_category tc on s.ticket_category_id = tc.id
group by m.name
order by total desc