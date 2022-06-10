select m.name as Movie,
       count(s2.id) as Sessions,
       count(t.id) as Tickets,
       sum(t.sold_for_price) as Revenue
from ticket as t
    join ticket_status ts on t.id = ts.ticket_id
    join status s on s.id = ts.status_id
    join seat_session ss on ts.seat_session_id = ss.id
    join session s2 on ss.session_id = s2.id
    join movie m on s2.movie_id = m.id
where s.name = 'prepaid'
group by Movie
order by Revenue desc