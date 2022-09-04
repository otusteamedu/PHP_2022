select m.name, sum(s.price)
from movie m inner join session s on m.id = s.movie_id
group by m.name order by sum(s.price) desc limit 1;
