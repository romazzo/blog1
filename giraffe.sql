-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 04 2018 г., 18:17
-- Версия сервера: 5.6.38
-- Версия PHP: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `giraffe`
--

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`id`, `title`, `description`, `created_at`, `user_id`) VALUES
(15, 'Второй', 'Привет это мой первый пост', '2018-09-27 00:00:00', 6),
(16, 'Третий пост', 'Привет это мой первый пост', '2018-09-27 00:00:00', 7),
(40, 'Sample blog post', 'This blog post shows a few different types of content that\'s supported and styled with Bootstrap. Basic typography, images, and code are all supported.', '2018-09-28 22:10:00', 6),
(62, 'Sample blog post 44', 'This blog post shows a few different types of content that\'s supported and styled with Bootstrap. Basic typography, images, and code are all supported.', '2018-10-01 22:06:00', 7),
(66, 'Sample blog post', 'This blog post shows a few different types of content that\'s supported and styled with Bootstrap. Basic typography, images, and code are all supported.', '2018-10-01 23:38:59', 11),
(68, 'Sample blog post', 'Привет повторный пост', '2018-10-02 00:44:52', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'roman', '$2y$13$PqSc7k7CniRgYa9psCbAQeRc5s3Fmsx8GQh5jtSH8UT4GHVHPR5Yq'),
(4, 'can', '$2y$13$hJNgJl0pW5pg9TgwYSZtSOT6mSKIgG4sH/LOevKUCOfr2mOMo9MqC'),
(6, 'ren', '$2y$13$Crt9S5v2mrDIwN/.n3OgNux0H6NJ.Ln5UMduv1UkQkLF9H0/BkvfS'),
(7, 'sin', '$2y$13$UxzA11nRrBo/3DDEmpuXduBwcChxDmwzZkm0hNWvM18cHexd6C8dO'),
(8, 'Den', '$2y$13$7r8PtA3oN26F7GQVOUnhguRwLtLyzPs9QkCi7Znj567wzv3kdEo3q'),
(9, 'admin', '$2y$13$tsr0Cbmn/81k7MCEtUgqzuxiJX1gO1e7pCtjUanEbjDOD2/frDsDO'),
(10, 'kiss', '$2y$13$BB5M1jQ1JXNSYms76YIHJe3PUpxLDatAk4a0CLkNwtD/m/Xq.gVMy'),
(11, 'lil', '$2y$13$xUUAwKXrbmHZKnp/GJAn4.HKeRCGu4J/j2udOfjNSa/2HQ6TkZa2q'),
(12, 'sten', '$2y$13$vL1bpgkTtrtiaBCd1tOFMeqHFcxnpKqoMElfQm3R3mDaXiJm/fUMO');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A8A6C8DA76ED395` (`user_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
