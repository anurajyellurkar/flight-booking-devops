
<?php require '../config.php'; require '../lib/audit.php';
$id=intval($_GET['id']);
$conn->query("UPDATE passengers SET refund_status='REFUNDED' WHERE id=$id");
log_action($conn,$_SESSION['user']['id'],'admin','PASSENGER_REFUND_APPROVED',"Passenger $id");
header("Location: passenger_refunds.php");
?>
