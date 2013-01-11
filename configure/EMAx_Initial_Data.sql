INSERT INTO `EMAx_Login` (`userName`,`password`) VALUES ('admin', 'admin');

INSERT INTO `EMAx_CostSettings` (`property`,`moneyValue`) VALUES 
('inCounty', 1.00),
('outCounty', 2.00);

INSERT INTO `EMAx_State` (`Name`) VALUES
('Alabama'),
('Alaska'),
('Arizona'),
('Arkansas'),
('California'),
('Colorado'),
('Connecticut'),
('Delaware'),
('Florida'),
('Georgia'),
('Hawaii'),
('Idaho'),
('Illinois'),
('Indiana'),
('Iowa'),
('Kansas'),
('Kentucky'),
('Louisiana'),
('Maine'),
('Maryland'),
('Massachusetts'),
('Michigan'),
('Minnesota'),
('Mississippi'),
('Missouri'),
('Montana'),
('Nebraska'),
('Nevada'),
('New Hampshire'),
('New Jersey'),
('New Mexico'),
('New York'),
('North Carolina'),
('North Dakota'),
('Ohio'),
('Oklahoma'),
('Oregon'),
('Pennsylvania'),
('Rhode Island'),
('South Carolina'),
('South Dakota'),
('Tennessee'),
('Texas'),
('Utah'),
('Vermont'),
('Virginia'),
('Washington'),
('West Virginia'),
('Wisconsin'),
('Wyoming');

INSERT INTO `EMAx_City` (`Name`) VALUES
('Town A'),
('City B'),
('Metro C'),
('Empire D');

INSERT INTO `EMAx_Option` (`Name`, `cost`) VALUES
('stand', 0.25),
('crawl', 0.50),
('walk', 0.75),
('run', 1.00);

INSERT INTO `EMAx_Grade` (`Name`,`cost`) VALUES
('small', 0.25),
('medium', 0.50),
('large', 0.75),
('x-large', 1.00);

INSERT INTO `EMAx_Zip` (`Name`) VALUES
('12345'),
('23456'),
('34567'),
('89898');

INSERT INTO `EMAx_Organization` (`name`, `phoneNumber`, `emailAddress`, `EMAx_City_ID`, `EMAx_State_ID`, `EMAx_Zip_ID`, `address`, `notes`) VALUES
('Company A', '1 (920) 982 2526', 'email@home.org', 1, 20, 1, '123 Fake St', 'notes'),
('Company B', '1 (920) 982 3357', 'mike@email.uk.co', 2, 30, 1, '321 Fakest street', 'more notes'),
('Company C', '1 (920) 654 3285', 'noreply@mail.us', 3, 40, 1, '1234 E main st', 'less notes');

INSERT INTO `EMAx_Person` (`fName`, `mName`, `lName`, `phoneNumber`, `secondaryPhoneNumber`, `emailAddress`, `address`, `notes`, `EMAx_City_ID`, `EMAx_State_ID`, `EMAx_Zip_ID`, `EMAx_Organization_ID`) VALUES
('Michael', 'R', 'Spear', '1 (982) 288 2135', '1 (920) 982 3357', 'email@home.org', 'emailE@home.org', 'notes for some', 1, 19, 1, 1),
('Bob', 'P', 'Smith', '1 (357) 486 5454', '1 (987) 258 6452', 'wishy@washy.me', '', '', 2, 17, 1, 1),
('Dave', NULL, 'Brown', NULL, NULL, NULL, NULL, NULL, 2, 18, 1, 3),
('Tom', '', 'Sizemore', '1 (975) 642 1357', '', 'testemail@bsd4breakfast.us', '', '', 1, 17, 1, 3),
('Nicolet', 'M', 'Anderson', '1 (920) 985 6598', '', '', '123 west main rd', 'notes', 2, 40, 4, 2);