CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
-- Справочник фильмов. --
CREATE TABLE IF NOT EXISTS movies
(
    id UUID NOT NULL DEFAULT uuid_generate_v4(),
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
COMMENT ON TABLE movies IS 'Справочник фильмов.';
COMMENT ON COLUMN movies.id IS 'Идентификатор.';
COMMENT ON COLUMN movies.title IS 'Название.';

-- Типы атрибутов. --
CREATE TABLE IF NOT EXISTS attributes_type(
    id UUID NOT NULL DEFAULT uuid_generate_v4(),
    title VARCHAR(255) NOT NULL,
    type VARCHAR(11) NOT NULL,
    PRIMARY KEY(id)
);
CREATE UNIQUE INDEX IF NOT EXISTS uniq_attributes_type_title ON attributes_type (title);
COMMENT ON TABLE attributes_type IS 'Типы атрибутов.';
COMMENT ON COLUMN attributes_type.id IS 'Идентификатор.';
COMMENT ON COLUMN attributes_type.title IS 'Название.';
COMMENT ON COLUMN attributes_type.type IS 'Тип.';

-- Атрибуты. --
CREATE TABLE IF NOT EXISTS attributes(
    id UUID NOT NULL DEFAULT uuid_generate_v4(),
    type_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_attributes_type
        FOREIGN KEY(type_id)
            REFERENCES attributes_type(id)
            DEFERRABLE INITIALLY IMMEDIATE
);
COMMENT ON TABLE attributes IS 'Атрибуты.';
COMMENT ON COLUMN attributes.id IS 'Идентификатор.';
COMMENT ON COLUMN attributes.type_id IS 'Идентификатор типа атрибута.';
COMMENT ON COLUMN attributes.title IS 'Название.';

-- Атрибуты фильмов и их значения. --
CREATE TABLE IF NOT EXISTS attributes_values(
    id UUID NOT NULL DEFAULT uuid_generate_v4(),
    entity_id UUID NOT NULL,
    attribute_id UUID NOT NULL,
    text_value TEXT NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_movie_id
        FOREIGN KEY(entity_id)
            REFERENCES movies(id) ON DELETE CASCADE
            DEFERRABLE INITIALLY IMMEDIATE,
    CONSTRAINT fk_attribute_id
        FOREIGN KEY(attribute_id)
            REFERENCES attributes(id) ON DELETE CASCADE
            DEFERRABLE INITIALLY IMMEDIATE
);
COMMENT ON TABLE attributes_values IS 'Атрибуты фильмов и их значения.';
COMMENT ON COLUMN attributes_values.id IS 'Идентификатор.';
COMMENT ON COLUMN attributes_values.entity_id IS 'Идентификатор фильма.';
COMMENT ON COLUMN attributes_values.attribute_id IS 'Идентификатор атрибута.';
COMMENT ON COLUMN attributes_values.text_value IS 'Значение.';
