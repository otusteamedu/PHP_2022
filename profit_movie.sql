select movie_id, m.title, sum(cost) profit
from sessions
         left outer join movies m on m.id = sessions.movie_id
group by movie_id, m.title
order by profit desc
limit 1;
