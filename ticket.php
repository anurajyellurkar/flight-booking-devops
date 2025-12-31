
<?php
require 'config.php';
require 'lib/fpdf.php';

$ticket=$_GET['t']??'';

$q=$conn->prepare("SELECT b.*,f.flight_no,f.origin,f.destination,f.depart_time FROM bookings b JOIN flights f ON b.flight_id=f.id WHERE b.ticket_no=?");
$q->bind_param("s",$ticket);
$q->execute();
$b=$q->get_result()->fetch_assoc();

if(!$b){ die("Invalid ticket"); }

$ps=$conn->query("SELECT name,seat_no FROM passengers WHERE booking_id=".$b['id']);

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'AIRLINE BOARDING PASS',0,1,'C');

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,'Ticket: '.$b['ticket_no'],0,1);
$pdf->Cell(0,8,'Flight: '.$b['flight_no'],0,1);
$pdf->Cell(0,8,'Route: '.$b['origin'].' -> '.$b['destination'],0,1);
$pdf->Cell(0,8,'Departure: '.$b['depart_time'],0,1);

$pdf->Ln(4);
$pdf->Cell(0,8,'Passengers & Seats:',0,1);

while($p=$ps->fetch_assoc()){
  $pdf->Cell(0,8,' - '.$p['name'].'  | Seat '.$p['seat_no'],0,1);
}

$pdf->Ln(4);
$pdf->Cell(0,8,'Class: '.$b['class_type'],0,1);
$pdf->Cell(0,8,'Total Paid: Rs '.$b['total_price'],0,1);

$pdf->Output('I','ticket.pdf');
?>
