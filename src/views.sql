create view important_dates as
(
    select
        film.name as film_name,
        fat.name as attribute_type,
        fa.name as attribute_name,
        v_date::varchar as value
    from film
             inner join film_attribute_value fav on film.id = fav.film_id
             inner join film_attribute fa on fa.id = fav.attribute_id
             inner join film_attribute fa1 on fa.parent_attribute_id = fa1.id
             inner join film_attribute_type fat on fat.id = fa.attribute_type
    where fa1.name = 'Важные даты'
);

create view marketing_dates as
(
    select
        film.name as "film name",
        tasks_today.name as today,
        tasks_20_days.name as "in 20 days"
    from film
             left join film_attribute_value fav_today on film.id = fav_today.film_id
        and fav_today.v_date = current_date
             left join film_attribute_value fav_20_days on film.id = fav_20_days.film_id
        and fav_20_days.v_date = current_date + interval '20 days'
             left join film_attribute tasks_today on tasks_today.id = fav_today.attribute_id
             left join film_attribute tasks_20_days on tasks_20_days.id = fav_20_days.attribute_id
             inner join film_attribute fa on (
                tasks_today.parent_attribute_id = fa.id or tasks_20_days.parent_attribute_id = fa.id
        )
    where fa.name = 'Служебные даты'  and (fav_today.id is not null or fav_20_days.id is not null)
);

