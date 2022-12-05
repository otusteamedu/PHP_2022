-- Запрос
explain select h.name, start_time
from hall h
inner join session s on h.id = s.hall_id
where s.start_time between '2023-01-01 00:00:00' and '2023-01-05 23:59:59';

-- План при 10 000 строк

-- План при 10 000 000 строк

-- Оптимизации



-- План при 10 000 000 строк после оптимизаций
