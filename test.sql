-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Сен 17 2024 г., 14:48
-- Версия сервера: 5.7.24
-- Версия PHP: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(24) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `tag_id` bigint(24) UNSIGNED DEFAULT NULL,
  `user_id` bigint(24) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `tag_id`, `user_id`, `created_at`, `updated_at`) VALUES
(34, 'лироьпирол', 'олриоли', 3, 9, '2024-09-17 11:56:20', '2024-09-17 11:56:20');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks_tags`
--

CREATE TABLE `tasks_tags` (
  `id` bigint(24) UNSIGNED NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `background` varchar(50) DEFAULT '#000',
  `color` varchar(50) NOT NULL DEFAULT '#fff',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks_tags`
--

INSERT INTO `tasks_tags` (`id`, `label`, `background`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Выполнено', '#198754', '#fff', '2024-09-03 15:44:48', '2024-09-03 15:44:48'),
(2, 'В процессе', '#ffc107', '#fff', '2024-09-03 15:44:48', '2024-09-03 15:44:48'),
(3, 'Создано', '#0ecaf0', '#fff', '2024-09-03 15:46:01', '2024-09-03 15:46:01'),
(4, 'Не выполнена', 'red', '#fff', '2024-09-09 12:12:12', '2024-09-09 12:12:12');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(24) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `group_id` bigint(24) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `dob`, `password`, `group_id`, `created_at`, `updated_at`) VALUES
(8, 'toxa-tox122@mail.ru', 'Антон Сергеевич Прохориr', '2004-04-07', '$2y$10$60kJymIqrcAkrb7eU81WjusnSSVCelCeggzyWt3rglxOq.nQi/YcW', 1, '2024-09-05 19:12:41', '2024-09-05 19:12:41'),
(9, 'Test@mail.ru', 'Test', '2008-08-14', '$2y$10$EYlyq6oZq5GCNDmqVl8Gk.SAtUaIVkpqF3pQtQmhPRJ61kHX/j7aW', 2, '2024-09-09 11:48:55', '2024-09-09 11:48:55');

-- --------------------------------------------------------

--
-- Структура таблицы `user_groups`
--

CREATE TABLE `user_groups` (
  `id` bigint(24) UNSIGNED NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_groups`
--

INSERT INTO `user_groups` (`id`, `label`, `created_at`, `updated_at`) VALUES
(1, 'Администратор', '2024-09-03 15:30:52', '2024-09-03 15:30:52'),
(2, 'Гражданин', '2024-09-03 15:31:10', '2024-09-03 15:31:10');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `tasks_tags`
--
ALTER TABLE `tasks_tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(24) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `tasks_tags`
--
ALTER TABLE `tasks_tags`
  MODIFY `id` bigint(24) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(24) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` bigint(24) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tasks_tags` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `user_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
