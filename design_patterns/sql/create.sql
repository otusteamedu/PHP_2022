CREATE TABLE money (
    id SERIAL PRIMARY KEY,
    fifty_banknote_count FLOAT,
    hundred_banknote_count FLOAT,
    five_hundred_banknote_count FLOAT,
    thousand_banknote_count FLOAT
);

INSERT INTO money (fifty_banknote_count, hundred_banknote_count, five_hundred_banknote_count, thousand_banknote_count) VALUES (0, 0, 0, 0);