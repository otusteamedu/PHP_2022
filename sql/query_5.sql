-- Запрос
explain select count(value_text)
from movie_attribute_value mav
inner join movie_attribute ma on ma.id = mav.attribute_id
where ma.name = 'reviews';

-- План при 10 000 строк

-- План при 10 000 000 строк

-- Оптимизации



-- План при 10 000 000 строк после оптимизаций
