<?php
// --------------------
// DATABASE CONNECTION
// --------------------
$host = "localhost";
$user = "root";
$pass = "";
$db   = "flight_booking";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// --------------------
// SESSION
// --------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --------------------
// AUTO MIGRATIONS
// --------------------

// ensure phone column exists
$check = $conn->query("SHOW COLUMNS FROM passengers LIKE 'phone'");
if ($check && $check->num_rows === 0) {
    $conn->query("ALTER TABLE passengers ADD COLUMN phone VARCHAR(20) NULL");
}

// ensure aircraft column
$ac = $conn->query("SHOW COLUMNS FROM flights LIKE 'aircraft_type'");
if ($ac && $ac->num_rows === 0) {
    $conn->query("ALTER TABLE flights ADD COLUMN aircraft_type VARCHAR(20) DEFAULT 'A320'");
}

// --- audit log table ---
$conn->query("
CREATE TABLE IF NOT EXISTS audit_log(
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NULL,
 role VARCHAR(20),
 action VARCHAR(255),
 details TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
");

// booking cancel / refund
$col = $conn->query("SHOW COLUMNS FROM bookings LIKE 'cancel_status'");
if ($col && $col->num_rows == 0) {
    $conn->query("ALTER TABLE bookings ADD cancel_status VARCHAR(20) DEFAULT 'ACTIVE'");
}

$col = $conn->query("SHOW COLUMNS FROM bookings LIKE 'refund_status'");
if ($col && $col->num_rows == 0) {
    $conn->query("ALTER TABLE bookings ADD refund_status VARCHAR(20) DEFAULT 'NONE'");
}

// passenger cancel / refund
$col = $conn->query("SHOW COLUMNS FROM passengers LIKE 'cancel_status'");
if ($col && $col->num_rows == 0) {
    $conn->query("ALTER TABLE passengers ADD cancel_status VARCHAR(20) DEFAULT 'ACTIVE'");
}

$col = $conn->query("SHOW COLUMNS FROM passengers LIKE 'refund_status'");
if ($col && $col->num_rows == 0) {
    $conn->query("ALTER TABLE passengers ADD refund_status VARCHAR(20) DEFAULT 'NONE'");
}

// --- SEATS TABLE ---
$conn->query("
CREATE TABLE IF NOT EXISTS seats(
 id INT AUTO_INCREMENT PRIMARY KEY,
 flight_id INT NOT NULL,
 seat_no VARCHAR(10) NOT NULL,
 status ENUM('FREE','HELD','BOOKED') DEFAULT 'FREE',
 held_until DATETIME NULL,
 UNIQUE KEY seat_unique(flight_id, seat_no)
) ENGINE=InnoDB
");

// --- PASSENGER TICKET NUMBERS ---
$col = $conn->query("SHOW COLUMNS FROM passengers LIKE 'ticket_no'");
if ($col && $col->num_rows === 0) {
    $conn->query("ALTER TABLE passengers ADD ticket_no VARCHAR(50) NULL");
}

$conn->query("
UPDATE passengers p 
JOIN bookings b ON b.id = p.booking_id
SET p.ticket_no = CONCAT(
    'TKT-',
    DATE_FORMAT(NOW(), '%Y%m%d'),
    '-',
    LPAD(p.id, 5, '0')
)
WHERE (p.ticket_no IS NULL OR p.ticket_no = '')
");

// --- SEAT SEEDER ---
$fl = $conn->query("SELECT id FROM flights");
while ($f = $fl->fetch_assoc()) {

    $fid = $f['id'];

    for ($r = 1; $r <= 20; $r++) {
        foreach (['A','B','C','D','E','F'] as $c) {

            $seat = $c . $r;

            $conn->query("
                INSERT IGNORE INTO seats(flight_id, seat_no, status)
                VALUES($fid, '$seat', 'FREE')
            ");
        }
    }
}
?>