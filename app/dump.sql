DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;

CREATE TABLE posts
(
    id    bigserial primary key,
    title varchar(200) NOT NULL
);

CREATE TABLE comments
(
    id      bigserial primary key,
    message varchar(200) NOT NULL,
    post_id bigint NOT NULL
);