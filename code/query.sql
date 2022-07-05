select film.title, sum(ticket.ticket_price) as sum
from film
    join ticket
on ticket.id_film=film.id
group by film.id
order by sum desc
    limit 1