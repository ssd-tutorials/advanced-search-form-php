<?php

return "
CREATE TABLE IF NOT EXISTS `book_location` (
	`book_id`	INTEGER NOT NULL,
	`location_id`	INTEGER NOT NULL,
	PRIMARY KEY(book_id,location_id)
)
";