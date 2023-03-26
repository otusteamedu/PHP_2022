create table cinema_rooms
(
    id        bigint unsigned auto_increment primary key,
    name      varchar(255) not null,
    createdAt datetime     not null,
    updatedAt datetime     not null
)
    collate = utf8mb4_unicode_ci;

create table movies
(
    id          bigint unsigned auto_increment primary key,
    name        varchar(255) not null,
    description text         not null,
    time        int          not null,
    createdAt   datetime     not null,
    updatedAt   datetime     not null
)
    collate = utf8mb4_unicode_ci;

create table movie_sessions
(
    id        bigint unsigned auto_increment primary key,
    roomId    bigint unsigned not null,
    movieId   bigint unsigned not null,
    startAt   datetime        not null,
    createdAt datetime        not null,
    updatedAt datetime        not null,

    constraint movie_sessions_movieid_foreign
        foreign key (movieId) references movies (id)
            on update cascade on delete cascade,

    constraint movie_sessions_roomid_foreign
        foreign key (roomId) references cinema_rooms (id)
            on update cascade on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table room_places
(
    id        bigint unsigned auto_increment primary key,
    roomId    bigint unsigned not null,
    name      varchar(255)    not null,
    createdAt datetime        not null,
    updatedAt datetime        not null,

    constraint room_places_roomid_foreign
        foreign key (roomId) references cinema_rooms (id)
            on update cascade on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table movie_tickets
(
    id          bigint unsigned auto_increment primary key,
    sessionId   bigint unsigned not null,
    roomPlaceId bigint unsigned not null,
    cost        int             not null,
    createdAt   datetime        not null,
    updatedAt   datetime        not null,

    constraint movie_tickets_roomplaceid_foreign
        foreign key (roomPlaceId) references room_places (id)
            on update cascade on delete cascade,

    constraint movie_tickets_sessionid_foreign
        foreign key (sessionId) references movie_sessions (id)
            on update cascade on delete cascade
)
    collate = utf8mb4_unicode_ci;