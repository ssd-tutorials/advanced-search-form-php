<?php

return "
CREATE TABLE IF NOT EXISTS `book_cover` (
  `book_id` int(10) unsigned NOT NULL,
  `cover_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`cover_id`),
  KEY `book_cover_cover_id` (`cover_id`),
  CONSTRAINT `book_cover_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `book_cover_cover_id` FOREIGN KEY (`cover_id`) REFERENCES `covers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
";