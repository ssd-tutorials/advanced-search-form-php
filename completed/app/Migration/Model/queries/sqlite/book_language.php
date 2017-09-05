<?php

return "
CREATE TABLE IF NOT EXISTS `book_language` (
	`book_id`	INTEGER NOT NULL,
	`language_id`	INTEGER NOT NULL,
	PRIMARY KEY(book_id,language_id)
)
";