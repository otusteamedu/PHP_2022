SELECT max(count(t.id_film)*f.price) AS "Max_sales", 
	f.title AS "Title" FROM ticket AS t INNER JOIN films AS f 
	ON(t.id_film=f.film_id) GROUP BY f.title ORDER BY DESC LIMIT 1;
