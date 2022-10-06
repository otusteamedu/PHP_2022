INSERT INTO film(film_name)
    select md5(random()::text) 
FROM generate_series(1,500000);

INSERT INTO film_attr_type(attr_type_name)
    select md5(random()::text) 
FROM generate_series(1,500000);

INSERT INTO public.film_attr(id_type_attr, attr_name)
    select floor(random()*(16-1+1))+1,
           md5(random()::text)
FROM generate_series(1,500000);

INSERT INTO public.film_values(id_film,id_attr)
    select film.id_film, 1 
FROM film
	LEFT JOIN film_values ON film_values.id_film=film.id_film
WHERE film_values.id_film IS NULL;

UPDATE public.film_values 
SET val_char = 'ну такое', val_date = '2022-08-14'
WHERE MOD(id_film,2) = 0; 