insert into cinema_hall (id, name, number_of_seats) values (1, 'Teal', 400);
insert into cinema_hall (id, name, number_of_seats) values (2, 'Indigo', 300);
insert into cinema_hall (id, name, number_of_seats) values (3, 'Green', 200);
insert into cinema_hall (id, name, number_of_seats) values (4, 'Goldenrod', 100);
insert into cinema_hall (id, name, number_of_seats) values (5, 'Red', 100);

insert into movie (id, title) values (1, 'Life with Father');
insert into movie (id, title) values (2, 'Pumping Iron');
insert into movie (id, title) values (3, 'Charlie Chan at Monte Carlo');
insert into movie (id, title) values (4, 'Dead of the Nite');
insert into movie (id, title) values (5, 'Earthling, The');

insert into seance (id, cinema_hall_id, movie_id, price, starts_at) values (1, 1, 1, 77.71, '12/3/2021');
insert into seance (id, cinema_hall_id, movie_id, price, starts_at) values (2, 2, 2, 96.86, '2/28/2022');
insert into seance (id, cinema_hall_id, movie_id, price, starts_at) values (3, 3, 3, 80.11, '6/5/2021');
insert into seance (id, cinema_hall_id, movie_id, price, starts_at) values (4, 4, 4, 95.69, '9/17/2021');
insert into seance (id, cinema_hall_id, movie_id, price, starts_at) values (5, 5, 5, 88.23, '11/1/2021');
insert into seance (id, cinema_hall_id, movie_id, price, starts_at) values (6, 5, 5, 88.23, '11/1/2021');
insert into seance (id, cinema_hall_id, movie_id, price, starts_at) values (7, 5, 5, 88.23, '11/1/2021');
insert into seance (id, cinema_hall_id, movie_id, price, starts_at) values (8, 5, 5, 88.23, '11/1/2021');
insert into seance (id, cinema_hall_id, movie_id, price, starts_at) values (9, 5, 5, 88.23, '11/1/2021');

insert into client (id, first_name, last_name) values (1, 'Jenine', 'Witchalls');
insert into client (id, first_name, last_name) values (2, 'Vannie', 'Gabala');
insert into client (id, first_name, last_name) values (3, 'Ambrosi', 'McEttigen');
insert into client (id, first_name, last_name) values (4, 'Rosana', 'Walker');
insert into client (id, first_name, last_name) values (5, 'Glyn', 'Forestel');

insert into ticket (id, client_id, seat_number, seance_id) values (1, '5', '300', '1');
insert into ticket (id, client_id, seat_number, seance_id) values (2, '4', '200', '2');
insert into ticket (id, client_id, seat_number, seance_id) values (3, '3', '111', '3');
insert into ticket (id, client_id, seat_number, seance_id) values (4, '2', '55', '4');
insert into ticket (id, client_id, seat_number, seance_id) values (5, '1', '23', '5');