//Количество фильмов. (count_films_img)
SELECT count(id) AS count_films FROM films;

//Фильмы, содержащие в описании "a". (like_a_img)
SELECT * FROM films WHERE description LIKE '%a%';

//Записи с атрибутом "Премия". (select_premium_img)
SELECT id, id_attribute, value_bool FROM values WHERE id_attribute = 2;

//Название аттрибута с типом 'bool'. (type_bool_img)
SELECT attributes.name_attribute, type_attribute.name_type FROM attributes
JOIN type_attribute ON attributes.id_type = type_attribute.id
WHERE type_attribute.name_type = 'bool';

//Список фильмов с рецензией. (review_img)
SELECT films.title FROM values
JOIN films ON values.id_film = films.id
WHERE values.id_attribute = 1;

//Фильмы, имеющие даты. (dates_img)
SELECT films.title, attributes.name_attribute, values.value_date FROM values
JOIN films ON films.id = values.id_film
JOIN attributes ON values.id_attribute = attributes.id
JOIN type_attribute ON attributes.id_type = type_attribute.id
WHERE attributes.name_attribute LIKE '%даты';

