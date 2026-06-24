CREATE DATABASE tour_travel;

USE tour_travel;

---------------------------------------------------
-- USERS TABLE
---------------------------------------------------

CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    mobile VARCHAR(20) NOT NULL,

    email VARCHAR(100) UNIQUE NOT NULL,

    password VARCHAR(255) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

---------------------------------------------------
-- ADMIN TABLE
---------------------------------------------------

CREATE TABLE admin (

    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(100) NOT NULL,

    password VARCHAR(100) NOT NULL
);

INSERT INTO admin(username,password)
VALUES
('admin','admin123');

---------------------------------------------------
-- TOUR PACKAGES TABLE
---------------------------------------------------

CREATE TABLE packages (

    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(150) NOT NULL,

    description TEXT NOT NULL,

    price DECIMAL(10,2) NOT NULL,

    image VARCHAR(255) NOT NULL,

    days VARCHAR(50),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

---------------------------------------------------
-- BUSES TABLE
---------------------------------------------------

CREATE TABLE buses (

    id INT AUTO_INCREMENT PRIMARY KEY,

    package_id INT,

    bus_name VARCHAR(100) NOT NULL,

    bus_number VARCHAR(50),

    bus_type VARCHAR(50),

    seat_type VARCHAR(50),

    from_city VARCHAR(100),

    to_city VARCHAR(100),

    departure_date DATE,

    departure_time TIME,

    arrival_time TIME,

    total_seats INT DEFAULT 40,

    available_seats INT DEFAULT 40,

    price DECIMAL(10,2),

    status VARCHAR(50) DEFAULT 'Available',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (package_id)
    REFERENCES packages(id)
    ON DELETE CASCADE
);

---------------------------------------------------
-- BUS SEATS TABLE
---------------------------------------------------

CREATE TABLE bus_seats (

    id INT AUTO_INCREMENT PRIMARY KEY,

    bus_id INT NOT NULL,

    seat_number VARCHAR(10) NOT NULL,

    gender VARCHAR(20) DEFAULT NULL,

    seat_status VARCHAR(20)
    DEFAULT 'Available',

    FOREIGN KEY (bus_id)
    REFERENCES buses(id)
    ON DELETE CASCADE
);

---------------------------------------------------
-- BUS BOOKINGS TABLE
---------------------------------------------------

CREATE TABLE bus_bookings (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    bus_id INT NOT NULL,

    package_id INT NOT NULL,

    seats TEXT NOT NULL,

    amount DECIMAL(10,2) NOT NULL,

    payment_method VARCHAR(50),

    payment_status VARCHAR(50)
    DEFAULT 'Pending',

    booking_status VARCHAR(50)
    DEFAULT 'Confirmed',

    booking_date TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY (bus_id)
    REFERENCES buses(id)
    ON DELETE CASCADE,

    FOREIGN KEY (package_id)
    REFERENCES packages(id)
    ON DELETE CASCADE
);

---------------------------------------------------
-- FEEDBACK TABLE
---------------------------------------------------

CREATE TABLE feedback (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT,

    message TEXT NOT NULL,

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);

---------------------------------------------------
-- SAMPLE PACKAGES
---------------------------------------------------

INSERT INTO packages
(title,description,price,image,days)

VALUES

(
'Goa Beach Tour',

'Enjoy beautiful Goa beaches with luxury stay and sightseeing.',

15000,

'goa.jpg',

'3 Days / 2 Nights'
),

(
'Manali Adventure',

'Snow adventure, mountain trekking and campfire in Manali.',

22000,

'manali.jpg',

'5 Days / 4 Nights'
),

(
'Dubai Luxury Trip',

'Luxury Dubai vacation with Burj Khalifa and desert safari.',

55000,

'dubai.jpg',

'6 Days / 5 Nights'
);

---------------------------------------------------
-- SAMPLE BUSES
---------------------------------------------------

INSERT INTO buses
(
package_id,
bus_name,
bus_number,
bus_type,
seat_type,
from_city,
to_city,
departure_date,
departure_time,
arrival_time,
total_seats,
available_seats,
price
)

VALUES

(
1,
'VRL Travels',
'MH12AB1234',
'AC',
'Sleeper',
'Mumbai',
'Goa',
'2026-05-20',
'08:00:00',
'20:00:00',
40,
40,
1500
),

(
2,
'SRS Travels',
'MH14XY5678',
'Non-AC',
'Seater',
'Pune',
'Manali',
'2026-05-25',
'06:00:00',
'23:00:00',
35,
35,
2500
),

(
3,
'Neeta Travels',
'MH10PQ9876',
'AC',
'Sleeper',
'Mumbai',
'Delhi',
'2026-06-01',
'09:00:00',
'22:00:00',
45,
45,
3000
);

---------------------------------------------------
-- SAMPLE SEATS
---------------------------------------------------

INSERT INTO bus_seats
(bus_id,seat_number)

VALUES

(1,'A1'),
(1,'A2'),
(1,'A3'),
(1,'A4'),

(2,'B1'),
(2,'B2'),
(2,'B3'),
(2,'B4'),

(3,'C1'),
(3,'C2'),
(3,'C3'),
(3,'C4');