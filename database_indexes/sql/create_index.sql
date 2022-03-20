CREATE INDEX film_session_index ON film_session (hall_id, film_id);
CREATE INDEX ticket_index ON ticket (film_session_id);