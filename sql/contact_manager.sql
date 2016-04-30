-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 31 2016 г., 22:54
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `contact_manager`
--

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `home_phone` varchar(255) NOT NULL,
  `work_phone` varchar(255) NOT NULL,
  `cell_phone` varchar(255) NOT NULL,
  `best_phone` varchar(10) NOT NULL,
  `adress1` varchar(255) NOT NULL,
  `adress2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `firstname`, `lastname`, `email`, `home_phone`, `work_phone`, `cell_phone`, `best_phone`, `adress1`, `adress2`, `city`, `state`, `zip`, `country`, `birthday`) VALUES
(1, 'Pavlo', 'Denys', 'fulg0re.den@gmail.com', '(0352) 28-90-83', '(067) 35-150-77', '(067) 35-150-35', 'cell_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '46016', 'Ukraine', '1989-07-11'),
(2, 'Ivan', 'Ivanov', 'Ivan@gmail.com', '(0352) 11-22-33', '(067) 11-222-33', '(095) 33-111-22', 'work_phone', 'Kiev1', 'Kiev2', 'Kiev3', 'Kiev4', '489562', 'Ukraine', '1987-01-24'),
(5, 'Mykola', 'Kushnir', 'kushnir@gmail.com', '26-55-44', '(095) 156-44-66', '(067) 123-55-77', 'cell_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '45612', 'Ukraine', '1986-06-29'),
(6, 'Mykola', 'Borysiyk', 'bor.myk@gmail.com', '45-88-99', '(095) 154-55-88', '(066) 154-88-99', 'home_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '45622', 'Ukraine', '1987-05-11'),
(7, 'Oksana', 'Pip', 'pip.o@gmail.com', '45-77-55', '(095) 47-85-444', '(067) 125-45-66', 'home_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '44478', 'Ukraine', '1985-04-25'),
(8, 'Rita', 'Rimata', 'rita.r@gmail.com', '47-88-99', '(095) 001-55-88', '(067) 54-88-99', 'home_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '78942', 'Ukraine', '1999-11-11'),
(9, 'Andriy', 'Sudoma', 'sudoma@gmail.com', '22-55-66', '(095) 54-89-251', '(097) 485-75-94', 'home_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '45678', 'Ukraine', '1988-04-27'),
(10, 'Oleksandr', 'Morkva', 'morkva@gmail.com', '45-66-88', '(095) 55-44-852', '(097) 456-88-99', 'home_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '45677', 'Ukraine', '1989-01-01'),
(11, 'Muhailo', 'Protsyk', 'protsyk@gmail.com', '44-56-88', '(095) 456-85-99', '(067) 11-22-458', 'home_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '11154', 'Ukraine', '1984-05-14'),
(14, 'Sergiy', 'Besh', 'besh@gmail.com', '45-87-26', '(095) 456-85-11', '(099) 54-78-22', 'cell_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '78945', 'Ukraine', '1989-11-25'),
(16, 'Iryna', 'Kolona', 'kol.ir@gmail.com', '65-88-11', '(095) 458-55-11', '(067) 458-55-77', 'home_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '15874', 'Ukraine', '1990-02-12');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'qwe', '056eafe7cf52220de2df36845b8ed170c67e23e3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
