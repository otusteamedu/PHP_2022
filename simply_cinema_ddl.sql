CREATE TABLE `halls` (
                         `id` INT NOT NULL AUTO_INCREMENT,
                         `name` VARCHAR(255) NOT NULL UNIQUE,
                         `rows` INT NOT NULL,
                         `seats` INT NOT NULL,
                         PRIMARY KEY (`id`)
);

CREATE TABLE `sessions` (
                            `id` INT NOT NULL AUTO_INCREMENT,
                            `movie_id` INT NOT NULL,
                            `hall_id` INT NOT NULL,
                            `start_at` TIMESTAMP NOT NULL,
                            `end_at` TIMESTAMP NOT NULL,
                            PRIMARY KEY (`id`)
);

CREATE TABLE `movies` (
                          `id` INT NOT NULL AUTO_INCREMENT,
                          `name` VARCHAR(255) NOT NULL,
                          `duration` TIME NOT NULL,
                          PRIMARY KEY (`id`)
);

CREATE TABLE `tickets` (
                           `id` INT NOT NULL AUTO_INCREMENT,
                           `row` INT NOT NULL,
                           `seat` INT NOT NULL,
                           `price` DECIMAL NOT NULL,
                           PRIMARY KEY (`id`)
);

CREATE TABLE `session_ticket` (
                                  `session_id` INT NOT NULL,
                                  `ticket_id` INT NOT NULL
);

ALTER TABLE `sessions` ADD CONSTRAINT `sessions_fk0` FOREIGN KEY (`movie_id`) REFERENCES `movies`(`id`);

ALTER TABLE `sessions` ADD CONSTRAINT `sessions_fk1` FOREIGN KEY (`hall_id`) REFERENCES `halls`(`id`);

ALTER TABLE `session_ticket` ADD CONSTRAINT `session_ticket_fk0` FOREIGN KEY (`session_id`) REFERENCES `sessions`(`id`);

ALTER TABLE `session_ticket` ADD CONSTRAINT `session_ticket_fk1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets`(`id`);
