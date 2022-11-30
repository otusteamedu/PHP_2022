select SUM(hrc.price) as best_fees, f.name
from tickets
         inner join sessions s on s.id = tickets.session_id
         inner join films f on f.id = s.film_id
         inner join hall_rows hr on hr.id = tickets.row_id
         inner join hall_rows_category hrc on hrc.id = hr.category
group by f.name
order by best_fees desc
limit 1
