select f.name, SUM(total_price) from order_client oc
     join seances s on s.id = oc.seance_id
     join films f on s.film_id = f.id
     join seates s2 on s2.seance_id = s.id
group by f.id order by sum desc;