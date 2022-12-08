SELECT * from films WHERE base_price > 199;

SELECT * from sessions WHERE DATE(`from`) >= DATE(NOW());

SELECT MAX(base_price) from films;

SELECT title, `from` from films
        join film_session on film_session.film_id = films.id
        join sessions on sessions.id = film_session.session_id
 WHERE DATE(`from`) >= DATE(NOW());
#base_price < 200