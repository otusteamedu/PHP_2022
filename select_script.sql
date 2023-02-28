select m.name, sum(t.price)
from movie m
         inner join session s on m.id = s.movie_id
         inner join ticket t on s.id = t.session_id
group by m.name
order by sum(s.price) desc
limit 1;
