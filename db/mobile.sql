-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: my-mysql
-- Время создания: Сен 24 2026 г., 17:19
-- Версия сервера: 26.7.0
-- Версия PHP: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mobile`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ads`
--

CREATE TABLE `ads` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `phone_model` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `ads`
--

INSERT INTO `ads` (`id`, `user_id`, `phone_model`, `price`, `description`, `photo`, `created_at`) VALUES
(1, 2, 'Pixel 9 Pro XL', 40000.00, 'no', '55e7cf804f0e77219782ca2541df3458.webp', '2026-09-24 16:47:50'),
(2, 4, 'Iphone 15', 55000.00, 'chotko', '7c82030320834b4570e66bfc8e5ec4e4.png', '2026-09-24 16:58:53');

-- --------------------------------------------------------

--
-- Структура таблицы `purchases`
--

CREATE TABLE `purchases` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `phone_model` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `fio` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `tel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `fio`, `tel`, `email`, `password`, `role`) VALUES
(2, 'qwerty', 'йцуке', '8(111)212-12-12', '123@123.com', '$2y$12$QOy3u5d2xsQD6CgYziU85uZSDLehmULqBYMOPd.UyIn06zXeXNy7q', 'user'),
(3, 'YaRcOO', 'йцуке', '8(111)212-12-11', '111@111.com', '$2y$12$v5vuiq2m/Rdbp7NCFClWZ.xH4DiueFh6PT6rKwq4L64VZkbkesu7W', 'admin'),
(4, 'YaRcOOo', 'КОКОКО', '8(112)121-22-22', '121212@121212.com', '$2y$12$0UE1eZwIAXoijP6Cx5OcpuE1q46WsO9eEsX0bRqNTTUk7JxT0N366', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `ads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
