<?php

return "
CREATE TABLE IF NOT EXISTS `book_language` (
  `book_id` int(10) unsigned NOT NULL,
  `language_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`language_id`),
  KEY `book_language_language_id` (`language_id`),
  CONSTRAINT `book_language_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `book_language_language_id` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
";