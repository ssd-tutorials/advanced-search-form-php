<?php

return "
CREATE TABLE IF NOT EXISTS `book_cover` (
	`book_id`	INTEGER NOT NULL,
	`cover_id`	INTEGER NOT NULL,
	PRIMARY KEY(book_id,cover_id)
)
";