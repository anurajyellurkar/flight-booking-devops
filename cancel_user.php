<?php
session_start();
require_once "config.php";

// user must be logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Get passenger/booking record id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} elseif (isset($_GET['pid'])) {
    $id = intval($_GET['pid']);
} else {
    die("Invalid request");
}

/*
 STEP 1: Get the seat number for this booking
*/
$getSeat = "SELECT seat_no FROM passengers WHERE id = ?";
$seatStmt = $conn->prepare($getSeat);
$seatStmt->bind_param("i", $id);
$seatStmt->execute();
$seatStmt->bind_result($seat_no);
$seatStmt->fetch();
$seatStmt->close();

// If no seat found, stop
if (!$seat_no) {
    die("Seat not found for this booking.");
}

/*
 STEP 2: Mark booking as CANCELLED (by user)
*/
$cancel = "UPDATE passengers 
           SET cancel_status = 'CANCELLED_USER',
               refund_status = 'PENDING'
           WHERE id = ?";

$cancelStmt = $conn->prepare($cancel);
$cancelStmt->bind_param("i", $id);
$cancelStmt->execute();
$cancelStmt->close();

/*
 STEP 3: Free the seat (make it available again)
*/
$freeSeat = "UPDATE seats 
             SET status = 'AVAILABLE'
             WHERE seat_no = ?";

$freeStmt = $conn->prepare($freeSeat);
$freeStmt->bind_param("s", $seat_no);
$freeStmt->execute();
$freeStmt->close();

/*
 STEP 4: Redirect back to dashboard
*/
header("Location: dashboard.php?msg=user_cancelled");
exit;

?>
