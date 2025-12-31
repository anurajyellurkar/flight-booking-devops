
<?php
function takenSeats($c,$f){
  $q=$c->prepare("SELECT seat_no FROM passengers p JOIN bookings b ON p.booking_id=b.id WHERE b.flight_id=? AND b.status='CONFIRMED'");
  $q->bind_param("i",$f); $q->execute(); $r=$q->get_result();
  $out=[]; while($x=$r->fetch_assoc()) $out[]=$x['seat_no']; return $out;
}
?>
