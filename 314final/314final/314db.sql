-- Create or use the SYSTEMADMIN database
CREATE DATABASE IF NOT EXISTS 314db;
USE 314db;
GRANT ALL PRIVILEGES ON 314db.* TO 'root';
FLUSH PRIVILEGES;
-- Create User Table
CREATE TABLE IF NOT EXISTS User (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    UserType ENUM('System Administrator', 'Real Estate Agent', 'Buyer', 'Seller') NOT NULL,
    AccountStatus ENUM('Active', 'Suspended') NOT NULL
);

-- Create UserProfile Table
CREATE TABLE IF NOT EXISTS UserProfile (
    ProfileID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    FirstName VARCHAR(255),
    LastName VARCHAR(255),
    Email VARCHAR(255),
    Phone VARCHAR(20),
    Address VARCHAR(255),
    City VARCHAR(255),
    State VARCHAR(255),
    ZipCode VARCHAR(10),
    AccountStatus ENUM('Active', 'Suspended') NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(UserID)
);

CREATE TABLE Property_table(
  propertyListingID int(11) NOT NULL,
  title varchar(255) NOT NULL,
  address varchar(255) NOT NULL,
  price decimal(11,2) NOT NULL,
  developer varchar(255) NOT NULL,
  propertyType enum('HDB','Apartment','Condo','Townhouse','Terrace') NOT NULL,
  viewCount int(11) NOT NULL,
  shortlistCount int(11) NOT NULL,
  status ENUM('All, Old, New') NOT NULL
    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create Review Table
CREATE TABLE IF NOT EXISTS Review (
    ReviewID INT AUTO_INCREMENT PRIMARY KEY,
    ReviewerID INT NOT NULL,
    RevieweeID INT NOT NULL,
    Rating INT CHECK (Rating BETWEEN 1 AND 5),
    Comments TEXT,
    Date DATE,
    FOREIGN KEY (ReviewerID) REFERENCES User(UserID),
    FOREIGN KEY (RevieweeID) REFERENCES User(UserID)
);

-- Create Rating Table
CREATE TABLE IF NOT EXISTS Rating (
    RatingID INT AUTO_INCREMENT PRIMARY KEY,
    RaterID INT NOT NULL,
    RateeID INT NOT NULL,
    Rating INT CHECK (Rating BETWEEN 1 AND 5),
    Date DATE,
    FOREIGN KEY (RaterID) REFERENCES User(UserID),
    FOREIGN KEY (RateeID) REFERENCES User(UserID)
);


ALTER TABLE `property_table`
  ADD PRIMARY KEY (`propertyListingID`);

  
ALTER TABLE `property_table`
  MODIFY `propertyListingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

-- Insert Sample Data into User Table
INSERT INTO User (Username, Password, UserType, AccountStatus) VALUES
('admin', 'admin123' , 'System Administrator', 'Active'),
('agent1', 'agent123', 'Real Estate Agent', 'Active'),
('buyer1', 'buyer123', 'Buyer', 'Active'),
('seller1', 'seller123', 'Seller', 'Active');

-- Insert Sample Data into UserProfile Table
INSERT INTO UserProfile (UserID, FirstName, LastName, Email, Phone, Address, City, State, ZipCode, AccountStatus) VALUES
(1, 'John', 'Doe', 'johndoe@example.com', '123-456-7890', '123 Main St', 'Anytown', 'CA', '12345','Active'),
(2, 'Jane', 'Smith', 'janesmith@example.com', '987-654-3210', '456 Elm St', 'Sometown', 'NY', '54321','Active'),
(3, 'Mike', 'Johnson', 'mikejohnson@example.com', '555-123-4567', '789 Oak Ave', 'Othercity', 'TX', '67890','Active'),
(4, 'Sara', 'Williams', 'sarawilliams@example.com', '111-222-3333', '321 Pine St', 'Anothercity', 'FL', '45678','Active');

INSERT INTO `property_table` (`propertyListingID`, `title`, `address`, `price`, `developer`, `propertyType`, `viewCount`, `shortlistCount`, `status`) VALUES
(51, 'Property Listing 1', '1234 SquareRoad 123456', 123.00, 'Lousy developer', 'HDB', 3510, 86, 'Sold'),
(52, 'listing 2', '1234 SquareRoad 123456', 4500.20, 'Developer 3', 'Condo', 1895, 22, 'Available'),
(54, 'Listing 3', 'new house', 8989.09, 'develophouse pte', 'Condo', 3730, 30, 'Available'),
(55, 'New Listing', '321 Address block 2', 4500.20, 'Developer 2', 'Condo', 283, 99, 'Sold'),
(56, 'New Listing2', 'Pineapple #01-01', 32.50, 'Spongebob', 'Apartment', 3522, 28, 'Available');


-- Insert Sample Data into Review Table
INSERT INTO Review (ReviewerID, RevieweeID, Rating, Comments, Date) VALUES
(3, 2, 5, 'Great agent to work with!', '2024-04-15'),
(4, 2, 4, 'Helpful and responsive', '2024-04-20'),
(2, 4, 3, 'Average experience', '2024-04-10');

-- Insert Sample Data into Rating Table
INSERT INTO Rating (RaterID, RateeID, Rating, Date) VALUES
(3, 2, 4, '2024-04-15'),
(4, 2, 5, '2024-04-20'),
(2, 4, 3, '2024-04-10');

