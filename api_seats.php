<?php
require "config.php";

$flight_id = intval($_GET['flight_id']);

$data = [];

$q = $conn->query("
    SELECT seat_no, status 
    FROM seats 
    WHERE flight_id=$flight_id
");

while($r = $q->fetch_assoc()){
    $data[$r['seat_no']] = $r['status'];
}

echo json_encode($data);
?>