select f.name, SUM(price) from seances
   join order_client oc on seances.id = oc.seance_id
   join films f on seances.film_id = f.id
group by f.id order by sum desc;