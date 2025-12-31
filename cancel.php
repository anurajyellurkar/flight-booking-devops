
<?php
require 'config.php'; require 'lib/audit.php';
if(!isset($_SESSION['user'])) die('Login required');
$tk=$_GET['t']??'';
$q=$conn->prepare("SELECT id,user_id FROM bookings WHERE ticket_no=?");
$q->bind_param("s",$tk); $q->execute(); $b=$q->get_result()->fetch_assoc();
if(!$b || $b['user_id']!=$_SESSION['user']['id']) die('Invalid');
$conn->query("UPDATE bookings SET cancel_status='CANCELLED', refund_status='PENDING' WHERE id=".$b['id']);
log_action($conn,$_SESSION['user']['id'],'user','BOOKING_CANCELLED',$tk);
header("Location: dashboard.php");
?>
