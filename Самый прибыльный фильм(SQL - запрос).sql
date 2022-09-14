SELECT a.film_name, d.place_id from film as a
inner join public.seance as b on a.film_id = b.film_id
inner join public.ticket as c on b.seance_id = c.seance_id
inner join public.place as d on d.place_id = c.place_id
inner join public.row_seat as e on d.row_seat_id = e.row_seat_id
inner join public.table_price as f on e.price_id = f.price_id;

"Рокки" 1290
"Соучастник"    750