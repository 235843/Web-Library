CREATE TABLE `Student` (
  `ID` int PRIMARY KEY,
  `Name` varchar(255),
  'Surname' varchar(255),
  `Password` varchar(255),
  `AddressID` int,
  `ContactID` int
);

CREATE TABLE `Address` (
  `InhabitantID` int PRIMARY KEY,
  `City` varchar(255),
  `Street` varchar(255),
  `LocalNumber` varchar(255),
  `ZIP` varchar(255)
);

CREATE TABLE `Contact` (
  `OwnerID` int PRIMARY KEY,
  `PhoneNumber` varchar(255),
  `EMail` varchar(255)
);

CREATE TABLE `Book` (
  `CategoryID` int,
  `BookID` int PRIMARY KEY,
  `LibraryID` int,
  `Title` varchar(255),
  `Amount` int,
  `Describtion` varchar(255),
  `AuthorID` int
);

CREATE TABLE `Author` (
  `AuthorID` int PRIMARY KEY,
  `AuthorName` varchar(255)
);

CREATE TABLE `Category` (
  `CategoryID` int PRIMARY KEY,
  `CategoryName` varchar(255)
);

CREATE TABLE `Order` (
  `OrderID` int PRIMARY KEY,
  `StudentID` int,
  `BookID` int,
  `OrdersDate` datetime,
  `OrdersDeadline` datetime,
  `Status` varchar(255),
  `Penalty` int
);

CREATE TABLE `Library` (
  `LibraryID` int PRIMARY KEY,
  `LibraryName` varchar(255)
);

ALTER TABLE `Address` ADD FOREIGN KEY (`InhabitantID`) REFERENCES `student` (`ID`);

ALTER TABLE `Book` ADD FOREIGN KEY (`CategoryID`) REFERENCES `Category` (`CategoryID`);

ALTER TABLE `Book` ADD FOREIGN KEY (`LibraryID`) REFERENCES `Library` (`LibraryID`);

ALTER TABLE `Book` ADD FOREIGN KEY (`AuthorID`) REFERENCES `Author` (`AuthorID`);

ALTER TABLE `Order` ADD FOREIGN KEY (`StudentID`) REFERENCES `Student` (`ID`);

ALTER TABLE `Order` ADD FOREIGN KEY (`BookID`) REFERENCES `Book` (`BookID`);
