-- Запрос
explain select m.name, max(number_of_seats)
from hall
inner join session s on hall.id = s.hall_id
inner join movie m on s.movie_id = m.id
group by m.name

-- План при 10 000 строк

-- План при 10 000 000 строк

-- Оптимизации



-- План при 10 000 000 строк после оптимизаций
