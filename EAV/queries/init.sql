-- INIT MovieAttributeType VALUES --

INSERT INTO "MovieAttributeType"(id, "Type") VALUES (1, 'date');
INSERT INTO "MovieAttributeType"(id, "Type") VALUES (2, 'text');
INSERT INTO "MovieAttributeType"(id, "Type") VALUES (3, 'bool');

-- INIT MovieAttribute VALUES --

INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (1, 'user review', 2);
INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (2, 'imdb review', 2);

INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (3, 'nika award', 3);
INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (4, 'saturn award', 3);

INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (5, 'World premier', 1);
INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (6, 'Russia premier', 1);

INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (7, 'start promo TV', 1);
INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (8, 'start promo social', 1);
INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (9, 'start sales', 1);

-- INIT MovieAttributeValue VALUES --

INSERT INTO "AttributeValueText"(id, "Value") VALUES (1, 'Фильм супер, всем советую');
INSERT INTO "AttributeValueText"(id, "Value") VALUES (2, 'Ерунда полная, про какое-то железо');
INSERT INTO "AttributeValueText"(id, "Value") VALUES (3, 'Шедевр');
INSERT INTO "AttributeValueText"(id, "Value") VALUES (4, 'Не стоит того, думала с Дикаприо, а там другой кто-то');

INSERT INTO "AttributeValueBool"(id, "Value") VALUES (1, true);
INSERT INTO "AttributeValueBool"(id, "Value") VALUES (2, false);

INSERT INTO "AttributeValueDate"(id, "Value") VALUES (1, '1980-12-01');
INSERT INTO "AttributeValueDate"(id, "Value") VALUES (2, '1990-01-01');
INSERT INTO "AttributeValueDate"(id, "Value") VALUES (3, '1984-06-12');
INSERT INTO "AttributeValueDate"(id, "Value") VALUES (4, CURRENT_DATE);
INSERT INTO "AttributeValueDate"(id, "Value") VALUES (5, CURRENT_DATE + 20);
INSERT INTO "AttributeValueDate"(id, "Value") VALUES (6, CURRENT_DATE);
INSERT INTO "AttributeValueDate"(id, "Value") VALUES (7, CURRENT_DATE + 20);

-- INIT for Movie 1 --
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (1, 1, 1, 2);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (2, 1, 2, 3);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (3, 1, 3, 1);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (4, 1, 4, 2);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (5, 1, 5, 3);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (6, 1, 6, 4);

-- INIT for Movie 2 --
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (7, 2, 1, 4);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (8, 2, 2, 1);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (9, 2, 3, 2);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (10, 2, 4, 2);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (11, 2, 8, 6);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (12, 2, 9, 7);

-- INIT for Movie 3 --
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (13, 3, 2, 2);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (14, 3, 7, 4);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (15, 3, 9, 5);

-- INIT for Movie 4 --
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (16, 4, 1, 4);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (17, 4, 3, 1);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueId") VALUES (18, 4, 9, 2);