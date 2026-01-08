
<?php
require 'config.php';
if(!isset($_SESSION['user'])){ http_response_code(401); exit; }
$flight_id=intval($_POST['flight_id']); 
$seat=$conn->real_escape_string($_POST['seat']);
$conn->query("
UPDATE seats 
SET status='HELD', held_until=DATE_ADD(NOW(), INTERVAL 2 MINUTE)
WHERE flight_id=$flight_id AND seat_no='$seat' AND status='FREE'");
echo $conn->affected_rows>0?'ok':'fail';
