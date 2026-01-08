
<?php require '../config.php'; require '../lib/audit.php';
$id=intval($_GET['id']);
$conn->query("UPDATE bookings SET refund_status='REFUNDED' WHERE id=$id");
log_action($conn,$_SESSION['user']['id'],'admin','REFUND_APPROVED',"Booking $id");
header("Location: refunds.php");
?>
