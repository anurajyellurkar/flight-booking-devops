
<?php
require "config.php";
if(!isset($_SESSION['user'])){ header("Location: login.php"); exit; }
include "partials/header.php";

$flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']);
if($flash){ echo "<div class='alert alert-info'>$flash</div>"; }
?>
<h2>My Bookings</h2>

<div class="card">
<table class="table">
<thead>
<tr>
  <th>Ticket</th><th>Passenger</th><th>Seat</th><th>Route</th>
  <th>Flight</th><th>Status</th><th>Action</th>
</tr>
</thead>
<tbody>
<?php
$q=$conn->query("
SELECT p.id pid, p.ticket_no, p.name, p.seat_no, p.cancel_status,
 f.flight_no, CONCAT(f.origin,' → ',f.destination) route, f.depart_time
FROM passengers p
JOIN bookings b ON b.id=p.booking_id
JOIN flights f ON f.id=b.flight_id
WHERE b.user_id=".$_SESSION['user']['id']."
ORDER BY p.id DESC
");

function human($s){
  if($s=='CANCELLED_ADMIN') return 'CANCELLED (by admin)';
  if($s=='CANCELLED_USER') return 'CANCELLED (by you)';
  return 'ACTIVE';
}

$now=date('Y-m-d H:i:s');

while($r=$q->fetch_assoc()):
  $can = ($r['cancel_status']=='ACTIVE' && $r['depart_time']>$now);
?>
<tr>
 <td><?= $r['ticket_no'] ?></td>
 <td><?= ucfirst($r['name']) ?></td>
 <td><?= $r['seat_no'] ?></td>
 <td><?= $r['route'] ?></td>
 <td><?= $r['flight_no'] ?></td>
 <td><?= human($r['cancel_status']) ?></td>
 <td>
   <?php if($can): ?>
     <a class="btn btn-sm btn-danger" 
        onclick="return confirm('Cancel this ticket? refund will be issued.')" 
        href="cancel_user.php?pid=<?= $r['pid'] ?>">Cancel</a>
   <?php endif; ?>
 </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
<?php include "partials/footer.php"; ?>
