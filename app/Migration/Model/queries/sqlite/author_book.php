<?php

return "
CREATE TABLE IF NOT EXISTS `author_book` (
	`author_id`	INTEGER NOT NULL,
	`book_id`	INTEGER NOT NULL,
	PRIMARY KEY(author_id,book_id)
)
";