<?php
require 'config.php';
if(!isset($_SESSION['user'])){ header('Location: login.php'); exit; }
if(!isset($_POST['flight_id'])){ header('Location: index.php'); exit; }
?>

<?php include 'partials/header.php';
$data=$_SESSION['tmp']; $seats=$_SESSION['seats'];
$fid=$_POST['flight_id']; $class=$_POST['class']; $total=$_POST['total'];
$uid=$_SESSION['user']['id'];
$ticket='TKT-'.date('Ymd').'-'.rand(10000,99999);

$b=$conn->prepare("INSERT INTO bookings(user_id,flight_id,class_type,total_price,ticket_no) VALUES(?,?,?,?,?)");
$b->bind_param("iisss",$uid,$fid,$class,$total,$ticket);$b->execute();$bid=$b->insert_id;

$p=$conn->prepare("INSERT INTO passengers(booking_id,name,age,gender,seat_no,phone) VALUES(?,?,?,?,?,?)");
for($i=0;$i<count($data['name']);$i++){
 $p->bind_param("isisss",$bid,$data['name'][$i],$data['age'][$i],$data['gender'][$i],$seats[$i],$data['phone'][$i]);
 $p->execute();
}

$names=implode(', ',$data['name']);
$seatlist=implode(', ',$seats);
$primary=$data['name'][0].' -> '.$seats[0];

$_SESSION['last_ticket'] = $ticket;
header("Location: success.php");
exit;

echo "<div class='card'>
<h3>Payment Successful ✔</h3>
Passenger(s): <b>$names</b><br>
Primary Assignment: <b>$primary</b><br>
Ticket: <b>$ticket</b><br>
Seats: <b>$seatlist</b><br>
Class: $class<br>
Total Paid: ₹$total<br><br>
<a class='btn' href='ticket.php?t=$ticket'>Download Ticket (PDF)</a>
</div>";
?>
<?php include 'partials/footer.php'; ?>
