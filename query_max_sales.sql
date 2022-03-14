SELECT max(count(t.id_films)*t.price) AS "Max_sales", 
	f.title AS title FROM ticket AS t INNER JOIN films AS f 
	ON(t.id_films=f.films_id) GROUP BY f.title ORDER BY DESC LIMIT 1;