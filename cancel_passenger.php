
<?php
require 'config.php'; require 'lib/audit.php';
if(!isset($_SESSION['user'])) die('Login required');

$id=intval($_GET['id']??0);

$q=$conn->query("SELECT p.*, b.user_id FROM passengers p JOIN bookings b ON b.id=p.booking_id WHERE p.id=$id");
$p=$q->fetch_assoc();
if(!$p || $p['user_id']!=$_SESSION['user']['id']) die('Invalid');

// set passenger cancelled
$conn->query("UPDATE passengers SET cancel_status='CANCELLED', refund_status='PENDING' WHERE id=$id");

// free seat
$conn->query("DELETE FROM seats WHERE flight_id=".$p['flight_id']." AND seat_no='".$p['seat_no']."' LIMIT 1");

log_action($conn,$_SESSION['user']['id'],'user','PASSENGER_CANCELLED',$p['ticket_no']);
header("Location: dashboard.php");
?>
