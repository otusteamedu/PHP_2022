//Создание индекса уменьшило время выполнения запросов для "Количество фильмов" и "Фильмы, содержащие в описании "a"".
CREATE INDEX films_title_idx
ON films (title);


//Создание индексов уменьшило время выполнения запроса "Название аттрибута с типом 'bool'"
CREATE INDEX type_attribute_name_idx
ON type_attribute (name_type);

CREATE INDEX attributes_name_idx
ON attributes (name_attribute);


//Создание индексов уменьшило время выполнения запроса "Фильмы, имеющие даты."
CREATE INDEX values_value_date_idx
ON values (value_date);