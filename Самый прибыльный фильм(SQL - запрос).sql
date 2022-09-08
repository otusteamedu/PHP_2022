
SELECT film.film_name, sum(ticket.ticket_price) from film, seance, ticket
where seance.film_id = film.film_id
and ticket.seance_id = seance.seance_id
group by film.film_name


"film_name"	"sum"
"Рокки"	3150
"Соучастник"	1350