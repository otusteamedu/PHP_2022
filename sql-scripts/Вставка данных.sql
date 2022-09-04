-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               PostgreSQL 12.12, compiled by Visual C++ build 1914, 64-bit
-- Операционная система:         
-- HeidiSQL Версия:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES  */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дамп данных таблицы public.attributes: 9 rows
/*!40000 ALTER TABLE "attributes" DISABLE KEYS */;
INSERT INTO "attributes" ("uid", "attribute_name", "attribute_type_id") VALUES
	(2, 'Премия "Оскар"', 3),
	(4, 'Сборы в мире', 6),
	(7, 'Сборы в России', 6),
	(20, 'Рецензии зрителей', 1),
	(25, 'Рецензии кинокритиков', 1),
	(31, 'Премьера в мире', 10),
	(38, 'Премьера в Росии', 10),
	(46, 'Начало продаж билетов', 15),
	(55, 'Старт рекламы', 15);
/*!40000 ALTER TABLE "attributes" ENABLE KEYS */;

-- Дамп данных таблицы public.attribute_types: 5 rows
/*!40000 ALTER TABLE "attribute_types" DISABLE KEYS */;
INSERT INTO "attribute_types" ("uid", "attribute_type_name") VALUES
	(1, 'Рецензии'),
	(3, 'Премии'),
	(6, 'Сборы'),
	(10, 'Важные даты'),
	(15, 'Служебные даты');
/*!40000 ALTER TABLE "attribute_types" ENABLE KEYS */;

-- Дамп данных таблицы public.attribute_values: 11 rows
/*!40000 ALTER TABLE "attribute_values" DISABLE KEYS */;
INSERT INTO "attribute_values" ("uid", "film_id", "attribute_id", "value_varchar", "value_text", "value_date", "value_numeric", "value_integer", "value_boolean") VALUES
	(1, 1, 2, 'Лучшие визуальные эффекты', NULL, NULL, NULL, NULL, NULL),
	(3, 1, 2, 'Лучшая операторская работа', NULL, NULL, NULL, NULL, NULL),
	(6, 1, 2, 'Лучшая работа художника-постановщика', NULL, NULL, NULL, NULL, NULL),
	(10, 1, 4, NULL, NULL, NULL, 2849856965.00, NULL, NULL),
	(31, 1, 7, NULL, NULL, NULL, 119903658.00, NULL, NULL),
	(37, 1, 20, NULL, 'Пик карьеры самого Джеймса Кэмерона – как с художественной, так и с технической точек зрения. Визуальные эффекты фильма сражают наповал; по части воссоздания другого мира рядом поставить просто нечего. И, конечно же, не забыта и история – и именно в ней маэстро раскрывается со своей самой лучшей стороны. Дергая за ниточки ровно тогда, когда это нужно, предлагая оглушительное буйство финала и реверанс, от которого мурашки бегут по коже', NULL, NULL, NULL, NULL),
	(44, 1, 25, NULL, 'Фильм Аватар 2009 года выпуска это художественное произведение, имеющие фантастический оттенок. Мне всегда нравились фильмы, которые повествуют о будущем нашей планеты. Точно так же и здесь, где действие проходило в очень далеком расстоянии от нашей Земли. Вы можете представить себе два световых года? Лететь такое расстояние с нашими, пока что ''технологиями'', однозначно тысячи и тысячи лет. Это уже может будоражить воображение зрителя. Представление такого в реальности, а возможно ли вообще это действо в настоящем мире? Именно этим и завлекла меня кинокартина.', NULL, NULL, NULL, NULL),
	(52, 1, 31, NULL, NULL, '2009-12-10', NULL, NULL, NULL),
	(101, 1, 38, NULL, NULL, '2009-12-15', NULL, NULL, NULL),
	(174, 1, 55, NULL, NULL, '2022-09-04', NULL, NULL, NULL),
	(185, 1, 46, NULL, NULL, '2022-09-24', NULL, NULL, NULL);
/*!40000 ALTER TABLE "attribute_values" ENABLE KEYS */;

-- Дамп данных таблицы public.films: 1 rows
/*!40000 ALTER TABLE "films" DISABLE KEYS */;
INSERT INTO "films" ("uid", "film_name", "year", "age_category") VALUES
	(1, 'Аватар', '2009', '12+');
/*!40000 ALTER TABLE "films" ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
