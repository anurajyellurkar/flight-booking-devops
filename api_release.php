
<?php
require 'config.php';
$flight_id=intval($_POST['flight_id']); 
$seat=$conn->real_escape_string($_POST['seat']);
$conn->query("UPDATE seats SET status='FREE', held_until=NULL 
WHERE flight_id=$flight_id AND seat_no='$seat' AND status='HELD'");
echo 'ok';
