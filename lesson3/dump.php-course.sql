-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 05 2022 г., 16:00
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `php-course`
--
CREATE DATABASE IF NOT EXISTS `php-course` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `php-course`;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` double NOT NULL,
  `prod_desc` varchar(2000) DEFAULT NULL,
  `prod_state` tinyint(1) DEFAULT NULL COMMENT 'null-actual, 1-no has',
  `prod_date_create` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Товары';

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`prod_id`, `prod_name`, `prod_price`, `prod_desc`, `prod_state`, `prod_date_create`) VALUES
(1, 'Мини юбка, латекс', 1500, 'Подчеркнёт Вашу фигуру, все будут в ударе', NULL, '2022-01-04 21:36:29'),
(2, 'Мини юбка, кожа', 1800, 'Красиво будет сидеть на Вашей фигуру, Вам понравится', NULL, '2022-01-04 21:36:29'),
(3, 'Атласные перчатки', 900, 'Подчеркнёт изящество Ваших рук', NULL, '2022-01-05 19:09:10'),
(4, 'Виниловое платье', 1800, 'Подчеркнёт изящество Вашего тела', NULL, '2022-01-05 19:09:10'),
(5, 'Виниловая юбка карандаш', 1900, 'Подчеркнёт изящество Вашей фигуры', NULL, '2022-01-05 19:10:03'),
(6, 'Чулки из искусственной кожи', 1100, 'Подчеркнёт изящество Ваших ног', NULL, '2022-01-05 19:10:03');

-- --------------------------------------------------------

--
-- Структура таблицы `prod__pics`
--

DROP TABLE IF EXISTS `prod__pics`;
CREATE TABLE `prod__pics` (
  `pp_id` int(11) NOT NULL,
  `pp_prod_id` int(11) NOT NULL,
  `pp_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Фото картинок';

--
-- Дамп данных таблицы `prod__pics`
--

INSERT INTO `prod__pics` (`pp_id`, `pp_prod_id`, `pp_name`) VALUES
(1, 1, '123.jpeg'),
(3, 2, '223.jpeg'),
(5, 3, '312.jpeg'),
(6, 6, '611.jpeg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `prod_state` (`prod_state`);

--
-- Индексы таблицы `prod__pics`
--
ALTER TABLE `prod__pics`
  ADD PRIMARY KEY (`pp_id`),
  ADD KEY `pp_prod_id` (`pp_prod_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `prod__pics`
--
ALTER TABLE `prod__pics`
  MODIFY `pp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
