INSERT INTO `authors` (id,name) VALUES 
(1,'Darren Shan'),
(2,'M.R. James'),
(3,'Stephanie Meyer'),
(4,'Nora Roberts');
 
INSERT INTO `categories` (id,name) VALUES 
(1,'Romance'),
(2,'Art'),
(3,'Comedy'),
(4,'Horror');
 
INSERT INTO `covers` (id,name) VALUES 
(1,'Soft'),
(2,'Hard');

INSERT INTO `languages` (id,name) VALUES 
(1,'English'),
(2,'French'),
(3,'German'),
(4,'Spanish'),
(5,'Italian'),
(6,'Polish');

INSERT INTO `locations` (id,name) VALUES 
(1,'London'),
(2,'Brighton'),
(3,'Bournemouth'),
(4,'Portsmouth'),
(5,'Southampton'),
(6,'Chichester');

INSERT INTO `books` (id,category_id,isbn,year,title,description,price) VALUES 
(1,4,'1405678151',2005,'Ghost Stories','This is the second collection of chilling ghost stories by M. R. James. \A Warning to the Curious\ features a young man who excavates an ancient crown - but soon wishes he had let it stay buried. In \The Mezzotint\ an engraving of a manor house reveals more than first meets the eye, while in \The Stalls of Barchester Cathedral\, an archdeacon''''s journal reveals the strange circumstances that led to his death. The final story, \A Neighbour''''s Landmark\, tells of a gentleman whose curiosity is piqued by a strange rhyme, leading him to take a walk through Betton Woods...Read by BAFTA and Emmy-award winning actor Derek Jacobi (\Cadfael\, \Gosford Park\, \Doctor Who\), and with eerie, evocative music, these four haunting stories will thrill anyone who loves to be terrified.',6.99),
(2,4,'0007260342',2001,'Hell''s Heroes','The final dramatic conclusion to Darren Shan''''s international phenomena, The Demonata. Expect the unexpected! The final dramatic conclusion to Darren Shan''''s international phenomena, The Demonata. Expect the unexpected!',6.49),
(3,1,'1904233651',2007,'Twilight','When 17 year old Isabella Swan moves to Forks, Washington to live with her father she expects that her new life will be as dull as the town. But in spite of her awkward manner and low expectations, she finds that her new classmates are drawn to this pale, dark-haired new girl in town. But not, it seems, the Cullen family. These five adopted brothers and sisters obviously prefer their own company and will make no exception for Bella. Bella is convinced that Edward Cullen in particular hates her, but she feels a strange attraction to him, although his hostility makes her feel almost physically ill. He seems determined to push her away ? until, that is, he saves her life from an out of control car. Bella will soon discover that there is a very good reason for Edward''''s coldness. He, and his family, are vampires ? and he knows how dangerous it is for others to get too close.',3.49),
(4,1,'074992926X',2001,'Black Hills','Lil Chance fell in love with Cooper Sullivan pretty much the first time she saw him, an awkward teenager staying with his grandparents on their cattle ranch in South Dakota while his parents went through a messy divorce. Each year, with Coop''''s annual summer visit, their friendship deepens - but then abruptly ends. Twelve years later and Cooper has returned to run the ranch after his grandfather is injured in a fall. Though his touch still haunts her, Lil has let nothing stop her dream of opening the Chance Wildlife Refuge, but something - or someone - has been keeping a close watch. When small pranks escalate into heartless killing, the memory of an unsolved murder in these very hills has Cooper springing to action to keep Lil safe. They both know the dangers that lurk in the wild landscape of the Black Hills. And now they must work together to unearth a killer of twisted and unnatural instincts who has singled them out as prey',7.19);

INSERT INTO `author_book` (author_id,book_id) VALUES 
(2,1),
(3,1),
(1,2),
(3,3),
(4,4);

INSERT INTO `book_cover` (book_id,cover_id) VALUES 
(3,1),
(4,1),
(1,2),
(2,2),
(3,2);

INSERT INTO `book_language` (book_id,language_id) VALUES 
(1,1),
(2,1),
(3,1),
(4,1),
(1,2),
(3,2),
(4,2),
(2,3),
(3,3),
(2,4),
(3,4),
(2,5);

INSERT INTO `book_location` (book_id,location_id) VALUES 
(1,1),
(3,1),
(4,1),
(1,2),
(2,2),
(3,2),
(3,3),
(4,3),
(2,4),
(3,5);
