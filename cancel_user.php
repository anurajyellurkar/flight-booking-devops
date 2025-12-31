<?php
session_start();
require_once "config.php";

// user must be logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// get booking/passenger id from URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} elseif (isset($_GET['pid'])) {
    $id = intval($_GET['pid']);
} else {
    die("Invalid request");
}

/*
 We update:
 cancel_status → CANCELLED_USER
 refund_status → PENDING
*/
$sql = "UPDATE passengers 
        SET cancel_status = 'CANCELLED_USER',
            refund_status = 'PENDING'
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: dashboard.php?msg=user_cancelled");
    exit;
} else {
    echo "Error updating booking status: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
