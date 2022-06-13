INSERT INTO film (
    name,
    date_premier,
    description,
    duration,
    price
)
VALUES (
           'Пропавшая',
           '2022-06-09',
           'Уилл Спэнн везет свою жену, с которой они собираются разводиться, домой к её родителям. Во время остановки на заправке супруга странным образом бесследно исчезает. Уилл поднимает на уши местную полицию и вместе с родителями жены пытается найти её. Однако со временем подозрение падает на него самого.',
           95,
           300.00
       );
INSERT INTO film (
    name,
    date_premier,
    description,
    duration,
    price
)
VALUES (
           'Кощей. Похититель невест',
           '2022-06-09',
           'Вечно молодой и всегда с иголочки одетый Кощей вот уже триста лет почему-то не может найти себе невесту. Он и запугивал, и похищал, и превращал в лягушек разнообразных царевен, но эти ухаживания так и не помогли принцу тьмы. Тем временем прекрасная богатырша Варвара только и делает, что отбивается на арене от женихов, позарившихся на ее приданное. Однако завладев кощеевой иглой, царь Горох придумывает, как добраться до Варвары. Вот только он не учел одного – смерть Кощея хоть и заключена в игле, но в его сердце еще может ожить любовь...',
           76,
           250.00
       );
INSERT INTO film (
    name,
    date_premier,
    description,
    duration,
    price
)
VALUES (
           'Одна',
           '2022-06-09',
           '24 августа 1981 года молодожены Лариса и Владимир Савицкие ступили на борт самолета, следующего рейсом Комсомольск-на-Амуре — Благовещенск. За 30 минут до посадки гражданский борт АН-24 столкнулся с другим самолетом и развалился на куски на высоте более 5 километров над землей. Выжить не должен был никто… но произошло чудо. Лариса Савицкая очнулась посреди обломков самолета в непроходимой тайге. Теперь она сама должна была сотворить настоящее чудо, на которое способен только сильный духом человек.',
           107,
           220.00
       );

INSERT INTO film_worker(surname, name) VALUES ('Гудман', 'Брайан');
INSERT INTO film_worker(surname, name, birthdate, description) VALUES ('Батлер', 'Джералд', '1969-11-13','Британский актёр, наиболее известный по работам в таких фильмах, как «Призрак Оперы», «300 спартанцев», «Голая правда», «Законопослушный гражданин», «Охотник за головами», «Рок-н-рольщик», «Падение Олимпа» и «Падение Лондона», «Боги Египта», «Геошторм», «Падение Ангела»');
INSERT INTO film_worker(surname, name) VALUES ('Александер', 'Джейми');
INSERT INTO film_worker(surname, name) VALUES ('Артемьев', 'Роман');
INSERT INTO film_worker(surname, name, birthdate) VALUES ('Добронравов', 'Виктор', '1983-03-08');
INSERT INTO film_worker(surname, name, birthdate) VALUES ('Боярская', 'Елизавета', '1985-12-20');
INSERT INTO film_worker(surname, name) VALUES ('Суворов', 'Дмитрий');
INSERT INTO film_worker(surname, name, birthdate) VALUES ('Цапник', 'Ян', '1968-08-15');

INSERT INTO film_composition(film_id, film_worker_id, type) VALUES (1, 1, 'director');
INSERT INTO film_composition(film_id, film_worker_id) VALUES (1, 2);
INSERT INTO film_composition(film_id, film_worker_id) VALUES (1, 3);
INSERT INTO film_composition(film_id, film_worker_id, type) VALUES (2, 4, 'director');
INSERT INTO film_composition(film_id, film_worker_id) VALUES (2, 4);
INSERT INTO film_composition(film_id, film_worker_id) VALUES (2, 5);
INSERT INTO film_composition(film_id, film_worker_id) VALUES (2, 6);
INSERT INTO film_composition(film_id, film_worker_id, type) VALUES (3, 7, 'director');
INSERT INTO film_composition(film_id, film_worker_id) VALUES (3, 5);
INSERT INTO film_composition(film_id, film_worker_id) VALUES (3, 8);

INSERT INTO hall(name) VALUES ('Большой стандартный зал');
INSERT INTO hall(name) VALUES ('Малый стандартный зал');
INSERT INTO hall(name, vip) VALUES ('VIP-зал', true);

INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 1, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 2, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 3, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 4, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 5, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 6, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 7, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 8, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 9, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 10, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 1, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 2, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 3, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 4, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 5, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 6, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 7, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 8, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 9, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 10, 0.9);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 1);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 2);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 3);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 4);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 5);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 6);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 7);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 8);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 9);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 10);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 1);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 2);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 3);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 4);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 5);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 6);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 7);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 8);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 9);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 10);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 1, 1, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 1, 2, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 1, 3, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 1, 4, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 2, 1, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 2, 2, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 2, 3, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 2, 4, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 3, 1, 1.2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 3, 2, 1.2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 3, 3, 1.2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 3, 4, 1.2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 4, 1, 1.5);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 4, 2, 1.5);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 4, 3, 1.5);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 4, 4, 1.5);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (3, 1, 1, 2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (3, 1, 2, 2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (3, 2, 1, 2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (3, 2, 2, 2);

INSERT INTO session(hall_id, film_id, start_timestamp, end_timestamp) VALUES (1, 1, timestamp '2022-06-09 09:18:00', timestamp '2022-06-09 10:53:00');
INSERT INTO session(hall_id, film_id, start_timestamp, end_timestamp) VALUES (1, 1, timestamp '2022-06-09 15:48:00', timestamp '2022-06-09 17:23:00');
INSERT INTO session(hall_id, film_id, start_timestamp, end_timestamp, price_ratio) VALUES (2, 1, timestamp '2022-06-09 16:30:00', timestamp '2022-06-09 18:05:00', 1.2);
INSERT INTO session(hall_id, film_id, start_timestamp, end_timestamp, price_ratio) VALUES (3, 1, timestamp '2022-06-09 19:00:00', timestamp '2022-06-09 20:35:00', 1.2);
INSERT INTO session(hall_id, film_id, start_timestamp, end_timestamp) VALUES (1, 2, timestamp '2022-06-09 12:10:00', timestamp '2022-06-09 13:26:00');
INSERT INTO session(hall_id, film_id, start_timestamp, end_timestamp) VALUES (1, 2, timestamp '2022-06-09 18:10:00', timestamp '2022-06-09 19:26:00');
INSERT INTO session(hall_id, film_id, start_timestamp, end_timestamp) VALUES (2, 2, timestamp '2022-06-09 11:25:00', timestamp '2022-06-09 12:41:00');
INSERT INTO session(hall_id, film_id, start_timestamp, end_timestamp, price_ratio) VALUES (1, 3, timestamp '2022-06-09 07:20:00', timestamp '2022-06-09 09:07:00', 0.5);
INSERT INTO session(hall_id, film_id, start_timestamp, end_timestamp, price_ratio) VALUES (2, 3, timestamp '2022-06-09 13:40:00', timestamp '2022-06-09 15:27:00', 0.5);

INSERT INTO customer(surname, name, phone, email) VALUES ('Иванов', 'Иван', '+7 (900) 111-11-11', '111@email.com');
INSERT INTO customer(surname, name, phone, email) VALUES ('Петрова', 'Мария', '+7 (900) 222-22-22', '222@email.com');
INSERT INTO customer(surname, name, phone, email) VALUES ('Арбузова', 'Виктория', '+7 (900) 333-33-33', '333@email.com');
INSERT INTO customer(surname, name, phone, email) VALUES ('Сидоров', 'Аркадий', '+7 (900) 444-44-44', '444@email.com');
INSERT INTO customer(surname, name, phone, email) VALUES ('Пронченко', 'Зинаида', '+7 (900) 555-55-55', '555@email.com');

INSERT INTO orders(customer_id, date_create, place_purchase, status) VALUES (1, timestamp '2022-06-09 09:01:00', 'website', 'paid');
INSERT INTO orders(date_create, place_purchase, status) VALUES (timestamp '2022-06-09 09:03:15', 'ticket window', 'paid');
INSERT INTO orders(customer_id, date_create, status) VALUES (2, timestamp '2022-06-09 10:01:00', 'paid');
INSERT INTO orders(customer_id, date_create, status) VALUES (3, timestamp '2022-06-09 03:01:00', 'canceled');
INSERT INTO orders(customer_id, date_create, status) VALUES (4, timestamp '2022-06-09 05:25:00', 'not paid');
INSERT INTO orders(customer_id, date_create, status) VALUES (4, timestamp '2022-06-09 18:25:00', 'paid');
INSERT INTO orders(customer_id, date_create, place_purchase, status) VALUES (5, timestamp '2022-06-09 18:25:00', 'terminal', 'paid');

INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (1, 1, 1, 270, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (1, 1, 2, 270, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (1, 1, 3, 270, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (2, 4, 58, 720, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (2, 4, 59, 720, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (3, 6, 22, 250, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (3, 6, 23, 250, true);
INSERT INTO tickets(order_id, session_id, place_id, price) VALUES (4, 6, 24, 250);
INSERT INTO tickets(order_id, session_id, place_id, price) VALUES (4, 6, 25, 250);
INSERT INTO tickets(order_id, session_id, place_id, price) VALUES (4, 6, 26, 250);
INSERT INTO tickets(order_id, session_id, place_id, price) VALUES (4, 6, 27, 250);
INSERT INTO tickets(order_id, session_id, place_id, price) VALUES (4, 6, 28, 250);
INSERT INTO tickets(order_id, session_id, place_id, price) VALUES (4, 6, 29, 250);
INSERT INTO tickets(order_id, session_id, place_id, price) VALUES (4, 6, 30, 250);
INSERT INTO tickets(order_id, session_id, place_id, price) VALUES (5, 4, 60, 720);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (6, 8, 38, 110, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (6, 8, 39, 110, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (6, 8, 40, 110, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (7, 9, 53, 165, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (7, 9, 54, 165, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (7, 9, 55, 165, true);
INSERT INTO tickets(order_id, session_id, place_id, price, active) VALUES (7, 9, 56, 165, true);