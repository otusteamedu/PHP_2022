select f.name as "Самый прибыльный фильм", sum(ticket.cost) as "Сборы"
from ticket
         inner join film_session fs on ticket.film_session_id = fs.id
         inner join film f on f.id = fs.film_id
         inner join ticket_status ts on ticket.ticket_status_id = ts.id
where ts.name = 'sold'
group by f.name
order by "Сборы" desc
limit 1;