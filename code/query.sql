select film.title, sum(session.price) as sum
from film
    join ticket
on ticket.id_film=film.id
    join session on session.id=ticket.id_session
group by film.id
order by sum desc
    limit 1