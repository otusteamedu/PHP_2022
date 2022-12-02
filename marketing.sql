select f.name as film_name, t.type as attribute_type, a.name as attribute_name, v.value
from films_entity as f
         inner join values v on f.id = v.entity_id
         inner join attributes a on a.id = v.attribute_id
         inner join attributes_types t on a.type = t.id