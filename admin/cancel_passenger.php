<?php
require '../config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Invalid passenger");
}

$pid = intval($_GET['id']);

// get passenger info
$p = $conn->query("
    SELECT p.*, b.flight_id 
    FROM passengers p
    JOIN bookings b ON b.id = p.booking_id
    WHERE p.id = $pid
")->fetch_assoc();

if (!$p) {
    die("Invalid passenger");
}

// mark passenger cancelled
$conn->query("
    UPDATE passengers 
    SET cancel_status='CANCELLED_ADMIN', refund_status='PENDING' 
    WHERE id = $pid
");

// free seat again
$conn->query("
    UPDATE seats 
    SET status='FREE', held_until=NULL
    WHERE flight_id={$p['flight_id']} 
      AND seat_no='{$p['seat_no']}'
");

// add audit log
$conn->query("
    INSERT INTO audit_log(user_id, role, action, details)
    VALUES (NULL, 'ADMIN', 'CANCEL PASSENGER',
    'Passenger {$p['name']} (Seat {$p['seat_no']}) cancelled by admin')
");

header("Location: booking_view.php?id=" . $p['booking_id']);
exit;
?>